<?php

namespace App\Http\Controllers;

use App\Model\Pages;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index($slug)
    {
        $page = Pages::whereLink('/'.$slug.'.htm')->firstOrFail();

        $view_name = $page->is_special ? 'special_page' : 'page';

        $this->setSeo($page);

        return view($view_name, compact('page'));

    }
}
