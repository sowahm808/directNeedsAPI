<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Communication;
use Illuminate\Http\Request;

class CommunicationController extends Controller
{
    // List all communications.
    public function index()
    {
        $communications = Communication::with('application')->get();
        return response()->json($communications);
    }

    // Store a new communication.
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'application_id' => 'required|exists:applications,id',
            'type' => 'required|in:approval_letter,state_resources,partnerships',
            'subject' => 'nullable|string',
            'message' => 'nullable|string',
            'sent_date' => 'nullable|date',
        ]);

        $communication = Communication::create($validatedData);
        return response()->json($communication, 201);
    }

    // Show a specific communication.
    public function show($id)
    {
        $communication = Communication::with('application')->findOrFail($id);
        return response()->json($communication);
    }

    // Update a communication.
    public function update(Request $request, $id)
    {
        $communication = Communication::findOrFail($id);
        $communication->update($request->all());
        return response()->json($communication);
    }

    // Delete a communication.
    public function destroy($id)
    {
        $communication = Communication::findOrFail($id);
        $communication->delete();
        return response()->json(null, 204);
    }
}
