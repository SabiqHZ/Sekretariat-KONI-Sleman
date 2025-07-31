<?php

namespace App\Http\Controllers;

use App\Models\Surats;
use App\Models\JenisSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuestSuratController extends Controller
{
    public function create()
    {
        $types = JenisSurat::all();
        return view('guest.surat.create', compact('types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'tanggal_surat' => 'required|date',
            'pengirim' => 'required|string|max:255',
            'jenis_surat_id' => 'required|exists:jenis_surat,id',
            'keterangan' => 'nullable|string',
            'file' => 'required|file|mimes:pdf|max:2048'
        ]);

        // Simpan file
        $filePath = $request->file('file')->store('surat_pdfs', 'public');

        // Simpan data surat
        Surats::create([
            'nomor_surat' => $validated['nomor_surat'],
            'tanggal_surat' => $validated['tanggal_surat'],
            'pengirim' => $validated['pengirim'],
            'jenis_surat_id' => $validated['jenis_surat_id'],
            'keterangan' => $validated['keterangan'],
            'file_path' => $filePath,
            'is_from_guest' => true,
            'guest_email' => $validated['guest_email'],
            'created_by' => null // Karena guest tidak login
        ]);

        return redirect()->route('guest.surat.create')
            ->with('success', 'Surat berhasil dikirim! Kami akan menghubungi via email.');
    }
}
