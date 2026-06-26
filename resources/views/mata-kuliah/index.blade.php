@extends('layout.app_nw')

@section('title', 'Mata Kuliah - COMPASS')
@section('headerTitle', 'Mata Kuliah')

@section('styles')
    @vite('resources/css/mata_kuliah.css')
@endsection

@section('content')
<section class="mk-wrapper">

    <div class="mk-title">Kelola Mata Kuliah</div>

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

    {{-- Toolbar: filter kiri, tombol kanan --}}
    <div class="mk-toolbar">
        <form method="GET" action="{{ route('mata-kuliah.index') }}" class="mk-filter-inline">
            <div class="mk-filter-item">
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
                    <th style="width:230px;">Aksi</th>
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

    {{-- MODAL DETAIL --}}
    <div id="detailMkModal" class="modal-overlay">
        <div class="edit-mk-modal" style="max-width:680px;max-height:88vh;overflow-y:auto;">
            <div class="modal-header-custom edit-modal-header" style="position:sticky;top:0;background:#fff;z-index:1;">
                <div>
                    <h3 id="detail-title" style="margin:0;font-size:16px;"></h3>
                    <p id="detail-sub" style="margin:2px 0 0;font-size:12px;color:#888;"></p>
                </div>
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
@endsection

@section('scripts')
<script>
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

                const ploChips = plos.length
                    ? plos.map(p =>
                        `<span class="detail-chip detail-chip-plo" title="${p.description_plo ?? ''}">${p.nama_plo}</span>`
                      ).join('')
                    : '<span style="color:#bbb;font-size:12px;">—</span>';

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
</script>
@endsection
