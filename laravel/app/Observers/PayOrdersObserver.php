<?php

namespace App\Observers;


use App\Model\PayOrder;

class PayOrdersObserver
{

    public function creating(PayOrder $payOrder)
    {

        $payOrder->hash = md5($payOrder->number . $payOrder->name. time());


    }

    public function created(PayOrder $payOrder)
    {


        \Mail::send(new \App\Mail\PayOrderClient($payOrder));
        \Mail::send(new \App\Mail\PayOrderAdmin($payOrder));

    }

}