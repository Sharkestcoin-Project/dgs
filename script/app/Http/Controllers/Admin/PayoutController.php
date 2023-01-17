<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Payout;
use App\Models\Wallet;
use App\Mail\PayoutMail;
use Illuminate\Http\Request;
use App\Models\UserPayoutMethod;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class PayoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:payouts-read');
    }

    public function index()
    {
        $data['total_payouts'] = Payout::count();
        $data['total_approved'] = Payout::where('status', 'approved')->count();
        $data['total_rejected'] = Payout::where('status', 'rejected')->count();
        $data['total_pending'] = Payout::where('status', 'pending')->count();
        $data['payouts'] = Payout::latest()->with('method.currency')
                    ->when(request('status') == 'approved', function($q) {
                        $q->where('status', 'approved');
                    })
                    ->when(request('status') == 'rejected', function($q) {
                        $q->where('status', 'rejected');
                    })
                    ->when(request('status') == 'pending', function($q) {
                        $q->where('status', 'pending');
                    })
                    ->paginate(10);
        return view('admin.payouts.index', $data);
    }

    public function show(Payout $payout)
    {
        $payout->load('user', 'method.currency');
        $usermethod = UserPayoutMethod::where('user_id', $payout->user_id)->where('payout_method_id', $payout->payout_method_id)->first();
        return view('admin.payouts.show', compact('payout', 'usermethod'));
    }

    public function approved(Request $request)
    {
        $payout = Payout::with('user')->find($request->payout);
        if ($payout->status == 'rejected') {
            $wallet = Wallet::where('user_id', $payout->user_id)->where('currency_id', $payout->currency_id)->first();
            if ($wallet->wallet >= $payout->amount) {
                $wallet->update([
                    'wallet' => $wallet->wallet - $payout->amount
                ]);
            } else {
                return back()->with('error', __('Insufficient balance.'));
            }
        }

        // Send Email to admin
        if (env('QUEUE_MAIL')) {
            Mail::to($payout->user->email)->queue(new PayoutMail($payout));
        } else {
            Mail::to($payout->user->email)->send(new PayoutMail($payout));
        }

        $payout->update([
            'status' => 'approved'
        ]);

        return response()->json([
            'message' => __('Payout approved successfully.'),
            'redirect' => route('admin.payouts.index')
        ]);
    }

    public function reject(Request $request)
    {
        $payout = Payout::with('user')->find($request->payout);
        $wallet = Wallet::where('user_id', $payout->user_id)->where('currency_id', $payout->currency_id)->first();
        $wallet->update([
            'wallet' => $wallet->wallet + $payout->amount
        ]);
        $payout->update([
            'status' => 'rejected'
        ]);

        // Send Email to admin
        if (env('QUEUE_MAIL')) {
            Mail::to($payout->user->email)->queue(new PayoutMail($payout));
        } else {
            Mail::to($payout->user->email)->send(new PayoutMail($payout));
        }

        return response()->json([
            'message' => __('Payout rejected successfully.'),
            'redirect' => route('admin.payouts.index')
        ]);
    }

    public function deleteAll(Request $request)
    {
        foreach ($request->ids as $id) {
            $method = Payout::find($id);
            $method->delete();
        }
        return response()->json([
            'message' => __('Payout deleted successfully'),
            'redirect' => route('admin.payouts.index')
        ]);
    }
}
