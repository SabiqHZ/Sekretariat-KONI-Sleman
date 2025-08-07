<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    protected $table = 'jenis_surat';

    protected $fillable = [
        'nama_jenis_surat',
    ];

    public function surats()
    {
        return $this->hasMany(Surats::class, 'jenis_surat_id');
    }
}
