@extends('layout.app_nw')

@section('title', 'Mata Kuliah - COMPASS')
@section('headerTitle', 'Mata Kuliah')

@section('styles')
    @vite('resources/css/mata_kuliah.css')
@endsection

@section('content')
<<<<<<< HEAD
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
=======
<section class="mk-wrapper">

    <div class="mk-title">Kelola Mata Kuliah</div>

    @if (session('success'))
        <div class="mk-alert-success" style="display:block;height:auto;padding:10px 16px;">{{ session('success') }}</div>
    @endif

    {{-- Toolbar: filter kiri, tombol kanan --}}
    <div class="mk-toolbar">
        <form method="GET" action="{{ route('mata-kuliah.index') }}" class="mk-filter-inline">
            <div class="mk-filter-item">
                <label>Kurikulum</label>
                <select name="tahun_kurikulum">
>>>>>>> bb78943 (ok done)
                    <option value="">Semua</option>
                    @foreach ($tahunList as $tahun)
                        <option value="{{ $tahun }}" {{ request('tahun_kurikulum') == $tahun ? 'selected' : '' }}>
                            {{ $tahun }}
                        </option>
                    @endforeach
                </select>
            </div>
<<<<<<< HEAD

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
=======
            <div class="mk-filter-item">
                <label>Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Kode / Nama MK">
            </div>
            <button type="submit" class="btn-apply">Apply</button>
        </form>

        <button type="button" class="btn-primary-action" onclick="openAddMkModal()">
            + Tambah Mata Kuliah
        </button>
    </div>

    <div class="mk-count">{{ $matkul->count() }} record(s)</div>

    <div class="mk-table-wrap">
        <table class="mk-table">
            <thead>
                <tr>
                    <th style="width:50px;">No</th>
                    <th style="width:140px;">Kode MK</th>
                    <th>Nama Mata Kuliah</th>
                    <th style="width:60px;">SKS</th>
                    <th style="width:80px;">Semester</th>
                    <th style="width:130px;">Tahun Kurikulum</th>
                    <th style="width:210px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($matkul as $index => $mk)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}.</td>
                        <td>{{ $mk->kode_mk }}</td>
                        <td>{{ $mk->nama_matakuliah }}</td>
                        <td class="text-center">{{ $mk->sks }}</td>
                        <td class="text-center">{{ $mk->semester }}</td>
                        <td class="text-center">{{ $mk->tahun_kurikulum }}</td>
                        <td>
                            <div class="action-row">
                                <button type="button" class="btn-action btn-detail-mk"
                                    onclick="openDetailModal({{ $mk->id_mk }})">
                                    Detail
                                </button>
                                <button type="button" class="btn-action btn-edit"
                                    onclick="openEditMkModal({{ $mk->id_mk }}, '{{ $mk->kode_mk }}', '{{ addslashes($mk->nama_matakuliah) }}', {{ $mk->sks }}, {{ $mk->semester }}, {{ $mk->tahun_kurikulum }})">
                                    Edit
                                </button>
                                <a href="{{ route('mata-kuliah.manage-plo.ui', ['id_mk' => $mk->id_mk]) }}"
                                   class="btn-action btn-manage">Manage PLO</a>
                                <form method="POST" action="{{ route('mata-kuliah.destroy', $mk->id_mk) }}"
                                    style="display:inline;"
                                    onsubmit="return confirm('Hapus mata kuliah {{ $mk->kode_mk }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action btn-danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center" style="padding:32px;color:#888;">
                            Belum ada mata kuliah. Klik "+ Tambah Mata Kuliah" untuk menambahkan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
>>>>>>> bb78943 (ok done)

    {{-- MODAL DETAIL --}}
    <div id="detailMkModal" class="modal-overlay">
        <div class="edit-mk-modal" style="max-width:680px;max-height:88vh;overflow-y:auto;">
            <div class="modal-header-custom edit-modal-header" style="position:sticky;top:0;background:#fff;z-index:1;">
                <div>
                    <h3 id="detail-title" style="margin:0;font-size:16px;"></h3>
                    <p id="detail-sub" style="margin:2px 0 0;font-size:12px;color:#888;"></p>
                </div>
