<?php

namespace App\Http\Controllers\Api;

use App\Model\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderUpdateController extends ApiAuthController
{

    public function store(\App\Http\Requests\Api\Order $request)
    {

        $result = [
            'status' => 1,
            'message' => 'Success update'
        ];

        if($this->isAuthenticated()){

            $order = Order::whereNumber($request->get('number'))->firstOrFail();

            if($order){

                if($request->get('status')){
                    $order->cancel = 0;
                    $order->api_status = $request->get('status');
                }

                if($request->get('cancel'))
                    $order->cancel = 1;

                if($request->get('shipping_file_url'))
                    $order->shipping_file_url = $request->get('shipping_file_url');

                $order->save();

            }else{
                $result['status'] = 0;
                $result['message'] = 'Order not found';
            }


        }else{

            $result['status'] = 0;
            $result['message'] = 'Not authenticated';

        }

        return $result;

    }


}
