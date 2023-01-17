<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoginWithTokenMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $mailable;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $mailable)
    {
        $this->mailable = $mailable;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.login-with-token-mail')
            ->subject("[".config('app.name')."] - ".$this->mailable['subject'])
            ->with('mailable', $this->mailable);
    }
}
