<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $replyBody;
    public string $recipientName;

    public function __construct(string $recipientName, string $replyBody)
    {
        $this->recipientName = $recipientName;
        $this->replyBody = $replyBody;
    }

    public function build()
    {
        return $this->subject('Re: Your message to Glow FM')
            ->view('emails.contact.reply');
    }
}
