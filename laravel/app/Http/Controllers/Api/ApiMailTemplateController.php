<?php

namespace App\Http\Controllers\Api;

use App\Model\Order;
use App\Model\MailTemplate;

class ApiMailTemplateController extends ApiAuthController
{

    public function index()
    {

        $result['status'] = 0;

        $title = '';

        if($this->isAuthenticated()){

            $order = Order::where('number', request('number'))->first();


            if($order) {

                switch (request('type')) {

                    case "discount":

                        $mailTemplate = MailTemplate::where('key', 'discount')->first();


                        if ($mailTemplate) {

                            $mailTemplate->pattern = ['code' => request('code')];

                            $result['subject'] = $mailTemplate->subject;

                            $title = $mailTemplate->title;

                            $body = $mailTemplate->body;

                    }


                        break;

                    default:

                        $title = request('subject');
                        $body = request('body');

                        break;

                }

                $result['status'] = 1;
                $result['body'] = view('emails.notifications.default', compact('title', 'body', 'order'))->render();

            }else{

                $result['message'] = 'Order not found';

            }


        }else{


            $result['message'] = 'Not authenticated';

        }


        return $result;

    }

}
