<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gateway;
use App\Models\Order;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use App\Rules\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Mail;
use App\Mail\LoginWithTokenMail;
use App\Mail\SendMail;
use App\Models\ProductOrder;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:users-create')->only('create', 'store');
        $this->middleware('permission:users-read')->only('index', 'show');
        $this->middleware('permission:users-update')->only('edit', 'update');
        $this->middleware('permission:users-delete')->only('edit', 'destroy');
    }

    public function index(Request $request)
    {
        $users = User::whereRole('user')
            ->when($request->get('src') !== null, function ($query) use($request){
                $query->where('name', 'LIKE', '%'.$request->get('src').'%')
                    ->orWhere('username', 'LIKE', '%'.$request->get('src').'%')
                    ->orWhere('email', 'LIKE', '%'.$request->get('src').'%')
                    ->orWhere('phone', 'LIKE', '%'.$request->get('src').'%');
            })
            ->withCount(['products', 'sales'])
            ->withSum('sales', 'amount')
            ->latest()
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $plans = Plan::whereStatus(1)->select(['id', 'name', 'price'])->get();
        $gateways = Gateway::whereStatus(1)->pluck('name', 'id');

        return view('admin.users.create', compact('plans', 'gateways'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'phone' => ['required', new Phone],
            'password' => ['required', Password::default()],
            'status' => ['required'],
            'plan' => ['nullable', 'exists:plans,id'],
            'gateway' => [
                Rule::requiredIf(fn() => $request->input('plan') !== null),
                'nullable',
                'exists:gateways,id'
            ],
            'trx' => [
                Rule::requiredIf(fn() => $request->input('gateway') !== null),
                'nullable',
                'string'
            ],
            'paid_status' => [
                Rule::requiredIf(fn() => $request->input('gateway') !== null),
                'nullable',
                Rule::in(0,1,2,3)
            ],
            'payment_status' => [
                Rule::requiredIf(fn() => $request->input('gateway') !== null),
                'nullable',
                Rule::in(0,1,2,3)
            ],
        ]);

        $user = \DB::transaction(function () use ($request){
            $plan = Plan::find($request->input('plan'));
            $gateway = Gateway::find($request->input('gateway'));

            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'username' => $this->usernameGenerate($request->input('email')),
                'password' => bcrypt($request->input('password')),
                'status' => $request->input('status'),
                'plan_id' => $request->input('plan') !== null ? $plan->id : null,
                'plan_meta' => $request->input('plan') !== null ? $plan->meta : null,
                'token' => Str::random(60)
            ]);

            if ($request->input('plan') !== null){
                Subscription::create([
                    'plan_id' => $plan->id,
                    'user_id' => $user->id,
                    'amount' => max($plan->price, 0),
                    'will_expire' => will_expire($plan),
                    'meta' => $plan->meta
                ]);

                Order::create([
                    "user_id" => \Auth::id(),
                    "plan_id" => $plan->id,
                    "gateway_id" => $gateway->id,
                    "trx" => $request->input('trx'),
                    "is_auto" => $gateway->is_auto,
                    "tax" => 0,
                    "will_expire" => will_expire($plan),
                    "price" => $plan->price,
                    "type" => 'payment',
                    "status" => $request->input('paid_status'),
                    "payment_status" => $request->input('payment_status'),
                ]);
            }

            if (config('system.queue.mail')) {
                Mail::to($user)->queue(new LoginWithTokenMail([
                    'subject' => __('Your account has been created successfully'),
                    'message' => __('Hey, :name your account has been created successfully', ['name' => $user->name]),
                    'button_text' => __('Login'),
                    'button_url' => route('login-with-token', $user->token)
                ]));
            } else {
                Mail::to($user)->send(new LoginWithTokenMail([
                    'subject' => __('Your account has been created successfully'),
                    'message' => __('Hey, :name your account has been created successfully', ['name' => $user->name]),
                    'button_text' => __('Login'),
                    'button_url' => route('login-with-token', $user->token)
                ]));
            }

            return $user;
        });

        return response()->json([
            'message' => __("User Created Successfully"),
            'redirect' => route('admin.users.show', $user->id)
        ]);
    }

    public function show(Request $request, User $user)
    {
        if ($request->ajax()){
            $salesStatistics = ProductOrder::whereUserId($user->id)
                ->orderBy('created_at')
                ->selectRaw('year(created_at) year, monthname(created_at) month, sum(amount) total')
                ->groupBy('year', 'month')
                ->get()
                ->map(function ($q) {
                    $data['year'] = $q->year;
                    $data['month'] = $q->month;
                    $data['total'] = number_format(max($q->total, 0), 2);

                    return $data;
                });

            return response()->json([
                'salesStatistics' => $salesStatistics
            ]);
        }

        $sales = ProductOrder::whereUserId($user->id)->latest()->paginate(10);

        return view('admin.users.show', compact('user', 'sales'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
       $validated = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,id,'.$user->id],
            'phone' => ['required', new Phone],
            'password' => ['nullable', Password::default()],
            'status' => ['required'],
        ]);

        $user->update([
            'password' => $request->input('password') == null ? $user->password : bcrypt($request->input('password'))
        ] + $validated);

        return response()->json([
            'message' => __("User Updated Successfully"),
            'redirect' => route('admin.users.show', $user->id)
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'message' => __('User Deleted Successfully'),
            'redirect' => url()->previous()
        ]);
    }

    public function sendEmail(Request $request, User $user)
    {
        $request->validate([
            'subject' => ['required', 'string'],
            'message' => ['required', 'string']
        ]);

        if (config('system.queue.mail')) {
            Mail::to($user)->queue(new SendMail([
                'subject' => $request->input('subject'),
                'message' => $request->input('message'),
            ]));
        } else {
            Mail::to($user)->send(new SendMail([
                'subject' => $request->input('subject'),
                'message' => $request->input('message'),
            ]));
        }

        return response()->json(__('Email Sent Successfully'));
    }

    private function usernameGenerate($email)
    {
        $explodeEmail = explode('@', $email);
        $username = $explodeEmail[0];
        $count_username = User::where('username', $username)->count();
        if ($count_username > 0) {
            $username = $username . $count_username + 1;
        }

        return $username;
    }

    public function login(User $user)
    {
        Auth::logout();
        Auth::login($user);

        return response()->json([
            'message' => __('You are logged in as :name', ['name' => $user->name]),
            'redirect' => route('user.dashboard')
        ]);
    }
}
