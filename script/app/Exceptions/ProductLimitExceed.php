<?php

namespace App\Exceptions;

use Exception;

class ProductLimitExceed extends Exception
{
    public function render($request)
    {
        if ($request->expectsJson()){
            return response()->json(__('Your product limit is exceed! Please upgrade the plan.'), 403);
        }else{
            return to_route('user.products.index')->with('warning', __('Your product limit is exceed! Please upgrade the plan.'));
        }
    }
}
