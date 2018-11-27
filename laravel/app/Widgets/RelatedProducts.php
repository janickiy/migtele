<?php

namespace App\Widgets;

use App\Model\Product;
use Arrilot\Widgets\AbstractWidget;

class RelatedProducts extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'product_id' => '',
        'is_mobile' => false
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {


        $products = Product::related($this->config['product_id'])->published()->limit(12)->get();

        $view = $this->config['is_mobile'] ?  'widgets.mobile.related_products' : 'widgets.related_products';

        return view($view, [
            'config' => $this->config,
            'products' => $products
        ]);
    }
}
