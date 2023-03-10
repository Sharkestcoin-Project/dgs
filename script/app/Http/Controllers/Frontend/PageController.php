<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Term;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function index(Term $page)
    {
        abort_if(!$page->status, 404);
        $page->load('pageMeta');
        return view('frontend.page', compact('page'));
    }
}
