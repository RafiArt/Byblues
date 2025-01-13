<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use Illuminate\Http\Request;

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
    public function create()
    {
        // Ambil data gejala dari database
        $gejala = Gejala::where('kategori', '!=', null)  // pastikan kategori tidak kosong
            ->get()
            ->groupBy('kategori');  // Kelompokkan berdasarkan kategori

        // Passing data gejala ke view
        return view('diagnosa.create', compact('gejala'));
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
