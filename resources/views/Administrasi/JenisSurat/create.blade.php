@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-semibold mb-6">Tambah Jenis Surat</h2>
        
        <form action="{{ route('administrasi.jenis-surat.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="jenis_surat" class="block text-sm font-medium text-gray-700 mb-2">Jenis Surat</label>
                <input type="text" name="jenis_surat" id="jenis_surat" 
                       class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500"
                       required>
                @error('jenis_surat')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <a href="{{ route('administrasi.surat.index') }}" 
                   class="mr-4 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection