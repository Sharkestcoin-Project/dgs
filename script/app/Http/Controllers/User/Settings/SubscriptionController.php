<?php

namespace App\Http\Controllers\User\Settings;

use App\Http\Controllers\Controller;
use App\Models\Gateway;
use App\Models\Order;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Tax;
use App\Rules\Phone;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Throwable;

class SubscriptionController extends Controller
{
    public function index()
    {
        Session::remove('is_user_subscription');
        $subscriptions = Plan::with('subscriptions')
            ->whereStatus(1)
            ->where('price', '>', 0)
            ->get();

        return view('user.settings.subscriptions.index', compact('subscriptions'));
    }

    public function store(Request $request)
    {
        $subscription = Plan::findOrFail($request->get('plan'));
        abort_if($subscription->price < 0 || $subscription->price == -1, 404);

        // CHeck product & plan quantity
        $user = Auth::user();
        if ($subscription->id !== $user->plan_id){
            if ($subscription->product_limit <= $user->plan->product_limit ?? 0){
                if ($user->products()->count() >= $subscription->product_limit){
                    $count = $user->products()->count() - $subscription->product_limit;

                    return response()->json([
                        'message' => __('Please remove at least :number of product.', ['number' => $count])
                    ], 403);
                }else{
                    return response()->json([
                        'message' => __("You are not allowed to downgrade your subscription")
                    ], 403);
                }
            }
            elseif($subscription->subscription_plan_limit < $user->plan->subscription_plan_limit ?? 0){
                return response()->json([
                    'message' => __("You are not allowed to downgrade your subscription")
                ], 403);
            }
        }

        Session::remove('is_user_subscription');
        Session::put('amount', $subscription->price);
        Session::put('plan', $subscription);

        Session::put('fund_callback.success_url', '/user/settings/subscription/payment/success');
        Session::put('fund_callback.cancel_url', '/user/settings/subscription/payment/failed');
        Session::put('payment_type', 'payment');
        Session::put('fund_callback.success_url', '/payment/success');
        Session::put('fund_callback.cancel_url', '/payment/failed');
        Session::put('without_tax', true);
        Session::put('without_auth', false);
        Session::put('is_admin_subscription', true);

        if($subscription->price == -1 && Auth::user()->is_free_enrolled){
            return response()->json(['message' => __("You're already used free plan")], 403);
        }

        if($subscription->is_trial && $request->get('trial') && Auth::user()->is_trial_enrolled){
            return response()->json(['message' => __("You're already used trial plan")], 403);
        }

        if ($subscription->price == -1 || $subscription->is_trial && $request->get('trial')){

            \Auth::user()->update([
                'plan_id' => $subscription->id,
                'plan_meta' => [
                    'name' => $subscription->name,
                    'price' => $subscription->price,
                    'duration' => $subscription->duration,
                    'description' => $subscription->description,
                    'meta' => $subscription->meta
                ],
                'will_expire' => will_expire($subscription)
            ]);

            Subscription::create([
                'plan_id' => $subscription->id,
                'user_id' => Auth::id(),
                'amount' => $request->get('trial') ? 0 : $subscription->price,
                'will_expire' => $request->get('trial') ? today()->addDays(7) : will_expire($subscription),
                'meta' => $subscription->meta,
                'is_trial' => $request->get('trial') ?? false
            ]);

            if($request->get('trial')){
                return $request->expectsJson() ?
                response()->json([
                    'message' => __('Trial Enrolled Successfully'),
                    'redirect' => url()->previous()
            ]) : redirect(url()->previous());
            }

            return $request->expectsJson() ?
                response()->json([
                'message' => __('Subscription Upgraded Successfully'),
                'redirect' => url()->previous()
            ]) : redirect(url()->previous());
        }

        return $request->expectsJson() ? response()->json([
            'message' => __('Hurrah! You are redirect to next step.'),
            'redirect' => route('user.settings.subscriptions.create')
        ]) : redirect()->route('user.settings.subscriptions.create');
    }

    public function create()
    {
        $plan = Session::get('plan');
        abort_if($plan->price < 0 || $plan->price == -1, 404);
        $amount = $plan->price;

        if (empty($amount) && $amount == null && $amount == 0) {
            return to_route('user.settings.subscriptions.index');
        }

        $gateways = Gateway::whereStatus(1)
            ->with('currency')
            ->whereNotIn('name', ['my credits', 'free', 'manual'])
            ->get();

        $taxes = Tax::whereStatus(1)->get();

        return view('user.settings.subscriptions.create', compact('gateways', 'amount', 'taxes'));
    }

