<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LoginListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {

        foreach ($this->getProductIdsByAppName('product_views') as $product_id){
            \ViewProducts::add($product_id);
        }

        foreach ($this->getProductIdsByAppName('wishlist') as $product_id){
            \WishlistProducts::add($product_id);
        }


        foreach (\Cart::getContent() as $product){
            \CartProducts::add($product->id, $product->quantity);
        }


    }


    /**
     * helpers
     */

    /**
     * @param $name
     * @return array
     */
    protected function getProductIdsByAppName($name){

        $app = app($name);

        $product_ids = [];

        foreach ($app->getContent() as $item){
            $product_ids[] = $item->id;
        }

        return $product_ids;

    }
}
