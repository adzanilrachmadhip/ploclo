@extends('layout.app')

@section('title', 'Mata Kuliah - COMPASS')

@vite(['resources/css/dashboard.css', 'resources/css/mata_kuliah.css'])

@section('content')
    <div class="dashboard-page">
        @include('components.sidebar_nw')

        <main class="dashboard-main">
            <header class="dashboard-header">
                <button class="mobile-menu-btn" onclick="toggleSidebar()">☰</button>

                <h1>Mata Kuliah</h1>

                <div class="header-actions">
                    <input type="text" placeholder="Search">
                    <span class="notif">3</span>
                    <div class="avatar"></div>
                    <span>⌄</span>
                </div>
            </header>

            <section class="mk-wrapper">
                <div class="mk-title">Kelola Mata Kuliah</div>

                <div class="mk-filter">
                    <div class="filter-row">
                        <label>Kurikulum</label>
                        <select>
                            <option>2024</option>
                        </select>
                    </div>

                    <div class="filter-row">
                        <label>Periode Akademik</label>
                        <select>
                            <option>2025/2026 Semester Ganjil</option>
                        </select>
                    </div>

                    <button class="mk-apply-btn">Apply</button>
                </div>

                <div class="mk-info-box">
                    Tempat Info
                </div>

                <div class="mk-table-top">
                    <div>
                        <span class="record-box"></span>
                        <span>Record per pages</span>
                    </div>

                    <div>
                        <label>Search (Press Enter):</label>
                        <input type="text">
                    </div>
                </div>

                <div class="mk-table-wrap">
                    <table class="mk-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Mata Kuliah</th>
                                <th>Nama Mata Kuliah</th>
                                <th>SKS</th>
                                <th>Semester</th>
                                <th>Tahun Akademik</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $matkul = [
                                    ['BBK1AAB4', 'ALGORITMA DAN PEMROGRAMAN', 4, 1, 2526, 'Active'],
                                    ['BBK1BAB3', 'MATEMATIKA DISKRIT', 3, 1, 2526, 'Active'],
                                    ['BBK1CAB3', 'MATEMATIKA UNTUK SISTEM INFORMASI', 3, 1, 2526, 'Active'],
                                    ['BBK1DAB3', 'PENGANTAR SISTEM INFORMASI', 3, 1, 2526, 'Active'],
                                    ['BBK1CAB3', 'MATEMATIKA UNTUK SISTEM INFORMASI', 3, 1, 2526, 'Active'],
                                ];
                            @endphp

                            @foreach ($matkul as $index => $mk)
                                <tr>
                                    <td>{{ $index + 1 }}.</td>
                                    <td>{{ $mk[0] }}</td>
                                    <td>{{ $mk[1] }}</td>
                                    <td>{{ $mk[2] }}</td>
                                    <td>{{ $mk[3] }}</td>
                                    <td>{{ $mk[4] }}</td>
                                    <td>{{ $mk[5] }}</td>
                                    <td>
                                        <div class="action-group">
                                            <button class="btn-edit">Edit</button>
                                            <a href="{{ route('mata-kuliah.manage-plo.ui') }}" class="btn-manage">
                                                Manage PLO
                                            </a>
                                            <button class="btn-detail">Detail</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <div id="sidebarOverlay" class="sidebar-overlay"></div>
@endsection
