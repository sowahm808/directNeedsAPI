<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'application_id' => 'required|exists:applications,id',
            'user_id' => 'required|exists:users,id',
            'payment_type' => 'required|in:service_provider,applicant',
            'amount' => 'required|numeric|min:1',
            'recipient_name' => 'required|string',
            'recipient_account' => 'required|string',
        ]);

        try {
            $payment = Payment::create($validatedData);

            // Log Audit
            AuditLog::create([
                'user_id' => $validatedData['user_id'],
                'action' => 'Payment Processed',
                'details' => "Processed payment of {$validatedData['amount']} to {$validatedData['recipient_name']}"
            ]);

            return response()->json(['message' => 'Payment processed successfully', 'payment' => $payment], 201);
        } catch (\Exception $e) {
            \Log::error('Payment Processing Error: ' . $e->getMessage());
            return response()->json(['message' => 'Payment processing failed'], 500);
        }
    }

    public function index($applicationId)
    {
        $payments = Payment::where('application_id', $applicationId)->get();
        return response()->json($payments);
    }
}
