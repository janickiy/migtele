<?php

namespace App\Widgets;

use App\Model\Slider;
use Arrilot\Widgets\AbstractWidget;

class Sliders extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'is_homepage' => false,
        'sliders' => []
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $sliders = $this->config['is_homepage'] ?  Slider::homepage()->published()->sort()->get() : $this->config['sliders'];

        return view('widgets.sliders', [
            'config' => $this->config,
            'sliders' => $sliders
        ]);
    }
}
