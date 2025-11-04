@extends('layouts.app')
@section('title','Daftar Surat')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 via-white to-sky-50 py-12">
    <div class="max-w-7xl mx-auto px-6 space-y-10">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.35em] text-orange-500">Administrasi Surat</p>
                <h1 class="text-4xl font-bold text-slate-800 mt-2">Kelola Surat Masuk & Arsip</h1>
                <p class="text-slate-500 mt-3 max-w-2xl">Pantau seluruh surat masuk dan keluar secara interaktif, lengkap dengan status realtime dan akses cepat menuju arsip digital.</p>
            </div>
            <div class="flex flex-wrap gap-3 justify-start lg:justify-end">
                <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white shadow-md text-slate-600 hover:text-orange-500 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" /><path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.121 2.121 0 013 3L13 14l-4 1 1-4 8.5-8.5z" /></svg>
                    Profil
                </a>
                @if(auth()->user()->role === 'administrasi')
                <a href="{{ route('administrasi.jenis-surat.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white shadow-md text-slate-600 hover:text-orange-500 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" /></svg>
                    Jenis Surat
                </a>
                <a href="{{ route('administrasi.surat.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-orange-500 to-amber-400 text-white shadow-lg shadow-orange-200/70 transition transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                    Tambah Surat
                </a>
                @endif
            </div>
        </div>

        <div class="grid lg:grid-cols-[minmax(0,2fr)_minmax(0,1fr)] gap-8">
            <section class="bg-white/90 backdrop-blur rounded-3xl shadow-xl shadow-slate-200/60 border border-white/50">
                <header class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 px-8 pt-8 pb-4">
                    <div>
                        <h2 class="text-2xl font-semibold text-slate-800">Daftar Surat</h2>
                        <p class="text-sm text-slate-500">Gunakan pencarian, filter dan status untuk mempercepat proses kerja.</p>
                    </div>
                    <div class="flex flex-col md:flex-row gap-3 md:items-center">
                        <form method="GET" action="{{ route('administrasi.surat.index') }}" class="flex flex-wrap gap-3 md:justify-end">
                            <input type="hidden" name="order" value="{{ request('order') }}">
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor / pengirim" class="w-64 pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:border-orange-500 focus:ring focus:ring-orange-100 text-sm text-slate-700">
                                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </div>
                            <div class="flex gap-2">
                                <select name="sort" class="px-3 py-2 rounded-xl border border-slate-200 text-sm text-slate-600 focus:border-orange-500 focus:ring-2 focus:ring-orange-100">
                                    <option value="">Urutkan</option>
                                    <option value="tanggal_surat" @selected(request('sort')==='tanggal_surat')>Tanggal Surat</option>
                                    <option value="tanggal_masuk" @selected(request('sort')==='tanggal_masuk')>Tanggal Masuk</option>
                                    <option value="jenis_surat_id" @selected(request('sort')==='jenis_surat_id')>Jenis Surat</option>
                                    <option value="nomor_surat" @selected(request('sort')==='nomor_surat')>Nomor Surat</option>
                                </select>
                                <select name="order" class="px-3 py-2 rounded-xl border border-slate-200 text-sm text-slate-600 focus:border-orange-500 focus:ring-2 focus:ring-orange-100">
                                    <option value="desc" @selected(request('order')==='desc')>Terbaru</option>
                                    <option value="asc" @selected(request('order')==='asc')>Terlama</option>
                                </select>
                                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-orange-500 text-white text-sm font-medium shadow hover:bg-orange-600 transition">
                                    Terapkan
                                </button>
                            </div>
                        </form>
                    </div>
                </header>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[760px]">
                        <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                            <tr>
                                <th class="py-4 pl-8 pr-3 text-left font-semibold">Nomor Surat</th>
                                <th class="px-3 py-4 text-left font-semibold">Jenis</th>
                                <th class="px-3 py-4 text-left font-semibold">Pengirim</th>
                                <th class="px-3 py-4 text-left font-semibold">Tanggal Surat</th>
                                <th class="px-3 py-4 text-left font-semibold">Tanggal Masuk</th>
                                <th class="px-3 py-4 text-left font-semibold">Keterangan</th>
                                <th class="px-3 py-4 text-left font-semibold">Aksi</th>
                                <th class="px-6 py-4 text-right font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody id="suratTableBody" class="divide-y divide-slate-100">
                            @forelse($surat as $s)
                                <tr class="hover:bg-orange-50/40 transition" data-row-id="{{ $s->id }}">
                                    <td class="py-5 pl-8 pr-3">
                                        <div class="flex items-center gap-3">
                                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-orange-100 text-orange-600 font-semibold">{{ strtoupper(substr($s->nomor_surat,0,2)) }}</span>
                                            <div>
                                                <p class="font-semibold text-slate-800">{{ $s->nomor_surat }}</p>
                                                @if(isset($s->is_from_guest) && $s->is_from_guest)
                                                    <span class="inline-flex items-center text-[11px] uppercase tracking-widest text-blue-600 font-semibold">Guest</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-5">
                                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-600 border border-blue-100">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                            {{ $s->jenis->nama_jenis_surat ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-5 text-slate-600">{{ $s->Pengirim }}</td>
                                    <td class="px-3 py-5 text-slate-600">{{ optional($s->tanggal_surat)?->format('d M Y') ?? '-' }}</td>
                                    <td class="px-3 py-5 text-slate-600">{{ optional($s->tanggal_masuk)?->format('d M Y') ?? '-' }}</td>
                                    <td class="px-3 py-5 text-slate-600 max-w-[180px]">
                                        @if($s->Keterangan)
                                            <p class="text-sm leading-relaxed">{{ $s->Keterangan }}</p>
                                        @else
                                            <span class="text-slate-400 italic">Tidak ada catatan</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-5">
                                        <div class="flex flex-wrap gap-2">
                                            @if($s->file_path)
                                                <a href="{{ Storage::url($s->file_path) }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-emerald-100 text-emerald-600 text-xs font-semibold">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                    PDF
                                                </a>
                                            @endif
                                            @if(auth()->user()->role === 'administrasi')
                                                <a href="{{ route('administrasi.surat.edit',$s) }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-amber-100 text-amber-600 text-xs font-semibold">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/><path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.121 2.121 0 013 3L13 14l-4 1 1-4 8.5-8.5z"/></svg>
                                                    Edit
                                                </a>
                                                <form action="{{ route('administrasi.surat.destroy',$s) }}" method="POST" class="inline delete-form">
                                                    @csrf @method('DELETE')
                                                    <button type="button" class="delete-btn inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-rose-100 text-rose-600 text-xs font-semibold" data-surat-jenissurat="{{ $s->jenis->nama_jenis_surat ?? '-' }}" data-surat-pengirim="{{ $s->Pengirim }}">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <div class="inline-flex bg-slate-100/80 border border-slate-200 rounded-xl p-1.5" data-status-control="{{ $s->id }}">
                                            <button type="button" data-value="menunggu" class="px-3 py-1 rounded-lg text-[11px] font-semibold uppercase tracking-widest text-slate-400">Menunggu</button>
                                            <button type="button" data-value="proses" class="px-3 py-1 rounded-lg text-[11px] font-semibold uppercase tracking-widest text-slate-400">Proses</button>
                                            <button type="button" data-value="selesai" class="px-3 py-1 rounded-lg text-[11px] font-semibold uppercase tracking-widest text-slate-400">Selesai</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-16 text-center text-slate-500">Belum ada surat terdata.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 px-8 py-6 border-t border-slate-100">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('surat.export') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-semibold shadow hover:from-emerald-600 hover:to-teal-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                            Export Excel
                        </a>
                        <span class="text-xs text-slate-400 uppercase tracking-[0.25em]">{{ $surat->total() }} Surat</span>
                    </div>
                    @if($surat->hasPages())
                        <div class="rounded-2xl bg-white/80 shadow-inner px-4 py-3 border border-slate-100">
                            {{ $surat->appends(request()->query())->links('pagination::tailwind') }}
                        </div>
                    @endif
                </div>
            </section>

            <aside class="space-y-6">
                <div class="bg-white/90 backdrop-blur rounded-3xl shadow-xl border border-white/50 p-6">
                    <h3 class="text-lg font-semibold text-slate-800">Arsip Surat</h3>
                    <p class="text-sm text-slate-500">Surat yang telah disimpan dengan keterangan arsip akan muncul di sini.</p>
                    <div class="mt-4 space-y-4" id="arsipList">
                        @forelse($archivedSurat as $item)
                            <article class="p-4 rounded-2xl border border-slate-100 bg-slate-50/80">
                                <div class="flex justify-between items-start gap-3">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-700">{{ $item->nomor_surat }}</p>
                                        <p class="text-xs text-slate-500">{{ optional($item->tanggal_surat)?->format('d M Y') ?? '-' }}</p>
                                    </div>
                                    <span class="inline-flex px-2 py-1 rounded-lg bg-amber-100 text-amber-600 text-xs font-semibold">{{ $item->jenis->nama_jenis_surat ?? '-' }}</span>
                                </div>
                                <p class="mt-3 text-sm text-slate-600">{{ $item->Pengirim }}</p>
                                <div class="mt-4 flex items-center justify-between text-xs text-slate-400">
                                    <span>Masuk: {{ optional($item->tanggal_masuk)?->format('d M Y') ?? '-' }}</span>
                                    <span>Diupdate: {{ optional($item->updated_at)?->format('d M Y - H:i') }}</span>
                                </div>
                            </article>
                        @empty
                            <div class="p-6 rounded-2xl border border-dashed border-slate-200 text-center text-slate-400">Belum ada surat yang diarsipkan.</div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-gradient-to-br from-orange-500 to-amber-400 text-white rounded-3xl shadow-xl p-6">
                    <h3 class="text-lg font-semibold">Catatan Aktivitas</h3>
                    <p class="text-sm text-orange-50/80">Status setiap surat tersimpan secara lokal dan dapat diperbarui kapan saja tanpa mengubah data utama.</p>
                    <ul class="mt-5 space-y-4 text-sm text-orange-50">
                        <li class="flex items-start gap-3">
                            <span class="mt-1 inline-block h-2.5 w-2.5 rounded-full bg-white/70"></span>
                            <span>Tombol status menunggu/proses/selesai tercatat untuk masing-masing surat.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1 inline-block h-2.5 w-2.5 rounded-full bg-white/70"></span>
                            <span>Gunakan arsip untuk memantau dokumen dengan keterangan arsip secara cepat.</span>
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const storedStatus = JSON.parse(localStorage.getItem('administrasi-surat-status') || '{}');

            document.querySelectorAll('[data-status-control]').forEach(group => {
                const id = group.getAttribute('data-status-control');
                const buttons = group.querySelectorAll('button[data-value]');
                const current = storedStatus[id] || 'menunggu';

                buttons.forEach(button => {
                    if (button.dataset.value === current) {
                        button.classList.add('bg-white', 'text-orange-500', 'shadow');
                    }

                    button.addEventListener('click', () => {
                        buttons.forEach(btn => btn.classList.remove('bg-white', 'text-orange-500', 'shadow'));
                        button.classList.add('bg-white', 'text-orange-500', 'shadow');
                        storedStatus[id] = button.dataset.value;
                        localStorage.setItem('administrasi-surat-status', JSON.stringify(storedStatus));
                    });
                });
            });

            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#eb5120'
                });
            @endif

            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const form = this.closest('.delete-form');
                    const jenis = this.getAttribute('data-surat-jenissurat');
                    const pengirim = this.getAttribute('data-surat-pengirim');

                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        html: `<div class="text-left"><p class="mb-2"><strong>Jenis:</strong> ${jenis}</p><p><strong>Pengirim:</strong> ${pengirim}</p></div>`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
@endsection
