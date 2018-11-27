<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');

Route::get('/set-sort/{sort_name}', 'SystemController@setSort');

Route::get('/profile/order-cancel/{id}', 'ProfileController@cancelOrder');

Route::get('/feed/google-merchant', 'GoogleFeedController');




Route::get('/send', 'NotificationController@sendCartProducts');
Route::post('/ordering', 'OrderController@ordering')->middleware(['requestOrderModify']);
Route::post('/dealer', 'Forms\DealerController@send');

Route::post('/payment-in-process', 'PaymentController@process');
Route::get('/pay/success/{hash}', 'PaymentController@success');

Route::get('/sitemap.xml', 'SystemController@sitemap_xml');

Route::domain('www.{slug}.migtele.local')->group(function () {

    Route::get('/', 'CategoryController@vendor');

});

Route::middleware(['auth'])->group(function () {
    Route::post('/profile/edit/save', 'ProfileController@save');
    Route::post('/profile/save-settings', 'ProfileController@saveSettings');
    Route::post('/profile/change-password', 'ProfileController@changePassword');
    Route::post('/profile/order-repeat', 'ProfileController@orderRepeat');
    Route::get('/orders/{id}/download/order', 'ProfileController@downloadOrderFile');
    Route::get('/orders/{id}/download/shipping', 'ProfileController@downloadShippingFile');
});

Route::get('/promocode/{code}', 'HomeController@promocode')->name('promocode.share');
Route::post('/promocode/apply', 'PromocodeController@apply')->name('promocode.apply');
Route::post('/promocode/remove', 'PromocodeController@remove')->name('promocode.remove');
Route::post('/promocode/send-friend', 'PromocodeController@sendFriend')->name('promocode.send-friend');



Route::domain(env('APP_URL'))->group(function () {

    $agent = new Jenssegers\Agent\Agent;


    if (Cookie::get('isDesktopVersion') || $agent->isRobot() || $agent->isDesktop()) {

        Route::middleware(['register'])->group(function () {

            Auth::routes();

        });


        Route::get('/feedback/{slug}', 'Forms\FeedbackController@view');
        Route::post('/feedback', 'Forms\FeedbackController@send');
        Route::post('/feedback/send', 'Forms\FeedbackController@sendOnType');

        Route::post('/callback', 'Forms\CallbackController@send');

        Route::get('/pay/{id}', 'PaymentController@pay');

        Route::get('/sitemap.php', 'SystemController@sitemap');

        Route::middleware(['auth'])->group(function () {
            Route::get('/profile', 'ProfileController@edit');
            Route::get('/profile/edit/individual', 'ProfileController@individual');
            Route::get('/profile/edit/juridical', 'ProfileController@juridical');

            Route::get('/profile/orders', 'ProfileController@orders');
            Route::get('/profile/{any}', 'ProfileController@edit');
        });

        Route::get('/popular-products', 'ProductController@popularProducts');
        Route::get('/new-products', 'ProductController@newProducts');
        Route::get('/vendor-popular-products', 'ProductController@vendorPopularProducts');
        Route::get('/related-products/{product_id}', 'ProductController@relatedProducts');

        Route::get('/cart', 'CartController@index');
        Route::get('/cart/info', 'CartController@getCartInfo');
        Route::post('/cart/add', 'CartController@add');
        Route::post('/cart/delete', 'CartController@delete')->name('cart-delete');
        Route::post('/cart/clear', 'CartController@clear');
        Route::post('/cart/update', 'CartController@update');
        Route::post('/cart/change-quantity', 'CartController@changeQuantity');

        Route::get('/wishlist', 'WishListController@index');
        Route::post('/wishlist/add', 'WishListController@add');
        Route::post('/wishlist/delete', 'WishListController@delete');
        Route::post('/wishlist/clear', 'WishListController@clear');

        Route::post('/quick-order', 'OrderController@quick');

        Route::get('/product-views', 'ProductViewsController@index');

        Route::get('/brands', 'CategoryController@vendors');
        Route::get('/brands/{slug}', 'CategoryController@vendor');

        Route::get('/sales', 'CategoryController@sales');
        Route::get('/catalog_new', 'CategoryController@catalogNew');

        Route::get('/news/{id}.htm', 'NewsController@index');

        Route::get('/order', 'OrderController@index');

        Route::get('/order/success/{id}', 'OrderController@success');

        Route::post('/set-page-size', 'SystemController@setPageSize');

        Route::get('/tags/{slug}.html', 'TagController@index');

        Route::get('/tovar/{link}.htm', 'ProductController@index')->where('link', '[a-zA-Z0-9\-/_]+');

        Route::get('/search/{search_text}', 'CategoryController@search');

        Route::get('/{slug}.htm', 'PageController@index')->where('slug', '[a-zA-Z0-9\-/_]+');

        Route::get('/{slug}', 'CategoryController@index');

        Route::get('/{category_slug}/{sub_category_slug}', 'CategoryController@sub_category');

        Route::get('/{category_slug}/{vendor_slug}/{sub_category_slug}', 'CategoryController@sub_category_vendor');

        Route::get('/{category_slug}/{vendor_slug}/{sub_category_slug}/{sub_category2_slug}', 'CategoryController@sub_category2_vendor');


    } else {

        Route::get('/', 'Mobile\HomeController@index');
        Route::get('/goToDesktopVersion', 'Mobile\HomeController@goToDesktopVersion');

        Auth::routes();

        Route::middleware(['auth'])->group(function () {
            Route::get('/profile', 'Mobile\ProfileController@edit');

            Route::get('/profile/orders', 'Mobile\ProfileController@orders');
            Route::get('/profile/settings', 'Mobile\ProfileController@settings');
            Route::get('/profile/{any}', 'Mobile\ProfileController@edit');
        });

        Route::get('/pay/{id}', 'Mobile\PaymentController@pay');

        Route::get('/cart', 'Mobile\CartController@index')->name('cart');
        Route::post('/cart/add', 'Mobile\CartController@add')->name('cart-add');
        Route::post('/cart/delete', 'Mobile\CartController@delete')->name('cart-delete');
        Route::post('/cart/change-quantity', 'Mobile\CartController@changeQuantity')->name('cart-change');

        Route::get('/order', 'Mobile\OrderController@index')->name('order');
        Route::get('/order/success/{id}', '\Mobile\OrderController@success');

        Route::get('/product-views', 'Mobile\ProductController@views');

        Route::get('/brands', 'Mobile\CategoryController@vendors');
        Route::get('/brands/{slug}', 'Mobile\CategoryController@vendor');

        Route::get('/tovar/{link}.htm', 'Mobile\ProductController@index')->where('link', '[a-zA-Z0-9\-/_]+');

        Route::get('/search/{search_text}', 'Mobile\CategoryController@search');

        Route::get('/{slug}.htm', 'Mobile\PageController@index')->where('slug', '[a-zA-Z0-9\-/_]+');

        Route::get('/{slug}', 'Mobile\CategoryController@category');
        Route::get('/{category_slug}/{sub_category_slug}', 'Mobile\CategoryController@sub_category');
        Route::get('/{category_slug}/{vendor_slug}/{sub_category_slug}', 'Mobile\CategoryController@sub_category_vendor');
    }

});







