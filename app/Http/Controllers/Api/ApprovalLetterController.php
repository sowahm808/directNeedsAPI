<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\ApprovalLetterMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ApprovalLetterController extends Controller
{
    public function generate(Request $request, $applicationId)
    {
        try {
            $request->validate([
                'letter_type' => 'required|in:approval,denial,request_information',
            ]);

            $letterType = $request->letter_type;

            $application = Application::with('applicant')->findOrFail($applicationId);

            if (!$application->applicant) {
                return response()->json(['message' => 'Applicant not found.'], 404);
            }

            // Prepare dynamic values
            $applicantName = $application->applicant->name;
            $grantAmount = (float) ($application->grant_amount ?? 0);
            $approvalDate = $application->approval_date
                ? \Carbon\Carbon::parse($application->approval_date)->format('Y-m-d')
                : now()->format('Y-m-d');
            $assistanceCategory = $application->assistance_category ?? 'General Assistance';

            $viewFile = match ($letterType) {
                'approval' => 'emails.approval-letter',
                'denial' => 'emails.denial-letter',
                'request_information' => 'emails.request-information-letter',
            };

            // Log input
            Log::info("Generating {$letterType} letter for Application #{$applicationId}");

            $html = view($viewFile, compact(
                'applicantName',
                'grantAmount',
                'approvalDate',
                'assistanceCategory'
            ))->render();

            $pdf = Pdf::loadHTML($html);

            $fileName = "{$letterType}_letter_{$applicationId}.pdf";
            $relativePath = "public/approval_letters/{$fileName}";
            $publicUrl = asset("storage/approval_letters/{$fileName}");

            // Save the file using Laravel's storage facade (makes checking existence more reliable)
            Storage::put($relativePath, $pdf->output());

            if (!Storage::exists($relativePath)) {
                throw new \Exception("PDF file not saved at expected path.");
            }

            // Send the PDF URL via email
            Mail::to($application->applicant->email)
                ->send(new ApprovalLetterMail($applicantName, $publicUrl));

            return response()->json([
                'message' => ucfirst($letterType) . ' letter generated successfully',
                'file_url' => $publicUrl
            ]);

        } catch (\Exception $e) {
            Log::error('Approval letter generation failed', [
                'error' => $e->getMessage(),
                'application_id' => $applicationId
            ]);

            return response()->json([
                'message' => 'Failed to generate letter.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function draft($applicationId)
    {
        $application = Application::with('applicant')->findOrFail($applicationId);

        return response()->json([
            'subject' => 'Approval Letter',
            'assistanceCategory' => $application->assistance_category ?? 'General Assistance',
            'body' => view('emails.approval-letter', [
                'applicantName' => $application->applicant->name,
                'grantAmount' => (float) ($application->grant_amount ?? 0),
                'approvalDate' => $application->approval_date ?? now()->toDateString(),
                'assistanceCategory' => $application->assistance_category ?? 'General Assistance',
                'custom' => true
            ])->render()
        ]);
    }

    public function send(Request $request, $applicationId)
    {
        $request->validate([
            'subject' => 'required|string',
            'body' => 'required|string',
        ]);

        $application = Application::with('applicant')->findOrFail($applicationId);

        Mail::to($application->applicant->email)
            ->send(new ApprovalLetterMail(
                $application->applicant->name,
                null,
                $request->body,
                $request->subject
            ));

        return response()->json(['message' => 'Letter sent successfully']);
    }

    public function batchGenerate(Request $request)
    {
        $validated = $request->validate([
            'applicationIds' => 'required|array',
            'letterType' => 'required|in:approval,denial,request_info'
        ]);

        $applications = Application::with('applicant')->whereIn('id', $validated['applicationIds'])->get();

        foreach ($applications as $application) {
            $pdf = Pdf::loadView('emails.approval-letter', [
                'applicantName' => $application->applicant->name,
                'grantAmount' => (float) ($application->grant_amount ?? 0),
                'approvalDate' => $application->approval_date ?? now()->toDateString(),
                'assistanceCategory' => $application->assistance_category ?? 'General Assistance',
                'customBody' => $request->custom_body ?? null,
            ]);

            $fileName = "{$validated['letterType']}_letter_{$application->id}.pdf";
            Storage::put("public/approval_letters/{$fileName}", $pdf->output());

            Mail::to($application->applicant->email)
                ->send(new ApprovalLetterMail(
                    $application->applicant->name,
                    asset("storage/approval_letters/{$fileName}")
                ));
        }

        return response()->json(['message' => 'Letters generated and sent successfully.']);
    }
}
