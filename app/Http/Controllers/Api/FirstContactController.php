<?php

namespace App\Http\Controllers\API;

use App\Models\FirstContact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class FirstContactController extends Controller
{
    public function schedule(Request $request, $applicationId)
{
    $validatedData = $request->validate([
        'contact_date' => 'required|date',
        'contact_method' => 'required|string',
        'processor_id' => 'required|exists:users,id'
    ]);

    // Attach the application_id from the route parameter
    $validatedData['application_id'] = $applicationId;

    try {
        $firstContact = FirstContact::create($validatedData);
        return response()->json($firstContact, 201);
    } catch (\Exception $e) {
        // Log the error for debugging
        Log::error('Error Scheduling First Contact', ['error' => $e->getMessage()]);
        return response()->json([
            'message' => 'Failed to schedule first contact. Please try again later.'
        ], 500);
    }
}

    

public function updateStatus(Request $request, $id)
{
    $firstContact = FirstContact::findOrFail($id);
    $firstContact->update($request->only('status', 'decision_outcome'));

    return response()->json($firstContact);
}

}
