<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Auth routes
    Route::post('auth/login', [\App\Http\Controllers\Api\V1\AuthController::class, 'login']);
    Route::post('auth/logout', [\App\Http\Controllers\Api\V1\AuthController::class, 'logout'])->middleware('auth:sanctum');

    // Client recruitment requests
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('requests', \App\Http\Controllers\Api\V1\RecruitmentRequestController::class)->names('api.v1.requests');
        Route::get('requests/{request}/attachments', [\App\Http\Controllers\Api\V1\RequestAttachmentController::class, 'index'])->name('api.v1.requests.attachments.index');
        Route::post('requests/{request}/attachments', [\App\Http\Controllers\Api\V1\RequestAttachmentController::class, 'store'])->name('api.v1.requests.attachments.store');
        Route::delete('requests/{request}/attachments/{attachment}', [\App\Http\Controllers\Api\V1\RequestAttachmentController::class, 'destroy'])->name('api.v1.requests.attachments.destroy');
    });

    // Candidate endpoints
    Route::post('candidate/auth/login', [\App\Http\Controllers\Api\V1\CandidateAuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('candidate/applications', [\App\Http\Controllers\Api\V1\CandidateApplicationController::class, 'index'])->name('api.v1.candidate.applications.index');
        Route::get('candidate/applications/{application}', [\App\Http\Controllers\Api\V1\CandidateApplicationController::class, 'show'])->name('api.v1.candidate.applications.show');
    });

    // Admin endpoints
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::apiResource('clients', \App\Http\Controllers\Api\V1\ClientController::class)->names('api.v1.clients');
        Route::apiResource('candidates', \App\Http\Controllers\Api\V1\CandidateController::class)->names('api.v1.candidates');
        Route::post('applications/{application}/status', [\App\Http\Controllers\Api\V1\ApplicationStatusController::class, 'update'])->name('api.v1.applications.status.update');
    });
});

