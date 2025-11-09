<?php

namespace App\Http\Controllers;

use App\Models\Surats;
use App\Models\JenisSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdministrasiController extends Controller
{

    public function index(Request $request)
    {
        $query = Surats::with('jenis');

        // Filter based on guest
        if ($request->has('show_guest')) {
            $query->where('is_from_guest', true);
        }

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                    ->orWhere('instansi_pengirim', 'like', "%{$search}%");
            });
        }

        // Sorting
        if ($request->filled('sort')) {
            $column = $request->input('sort');
            $order = $request->input('order', 'asc');

            $sortColumns = [
                'tanggal_surat' => 'tanggal_surat',
                'tanggal_masuk' => 'tanggal_masuk',
                'jenis_surat_id' => 'jenis_surat_id',
                'nomor_surat' => 'nomor_surat',
            ];

            if (array_key_exists($column, $sortColumns)) {
                $query->orderBy($sortColumns[$column], $order);
            }
        } else {
            // Default sorting
            $query->orderBy('created_at', 'desc');
        }

        $surat = $query->paginate(10)->withQueryString();
        $isSupervisor = Auth::user()->role === 'supervisor';

        return view('administrasi.surat.index', compact('surat', 'isSupervisor'));
    }

    public function dashboard()
    {
        $totalSurat = Surats::count();
        $suratFromGuest = DB::table('surats')
            ->where('is_from_guest', 1)
            ->count();
        $recentSurat = Surats::with('jenis')
            ->orderByDesc('tanggal_masuk')   // atau created_at kalau lebih aman
            ->paginate(10);                  // 10 per halaman, silakan ganti angkanya kalau mau

        $types = JenisSurat::all();
        return view('administrasi.dashboard', compact('totalSurat', 'suratFromGuest', 'recentSurat', 'types'));
    }

    public function create()
    {
        if (Auth::user()->role === 'supervisor') {
            abort(403, 'Unauthorized action.');
        }

        $types = JenisSurat::all();
        return view('administrasi.surat.create', compact('types'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role === 'supervisor') {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_masuk' => 'required|date',
            'instansi_pengirim' => 'required|string|max:255',
            'keterangan' => 'required|string|max:500',
            'jenis_surat_id' => 'required|exists:jenis_surat,id',
            'file' => 'nullable|file|mimes:pdf|max:2048',
            'status' => 'nullable|in:menunggu,diproses,selesai',
        ]);

        $data['tanggal_surat'] = date('Y-m-d', strtotime($request->tanggal_surat));
        $data['tanggal_masuk'] = date('Y-m-d', strtotime($request->tanggal_masuk));
        $data['instansi_pengirim'] = $request->input('instansi_pengirim');
        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('surat_pdfs', 'public');
        }
        $data['status'] = $request->input('status', 'menunggu');
        $data['created_by'] = Auth::id();
        Surats::create($data);

        return redirect()->route('administrasi.dashboard')->with('success', 'File surat berhasil diunggah.');
    }

    public function edit(Surats $surat)
    {
        if (Auth::user()->role === 'supervisor') {
            abort(403, 'Unauthorized action.');
        }

        $types = JenisSurat::all();
        return view('administrasi.surat.edit', compact('surat', 'types'));
    }
    public function updateStatus(Request $request, Surats $surat)
    {
        // batasi role (sesuaikan dengan kebutuhan)
        if (Auth::user()->role === 'supervisor') {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai',
        ]);

        $surat->update([
            'status' => $data['status'],
        ]);

        // respons JSON untuk AJAX
        return response()->json([
            'success' => true,
            'status'  => $surat->status,
        ]);
    }

    public function update(Request $request, Surats $surat)
    {
        if (Auth::user()->role === 'supervisor') {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validate([
            'jenis_surat_id' => 'required|exists:jenis_surat,id',
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_masuk' => 'required|date',
            'instansi_pengirim' => 'required|string|max:255',
            'keterangan' => 'required|string|max:500',
            'file' => 'nullable|file|mimes:pdf|max:2048',
            'status' => 'nullable|in:menunggu,diproses,selesai',
        ]);

        $data['tanggal_surat'] = date('Y-m-d', strtotime($request->tanggal_surat));
        $data['tanggal_masuk'] = date('Y-m-d', strtotime($request->tanggal_masuk));

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('surat_pdfs', 'public');
        }
        if (!isset($data['status'])) {
            $data['status'] = $surat->status ?? 'menunggu';
        }

        $surat->update($data);

        return redirect()->route('administrasi.surat.index')->with('success', 'Data surat berhasil diperbarui.');
    }

    public function destroy(Surats $surat)
    {
        if (Auth::user()->role === 'supervisor') {
            abort(403, 'Unauthorized action.');
        }

        $surat->delete();
        return back()->with('success', 'Data surat berhasil dihapus.');
    }
}
