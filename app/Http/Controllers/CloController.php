<?php

namespace App\Http\Controllers;

use App\Models\Clo;
use App\Models\MataKuliah;
use Illuminate\Http\Request;

class CloController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_mk'          => 'required|exists:mata_kuliah,id_mk',
            'nama_clo'       => 'required|string|max:20',
            'description_clo'=> 'required|string|max:1000',
        ]);
        Clo::create($validated);
        return back()->with('success', "CLO {$validated['nama_clo']} berhasil ditambahkan.");
    }

    public function update(Request $request, int $id)
    {
        $clo = Clo::findOrFail($id);
        $validated = $request->validate([
            'nama_clo'        => 'required|string|max:20',
            'description_clo' => 'required|string|max:1000',
        ]);
        $clo->update($validated);
        return back()->with('success', "CLO {$clo->nama_clo} berhasil diperbarui.");
    }

    public function destroy(int $id)
    {
        $clo = Clo::findOrFail($id);
        $nama = $clo->nama_clo;
        $clo->delete();
        return back()->with('success', "CLO {$nama} berhasil dihapus.");
    }
}
