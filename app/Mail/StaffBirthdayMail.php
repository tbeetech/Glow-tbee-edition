<?php

namespace App\Mail;

use App\Models\Staff\StaffMember;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StaffBirthdayMail extends Mailable
{
    use Queueable, SerializesModels;

    public StaffMember $staff;
    public string $subjectLine;
    public string $messageBody;
    public string $stationName;
    public string $stationFrequency;

    public function __construct(
        StaffMember $staff,
        string $subjectLine,
        string $messageBody,
        string $stationName,
        string $stationFrequency = ''
    ) {
        $this->staff = $staff;
        $this->subjectLine = $subjectLine;
        $this->messageBody = $messageBody;
        $this->stationName = $stationName;
        $this->stationFrequency = $stationFrequency;
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
            ->view('emails.staff.birthday');
    }
}
