<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RestPasswordMail extends Mailable
{
    use Queueable, SerializesModels;
    public $msg;

    /**
     * Create a new msg instance.
     *
     * @return void
     */
    public function __construct($msg)
    {
        $this->msg = $msg;
    }

    /**
     * Build the msg.
     *
     * @return $this
     */
    public function build()
    {
        $msg = $this->msg;

        return $this->subject('المرصد')
            ->view('mails.forget_password', compact('msg'));
    }
}
