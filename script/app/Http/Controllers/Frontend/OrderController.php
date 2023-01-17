<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\SendInvoiceMail;
use App\Models\Gateway;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\Promotion;
use App\Models\PromotionLog;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Rules\Phone;
use Auth;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Session;
use Throwable;

class OrderController extends Controller
{
    public function index(Request $request, $id)
    {
        $request->validate([
            'name' => ['nullable', 'string'],
            'email' => ['required', 'email'],
        ]);
        $product = cache_remember('product.'.$id, function () use ($id){
            return Product::with('user', 'currency')->findOrFail($id);
        });
        abort_if($product->user->will_expire < today(), 404);

        Session::put('name', $request->input('name'));
        Session::put('email', $request->input('email'));

        $promotion = Session::get('promotion');

        if ($promotion->product_id ?? null !== $product->id) {
            Session::forget('promotion');
        }

        $gateways = Gateway::whereStatus(1)->whereIsAuto(1)->get();
        $isSubscription = false;
        return view('frontend.payment.index', compact('product', 'gateways', 'promotion', 'isSubscription'));
    }

    public function iframeOrder(Request $request, $id)
    {
        $request->validate([
            'name' => ['nullable', 'string'],
            'email' => ['required', 'email'],
        ]);
        $product = cache_remember('product.'.$id, function () use ($id){
            return Product::with('user', 'currency')->findOrFail($id);
        });
        abort_if($product->user->will_expire < today(), 404);
        Session::put('name', $request->input('name'));
        Session::put('email', $request->input('email'));

        $promotion = Session::get('promotion');

        if (isset($promotion) && $promotion->product_id !== $product->id) {
            Session::forget('promotion');
        }

        $gateways = Gateway::whereStatus(1)->whereIsAuto(1)->get();
        $isSubscription = false;
        return view('frontend.payment.index', compact('product', 'gateways', 'promotion', 'isSubscription'));
    }

    public function validatePromo(Request $request, $id)
    {
        $product = cache_remember('product.'.$id, function () use ($id){
            return Product::with('user')->findOrFail($id);
        });
        abort_if($product->user->will_expire < today(), 404);

        $promotion = Promotion::whereCode($request->input('code'))
            ->whereProductId($product->id)
            ->first();

        if ($promotion && $promotion->redemptions()->count() == $promotion->max_limit){
            Session::forget('promotion');
            return response()->json([
                'message' => __('The promo usage limit exceed'),
                'errors' => [
                    'promo_code' => [
                        __('The promo usage limit exceed')
                    ]
                ]
            ], 404);
        }

        if (!$promotion) {
            Session::forget('promotion');
            return response()->json([
                'message' => __('The promo code is invalid'),
                'errors' => [
                    'promo_code' => [
                        __('The promo code is invalid')
                    ]
                ]
            ], 404);
        } else {
            Session::put('promotion', $promotion);

            $gateways = Gateway::whereStatus(1)->get();

            $html = view('frontend.payment.getGateways', compact('gateways', 'product', 'promotion'))->render();

            return response()->json([
                'message' => __('Promo code successfully applied'),
                'html' => $html
            ]);
        }
    }

    public function removePromo($id)
    {
        $product = cache_remember('product.'.$id, function () use ($id){
            return Product::with('user')->findOrFail($id);
        });
        abort_if($product->user->will_expire < today(), 404);

        Session::forget('promotion');
        $gateways = Gateway::whereStatus(1)->get();

        $html = view('frontend.payment.getGateways', compact('gateways', 'product'))->render();

        return response()->json([
            'message' => __('Promo Code Removed Successfully'),
            'html' => $html
        ]);
    }

