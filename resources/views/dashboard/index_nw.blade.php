@extends('layout.app_nw')

@section('title', 'Dashboard - COMPASS')
@section('headerTitle', 'Dashboard Perhitungan PLO')

@section('styles')
    @vite('resources/css/dashboard.css')
@endsection

@section('content')
    <main class="dashboard-inner">
        <div class="dashboard-top" style="display:flex; justify-content:space-between; align-items:flex-start; gap:16px;">
            <div style="flex:1;">
                <p class="overview-title">Overview</p>
            </div>

            <div style="min-width:260px; display:flex; flex-direction:column; align-items:flex-end;">
                <form method="get" class="filter-form" style="display:flex; flex-direction:column; gap:8px; align-items:flex-end; margin:0; width:100%;">
                    <div style="width:100%; display:flex; justify-content:space-between; align-items:center;">
                        <span style="opacity:0.9;">Angkatan:</span>
                        <select name="angkatan" style="width:140px;">
                            <option value="">Semua</option>
                            @foreach($availableAngkatan as $ang)
                                <option value="{{ $ang }}" {{ (string)$ang === (string)$angkatan ? 'selected' : '' }}>{{ $ang }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="width:100%; display:flex; justify-content:space-between; align-items:center;">
                        <span style="opacity:0.9;">Periode:</span>
                        <select name="periode" style="width:140px;">
                            <option value="">Semua</option>
                            @foreach($availablePeriode as $prd)
                                <option value="{{ $prd }}" {{ (string)$prd === (string)$selectedPeriode ? 'selected' : '' }}>{{ $prd }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="display:flex; gap:8px; justify-content:flex-end; width:100%;">
                        <button type="submit" class="btn">Terapkan</button>
                        <a href="{{ route('kaprodi.dashboard') }}" class="btn">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        @php
            $avgPlo = count($ploData) > 0
                ? number_format(array_sum(array_column($ploData, 'value')) / count($ploData), 2)
                : '0.00';
        @endphp
        <div class="stat-grid">
            <div class="stat-card">
                <p>Total Mahasiswa</p>
                <h2>{{ $totalMahasiswa }}</h2>
            </div>
            <div class="stat-card">
                <p>Rata-Rata Ketercapaian PLO%</p>
                <h2>{{ $avgPlo }}%</h2>
            </div>
        </div>

        <div class="chart-card">
            @php
                $titleAngkatan = null;
                if (isset($angkatan) && $angkatan) {
                    $titleAngkatan = (strlen((string)$angkatan) === 2) ? '20' . $angkatan : $angkatan;
                } else {
                    $titleAngkatan = '2024';
                }
            @endphp
            <h3>Ketercapaian PLO Angkatan {{ $titleAngkatan }}</h3>
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
