<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    // List all audit logs.
    public function index()
    {
        $logs = AuditLog::with(['user', 'application'])->get();
        return response()->json($logs);
    }

    // Store a new audit log.
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'application_id' => 'nullable|exists:applications,id',
            'action' => 'required|string',
            'details' => 'nullable|string',
        ]);

        $log = AuditLog::create($validatedData);
        return response()->json($log, 201);
    }

    // Show a specific audit log.
    public function show($id)
    {
        $log = AuditLog::with(['user', 'application'])->findOrFail($id);
        return response()->json($log);
    }

    // Update an audit log.
    public function update(Request $request, $id)
    {
        $log = AuditLog::findOrFail($id);
        $log->update($request->all());
        return response()->json($log);
    }

    // Delete an audit log.
    public function destroy($id)
    {
        $log = AuditLog::findOrFail($id);
        $log->delete();
        return response()->json(null, 204);
    }
}
