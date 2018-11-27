<?php

namespace App\Widgets;

use App\Model\Category;
use App\Model\Product;
use Arrilot\Widgets\AbstractWidget;

class PopularProducts extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'category_id' => '',
        'product_category_ids' => [],
        'is_mobile' => false
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {

        $product_category_ids = count($this->config['product_category_ids']) ? $this->config['product_category_ids'] :  $this->getProductCategoryIds();

        $products = Product::categoryIds($product_category_ids)->published()->popular()->limit(12)->get();



        $view_path_mobile = $this->config['is_mobile'] ? 'mobile.' : '';

        return view('widgets.'.$view_path_mobile.'popular_products', [
            'config' => $this->config,
            'products' => $products
        ]);
    }


    public function getProductCategoryIds()
    {
        $product_category_ids = [];


        if($this->config['category_id']){
            $category = Category::find($this->config['category_id']);

            if($category){

                $product_category_ids = $category->product_category_ids;

            }

        }


        return $product_category_ids;
    }
}
