<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Division;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;

class UserApiController extends Controller
{
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
            $appToken = Str::random(60); // Generate a new app token
            $credential = $this->credential($token);

            if ($credential->success) {
                $usercode = $credential->data->user->usercode;
                $hashedPassword = Hash::make($usercode);

                // Sinkronisasi data divisi
                $employeeResponse = Http::withoutVerifying()->withToken($token)
                    ->get(env('API_SSO') . '/api/admin/v1/employee/' . $usercode);

                if ($employeeResponse->successful()) {
                    $employeeData = $employeeResponse->json();

                    $divisionCode = $employeeData['data']['division']['code'];
                    $divisionName = $employeeData['data']['division']['name'];

                    $division = Division::firstOrCreate(
                        ['code' => $divisionCode],
                        ['name_divisions' => $divisionName]
                    );

                    // Simpan atau update data user
                    $user = User::updateOrCreate(
                        ['usercode' => $usercode],
                        [
                            'name' => $credential->data->user->name ?? 'SSO User',
                            'email' => $credential->data->user->email ?? null,
                            'password' => $hashedPassword,
                            'division_id' => $division->id,
                            'app_token' => $appToken, // Save app token in database
                        ]
                    );

                    $user->assignRole('user');

                    Auth::login($user);

                    return response()->json([
                        'success' => true,
                        'message' => 'You are now logged in.',
                        'user' => $user,
                        'token' => $token,
                        'app_token' => $appToken,
                    ], 200);
                }
            }
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

    public function logout(Request $request)
    {
        $appToken = $request->bearerToken();

        // Cek apakah app_token valid
        $user = User::where('app_token', $appToken)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak valid.',
            ], 401);
        }

        // Logout user
        Auth::logout();
        $user->app_token = null; // Hapus app_token dari database
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'You have been logged out.',
        ], 200);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            // Temukan pengguna berdasarkan email
            $user = User::where('email', $request->email)->first();

            // Verifikasi password
            if ($user && Hash::check($request->password, $user->password)) {
                // Generate a random token
                $appToken = Str::random(60);

                // Simpan token ke database
                $user->update(['app_token' => $appToken]);

                return response()->json([
                    'success' => true,
                    'message' => 'You are now logged in.',
                    'token' => $appToken,
                ], 200);
            }

            return response()->json(['error' => 'Invalid credentials.'], 401);
        } catch (\Exception $e) {
            \Log::error('Login error: ' . $e->getMessage());
            return response()->json(['error' => 'Login failed.', 'message' => $e->getMessage()], 500);
        }
    }


}
