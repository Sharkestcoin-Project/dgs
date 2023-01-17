<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Order;
use Throwable;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:orders-read')->only('index', 'show');
        $this->middleware('permission:orders-update')->only('edit');
        $this->middleware('permission:orders-delete')->only('destroy');
    }

    public function index(Request $request)
    {
        $orders = Order::with('user','plan','gateway')
            ->when($request->get('payment_status') !== null, function (Builder $query) use ($request) {
                $query->where('payment_status', '=', $request->get('payment_status'));
            })
            ->when($request->get('src') !== null, function (Builder $query) use ($request) {
                $query->where('invoice_no', 'LIKE', '%' . $request->get('src') . '%');

                $query->orWhereHas('user', function (Builder $query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->get('src') . '%');
                    $query->orWhere('username', 'LIKE', '%' . $request->get('src') . '%');
                });
            })
            ->when($request->get('start') !== null, function (Builder $query) use ($request) {
                $query->whereDate('created_at', '>=', $request->get('start'));
            })
            ->when($request->get('end') !== null, function (Builder $query) use ($request) {
                $query->whereDate('created_at', '<=', $request->get('end'));
            })
            ->latest()
            ->paginate(10);

        $all = Order::get();
        $complete = Order::wherePaymentStatus(1)->get();
        $failed = Order::wherePaymentStatus(0)->get();
        $pending = Order::wherePaymentStatus(2)->get();
        $expired = Order::wherePaymentStatus(3)->get();

        return view('admin.orders.index', compact('orders','all','complete','failed','pending','expired'));
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function edit($id){
        $currency_name = get_option('currency_name',false);
        $tax = get_option('tax',false);
        $order = Order::with('gateway','plan','user')->findOrFail($id);
       return view('admin.orders.edit',compact('order','currency_name','tax'));
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json([
            'message' => __("Orders Has Been Deleted"),
            'redirect' => route('admin.orders.index')
        ]);
    }

    public function massDestroy(Request $request)
    {
        DB::beginTransaction();
        try {
            foreach ($request->input('id') as $id) {
                $user = Order::findOrFail($id);
                $user->delete();
            }

            DB::commit();

            return response()->json([
                'message' => __("Selected Orders Has Been Deleted"),
                'redirect' => route('admin.orders.index')
            ]);
        } catch (Throwable $exception) {
            return response()->json($exception->getMessage(), 500);
        }
    }

    public function print(Request $request, Order $order)
    {
        $pdf = PDF::loadView('admin.orders.pdf', compact('order'));

        if ($request->get('type') == 'print'){
            return $pdf->stream('Order%20Invoice-'.$order->invoice_no.'.pdf');
        }
        return $pdf->download('Order%20Invoice-'.$order->invoice_no.'.pdf');
    }

    public function orderPdf(Request $request)
    {
        $orders = Order::get();
        $pdf = PDF::loadView('admin.orders.allOrderPdf', compact('orders'));

        return $pdf->download('Order%20Invoice.pdf');
    }

    public function paymentStatusUpdate(Request $request,$id){
         $order = Order::find($id);
         $order->payment_status = $request->payment_status;
         $order->save();

        return response()->json('Payment Status Update Succesfully');

    }
}
