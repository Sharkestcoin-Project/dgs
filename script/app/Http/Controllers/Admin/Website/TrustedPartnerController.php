<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TrustedPartnerController extends Controller
{
    public function index(){
        $trustedPartner = Category::where([
                'key' => 'trusted_partner',
            ])
            ->get();

        return view('admin.settings.website.trustedpartner.index', compact('trustedPartner'));
    }

    public function create(){
        return view('admin.settings.website.trustedpartner.create');
    }

    public function store(Request $request){
        $request->validate([
            'image' => ['required', 'string'],
            'title' => ['required', 'string'],
            'website_link' => ['required', 'url']
        ]);

        Category::create([
            'key' => 'trusted_partner',
            'value' => [
                'website_link' => $request->input('website_link'),
                'title' => $request->input('title'),
                'image' => $request->input('image')
            ]
        ]);

        Cache::forget('website.home.'.current_locale());

        return response()->json(__('Trusted Partner Created Successfully'));
    }

    public function edit(Category $trustedPartner)
    {
        return view('admin.settings.website.trustedpartner.edit', compact('trustedPartner'));
    }

    public function update(Request $request, Category $trustedPartner)
    {
        $request->validate([
            'image' => ['required', 'string'],
            'title' => ['required', 'string'],
            'website_link' => ['required', 'url']
        ]);

        $trustedPartner->update([
            'value' => [
                'website_link' => $request->input('website_link'),
                'title' => $request->input('title'),
                'image' => $request->input('image')
            ]
        ]);

        Cache::forget('website.home.'.current_locale());

        return response()->json([
            'message' => __('Trusted Partner Updated Successfully'),
            'redirect' => route('admin.settings.website.trusted-partner.index')
        ]);
    }

    public function destroy(Category $trustedPartner)
    {
        $trustedPartner->delete();

        Cache::forget('website.home.'.current_locale());

        return response()->json([
            'message' => __('Trusted Partner Deleted Successfully'),
            'redirect' => route('admin.settings.website.trusted-partner.index')
        ]);

    }
}
