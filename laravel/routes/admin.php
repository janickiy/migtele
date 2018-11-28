<?php

Route::get('/login', 'AuthController@showLoginForm')->name('admin.login');
Route::post('/login', 'AuthController@login')->name('admin.login.submit');
Route::get('logout/', 'AuthController@logout')->name('admin.logout');
Route::get('/', 'IndexController@index')->name('admin.index');



Route::get('create', 'PagesController@create')->name('admin.pages.create');
Route::post('store', 'PagesController@store')->name('admin.pages.store');
Route::get('edit/{id}', 'PagesController@edit')->name('admin.pages.edit')->where('id', '[0-9]+');
Route::put('update', 'PagesController@update')->name('admin.pages.update');
Route::delete('destroy/{id}', 'PagesController@destroy')->name('admin.pages.destroy')->where('id', '[0-9]+');



// жд заявки
Route::prefix('orders-railway')->group(function () {
    Route::get('/', 'OrdersRailwayController@list')->name('admin.ordersrailway.list');

    Route::prefix('trains')->group(function () {
        Route::get('', 'TrainsController@list')->name('admin.trains.list');
        Route::get('create', 'TrainsController@create')->name('admin.trains.create');
        Route::post('store', 'TrainsController@store')->name('admin.trains.store');
        Route::get('edit/{id}', 'TrainsController@edit')->name('admin.trains.edit')->where('id', '[0-9]+');
        Route::put('update', 'TrainsController@update')->name('admin.trains.update');
        Route::delete('destroy/{id}', 'TrainsController@destroy')->name('admin.trains.destroy')->where('id', '[0-9]+');
    });

});

// пользователи админки
Route::prefix('users')->group(function () {
    Route::get('/', 'UsersController@list')->name('admin.users.list');
    Route::get('create', 'UsersController@create')->name('admin.users.create');
    Route::post('store', 'UsersController@store')->name('admin.users.store');
    Route::get('edit/{id}', 'UsersController@edit')->name('admin.users.edit')->where('id', '[0-9]+');
    Route::put('update', 'UsersController@update')->name('admin.users.update');
    Route::delete('destroy/{id}', 'UsersController@destroy')->name('admin.users.destroy')->where('id', '[0-9]+');
    Route::get('change-user-password/{id}', 'UsersController@changeUserPassword')->name('admin.users.changeuserpassword');
});

// роли
Route::prefix('role')->group(function () {
    Route::get('/', 'RoleController@list')->name('admin.role.list');
    Route::get('create', 'RoleController@create')->name('admin.role.create');
    Route::post('store', 'RoleController@store')->name('admin.role.store');
    Route::get('edit/{id}', 'RoleController@edit')->name('admin.role.edit')->where('id', '[0-9]+');
    Route::put('update', 'RoleController@update')->name('admin.role.update');
    Route::delete('destroy/{id}', 'RoleController@destroy')->name('admin.role.destroy')->where('id', '[0-9]+');
});


Route::prefix('news')->group(function () {
    Route::get('/', 'NewsController@list')->name('admin.news.list');
});

Route::prefix('sliders')->group(function () {
    Route::get('/', 'SliderController@list')->name('admin.sliders.list');
});

Route::prefix('gr')->group(function () {
    Route::get('/', 'GrController@list')->name('admin.gr.list');

});

Route::prefix('otr')->group(function () {
    Route::get('/', 'OtrController@list')->name('admin.otr.list');
});

Route::prefix('category_vendor_texts')->group(function () {
    Route::get('/', 'CategoryVendorTextsController@list')->name('admin.category_vendor_texts.list');
});

Route::prefix('cattype')->group(function () {
    Route::get('/', 'CattypeController@list')->name('admin.cattype.list');
});

Route::prefix('catmaker')->group(function () {
    Route::get('/', 'CattypeController@list')->name('admin.catmaker.list');
});

Route::prefix('tags')->group(function () {
    Route::get('/', 'TagsController@list')->name('admin.tags.list');
});

Route::prefix('goods')->group(function () {
    Route::get('/', 'GoodsController@list')->name('admin.goods.list');
});

Route::prefix('valuta')->group(function () {
    Route::get('/', 'ValutaController@list')->name('admin.valuta.list');
});

Route::prefix('clients')->group(function () {
    Route::get('/', 'ClientsController@list')->name('admin.clients.list');
});

Route::prefix('orders')->group(function () {
    Route::get('/', 'OrdersController@list')->name('admin.orders.list');
});

Route::prefix('call_orders')->group(function () {
    Route::get('/', 'CallOrdersController@list')->name('admin.call_orders.list');
});

Route::prefix('counters')->group(function () {
    Route::get('/', 'CountersController@list')->name('admin.counters.list');
});

Route::prefix('settings')->group(function () {
    Route::get('/', 'SettingsController@list')->name('admin.settings.list');
});

Route::prefix('payment_methods')->group(function () {
    Route::get('/', 'PaymentMethodsController@list')->name('admin.payment_methods.list');
});

Route::prefix('delivery_methods')->group(function () {
    Route::get('/', 'DeliveryMethodsController@list')->name('admin.delivery_methods.list');
});

Route::prefix('mail_templates')->group(function () {
    Route::get('/', 'MailTemplatesController@list')->name('admin.mail_templates.list');
});

Route::prefix('visit')->group(function () {
    Route::get('/', 'VisitController@list')->name('admin.visit.list');
});



Route::group(['prefix' => 'datatable'], function () {
    Route::any('admin-users', 'DataTableController@getAdminUsers')->name('admin.datatable.adminusers');
    Route::any('role', 'DataTableController@getRole')->name('admin.datatable.role');
    Route::any('settings', 'DataTableController@getSettings')->name('admin.datatable.settings');

    Route::any('pages', 'DataTableController@getPages')->name('admin.datatable.pages');



});