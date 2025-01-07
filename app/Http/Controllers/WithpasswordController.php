<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\ClickTracking;

class WithpasswordController extends Controller
{
    public function index($short_url)
    {
        return view('confirm-password', ['short_url' => $short_url]);
    }

    private function getDeviceType()
    {
        $agent = new \Jenssegers\Agent\Agent();

        if ($agent->isMobile()) {
            return 'Mobile';
        } elseif ($agent->isTablet()) {
            return 'Tablet';
        } else {
            return 'Desktop';
        }
    }
    public function redirect(Request $request, $short_url)
    {
        // Menemukan link berdasarkan short_url
        $link = Link::where('short_url', $short_url)->firstOrFail();

        // Mendapatkan passphrase dari request
        $password = $request->input('passphrase');

        // Memeriksa apakah password yang dimasukkan cocok
        if (Hash::check($password, $link->password)) {
            // Mendapatkan alamat IP dan tipe perangkat pengunjung
            $ipAddress = request()->ip();
            $deviceType = $this->getDeviceType();

            // Menyimpan data tracking ke dalam database
            ClickTracking::create([
                'link_id' => $link->id,
                'ip_address' => $ipAddress,
                'device_type' => $deviceType,
            ]);

            // Meningkatkan jumlah klik
            $link->increment('clicks');

            // Redirect ke view intermediateRedirect dengan data original_url dan link
            return view('layouts.intermediateRedirect', [
                'original_url' => $link->original_url,
                'link' => $link
            ]);
        } else {
            // Jika password salah, kembali ke halaman sebelumnya dengan pesan error
            return redirect()->back()->with('error', 'Password is incorrect.');
        }
    }

}
