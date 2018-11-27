<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePassword;
use App\Model\Order;
use App\Model\Product;
use App\Model\User;
use Illuminate\Http\Request;
use League\Flysystem\Exception;
use ReCaptcha\RequestMethod\Curl;

class ProfileController extends Controller
{


    public function edit(){

        $user = \Auth::user();
        /**
         * @var $user User
         */

        return redirect('/profile/edit/'.($user->type == '1' ? 'individual' : 'juridical'));
    }

    public function individual()
    {

        $user = \Auth::user();

        return view('profile.edit.individual', compact('user'));
    }

    public function juridical()
    {
        $user = \Auth::user();

        return view('profile.edit.juridical', compact('user'));
    }

    public function save(Request $request)
    {
        $user = \Auth::user();

        $this->validate($request, User::getValidatorRulesOnType($request->get('type'), false, true, $user->id));

        $user->update($request->all());

        return back();

    }

    public function orders()
    {
        $user = \Auth::user();

        return view('profile.orders', compact('user'));
    }


    public function saveSettings(Request $request)
    {
        $user = \Auth::user();

        $user->update($request->all());

        return back()->with('success_message', 'Настройки сохранены');
    }

    public function changePassword(ChangePassword $request)
    {

        $user = \Auth::user();

        $user->update([
            'password' =>  bcrypt($request->get('password'))
        ]);

        return back()->with('success_messagemessage', 'Пароль успешно изменен');

    }


    public function cancelOrder($id)
    {
        $order = Order::whereId($id)->where('user_id', \Auth::user()->id)->firstOrFail();
        $order->cancel = 1;
        $order->api_status = "Отменен";
        $order->save();

        return redirect('/profile/orders');

    }


    public function downloadOrderFile($id)
    {

        $order = Order::where('id', $id)->where('user_id', \Auth::id())->whereNotNull('order_file_url')->firstOrFail();

        return $this->downloadFile($order->order_file_url, 'order-'.$order->id.'.xlsx');

    }

    public function downloadShippingFile($id)
    {

        $order = Order::where('id', $id)->where('user_id', \Auth::id())->whereNotNull('shipping_file_url')->firstOrFail();

        return $this->downloadFile($order->shipping_file_url, 'shipping-'.$order->id.'.xlsx');


    }


    public function downloadFile($file_url, $tmp_name)
    {

        $file_url = preg_replace_callback('#://([^/]+)/([^?]+)#', function ($match) {
            return '://' . $match[1] . '/' . join('/', array_map('rawurlencode', explode('/', $match[2])));
        }, $file_url);

        $file = @file_get_contents($file_url);

        if(!$file) return abort(404);

        \Storage::put($tmp_name, $file, 'public');

        $file_path = storage_path('app/'.$tmp_name);

        return response()->download($file_path, urldecode(basename($file_url)));
    }



    public function orderRepeat(Request $request)
    {

        /**
         * @var Order $order
         */

        $order = Order::findOrFail($request->get('order_id'));

        $newOrder = clone $order;

        $clone_products = [];

        foreach ($order->products as $product) {

            $clone_products[] = [
                'id' => $product->id,
                'quantity' => $product->pivot->kol
            ];
        }

        session(['clone_products' => $clone_products]);

        unset($newOrder->id);
        unset($newOrder->status);
        unset($newOrder->api_status);
        unset($newOrder->promocode_id);


        Order::create($newOrder->toArray());

        return back()->with('success_message', _setting('repeat-order-success-message'));
    }

}
