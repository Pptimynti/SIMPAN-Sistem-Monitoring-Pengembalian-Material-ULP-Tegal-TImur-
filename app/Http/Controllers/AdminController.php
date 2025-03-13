<?php

namespace App\Http\Controllers;

use App\Exports\DetailRekapPengembalianMaterial;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\ActivityLog;
use App\Models\Material;
use App\Models\MaterialBekas;
use App\Models\MaterialDikembalikan;
use App\Models\Pekerjaan;
use App\Models\User;
use App\Services\MaterialBekasInterface;
use App\Services\MaterialInterface;
use App\Services\PekerjaanInterface;
use App\Services\UserInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Log;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{

    private PekerjaanInterface $pekerjaanService;
    private UserInterface $userService;
    private MaterialInterface $materialService;
    private MaterialBekasInterface $materialBekasService;

    public function __construct(PekerjaanInterface $pekerjaanService, UserInterface $userService, MaterialInterface $materialService, MaterialBekasInterface $materialBekasService)
    {
        $this->pekerjaanService = $pekerjaanService;
        $this->userService = $userService;
        $this->materialService = $materialService;
        $this->materialBekasService = $materialBekasService;
    }

    public function dashboard()
    {
        $activityLogs = ActivityLog::with(['pekerjaan.materialDikembalikans.material', 'materialBekas'])->latest()->paginate(5);
        $totalMaterial = Material::all()->count();
        $adminCount = User::where('role', 'admin')->get()->count();
        $petugasCount = User::where('role', 'petugas')->get()->count();
        $managerCount = User::where('role', 'manager')->get()->count();
        $materialBekas = MaterialBekas::all();
        return view('admin.dashboard', compact('materialBekas', 'adminCount', 'petugasCount', 'managerCount', 'activityLogs', 'totalMaterial'));
    }

    public function activities()
    {
        $activityLogs = ActivityLog::with(['pekerjaan.materialDikembalikans.material', 'materialBekas'])->latest()->paginate(5);
        return view('admin.aktivitas', compact('activityLogs'));
    }

    public function getStatistik(Request $request)
    {
        $bulan = $request->bulan;

        $materials = MaterialDikembalikan::selectRaw('material_id, SUM(jumlah) as total_jumlah')
            ->when($bulan, function ($query) use ($bulan) {
                $query->whereMonth('created_at', $bulan);
            })
            ->groupBy('material_id')
            ->with('material')
            ->get();

        $labels = $materials->pluck('material.nama');
        $jumlah = $materials->pluck('total_jumlah');
        $satuan = $materials->pluck('material.satuan');

        return response()->json([
            'labels' => $labels,
            'jumlah' => $jumlah,
            'satuan' => $satuan,
        ]);
    }



    public function pengembalianMaterial()
    {
        $pekerjaans = Pekerjaan::with(['materialDikembalikans.gambarMaterials'])->get();
        return view('admin.pengembalian-material', compact('pekerjaans'));
    }

    public function halamanTambahPengembalianMaterial()
    {
        $materials = Material::all();
        return view('admin.tambah-pengembalian-material', compact('materials'));
    }

    public function tambahPengembalianMaterial(Request $request)
    {
        if ($this->pekerjaanService->tambahPekerjaan($request->all())) {
            return redirect(route('admin.pengembalian-material'))->with('success', 'Berhasil!');
        } else {
            return redirect()->back()->with('error', 'Gagal!');
        }
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

    public function hapusPengembalianMaterial($pekerjaanId)
    {
        if ($this->pekerjaanService->hapusPekerjaan($pekerjaanId)) {
            return redirect()->back()->with('success', 'Berhasil');
        }

        return redirect()->back()->with('error', 'Gagal');
    }

    public function rekapPengembalianMaterial()
    {
        $pekerjaans = Pekerjaan::with(['materialDikembalikans.gambarMaterials'])->get();
        return view('admin.rekap-pengembalian-material', compact('pekerjaans'));
    }

    public function rekapDetailPengembalianMaterial($pekerjaanId)
    {
        $pekerjaan = Pekerjaan::with('materialDikembalikans.gambarMaterials')
            ->findOrFail($pekerjaanId);
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

        return Redirect::route('admin.profile-edit')->with('status', 'profile-updated');
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

    public function showUser($userId)
    {
        $user = User::findOrFail($userId);
        if ($user) {
            return response()->json($user);
        }

        return response()->json([
            'error' => 'Gagal mengambil data user'
        ]);
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

    public function updateUser(Request $request)
    {
        Log::info('rekuest update user: ', $request->all());
        if ($this->userService->update($request->user_id, $request->all())) {
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
        $materials = Material::withTrashed()->get();
        $materialBekas = MaterialBekas::with('material.materialDikembalikans')->get();
        return view('admin.stok-material-return', compact('materialBekas', 'materials'));
    }

    public function materialBekasById($materialId)
    {
        $materialBekas = MaterialBekas::with('material')->where('material_id', $materialId)->first();

        if (!$materialBekas) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($materialBekas);
    }

    public function showMaterial($materialId)
    {
        $material = Material::findOrFail($materialId);

        if ($material) {
            return response()->json($material);
        }

        return response()->json(['error', 'Data Tidak Ditemukan'], 400);
    }

    public function daftarMaterial()
    {
        return view('admin.material');
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

    public function updateMaterial(Request $request)
    {
        if ($this->materialService->update($request->material_id, $request->all())) {
            return redirect(route('admin.daftar-material'))->with('success', 'Berhasil mengupdate material');
        } else {
            return redirect()->back()->with('error', 'Gagal mengupdate material');
        }
    }

    public function deleteMaterial($idMaterial)
    {
        if ($this->materialService->destroy($idMaterial)) {
            return redirect(route('admin.daftar-material'))->with('success', 'Berhasil menghapus material');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus material');
        }
    }

    public function menggunakanMaterialBekas(Request $request)
    {
        $materialBekas = MaterialBekas::findOrFail($request->materialBekas_id);
        if ($materialBekas->stok_tersedia >= $request->jumlah) {
            if ($this->materialBekasService->menggunakanMaterialBekas($materialBekas->id, $request->jumlah)) {
                return redirect()->back()->with('success', 'Berhasil');
            } else {
                return redirect()->back()->with('error', 'Gagal!');
            }
        } else {
            return redirect()->back()->with('error', 'Gagal! Material tidak mencukupi dengan jumlah yang ingin kamu pakai');
        }
    }

    public function menyesuaikanStokManual(Request $request)
    {
        Log::info('Rekuest penyesuaian material : ', $request->all());
        $materialId = $request->material_id;
        if ($this->materialBekasService->menyesuaikanStokManual($materialId, $request->jumlah)) {
            return redirect()->back()->with('success', 'Berhasil');
        } else {
            return redirect()->back()->with('error', 'Gagal!');
        }
    }
}
