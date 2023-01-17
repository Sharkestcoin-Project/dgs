<?php

Route::group(['as' => 'user.', 'prefix' => 'user', 'namespace' => 'App\Http\Controllers\User', 'middleware' => ['auth','user', 'verified']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('dashboard/statistics', 'DashboardController@statistics')->name('dashboard.statistics');
    // Force User to purchase plan middleware used
    Route::group(['middleware' => 'plan.expired'], function(){
        Route::post('promotions/destroy/mass', 'PromotionController@destroyMass')->name('promotions.destroy.mass');
        Route::post('products/upload', 'ProductController@upload')->name('products.upload');
        Route::delete('products/destroy/temporary/{file:folder}', 'ProductController@destroyTemporary')->name('products.destroy.temporary');
        Route::delete('products/destroy/file/{product}', 'ProductController@destroyFile')->name('products.destroy.file');
        Route::get('products/download/file/{product}', 'ProductController@download')->name('products.download');

        Route::resource('products', 'ProductController');
        Route::get('product/iframe/{id}', 'ProductController@iframe')->name('product.iframe');
        Route::resource('promotions', 'PromotionController')->except('show');
        Route::get('orders/products', 'ProductOrderController@index')->name('orders.products.index');
        Route::put('orders/products/resend/{id}', 'ProductOrderController@resend')->name('orders.products.resend');
        Route::get('orders/subscriptions', 'SubscriptionOrderController@index')->name('orders.subscriptions.index');
        Route::get('orders/subscriptions/{order}', 'SubscriptionOrderController@show')->name('orders.subscriptions.show');
        Route::put('orders/subscriptions/{order}/resend', 'SubscriptionOrderController@resend')->name('orders.subscriptions.resend');
        Route::post('subscriptions/destroy/mass',  'SubscriptionController@destroyMass')->name('subscriptions.destroy.mass');
        Route::get('subscriptions/subscribers',  'SubscriberController@index')->name('subscribers.index');
        Route::get('subscriptions/subscribers/{subscriber}',  'SubscriberController@show')->name('subscribers.show');
        Route::post('subscriptions/subscribers/{order}/renewal',  'SubscriberController@renewal')->name('subscribers.renewal');
        Route::get('subscriptions/iframe/{id}', 'SubscriptionController@iframe')->name('subscription.iframe');
        Route::resource('subscriptions', 'SubscriptionController');
    });

    Route::get('/payout', 'PayoutController@payout')->name('payout');
    Route::group(['prefix' => 'payout', 'as' => 'payout.'], function () {
        Route::get('/', 'PayoutController@index')->name('index');
        Route::post('checkotp/', 'PayoutController@checkotp')->name('checkotp');
        Route::get('payout/otp/{method_id}', 'PayoutController@otp')->name('otp');
        Route::post('update/{method_id}', 'PayoutController@update')->name('update');
        Route::post('getotp/{method_id}', 'PayoutController@getotp')->name('get-otp');
        Route::post('success/{method_id}', 'PayoutController@success')->name('success');
        Route::get('/payout/setup/{method_id}', 'PayoutController@setup')->name('setup');
        Route::get('/payoutmethod/{method_id}/edit', 'PayoutController@edit')->name('edit');
        Route::get('make-payout/{method_id}', 'PayoutController@makepayout')->name('make-payout');
    });

    Route::group(['prefix' => 'settings', 'as' => 'settings.', 'namespace' => 'Settings'], function () {
        Route::resource('/', 'SettingsController')->only('index', 'store');
        Route::post('subscription/make-payment/{gateway}', 'SubscriptionController@makePayment')->name('subscriptions.make-payment');
        Route::get('subscription/payment/success', 'SubscriptionController@success')->name('subscriptions.payment.success');
        Route::get('subscription/payment/failed', 'SubscriptionController@failed')->name('subscriptions.payment.failed');
        Route::get('subscriptions/plan-renew', 'SubscriptionController@redirectFromEmail')->name('subscriptions.plan-renew');
        Route::get('logs-subscriptions', 'SubscriptionController@log')->name('subscriptions.log');
        Route::resource('subscriptions', 'SubscriptionController')->only('index', 'store', 'create');
    });

    Route::get('profile', 'ProfileController@index')->name('profile.index');
    Route::get('profile/edit', 'ProfileController@edit')->name('profile.edit');
    Route::put('profile/update', 'ProfileController@update')->name('profile.update');

    Route::get('/payment/paypal', '\App\Lib\Paypal@status');
    Route::post('/stripe/payment', '\App\Lib\Stripe@status')->name('stripe.payment');
    Route::get('/stripe', '\App\Lib\Stripe@view')->name('stripe.view');
    Route::get('/payment/mollie', '\App\Lib\Mollie@status');
    Route::post('/payment/paystack', '\App\Lib\Paystack@status')->name('paystack.status');
    Route::get('/paystack', '\App\Lib\Paystack@view')->name('paystack.view');
    Route::get('/mercadopago/pay', '\App\Lib\Mercado@status')->name('mercadopago.status');
    Route::get('/razorpay/payment', '\App\Lib\Razorpay@view')->name('razorpay.view');
    Route::post('/razorpay/status', '\App\Lib\Razorpay@status');
    Route::get('/payment/flutterwave', '\App\Lib\Flutterwave@status');
    Route::get('/payment/thawani', '\App\Lib\Thawani@status');
    Route::get('/payment/instamojo', '\App\Lib\Instamojo@status');
    Route::get('/payment/toyyibpay', '\App\Lib\Toyyibpay@status');
    Route::get('/manual/payment', '\App\Lib\CustomGateway@status')->name('manual.payment');
    Route::get('payu/payment', '\App\Lib\Payu@view')->name('payu.view');
    Route::post('/payu/status', '\App\Lib\Payu@status')->name('payu.status');
});
