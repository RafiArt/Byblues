<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Diagnosa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiagnosaAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Diagnosa::with('user')->orderBy('created_at', 'desc');

        // Search by user name
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by Peran
        if ($request->filled('peran')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('peran', $request->peran);
            });
        }

        // Filter by Kategori
        if ($request->filled('kategori')) {
            $query->where('hasil', $request->kategori);
        }

        $diagnosas = $query->paginate(10)->withQueryString();

        return view('admin.diagnosa_admin.index', [
            'diagnosas' => $diagnosas,
            'search' => $request->search,
            'peran' => $request->peran,
            'kategori' => $request->kategori
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        $diagnosa = Diagnosa::find($id);

        $user = Auth::user();
        if (!$diagnosa) {
            abort(404);
        }

        // Check if the user is the owner of the diagnosa or an administrator
        if ($diagnosa->user_id != $user->id && $user->roles[0]->name != 'administrator') {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.diagnosa_admin.show', data: compact('diagnosa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
    public function destroy($id)
    {
        // Find the diagnosa by ID
        $diagnosa = Diagnosa::findOrFail($id);

        // Delete the diagnosa record
        $diagnosa->delete();

        // Redirect back with a success message
        return redirect()->route('diagnosa_admin.index')->with('success', 'Diagnosa deleted successfully');
    }
}
