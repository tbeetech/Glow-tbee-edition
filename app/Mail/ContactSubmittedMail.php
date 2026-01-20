<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public ContactMessage $messageRecord;

    public function __construct(ContactMessage $messageRecord)
    {
        $this->messageRecord = $messageRecord;
    }

    public function build()
    {
        return $this->subject('New contact message: ' . $this->messageRecord->subject)
            ->view('emails.contact.submitted');
    }
}
