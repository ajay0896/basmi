<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
     protected $fillable = ['laporan_id', 'admin_id', 'catatan'];

    public function laporan()
    {
        return $this->belongsTo(LaporanMasyarakat::class, 'laporan_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
