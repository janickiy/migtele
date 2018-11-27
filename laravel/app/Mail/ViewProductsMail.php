<?php

namespace App\Mail;

use App\Model\MailTemplate;
use App\Model\Product;
use App\Model\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ViewProductsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $view_products;
    public $recommended_products;
    public $mailTemplate;

    /**
     * ViewProductsMail constructor.
     * @param User $user
     * @param Product[] $view_products
     * @param Product[] $recommended_products
     */
    public function __construct($user, $view_products, $recommended_products)
    {
        $this->user = $user;
        $this->view_products = $view_products;
        $this->recommended_products = $recommended_products;

        $this->to($user->email, $user->name);

        $this->mailTemplate = MailTemplate::where('key', 'view-products')->first();

        $this->subject($this->mailTemplate->subject);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('emails.notifications.view_products');
    }
}
