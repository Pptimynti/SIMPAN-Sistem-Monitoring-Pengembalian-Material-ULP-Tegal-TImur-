<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Material;
use App\Models\MaterialDikembalikan;
use App\Models\Pekerjaan;
use App\Services\PekerjaanInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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
        $pengembalianMaterial = Pekerjaan::where('user_id', Auth::user()->id)->latest()->paginate(3);
        $totalPengembalianMaterialByUser = Pekerjaan::where('user_id', Auth::user()->id)->whereDate('created_at', Carbon::today())->get()->count();
        return view('petugas.dashboard', compact('pengembalianMaterial', 'totalPengembalianMaterialByUser'));
    }

    public function pengembalianMaterial()
    {
        $pekerjaans = Pekerjaan::with('materialDikembalikans.gambarMaterials')->where('created_at', Carbon::parse(today()));
        return view('petugas.pengembalian-material', compact('pekerjaans'));
    }

    public function halamanTambahPengembalianMaterial()
    {
        $materials = Material::all();
        return view('petugas.tambah-pengembalian-material', compact('materials'));
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

        return Redirect::route('petugas.profile-edit')->with('status', 'profile-updated');
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
