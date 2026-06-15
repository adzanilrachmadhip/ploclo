@extends('layout.app_nw')

@section('title', 'Dashboard Dosen Wali')

@section('headerTitle', 'Dashboard Dosen Wali')

@section('content')
<div class="doswal-dashboard-page">

    <div class="doswal-overview-row">
        <div>
            <h1>Overview</h1>
            <p>Ringkasan monitoring mahasiswa perwalian dan capaian akademik.</p>
        </div>

        <div class="doswal-period-select">
            <span class="period-icon"></span>
            <span>2526/1 (Ganjil)</span>
        </div>
    </div>

    <div class="doswal-stats-grid">
        <div class="doswal-stat-card">
            <div class="doswal-stat-icon purple">👥</div>
            <div>
                <p class="doswal-stat-label">Mahasiswa Perwalian</p>
                <div class="doswal-stat-main">
                    <span>{{ $totalMahasiswaPerwalian }}</span>
                    <small>Mahasiswa</small>
                </div>
                <p class="doswal-stat-tag">Aktif</p>
            </div>
        </div>

        <div class="doswal-stat-card">
            <div class="doswal-stat-icon blue">🏫</div>
            <div>
                <p class="doswal-stat-label">Kelas Perwalian</p>
                <div class="doswal-stat-main">
                    <span>{{ $jumlahKelasPerwalian }}</span>
                    <small>Kelas</small>
                </div>
                <p class="doswal-stat-tag">Aktif</p>
            </div>
        </div>

        <div class="doswal-stat-card">
            <div class="doswal-stat-icon green">📈</div>
            <div>
                <p class="doswal-stat-label">Rata-rata Capaian PLO</p>
                <div class="doswal-stat-main">
                    <span>{{ $rataRataPlo }}%</span>
                </div>
                <p class="doswal-stat-tag green">Capaian baik</p>
            </div>
        </div>
    </div>

    <div class="doswal-main-grid">
        <section class="doswal-card doswal-chart-card">
            <div class="doswal-card-header">
                <h3>Capaian PLO Mahasiswa Perwalian</h3>
                <select>
                    <option>Semester Aktif</option>
                    <option>2526/1 Ganjil</option>
                    <option>2425/2 Genap</option>
                </select>
            </div>

            <div class="doswal-chart-box">
                <div class="y-axis">
                    <span>100</span>
                    <span>80</span>
                    <span>60</span>
                    <span>40</span>
                    <span>20</span>
                    <span>0</span>
                </div>

                <div class="bar-chart">
                    <div class="bar-item">
                        <div class="bar" style="height: 84%;"></div>
                        <span>PLO1</span>
                    </div>
                    <div class="bar-item">
                        <div class="bar" style="height: 76%;"></div>
                        <span>PLO2</span>
                    </div>
                    <div class="bar-item">
                        <div class="bar" style="height: 88%;"></div>
                        <span>PLO3</span>
                    </div>
                    <div class="bar-item">
                        <div class="bar" style="height: 70%;"></div>
                        <span>PLO4</span>
                    </div>
                    <div class="bar-item">
                        <div class="bar" style="height: 82%;"></div>
                        <span>PLO5</span>
                    </div>
                    <div class="bar-item">
                        <div class="bar" style="height: 91%;"></div>
                        <span>PLO6</span>
                    </div>
                    <div class="bar-item">
                        <div class="bar" style="height: 79%;"></div>
                        <span>PLO7</span>
                    </div>
                    <div class="bar-item">
                        <div class="bar" style="height: 86%;"></div>
                        <span>PLO8</span>
                    </div>
                </div>
            </div>

            <div class="doswal-chart-note">
                Grafik menampilkan rata-rata capaian PLO mahasiswa perwalian pada semester aktif.
            </div>
        </section>

        <section class="doswal-card doswal-activity-card">
            <h3>Aktivitas Terbaru</h3>

            <div class="doswal-activity-list">
                @foreach ($activities as $activity)
                    <div class="doswal-activity-item">
                        <div class="activity-icon {{ $activity['type'] }}">●</div>
                        <div class="activity-content">
                            <div class="activity-title-row">
                                <strong>{{ $activity['title'] }}</strong>
                                <span>{{ $activity['time'] }}</span>
                            </div>
                            <p>{{ $activity['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <a href="#" class="doswal-see-all">Lihat semua aktivitas →</a>
        </section>
    </div>

    <div class="doswal-bottom-grid">
        <section class="doswal-card doswal-student-card">
            <div class="doswal-table-header">
                <h3>Daftar Mahasiswa Perwalian</h3>
            </div>

            <div class="doswal-table-wrapper">
                <table class="doswal-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Kelas</th>
                            <th>Nilai PLO</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ $student['no'] }}</td>
                                <td>{{ $student['nim'] }}</td>
                                <td><strong>{{ $student['nama'] }}</strong></td>
                                <td>{{ $student['kelas'] }}</td>
                                <td><strong>{{ $student['nilai_plo'] }}</strong></td>
                                <td>
                                    @if ($student['status'] === 'Aman')
                                        <span class="doswal-status success">Aman</span>
                                    @else
                                        <span class="doswal-status warning">Perlu<br>Perhatian</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="doswal-table-footer">
                <span>Menampilkan 5 dari {{ $totalMahasiswaPerwalian }} mahasiswa perwalian</span>
                <a href="{{ route('mahasiswa.index') }}">Lihat semua mahasiswa →</a>
            </div>
        </section>

        <section class="doswal-quick-actions">
            <h3>Quick Action</h3>

            <a href="{{ route('nilai.input') }}" class="doswal-action-card purple">
                <div class="action-icon">✎</div>
                <div>
                    <strong>Input Nilai Mahasiswa</strong>
                    <p>Input nilai assessment mahasiswa</p>
                </div>
                <span>›</span>
            </a>

            <a href="{{ route('nilai.index') }}" class="doswal-action-card blue">
                <div class="action-icon">📊</div>
                <div>
                    <strong>Lihat Nilai PLO Mahasiswa</strong>
                    <p>Lihat capaian PLO per mahasiswa</p>
                </div>
                <span>›</span>
            </a>

            <a href="{{ route('nilai.index') }}" class="doswal-action-card green">
                <div class="action-icon">✓</div>
                <div>
                    <strong>Lihat Nilai CLO Mahasiswa</strong>
                    <p>Lihat capaian CLO per mahasiswa</p>
                </div>
                <span>›</span>
            </a>
        </section>
    </div>
</div>
@endsection
