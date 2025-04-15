<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ApplicationNote;
use Illuminate\Http\Request;

class ApplicationNoteController extends Controller
{
    public function index()
    {
        $notes = ApplicationNote::with(['application', 'user'])->get();
        return response()->json($notes);
    }

    public function store(Request $request, $applicationId)
{
    $validatedData = $request->validate([
        'note_type' => 'required|in:initial,follow_up,contact,approval,other',
        'note' => 'required|string',
        'user_id' => 'required|exists:users,id'
    ]);

    // Fetch the application
    $application = \App\Models\Application::find($applicationId);
    if (!$application) {
        return response()->json(['message' => 'Application not found'], 404);
    }

    // Set the application_id from the route parameter
    $validatedData['application_id'] = $applicationId;
    $validatedData['user_id'] = auth()->id(); // Using authenticated user ID

    // Create the note
    $note = ApplicationNote::create($validatedData);

    // ** Update Application based on note type **
    if ($validatedData['note_type'] === 'approval') {
        $application->status = 'approved';
        $application->approval_date = now();
    } elseif ($validatedData['note_type'] === 'follow_up') {
        $application->status = 'processing';
    } elseif ($validatedData['note_type'] === 'contact') {
        $application->status = 'first_contact';
    }

    // Save the updated application
    $application->save();

    return response()->json([
        'message' => 'Note added successfully',
        'note' => $note,
        'updated_application' => $application
    ], 201);
}



    public function getNotesByApplicationId($applicationId)
{
    try {
        // Ensure the application exists
        $notes = ApplicationNote::where('application_id', $applicationId)
            ->with('user:id,name') // Only fetch relevant fields
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($notes);
    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Error fetching notes: ' . $e->getMessage());

        return response()->json([
            'message' => 'Failed to retrieve notes. Please try again later.'
        ], 500);
    }
}
    public function show($id)
    {
        $note = ApplicationNote::with(['application', 'user'])->findOrFail($id);
        return response()->json($note);
    }

    public function update(Request $request, $id)
    {
        // Find the note or return 404 if not found
        $note = ApplicationNote::findOrFail($id);

        // Validate the incoming request data
        $validatedData = $request->validate([
            'note_type' => 'required|in:overview,information_request,follow_up',
            'note' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'application_id' => 'required|exists:applications,id'
        ]);

        // Update the note with validated data
        $note->update($validatedData);

        // Return the updated note as JSON
        return response()->json($note);
    }


    public function destroy($id)
    {
        $note = ApplicationNote::findOrFail($id);
        $note->delete();
        return response()->json(null, 204);
    }

    public function applicationsByProcessor($processorId)
{
    try {
        // Get all distinct application IDs where the processor added notes
        $applicationIds = ApplicationNote::where('user_id', $processorId)
            ->pluck('application_id')
            ->unique();

        // Load full application details including notes and payments
        $applications = \App\Models\Application::with(['notes', 'payments'])
            ->whereIn('id', $applicationIds)
            ->get();

        return response()->json($applications);
    } catch (\Exception $e) {
        \Log::error('Error fetching applications by processor notes: ' . $e->getMessage());
        return response()->json([
            'message' => 'Failed to fetch applications. Try again later.'
        ], 500);
    }
}

}
