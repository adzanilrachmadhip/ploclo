<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    public function index(Request $request)
    {
        $query = MataKuliah::query();

        if ($request->filled('tahun_kurikulum')) {
            $query->where('tahun_kurikulum', $request->tahun_kurikulum);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_mk', 'like', "%{$search}%")
                  ->orWhere('nama_matakuliah', 'like', "%{$search}%");
            });
        }

        $matkul = $query->with(['clos.assessmentTools', 'clos.plos'])
                        ->orderBy('semester')->orderBy('kode_mk')->get();
        $tahunList = MataKuliah::select('tahun_kurikulum')->distinct()->orderBy('tahun_kurikulum', 'desc')->pluck('tahun_kurikulum');

        return view('mata-kuliah.index', compact('matkul', 'tahunList'));
    }

    public function lihat(Request $request)
    {
        $query = MataKuliah::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_mk', 'like', "%{$search}%")
                  ->orWhere('nama_matakuliah', 'like', "%{$search}%");
            });
        }
        $matkul = $query->orderBy('semester')->orderBy('kode_mk')->get();

        return view('mata-kuliah.lihat_nw', compact('matkul'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_mk'         => 'required|string|max:20|unique:mata_kuliah,kode_mk',
            'nama_matakuliah' => 'required|string|max:255',
            'sks'             => 'required|integer|min:1|max:6',
            'semester'        => 'required|integer|min:1|max:8',
            'tahun_kurikulum' => 'required|integer|min:2000|max:2100',
        ]);

        MataKuliah::create($validated);

        return back()->with('success', "Mata kuliah {$validated['kode_mk']} berhasil ditambahkan.");
    }

    public function update(Request $request, int $id)
    {
        $mk = MataKuliah::findOrFail($id);

        $validated = $request->validate([
            'kode_mk'         => "required|string|max:20|unique:mata_kuliah,kode_mk,{$id},id_mk",
            'nama_matakuliah' => 'required|string|max:255',
            'sks'             => 'required|integer|min:1|max:6',
            'semester'        => 'required|integer|min:1|max:8',
            'tahun_kurikulum' => 'required|integer|min:2000|max:2100',
        ]);

        $mk->update($validated);

        return back()->with('success', "Mata kuliah {$mk->kode_mk} berhasil diperbarui.");
    }

    public function destroy(int $id)
    {
        $mk = MataKuliah::findOrFail($id);
        $kode = $mk->kode_mk;
        $mk->delete();

        return back()->with('success', "Mata kuliah {$kode} berhasil dihapus.");
    }
}
