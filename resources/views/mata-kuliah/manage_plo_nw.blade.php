@extends('layout.app_nw')

@section('title', 'Manage PLO Mata Kuliah - COMPASS')
@section('headerTitle', 'Mata Kuliah')

@section('styles')
    @vite('resources/css/mata_kuliah.css')
@endsection

@section('content')
    <section class="mk-wrapper">
        <div class="mk-title">Manage CLO & Mapping PLO</div>

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
        <form method="GET" action="{{ route('mata-kuliah.manage-plo.ui') }}" class="mk-filter">
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

            {{-- Tabel CLO + Mapping PLO --}}
            <div class="mk-table-wrap">
                <table class="mk-table">
                    <thead>
                        <tr>
                            <th>CLO</th>
                            <th>Deskripsi</th>
                            <th>Mapping PLO</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cloList as $clo)
                            <tr>
                                <td><strong>{{ $clo->nama_clo }}</strong></td>
                                <td style="max-width:280px;white-space:normal;">{{ $clo->description_clo }}</td>
                                <td>
                                    @foreach ($clo->plos as $plo)
                                        <span style="display:inline-block;margin:2px 4px 2px 0;padding:2px 8px;background:#e8f0fe;border-radius:12px;font-size:0.82em;">
                                            {{ $plo->nama_plo }}
                                            <form method="POST" action="{{ route('plo-mapping.detach', $plo->pivot->id_pivot) }}"
                                                style="display:inline;"
                                                onsubmit="return confirm('Hapus mapping {{ $clo->nama_clo }} → {{ $plo->nama_plo }}?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" style="background:none;border:none;color:#e74c3c;cursor:pointer;font-weight:bold;padding:0 2px;">×</button>
                                            </form>
                                        </span>
                                    @endforeach
                                    <button type="button"
                                        style="font-size:0.78em;padding:2px 8px;background:#28a745;color:#fff;border:none;border-radius:12px;cursor:pointer;"
                                        onclick="openAddMappingModal({{ $clo->id_clo }}, '{{ $clo->nama_clo }}')">
                                        + PLO
                                    </button>
                                </td>
                                <td>
                                    <div class="action-group">
                                        <button type="button" class="btn-edit"
                                            onclick="openEditCloModal({{ $clo->id_clo }}, '{{ $clo->nama_clo }}', '{{ addslashes($clo->description_clo) }}')">
                                            Edit
                                        </button>
                                        <form method="POST" action="{{ route('clo.destroy', $clo->id_clo) }}"
                                            style="display:inline;"
                                            onsubmit="return confirm('Hapus CLO {{ $clo->nama_clo }}? Semua mapping & nilai terkait juga terhapus.')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-detail" style="background:#e74c3c;color:#fff;">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" style="text-align:center;">Belum ada CLO untuk mata kuliah ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Tambah CLO --}}
            <div style="margin-top:12px;">
                <button type="button" class="mk-apply-btn" onclick="openAddCloModal()"> Tambah CLO</button>
            </div>
        @else
            <div class="mk-info-box">Pilih mata kuliah untuk melihat dan mengelola CLO & mapping PLO.</div>
        @endif

        {{-- MODAL TAMBAH CLO --}}
        <div id="addCloModal" class="modal-overlay">
            <div class="edit-mk-modal">
                <div class="modal-header-custom edit-modal-header">
                    <h3>Tambah CLO</h3>
                    <button type="button" onclick="closeAddCloModal()">×</button>
                </div>
                <form method="POST" action="{{ route('clo.store') }}">
                    @csrf
                    <input type="hidden" name="id_mk" value="{{ $idMk }}">
                    <div class="edit-modal-body">
                        <div class="edit-field-group">
                            <label>Nama CLO (maks 20 karakter)</label>
                            <input type="text" name="nama_clo" required maxlength="20" placeholder="CLO1">
                        </div>
                        <div class="edit-field-group">
                            <label>Deskripsi CLO</label>
                            <textarea name="description_clo" required maxlength="1000" rows="3"
                                style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;resize:vertical;"
                                placeholder="Mahasiswa mampu..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer-custom modal-footer-edit">
                        <button type="button" class="btn-cancel" onclick="closeAddCloModal()">Cancel</button>
                        <button type="submit" class="btn-save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL EDIT CLO --}}
        <div id="editCloModal" class="modal-overlay">
            <div class="edit-mk-modal">
                <div class="modal-header-custom edit-modal-header">
                    <h3>Edit CLO</h3>
                    <button type="button" onclick="closeEditCloModal()">×</button>
                </div>
                <form id="editCloForm" method="POST" action="">
                    @csrf @method('PUT')
                    <div class="edit-modal-body">
                        <div class="edit-field-group">
                            <label>Nama CLO</label>
                            <input type="text" id="editNamaClo" name="nama_clo" required maxlength="20">
                        </div>
                        <div class="edit-field-group">
                            <label>Deskripsi CLO</label>
                            <textarea id="editDescClo" name="description_clo" required maxlength="1000" rows="3"
                                style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;resize:vertical;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer-custom modal-footer-edit">
                        <button type="button" class="btn-cancel" onclick="closeEditCloModal()">Cancel</button>
                        <button type="submit" class="btn-save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL TAMBAH MAPPING CLO → PLO --}}
        <div id="addMappingModal" class="modal-overlay">
            <div class="edit-mk-modal">
                <div class="modal-header-custom edit-modal-header">
                    <h3>Tambah Mapping CLO → PLO</h3>
                    <button type="button" onclick="closeAddMappingModal()">×</button>
                </div>
                <form method="POST" action="{{ route('plo-mapping.attach') }}">
                    @csrf
                    <input type="hidden" id="mappingCloId" name="id_clo" value="">
                    <div class="edit-modal-body">
                        <div class="edit-field-group">
                            <label>CLO</label>
                            <input type="text" id="mappingCloName" readonly style="background:#f5f5f5;">
                        </div>
                        <div class="edit-field-group">
                            <label>PLO</label>
                            <select name="id_plo" required>
                                <option value="">-- Pilih PLO --</option>
                                @foreach ($plosAll as $plo)
                                    <option value="{{ $plo->id_plo }}">{{ $plo->nama_plo }}</option>
                                @endforeach
                            </select>
                        </div>
                         <div class="edit-field-group">
                            <div style="background:#fffbe6;border-radius:6px;padding:10px;font-size:12px;color:#555;">
                                Bobot penilaian tidak diatur pada mapping CLO-PLO.
                                Bobot 100% mata kuliah dihitung dari Assessment Tools.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer-custom modal-footer-edit">
                        <button type="button" class="btn-cancel" onclick="closeAddMappingModal()">Cancel</button>
                        <button type="submit" class="btn-save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function openAddCloModal()  { document.getElementById('addCloModal').classList.add('show'); }
        function closeAddCloModal() { document.getElementById('addCloModal').classList.remove('show'); }

        function openEditCloModal(id, nama, desc) {
            document.getElementById('editCloForm').action = '/clo/' + id;
            document.getElementById('editNamaClo').value  = nama;
            document.getElementById('editDescClo').value  = desc;
            document.getElementById('editCloModal').classList.add('show');
        }
        function closeEditCloModal() { document.getElementById('editCloModal').classList.remove('show'); }

        function openAddMappingModal(cloId, cloName) {
            document.getElementById('mappingCloId').value   = cloId;
            document.getElementById('mappingCloName').value = cloName;
            document.getElementById('addMappingModal').classList.add('show');
        }
        function closeAddMappingModal() { document.getElementById('addMappingModal').classList.remove('show'); }
    </script>
@endsection
