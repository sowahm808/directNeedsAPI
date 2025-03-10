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
    public function generate(Request $request, $applicationId)
{
    $request->validate([
        'letter_type' => 'required|in:approval,denial,request_information',
    ]);

    $letterType = $request->letter_type;

    // Fetch Application Details
    $application = Application::with('applicant')->findOrFail($applicationId);

    // Determine view file based on letter type
    $viewFile = match ($letterType) {
        'approval' => 'emails.approval-letter',
        'denial' => 'emails.denial-letter',
        'request_information' => 'emails.request-information-letter',
        default => 'emails.approval-letter',
    };

    // Generate PDF
    $pdf = Pdf::loadView($viewFile, [
        'applicantName' => $application->applicant->name,
        'grantAmount' => $application->grant_amount ?? 'N/A',
        'approvalDate' => $application->approval_date ?? now()->toDateString()
    ]);

    // Save PDF and send email
    $fileName = "{$letterType}_letter_{$applicationId}.pdf";
    Storage::put("public/letters/$fileName", $pdf->output());
    $publicUrl = asset("storage/letters/$fileName");

    Mail::to($application->applicant->email)
        ->send(new ApprovalLetterMail($application->applicant->name, $publicUrl));

    return response()->json(['message' => ucfirst($letterType) . ' letter generated successfully', 'file_url' => $publicUrl]);
}
public function batchGenerate(Request $request)
{
    $applicationIds = $request->input('applicationIds');
    $letterType = $request->input('letterType');

    if (!$applicationIds || !in_array($letterType, ['approval', 'denial', 'request_info'])) {
        return response()->json(['message' => 'Invalid request'], 400);
    }

    $applications = Application::whereIn('id', $applicationIds)->get();

    foreach ($applications as $application) {
        // Generate PDF based on letter type
        $pdf = Pdf::loadView("emails.{$letterType}-letter", [
            'applicantName' => $application->applicant->name,
            'grantAmount' => $application->grant_amount,
            'approvalDate' => $application->approval_date
        ]);

        // Save and email
        $fileName = "{$letterType}_letter_{$application->id}.pdf";
        $filePath = "approval_letters/$fileName";
        Storage::put($filePath, $pdf->output());

        Mail::to($application->applicant->email)
            ->send(new ApprovalLetterMail($application->applicant->name, Storage::url($filePath)));
    }

    return response()->json(['message' => 'Letters generated and sent successfully.']);
}

}
