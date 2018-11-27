<?php

namespace App\Helpers;


class WishlistProducts extends HelperProducts
{


    public static function all()
    {

        $product_ids = [];

        if(\Auth::check()){

            $product_ids = \Auth::user()->wishlist_products()->get()->pluck('id');

        }else{


            foreach (app('wishlist')->getContent() as $item){
                $product_ids[] = $item->id;
            }

        }

        return $product_ids;
    }


    /**
     * @param $product_id
     */
    public static function add($product_id)
    {

        if(\Auth::check()){

            if (!\Auth::user()->not_send_wishlist_products->contains($product_id)) {

                \Auth::user()->wishlist_products()->detach($product_id);
                \Auth::user()->wishlist_products()->attach($product_id);

            }

        }else{

            app('wishlist')->add(array(
                'id' => $product_id,
                'name' => $product_id,
                'price' => 0,
                'quantity' => 1,
            ));
        }

    }


    public static function exist($product_id)
    {
        if(\Auth::check()) {
                return \Auth::user()->wishlist_products->contains($product_id);
        }else{
            return app('wishlist')->get($product_id) ? true : false;
        }
    }


    /**
     * @param $product_id
     */
    public static function delete($product_id)
    {

        if(\Auth::check()){

            \Auth::user()->wishlist_products()->detach($product_id);

        }else{

            app('wishlist')->remove($product_id);
        }

    }


    public static function clear()
    {
        if(\Auth::check()){

            \Auth::user()->wishlist_products()->sync([]);

        }else{
            app('wishlist')->clear();
        }


    }

}