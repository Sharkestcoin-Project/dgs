<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class PlanExpiredMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (
            Auth::check() &&
            Auth::user()->will_expire < today() &&
            config('system.users.force_to_purchase_plan')
        ){
            \Session::flash('warning', __("You have to purchase a paid subscription"));
            return redirect()->route('user.settings.subscriptions.index');
        }
        return $next($request);
    }
}
