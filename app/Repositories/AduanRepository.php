<?php

namespace App\Repositories;

use App\Interfaces\AduanRepositoryInterface;
use App\Models\Aduan;


class AduanRepository implements AduanRepositoryInterface
{
    public function getAll()
    {
        return Aduan::with('laporan')->latest()->paginate(10);
    }

    public function getById($id)
    {
        return Aduan::with('laporan')->findOrFail($id);
    }



    public function create(array $data)
    {
        return Aduan::create($data);
    }

    public function update($id, array $data)
    {
        $aduan = Aduan::findOrFail($id);
        $aduan->update($data);
        return $aduan;
    }

    public function delete($id)
    {
        $aduan = Aduan::findOrFail($id);
        return $aduan->delete();
    }
}
