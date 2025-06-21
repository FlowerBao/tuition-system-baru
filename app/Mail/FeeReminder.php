<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\StudentList;

class FeeReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $student;

    public function __construct(StudentList $student)
    {
        $this->student = $student;
    }

    public function build()
    {
        return $this->subject('Fee Payment Reminder')
                    ->view('emails.fee_reminder')
                    ->with(['student' => $this->student]);
    }
}
