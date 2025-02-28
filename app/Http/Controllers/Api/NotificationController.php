<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\StateResourcesMail;
use App\Models\Application;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Send State Resources Letter
     */
    public function sendStateResourcesLetter($applicationId)
    {
        $application = Application::with('applicant')->findOrFail($applicationId);

        Mail::to($application->applicant->email)
            ->send(new StateResourcesMail($application));

        return response()->json(['message' => 'State Resources Letter sent successfully.']);
    }
}

