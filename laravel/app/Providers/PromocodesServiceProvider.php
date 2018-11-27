<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PromocodesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        \Validator::extend('promocode', function ($attribute, $value, $parameters, $validator) {

            return \Promocodes::validation($value);

        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        \App::bind('promocodes', function()
        {
            return new \App\Helpers\Promocodes\Promocodes;
        });
    }
}
