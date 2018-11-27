<?php

namespace App\Http\Controllers\Api;

use App\Model\Order;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{

    protected $order;
    protected $data;

    public function __construct(Order $order)
    {

        $this->order = $order;

        $this->makeData();

    }


    public function create()
    {
        $createUrl = $this->getCreateOrderUrl();

        if(!$createUrl) return false;

        ksort($this->data);

        $this->data['hash'] = hash('sha256',serialize($this->data));


        $this->data = http_build_query($this->data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $createUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec ($ch);
        curl_close ($ch);

        return $this->prepareData($output);
    }




    protected function prepareData($output)
    {

        $output = json_decode($output, true);

        if(isset($output['success']) && $output['success']){

            $output['status'] = isset($output['status']) ? $output['status'] : '';
            $output['number'] = isset($output['billNumber']) ? $output['billNumber'] : '';
            $output['order_file_url'] = isset($output['order_file_url']) ? $output['order_file_url'] : '';

            return $output;
        }else{
            return false;
        }

    }



    protected function makeData()
    {


        $this->data = [
            'login' => (string)$this->getLogin(),
            'password' => (string)$this->getPassword(),

            'paymentTypeName' => (string)$this->order->payment_method_name,
            'products' => (string)$this->makeProductsData(),
            'amount' => (string)$this->order->amount,

            'contractor' => $this->getContractorData(),

            'comment' => $this->order->comment,

            'deliveryName' => (string)$this->order->delivery_name,
            'deliveryCost' => (string)$this->order->delivery_price,
            'deliveryAddress' => (string)$this->order->deliveryAddress

        ];



    }


    protected function getContractorData()
    {
        $contractor = [];


        foreach ($this->order->contractor->toArray() as $key=>$value)
        {

            /**
             * Делаем орфографическую ошибку в ключе lol
             */
            $key = str_replace('receiver', 'reciever', $key);

            $contractor[camel_case($key)] = strval($value);
        }

        return $contractor;
    }

    /**
     * @return string
     */
    protected function makeProductsData()
    {
        $products = [];


        foreach ($this->order->products as $product) {
            $products[] = [
                'code' => $product->kod,
                'name' => $product->text1,
                'price' => $product->pivot->price,
                'count' => $product->pivot->kol
            ];

        }

        return json_encode($products);

    }

    protected function getCreateOrderUrl()
    {
        return env('BDRUS_CREATE_ORDER_URL');
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
