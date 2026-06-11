<?php

namespace App\Http\Controllers;

use App\Models\AssessmentTool;
use App\Models\Clo;
use App\Models\MataKuliah;
use Illuminate\Http\Request;

class AssessmentToolController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $matkuls = MataKuliah::orderBy('kode_mk')->get();
        $idMk    = $request->id_mk;

        $selectedMk = null;
        $cloList    = collect();

        if ($idMk) {
            $selectedMk = MataKuliah::find($idMk);
            if ($selectedMk) {
                $cloList = Clo::with(['assessmentTools'])
                    ->where('id_mk', $idMk)
                    ->orderBy('nama_clo')
                    ->get();
            }
        }

        return view('assessment-tools.index_nw', compact('matkuls', 'selectedMk', 'cloList', 'idMk'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_clo'        => 'required|exists:data_clo,id_clo',
            'nama_at'       => 'required|string|max:100',
            'weight_in_clo' => 'required|numeric|min:0|max:100',
        ]);

        AssessmentTool::create($validated);

        return back()->with('success', "Assessment Tool '{$validated['nama_at']}' berhasil ditambahkan.");
    }

    public function update(Request $request, int $id)
    {
        $at = AssessmentTool::findOrFail($id);

        $validated = $request->validate([
            'nama_at'       => 'required|string|max:100',
            'weight_in_clo' => 'required|numeric|min:0|max:100',
        ]);

        $at->update($validated);

        return back()->with('success', "Assessment Tool '{$at->nama_at}' berhasil diperbarui.");
    }

    public function destroy(int $id)
    {
        $at   = AssessmentTool::findOrFail($id);
        $nama = $at->nama_at;
        $at->delete();

        return back()->with('success', "Assessment Tool '{$nama}' berhasil dihapus.");
    }
}
