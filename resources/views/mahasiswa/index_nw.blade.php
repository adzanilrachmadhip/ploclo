@extends('layout.app_nw')

@section('title', 'Data Mahasiswa - COMPASS')
@section('headerTitle', 'Data Mahasiswa')

@section('styles')
    @vite('resources/css/mata_kuliah.css')
@endsection

@section('content')
    <section class="mk-wrapper mahasiswa-page">
        <div class="mk-title">Data Mahasiswa</div>

        @if (session('success'))
            <div class="mk-alert-success" style="display:block;">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mk-alert-success" style="display:block;background:#f8d7da;color:#721c24;border-color:#f5c6cb;">
                {{ session('error') }}</div>
        @endif

        {{-- Filter --}}
        <form method="GET" action="{{ route('mahasiswa.index') }}" class="mk-filter" style="flex-wrap:wrap;gap:10px;">
            <div class="filter-row">
                <label>Angkatan</label>
                <select name="angkatan">
                    <option value="">Semua</option>
                    @foreach ($angkatanList as $thn)
                        <option value="{{ $thn }}" {{ request('angkatan') == $thn ? 'selected' : '' }}>
                            {{ $thn }}</option>
                    @endforeach
                </select>
            </div>
            @if (!auth()->user()->isDosenWali())
                <div class="filter-row">
                    <label>Dosen Wali</label>
                    <select name="kode_dosen">
                        <option value="">Semua</option>
                        @foreach ($dosenList as $dosen)
                            <option value="{{ $dosen->kode_dosen }}"
                                {{ request('kode_dosen') == $dosen->kode_dosen ? 'selected' : '' }}>
                                {{ $dosen->kode_dosen }} — {{ $dosen->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div class="filter-row">
                <label>Status</label>
                <select name="status">
                    <option value="">Semua</option>
                    @foreach (['Aktif', 'Cuti', 'Lulus', 'DO'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                            {{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-row">
                <label>Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="NIM / Nama">
            </div>
            <button type="submit" class="mk-apply-btn">Apply</button>
        </form>

        <div class="mahasiswa-count-action-row">
            <span class="mahasiswa-count-text">{{ $mahasiswas->count() }} mahasiswa</span>
            @if (auth()->user()->isAdmin() || auth()->user()->isKaprodi())
                <button type="button" class="btn-tambah-mahasiswa" onclick="openAddMhsModal()">Tambah Mahasiswa</button>
            @endif
        </div>

        <div class="mk-table-wrap">
            <table class="mk-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Angkatan</th>
                        <th>Kelas</th>
                        <th>Status</th>
                        <th>Dosen Wali</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mahasiswas as $i => $mhs)
                        <tr>
                            <td>{{ $i + 1 }}.</td>
                            <td>{{ $mhs->nim }}</td>
                            <td>{{ $mhs->nama }}</td>
                            <td>{{ $mhs->tahun_masuk }}</td>
                            <td>{{ $mhs->class_code ?? '-' }}</td>
                            <td>
                                <span
                                    style="padding:2px 8px;border-radius:10px;font-size:0.82em;
                            background:{{ $mhs->status === 'Aktif' ? '#e8fdf0' : ($mhs->status === 'Lulus' ? '#e8f4fd' : '#fff3cd') }};
                            color:{{ $mhs->status === 'Aktif' ? '#27ae60' : ($mhs->status === 'Lulus' ? '#2980b9' : '#856404') }};">
                                    {{ $mhs->status }}
                                </span>
                            </td>
                            <td>
                                @if ($mhs->dosenWali)
                                    <span title="{{ $mhs->dosenWali->nama_lengkap }}">{{ $mhs->kode_dosen }}</span>
                                @else
                                    <span style="color:#aaa;">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-group">
                                    @if (auth()->user()->isAdmin() || auth()->user()->isKaprodi())
                                        <button type="button" class="btn-edit"
                                            onclick="openEditMhsModal(
                                    {{ $mhs->id_mahasiswa }},
                                    '{{ $mhs->nim }}',
                                    '{{ addslashes($mhs->nama) }}',
                                    {{ $mhs->tahun_masuk }},
                                    '{{ $mhs->class_code ?? '' }}',
                                    '{{ $mhs->status }}',
                                    '{{ $mhs->kode_dosen ?? '' }}'
                                )">Edit</button>

                                        <form method="POST" action="{{ route('mahasiswa.destroy', $mhs->id_mahasiswa) }}"
                                            style="display:inline;"
                                            onsubmit="return confirm('Hapus {{ $mhs->nama }}? Semua data nilai juga terhapus.')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-detail"
                                                style="background:#e74c3c;color:#fff;">Hapus</button>
                                        </form>
                                    @endif

                                    <a href="{{ route('nilai.index', ['kode_dosen' => $mhs->kode_dosen]) }}"
                                        class="btn-manage">Nilai</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center;">Belum ada data mahasiswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MODAL TAMBAH MAHASISWA --}}
        <div id="addMhsModal" class="modal-overlay">
            <div class="edit-mk-modal" style="max-width:480px;">
                <div class="modal-header-custom edit-modal-header">
                    <h3>Tambah Mahasiswa</h3>
                    <button type="button" onclick="closeAddMhsModal()">×</button>
                </div>
                <form method="POST" action="{{ route('mahasiswa.store') }}">
                    @csrf
                    <div class="edit-modal-body">
                        <div class="edit-field-group">
                            <label>NIM</label>
                            <input type="text" name="nim" required maxlength="20" placeholder="1301224001">
                        </div>
                        <div class="edit-field-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" required maxlength="255">
                        </div>
                        <div class="edit-field-group">
                            <label>Tahun Masuk</label>
                            <input type="number" name="tahun_masuk" required min="2000" max="2100"
                                value="{{ date('Y') }}">
                        </div>
                        <div class="edit-field-group">
                            <label>Kode Kelas</label>
                            <input type="text" name="class_code" maxlength="20" placeholder="SI-44-01">
                        </div>
                        <div class="edit-field-group">
                            <label>Status</label>
                            <select name="status">
                                <option value="Aktif">Aktif</option>
                                <option value="Cuti">Cuti</option>
                                <option value="Lulus">Lulus</option>
                                <option value="DO">DO</option>
                            </select>
                        </div>
                        <div class="edit-field-group">
                            <label>Dosen Wali</label>
                            <select name="kode_dosen">
                                <option value="">-- Pilih Dosen Wali --</option>
                                @foreach ($dosenList as $d)
                                    <option value="{{ $d->kode_dosen }}">{{ $d->kode_dosen }} — {{ $d->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer-custom modal-footer-edit">
                        <button type="button" class="btn-cancel" onclick="closeAddMhsModal()">Cancel</button>
                        <button type="submit" class="btn-save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL EDIT MAHASISWA --}}
        <div id="editMhsModal" class="modal-overlay">
            <div class="edit-mk-modal" style="max-width:480px;">
                <div class="modal-header-custom edit-modal-header">
                    <h3>Edit Mahasiswa</h3>
                    <button type="button" onclick="closeEditMhsModal()">×</button>
                </div>
                <form id="editMhsForm" method="POST" action="">
                    @csrf @method('PUT')
                    <div class="edit-modal-body">
                        <div class="edit-field-group">
                            <label>NIM</label>
                            <input type="text" id="editNim" name="nim" required maxlength="20">
                        </div>
                        <div class="edit-field-group">
                            <label>Nama Lengkap</label>
                            <input type="text" id="editNamaMhs" name="nama" required maxlength="255">
                        </div>
                        <div class="edit-field-group">
                            <label>Tahun Masuk</label>
                            <input type="number" id="editTahunMasuk" name="tahun_masuk" required min="2000"
                                max="2100">
                        </div>
                        <div class="edit-field-group">
                            <label>Kode Kelas</label>
                            <input type="text" id="editClassCode" name="class_code" maxlength="20">
                        </div>
                        <div class="edit-field-group">
                            <label>Status</label>
                            <select id="editStatusMhs" name="status">
                                <option value="Aktif">Aktif</option>
                                <option value="Cuti">Cuti</option>
                                <option value="Lulus">Lulus</option>
                                <option value="DO">DO</option>
                            </select>
                        </div>
                        <div class="edit-field-group">
                            <label>Dosen Wali</label>
                            <select id="editKodeDosenMhs" name="kode_dosen">
                                <option value="">-- Pilih Dosen Wali --</option>
                                @foreach ($dosenList as $d)
                                    <option value="{{ $d->kode_dosen }}">{{ $d->kode_dosen }} — {{ $d->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer-custom modal-footer-edit">
                        <button type="button" class="btn-cancel" onclick="closeEditMhsModal()">Cancel</button>
                        <button type="submit" class="btn-save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function openAddMhsModal() {
            document.getElementById('addMhsModal').classList.add('show');
        }

        function closeAddMhsModal() {
            document.getElementById('addMhsModal').classList.remove('show');
        }

        function openEditMhsModal(id, nim, nama, tahun, kelas, status, kodeDosen) {
            document.getElementById('editMhsForm').action = '/mahasiswa/' + id;
            document.getElementById('editNim').value = nim;
            document.getElementById('editNamaMhs').value = nama;
            document.getElementById('editTahunMasuk').value = tahun;
            document.getElementById('editClassCode').value = kelas;
            document.getElementById('editStatusMhs').value = status;
            document.getElementById('editKodeDosenMhs').value = kodeDosen;
            document.getElementById('editMhsModal').classList.add('show');
        }

        function closeEditMhsModal() {
            document.getElementById('editMhsModal').classList.remove('show');
        }
    </script>
@endsection
