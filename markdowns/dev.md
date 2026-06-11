# COMPASS — Development Guide

> Dokumen ini ditulis untuk AI / developer yang melanjutkan pekerjaan ini.
> Baca seluruh file ini sebelum menyentuh kode.

---

## 1. Konteks Proyek

**COMPASS** (Computarized Automatization PLO System) adalah sistem penilaian OBE (Outcome-Based Education) untuk Program Studi S1 Sistem Informasi Telkom University Surabaya.

Sistem ini menghitung dan memantau ketercapaian **PLO (Program Learning Outcomes)** per mahasiswa, berdasarkan nilai assessment tools yang dipetakan ke CLO → PLO.

**Repo:** `adzanilrachmadhip/ploclo`

---

## 2. Struktur Branch

| Branch | Isi | Status |
|--------|-----|--------|
| `main` | Monorepo lama (folder `backend_sistem/` + `frontend_sistem/`) | Sumber awal, jangan diubah |
| `back-end` | Laravel 12 full-stack (Blade views + API) | **Aktif dikerjakan** |
| `front-end` | Vite vanilla JS (hanya login page placeholder) | Belum dikembangkan |

Working directory: `back-end` branch di `/Applications/XAMPP/xamppfiles/htdocs/laravel/ploclo/`

---

## 3. Tech Stack

| Layer | Teknologi |
|-------|-----------|
| Framework | Laravel 12 |
| PHP | ^8.2 |
| Auth | Session-based (`auth` middleware) + JWT untuk API |
| Database | MySQL (XAMPP) / SQLite (dev) |
| Frontend render | Blade + Bootstrap 5.3 |
| Build tool | Vite |
| JWT | `firebase/php-jwt ^6.10` — **wajib `composer install` dulu** |

---

## 4. Setup Lokal

```bash
cd /Applications/XAMPP/xamppfiles/htdocs/laravel/ploclo

composer install           # install firebase/php-jwt dan semua dependencies
cp .env.example .env
php artisan key:generate

# Edit .env: DB_DATABASE, DB_USERNAME, DB_PASSWORD, JWT_SECRET

php artisan migrate
npm install && npm run build
php artisan serve
```

---

## 5. Struktur File Penting

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/JwtAuthController.php   JWT login/logout/me
│   │   ├── HomeController.php           Dashboard (auth protected)
│   │   ├── LoginController.php          Session login/logout
│   │   ├── NilaiController.php          Tabel & detail nilai PLO
│   │   └── DataAkademikController.php   Belum terhubung ke routes
│   └── Middleware/
│       ├── Authenticate.php             Redirect ke login.form
│       ├── JwtMiddleware.php            Validasi Bearer token
│       └── RoleMiddleware.php           Cek role user
├── Models/
│   ├── User.php           PK: id_user, kolom: username, role, kode_dosen
│   ├── Plo.php            table: data_plo
│   ├── Clo.php            table: data_clo
│   ├── MataKuliah.php     table: mata_kuliah
│   ├── AssessmentTool.php table: assessment_tools
│   ├── Mahasiswa.php      table: mahasiswa
│   ├── NilaiMahasiswa.php table: nilai_mahasiswa
│   └── DataAkademik.php   table: data_akademik (belum ada migration)
└── Services/
    └── PloCalculationService.php   Inti kalkulasi PLO/CLO

resources/
├── css/
│   ├── compass_nw.css      Global layout (sidebar, header, wrapper)
│   ├── login.css           Halaman login
│   ├── dashboard.css       Stat cards, bar chart, PLO table
│   ├── mata_kuliah.css     Semua halaman mata kuliah + modals
│   ├── nilai.css           Tabel nilai mahasiswa
│   └── nilai_detail.css    Detail nilai per PLO/CLO
└── views/
    ├── layout/app_nw.blade.php       Layout utama (sidebar + header)
    ├── layout/guest_nw.blade.php     Layout tanpa auth (login)
    ├── components/sidebar_nw.blade.php
    ├── components/header_nw.blade.php
    ├── auth/login_nw.blade.php
    ├── dashboard/index_nw.blade.php
    ├── nilai/index_nw.blade.php
    ├── nilai/show_nw.blade.php
    ├── mata-kuliah/index.blade.php          Kelola MK
    ├── mata-kuliah/lihat_nw.blade.php       Lihat MK
    ├── mata-kuliah/manage_plo_nw.blade.php  Manage PLO per MK
    ├── rps/index_nw.blade.php
    └── 404.blade.php
