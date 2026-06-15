<?php

namespace Database\Seeders;

use App\Models\AssessmentTool;
use App\Models\Clo;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\NilaiMahasiswa;
use App\Models\Plo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // // ── Users ──────────────────────────────────────────────
        // User::create([
        //     'username'     => 'admin',
        //     'name'         => 'Administrator',
        //     'nama_lengkap' => 'Administrator COMPASS',
        //     'email'        => 'admin@compass.ac.id',
        //     'password'     => Hash::make('password'),
        //     'role'         => 'admin',
        //     'kode_dosen'   => null,
        // ]);

        // User::create([
        //     'username'     => 'kaprodi',
        //     'name'         => 'Kaprodi SI',
        //     'nama_lengkap' => 'Dr. Berlian Rahmy Lidiawaty',
        //     'email'        => 'kaprodi@compass.ac.id',
        //     'password'     => Hash::make('password'),
        //     'role'         => 'kaprodi',
        //     'nip'          => '198501012010011001',
        //     'kode_dosen'   => null,
        // ]);

        // User::create([
        //     'username'     => 'trl',
        //     'name'         => 'Dosen Wali TRL',
        //     'nama_lengkap' => 'Dr. Tri Lathif',
        //     'email'        => 'trl@compass.ac.id',
        //     'password'     => Hash::make('password'),
        //     'role'         => 'dosen wali',
        //     'nidn'         => '0011018501',
        //     'kode_dosen'   => 'TRL',
        // ]);

        // User::create([
        //     'username'     => 'raf',
        //     'name'         => 'Dosen Wali RAF',
        //     'nama_lengkap' => 'Rafi Ahmad Fauzan, S.T., M.T.',
        //     'email'        => 'raf@compass.ac.id',
        //     'password'     => Hash::make('password'),
        //     'role'         => 'dosen wali',
        //     'nidn'         => '0021079001',
        //     'kode_dosen'   => 'RAF',
        // ]);

        // // ── PLO ────────────────────────────────────────────────
        // $plo1 = Plo::create([
        //     'nama_plo'        => 'PLO01',
        //     'description_plo' => 'Mampu menganalisis permasalahan infokom yang kompleks, mendefinisikan, dan memodelkan kebutuhan dalam konteks enterprise atau masyarakat dengan menerapkan ilmu dan pengetahuan dalam bidang komputasi, teknologi informasi dan komunikasi, dan disiplin lain yang relevan.',
        // ]);

        // $plo2 = Plo::create([
        //     'nama_plo'        => 'PLO02',
        //     'description_plo' => 'Mampu merancang, mengembangkan, mengimplementasikan, dan mengevaluasi solusi berbasis sistem informasi untuk memenuhi kebutuhan yang telah diidentifikasi dengan mempertimbangkan aspek teknis, ekonomi, sosial, dan etika.',
        // ]);

        // $plo3 = Plo::create([
        //     'nama_plo'        => 'PLO03',
        //     'description_plo' => 'Mampu bekerja secara kolaboratif, proaktif, dan bertanggung jawab dalam tim multidisiplin untuk mencapai tujuan bersama, termasuk kemampuan berkomunikasi secara efektif dengan berbagai pemangku kepentingan.',
        // ]);

        // // ── Mata Kuliah ────────────────────────────────────────
        // $mkAlgo = MataKuliah::create([
        //     'kode_mk'          => 'BBK1AAB4',
        //     'nama_matakuliah'  => 'ALGORITMA DAN PEMROGRAMAN',
        //     'sks'              => 4,
        //     'semester'         => 1,
        //     'tahun_kurikulum'  => 2024,
        // ]);

        // $mkSbd = MataKuliah::create([
        //     'kode_mk'          => 'BBK1JAB3',
        //     'nama_matakuliah'  => 'SISTEM BASIS DATA',
        //     'sks'              => 3,
        //     'semester'         => 2,
        //     'tahun_kurikulum'  => 2024,
        // ]);

        // $mkMatdis = MataKuliah::create([
        //     'kode_mk'          => 'BBK1BAB3',
        //     'nama_matakuliah'  => 'MATEMATIKA DISKRIT',
        //     'sks'              => 3,
        //     'semester'         => 1,
        //     'tahun_kurikulum'  => 2024,
        // ]);

        // // ── CLO ───────────────────────────────────────────────
        // // ALGO: 2 CLO
        // $alg_clo1 = Clo::create(['id_mk' => $mkAlgo->id_mk, 'nama_clo' => 'CLO1', 'description_clo' => 'Mahasiswa mampu memahami konsep dasar algoritma dan struktur kontrol program.']);
        // $alg_clo2 = Clo::create(['id_mk' => $mkAlgo->id_mk, 'nama_clo' => 'CLO2', 'description_clo' => 'Mahasiswa mampu mengimplementasikan algoritma dalam bahasa pemrograman Python.']);

        // // SBD: 2 CLO
        // $sbd_clo1 = Clo::create(['id_mk' => $mkSbd->id_mk, 'nama_clo' => 'CLO1', 'description_clo' => 'Mahasiswa mampu merancang skema database relasional yang efisien.']);
        // $sbd_clo2 = Clo::create(['id_mk' => $mkSbd->id_mk, 'nama_clo' => 'CLO2', 'description_clo' => 'Mahasiswa mampu menggunakan SQL untuk manipulasi data.']);

        // // MATDIS: 2 CLO
        // $mat_clo1 = Clo::create(['id_mk' => $mkMatdis->id_mk, 'nama_clo' => 'CLO1', 'description_clo' => 'Mahasiswa mampu menerapkan logika proposisional dan teori himpunan.']);
        // $mat_clo2 = Clo::create(['id_mk' => $mkMatdis->id_mk, 'nama_clo' => 'CLO2', 'description_clo' => 'Mahasiswa mampu bekerja dalam kelompok untuk menyelesaikan persoalan matematika diskrit.']);

        // // ── Pivot CLO ↔ PLO ────────────────────────────────────
        // DB::table('pivot_clo_plo')->insert([
        //     ['id_clo' => $alg_clo1->id_clo, 'id_plo' => $plo1->id_plo, 'percentage_weight' => 40.00, 'created_at' => now(), 'updated_at' => now()],
        //     ['id_clo' => $alg_clo1->id_clo, 'id_plo' => $plo2->id_plo, 'percentage_weight' => 60.00, 'created_at' => now(), 'updated_at' => now()],
        //     ['id_clo' => $alg_clo2->id_clo, 'id_plo' => $plo2->id_plo, 'percentage_weight' => 100.00, 'created_at' => now(), 'updated_at' => now()],
        //     ['id_clo' => $sbd_clo1->id_clo, 'id_plo' => $plo1->id_plo, 'percentage_weight' => 50.00, 'created_at' => now(), 'updated_at' => now()],
        //     ['id_clo' => $sbd_clo1->id_clo, 'id_plo' => $plo2->id_plo, 'percentage_weight' => 50.00, 'created_at' => now(), 'updated_at' => now()],
        //     ['id_clo' => $sbd_clo2->id_clo, 'id_plo' => $plo2->id_plo, 'percentage_weight' => 100.00, 'created_at' => now(), 'updated_at' => now()],
        //     ['id_clo' => $mat_clo1->id_clo, 'id_plo' => $plo1->id_plo, 'percentage_weight' => 100.00, 'created_at' => now(), 'updated_at' => now()],
        //     ['id_clo' => $mat_clo2->id_clo, 'id_plo' => $plo3->id_plo, 'percentage_weight' => 100.00, 'created_at' => now(), 'updated_at' => now()],
        // ]);

        // // ── Assessment Tools ───────────────────────────────────
        // // ALGO CLO1: UTS 40%, UAS 60%
        // $at_alg1_uts = AssessmentTool::create(['id_clo' => $alg_clo1->id_clo, 'nama_at' => 'UTS CLO1',   'weight_in_clo' => 40.00]);
        // $at_alg1_uas = AssessmentTool::create(['id_clo' => $alg_clo1->id_clo, 'nama_at' => 'UAS CLO1',   'weight_in_clo' => 60.00]);
        // // ALGO CLO2: TUGAS 30%, UAS 70%
        // $at_alg2_tgs = AssessmentTool::create(['id_clo' => $alg_clo2->id_clo, 'nama_at' => 'TUGAS CLO2', 'weight_in_clo' => 30.00]);
        // $at_alg2_uas = AssessmentTool::create(['id_clo' => $alg_clo2->id_clo, 'nama_at' => 'UAS CLO2',   'weight_in_clo' => 70.00]);

        // // SBD CLO1: UTS 40%, UAS 60%
        // $at_sbd1_uts = AssessmentTool::create(['id_clo' => $sbd_clo1->id_clo, 'nama_at' => 'UTS CLO1',   'weight_in_clo' => 40.00]);
        // $at_sbd1_uas = AssessmentTool::create(['id_clo' => $sbd_clo1->id_clo, 'nama_at' => 'UAS CLO1',   'weight_in_clo' => 60.00]);
        // // SBD CLO2: QUIZ 30%, UAS 70%
        // $at_sbd2_qiz = AssessmentTool::create(['id_clo' => $sbd_clo2->id_clo, 'nama_at' => 'QUIZ CLO2',  'weight_in_clo' => 30.00]);
        // $at_sbd2_uas = AssessmentTool::create(['id_clo' => $sbd_clo2->id_clo, 'nama_at' => 'UAS CLO2',   'weight_in_clo' => 70.00]);

        // // MATDIS CLO1: UTS 50%, UAS 50%
        // $at_mat1_uts = AssessmentTool::create(['id_clo' => $mat_clo1->id_clo, 'nama_at' => 'UTS CLO1',   'weight_in_clo' => 50.00]);
        // $at_mat1_uas = AssessmentTool::create(['id_clo' => $mat_clo1->id_clo, 'nama_at' => 'UAS CLO1',   'weight_in_clo' => 50.00]);
        // // MATDIS CLO2: PRESENTASI 40%, UAS 60%
        // $at_mat2_pre = AssessmentTool::create(['id_clo' => $mat_clo2->id_clo, 'nama_at' => 'PRESENTASI', 'weight_in_clo' => 40.00]);
        // $at_mat2_uas = AssessmentTool::create(['id_clo' => $mat_clo2->id_clo, 'nama_at' => 'UAS CLO2',   'weight_in_clo' => 60.00]);

        // // ── Mahasiswa ──────────────────────────────────────────
        // $students = [
        //     ['nim' => '1301224001', 'nama' => 'Andi Pratama',       'kode_dosen' => 'TRL'],
        //     ['nim' => '1301224002', 'nama' => 'Bella Sari Dewi',    'kode_dosen' => 'TRL'],
        //     ['nim' => '1301224003', 'nama' => 'Chandra Wijaya',     'kode_dosen' => 'TRL'],
        //     ['nim' => '1301224004', 'nama' => 'Diana Putri Utami',  'kode_dosen' => 'RAF'],
        //     ['nim' => '1301224005', 'nama' => 'Eko Saputra',        'kode_dosen' => 'RAF'],
        // ];

        // $mahasiswaModels = [];
        // foreach ($students as $s) {
        //     $mahasiswaModels[] = Mahasiswa::create([
        //         'nim'         => $s['nim'],
        //         'nama'        => $s['nama'],
        //         'tahun_masuk' => 2024,
        //         'class_code'  => 'SI-44-01',
        //         'status'      => 'Aktif',
        //         'kode_dosen'  => $s['kode_dosen'],
        //     ]);
        // }

        // // ── Nilai Mahasiswa ────────────────────────────────────
        // // Semua AT yang relevan per mahasiswa
        // $allAts = [
        //     $at_alg1_uts, $at_alg1_uas, $at_alg2_tgs, $at_alg2_uas,
        //     $at_sbd1_uts, $at_sbd1_uas, $at_sbd2_qiz, $at_sbd2_uas,
        //     $at_mat1_uts, $at_mat1_uas, $at_mat2_pre, $at_mat2_uas,
        // ];

        // // Nilai representatif per mahasiswa (realistis beda-beda kemampuan)
        // $scoreMatrix = [
        //     // Andi:   konsisten bagus
        //     [85, 88, 90, 82, 78, 80, 88, 85, 92, 90, 87, 86],
        //     // Bella:  sangat baik
        //     [92, 95, 88, 91, 90, 93, 87, 94, 96, 94, 91, 93],
        //     // Chandra: rata-rata
        //     [70, 72, 68, 75, 65, 70, 72, 68, 74, 71, 69, 73],
        //     // Diana:  bagus di basis data, lemah matdis
        //     [78, 80, 82, 79, 88, 90, 85, 92, 62, 65, 70, 68],
        //     // Eko:    lemah di algo, bagus matdis
        //     [60, 65, 62, 70, 72, 75, 68, 74, 88, 85, 90, 87],
        // ];

        // foreach ($mahasiswaModels as $i => $mahasiswa) {
        //     foreach ($allAts as $j => $at) {
        //         NilaiMahasiswa::create([
        //             'id_mahasiswa' => $mahasiswa->id_mahasiswa,
        //             'id_at'        => $at->id_at,
        //             'score'        => $scoreMatrix[$i][$j],
        //         ]);
        //     }
        // }
    }
}
