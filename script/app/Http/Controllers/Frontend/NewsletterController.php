<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Newsletter;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email']
        ]);

        Newsletter::subscribe($request->input('email'), [], 'subscribers');

        return response()->json( __('Thanks for joining our newsletter'));
    }
}
