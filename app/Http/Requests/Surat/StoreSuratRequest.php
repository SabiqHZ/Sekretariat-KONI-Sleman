<?php

namespace App\Http\Requests\Surat;

use App\Models\Surats;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSuratRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role !== 'supervisor';
    }

    public function rules(): array
    {
        return [
            'nomor_surat'       => ['required', 'string', 'max:255'],
            'tanggal_surat'     => ['required', 'date'],
            'tanggal_masuk'     => ['required', 'date'],
            'instansi_pengirim' => ['required', 'string', 'max:255'],
            'keterangan'        => ['required', 'string', 'max:500'],
            'jenis_surat_id'    => ['required', 'exists:jenis_surat,id'],
            'file'              => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'status'            => ['nullable', Rule::in([
                Surats::STATUS_MENUNGGU,
                Surats::STATUS_DIPROSES,
                Surats::STATUS_SELESAI,
            ])],
        ];
    }
}
