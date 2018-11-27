<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiAuthController extends Controller
{
    protected function isAuthenticated()
    {
        return request('login') == $this->getLogin() && request('password') == $this->getPassword();
    }


    protected function getPassword()
    {
        return env('BDRUS_PASSWORD');
    }

    protected function getLogin()
    {
        return env('BDRUS_LOGIN');
    }
}
