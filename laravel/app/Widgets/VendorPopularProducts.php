<?php

namespace App\Widgets;

use App\Model\Product;
use Arrilot\Widgets\AbstractWidget;

class VendorPopularProducts extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'vendor' => ''
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {

        $products = Product::categoryIds($this->config['vendor']->getProductCategoryIds())->published()->popular()->limit(12)->get();

        $url = url('/vendor-popular-products?vendor_id='.$this->config['vendor']->id.'&page=2');

        return view('widgets.vendor_popular_products', [
            'config' => $this->config,
            'products' => $products,
            'url' => $url
        ]);
    }
}
