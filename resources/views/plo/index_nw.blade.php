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
            <div class="mk-alert-success" style="display:block;">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mk-alert-success" style="display:block;background:#f8d7da;color:#721c24;border-color:#f5c6cb;">{{ session('error') }}</div>
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
                                <div class="action-group">
                                    <button type="button" class="btn-edit"
                                        onclick="openEditPloModal({{ $plo->id_plo }}, '{{ $plo->nama_plo }}', '{{ addslashes($plo->description_plo) }}')">
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('plo.destroy', $plo->id_plo) }}"
                                        style="display:inline;"
                                        onsubmit="return confirm('Hapus {{ $plo->nama_plo }}? Semua mapping CLO-PLO juga akan terhapus.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-detail" style="background:#e74c3c;color:#fff;">Hapus</button>
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