    public function makePayment(Request $request, $id, Gateway $gateway)
    {
        $product = cache_remember('product.'.$id, function () use ($id){
            return Product::with('user')->findOrFail($id);
        });
        abort_if($product->user->will_expire < today(), 404);

        if ($gateway->is_auto == 0){
            return redirect()->back()->with('error', __('This gateway is not supported'));
        }

        $promotion = Session::get('promotion');

        $convertedPrice = convert_money($product->price, $product->currency);
        if (Session::has('promotion')){
            $originalDiscount =  $promotion->is_percent ? (($product->price * $promotion->discount) / 100) : $promotion->discount;
            $convertedDiscount = convert_money($originalDiscount, $product->currency);
            $originalDiscountAmount = $product->price - $originalDiscount;
            $convertedDiscountAmount = convert_money($originalDiscountAmount, $product->currency);
        }

        Session::put('product', $product);
        Session::put('discount_price', $convertedDiscountAmount ?? $convertedPrice);
        Session::put('payment_type', 'payment');
        Session::put('fund_callback.success_url', '/payment/success');
        Session::put('fund_callback.cancel_url', '/payment/failed');
        Session::put('without_tax', true);
        Session::put('without_auth', true);

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
        $payment_data['amount'] = $product->price;
        $payment_data['test_mode'] = $gateway->test_mode;
        $payment_data['charge'] = $gateway->charge ?? 0;
        $payment_data['pay_amount'] = round(payable($convertedDiscountAmount ?? $convertedPrice, $gateway, true), 2);
        $payment_data['gateway_id'] = $gateway->id;
        $payment_data['payment_type'] = 'payment';
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
            $product = Session::get('product');
            $promotion = Session::get('promotion');
            abort_if($product->user->will_expire < today(), 404);

            $price = Session::get('discount_price');
            $gateway_id = Session::get('payment_info')['gateway_id'];
            $trx = Session::get('payment_info')['payment_id'];
            $payment_status = Session::get('payment_info')['payment_status'] ?? 0;

            $productOrder = ProductOrder::create([
                "trx" => $trx,
                "name" => Session::get('name'),
                "email" => Session::get('email'),
                "amount" => $price,
                "product_id" => $product->id,
                "user_id" => $product->user_id,
                "currency_id" => $product->currency_id,
                "gateway_id" => $gateway_id,
                "has_promotion" => $promotion->code ?? null,
                "will_expire_at" => now()->addHours(168),
            ]);

            if ($promotion) {
                PromotionLog::create([
                    "product_id" => $product->id,
                    "promotion_id" => $promotion->id,
                    "product_order_id" => $productOrder->id,
                ]);
            }

            if ($payment_status) {
                $user = User::findOrFail($product->user_id);
                $plan = $user->plan;

                $wallet = Wallet::where('user_id', $user->id)
                    ->where('currency_id', $product->currency_id)
                    ->first();

                if ($wallet){
                    $wallet->update([
                        'wallet' => $wallet->wallet + $price
                    ]);
                } else {
                    Wallet::create([
                        'user_id' => $user->id ?? null,
                        'currency_id' => $product->currency_id,
                        'wallet' => $user->wallet + $price
                    ]);
                }

                Transaction::create([
                    "type" => 'sell',
                    "amount" => $price,
                    "user_id" => $user->id,
                ]);
            }

            // Email
            $name = Session::get('name');
            $email = Session::get('email');
            $options = [
                'product_name' => $product->name,
                'invoice_id' => $productOrder->invoice_no,
                'invoice_total' => $price,
                'download_link' => route('download.product', $productOrder->token),
                'order' => $productOrder
            ];

            $template = 'mail.send-invoice-mail';

            if (config('system.queue.mail')){
                \Mail::to($email)->queue(new SendInvoiceMail($options, $template));
            }else{
                \Mail::to($email)->send(new SendInvoiceMail($options, $template));
            }

            DB::commit();

            $status = Session::get('payment_info')['payment_status'];

            Session::put('deposit_status', $status);
            Session::forget('fund_callback');
            Session::forget('product');
            Session::forget('promotion');
            Session::forget('price');
            Session::forget('payment_info');

            if ($product->return_url){
                return redirect($product->return_url);
            }

            return view('frontend.payment.success', compact('productOrder'));

        } catch (Throwable $th) {
            DB::rollback();
            Session::forget('fund_callback');
            Session::forget('product');
            Session::forget('promotion');
            Session::forget('price');
            Session::forget('payment_info');
            Session::flash('error', $th->getMessage());
            return to_route('products.index')->with('error', __('Something went wrong.'));
        }
    }

    public function expired()
    {
        abort_if(Auth::user()->will_expire < today(), 404);
    }

    public function failed()
    {
        Session::forget('fund_callback');
        Session::forget('product');
        Session::forget('promotion');
        Session::forget('price');
        Session::forget('payment_info');
        return to_route('products.index');
    }
}
