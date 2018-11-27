<?php

namespace App\Http\Controllers\Forms;

use App\Http\Requests\Dealer;
use App\Model\CallOrder;
use App\Model\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DealerController extends Controller
{
    public function send(Dealer $request){


        $request->request->set('date', Carbon::now());

        CallOrder::create($request->all());


        $data = $request->all();

        if($data['product_id']){
            $data['product'] = Product::whereId($data['product_id'])->first();
        }

        \Mail::send(new \App\Mail\Dealer($data));

        return back()->with('success_message', _setting('alert_call'));

    }
}
