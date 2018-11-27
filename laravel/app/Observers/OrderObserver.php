<?php

namespace App\Observers;


use App\Mail\DefaultMail;
use App\Model\Order;
use App\Model\Product;
use Carbon\Carbon;

class OrderObserver
{


    public function creating(Order $order)
    {
        $order->date = Carbon::now();

        if (!$order->status)
            $order->status = Order::DEFAULT_STATUS;

        if(!$order->user_id)
            $order->user_id = \Auth::user() ? \Auth::user()->id : 0;

        if(!$order->payment_method_id)
            $order->payment_method_id = $order->default_payment_method_id;

        if(!$order->delivery_method_id)
            $order->delivery_method_id = $order->default_delivery_method_id;

        if(session('clone_products')){

            $order->order_info = view('order.partial.clone_order_info', ['products' => session('clone_products')])->render();

        }else{
            $order->order_info = view('order.partial.order_info', ['products' => Product::getCartProduct()])->render();
        }

        $order->user_info = view('order.partial.user_info', compact('order'))->render();


        if(\Promocodes::getSessionPromocode()){
            $order->promocode_id = \Promocodes::getSessionPromocode()->id;
        }


    }


    public function created(Order $order)
    {


        if(session('clone_products')){

            foreach (session('clone_products') as $clone_product){
                $product = Product::find($clone_product['id']);
                if($product){

                    $this->attachProduct($order, $product, $clone_product);
                }
            }


        }else{
            foreach (Product::getCartProduct() as $product)
            {
                $this->attachProduct($order, $product);
            }
        }



        $api_order = new \App\Http\Controllers\Api\OrderController($order);
        $api_result = $api_order->create();


        if($api_result){
            $order->number = $api_result['number'];
            $order->api_status = $api_result['status'];
            $order->order_file_url = $api_result['order_file_url'];
            $order->save();
        }

        \Mail::send(new \App\Mail\Order($order));
        \Mail::send(new \App\Mail\Admin\AdminOrderMail($order));

        if(session('clone_products')){

            \Request::session()->forget('clone_products');

        }else{

            if(env('APP_ENV') != 'local')
                \CartProducts::clear();
        }

        if($order->promocode_id)
            \Promocodes::used($order->promocode->code, $order->contractor->email, $order->contractor->name);

        \Promocodes::remove();

        /**
         * Создаем промокод для друзей
         */
        $promocode = \Promocodes::createInEmail($order->contractor->email, $order->contractor->name);

        \Mail::send(new DefaultMail('promocode-friend', $promocode->mail_patterns, $order->contractor->name, $order->contractor->email));

    }

    protected function attachProduct($order, $product, $clone_product = false)
    {

        $quantity = $clone_product ? $clone_product['quantity'] : $product->quantity;

        $order->products()->attach($product->id, [
            'price' => $product->cart_price,
            'kol' => $quantity,
            'discount' => $product->cart_discount,
            'stoim' => $product->cart_price * $quantity
        ]);
    }

    protected function promocodeDiscountProduct($order, $price)
    {
        return $price * ($order->promocode ? $order->promocode->reward : 0) / 100;
    }

    public function saved(Order $order)
    {
        if ($order->isDirty('cancel') && $order->cancel){
            \Mail::send(new \App\Mail\CancelOrder($order));
            \Mail::send(new \App\Mail\Admin\CancelOrder($order));
        }


    }

}