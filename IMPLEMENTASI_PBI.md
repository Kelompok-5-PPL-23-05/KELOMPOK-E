# 📚 Fitur: Pilih Mata Pelajaran dan Kelola Data Siswa

## ✅ Implementasi Selesai

### 1. Database Changes
- **Migration**: `2026_04_18_000008_create_guru_mata_pelajaran_table.php`
  - Tabel pivot untuk relasi many-to-many antara Guru dan MataPelajaran
  - Kolom: `id`, `guru_id`, `mapel_id`, `timestamps`
  - Foreign keys ke tabel `guru` dan `mata_pelajaran`

### 2. Model Updates
- **Guru Model**: Added `mataPelajaran()` relationship (many-to-many)
- **MataPelajaran Model**: Added `guru()` relationship (many-to-many)

### 3. Controller Methods (DashboardController)
```
- selectMapel()           : Tampilkan form pilih mata pelajaran
- storeMapel()            : Simpan pilihan mata pelajaran
- manageStudents()        : Tampilkan siswa per mata pelajaran
```

### 4. Routes Added
```
GET  /dashboard/select-mapel              → selectMapel()
POST /dashboard/store-mapel               → storeMapel()
GET  /dashboard/manage-students           → manageStudents()
```

### 5. Views Created
- **dashboard-select-mapel.blade.php**: Form checkbox untuk memilih mata pelajaran
- **dashboard-manage-students.blade.php**: Tampilkan daftar siswa berdasarkan mapel & kelas

### 6. Database Seeder
- Guru1 secara otomatis diampu dengan "Bahasa Indonesia" dan "Matematika"
- Relasi many-to-many dibuat saat seeding

### 7. UI Update
- Dashboard sidebar updated dengan links baru:
  - ⚙️ Pilih Mata Pelajaran
  - 👥 Kelola Siswa
  - Daftar mata pelajaran yang diampu

## 🚀 Cara Menggunakan

### Login sebagai Guru
1. Username: `Guru1`
2. Password: `Guru123`

### Pilih Mata Pelajaran yang Diampu
1. Di dashboard, klik "Mata Pelajaran" → "⚙️ Pilih Mata Pelajaran"
2. Centang mata pelajaran yang ingin diampu
3. Klik "Simpan Pilihan"

### Kelola Data Siswa
1. Di dashboard, klik "Mata Pelajaran" → "👥 Kelola Siswa"
2. Pilih Mata Pelajaran dari dropdown
3. Pilih Kelas dari dropdown
4. Lihat daftar siswa di kelas tersebut

## 📊 Data Seeder Default
**Guru Tersedia:**
- Guru1 (diampu: Bahasa Indonesia, Matematika)

**Mata Pelajaran:**
- Bahasa Indonesia
- Bahasa Inggris
- Matematika

**Kelas:**
- Paket A Kelas 3
- Paket B Kelas 1
- Paket C Kelas 2

**Siswa (di Paket A Kelas 3):**
- Agus Setiawan
- Budi Santoso
- Citra Lestari

## 🔒 Security Features
- Guru hanya bisa lihat mata pelajaran yang mereka ampu
- Validasi di controller untuk mencegah akses unauthorized
- Authorization check di `manageStudents()` method

## 📝 Custom Artisan Commands
```bash
# Drop semua tables (gunakan jika FK constraint error)
php artisan db:drop-all

# Migrate dengan FK checks disabled
php artisan migrate:refresh-noFK
```

## 🎯 Flow Lengkap
1. Guru login → Dashboard
2. Sidebar → Mata Pelajaran → Pilih Mata Pelajaran
3. Centang mata pelajaran, simpan
4. Kembali ke sidebar → Mata Pelajaran → Kelola Siswa
5. Pilih mapel & kelas → Lihat daftar siswa
6. (Future) Input nilai, absensi, dll