    public function makePayment(Request $request, Gateway $gateway)
    {
        $request->validate([
            'phone' => [
                Rule::requiredIf(fn() => $gateway->phone_required),
                new Phone
            ],
            'comment' => ['nullable', 'string', 'max:255'],
            'screenshot' => ['nullable', 'image', 'max:2048'] // 2MB
        ]);

        $plan = Session::get('plan');
        abort_if($plan->price < 0 || $plan->price == -1, 404);
        $amount = $plan->price;

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
        $payment_data['currency'] = $gateway->currency->code ?? 'USD';
        $payment_data['email'] = auth()->user()->email;
        $payment_data['name'] = auth()->user()->name;
        $payment_data['phone'] = $request->input('phone');
        $payment_data['billName'] = __('Subscription Payment');
        $payment_data['amount'] = $amount;
        $payment_data['test_mode'] = $gateway->test_mode;
        $payment_data['charge'] = $gateway->charge ?? 0;
        $payment_data['pay_amount'] = round(payable($plan->price, $gateway), 2);
        $payment_data['gateway_id'] = $gateway->id;
        $payment_data['payment_type'] = 'payment';
        $payment_data['request_from'] = 'merchant';

        $gateway_info = json_decode($gateway->data, true);
        if (!empty($gateway_info)) {
            foreach ($gateway_info as $key => $info) {
                $payment_data[$key] = $info;
            }
        }

        Session::put('payment_type', 'payment');
        Session::put('fund_callback.success_url', route('user.settings.subscriptions.payment.success'));
        Session::put('fund_callback.cancel_url', route('user.settings.subscriptions.payment.failed'));

        $redirect = $gateway->namespace::make_payment($payment_data);

        return $request->expectsJson() ? response()->json([
                'message' => __('Hurrah! You are redirect to next step.'),
                'redirect' => $redirect
            ]) : $redirect;
    }

    public function failed()
    {
        Session::flash('error', __('Oops! Payment Failed.'));
        Session::forget('payment_info');
        Session::forget('payment_type');

        return to_route('user.settings.subscriptions.index');
    }

    public function success()
    {
        abort_if(!Session::has('payment_info') && !Session::has('payment_type'), 404);

        \DB::beginTransaction();
        try {
            $plan = Session::get('plan');
            $amount = Session::get('amount');
            $gateway_id = Session::get('payment_info')['gateway_id'];
            $trx = Session::get('payment_info')['payment_id'];
            $payment_status = Session::get('payment_info')['payment_status'] ?? 0;
            $status = Session::get('payment_info')['status'] ?? 1;
            $gateway = Gateway::findOrFail($gateway_id);

            $user = \Auth::user();

            Subscription::create([
                'plan_id' => $plan->id,
                'user_id' => $user->id,
                'amount' => $plan->price,
                'will_expire' => will_expire($plan),
                'meta' => $plan->meta
            ]);

            Order::create([
                "user_id" => $user->id,
                "plan_id" => $plan->id,
                "gateway_id" => $gateway_id,
                "trx" => $trx,
                "is_auto" => $gateway->is_auto,
                "tax" => 0,
                "will_expire" => will_expire($plan),
                "price" => $amount,
                "type" => 'payment',
                "status" => $status,
                "payment_status" => $payment_status,
            ]);

            // If Plan is Renew
            $extraDate = 0;
            if ($user->will_expire > now() && $user->plan_id == $plan->id){
                $extraDate = now()->diffInDays($user->will_expire);
            }
            $mergeDays = $plan->duration + $extraDate;
            $isRenewed = $user->plan_id == $plan->id;

            $user->update([
                'plan_id' => $plan->id,
                'plan_meta' => $plan->meta,
                'will_expire' => now()->addDays($mergeDays)
            ]);

            \DB::commit();

            $status = Session::get('payment_info')['payment_status'];

            Session::put('deposit_status', $status);
            Session::flash('success', $isRenewed ? __("Subscription Renewed Successfully") : __('Subscription Upgraded Successfully'));
            Session::forget('fund_callback');

            if ($status != 0) {
                return to_route('user.settings.subscriptions.index');
            } else {
                return to_route('user.settings.subscriptions.create');
            }

        } catch (Throwable $th) {
            \DB::rollback();
            Session::forget('fund_callback');
            Session::forget('payment_info');
            Session::flash('error', 'Something wrong please contact with support..!');
            throw $th;
            return redirect()->route('user.settings.subscriptions.index');
        }
    }

    public function redirectFromEmail(Request $request)
    {
        $subscription = Plan::findOrFail($request->get('plan'));

        Session::put('amount', $subscription->price);
        Session::put('plan_id', $subscription->id);

        return redirect()->route('user.settings.subscriptions.create');
    }

    public function log(Request $request)
    {
        $subscriptions = Subscription::whereUserId(Auth::id())
            ->with('plan')
            ->when(!empty($request->get('src')), function (Builder $builder) use ($request){
                $builder->where('invoice_no', 'LIKE', '%'.$request->get('src').'%');
            })
            ->latest()
            ->paginate();

        return view('user.settings.subscriptions.log', compact('subscriptions'));
    }
}
