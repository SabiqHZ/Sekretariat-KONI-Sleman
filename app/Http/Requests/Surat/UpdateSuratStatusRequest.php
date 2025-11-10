<?php

namespace App\Http\Requests\Surat;

use App\Models\Surats;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSuratStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role !== 'supervisor';
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in([
                Surats::STATUS_MENUNGGU,
                Surats::STATUS_DIPROSES,
                Surats::STATUS_SELESAI,
            ])],
        ];
    }
}
