<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClickTracking;
use App\Models\Link;
use App\Models\Qrcodes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnalyticsAdminController extends Controller
{
    public function index(Request $request)
    {
        // Ambil tahun dari input, jika tidak ada gunakan tahun saat ini
        $selectedYear = $request->input('tahun', date('Y'));

        // Fetch the top 6 links by clicks for all users
        $link = Link::whereYear('created_at', $selectedYear)
            ->orderBy('clicks', 'desc')
            ->take(6)
            ->get();

        // If all links have 0 clicks, get the 5 most recent links for all users
        if ($link->isEmpty() || $link->every(fn($link) => $link->clicks === 0)) {
            $link = Link::whereYear('created_at', $selectedYear)
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get();
        }

        // Fetch all QR codes for all users, paginated
        $qrcodes = Qrcodes::whereYear('created_at', $selectedYear)
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        // Count of links and total clicks for all users
        $linksCount = Link::whereYear('created_at', $selectedYear)
            ->count();

        $linksVisitors = Link::whereYear('created_at', $selectedYear)
            ->sum('clicks');

        // Unique visitors for all users
        $uniqueVisitors = ClickTracking::whereIn('link_id', Link::whereYear('created_at', $selectedYear)
            ->pluck('id'))
            ->distinct('ip_address')
            ->count('ip_address');

        // Dates for the past week and link counts per day
        $dates = [];
        for ($i = 6; $i >= 0; $i--) {
            $dates[] = Carbon::today()->subDays($i)->toDateString();
        }

        $linkCountPerDay = Link::whereYear('created_at', $selectedYear)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->pluck('count', 'date');

        $counts = [];
        foreach ($dates as $date) {
            $counts[] = $linkCountPerDay->get($date, 0);
        }

        // Retrieve total clicks across all users
        $totalClicksAllUsers = Link::whereYear('created_at', $selectedYear)->sum('clicks');

        // Pass total clicks for all users to the view
        return view('admin.analytics.index', compact(
            'linksCount', 'linksVisitors', 'uniqueVisitors', 'link', 'qrcodes',
            'dates', 'counts', 'selectedYear', 'totalClicksAllUsers'
        ));
    }
}
