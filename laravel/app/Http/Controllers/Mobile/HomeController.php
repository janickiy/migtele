<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {


        return view('mobile.index');
    }



    public function goToDesktopVersion()
    {

        \Cookie::queue('isDesktopVersion', 1);

        return back();

    }

}
