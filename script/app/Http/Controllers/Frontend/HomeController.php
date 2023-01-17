<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Option;
use App\Models\Plan;
use App\Models\Term;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data = cache_remember('website.heading.'.current_locale(), function (){
            $headingData = Option::whereLang(current_locale())
                ->whereIn('key', [
                    'heading.welcome',
                    'heading.feature',
                    'heading.about',
                    'heading.our-service',
                    'heading.pricing',
                    'heading.review',
                    'heading.faq',
                    'heading.latest-news',
                ])->get();

            $headings = [];
            foreach ($headingData as $heading) {
                $headings[$heading->key] = $heading->value;
            }

            $blog = Term::with('excerpt', 'preview')->whereStatus(1)->whereType('blog')->whereLang(current_locale())->latest()->limit(3)->get();
            $faqs = Category::where('key', '=', 'faq')->latest()->limit(5)->get();
            $reviews = Category::where('key', '=', 'reviews')->whereStatus(1)->latest()->get();
            $our_services = Category::where('key', '=', 'our_services')->whereLang(current_locale())->get();
            $plans = Plan::whereStatus(1)->get();

            return [
                'headings' => $headings,
                'blog' => $blog,
                'faqs' => $faqs,
                'reviews' => $reviews,
                'plans' => $plans,
                'our_services' => $our_services,
            ];
        });

        //Set SEO
        $seo = get_option('seo_home', true);
        $logo=$seo->meta_image ?? '';

        JsonLdMulti::setTitle($seo->site_name ?? env('APP_NAME'));
        JsonLdMulti::setDescription($seo->matadescription ?? null);
        JsonLdMulti::addImage(asset($logo));

        SEOMeta::setTitle($seo->site_name ?? env('APP_NAME'));
        SEOMeta::setDescription($seo->matadescription ?? null);
        SEOMeta::addKeyword($seo->tags ?? null);

        SEOTools::setTitle($seo->site_name ?? env('APP_NAME'));
        SEOTools::setDescription($seo->matadescription ?? null);
        SEOTools::opengraph()->addProperty('keywords', $seo->matatag ?? null);
        SEOTools::opengraph()->addProperty('image', asset($logo));
        SEOTools::twitter()->setTitle($seo->site_name ?? env('APP_NAME'));
        SEOTools::twitter()->setSite($seo->twitter_site_title ?? null);
        SEOTools::jsonLd()->addImage(asset($logo));
        SEOMeta::addKeyword($seo->tags ?? null);

        return view('frontend.index', compact('data'));
    }
}
