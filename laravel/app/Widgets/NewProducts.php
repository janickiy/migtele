<?php

namespace App\Widgets;

use App\Model\Product;
use Arrilot\Widgets\AbstractWidget;

class NewProducts extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'is_mobile' => false
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $products = Product::published()->new()->limit(12)->get();

        $view_path_mobile = $this->config['is_mobile'] ? 'mobile.' : '';

        return view('widgets.'.$view_path_mobile.'new_products', [
            'config' => $this->config,
            'products' => $products
        ]);
    }
}
