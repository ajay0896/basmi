<?php

namespace App\Interfaces;

interface LaporanRepositoryInterface
{
    public function getAll($search = null, $kkecamatanId = null, $filters = []);
    public function getAllHome($search = null, $kecamatanId = null, $filters = []);
    public function getById($id);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
