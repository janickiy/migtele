<?php
/**
 * Created by PhpStorm.
 * User: guchenko
 * Date: 14.08.2018
 * Time: 12:03
 */

namespace App\Http\Controllers\Admin;


class IndexController extends Controller
{

    /**
     * show dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index');
    }
}