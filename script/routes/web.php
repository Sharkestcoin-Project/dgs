<?php

use App\Mail\SubscriptionAlertMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/',function(){
    return redirect('/install');
});
