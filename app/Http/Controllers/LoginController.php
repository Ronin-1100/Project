<?php

namespace App\Http\Controllers;

use App\Http\Requests\Login\LoginRequest;
use App\Services\LoginService;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __construct(
        private readonly LoginService $service
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->service->login($request->validated());

        if (!$token) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json(['token' => $token]);
    }

    public function logout(LoginRequest $request): JsonResponse
    {
        $success = $this->service->logout($request->header('AuthToken'));

        if (!$success) {
            return response()->json(['message' => 'AuthToken header missing'], 401);
        }

        return response()->json(['message' => 'Logged out successfully']);
    }
}
