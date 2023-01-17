<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserPlan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $plans = UserPlan::when(request()->src, function($q) {
                $q->where('name', 'like', '%' . request('src') . '%');
            })
            ->latest()
            ->paginate();

        return view('admin.subscriptions.index', compact('plans'));
    }

    public function destroyMass(Request $request){
        foreach ($request->input('id') as $id) {
            $plan = UserPlan::findOrFail($id);
            $plan->delete();
        }

        return response()->json([
            'message' => __('Subscription Plans Deleted Successfully'),
            'redirect' => route('admin.subscriptions.index')
        ]);
    }
}
