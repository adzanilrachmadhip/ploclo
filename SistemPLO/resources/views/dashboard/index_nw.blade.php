@extends('layout.app')

@section('title', 'Dashboard - COMPASS')

@vite('resources/css/dashboard.css')

@section('content')
    <div class="dashboard-page">
        <aside class="dashboard-sidebar">
            <h2 class="sidebar-logo">COMPASS</h2>

            <div class="sidebar-profile">
                <div class="profile-circle"></div>
                <p class="profile-name">Dr. Berlian Rahmy Lidiawaty</p>
                <p class="profile-id">1234567891011</p>
            </div>

            @php
                $homeIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" fill="none">
        <path d="M10.1377 0C10.6066 1.68174e-05 11.0504 0.145636 11.3867 0.40918L19.6221 6.86621C19.9942 7.15804 20.2754 7.73664 20.2754 8.21191V9.08789C20.2754 9.6495 19.822 10.1064 19.2646 10.1064H17.8525C17.6908 10.1064 17.5586 10.2395 17.5586 10.4023V16.4482C17.5584 17.855 16.4231 18.9997 15.0273 19H12.2783V14.376C12.2783 12.9999 11.6627 11.8809 10.1377 11.8809C8.61266 11.8809 7.99707 12.9999 7.99707 14.376V19H5.24805C3.85238 19 2.71702 17.8551 2.7168 16.4482V10.4023C2.71677 10.2395 2.58459 10.1064 2.42285 10.1064H1.01074C0.453399 10.1064 0 9.64974 0 9.08789V8.21191C3.11853e-05 7.73661 0.281178 7.15802 0.65332 6.86621L8.88867 0.40918C9.2252 0.145671 9.66836 0 10.1377 0Z" fill="white"/>
    </svg>';
            @endphp
            <p class="menu-title">MENU</p>
            <nav class="sidebar-menu">
                <a href="{{ route('dashboard.ui') }}" class="menu-link active">
                    {!! $homeIcon !!}
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('nilai.index') }}" class="menu-link">
                    {!! $homeIcon !!}
                    <span>Nilai</span>
                </a>

                <a href="#" class="menu-link">
                    {!! $homeIcon !!}
                    <span>Mata Kuliah</span>
                </a>

                <a href="#" class="menu-link">
                    {!! $homeIcon !!}
                    <span>RPS</span>
                </a>
            </nav>

            <div class="logout-area">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">⏻ Log Out</button>
                </form>
            </div>
        </aside>
        <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

        <main class="dashboard-main">
            <header class="dashboard-header">
                <button class="mobile-menu-btn" type="button" onclick="toggleSidebar()">
                    <span>☰</span>
                </button>
                <h1>Dashboard Perhitungan PLO</h1>

                <div class="header-actions">
                    <input type="text" placeholder="Search">
                    <span class="notif">3</span>
                    <div class="avatar"></div>
                    <span>⌄</span>
                </div>
            </header>

            <section class="dashboard-content">
                <div class="dashboard-top">
                    <p class="overview-title">Overview</p>
                    <p class="period-text">Tahun : 2425/1 Genap⌄</p>
                </div>

                <div class="stat-grid">
                    <div class="stat-card">
                        <p>Total Mahasiswa</p>
                        <h2>150</h2>
                    </div>

                    <div class="stat-card">
                        <p>Rata-Rata Ketercapaian PLO%</p>
                        <h2>53,6%</h2>
                    </div>
                </div>

                <div class="chart-card">
                    <h3>Ketercapaian PLO Angkatan 2024</h3>

                    <div class="chart-area">
                        <div class="y-axis">
                            <span>30%</span>
                            <span>20%</span>
                            <span>10%</span>
                            <span>0</span>
                        </div>

                        <div class="bar-area">
                            @php
                                $ploBars = [
                                    ['label' => 'PLO 1', 'value' => 38, 'color' => '#A9C7F5'],
                                    ['label' => 'PLO 2', 'value' => 70, 'color' => '#5FE4D7'],
                                    ['label' => 'PLO 3', 'value' => 48, 'color' => '#000000'],
                                    ['label' => 'PLO 4', 'value' => 78, 'color' => '#69B5FF'],
                                    ['label' => 'PLO 5', 'value' => 82, 'color' => '#000000'],
                                    ['label' => 'PLO 6', 'value' => 82, 'color' => '#000000'],
                                    ['label' => 'PLO 7', 'value' => 82, 'color' => '#000000'],
                                    ['label' => 'PLO 8', 'value' => 82, 'color' => '#000000'],
                                    ['label' => 'PLO 9', 'value' => 82, 'color' => '#000000'],
                                    ['label' => 'PLO 10', 'value' => 82, 'color' => '#000000'],
                                ];
                            @endphp

                            @foreach ($ploBars as $bar)
                                <div class="bar-item">
                                    <div class="bar"
                                        style="height: {{ $bar['value'] }}%; background: {{ $bar['color'] }}"></div>
                                    <span>{{ $bar['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="plo-table-card">
                    <h3>Hasil Perolehan Nilai Program Outcomes Learning (PLO)</h3>

                    <table>
                        <thead>
                            <tr>
                                <th>PLO</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>PLO 1 [PLO01]</td>
                                <td>67.02</td>
                            </tr>
                            <tr>
                                <td>PLO 2 [PLO02]</td>
                                <td>58.12</td>
                            </tr>
                            <tr>
                                <td>PLO 3 [PLO03]</td>
                                <td>53.27</td>
                            </tr>
                            <tr>
                                <td>PLO 4 [PLO04]</td>
                                <td>65.82</td>
                            </tr>
                            <tr>
                                <td>PLO 5 [PLO05]</td>
                                <td>72.15</td>
                            </tr>
                            <tr>
                                <td>PLO 6 [PLO06]</td>
                                <td>87.40</td>
                            </tr>
                            <tr>
                                <td>PLO 7 [PLO07]</td>
                                <td>90.12</td>
                            </tr>
                            <tr>
                                <td>PLO 8 [PLO08]</td>
                                <td>84.27</td>
                            </tr>
                            <tr>
                                <td>PLO 9 [PLO09]</td>
                                <td>92.82</td>
                            </tr>
                            <tr>
                                <td>PLO 10 [PLO10]</td>
                                <td>88.15</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
    <script>
        function toggleSidebar() {
            document.querySelector('.dashboard-sidebar').classList.toggle('show');
            document.querySelector('.sidebar-overlay').classList.toggle('show');
        }
    </script>
@endsection
