<?php

namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use App\Services\PekerjaanInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Log;

class PetugasController extends Controller
{
    private PekerjaanInterface $pekerjaanService;

    public function __construct(PekerjaanInterface $pekerjaanService)
    {
        $this->pekerjaanService = $pekerjaanService;
    }
    public function dashboard()
    {
        return view('petugas.dashboard');
    }

    public function pengembalianMaterial()
    {
        $pekerjaans = Pekerjaan::with('materialDikembalikans.gambarMaterials')->where('created_at', Carbon::parse(today()));
        return view('petugas.pengembalian-material', compact('pekerjaans'));
    }

    public function halamanTambahPengembalianMaterial()
    {
        return view('petugas.tambah-pengembalian-material');
    }

    public function tambahPengembalianMaterial(Request $request)
    {
        Log::info('Data yang diterima untuk tambah:', $request->all());
        if ($this->pekerjaanService->tambahPekerjaan($request->all())) {
            return redirect(route('petugas.pengembalian-material'))->with('success', 'Berhasil menambahkan pengembalian material');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan pengembalian material');
        }
    }
}
