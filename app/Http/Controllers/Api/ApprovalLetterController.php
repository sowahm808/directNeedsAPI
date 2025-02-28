<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\ApprovalLetterMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ApprovalLetterController extends Controller
{
    public function generate($applicationId)
    {
        try {
            // Fetch Application Details
            $application = Application::with('applicant')->findOrFail($applicationId);

            // Generate PDF
            $pdf = Pdf::loadView('emails.approval-letter', [
                'applicantName' => $application->applicant->name,
                'grantAmount' => $application->grant_amount,
                'approvalDate' => $application->approval_date
            ]);

                    // Ensure Directory Exists
            $directory = storage_path('app/public/storage/approval_letters');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            // Save PDF to Storage
            $fileName = "approval_letter_{$applicationId}.pdf";
            $filePath = "app/public/storage/approval_letters/$fileName";
             // Check if directory exists, if not create it
            if (!file_exists(storage_path('app/public/approval_letters'))) {
            mkdir(storage_path('app/public/approval_letters'), 0755, true);
            }

            // Save using Laravel Storage
            Storage::put($filePath, $pdf->output());

            // Get public URL
            $publicUrl = Storage::url($filePath);

            // Send Email with the public URL as attachment
            Mail::to($application->applicant->email)
                ->send(new ApprovalLetterMail($application->applicant->name, $publicUrl));

                // Return URL to access the PDF
            $publicUrl = asset("storage/storage/approval_letters/$fileName");
            return response()->json(['message' => 'Approval letter generated and sent successfully','url' => $publicUrl]);


        } catch (\Exception $e) {
            \Log::error('Error generating approval letter', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Failed to generate approval letter. Please try again later.'
            ], 500);
        }
    }
}