<<<<<<< HEAD

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

=======
                <button type="button" onclick="closeDetailModal()" style="font-size:22px;line-height:1;background:none;border:none;color:#555;cursor:pointer;">×</button>
            </div>
            <div class="edit-modal-body" id="detail-body" style="gap:0;padding:0 22px 22px;"></div>
        </div>
    </div>

    {{-- MODAL TAMBAH --}}
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
                        <input type="text" name="kode_mk" required maxlength="20" placeholder="BBK1AAB4"
                            style="padding:8px 12px;border:1px solid #d4d4d4;border-radius:4px;font-size:14px;">
                    </div>
                    <div class="edit-field-group">
                        <label>Nama Mata Kuliah</label>
                        <input type="text" name="nama_matakuliah" required maxlength="255"
                            placeholder="ALGORITMA DAN PEMROGRAMAN"
                            style="padding:8px 12px;border:1px solid #d4d4d4;border-radius:4px;font-size:14px;">
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;">
>>>>>>> bb78943 (ok done)
                        <div class="edit-field-group">
                            <label>SKS</label>
                            <input type="number" name="sks" required min="1" max="6" value="3"
                                style="padding:8px 12px;border:1px solid #d4d4d4;border-radius:4px;font-size:14px;">
                        </div>

                        <div class="edit-field-group">
                            <label>Semester</label>
                            <input type="number" name="semester" required min="1" max="8" value="1"
                                style="padding:8px 12px;border:1px solid #d4d4d4;border-radius:4px;font-size:14px;">
                        </div>

                        <div class="edit-field-group">
                            <label>Tahun Kurikulum</label>
                            <input type="number" name="tahun_kurikulum" required min="2000" max="2100" value="2024"
                                style="padding:8px 12px;border:1px solid #d4d4d4;border-radius:4px;font-size:14px;">
                        </div>
                    </div>
<<<<<<< HEAD

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
=======
                </div>
                <div class="modal-footer-custom modal-footer-edit">
                    <button type="button" class="btn-cancel" onclick="closeAddMkModal()">Cancel</button>
                    <button type="submit" class="btn-save">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT --}}
    <div id="editMkModal" class="modal-overlay">
        <div class="edit-mk-modal">
            <div class="modal-header-custom edit-modal-header">
                <h3>Edit Mata Kuliah</h3>
                <button type="button" onclick="closeEditMkModal()">×</button>
            </div>
            <form id="editMkForm" method="POST" action="">
                @csrf @method('PUT')
                <div class="edit-modal-body">
                    <div class="edit-field-group">
                        <label>Kode Mata Kuliah</label>
                        <input type="text" id="editKodeMk" name="kode_mk" required maxlength="20"
                            style="padding:8px 12px;border:1px solid #d4d4d4;border-radius:4px;font-size:14px;">
                    </div>
                    <div class="edit-field-group">
                        <label>Nama Mata Kuliah</label>
                        <input type="text" id="editNamaMk" name="nama_matakuliah" required maxlength="255"
                            style="padding:8px 12px;border:1px solid #d4d4d4;border-radius:4px;font-size:14px;">
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;">
                        <div class="edit-field-group">
                            <label>SKS</label>
                            <input type="number" id="editSks" name="sks" required min="1" max="6"
                                style="padding:8px 12px;border:1px solid #d4d4d4;border-radius:4px;font-size:14px;">
                        </div>
                        <div class="edit-field-group">
                            <label>Semester</label>
                            <input type="number" id="editSemester" name="semester" required min="1" max="8"
                                style="padding:8px 12px;border:1px solid #d4d4d4;border-radius:4px;font-size:14px;">
                        </div>
                        <div class="edit-field-group">
                            <label>Tahun Kurikulum</label>
                            <input type="number" id="editTahun" name="tahun_kurikulum" required min="2000" max="2100"
                                style="padding:8px 12px;border:1px solid #d4d4d4;border-radius:4px;font-size:14px;">
                        </div>
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
>>>>>>> bb78943 (ok done)
@endsection

