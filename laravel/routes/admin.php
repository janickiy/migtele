<?php

Route::get('/login', 'AuthController@showLoginForm')->name('admin.login');
Route::post('/login', 'AuthController@login')->name('admin.login.submit');
Route::get('logout/', 'AuthController@logout')->name('admin.logout');
Route::get('/', 'IndexController@index')->name('admin.index');

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


Route::prefix('pages')->group(function () {

});

Route::prefix('news')->group(function () {

});

Route::prefix('sliders')->group(function () {

});

Route::prefix('gr')->group(function () {

});

Route::prefix('otr')->group(function () {

});

Route::prefix('category_vendor_texts')->group(function () {

});

Route::prefix('cattype')->group(function () {

});

Route::prefix('catmaker')->group(function () {

});

Route::prefix('tags')->group(function () {

});

Route::prefix('goods')->group(function () {

});

Route::prefix('valuta')->group(function () {

});

Route::prefix('clients')->group(function () {

});

Route::prefix('orders')->group(function () {

});

Route::prefix('call_orders')->group(function () {

});

Route::prefix('counters')->group(function () {

});

Route::prefix('settings')->group(function () {
    Route::get('/', 'SettingsController@list')->name('admin.settings.list');
});

Route::prefix('payment_methods')->group(function () {

});

Route::prefix('delivery_methods')->group(function () {

});

Route::prefix('mail_templates')->group(function () {

});

Route::prefix('visit')->group(function () {

});



Route::group(['prefix' => 'datatable'], function () {
    Route::any('sessionlog', 'DataTableController@getSessionLog')->name('admin.datatable.sessionlog');
    Route::any('admin-users', 'DataTableController@getAdminUsers')->name('admin.datatable.adminusers');
    Route::any('role', 'DataTableController@getRole')->name('admin.datatable.role');
    Route::any('settings', 'DataTableController@getSettings')->name('admin.datatable.settings');
    Route::any('portalusers', 'DataTableController@getPortalUsers')->name('admin.datatable.portalusers');
    Route::any('orders-railway', 'DataTableController@getOrdersRailways')->name('admin.datatable.ordersrailway');
    Route::any('trains-car', 'DataTableController@getTrainsCar')->name('admin.datatable.trainscar');
    Route::any('trains', 'DataTableController@getTrains')->name('admin.datatable.trains');
});