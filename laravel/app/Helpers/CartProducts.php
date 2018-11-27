<?php

namespace App\Helpers;


use App\Model\Product;

class CartProducts extends HelperProducts
{

    public static function all()
    {

        $product_ids = [];

        if(\Auth::check()){

            $product_ids = \Auth::user()->cart_products()->get()->pluck('id', 'id');

        }else{

            $product_cart= app('cart');

            foreach ($product_cart->getContent() as $item){
                $product_ids[$item->id] = $item->id;
            }

            $product_ids = collect($product_ids);

        }

        return $product_ids;
    }


    public static function getTotal()
    {
        $total = 0;

        $products = \Auth::check() ? \Auth::user()->cart_products()->get() : Product::whereIn('goods.id', self::all())->published()->get();

        foreach ($products as $product) {

            $total += $product->cart_price * $product->quantity;
        }


        return $total;

    }


    public static function getTotalQuantity()
    {
        $quantity = 0;

        if(\Auth::check()){

            foreach (\Auth::user()->cart_products()->get() as $product) {
                $quantity += $product->pivot->quantity;
            }
        }else{
            $quantity = app('cart')->getTotalQuantity();
        }

        return $quantity;
    }


    /**
     * @param $product_id
     * @param int $quantity
     * @return bool
     */
    public static function add($product_id, $quantity = 1)
    {

        if(!$product_id) return false;

        if(\Auth::check()){

            if (!\Auth::user()->cart_products->contains($product_id)) {

                $quantity = !$quantity ? 1 : $quantity;

                \Auth::user()->cart_products()->attach([$product_id => ['quantity' => $quantity]]);

            }else{

                $quantity = !$quantity ? self::getQuantity($product_id) + 1 : $quantity;

                \Auth::user()->cart_products()->updateExistingPivot($product_id, ['quantity' => $quantity, 'send' => 0]);

            }

        }else{

            if(app('cart')->get($product_id)){
                app('cart')->update($product_id, [
                    'quantity' => array(
                        'relative' => false,
                        'value' => $quantity
                    )
                ]);
            }else{

                $quantity = !$quantity ? 1 : $quantity;

                app('cart')->add([
                    'id' => $product_id,
                    'name' => $product_id,
                    'price' => 0,
                    'quantity' => $quantity,
                ]);
            }


        }

    }


    public static function exist($product_id)
    {
        if(\Auth::check()) {
            return \Auth::user()->cart_products->contains($product_id);
        }else{
            return app('cart')->get($product_id) ? true : false;
        }
    }



    public static function getQuantity($product_id)
    {
        if(\Auth::check()) {
            return \Auth::user()->cart_products()->where('product_id', $product_id)->first()->pivot->quantity;
        }else{
            return \Cart::get($product_id)->quantity;
        }
    }

    /**
     * @param $product_id
     */
    public static function delete($product_id)
    {

        if(\Auth::check()){

            \Auth::user()->cart_products()->detach($product_id);

        }else{

            app('cart')->remove($product_id);
        }

    }


    public static function clear()
    {
        if(\Auth::check()){

            \Auth::user()->cart_products()->sync([]);

        }else{
            app('cart')->clear();
        }


    }



}