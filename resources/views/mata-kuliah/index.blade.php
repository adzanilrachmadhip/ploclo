@extends('layout.app_nw')

@section('title', 'Mata Kuliah - COMPASS')
@section('headerTitle', 'Mata Kuliah')

@section('styles')
    @vite('resources/css/mata_kuliah.css')
@endsection

@section('content')
    <section class="mk-wrapper">
        <div class="mk-title">Kelola Mata Kuliah</div>

        {{-- Flash messages --}}
        @if (session('success'))
            <div class="mk-alert-success" style="display:block;">{{ session('success') }}</div>
        @endif

        {{-- Filter --}}
        <form method="GET" action="{{ route('mata-kuliah.index') }}" class="mk-filter">
            <div class="filter-row">
                <label>Kurikulum</label>
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
                <label>Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Kode / Nama MK">
            </div>
            <button type="submit" class="mk-apply-btn">Apply</button>
        </form>

        {{-- Add button --}}
        <div style="margin-bottom:12px;">
            <button type="button" class="mk-apply-btn" onclick="openAddMkModal()">+ Tambah Mata Kuliah</button>
        </div>

        <div class="mk-table-top">
            <span>{{ $matkul->count() }} record(s)</span>
        </div>

        <div class="mk-table-wrap">
            <table class="mk-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode MK</th>
                        <th>Nama Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Semester</th>
                        <th>Tahun Kurikulum</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($matkul as $index => $mk)
                        <tr>
                            <td>{{ $index + 1 }}.</td>
                            <td>{{ $mk->kode_mk }}</td>
                            <td>{{ $mk->nama_matakuliah }}</td>
                            <td>{{ $mk->sks }}</td>
                            <td>{{ $mk->semester }}</td>
                            <td>{{ $mk->tahun_kurikulum }}</td>
                            <td>
                                <div class="action-group">
                                    <button type="button" class="btn-edit"
                                        onclick="openEditMkModal({{ $mk->id_mk }}, '{{ $mk->kode_mk }}', '{{ addslashes($mk->nama_matakuliah) }}', {{ $mk->sks }}, {{ $mk->semester }}, {{ $mk->tahun_kurikulum }})">
                                        Edit
                                    </button>
                                    <a href="{{ route('mata-kuliah.manage-plo.ui', ['id_mk' => $mk->id_mk]) }}" class="btn-manage">Manage PLO</a>
                                    <form method="POST" action="{{ route('mata-kuliah.destroy', $mk->id_mk) }}"
                                        style="display:inline;"
                                        onsubmit="return confirm('Hapus mata kuliah {{ $mk->kode_mk }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-detail" style="background:#e74c3c;color:#fff;">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" style="text-align:center;">Belum ada mata kuliah.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MODAL TAMBAH MATA KULIAH --}}
        <div id="addMkModal" class="modal-overlay">
            <div class="edit-mk-modal">
                <div class="modal-header-custom edit-modal-header">
                    <h3>Tambah Mata Kuliah</h3>
                    <button type="button" onclick="closeAddMkModal()">×</button>
                </div>
                <form method="POST" action="{{ route('mata-kuliah.store') }}">
                    @csrf
                    <div class="edit-modal-body">
                        <div class="edit-field-group">
                            <label>Kode Mata Kuliah</label>
                            <input type="text" name="kode_mk" required maxlength="20" placeholder="BBK1AAB4">
                        </div>
                        <div class="edit-field-group">
                            <label>Nama Mata Kuliah</label>
                            <input type="text" name="nama_matakuliah" required maxlength="255" placeholder="ALGORITMA DAN PEMROGRAMAN">
                        </div>
                        <div class="edit-field-group">
                            <label>SKS</label>
                            <input type="number" name="sks" required min="1" max="6" value="3">
                        </div>
                        <div class="edit-field-group">
                            <label>Semester</label>
                            <input type="number" name="semester" required min="1" max="8" value="1">
                        </div>
                        <div class="edit-field-group">
                            <label>Tahun Kurikulum</label>
                            <input type="number" name="tahun_kurikulum" required min="2000" max="2100" value="2024">
                        </div>
                    </div>
                    <div class="modal-footer-custom modal-footer-edit">
                        <button type="button" class="btn-cancel" onclick="closeAddMkModal()">Cancel</button>
                        <button type="submit" class="btn-save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL EDIT MATA KULIAH --}}
        <div id="editMkModal" class="modal-overlay">
            <div class="edit-mk-modal">
                <div class="modal-header-custom edit-modal-header">
                    <h3>Edit Mata Kuliah</h3>
                    <button type="button" onclick="closeEditMkModal()">×</button>
                </div>
                <form id="editMkForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="edit-modal-body">
                        <div class="edit-field-group">
                            <label>Kode Mata Kuliah</label>
                            <input type="text" id="editKodeMk" name="kode_mk" required maxlength="20">
                        </div>
                        <div class="edit-field-group">
                            <label>Nama Mata Kuliah</label>
                            <input type="text" id="editNamaMk" name="nama_matakuliah" required maxlength="255">
                        </div>
                        <div class="edit-field-group">
                            <label>SKS</label>
                            <input type="number" id="editSks" name="sks" required min="1" max="6">
                        </div>
                        <div class="edit-field-group">
                            <label>Semester</label>
                            <input type="number" id="editSemester" name="semester" required min="1" max="8">
                        </div>
                        <div class="edit-field-group">
                            <label>Tahun Kurikulum</label>
                            <input type="number" id="editTahun" name="tahun_kurikulum" required min="2000" max="2100">
                        </div>
                    </div>
                    <div class="modal-footer-custom modal-footer-edit">
                        <button type="button" class="btn-cancel" onclick="closeEditMkModal()">Cancel</button>
                        <button type="submit" class="btn-save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function openAddMkModal() {
            document.getElementById('addMkModal').classList.add('show');
        }
        function closeAddMkModal() {
            document.getElementById('addMkModal').classList.remove('show');
        }

        function openEditMkModal(id, kode, nama, sks, semester, tahun) {
            document.getElementById('editMkForm').action = '/mata-kuliah/' + id;
            document.getElementById('editKodeMk').value    = kode;
            document.getElementById('editNamaMk').value    = nama;
            document.getElementById('editSks').value       = sks;
            document.getElementById('editSemester').value  = semester;
            document.getElementById('editTahun').value     = tahun;
            document.getElementById('editMkModal').classList.add('show');
        }
        function closeEditMkModal() {
            document.getElementById('editMkModal').classList.remove('show');
        }
    </script>
@endsection
