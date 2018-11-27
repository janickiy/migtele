<?php

/**
 * @var \App\Model\Order $order
 */

namespace App\Mail;

use App\Model\MailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Order extends Mailable
{
    use Queueable, SerializesModels;


    public $order = '';
    public $mailTemplate = '';



    /**
     * Order constructor.
     * @param $order
     * @param $user_data
     */
    public function __construct($order)
    {
        $this->order = $order;

        $this->to($this->order->contractor->email, $this->order->contractor->name);

        $this->mailTemplate = MailTemplate::where('key', 'order')->first();

        $this->mailTemplate->patterns = [
            '[number]' => $this->order->number,
            '[date]' => $this->order->date->format('d.m.Y')
        ];

        $this->subject($this->mailTemplate->subject);

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.order.index');
    }
}
