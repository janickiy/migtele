<?php

namespace App\Http\Controllers;

use App\Model\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index()
    {

        $products = Product::whereIn('goods.id', \CartProducts::all())->published()->get();

        $this->setSeoMeta('Ваша корзина');

        $promocode = \Promocodes::getSessionPromocode();

        return view('cart', compact('products', 'promocode'));
    }

    public function add()
    {

        \CartProducts::add(request('product_id'), request('quantity', 1));

        $product_ids = \CartProducts::all();


        $ids_ordered = $product_ids->implode(',');

        $products = $ids_ordered ? Product::whereIn('goods.id', $product_ids)->orderByRaw(\DB::raw("FIELD(".env('DB_PREFIX')."goods.id, $ids_ordered) DESC"))->published()->get() : [];



        return view('ajax.cart', compact('products'));
    }

    public function changeQuantity()
    {

        \CartProducts::add(request('product_id'), request('quantity', 1));

        if(request('is_modal')){
            return redirect(url()->previous() . "#cart-modal");
        }else{
            return back();
        }

    }

    public function delete()
    {
        \CartProducts::delete(request('id'));

        if(request('is_modal')){
            return redirect(url()->previous() . "#cart-modal");
        }else{
            return back();
        }
    }

    public function clear()
    {
        \CartProducts::clear();

        return back();
    }

    public function getCartInfo()
    {
        return [
            'count' => \CartProducts::getTotalQuantity(),
            'total' => \CartProducts::getTotal(),

        ];

    }


}
