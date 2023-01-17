<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

class PlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:plans-create')->only('create', 'store');
        $this->middleware('permission:plans-read')->only('index', 'show');
        $this->middleware('permission:plans-update')->only('edit', 'update');
        $this->middleware('permission:plans-delete')->only('destroy');
    }

    public function index(Request $request)
    {
        $all      = Plan::count();
        $active   = Plan::where('status', '1')->count();
        $inactive = Plan::where('status', '0')->count();

        $plans = Plan::when($request->get('type') !== null, function (Builder $query) use ($request){
            $type = $request->get('type');
            if ($type == 'active'){
                $type = 1;
            }elseif ($type == 'inactive'){
                $type = 0;
            }
            $query->where('status', '=', $type);
        })
            ->withSum('orders', 'price')
            ->withCount(['orders', 'active_orders'])
            ->paginate(10);

        return view('admin.plans.index', compact('plans', 'active', 'inactive', 'all'));
    }

    public function create()
    {
        $features = Plan::features();

        return view('admin.plans.create', compact('features'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'duration' => ['required', 'integer'],
            'price' => ['required', 'numeric'],
            'status' => ['required', 'boolean'],
            'is_trial' => ['required', 'boolean'],
            'featured' => ['required', 'boolean'],
            'withdraw_charge' => ['integer', 'min:1'],
            'meta' => ['nullable', 'array']
        ]);

        Plan::create(['meta' => $request->input('meta')] + $validated);

        return response()->json([
            'message' => __('Plan Created Successfully'),
            'redirect' => route('admin.plans.index')
        ]);
    }

    public function edit(Plan $plan)
    {
        $features = Plan::features();
        return view('admin.plans.edit', compact('plan', 'features'));
    }


    public function update(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'duration' => ['required', 'integer'],
            'price' => ['required', 'numeric'],
            'status' => ['required', 'boolean'],
            'is_trial' => ['required', 'boolean'],
            'featured' => ['required', 'boolean'],
            'withdraw_charge' => ['integer', 'min:1'],
            'meta' => ['nullable', 'array']
        ]);

        $plan->update($validated);

        return response()->json([
            'message' => __('Plan Updated Successfully'),
            'redirect' => route('admin.plans.index')
        ]);
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();

        return response()->json([
            'message' => __('Plan Deleted Successfully'),
            'redirect' => route('admin.plans.index')
        ]);
    }

    public function destroyMass(Request $request){
        foreach ($request->input('id') as $id) {
            $plan = Plan::findOrFail($id);
            $plan->delete();
        }

        return response()->json([
            'message' => __('Plans Deleted Successfully'),
            'redirect' => route('admin.plans.index')
        ]);
    }
}
