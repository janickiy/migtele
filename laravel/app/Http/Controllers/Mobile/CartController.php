<?php

namespace App\Http\Controllers\Mobile;

use App\Helpers\CartProducts;
use App\Model\Product;
use \Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{


    public function index()
    {

        $products = Product::whereIn('goods.id', CartProducts::all())->published()->get();

        $promocode = \Promocodes::getSessionPromocode();

        return view('mobile.cart', compact('products', 'promocode'));
    }


    public function changeQuantity()
    {
        CartProducts::add(request('product_id'), request('quantity', 1));

        return back();

    }


    public function add()
    {

        CartProducts::add(request('product_id'), request('quantity', 1));

        return back()->with('success_message', 'Товар добавлен в корзину');

    }

    public function delete()
    {
        CartProducts::delete(request('id'));

        return back()->with('success_message', 'Товар удален из корзины');
    }


}
