<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:products-read');
    }

    public function index()
    {
        $products = Product::with('currency')
                    ->when(request()->search, function($q) {
                        $q->where('name', 'like', '%' . request('search') . '%');
                    })
                    ->latest()
                    ->paginate();
        return view('admin.products.index', compact('products'));
    }

    public function show(Product $product)
    {
        $product->load('currency');
        return view('admin.products.show', compact('product'));
    }

    public function destroy(Product $product)
    {
        Cache::forget('product.' . $product->id);
        // Delete File
        if ($product->file && Storage::disk(config('filesystems.default'))->exists($product->file)) {
            Storage::disk(config('filesystems.default'))->delete($product->file);
        }

        // Delete Cover Photo
        if (config('filesystems.default') == 'local') {
            if (\File::isFile($product->cover)) {
                \File::delete($product->cover);
            }
        } else {
            if (Storage::disk(config('filesystems.default'))->exists($product->cover)) {
                Storage::disk(config('filesystems.default'))->delete($product->cover);
            }
        }
        $product->delete();

        return response()->json([
            'message' => __('Product Deleted Successfully'),
            'redirect' => route('admin.products.index'),
        ]);
    }
}
