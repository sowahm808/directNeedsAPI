<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PartnershipsLetterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $application;

    /**
     * Create a new message instance.
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Partnerships and Community Support')
                    ->view('emails.partnerships-letter')
                    ->with([
                        'applicantName' => $this->application->applicant->name,
                        'grantAmount' => $this->application->grant_amount,
                        'approvalDate' => $this->application->approval_date
                    ]);
    }
}
