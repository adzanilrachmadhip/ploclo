@extends('layout.app_nw')

@section('title', 'Nilai - COMPASS')
@section('headerTitle', 'Student Competency Oversight | Classroom Section Lens')

@section('styles')
    @vite('resources/css/nilai.css')
@endsection

@section('content')
    <main class="nilai-wrapper">
        <div class="nilai-title">Student Competency Oversight</div>

        {{-- Filter — hanya tampil untuk admin/kaprodi --}}
        @if (auth()->user()->isAdmin() || auth()->user()->isKaprodi())
        <form method="GET" action="{{ route('nilai.index') }}" class="filter-section">
            <div class="filter-item">
                <label>Angkatan</label>
                <select name="angkatan">
                    <option value="">Semua</option>
                    @foreach ($angkatanList as $thn)
                        <option value="{{ $thn }}" {{ request('angkatan') == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-item">
                <label>Dosen Wali</label>
                <select name="kode_dosen">
                    <option value="">Semua</option>
                    @foreach ($dosenList as $d)
                        <option value="{{ $d->kode_dosen }}" {{ request('kode_dosen') == $d->kode_dosen ? 'selected' : '' }}>
                            {{ $d->kode_dosen }} — {{ $d->nama_lengkap }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-item">
                <label>Status</label>
                <select name="status">
                    <option value="">Semua</option>
                    @foreach (['Aktif','Cuti','Lulus','DO'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="apply-btn">Apply</button>
        </form>
        @else
        {{-- Dosen wali: tampilkan info saja --}}
        <div class="info-box" style="margin-bottom:16px;">
            Menampilkan mahasiswa bimbingan: <strong>{{ auth()->user()->kode_dosen }} — {{ auth()->user()->nama_lengkap }}</strong>
        </div>
        @endif

        <div class="table-card">
            <div class="table-responsive">
                <table class="nilai-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Kode Dosen</th>
                            @foreach ($plos as $plo)
                                <th>{{ $plo->nama_plo }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rows as $index => $row)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $row['mahasiswa']->nim }}</td>
                                <td>{{ $row['mahasiswa']->nama }}</td>
                                <td>{{ $row['mahasiswa']->kode_dosen ?? '-' }}</td>
                                @foreach ($plos as $plo)
                                    @php $nilaiPlo = $row['plos'][$plo->id_plo] ?? '-'; @endphp
                                    <td>
                                        @if ($nilaiPlo !== '-')
                                            <a href="{{ route('nilai.show', ['idMahasiswa' => $row['mahasiswa']->id_mahasiswa, 'idPlo' => $plo->id_plo]) }}"
                                               class="nilai-plo-link">
                                                {{ number_format($nilaiPlo, 2) }}
                                            </a>
                                        @else
                                            <span>-</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 4 + $plos->count() }}" class="text-center">
                                    Data nilai belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection
