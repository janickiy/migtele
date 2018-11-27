<?php

namespace App\Http\Controllers\Mobile;

use App\Model\Category;
use App\Model\Cattmr;
use App\Model\Product;
use App\Model\SubCategory;
use App\Model\Vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function category($slug)
    {

        $category = Category::whereSlug($slug)->firstOrFail();


        return view('mobile.category', compact('category'));

    }


    public function sub_category($category_slug, $second_slug)
    {

        $category = Category::whereSlug($category_slug)->firstOrFail();

        $sub_category = SubCategory::whereSlug($second_slug)->first();
        $vendor = Vendor::whereSlug($second_slug)->first();

        $vendors = $sub_category ? $sub_category->vendors($category->id)->get() : $category->vendors->unique();

        $category_ids = $sub_category ? $sub_category->getProductCategoryIds($category->id) : $vendor->getProductCategoryIdsWithCategoryId($category->id);

        $products = Product::getCatalog($category_ids);


        return view('mobile.sub_category', compact('category', 'sub_category', 'vendor', 'vendors', 'products'));

    }


    public function sub_category_vendor($category_slug, $vendor_slug, $sub_category_slug)
    {

        $category = Category::whereSlug($category_slug)->firstOrFail();
        $sub_category = SubCategory::whereSlug($sub_category_slug)->firstOrFail();
        $vendor = Vendor::whereSlug($vendor_slug)->firstOrFail();

        $product_category = Cattmr::where('id_cattype', $category->id)->where('id_catmaker', $vendor->id)->where('id_catrazdel', $sub_category->id)->firstOrFail();


        $products = Product::getCatalog([$product_category->id]);

        return view('mobile.sub_category_vendor', compact('product_category', 'products'));

    }


    public function vendor($slug)
    {

        $vendor = Vendor::whereSlug($slug)->firstOrFail();

        $vendor->setCount();

        return view('mobile.vendor', compact('vendor'));
    }

    public function vendors(){

        $vendors = Vendor::published()->alphabet()->get();

        return view('mobile.vendors', compact('vendors'));
    }


    public function search($search_text)
    {

        $products = Product::published()->search($search_text)->paginate(getPageSize());


        return view('mobile.search', compact('products'));
    }

}
