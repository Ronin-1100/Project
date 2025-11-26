<?php

namespace App\Redis;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class LoginClient
{
    private const TTL = 60*60*24;

    public static function login(int $userId): string
    {
        $token = Str::random(40);

        Redis::setex("auth_token:{$token}", self::TTL, $userId);

        return $token;
    }


    public static function getUserIdByToken(?string $token): ?int
    {
        if (!$token) {
            return null;
        }

        return Redis::get("auth_token:{$token}");
    }

    public static function logout(string $token): string
    {
        Redis::del("auth_token:{$token}");

        return $token;
    }
}
