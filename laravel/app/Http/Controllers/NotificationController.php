<?php

namespace App\Http\Controllers;

use App\Mail\CartProductsMail;
use App\Mail\ViewProductsMail;
use App\Mail\WishlistProductsMail;
use App\Model\Product;
use App\Model\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    /**
     * @param User $user
     * @return bool
     */
    public static function sendViewProducts($user)
    {
        $view_products = $user->not_send_view_products()->limit(8)->get();

        if(!count($view_products)) return false;

        $recommended_products = Product::published()->whereIn('id_cattmr', $view_products[0]->category->product_category_ids)->inRandomOrder()->limit(4)->get();

        \Mail::send(new ViewProductsMail($user, $view_products, $recommended_products));

        foreach ($user->not_send_view_products as $product){
            $user->not_send_view_products()->updateExistingPivot($product->id, ['send' => 1]);
        }


        return true;
    }


    /**
     * @param User $user
     * @return bool
     */
    public static function sendWishlistProducts($user)
    {
        $wish_products = $user->not_send_wishlist_products;

        if(!count($wish_products)) return false;

        $recommended_products = Product::published()->whereIn('id_cattmr', $wish_products[0]->category->product_category_ids)->inRandomOrder()->limit(4)->get();

        \Mail::send(new WishlistProductsMail($user, $wish_products, $recommended_products));

        foreach ($user->not_send_wishlist_products as $product){
            $user->not_send_wishlist_products()->updateExistingPivot($product->id, ['send' => 1]);
        }

        return true;

    }


    /**
     * @param User $user
     * @return bool
     */
    public static function sendCartProducts($user)
    {

        $products = $user->not_send_cart_products;

        if(!count($products)) return false;

        \Mail::send(new CartProductsMail($user, $products));

        foreach ($user->not_send_cart_products as $product){
            $user->not_send_cart_products()->updateExistingPivot($product->id, ['send' => 1]);
        }

        return true;

    }





}
