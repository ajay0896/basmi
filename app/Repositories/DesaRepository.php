<?php

namespace App\Repositories;

use App\Interfaces\DesaRepositoryInterface;
use App\Models\Desa;


class DesaRepository implements DesaRepositoryInterface
{
    public function getByKecamatan($kecamatanId=null)
    {
        if (!$kecamatanId) {
        return collect();
    }

    return Desa::where('kecamatan_id', $kecamatanId)->get();
    }
}