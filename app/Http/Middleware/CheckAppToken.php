<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAppToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Ambil token dari header Authorization
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Token not provided.'], 401);
        }

        // Cek apakah ada user dengan app_token sesuai
        $user = User::where('app_token', $token)->first();

        if (!$user) {
            return response()->json(['error' => 'Invalid or missing app_token.'], 401);
        }

        // Autentikasi user agar tersedia di request
        Auth::setUser($user);


        return $next($request);
    }
}
