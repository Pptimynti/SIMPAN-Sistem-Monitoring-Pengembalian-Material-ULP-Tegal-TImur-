<?php

namespace App\Http\Controllers;

use App\Exports\DetailRekapPengembalianMaterial;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Pekerjaan;
use App\Services\PekerjaanInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Log;
use Maatwebsite\Excel\Facades\Excel;

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

    public function rekapDetailPengembalianMaterial($pekerjaanId)
    {
        $pekerjaan = Pekerjaan::with('materialDikembalikans.gambarMaterials')
            ->findOrFail($pekerjaanId)
            ->first();
        if ($pekerjaan) {
            return view('admin.detail-pengembalian-material', compact('pekerjaan'));
        } else {
            abort(404);
        }
    }

    public function exportDetailPengembalianMaterial($pekerjaanId)
    {
        $no_agenda = Pekerjaan::findOrFail($pekerjaanId)->first()->no_agenda;
        return Excel::download(new DetailRekapPengembalianMaterial($pekerjaanId), "detail-{$no_agenda}.xlsx");
    }

    public function cetakPdfDetailPengembalianMaterial($pekerjaanId)
    {
        $pekerjaan = Pekerjaan::with('materialDikembalikans.gambarMaterials')->findOrFail($pekerjaanId)->first();

        $pdf = Pdf::loadView('detail_pengembalian_material', ['pekerjaan' => $pekerjaan])->setPaper('A4', 'landscape');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'detail-pengembalian-material.pdf');
    }

    public function profileEdit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function profileUpdate(ProfileUpdateRequest $request)
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function profileDestroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to(route('login'));
    }
}
