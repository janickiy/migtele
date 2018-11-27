<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuickOrder;
use App\Model\Contractor;
use App\Model\DeliveryMethod;
use App\Model\DeliveryMethodItem;
use App\Model\Order;
use App\Model\PaymentMethod;
use App\Model\Product;
use App\Model\User;
use \App\Model\Subscriber;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{


    public function index()
    {

        $payments = PaymentMethod::published()->sort()->get();
        $deliveries = DeliveryMethod::published()->sort()->get();


        return view('order', compact('payments', 'deliveries', 'promocode'));

    }

    /**
     * @param \App\Http\Requests\Order $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function ordering(\App\Http\Requests\Order $request)
    {
        $data = $request->toArray();

        $delivery = DeliveryMethod::getDeliveryInfoInOrder();

        $request->request->set('delivery_name', $delivery['full_name']);
        $request->request->set('delivery_price', $delivery['price']);
        $request->request->set('delivery_address', $delivery['address']);
        $request->request->set('delivery_note', $delivery['note']);
        $request->request->set('delivery_time', $delivery['time']);

        $request->request->set('comment', $request->get('comment') .($delivery['to'] ?  "\nДоставка: ". $delivery['to'] : ""));

        $user = \Auth::check()  ? \Auth::user() : null;

        if(request('register')){

            $user = User::create([

                'email' => $data['email'],
                'type' => $data['type'],
                'name' => $data['name'],

                'phones' => [$data['phone']],
                'company_name' => $data['company_name'],
                'tin' => $data['inn'],

                'juridical_address' => $data['address'],
                'delivery_addresses' => [$delivery['address']],

                'subscribe_order' => request('subscribe_order'),
                'subscribe_news' => request('subscribe_news'),
                'subscribe_cart' => request('subscribe_cart'),
                'subscribe_view' => request('subscribe_view'),
                'subscribe_wishlist' => request('subscribe_wishlist'),

                'password' => ''
            ]);

            $request->request->set('user_id', $user->id);
        }

        $contractor = Contractor::create($request->all());
        $contractor->order()->create($request->all());

        if ($user && !\Auth::user())
            \Auth::attempt(['email' => $user->email, 'password' => session('temp_password')]);

        $redirect_url = \Auth::user() ? '/profile/orders' : '/order/success/'.$contractor->order->id;

        return  redirect($redirect_url);

    }


    public function quick(QuickOrder $request)
    {
        if(request('product_id'))
            \CartProducts::add(request('product_id'));

        $contractor = Contractor::create($request->all());

        $contractor->order()->create($request->all());

        $redirect_url = \Auth::user() ? '/profile/orders' : '/order/success/'.$contractor->order->id;
        return  redirect($redirect_url);
    }


    public function success($id)
    {
        $order = Order::findOrFail($id);

        return view('order.success', compact('order'));
    }



}
