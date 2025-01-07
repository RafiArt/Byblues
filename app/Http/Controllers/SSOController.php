<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SSOController extends Controller
{
    public function index()
    {
        return view('auth.sso-login');
    }

    public function store(Request $request)
    {
        $usercode = $request->usercode;
        $password = $request->password;

        // Kirim request ke API SSO untuk login
        $response = Http::timeout(20)->withoutVerifying()->post(env('API_SSO') . '/api/auth/login', [
            'usercode' => $usercode,
            'password' => $password,
        ]);

        $data = $response->json();

        if ($response->successful()) {
            $token = $data['data']['token'];
            $credential = $this->credential($token);

            if ($credential->success) {
                $usercode = $credential->data->user->usercode;
                $hashedPassword = Hash::make($usercode);

                // Mendapatkan informasi pegawai dari API
                $employeeResponse = Http::withoutVerifying()->withToken($token)
                    ->get(env('API_SSO') . '/api/admin/v1/employee/' . $usercode);

                if ($employeeResponse->successful()) {
                    // Jika data pegawai ditemukan
                    $employeeData = $employeeResponse->json();

                    // Sinkronisasi data divisi berdasarkan data pegawai
                    $divisionCode = $employeeData['data']['division']['code'];
                    $divisionName = $employeeData['data']['division']['name'];

                    // Buat atau update division berdasarkan code dan name
                    $division = Division::firstOrCreate(
                        ['code' => $divisionCode],
                        ['name_divisions' => $divisionName]
                    );
                } else {
                    // Jika data pegawai tidak ditemukan, periksa apakah itu vendor
                    $roles = $data['data']['roles'] ?? [];  // Ambil roles dari data API

                    // Mengambil hanya nilai 'name' dari setiap elemen dalam array $roles
                    $roleNames = collect($roles)->pluck('name'); // Mengambil 'name' saja dari roles

                    // Periksa apakah ada role 'vendor'
                    $isVendor = $roleNames->contains('vendor');

                    if ($isVendor) {
                        // Jika role adalah vendor
                        $division = Division::firstOrCreate(
                            ['code' => 'DIV021'], // Kode divisi Vendor
                            ['name_divisions' => 'Vendor'] // Nama divisi Vendor
                        );
                    } else {
                        // Jika bukan pegawai atau vendor, maka dianggap sebagai guest
                        $division = Division::firstOrCreate(
                            ['code' => 'DIV022'], // Kode divisi Guest
                            ['name_divisions' => 'Guest'] // Nama divisi Guest
                        );
                    }
                }

                // Buat atau update data user dan simpan app_token
                $user = User::updateOrCreate(
                    ['usercode' => $usercode],
                    [
                        'name' => $credential->data->user->name ?? 'SSO User',
                        'email' => $credential->data->user->email ?? 'guest@example.com', // Simpan null jika email tidak tersedia
                        'password' => $hashedPassword,
                        'division_id' => $division->id, // Kaitkan dengan division_id dari tabel divisions
                    ]
                );

                // Membuat app_token untuk autentikasi aplikasi
                $appToken = Str::random(60); // Token aplikasi yang acak
                $user->app_token = $appToken;
                $user->save();

                // Assign role ke user
                $user->assignRole('user');

                // Autentikasi user
                Auth::login($user);

                // Redirect ke dashboard jika login berhasil
                return redirect()->intended(route('dashboard'))->with('success', 'You are now logged in.')->with('app_token', $appToken);
            } else {
                // Error jika kredensial gagal diverifikasi
                return redirect('/login/sso')->with('error', 'Kredensial tidak valid.');
            }
        } else {
            // Error jika login SSO gagal
            return redirect('/login/sso')->with('error', $data['message'] ?? 'Login SSO gagal.');
        }
    }

    protected function credential($token)
    {
        $url = env('API_SSO') . '/api/web/v1/auth/credential';
        $response = Http::withoutVerifying()->withToken($token)
            ->get($url, [
                'client_id' => env('CLIENT_ID'),
                'client_secret' => env('CLIENT_SECRET'),
            ])
            ->throw();

        return $response->object();
    }
}
