# Sistem Peminjaman Ruangan

Aplikasi berbasis Laravel untuk mengelola peminjaman ruangan.

---

## 📌 Fitur Utama

- Login (Superadmin & Petugas)
- Manajemen Ruangan
- Manajemen Sarana
- Peminjaman Ruangan
- Upload Foto Kegiatan
- FAQ

---

## ⚙️ Kebutuhan Sistem

- PHP >= 8.1
- Composer
- MySQL
- Laragon / XAMPP (disarankan)

---

## 🚀 Cara Instalasi

1. Clone repository:

```bash
git clone https://github.com/Itsna05/peminjaman_ruangan_part2.git
```

2. Masuk ke folder project:

```bash
cd peminjaman_ruangan_part2
```

3. Install dependency:

```bash
composer install
```

4. Copy file environment:

```bash
cp .env.example .env
```

5. Generate app key:

```bash
php artisan key:generate
```

6. Atur database di file .env:

```bash
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```

7. Buat database di MySQL sesuai nama di .env

8. Jalankan migration & seeder:

```bash
php artisan migrate:fresh --seed
```

9. Jalankan server:

```bash
php artisan serve
```

---

## 🔑 Akun Demo

### Superadmin

- Username: `admin`
- Password: `admin123`

### Petugas

- Username: `petugas`
- Password: `petugas123`

---

## 📂 Database

- Struktur database dibuat menggunakan migration
- Data awal menggunakan seeder (DemoSeeder)
- Database tidak perlu import manual
