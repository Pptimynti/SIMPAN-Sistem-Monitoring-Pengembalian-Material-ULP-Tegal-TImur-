<?php

namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use App\Services\PekerjaanInterface;
use Illuminate\Http\Request;
use Log;

class AdminController extends Controller
{

    private PekerjaanInterface $pekerjaanService;

    public function __construct(PekerjaanInterface $pekerjaanService)
    {
        $this->pekerjaanService = $pekerjaanService;
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function pengembalianMaterial()
    {
        $pekerjaans = Pekerjaan::with(['materialDikembalikans.gambarMaterials'])->get();
        return view('admin.pengembalian-material', compact('pekerjaans'));
    }

    public function editPengembalianMaterial($pekerjaanId)
    {
        $pekerjaan = Pekerjaan::where('id', $pekerjaanId)->with(['materialDikembalikans.gambarMaterials'])->first();
        return view('admin.edit-pengembalian-material', compact('pekerjaan'));
    }

    public function updatePengembalianMaterial(Request $request, $pekerjaanId)
    {
        Log::info("Data Request Update Material: " . $request);
        if ($this->pekerjaanService->updatePekerjaan($pekerjaanId, $request->all())) {
            return redirect(route('admin.pengembalian-material'))->with('success', 'Berhasil mengupdate pengembalian material');
        } else {
            return redirect()->back()->with('error', 'Gagal mengupdate pengembalian material');
        }
    }

    public function rekapPengembalianMaterial()
    {
        $pekerjaans = Pekerjaan::with(['materialDikembalikans.gambarMaterials'])->get();
        return view('admin.rekap-pengembalian-material', compact('pekerjaans'));
    }
}
