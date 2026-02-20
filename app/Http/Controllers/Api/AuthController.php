<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CompanyRegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService)
    {
    }

    public function registerCompany(CompanyRegisterRequest $request)
    {
        $data = $this->authService->registerCompany($request->validated());
        return response()->json([
            'success' => true,
            'token' => $data['token'],
            'user' => [
                'id' => $data['user']->id,
                'name' => $data['user']->name,
                'email' => $data['user']->email,
                'role' => $data['user']->role->value,
            ],
            'company' => [
                'id' => $data['company']->id,
                'company_name' => $data['company']->company_name,
            ],
        ], 201);
    }

    public function loginCompany(LoginRequest $request)
    {
        $v = $request->validated();
        $payload = $this->authService->loginCompany($v['email'], $v['password']);
        return response()->json([
            'success' => true,
            'token' => $payload['token'],
            'user' => [
                'id' => $payload['user']->id,
                'name' => $payload['user']->name,
                'email' => $payload['user']->email,
                'role' => $payload['user']->role->value,
            ],
        ]);
    }

    public function loginCandidate(LoginRequest $request)
    {
        $v = $request->validated();
        $payload = $this->authService->loginCandidate($v['email'], $v['password']);
        return response()->json([
            'success' => true,
            'token' => $payload['token'],
            'user' => [
                'id' => $payload['user']->id,
                'name' => $payload['user']->name,
                'email' => $payload['user']->email,
                'role' => $payload['user']->role->value,
            ],
        ]);
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());
        return response()->json(['success' => true]);
        }
}
