<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

     public function show()
    {
        return view('profile.index'); // This will load a blank profile page in the 'user/index.blade.php' file
    }

    // Show the profile edit form
    public function edit()
    {
        return view('profile.update'); // Adjust the view path accordingly
    }


    public function update(Request $request)
    {
        // Validasi data yang masuk
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'required' // Pastikan password dimasukkan untuk verifikasi
        ]);

        // Dapatkan pengguna yang terautentikasi
        $user = Auth::user();

        // Verifikasi password
        if (!Hash::check($request->input('password'), $user->password)) {
            return redirect()->route('profile.edit')->withErrors(['password' => 'Password tidak cocok.']);
        }

        // Update nama dan email pengguna
        DB::table('users')->where('id', Auth::id())->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }

    // public function edit(Request $request): View
    // {
    //     return view('profile.edit', [
    //         'user' => $request->user(),
    //     ]);
    // }

    // public function update(ProfileUpdateRequest $request): RedirectResponse
    // {
    //     $request->user()->fill($request->validated());

    //     if ($request->user()->isDirty('email')) {
    //         $request->user()->email_verified_at = null;
    //     }

    //     $request->user()->save();

    //     return Redirect::route('profile.edit')->with('status', 'profile-updated');
    // }

    // Menampilkan form reset password
    public function showResetForm()
    {
        return view('profile.reset');
    }

    public function reset(Request $request)
    {
        // Validasi input
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' otomatis memeriksa kecocokan dengan 'password_confirmation'
        ]);

        // Cek apakah password saat ini benar
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak cocok.']);
        }

        // Memeriksa kecocokan password dan konfirmasi password
        if ($request->password !== $request->password_confirmation) {
            return back()->withErrors(['password' => 'Password baru dan konfirmasi password tidak cocok.']);
        }

        // Jika password saat ini valid dan password baru sesuai, perbarui password
        DB::table('users')->where('id', Auth::id())->update([
            'password' => Hash::make($request->password),
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('profile.reset')->with('success', 'Password berhasil diperbarui.');
    }

    // Mengatur ulang password
    // public function reset(Request $request)
    // {
    //     // Validasi data yang masuk
    //     $request->validate([
    //         'password' => 'required|string|min:8|confirmed', // Menggunakan confirmed untuk verifikasi
    //     ]);

    //     // Dapatkan pengguna yang terautentikasi
    //     $user = Auth::user();

    //     // Update password pengguna
    //     $user->password = Hash::make($request->input('password'));
    //     $user->save(); // Simpan perubahan ke database

    //     // Redirect dengan pesan sukses
    //     return redirect()->route('profile.edit')->with('success', 'Password berhasil diperbarui.');
    // }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
