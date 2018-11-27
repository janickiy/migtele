<?php

namespace App\Mail;

use App\Model\MailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PayOrderClient extends Mailable
{
    use Queueable, SerializesModels;

    public $pay_order;
    public $mailTemplate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pay_order)
    {
        $this->pay_order = $pay_order;
        $this->to($this->pay_order->email, $this->pay_order->name);

        $this->mailTemplate = MailTemplate::where('key', 'pay-order-client')->first();

        $this->mailTemplate->patterns = [
            '[number]' => $this->pay_order->number,
            '[link]' => '<a href="'.url('/pay/'.$this->pay_order->id).'">'.url('/pay/'.$this->pay_order->id).'</a>',
            '[form-data]' => view('emails.payment.form-data', ['pay_order' => $pay_order])->render()
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
        return $this->view('emails.order.default');
    }
}
