@extends('layout.app_nw')

@section('title', 'Dashboard - COMPASS')
@section('headerTitle', 'Dashboard Perhitungan PLO')

@section('styles')
    @vite('resources/css/dashboard.css')
@endsection

@section('content')
    <main class="dashboard-inner">
        <div class="dashboard-top">
            <p class="overview-title">Overview</p>
            <p class="period-text">Tahun : 2425/1 Genap ⌄</p>
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
                    <span>75%</span>
                    <span>50%</span>
                    <span>25%</span>
                    <span>0</span>
                </div>
                <div class="bar-area">
                    @foreach ($ploData as $bar)
                        <div class="bar-item">
                            <div class="bar" style="height: {{ $bar['value'] }}%; background: {{ $bar['color'] }};"></div>
                            <span>{{ explode(' ', $bar['label'])[0] . ' ' . explode(' ', $bar['label'])[1] }}</span>
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
                    @foreach ($ploData as $bar)
                        <tr>
                            <td>{{ $bar['label'] }}</td>
                            <td>{{ number_format($bar['value'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
@endsection
