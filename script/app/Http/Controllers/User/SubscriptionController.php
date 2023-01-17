<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\ProductSubscriptionRenewMail;
use App\Mail\SubscriptionRenewalMail;
use App\Models\Currency;
use App\Models\ProductOrder;
use App\Models\UserPlanOrder;
use App\Models\UserPlanSubscriber;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\UserPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $src = $request->get('src');

        $user = Auth::user();

        if ($user->plan->sell_subscription){
            $plans = UserPlan::whereUserId($user->id)
                ->when(!is_null($src), function (Builder $builder) use($src){
                    $builder->where('name', 'LIKE', '%'.$src.'%');
                })
                ->latest()
                ->paginate();
        }else{
            $plans = [];
        }

        return view('user.subscriptions.index', compact('plans'));
    }

    public function create()
    {
        $currencies = Currency::whereStatus(1)->get();

        if (!Auth::user()->sell_subscription){
            return redirect()->back()->with('warning', __("Your plan does not support to sell subscription"));
        }elseif((Auth::user()->subscription_plan_limit - Auth::user()->plans()->count()) < 1){
            return redirect()->back()->with('warning', __("Plan creation limit is exceeds"));
        }else{
            return view('user.subscriptions.create', compact('currencies'));
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'period' => ['required', Rule::in(["weekly", "monthly", "yearly"])],
            'cover' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'features' => ['required', 'array'],
            'features.*.title' => ['required', 'string'],
            'currency' => ['required', 'exists:currencies,id'],
            'welcome_message' => ['required', 'string'],
            'return_url' => ['nullable', 'active_url']
        ]);

        if (!Auth::user()->sell_subscription){
            return response()->json([
                'message' => __("Your plan does not support to sell subscription"),
            ], 403);
        }elseif((Auth::user()->subscription_plan_limit - Auth::user()->plans()->count()) < 1){
            return response()->json([
                'message' => __("Plan creation limit is exceeds")
            ], 403);
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

        $plan = UserPlan::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'period' => $request->input('period'),
            'cover' => $coverName,
            'description' => $request->input('description'),
            'currency_id' => $request->input('currency'),
            'return_url' => $request->input('return_url'),
            'meta' => [
                'features' => $request->input('features'),
                'welcome_message' => $request->input('welcome_message')
            ],
            'user_id' => Auth::id()
        ]);

        return response()->json([
            'message' => __('Subscription Plan Created Successfully'),
            'redirect' => route('user.subscription.iframe', $plan->id)
        ]);
    }

    public function edit(UserPlan $subscription)
    {
        abort_if($subscription->user_id !== Auth::id(), 404);
        $currencies = Currency::whereStatus(1)->get();
        return view('user.subscriptions.edit', compact('subscription', 'currencies'));
    }

    public function update(Request $request, UserPlan $subscription)
    {
        abort_if($subscription->user_id !== Auth::id(), 404);
        $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'period' => ['required', Rule::in(["weekly", "monthly", "yearly"])],
            'cover' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'features' => ['required', 'array'],
            'features.*.title' => ['required', 'string'],
            'currency' => ['required', 'exists:currencies,id'],
            'welcome_message' => ['required', 'string'],
            'return_url' => ['nullable', 'active_url']
        ]);

        if ($request->input('cover')){
            $file = base64_image_decode($request->input('cover'));
            $coverPath = 'uploads/' . Auth::id() . date('/y') . '/' . date('m');
            $coverName = $coverPath . '/'.uniqid().$file['type'];

            if (config('filesystems.default') == 'local'){
                Storage::disk('public')->put($coverName, $file['content']);
            } else {
                Storage::disk(config('filesystems.default'))->put($coverName, $file['content']);
            }
        }

        $subscription->update([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'period' => $request->input('period'),
            'cover' => $coverName ?? $subscription->cover,
            'description' => $request->input('description'),
            'currency_id' => $request->input('currency'),
            'return_url' => $request->input('return_url'),
            'meta' => [
                'features' => $request->input('features'),
                'welcome_message' => $request->input('welcome_message')
            ]
        ]);

        return response()->json([
            'message' => __('Subscription Plan Update Successfully'),
            'redirect' => route('user.subscriptions.index')
        ]);
    }

    public function destroy(UserPlan $subscription)
    {
        abort_if($subscription->user_id !== Auth::id(), 404);
        $subscription->delete();

        return response()->json([
            'message' => __('Subscription Plan Deleted Successfully'),
            'redirect' => route('user.subscriptions.index')
        ]);
    }

    public function destroyMass(Request $request){
        if (count($request->input('ids')) < 1){
            return response()->json(['message' => __("Please select at least one item")]);
        }

        UserPlan::whereUserId(Auth::id())
            ->whereIn('id', $request->input('id'))
            ->delete();

        return response()->json([
            'message' => __('Subscription Plans Deleted Successfully'),
            'redirect' => route('user.subscriptions.index')
        ]);
    }

    public function iframe($id)
    {
        $plan = UserPlan::whereUserId(auth()->id())->with('user')->findOrFail($id);
        return view('user.subscriptions.subscription-links', compact('plan'));
    }
}
