<?php

namespace App\Http\Controllers;

use App\Models\JenisSurat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class JenisSuratController extends Controller
{
    public function index(): View
    {
        $jenisSurats = JenisSurat::orderBy('nama_jenis_surat')->get();

        return view('administrasi.jenis-surat.index', compact('jenisSurats'));
    }

    public function create(): View
    {
        return view('administrasi.jenis-surat.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_jenis_surat' => [
                'required',
                'string',
                'max:255',
                Rule::unique('jenis_surat', 'nama_jenis_surat'),
            ],
        ]);

        JenisSurat::create($validated);

        return redirect()->route('administrasi.jenis-surat.index')
            ->with('success', 'Jenis Surat berhasil ditambahkan!');
    }

    public function show(JenisSurat $jenissurat): RedirectResponse
    {
        return redirect()->route('administrasi.jenis-surat.edit', $jenissurat);
    }

    public function edit(JenisSurat $jenissurat): View
    {
        return view('administrasi.jenis-surat.edit', [
            'jenisSurat' => $jenissurat,
        ]);
    }

    public function update(Request $request, JenisSurat $jenissurat): RedirectResponse
    {
        $validated = $request->validate([
            'nama_jenis_surat' => [
                'required',
                'string',
                'max:255',
                Rule::unique('jenis_surat', 'nama_jenis_surat')->ignore($jenissurat->id),
            ],
        ]);

        $jenissurat->update($validated);

        return redirect()->route('administrasi.jenis-surat.index')
            ->with('success', 'Jenis Surat berhasil diperbarui!');
    }

    public function destroy(JenisSurat $jenissurat): RedirectResponse
    {
        $jenissurat->delete();

        return redirect()->route('administrasi.jenis-surat.index')
            ->with('success', 'Jenis Surat berhasil dihapus!');
    }
}
