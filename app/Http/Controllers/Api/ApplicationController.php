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

}
