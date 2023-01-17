<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FooterController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:website-read')->only('index');
        $this->middleware('permission:website-update')->except('index');
    }

    public function index()
    {
        $footer = get_option('footer_setting', true, current_locale());

        return view('admin.settings.website.footer', compact('footer'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => ['nullable', 'string'],
            'address' => ['required', 'string'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string'],
            'copyright' => ['required', 'string'],
            'social' => ['nullable', 'array']
        ]);

        $social = [];

        foreach ($request->input('social') ?? [] as $value) {
            $social[] = [
                'icon_class' => $value['icon_class'],
                'website_url' => $value['website_url'],
            ];
        }



        $option = Option::firstOrNew([
            'key' => 'footer_setting',
            'lang' => current_locale()
        ]);

        $option->value = [
            'description' => $request->input('description'),
            'address' => $request->input('address'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'copyright' => $request->input('copyright'),
            'social' => $social
        ];
        $option->save();

        Cache::forget('website.home.'.current_locale());
        Cache::flush();

        return response()->json(__('Footer Settings Updated'));
    }
}
