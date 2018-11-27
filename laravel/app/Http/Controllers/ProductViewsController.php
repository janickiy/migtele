<?php

namespace App\Http\Controllers;

use App\Model\SubCategory;
use Illuminate\Http\Request;

class ProductViewsController extends Controller
{
    public function index()
    {

        $sub_categories = SubCategory::getProductsWithSubCategories(\ViewProducts::all());

        $auth_view = \Auth::guest() ? '' : 'profile.';

        $this->setSeoMeta('Просмотренный товар');


        return view($auth_view.'product_views', ['sub_categories' => $sub_categories]);
    }
}
