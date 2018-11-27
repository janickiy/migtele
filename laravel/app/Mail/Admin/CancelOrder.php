<?php

namespace App\Mail\Admin;

use App\Model\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CancelOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $order;


    public function __construct(Order $order)
    {
        $this->order = $order;

        $this->subject = 'Клиент отменил заказ №'.$order->number.' '.$_SERVER['SERVER_NAME'];

        $this->to(_setting('email'));
        $this->from(_setting('email'), config('app.name'));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.admin.order_cancel');
    }
}
