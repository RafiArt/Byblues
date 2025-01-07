<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Ambil pengguna yang sedang login
        $user = Auth::user();

        // Cek apakah pengguna memiliki role "administrator"
        if (!$user || $user->roles->isEmpty() || $user->roles[0]->name !== 'administrator') {
            return response()->json(['error' => 'Unauthorized. You do not have access.'], 403);
        }

        return $next($request);
    }
}
