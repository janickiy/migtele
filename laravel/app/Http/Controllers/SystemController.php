<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\Cattmr;
use App\Model\News;
use App\Model\Pages;
use App\Model\Product;
use App\Model\Tag;
use App\Model\Vendor;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    public function setSort($sort_name)
    {

        session(['sort' => $sort_name]);


        return back();
    }

    public function setPageSize()
    {
        session(['page_size' => request('page_size')]);

        return back();
    }

    public function sitemap()
    {
        $pages = Pages::sort()->get();
        $categories = Category::mainSort()->published()->get();

        return view('sitemap', compact('pages', 'categories'));
    }


    public function sitemap_xml()
    {

        $urls = [];

        foreach (News::all() as $page)
        {
            $urls[] = $page->url;
        }

        foreach (Pages::all() as $page)
        {
            if ($page->name == 'Главная'){
                $urls[] = '/';
                continue;
            }

            $urls[] = $page->link;
        }

        foreach (Category::published()->get() as $category)
        {
            $urls[] = $category->url;

            foreach ($category->sub_categories->unique() as $sub_category){
                $urls[] = $category->getUrlWithSubcategory($sub_category);
            }

            foreach ($category->vendors->unique() as $vendor){
                $urls[] = $category->getUrlWithVendor($vendor);
            }

        }

        foreach (Cattmr::published()->get() as $cattmr)
        {
            if($cattmr->category && $cattmr->vendor && $cattmr->sub_category)
                if($cattmr->sub_category2){
                    $urls[] =  $cattmr->category->getUrlSubcategory2($cattmr->sub_category, $cattmr->sub_category2, $cattmr->vendor);
                }else{
                    $urls[] =  $cattmr->category->getUrlWithVendorAndSubcategory($cattmr->vendor, $cattmr->sub_category);
                }

        }


        foreach (Vendor::published()->get() as $vendor)
        {
            $urls[] = $vendor->url;
        }

        foreach (Product::published()->get() as $product)
        {
            $urls[] = $product->url;
        }

        foreach (Tag::published()->get() as $tag)
        {
            $urls[] = $tag->url;
        }

        return response()->view('system.sitemap', compact('urls'))->header('Content-Type', 'text/xml');

    }

}
