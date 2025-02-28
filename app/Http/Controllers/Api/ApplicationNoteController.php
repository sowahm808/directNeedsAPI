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
    
        // Attach the application_id from the route parameter
        $validatedData['application_id'] = $applicationId;
        $validatedData['user_id'] = auth()->id(); // Using authenticated user ID
    
        $note = ApplicationNote::create($validatedData);
        return response()->json($note, 201);
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
}
