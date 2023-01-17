<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\SEOTools;
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('currency', 'user')
            ->whereHas('user', function (Builder $builder){
                $builder->whereDate('will_expire', '>', today());
            })
            ->withOrdersCount()
            ->orderBy('orders_count', 'desc')
            ->latest()
            ->paginate();

        $heading = get_option('heading.product');

        $seo = get_option('seo_products', true,'en');
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

        return view('frontend.products.index', compact('products', 'heading'));
    }

    public function show($id)
    {
        $product = cache_remember('product.'.$id, function () use ($id){
            return Product::with('user')->findOrFail($id);
        });

        return view('frontend.products.show', compact('product'));
    }

    public function show2()
    {
        return view('frontend.products.show2');
    }

    public function iframe($id)
    {
        $product = cache_remember('product.'.$id, function () use ($id){
            return Product::with('user')->findOrFail($id);
        });

        return view('frontend.iframe.index', compact('product'));
    }
}
