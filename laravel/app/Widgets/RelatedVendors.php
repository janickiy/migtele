<?php

namespace App\Widgets;

use App\Model\Cattmr;
use App\Model\Vendor;
use Arrilot\Widgets\AbstractWidget;

class RelatedVendors extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'vendor' => ''
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {

        $sub_category_ids = $this->config['vendor']->sub_categories->pluck('id');


        $vendors = Vendor::sortRelatedVendors($sub_category_ids)->published()->whereNotIn('id', [$this->config['vendor']->id])->mainSort()->limit(12)->get();

        return view('widgets.related_vendors', [
            'config' => $this->config,
            'vendors' => $vendors
        ]);
    }
}
