<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly string $recipientName,
        public readonly string $rentalTitle,
        public readonly string $newStatus,   // approved|rejected|pending
        public readonly ?string $messageForUser = null,
    ) {}

    public function build()
    {
        $subject = "Your request is {$this->newStatus} – {$this->rentalTitle}";
        return $this->subject($subject)
            ->view('emails.request-status-changed');
    }
}
