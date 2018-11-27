<?php

namespace App\Providers;


use App\Model\Order;
use App\Model\PayOrder;
use App\Model\Statistic\VisitDay;
use App\Model\Subscriber;
use App\Model\User;
use App\Observers\OrderObserver;
use App\Observers\PayOrdersObserver;
use App\Observers\SubscriberObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Subscriber::observe(SubscriberObserver::class);
        Order::observe(OrderObserver::class);
        PayOrder::observe(PayOrdersObserver::class);


        Validator::extend('old_password', function ($attribute, $value, $parameters, $validator) {
            return \Auth::user() ? \Hash::check( $value, \Auth::user()->password ) : false;
        });


       VisitDay::setVisit();

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        require_once __DIR__ . '/../helper.php';
        require_once __DIR__ . '/../htmlTruncate.php';
    }
}
