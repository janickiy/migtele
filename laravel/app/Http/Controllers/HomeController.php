<?php

namespace App\Http\Controllers;

use App\Model\Pages;
use App\Models\Promocode;


class HomeController extends Controller
{

    public function index()
    {
        return $this->showHomePage();
    }

    public function showHomePage($promocode = false)
    {
        $page = Pages::whereLink('/')->first();

        return $this->render('index', compact('page', 'promocode'));

    }


    public function promocode($code)
    {
        $promocode = Promocode::byCode($code)->firstOrFail();

        $this->setSeoMeta($promocode->seo_title, $promocode->seo_description);


        return $this->showHomePage($promocode);

    }
    
}
