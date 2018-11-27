<?php

namespace App\Mail;

use App\Model\MailTemplate;
use App\Model\Product;
use App\Model\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CartProductsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $products;
    public $mailTemplate;


    /**
     * ViewProductsMail constructor.
     * @param User $user
     * @param Product[] $products
     */
    public function __construct($user, $products)
    {
        $this->user = $user;
        $this->products = $products;

        $this->to($user->email, $user->name);

        $this->mailTemplate = MailTemplate::where('key', 'cart-products')->first();

        $this->subject($this->mailTemplate->subject);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('emails.notifications.cart_products');
    }
}
