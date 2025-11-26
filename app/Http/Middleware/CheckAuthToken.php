<?php

namespace App\Http\Middleware;

use App\Redis\LoginClient;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('AuthToken');

        $userId = LoginClient::getUserIdByToken($token);

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired token',
            ], 401);
        }

        $request->merge(['user_id' => $userId]);

        return $next($request);
    }
}
