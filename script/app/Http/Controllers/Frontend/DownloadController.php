<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Str;
use App\Mail\ProductOtpMail;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use App\Mail\NewDownloadLinkMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Storage;

class DownloadController extends Controller
{
    public function download($token)
    {
        $productOrder = ProductOrder::where('token', $token)->first();
        abort_if(!$productOrder, 404);
        if ($productOrder->will_expire_at < now()){
            return view('frontend.downloads.confirmemail', compact('productOrder'));
        }

        return view('frontend.payment.success', compact('productOrder'));
    }

    public function sendotp(ProductOrder $productOrder)
    {
        if (!$productOrder) {
            return response()->json(__("Product not found."), 404);
        }

        $otp = rand();
        session()->put('download_otp', $otp);

        if (env('QUEUE_MAIL')) {
            Mail::to($productOrder->email)->queue(new ProductOtpMail($otp));
        } else {
            Mail::to($productOrder->email)->send(new ProductOtpMail($otp));
        }

        return response()->json([
            'message' => "An OTP has been sended to your mail. Please check and confirm."
        ]);
    }

    public function resent(Request $request, ProductOrder $productOrder)
    {
        $request->validate([
            'download_otp' => ['required', 'integer']
        ]);

        $download_otp = session()->get('download_otp');

        if ($download_otp == $request->download_otp) {
            $productOrder->update([
                'token' => now()->timestamp.Str::random(30),
                'will_expire_at' => now()->addHours(168),
            ]);

            if (config('system.queue.mail')){
                \Mail::to($productOrder->email)->queue(new NewDownloadLinkMail($productOrder));
            }else{
                \Mail::to($productOrder->email)->send(new NewDownloadLinkMail($productOrder));
            }
        } else {
            return response()->json(__('Your OTP is incorrect please check your mail and confirm.'), 404);
        }

        session()->forget('download_otp');

        return response()->json(__('A new fresh download link sent to your email'));
    }

    public function start(ProductOrder $productOrder)
    {
        if ($productOrder->will_expire_at < now()){
            return view('frontend.downloads.confirmemail', compact('productOrder'));
        }
        if ($productOrder->is_open == 0) {
            $productOrder->is_open = 1;
            $productOrder->save();
        }
        $file = $productOrder->product->file;
        if (Storage::disk(config('filesystems.default'))->exists($file)){
            return Storage::disk(config('filesystems.default'))->download($file);
        }else{
            abort(404, __("File Not Found"));
        }
    }
}
