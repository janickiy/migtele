<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Callback extends Mailable
{
    use Queueable, SerializesModels;

    public $data = '';

    public $subject = 'Заказ звонка';

    /**
     * Callback constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;

        $this->subject = 'Заказ звонка с сайта '.$_SERVER['SERVER_NAME'];

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
        return $this->view('emails.admin.callback');
    }
}
