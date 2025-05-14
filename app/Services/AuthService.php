<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    // Register a new user and issue an API token.
    public function register(array $data): array
    {
        $user = User::create($data);

        return [
            'user' => $user,
            'token' => $user->createToken('api_token')->plainTextToken,
        ];
    }

    /**
     * Authenticate user and return API token.
     *
     * @throws ValidationException if credentials are invalid
     */
    public function login(array $credentials): array
    {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
               'message' => ['The provided credentials are invalid.'],
            ]);
        }

        return [
            'user' => $user,
            'token' => $user->createToken('api_token')->plainTextToken,
        ];
    }

    // delete the current access token (logout from current device).
    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }

    // delete all tokens (logout from all devices).
    public function logoutFromAllDevices(User $user): void
    {
        $user->tokens()->delete();
    }
}
