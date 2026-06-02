@extends('layout.app')

@section('title', 'Student Competency Oversight')

@section('content')
<div class="d-flex nilai-page">
    <x-dashboard.sidebar :user="auth()->user()" :nav-items="[]" />    {{-- @include('partials.sidebar', ['user' => $user, 'navItems' => $navItems]) --}}

    <div class="flex-grow-1">

        <div class="nilai-header">
            <h1 class="nilai-title">
                Student Competency Oversight | Classroom Section Lens
            </h1>
        </div>

        <div class="nilai-content">

            <div class="nilai-breadcrumb rounded px-4 py-2 mb-4" style="background:#D5C6FF;">
                Student Competency Oversight
            </div>

            <div class="nilai-filter-card">
                <form method="GET" action="{{ route('nilai.index') }}">
                    <div class="row g-3 align-items-end">

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Angkatan</label>
                            <input
                                type="text"
                                name="angkatan"
                                class="form-control"
                                value="{{ request('angkatan') }}"
                                placeholder="2024"
                            >
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Kode Dosen</label>
                            <input
                                type="text"
                                name="kode_dosen"
                                class="form-control"
                                value="{{ request('kode_dosen') }}"
                                placeholder="AHQ"
                            >
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Kurikulum</label>
                            <input
                                type="text"
                                class="form-control"
                                value="2024"
                                disabled
                            >
                        </div>

                        <div class="col-md-3">
                            <button type="submit" class="btn btn-dark w-100">
                                Apply
                            </button>
                        </div>

                    </div>
                </form>
            </div>

            <div class="nilai-table-card">

                <div class="table-responsive">
                    <table class="table nilai-table align-middle">

                        <thead>
                            <tr>
                                <th width="55">No</th>
                                <th width="140">NIM</th>
                                <th width="260">Name</th>
                                <th width="100">Kode Dosen</th>

                                @foreach($plos as $plo)
                                    <th width="90">{{ $plo->nama_plo }}</th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($rows as $index => $row)
                                <tr>
                                    <td class="text-center">
                                        {{ $index + 1 }}
                                    </td>

                                    <td class="text-center">
                                        {{ $row['mahasiswa']->nim }}
                                    </td>

                                    <td>
                                        {{ $row['mahasiswa']->nama }}
                                    </td>

                                    <td class="text-center">
                                        {{ $row['mahasiswa']->kode_dosen ?? '-' }}
                                    </td>

                                    @foreach($plos as $plo)
                                        @php
                                            $score = $row['plos'][$plo->id_plo] ?? '-';
                                        @endphp

                                        <td class="text-center">
                                            @if($score !== '-')
                                                <a
                                                    href="{{ route('nilai.show', [$row['mahasiswa']->id_mahasiswa, $plo->id_plo]) }}"
                                                    class="nilai-score-link"
                                                    title="Klik untuk melihat detail CLO dan Assessment Tools"
                                                >
                                                    {{ $score }}
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ 4 + count($plos) }}" class="text-center py-4">
                                        Belum ada data nilai mahasiswa.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
