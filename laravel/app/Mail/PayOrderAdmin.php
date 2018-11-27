<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PayOrderAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $pay_order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pay_order)
    {
        $this->pay_order = $pay_order;

        $this->subject = 'Начата оплата по счету №'.$pay_order->number.' с сайта '.$_SERVER['SERVER_NAME'];

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
        return $this->view('emails.admin.new_payment');
    }
}
