<?php

namespace App\Traits;

use App\Exceptions\FileSizeLimitExceed;
use App\Exceptions\ProductLimitExceed;
use App\Models\Product;
use App\Models\TemporaryFile;
use Auth;
use finfo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait HasProduct
{
    /**
     * Check Product Limit
     * @return void
     * @throws ProductLimitExceed
     */
    public function checkProductLimit(): void
    {
        $products = Auth::user()->products()->count();
        $limit = Auth::user()->product_limit ?? 0;

        if ($limit <= $products && $limit != -1){
            throw new ProductLimitExceed();
        }
    }

    public function checkMaximumFileSize($fileSize)
    {
        $maxFileSize = Auth::user()->max_file_size ?? 0;
        $maxFileSize = $maxFileSize * 1048576; // Convert MB to B
        $totalUploadedSize = Auth::user()->products()->sum('size');
        $fileSize = $totalUploadedSize + $fileSize;

        if ($fileSize >= $maxFileSize){
            throw new FileSizeLimitExceed();
        }
    }

    public function upload(Request $request)
    {
        if ($request->type == 'local') {
            $validator = \Validator::make($request->all(), [
                'file' => ['required', 'file', 'mimes:zip']
            ]);

            if ($validator->fails()){
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $file = file_get_contents($file);

        } elseif ($request->type == 'direct') {
            $url = $request->input('url');
            $file = file_get_contents($url);
            $filename = basename($request->input('url'));
        }

        $temp = $this->saveToTemporary($file, $filename);

        $size = Storage::disk(config('filesystems.default'))->size('temp/'.$temp->folder.'/'.$filename);
        $this->checkMaximumFileSize($size);

        return response()->json($temp);
    }

    public function destroyFile(Product $product)
    {
        if (Storage::disk(config('filesystems.default'))->exists($product->file)) {
            Storage::disk(config('filesystems.default'))->delete($product->file);
        }
        $product->update([
            'file' => null
        ]);
        return response()->json(__('File Deleted Successfully'));
    }

    public function destroyTemporary(TemporaryFile $file)
    {
        $path = 'temp/' . $file->folder;
        if (Storage::disk(config('filesystems.default'))->exists($path)) {
            Storage::disk(config('filesystems.default'))->deleteDirectory($path);
        }
        $file->delete();
        return response()->json(__('File Deleted Successfully'));
    }

    public function saveToTemporary($file, $filename)
    {
        $folder = uniqid() . '-' . now()->timestamp;

        Storage::disk(config('filesystems.default'))->put('temp/' . $folder . '/' . $filename, $file);

        return TemporaryFile::create([
            'folder' => $folder,
            'filename' => $filename
        ]);
    }
}
