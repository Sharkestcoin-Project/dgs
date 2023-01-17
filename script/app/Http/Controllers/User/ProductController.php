<?php

namespace App\Http\Controllers\User;

use App\Actions\CreateProduct;
use App\Actions\DeleteProduct;
use App\Actions\UpdateProduct;
use App\Http\Controllers\Controller;
use App\Mail\NotifyPreviousBuyerMail;
use App\Models\Currency;
use App\Models\Product;
use App\Models\ProductOrder;
use Auth;
use Cache;
use Illuminate\Http\Request;
use App\Traits\HasProduct;

class ProductController extends Controller
{
    use HasProduct;

    public function index(Request $request)
    {
        $products = Product::with('currency')->whereUserId(Auth::id())
                    ->when(request()->search, function($q) {
                        $q->where('name', 'like', '%' . request('search') . '%');
                    })
                    ->get();
        return view('user.products.index', compact('products'));
    }

    public function create()
    {
        $this->checkProductLimit();
        $currencies = Currency::whereStatus(1)->get();
        return view('user.products.create', compact('currencies'));
    }

    public function store(Request $request, CreateProduct $creator)
    {
        $this->checkProductLimit();

        \DB::beginTransaction();
        try {
            if (!$request->input('folder') && !$request->direct_url) {
                return response()->json([
                    'message' => __('File/File link field is required.'),
                ], 404);
            }

            $product = $creator->create($request);

            \DB::commit();

            return response()->json([
                'message' => __('Product Created Successfully'),
                'redirect' => route('user.product.iframe', $product->id)
            ]);
        }catch (\Throwable $e){
            \DB::rollBack();

            return response()->json($e->getMessage(), 422);
        }
    }

    public function show(Product $product)
    {
        abort_if($product->user_id !== Auth::id(), 403);
        $product->load('currency');
        return view('user.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        abort_if($product->user_id !== Auth::id(), 403);
        $currencies = Currency::whereStatus(1)->get();
        return view('user.products.edit', compact('currencies', 'product'));
    }

    public function update(Request $request, Product $product, UpdateProduct $updator)
    {
        abort_if($product->user_id !== Auth::id(), 403);
        if (!$product->file && !$request->input('folder') && !$request->direct_url) {
            return response()->json([
                'message' => __('File/File link field is required.'),
            ], 404);
        }
        $updator->update($request, $product);

        if($request->notify_previous_buyer){
            $customers =$product->orders()->get()->pluck('email');

            if ($customers->count() > 0){
                if (config('system.queue.mail')){
                    \Mail::to($customers)->queue(new NotifyPreviousBuyerMail($product));
                }else{
                    \Mail::to($customers)->send(new NotifyPreviousBuyerMail($product));
                }
            }
        }

        Cache::forget('product.'.$product->id);
        return response()->json([
            'message' => __('Product Updated Successfully'),
            'redirect' => route('user.products.index')
        ]);
    }

    public function destroy(Product $product, DeleteProduct $deletor)
    {
        abort_if($product->user_id !== Auth::id(), 403);

        if ($product->orders()->count() > 0){
            return response()->json(__('You are not allowed to delete this product. It has :number customers.', ['number' => $product->orders()->count()]), 403);
        }
        Cache::forget('product.'.$product->id);
        $deletor->delete($product);
        return response()->json([
            'message' => __('Product Deleted Successfully'),
            'redirect' => route('user.products.index')
        ]);
    }

    public function download(Product $product)
    {
        abort_if($product->user_id !== Auth::id(), 404);
        if (\Storage::disk(config('filesystems.default'))->exists($product->file)){
            return \Storage::disk(config('filesystems.default'))->download($product->file);
        }else{
            abort(404, __("File Not Found"));
        }
    }

    public function iframe($id)
    {
        $product = Product::where('user_id', auth()->id())->with('user')->findOrFail($id);
        abort_if($product->user_id !== Auth::id(), 404);
        return view('user.products.product-links', compact('product'));
    }
}
