<?php

namespace App\Actions;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DeleteProduct
{
    public function delete(Product $product)
    {
        abort_if($product->user_id !== Auth::id(), 403);
        // Delete File
        if ($product->file && Storage::disk(config('filesystems.default'))->exists($product->file)){
            Storage::disk(config('filesystems.default'))->delete($product->file);
        }

        // Delete Cover Photo
        if (config('filesystems.default') == 'local'){
            if (\File::isFile($product->cover)){
                \File::delete($product->cover);
            }
        }else{
            if (Storage::disk(config('filesystems.default'))->exists($product->cover)){
                Storage::disk(config('filesystems.default'))->delete($product->cover);
            }
        }

        // Delete Product
        $product->delete();
    }
}
