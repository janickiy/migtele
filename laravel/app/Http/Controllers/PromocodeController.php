<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromocodeApplyRequest;
use App\Http\Requests\PromocodeSendFriendRequest;
use App\Mail\DefaultMail;
use App\Models\Promocode;
use Illuminate\Http\Request;

class PromocodeController extends Controller
{

    public function apply(PromocodeApplyRequest $request)
    {
        \Promocodes::apply($request->get('promocode'));

        return back();
    }


    public function remove()
    {

        \Promocodes::remove();

        return back()->with('success_message', 'Промокод успешно удален.');
    }


    public function sendFriend(PromocodeSendFriendRequest $request)
    {

        $promocode = Promocode::byCode($request->get('code'))->first();

        \Mail::send(new DefaultMail('promocode-send-friend', $promocode->mail_patterns, '', $request->get('email')));

    }

}
