<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Term;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $heading = get_option('heading.latest-news');
        $src = $request->get('search');
        $tag = $request->get('tag');

        $blog = Term::whereType('blog')->whereStatus(1)->whereLang(current_locale())
            ->when($src !== null, function (Builder $builder) use ($src) {
                $builder->where('title', 'LIKE', '%' . $src . '%');
            })
            ->when($src !== null, function (Builder $builder) use ($tag) {
                $builder->whereHas('metaTag', function (Builder $builder) use ($tag) {
                    $builder->where('value', 'LIKE', '%' . $tag . '%');
                });
            })
            ->latest()
            ->paginate(10);

       

        $seo = get_option('seo_blog', true,'en');
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

        return view('frontend.blog.index', compact('heading', 'blog'));
    }

    public function post(Term $post)
    {
        abort_if(!$post->status, 404);
        $recentPosts = Term::whereType('blog')
            ->whereLang(current_locale())
            ->whereStatus(1)
            ->latest()
            ->limit(3)
            ->get();

        $logo=asset($post->preview->value ?? 'default.png');
        JsonLdMulti::setTitle($post->title ?? env('APP_NAME'));
        JsonLdMulti::setDescription($post->excerpt->value  ?? null);
        JsonLdMulti::addImage($logo);

        SEOMeta::setTitle($post->title ?? env('APP_NAME'));
        SEOMeta::setDescription($post->excerpt->value  ?? null);
        

        SEOTools::setTitle($post->title ?? env('APP_NAME'));
        SEOTools::setDescription($post->excerpt->value  ?? null);
        
        
        SEOTools::opengraph()->addProperty('image', $logo);
        SEOTools::twitter()->setTitle($post->title ?? env('APP_NAME'));
        
        SEOTools::jsonLd()->addImage($logo);
        return view('frontend.blog.post', compact('post', 'recentPosts'));
    }
}
