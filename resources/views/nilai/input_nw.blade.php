@extends('layout.app_nw')

@section('title', 'Input Nilai - COMPASS')
@section('headerTitle', 'Input Nilai Mahasiswa')

@section('styles')
    @vite(['resources/css/nilai.css', 'resources/css/mata_kuliah.css'])
@endsection

@section('content')
    <main class="nilai-wrapper">
        <div class="nilai-title">Input Nilai Mahasiswa</div>

        @if (session('success'))
            <div
                style="background:#d4edda;color:#155724;padding:10px 16px;border-radius:6px;margin-bottom:16px;border:1px solid #c3e6cb;">
                {{ session('success') }}
            </div>
        @endif

        {{-- Pilih Mata Kuliah --}}
        <form method="GET" action="{{ route('nilai.input') }}" class="filter-section">
            <div class="filter-item">
                <label>Mata Kuliah</label>
                <select name="id_mk" onchange="this.form.submit()">
                    <option value="">-- Pilih MK --</option>
                    @foreach ($matkuls as $mk)
                        <option value="{{ $mk->id_mk }}" {{ $idMk == $mk->id_mk ? 'selected' : '' }}>
                            {{ $mk->kode_mk }} — {{ $mk->nama_matakuliah }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        {{-- Pilih Assessment Tool --}}
        @if ($idMk && $cloAtList->count() > 0)
            <div class="table-card" style="margin-bottom:16px;">
                <p style="font-weight:600;margin-bottom:8px;">Pilih Assessment Tool:</p>
                @foreach ($cloAtList as $clo)
                    <div style="margin-bottom:8px;">
                        <span style="font-size:0.85em;color:#666;font-weight:600;">{{ $clo->nama_clo }}:</span>
                        <div style="display:flex;flex-wrap:wrap;gap:6px;margin-top:4px;">
                            @foreach ($clo->assessmentTools as $at)
                                <a href="{{ route('nilai.input', ['id_at' => $at->id_at, 'id_mk' => $idMk]) }}"
                                    style="padding:4px 12px;border-radius:16px;font-size:0.82em;text-decoration:none;
                                        background:{{ $idAt == $at->id_at ? '#3d5a99' : '#e8f0fe' }};
                                        color:{{ $idAt == $at->id_at ? '#fff' : '#3d5a99' }};
                                        border:1px solid #3d5a99;">
                                    {{ $at->nama_at }} ({{ $at->weight_in_clo }}%)
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif ($idMk)
            <div class="info-box">Belum ada CLO/AT untuk mata kuliah ini.</div>
        @endif

        @if ($selectedAt && $mahasiswas->count() > 0)
            <div class="table-card">
                <h3 style="margin-bottom:4px;">
                    Input Nilai: <strong>{{ $selectedAt->nama_at }}</strong>
                    ({{ $selectedAt->clo?->nama_clo }} — {{ $selectedAt->clo?->mataKuliah?->kode_mk }})
                </h3>
                <p style="font-size:0.85em;color:#666;margin-bottom:16px;">
                    Bobot dalam CLO: {{ $selectedAt->weight_in_clo }}%
                </p>

                <form id="formInputNilai" method="POST" action="{{ route('nilai.store') }}">
                    @csrf
                    <input type="hidden" name="id_at" value="{{ $selectedAt->id_at }}">

                    <div class="table-responsive">
                        <table class="nilai-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIM</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Kode Dosen</th>
                                    <th>Nilai (0–100)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mahasiswas as $i => $mhs)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $mhs->nim }}</td>
                                        <td>{{ $mhs->nama }}</td>
                                        <td>{{ $mhs->kode_dosen ?? '-' }}</td>
                                        <td>
                                            <input type="number" name="scores[{{ $mhs->id_mahasiswa }}]"
                                                value="{{ $existingScores[$mhs->id_mahasiswa] ?? '' }}" min="0"
                                                max="100" step="0.01"
                                                style="width:90px;padding:4px 8px;border:1px solid #ccc;border-radius:4px;text-align:center;"
                                                placeholder="–">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="input-nilai-actions">
                        <button type="submit" class="btn-simpan-nilai">
                            Simpan Nilai
                        </button>
                    </div>
                </form>
            </div>
        @elseif ($selectedAt)
            <div class="info-box">Belum ada data mahasiswa.</div>
        @endif
    </main>


@endsection

@section('scripts')
    <script>
        let nilaiChanged = false;
        let isSubmitting = false;

        const formInputNilai = document.getElementById('formInputNilai');

        if (formInputNilai) {
            const nilaiInputs = formInputNilai.querySelectorAll('input, select, textarea');

            nilaiInputs.forEach(function(input) {
                input.addEventListener('change', function() {
                    nilaiChanged = true;
                });

                input.addEventListener('input', function() {
                    nilaiChanged = true;
                });
            });

            formInputNilai.addEventListener('submit', function() {
                isSubmitting = true;
                nilaiChanged = false;
            });
        }

        window.addEventListener('beforeunload', function(event) {
            if (nilaiChanged && !isSubmitting) {
                event.preventDefault();
                event.returnValue = '';
            }
        });

        document.addEventListener('click', function(event) {
            const target = event.target.closest('a, button');

            if (!target) {
                return;
            }

            if (target.type === 'submit') {
                return;
            }

            if (nilaiChanged && !isSubmitting) {
                const confirmLeave = confirm(
                    'Jika Anda beralih, perubahan tidak akan disimpan. Mau simpan nilai dulu?'
                );

                if (confirmLeave) {
                    event.preventDefault();
                    formInputNilai?.requestSubmit();
                } else {
                    nilaiChanged = false;
                }
            }
        });
    </script>
@endsection
