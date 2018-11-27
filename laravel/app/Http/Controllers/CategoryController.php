<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\CategoryVendorText;
use App\Model\Cattmr;
use App\Model\Product;
use App\Model\SubCategory;
use App\Model\Vendor;


/**
 * TODO: переписать контроллер, куча повторяющегося кода, перенести методы search, vendors, vendor, new_, sale в отдельные контроллеры
 * Class CategoryController
 * @package App\Http\Controllers
 */
class CategoryController extends Controller
{

    public function index($slug)
    {

        $category = Category::published()->whereSlug($slug)->firstOrFail();

        $products = Product::getCatalog($category->product_category_ids);
        $price_range = Product::getPriceRange($category->product_category_ids);

        $category->setCount();

        $this->setSeo($category);

        return view('category', compact('category', 'products', 'price_range'));

    }


    public function sub_category($category_slug, $second_slug)
    {

        $category = Category::published()->whereSlug($category_slug)->firstOrFail();

        $sub_category = SubCategory::published()->whereSlug($second_slug)->first();
        $vendor = Vendor::published()->whereSlug($second_slug)->first();

        if(!$sub_category && !$vendor)
            return abort(404);

        $vendors = $sub_category ? $sub_category->vendors($category->id)->orderBy('name')->get() : $category->vendors()->orderBy('name')->get()->unique();

        $category_ids = $sub_category ? $sub_category->getProductCategoryIds($category->id) : $vendor->getProductCategoryIdsWithCategoryId($category->id);

        $products = Product::getCatalog($category_ids);
        $price_range = Product::getPriceRange($category_ids);

        $sub_categories2 = $sub_category ? $sub_category->sub_categories2($category->id)->get() : [];


        if($sub_category)
            $sub_category->setCount();

        if($vendor)
            $vendor->setCount();

        $breadcrumbs_setting = ['type'=> 'sub_category', 'element' => $sub_category ? $sub_category : $vendor];

        $sliders = $sub_category ? $sub_category->sliders : $vendor->sliders;

        $tags = $sub_category ? $sub_category->tags : '';
        $interested_products = $vendor ? $vendor->interested_products : '';


        $categoryVendorText = $vendor ? CategoryVendorText::where(['category_id' => $category->id, 'vendor_id' => $vendor->id])->first() : '';

        if($categoryVendorText){

            $site_title = $categoryVendorText->content_title ? $categoryVendorText->content_title : $vendor->name;

            $text = $categoryVendorText->text;

            $title = $categoryVendorText->title;
            $keywords = $categoryVendorText->keywords;
            $description = $categoryVendorText->description;

            $accordion_name = $categoryVendorText->content_title;
            $warranty_text = $categoryVendorText->warranty_text;
            $delivery_text = $categoryVendorText->delivery_text;

        }elseif($sub_category){

            $site_title = $sub_category->content_title ? $sub_category->content_title : $sub_category->name;
            $text = $sub_category->text;

            $title = $sub_category->title;
            $keywords = $sub_category->keywords;
            $description = $sub_category->description;

            $accordion_name = $sub_category->name;
            $warranty_text = $sub_category->warranty_text;
            $delivery_text = $sub_category->delivery_text;

        }else{
            $site_title = $category->name . ' ' . $vendor->name;
            $text = '';
            $title = '';
            $keywords = '';
            $description = '';
            $accordion_name = '';
            $warranty_text = '';
            $delivery_text = '';
        }




        return $this->catalog_render(
            $category,
            $products,
            $price_range,

            $site_title,
            $text,
            $breadcrumbs_setting,

            $sub_category,
            '',
            $vendor,
            $sub_categories2,
            $vendors,

            $sliders,
            $tags,
            $interested_products,

            $title,
            $keywords,
            $description,
            $accordion_name,
            $warranty_text,
            $delivery_text
        );

    }

