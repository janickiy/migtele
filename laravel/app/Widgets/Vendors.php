<?php

namespace App\Widgets;

use App\Model\Vendor;
use Arrilot\Widgets\AbstractWidget;

class Vendors extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'category' => '',
        'sub_category' => '',
        'sub_category2' => '',
        'vendors' => [],
        'title' => 'Товар по производителям',
        'selected_vendor' => '',
        'class' => '',
        'is_mobile' => false
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $vendors = $this->config['category'] ? $this->config['vendors'] : ($this->config['vendors'] ? $this->config['vendors'] : Vendor::published()->orderBy('name')->get());

        $view_path_mobile = $this->config['is_mobile'] ? 'mobile.' : '';

        return view('widgets.'.$view_path_mobile.'vendors', [
            'config' => $this->config,
            'vendors' => $vendors
        ]);
    }
}
