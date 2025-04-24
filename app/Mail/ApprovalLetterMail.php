<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApprovalLetterMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $applicantName;
    public ?string $pdfPath;
    public ?string $customBody;
    public ?string $subjectLine;

    public function __construct(string $applicantName, ?string $pdfPath = null, ?string $customBody = null, ?string $subjectLine = 'Approval Letter')
    {
        $this->applicantName = $applicantName;
        $this->pdfPath = $pdfPath;
        $this->customBody = $customBody;
        $this->subjectLine = $subjectLine;
    }

    public function build()
    {
        $mail = $this->view('emails.approval-letter')
                     ->subject($this->subjectLine)
                     ->with([
                         'applicantName' => $this->applicantName,
                         'customBody' => $this->customBody,
                     ]);

        if ($this->pdfPath) {
            $mail->attach($this->pdfPath, [
                'as' => 'ApprovalLetter.pdf',
                'mime' => 'application/pdf',
            ]);
        }

        return $mail;
    }
}
