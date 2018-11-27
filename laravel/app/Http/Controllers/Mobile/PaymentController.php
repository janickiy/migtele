<?php

namespace App\Http\Controllers\Mobile;

use App\Model\PayOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function pay($id)
    {
        $pay_order = PayOrder::whereId($id)->firstOrFail();

        return view('mobile.payment.yandex.pay', compact('pay_order'));

    }
}
