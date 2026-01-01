<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanMasyarakat extends Model
{
    protected $casts = [
        'tanggal_kejadian' => 'datetime',
        'ml_checked_at' => 'datetime',
    ];

    protected $fillable = [
        'user_id',
        'kode_laporan',
        'deskripsi_kejadian',
        'lokasi_kejadian',
        'foto',
        'status',
        'kecamatan_id',
        'desa_id',
        'tanggal_kejadian',
        'lat',
        'lng',
        // ML metadata fields
        'ml_confidence',
        'ml_label',
        'ml_reason',
        'ml_processing_time',
        'ml_checked_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'laporan_id');
    }

     public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function desa()
    {
    return $this->belongsTo(Desa::class, 'desa_id');
     }

     public function aduan()
    {
    return $this->belongsTo(Aduan::class, 'aduan_id');
    }

}
