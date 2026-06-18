@extends('layout.app_nw')

@section('title', 'Manajemen User - COMPASS')
@section('headerTitle', 'Manajemen User')

@section('styles')
    @vite('resources/css/mata_kuliah.css')
@endsection

@section('content')
    <section class="mk-wrapper">
        <div class="mk-title">Manajemen User</div>

        @if (session('success'))
            <div class="mk-alert-success" style="display:block;">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mk-alert-success" style="display:block;background:#f8d7da;color:#721c24;border-color:#f5c6cb;">
                {{ session('error') }}</div>
        @endif

        @if (auth()->user()->isAdmin() || auth()->user()->isKaprodi())
            <div class="mk-add-area-kelola">
                <button type="button" class="mk-btn-add-kelola" onclick="openAddUserModal()">
                    <span>+</span>
                    Tambah User
                </button>
            </div>
        @endif

        <div class="mk-table-wrap">
            <table class="mk-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Role</th>
                        <th>Kode Dosen</th>
                        <th>Email</th>
                        <th>NIP / NIDN</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $i => $u)
                        <tr>
                            <td>{{ $i + 1 }}.</td>
                            <td><strong>{{ $u->username }}</strong></td>
                            <td>{{ $u->nama_lengkap }}</td>
                            <td>
                                <span
                                    style="padding:2px 10px;border-radius:10px;font-size:0.82em;font-weight:600;
                            background:{{ $u->role === 'admin' ? '#fde8e8' : ($u->role === 'kaprodi' ? '#e8f4fd' : '#e8fdf0') }};
                            color:{{ $u->role === 'admin' ? '#c0392b' : ($u->role === 'kaprodi' ? '#2980b9' : '#27ae60') }};">
                                    {{ ucfirst($u->role) }}
                                </span>
                            </td>
                            <td>{{ $u->kode_dosen ?? '-' }}</td>
                            <td>{{ $u->email ?? '-' }}</td>
                            <td>{{ $u->nip ?? ($u->nidn ?? '-') }}</td>
                            <td>
                                <div class="action-group">
                                    @if (auth()->user()->isAdmin() || auth()->user()->isKaprodi())
                                        <button type="button" class="btn-edit"
                                            onclick="openEditUserModal(
                                    {{ $u->id_user }},
                                    '{{ $u->username }}',
                                    '{{ addslashes($u->nama_lengkap) }}',
                                    '{{ $u->email ?? '' }}',
                                    '{{ $u->role }}',
                                    '{{ $u->kode_dosen ?? '' }}',
                                    '{{ $u->nip ?? '' }}',
                                    '{{ $u->nidn ?? '' }}'
                                )">Edit</button>

                                        <form method="POST" action="{{ route('users.reset-password', $u->id_user) }}"
                                            style="display:inline;"
                                            onsubmit="return confirm('Reset password {{ $u->username }} ke \"password\"?')">
                                            @csrf
                                            <button type="submit" class="btn-manage">Reset PW</button>
                                        </form>
                                    @endif

                                    @if (auth()->user()->isAdmin() && $u->id_user !== auth()->id())
                                        <form method="POST" action="{{ route('users.destroy', $u->id_user) }}"
                                            style="display:inline;"
                                            onsubmit="return confirm('Hapus user {{ $u->username }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-detail"
                                                style="background:#e74c3c;color:#fff;">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center;">Belum ada user.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MODAL TAMBAH USER --}}
        <div id="addUserModal" class="modal-overlay">
            <div class="edit-mk-modal" style="max-width:520px;">
                <div class="modal-header-custom edit-modal-header">
                    <h3>Tambah User</h3>
                    <button type="button" onclick="closeAddUserModal()">×</button>
                </div>
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="edit-modal-body">
                        <div class="edit-field-group">
                            <label>Username</label>
                            <input type="text" name="username" required maxlength="50" placeholder="contoh: trl">
                        </div>
                        <div class="edit-field-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" required maxlength="255">
                        </div>
                        <div class="edit-field-group">
                            <label>Email</label>
                            <input type="email" name="email" maxlength="255" placeholder="(opsional)">
                        </div>
                        <div class="edit-field-group">
                            <label>Role</label>
                            <select name="role" id="addRole" onchange="toggleKodeDosen('add')">
                                <option value="dosen wali">Dosen Wali</option>
                                <option value="kaprodi">Kaprodi</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="edit-field-group" id="addKodeDosenGroup">
                            <label>Kode Dosen (3 huruf)</label>
                            <input type="text" name="kode_dosen" maxlength="3" placeholder="TRL"
                                style="text-transform:uppercase;">
                        </div>
                        <div class="edit-field-group">
                            <label>NIP</label>
                            <input type="text" name="nip" maxlength="30" placeholder="(opsional)">
                        </div>
                        <div class="edit-field-group">
                            <label>NIDN</label>
                            <input type="text" name="nidn" maxlength="20" placeholder="(opsional)">
                        </div>
                        <div class="edit-field-group">
                            <label>Password</label>
                            <input type="password" name="password" required minlength="6">
                        </div>
                    </div>
                    <div class="modal-footer-custom modal-footer-edit">
                        <button type="button" class="btn-cancel" onclick="closeAddUserModal()">Cancel</button>
                        <button type="submit" class="btn-save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL EDIT USER --}}
        <div id="editUserModal" class="modal-overlay">
            <div class="edit-mk-modal" style="max-width:520px;">
                <div class="modal-header-custom edit-modal-header">
                    <h3>Edit User</h3>
                    <button type="button" onclick="closeEditUserModal()">×</button>
                </div>
                <form id="editUserForm" method="POST" action="">
                    @csrf @method('PUT')
                    <div class="edit-modal-body">
                        <div class="edit-field-group">
                            <label>Username</label>
                            <input type="text" id="editUsername" name="username" required maxlength="50">
                        </div>
                        <div class="edit-field-group">
                            <label>Nama Lengkap</label>
                            <input type="text" id="editNamaLengkap" name="nama_lengkap" required maxlength="255">
                        </div>
                        <div class="edit-field-group">
                            <label>Email</label>
                            <input type="email" id="editEmail" name="email" maxlength="255">
                        </div>
                        <div class="edit-field-group">
                            <label>Role</label>
                            <select id="editRole" name="role" onchange="toggleKodeDosen('edit')">
                                <option value="dosen wali">Dosen Wali</option>
                                <option value="kaprodi">Kaprodi</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="edit-field-group" id="editKodeDosenGroup">
                            <label>Kode Dosen (3 huruf)</label>
                            <input type="text" id="editKodeDosen" name="kode_dosen" maxlength="3"
                                style="text-transform:uppercase;">
                        </div>
                        <div class="edit-field-group">
                            <label>NIP</label>
                            <input type="text" id="editNip" name="nip" maxlength="30">
                        </div>
                        <div class="edit-field-group">
                            <label>NIDN</label>
                            <input type="text" id="editNidn" name="nidn" maxlength="20">
                        </div>
                    </div>
                    <div class="modal-footer-custom modal-footer-edit">
                        <button type="button" class="btn-cancel" onclick="closeEditUserModal()">Cancel</button>
                        <button type="submit" class="btn-save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function openAddUserModal() {
            document.getElementById('addUserModal').classList.add('show');
        }

        function closeAddUserModal() {
            document.getElementById('addUserModal').classList.remove('show');
        }

        function openEditUserModal(id, username, nama, email, role, kodeDosen, nip, nidn) {
            document.getElementById('editUserForm').action = '/users/' + id;
            document.getElementById('editUsername').value = username;
            document.getElementById('editNamaLengkap').value = nama;
            document.getElementById('editEmail').value = email;
            document.getElementById('editRole').value = role;
            document.getElementById('editKodeDosen').value = kodeDosen;
            document.getElementById('editNip').value = nip;
            document.getElementById('editNidn').value = nidn;
            toggleKodeDosen('edit');
            document.getElementById('editUserModal').classList.add('show');
        }

        function closeEditUserModal() {
            document.getElementById('editUserModal').classList.remove('show');
        }

        function toggleKodeDosen(prefix) {
            const role = document.getElementById(prefix + 'Role').value;
            const group = document.getElementById(prefix + 'KodeDosenGroup');
            group.style.display = role === 'dosen wali' ? 'flex' : 'none';
        }

        // Init
        toggleKodeDosen('add');
        toggleKodeDosen('edit');
    </script>
@endsection
