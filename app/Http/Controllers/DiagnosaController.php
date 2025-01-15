<?php

namespace App\Http\Controllers;

use App\Models\Diagnosa;
use App\Models\Gejala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiagnosaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        session()->forget(['diagnosa_temp', 'diagnosa_tanggal']);

        $user = Auth::user();
        // Ambil data berdasarkan role
        if ($user->roles[0]->name == 'administrator') {
            $diagnosas = Diagnosa::with('user') // Include the users relationship
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            // If the role is user, retrieve data based on user_id
            $diagnosas = Diagnosa::with('user') // Include the users relationship
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }


        // Kirim data ke view
        return view('diagnosa.index', compact('diagnosas'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function saveTemp(Request $request)
    {
        $existingTempData = session('diagnosa_temp', [
            'tanggal' => '',
            'kondisi' => []
        ]);

        $mergedKondisi = array_merge(
            $existingTempData['kondisi'] ?? [],
            $request->kondisi ?? []
        );

        $tempData = [
            'tanggal' => $request->tanggal ?? $existingTempData['tanggal'],
            'kondisi' => $mergedKondisi
        ];

        session(['diagnosa_temp' => $tempData]);
        session(['diagnosa_tanggal' => $request->tanggal]);

        return redirect()->route('diagnosa.create', ['kategori' => $request->next_kategori]);
    }



    public function create(Request $request)
    {
        // Ambil semua kategori yang unik
        $kategoriList = Gejala::where('kategori', '!=', null)
            ->distinct()
            ->pluck('kategori');

        // Ambil kategori saat ini dari query string atau gunakan yang pertama
        $currentKategori = $request->query('kategori', $kategoriList->first());

        // Ambil gejala untuk kategori saat ini
        $gejala = Gejala::where('kategori', $currentKategori)
            ->where(function($query) {
                $peran = Auth::user()->peran;
                if ($peran === 'Ibu') {
                    $query->where('kode', 'LIKE', 'IB%');
                } elseif ($peran === 'Suami') {
                    $query->where('kode', 'LIKE', 'SU%');
                } elseif ($peran === 'Orang Tua') {
                    $query->where('kode', 'LIKE', 'OT%');
                }
            })
            ->get()
            ->groupBy('kategori');

        // Cari indeks kategori saat ini
        $currentIndex = $kategoriList->search($currentKategori);

        // Tentukan kategori sebelumnya dan selanjutnya
        $previousKategori = $currentIndex > 0 ? $kategoriList[$currentIndex - 1] : null;
        $nextKategori = $currentIndex < $kategoriList->count() - 1 ? $kategoriList[$currentIndex + 1] : null;


        return view('diagnosa.create', compact(
            'gejala',
            'kategoriList',
            'currentKategori',
            'previousKategori',
            'nextKategori'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Get temporary data from session
        $tempData = session('diagnosa_temp', [
            'tanggal' => '',
            'kondisi' => []
        ]);

        // Merge with any new conditions from the final submission
        $allKondisi = array_merge(
            $tempData['kondisi'] ?? [],
            $request->kondisi ?? []
        );

        // Calculate MB and MD for each answer
        $totalMB = 0;
        $totalMD = 0;
        $numberOfAnswers = count($allKondisi);

        foreach ($allKondisi as $jawaban) {
            switch ($jawaban) {
                case 'ya':
                    $totalMB += 1; // Full belief that supports baby blues
                    $totalMD += 0; // No disbelief
                    break;
                case 'bisa jadi':
                    $totalMB += 0.5; // Partial belief
                    $totalMD += 0.5; // Partial disbelief
                    break;
                case 'tidak':
                    $totalMB += 0; // No belief
                    $totalMD += 1; // Full disbelief
                    break;
            }
        }

        // Calculate average MB and MD
        $MB = $totalMB / $numberOfAnswers;
        $MD = $totalMD / $numberOfAnswers;

        // Calculate CF using the formula CF[h,e] = MB[h,e] - MD[h,e]
        $cf_value = $MB - $MD;

        // Convert CF value to score range (0-20 scale for classification)
        // Hanya menggunakan nilai positif untuk menunjukkan risiko
        // Nilai negatif akan menjadi 0 (tidak ada risiko)
        $score = max(0, $cf_value * 20);

        // Determine risk level and recommendations
        if (Auth::user()->peran == 'Ibu') {
            if ($score >= 13) {
                $hasil = 'Risiko Tinggi Baby Blues';
                $solusi = "Rekomendasi Penanganan:\n" .
                    "* Segera Konsultasi: Lakukan konsultasi dengan psikiater/psikolog untuk evaluasi mendalam dan penanganan intensif.\n" .
                    "* Terapi Rutin: Ikuti jadwal terapi yang direkomendasikan, minimal 1-2 kali seminggu.\n" .
                    "* Pengobatan: Ikuti anjuran pengobatan yang diberikan oleh profesional kesehatan.\n" .
                    "* Monitoring: Catat perubahan mood dan perilaku setiap hari untuk evaluasi treatment.";
            } elseif ($score >= 10 && $score <= 12) {
                $hasil = 'Risiko Sedang Baby Blues';
                $solusi = "Rekomendasi Penanganan:\n" .
                    "* Rencanakan Konsultasi: Catat gejala yang dialami dan buat jadwal konsultasi dengan profesional.\n" .
                    "* Dokumentasi: Catat pola tidur, makan, dan pemicu stres untuk didiskusikan saat konsultasi.\n" .
                    "* Support Group: Bergabung dengan kelompok dukungan ibu dengan baby blues.\n" .
                    "* Manajemen Stres: Terapkan teknik relaksasi dan meditasi yang diajarkan profesional.";
            } elseif ($score >= 5 && $score <= 9) {
                $hasil = 'Risiko Rendah Baby Blues';
                $solusi = "Rekomendasi Penanganan:\n" .
                    "* Komunitas: Bergabung dengan komunitas ibu baru untuk berbagi pengalaman.\n" .
                    "* Self-Care: Luangkan waktu untuk aktivitas yang menyenangkan dan menenangkan.\n" .
                    "* Istirahat Berkualitas: Atur jadwal tidur sesuai dengan jadwal tidur bayi.\n" .
                    "* Komunikasi: Ungkapkan perasaan dan kekhawatiran kepada orang terdekat.";
            } else {
                $hasil = 'Tidak Ada Risiko Baby Blues';
                $solusi = "Rekomendasi Penanganan:\n" .
                    "* Persiapan Mental: Ikuti kelas prenatal dan persiapkan mental sejak kehamilan.\n" .
                    "* Pola Hidup: Pertahankan pola makan sehat dan istirahat yang cukup.\n" .
                    "* Ekspektasi Realistis: Bangun pemahaman yang realistis tentang peran sebagai ibu baru.\n" .
                    "* Relaksasi: Pelajari dan praktikkan teknik relaksasi secara rutin.";
            }
        } elseif (Auth::user()->peran == 'Suami') {
            if ($score >= 13) {
                $hasil = 'Risiko Tinggi Baby Blues';
                $solusi = "Rekomendasi Penanganan:\n" .
                    "* Pendampingan Medis: Dampingi istri dalam setiap sesi terapi dan konsultasi.\n" .
                    "* Pengambilalihan Tugas: Ambil alih sebagian besar tanggung jawab pengasuhan dan rumah tangga.\n" .
                    "* Pemantauan Rutin: Pantau pengobatan dan perkembangan kondisi istri.\n" .
                    "* Koordinasi: Berkoordinasi dengan tenaga medis tentang cara terbaik mendukung istri.";
            } elseif ($score >= 10 && $score <= 12) {
                $hasil = 'Risiko Sedang Baby Blues';
                $solusi = "Rekomendasi Penanganan:\n" .
                    "* Dukungan Konsultasi: Bantu istri merencanakan dan mengatur jadwal konsultasi.\n" .
                    "* Pembagian Tugas: Ambil lebih banyak tanggung jawab rumah tangga.\n" .
                    "* Quality Time: Luangkan waktu khusus untuk mendengarkan dan mendukung istri.\n" .
                    "* Pemantauan: Perhatikan perubahan mood dan perilaku istri.";
            } elseif ($score >= 5 && $score <= 9) {
                $hasil = 'Risiko Rendah Baby Blues';
                $solusi = "Rekomendasi Penanganan:\n" .
                    "* Bantuan Aktif: Bantu perawatan bayi dan pekerjaan rumah tangga secara proaktif.\n" .
                    "* Apresiasi: Berikan pujian dan apresiasi atas usaha istri dalam merawat bayi.\n" .
                    "* Waktu Istirahat: Pastikan istri mendapat waktu istirahat yang cukup.\n" .
                    "* Lingkungan Positif: Ciptakan suasana rumah yang tenang dan nyaman.";
            } else {
                $hasil = 'Tidak Ada Risiko Baby Blues';
                $solusi = "Rekomendasi Penanganan:\n" .
                    "* Persiapan: Pelajari cara merawat bayi bersama istri sejak masa kehamilan.\n" .
                    "* Keterlibatan: Terlibat aktif dalam persiapan kelahiran dan perawatan bayi.\n" .
                    "* Pemahaman: Pelajari perubahan hormonal dan emosional yang akan dialami istri.\n" .
                    "* Dukungan: Tunjukkan dukungan emosional dan jadilah pendengar yang baik.";
            }
        } elseif (Auth::user()->peran == 'Orang Tua') {
            if ($score >= 13) {
                $hasil = 'Risiko Tinggi Baby Blues';
                $solusi = "Rekomendasi Penanganan:\n" .
                    "* Pengasuhan Intensif: Bantu pengasuhan bayi secara penuh jika diperlukan.\n" .
                    "* Dukungan Terapi: Dukung proses terapi dan pengobatan secara konsisten.\n" .
                    "* Pemulihan: Ciptakan lingkungan yang mendukung proses pemulihan.\n" .
                    "* Koordinasi Medis: Bantu koordinasi dengan tim medis untuk pemantauan kondisi.";
            } elseif ($score >= 10 && $score <= 12) {
                $hasil = 'Risiko Sedang Baby Blues';
                $solusi = "Rekomendasi Penanganan:\n" .
                    "* Dukungan Konsultasi: Bantu mengatur jadwal dan transportasi untuk konsultasi.\n" .
                    "* Bantuan Praktis: Berikan bantuan intensif dalam perawatan bayi dan rumah tangga.\n" .
                    "* Sistem Pendukung: Jadilah sistem pendukung yang stabil dan dapat diandalkan.\n" .
                    "* Pemahaman: Pahami pentingnya penanganan profesional tanpa menghakimi.";
            } elseif ($score >= 5 && $score <= 9) {
                $hasil = 'Risiko Rendah Baby Blues';
                $solusi = "Rekomendasi Penanganan:\n" .
                    "* Bantuan Fleksibel: Berikan bantuan sesuai kebutuhan tanpa memaksa.\n" .
                    "* Waktu Istirahat: Tawarkan bantuan agar pasangan bisa beristirahat.\n" .
                    "* Lingkungan Positif: Hindari kritik dan komentar negatif.\n" .
                    "* Dukungan Praktis: Bantu pekerjaan rumah tangga sesuai kebutuhan.";
            } else {
                $hasil = 'Tidak Ada Risiko Baby Blues';
                $solusi = "Rekomendasi Penanganan:\n" .
                    "* Pengalaman Positif: Berbagi pengalaman pengasuhan yang positif.\n" .
                    "* Persiapan: Bantu mempersiapkan keperluan bayi tanpa menimbulkan tekanan.\n" .
                    "* Dukungan Moral: Berikan dukungan moral yang membangun.\n" .
                    "* Penghargaan: Hormati keputusan pasangan dalam pengasuhan anak.";
            }
        }

        // Store single record in database
        Diagnosa::create([
            'user_id' => Auth::id(),
            'hasil' => $hasil,
            'cf_value' => $cf_value,
            'solusi' => $solusi,
            'tanggal' => $tempData['tanggal']
        ]);

        // Clear temporary session data
        session()->forget(['diagnosa_temp', 'diagnosa_tanggal']);

        return redirect()->route('diagnosa.index')
            ->with('success', 'Diagnosa berhasil disimpan');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
