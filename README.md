# ✈️ VOLO Flight Booking System

Project Aplikasi Pemesanan Tiket Pesawat berbasis Web (PHP Native & MySQL) untuk tugas kuliah Semester 3.
Mengusung tema **"Aero-Glass"** dengan antarmuka modern dan responsif.

## 👥 Tim Pengembang

| Role | Tanggung Jawab | Nama Anggota |
| :--- | :--- | :--- |
| **Core Logic (Lead)** | Alur Booking, Session, Search Logic | **Yasin** |
| **Frontend & Assets** | UI/UX, CSS, Responsive, Asset Management | *(Nama Teman 1)* |
| **Admin & Database** | CRUD Rute, Manajemen User, Laporan | *(Nama Teman 2)* |

## 📂 Struktur Folder Project

Pastikan meletakkan file sesuai tempatnya agar tidak error:

```text
/volo
├── /admin             # Halaman khusus Admin (CRUD Rute, dll)
├── /assets
│   ├── /css           # File style.css simpan di sini
│   ├── /images        # Banner, Logo, Icon simpan di sini
│   └── /js            # Script Javascript (jika ada)
├── /config
│   └── koneksi.php    # Konfigurasi database
├── index.php          # Landing Page
├── login.php          # Halaman Login
├── dashboard.php      # Halaman Utama User (Cari Tiket)
├── search.php         # Halaman Hasil Pencarian
└── README.md          # Dokumentasi ini
```

## 🚀 Cara Instalasi (Untuk Anggota Tim)
**Clone Repo ini: Buka terminal/Git Bash di folder htdocs kalian.**

```bash

git clone [https://github.com/username-kalian/volo-project.git](https://github.com/username-kalian/volo-project.git)
```

### Setup Database:

1. Buka XAMPP, nyalakan Apache & MySQL.

2. Buka localhost/phpmyadmin.

3. Buat database baru bernama volo_db.

4. Import file volo_db.sql (Minta file ini ke Admin Database).

5. Cek Koneksi: Pastikan file config/koneksi.php sudah sesuai dengan settingan XAMPP kalian (biasanya password kosong).

6. Jalankan: Buka browser dan akses localhost/volo-project.

### 🛠️ Panduan Git (PENTING!)
**Agar codingan kita tidak bentrok/hilang, ikuti aturan ini:**
***Remote Ke repo dulu kalau belum***
```Bash

git remote add origin https://github.com/Hyphen-14/VOLO
```
1. Sebelum Mulai Coding (Wajib!)
Selalu tarik update terbaru dari teman lain sebelum kalian mengubah satu baris kode pun.

```bash

git pull origin main
```
2. Cek Status File
Lihat file mana saja yang sudah kalian ubah.

```Bash

git status
```
3. Upload Perubahan (Save & Upload)
Lakukan ini setelah fitur yang kalian kerjakan selesai.
**Buat Branch baru**
```Bash

git branch [nama branch]
git checkout [nama branch]
git checkout -b [nama branch] #kalau branch belum dibuat samasekali
```

**Membuat commit**
```Bash

# Tandai semua file yang berubah
git add .

# Beri pesan yang JELAS (Jangan cuma "update")
git commit -m "Menambahkan fitur login admin"

# Kirim ke GitHub
git push -u origin [nama branch kalian]
```

### ⚠️ Jika Terjadi Konflik (Merge Conflict)
**Jika pas git pull atau git push ada error conflict:**
**Jangan panik.**

1. Buka VS Code, cari file yang merah.

2. Pilih kode mana yang mau dipakai ("Accept Current Change" atau "Accept Incoming Change").

3. Save, lalu lakukan git add ., git commit, dan git push lagi.
