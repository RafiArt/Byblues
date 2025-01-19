<?php

namespace App\Http\Controllers;
use App\Models\Diagnosa;
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
        $user = Auth::user();

        if ($user->roles[0]->name == 'administrator') {
            $CountDiagnosis = (object) [
                'total' => Diagnosa::count(),
                'tidak_ada_risiko' => Diagnosa::where('hasil', 'Tidak Ada Risiko Baby Blues')->count(),
                'risiko_rendah' => Diagnosa::where('hasil', 'Risiko Rendah Baby Blues')->count(),
                'risiko_sedang' => Diagnosa::where('hasil', 'Risiko Sedang Baby Blues')->count(),
                'risiko_tinggi' => Diagnosa::where('hasil', 'Risiko Tinggi Baby Blues')->count()
            ];
        } else {
            $CountDiagnosis = (object) [
                'total' => Diagnosa::where('user_id', $user->id)->count(),
                'tidak_ada_risiko' => Diagnosa::where('user_id', $user->id)
                    ->where('hasil', 'Tidak Ada Risiko Baby Blues')->count(),
                'risiko_rendah' => Diagnosa::where('user_id', $user->id)
                    ->where('hasil', 'Risiko Rendah Baby Blues')->count(),
                'risiko_sedang' => Diagnosa::where('user_id', $user->id)
                    ->where('hasil', 'Risiko Sedang Baby Blues')->count(),
                'risiko_tinggi' => Diagnosa::where('user_id', $user->id)
                    ->where('hasil', 'Risiko Tinggi Baby Blues')->count()
            ];
        }

        return view('dashboard', compact('CountDiagnosis'));
    }




}
