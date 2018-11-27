<?php

namespace App\Mail\Admin;

use App\Http\Controllers\Forms\FeedbackController;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FeedbackOnTypeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $photo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->subject(FeedbackController::ITEMS[$data['type']].' с сайта '. $_SERVER['SERVER_NAME']);

        $this->to(_setting('email'));
        $this->from(_setting('email'), config('app.name'));

        unset($data['type']);
        unset($data['g-recaptcha-response']);
        unset($data['_token']);

        if(isset($data['photo'])){
            $this->photo = $data['photo'];
            unset($data['photo']);
        }

        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $email = $this->view('emails.admin.feedback_on_type');

        if($this->photo)
            $email->attach($this->photo);

        return $email;

    }
}
