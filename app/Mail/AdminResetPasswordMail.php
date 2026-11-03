<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otpCode;
    public $subjectLine;

    public function __construct($otpCode = null, $subjectLine = 'CentraDesk Password Reset Passcode')
    {
        $this->otpCode = $otpCode;
        $this->subjectLine = $subjectLine;
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
                    ->view('backend.admin.emails.admin-password-reset');
    }
}