<?php

use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\ApplicationNoteController;
use App\Http\Controllers\Api\DiaryReminderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\CommunicationController;
use App\Http\Controllers\Api\VerbalContactController;
use App\Http\Controllers\Api\ExpenseStatementController;
use App\Http\Controllers\Api\FirstContactController;
use App\Http\Controllers\Api\ApprovalLetterController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\AuditLogController;
use App\Http\Controllers\Api\UserRoleController;
use App\Http\Controllers\Api\AuthController;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;
use Illuminate\Support\Facades\Route;

// CSRF Route
Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);

// Public Authentication Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'signup']);
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

// Protected Routes with Sanctum Middleware
Route::middleware('auth:sanctum')->group(function () {

    // User Profile & Logout
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);

    // Application Management
    Route::apiResource('applications', ApplicationController::class);
    Route::get('applications/status/{status}', [ApplicationController::class, 'getByStatus']);
    Route::patch('applications/{applicationId}/close-file', [ApplicationController::class, 'closeFile']);
    Route::post('applications/{applicationId}/exception-reason', [ApplicationController::class, 'addExceptionReason']);
    Route::get('/applications/notes-by-processor/{processorId}', [ApplicationNoteController::class, 'applicationsByProcessor']);

    // State Resources Letter Route
    Route::post('notifications/applications/{applicationId}/state-resources', [NotificationController::class, 'sendStateResourcesLetter']);

    //Notes
    Route::prefix('applications/{applicationId}')->group(function () {
        Route::get('notes', [ApplicationNoteController::class, 'getNotesByApplicationId']);
        Route::post('notes', [ApplicationNoteController::class, 'store']); // This is the POST route
        Route::get('notes/{id}', [ApplicationNoteController::class, 'show']);
        Route::patch('notes/{id}', [ApplicationNoteController::class, 'update']);
        Route::delete('notes/{id}', [ApplicationNoteController::class, 'destroy']);
    });


    Route::prefix('applications/{applicationId}/first-contacts')->group(function () {
        Route::post('/', [FirstContactController::class, 'schedule']);
        Route::patch('{id}/status', [FirstContactController::class, 'updateStatus']);
    });

    // Verbal Contact Logging
    Route::prefix('applications/{applicationId}/verbal-contacts')->group(function () {
        Route::post('/', [VerbalContactController::class, 'logContact']);
    });

    // Approval Letter
    Route::prefix('applications/{applicationId}/approval-letter')->group(function () {
    Route::get('generate', [ApprovalLetterController::class, 'generate']);
    // Letter Generation Routes
    Route::post('applications/generate-letters', [ApprovalLetterController::class, 'batchGenerate']);
});

    // Diary Reminders
    Route::apiResource('diary-reminders', DiaryReminderController::class);


    // Payment Routes
    Route::prefix('applications/{applicationId}/payments')->group(function () {
    Route::get('/', [PaymentController::class, 'index']);
    Route::post('/', [PaymentController::class, 'store']);
    });

    // Communications
    Route::apiResource('communications', CommunicationController::class);

    // Expense Statements
    Route::apiResource('expense-statements', ExpenseStatementController::class);

    // Audit Logs
    Route::apiResource('audit-logs', AuditLogController::class);

    // User Role Management
    Route::get('/users', [UserRoleController::class, 'index']);
    Route::put('/users/{id}/role', [UserRoleController::class, 'update']);
});
