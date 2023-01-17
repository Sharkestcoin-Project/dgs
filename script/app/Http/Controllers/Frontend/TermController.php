<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TermController extends Controller
{
    public function index()
    {
        $term = get_option('term_of_service');

        return view('frontend.terms', compact('term'));
    }
}
