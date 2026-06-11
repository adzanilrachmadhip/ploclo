<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Mahasiswa::with('dosenWali');

        if ($request->filled('angkatan')) {
            $query->where('tahun_masuk', $request->angkatan);
        }
        if ($request->filled('kode_dosen')) {
            $query->where('kode_dosen', $request->kode_dosen);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('nim', 'like', "%{$s}%")->orWhere('nama', 'like', "%{$s}%"));
        }

        $mahasiswas  = $query->orderBy('nama')->get();
        $angkatanList = Mahasiswa::select('tahun_masuk')->distinct()->orderBy('tahun_masuk', 'desc')->pluck('tahun_masuk');
        $dosenList    = User::where('role', 'dosen wali')->whereNotNull('kode_dosen')->orderBy('kode_dosen')->get(['id_user', 'kode_dosen', 'nama_lengkap']);

        return view('mahasiswa.index_nw', compact('mahasiswas', 'angkatanList', 'dosenList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim'         => 'required|string|max:20|unique:mahasiswa,nim',
            'nama'        => 'required|string|max:255',
            'tahun_masuk' => 'required|integer|min:2000|max:2100',
            'class_code'  => 'nullable|string|max:20',
            'status'      => 'required|in:Aktif,Cuti,Lulus,DO',
            'kode_dosen'  => 'nullable|string|size:3|exists:users,kode_dosen',
        ]);

        Mahasiswa::create($validated);
        return back()->with('success', "Mahasiswa '{$validated['nama']}' berhasil ditambahkan.");
    }

    public function update(Request $request, int $id)
    {
        $mhs = Mahasiswa::findOrFail($id);

        $validated = $request->validate([
            'nim'         => "required|string|max:20|unique:mahasiswa,nim,{$id},id_mahasiswa",
            'nama'        => 'required|string|max:255',
            'tahun_masuk' => 'required|integer|min:2000|max:2100',
            'class_code'  => 'nullable|string|max:20',
            'status'      => 'required|in:Aktif,Cuti,Lulus,DO',
            'kode_dosen'  => 'nullable|string|size:3|exists:users,kode_dosen',
        ]);

        $mhs->update($validated);
        return back()->with('success', "Mahasiswa '{$mhs->nama}' berhasil diperbarui.");
    }

    public function destroy(int $id)
    {
        $mhs  = Mahasiswa::findOrFail($id);
        $nama = $mhs->nama;
        $mhs->delete();
        return back()->with('success', "Mahasiswa '{$nama}' berhasil dihapus.");
    }
}
