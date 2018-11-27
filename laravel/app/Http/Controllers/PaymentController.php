<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Model\PayOrder;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function process(PaymentRequest $request)
    {

        $pay_order = PayOrder::create($request->except('g-recaptcha-response'));


        return redirect('/pay/'.$pay_order->id);
    }


    public function pay($id)
    {
        $pay_order = PayOrder::whereId($id)->firstOrFail();

        return view('payment.yandex.pay', compact('pay_order'));

    }

    public function success($hash)
    {

        $pay_order = PayOrder::where('hash', $hash)->firstOrFail();

        $pay_order->is_pay = 1;
        $pay_order->save();


        return redirect('/pay/'.$pay_order->id);

    }

}
