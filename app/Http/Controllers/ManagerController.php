<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\ActivityLog;
use App\Models\Material;
use App\Models\MaterialBekas;
use App\Models\MaterialDikembalikan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ManagerController extends Controller
{
    public function dashboard()
    {
        $activityLogs = ActivityLog::with(['pekerjaan.materialDikembalikans.material', 'materialBekas'])->latest()->paginate(5);
        $totalMaterial = Material::all()->count();
        $totalMaterialBekasDipake = MaterialBekas::where('telah_digunakan', '<=', 1)->sum('telah_digunakan');
        $materialBekas = MaterialBekas::all();
        $materialSisa = MaterialBekas::where('telah_digunakan', '<', 0)->get();
        return view('manager.dashboard', compact('totalMaterial', 'materialBekas', 'activityLogs', 'totalMaterialBekasDipake', 'materialSisa'));
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
        return view('manager.pengembalian-material');
    }

    public function stokMaterialReturn()
    {
        return view('manager.stok-material-return');
    }

    public function rekapDataPengembalianMaterial()
    {
        return view('manager.rekap-data');
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

        return Redirect::route('manager.profile-edit')->with('status', 'profile-updated');
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
