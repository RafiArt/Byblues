<?php

namespace App\Http\Controllers;

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
        return view('diagnosa.index');
    }

    /**
     * Show the form for creating a new resource.
     */
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
        //
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
