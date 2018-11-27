<?php

namespace App\Http\Controllers\Mobile;

use App\Model\DeliveryMethod;
use App\Model\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{


    public function index()
    {

        $payments = PaymentMethod::published()->sort()->get();
        $deliveries = DeliveryMethod::published()->sort()->get();

        return view('mobile.order', compact('payments', 'deliveries'));

    }


}
