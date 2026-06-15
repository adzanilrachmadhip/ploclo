@extends('layout.app_nw')

@section('title', 'RPS - COMPASS')
@section('headerTitle', 'RPS')

@section('styles')
    @vite('resources/css/mata_kuliah.css')
@endsection

@section('content')
    <section class="mk-wrapper">
        <div class="mk-title">Rencana Pembelajaran Semester (RPS)</div>

        <form method="GET" action="{{ route('rps.index') }}" class="mk-filter">
            <div class="filter-row">
                <label>Tahun Kurikulum</label>
                <select name="tahun_kurikulum">
                    <option value="">Semua</option>
                    @foreach ($tahunList as $tahun)
                        <option value="{{ $tahun }}" {{ request('tahun_kurikulum') == $tahun ? 'selected' : '' }}>
                            {{ $tahun }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-row">
                <label>Semester</label>
                <select name="semester">
                    <option value="">Semua</option>
                    @foreach ($semesterList as $semester)
                        <option value="{{ $semester }}" {{ request('semester') == $semester ? 'selected' : '' }}>
                            Semester {{ $semester }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="mk-apply-btn">
                Apply
            </button>
        </form>

        <div class="mk-info-box">
            <strong>INFO !!!</strong><br>
            Halaman ini menampilkan daftar dokumen RPS mata kuliah berdasarkan kurikulum dan semester.
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
                        <th>Semester</th>
                        <th>Jenis Mata Kuliah</th>
                        <th>Dokumen RPS</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $rpsData = [
                            ['BBK1AAB4', 'ALGORITMA PEMROGRAMAN', 1, 'Wajib'],
                            ['BBK1BAB3', 'MATEMATIKA DISKRIT', 1, 'Wajib'],
                            ['BBK1EAB3', 'SISTEM ENTERPRISE', 1, 'Wajib'],
                            ['BBK1FAB3', 'DESIGN THINKING', 2, 'Wajib'],
                            ['BBK1GAB3', 'JARINGAN KOMPUTER', 2, 'Wajib'],
                            ['BBK1JAB3', 'SISTEM BASIS DATA', 2, 'Wajib'],
                        ];
                    @endphp
                    @forelse ($rpsList as $index => $mk)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $mk->kode_mk }}</td>
                            <td>{{ $mk->nama_matakuliah }}</td>
                            <td>{{ $mk->semester }}</td>
                            <td>Wajib</td>
                            <td>
                                <button type="button" class="btn-detail">
                                    Lihat RPS
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;">
                                Tidak ada data RPS untuk filter yang dipilih.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mk-pagination">
            <button>First</button>
            <button>Previous</button>
            <button class="active">1</button>
            <button>2</button>
            <button>Next</button>
            <button>Last</button>
        </div>
    </section>
@endsection
