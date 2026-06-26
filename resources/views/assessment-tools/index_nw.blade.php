@extends('layout.app_nw')

@section('title', 'Assessment Tools - COMPASS')
@section('headerTitle', 'Assessment Tools')

@section('styles')
    @vite('resources/css/mata_kuliah.css')
@endsection

@section('content')
    <section class="mk-wrapper">
        <div class="mk-title">Kelola Assessment Tools</div>

        @if (session('success'))
            <div class="toast-alert toast-success">
                <span class="toast-icon">✓</span>
                <span class="toast-msg">{{ session('success') }}</span>
                <button class="toast-close" onclick="this.parentElement.remove()">×</button>
            </div>
        @endif
        @if (session('error'))
            <div class="toast-alert toast-error">
                <span class="toast-icon">!</span>
                <span class="toast-msg">{{ session('error') }}</span>
                <button class="toast-close" onclick="this.parentElement.remove()">×</button>
            </div>
        @endif
        

        {{-- Filter: pilih MK --}}
        <form method="GET" action="{{ route('assessment-tools.index') }}" class="mk-filter">
            <div class="filter-row">
                <label>Mata Kuliah</label>
                <select name="id_mk" onchange="this.form.submit()">
                    <option value="">-- Pilih Mata Kuliah --</option>
                    @foreach ($matkuls as $mk)
                        <option value="{{ $mk->id_mk }}" {{ $idMk == $mk->id_mk ? 'selected' : '' }}>
                            {{ $mk->kode_mk }} — {{ $mk->nama_matakuliah }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        @if ($selectedMk)
            <div class="mk-info-box">
                <strong>{{ $selectedMk->kode_mk }}</strong> — {{ $selectedMk->nama_matakuliah }}
                | SKS: {{ $selectedMk->sks }} | Semester: {{ $selectedMk->semester }}
            </div>

            @forelse ($cloList as $clo)
                @php $totalBobot = $clo->assessmentTools->sum('weight_in_clo'); @endphp

                <div style="margin:20px 0 8px;display:flex;align-items:center;gap:12px;">
                    <strong>{{ $clo->nama_clo }}</strong>
                    <span style="font-size:0.85em;color:#666;">{{ $clo->description_clo }}</span>
                    <span style="font-size:0.82em;padding:2px 8px;border-radius:10px;
                        background:{{ $totalBobot == 100 ? '#d4edda' : '#fff3cd' }};
                        color:{{ $totalBobot == 100 ? '#155724' : '#856404' }};">
                        Total Bobot: {{ $totalBobot }}%
                        {{ $totalBobot != 100 ? '⚠ (harus 100%)' : '✓' }}
                    </span>
                    <button type="button" class="mk-apply-btn" style="padding:4px 12px;font-size:0.82em;"
                        onclick="openAddAtModal({{ $clo->id_clo }}, '{{ $clo->nama_clo }}')">
                        + Tambah AT
                    </button>
                </div>

                <div class="mk-table-wrap" style="margin-bottom:8px;">
                    <table class="mk-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Assessment Tool</th>
                                <th>Bobot dalam CLO (%)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($clo->assessmentTools as $i => $at)
                                <tr>
                                    <td>{{ $i + 1 }}.</td>
                                    <td>{{ $at->nama_at }}</td>
                                    <td>{{ $at->weight_in_clo }}%</td>
                                    <td>
                                        <div class="action-group">
                                            <button type="button" class="btn-edit"
                                                onclick="openEditAtModal({{ $at->id_at }}, '{{ addslashes($at->nama_at) }}', {{ $at->weight_in_clo }})">
                                                Edit
                                            </button>
                                            <form method="POST" action="{{ route('assessment-tools.destroy', $at->id_at) }}"
                                                style="display:inline;"
                                                onsubmit="return confirm('Hapus AT {{ $at->nama_at }}? Semua nilai terkait juga terhapus.')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn-detail" style="background:#e74c3c;color:#fff;">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" style="text-align:center;color:#888;">Belum ada assessment tool untuk CLO ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @empty
                <div class="mk-info-box">Belum ada CLO untuk mata kuliah ini. Tambahkan CLO terlebih dahulu di menu Manage PLO.</div>
            @endforelse

        @else
            <div class="mk-info-box">Pilih mata kuliah untuk melihat dan mengelola assessment tools.</div>
        @endif

        {{-- MODAL TAMBAH AT --}}
        <div id="addAtModal" class="modal-overlay">
            <div class="edit-mk-modal">
                <div class="modal-header-custom edit-modal-header">
                    <h3>Tambah Assessment Tool</h3>
                    <button type="button" onclick="closeAddAtModal()">×</button>
                </div>
                <form method="POST" action="{{ route('assessment-tools.store') }}">
                    @csrf
                    <input type="hidden" id="addAtCloId" name="id_clo" value="">
                    <div class="edit-modal-body">
                        <div class="edit-field-group">
                            <label>CLO</label>
                            <input type="text" id="addAtCloName" readonly style="background:#f5f5f5;">
                        </div>
                        <div class="edit-field-group">
                            <label>Nama Assessment Tool</label>
                            <input type="text" name="nama_at" required maxlength="100" placeholder="UTS / UAS / TUGAS / QUIZ">
                        </div>
                        <div class="edit-field-group">
                            <label>Bobot dalam CLO (%)</label>
                            <input type="number" name="weight_in_clo" required min="0" max="100" step="0.01" value="100">
                            <small style="color:#888;">Jumlah semua bobot AT dalam 1 CLO harus = 100%</small>
                        </div>
                    </div>
                    <div class="modal-footer-custom modal-footer-edit">
                        <button type="button" class="btn-cancel" onclick="closeAddAtModal()">Cancel</button>
                        <button type="submit" class="btn-save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL EDIT AT --}}
        <div id="editAtModal" class="modal-overlay">
            <div class="edit-mk-modal">
                <div class="modal-header-custom edit-modal-header">
                    <h3>Edit Assessment Tool</h3>
                    <button type="button" onclick="closeEditAtModal()">×</button>
                </div>
                <form id="editAtForm" method="POST" action="">
                    @csrf @method('PUT')
                    <div class="edit-modal-body">
                        <div class="edit-field-group">
                            <label>Nama Assessment Tool</label>
                            <input type="text" id="editAtNama" name="nama_at" required maxlength="100">
                        </div>
                        <div class="edit-field-group">
                            <label>Bobot dalam CLO (%)</label>
                            <input type="number" id="editAtBobot" name="weight_in_clo" required min="0" max="100" step="0.01">
                        </div>
                    </div>
                    <div class="modal-footer-custom modal-footer-edit">
                        <button type="button" class="btn-cancel" onclick="closeEditAtModal()">Cancel</button>
                        <button type="submit" class="btn-save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function openAddAtModal(cloId, cloName) {
            document.getElementById('addAtCloId').value   = cloId;
            document.getElementById('addAtCloName').value = cloName;
            document.getElementById('addAtModal').classList.add('show');
        }
        function closeAddAtModal() { document.getElementById('addAtModal').classList.remove('show'); }

        function openEditAtModal(id, nama, bobot) {
            document.getElementById('editAtForm').action = '/assessment-tools/' + id;
            document.getElementById('editAtNama').value  = nama;
            document.getElementById('editAtBobot').value = bobot;
            document.getElementById('editAtModal').classList.add('show');
        }
        function closeEditAtModal() { document.getElementById('editAtModal').classList.remove('show'); }
    </script>
@endsection
