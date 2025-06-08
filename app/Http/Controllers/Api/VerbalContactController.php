<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VerbalContact;
use Illuminate\Http\Request;

class VerbalContactController extends Controller
{
    public function logContact(Request $request, $applicationId)
    {
        $validatedData = $request->validate([
            'processor_id' => 'required|exists:users,id',
            'contact_successful' => 'required|boolean',
            'contact_notes' => 'nullable|string'
        ]);

        $validatedData['application_id'] = $applicationId;

        try {
            $verbalContact = VerbalContact::create($validatedData);
            return response()->json($verbalContact, 201);
        } catch (\Exception $e) {
            \Log::error('Error Logging Verbal Contact', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Failed to log verbal contact. Please try again later.'
            ], 500);
        }
    }
}

