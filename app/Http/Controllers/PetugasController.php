<?php

namespace App\Http\Controllers;

use App\Services\PekerjaanInterface;
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
        return view('petugas.pengembalian-material');
    }

    public function halamanTambahPengembalianMaterial()
    {
        return view('petugas.tambah-pengembalian-material');
    }

    public function tambahPengembalianMaterial(Request $request)
    {
        Log::info($request->all);
        if ($this->pekerjaanService->tambahPekerjaan($request->all())) {
            return redirect(route('petugas.pengembalian-material'))->with('success', 'Berhasil menambahkan pengembalian material');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan pengembalian material');
        }
    }
}
