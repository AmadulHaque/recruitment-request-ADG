<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $userRole = $user->role instanceof \UnitEnum ? $user->role->value : (string) $user->role;
        $allowed = in_array($userRole, $roles, true);

        if (!$allowed) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
