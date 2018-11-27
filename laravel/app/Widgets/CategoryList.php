<?php

namespace App\Widgets;

use App\Model\Category;
use Arrilot\Widgets\AbstractWidget;

class CategoryList extends AbstractWidget
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
        //

        $categories = Category::published()->mainSort()->get();

        $view_path_mobile = $this->config['is_mobile'] ? 'mobile.' : '';

        return view('widgets.'.$view_path_mobile.'category_list', [
            'config' => $this->config,
            'categories' => $categories
        ]);
    }
}
