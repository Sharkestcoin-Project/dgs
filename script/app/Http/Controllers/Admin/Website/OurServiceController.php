<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OurServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:website-read')->only('index');
        $this->middleware('permission:website-update')->except('index');
    }

    public function index(){
        $ourServices = Category::where([
                'key' => 'our_services',
            ])
            ->get();

        return view('admin.settings.website.ourservices.index', compact('ourServices'));
    }

    public function create(){
        $languages = Option::where('key', '=', 'languages')
            ->withCasts(['value' => 'array'])
            ->select(['value'])
            ->first();

        return view('admin.settings.website.ourservices.create', compact('languages'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'icon' => ['required', 'string'],
            'title' => ['required', 'string'],
            'description' => ['required', 'string']
        ]);

        Category::create([
            'key' => 'our_services',
            'value' => $validated,
            'lang' => $request->input('lang')
        ]);

        Cache::forget('website.home.'.current_locale());

        return response()->json(__('Our Service Created Successfully'));
    }

    public function edit(Category $ourService)
    {
        $languages = Option::where('key', '=', 'languages')
            ->withCasts(['value' => 'array'])
            ->select(['value'])
            ->first();

        return view('admin.settings.website.ourservices.edit', compact('ourService', 'languages'));
    }

    public function update(Request $request, Category $ourService)
    {
        $validated = $request->validate([
            'icon' => ['required', 'string'],
            'title' => ['required', 'string'],
            'description' => ['required', 'string']
        ]);

        $ourService->update([
            'value' => $validated,
            'lang' => $request->input('lang')
        ]);

        Cache::forget('website.home.'.current_locale());

        return response()->json([
            'message' => __('Our Service Updated Successfully'),
            'redirect' => route('admin.settings.website.our-services.index')
        ]);
    }

    public function destroy(Category $ourService)
    {
        $ourService->delete();

        Cache::forget('website.home.'.current_locale());

        return response()->json([
            'message' => __('Our Service Deleted Successfully'),
            'redirect' => route('admin.settings.website.our-services.index')
        ]);

    }
}
