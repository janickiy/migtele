<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class Cart extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'theme' => 'default'
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {

        return view('widgets.cart.'.$this->config['theme'], [
            'config' => $this->config,
            'quantity' => \CartProducts::getTotalQuantity(),
            'price' => _price(\CartProducts::getTotal())
        ]);
    }
}
