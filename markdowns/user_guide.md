# Panduan Pengguna COMPASS

**COMPASS** — *Computerized Automatization PLO System*
Sistem Penilaian OBE (Outcome-Based Education) untuk Program Studi S1 Sistem Informasi
Telkom University Surabaya

---

## Daftar Isi

1. [Pengenalan Sistem](#1-pengenalan-sistem)
2. [Login ke Sistem](#2-login-ke-sistem)
3. [Tampilan Utama (Dashboard)](#3-tampilan-utama-dashboard)
4. [Menu Nilai — Lihat Nilai](#4-menu-nilai--lihat-nilai)
5. [Menu Nilai — Detail Nilai PLO](#5-menu-nilai--detail-nilai-plo)
6. [Menu Nilai — Input Nilai](#6-menu-nilai--input-nilai)
7. [Menu Mata Kuliah — Lihat](#7-menu-mata-kuliah--lihat)
8. [Menu Mata Kuliah — Kelola (CRUD)](#8-menu-mata-kuliah--kelola-crud)
9. [Menu Mata Kuliah — Manage CLO & Mapping PLO](#9-menu-mata-kuliah--manage-clo--mapping-plo)
10. [Menu Kurikulum — Kelola PLO](#10-menu-kurikulum--kelola-plo)
11. [Menu Kurikulum — Assessment Tools](#11-menu-kurikulum--assessment-tools)
12. [Logout](#12-logout)
13. [Akun Bawaan (Seeder)](#13-akun-bawaan-seeder)
14. [Alur Kerja yang Direkomendasikan](#14-alur-kerja-yang-direkomendasikan)

---

## 1. Pengenalan Sistem

COMPASS membantu program studi menghitung dan memantau ketercapaian **PLO (Program Learning Outcomes)** setiap mahasiswa secara otomatis, berdasarkan nilai assessment yang telah diinput dosen.

### Konsep Utama

```
Assessment Tool  →  CLO (Course Learning Outcome)
       ↓                       ↓
   Nilai Mahasiswa     Mapping CLO ↔ PLO (dengan bobot)
                               ↓
                    Skor PLO per Mahasiswa
```

| Istilah | Penjelasan |
|---------|-----------|
| **PLO** | Program Learning Outcomes — capaian program studi secara keseluruhan |
| **CLO** | Course Learning Outcomes — capaian tiap mata kuliah |
| **Assessment Tool (AT)** | Instrumen penilaian dalam satu CLO (contoh: UTS, UAS, Tugas) |
| **Bobot AT** | Persentase kontribusi AT terhadap nilai CLO. Total bobot per CLO harus = 100% |
| **Mapping CLO–PLO** | Keterhubungan antara CLO dengan PLO disertai persentase kontribusi |

### Peran Pengguna

| Role | Hak Akses |
|------|-----------|
| **Admin** | Akses penuh ke semua fitur |
| **Kaprodi** | Akses penuh ke semua fitur |
| **Dosen Wali** | Akses lihat nilai mahasiswa bimbingannya |

---

## 2. Login ke Sistem

### Langkah Login

1. Buka browser dan akses `http://localhost:8000`
2. Halaman login akan muncul secara otomatis
3. Masukkan **Username** dan **Password**
4. Klik tombol **Login**

> **Catatan:** Login menggunakan **username**, bukan email.

### Jika Login Gagal

- Pastikan username dan password sudah benar (perhatikan huruf besar/kecil)
- Pastikan server Laravel sudah berjalan (`php artisan serve`)
- Pastikan database sudah di-migrate dan di-seed

---

## 3. Tampilan Utama (Dashboard)

Setelah login berhasil, Anda akan langsung masuk ke halaman **Dashboard**.

### Yang Terlihat di Dashboard

| Elemen | Keterangan |
|--------|-----------|
| **Total Mahasiswa** | Jumlah mahasiswa aktif yang tercatat di sistem |
| **Rata-rata Ketercapaian PLO%** | Rata-rata skor PLO keseluruhan dari semua mahasiswa |
| **Bar Chart** | Visualisasi skor per PLO dalam bentuk diagram batang |
| **Tabel Hasil PLO** | Rincian nilai rata-rata tiap PLO dalam format angka |

> Semua data dashboard bersumber langsung dari database — tidak ada data statis.

### Navigasi Sidebar

Di sebelah kiri layar terdapat sidebar dengan menu:

- **Dashboard** — Halaman utama ringkasan
- **Nilai** → *Lihat Nilai* dan *Input Nilai*
- **Mata Kuliah** → *Lihat Mata Kuliah* dan *Kelola Mata Kuliah*
- **Kurikulum** → *Kelola PLO* dan *Assessment Tools*
- **RPS** — Halaman dokumen RPS
- **Log Out** — Keluar dari sistem

---

## 4. Menu Nilai — Lihat Nilai

Halaman ini menampilkan **tabel skor PLO per mahasiswa**.

### Cara Mengakses

Sidebar → **Nilai** → **Lihat Nilai**

### Yang Terlihat

Tabel dengan kolom:
- No, NIM, Nama Mahasiswa, Kode Dosen
- Satu kolom untuk setiap PLO yang ada (PLO01, PLO02, PLO03, dst.)

Setiap sel nilai PLO adalah **link yang bisa diklik** untuk melihat detail.

### Filter Data *(coming soon)*

Akan tersedia filter berdasarkan:
- Angkatan (tahun masuk)
- Kode Dosen

---

## 5. Menu Nilai — Detail Nilai PLO

Halaman ini menampilkan **breakdown nilai satu mahasiswa untuk satu PLO tertentu**, sampai ke level Assessment Tool.

### Cara Mengakses

Dari halaman Lihat Nilai → Klik angka nilai PLO pada baris mahasiswa yang diinginkan

### Yang Terlihat

**Header:** NIM dan Nama Mahasiswa + Nama & Deskripsi PLO

**Tabel Detail:**

| Kolom | Keterangan |
|-------|-----------|
| Kode MK | Kode mata kuliah |
| Nama MK | Nama mata kuliah |
| Semester | Semester pengambilan |
| SKS | Jumlah SKS |
| Nilai CLO | Nilai akhir CLO setelah perhitungan bobot |
| Detail Nilai PLO | Nama CLO |

### Interaksi Tabel

- **Klik baris MK** → ekspansi menampilkan detail CLO
- **Klik CLO** → tampilkan/sembunyikan rincian nilai per Assessment Tool

### Contoh Perhitungan

```
CLO1 (Algo):
  UTS CLO1 = 85 × bobot 40% = 34
  UAS CLO1 = 88 × bobot 60% = 52.8
  ─────────────────────────────────
  Final CLO1 Score = 86.8

CLO1 berkontribusi ke PLO01 dengan bobot 40%
→ Kontribusi ke PLO01 = 86.8 × 40% = 34.72
```

---

## 6. Menu Nilai — Input Nilai

Halaman ini untuk **memasukkan atau memperbarui nilai mahasiswa** per Assessment Tool.

### Cara Mengakses

Sidebar → **Nilai** → **Input Nilai**

### Alur Pengisian (3 Langkah)

#### Langkah 1 — Pilih Mata Kuliah

1. Buka dropdown **Mata Kuliah**
2. Pilih mata kuliah yang ingin diisi nilainya
3. Sistem otomatis memuat daftar CLO dan Assessment Tool

#### Langkah 2 — Pilih Assessment Tool

Setelah memilih MK, akan muncul daftar AT yang dikelompokkan per CLO.

Contoh tampilan:
```
CLO1:  [UTS CLO1 (40%)]  [UAS CLO1 (60%)]
CLO2:  [TUGAS CLO2 (30%)]  [UAS CLO2 (70%)]
```

Klik salah satu tombol AT (contoh: **UTS CLO1**) untuk membuka form input nilai.

#### Langkah 3 — Input Nilai

1. Tabel menampilkan seluruh daftar mahasiswa
2. Isi nilai pada kolom **Nilai (0–100)** untuk setiap mahasiswa
3. Kolom yang sudah terisi sebelumnya akan menampilkan nilai lama (bisa diedit)
4. Biarkan kosong jika mahasiswa belum mengikuti assessment ini
5. Klik **Simpan Semua Nilai**

> **Catatan:**
> - Nilai yang sudah ada akan **diperbarui** (bukan digandakan)
> - Nilai dapat berupa desimal (contoh: 87.50)
> - Setelah menyimpan, klik **"Pilih AT lain"** untuk mengisi AT berikutnya

---

## 7. Menu Mata Kuliah — Lihat

Halaman ini menampilkan **daftar semua mata kuliah** dalam format tabel baca-saja.

### Cara Mengakses

Sidebar → **Mata Kuliah** → **Lihat Mata Kuliah**

### Yang Terlihat

| Kolom | Keterangan |
|-------|-----------|
| No | Nomor urut |
| Kode Mata Kuliah | Kode unik MK (contoh: BBK1AAB4) |
| Nama Mata Kuliah | Nama lengkap MK |
| Program Studi | S1 Sistem Informasi - Kampus Surabaya |
| Semester | Semester pengambilan MK |
| Tahun Kurikulum | Tahun kurikulum berlaku |

### Filter dan Pencarian

- Ketik di kolom **Search** lalu tekan Enter untuk mencari berdasarkan kode atau nama MK

---

## 8. Menu Mata Kuliah — Kelola (CRUD)

Halaman ini untuk **menambah, mengedit, dan menghapus mata kuliah**.

### Cara Mengakses

Sidebar → **Mata Kuliah** → **Kelola Mata Kuliah**

### Filter Data

Gunakan dropdown **Kurikulum** dan/atau field **Search** lalu klik **Apply**.

---

### Tambah Mata Kuliah Baru

1. Klik tombol **+ Tambah Mata Kuliah**
2. Isi form yang muncul:

   | Field | Keterangan | Contoh |
   |-------|-----------|--------|
   | Kode Mata Kuliah | Kode unik, maks 20 karakter | `BBK1AAB4` |
   | Nama Mata Kuliah | Nama lengkap, maks 255 karakter | `ALGORITMA DAN PEMROGRAMAN` |
   | SKS | Jumlah SKS (1–6) | `4` |
   | Semester | Semester ke- (1–8) | `1` |
   | Tahun Kurikulum | Tahun kurikulum | `2024` |

3. Klik **Simpan**

---

### Edit Mata Kuliah

1. Klik tombol **Edit** pada baris MK yang ingin diubah
2. Ubah data yang diperlukan
3. Klik **Simpan**

---

### Hapus Mata Kuliah

1. Klik tombol **Hapus** (merah) pada baris MK yang ingin dihapus
2. Konfirmasi penghapusan pada dialog yang muncul

> ⚠ **Perhatian:** Menghapus MK akan menghapus semua CLO, Assessment Tool, dan data nilai yang terkait dengan MK tersebut secara berantai.

---

### Manage PLO (dari tabel MK)

Klik tombol **Manage PLO** pada baris MK untuk langsung masuk ke halaman pengelolaan CLO dan mapping PLO untuk MK tersebut.

---

## 9. Menu Mata Kuliah — Manage CLO & Mapping PLO

Halaman ini untuk **mengelola CLO per mata kuliah** dan **memetakan CLO ke PLO** beserta bobotnya.

### Cara Mengakses

- Sidebar → **Mata Kuliah** → **Kelola Mata Kuliah** → klik **Manage PLO**, ATAU
- Sidebar → **Mata Kuliah** → **Kelola Mata Kuliah** dan pilih MK dari dropdown

### Langkah Pemilihan MK

1. Pilih **Mata Kuliah** dari dropdown di bagian atas
2. Halaman otomatis memuat daftar CLO untuk MK tersebut

---

### Tambah CLO Baru

1. Klik **+ Tambah CLO**
2. Isi form:

   | Field | Keterangan | Contoh |
   |-------|-----------|--------|
   | Nama CLO | Identifier CLO, maks 20 karakter | `CLO1` |
   | Deskripsi CLO | Deskripsi kemampuan yang diharapkan | `Mahasiswa mampu memahami konsep dasar algoritma` |

3. Klik **Simpan**

---

### Edit & Hapus CLO

- Klik **Edit** untuk mengubah nama atau deskripsi CLO
- Klik **Hapus** untuk menghapus CLO

> ⚠ Menghapus CLO akan menghapus semua Assessment Tool dan nilai yang terkait.

---

### Tambah Mapping CLO → PLO

Setiap CLO dapat dipetakan ke satu atau lebih PLO dengan bobot tertentu.

1. Pada baris CLO, klik tombol hijau **+ PLO**
2. Isi form:

   | Field | Keterangan |
   |-------|-----------|
   | CLO | Terisi otomatis |
   | PLO | Pilih PLO yang akan dihubungkan |
   | Bobot (%) | Persentase kontribusi CLO terhadap PLO ini |

3. Klik **Simpan**

**Contoh mapping yang benar:**
```
CLO1 (Algo) → PLO01 dengan bobot 40%
CLO1 (Algo) → PLO02 dengan bobot 60%
```
> Satu CLO bisa berkontribusi ke beberapa PLO sekaligus.

---

### Hapus Mapping CLO → PLO

Klik tanda **×** pada badge PLO di baris CLO yang ingin dihapus mapping-nya.

---

## 10. Menu Kurikulum — Kelola PLO

Halaman ini untuk **mengelola daftar Program Learning Outcomes (PLO)** secara global.

### Cara Mengakses

Sidebar → **Kurikulum** → **Kelola PLO**

### Yang Terlihat

| Kolom | Keterangan |
|-------|-----------|
| No | Nomor urut |
| Nama PLO | Kode PLO (contoh: PLO01) |
| Deskripsi | Deskripsi lengkap capaian |
| CLO Terkait | Jumlah CLO yang dipetakan ke PLO ini |
| Aksi | Edit / Hapus |

---

### Tambah PLO Baru

1. Klik **+ Tambah PLO**
2. Isi form:

   | Field | Keterangan | Contoh |
   |-------|-----------|--------|
   | Nama PLO | Kode PLO, maks 10 karakter | `PLO04` |
   | Deskripsi PLO | Deskripsi kemampuan, maks 1000 karakter | `Mampu menerapkan pemikiran logis...` |

3. Klik **Simpan**

---

### Edit & Hapus PLO

- Klik **Edit** untuk mengubah nama atau deskripsi PLO
- Klik **Hapus** untuk menghapus PLO

> ⚠ Menghapus PLO akan menghapus semua mapping CLO–PLO yang terkait. Skor PLO mahasiswa tidak lagi terhitung untuk PLO ini.

---

## 11. Menu Kurikulum — Assessment Tools

Halaman ini untuk **mengelola daftar Assessment Tool per CLO** beserta bobotnya.

### Cara Mengakses

Sidebar → **Kurikulum** → **Assessment Tools**

### Langkah Pemilihan MK

1. Pilih **Mata Kuliah** dari dropdown
2. Sistem memuat semua CLO beserta AT-nya

### Yang Terlihat per CLO

```
CLO1 — "Mahasiswa mampu memahami konsep dasar..."    Total Bobot: 100% ✓
┌────────────────────────────────────────────────────┐
│  No  │  Nama Assessment Tool  │  Bobot dalam CLO  │
│  1   │  UTS CLO1              │  40%              │
│  2   │  UAS CLO1              │  60%              │
└────────────────────────────────────────────────────┘
```

> **Indikator Bobot:** Badge hijau (✓) jika total = 100%, kuning (⚠) jika belum 100%.

---

### Tambah Assessment Tool

1. Klik **+ Tambah AT** di samping nama CLO yang diinginkan
2. Isi form:

   | Field | Keterangan | Contoh |
   |-------|-----------|--------|
   | CLO | Terisi otomatis | CLO1 |
   | Nama Assessment Tool | Nama instrumen penilaian | `UTS`, `UAS`, `TUGAS`, `QUIZ` |
   | Bobot dalam CLO (%) | Kontribusi AT terhadap nilai CLO | `40` |

3. Klik **Simpan**

> **Aturan Bobot:** Jumlah semua bobot AT dalam satu CLO **harus = 100%**.
> Contoh benar: UTS 40% + UAS 60% = 100% ✓

---

### Edit & Hapus Assessment Tool

- Klik **Edit** untuk mengubah nama atau bobot AT
- Klik **Hapus** untuk menghapus AT

> ⚠ Menghapus AT akan menghapus semua data nilai mahasiswa untuk AT tersebut.

---

## 12. Logout

### Cara Logout

1. Di sidebar paling bawah, klik **⏻ Log Out**
2. Session akan dihapus dan Anda diarahkan kembali ke halaman login

---

## 13. Akun Bawaan (Seeder)

Sistem sudah menyediakan akun demo untuk keperluan pengujian:

| Role | Username | Password | Keterangan |
|------|----------|----------|-----------|
| Admin | `admin` | `password` | Akses penuh |
| Kaprodi | `kaprodi` | `password` | Dr. Berlian Rahmy Lidiawaty |
| Dosen Wali | `trl` | `password` | Dr. Tri Lathif — membimbing 3 mahasiswa |
| Dosen Wali | `raf` | `password` | Rafi Ahmad Fauzan — membimbing 2 mahasiswa |

### Data Mahasiswa Demo

| NIM | Nama | Dosen Wali |
|-----|------|-----------|
| 1301224001 | Andi Pratama | TRL |
| 1301224002 | Bella Sari Dewi | TRL |
| 1301224003 | Chandra Wijaya | TRL |
| 1301224004 | Diana Putri Utami | RAF |
| 1301224005 | Eko Saputra | RAF |

### Mata Kuliah Demo

| Kode | Nama | SKS | Sem |
|------|------|-----|-----|
| BBK1AAB4 | Algoritma dan Pemrograman | 4 | 1 |
| BBK1JAB3 | Sistem Basis Data | 3 | 2 |
| BBK1BAB3 | Matematika Diskrit | 3 | 1 |

### PLO Demo

| PLO | Ringkasan |
|-----|-----------|
| PLO01 | Mampu menganalisis permasalahan infokom yang kompleks |
| PLO02 | Mampu merancang dan mengimplementasikan solusi berbasis SI |
| PLO03 | Mampu bekerja kolaboratif dalam tim multidisiplin |

---

## 14. Alur Kerja yang Direkomendasikan

Berikut urutan penggunaan sistem yang disarankan ketika memulai dari awal:

### Tahap 1 — Setup Kurikulum

```
1. Masuk sebagai Admin atau Kaprodi
2. Buka Menu Kurikulum → Kelola PLO
3. Tambahkan semua PLO program studi (PLO01 s.d. PLO-N)
```

### Tahap 2 — Setup Mata Kuliah

```
4. Buka Menu Mata Kuliah → Kelola Mata Kuliah
5. Tambahkan semua mata kuliah yang ada
```

### Tahap 3 — Setup CLO dan Mapping PLO

```
6. Dari halaman Kelola Mata Kuliah, klik Manage PLO pada setiap MK
7. Tambahkan CLO untuk setiap MK
8. Untuk setiap CLO, tambahkan mapping ke PLO yang sesuai beserta bobotnya
```

### Tahap 4 — Setup Assessment Tools

```
9. Buka Menu Kurikulum → Assessment Tools
10. Pilih MK
11. Untuk setiap CLO, tambahkan AT (UTS, UAS, dll.) beserta bobotnya
    ⚠ Pastikan total bobot per CLO = 100%
```

### Tahap 5 — Input Nilai

```
12. Buka Menu Nilai → Input Nilai
13. Pilih MK → Pilih AT → Input nilai per mahasiswa
14. Ulangi untuk semua AT
```

### Tahap 6 — Pantau Hasil

```
15. Buka Menu Nilai → Lihat Nilai
    → Tampil tabel skor PLO per mahasiswa (dihitung otomatis)
16. Klik angka PLO untuk melihat detail breakdown per CLO dan AT
17. Buka Dashboard untuk melihat ringkasan rata-rata seluruh angkatan
```

---

> **Versi Dokumen:** 1.0 — Juni 2026
> **Sistem:** COMPASS v1.0 — Laravel 12, Bootstrap 5.3
> **Hubungi:** Tim Pengembang Program Studi S1 Sistem Informasi, Telkom University Surabaya
