<?php

namespace App\Mail;

use App\Model\MailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WishlistProductsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $wishlist_products;
    public $recommended_products;
    public $mailTemplate;


    public function __construct($user, $wishlist_products, $recommended_products)
    {
        $this->user = $user;
        $this->wishlist_products = $wishlist_products;
        $this->recommended_products = $recommended_products;

        $this->to($user->email, $user->name);

        $this->mailTemplate = MailTemplate::where('key', 'wishlist-products')->first();

        $this->subject($this->mailTemplate->subject);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.notifications.wishlist_products');
    }
}
