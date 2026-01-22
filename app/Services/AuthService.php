<?php

namespace App\Services;

use App\Contracts\Services\AuthServiceInterface;
use App\Exceptions\Auth\CandidateAuthException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{
    public function login(string $email, string $password): User
    {
        $user = User::where('email', $email)->first();
        if (!$user || !Hash::check($password, $user->password)) {
            throw new CandidateAuthException('Invalid credentials', ['email' => $email]);
        }

        return $user;
    }
}

