<?php

namespace App\Http\Controllers;

use App\Helpers\ViewProducts;
use App\Model\Product;
use App\Model\Vendor;
use Illuminate\Http\Request;

class ProductController extends Controller
{


    public function index($link)
    {

        $product = Product::published()->whereLink($link)->firstOrFail();

        ViewProducts::add($product->id);

        $product->setCount();

        $title = $product->name . ' | ' . ($product->sub_category2 ? $product->sub_category2->content_title : $product->sub_category->content_title);

        $this->setSeoMeta($title, strip_tags($product->text1), $product->keywords);

        return view('product', compact('product', 'title'));

    }



    public function popularProducts()
    {
        $products = Product::published()->popular()->simplePaginate(12);


        return view('ajax.product_items', compact('products'));

    }

    public function newProducts()
    {
        $products = Product::published()->new()->simplePaginate(12);

        return view('ajax.product_items', compact('products'));

    }


    public function vendorPopularProducts()
    {

        $vendor = Vendor::whereId(request('vendor_id'))->first();

        $products = Product::categoryIds($vendor->getProductCategoryIds())->published()->popular()->simplePaginate(12);

        $products = $products->appends(['vendor_id' => request('vendor_id')]);

        return view('ajax.product_items', compact('products'));
    }


    public function relatedProducts($product_id)
    {

        $products = Product::related($product_id)->simplePaginate(12);

        return view('ajax.product_items', compact('products'));
    }

}
