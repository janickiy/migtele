<?php
namespace App\Providers;
use Darryldecode\Cart\Cart;
use Illuminate\Support\ServiceProvider;

class ProductViewsProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('product_views', function($app)
        {
            $storage = $app['session'];
            $events = $app['events'];
            $instanceName = 'product_views';
            $session_key = '88uuiioo998881556';
            return new Cart(
                $storage,
                $events,
                $instanceName,
                $session_key,
                config('shopping_cart')
            );
        });
    }
}