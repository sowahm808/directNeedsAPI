<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function index()
    {
        return User::all(['id', 'name', 'email', 'role']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:applicant,processor,admin,auditor',
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return response()->json(['message' => 'User role updated successfully.']);
    }
}
