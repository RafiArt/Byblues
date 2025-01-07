<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Qrcodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QrcodeAdminController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input pencarian dan division_id
        $search = $request->input('search');
        $divisionId = $request->input('division_id');

        // Query untuk mengambil semua QR codes
        $qrcodes = Qrcodes::query()
            ->when($search, function ($query, $search) {
                // Filter berdasarkan 'link' atau atribut lainnya
                return $query->where(function ($query) use ($search) {
                    $query->where('link', 'LIKE', '%' . $search . '%');
                });
            })
            ->when($divisionId, function ($query, $divisionId) {
                // Filter berdasarkan division_id melalui user
                return $query->whereHas('user', function ($userQuery) use ($divisionId) {
                    $userQuery->where('division_id', $divisionId);
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

         // Ambil semua division untuk dropdown
         $divisions = Division::all();

        // Kembali ke view dengan data yang dipaginate
        return view('admin.qrcode_admin.index', compact('qrcodes','divisions'));
    }

    public function destroy($id)
    {
        // Find the QR code by ID
        $qrcode = Qrcodes::findOrFail($id);

        // Allow only the owner or an administrator to delete the QR code
        if (!Auth::user()->roles[0]->name == 'administrator' && $qrcode->user_id !== Auth::id()) {
            return redirect()->route('qrcodes.index')->with('error', 'Unauthorized action.');
        }

        // Delete the QR code
        $qrcode->delete();

        // Redirect back with a success message
        return redirect()->route('qrcodes_admin.index')->with('success', 'QR code deleted successfully.');
    }


}
