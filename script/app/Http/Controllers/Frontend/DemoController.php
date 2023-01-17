<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\DemoMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class DemoController extends Controller
{
    public function demoEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email']
        ]);

        if (config('system.queue.mail')){
            Mail::to($request->input('email'))->queue(new DemoMail());
        }else{
            Mail::to($request->input('email'))->send(new DemoMail());
        }

        return response()->json(__('Download link sent to your email'));
    }

    public function index($timestamp)
    {
        $demo = get_option('demo_product', true);
        abort_if(Carbon::createFromTimestamp($timestamp) < now(), 403);
        abort_if(!isset($demo), 404);

        $path = str($demo->file ?? null)->remove('/storage')->remove('storage');
        if (Storage::disk(config('filesystems.default'))->exists($path)){
            $filesize = Storage::disk(config('filesystems.default'))->size($path);
            $filetype = Storage::disk(config('filesystems.default'))->mimeType($path);
            $filetype = str($filetype)->upper()->explode('/')[1] ?? null;
        }

        return view('frontend.downloads.demo', compact('demo', 'timestamp', 'filesize', 'filetype'));
    }

    public function download($timestamp)
    {
        $demo = get_option('demo_product', true);
        abort_if(Carbon::createFromTimestamp($timestamp) < now(), 403);
        abort_if(!isset($demo), 404);
        $path = str($demo->file ?? null)->remove('/storage')->remove('storage');
        if (Storage::disk(config('filesystems.default'))->exists($path)){
            return Storage::disk(config('filesystems.default'))->download($path);
        }else{
            abort(404, __("File Not Found"));
        }
    }
}
