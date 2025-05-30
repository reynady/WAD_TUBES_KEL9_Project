<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengaduan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = '_pengajuan';

    protected $fillable = [
        'judul',
        'deskripsi',
        'kategori_id',
        'mahasiswa_id',
        'status_id',
        'lokasi',
        'urgensi',
        'tanggal_pengaduan',
        'tanggal_selesai',
        'bukti_path'
    ];

    protected $casts = [
        'tanggal_pengaduan' => 'date',
        'tanggal_selesai' => 'date',
        'urgensi' => 'string'
    ];


    public function kategori()
    {
        return $this->belongsTo(KategoriPengaduan::class, 'kategori_id');
    }


    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }


    public function status()
    {
        return $this->belongsTo(StatusPengaduan::class, 'status_id');
    }
}
