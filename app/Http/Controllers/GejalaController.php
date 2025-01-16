<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GejalaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil data berdasarkan role
        if ($user->roles[0]->name == 'administrator') {
            $gejalas = Gejala::orderBy('created_at', 'desc')->paginate(10);
            $gejalas->getCollection()->transform(function ($gejala) {
                // Menentukan peran berdasarkan prefix pada kolom kode
                if (str_starts_with($gejala->kode, 'OT')) {
                    $gejala->peran = 'Orang tua';
                } elseif (str_starts_with($gejala->kode, 'SU')) {
                    $gejala->peran = 'Suami';
                } elseif (str_starts_with($gejala->kode, 'IB')) {
                    $gejala->peran = 'Ibu';
                } else {
                    $gejala->peran = 'Tidak diketahui';
                }
                return $gejala;
            });
        } else {
            // Jika role adalah user, filter berdasarkan ID pengguna
            $gejalas = Gejala::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            $gejalas->getCollection()->transform(function ($gejala) {
                // Menentukan peran berdasarkan prefix pada kolom kode
                if (str_starts_with($gejala->kode, 'OT')) {
                    $gejala->peran = 'Orang tua';
                } elseif (str_starts_with($gejala->kode, 'SU')) {
                    $gejala->peran = 'Suami';
                } elseif (str_starts_with($gejala->kode, 'IB')) {
                    $gejala->peran = 'Ibu';
                } else {
                    $gejala->peran = 'Tidak diketahui';
                }
                return $gejala;
            });
        }

        // Kirim data ke view
        return view('admin.gejala.index', compact('gejalas'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi input, termasuk kategori
            $request->validate([
                'kode' => 'required|unique:gejalas,kode', // Kode harus unik
                'keterangan' => 'required',
                'kategori' => 'required|in:Kesejahteraan Emosional,Kesejahteraan Fisik,Hubungan Sosial,Peran dan Dukungan Keluarga', // Validasi kategori harus sesuai daftar opsi
            ], [
                'kode.unique' => 'Kode gejala sudah ada.',
                'kategori.in' => 'Kategori yang dipilih tidak valid.',
            ]);

            // Simpan data gejala ke database
            Gejala::create($request->all());

            // Kirimkan pesan sukses ke session
            return redirect()->route('gejala.index')->with('success', 'Gejala berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Jika ada error, kirimkan pesan error ke session
            return redirect()->route('gejala.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }



    public function update(Request $request, Gejala $gejala)
    {
        try {
            // Validate the input
            $validated = $request->validate([
                'kode' => 'unique:gejalas,kode,' . $gejala->id . '|max:10', // Unique, excluding current Gejala id
                'keterangan' => 'max:255',
                'kategori' => 'in:Kesejahteraan Emosional,Kesejahteraan Fisik,Hubungan Sosial,Peran dan Dukungan Keluarga',
            ], [
                'kode.unique' => 'Kode gejala sudah ada.',
                'keterangan.max' => 'Keterangan maksimal 255 karakter.',
            ]);

            // Update the gejala data
            $gejala->update($validated);

            // Redirect back with success message
            return redirect()->route('gejala.index')->with('success', 'Gejala berhasil diupdate.');
        } catch (\Exception $e) {
            // Jika ada error, kirimkan pesan error ke session
            return redirect()->route('gejala.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function destroy(Gejala $gejala)
    {
        $gejala->delete();

        return redirect()->route('gejala.index')
            ->with('success', 'Gejala berhasil dihapus.');
    }
}
