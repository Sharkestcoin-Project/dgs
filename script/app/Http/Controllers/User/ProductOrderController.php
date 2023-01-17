<?php

namespace App\Http\Controllers\User;

use App\Mail\NewDownloadLinkMail;
use App\Models\Product;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use App\Mail\SendInvoiceMail;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class ProductOrderController extends Controller
{
    public function index(Request $request)
    {
        $src = $request->get('src');

        $orders = ProductOrder::whereUserId(\Auth::id())
            ->with('product')
            ->when($request->has('subscriptions'), function (Builder $builder){
                $builder->whereNotNull('subscription_expire_at');
            })
            ->when($src !== null, function (Builder $builder) use($src){
                $builder->where('email', 'LIKE', '%'.$src.'%')
                    ->orWhere('has_promotion', 'LIKE', '%'.$src.'%');
            })
            ->latest()
            ->paginate();

        return view('user.orders.products', compact('orders'));
    }

    public function resend($id)
    {
        $productOrder = ProductOrder::findOrFail($id);
        $productOrder->will_expire_at = now()->addDays(168);
        $productOrder->save();

        if (config('system.queue.mail')){
            \Mail::to($productOrder->email)->queue(new NewDownloadLinkMail($productOrder));
        }else{
            \Mail::to($productOrder->email)->send(new NewDownloadLinkMail($productOrder));
        }

        return response()->json(__('Resend link has been sent to '. $productOrder->email));
    }
}
