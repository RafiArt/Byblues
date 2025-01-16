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
    public function index(Request $request)
    {
        $user = Auth::user();

        // Get search query, category, and role filter from the request
        $search = $request->input('search');
        $kategori = $request->input('kategori');
        $peran = $request->input('peran');

        // Query builder
        $gejalas = Gejala::query();

        // Apply filters
        if ($user->roles[0]->name == 'administrator') {
            // If user is an admin, allow all data
            if ($search) {
                $gejalas->where('kode', 'like', '%' . $search . '%');
            }
            if ($kategori) {
                $gejalas->where('kategori', $kategori);
            }
            if ($peran) {
                $gejalas->where('kode', 'like', $this->getPeranPrefix($peran) . '%');
            }
        } else {
            // If user is a regular user, filter by user_id
            $gejalas->where('user_id', $user->id);
            if ($search) {
                $gejalas->where('kode', 'like', '%' . $search . '%');
            }
            if ($kategori) {
                $gejalas->where('kategori', $kategori);
            }
            if ($peran) {
                $gejalas->where('kode', 'like', $this->getPeranPrefix($peran) . '%');
            }
        }

        // Paginate the results
        $gejalas = $gejalas->orderBy('created_at', 'desc')->paginate(10);

        // Add peran attribute to each gejala
        $gejalas->getCollection()->transform(function ($gejala) {
            $gejala->peran = $this->getPeran($gejala->kode);
            return $gejala;
        });

        // Return the view with the results and filter values
        return view('admin.gejala.index', compact('gejalas', 'search', 'kategori', 'peran'));
    }

    // Helper function to get peran based on kode prefix
    private function getPeran($kode)
    {
        if (str_starts_with($kode, 'OT')) {
            return 'Orang tua';
        } elseif (str_starts_with($kode, 'SU')) {
            return 'Suami';
        } elseif (str_starts_with($kode, 'IB')) {
            return 'Ibu';
        }
        return 'Tidak diketahui';
    }

    // Helper function to get peran prefix
    private function getPeranPrefix($peran)
    {
        switch ($peran) {
            case 'Orang tua':
                return 'OT';
            case 'Suami':
                return 'SU';
            case 'Ibu':
                return 'IB';
            default:
                return '';
        }
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
