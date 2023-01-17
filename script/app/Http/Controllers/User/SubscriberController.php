<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\SubscriptionRenewalMail;
use App\Models\UserPlanOrder;
use App\Models\UserPlanSubscriber;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $src = $request->get('src');
        $subscribers = UserPlanSubscriber::withCount('orders')
            ->when(!is_null($src), function (Builder $builder) use ($src){
                $builder->where('name', 'LIKE', '%'.$src.'%')
                    ->orWhere('email', 'LIKE', '%'.$src.'%')
                    ->orWhere('phone', 'LIKE', '%'.$src.'%');
            })
            ->latest()
            ->paginate();

        return view('user.subscribers.index', compact('subscribers'));
    }

    public function show(UserPlanSubscriber $subscriber)
    {
        $subscriber->load('orders.plan', 'orders.gateway', 'orders.currency');
        $orders = $subscriber->orders()->latest()->orderBy('invoice_no', 'desc')->paginate();
        return view('user.subscribers.show', compact('subscriber', 'orders'));
    }

    public function renewal(UserPlanOrder $order)
    {
        abort_if($order->user_id !== \Auth::id(), 404);

        if (!$order->is_open){
            return response()->json(__('You are not allowed to send renewal mail for this order'), 403);
        }

        if (config('system.queue.mail')){
            \Mail::to($order->subscriber->email)->queue(new SubscriptionRenewalMail($order));
        }else{
            \Mail::to($order->subscriber->email)->send(new SubscriptionRenewalMail($order));
        }

        return response()->json([
            'message' => __('Renewal Email Has Been Sent')
        ]);
    }
}
