@extends('layout.app_nw')

@section('title', 'Mata Kuliah - COMPASS')
@section('headerTitle', 'Mata Kuliah')

@section('styles')
    @vite('resources/css/mata_kuliah.css')
@endsection

@section('content')
    <section class="mk-wrapper mk-page-kelola">

        <div class="mk-title-bar">
            <p>Kelola Mata Kuliah</p>
        </div>

        {{-- Flash messages --}}
        @if (session('success'))
            <div class="mk-alert-success-text">
                {{ session('success') }}
            </div>
        @endif

        {{-- Filter --}}
        <form method="GET" action="{{ route('mata-kuliah.index') }}" class="mk-filter-kelola">
            <div class="mk-filter-row-kelola">
                <label for="tahun_kurikulum">Kurikulum</label>
                <select name="tahun_kurikulum" id="tahun_kurikulum">
                    <option value="">Semua</option>
                    @foreach ($tahunList as $tahun)
                        <option value="{{ $tahun }}" {{ request('tahun_kurikulum') == $tahun ? 'selected' : '' }}>
                            {{ $tahun }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mk-filter-row-kelola">
                <label for="search">Search</label>
                <input
                    type="text"
                    name="search"
                    id="search"
                    value="{{ request('search') }}"
                    placeholder="Kode / Nama MK"
                >
            </div>

            <div class="mk-filter-action-kelola">
                <button type="submit" class="mk-btn-apply-kelola">
                    Apply
                </button>
            </div>
        </form>

        <div class="mk-info-box-kelola">
            Tempat Info
        </div>

        <div class="mk-add-area-kelola">
            <button type="button" class="mk-btn-add-kelola" onclick="openAddMkModal()">
                <span>+</span>
                Tambah Mata Kuliah
            </button>
        </div>

        <div class="mk-table-toolbar-kelola">
            <div class="mk-record-kelola">
                <span class="record-box-kelola"></span>
                <span>{{ $matkul->count() }} record(s)</span>
            </div>

            <form method="GET" action="{{ route('mata-kuliah.index') }}" class="mk-search-table-kelola">
                <input type="hidden" name="tahun_kurikulum" value="{{ request('tahun_kurikulum') }}">
                <label for="table_search">Search (Press Enter):</label>
                <input
                    type="text"
                    name="search"
                    id="table_search"
                    value="{{ request('search') }}"
                >
            </form>
        </div>

        <div class="mk-table-wrapper-kelola">
            <table class="mk-table mk-table-kelola">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Mata Kuliah</th>
                        <th>Nama Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Semester</th>
                        <th>Tahun Kurikulum</th>
                        <th>Status</th>
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
                            <td>Active</td>
                            <td>
                                <div class="action-group-kelola">
                                    <button
                                        type="button"
                                        class="mk-action-btn-kelola edit btn-open-edit-mk"
                                        data-id="{{ $mk->id_mk }}"
                                        data-kode="{{ $mk->kode_mk }}"
                                        data-nama="{{ $mk->nama_matakuliah }}"
                                        data-sks="{{ $mk->sks }}"
                                        data-semester="{{ $mk->semester }}"
                                        data-tahun="{{ $mk->tahun_kurikulum }}"
                                    >
                                        Edit
                                    </button>

                                    <a
                                        href="{{ route('mata-kuliah.manage-plo.ui', ['id_mk' => $mk->id_mk]) }}"
                                        class="mk-action-btn-kelola manage"
                                    >
                                        Manage PLO
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('mata-kuliah.destroy', $mk->id_mk) }}"
                                        onsubmit="return confirm('Hapus mata kuliah {{ $mk->kode_mk }}?')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="mk-action-btn-kelola delete">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                Belum ada mata kuliah.
                            </td>
                        </tr>
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
                            <input type="text" name="nama_matakuliah" required maxlength="255"
                                placeholder="ALGORITMA DAN PEMROGRAMAN">
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

        {{-- MODAL EDIT MANAGE PLO --}}
        <div id="editManagePloModal" class="modal-overlay">
            <div class="edit-manage-plo-modal">
                <div class="edit-manage-plo-header">
                    <h3>Edit Manage PLO</h3>
                    <button type="button" id="btnCloseEditManagePlo">×</button>
                </div>

                <form id="editManagePloForm" method="POST" action="">
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="editNamaMatakuliah" name="nama_matakuliah">
                    <input type="hidden" id="editSks" name="sks">
                    <input type="hidden" id="editSemester" name="semester">
                    <input type="hidden" id="editTahunKurikulum" name="tahun_kurikulum">

                    <div class="edit-manage-plo-body">
                        <div class="edit-manage-plo-info">
                            Tempat Info
                        </div>

                        <div class="edit-manage-plo-row">
                            <label for="editKodeMk">Kode Mata Kuliah</label>
                            <select id="editKodeMk" name="kode_mk" required>
                                @foreach ($matkul as $item)
                                    <option value="{{ $item->kode_mk }}">
                                        {{ $item->kode_mk }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="edit-manage-plo-row">
                            <label for="editStatusPlo">Status Aktif PLO</label>

                            <label class="plo-switch">
                                <input type="checkbox" id="editStatusPlo" name="status_aktif_plo" value="1" checked>
                                <span class="plo-slider"></span>
                            </label>
                        </div>
                    </div>

                    <div class="edit-manage-plo-footer">
                        <button type="button" class="btn-edit-cancel" id="btnCancelEditManagePlo">
                            Cancel
                        </button>

                        <button type="submit" class="btn-edit-save">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addModal = document.getElementById('addMkModal');
        const editModal = document.getElementById('editManagePloModal');

        const editForm = document.getElementById('editManagePloForm');
        const editKodeMk = document.getElementById('editKodeMk');
        const editNamaMatakuliah = document.getElementById('editNamaMatakuliah');
        const editSks = document.getElementById('editSks');
        const editSemester = document.getElementById('editSemester');
        const editTahunKurikulum = document.getElementById('editTahunKurikulum');

        window.openAddMkModal = function () {
            addModal?.classList.add('show');
        }

        window.closeAddMkModal = function () {
            addModal?.classList.remove('show');
        }

        function openEditModal(button) {
            const id = button.dataset.id;
            const kode = button.dataset.kode;
            const nama = button.dataset.nama;
            const sks = button.dataset.sks;
            const semester = button.dataset.semester;
            const tahun = button.dataset.tahun;

            if (!editForm || !editModal) {
                return;
            }

            editForm.action = `/mata-kuliah/${id}`;

            if (editKodeMk) editKodeMk.value = kode;
            if (editNamaMatakuliah) editNamaMatakuliah.value = nama;
            if (editSks) editSks.value = sks;
            if (editSemester) editSemester.value = semester;
            if (editTahunKurikulum) editTahunKurikulum.value = tahun;

            editModal.classList.add('show');
        }

        function closeEditModal() {
            editModal?.classList.remove('show');
        }

        document.querySelectorAll('.btn-open-edit-mk').forEach(function (button) {
            button.addEventListener('click', function () {
                openEditModal(button);
            });
        });

        document.getElementById('btnCloseEditManagePlo')?.addEventListener('click', closeEditModal);
        document.getElementById('btnCancelEditManagePlo')?.addEventListener('click', closeEditModal);

        document.addEventListener('click', function (event) {
            if (event.target === addModal) {
                window.closeAddMkModal();
            }

            if (event.target === editModal) {
                closeEditModal();
            }
        });
    });
</script>
@endsection
