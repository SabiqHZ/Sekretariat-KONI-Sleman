@extends('layouts.app')
@section('title','Upload Surat Baru')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 via-white to-sky-50 py-12">
    <div class="max-w-6xl mx-auto px-6 space-y-10">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.35em] text-orange-500">Upload Surat</p>
                <h1 class="text-4xl font-bold text-slate-800 mt-2">Unggah Surat Administrasi Baru</h1>
                <p class="text-slate-500 mt-3 max-w-2xl">Isi formulir lengkap berikut untuk memastikan surat terdata dengan baik dan siap disimpan di arsip digital.</p>
            </div>
            <div class="flex flex-wrap gap-3 justify-start lg:justify-end">
                <a href="{{ route('administrasi.surat.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white shadow-md text-slate-600 hover:text-orange-500 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid lg:grid-cols-[minmax(0,1.7fr)_minmax(0,1fr)] gap-8">
            <section class="bg-white/90 backdrop-blur rounded-3xl shadow-xl shadow-slate-200/60 border border-white/50">
                <div class="h-2 rounded-t-3xl bg-gradient-to-r from-orange-500 via-amber-400 to-yellow-300"></div>
                <form action="{{ route('administrasi.surat.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-600 mb-2">Jenis Surat</label>
                            <select name="jenis_surat_id" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-orange-500 focus:ring focus:ring-orange-100 text-slate-700" required>
                                <option value="">Pilih jenis surat</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->nama_jenis_surat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-600 mb-2">Nomor Surat</label>
                            <input type="text" name="nomor_surat" placeholder="Contoh: 001/ADM/{{ date('Y') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-orange-500 focus:ring focus:ring-orange-100 text-slate-700" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-600 mb-2">Pengirim</label>
                            <input type="text" name="pengirim" placeholder="Instansi/perorangan" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-orange-500 focus:ring focus:ring-orange-100 text-slate-700" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-600 mb-2">Tanggal Surat</label>
                            <input type="date" name="tanggal_surat" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-orange-500 focus:ring focus:ring-orange-100 text-slate-700" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-600 mb-2">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-orange-500 focus:ring focus:ring-orange-100 text-slate-700" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-600 mb-2">Keterangan</label>
                            <textarea name="keterangan" rows="4" placeholder="Deskripsi singkat isi surat" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-orange-500 focus:ring focus:ring-orange-100 text-slate-700 resize-none"></textarea>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-600 mb-2">Upload PDF (opsional)</label>
                            <div class="relative group border-2 border-dashed border-slate-200 rounded-2xl p-6 text-center transition hover:border-orange-300">
                                <input type="file" name="file" accept="application/pdf" class="absolute inset-0 opacity-0 cursor-pointer" id="file-upload" />
                                <div class="space-y-2">
                                    <div class="flex items-center justify-center">
                                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-orange-100 text-orange-500">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                        </span>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-700">Seret & lepas atau klik untuk memilih PDF</p>
                                    <p class="text-xs text-slate-400">Maksimal 2 MB • Format .pdf</p>
                                    <p id="file-name-display" class="text-xs text-orange-500 font-medium"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pt-6 border-t border-slate-100">
                        <div class="text-xs text-slate-400 uppercase tracking-[0.25em]">Data tersimpan otomatis ke sistem</div>
                        <button type="submit" class="inline-flex items-center gap-3 px-6 py-3 rounded-xl bg-gradient-to-r from-orange-500 to-amber-400 text-white font-semibold shadow-lg shadow-orange-200/70 transition transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            Simpan Surat
                        </button>
                    </div>
                </form>
            </section>

            <aside class="space-y-6">
                <div class="bg-white/90 backdrop-blur rounded-3xl shadow-xl border border-white/50 p-6">
                    <h3 class="text-lg font-semibold text-slate-800">Langkah Cepat</h3>
                    <ul class="mt-4 space-y-4 text-sm text-slate-600">
                        <li class="flex items-start gap-3">
                            <span class="mt-1 inline-block h-2.5 w-2.5 rounded-full bg-orange-500/80"></span>
                            <span>Pastikan tanggal surat dan tanggal masuk sesuai dokumen fisik untuk menjaga kronologi.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1 inline-block h-2.5 w-2.5 rounded-full bg-orange-500/80"></span>
                            <span>Gunakan keterangan untuk menandai status arsip atau disposisi.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1 inline-block h-2.5 w-2.5 rounded-full bg-orange-500/80"></span>
                            <span>Format nomor surat mengikuti standar instansi agar mudah ditelusuri.</span>
                        </li>
                    </ul>
                </div>
                <div class="bg-gradient-to-br from-orange-500 to-amber-400 text-white rounded-3xl shadow-xl p-6">
                    <h3 class="text-lg font-semibold">Tips Arsip Digital</h3>
                    <p class="text-sm text-orange-50/80 mt-2">Unggah file PDF untuk memudahkan proses pencarian dan distribusi surat secara digital.</p>
                    <ul class="mt-4 space-y-3 text-sm text-orange-50">
                        <li class="flex items-start gap-3"><span class="mt-1 inline-block h-2.5 w-2.5 rounded-full bg-white/70"></span>Gunakan nama file dengan format <strong>nomor_surat_tanggal.pdf</strong>.</li>
                        <li class="flex items-start gap-3"><span class="mt-1 inline-block h-2.5 w-2.5 rounded-full bg-white/70"></span>Pastikan file terbaca jelas sebelum diunggah.</li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const fileInput = document.getElementById('file-upload');
        const fileNameDisplay = document.getElementById('file-name-display');

        fileInput?.addEventListener('change', (event) => {
            const file = event.target.files?.[0];
            if (file) {
                fileNameDisplay.textContent = `File dipilih: ${file.name}`;
            } else {
                fileNameDisplay.textContent = '';
            }
        });
    });
</script>
@endpush
@endsection
