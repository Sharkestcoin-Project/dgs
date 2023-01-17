<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Throwable;

class ProductOrderLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:product-orders-read');
    }

    public function index(Request $request)
    {
        $orders = ProductOrder::with('user','product','gateway')

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

        $all = ProductOrder::get();

        return view('admin.product-orders.index', compact('orders','all'));
    }

    public function show($id)
    {
        $order = ProductOrder::with('user','product')->findOrFail($id);
        return view('admin.product-orders.show', compact('order'));
    }

    public function destroy($id)
    {
        ProductOrder::findOrFail($id)->delete();

        return response()->json([
            'message' => __("Orders Has Been Deleted"),
            'redirect' => route('admin.product-orders.index')
        ]);
    }

    public function massDestroy(Request $request)
    {
        DB::beginTransaction();
        try {
            foreach ($request->input('id') as $id) {
                $user = ProductOrder::findOrFail($id);
                $user->delete();
            }

            DB::commit();

            return response()->json([
                'message' => __("Selected Orders Has Been Deleted"),
                'redirect' => route('admin.product-orders.index')
            ]);
        } catch (Throwable $exception) {
            return response()->json($exception->getMessage(), 500);
        }
    }

    public function print(Request $request, ProductOrder $order)
    {
        $pdf = PDF::loadView('admin.product-orders.pdf', compact('order'));

        if ($request->get('type') == 'print'){
            return $pdf->stream('Order%20Invoice-'.$order->invoice_no.'.pdf');
        }
        return $pdf->download('Order%20Invoice-'.$order->invoice_no.'.pdf');
    }

    public function orderPdf(Request $request)
    {
        $orders = ProductOrder::get();
        $pdf = PDF::loadView('admin.product-orders.allOrderPdf', compact('orders'));

        return $pdf->download('Order%20Invoice.pdf');
    }


}
