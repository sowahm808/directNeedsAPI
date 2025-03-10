<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
class ApplicationController extends Controller
{
    public function index()
    {
        // return response()->json(['message' => 'Applications index working']);

        $applications = Application::with(['applicant', 'processor'])->get();
        return response()->json($applications);


    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
        'applicant_id' => 'required|exists:users,id',
        'name' => 'required|string|max:255',
        'address' => 'nullable|string|max:255',
        'apartment' => 'nullable|string|max:100',
        'city' => 'nullable|string|max:100',
        'state' => 'nullable|string|max:100',
        'zip' => 'nullable|string|max:20',
        'phone' => 'required|string|max:15',
        'email' => 'required|email|max:255',
        'role' => 'required|string|in:Parent,Caregiver,Guardian,Other',
        'childrenCount' => 'required|integer|min:0',
        'childrenDetails' => 'nullable|string',
        'assistanceNeeded' => 'required|array',
        'assistanceNeeded.*' => 'string',
        'snapBenefits' => 'required|boolean',
        'circumstanceDetails' => 'nullable|string',
        'essentialNeeds' => 'required|array',
        'essentialNeeds.*' => 'string',
        'essentialCircumstances' => 'nullable|string',
        'supportingDocuments' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

         // Handle file upload
    if ($request->hasFile('supportingDocuments')) {
        $validatedData['supportingDocuments'] = $request->file('supportingDocuments')->store('documents');
    }
        $application = Application::create($validatedData);
        return response()->json($application, 201);
    }

    public function show($id)
    {
        $application = Application::with([
            'applicant',
            'processor',
            'notes',
            'diaryReminders',
            'payments',
            'communications',
            'auditLogs'
        ])->findOrFail($id);
        return response()->json($application);
    }

    public function update(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        $application->update($request->all());
        return response()->json($application);
    }

    public function destroy($id)
    {
        $application = Application::findOrFail($id);
        $application->delete();
        return response()->json(null, 204);
    }

    public function getByStatus($status)
{
    $validStatuses = ['submitted', 'processing', 'first_contact', 'approved', 'denied', 'closed'];

    if (!in_array($status, $validStatuses)) {
        return response()->json(['message' => 'Invalid status'], 400);
    }

    $applications = Application::where('status', $status)->get();
    return response()->json($applications);
}

public function closeFile($applicationId)
{
    try {
        $application = Application::findOrFail($applicationId);

        if ($application->status !== 'approved') {
            return response()->json(['error' => 'Only approved applications can be closed.'], 403);
        }

        $application->status = 'closed';
        $application->save();

        return response()->json(['message' => 'File closed successfully']);
    } catch (\Exception $e) {
        \Log::error('Error closing file', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'Failed to close file. Please try again later.'], 500);
    }
}
public function addExceptionReason(Request $request, $applicationId)
{
    $validatedData = $request->validate([
        'reason' => 'required|string',
    ]);

    $application = Application::findOrFail($applicationId);
    $application->exception_reason = $validatedData['reason'];
    $application->save();

    return response()->json(['message' => 'Reason added successfully']);
}



}
