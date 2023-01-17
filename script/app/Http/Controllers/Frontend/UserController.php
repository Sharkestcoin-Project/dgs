<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereHas('products')
            ->whereDate('will_expire', '>', today())
            ->with('plans')
            ->latest()
            ->paginate();
        return view('frontend.users.index', compact('users'));
    }

    public function show(User $user)
    {
        abort_if($user->will_expire < today(), 404);
        $user->loadCount('products', 'plans');
        $products = $user->products()->latest()->paginate();
        return view('frontend.users.show', compact('user', 'products'));
    }

    public function share(User $user)
    {
        abort_if($user->will_expire < today(), 404);
        $user->loadCount('products', 'plans');
        $products = $user->products()->latest()->paginate();
        return view('frontend.users.share', compact('user', 'products'));
    }

    public function showSubscriptions(User $user)
    {
        abort_if($user->will_expire < today(), 404);
        $user->loadCount('products', 'plans');
        $plans = $user->plans()->orderBy('price')->latest()->paginate();
        return view('frontend.users.show', compact('user', 'plans'));
    }

    public function showSubscription(User $user, UserPlan $plan)
    {
        abort_if($user->will_expire < today(), 404);
        return view('frontend.users.showPlan', compact('plan', 'user'));
    }

    public function getPlan(User $user, UserPlan $plan)
    {
        abort_if($user->will_expire < today(), 404);
        return view('frontend.users.getPlan', compact('user','plan'))->render();
    }
}
