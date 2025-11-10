@extends('layouts.app')
@section('title','Daftar Surat')
@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold text-gray-800">Daftar Surat</h1>
    <a href="{{ route('keuangan.surat.create') }}" class="px-4 py-2 bg-blue-600 text-blue rounded hover:bg-blue-700">Buat Surat</a>
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
<form method="GET" action="{{ route('keuangan.surat.index') }}" class="mb-4 flex gap-2 items-center">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pengirim / nomor surat..." class="border p-2 rounded" />

    <select name="sort" class="border p-2 rounded">
        <option value="">Sortir Berdasarkan</option>
        <option value="tanggal_surat" {{ request('sort') == 'tanggal_surat' ? 'selected' : '' }}>Tanggal Surat</option>
        <option value="tanggal_masuk" {{ request('sort') == 'tanggal_masuk' ? 'selected' : '' }}>Tanggal Masuk</option>
        <option value="jenis_surat_id" {{ request('sort') == 'jenis_surat_id' ? 'selected' : '' }}>Jenis Surat</option>
    </select>

    <select name="order" class="border p-2 rounded">
        <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Naik</option>
        <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Turun</option>
    </select>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
</form>
</div>

<table class="min-w-full bg-white border border-gray-300 rounded-lg shadow">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-2 border-b">Nomor Surat</th>
            <th class="px-4 py-2 border-b">Jenis Surat</th>
            <th class="px-4 py-2 border-b">Pengirim</th>
            <th class="px-4 py-2 border-b">Tanggal Surat</th>
            <th class="px-4 py-2 border-b">Tanggal Masuk</th>
            <th class="px-4 py-2 border-b">Keterangan</th>
            <th class="px-4 py-2 border-b">Aksi</th>
        </tr>
    </thead>
    <tbody>
    @foreach($surat as $s)
        <tr class="border-t hover:bg-gray-50">
            <td class="px-4 py-2">{{ $s->nomor_surat }}</td>
            <td class="px-4 py-2">{{ $s->jenis->jenis_surat }}</td>
            <td class="px-4 py-2">{{ $s->Pengirim }}</td>
            <td class="px-4 py-2">{{ $s->tanggal_surat->format('d-m-Y') }}</td>
            <td class="px-4 py-2">{{ $s->tanggal_masuk->format('d-m-Y') }}</td>
            <td class="px-4 py-2">{{ $s->Keterangan }}</td>
            <td class="px-4 py-2 space-x-2">
                <a href="{{ route('keuangan.surat.show',$s) }}" class="text-blue-600 hover:underline">Lihat</a>
                <a href="{{ route('keuangan.surat.edit',$s) }}" class="text-yellow-600 hover:underline">Edit</a>
                <a href="{{ route('keuangan.surat.pdf',$s) }}" class="text-green-600 hover:underline">PDF</a>
                <form action="{{ route('keuangan.surat.destroy',$s) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('Yakin diarsipkan?')" class="text-red-600 hover:underline">Arsip</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="mt-4">{{ $surat->links() }}</div>
@endsection
