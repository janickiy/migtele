<?php

namespace App\Widgets;

use App\Model\Category;
use Arrilot\Widgets\AbstractWidget;

class CategoryMenu extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        
        $categories = Category::published()->mainSort()->get();

        return view('widgets.category_menu', [
            'config' => $this->config,
            'categories' => $categories
        ]);
    }
}
