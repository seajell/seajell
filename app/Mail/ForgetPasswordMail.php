<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgetPasswordMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $basicEmailDetails;
    public $emailDetails;

    public function __construct($basicEmailDetails, $emailDetails)
    {
        $this->basicEmailDetails = $basicEmailDetails;
        $this->emailDetails = $emailDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Lupa Kata Laluan')->markdown('emails.forgetpassword')->with(['basicEmailDetails' => $this->basicEmailDetails, 'emailDetails' => $this->emailDetails]);
    }
}
