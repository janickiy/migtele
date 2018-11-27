<?php

namespace App\Widgets;

use App\Models\Promocode;
use Arrilot\Widgets\AbstractWidget;

class SharePromocode extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $promocode = session('share_promocode');

        $promocode = Promocode::byCode($promocode)->first();

        if(!$promocode)
            return '';

        return view('widgets.share_promocode', [
            'config' => $this->config,
            'promocode' => $promocode
        ]);
    }
}
