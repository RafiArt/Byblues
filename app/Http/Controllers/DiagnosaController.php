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
                } elseif ($peran === 'Orang Terdekat') {
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
                $solusi = '
                    <div class="flex flex-col items-start space-y-2">
                        <span><strong>Rekomendasi Penanganan</strong>:</span>
                        <ul class="list-disc ml-6 space-y-2">
                            <li><strong>Segera Konsultasi</strong>: Lakukan konsultasi dengan psikiater/psikolog untuk evaluasi mendalam dan penanganan intensif.</li>
                            <li><strong>Terapi Rutin</strong>: Ikuti jadwal terapi yang direkomendasikan, minimal 1-2 kali seminggu.</li>
                            <li><strong>Pengobatan</strong>: Ikuti anjuran pengobatan yang diberikan oleh profesional kesehatan.</li>
                            <li><strong>Monitoring</strong>: Catat perubahan mood dan perilaku setiap hari untuk evaluasi treatment.</li>
                        </ul>
                    </div>';
            } elseif ($score >= 10 && $score <= 12) {
                $hasil = 'Risiko Sedang Baby Blues';
                $solusi = '
                    <div class="flex flex-col items-start space-y-2">
                        <span><strong>Rekomendasi Penanganan</strong>:</span>
                        <ul class="list-disc ml-6 space-y-2">
                            <li><strong>Rencanakan Konsultasi</strong>: Catat gejala yang dialami dan buat jadwal konsultasi dengan profesional.</li>
                            <li><strong>Dokumentasi</strong>: Catat pola tidur, makan, dan pemicu stres untuk didiskusikan saat konsultasi.</li>
                            <li><strong>Support Group</strong>: Bergabung dengan kelompok dukungan ibu dengan baby blues.</li>
                            <li><strong>Manajemen Stres</strong>: Terapkan teknik relaksasi dan meditasi yang diajarkan profesional.</li>
                        </ul>
                    </div>';
            } elseif ($score >= 5 && $score <= 9) {
                $hasil = 'Risiko Rendah Baby Blues';
                $solusi = '
                    <div class="flex flex-col items-start space-y-2">
                        <span><strong>Rekomendasi Penanganan</strong>:</span>
                        <ul class="list-disc ml-6 space-y-2">
                            <li><strong>Komunitas</strong>: Bergabung dengan komunitas ibu baru untuk berbagi pengalaman.</li>
                            <li><strong>Self-Care</strong>: Luangkan waktu untuk aktivitas yang menyenangkan dan menenangkan.</li>
                            <li><strong>Istirahat Berkualitas</strong>: Atur jadwal tidur sesuai dengan jadwal tidur bayi.</li>
                            <li><strong>Komunikasi</strong>: Ungkapkan perasaan dan kekhawatiran kepada orang terdekat.</li>
                        </ul>
                    </div>';
            } else {
                $hasil = 'Tidak Ada Risiko Baby Blues';
                $solusi = '
                    <div class="flex flex-col items-start space-y-2">
                        <span><strong>Rekomendasi Penanganan</strong>:</span>
                        <ul class="list-disc ml-6 space-y-2">
                            <li><strong>Persiapan Mental</strong>: Ikuti kelas prenatal dan persiapkan mental sejak kehamilan.</li>
                            <li><strong>Pola Hidup</strong>: Pertahankan pola makan sehat dan istirahat yang cukup.</li>
                            <li><strong>Ekspektasi Realistis</strong>: Bangun pemahaman yang realistis tentang peran sebagai ibu baru.</li>
                            <li><strong>Relaksasi</strong>: Pelajari dan praktikkan teknik relaksasi secara rutin.</li>
                        </ul>
                    </div>';
            }
        } elseif (Auth::user()->peran == 'Suami') {
            if ($score >= 13) {
                $hasil = 'Risiko Tinggi Baby Blues';
                $solusi = '
                    <div class="flex flex-col items-start space-y-2">
                        <span><strong>Rekomendasi Penanganan</strong>:</span>
                        <ul class="list-disc ml-6 space-y-2">
                            <li><strong>Pendampingan Medis</strong>: Dampingi istri dalam setiap sesi terapi dan konsultasi.</li>
                            <li><strong>Pengambilalihan Tugas</strong>: Ambil alih sebagian besar tanggung jawab pengasuhan dan rumah tangga.</li>
                            <li><strong>Pemantauan Rutin</strong>: Pantau pengobatan dan perkembangan kondisi istri.</li>
                            <li><strong>Koordinasi</strong>: Berkoordinasi dengan tenaga medis tentang cara terbaik mendukung istri.</li>
                        </ul>
                    </div>';
            } elseif ($score >= 10 && $score <= 12) {
                $hasil = 'Risiko Sedang Baby Blues';
                $solusi = '
                    <div class="flex flex-col items-start space-y-2">
                        <span><strong>Rekomendasi Penanganan</strong>:</span>
                        <ul class="list-disc ml-6 space-y-2">
                            <li><strong>Dukungan Konsultasi</strong>: Bantu istri merencanakan dan mengatur jadwal konsultasi.</li>
                            <li><strong>Pembagian Tugas</strong>: Ambil lebih banyak tanggung jawab rumah tangga.</li>
                            <li><strong>Quality Time</strong>: Luangkan waktu khusus untuk mendengarkan dan mendukung istri.</li>
                            <li><strong>Pemantauan</strong>: Perhatikan perubahan mood dan perilaku istri.</li>
                        </ul>
                    </div>';
            } elseif ($score >= 5 && $score <= 9) {
                $hasil = 'Risiko Rendah Baby Blues';
                $solusi = '
                    <div class="flex flex-col items-start space-y-2">
                        <span><strong>Rekomendasi Penanganan</strong>:</span>
                        <ul class="list-disc ml-6 space-y-2">
                            <li><strong>Bantuan Aktif</strong>: Bantu perawatan bayi dan pekerjaan rumah tangga secara proaktif.</li>
                            <li><strong>Apresiasi</strong>: Berikan pujian dan apresiasi atas usaha istri dalam merawat bayi.</li>
                            <li><strong>Waktu Istirahat</strong>: Pastikan istri mendapat waktu istirahat yang cukup.</li>
                            <li><strong>Lingkungan Positif</strong>: Ciptakan suasana rumah yang tenang dan nyaman.</li>
                        </ul>
                    </div>';
            } else {
                $hasil = 'Tidak Ada Risiko Baby Blues';
                $solusi = '
                    <div class="flex flex-col items-start space-y-2">
                        <span><strong>Rekomendasi Penanganan</strong>:</span>
                        <ul class="list-disc ml-6 space-y-2">
                            <li><strong>Persiapan</strong>: Pelajari cara merawat bayi bersama istri sejak masa kehamilan.</li>
                            <li><strong>Keterlibatan</strong>: Terlibat aktif dalam persiapan kelahiran dan perawatan bayi.</li>
                            <li><strong>Pemahaman</strong>: Pelajari perubahan hormonal dan emosional yang akan dialami istri.</li>
                            <li><strong>Dukungan</strong>: Tunjukkan dukungan emosional dan jadilah pendengar yang baik.</li>
                        </ul>
                    </div>';
            }
        } elseif (Auth::user()->peran == 'Orang Terdekat') {
            if ($score >= 13) {
                $hasil = 'Risiko Tinggi Baby Blues';
                $solusi = '
                    <div class="flex flex-col items-start space-y-2">
                        <span><strong>Rekomendasi Penanganan</strong>:</span>
                        <ul class="list-disc ml-6 space-y-2">
                            <li><strong>Pengasuhan Intensif</strong>: Bantu pengasuhan bayi secara penuh jika diperlukan.</li>
                            <li><strong>Dukungan Terapi</strong>: Dukung proses terapi dan pengobatan secara konsisten.</li>
                            <li><strong>Pemulihan</strong>: Ciptakan lingkungan yang mendukung proses pemulihan.</li>
                            <li><strong>Koordinasi Medis</strong>: Bantu koordinasi dengan tim medis untuk pemantauan kondisi.</li>
                        </ul>
                    </div>';
            } elseif ($score >= 10 && $score <= 12) {
                $hasil = 'Risiko Sedang Baby Blues';
                $solusi = '
                    <div class="flex flex-col items-start space-y-2">
                        <span><strong>Rekomendasi Penanganan</strong>:</span>
                        <ul class="list-disc ml-6 space-y-2">
                            <li><strong>Dukungan Konsultasi</strong>: Bantu mengatur jadwal dan transportasi untuk konsultasi.</li>
                            <li><strong>Bantuan Praktis</strong>: Berikan bantuan intensif dalam perawatan bayi.</li>
                            <li><strong>Sistem Pendukung</strong>: Jadilah sistem pendukung yang stabil dan dapat diandalkan.</li>
                            <li><strong>Perhatikan</strong>: Perhatikan perubahan pola makan, istirahat, mood dan perilaku ibu.</li>
                        </ul>
                    </div>';
            } elseif ($score >= 5 && $score <= 9) {
                $hasil = 'Risiko Rendah Baby Blues';
                $solusi = '
                    <div class="flex flex-col items-start space-y-2">
                        <span><strong>Rekomendasi Penanganan</strong>:</span>
                        <ul class="list-disc ml-6 space-y-2">
                            <li><strong>Bantuan Fleksibel</strong>: Berikan bantuan sesuai kebutuhan tanpa memaksa.</li>
                            <li><strong>Waktu Istirahat</strong>: Tawarkan bantuan agar ibu bisa beristirahat.</li>
                            <li><strong>Lingkungan Positif</strong>: Hindari kritik dan komentar negatif.</li>
                            <li><strong>Dukungan Praktis</strong>: Bantu biar bisa jadi pendengar yang baik untuk ibu.</li>
                        </ul>
                    </div>';
            } else {
                $hasil = 'Tidak Ada Risiko Baby Blues';
                $solusi = '
                    <div class="flex flex-col items-start space-y-2">
                        <span><strong>Rekomendasi Penanganan</strong>:</span>
                        <ul class="list-disc ml-6 space-y-2">
                            <li><strong>Pengalaman Positif</strong>: Berbagi pengalaman pengasuhan yang positif.</li>
                            <li><strong>Persiapan</strong>: Bantu mempersiapkan keperluan bayi tanpa menimbulkan tekanan.</li>
                            <li><strong>Dukungan Moral</strong>: Berikan dukungan moral yang membangun.</li>
                            <li><strong>Penghargaan</strong>: Hormati keputusan ibu dalam pengasuhan anak.</li>
                        </ul>
                    </div>';
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
        $diagnosa = Diagnosa::find($id);

        $user = Auth::user();
        if (!$diagnosa){
            abort(404);
        }

        if ($diagnosa->user_id != $user->id || $user->roles[0]->name == 'administrator' ) {
            abort(403, 'Unauthorized action.');
        }



        return view('diagnosa.detail', data: compact('diagnosa'));
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
    public function destroy($id)
    {
        // Find the diagnosa by ID
        $diagnosa = Diagnosa::findOrFail($id);

        // Delete the diagnosa record
        $diagnosa->delete();

        // Redirect back with a success message
        return redirect()->route('diagnosa.index')->with('success', 'Diagnosa deleted successfully');
    }

}
