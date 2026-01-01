<?php

namespace App\Http\Controllers;

use App\Http\Requests\LaporanRequestStore;
use App\Interfaces\AduanRepositoryInterface;
use App\Interfaces\DesaRepositoryInterface;
use App\Interfaces\LaporanRepositoryInterface;
use App\Services\SpamDetectionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Kecamatan;

class AduanController extends Controller
{
    protected $aduanRepo;
    protected $laporanRepo;
    protected $desaRepository;

    public function __construct(
        AduanRepositoryInterface $aduanRepo,
        LaporanRepositoryInterface $laporanRepo,
        DesaRepositoryInterface $desaRepository
    ) {
        $this->aduanRepo = $aduanRepo;
        $this->laporanRepo = $laporanRepo;
        $this->desaRepository = $desaRepository;
    }

    public function index()
     {
      $user = Auth::user();
      $laporans = $this->laporanRepo->getById($user->id);
      return view('pages.aduanku', compact('laporans'));

     }


      public function form(){

        $laporanData = session('laporan_data', []);
        $kecamatans =  Kecamatan::all();

        return view('pages.aduan-form', compact('laporanData', 'kecamatans'));

      }
      public function storeLaporan(LaporanRequestStore $request, SpamDetectionService $spamService)
     {
        $data = $request->validated();
        $spamCheck = $spamService->checkText($data['deskripsi']);

        // Handle ML API errors
        if (!$spamCheck['success']) {
            Log::error('ML spam check failed', [
                'error' => $spamCheck['error'] ?? 'Unknown error',
                'user_id' => Auth::id()
            ]);

            return back()->withErrors([
                'deskripsi' => 'Terjadi kesalahan saat memeriksa laporan. Coba lagi.'
            ])->withInput();
        }

        // Check if spam detected
        if ($spamCheck['label'] === 'spam' || $spamCheck['prediction'] === 0) {
            Log::info('Spam detected', [
                'user_id' => Auth::id(),
                'confidence' => $spamCheck['confidence'] ?? 0,
                'reason' => $spamCheck['reason'] ?? 'Unknown'
            ]);

            $errorMessage = 'Laporan terdeteksi sebagai spam.';

            // Add reason if provided by ML
            if (isset($spamCheck['reason'])) {
                $errorMessage .= ' ' . $spamCheck['reason'];
            }

            return back()->withErrors([
                'deskripsi' => $errorMessage
            ])->withInput();
        }

        // Low confidence warning (still allow but log)
        if (isset($spamCheck['confidence']) && !$spamService->isConfident($spamCheck['confidence'])) {
            Log::warning('Low confidence spam check', [
                'user_id' => Auth::id(),
                'confidence' => $spamCheck['confidence']
            ]);
        }

        // Handle file upload if exists
        if ($request->hasFile('lampiran')) {
            $data['foto'] = $request->file('lampiran')->store('laporan', 'public');
        }

        // Prepare laporan data with ML metadata
        $laporanData = [
            'user_id'          => Auth::id(),
            'deskripsi_kejadian' => $data['deskripsi'],
            'lokasi_kejadian'  => $data['lokasi'],
            'foto'             => $data['foto'] ?? null,
            'kecamatan_id'     => $data['kecamatan_id'],
            // 'desa_id'          => $data['desa_id'],
            'status'           => 'menunggu',
            'tanggal_kejadian' => now()->toDateString(),

            // Store ML metadata
            'ml_confidence'    => $spamCheck['confidence'] ?? null,
            'ml_label'         => $spamCheck['label'] ?? null,
            'ml_reason'        => $spamCheck['reason'] ?? null,
            'ml_processing_time' => $spamCheck['processing_time'] ?? null,
            'ml_checked_at'    => now(),
        ];

        $request->session()->put('laporan_data', $laporanData);

        return redirect()->route('aduan.create');
     }

         public function create()
         {
          $aduanData = session('aduan_data', []);
          return view('pages.aduan-diri', compact('aduanData'));
         }

          public function store(Request $request)
          {
           $data= $request->validate([
            'nama'   => 'required|string|max:255',
            'nik'    => 'required|string|max:16',
            'no_hp'  => 'required|string|max:15',
         ]);

        $request->session()->put('aduan_data', $data);
        $laporanData = $request->session()->get('laporan_data', []);
        $request->session()->put('final_data', array_merge($laporanData, $data));


        return redirect()->route('aduan.confirm');
      }



        public function confirm()
        {
        $laporanData = session('laporan_data', []);
        $aduanData   = session('aduan_data', []);

        if (empty($laporanData) || empty($aduanData)) {
            return redirect()->route('aduan.form')->with('error', 'Lengkapi data aduan terlebih dahulu.');
        }
        $finalData = array_merge($laporanData, $aduanData);
        return view('pages.aduan-confirm', compact('laporanData', 'aduanData', 'finalData'));
        }

       public function submitFinal(Request $request)
        {
        $laporanData = $request->session()->get('laporan_data');
        $aduanData   = $request->session()->get('aduan_data');

        if ($laporanData && $aduanData) {
            $finalData = array_merge($laporanData, $aduanData);
            // Simpan laporan
            $laporan = $this->laporanRepo->create($laporanData);

            // Simpan aduan (tanpa relasi ke laporan_masyarakat)
            $this->aduanRepo->create($aduanData);

            // Bersihkan session
            $request->session()->forget(['laporan_data', 'aduan_data']);

            return redirect()->route('home')->with('success', 'Aduan berhasil dikirim!');
          }

        return redirect()->route('aduan.form')->with('error', 'Lengkapi laporan dan aduan terlebih dahulu.');
        }





}
