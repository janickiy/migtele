<?php

namespace App\Widgets;

use App\Model\Pages;
use Arrilot\Widgets\AbstractWidget;

class Menu extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'position' => 'top',
        'template' => 'default'
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $pages = Pages::where($this->config['position'], 1)->sort()->get();

        return view('widgets.menu.'.$this->config['template'], [
            'config' => $this->config,
            'pages' => $pages
        ]);
    }
}
