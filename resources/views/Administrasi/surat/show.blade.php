@extends('layouts.app')
@section('title','Detail Surat')
@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Detail Surat</h1>
    <p><strong>Nomor Surat:</strong> {{ $surat->nomor_surat }}</p>
    <p><strong>Jenis:</strong> {{ $surat->jenis->nama }}</p>
    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d-m-Y') }}</p>
    <p><strong>Perihal:</strong> {{ $surat->perihal }}</p>
    <p><strong>Tujuan:</strong> {{ $surat->tujuan }}</p>
    <div><strong>Isi Surat:</strong>
        <div class="border rounded p-2 mt-1 bg-gray-50 whitespace-pre-line">{{ $surat->isi }}</div>
    </div>
    @if($surat->file_path)
    <div class="mt-4">
        <strong>File PDF:</strong>
        <a href="{{ asset('storage/'.$surat->file_path) }}" class="text-blue-600 hover:underline" target="_blank">Download PDF</a>
    </div>
    @endif
    <div class="mt-4 space-x-2">
        <a href="{{ route('administrasi.surat.edit',$surat) }}" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</a>
        <a href="{{ route('administrasi.surat.pdf',$surat) }}" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Export PDF</a>
        <a href="{{ route('administrasi.surat.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Kembali</a>
    </div>
</div>
@endsection
