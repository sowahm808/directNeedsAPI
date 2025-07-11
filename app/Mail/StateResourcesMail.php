<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StateResourcesMail extends Mailable
{
    use Queueable, SerializesModels;

    public $application;

    /**
     * Create a new message instance.
     *
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('State Resources Assistance')
                    ->view('emails.state-resources')
                    ->with([
                        'applicantName' => $this->application->applicant->name,
                        'grantAmount' => $this->application->grant_amount,
                        'approvalDate' => $this->application->approval_date,
                    ]);
    }
    
}
