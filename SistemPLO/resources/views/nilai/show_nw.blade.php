@extends('layout.app_nw')

@section('title', 'Detail Nilai PLO - COMPASS')

@vite(['resources/css/dashboard.css', 'resources/css/nilai_detail.css'])

@section('content')
    <div class="dashboard-page">
        @include('components.sidebar_nw')

        <main class="dashboard-main">
            <header class="dashboard-header">
                <button class="mobile-menu-btn" onclick="toggleSidebar()">☰</button>

                <h1>Student Competency Oversight | Classroom Section Lens</h1>

                <div class="header-actions">
                    <span class="notif">3</span>
                    <div class="avatar"></div>
                    <span>⌄</span>
                </div>
            </header>

            <section class="detail-nilai-wrapper">
                <div class="nilai-title">Student Competency Oversight</div>

                <div class="detail-card">
                    <div class="student-row">
                        120230114 / DIANA IFFATUL INSYIRAH
                    </div>

                    <div class="plo-info">
                        <h2>PLO-1</h2>
                        <p>
                            [PLO01] Mampu menganalisis permasalahan infokom yang komplek,
                            mendefinisikan, dan memodelkan kebutuhan dalam konteks enterprise
                            atau masyarakat dengan menerapkan ilmu dan pengetahuan dalam bidang
                            komputasi, teknologi informasi dan komunikasi, dan disiplin lain yang relevan
                        </p>
                    </div>

                    <h3>Detail Nilai PLO</h3>

                    <div class="record-row">
                        <span class="record-box"></span>
                        <span>Record per pages</span>
                    </div>

                    <div class="detail-table-wrap">
                        <table class="detail-table">
                            <thead>
                                <tr>
                                    <th>Kode MK</th>
                                    <th>Nama MK</th>
                                    <th>Semester</th>
                                    <th>SKS</th>
                                    <th>Nilai PLO</th>
                                    <th>Detail Nilai PLO</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr class="mk-row" onclick="toggleClo('mk1')">
                                    <td>1</td>
                                    <td>Algoritma Pemrograman</td>
                                    <td>2324/1</td>
                                    <td>4</td>
                                    <td>244</td>
                                    <td>313113</td>
                                </tr>

                                <tr id="mk1" class="clo-row">
                                    <td colspan="6" class="clo-cell">

                                        <div class="clo-block">
                                            <div class="clo-line" onclick="toggleTools(event, 'clo4')">
                                                <strong>CLO 4</strong> <span>: 56</span>
                                            </div>

                                            <div id="clo4" class="assessment-tools show">
                                                <div>Kuis <span>: 90</span></div>
                                                <div>Tugas <span>: 90</span></div>
                                                <div>Tubes <span>: 90</span></div>
                                                <div>Praktikum <span>: 90</span></div>
                                            </div>
                                        </div>

                                        <div class="clo-block">
                                            <div class="clo-line" onclick="toggleTools(event, 'clo8')">
                                                <strong>CLO 8</strong> <span>: 47</span>
                                            </div>

                                            <div id="clo8" class="assessment-tools show">
                                                <div>UTS <span>: 90</span></div>
                                                <div>UAS <span>: 90</span></div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>

                                @php
                                    $mk = [
                                        ['2', 'Matematika Diskrit', '2324/1', '3', '244', '313113'],
                                        ['3', 'Matematika untuk Sistem Informasi', '2324/1', '3', '244', '313113'],
                                        ['4', 'Pengantar Sistem Informasi', '2324/1', '2', '244', '313113'],
                                        ['5', 'Design Thinking', '2324/1', '3', '244', '313113'],
                                        ['6', 'Sistem Enterprise', '2324/1', '3', '244', '313113'],
                                    ];
                                @endphp

                                @foreach ($mk as $item)
                                    <tr>
                                        <td>{{ $item[0] }}</td>
                                        <td>{{ $item[1] }}</td>
                                        <td>{{ $item[2] }}</td>
                                        <td>{{ $item[3] }}</td>
                                        <td>{{ $item[4] }}</td>
                                        <td>{{ $item[5] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <div id="sidebarOverlay" class="sidebar-overlay"></div>

    <script>
        function toggleClo(id) {
            document.getElementById(id).classList.toggle('show');
        }

        function toggleTools(event, id) {
            event.stopPropagation();
            document.getElementById(id).classList.toggle('show');
        }
    </script>
@endsection
