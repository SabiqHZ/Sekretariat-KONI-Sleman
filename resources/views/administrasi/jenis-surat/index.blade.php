@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">Daftar Jenis Surat</h2>
                <p class="text-gray-600">Kelola referensi jenis surat yang digunakan pada sistem.</p>
            </div>
            <a href="{{ route('administrasi.jenis-surat.create') }}"
               class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Tambah Jenis Surat
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 px-4 py-3 text-sm text-green-800 bg-green-100 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Jenis Surat</th>
                        <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($jenisSurats as $index => $jenisSurat)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $jenisSurat->nama_jenis_surat }}</td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('administrasi.jenis-surat.edit', $jenisSurat) }}"
                                       class="px-3 py-1 border border-blue-500 text-blue-600 rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        Edit
                                    </a>
                                    <form action="{{ route('administrasi.jenis-surat.destroy', $jenisSurat) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus jenis surat ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1 border border-red-500 text-red-600 rounded-lg hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-sm text-gray-500">
                                Belum ada data jenis surat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
