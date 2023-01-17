<?php
use Illuminate\Support\Facades\Route;

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['auth', 'admin', 'verified']], function () {

    Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
    Route::get('settings', 'AdminController@settings')->name('settings');
    Route::post('update-general', 'AdminController@updateGeneral')->name('update-general');
    Route::post('update-password', 'AdminController@updatePassword')->name('update-password');
    Route::get('clear-cache', 'AdminController@clearCache')->name('clear-cache');


    Route::post('blog/delete-all',  'BlogController@deleteAll')->name('blog.delete-all');
    Route::resource('products', 'ProductController')->only('index', 'show', 'destroy');
    Route::post('subscriptions/destroy/mass',  'SubscriptionController@destroyMass')->name('subscriptions.destroy.mass');
    Route::resource('subscriptions', 'SubscriptionController');
    Route::resource('blog', 'BlogController');
    Route::resource('reviews', 'ReviewController');

    // Payouts
    Route::resource('payout-methods', 'PayoutMethodController');
    Route::post('payout-methods/delete-all', 'PayoutMethodController@deleteAll')->name('payout-methods.delete');
    Route::post('payouts/delete-all', 'PayoutController@deleteAll')->name('payouts.delete');
    Route::get('payouts/approved', 'PayoutController@approved')->name('payouts.approved');
    Route::get('payouts/reject', 'PayoutController@reject')->name('payouts.reject');
    Route::resource('payouts', 'PayoutController');

    Route::get('pages/choose/{lang}', 'PageController@choose')->name('page.choose');
    Route::post('page/delete-all',  'PageController@deleteAll')->name('page.delete-all');
    Route::resource('page', 'PageController');
    Route::post('plans/destroy/mass',  'PlanController@destroyMass')->name('plans.destroy.mass');
    Route::resource('plans', 'PlanController');
    Route::resource('payment-gateways', 'PaymentGatewayController')->except('show');
    Route::post('/orders/mass-destroy','OrderController@massDestroy')->name('orders.mass-destroy');
    Route::get('orders/invoice/{order}/print', 'OrderController@print')->name('orders.print.invoice');
    Route::get('orders/pdf', 'OrderController@orderPdf')->name('orders.pdf');
    Route::post('orders/payment-status/{id}', 'OrderController@paymentStatusUpdate')->name('orders.payment-status');
    Route::resource('orders', 'OrderController');

    Route::post('/product-orders/mass-destroy','ProductOrderLogController@massDestroy')->name('product-orders.mass-destroy');
    Route::get('product-orders/invoice/{order}/print', 'ProductOrderLogController@print')->name('product-orders.print.invoice');
    Route::get('product-orders/pdf', 'ProductOrderLogController@orderPdf')->name('product-orders.pdf');
    Route::post('product-orders/payment-status/{id}', 'ProductOrderLogController@paymentStatusUpdate')->name('product-orders.payment-status');
    Route::resource('product-orders', 'ProductOrderLogController');

    Route::post('users/send-email/{user}', 'UserController@sendEmail')->name('users.send-email');
    Route::post('users/kyc-verified/{user}', 'UserController@kycVerified')->name('users.kyc-verified');
    Route::post('users/login/{user}', 'UserController@login')->name('users.login');
    Route::resource('users', 'UserController');
    Route::delete('subscribers/{email}/unsubscribe', 'SubscriberController@unsubscribe')->name('subscribers.unsubscribe');
    Route::resource('subscribers', 'SubscriberController')->only('index', 'destroy');

    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
        Route::group(['prefix' => 'website', 'as' => 'website.', 'namespace' => 'Website'], function () {
            Route::group(['prefix' => 'heading', 'as' => 'heading.'], function () {
                Route::controller('HeadingController')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::put('update-welcome', 'updateWelcome')->name('update-welcome');
                    Route::put('update-feature', 'updateFeature')->name('update-feature');
                    Route::put('update-about', 'updateAbout')->name('update-about');
                    Route::put('update-our-service', 'updateOurService')->name('update-our-service');
                    Route::put('update-pricing', 'updatePricing')->name('update-pricing');
                    Route::put('update-review', 'updateReview')->name('update-review');
                    Route::put('update-faq', 'updateFaq')->name('update-faq');
                    Route::put('update-latest-news', 'updateLatestNews')->name('update-latest-news');
                    Route::put('update-call-to-action', 'updateCallToAction')->name('update-call-to-action');
                    Route::put('update-trusted-by', 'updateTrustedBy')->name('update-trusted-by');
                    Route::put('update-trusted-partner', 'updateTrustedPartner')->name('update-trusted-partner');
                    Route::put('update-about-us', 'updateAboutUs')->name('update-about-us');
                    Route::put('update-contact', 'updateContact')->name('update-contact');
                    Route::put('update-product', 'updateProduct')->name('update-product');
                });
            });
            Route::get('logo', 'LogoController@index')->name('logo.index');
            Route::put('logo', 'LogoController@update')->name('logo.update');
            Route::get('footer', 'FooterController@index')->name('footer.index');
            Route::post('footer/store', 'FooterController@store')->name('footer.store');
            Route::resource('trusted-partner', 'TrustedPartnerController')->except('show');
            Route::resource('faq', 'FAQController')->except('show');
            Route::resource('our-services', 'OurServiceController')->except('show');
            Route::get('term', 'TermController@index')->name('term.index');
            Route::put('term', 'TermController@update')->name('term.update');
            Route::get('demo', 'DemoProductController@index')->name('demo.index');
            Route::put('demo', 'DemoProductController@update')->name('demo.update');
            Route::get('demo/download', 'DemoProductController@download')->name('demo.download');
        });
    });

    Route::resource('roles', 'RoleController')->except('show');
    Route::post('assign-role/search', 'AssignRoleController@search')->name('assign-role.search');
    Route::resource('assign-role', 'AssignRoleController')->only('index', 'store');
    Route::put('currencies/default/{currency}', 'CurrencyController@makeDefault')->name('currencies.make.default');
    Route::resource('currencies', 'CurrencyController');
    Route::resource('taxes', 'TaxController');
    Route::resource('seo', 'SeoController');
    Route::resource('env', 'EnvController');
    Route::resource('media', 'MediaController');
    Route::get('medias/list', 'MediaController@list')->name('media.list');
    Route::post('medias/delete', 'MediaController@destroy')->name('medias.delete');
    Route::get('/dashboard/static', 'DashboardController@staticData');
    Route::get('/dashboard/performance/{period}', 'DashboardController@performance');
    Route::get('/dashboard/deposit/performance/{period}', 'DashboardController@depositPerformance');
    Route::get('/dashboard/order_statics/{month}', 'DashboardController@order_statics');
    Route::get('/dashboard/visitors/{days}', 'DashboardController@google_analytics');
    Route::get('languages/delete/{id}', 'LanguageController@destroy')->name('languages.delete');
    Route::post('languages/setActiveLanguage', 'LanguageController@setActiveLanguage')->name('languages.active');
    Route::post('languages/add_key', 'LanguageController@add_key')->name('language.add_key');
    Route::resource('language', 'LanguageController');
    Route::resource('menu', 'MenuController');
    Route::post('/menus/destroy', 'MenuController@destroy')->name('menus.destroy');
    Route::post('menues/node', 'MenuController@MenuNodeStore')->name('menus.MenuNodeStore');
    Route::get('/site-settings', 'SitesettingsController@index')->name('site-settings');
    Route::post('/site-settings-update/{type}', 'SitesettingsController@update')->name('site-settings.update');
    Route::resource('cron', 'CronController');
});
