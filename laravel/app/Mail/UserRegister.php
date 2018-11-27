<?php

namespace App\Mail;

use App\Model\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegister extends Mailable
{
    use Queueable, SerializesModels;

    public $user = '';
    public $password = '';

    /**
     * UserRegister constructor.
     * @param User $user
     * @param string $password
     */
    public function __construct($user, $password)
    {
        $this->subject = 'Регистрация на сайте '.config('app.name');
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.user.register', [

            'user' => $this->user,
            'password' => $this->password

        ]);
    }
}
