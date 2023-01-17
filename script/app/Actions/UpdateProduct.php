<?php

namespace App\Actions;

use App\Models\Product;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UpdateProduct
{
    public function update(Request $request, Product $product)
    {
        $request['notify_previous_buyer'] = $request->has('notify_previous_buyer');

        Validator::extend('is_png',function($attribute, $value, $params, $validator) {
            $image_parts = explode(";base64,", $value);
            $file_type_aux = explode("data:", $image_parts[0]);
            $file_type = $file_type_aux[1];

            return $file_type == "image/png";
        });

        $validated = $request->validate([
            "name" => ['required', 'string'],
            "description" => ['required', 'string'],
            "price" => ['required', 'numeric', 'min:0'],
            "notify_previous_buyer" => ['required', 'boolean'],
            "cover" => ['nullable', 'is_png'],
            "return_url" => ['nullable', 'url'],
            "theme_color" => ['required', 'string'],
            "currency" => ['required', 'exists:currencies,id'],
        ]);

        $fileName = $product->file;
        if ($request->input('folder'))
        {
            // Move Temporary File To Upload Product Directory
            $temporaryFile = TemporaryFile::where('folder', $request->input('folder'))->first();
            $fileName = 'uploads/' . Auth::id() . '/products/' . $temporaryFile->filename;

            if ($temporaryFile) {
                $path = 'temp/' . $temporaryFile->folder . '/' . $temporaryFile->filename;
                // Delete Old File
                if ($product->file && Storage::disk(config('filesystems.default'))->exists($product->file)){
                    Storage::disk(config('filesystems.default'))->delete($product->file);
                }
                Storage::disk(config('filesystems.default'))->copy($path, $fileName);
            } else {
                return response()->json(__('File Not Found! Please try again'), 404);
            }
        }

        if ($request->input('cover')) {
            //Upload Cover Photo
            $file = base64_image_decode($request->input('cover'));
            $coverPath = 'uploads/' . Auth::id() . date('/y') . '/' . date('m') . '/';
            $coverName = $coverPath . '/' . uniqid().$file['type'];

            if (config('filesystems.default') == 'local') {
                Storage::disk('public')->put($coverName, $file['content']);
            } else {
                Storage::disk(config('filesystems.default'))->put($coverName, $file['content']);
            }

            if (config('filesystems.default') == 'local') {
                if (Storage::disk('public')->exists($product->cover)){
                    Storage::disk('public')->delete($product->cover);
                }
            } else {
                if (Storage::disk(config('filesystems.default'))->exists($product->cover)){
                    Storage::disk(config('filesystems.default'))->delete($product->cover);
                }
            }
        }

        $product->update([
                'file' => $request->direct_url ? NULL : $fileName,
                'cover' => $coverName ?? $product->cover,
                'currency_id' => $request->input('currency'),
                'size' => $request->direct_url ? 0 : Storage::disk(config('filesystems.default'))->size($fileName),
                'meta' => [
                    'direct_url' => $request->direct_url
                ]
            ] + $validated);
    }
}