```

---

## 6. Skema Database

```
users           id_user | username | name | nama_lengkap | nip | nidn
                kode_dosen (3 char) | role | email | password

data_plo        id_plo | nama_plo (max 10, e.g. "PLO01") | description_plo

mata_kuliah     id_mk | kode_mk | nama_matakuliah | sks | semester | tahun_kurikulum

data_clo        id_clo | id_mk (FK) | nama_clo | description_clo

assessment_tools  id_at | id_clo (FK) | nama_at | weight_in_clo (decimal 5,2)

mahasiswa       id_mahasiswa | nim | nama | tahun_masuk | class_code
                status (Aktif/Cuti/Lulus/DO) | kode_dosen (FK → users.kode_dosen)

nilai_mahasiswa id_nilai | id_mahasiswa (FK) | id_at (FK) | score (decimal 5,2)

pivot_clo_plo   id_pivot | id_clo (FK) | id_plo (FK) | percentage_weight (decimal 5,2)
```

### Alur Kalkulasi PLO
```
nilai_mahasiswa.score × assessment_tools.weight_in_clo
    → weighted sum per CLO → final_clo_score
    → rata-rata CLO yang dipetakan ke PLO → final_plo_score
```
Lihat `app/Services/PloCalculationService.php::calculate(int $idMahasiswa)`.

---

## 7. Routes Lengkap

```
GET  /login               LoginController@showLogin       (guest)
POST /login               LoginController@handleLogin     (guest)
POST /logout              LoginController@logout          (auth)

GET  /                    HomeController@index            (auth)
GET  /dashboard           HomeController@index            (auth)
GET  /nilai               NilaiController@index           (auth)
GET  /nilai/{id}/plo/{plo}  NilaiController@show          (auth)
GET  /mata-kuliah          view: mata-kuliah.index         (auth)
GET  /mata-kuliah/lihat    view: mata-kuliah.lihat_nw      (auth)
GET  /mata-kuliah/manage-plo  view: manage_plo_nw         (auth)
GET  /rps                 view: rps.index_nw              (auth)

