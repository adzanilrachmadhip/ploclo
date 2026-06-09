<?php

namespace App\Http\Controllers;

use App\Models\DataAkademik;
use Illuminate\Http\Request;

class DataAkademikController extends Controller
{
    public function index()
    {
        $dataAkademik = DataAkademik::all();
        return view('data-akademik.index', compact('dataAkademik'));
    }

    public function store(Request $request)
    {
        DataAkademik::create($request->only(['kurikulum', 'angkatan', 'periode_akademik', 'kode_dosen']));
        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }
}
