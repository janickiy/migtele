<?php

namespace App\Widgets;

use App\Model\Pages;
use Arrilot\Widgets\AbstractWidget;

class Advantages extends AbstractWidget
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


        $advantages = Pages::advantages()->get();


        $view_path_mobile = $this->config['is_mobile'] ? 'mobile.' : '';

        return view('widgets.'.$view_path_mobile.'advantages', [
            'config' => $this->config,
            'advantages' => $advantages
        ]);
    }
}