POST /api/login           JwtAuthController@login         (public)
GET  /api/user            JwtAuthController@me            (jwt.auth)
POST /api/logout          JwtAuthController@logout        (jwt.auth)
GET  /api/admin-only      ...                             (jwt.auth + role:admin)
GET  /api/kaprodi-only    ...                             (jwt.auth + role:kaprodi)
```

---

## 8. Cross-Check: View vs Kebutuhan Fitur

### Sudah Selesai dan Fungsional
| Fitur | File | Keterangan |
|-------|------|-----------|
| Login session-based | `auth/login_nw` + `LoginController` | Autentikasi via `username` |
| Logout | `sidebar_nw` + `LoginController@logout` | Session invalidate |
| Redirect unauthenticated | `Authenticate.php` | Ke `route('login.form')` |
| Nilai mahasiswa per PLO | `nilai/index_nw` + `NilaiController@index` | Data real dari DB |
| Detail nilai PLO/CLO | `nilai/show_nw` + `NilaiController@show` | Drill-down per mahasiswa |
| PLO Calculation Engine | `PloCalculationService::calculate()` | Weighted avg CLO → PLO |
| JWT API endpoints | `Auth/JwtAuthController` | Login, me, logout |
| Role middleware | `RoleMiddleware` | Siap pakai, belum dikaitkan ke view |
| Sidebar + active state | `components/sidebar_nw` | Deteksi route aktif otomatis |

### View Ada Tapi Data Masih Statis
| Fitur | File | Yang Perlu Dikerjakan |
|-------|------|----------------------|
| Dashboard | `dashboard/index_nw` | PLO data hardcoded di `HomeController`. Perlu query real: `Plo::all()`, avg score per PLO |
| Kelola Mata Kuliah | `mata-kuliah/index` | `$matkul` hardcoded di view. Perlu `MataKuliahController` + CRUD |
| Lihat Mata Kuliah | `mata-kuliah/lihat_nw` | `$data` hardcoded. Perlu `MataKuliah::all()` |
| Manage PLO per MK | `mata-kuliah/manage_plo_nw` | Seluruh statis. Perlu query `pivot_clo_plo` + attach/detach |
| RPS | `rps/index_nw` | Data hardcoded. Perlu kolom/tabel untuk dokumen RPS |

### Belum Ada (perlu dibuat dari awal)
| Fitur | Prioritas | Keterangan |
|-------|-----------|-----------|
| DatabaseSeeder (data dummy) | **Tinggi** | Wajib untuk bisa test fitur nilai |
| Dashboard dinamis | Tinggi | Hitung avg PLO dari semua mahasiswa |
| CRUD Mata Kuliah | Tinggi | Form tambah/edit/hapus MK |
| CRUD Assessment Tools | Tinggi | Input nama AT + bobot per CLO |
| Input / import Nilai Mahasiswa | Tinggi | Form atau Excel import untuk `nilai_mahasiswa` |
| CRUD PLO & CLO | Sedang | Halaman admin kelola PLO, CLO, pemetaan |
| Manajemen User | Sedang | CRUD user + role assignment |
| Filter dinamis halaman Nilai | Sedang | Filter by angkatan/kode_dosen query ke DB |
| `data_akademik` migration | Sedang | Model ada, migration belum dibuat |
| Upload dokumen RPS | Rendah | File upload, simpan path di DB |
| Foto profil user | Rendah | Sidebar saat ini tampilkan div kosong |
| Notifikasi header | Rendah | Angka "3" hardcoded di `header_nw` |

---

## 9. Hal-hal Penting yang Harus Diingat

**User PK adalah `id_user` bukan `id`**
Semua `Auth::loginUsingId()` dan relasi harus pakai `id_user`.

**`kode_dosen` adalah natural key penghubung mahasiswa ↔ user**
Relasi `mahasiswa.kode_dosen` → `users.kode_dosen` (bukan via id). Desain ini dari SistemPLO lama.

**`firebase/php-jwt` wajib diinstall**
`JwtAuthController` dan `JwtMiddleware` akan `ClassNotFoundException` sebelum `composer install` dijalankan.

**Dua migration dengan timestamp identik**
`2026_05_21_115522_create_assessment_tools_table.php` dan `...create_mahasiswas_table.php` punya timestamp sama. Jika urutan jadi masalah, rename timestamp salah satu.

**`DataAkademik` model belum ada migration**
Buat migration untuk tabel `data_akademik` jika fitur ini diaktifkan.

**Vite harus di-build dulu**
Semua halaman pakai `@vite('resources/css/...')`. Jalankan `npm run build` atau `npm run dev`.

---

## 10. Alur Pengerjaan Selanjutnya (Recommended)

```
1. [SETUP]      composer install + migrate + .env (DB + JWT_SECRET)
2. [SEEDER]     Buat DatabaseSeeder: 1 user admin, 3 PLO, 3 MK, CLO, AT, 5 mahasiswa, nilai
3. [TEST]       Akses /nilai untuk verify PloCalculationService bekerja dengan data real
4. [DASHBOARD]  Update HomeController: Plo::all() + hitung avg PLO dari semua mahasiswa
5. [MK-CRUD]    Buat MataKuliahController (index/store/update/destroy) + update routes
6. [PLO-CRUD]   Buat PloController + halaman manage PLO/CLO
7. [AT-CRUD]    Buat AssessmentToolController + form per CLO
8. [NILAI-INPUT] Form input nilai per mahasiswa per AT, atau Excel import
9. [ROLE-UI]    Tambah @if(auth()->user()->isAdmin()) di view untuk conditional UI
10. [DATA-AKD]  Buat migration data_akademik + hubungkan ke filter halaman Nilai
```

---

## 11. Front-end Branch (Vite SPA)

Saat ini branch `front-end` hanya berisi:
- `src/pages/login.html` — form login statis, belum hit API
- `src/js/login.js` — hanya `alert()`, belum integrasi JWT

Jika akan dikembangkan sebagai SPA, perlu:
- Hit `POST /api/login` → simpan `access_token` di `localStorage`
- Kirim `Authorization: Bearer <token>` di setiap request
- Tambah endpoint API: `/api/nilai`, `/api/mata-kuliah`, dll. di back-end
- Pilih framework: vanilla JS, Vue, atau React

---

## 12. Environment Variables

```env
APP_NAME=COMPASS
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=compass_db
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

JWT_SECRET=isi-dengan-random-string-minimal-32-karakter
```

---

## 13. Git Workflow

```bash
git checkout back-end      # selalu kerja di sini
git add <file-spesifik>
git commit -m "deskripsi singkat"
git push origin back-end
```

Jangan push ke `main` — branch `main` hanya referensi sumber awal.
