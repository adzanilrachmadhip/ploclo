<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\NilaiMahasiswa;
use App\Services\PloCalculationService;
use Illuminate\Http\Request;

class DosenWaliDashboardController extends Controller
{
    public function index(PloCalculationService $ploService)
    {
        $user = auth()->user();
        $kodeDosen = strtolower($user->kode_dosen ?? $user->username ?? '');
        $mahasiswaPerwalian = Mahasiswa::query()
            ->whereRaw('LOWER(kode_dosen) = ?', [$kodeDosen])
            ->orderBy('class_code')
            ->orderBy('nama')
            ->get();

        $totalMahasiswaPerwalian = $mahasiswaPerwalian->count();
        $jumlahKelasPerwalian = $mahasiswaPerwalian
            ->pluck('class_code')
            ->filter()
            ->unique()
            ->count();

        $students = [];
        $allStudentAverages = [];

        foreach ($mahasiswaPerwalian as $index => $mahasiswa) {
            $averagePlo = null;

            try {
                $result = $ploService->calculate($mahasiswa->id_mahasiswa);

                $ploScores = collect($result['plo_results'] ?? [])
                    ->pluck('final_plo_score')
                    ->filter(function ($score) {
                        return is_numeric($score);
                    })
                    ->values();

                if ($ploScores->count() > 0) {
                    $averagePlo = round($ploScores->avg(), 2);
                    $allStudentAverages[] = $averagePlo;
                }
            } catch (\Throwable $e) {
                $averagePlo = null;
            }

            $status = 'Perlu Perhatian';

            if ($averagePlo !== null && $averagePlo >= 75) {
                $status = 'Aman';
            }

            $students[] = [
                'no' => $index + 1,
                'nim' => $mahasiswa->nim,
                'nama' => $mahasiswa->nama,
                'kelas' => $mahasiswa->class_code ?? '-',
                'nilai_plo' => $averagePlo !== null ? $averagePlo . '%' : '-',
                'status' => $status,
            ];
        }

        $rataRataPlo = count($allStudentAverages) > 0
            ? round(array_sum($allStudentAverages) / count($allStudentAverages), 2)
            : 0;

        $chartData = [
            ['label' => 'PLO1', 'value' => 84],
            ['label' => 'PLO2', 'value' => 76],
            ['label' => 'PLO3', 'value' => 88],
            ['label' => 'PLO4', 'value' => 70],
            ['label' => 'PLO5', 'value' => 82],
            ['label' => 'PLO6', 'value' => 91],
            ['label' => 'PLO7', 'value' => 79],
            ['label' => 'PLO8', 'value' => 86],
        ];

        $mahasiswaIds = $mahasiswaPerwalian
            ->pluck('id_mahasiswa')
            ->toArray();

        $latestScores = NilaiMahasiswa::with([
            'mahasiswa',
            'assessmentTool.clo.mataKuliah',
        ])
            ->whereIn('id_mahasiswa', $mahasiswaIds)
            ->orderByDesc('updated_at')
            ->limit(5)
            ->get();

        $activities = $latestScores
            ->map(function ($nilai, $index) {
                $types = ['green', 'blue', 'purple', 'orange', 'blue'];

                $namaMahasiswa = $nilai->mahasiswa->nama ?? 'Mahasiswa';
                $kelas = $nilai->mahasiswa->class_code ?? '-';
                $namaAt = $nilai->assessmentTool->nama_at ?? 'Assessment Tool';
                $namaMk = $nilai->assessmentTool->clo->mataKuliah->nama_matakuliah ?? 'Mata Kuliah';

                return [
                    'title' => 'Nilai mahasiswa diperbarui',
                    'time' => optional($nilai->updated_at)->diffForHumans() ?? 'Terbaru',
                    'desc' => $kelas . ' - ' . $namaMahasiswa . ' | ' . $namaAt . ' - ' . $namaMk,
                    'type' => $types[$index % count($types)],
                ];
            })
            ->values()
            ->toArray();

        if (count($activities) === 0) {
            $activities = [
                [
                    'title' => 'Belum ada aktivitas nilai',
                    'time' => '-',
                    'desc' => 'Belum ada perubahan nilai pada mahasiswa perwalian ini',
                    'type' => 'orange',
                ],
            ];
        }

        return view('dashboard.dosen_wali', compact(
            'user',
            'totalMahasiswaPerwalian',
            'jumlahKelasPerwalian',
            'rataRataPlo',
            'students',
            'activities',
            'chartData'
        ));
    }
}
