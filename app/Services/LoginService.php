<?php

namespace App\Services;

use App\Models\User;
use App\Redis\LoginClient;
use Illuminate\Support\Facades\Hash;

class LoginService
{
    public function login(array $data): ?string
    {
        $user = User::query()->where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return null;
        }

        return LoginClient::login($user->id);
    }

    public function logout(?string $token): bool
    {
        if (!$token) {
            return false;
        }

        LoginClient::logout($token);

        return true;
    }
}
