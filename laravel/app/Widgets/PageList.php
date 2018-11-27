<?php

namespace App\Widgets;

use App\Model\Pages;
use Arrilot\Widgets\AbstractWidget;

class PageList extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'active_page_id' => ''
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $pages = Pages::where('top', 1)->sort()->get();

        return view('widgets.page_list', [
            'config' => $this->config,
            'pages' => $pages
        ]);
    }
}
