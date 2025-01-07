<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ClickTracking;
use App\Models\Link;
use App\Models\Qrcodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LinkApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexApi(Request $request)
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
            ->get();

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

        // Return data dalam format JSON
        return response()->json([
            'links' => $links,
            'visitors_data' => $formattedVisitorsData,
            'unique_visitors_data' => $formattedUniqueVisitorsData,
            'labels' => $labels,
        ], 200);
    }
    public function storeLink(Request $request)
    {
        // Validasi input data
        $validatedData = $request->validate([
            'original_url' => 'required|url',
            'title' => 'nullable|string', // Ini tetap nullable
            'password' => 'nullable|string',
            'active' => 'nullable|boolean',
        ]);

        // Pastikan title ada atau set ke null jika tidak ada
        $title = $validatedData['title'] ?? null;

        // Pastikan title ada atau set ke null jika tidak ada
        $password = $validatedData['password'] ?? null;

        // Buat short link di tabel links
        $link = Link::create([
            'title' => $title, // Gunakan title yang sudah diperiksa
            'deskripsi' => $request->deskripsi,
            'original_url' => $validatedData['original_url'],
            'short_url' => Str::random(6), // Generate short URL secara acak
            'password' => $password,
            'expiration_date' => $request->deskripsi,
            'user_id' => Auth::id(),
            'active' => $validatedData['active'] ?? true,
        ]);

        // Generate QR Code dalam format SVG dengan tingkat kesalahan tinggi
        $qrCodeSvg = QrCode::format('svg')
            ->size(300)
            ->errorCorrection('H')
            ->generate(url($link->short_url)); // Menggunakan short URL untuk QR Code

        // Muat logo dari public_path dan encode sebagai base64
        $logoPath = public_path('logosier.png');

        if (!file_exists($logoPath)) {
            return response()->json(['error' => 'Logo tidak ditemukan.'], 404);
        }

        $logoData = base64_encode(file_get_contents($logoPath));

            // Tentukan ukuran logo dan QR Code
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

        // Return response JSON
        return response()->json([
            'success' => true,
            'message' => 'Link and QR code created successfully.',
            'data' => [
                'short_url' => $link->short_url,
                'qrcode' => $svgWithLogo,
                'link' => env('APP_URL') . '/' . $link->short_url,
            ]
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateLink(Request $request, $id)
    {
        try {
            // Cari link yang akan diupdate
            $link = Link::findOrFail($id);

            // Cek apakah user yang sedang login adalah pemilik link
            if ($link->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak. Anda tidak memiliki izin untuk mengupdate link ini.'
                ], 403);
            }

            // Validasi input
            $validatedData = $request->validate([
                'short_url' => [
                    'nullable',
                    'string',
                    'min:1',
                    Rule::unique('links')->ignore($id)->whereNotNull('short_url')
                ],
                'link_title' => 'nullable|string',
                'deskripsi' => 'nullable|string',
            ]);

            // Siapkan data untuk update
            $updateData = [
                'user_id' => Auth::id(), // Menggunakan Auth::id() untuk mendapatkan ID user yang sedang login
            ];

            // Tambahkan field opsional jika ada
            if (!empty($validatedData['short_url'])) {
                $updateData['short_url'] = $validatedData['short_url'];
            }
            if (!empty($validatedData['link_title'])) {
                $updateData['title'] = $validatedData['link_title'];
            }
            if (!empty($validatedData['deskripsi'])) {
                $updateData['deskripsi'] = $validatedData['deskripsi'];
            }

            // Lakukan update, tanpa mengupdate original_url
            $link->update($updateData);

            // Generate QR Code
            $qrCodeSvg = QrCode::format('svg')
                ->size(300)
                ->errorCorrection('H')
                ->generate(url($link->short_url));
    // Muat logo dari public_path dan encode sebagai base64
    $logoPath = public_path('logosier.png');

    if (!file_exists($logoPath)) {
        return back()->with('error', 'Logo tidak ditemukan.');
    }

    $logoData = base64_encode(file_get_contents($logoPath));

            // Tentukan ukuran logo dan QR Code
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

            return response()->json([
                'success' => true,
                'message' => 'Link dan QR Code berhasil diupdate.',
                'data' => [
                    'id' => $link->id,
                    'user_id' => $link->user_id,
                    'original_url' => $link->original_url,
                    'short_url' => $link->short_url,
                    'title' => $link->title,
                    'deskripsi' => $link->deskripsi,
                    'qrcode' => $svgWithLogo,
                    'link' => env('APP_URL') . '/' . $link->short_url,
                ]
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Link tidak ditemukan'
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error validasi',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengupdate link',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateExpiredApi(Request $request, $id)  // Ganti Link $link dengan $id
    {
        // Ambil link berdasarkan ID yang dikirimkan
        $link = Link::findOrFail($id);  // Gunakan findOrFail untuk otomatis menangani jika tidak ada link ditemukan

        if ($request->expiration_date) {
            $expiredDate = strtotime($request->expiration_date);
            $link->expiration_date = date('Y-m-d H:i:s', $expiredDate);
            $link->save();
            return response()->json(['message' => 'Link expiration date updated successfully.'], 200);
        } else {
            return response()->json(['error' => 'Expiration date is required.'], 400);
        }
    }

    public function updatePasswordApi(Request $request, $id)
    {
        // Ambil link berdasarkan ID yang dikirimkan
        $link = Link::findOrFail($id);

        // Validasi apakah password baru ada
        if ($request->pashphrase) {
            // Update password dengan hash baru
            $link->password = Hash::make($request->pashphrase);
            $link->save();

            return response()->json(['message' => 'Link password updated successfully.'], 200);
        } else {
            return response()->json(['error' => 'Password is required.'], 400);
        }
    }

    public function removeExpirationDateApi(Request $request, $id)
    {
        // Ambil link berdasarkan ID yang dikirimkan
        $link = Link::findOrFail($id);

        // Hapus expiration_date
        $link->expiration_date = null;
        $link->save();

        return response()->json(['message' => 'Time-based link removed successfully.'], 200);
    }

    public function removePasswordApi(Request $request, $id)
    {
        // Ambil link berdasarkan ID yang dikirimkan
        $link = Link::findOrFail($id);

        // Hapus password
        $link->password = null;
        $link->save();

        return response()->json(['message' => 'Link password removed successfully.'], 200);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroyLink($id)
    {
        try {
            // Find the link by ID
            $link = Link::findOrFail($id);

            // Delete the link
            $link->delete();

            // Return a success response
            return response()->json([
                'success' => true,
                'message' => 'Link deleted successfully.'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Return a not found response
            return response()->json([
                'success' => false,
                'message' => 'Link not found.'
            ], 404);
        } catch (\Exception $e) {
            // Return an error response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the link.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
