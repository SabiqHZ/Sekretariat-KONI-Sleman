<?php

namespace App\Http\Controllers;

use App\Models\JenisSurat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JenisSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenisSurats = JenisSurat::all();
        return view('JenisSurat.index', compact('jenisSurats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('administrasi.JenisSurat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_surat' => [
                'required',
                'string',
                'max:255',
                Rule::unique('jenis_surat'),
            ],
        ]);

        JenisSurat::create($request->only('jenis_surat'));

        return redirect()->route('administrasi.dashboard')
            ->with('success', 'Jenis Surat berhasil ditambahkan!');
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
        $request->validate([
            'jenis_surat' => [
                'required',
                'string',
                'max:255',
                Rule::unique('jenis_surat')->ignore($id),
            ],

        ]);

        $jenisSurat = JenisSurat::findOrFail($id);
        $jenisSurat->update($request->only('jenis_surat'));


        return redirect()->route('administrasi.index')
            ->with('success', 'Jenis Surat berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisSurat $jenisSurat)
    {
        $jenisSurat->delete();

        return redirect()->route('administrasi.JenisSurat.index')
            ->with('success', 'Jenis Surat berhasil dihapus!');
    }
}
