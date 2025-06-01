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
        Schema::create('laporan_pengaduan', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('pengaduan_id');
    $table->date('tanggal_laporan');
    $table->string('kategori');
    $table->string('status');
    $table->timestamps();

    $table->foreign('pengaduan_id')->references('id')->on('pengaduan')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_pengaduan');
    }
};
