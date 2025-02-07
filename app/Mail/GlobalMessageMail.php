<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GlobalMessageMail extends Mailable
{
    use SerializesModels;

    public $messageContent;

    public function __construct($message)
    {
        $this->messageContent = $message;
    }

    public function build()
    {
        return $this->subject('Global Message from Admin')
                    ->view('emails.global_message'); // Blade view for email content
    }
}
