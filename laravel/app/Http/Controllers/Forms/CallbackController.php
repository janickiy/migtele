<?php
namespace App\Http\Controllers\Forms;

use App\Http\Requests\Callback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Model\CallOrder;

class CallbackController extends Controller
{
    public function send(Callback $request){


        $request->request->set('date', Carbon::now());


        CallOrder::create($request->all());


        \Mail::send(new \App\Mail\Callback($request->all()));


        return back()->with('success_message', _setting('alert_call'));

    }
}