    public function sub_category2($category_slug, $sub_category_slug, $sub_category2_slug)
    {

        $category = Category::published()->whereSlug($category_slug)->firstOrFail();
        $sub_category = SubCategory::published()->whereSlug($sub_category_slug)->firstOrFail();
        $sub_category2 = SubCategory::published()->whereSlug($sub_category2_slug)->firstOrFail();

        $vendors = $sub_category2->sub_category_vendors($category->id, $sub_category->id)->orderBy('name')->get();
        $category_ids = $sub_category2->getProductCategoryIds2($category->id, $sub_category->id);
        $products = Product::getCatalog($category_ids);
        $price_range = Product::getPriceRange($category_ids);

        $sub_categories2 = $sub_category->sub_categories2($category->id)->get();

        $site_title = $sub_category2->content_title ? $sub_category2->content_title : $sub_category2->name;

        $breadcrumbs_setting = ['type'=> 'sub_category2', 'element' => $category, 'element2' => $sub_category, 'element3' => $sub_category2];

        $sub_category2->setCount();

        return $this->catalog_render($category, $products, $price_range, $site_title, $sub_category2->text, $breadcrumbs_setting, $sub_category, $sub_category2, '', $sub_categories2, $vendors, $sub_category2->sliders, $sub_category2->tags, [], $sub_category2->title, $sub_category2->keywords, $sub_category2->description, $sub_category2->name, $sub_category2->warranty_text, $sub_category2->delivery_text);
    }


    public function sub_category_vendor($category_slug, $vendor_slug, $sub_category_slug)
    {
        $category = Category::whereSlug($category_slug)->published()->first();
        $sub_category = SubCategory::whereSlug($sub_category_slug)->published()->first();
        $vendor = Vendor::whereSlug($vendor_slug)->published()->first();


        if(!$category || !$sub_category || !$vendor){
            return $this->sub_category2($category_slug, $vendor_slug, $sub_category_slug);
        }

        $cattmr = Cattmr::where(['id_cattype' => $category->id, 'id_catrazdel' => $sub_category->id, 'id_catmaker' => $vendor->id])->published()->firstOrFail();



        $cattmr->setCount();


        $product_category_ids = Cattmr::where(['id_cattype' => $category->id, 'id_catrazdel' => $sub_category->id, 'id_catmaker' => $vendor->id])->pluck('id');

        $products = Product::getCatalog($product_category_ids);
        $price_range = Product::getPriceRange($product_category_ids);


        $vendors = $sub_category->vendors($category->id)->orderBy('name')->get();

        $site_title = $cattmr->content_title ? $cattmr->content_title : $vendor->name;
        $sub_categories2 = $sub_category->sub_categories2($category->id, $vendor->id)->get();

        $breadcrumbs_setting = ['type'=> 'sub_category_vendor', 'element' => $sub_category, 'element2' => $vendor];

        $sub_category2 = '';


        return $this->catalog_render($category, $products, $price_range, $site_title, $cattmr->text, $breadcrumbs_setting, $sub_category, $sub_category2, $vendor, $sub_categories2, $vendors, $vendor->sliders, [], $vendor->interested_products, $cattmr->title, $cattmr->keywords, $cattmr->description, $site_title, $cattmr->warranty_text, $cattmr->delivery_text);

    }

    public function sub_category2_vendor($category_slug, $vendor_slug, $sub_category_slug, $sub_category2_slug)
    {
        $category = Category::published()->whereSlug($category_slug)->firstOrFail();
        $vendor = Vendor::published()->whereSlug($vendor_slug)->firstOrFail();
        $sub_category = SubCategory::published()->whereSlug($sub_category_slug)->firstOrFail();
        $sub_category2 = SubCategory::published()->whereSlug($sub_category2_slug)->firstOrFail();

        $cattmr = Cattmr::where(['id_cattype' => $category->id, 'id_catrazdel' => $sub_category->id, 'id_sub_catrazdel' => $sub_category2->id, 'id_catmaker' => $vendor->id])->published()->firstOrFail();

        $products = Product::getCatalog([$cattmr->id]);
        $price_range = Product::getPriceRange([$cattmr->id]);

        $site_title = $cattmr->content_title ? $cattmr->content_title : $vendor->name;

        $sub_categories2 = $sub_category->sub_categories2($category->id, $vendor->id)->get();
        $vendors = $sub_category2->sub_category_vendors($category->id, $sub_category->id)->orderBy('name')->get();

        $breadcrumbs_setting = ['type'=> 'sub_category2_vendor', 'element' => $category, 'element2' => $vendor, 'element3' => $sub_category, 'element4' => $sub_category2];

        return $this->catalog_render($category, $products, $price_range, $site_title, $cattmr->text, $breadcrumbs_setting, $sub_category, $sub_category2, $vendor, $sub_categories2, $vendors, $vendor->sliders, [], $vendor->interested_products, $cattmr->title, $cattmr->keywords, $cattmr->description, $site_title, $cattmr->warranty_text, $cattmr->delivery_text);

    }



