<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Qrcodes;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Intervention\Image\Facades\Image;

class QrcodeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $divisionId = $user->division_id;

        // Query untuk mengambil data QR codes milik user yang sedang login
        $qrcodes = Qrcodes::where('user_id', $user->id) // Hanya ambil user_id
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);

        // Query untuk mengambil data QR codes dari user lain di divisi yang sama
        $qrcodesDivisions = Qrcodes::query()
                            ->whereHas('user', function ($query) use ($divisionId, $user) {
                                $query->where('division_id', $divisionId)
                                      ->where('id', '!=', $user->id); // Pastikan bukan user yang sedang login
                            })
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);

        // Jika ada input pencarian, tambahkan filter berdasarkan 'link' atau atribut lainnya
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $qrcodes->where('link', 'LIKE', '%' . $searchTerm . '%');
        }

        // Return ke view dengan data yang dipaginate
        return view('qrcodes.index', compact('qrcodes'));
    }

    public function divisionQRcode(Request $request)
    {
        $user = Auth::user();
        $divisionId = $user->division_id;

        // Query untuk mengambil data QR codes dari user lain di divisi yang sama
        $qrcodesDivisions = Qrcodes::query()
            ->whereHas('user', function ($query) use ($divisionId, $user) {
                $query->where('division_id', $divisionId)
                    ->where('id', '!=', $user->id); // Pastikan bukan user yang sedang login
            });

        // Jika ada input pencarian, tambahkan filter berdasarkan 'link'
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $qrcodesDivisions->where('link', 'LIKE', '%' . $searchTerm . '%');
        }

        // Ambil data dengan urutan terbaru
        $qrcodesDivisions = $qrcodesDivisions->orderBy('created_at', 'desc')->paginate(10);

        // Return ke view dengan data
        return view('qrcodes.division-qrcode', compact('qrcodesDivisions'));
    }



    public function store(Request $request)
{
    // Validasi input
    $validatedData = $request->validate([
        'link' => 'required|url',
    ]);

    // Generate QR Code dalam format SVG dengan tingkat kesalahan yang lebih tinggi
    $qrCodeSvg = QrCode::format('svg')->size(300)->errorCorrection('H')->generate($validatedData['link']);

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

    // Simpan hasil SVG ke dalam database
    Qrcodes::create([
        'qrcode' => $svgWithLogo,
        'link' => $validatedData['link'],
        'user_id' => Auth::id(), // ID pengguna yang sedang login
        'shortlink_id' => null, // Sesuaikan sesuai kebutuhan
    ]);

    // Redirect kembali dengan pesan sukses
    return redirect()->route('qrcodes.index')->with('success', 'QR Code dengan logo berhasil dibuat.');
}


    public function download($id)
    {
        // Temukan QR code berdasarkan ID
        $qrcode = Qrcodes::findOrFail($id);

        // Generate gambar QR Code sebagai PNG
        $image = QrCode::format('png')->size(300)->generate($qrcode->link);

        // Buat respons untuk mendownload gambar
        return response($image)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="qrcode-' . $id . '.png"');
    }

    public function destroy($id)
    {
        // Find the QR code by ID
        $qrcode = Qrcodes::findOrFail($id);

        // Check if the authenticated user is the owner (optional)
        if ($qrcode->user_id !== Auth::id()) {
            return redirect()->route('qrcodes.index')->with('error', 'Unauthorized action.');
        }

        // Delete the QR code
        $qrcode->delete();

        // Redirect back with a success message
        return redirect()->route('qrcodes.index')->with('success', 'QR code deleted successfully.');
    }
}
