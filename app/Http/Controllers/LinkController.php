<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Http\Controllers\Controller;
use App\Models\ClickTracking;
use App\Models\Qrcodes;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Jorenvh\Share\Share;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */


     public function index(Request $request)
     {
         $search = $request->get('search');
         $user = Auth::user();

         // Ambil semua link milik pengguna yang sedang login, dan filter jika ada pencarian berdasarkan `short_url`
         $links = Link::query()
             ->where('user_id', $user->id)
             ->when($search, function ($query, $search) {
                 return $query->where('short_url', 'LIKE', '%' . $search . '%'); // Cari berdasarkan `short_url`
             })
             ->orderBy('created_at', 'desc') // Urutkan berdasarkan created_at desc
             ->paginate(10);

         // Inisialisasi array untuk menyimpan data pengunjung
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

         return view('link.index', compact('formattedVisitorsData', 'formattedUniqueVisitorsData', 'labels', 'links'));
     }


    public function divisionLink(Request $request){
        $search = $request->get('search');
        $user = Auth::user();
        $divisionId = $user->division_id;

        // Ambil semua link milik pengguna yang sedang login, dan filter jika ada pencarian
        $links = Link::query()
            ->where('user_id', $user->id)
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('title', 'LIKE', '%' . $search . '%')
                        ->orWhere('short_url', 'LIKE', '%' . $search . '%');
                });
            })
            ->orderBy('created_at', 'desc') // Urutkan berdasarkan created_at desc
            ->paginate(10);

        // Shortlink yang dibuat oleh pengguna lain dalam divisi yang sama
        $divisionLinks = Link::query()
            ->whereHas('user', function ($query) use ($divisionId, $user) {
                $query->where('division_id', $divisionId)
                    ->where('id', '!=', $user->id); // Pastikan bukan user yang sedang login
            })
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('title', 'LIKE', '%' . $search . '%')
                        ->orWhere('short_url', 'LIKE', '%' . $search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);


        // Inisialisasi array untuk menyimpan data pengunjung
        $visitorsData = [];
        $uniqueVisitorsData = [];
        $labels = [];

        // Hitung total visitors dan unique visitors berdasarkan tanggal untuk setiap link
        foreach ($links as $link) {
            // Hitung total dan unique visitors
            $clicks = ClickTracking::selectRaw('DATE(created_at) as date, COUNT(*) as total_visitors, COUNT(DISTINCT ip_address) as unique_visitors')
                ->where('link_id', $link->id)
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            // Menghitung jumlah pengunjung unik
            $uniqueCount = ClickTracking::where('link_id', $link->id)
                ->distinct('ip_address')
                ->count('ip_address');

            // Simpan data ke dalam link
            $link->unique_visitors_count = $uniqueCount; // Menyimpan jumlah pengunjung unik ke dalam objek link
            $link->visitors_data = $clicks; // Simpan data clicks ke dalam objek link

            // Simpan ke array untuk view
            $uniqueVisitorsData[$link->id] = $uniqueCount; // Simpan jumlah pengunjung unik per link

            // Persiapkan data untuk grafik
            foreach ($clicks as $click) {
                // Menambahkan total visitors dan unique visitors per tanggal ke array
                $visitorsData[$link->id][$click->date] = $click->total_visitors;
                // Mengumpulkan label tanggal yang unik
                if (!in_array($click->date, $labels)) {
                    $labels[] = $click->date; // Hanya ambil label tanggal yang unik
                }
            }
        }
        // Kirim data ke view
        return view('link.division-link', compact('visitorsData', 'uniqueVisitorsData', 'labels', 'divisionLinks', 'links'));

    }




    /**
     * Show the form for creating a new resource.
     */

    public function redirect($link)
    {
        // Cari link berdasarkan short_url
        $link = Link::where('short_url', $link)->firstOrFail();

        if ($link->expiration_date && $link->expiration_date < Carbon::now()) {
            return view('expiredPage');
        }

        if ($link->password) {
            return redirect()->route('confirm-password.index', ['short_url' => $link->short_url]);
        }

        // Increment total clicks (pengunjung total)
        $link->increment('clicks');

        // Dapatkan IP pengunjung dan tipe perangkat (device type)
        $ipAddress = request()->ip();
        $deviceType = $this->getDeviceType();

        // Simpan data tracking ke dalam database
        ClickTracking::create([
            'link_id' => $link->id,
            'ip_address' => $ipAddress,
            'device_type' => $deviceType,
        ]);

        // Tampilkan halaman perantara sebelum redirect
        return view('layouts.intermediateRedirect', ['original_url' => $link->original_url, 'link' => $link]);
    }



    // Fungsi sederhana untuk mendeteksi jenis perangkat
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

    // Menyimpan link baru ke database
    public function store(Request $request)
    {
        // Validasi input data
        $validatedData = $request->validate([
            'original_url' => 'required|url',
            'title' => 'nullable|string',
            'password' => 'nullable|string',
            'expiration_date' => 'nullable|date',
            'active' => 'nullable|boolean',
        ]);

        // Buat short link di tabel links
        $link = Link::create([
            'title' => $validatedData['title'],
            'deskripsi' => $request->deskripsi,
            'original_url' => $validatedData['original_url'],
            'short_url' => Str::random(6), // Generate short URL secara acak
            'password' => $validatedData['password'] ? bcrypt($validatedData['password']) : null,
            'expiration_date' => $validatedData['expiration_date'],
            'user_id' => Auth::id(),
            'active' => $validatedData['active'] ?? true,
        ]);

        // Generate QR Code dalam format SVG dengan tingkat kesalahan tinggi
        $qrCodeSvg = QrCode::format('svg')
            ->size(300)
            ->errorCorrection('H')
            ->generate(url($link->short_url)); // Menggunakan short URL untuk QR Code

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


        // Buat entri QR Code di tabel qrcodes
        Qrcodes::create([
            'qrcode' => $svgWithLogo,
            'link' => env('APP_URL') . '/' . $link->short_url,
            'user_id' => Auth::id(),
            'shortlink_id' => $link->id, // Kaitkan dengan link yang dibuat
        ]);

        // Redirect ke index dengan pesan sukses
        return redirect()->route('links.index')->with('success', 'Link successfully created.');
    }


    /**
     * Display the specified resource.
     */
    public function show(link $link)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(link $link)
    {
        $link = Link::where('id', $link->id)->firstOrFail();
        return view('link.edit', compact('link'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Link $link)
    {

        // Validate the request
        $request->validate([
            'short_url' => 'required|string|unique:links,short_url,' . $link->id, // Exclude current link from unique validation
            'link_title' => 'nullable|string', // Optional title validation
            'deskripsi' => 'nullable|string',
            'expiration_date' => 'nullable',
        ]);
        // Update the link details
        $link->short_url = $request->short_url;
        $link->title = $request->link_title;
        $link->deskripsi = $request->deskripsi;
        $link->save();

        $qrCodeSvg = QrCode::format('svg')
            ->size(300)
            ->errorCorrection('H')
            ->generate(url($link->short_url)); // Menggunakan short URL untuk QR Code

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

        return redirect()->route('links.index')->with('success', 'Link and QR Code updated successfully.');
    }


    public function updateExpired(Request $request, Link $link)
    {

        $link = Link::where('id', $link->id)->firstOrFail();

        if ($request->expiration_date) {
            $expiredDate = strtotime($request->expiration_date);
            $link->expiration_date = date('Y-m-d H:i:s', $expiredDate);
            $link->save();
            return redirect()->route('links.index')->with('success', 'Link expiration date updated successfully.');
        } else {
            return redirect()->route('links.index')->with('error', 'Expiration date is required.');
        }
    }

    public function updatePashphrase(Request $request, Link $link)
    {

        $link = Link::where('id', $link->id)->firstOrFail();
        if ($request->pashphrase) {
            $link->password = Hash::make($request->pashphrase);
            $link->save();
            return redirect()->route('links.index')->with('success', 'Link password updated successfully.');
        } else {
            return redirect()->route('links.index')->with('error', 'Password is required.');
        };
    }

    public function removePashphrase(Link $link)
    {
        $link = Link::where('id', $link->id)->firstOrFail();
        $link->password = null;
        $link->save();
        return redirect()->route('links.index')->with('success', 'Link password removed successfully.');
    }

    public function removeExpirationDate(Link $link)
    {
        $link = Link::where('id', $link->id)->firstOrFail();
        $link->expiration_date = null;
        $link->save();
        return redirect()->route('links.index')->with('success', 'Time-based link removed successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(link $link)
    {
        $link = Link::where('id', $link->id)->firstOrFail();
        $link->delete();
        return redirect()->route('links.index')->with('success', 'Link deleted successfully.');
    }
}
