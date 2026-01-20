<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterConfirmMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $confirmUrl;
    public string $unsubscribeUrl;

    public function __construct(string $confirmUrl, string $unsubscribeUrl)
    {
        $this->confirmUrl = $confirmUrl;
        $this->unsubscribeUrl = $unsubscribeUrl;
    }

    public function build()
    {
        return $this->subject('Confirm your Glow FM newsletter subscription')
            ->view('emails.newsletter.confirm');
    }
}
