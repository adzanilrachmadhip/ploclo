<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('role')->orderBy('nama_lengkap')->get();
        return view('user.index_nw', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username'     => 'required|string|max:50|unique:users,username',
            'nama_lengkap' => 'required|string|max:255',
            'email'        => 'nullable|email|max:255|unique:users,email',
            'role'         => 'required|in:admin,kaprodi,dosen wali',
            'kode_dosen'   => 'nullable|string|size:3|unique:users,kode_dosen',
            'nip'          => 'nullable|string|max:30',
            'nidn'         => 'nullable|string|max:20',
            'password'     => 'required|string|min:6',
        ]);

        User::create([
            'username'     => $validated['username'],
            'name'         => $validated['nama_lengkap'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'email'        => $validated['email'] ?? null,
            'role'         => $validated['role'],
            'kode_dosen'   => $validated['role'] === 'dosen wali' ? strtoupper($validated['kode_dosen'] ?? '') : null,
            'nip'          => $validated['nip'] ?? null,
            'nidn'         => $validated['nidn'] ?? null,
            'password'     => Hash::make($validated['password']),
        ]);

        return back()->with('success', "User '{$validated['username']}' berhasil ditambahkan.");
    }

    public function update(Request $request, int $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'username'     => "required|string|max:50|unique:users,username,{$id},id_user",
            'nama_lengkap' => 'required|string|max:255',
            'email'        => "nullable|email|max:255|unique:users,email,{$id},id_user",
            'role'         => 'required|in:admin,kaprodi,dosen wali',
            'kode_dosen'   => "nullable|string|size:3|unique:users,kode_dosen,{$id},id_user",
            'nip'          => 'nullable|string|max:30',
            'nidn'         => 'nullable|string|max:20',
        ]);

        $newRole      = $validated['role'];
        $oldKodeDosen = $user->kode_dosen;
        $newKodeDosen = $newRole === 'dosen wali'
            ? strtoupper($validated['kode_dosen'] ?? '')
            : null;

        // Cek kaprodi aktif — hanya boleh ada 1
        if ($newRole === 'kaprodi') {
            $existingKaprodi = User::where('role', 'kaprodi')
                                   ->where('id_user', '!=', $id)
                                   ->first();
            if ($existingKaprodi) {
                return back()->with(
                    'error',
                    "Terdapat kaprodi aktif ({$existingKaprodi->nama_lengkap}). Nonaktifkan kaprodi lama terlebih dahulu."
                );
            }
        }

        DB::transaction(function () use ($user, $validated, $newRole, $newKodeDosen, $oldKodeDosen) {
            // Jika kode_dosen akan di-null dan ada mahasiswa yang masih referencing,
            // putus relasi mahasiswa dulu agar FK tidak error
            if ($oldKodeDosen && $newKodeDosen === null) {
                Mahasiswa::where('kode_dosen', $oldKodeDosen)
                         ->update(['kode_dosen' => null]);
            }

            $user->update([
                'username'     => $validated['username'],
                'name'         => $validated['nama_lengkap'],
                'nama_lengkap' => $validated['nama_lengkap'],
                'email'        => $validated['email'] ?? null,
                'role'         => $newRole,
                'kode_dosen'   => $newKodeDosen,
                'nip'          => $validated['nip'] ?? null,
                'nidn'         => $validated['nidn'] ?? null,
            ]);
        });

        $extra = ($oldKodeDosen && $newKodeDosen === null)
            ? ' Mahasiswa yang sebelumnya dibimbing telah dilepas dari dosen ini.'
            : '';

        return back()->with('success', "{$user->nama_lengkap} berhasil diperbarui.{$extra}");
    }

    public function resetPassword(int $id)
    {
        $user = User::findOrFail($id);
        $user->update(['password' => Hash::make('password')]);
        return back()->with('success', "Password '{$user->username}' direset ke: password");
    }

    public function destroy(int $id)
    {
        $user = User::findOrFail($id);

        if ($user->id_user === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun yang sedang digunakan.');
        }

        $username = $user->username;
        $user->delete();
        return back()->with('success', "User '{$username}' berhasil dihapus.");
    }
}
