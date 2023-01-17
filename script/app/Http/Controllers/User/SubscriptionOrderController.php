<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\NewDownloadLinkMail;
use App\Mail\NewSubscriptionMail;
use App\Models\ProductOrder;
use App\Models\UserPlanOrder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SubscriptionOrderController extends Controller
{
    public function index(Request $request)
    {
        $src = $request->get('src');

        $orders = UserPlanOrder::whereUserId(\Auth::id())
            ->with('subscriber')
            ->when($src !== null, function (Builder $builder) use($src){
                $builder->whereHas('subscriber', function (Builder $builder) use ($src){
                    $builder->where('email', 'LIKE', '%'.$src.'%')
                        ->orWhere('name', 'LIKE', '%'.$src.'%')
                        ->orWhere('phone', 'LIKE', '%'.$src.'%');
                });
            })
            ->latest()
            ->paginate();

        return view('user.orders.subscriptions', compact('orders'));
    }

    public function show(UserPlanOrder $order)
    {
        $order->load('plan.currency', 'currency', 'subscriber', 'gateway');
        return view('user.orders.showSubscription', compact('order'));
    }

    public function resend(Request $request, UserPlanOrder $order)
    {
        if (!$order->is_open){
            return response()->json([
                'message' => __('This order is closed')
            ], 403);
        }

        $data = [
            'name' => $order->subscriber->name,
            'email' => $order->subscriber->email,
            'phone' => $order->subscriber->phone,
            'plan' => $order->plan
        ];
        if (config('system.queue.mail')){
            \Mail::to($order->subscriber->email)->queue(new NewSubscriptionMail('customer', $order->plan->user, $data, $order));
        }else{
            \Mail::to($order->subscriber->email)->send(new NewSubscriptionMail('customer', $order->plan->user, $data, $order));
        }


        return response()->json(__('Resend link has been sent to '. $order->subscriber->name));
    }
}
