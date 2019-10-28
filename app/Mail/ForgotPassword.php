<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    private $id;
    private $token;

    public function __construct($id, $token)
    {
        $this->id = $id;
        $this->token = $token;
    }

    public function build()
    {
        return $this->markdown('emails.forgot-password')->with([
            'id' => $this->id,
            'token' => $this->token,
        ]);
    }
}
