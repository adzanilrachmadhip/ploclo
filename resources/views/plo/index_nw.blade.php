@extends('layout.app_nw')

@section('title', 'Kelola PLO - COMPASS')
@section('headerTitle', 'Program Learning Outcomes (PLO)')

@section('styles')
    @vite('resources/css/mata_kuliah.css')
    @vite('resources/css/compass_nw.css')
@endsection

@section('content')
    <section class="mk-wrapper">
        <div class="mk-title">Kelola PLO</div>

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

        <div class="mk-table-wrap">
            <table class="mk-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama PLO</th>
                        <th>Deskripsi</th>
                        <th>CLO Terkait</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($plos as $i => $plo)
                        <tr>
                            <td>{{ $i + 1 }}.</td>
                            <td><strong>{{ $plo->nama_plo }}</strong></td>
                            <td style="max-width:400px;white-space:normal;">{{ $plo->description_plo }}</td>
                            <td>{{ $plo->clos_count }}</td>
                            <td>
                                <div class="action-row">
                                    <button type="button" class="btn-action btn-detail-mk"
                                        onclick="openDetailPlo({{ $plo->id_plo }})">
                                        Detail
                                    </button>
                                    <button type="button" class="btn-action btn-edit"
                                        onclick="openEditPloModal({{ $plo->id_plo }}, '{{ $plo->nama_plo }}', '{{ addslashes($plo->description_plo) }}')">
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('plo.destroy', $plo->id_plo) }}"
                                        style="display:inline;"
                                        onsubmit="return confirm('Hapus {{ $plo->nama_plo }}? Semua mapping CLO-PLO juga akan terhapus.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-action btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="text-align:center;">Belum ada PLO.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="plo-add-bottom-wrap">
            <button type="button" class="btn-tambah-plo-bawah" onclick="openAddPloModal()">
                Tambah PLO
            </button>
        </div>

        {{-- MODAL DETAIL PLO --}}
        <div id="detailPloModal" class="modal-overlay">
            <div class="dplo-modal">
                {{-- Header: PLO info di kiri, close di kanan --}}
                <div class="dplo-modal-header">
                    <div class="dplo-header-left">
                        <span id="dplo-title" class="dplo-title-badge"></span>
                        <p id="dplo-desc" class="dplo-header-desc"></p>
                    </div>
                    <button type="button" onclick="closeDetailPlo()" class="dplo-close">×</button>
                </div>
                {{-- Body: label + grid konten --}}
                <div class="dplo-modal-body">
                    <div class="detail-section-label" style="margin-bottom:16px;padding-bottom:8px;border-bottom:1px solid #EEEAF8;">
                        CLO yang dipetakan ke PLO ini
                    </div>
                    <div id="dplo-body"></div>
                </div>
            </div>
        </div>

        {{-- MODAL TAMBAH PLO --}}
        <div id="addPloModal" class="modal-overlay">
            <div class="edit-mk-modal">
                <div class="modal-header-custom edit-modal-header">
                    <h3>Tambah PLO</h3>
                    <button type="button" onclick="closeAddPloModal()">×</button>
                </div>
                <form method="POST" action="{{ route('plo.store') }}">
                    @csrf
                    <div class="edit-modal-body">
                        <div class="edit-field-group">
                            <label>Nama PLO (maks 10 karakter)</label>
                            <input type="text" name="nama_plo" required maxlength="10" placeholder="PLO01">
                        </div>
                        <div class="edit-field-group">
                            <label>Deskripsi PLO</label>
                            <textarea name="description_plo" required maxlength="1000" rows="4"
                                style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;resize:vertical;"
                                placeholder="Deskripsi kemampuan yang diharapkan..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer-custom modal-footer-edit">
                        <button type="button" class="btn-cancel" onclick="closeAddPloModal()">Cancel</button>
                        <button type="submit" class="btn-save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL EDIT PLO --}}
        <div id="editPloModal" class="modal-overlay">
            <div class="edit-mk-modal">
                <div class="modal-header-custom edit-modal-header">
                    <h3>Edit PLO</h3>
                    <button type="button" onclick="closeEditPloModal()">×</button>
                </div>
                <form id="editPloForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="edit-modal-body">
                        <div class="edit-field-group">
                            <label>Nama PLO</label>
                            <input type="text" id="editNamaPlo" name="nama_plo" required maxlength="10">
                        </div>
                        <div class="edit-field-group">
                            <label>Deskripsi PLO</label>
                            <textarea id="editDescPlo" name="description_plo" required maxlength="1000" rows="4"
                                style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;resize:vertical;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer-custom modal-footer-edit">
                        <button type="button" class="btn-cancel" onclick="closeEditPloModal()">Cancel</button>
                        <button type="submit" class="btn-save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        const ploData = @json($plos->keyBy('id_plo'));

        // ── Detail PLO modal ─────────────────────────────────────────
        function openDetailPlo(id) {
            const plo  = ploData[id];
            if (!plo) return;

            document.getElementById('dplo-title').textContent = plo.nama_plo;
            document.getElementById('dplo-desc').textContent  = plo.description_plo ?? '';

            const body = document.getElementById('dplo-body');
            body.innerHTML = '';

            const clos = plo.clos ?? [];
            if (clos.length === 0) {
                body.innerHTML = '<p style="color:#aaa;text-align:center;padding:20px 0;">Belum ada CLO yang dipetakan ke PLO ini.</p>';
            } else {
                // Group by mata kuliah
                const byMk = {};
                clos.forEach(clo => {
                    const mkNama = clo.mata_kuliah ? clo.mata_kuliah.nama_matakuliah : 'Tanpa Mata Kuliah';
                    const mkKode = clo.mata_kuliah ? clo.mata_kuliah.kode_mk : '-';
                    const key    = mkKode;
                    if (!byMk[key]) byMk[key] = { kode: mkKode, nama: mkNama, clos: [] };
                    byMk[key].clos.push(clo);
                });

                Object.values(byMk).forEach(mk => {
                        const rows = mk.clos.map((clo, idx) => `
                        <div class="dplo-clo-row">
                            <span class="dplo-clo-num">${idx + 1}</span>
                            <div class="dplo-clo-info">
                                <span class="dplo-clo-badge">${clo.nama_clo}</span>
                                <p class="dplo-clo-desc">${clo.description_clo ?? '-'}</p>
                            </div>
                        </div>`).join('');

                    body.insertAdjacentHTML('beforeend', `
                        <div class="dplo-mk-block">
                            <div class="dplo-mk-header">
                                <span class="dplo-mk-tag">MK</span>
                                <span class="dplo-mk-name">${mk.kode} — ${mk.nama}</span>
                            </div>
                            <div class="dplo-clo-grid">${rows}</div>
                        </div>`);
                });
            }

            document.getElementById('detailPloModal').classList.add('show');
        }

        function closeDetailPlo() { document.getElementById('detailPloModal').classList.remove('show'); }

        // ── Add / Edit PLO modals ─────────────────────────────────────
        function openAddPloModal()  { document.getElementById('addPloModal').classList.add('show'); }
        function closeAddPloModal() { document.getElementById('addPloModal').classList.remove('show'); }

        function openEditPloModal(id, nama, desc) {
            document.getElementById('editPloForm').action = '/plo/' + id;
            document.getElementById('editNamaPlo').value  = nama;
            document.getElementById('editDescPlo').value  = desc;
            document.getElementById('editPloModal').classList.add('show');
        }
        function closeEditPloModal() { document.getElementById('editPloModal').classList.remove('show'); }
    </script>
@endsection
