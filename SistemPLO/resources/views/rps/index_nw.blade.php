@extends('layout.app_nw')

@section('title', 'RPS - COMPASS')

@vite(['resources/css/dashboard.css', 'resources/css/rps.css'])

@section('content')
    <div class="dashboard-page">
        @include('components.sidebar_nw')

        <main class="dashboard-main">
            <header class="dashboard-header">
                <button class="mobile-menu-btn" onclick="toggleSidebar()">☰</button>

                <h1>Rencana Pengajaran Semester</h1>

                <div class="header-actions">
                    <input type="text" placeholder="Search">
                    <span class="notif">3</span>
                    <div class="avatar"></div>
                    <span>⌄</span>
                </div>
            </header>

            <section class="rps-wrapper">
                <div class="rps-title">Daftar Rancangan Pengajaran Semester</div>

                <div class="rps-filter">
                    <div class="filter-row">
                        <label>Tahun Kurikulum</label>
                        <select>
                            <option>2024</option>
                        </select>
                    </div>

                    <div class="filter-row">
                        <label>Tahun Akademik</label>
                        <select>
                            <option>2025/2026 Semester Ganjil</option>
                        </select>
                    </div>

                    <button class="rps-apply-btn">Apply</button>
                </div>

                <div class="rps-info-box">Info</div>

                <div class="rps-chart-section">
                    <div class="rps-chart-card">
                        <div class="chart-title">RPS <span>☰</span></div>

                        <div class="bar-chart">
                            @php
                                $bars = [
                                    'PENGUJIAN',
                                    'ksmks',
                                    'ksmks',
                                    'ksmks',
                                    'ksmks',
                                    'ksmks',
                                    'KECERDASAN ARTIFISIAL',
                                ];
                            @endphp

                            @foreach ($bars as $bar)
                                <div class="bar-item">
                                    <div class="bar-bg">
                                        <div class="bar-fill"></div>
                                    </div>
                                    <span>{{ $bar }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="chart-legend">
                            <span></span> TOTAL WEEK RPS
                        </div>
                    </div>

                    <div class="rps-chart-card">
                        <div class="chart-title">RPS <span>☰</span></div>

                        <div class="pie-chart"></div>

                        <div class="pie-legend">
                            <p><span class="c1"></span> TOTAL RPS DISAPPROVE</p>
                            <p><span class="c2"></span> TOTAL RPS APPROVE</p>
                            <p><span class="c3"></span> TOTAL RPS SUBMITTED</p>
                            <p><span class="c4"></span> TOTAL RPS NO ACTION</p>
                        </div>
                    </div>
                </div>

                <div class="rps-table-top">
                    <div>
                        <span class="record-box"></span>
                        <span>Record per pages</span>
                    </div>

                    <div>
                        <label>Search (Press Enter):</label>
                        <input type="text">
                    </div>
                </div>

                <div class="rps-table-wrap">
                    <table class="rps-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kode Subjek</th>
                                <th>Nama Mata Kuliah</th>
                                <th>Semester</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $rps = [
                                    ['BBK1GAB3', 'JARINGAN KOMPUTER', 1],
                                    ['BBK3AAB3', 'ARSITEKTUR ENTERPRISE', 5],
                                    ['UBKXBCB2', 'PANCASILA', 1],
                                    ['BBK1FAB3', 'DESIGN THINKING', 3],
                                    ['UBKXCCB2', 'BAHASA INDONESIA', 1],
                                    ['BBK3HAB3', 'KECERDASAN ARTIFISIAL DAN PENERAPANNYA', 6],
                                    ['BBK3VBB3', 'PEMERINTAHAN ELEKTRONIK DAN KOTA CERDAS', '-'],
                                ];
                            @endphp

                            @foreach ($rps as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}.</td>
                                    <td>{{ $item[0] }}</td>
                                    <td>{{ $item[1] }}</td>
                                    <td>{{ $item[2] }}</td>
                                    <td>
                                        <button class="btn-view-rps">View RPS</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="rps-pagination">
                    <button>First</button>
                    <button>Previous</button>
                    <button class="active">1</button>
                    <button>2</button>
                    <button>3</button>
                    <button>4</button>
                    <button>Next</button>
                    <button>Last</button>
                </div>
            </section>
        </main>
    </div>

    <div id="sidebarOverlay" class="sidebar-overlay"></div>
@endsection
