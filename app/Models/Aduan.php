<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aduan extends Model
{
    use HasFactory;

    protected $table = 'aduans';
    protected $fillable = [
        'nama',
        'nik',
        'no_hp',
        'email',
    ];

    // App\Models\Aduan.php
       public function laporans()
   {
    return $this->hasMany(LaporanMasyarakat::class, 'aduan_id');
    }

}