<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CertificateAddMail extends Mailable implements ShouldQueue
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
        return $this->subject('E-sijil Baru Dikeluarkan')->markdown('emails.certificateadd')->with(['basicEmailDetails' => $this->basicEmailDetails, 'emailDetails' => $this->emailDetails]);
    }
}
