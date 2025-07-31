
@extends('layouts.app')
@section('title','Edit Surat')
@section('content')
<div class="bg-white p-6 roun
d-lg shadow">
    <h1 class="text-xl font-bold text-gray-800 mb-4">Edit Surat</h1>
    <form action="{{ route('administrasi.surat.update',$surat) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block font-semibold">Jenis Surat</label>
            <select name="jenis_surat_id" class="w-full border rounded p-2">
                @foreach($types as $type)
                    <option value="{{ $type->id }}" {{ $surat->jenis_surat_id == $type->id ? 'selected' : '' }}>{{ $type->nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block font-semibold">Nomor Surat</label>
            <input type="text" name="nomor_surat" value="{{ $surat->nomor_surat }}" class="w-full border rounded p-2" required>
        </div>
        <div>
            <label class="block font-semibold">Tanggal Surat</label>
            <input type="date" name="tanggal_surat" value="{{ $surat->tanggal_surat->toDateString() }}" class="w-full border rounded p-2" required>
        </div>
        <div>
            <label class="block font-semibold">Perihal</label>
            <input type="text" name="perihal" value="{{ $surat->perihal }}" class="w-full border rounded p-2" required>
        </div>
        <div>
            <label class="block font-semibold">Tujuan</label>
            <input type="text" name="tujuan" value="{{ $surat->tujuan }}" class="w-full border rounded p-2" required>
        </div>
        <div>
            <label class="block font-semibold">Isi Surat</label>
            <textarea name="isi" rows="5" class="w-full border rounded p-2">{{ $surat->isi }}</textarea>
        </div>
        <div>
            <label class="block font-semibold">Upload PDF [Ganti]</label>
            <input type="file" name="file" accept="application/pdf">
            @if($surat->file_path)
                <p class="text-sm">File saat ini: <a href="{{ asset('storage/'.$surat->file_path) }}" target="_blank" class="text-blue-600 hover:underline">Lihat PDF</a></p>
            @endif
        </div>
        <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Perbarui</button>
    </form>
</div>
@endsection