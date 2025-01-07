<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ClickTracking;
use App\Models\Link;
use App\Models\Qrcodes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnalyticController extends Controller
{
    public function index(Request $request)
    {
        // Ambil tahun dari input, jika tidak ada gunakan tahun saat ini
        $selectedYear = $request->input('tahun', date('Y'));

        // Fetch the top 6 links by clicks for the authenticated user
        $link = Link::where('user_id', Auth::id())
            ->whereYear('created_at', $selectedYear) // Filter berdasarkan tahun
            ->orderBy('clicks', 'desc')
            ->take(6)
            ->get();

        // If all links have 0 clicks, get the 5 most recent links for the authenticated user
        if ($link->isEmpty() || $link->every(fn($link) => $link->clicks === 0)) {
            $link = Link::where('user_id', Auth::id())
                ->whereYear('created_at', $selectedYear) // Filter berdasarkan tahun
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get();
        }

        // Mulai query untuk mengambil data QR codes milik user yang sedang login
        $qrcodes = Qrcodes::where('user_id', Auth::id())
                        ->whereYear('created_at', $selectedYear) // Filter berdasarkan tahun
                        ->orderBy('created_at', 'desc');
        // Lakukan pagination, hasil 6 item per halaman
        $qrcodes = $qrcodes->paginate(6);

        $linksCount = Link::where('user_id', Auth::id())
                        ->whereYear('created_at', $selectedYear) // Filter berdasarkan tahun
                        ->count();

        $linksVisitors = Link::where('user_id', Auth::id())
                            ->whereYear('created_at', $selectedYear) // Filter berdasarkan tahun
                            ->sum('clicks');

        $uniqueVisitors = ClickTracking::whereIn('link_id', Link::where('user_id', Auth::id())
                            ->whereYear('created_at', $selectedYear) // Filter berdasarkan tahun
                            ->pluck('id'))
                            ->distinct('ip_address')
                            ->count('ip_address');

        $dates = [];
        for ($i = 6; $i >= 0; $i--) {
            $dates[] = Carbon::today()->subDays($i)->toDateString();
        }

        $linkCountPerDay = Link::where('user_id', Auth::id())
            ->whereYear('created_at', $selectedYear) // Filter berdasarkan tahun
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->pluck('count', 'date'); // Mengambil tanggal sebagai key dan jumlah sebagai value

        $counts = [];
        foreach ($dates as $date) {
            $counts[] = $linkCountPerDay->get($date, 0); // Ambil jumlah atau 0 jika tidak ada
        }

        return view('analytic.index', compact('linksCount', 'linksVisitors', 'uniqueVisitors', 'link', 'qrcodes', 'dates', 'counts', 'selectedYear'));
    }
}
