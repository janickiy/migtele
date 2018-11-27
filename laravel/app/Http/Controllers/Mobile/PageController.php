<?php

namespace App\Http\Controllers\Mobile;

use App\Model\Pages;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function index($slug)
    {


        $page = Pages::whereLink('/'.$slug.'.htm')->firstOrFail();

        return view('mobile.page', compact('page'));

    }
}
