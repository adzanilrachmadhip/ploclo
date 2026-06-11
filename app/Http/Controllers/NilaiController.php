<?php

namespace App\Http\Controllers;

use App\Models\AssessmentTool;
use App\Models\Clo;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\NilaiMahasiswa;
use App\Models\Plo;
use App\Models\User;
use App\Services\PloCalculationService;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index(Request $request, PloCalculationService $service)
    {
        $user  = auth()->user();
        $query = Mahasiswa::query();

        // Dosen wali hanya bisa lihat mahasiswa bimbingannya sendiri
        if ($user->isDosenWali()) {
            $query->where('kode_dosen', $user->kode_dosen);
        } else {
            // Admin/Kaprodi bisa filter bebas
            $query->when($request->filled('kode_dosen'), fn($q) => $q->where('kode_dosen', $request->kode_dosen));
        }

        $query->when($request->filled('angkatan'), fn($q) => $q->where('tahun_masuk', $request->angkatan))
              ->when($request->filled('status'),   fn($q) => $q->where('status', $request->status));

        $mahasiswas = $query->orderBy('nama')->get();
        $plos       = Plo::orderBy('id_plo')->get();

        $rows = $mahasiswas->map(function ($mahasiswa) use ($service, $plos) {
            $result     = $service->calculate($mahasiswa->id_mahasiswa);
            $ploResults = collect($result['plo_results']);

            return [
                'mahasiswa' => $mahasiswa,
                'plos' => $plos->mapWithKeys(function ($plo) use ($ploResults) {
                    $score = $ploResults[$plo->id_plo]['final_plo_score'] ?? null;
                    return [$plo->id_plo => $score !== null ? round($score, 2) : '-'];
                }),
            ];
        });

        // Data untuk dropdown filter
        $angkatanList = Mahasiswa::select('tahun_masuk')->distinct()->orderBy('tahun_masuk', 'desc')->pluck('tahun_masuk');
        $dosenList    = User::where('role', 'dosen wali')->whereNotNull('kode_dosen')->orderBy('kode_dosen')->get(['kode_dosen', 'nama_lengkap']);

        return view('nilai.index_nw', compact('rows', 'plos', 'angkatanList', 'dosenList'));
    }

    public function inputForm(Request $request)
    {
        $matkuls = MataKuliah::orderBy('kode_mk')->get();
        $idAt    = $request->id_at;
        $idMk    = $request->id_mk;

        $selectedAt = null;
        $mahasiswas = collect();
        $existingScores = [];
        $cloAtList = collect();

        if ($idMk) {
            $cloAtList = Clo::with('assessmentTools')
                ->where('id_mk', $idMk)
                ->orderBy('nama_clo')
                ->get();
        }

        if ($idAt) {
            $selectedAt = AssessmentTool::with('clo.mataKuliah')->findOrFail($idAt);
            $mahasiswas = Mahasiswa::orderBy('nama')->get();

            $existingScores = NilaiMahasiswa::where('id_at', $idAt)
                ->pluck('score', 'id_mahasiswa')
                ->toArray();

            $idMk = $selectedAt->clo?->id_mk;
            $cloAtList = Clo::with('assessmentTools')
                ->where('id_mk', $idMk)
                ->orderBy('nama_clo')
                ->get();
        }

        return view('nilai.input_nw', compact(
            'matkuls', 'cloAtList', 'selectedAt',
            'mahasiswas', 'existingScores', 'idMk', 'idAt'
        ));
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'id_at'    => 'required|exists:assessment_tools,id_at',
            'scores'   => 'required|array',
            'scores.*' => 'nullable|numeric|min:0|max:100',
        ]);

        $idAt = $request->id_at;

        foreach ($request->scores as $idMahasiswa => $score) {
            if ($score === null || $score === '') continue;

            NilaiMahasiswa::updateOrCreate(
                ['id_mahasiswa' => $idMahasiswa, 'id_at' => $idAt],
                ['score' => $score]
            );
        }

        return back()->with('success', 'Nilai berhasil disimpan.');
    }

    public function show($idMahasiswa, $idPlo, PloCalculationService $service)
    {
        $mahasiswa = Mahasiswa::findOrFail($idMahasiswa);
        $plo = Plo::findOrFail($idPlo);

        $result = $service->calculate($idMahasiswa);

        $cloResults = collect($result['clo_results'])
            ->filter(fn ($clo) => $clo['id_plo'] == $idPlo)
            ->values();

        return view('nilai.show_nw', compact('mahasiswa', 'plo', 'cloResults'));
    }
}
