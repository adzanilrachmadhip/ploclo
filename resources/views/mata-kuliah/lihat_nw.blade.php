@extends('layout.app_nw')

@section('title', 'Lihat Mata Kuliah - COMPASS')
@section('headerTitle', 'Mata Kuliah')

@section('styles')
    @vite(['resources/css/dashboard.css', 'resources/css/mata_kuliah.css'])
@endsection

@section('content')
    <section class="mk-wrapper">
        <div class="mk-title">Lihat Mata Kuliah</div>

        <form method="GET" action="{{ route('mata-kuliah.lihat.ui') }}" class="mk-table-top" style="margin-bottom:16px;">
            <div>
                <span>{{ $matkul->count() }} record(s)</span>
            </div>
            <div>
                <label>Search (Press Enter):</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Kode / Nama MK">
            </div>
        </form>

        <div class="mk-table-wrap">
            <table class="mk-table mk-lihat-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Mata Kuliah</th>
                        <th>Nama Mata Kuliah</th>
                        <th>Program Studi</th>
                        <th>Semester</th>
                        <th>Tahun Kurikulum</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($matkul as $i => $mk)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $mk->kode_mk }}</td>
                            <td>{{ $mk->nama_matakuliah }}</td>
                            <td>S1 Sistem Informasi - Kampus Surabaya</td>
                            <td>{{ $mk->semester }}</td>
                            <td>{{ $mk->tahun_kurikulum }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align:center;">Belum ada mata kuliah.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mk-pagination">
            <span style="padding:8px 12px;">Showing {{ $matkul->count() }} entries</span>
        </div>
    </section>
@endsection
