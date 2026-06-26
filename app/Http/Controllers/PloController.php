<?php

namespace App\Http\Controllers;

use App\Models\Clo;
use App\Models\MataKuliah;
use App\Models\Plo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PloController extends Controller
{
    // Global PLO list + CRUD
    public function index()
    {
        $plos = Plo::withCount('clos')
                   ->with(['clos' => fn($q) => $q->with('mataKuliah')->orderBy('id_mk')])
                   ->orderBy('nama_plo')
                   ->get();
        return view('plo.index_nw', compact('plos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_plo'        => 'required|string|max:10|unique:data_plo,nama_plo',
            'description_plo' => 'required|string|max:1000',
        ]);
        Plo::create($validated);
        return back()->with('success', "PLO {$validated['nama_plo']} berhasil ditambahkan.");
    }

    public function update(Request $request, int $id)
    {
        $plo = Plo::findOrFail($id);
        $validated = $request->validate([
            'nama_plo'        => "required|string|max:10|unique:data_plo,nama_plo,{$id},id_plo",
            'description_plo' => 'required|string|max:1000',
        ]);
        $plo->update($validated);
        return back()->with('success', "PLO {$plo->nama_plo} berhasil diperbarui.");
    }

    public function destroy(int $id)
    {
        $plo = Plo::findOrFail($id);
        $nama = $plo->nama_plo;
        $plo->delete();
        return back()->with('success', "PLO {$nama} berhasil dihapus.");
    }

    // Manage CLO-PLO mapping per MK
    public function managePlo(Request $request)
    {
        $matkuls  = MataKuliah::orderBy('kode_mk')->get();
        $plosAll  = Plo::orderBy('nama_plo')->get();
        $idMk     = $request->id_mk;

        $selectedMk = null;
        $cloList    = collect();

        if ($idMk) {
            $selectedMk = MataKuliah::find($idMk);
            if ($selectedMk) {
                $cloList = Clo::with('plos')
                    ->where('id_mk', $idMk)
                    ->orderBy('nama_clo')
                    ->get();
            }
        }

        return view('mata-kuliah.manage_plo_nw', compact('matkuls', 'plosAll', 'selectedMk', 'cloList', 'idMk'));
    }

    // Attach CLO → PLO with weight
    public function attachClo(Request $request)
    {
        $validated = $request->validate([
            'id_clo'            => 'required|exists:data_clo,id_clo',
            'id_plo'            => 'required|exists:data_plo,id_plo',
        ]);

        // Prevent duplicate
        $exists = DB::table('pivot_clo_plo')
            ->where('id_clo', $validated['id_clo'])
            ->where('id_plo', $validated['id_plo'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Mapping CLO → PLO ini sudah ada.');
        }

        DB::table('pivot_clo_plo')->insert([
            'id_clo'            => $validated['id_clo'],
            'id_plo'            => $validated['id_plo'],
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        return back()->with('success', 'Mapping CLO → PLO berhasil ditambahkan.');
    }

    // Detach CLO-PLO mapping
    public function detachClo(int $pivotId)
    {
        DB::table('pivot_clo_plo')->where('id_pivot', $pivotId)->delete();
        return back()->with('success', 'Mapping CLO → PLO berhasil dihapus.');
    }
}
