<?php
namespace App\Http\Controllers;

use App\Models\Surats;
use App\Models\JenisSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class AdministrasiController extends Controller {
    public function index(Request $request)
    {
        $query = Surats::with('jenis');
        
        // Filter berdasarkan guest
        if ($request->has('show_guest')) {
            $query->where('is_from_guest', true);            
        }
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('pengirim', 'like', "%{$search}%");
            });
        }

        // Sorting
        if ($request->filled('sort')) {
            $column = $request->input('sort');
            $order = $request->input('order', 'asc');
            
            // Mapping untuk field yang benar
            $sortColumns = [
                'tanggal_surat' => 'tanggal_surat',
                'tanggal_masuk' => 'tanggal_masuk', 
                'jenis_surat_id' => 'jenis_surat_id'
            ];
            
            if (array_key_exists($column, $sortColumns)) {
                $query->orderBy($sortColumns[$column], $order);
            }
        } else {
            // Default sorting
            $query->orderBy('created_at', 'desc');
        }
        
        // Pagination dengan 10 data per halaman
        $surat = $query->paginate(10)->withQueryString();
        
        return view('administrasi.surat.index', compact('surat'));
    }

    public function dashboard()
    {
        $totalSurat = Surats::count();
        return view('administrasi.dashboard', compact('totalSurat'));
    }

    public function create() {
        $types = JenisSurat::all();
        return view('administrasi.surat.create', compact('types'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_masuk' => 'required|date',
            'pengirim' => 'required|string|max:255',
            'keterangan' => 'required|string|max:500', // Diperbesar untuk keterangan panjang
            'jenis_surat_id' => 'required|exists:jenis_surat,id',
            'file' => 'nullable|file|mimes:pdf|max:2048'
        ]);

        // Format tanggal
        $data['tanggal_surat'] = date('Y-m-d', strtotime($request->tanggal_surat));
        $data['tanggal_masuk'] = date('Y-m-d', strtotime($request->tanggal_masuk));

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('surat_pdfs', 'public');
        }

        $data['created_by'] = auth()->id();
        Surats::create($data);

        return redirect()->route('administrasi.surat.index')->with('success', 'File surat berhasil diunggah.');
    }

    public function edit(Surats $surat) {
        $types = JenisSurat::all();
        return view('administrasi.surat.edit', compact('surat', 'types'));
    }

    public function update(Request $request, Surats $surat) {
        $data = $request->validate([
            'jenis_surat_id' => 'required|exists:jenis_surat,id',
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_masuk' => 'required|date',
            'pengirim' => 'required|string|max:255',
            'keterangan' => 'required|string|max:500', // Diperbesar untuk keterangan panjang
            'file' => 'nullable|file|mimes:pdf|max:2048'
        ]);

        $data['tanggal_surat'] = date('Y-m-d', strtotime($request->tanggal_surat));
        $data['tanggal_masuk'] = date('Y-m-d', strtotime($request->tanggal_masuk));

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('surat_pdfs', 'public');
        }

        $surat->update($data);

        return redirect()->route('administrasi.surat.index')->with('success', 'Data surat berhasil diperbarui.');
    }

    public function destroy(Surats $surat) {
        $surat->delete();
        return back()->with('success', 'Data surat berhasil dihapus.');
    }
}