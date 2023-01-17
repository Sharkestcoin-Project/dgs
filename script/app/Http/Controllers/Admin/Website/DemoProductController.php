<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DemoProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:website-read')->only('index');
        $this->middleware('permission:website-update')->except('index');
    }

    public function index()
    {
        $demo = get_option('demo_product', true);
        return view('admin.settings.website.demo', compact('demo'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'file' => ['nullable', 'file'],
            'price' => ['required', 'numeric'],
            'product_cover' => ['required', 'string'],
            'user_name' => ['required', 'string'],
            'user_avatar' => ['required', 'string'],
        ]);

        $demo = get_option('demo', true);
        if ($request->hasFile('file')){
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $file = file_get_contents($file);
            $path = 'uploads/'.$filename;
            Storage::disk(config('filesystems.default'))->put($path, $file);

            // Delete Old File
            $dlPath = str($demo->file ?? '')->remove('/storage')->remove('storage');
            if (isset($demo) && Storage::disk(config('filesystems.default'))->exists($dlPath)){
                Storage::disk(config('filesystems.default'))->delete($dlPath);
            }
            $path = '/storage/'.$path;
        }

        Option::updateOrCreate([
            'key' => 'demo_product',
            'lang' => 'en'
        ], [
            'value' => [
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'file' => $path ?? $demo->file ?? null,
                'price' => $request->input('price'),
                'product_cover' => $request->input('product_cover'),
                'user_name' => $request->input('user_name'),
                'user_avatar' => $request->input('user_avatar'),
            ]
        ]);

        return response()->json(__('Demo Product Updated Successfully'));
    }

    public function download()
    {
        $demo = get_option('demo_product', true);

        $path = str($demo->file ?? null)->remove('/storage')->remove('storage');
        if (isset($demo) && Storage::disk(config('filesystems.default'))->exists($path)){
            return Storage::disk(config('filesystems.default'))->download($path);
        }else{
            abort(404, 'Demo Product Not Found');
        }
    }
}
