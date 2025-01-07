<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Qrcodes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Intervention\Image\Facades\Image;
class QrcodeApiController extends Controller
{
    public function indexApi(Request $request)
    {
        $user = Auth::user();
        $divisionId = $user->division_id;

        // Query untuk mengambil data QR codes milik user yang sedang login
        $qrcodes = Qrcodes::where('user_id', $user->id) // Hanya ambil user_id
                          ->orderBy('created_at', 'desc');

        // Query untuk mengambil data QR codes dari user lain di divisi yang sama
        $qrcodesDivisions = Qrcodes::query()
                            ->whereHas('user', function ($query) use ($divisionId, $user) {
                                $query->where('division_id', $divisionId)
                                      ->where('id', '!=', $user->id); // Pastikan bukan user yang sedang login
                            })
                            ->orderBy('created_at', 'desc')
                            ->get();

        // Jika ada input pencarian, tambahkan filter berdasarkan 'link' atau atribut lainnya
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $qrcodes->where('link', 'LIKE', '%' . $searchTerm . '%');
        }

        // Lakukan pagination, hasil 10 item per halaman
        $qrcodes = $qrcodes->paginate(10);

        // Return data dalam format JSON
        return response()->json([
            'qrcodes' => $qrcodes,
            'qrcodes_divisions' => $qrcodesDivisions,
        ], 200);
    }
    public function storeQrcode(Request $request)
    {
        // Ambil data pengguna yang sedang login
        $user = Auth::user();

        // Periksa apakah app_token ada pada user
        if (!$user || !$user->app_token) {
            return response()->json(['error' => 'User not authenticated or app_token missing.'], 401);
        }

        // Validasi input
        $validatedData = $request->validate([
            'link' => 'required|url',
        ]);

        // Generate QR Code
        $qrCodeSvg = QrCode::format('svg')->size(300)->errorCorrection('H')->generate($validatedData['link']);

        // Muat logo dari public_path dan encode sebagai base64
        $logoPath = public_path('logosier.png');
        if (!file_exists($logoPath)) {
            return response()->json(['error' => 'Logo tidak ditemukan.'], 404);
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
      try {
            $qrcode = Qrcodes::create([
                'qrcode' => $svgWithLogo,
                'link' => $validatedData['link'],
                'user_id' => $user->id,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menyimpan QR Code.'], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'QR Code dengan logo berhasil dibuat.',
            'data' => [
                'qrcode_id' => $qrcode->id,
                'qrcode' => $svgWithLogo,
                'link' => $validatedData['link'],
            ]
        ], 201);
    }

    public function destroy($id)
    {
        // Temukan QR Code berdasarkan ID
        $qrcode = Qrcodes::findOrFail($id);

        // Cek apakah pengguna yang terautentikasi adalah pemilik
        if ($qrcode->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }

        // Cek apakah shortlink_id bernilai null atau tidak
        if ($qrcode->shortlink_id !== null) {
            return response()->json(['error' => 'Cannot delete QR code with associated shortlink.'], 400);
        }

        // Hapus QR code
        $qrcode->delete();

        // Kembalikan respons sukses
        return response()->json(['success' => 'QR code deleted successfully.'], 200);
    }
}
