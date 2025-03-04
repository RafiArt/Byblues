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
                            <li>Lakukan konsultasi dengan psikiater/psikolog untuk evaluasi mendalam dan penanganan intensif.</li>
                            <li>Ikuti jadwal terapi intensif atau terapi kognitif-perilaku, minimal 1-2 kali seminggu.</li>
                            <li>Konsumsi obat farmakologis di bawah pengawasan ahli jika diperlukan.</li>
                            <li>Lakukan pencatatan  perubahan mood dan perilaku setiap hari untuk evaluasi treatment.</li>
                            <li>Praktikkan teknik relaksasi dan pernapasan.</li>
                            <li>Fokus pada nutrisi seimbang dan istirahat yang cukup.</li>
                            <li>Hindari isolasi sosial, tetap terhubung dengan support system.</li>
                        </ul>
                    </div>';
            } elseif ($score >= 10 && $score <= 12) {
                $hasil = 'Risiko Sedang Baby Blues';
                $solusi = '
                    <div class="flex flex-col items-start space-y-2">
                        <span><strong>Rekomendasi Penanganan</strong>:</span>
                        <ul class="list-disc ml-6 space-y-2">
                            <li>Catat gejala yang dialami dan buat jadwal konsultasi dengan profesional.</li>
                            <li>Bergabung dengan support group ibu baru bila ada.</li>
                            <li>Praktikkan manajemen stres (meditasi, yoga ringan).</li>
                            <li>Dokumentasikan pola tidur, makan, dan pemicu emosional.</li>
                            <li>Tetapkan rutinitas harian yang terstruktur.</li>
                            <li>Batasi paparan informasi yang berpotensi meningkatkan kecemasan.</li>
                            <li>Lakukan aktivitas menyenangkan minimal 30 menit sehari.</li>
                        </ul>
                    </div>';
            } elseif ($score >= 5 && $score <= 9) {
                $hasil = 'Risiko Rendah Baby Blues';
                $solusi = '
                    <div class="flex flex-col items-start space-y-2">
                        <span><strong>Rekomendasi Penanganan</strong>:</span>
                        <ul class="list-disc ml-6 space-y-2">
                            <li>Praktikkan self-care secara rutin.</li>
                            <li>Atur jadwal tidur selaras dengan bayi.</li>
                            <li>Lakukan aktivitas yang menyenangkan.</li>
                            <li>Komunikasikan perasaan dengan pasangan/keluarga.</li>
                            <li>Tetapkan batasan dan prioritas.</li>
                            <li>Terima bantuan yang ditawarkan.</li>
                        </ul>
                    </div>';
            } else {
                $hasil = 'Tidak Ada Risiko Baby Blues';
                $solusi = '
                    <div class="flex flex-col items-start space-y-2">
                        <span><strong>Rekomendasi Penanganan</strong>:</span>
                        <ul class="list-disc ml-6 space-y-2">
                            <li>Ikuti kelas prenatal dan persiapkan mental sejak kehamilan.</li>
                            <li>Pertahankan pola makan sehat dan istirahat yang cukup.</li>
                            <li>Bangun ekspektasi realistis tentang pengasuhan.</li>
                            <li>Pelajari dan praktikkan teknik relaksasi secara rutin.</li>
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
                            <li>Dampingi istri dalam setiap sesi terapi dan konsultasi.</li>
                            <li>Ambil alih sebagian besar tanggung jawab pengasuhan dan rumah tangga.</li>
                            <li>Sediakan waktu istirahat dan pemulihan berkualitas.</li>
                            <li>Pantau kondisi istri secara konsisten.</li>
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
                            <li>Berikan waktu khusus untuk mendengarkan tanpa menghakimi.</li>
                            <li>Perhatikan perubahan mood dan perilaku istri.</li>
                            <li>Berikan apresiasi dan dukungan positif</li>
                        </ul>
                    </div>';
            } elseif ($score >= 5 && $score <= 9) {
                $hasil = 'Risiko Rendah Baby Blues';
                $solusi = '
                    <div class="flex flex-col items-start space-y-2">
                        <span><strong>Rekomendasi Penanganan</strong>:</span>
                        <ul class="list-disc ml-6 space-y-2">
                            <li>Bantu perawatan bayi dan pekerjaan rumah tangga secara proaktif.</li>
                            <li>Berikan apresiasi pada upaya istri.</li>
                            <li>Pastikan istri mendapat waktu istirahat yang cukup.</li>
                            <li>Ciptakan lingkungan positif dan mendukung.</li>
                        </ul>
                    </div>';
            } else {
                $hasil = 'Tidak Ada Risiko Baby Blues';
                $solusi = '
                    <div class="flex flex-col items-start space-y-2">
                        <span><strong>Rekomendasi Penanganan</strong>:</span>
                        <ul class="list-disc ml-6 space-y-2">
                            <li>Pelajari fase kehamilan dan pasca melahirkan.</li>
                            <li>Terlibat aktif dalam persiapan kelahiran dan perawatan bayi.</li>
                            <li>Pelajari perubahan hormonal dan emosional yang akan dialami istri.</li>
                            <li>Tunjukkan dukungan emosional dan jadilah pendengar yang baik.</li>
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
                            <li>Bantu pengasuhan bayi secara penuh.</li>
                            <li>Koordinasi dengan tim medis untuk pemantauan.</li>
                            <li>Ciptakan lingkungan aman dan nyaman.</li>
                            <li>Hindari kritikan atau tekanan tambahan.</li>
                        </ul>
                    </div>';
            } elseif ($score >= 10 && $score <= 12) {
                $hasil = 'Risiko Sedang Baby Blues';
                $solusi = '
                    <div class="flex flex-col items-start space-y-2">
                        <span><strong>Rekomendasi Penanganan</strong>:</span>
                        <ul class="list-disc ml-6 space-y-2">
                            <li>Bantu mengatur jadwal dan transportasi untuk konsultasi.</li>
                            <li>Berikan bantuan intensif dalam perawatan bayi.</li>
                            <li>Jadilah sistem pendukung yang stabil dan dapat diandalkan.</li>
                            <li>Perhatikan perubahan pola makan, istirahat, mood dan perilaku ibu.</li>
                        </ul>
                    </div>';
            } elseif ($score >= 5 && $score <= 9) {
                $hasil = 'Risiko Rendah Baby Blues';
                $solusi = '
                    <div class="flex flex-col items-start space-y-2">
                        <span><strong>Rekomendasi Penanganan</strong>:</span>
                        <ul class="list-disc ml-6 space-y-2">
                            <li>Berikan bantuan sesuai kebutuhan tanpa memaksa.</li>
                            <li>Tawarkan bantuan agar ibu bisa beristirahat.</li>
                            <li>Hindari kritik dan komentar negatif.</li>
                            <li>Bantu biar bisa jadi pendengar yang baik untuk ibu.</li>
                        </ul>
                    </div>';
            } else {
                $hasil = 'Tidak Ada Risiko Baby Blues';
                $solusi = '
                    <div class="flex flex-col items-start space-y-2">
                        <span><strong>Rekomendasi Penanganan</strong>:</span>
                        <ul class="list-disc ml-6 space-y-2">
                            <li>Berbagi pengalaman positif pengasuhan.</li>
                            <li>Bantu mempersiapkan keperluan bayi.</li>
                            <li>Berikan dukungan moral konstruktif.</li>
                            <li>Hormati keputusan pengasuhan.</li>
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
