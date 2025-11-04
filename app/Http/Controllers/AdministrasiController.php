<?php
namespace App\Http\Controllers;

use App\Models\Surats;
use App\Models\JenisSurat;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
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
            $query->where(function($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('pengirim', 'like', "%{$search}%");
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
        
        $surat = $query->paginate(15)->withQueryString();
        $isSupervisor = Auth::user()->role === 'supervisor';
        
        return view('administrasi.surat.index', compact('surat', 'isSupervisor'));
    }

    public function dashboard()
    {
        $now = Carbon::now();
        $rangeStart = $now->copy()->subMonths(5)->startOfMonth();

        $totalSurat = Surats::count();
        $suratFromGuest = Surats::where('is_from_guest', true)->count();
        $suratInternal = max($totalSurat - $suratFromGuest, 0);
        $jenisCount = JenisSurat::count();
        $suratWithAttachment = Surats::whereNotNull('file_path')->count();
        $suratThisWeek = Surats::whereBetween(
            DB::raw('DATE(COALESCE(tanggal_masuk, tanggal_surat, created_at))'),
            [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()]
        )->count();

        $monthlyCountsRaw = Surats::selectRaw(
            "DATE_FORMAT(COALESCE(tanggal_masuk, tanggal_surat, created_at), '%Y-%m') as periode"
        )
            ->selectRaw('COUNT(*) as total')
            ->whereBetween(
                DB::raw('COALESCE(tanggal_masuk, tanggal_surat, created_at)'),
                [$rangeStart, $now->copy()->endOfMonth()]
            )
            ->groupBy('periode')
            ->pluck('total', 'periode');

        $monthlyCounts = collect(CarbonPeriod::create($rangeStart, '1 month', $now))->map(
            function (Carbon $date) use ($monthlyCountsRaw) {
                $key = $date->format('Y-m');
                return [
                    'label' => $date->locale('id')->isoFormat('MMM Y'),
                    'total' => (int) ($monthlyCountsRaw[$key] ?? 0),
                ];
            }
        )->values();

        $suratByJenis = Surats::select('jenis_surat_id')
            ->selectRaw('COUNT(*) as total')
            ->with('jenis:id,nama_jenis_surat')
            ->groupBy('jenis_surat_id')
            ->get()
            ->map(function ($item) {
                return [
                    'jenis' => optional($item->jenis)->nama_jenis_surat ?? 'Tidak Terdata',
                    'total' => (int) $item->total,
                ];
            })
            ->sortByDesc('total')
            ->values();

        $suratOriginsByJenis = Surats::select('jenis_surat_id')
            ->selectRaw("SUM(CASE WHEN is_from_guest = 1 THEN 1 ELSE 0 END) as guest_total")
            ->selectRaw("SUM(CASE WHEN is_from_guest = 0 OR is_from_guest IS NULL THEN 1 ELSE 0 END) as internal_total")
            ->with('jenis:id,nama_jenis_surat')
            ->groupBy('jenis_surat_id')
            ->get()
            ->map(function ($item) {
                return [
                    'jenis' => optional($item->jenis)->nama_jenis_surat ?? 'Tidak Terdata',
                    'guest' => (int) $item->guest_total,
                    'internal' => (int) $item->internal_total,
                ];
            })
            ->sortByDesc(fn ($row) => $row['guest'] + $row['internal'])
            ->values()
            ->take(4);

        $recentSurat = Surats::with('jenis:id,nama_jenis_surat')
            ->orderByDesc(DB::raw('COALESCE(tanggal_masuk, tanggal_surat, created_at)'))
            ->take(8)
            ->get();

        return view('administrasi.dashboard', [
            'totalSurat' => $totalSurat,
            'suratFromGuest' => $suratFromGuest,
            'suratInternal' => $suratInternal,
            'jenisCount' => $jenisCount,
            'suratWithAttachment' => $suratWithAttachment,
            'suratThisWeek' => $suratThisWeek,
            'monthlyCounts' => $monthlyCounts,
            'suratByJenis' => $suratByJenis,
            'suratOriginsByJenis' => $suratOriginsByJenis,
            'recentSurat' => $recentSurat,
        ]);
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
            'pengirim' => 'required|string|max:255',
            'keterangan' => 'required|string|max:500',
            'jenis_surat_id' => 'required|exists:jenis_surat,id',
            'file' => 'nullable|file|mimes:pdf|max:2048'
        ]);

        $data['tanggal_surat'] = date('Y-m-d', strtotime($request->tanggal_surat));
        $data['tanggal_masuk'] = date('Y-m-d', strtotime($request->tanggal_masuk));

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('surat_pdfs', 'public');
        }

        $data['created_by'] = Auth::id();
        Surats::create($data);

        return redirect()->route('administrasi.surat.index')->with('success', 'File surat berhasil diunggah.');
    }

    public function edit(Surats $surat) 
    {
        if (Auth::user()->role === 'supervisor') {
            abort(403, 'Unauthorized action.');
        }

        $types = JenisSurat::all();
        return view('administrasi.surat.edit', compact('surat', 'types'));
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
            'pengirim' => 'required|string|max:255',
            'keterangan' => 'required|string|max:500',
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

    public function destroy(Surats $surat) 
    {
        if (Auth::user()->role === 'supervisor') {
            abort(403, 'Unauthorized action.');
        }

        $surat->delete();
        return back()->with('success', 'Data surat berhasil dihapus.');
    }
}