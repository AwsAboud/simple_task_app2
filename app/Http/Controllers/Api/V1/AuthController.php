<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\LoginUserRequest;
use App\Http\Requests\User\Auth\RegisterUserRequest;
use App\Http\Resources\User\UserResource;

class AuthController extends Controller
{
    
     public function __construct(private AuthService $authService) {}
     
    /**
     * Register a new user and return an auth token.
     */
    public function register(RegisterUserRequest $request)
    {
        ['user' => $user, 'token' => $token] = $this->authService->register($request->validated());

        return $this->successResponse([
            'user' => new UserResource($user),
            'token' => $token,
        ], 'Registered successfully');
    }

    /**
     * Login and return token with user data.
     */
    public function login(LoginUserRequest $request)
    {
        ['user' => $user, 'token' => $token] = $this->authService->login($request->validated());

        return $this->successResponse([
            'user' => new UserResource($user),
            'token' => $token,
        ], 'Logged in successfully');
    }

    /**
     * Logout user by revoking the current token.
     */
    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return $this->successResponse(null, 'Logged out successfully');
    }

    /**
     * Return authenticated user's profile.
     */
    public function logoutFromAllDevices(Request $request)
    {   
        $this->authService->logoutFromAllDevices($request->user());

         return $this->successResponse(null, 'Logged out from all devices successfully');
    }
}
