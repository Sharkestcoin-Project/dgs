<?php

namespace App\Observers;

use App\Models\Option;
use Cache;

class OptionObserver
{
    public function created(Option $option)
    {
        cache_remember($option->key, function () use ($option){
            return $option;
        });
    }

    public function updated(Option $option)
    {
        Cache::forget($option->key);
        cache_remember($option->key, function () use ($option){
            return $option;
        });
    }

    public function deleted(Option $option)
    {
        Cache::forget($option->key);
    }

    public function restored(Option $option)
    {
        Cache::forget($option->key);
        cache_remember($option->key, function () use ($option){
            return $option;
        });
    }
}
