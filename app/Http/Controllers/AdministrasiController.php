<?php

namespace App\Http\Controllers;

use App\Models\Surats;
use App\Models\JenisSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdministrasiController extends Controller
{

    public function index(Request $request)
    {
        return $this->renderDashboard($request);
    }

    public function dashboard(Request $request)
    {
        return $this->renderDashboard($request);
    }


    private function renderDashboard(Request $request)
    {
        $query = Surats::with('jenis');

        if ($request->has('show_guest')) {
            $query->where('is_from_guest', true);
        }

        // Pencarian
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
            $order  = $request->input('order', 'asc');

            $map = [
                'tanggal_surat'  => 'tanggal_surat',
                'tanggal_masuk'  => 'tanggal_masuk',
                'jenis_surat_id' => 'jenis_surat_id',
                'nomor_surat'    => 'nomor_surat',
            ];

            if (array_key_exists($column, $map)) {
                $query->orderBy($map[$column], $order);
            }
        } else {
            // Default: paling relevan untuk dashboard
            $query->orderByDesc('tanggal_masuk');
        }

        // Data tabel di dashboard (pakai nama variabel yang memang dipakai Blade)
        $recentSurat    = $query->paginate(10)->withQueryString();

        // Kartu ringkas di atas
        $totalSurat     = Surats::count();
        $suratFromGuest = Surats::where('is_from_guest', 1)->count();

        // Dropdown jenis (agar tidak undefined)
        $types = JenisSurat::orderBy('nama_jenis_surat')->get(['id', 'nama_jenis_surat']);

        // Flag peran (jika dipakai di Blade)
        $isSupervisor = Auth::user()->role === 'supervisor';

        return view('administrasi.dashboard', compact(
            'recentSurat',
            'totalSurat',
            'suratFromGuest',
            'types',
            'isSupervisor'
        ));
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
            'nomor_surat'       => 'required|string|max:255',
            'tanggal_surat'     => 'required|date',
            'tanggal_masuk'     => 'required|date',
            'instansi_pengirim' => 'required|string|max:255',
            'keterangan'        => 'required|string|max:500',
            'jenis_surat_id'    => 'required|exists:jenis_surat,id',
            'file'              => 'nullable|file|mimes:pdf|max:2048',
            'status'            => 'nullable|in:menunggu,diproses,selesai',
        ]);

        $data['tanggal_surat']  = date('Y-m-d', strtotime($request->tanggal_surat));
        $data['tanggal_masuk']  = date('Y-m-d', strtotime($request->tanggal_masuk));
        $data['instansi_pengirim'] = $request->input('instansi_pengirim');

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('surat_pdfs', 'public');
        }

        $data['status']     = $request->input('status', 'menunggu');
        $data['created_by'] = Auth::id();

        Surats::create($data);

        // TETAP ke rute administrasi.dashboard
        return redirect()->route('administrasi.dashboard')
            ->with('success', 'File surat berhasil diunggah.');
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
        if (Auth::user()->role === 'supervisor') {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai',
        ]);

        $surat->update(['status' => $data['status']]);

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
            'jenis_surat_id'    => 'required|exists:jenis_surat,id',
            'nomor_surat'       => 'required|string|max:255',
            'tanggal_surat'     => 'required|date',
            'tanggal_masuk'     => 'required|date',
            'instansi_pengirim' => 'required|string|max:255',
            'keterangan'        => 'required|string|max:500',
            'file'              => 'nullable|file|mimes:pdf|max:2048',
            'status'            => 'nullable|in:menunggu,diproses,selesai',
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

        // TETAP ke rute administrasi.dashboard
        return redirect()->route('administrasi.dashboard')
            ->with('success', 'Data surat berhasil diperbarui.');
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
