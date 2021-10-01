<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CertificateAddMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
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
        return $this->markdown('emails.certificateadd')->with(['basicEmailDetails' => $this->basicEmailDetails, 'emailDetails' => $this->emailDetails]);
    }
}
