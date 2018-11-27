<?php

namespace App\Helpers;


class ViewProducts extends HelperProducts
{

    public static function all()
    {

        $product_ids = [];

        if(\Auth::check()){

            $product_ids = \Auth::user()->view_products()->get()->pluck('id');

        }else{

            $product_views = app('product_views');
            foreach ($product_views->getContent() as $item){
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

            if (!\Auth::user()->not_send_view_products->contains($product_id)) {

                \Auth::user()->view_products()->detach($product_id);
                \Auth::user()->view_products()->attach($product_id);

            }

        }else{

            app('product_views')->add([
                'id' => $product_id,
                'name' => $product_id,
                'price' => 0,
                'quantity' => 1,
            ]);

        }

    }



}