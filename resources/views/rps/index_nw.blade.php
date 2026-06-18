@extends('layout.app_nw')

@section('title', 'RPS - COMPASS')
@section('headerTitle', 'RPS')

@section('styles')
    @vite('resources/css/mata_kuliah.css')
@endsection

@section('content')
    <section class="mk-wrapper">
        <div class="mk-title">Rencana Pembelajaran Semester (RPS)</div>

        <form method="GET" action="{{ route('rps.index') }}" class="mk-filter">
            <div class="filter-row">
                <label>Tahun Kurikulum</label>
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
                <label>Semester</label>
                <select name="semester">
                    <option value="">Semua</option>
                    @foreach ($semesterList as $semester)
                        <option value="{{ $semester }}" {{ request('semester') == $semester ? 'selected' : '' }}>
                            Semester {{ $semester }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="mk-apply-btn">
                Apply
            </button>
        </form>

        <div class="mk-info-box">
            <strong>INFO !!!</strong><br>
            Halaman ini menampilkan daftar dokumen RPS mata kuliah berdasarkan kurikulum dan semester.
        </div>

        <div class="mk-table-top">
            <div>
                <span class="record-box"></span>
                <span>Record per pages</span>
            </div>
            <form method="GET" action="{{ route('rps.index') }}" class="table-search">
                <input type="hidden" name="tahun_kurikulum" value="{{ request('tahun_kurikulum') }}">
                <input type="hidden" name="semester" value="{{ request('semester') }}">

                <label>Search (Press Enter):</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Kode / Nama MK" onkeydown="if(event.key === 'Enter') this.form.submit();">
            </form>
        </div>

        <div class="mk-table-wrap">
            <table class="mk-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Mata Kuliah</th>
                        <th>Nama Mata Kuliah</th>
                        <th>Semester</th>
                        <th>Jenis Mata Kuliah</th>
                        <th>Dokumen RPS</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rpsList as $index => $mk)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $mk->kode_mk }}</td>
                            <td>{{ $mk->nama_matakuliah }}</td>
                            <td>{{ $mk->semester }}</td>
                            <td>{{ $mk->jenis_mata_kuliah ?? 'wajib' }}</td>
                            <td>
                                @if ($mk->file_rps)
                                    <a href="{{ asset('storage/' . $mk->file_rps) }}" target="_blank" class="rps-view-btn">
                                        Lihat RPS
                                    </a>
                                @else
                                    <span class="rps-empty-text">Belum ada file</span>
                                @endif
                            </td>

                            <td>
                                <div class="action-group-kelola">
                                    <button type="button" class="mk-action-btn-kelola edit"
                                        onclick="openEditRpsModal(this)" data-id="{{ $mk->id_mk }}"
                                        data-kode="{{ $mk->kode_mk }}" data-nama="{{ $mk->nama_matakuliah }}"
                                        data-tahun="{{ $mk->tahun_kurikulum }}" data-semester="{{ $mk->semester }}"
                                        data-jenis="{{ $mk->jenis_mata_kuliah ?? 'Wajib' }}"
                                        data-update-url="{{ route('rps.update', $mk->id_mk) }}">
                                        Edit
                                    </button>

                                    <form method="POST" action="{{ route('rps.file.delete', $mk->id_mk) }}"
                                        onsubmit="return confirm('Yakin ingin menghapus dokumen RPS mata kuliah ini?')">
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
                            <td colspan="7" style="text-align:center;">
                                Tidak ada data RPS untuk filter yang dipilih.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mk-pagination">
            <button>First</button>
            <button>Previous</button>
            <button class="active">1</button>
            <button>2</button>
            <button>Next</button>
            <button>Last</button>
        </div>

        <div id="editRpsModal" class="modal-overlay">
            <div class="edit-mk-modal">
                <div class="edit-modal-header">
                    <h3>Edit RPS</h3>
                    <button type="button" onclick="closeEditRpsModal()">×</button>
                </div>

                <form id="editRpsForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="edit-modal-body">
                        <div class="edit-field-group">
                            <label>Kode Mata Kuliah</label>
                            <div class="edit-field-value">
                                <span id="editRpsKode" class="edit-code-text"></span>
                            </div>
                        </div>

                        <div class="edit-field-group">
                            <label>Nama Mata Kuliah</label>
                            <div class="edit-field-value">
                                <span id="editRpsNama" class="edit-code-text"></span>
                            </div>
                        </div>

                        <div class="edit-field-group">
                            <label>Tahun Kurikulum</label>
                            <div class="edit-field-value">
                                <span id="editRpsTahun" class="edit-code-text"></span>
                            </div>
                        </div>

                        <div class="edit-field-group">
                            <label>Semester</label>
                            <div class="edit-field-value">
                                <span id="editRpsSemester" class="edit-code-text"></span>
                            </div>
                        </div>

                        <div class="edit-field-group">
                            <label>Jenis Mata Kuliah</label>
                            <select id="editRpsJenis" name="jenis_mata_kuliah" class="edit-rps-select">
                                <option value="Wajib">Wajib</option>
                                <option value="Pilihan">Pilihan</option>
                            </select>
                        </div>

                        <div class="edit-field-group">
                            <label>Dokumen RPS</label>
                            <input type="file" name="file_rps" accept="application/pdf" class="edit-rps-file">
                            <small>Format file harus PDF. Kosongkan jika tidak ingin mengganti file.</small>
                        </div>
                    </div>

                    <div class="modal-footer-custom modal-footer-edit">
                        <button type="button" class="btn-cancel" onclick="closeEditRpsModal()">Cancel</button>
                        <button type="submit" class="btn-save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function openEditRpsModal(button) {
            const modal = document.getElementById('editRpsModal');
            const form = document.getElementById('editRpsForm');

            form.action = button.dataset.updateUrl;

            document.getElementById('editRpsKode').textContent = button.dataset.kode || '-';
            document.getElementById('editRpsNama').textContent = button.dataset.nama || '-';
            document.getElementById('editRpsTahun').textContent = button.dataset.tahun || '-';
            document.getElementById('editRpsSemester').textContent = button.dataset.semester || '-';
            document.getElementById('editRpsJenis').value = button.dataset.jenis || 'Wajib';

            modal.classList.add('show');
        }

        function closeEditRpsModal() {
            document.getElementById('editRpsModal').classList.remove('show');
        }
    </script>
@endsection
