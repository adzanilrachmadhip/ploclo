@extends('layout.app_nw')

@section('title', 'Dashboard Admin')

@section('topbar_adm')
    @include('components.topbar_adm', [
        'title' => 'Dashboard Admin',
        'subtitle' => 'Selamat datang di sistem COMPASS',
    ])
@endsection

@section('content')
    <div class="admin-page">
        <main class="admin-content">
            <div class="admin-content-header">
                <div>
                    <h2>Overview Data Sistem</h2>
                    <p>Ringkasan data utama dan kelengkapan akademik COMPASS.</p>
                </div>

                <div class="admin-period-card">
                    <div class="period-icon">
                        <i class="bi bi-calendar3"></i>
                    </div>
                    <div>
                        <span>Periode Akademik Aktif</span>
                        <strong>2526/1 (Ganjil)</strong>
                    </div>
                    <i class="bi bi-chevron-down"></i>
                </div>
            </div>

            <section class="admin-stats-grid">
                <div class="admin-stat-card">
                    <div class="stat-icon blue">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <span>Total User</span>
                        <h3>12</h3>
                        <p>3 Admin, 1 Kaprodi, 8 Dosen Wali</p>
                    </div>
                </div>

                <div class="admin-stat-card">
                    <div class="stat-icon green">
                        <i class="bi bi-person-vcard-fill"></i>
                    </div>
                    <div>
                        <span>Total Mahasiswa</span>
                        <h3>356</h3>
                        <p>Semua angkatan</p>
                    </div>
                </div>

                <div class="admin-stat-card">
                    <div class="stat-icon orange">
                        <i class="bi bi-person-workspace"></i>
                    </div>
                    <div>
                        <span>Total Dosen Wali</span>
                        <h3>8</h3>
                        <p>Dosen wali aktif</p>
                    </div>
                </div>

                <div class="admin-stat-card">
                    <div class="stat-icon purple">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                    <div>
                        <span>Mata Kuliah</span>
                        <h3>54</h3>
                        <p>Kurikulum 2024</p>
                    </div>
                </div>

                <div class="admin-stat-card">
                    <div class="stat-icon cyan">
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </div>
                    <div>
                        <span>Total RPS</span>
                        <h3>48</h3>
                        <p>RPS terunggah</p>
                    </div>
                </div>

                <div class="admin-stat-card">
                    <div class="stat-icon indigo">
                        <i class="bi bi-clipboard-check-fill"></i>
                    </div>
                    <div>
                        <span>Assessment Tools</span>
                        <h3>87</h3>
                        <p>Komponen penilaian</p>
                    </div>
                </div>
            </section>

            <section class="admin-middle-grid">
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h4>
                            <i class="bi bi-database-check"></i>
                            Kelengkapan Data Akademik
                        </h4>
                    </div>

                    <div class="data-completeness-list">
                        <div class="data-item">
                            <span>User</span>
                            <span class="status-badge complete">Lengkap</span>
                        </div>

                        <div class="data-item">
                            <span>Mahasiswa</span>
                            <span class="status-badge complete">Lengkap</span>
                        </div>

                        <div class="data-item">
                            <span>Mata Kuliah</span>
                            <span class="status-badge complete">Lengkap</span>
                        </div>

                        <div class="data-item">
                            <span>RPS</span>
                            <span class="status-badge danger">Belum Lengkap</span>
                        </div>

                        <div class="data-item">
                            <span>CLO</span>
                            <span class="status-badge warning">Sebagian</span>
                        </div>

                        <div class="data-item">
                            <span>PLO</span>
                            <span class="status-badge complete">Lengkap</span>
                        </div>

                        <div class="data-item full">
                            <span>Mapping CLO-PLO</span>
                            <span class="status-badge danger">Belum Lengkap</span>
                        </div>

                        <div class="data-item full">
                            <span>Nilai Mahasiswa</span>
                            <span class="status-badge danger">Belum Lengkap</span>
                        </div>
                    </div>

                    <div class="admin-progress-summary">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span>Total Kelengkapan Data</span>
                            <strong>72%</strong>
                        </div>
                        <div class="progress admin-progress">
                            <div class="progress-bar" style="width: 72%"></div>
                        </div>
                    </div>
                </div>

                <div class="admin-card">
                    <div class="admin-card-header">
                        <h4>
                            <i class="bi bi-pie-chart-fill"></i>
                            Progress Data Sistem
                        </h4>
                    </div>

                    <div class="progress-circle-wrapper">
                        <div class="progress-circle">
                            <strong>89%</strong>
                            <span>RPS</span>
                        </div>

                        <div class="progress-circle second">
                            <strong>92%</strong>
                            <span>CLO-PLO</span>
                        </div>
                    </div>

                    <div class="progress-label-wrapper">
                        <div>
                            <span>RPS Terunggah</span>
                            <strong>48/54</strong>
                        </div>

                        <div>
                            <span>Mapping CLO-PLO</span>
                            <strong>80/87</strong>
                        </div>
                    </div>
                </div>
            </section>

            <section class="admin-card admin-activity-card">
                <div class="admin-card-header">
                    <h4>
                        <i class="bi bi-clock-history"></i>
                        Aktivitas Terbaru
                    </h4>
                    <a href="#">Lihat Semua</a>
                </div>

                <div class="table-responsive">
                    <table class="table admin-activity-table mb-0">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Aktivitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>10 Juni 2026, 10:23</td>
                                <td>
                                    <span class="activity-dot blue"></span>
                                    User dosen wali ditambahkan
                                </td>
                            </tr>
                            <tr>
                                <td>10 Juni 2026, 09:15</td>
                                <td>
                                    <span class="activity-dot green"></span>
                                    Data mata kuliah diperbarui
                                </td>
                            </tr>
                            <tr>
                                <td>9 Juni 2026, 16:42</td>
                                <td>
                                    <span class="activity-dot purple"></span>
                                    Mapping CLO-PLO diperbarui
                                </td>
                            </tr>
                            <tr>
                                <td>8 Juni 2026, 14:30</td>
                                <td>
                                    <span class="activity-dot orange"></span>
                                    RPS Matematika untuk Sistem Informasi ditambahkan
                                </td>
                            </tr>
                            <tr>
                                <td>8 Juni 2026, 09:10</td>
                                <td>
                                    <span class="activity-dot red"></span>
                                    Nilai mahasiswa diperbarui
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="quick-action-section">
                <div class="quick-action-title">
                    <h4>Quick Action</h4>
                    <div></div>
                </div>

                <div class="quick-action-grid">
                    <a href="#" class="quick-action-card">
                        <div class="quick-icon">
                            <i class="bi bi-person-plus-fill"></i>
                        </div>
                        <h5>Tambah User</h5>
                        <p>Tambah akun admin, kaprodi, atau dosen wali.</p>
                    </a>

                    <a href="#" class="quick-action-card">
                        <div class="quick-icon">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>
                        <h5>Tambah Mata Kuliah</h5>
                        <p>Tambah mata kuliah baru ke sistem.</p>
                    </a>

                    <a href="#" class="quick-action-card">
                        <div class="quick-icon">
                            <i class="bi bi-calendar-week-fill"></i>
                        </div>
                        <h5>Atur Semester</h5>
                        <p>Kelola periode akademik yang aktif.</p>
                    </a>

                    <a href="#" class="quick-action-card">
                        <div class="quick-icon">
                            <i class="bi bi-diagram-3-fill"></i>
                        </div>
                        <h5>Kelola Kurikulum</h5>
                        <p>Atur mapping CLO-PLO dan ekuivalensi MK.</p>
                    </a>
                </div>
            </section>
        </main>

        <footer class="admin-footer">
            <span>COMPASS - Curriculum Outcomes Mapping, Performance and Assessment System</span>
            <span>© 2026 Telkom University Surabaya</span>
        </footer>
    </div>
@endsection
