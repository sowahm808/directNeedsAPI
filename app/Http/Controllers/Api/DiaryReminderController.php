<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DiaryReminder;
use Illuminate\Http\Request;

class DiaryReminderController extends Controller
{
    // List all diary reminders.
    public function index()
    {
        $reminders = DiaryReminder::with(['application', 'user'])->get();
        return response()->json($reminders);
    }

    // Create a new diary reminder.
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'application_id' => 'required|exists:applications,id',
            'user_id' => 'required|exists:users,id',
            'reminder_date' => 'required|date',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,completed',
        ]);

        $reminder = DiaryReminder::create($validatedData);
        return response()->json($reminder, 201);
    }

    // Show a specific diary reminder.
    public function show($id)
    {
        $reminder = DiaryReminder::with(['application', 'user'])->findOrFail($id);
        return response()->json($reminder);
    }

    // Update a diary reminder.
    public function update(Request $request, $id)
    {
        $reminder = DiaryReminder::findOrFail($id);
        $reminder->update($request->all());
        return response()->json($reminder);
    }

    // Delete a diary reminder.
    public function destroy($id)
    {
        $reminder = DiaryReminder::findOrFail($id);
        $reminder->delete();
        return response()->json(null, 204);
    }
}
