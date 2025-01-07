<?php

namespace App\Http\Controllers;
use Spatie\Permission\Traits\HasRoles;
use App\Models\ClickTracking;
use App\Models\Link;
use App\Models\User;
use App\Models\Qrcodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
{
    $user = Auth::user(); // Ambil user yang sedang login

    // Cek apakah user memiliki role 'administrator' menggunakan hasRole dari Spatie
    if ($user->roles[0]->name == 'administrator') {
        // Jika user memiliki role 'administrator', ambil semua data
        $CountLink = Link::count();
        $Visitor = Link::sum('clicks');
        $VisitorUnique = ClickTracking::distinct('ip_address')->count('ip_address');
        $divisionLinksCount = 0;
        $qrcodesDivisions = 0;
    } else {
        // Jika user memiliki role 'user', ambil data berdasarkan division_id
        $divisionId = $user->division_id;

        $divisionLinksCount = Link::query()
            ->whereHas('user', function ($query) use ($divisionId, $user) {
                $query->where('division_id', $divisionId)
                    ->where('id', '!=', $user->id); // Filter bukan user login
            })
            ->count();

        $qrcodesDivisions = Qrcodes::query()
            ->whereHas('user', function ($query) use ($divisionId, $user) {
                $query->where('division_id', $divisionId)
                    ->where('id', '!=', $user->id); // Pastikan bukan user yang sedang login
            })
            ->count();

        $CountLink = Link::where('user_id', $user->id)->count();
        $Visitor = Link::where('user_id', $user->id)->sum('clicks');
        $VisitorUnique = ClickTracking::whereIn('link_id', Link::where('user_id', $user->id)->pluck('id'))
            ->distinct('ip_address')
            ->count('ip_address');
    }

    return view('dashboard', compact('CountLink', 'Visitor', 'VisitorUnique', 'divisionLinksCount', 'qrcodesDivisions'));
}


}
