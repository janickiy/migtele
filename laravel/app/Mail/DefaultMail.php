<?php

namespace App\Mail;

use App\Model\MailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DefaultMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailTemplate;

    protected $mailTemplateKey;

    /**
     * DefaultMail constructor.
     * @param $key
     * @param $pattern
     * @param $name
     * @param $email
     */
    public function __construct($key, $pattern, $name, $email)
    {
        $this->to($email, $name);

        $this->initMailTemplate($key, $pattern);
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



    protected function initMailTemplate($key, $patterns)
    {
        $this->mailTemplateKey = $key;

        $this->setMailTemplate();
        $this->setPatterns($patterns);
        $this->setSubject();
    }

    protected function setMailTemplate()
    {
        $this->mailTemplate = MailTemplate::where('key', $this->mailTemplateKey)->first();
    }


    protected function setPatterns($patterns){
        $this->mailTemplate->patterns = $patterns;
    }

    protected function setSubject()
    {
        $this->subject($this->mailTemplate->subject);
    }
}
