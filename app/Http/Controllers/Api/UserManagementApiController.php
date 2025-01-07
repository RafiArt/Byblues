<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserManagementApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Mengambil parameter sort dan direction dari request
        $sortColumn = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        // Mengambil data pengguna, termasuk role dan division yang terhubung
        $users = User::query()
            ->orderBy($sortColumn, $sortDirection)
            ->with(['roles', 'division']) // Menyertakan roles dan division
            ->get();

        // Mengambil semua roles
        $roles = Role::all();

        // Mengembalikan data sebagai response JSON
        return response()->json([
            'users' => $users,
            'roles' => $roles
        ], 200);
    }

    public function updateRole(Request $request, $userId)
    {
        // Temukan pengguna berdasarkan ID
        $user = User::findOrFail($userId);

        // Validasi input
        $validatedData = $request->validate([
            'role' => 'required|exists:roles,name', // Pastikan role yang dikirim ada di tabel roles
        ]);

        // Sinkronkan role pengguna
        $user->syncRoles($validatedData['role']);

        // Muat ulang data user dengan role yang diperbarui
        $user->refresh(); // Refresh model untuk memastikan data terbarui dari database
        $user->load('roles'); // Muat ulang relasi roles

        // Kembalikan respons JSON
        return response()->json([
            'message' => 'User role updated successfully.',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'roles' => $user->roles->pluck('name') // Mengambil hanya nama dari setiap role
            ]
        ], 200);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
