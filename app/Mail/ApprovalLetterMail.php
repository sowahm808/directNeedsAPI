<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApprovalLetterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $applicantName;
    public $filePath;

    public function __construct($applicantName, $filePath)
    {
        $this->applicantName = $applicantName;
        $this->filePath = $filePath;
    }

    public function build()
    {
        return $this->view('emails.approval-letter')
                    ->subject('Your Approval Letter')
                    ->attach($this->filePath, [
                        'as' => 'Approval_Letter.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
//     public function build()
// {
//     return $this->view('emails.approval-letter')
//                 ->subject('Approval Letter')
//                 ->attach(public_path('storage/approval_letters/'.$this->fileName));
// }

}
