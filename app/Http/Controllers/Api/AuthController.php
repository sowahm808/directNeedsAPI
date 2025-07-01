<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Services\FirebaseService;

class AuthController extends Controller
{
    // **Login with Email and Password**
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials. Please try again.'
            ], 401);
        }

        // Revoke all previous tokens (optional)
        $user->tokens()->delete();

        // Create a new token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Update remember_token if not set
        if (!$user->remember_token) {
            $user->remember_token = Str::random(60);
            $user->save();
        }

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'remember_token' => $user->remember_token
            ],
            'token' => $token
        ], 200);
    }

    // **Login using a Firebase ID token**
    public function loginWithFirebase(Request $request, FirebaseService $firebase)
    {
        $request->validate([
            'id_token' => 'required|string',
            'fcm_token' => 'sometimes|string',
        ]);

        $verified = $firebase->verifyIdToken($request->id_token);

        if (!$verified) {
            return response()->json(['message' => 'Invalid Firebase token'], 401);
        }

        $email = $verified->claims()->get('email');
        $name = $verified->claims()->get('name', $email);

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make(Str::random(12)),
                'role' => 'applicant',
                'remember_token' => Str::random(60),
            ]
        );

        if ($request->filled('fcm_token')) {
            $user->fcm_token = $request->fcm_token;
            $user->save();
        }

        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'remember_token' => $user->remember_token
            ],
            'token' => $token
        ], 200);
    }

    // **Sign-up with Email and Password**
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:supervisor,processor,administrator,auditor,applicant'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Convert 'admin' to 'administrator' if necessary
        $role = $request->role === 'admin' ? 'administrator' : $request->role;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
            'remember_token' => Str::random(60)
        ]);

        // Automatically log in the user after signup
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'remember_token' => $user->remember_token
            ],
            'token' => $token
        ], 201);
    }

    // **Google OAuth Redirect URL**
    public function redirectToGoogle()
    {
        return response()->json([
            'redirect_url' => Socialite::driver('google')->stateless()->redirect()->getTargetUrl()
        ]);
    }

    // **Handle Google Login Callback**
    public function handleGoogleCallback(Request $request)
{
    try {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Check if user already exists
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // Assign "applicant" as the default role for new Google users
            $defaultRole = 'applicant';

            // Create a new user
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => Hash::make(Str::random(12)), // Generate a random password
                'role' => $defaultRole, // Assign default role
                'remember_token' => Str::random(60),
                'google_id' => $googleUser->getId(),
            ]);
        }

        // Generate API Token
        $token = $user->createToken('auth_token')->plainTextToken;

        // ✅ Ensure the response **redirects to Angular frontend**
        return redirect()->to(env('FRONTEND_URL') . "/google-auth-success?token={$token}&role={$user->role}");

    } catch (\Exception $e) {
        return redirect()->to(env('FRONTEND_URL') . "/google-auth-failed?error=" . urlencode($e->getMessage()));
    }
}


    // **Logout and Revoke Token**
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }

    // **Get User Profile**
    public function userProfile(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }
}
