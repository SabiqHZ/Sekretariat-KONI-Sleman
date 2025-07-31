<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Surats extends Model {
    

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_masuk' => 'date',
    ];
    protected $table = 'surats';

    protected $fillable = [
        'nomor_surat',
        'jenis_surat_id',
        'pengirim',
        'tanggal_surat',
        'tanggal_masuk',
        'keterangan',
        'file_path',
    ];

    public function jenis() {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id');
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function getFileUrlAttribute() {
        return $this->file_path ? Storage::url($this->file_path) : null;
    }
}
