@extends('layout.app')

@section('title', 'Nilai - COMPASS')

@vite([
    'resources/css/dashboard.css',
    'resources/css/nilai.css'
])
@section('content')

<div class="dashboard-page">

    {{-- SIDEBAR --}}
    @include('components.sidebar_nw')

    {{-- MAIN --}}
    <main class="dashboard-main">

        {{-- HEADER --}}
        <header class="dashboard-header">

            <button class="mobile-menu-btn" onclick="toggleSidebar()">
                ☰
            </button>

            <h1>
                Student Competency Oversight |
                <span>Classroom Section Lens</span>
            </h1>

            <div class="header-actions">
                <div class="notif-dot">3</div>

                <div class="profile-mini"></div>
            </div>

        </header>

        {{-- CONTENT --}}
        <section class="nilai-wrapper">

            {{-- TITLE --}}
            <div class="nilai-title">
                Student Competency Oversight
            </div>

            {{-- FILTER --}}
            <div class="filter-section">

                <div class="filter-item">
                    <label>Kurikulum</label>
                    <select>
                        <option>2024</option>
                    </select>
                </div>

                <div class="filter-item">
                    <label>Angkatan</label>
                    <select>
                        <option>2024</option>
                    </select>
                </div>

                <div class="filter-item">
                    <label>Periode Akademik</label>
                    <select>
                        <option>2024/1</option>
                    </select>
                </div>

                <div class="filter-item">
                    <label>Kode Dosen</label>
                    <select>
                        <option>TRL</option>
                    </select>
                </div>

                <button class="apply-btn">
                    Apply
                </button>

            </div>

            {{-- INFO --}}
            <div class="info-box">
                <strong>INFO !!!</strong><br>

                TEMPAT INFORMASI <br>

                | INFORMASI A |
                INFORMASI B |
                INFORMASI C |
                INFORMASI D |
            </div>

            {{-- TABLE --}}
            <div class="table-card">

                <div class="table-responsive">

                    <table class="nilai-table">

                        <thead>

                            <tr>
                                <th>No</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Kode Dosen</th>

                                @for ($i = 1; $i <= 10; $i++)
                                    <th>PLO0{{ $i }}</th>
                                @endfor
                            </tr>

                        </thead>

                        <tbody>

                            @for ($x = 1; $x <= 10; $x++)

                            <tr>

                                <td>{{ $x }}</td>
                                <td>120423000{{ $x }}</td>
                                <td>Jihan Natasya Najwa</td>
                                <td>TRL</td>

                                @for ($i = 1; $i <= 10; $i++)
                                    <td>{{ rand(50, 100) }}</td>
                                @endfor

                            </tr>

                            @endfor

                        </tbody>

                    </table>

                </div>

            </div>

        </section>

    </main>

</div>

<div id="sidebarOverlay" class="sidebar-overlay"></div>

@endsection
