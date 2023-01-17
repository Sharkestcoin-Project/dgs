<?php

namespace App\Http\Controllers\Admin\Website;

use App\Models\Option;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HeadingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:website-read')->only('index');
        $this->middleware('permission:website-update')->except('index');
    }

    public function index()
    {
        $languages = Option::where('key', '=', 'languages')
            ->withCasts(['value' => 'array'])
            ->select(['value'])
            ->first();

        $headingData = Option::whereIn('key', [
            'heading.welcome',
            'heading.feature',
            'heading.about',
            'heading.our-service',
            'heading.pricing',
            'heading.review',
            'heading.faq',
            'heading.latest-news',
            'heading.call-to-action',
            'heading.trusted-by',
            'heading.trusted-partner',
            'heading.about-us',
            'heading.contact',
            'heading.product',
        ])->get();

        $headings = [];
        foreach ($headingData as $heading) {
            $headings[$heading->key][$heading->lang] = $heading->value;
        }

        return view('admin.settings.website.heading.index', compact('languages', 'headings'));
    }

    public function updateWelcome(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'button1_text' => ['required', 'string'],
            'button1_url' => ['required', 'string'],
            'button2_text' => ['required', 'string'],
            'button2_url' => ['required', 'string'],
            'image' => ['required', 'string'],
            'lang' => ['required', 'string']
        ]);

        Option::updateOrCreate([
            'key' => 'heading.welcome',
            'lang' => $request->input('lang')
        ], [
            'value' => $validated
        ]);

        \Artisan::call('cache:clear');

        return response()->json(__('Welcome Section Updated'));
    }

    public function updateFeature(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'button_text' => ['required', 'string'],
            'button_url' => ['required', 'string'],
            'feature_1_icon' => ['nullable', 'string'],
            'feature_1_text' => ['nullable', 'string'],
            'feature_1_description' => ['nullable', 'string'],
            'feature_2_icon' => ['nullable', 'string'],
            'feature_2_text' => ['nullable', 'string'],
            'feature_2_description' => ['nullable', 'string'],
            'feature_3_icon' => ['nullable', 'string'],
            'feature_3_text' => ['nullable', 'string'],
            'feature_3_description' => ['nullable', 'string'],
        ]);

        Option::updateOrCreate([
            'key' => 'heading.feature',
            'lang' => $request->input('lang')
        ], [
            'value' => $validated
        ]);

        \Artisan::call('cache:clear');

        return response()->json(__('Feature Section Updated'));
    }

    public function updateAbout(Request $request)
    {
        $validated = $request->validate([
            'heading' => ['required', 'string'],
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'option_1' => ['required', 'string'],
            'option_2' => ['required', 'string'],
            'option_3' => ['required', 'string'],
            'option_4' => ['required', 'string'],
            'image' => ['required', 'string']
        ]);

        Option::updateOrCreate([
            'key' => 'heading.about',
            'lang' => $request->input('lang')
        ], [
            'value' => $validated
        ]);

        \Artisan::call('cache:clear');

        return response()->json(__('About Section Updated'));
    }

    public function updateOurService(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        Option::updateOrCreate([
            'key' => 'heading.our-service',
            'lang' => $request->input('lang')
        ], [
            'value' => $validated
        ]);

        \Artisan::call('cache:clear');

        return response()->json(__('Our Service Section Updated'));
    }

    public function updatePricing(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        Option::updateOrCreate([
            'key' => 'heading.pricing',
            'lang' => $request->input('lang')
        ], [
            'value' => $validated
        ]);

        \Artisan::call('cache:clear');

        return response()->json(__('Our Service Section Updated'));
    }

    public function updateReview(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        Option::updateOrCreate([
            'key' => 'heading.review',
            'lang' => $request->input('lang')
        ], [
            'value' => $validated
        ]);

        \Artisan::call('cache:clear');

        return response()->json(__('Review Section Updated'));
    }

    public function updateFaq(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'image' => ['required', 'string'],
        ]);

        Option::updateOrCreate([
            'key' => 'heading.faq',
            'lang' => $request->input('lang')
        ], [
            'value' => $validated
        ]);

        \Artisan::call('cache:clear');

        return response()->json(__('Faq Section Updated'));
    }

    public function updateLatestNews(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        Option::updateOrCreate([
            'key' => 'heading.latest-news',
            'lang' => $request->input('lang')
        ], [
            'value' => $validated
        ]);

        \Artisan::call('cache:clear');

        return response()->json(__('Latest News Section Updated'));
    }

    public function updateCallToAction(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'button_text' => ['required', 'string'],
            'button_url' => ['required', 'string'],
        ]);

        Option::updateOrCreate([
            'key' => 'heading.call-to-action',
            'lang' => $request->input('lang')
        ], [
            'value' => $validated
        ]);

        \Artisan::call('cache:clear');

        return response()->json(__('Call To Action Section Updated'));
    }

    public function updateTrustedBy(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'widget_1_title'  => ['required', 'string'],
            'widget_1_description'  => ['required', 'string'],
            'widget_2_rating'  => ['required', 'numeric'],
            'widget_2_rating_count'  => ['required', 'numeric'],
        ]);

        Option::updateOrCreate([
            'key' => 'heading.trusted-by',
            'lang' => $request->input('lang')
        ], [
            'value' => $validated
        ]);

        \Artisan::call('cache:clear');

        return response()->json(__('Trusted By Section Updated'));
    }

    public function updateTrustedPartner(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        Option::updateOrCreate([
            'key' => 'heading.trusted-partner',
            'lang' => $request->input('lang')
        ], [
            'value' => $validated
        ]);

        \Artisan::call('cache:clear');

        return response()->json(__('Trusted By Section Updated'));
    }

    public function updateAboutUs(Request $request)
    {
        $validated = $request->validate([
            'heading' => ['required', 'string'],
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        Option::updateOrCreate([
            'key' => 'heading.about-us',
            'lang' => $request->input('lang')
        ], [
            'value' => $validated
        ]);

        \Artisan::call('cache:clear');

        return response()->json(__('About US Section Updated'));
    }

    public function updateContact(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'email' => ['required', 'string'],
            'location' => ['required', 'string'],
            'map_url' => ['required', 'string'],
        ]);

        Option::updateOrCreate([
            'key' => 'heading.contact',
            'lang' => $request->input('lang')
        ], [
            'value' => $validated
        ]);

        \Artisan::call('cache:clear');

        return response()->json(__('Contact Section Updated'));
    }


    public function updateProduct(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        Option::updateOrCreate([
            'key' => 'heading.product',
            'lang' => $request->input('lang')
        ], [
            'value' => $validated
        ]);

        \Artisan::call('cache:clear');

        return response()->json(__('Product Section Updated'));
    }

    public function updateProducts(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        Option::updateOrCreate([
            'key' => 'heading.products',
            'lang' => $request->input('lang')
        ], [
            'value' => $validated
        ]);

        \Artisan::call('cache:clear');

        return response()->json(__('Product Section Updated'));
    }
}
