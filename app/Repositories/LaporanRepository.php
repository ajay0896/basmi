<?php

namespace App\Repositories;

use App\Interfaces\LaporanRepositoryInterface;
use App\Models\LaporanMasyarakat;

class LaporanRepository implements LaporanRepositoryInterface
{
    public function getAll($search = null, $kecamatanId = null, $filters = [])
    {
        $query = LaporanMasyarakat::query();

        if ($search) {
        $keywords = explode(" ", $search);

        $query->where(function ($q) use ($keywords) {
        foreach ($keywords as $word) {
            $q->orWhere('deskripsi_kejadian', 'like', '%' . $word . '%')
              ->orWhere('lokasi_kejadian', 'like', '%' . $word . '%');
               }
            });
          }

         if ($kecamatanId) {
           $query->where('kecamatan_id', $kecamatanId);
          }

        $sort = $filters['sort'] ?? 'latest';

        if ($sort === 'oldest') {
        $query->orderBy('tanggal_kejadian', 'asc');
        } else {
        $query->orderBy('tanggal_kejadian', 'desc');
        }

        return $query->paginate(10);
    }

     public function getAllHome($search = null, $kecamatanId = null, $filters = []){
           $query = LaporanMasyarakat::query();

            if ($search) {
               $query->where('deskripsi_kejadian', 'LIKE', "%{$search}%")
              ->orWhere('lokasi_kejadian', 'LIKE', "%{$search}%");
           }

           if ($kecamatanId) {
               $query->where('kecamatan_id', $kecamatanId);
             }

           return $query->latest()->get();
     }

    public function getById($id)
    {
        return LaporanMasyarakat::where('user_id', $id)
        ->orderBy('tanggal_kejadian', 'desc')
        ->get();
    }
       public function find($id)
        {
           return LaporanMasyarakat::find($id);
        }


    public function create(array $data)
    {
         do {
            $data['kode_laporan'] = $this->generateCode();
          } while (LaporanMasyarakat::where('kode_laporan', $data['kode_laporan'])->exists());
        return LaporanMasyarakat::create($data);
    }

    public function update($id, array $data)
    {
        $laporan = LaporanMasyarakat::findOrFail($id);
        $laporan->update($data);
        return $laporan;
    }

    public function delete($id)
    {
        $laporan = LaporanMasyarakat::findOrFail($id);
        return $laporan->delete();
    }

    private function generateCode()
    {
        return 'bsm' . rand(100000, 999999);
    }
}