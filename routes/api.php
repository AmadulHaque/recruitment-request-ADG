<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompanyJobController;
use App\Http\Controllers\Api\CandidateProfileController;
use App\Http\Controllers\Api\AdminUserController;
use App\Http\Controllers\Api\JobApplicationController;

Route::prefix('auth')->group(function () {
    Route::post('company/register', [AuthController::class, 'registerCompany']);
    Route::post('company/login', [AuthController::class, 'loginCompany']);
    Route::post('candidate/login', [AuthController::class, 'loginCandidate']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::middleware(['auth:sanctum', 'role:company'])->prefix('company')->group(function () {
    Route::get('jobs', [CompanyJobController::class, 'index']);
    Route::post('jobs', [CompanyJobController::class, 'store']);
    Route::get('jobs/{job}', [CompanyJobController::class, 'show']);
    Route::put('jobs/{job}', [CompanyJobController::class, 'update']);
    Route::patch('jobs/{job}/status', [CompanyJobController::class, 'updateStatus']);
    Route::get('jobs/{job}/applicants', [CompanyJobController::class, 'applicants']);
});

Route::middleware(['auth:sanctum', 'role:candidate'])->prefix('candidate')->group(function () {
    Route::get('profile', [CandidateProfileController::class, 'show']);
    Route::post('profile', [CandidateProfileController::class, 'store']);
    Route::put('profile', [CandidateProfileController::class, 'update']);
    Route::post('apply/{job}', [JobApplicationController::class, 'apply']);
    Route::get('applications', [JobApplicationController::class, 'index']);
});

Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('applications/{application}', [JobApplicationController::class, 'show']);
    Route::patch('applications/{application}/status', [JobApplicationController::class, 'updateStatus']);
    Route::patch('applications/{application}/schedule', [JobApplicationController::class, 'scheduleInterview']);
    Route::patch('applications/{application}/final', [JobApplicationController::class, 'finalize']);
    
    // User Management
    Route::put('users/{user}', [AdminUserController::class, 'update']);
});

