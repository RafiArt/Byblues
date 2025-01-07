<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Str;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Cek kredensial login
        if (Auth::attempt($request->only('email', 'password'))) {
            // Ambil ID user yang sedang login
            $userId = Auth::id();

            // Cari user dari database
            $user = User::find($userId);

            // Autentikasi pengguna
            $request->authenticate();

            // Regenerasi session
            $request->session()->regenerate();

            // Redirect ke halaman dashboard
            return redirect()->intended(route('dashboard'))
                ->with('success', 'You are now logged in.');
        }

        // Jika gagal login, redirect ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'The provided credentials are incorrect.',
        ]);
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Ambil user sebelum logout
        $user = User::find(Auth::id());

        // Logout user
        Auth::guard('web')->logout();

        // Jika user ditemukan, hapus informasi terkait app_token (jika ada)
        if ($user) {
            // Tidak perlu lagi mengubah app_token karena kolom tersebut sudah tidak ada
            // Jika sebelumnya ingin menyimpan perubahan lainnya, Anda bisa melakukannya di sini.
            // Contoh: $user->other_field = null; // Hapus field lainnya jika ada
            $user->save();
        }

        // Invalidate session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        // Redirect ke halaman utama
        return redirect('/');
    }

}
