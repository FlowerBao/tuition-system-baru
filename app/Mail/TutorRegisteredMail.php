<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TutorRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tutorName;
    public $email;
    public $password;

    public function __construct($tutorName, $email, $password)
    {
        $this->tutorName = $tutorName;
        $this->email = $email;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Your Tutor Account Information')
                    ->view('emails.tutor-registered');
    }
}

