@extends('layout.app')

@section('title', 'Detail Nilai PLO')

@section('content')
<div class="d-flex nilai-page">

    <x-dashboard.sidebar :user="auth()->user()" :nav-items="[]" />

    <div class="flex-grow-1">
        <div class="nilai-header">
            <h1 class="nilai-title">
                Student Competency Oversight | Detail PLO
            </h1>
        </div>

        <div class="nilai-content">
            <div class="nilai-breadcrumb rounded px-4 py-2 mb-4" style="background:#D5C6FF;">
                Student Competency Oversight
            </div>

            <div class="nilai-detail-card">
                <div class="mb-3 fw-semibold">
                    {{ $mahasiswa->nim }} / {{ $mahasiswa->nama }}
                </div>

                <hr>

                <h3 class="fw-bold">{{ $plo->nama_plo }}</h3>
                <p class="mb-4">{{ $plo->description_plo }}</p>

                <div class="mb-4">
                    <a href="{{ route('nilai.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table nilai-table align-middle">
                        <thead>
                            <tr>
                                <th width="120">Kode MK</th>
                                <th width="250">Nama MK</th>
                                <th width="120">Semester</th>
                                <th width="80">SKS</th>
                                <th width="120">Nilai CLO</th>
                                <th>Detail Assessment</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($cloResults as $index => $clo)
                                <tr>
                                    <td class="text-center">{{ $clo['kode_mk'] }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $clo['nama_matakuliah'] }}</div>
                                        <div class="nilai-clo-small">
                                            {{ $clo['nama_clo'] }} - {{ $clo['description_clo'] }}
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $clo['semester'] }}</td>
                                    <td class="text-center">{{ $clo['sks'] }}</td>
                                    <td class="text-center fw-bold">
                                        {{ $clo['final_clo_score'] }}
                                    </td>
                                    <td class="text-center">
                                        <button
                                            class="btn btn-outline-primary btn-sm"
                                            type="button"
                                            onclick="toggleAssessment('assessment-{{ $index }}', this)"
                                        >
                                            Lihat Assessment
                                        </button>
                                    </td>
                                </tr>

                                <tr class="d-none" id="assessment-{{ $index }}">
                                    <td colspan="6">
                                        <div class="p-3 bg-light rounded">
                                            <div class="row g-3">
                                                @foreach($clo['assessments'] as $assessment)
                                                    <div class="col-md-4">
                                                        <div class="assessment-box">
                                                            <div class="fw-bold mb-2">
                                                                {{ $assessment['nama_at'] }}
                                                            </div>

                                                            <div>
                                                                Nilai:
                                                                <strong>{{ $assessment['score'] }}</strong>
                                                            </div>

                                                            <div>
                                                                Bobot:
                                                                <strong>{{ $assessment['weight_in_clo'] }}%</strong>
                                                            </div>

                                                            <div>
                                                                Kontribusi:
                                                                <strong>{{ round($assessment['weighted_score'], 2) }}</strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        Tidak ada data CLO untuk PLO ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

<script>
function toggleAssessment(id, button) {
    const row = document.getElementById(id);

    if (!row) return;

    row.classList.toggle('d-none');

    button.innerText = row.classList.contains('d-none')
        ? 'Lihat Assessment'
        : 'Sembunyikan Assessment';
}
</script>
@endsection
