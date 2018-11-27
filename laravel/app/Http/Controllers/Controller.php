<?php

namespace App\Http\Controllers;

use \Meta;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        # Default title
        Meta::set('title', _setting('title'));
        Meta::set('description', _setting('description'));
        Meta::set('keywords', _setting('keywords'));

    }

    protected function setSeo($entry)
    {
        $this->setSeoMeta($entry->title, $entry->description, $entry->keywords);
    }

    protected function setSeoMeta($title, $description = '', $keywords = '')
    {
        if($title)
            Meta::set('title', $title);

        if($description)
            Meta::set('description', $description);

        if($keywords)
            Meta::set('keywords', $keywords);
    }

    /**
     * @param $view_path
     * @param null $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function render($view_path, $data = [])
    {

        if(\Agent::isMobile() && !\Cookie::get('isDesktopVersion'))
            $view_path = 'mobile.'.$view_path;


        return view($view_path, $data);
    }
}
