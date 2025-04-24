<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::with(['applicant', 'processor', 'payments', 'notes'])->get();
        return response()->json($applications);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'applicant_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'street_address' => 'nullable|string|max:255',
            'apartment' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip' => 'nullable|string|max:20',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'role' => 'required|string|in:Grand Parent,Caregiver,Guardian,Other',
            'children_count' => 'required|integer|min:0',
            'children_details' => 'nullable|string',
            'assistance_needed' => 'required|array',
            'assistance_needed.*' => 'string',
            'snap_benefits' => 'required|boolean',
            'circumstance_details' => 'nullable|string',
            'essential_needs' => 'required|array',
            'essential_needs.*' => 'string',
            'essential_circumstances' => 'nullable|string',
            'supporting_documents' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);

        // Convert arrays to JSON for DB storage
        $validatedData['assistance_needed'] = json_encode($validatedData['assistance_needed']);
        $validatedData['essential_needs'] = json_encode($validatedData['essential_needs']);

        // Handle file upload
        if ($request->hasFile('supporting_documents')) {
            $validatedData['supporting_documents'] = $request->file('supporting_documents')->store('documents');
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

    public function getByUser($userId)
    {
        $application = Application::with(['applicant'])
            ->where('applicant_id', $userId)
            ->latest()
            ->first();

        if (!$application) {
            return response()->json(['message' => 'No application found'], 404);
        }

        $application->assistance_needed = json_decode($application->assistance_needed ?? '[]', true);
        $application->essential_needs = json_decode($application->essential_needs ?? '[]', true);

        return response()->json($application);
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

    public function getLatestForAuthenticatedUser(Request $request)
    {
        \Log::info('User accessed /applications/mine', ['user_id' => $request->user()->id]);

        $user = $request->user(); // gets the currently logged in user

        $application = Application::where('applicant_id', $user->id)
            ->latest()
            ->first();

        if ($application) {
            $application->assistance_needed = is_string($application->assistance_needed)
                ? json_decode($application->assistance_needed, true)
                : $application->assistance_needed;

            $application->essential_needs = is_string($application->essential_needs)
                ? json_decode($application->essential_needs, true)
                : $application->essential_needs;
        }

        return response()->json($application);
    }

}
