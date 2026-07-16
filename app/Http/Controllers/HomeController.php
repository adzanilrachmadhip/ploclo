<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Plo;
use App\Services\PloCalculationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request, PloCalculationService $service)
    {
        $plos = Plo::all();

        // Filter mahasiswa by angkatan (tahun_masuk) if provided
        $angkatan = $request->query('angkatan');
        $mahasiswasQuery = Mahasiswa::query();
        if ($angkatan) {
            $mahasiswasQuery->where('tahun_masuk', $angkatan);
        }
        $mahasiswas = $mahasiswasQuery->get();

        // Prepare available filter options
        $availableAngkatan = Mahasiswa::select('tahun_masuk')->distinct()->orderByDesc('tahun_masuk')->pluck('tahun_masuk')->toArray();
        // Periode options (fixed list)
        $availablePeriode = [
            '2223 Ganjil', '2223 Genap',
            '2324 Ganjil', '2324 Genap',
            '2425 Ganjil', '2425 Genap',
            '2526 Ganjil', '2526 Genap',
        ];

        $selectedPeriode = $request->query('periode');

        // Convert selected periode into tahun_kurikulum and semester number
        $selectedTahunKurikulum = null;
        $selectedSemester = null;
        if ($selectedPeriode) {
            $parts = preg_split('/\s+/', trim($selectedPeriode));
            if (count($parts) >= 2) {
                $selectedTahunKurikulum = $parts[0];
                $term = strtolower($parts[1]);
                $selectedSemester = (strpos($term, 'ganjil') !== false) ? 1 : ((strpos($term, 'genap') !== false) ? 2 : null);
            }
        }

        // Palette warna per PLO (cycling)
        $colors = ['#A0BCE8', '#6BE6D3', '#7DBBFF', '#F4A261', '#E76F51', '#8ECAE6', '#219EBC', '#023047', '#FFB703', '#FB8500'];

        // Hitung rata-rata final_plo_score lintas mahasiswa terfilter per PLO
        $filters = [
            'semester' => $selectedSemester !== null ? $selectedSemester : null,
            'tahun_kurikulum' => $selectedTahunKurikulum !== null ? $selectedTahunKurikulum : null,
        ];

        $ploData = $plos->map(function ($plo, $i) use ($mahasiswas, $service, $colors, $filters) {
            $scores = [];
            foreach ($mahasiswas as $mahasiswa) {
                $result = $service->calculate($mahasiswa->id_mahasiswa, $filters);
                foreach ($result['plo_results'] as $ploResult) {
                    if ($ploResult['id_plo'] === $plo->id_plo) {
                        $scores[] = $ploResult['final_plo_score'];
                        break;
                    }
                }
            }
            $avg = count($scores) > 0 ? round(array_sum($scores) / count($scores), 2) : 0;

            return [
                'label' => $plo->nama_plo . ' [' . $plo->nama_plo . ']',
                'value' => $avg,
                'color' => $colors[$i % count($colors)],
            ];
        })->values()->toArray();

        $totalMahasiswa = $mahasiswas->count();
        $chartMax = 100;
        $yAxisTicks = [75, 50, 25, 0];
        $user = auth()->user();

        return view('dashboard.index_nw', compact(
            'ploData', 'chartMax', 'yAxisTicks', 'user', 'totalMahasiswa',
            'availableAngkatan', 'availablePeriode', 'selectedPeriode',
            'selectedSemester', 'selectedTahunKurikulum', 'angkatan'
        ));
    }
}
