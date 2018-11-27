<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Feedback extends Mailable
{
    use Queueable, SerializesModels;

    public $data = '';

    public $subject = 'Обратная связь';

    /**
     * Feedback constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;

        $this->subject = 'Обратная связь '.'от '.date("d.m.Y").' с сайта '.$_SERVER['SERVER_NAME'];

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
        return $this->view('emails.admin.feedback');
    }
}
