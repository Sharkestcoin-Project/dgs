<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class FileSizeLimitExceed extends Exception
{
    public function render(Request $request)
    {
        if ($request->expectsJson() || $request->ajax()){
            return response()->json(__('Your max file size limit is exceed! Please upgrade the plan.'), 403);
        }else{
            return to_route('user.products.index')->with('warning', __('Your max file size limit is exceed! Please upgrade the plan.'));
        }
    }
}
