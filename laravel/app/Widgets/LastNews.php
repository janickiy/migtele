<?php

namespace App\Widgets;

use App\Model\News;
use Arrilot\Widgets\AbstractWidget;

class LastNews extends AbstractWidget
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
        $news = News::orderBy('date', 'desc')->get();

        return view('widgets.last_news', [
            'config' => $this->config,
            'news' => $news
        ]);
    }
}
