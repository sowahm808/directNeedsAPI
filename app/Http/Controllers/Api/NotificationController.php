<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\StateResourcesMail;
use App\Models\Application;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Services\FirebaseService;

class NotificationController extends Controller
{
    protected FirebaseService $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }
    /**
     * Send State Resources Letter
     */
    public function sendStateResourcesLetter($applicationId)
    {
        $application = Application::with('applicant')->findOrFail($applicationId);

        Mail::to($application->applicant->email)
            ->send(new StateResourcesMail($application));

        if ($application->applicant->fcm_token) {
            $this->firebase->sendPush([
                $application->applicant->fcm_token
            ], 'New Letter Available', 'A state resources letter was sent to you.');
        }

        return response()->json(['message' => 'State Resources Letter sent successfully.']);
    }
}

