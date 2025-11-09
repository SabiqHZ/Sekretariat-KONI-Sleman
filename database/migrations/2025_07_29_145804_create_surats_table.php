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
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat');
            $table->unsignedBigInteger('jenis_surat_id');
            $table->foreign('jenis_surat_id')->references('id')->on('jenis_surat')->onDelete('cascade');
            $table->string('instansi_pengirim');
            $table->date('tanggal_surat');
            $table->date('tanggal_masuk')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('status', 20)
                ->default('menunggu');
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};
