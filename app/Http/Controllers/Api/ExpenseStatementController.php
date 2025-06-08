<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ExpenseStatement;
use Illuminate\Http\Request;

class ExpenseStatementController extends Controller
{
    // List all expense statements.
    public function index()
    {
        $statements = ExpenseStatement::with('application')->get();
        return response()->json($statements);
    }

    // Store a new expense statement.
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'application_id' => 'required|exists:applications,id',
            'total_grant_amount' => 'required|numeric',
            'total_expense' => 'required|numeric',
            'deductions' => 'required|numeric',
        ]);

        $statement = ExpenseStatement::create($validatedData);
        return response()->json($statement, 201);
    }

    // Show a specific expense statement.
    public function show($id)
    {
        $statement = ExpenseStatement::with('application')->findOrFail($id);
        return response()->json($statement);
    }

    // Update an expense statement.
    public function update(Request $request, $id)
    {
        $statement = ExpenseStatement::findOrFail($id);
        $statement->update($request->all());
        return response()->json($statement);
    }

    // Delete an expense statement.
    public function destroy($id)
    {
        $statement = ExpenseStatement::findOrFail($id);
        $statement->delete();
        return response()->json(null, 204);
    }
}
