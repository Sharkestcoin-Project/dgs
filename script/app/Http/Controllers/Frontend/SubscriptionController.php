<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\NewSubscriptionMail;
use App\Models\Gateway;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserPlan;
use App\Models\UserPlanOrder;
use App\Models\UserPlanSubscriber;
use App\Models\Wallet;
use App\Rules\Phone;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Throwable;

class SubscriptionController extends Controller
{
    public function renew(User $user, UserPlanOrder $order)
    {
        $user->loadCount('products', 'plans');
        $order->load('plan.currency', 'subscriber');
        return view('frontend.users.renew', compact('user', 'order'));
    }

    public function index(Request $request, User $user, UserPlan $plan)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'phone' => ['required', new Phone],
        ]);
        Session::put('plan', $plan);
        Session::put('name', $request->input('name'));
        Session::put('email', $request->input('email'));
        Session::put('phone', $request->input('phone'));

        $gateways = Gateway::with('currency')->whereStatus(1)->whereIsAuto(1)->get();
        $isSubscription = true;

        return view('frontend.payment.index', compact('gateways','plan', 'isSubscription'));
    }

    public function makePayment(Request $request, UserPlan $plan, Gateway $gateway)
    {
        if ($gateway->is_auto == 0){
            return redirect()->back()->with('error', __('This gateway is not supported'));
        }

        $convertedPrice = convert_money($plan->price, $plan->currency);

        Session::put('plan', $plan);
        Session::put('price', $convertedPrice);
        Session::put('payment_type', 'subscription');
        Session::put('fund_callback.success_url', '/subscription/payment/success');
        Session::put('fund_callback.cancel_url', '/subscription/payment/failed');
        Session::put('without_tax', true);
        Session::put('without_auth', true);
        Session::put('is_user_subscription', true);

        // Validate the incoming form request
        $request->validate([
            'phone' => [
                Rule::requiredIf(fn() => $gateway->phone_required),
                new Phone
            ],
            'comment' => ['nullable', 'string', 'max:255'],
            'screenshot' => ['nullable', 'image', 'max:2048'] // 2MB
        ]);

        // Upload files if exists
        if ($gateway->is_auto == 0) {
            $payment_data['comment'] = $request->input('comment');
            if ($request->hasFile('screenshot')) {

                $path = 'uploads/' . strtolower(config('app.name')) . '/payments' . date('/y/m/');
                $name = uniqid() . date('dmy') . time() . "." . $request->file('screenshot')->getClientOriginalExtension();

                Storage::disk(config('filesystems.default'))->put($path . $name, file_get_contents(Request()->file('screenshot')));

                $image = Storage::disk(config('filesystems.default'))->url($path . $name);

                $payment_data['screenshot'] = $image;
            }
        }

        // Checkout process
        $payment_data['currency'] = $gateway->currency->code;
        $payment_data['email'] = Session::get('email');
        $payment_data['name'] = Session::get('name');
        $payment_data['phone'] = $request->input('phone');
        $payment_data['billName'] = Session::get('name');
        $payment_data['amount'] = $plan->price;
        $payment_data['test_mode'] = $gateway->test_mode;
        $payment_data['charge'] = $gateway->charge ?? 0;
        $payment_data['pay_amount'] = round(payable($convertedPrice, $gateway, true), 2);
        $payment_data['gateway_id'] = $gateway->id;
        $payment_data['payment_type'] = 'subscription';
        $payment_data['request_from'] = 'merchant';

        $gateway_info = json_decode($gateway->data, true);
        if (!empty($gateway_info)) {
            foreach ($gateway_info as $key => $info) {
                $payment_data[$key] = $info;
            }
        }

        $redirect = $gateway->namespace::make_payment($payment_data);

        return $request->expectsJson() ? response()->json([
            'message' => __('Hurrah! You are redirect to next step.'),
            'redirect' => $redirect
        ]) : $redirect;
    }

    public function success()
    {
        abort_if(!Session::has('payment_info') && !Session::has('payment_type'), 404);

        DB::beginTransaction();
        try {
            $plan = Session::get('plan');

            $price = Session::get('price');
            $gateway_id = Session::get('payment_info')['gateway_id'];
            $trx = Session::get('payment_info')['payment_id'];
            $payment_status = Session::get('payment_info')['payment_status'] ?? 0;

            $subscriptionExpireAt = null;
            switch ($plan->period){
                case "weekly":
                    $subscriptionExpireAt = now()->addWeek();
                    break;
                case "monthly":
                    $subscriptionExpireAt = now()->addMonth();
                    break;
                case "yearly":
                    $subscriptionExpireAt = now()->addYear();
                    break;
            }

            $subscriber = UserPlanSubscriber::updateOrCreate([
                "email" => Session::get('email')
            ],[
                "name" => Session::get('name'),
                "phone" => Session::get('phone')
            ]);

            $isRenew = $subscriber->orders()->where('plan_id', $plan->id)->first();
            if ($isRenew){
                $subscriber->orders()->where('plan_id', $plan->id)->update(['is_open' => false]);

                if ($isRenew->subscription_expire_at > today()){
                    $subscriptionExpireAt = $subscriptionExpireAt->addDays(Carbon::today()->diffInDays($isRenew->subscription_expire_at));
                }
            }

            $order = UserPlanOrder::create([
                "trx" => $trx,
                "amount" => $price,
                "period" => $plan->period,
                "subscriber_id" => $subscriber->id,
                "plan_id" => $plan->id,
                "user_id" => $plan->user_id,
                "currency_id" => $plan->currency_id,
                "gateway_id" => $gateway_id,
                "subscription_expire_at" => $subscriptionExpireAt,
                "is_open" => true
            ]);

            if ($payment_status) {
                $user = User::findOrFail($plan->user_id);
                $mainPlan = $user->plan;
                $commission = ($price * $mainPlan->commission) / 100;

                $wallet = Wallet::where('user_id', $user->id)
                    ->where('currency_id', $plan->currency_id)
                    ->first();

                if ($wallet){
                    $wallet->update([
                        'wallet' => $wallet->wallet + ($price - $commission)
                    ]);
                }else{
                    Wallet::create([
                        'user_id' => $user->id ?? null,
                        'currency_id' => $plan->currency_id,
                        'wallet' => $user->wallet + ($price - $commission)
                    ]);
                }
            }

            $name = Session::get('name');
            $email = Session::get('email');
            $phone = Session::get('phone');
            $data = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'plan' => $plan
            ];

            if (config('system.queue.mail')){
                \Mail::to($email)->queue(new NewSubscriptionMail('customer', $user, $data, $order));
                \Mail::to($user->email)->queue(new NewSubscriptionMail('owner', $user, $data, $order));
            }else{
                \Mail::to($email)->send(new NewSubscriptionMail('customer', $user, $data, $order));
                \Mail::to($user->email)->send(new NewSubscriptionMail('owner', $user, $data, $order));
            }

            DB::commit();

            Session::forget('fund_callback');
            Session::forget('product');
            Session::forget('promotion');
            Session::forget('price');
            Session::forget('payment_info');
            Session::forget('is_user_subscription');
            Session::flash('success', __('Payment Successfully Completed'));

            if ($plan->return_url){
                return redirect($plan->return_url);
            }

            return view('frontend.users.share', compact('user', 'plan'));

        } catch (Throwable $th) {
            DB::rollback();
            Session::forget('fund_callback');
            Session::forget('product');
            Session::forget('promotion');
            Session::forget('price');
            Session::forget('payment_info');
            Session::forget('is_user_subscription');
            Session::flash('error', $th->getMessage());
            throw $th;
        }
    }

    public function failed()
    {
        Session::forget('fund_callback');
        Session::forget('product');
        Session::forget('promotion');
        Session::forget('price');
        Session::forget('payment_info');
        Session::forget('is_user_subscription');
        abort(500, __('Subscription Payment Failed'));
    }

    public function iframe($id)
    {
        $plan = UserPlan::with('user', 'currency')->findOrFail($id);
        return view('frontend.iframe.subscription', compact('plan'));
    }

}
