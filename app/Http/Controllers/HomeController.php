<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Plo;
use App\Services\PloCalculationService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(PloCalculationService $service)
    {
        $plos = Plo::all();
        $mahasiswas = Mahasiswa::all();

        // Palette warna per PLO (cycling)
        $colors = ['#A0BCE8', '#6BE6D3', '#7DBBFF', '#F4A261', '#E76F51', '#8ECAE6', '#219EBC', '#023047', '#FFB703', '#FB8500'];

        // Hitung rata-rata final_plo_score lintas semua mahasiswa per PLO
        $ploData = $plos->map(function ($plo, $i) use ($mahasiswas, $service, $colors) {
            $scores = [];
            foreach ($mahasiswas as $mahasiswa) {
                $result = $service->calculate($mahasiswa->id_mahasiswa);
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

        return view('dashboard.index_nw', compact('ploData', 'chartMax', 'yAxisTicks', 'user', 'totalMahasiswa'));
    }
}
