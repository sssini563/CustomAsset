# 🐳 Docker Setup untuk Snipe-IT dengan MariaDB

Panduan lengkap untuk menjalankan Snipe-IT menggunakan Docker Desktop dengan MariaDB.

## 📋 Prerequisites

- Docker Desktop sudah terinstall dan running
- Port 8000 dan 3306 tersedia (tidak digunakan aplikasi lain)
- Git Bash atau PowerShell

## 🚀 Cara Menjalankan

### 1. Persiapan Awal

```powershell
# Pastikan Docker Desktop sudah berjalan
# Buka PowerShell di folder project ini

# Copy file environment (jika belum ada)
Copy-Item .env.docker .env
```

### 2. Membuat Folder Data

```powershell
# Buat folder untuk menyimpan data persistent
New-Item -ItemType Directory -Force -Path .\data\uploads
New-Item -ItemType Directory -Force -Path .\data\storage\framework\views
New-Item -ItemType Directory -Force -Path .\data\snipeit
```

### 3. Build dan Jalankan Container

```powershell
# Build dan jalankan semua container
docker-compose up -d

# Cek status container
docker-compose ps

# Lihat logs (untuk troubleshooting)
docker-compose logs -f
```

### 4. Setup Database & Aplikasi

```powershell
# Tunggu beberapa saat sampai MariaDB siap (sekitar 30 detik)

# Generate App Key (jika belum ada)
docker-compose exec app php artisan key:generate

# Jalankan migrasi database
docker-compose exec app php artisan migrate --force

# (Opsional) Seed data demo
docker-compose exec app php artisan db:seed --force
```

### 5. Akses Aplikasi

Buka browser dan akses: **http://localhost:8000**

Default credentials (jika menggunakan seeder):
- Username: `admin`
- Password: `password`

## 🔧 Konfigurasi

### Database (MariaDB)
- **Host**: mariadb (internal Docker network)
- **Port**: 3306
- **Database**: snipeit
- **Username**: snipeit_user
- **Password**: snipeit_password_123 (⚠️ Ganti untuk production!)

### Aplikasi
- **URL**: http://localhost:8000
- **Timezone**: Asia/Jakarta
- **Locale**: id-ID

## 📝 Perintah Docker Berguna

```powershell
# Stop semua container
docker-compose down

# Stop dan hapus volumes (⚠️ HATI-HATI: Menghapus semua data!)
docker-compose down -v

# Restart container tertentu
docker-compose restart app
docker-compose restart mariadb

# Lihat logs container tertentu
docker-compose logs app
docker-compose logs mariadb

# Masuk ke container
docker-compose exec app bash
docker-compose exec mariadb mysql -u root -p

# Update container (pull image terbaru)
docker-compose pull
docker-compose up -d

# Backup database
docker-compose exec mariadb mysqldump -u root -proot_password_123 snipeit > backup.sql

# Restore database
Get-Content backup.sql | docker-compose exec -T mariadb mysql -u root -proot_password_123 snipeit
```

## 🗂️ Struktur Volume

```
data/
├── uploads/          # File upload dari aplikasi
├── storage/          # Laravel storage
│   └── framework/
│       └── views/    # Compiled blade templates
└── snipeit/          # Data aplikasi Snipe-IT

Docker Volumes:
- mariadb_data        # Data database MariaDB (managed by Docker)
```

## 🔍 Troubleshooting

### Container tidak mau start
```powershell
# Cek logs untuk error
docker-compose logs

# Cek port yang digunakan
netstat -ano | findstr :8000
netstat -ano | findstr :3306
```

### Database connection error
```powershell
# Pastikan MariaDB sudah ready
docker-compose exec mariadb mysqladmin ping -u root -proot_password_123

# Cek koneksi dari app container
docker-compose exec app ping mariadb
```

### Permission issues
```powershell
# Set permission pada folder data
icacls .\data /grant Users:F /T
```

### Clear cache
```powershell
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan view:clear
```

## 🔐 Keamanan untuk Production

**⚠️ PENTING: Ganti semua password default sebelum production!**

Edit file `.env` dan ganti:
- `DB_PASSWORD`
- `MYSQL_ROOT_PASSWORD`
- `APP_KEY` (generate ulang)

```powershell
# Generate new APP_KEY
docker-compose exec app php artisan key:generate --show
```

## 📦 Update Aplikasi

```powershell
# Pull image terbaru
docker-compose pull app

# Restart dengan image baru
docker-compose up -d

# Jalankan migrasi jika ada
docker-compose exec app php artisan migrate --force
```

## 🛑 Uninstall

```powershell
# Stop dan hapus semua container, networks, dan volumes
docker-compose down -v

# Hapus folder data (opsional)
Remove-Item -Recurse -Force .\data
```

## 📞 Support

- Snipe-IT Documentation: https://snipe-it.readme.io/docs
- Docker Documentation: https://docs.docker.com
- MariaDB Documentation: https://mariadb.com/kb/en/

## 📄 Lisensi

Snipe-IT adalah software open source berlisensi AGPL-3.0.
