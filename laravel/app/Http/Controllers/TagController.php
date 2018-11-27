<?php

namespace App\Http\Controllers;

use App\Model\Product;
use App\Model\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index($slug)
    {
        $tag = Tag::where('slug', $slug)->published()->firstOrFail();

        $category = $tag->category;

        if(!$category){
            abort(404);
        }

        $sub_category = $tag->sub_category;

        $vendors = $sub_category ? $sub_category->vendors($category->id)->orderBy('name')->get() : $category->vendors()->orderBy('name')->get()->unique();

        $category_ids = $sub_category ? $sub_category->getProductCategoryIds($category->id) : $category->product_category_ids;

        $products = Product::getCatalog($category_ids);
        $price_range = Product::getPriceRange($category_ids);


        $this->setSeo($tag);

        return view('tag', compact('tag', 'category', 'sub_category', 'products', 'price_range', 'vendors'));
    }
}
