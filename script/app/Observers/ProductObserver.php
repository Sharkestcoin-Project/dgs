<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    public function created(Product $product)
    {
        cache_remember('product.'.$product->id, function () use ($product){
            return $product;
        });
    }

    public function updated(Product $product)
    {
        Cache::forget('product.'.$product->id);
        cache_remember('product.'.$product->id, function () use ($product){
            return $product;
        });
    }

    public function deleted(Product $product)
    {
        Cache::forget('product.'.$product->id);
    }

    public function restored(Product $product)
    {
        Cache::forget('product.'.$product->id);
        cache_remember('product.'.$product->id, function () use ($product){
            return $product;
        });
    }
}
