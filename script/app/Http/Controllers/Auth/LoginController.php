<?php

namespace App\Http\Controllers\Auth;

use Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $request->wantsJson()
                    ? response()->json([
                        'message' => __('Logged In Successfully'),
                        'redirect' => $this->redirectPath()
                    ])
                    : redirect()->intended($this->redirectPath());
    }

    public function redirectTo()
    {
        $auth = Auth::user();

        if (Auth::user()->role == 'admin') {
            return $this->redirectTo = route('admin.dashboard');
        }
        if ($auth->role == 'user') {
            return $this->redirectTo = route('user.dashboard');
        }

        $this->middleware('guest')->except('logout');
    }


    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

//        if ($response = $this->loggedOut($request)) {
//            return $response;
//        }

        return $request->wantsJson()
            ? new JsonResponse([
                'message' => __('Logged Out Successfully'),
                'redirect' => url('/')
            ], 204)
            : redirect('/');
    }

    public function loginWithToken(User $user)
    {
        Auth::logout();
        Auth::login($user);

        Session::flash('success', __('Logged In Successfully'));

        return redirect()->intended($this->redirectPath());
    }

    // Google Login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    // Google Callback
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();
        $this->registerOrLoginUser($user);
        return redirect()->route('user.dashboard');
    }

    // Facebook Login
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    // Facebook Callback
    public function handleFacebookCallback()
    {
        return $user = Socialite::driver('facebook')->user();
        $this->registerOrLoginUser($user);
        return redirect()->route('user.dashboard');
    }

    // Github Login
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }
    // Github Callback
    public function handleGithubCallback()
    {
        $user = Socialite::driver('github')->user();
        $this->registerOrLoginUser($user);
        return redirect()->route('user.dashboard');
    }

    protected function registerOrLoginUser($data)
    {
        $user = User::where('email', $data->email)->first();
        $plan = Plan::whereStatus(1)->where('is_trial', 1)->first();
        if (!$user) {
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->username = str_replace(" ", "", strtolower($data->name));
            $user->plan_id = $plan->id;
            $user->plan_meta = $plan;
            $user->avatar = $data->avatar;
            $user->save();
        }

        Auth::login($user);
    }
}
