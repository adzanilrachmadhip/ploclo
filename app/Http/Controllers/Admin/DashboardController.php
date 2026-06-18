<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalUsers = DB::table('users')->count();

        $totalAdmin = DB::table('users')
            ->whereRaw('LOWER(role) = ?', ['admin'])
            ->count();

        $totalKaprodi = DB::table('users')
            ->whereRaw('LOWER(role) = ?', ['kaprodi'])
            ->count();

        $totalDosenWali = DB::table('users')
            ->whereRaw("LOWER(role) IN ('dosen wali', 'dosen_wali', 'dosenwali', 'dosen-wali')")
            ->count();

        $totalMahasiswa = DB::table('mahasiswa')->count();
        $totalMataKuliah = DB::table('mata_kuliah')->count();
        $totalAssessmentTools = DB::table('assessment_tools')->count();
        $totalClo = DB::table('data_clo')->count();
        $totalPlo = DB::table('data_plo')->count();

        $totalRps = 0;
        if (Schema::hasColumn('mata_kuliah', 'file_rps')) {
            $totalRps = DB::table('mata_kuliah')
                ->whereNotNull('file_rps')
                ->where('file_rps', '!=', '')
                ->count();
        }

        $mkWithClo = DB::table('data_clo')
            ->whereNotNull('id_mk')
            ->distinct()
            ->count('id_mk');

        $mappedClo = DB::table('pivot_clo_plo')
            ->whereNotNull('id_clo')
            ->distinct()
            ->count('id_clo');

        $totalMappingCloPlo = DB::table('pivot_clo_plo')->count();

        $mahasiswaWithNilai = DB::table('nilai_mahasiswa')
            ->whereNotNull('id_mahasiswa')
            ->distinct()
            ->count('id_mahasiswa');

        $rpsPercent = $this->percent($totalRps, $totalMataKuliah);
        $cloPercent = $this->percent($mkWithClo, $totalMataKuliah);
        $mappingPercent = $this->percent($mappedClo, $totalClo);
        $nilaiPercent = $this->percent($mahasiswaWithNilai, $totalMahasiswa);

        $userPercent = $totalUsers > 0 ? 100 : 0;
        $mahasiswaPercent = $totalMahasiswa > 0 ? 100 : 0;
        $mataKuliahPercent = $totalMataKuliah > 0 ? 100 : 0;
        $ploPercent = $totalPlo >= 10 ? 100 : $this->percent($totalPlo, 10);

        $overallPercent = (int) round(collect([
            $userPercent,
            $mahasiswaPercent,
            $mataKuliahPercent,
            $rpsPercent,
            $cloPercent,
            $ploPercent,
            $mappingPercent,
            $nilaiPercent,
        ])->avg());

        $tahunAktif = DB::table('mata_kuliah')->max('tahun_kurikulum');
        $activePeriod = $tahunAktif ? $tahunAktif . '/1 (Ganjil)' : '-';

        $metrics = [
            'total_users' => $totalUsers,
            'total_admin' => $totalAdmin,
            'total_kaprodi' => $totalKaprodi,
            'total_dosen_wali' => $totalDosenWali,

            'total_mahasiswa' => $totalMahasiswa,
            'total_mata_kuliah' => $totalMataKuliah,
            'total_rps' => $totalRps,
            'total_assessment_tools' => $totalAssessmentTools,

            'total_clo' => $totalClo,
            'total_plo' => $totalPlo,
            'mapped_clo' => $mappedClo,
            'total_mapping_clo_plo' => $totalMappingCloPlo,
            'mahasiswa_with_nilai' => $mahasiswaWithNilai,

            'rps_percent' => $rpsPercent,
            'clo_percent' => $cloPercent,
            'mapping_percent' => $mappingPercent,
            'nilai_percent' => $nilaiPercent,
            'overall_percent' => $overallPercent,

            'active_period' => $activePeriod,
            'tahun_aktif' => $tahunAktif ?? '-',
        ];

        $completeness = [
            [
                'label' => 'User',
                'status' => $this->statusText($userPercent),
                'class' => $this->statusClass($userPercent),
                'full' => false,
            ],
            [
                'label' => 'Mahasiswa',
                'status' => $this->statusText($mahasiswaPercent),
                'class' => $this->statusClass($mahasiswaPercent),
                'full' => false,
            ],
            [
                'label' => 'Mata Kuliah',
                'status' => $this->statusText($mataKuliahPercent),
                'class' => $this->statusClass($mataKuliahPercent),
                'full' => false,
            ],
            [
                'label' => 'RPS',
                'status' => $this->statusText($rpsPercent),
                'class' => $this->statusClass($rpsPercent),
                'full' => false,
            ],
            [
                'label' => 'CLO',
                'status' => $this->statusText($cloPercent),
                'class' => $this->statusClass($cloPercent),
                'full' => false,
            ],
            [
                'label' => 'PLO',
                'status' => $this->statusText($ploPercent),
                'class' => $this->statusClass($ploPercent),
                'full' => false,
            ],
            [
                'label' => 'Mapping CLO-PLO',
                'status' => $this->statusText($mappingPercent),
                'class' => $this->statusClass($mappingPercent),
                'full' => true,
            ],
            [
                'label' => 'Nilai Mahasiswa',
                'status' => $this->statusText($nilaiPercent),
                'class' => $this->statusClass($nilaiPercent),
                'full' => true,
            ],
        ];

        $activities = $this->latestActivities();

        $navItems = [
            [
                'label' => 'Dashboard',
                'route' => 'admin.dashboard',
                'icon' => 'home',
            ],
            [
                'label' => 'Kelola User',
                'route' => 'users.index',
                'icon' => 'users',
            ],
            [
                'label' => 'Kelola Mahasiswa',
                'route' => 'mahasiswa.index',
                'icon' => 'users',
            ],
            [
                'label' => 'Kelola Mata Kuliah',
                'route' => 'mata-kuliah.index',
                'icon' => 'book',
            ],
            [
                'label' => 'Kelola Kurikulum',
                'route' => '#',
                'icon' => 'book',
            ],
            [
                'label' => 'RPS',
                'route' => 'rps.index',
                'icon' => 'file',
            ],
            [
                'label' => 'Pengaturan Sistem',
                'route' => '#',
                'icon' => 'setting',
            ],
        ];

        return view('admin.dashboard', compact(
            'user',
            'navItems',
            'metrics',
            'completeness',
            'activities'
        ));
    }

    private function percent(int $value, int $total): int
    {
        if ($total <= 0) {
            return 0;
        }

        $percent = (int) round(($value / $total) * 100);

        return min($percent, 100);
    }

    private function statusText(int $percent): string
    {
        if ($percent >= 90) {
            return 'Lengkap';
        }

        if ($percent > 0) {
            return 'Sebagian';
        }

        return 'Belum Lengkap';
    }

    private function statusClass(int $percent): string
    {
        if ($percent >= 90) {
            return 'complete';
        }

        if ($percent > 0) {
            return 'warning';
        }

        return 'danger';
    }

    private function latestActivities(): array
    {
        $activities = collect();

        if (Schema::hasColumn('users', 'created_at')) {
            DB::table('users')
                ->select('name', 'username', 'role', 'created_at')
                ->whereNotNull('created_at')
                ->orderByDesc('created_at')
                ->limit(3)
                ->get()
                ->each(function ($user) use ($activities) {
                    $name = $user->name ?: $user->username;

                    $activities->push([
                        'time_raw' => $user->created_at,
                        'time' => $this->formatDate($user->created_at),
                        'text' => 'User ' . $name . ' ditambahkan sebagai ' . $user->role,
                        'color' => 'blue',
                    ]);
                });
        }

        if (Schema::hasColumn('mata_kuliah', 'created_at')) {
            DB::table('mata_kuliah')
                ->select('kode_mk', 'nama_matakuliah', 'created_at')
                ->whereNotNull('created_at')
                ->orderByDesc('created_at')
                ->limit(3)
                ->get()
                ->each(function ($mk) use ($activities) {
                    $activities->push([
                        'time_raw' => $mk->created_at,
                        'time' => $this->formatDate($mk->created_at),
                        'text' => 'Mata kuliah ' . $mk->nama_matakuliah . ' ditambahkan',
                        'color' => 'green',
                    ]);
                });
        }

        if (Schema::hasColumn('mahasiswa', 'created_at')) {
            DB::table('mahasiswa')
                ->select('nama', 'created_at')
                ->whereNotNull('created_at')
                ->orderByDesc('created_at')
                ->limit(3)
                ->get()
                ->each(function ($mahasiswa) use ($activities) {
                    $activities->push([
                        'time_raw' => $mahasiswa->created_at,
                        'time' => $this->formatDate($mahasiswa->created_at),
                        'text' => 'Mahasiswa ' . $mahasiswa->nama . ' ditambahkan',
                        'color' => 'purple',
                    ]);
                });
        }

        return $activities
            ->sortByDesc('time_raw')
            ->take(5)
            ->values()
            ->toArray();
    }

    private function formatDate($date): string
    {
        return Carbon::parse($date)
            ->locale('id')
            ->translatedFormat('d F Y, H:i');
    }
}
