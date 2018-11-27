<?php

namespace App\Http\Controllers;

use App\Model\Product;
use App\Model\SubCategory;
use Illuminate\Http\Request;

class WishListController extends Controller
{

    public function index()
    {

        $sub_categories = SubCategory::getProductsWithSubCategories(\WishlistProducts::all());

        $auth_view = \Auth::guest() ? '' : 'profile.';

        $this->setSeoMeta('Закладки');

        return view($auth_view.'wishlist', ['sub_categories' => $sub_categories]);
    }

    public function add(request $request)
    {

        \WishlistProducts::add(request('id'));

        return \WishlistProducts::count();
    }

    public function delete()
    {
        \WishlistProducts::delete(request('id'));

        return \WishlistProducts::count();
    }

    public function clear()
    {
        \WishlistProducts::clear();

        return back();
}
}
