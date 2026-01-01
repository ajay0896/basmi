<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\LaporanRepositoryInterface;
use App\Models\Kecamatan;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LaporanRequestStore;


class LaporanController extends Controller
{
    protected $laporanRepo;

    public function __construct(LaporanRepositoryInterface $laporanRepo)
    {

        $this->laporanRepo = $laporanRepo;
    }

       public function index()
       {
        $laporans = $this->laporanRepo->getAll(null, null, []);
        $kecamatans = Kecamatan::orderBy('nama')->get();
        $filters = [];

           return view('pages.home', compact('laporans', 'kecamatans', 'filters'));
           }

         public function jelajah(Request $request)
        {
        $filters = [
            'kecamatan_id' => $request->get('kecamatan_id'),
            'sort'         => $request->get('sort', 'latest'),
        ];
         $search    = $request->get('search');
         $kecamatanId = $request->get('kecamatan_id');


        $laporans   = $this->laporanRepo->getAll($search, $kecamatanId, $filters);
        $kecamatans = Kecamatan::orderBy('nama')->get();

        return view('pages.laporan', compact('laporans', 'kecamatans', 'filters'));
          }


          public function detail($id)
          {
             $user = Auth::user();

             // ambil semua laporan berdasarkan user_id
             $laporan = $this->laporanRepo->find($id);

             if (!$laporan) {
                 return redirect()->route('aduan.show')->with('error', 'Belum ada laporan yang ditemukan.');
             }

             return view('pages.detail', compact('laporan'));
         }


         public function search(Request $request)
          {
             $search = $request->get('search');
             $kecamatanId = $request->get('kecamatan_id');



              $filters = [
            'kecamatan_id' => $kecamatanId,
              ];


              $laporans = $this->laporanRepo->getAll($search, $kecamatanId, $filters);


              $kecamatans = Kecamatan::orderBy('nama')->get();

               return view('pages.home', compact('laporans', 'kecamatans', 'filters'));
        }





}