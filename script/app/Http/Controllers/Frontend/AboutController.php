<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Option;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\SEOTools;

class AboutController extends Controller
{
    public function index()
    {
        $data = cache_remember('website.about.'.current_locale(), function (){
            $headingData = Option::whereLang(current_locale())
                ->whereIn('key', [
                    'heading.about',
                    'heading.about-us',
                    'heading.trusted-by',
                    'heading.trusted-partner',
                ])->get();

            $headings = [];
            foreach ($headingData as $heading) {
                $headings[$heading->key] = $heading->value;
            }

            $trustedPartners = Category::where(['key' => 'trusted_partner', 'lang' => 'en'])->get();

            return [
                'headings' => $headings,
                'trustedPartners' => $trustedPartners,
            ];
        });

        $seo = get_option('seo_about', true,'en');
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

        return view('frontend.about', compact('data'));
    }
}