    public function catalog_render(
        $category,
        $products,
        $price_range,

        $site_title,
        $text,
        $breadcrumbs_setting,

        $sub_category = '',
        $sub_category2 = '',
        $vendor = '',
        $sub_categories2 = [],
        $vendors = [],

        $sliders = [],
        $tags = [],
        $interested_products = [],

        $title='',
        $keywords = '',
        $description = '',
        $accordion_name = '',
        $warranty_text = '',
        $delivery_text = ''
    )
    {


        $this->setSeoMeta($title, $description, $keywords);

        return view('catalog', compact(
                'category',
                'products',
                'price_range',

                'site_title',
                'text',
                'breadcrumbs_setting',

                'sub_category',
                'sub_category2',
                'vendor',
                'sub_categories2',
                'vendors',

                'sliders',
                'tags',
                'interested_products',

                'title',
                'keywords',
                'description',
                'accordion_name',
                'warranty_text',
                'delivery_text'

            )
        );
    }


    public function vendor($slug)
    {
        $vendor = Vendor::whereSlug($slug)->firstOrFail();

        $vendor->setCount();

        $this->setSeo($vendor);

        return view('vendor', compact('vendor'));
    }


    public function vendors()
    {
        $vendors = Vendor::published()->alphabet()->char(request('char'))->get();

        $links = [
            [
                'title' => 'Производители',
                'url' => request('char') ? url('/brands') : ''
            ]
        ];

        if(request('char')){
            array_push($links, ['title' => request('char')]);
        }

        return view('vendors', compact('vendors', 'links'));
    }

    public function sales()
    {
        $products = Product::published()->sales()->priceRange()->sessionSort()->distinct()->paginate(getPageSize());

        $from = Product::published()->sales()->sortExchangeToRub()->first();
        $to = Product::published()->sales()->sortExchangeToRub('desc')->first();

        $price_range = array(
            'from' => $from ? $from->getCorrectPrice() : 0,
            'to' => $to ? $to->getCorrectPrice() : 0,

        );


        $this->setSeoMeta(_setting('seo_title_sale_page'));

        return view('sales', compact('products', 'price_range'));
    }

    public function catalogNew()
    {
        $products = Product::published()->catalogNew()->priceRange()->sessionSort()->distinct()->paginate(getPageSize());


        $from = Product::published()->catalogNew()->sortExchangeToRub()->first();
        $to = Product::published()->catalogNew()->sortExchangeToRub('desc')->first();

        $price_range = array(
            'from' => $from ? $from->getCorrectPrice() : 0,
            'to' => $to ? $to->getCorrectPrice() : 0,

        );

        $this->setSeoMeta(_setting('seo_title_catalog_new_page'));

        return view('catalog_new', compact('products', 'price_range'));
    }


    public function search($search_text)
    {

        $products = Product::published()->search($search_text)->sortBySubCategory()->paginate(getPageSize());

        $sub_categories = SubCategory::chunkWithSubCategories($products);

        $vendors = Vendor::published()->search($search_text)->get();

        $categories = Category::published()->search($search_text)->get();

        $sub_categories_list = SubCategory::published()->search($search_text)->get();

        $cattmrs = Cattmr::published()->search($search_text)->get();

        $this->setSeoMeta('Поиск');

        return view('search', compact('sub_categories', 'products', 'vendors', 'categories', 'sub_categories_list', 'cattmrs'));
    }

}
