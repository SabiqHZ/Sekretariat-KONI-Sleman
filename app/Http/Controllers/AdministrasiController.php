<?php

namespace App\Http\Controllers;

use App\Http\Requests\Surat\StoreSuratRequest;
use App\Http\Requests\Surat\UpdateSuratRequest;
use App\Http\Requests\Surat\UpdateSuratStatusRequest;
use App\Models\JenisSurat;
use App\Models\Surats;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdministrasiController extends Controller
{
    public function index(Request $request): View
    {
        return $this->renderDashboard($request);
    }

    public function dashboard(Request $request): View
    {
        return $this->renderDashboard($request);
    }

    public function create(): View
    {
        $this->abortIfSupervisor();

        $types = JenisSurat::orderBy('nama_jenis_surat')->get(['id', 'nama_jenis_surat']);

        return view('administrasi.surat.create', compact('types'));
    }

    public function store(StoreSuratRequest $request): RedirectResponse
    {
        $attributes = $this->prepareSuratAttributes($request->validated(), $request);
        $attributes['status']     = $attributes['status'] ?? Surats::STATUS_MENUNGGU;
        $attributes['created_by'] = Auth::id();

        Surats::create($attributes);

        return redirect()->route('administrasi.dashboard')
            ->with('success', 'File surat berhasil diunggah.');
    }

    public function show(Surats $surat): View
    {
        return view('administrasi.surat.show', compact('surat'));
    }

    public function edit(Surats $surat): View
    {
        $this->abortIfSupervisor();

        $types = JenisSurat::orderBy('nama_jenis_surat')->get(['id', 'nama_jenis_surat']);

        return view('administrasi.surat.edit', compact('surat', 'types'));
    }

    public function update(UpdateSuratRequest $request, Surats $surat): RedirectResponse
    {
        $attributes = $this->prepareSuratAttributes($request->validated(), $request, $surat);

        if (! array_key_exists('status', $attributes)) {
            $attributes['status'] = $surat->status ?? Surats::STATUS_MENUNGGU;
        }

        $surat->update($attributes);

        return redirect()->route('administrasi.dashboard')
            ->with('success', 'Data surat berhasil diperbarui.');
    }

    public function updateStatus(UpdateSuratStatusRequest $request, Surats $surat): JsonResponse
    {
        $surat->update(['status' => $request->validated('status')]);

        return response()->json([
            'success' => true,
            'status'  => $surat->status,
        ]);
    }

    public function destroy(Surats $surat): RedirectResponse
    {
        $this->abortIfSupervisor();

        $surat->delete();

        return back()->with('success', 'Data surat berhasil dihapus.');
    }

    public function exportPdf(Surats $surat)
    {
        $this->abortIfSupervisor();

        if (! $surat->file_path || ! Storage::disk('public')->exists($surat->file_path)) {
            abort(404, 'File surat tidak ditemukan.');
        }

        $filename = Str::slug($surat->nomor_surat, '-') . '.pdf';

        return Storage::disk('public')->download($surat->file_path, $filename);
    }

    private function renderDashboard(Request $request): View
    {
        $recentSurat    = $this->buildSuratQuery($request)->paginate(10)->withQueryString();
        $totalSurat     = Surats::count();
        $suratFromGuest = Surats::where('is_from_guest', true)->count();
        $types          = JenisSurat::orderBy('nama_jenis_surat')->get(['id', 'nama_jenis_surat']);
        $isSupervisor   = Auth::user()?->role === 'supervisor';

        return view('administrasi.dashboard', compact(
            'recentSurat',
            'totalSurat',
            'suratFromGuest',
            'types',
            'isSupervisor'
        ));
    }

    private function buildSuratQuery(Request $request): Builder
    {
        return Surats::with('jenis')
            ->when($request->boolean('show_guest'), fn ($query) => $query->where('is_from_guest', true))
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');

                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery
                        ->where('nomor_surat', 'like', "%{$search}%")
                        ->orWhere('instansi_pengirim', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('sort'), function ($query) use ($request) {
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
            }, fn ($query) => $query->orderByDesc('tanggal_masuk'));
    }

    private function prepareSuratAttributes(array $attributes, Request $request, ?Surats $surat = null): array
    {
        $attributes['tanggal_surat'] = Carbon::parse($attributes['tanggal_surat'])->toDateString();
        $attributes['tanggal_masuk'] = Carbon::parse($attributes['tanggal_masuk'])->toDateString();

        $attributes['file_path'] = $surat?->file_path;

        if ($request->hasFile('file')) {
            $attributes['file_path'] = $request->file('file')->store('surat_pdfs', 'public');
        }

        unset($attributes['file']);

        return $attributes;
    }

    private function abortIfSupervisor(): void
    {
        if (Auth::user()?->role === 'supervisor') {
            abort(403, 'Unauthorized action.');
        }
    }
}
