<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('surats', function (Blueprint $table) {
            $table->date('tanggal_surat')->nullable()->change();
            // Pastikan untuk mengubah kolom tanggal_surat menjadi nullable
            // jika sebelumnya tidak nullable, ini akan mengubahnya.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surats', function (Blueprint $table) {
            $table->date('tanggal_surat')->nullable(false)->change();
            // Kembalikan kolom tanggal_surat menjadi tidak nullable
            // jika sebelumnya nullable, ini akan mengubahnya kembali.
        });
    }
};
