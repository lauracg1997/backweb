<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\FormSubmissionController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;

// ── Públicas (sin auth) ──────────────────────────────────────────────────────
Route::middleware('throttle:login')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendCode']);
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);
});

// Formulario web público (leads externos rellenan desde la web)
Route::middleware('throttle:form')->post(
    'form-submissions',
    [FormSubmissionController::class, 'store']
);

// ── Protegidas con Sanctum ───────────────────────────────────────────────────
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {

    Route::get('/user', fn(Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('activity-logs', [ActivityLogController::class, 'index']);

    Route::post('users/upload', [UserController::class, 'upload']);
    Route::apiResource('users', UserController::class)->except(['show']);

    Route::post('resources/upload', [ResourceController::class, 'upload']);
    Route::post('posts/upload', [ResourceController::class, 'upload']);
    Route::apiResource('resources', ResourceController::class)->except(['show']);
    Route::apiResource('posts', PostController::class)->except(['show']);

    Route::apiResource('leads', LeadController::class)->except(['show']);
    Route::apiResource('candidates', CandidateController::class)->except(['show']);

    Route::apiResource('campaigns', CampaignController::class)->except(['show']);
    Route::post('campaigns/{campaign}/send', [CampaignController::class, 'send']);

    Route::apiResource('newsletters', NewsletterController::class)->except(['show']);
    Route::post('newsletters/{newsletter}/send', [NewsletterController::class, 'send']);

    Route::apiResource('form-submissions', FormSubmissionController::class)
        ->only(['index', 'update', 'destroy']);

    Route::get('settings', [SettingsController::class, 'index']);
    Route::post('settings', [SettingsController::class, 'store']);
    Route::post('settings/test-smtp', [SettingsController::class, 'testSmtp']);
});
