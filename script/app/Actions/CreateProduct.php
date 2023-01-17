<?php

namespace App\Actions;

use App\Models\Product;
use App\Models\TemporaryFile;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CreateProduct
{
    public function create(Request $request)
    {
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
            "cover" => ['required', 'is_png'],
            "return_url" => ['nullable', 'url'],
            "direct_url" => ['nullable', 'url'],
            "theme_color" => ['required', 'string'],
            "currency" => ['required', 'exists:currencies,id'],
        ]);

        // Move Temporary File To Upload Product Directory
        $fileName = false;
        if ($request->folder) {
            $temporaryFile = TemporaryFile::where('folder', $request->folder)->first();
            $fileName = 'uploads/' . Auth::id() . '/products/' . $temporaryFile->filename;

            if ($temporaryFile) {
                $path = 'temp/' . $temporaryFile->folder . '/' . $temporaryFile->filename;
                Storage::disk(config('filesystems.default'))->move($path, $fileName);
            } else {
                throw new ModelNotFoundException(__('File Not Found! Please try again'), 404);
            }
        } elseif($request->direct_url == '') {
            return response()->json(__('The file field is required'), 404);
        }

        //Upload Cover Photo
        $file = base64_image_decode($request->input('cover'));
        $coverPath = 'uploads/' . Auth::id() . date('/y') . '/' . date('m');
        $coverName = $coverPath . '/'.uniqid().$file['type'];

        if (config('filesystems.default') == 'local'){
            Storage::disk('public')->put($coverName, $file['content']);
        } else {
            Storage::disk(config('filesystems.default'))->put($coverName, $file['content']);
        }

        return Product::create([
                'file' => $fileName ?? NULL,
                'cover' => $coverName,
                'currency_id' => $request->input('currency'),
                'user_id' => Auth::id(),
                'size' => $fileName ? Storage::disk(config('filesystems.default'))->size($fileName):0,
                'meta' => [
                    'direct_url' => $request->direct_url
                ]
            ] + $validated);
    }
}
