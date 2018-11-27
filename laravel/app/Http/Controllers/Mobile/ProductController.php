<?php

namespace App\Http\Controllers\Mobile;

use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index($link)
    {

        $product = Product::whereLink($link)->published()->firstOrFail();



        \ViewProducts::add($product->id);


        return view('mobile.product', compact('product'));

    }


    public function views()
    {


        $products = Product::whereIn('goods.id', \ViewProducts::all())->priceRange()->published()->sessionSort()->distinct()->paginate(getPageSize());

        return view('mobile.product_views', compact('products'));
    }

}
