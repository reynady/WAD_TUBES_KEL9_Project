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
        Schema::create('_pengajuan', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 100);
            $table->text('deskripsi');
            $table->foreignId('kategori_id')->constrained('kategori_pengaduan');
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa');
            $table->foreignId('status_id')->constrained('status_pengaduan')->default(1); 
            $table->string('lokasi', 50);
            $table->enum('urgensi', ['rendah', 'sedang', 'tinggi', 'kritis'])->default('sedang');
            $table->date('tanggal_pengaduan')->useCurrent();
            $table->date('tanggal_selesai')->nullable();
            $table->string('bukti_path')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_pengajuan');
    }
};
