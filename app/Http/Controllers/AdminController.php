<?php

namespace App\Http\Controllers;

use App\Exports\DetailRekapPengembalianMaterial;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Material;
use App\Models\Pekerjaan;
use App\Models\User;
use App\Services\MaterialInterface;
use App\Services\PekerjaanInterface;
use App\Services\UserInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Log;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{

    private PekerjaanInterface $pekerjaanService;
    private UserInterface $userService;
    private MaterialInterface $materialService;

    public function __construct(PekerjaanInterface $pekerjaanService, UserInterface $userService, MaterialInterface $materialService)
    {
        $this->pekerjaanService = $pekerjaanService;
        $this->userService = $userService;
        $this->materialService = $materialService;
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
        $materials = Material::all();
        return view('admin.edit-pengembalian-material', compact('pekerjaan', 'materials'));
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

    public function users()
    {
        return view('admin.user');
    }

    public function halamanTambahUser()
    {
        return view('admin.tambah-user');
    }

    public function tambahUser(Request $request)
    {
        if ($this->userService->store($request->all())) {
            return redirect(route('admin.users'))->with('success', 'Berhasil menambahkan user');
        } else {
            return redirect()->back()->with('error', 'Gagal mengambahkan user');
        }
    }

    public function editUser($userId)
    {
        $user = User::findOrFail($userId)->first();
        return view('admin.edit-user', compact('user'));
    }

    public function updateUser(Request $request, $userId)
    {
        if ($this->userService->update($userId, $request->all())) {
            return redirect(route('admin.users'))->with('success', 'Berhasil mengupdate user');
        } else {
            return redirect()->back()->with('error', 'Gagal mengupdate user');
        }
    }

    public function hapusUser($userId)
    {
        if ($this->userService->destroy($userId)) {
            return redirect(route('admin.users'))->with('success', 'Berhasil menghapus user');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus user');
        }
    }

    public function stokMaterialReturn()
    {
        return view('admin.stok-material-return');
    }

    public function daftarMaterial()
    {
        return view('admin.material');
    }

    public function halamanTambahMaterial()
    {
        return view('admin.tambah-material');
    }

    public function tambahMaterial(Request $request)
    {
        if ($this->materialService->store($request->all())) {
            return redirect(route('admin.daftar-material'))->with('success', 'Berhasil menambahkan material');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan material');
        }
    }

    public function editMaterial($idMaterial)
    {
        $material = Material::findOrFail($idMaterial)->first();
        return view('admin.edit-material', compact('material'));
    }

    public function updateMaterial(Request $request, $idMaterial)
    {
        if ($this->materialService->update($idMaterial, $request->all())) {
            return redirect(route('admin.material-return'))->with('success', 'Berhasil mengupdate material');
        } else {
            return redirect()->back()->with('error', 'Gagal mengupdate material');
        }
    }

    public function deleteMaterial($idMaterial)
    {
        if ($this->materialService->destroy($idMaterial)) {
            return redirect(route('admin.material-return'))->with('success', 'Berhasil menghapus material');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus material');
        }
    }


}
