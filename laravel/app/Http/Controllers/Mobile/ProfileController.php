<?php

namespace App\Http\Controllers\Mobile;

use App\Model\User;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function edit(){

        $user = \Auth::user();
        /**
         * @var $user User
         */

        return view('mobile.profile.edit', compact('user'));
    }

    public function orders()
    {
        $user = \Auth::user();

        return view('mobile.profile.orders', compact('user'));
    }


    public function settings()
    {
        $user = \Auth::user();

        return view('mobile.profile.settings', compact('user'));
    }

}
