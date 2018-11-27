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

    Route::prefix('trains-car')->group(function () {
        Route::get('', 'TrainsCarController@list')->name('admin.trainscar.list');
        Route::get('create', 'TrainsCarController@create')->name('admin.trainscar.create');
        Route::post('store', 'TrainsCarController@store')->name('admin.trainscar.store');
        Route::get('edit/{id}', 'TrainsCarController@edit')->name('admin.trainscar.edit')->where('id', '[0-9]+');
        Route::put('update', 'TrainsCarController@update')->name('admin.trainscar.update');
        Route::delete('destroy/{id}', 'TrainsCarController@destroy')->name('admin.trainscar.destroy')->where('id', '[0-9]+');
        Route::delete('del-image/{id}', 'TrainsCarController@delImage')->name('admin.trainscar.delimage')->where('id', '[0-9]+');
    });

    Route::group(['prefix' => 'menu'], function () {
        Route::get('','MenuController@list')->name('admin.menu.list');
        Route::get('create/{parent_id?}','MenuController@create')->name('admin.menu.create');
        Route::post('store','MenuController@store')->name('admin.menu.store');
        Route::get('edit/{id}','MenuController@edit')->name('admin.menu.edit')->where('id', '[0-9]+');
        Route::put('update','MenuController@update')->name('admin.menu.update');
        Route::get('delete/{id}','MenuController@destroy')->name('admin.menu.delete')->where('id', '[0-9]+');
    });

    Route::get('info/{id}', 'OrdersRailwayController@info')->name('admin.ordersrailway.info')->where('id', '[0-9]+');
    Route::put('update', 'OrdersRailwayController@update')->name('admin.ordersrailway.update');
    Route::get('edit-passenger/{id}', 'OrdersRailwayController@editPassenger')->name('admin.ordersrailway.editpassenger')->where('id', '[0-9]+');
    Route::put('update-passenger', 'OrdersRailwayController@updatePassenger')->name('admin.orders-railway.update_passenger');

   //

});

// пользователи портала
Route::prefix('portal-users')->group(function () {
    Route::get('/', 'PortalUsersController@list')->name('admin.portalusers.list');
    Route::get('edit/{id}', 'PortalUsersController@edit')->name('admin.portalusers.edit')->where('id', '[0-9]+');
    Route::put('update', 'PortalUsersController@update')->name('admin.portalusers.update');
    Route::delete('destroy/{id}', 'PortalUsersController@destroy')->name('admin.portalusers.destroy')->where('id', '[0-9]+');
});

// логи
Route::prefix('logs')->group(function () {
    Route::get('/', 'SessionLogController@list')->name('admin.logs.list');
    Route::get('info/{id}', 'SessionLogController@info')->name('admin.logs.info')->where('id', '[0-9]+');
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

// настройки
Route::prefix('settings')->group(function () {
    Route::get('/', 'AppSettingsController@listSettings')->name('admin.settings.list');
    Route::get('create', 'AppSettingsController@create')->name('admin.settings.create');
    Route::post('store', 'AppSettingsController@store')->name('admin.settings.store');
    Route::get('edit/{id}', 'AppSettingsController@edit')->name('admin.settings.edit')->where('id', '[0-9]+');
    Route::put('update', 'AppSettingsController@update')->name('admin.settings.update');
    Route::delete('destroy/{id}', 'AppSettingsController@destroy')->name('admin.settings.destroy')->where('id', '[0-9]+');
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