<?php

namespace App\Services;

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function registerCompany(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => UserRole::COMPANY,
            ]);

            $company = Company::create([
                'user_id' => $user->id,
                'company_name' => $data['company_name'],
                'website' => $data['website'] ?? null,
                'location' => $data['location'] ?? null,
            ]);

            $token = $user->createToken('company-api')->plainTextToken;

            return ['user' => $user, 'company' => $company, 'token' => $token];
        });
    }

    public function loginCompany(string $email, string $password): array
    {
        $user = User::where('email', $email)->where('role', UserRole::COMPANY)->first();
        if (!$user || !Hash::check($password, $user->password)) {
            abort(422, 'Invalid credentials');
        }
        $token = $user->createToken('company-api')->plainTextToken;
        return ['user' => $user, 'token' => $token];
    }

    public function loginCandidate(string $email, string $password): array
    {
        $user = User::where('email', $email)->where('role', UserRole::CANDIDATE)->first();
        if (!$user || !Hash::check($password, $user->password)) {
            abort(422, 'Invalid credentials');
        }
        $token = $user->createToken('candidate-api')->plainTextToken;
        return ['user' => $user, 'token' => $token];
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()?->delete();
    }
}

