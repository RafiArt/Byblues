<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserAdminController extends Controller
{
    public function index(Request $request)
    {
        $sortColumn = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        $users = User::query()
            ->orderBy($sortColumn, $sortDirection)
            ->with('roles')
            ->paginate(10);

        $roles = Role::all();

        return view("admin.user_management.index", compact("users", "sortColumn", "sortDirection", "roles"));
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user->syncRoles($validatedData['role']);

        return redirect()->route('admin.user.index')->with('success', 'User updated successfully.');
    }
}
