<?php
namespace App\Http\Controllers;

use App\Models\Surats;
use App\Models\JenisSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

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
        Carbon::setLocale('id');

        $totalSurat = Surats::count();
        $suratFromGuest = Surats::where('is_from_guest', true)->count();
        $suratSelesai = Surats::where('is_completed', true)->count();
        $suratBelum = $totalSurat - $suratSelesai;

        $latestSurat = Surats::with('jenis')
            ->orderByDesc('tanggal_masuk')
            ->orderByDesc('created_at')
            ->take(12)
            ->get();

        $startMonth = Carbon::now()->startOfMonth()->subMonths(11);
        $monthlySummary = Surats::selectRaw('DATE_FORMAT(tanggal_masuk, "%Y-%m") as period, COUNT(*) as total')
            ->whereNotNull('tanggal_masuk')
            ->where('tanggal_masuk', '>=', $startMonth)
            ->groupBy('period')
            ->orderBy('period')
            ->get()
            ->keyBy('period');

        $monthlyLabels = [];
        $monthlyCounts = [];

        for ($i = 0; $i < 12; $i++) {
            $month = $startMonth->copy()->addMonths($i);
            $key = $month->format('Y-m');
            $monthlyLabels[] = $month->translatedFormat('M');
            $monthlyCounts[] = $monthlySummary[$key]->total ?? 0;
        }

        $jenisBreakdown = Surats::select(
            'jenis_surat_id',
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN is_completed = 1 THEN 1 ELSE 0 END) as selesai'),
            DB::raw('SUM(CASE WHEN is_completed = 0 THEN 1 ELSE 0 END) as belum'),
            DB::raw('SUM(CASE WHEN is_from_guest = 1 THEN 1 ELSE 0 END) as guest')
        )
            ->whereNotNull('jenis_surat_id')
            ->groupBy('jenis_surat_id')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $jenisNames = JenisSurat::whereIn('id', $jenisBreakdown->pluck('jenis_surat_id'))
            ->get()
            ->keyBy('id');

        $jenisLabels = [];
        $jenisSelesai = [];
        $jenisBelum = [];
        $jenisGuest = [];

        foreach ($jenisBreakdown as $row) {
            $jenisLabels[] = $jenisNames[$row->jenis_surat_id]->jenis_surat ?? 'Tidak diketahui';
            $jenisSelesai[] = (int) $row->selesai;
            $jenisBelum[] = (int) $row->belum;
            $jenisGuest[] = (int) $row->guest;
        }

        $completionRate = $totalSurat > 0 ? round(($suratSelesai / $totalSurat) * 100, 1) : 0;
        $guestRate = $totalSurat > 0 ? round(($suratFromGuest / $totalSurat) * 100, 1) : 0;

        $tableData = $latestSurat->map(function (Surats $surat) {
            return [
                'id' => $surat->id,
                'nomor_surat' => $surat->nomor_surat,
                'jenis' => optional($surat->jenis)->jenis_surat ?? 'Tidak diketahui',
                'pengirim' => $surat->pengirim,
                'tanggal_surat' => optional($surat->tanggal_surat)->translatedFormat('d M Y'),
                'tanggal_masuk' => optional($surat->tanggal_masuk)->translatedFormat('d M Y'),
                'keterangan' => $surat->keterangan,
                'is_from_guest' => (bool) $surat->is_from_guest,
                'is_completed' => (bool) $surat->is_completed,
            ];
        });

        $jenisOptions = JenisSurat::orderBy('jenis_surat')->get();

        return view('administrasi.dashboard', [
            'totalSurat' => $totalSurat,
            'suratFromGuest' => $suratFromGuest,
            'suratSelesai' => $suratSelesai,
            'suratBelum' => $suratBelum,
            'completionRate' => $completionRate,
            'guestRate' => $guestRate,
            'monthlyLabels' => $monthlyLabels,
            'monthlyCounts' => $monthlyCounts,
            'jenisLabels' => $jenisLabels,
            'jenisSelesai' => $jenisSelesai,
            'jenisBelum' => $jenisBelum,
            'jenisGuest' => $jenisGuest,
            'tableData' => $tableData,
            'jenisOptions' => $jenisOptions,
        ]);
    }

    public function toggleCompletion(Request $request, Surats $surat)
    {
        if (Auth::user()->role === 'supervisor') {
            abort(403, 'Unauthorized action.');
        }

        $surat->update([
            'is_completed' => $request->boolean('is_completed'),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Status surat diperbarui.',
                'is_completed' => (bool) $surat->is_completed,
            ]);
        }

        return back()->with('success', 'Status surat diperbarui.');
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