@section('scripts')
<script>
<<<<<<< HEAD
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
=======
    const matkulData = @json($matkul->keyBy('id_mk'));

    // ── Detail modal ──────────────────────────────────────────────
    function openDetailModal(id) {
        const mk = matkulData[id];
        if (!mk) return;

        document.getElementById('detail-title').textContent = mk.kode_mk + ' — ' + mk.nama_matakuliah;
        document.getElementById('detail-sub').textContent   =
            'SKS: ' + mk.sks + '  •  Semester: ' + mk.semester + '  •  Kurikulum: ' + mk.tahun_kurikulum;

        const body = document.getElementById('detail-body');
        body.innerHTML = '';

        const clos = mk.clos ?? [];
        if (clos.length === 0) {
            body.innerHTML = '<p style="padding:20px 0;color:#aaa;text-align:center;">Belum ada CLO untuk mata kuliah ini.</p>';
        } else {
            clos.forEach((clo, idx) => {
                const plos = clo.plos ?? [];
                const ats  = clo.assessment_tools ?? [];

                // PLO chips
                const ploChips = plos.length
                    ? plos.map(p =>
                        `<span class="detail-chip detail-chip-plo" title="${p.description_plo ?? ''}">${p.nama_plo} <span class="chip-weight">${p.pivot.percentage_weight}%</span></span>`
                      ).join('')
                    : '<span style="color:#bbb;font-size:12px;">—</span>';

                // AT rows
                const atRows = ats.length
                    ? ats.map(at => `
                        <tr>
                            <td>${at.nama_at}</td>
                            <td style="text-align:center;width:90px;">
                                <span class="detail-weight-badge">${at.weight_in_clo}%</span>
                            </td>
                        </tr>`).join('')
                    : `<tr><td colspan="2" style="color:#bbb;font-size:12px;">Belum ada assessment tool</td></tr>`;

                const totalBobot = ats.reduce((s, a) => s + parseFloat(a.weight_in_clo ?? 0), 0);
                const totalOk    = Math.abs(totalBobot - 100) < 0.01;

                body.insertAdjacentHTML('beforeend', `
                <div class="detail-clo-card">
                    <div class="detail-clo-header">
                        <span class="detail-clo-badge">CLO ${idx + 1}</span>
                        <span class="detail-clo-name">${clo.nama_clo}</span>
                    </div>
                    ${clo.description_clo ? `<p class="detail-clo-desc">${clo.description_clo}</p>` : ''}

                    <div class="detail-section-label">PLO yang dipetakan</div>
                    <div class="detail-chips">${ploChips}</div>

                    <div class="detail-section-label" style="margin-top:14px;">Assessment Tools</div>
                    <table class="detail-at-table">
                        <thead>
                            <tr><th>Nama Assessment Tool</th><th style="width:90px;">Bobot</th></tr>
                        </thead>
                        <tbody>${atRows}</tbody>
                        <tfoot>
                            <tr>
                                <td style="font-weight:600;">Total Bobot</td>
                                <td style="text-align:center;">
                                    <span class="${totalOk ? 'detail-bobot-ok' : 'detail-bobot-warn'}">${totalBobot.toFixed(1)}%</span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>`);
            });
        }

        document.getElementById('detailMkModal').classList.add('show');
    }

    function closeDetailModal() { document.getElementById('detailMkModal').classList.remove('show'); }

    // ── Add / Edit modals ─────────────────────────────────────────
    function openAddMkModal()  { document.getElementById('addMkModal').classList.add('show'); }
    function closeAddMkModal() { document.getElementById('addMkModal').classList.remove('show'); }

    function openEditMkModal(id, kode, nama, sks, semester, tahun) {
        document.getElementById('editMkForm').action   = '/mata-kuliah/' + id;
        document.getElementById('editKodeMk').value    = kode;
        document.getElementById('editNamaMk').value    = nama;
        document.getElementById('editSks').value       = sks;
        document.getElementById('editSemester').value  = semester;
        document.getElementById('editTahun').value     = tahun;
        document.getElementById('editMkModal').classList.add('show');
    }
    function closeEditMkModal() { document.getElementById('editMkModal').classList.remove('show'); }
>>>>>>> bb78943 (ok done)
</script>
@endsection
