<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function dashboard()
    {
        return view('manager.dashboard');
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
}
