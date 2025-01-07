<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClickTracking;
use App\Models\Division;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LinkAdminController extends Controller
{

    public function index(Request $request)
    {
        $divisionId = $request->input('division_id');
        $search = $request->get('search');

        // Query untuk filter
        $links = Link::query()
            ->when($search, function ($query, $search) {
                // Filter berdasarkan judul atau short_url
                return $query->where(function ($query) use ($search) {
                    $query->where('title', 'LIKE', '%' . $search . '%')
                        ->orWhere('short_url', 'LIKE', '%' . $search . '%');
                });
            })
            ->when($divisionId, function ($query) use ($divisionId) {
                // Filter berdasarkan division_id melalui user
                return $query->whereHas('user', function ($userQuery) use ($divisionId) {
                    $userQuery->where('division_id', $divisionId);
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Ambil semua division untuk dropdown
        $divisions = Division::all();

        // Inisialisasi array untuk menyimpan data
        $visitorsData = [];
        $uniqueVisitorsData = [];
        $labels = [];

        // Proses data untuk setiap link
        foreach ($links as $link) {
            // Hitung total dan unique visitors
            $clicks = ClickTracking::selectRaw('DATE(created_at) as date, COUNT(*) as total_visitors, COUNT(DISTINCT ip_address) as unique_visitors')
                ->where('link_id', $link->id)
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            // Menghitung jumlah pengunjung unik untuk link ini
            $uniqueCount = ClickTracking::where('link_id', $link->id)
                ->distinct('ip_address')
                ->count('ip_address');

            $link->unique_visitors_count = $uniqueCount;
            $link->visitors_data = $clicks;

            // Persiapkan data untuk grafik
            foreach ($clicks as $click) {
                $date = $click->date;

                // Konversi data ke format yang sesuai untuk JSON
                $visitorsData[$link->id][$date] = (int)$click->total_visitors;
                $uniqueVisitorsData[$link->id][$date] = (int)$click->unique_visitors;

                if (!in_array($date, $labels)) {
                    $labels[] = $date;
                }
            }
        }

        // Urutkan labels tanggal
        sort($labels);

        // Konversi data ke format yang sesuai untuk grafik
        $formattedVisitorsData = [];
        $formattedUniqueVisitorsData = [];

        foreach ($links as $link) {
            $formattedVisitorsData[$link->id] = [];
            $formattedUniqueVisitorsData[$link->id] = [];

            foreach ($labels as $date) {
                $formattedVisitorsData[$link->id][] = $visitorsData[$link->id][$date] ?? 0;
                $formattedUniqueVisitorsData[$link->id][] = $uniqueVisitorsData[$link->id][$date] ?? 0;
            }
        }

        return view('admin.links.index', compact('formattedVisitorsData', 'formattedUniqueVisitorsData', 'labels', 'links','divisions'));
    }

    public function edit($id)
    {
        // $link = Link::findOrFail($link->id);
        $link = Link::findOrFail($id);
        // Menampilkan form untuk mengedit link
        return view('admin.links.edit', compact('link'));
    }

    public function update(Request $request, Link $link)
    {
        // Validasi request
        $request->validate([
            'short_url' => 'required|string|unique:links,short_url,' . $link->id,
            'link_title' => 'nullable|string',
            'deskripsi' => 'nullable|string',
        ]);

        // Update link details
        $link->short_url = $request->short_url;
        $link->title = $request->link_title;
        $link->deskripsi = $request->deskripsi;
        $link->save();

        // Generate QR Code dalam format SVG dengan tingkat kesalahan tinggi
        $qrCodeSvg = QrCode::format('svg')
            ->size(300)
            ->errorCorrection('H')
            ->generate(url($link->short_url)); // Menggunakan short URL untuk QR Code

        // Muat logo dari public_path dan encode sebagai base64
        $logoPath = public_path('logosier.png');

        if (!file_exists($logoPath)) {
            return back()->with('error', 'Logo tidak ditemukan.');
        }

        $logoData = base64_encode(file_get_contents($logoPath));

        $qrCodeSize = 300; // Ukuran QR Code
        $boxSize = 130; // Ukuran kotak putih yang menampung logo
        $logoSize = $boxSize * 0.8; // Logo mengambil 90% dari ukuran kotak (agar ada jarak putih di sekitar logo)

        // Tentukan posisi tengah untuk menempatkan kotak dan logo
        $centerPositionBox = ($qrCodeSize - $boxSize) / 2;
        $centerPositionLogo = ($qrCodeSize - $logoSize) / 2;  // Pastikan logo ada di tengah QR Code

        // Tentukan tipe MIME logo
        $logoMime = mime_content_type($logoPath);

        // Sisipkan kotak putih dengan ujung bulat di tengah QR Code dan masukkan logo di dalam kotak
        $svgWithLogo = str_replace('</svg>', '
            <!-- Kotak putih dengan ujung bulat di tengah QR Code -->
            <rect x="' . $centerPositionBox . '"
                y="' . $centerPositionBox . '"
                width="' . $boxSize . '"
                height="' . $boxSize . '"
                fill="white"
                stroke="none"
                rx="20" ry="20" /> <!-- Menambahkan radius sudut untuk membuat kotak menjadi bulat -->

            <!-- Sisipkan logo di dalam kotak -->
            <image x="' . $centerPositionLogo . '"
                y="' . $centerPositionLogo . '"
                width="' . $logoSize . '"
                height="' . $logoSize . '"
                href="data:' . $logoMime . ';base64,' . $logoData . '" />
        </svg>', $qrCodeSvg);

        // Update entri QR Code yang terkait dengan link
        $link->qrcodes()->update([
            'qrcode' => $svgWithLogo, // Perbarui QR Code dengan yang baru
            'link' => env('APP_URL') . '/' . $link->short_url, // Pastikan link juga diperbarui
        ]);

        return redirect()->route('links_admin.index')->with('success', 'Link and QR Code updated successfully.');
    }

    public function destroy($id)
    {
        // Find the QR code by ID
        $link = Link::findOrFail($id);

        // Allow only the owner or an administrator to delete the QR code
        if (Auth::user()->roles[0]->name !== 'administrator' && $link->user_id !== Auth::id()) {
            return redirect()->route('links.index')->with('error', 'Unauthorized action.');
        }

        $link->delete();
        return redirect()->route('links_admin.index')->with('success', 'Link deleted successfully.');
    }
}
