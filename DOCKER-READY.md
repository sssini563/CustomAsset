# 🚀 Quick Start - Docker Setup Selesai!

## ✅ Status Setup

Snipe-IT dengan MariaDB sudah berhasil di-setup dan sedang berjalan!

### Containers yang berjalan:
- **snipeit-app**: Aplikasi Snipe-IT (Port: 8000)
- **snipeit-mariadb**: Database MariaDB (Port: 3306)

## 🌐 Akses Aplikasi

Buka browser dan akses:
```
http://localhost:8000
```

## 📊 Konfigurasi Database

- **Host**: mariadb (internal) atau localhost:3306 (dari host)
- **Database**: snipeit
- **Username**: snipeit_user
- **Password**: snipeit_password_123
- **Root Password**: root_password_123

⚠️ **PENTING**: Ganti password ini sebelum production!

## 🔧 Perintah Berguna

### Melihat Status Containers
```powershell
docker-compose ps
```

### Melihat Logs
```powershell
# Semua logs
docker-compose logs -f

# Logs aplikasi saja
docker-compose logs -f app

# Logs database saja
docker-compose logs -f mariadb
```

### Stop Containers
```powershell
docker-compose down
```

### Start Ulang Containers
```powershell
docker-compose up -d
```

### Restart Container Tertentu
```powershell
docker-compose restart app
docker-compose restart mariadb
```

### Masuk ke Container
```powershell
# Masuk ke aplikasi
docker-compose exec app bash

# Masuk ke database
docker-compose exec mariadb mysql -u root -p
# Password: root_password_123
```

### Jalankan Artisan Command
```powershell
# Migrasi database
docker-compose exec app php artisan migrate

# Clear cache
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan view:clear

# Generate key baru
docker-compose exec app php artisan key:generate
```

## 💾 Backup Database

```powershell
# Backup
docker-compose exec mariadb mysqldump -u root -proot_password_123 snipeit > backup-$(Get-Date -Format 'yyyyMMdd').sql

# Restore
Get-Content backup-20241102.sql | docker-compose exec -T mariadb mysql -u root -proot_password_123 snipeit
```

## 📁 Struktur Data

Data persistent disimpan di:
```
data/
├── uploads/          # File uploads
├── storage/          # Laravel storage
│   ├── app/
│   ├── logs/
│   └── framework/
│       ├── views/
│       ├── sessions/
│       └── cache/
└── snipeit/          # Data Snipe-IT

Docker Volumes:
- mariadb_data        # Database MariaDB
```

## 🔄 Update Aplikasi

```powershell
# Pull image terbaru
docker-compose pull

# Restart dengan image baru
docker-compose up -d

# Jalankan migrasi jika ada
docker-compose exec app php artisan migrate --force
```

## 🛑 Uninstall

```powershell
# Stop dan hapus containers + networks
docker-compose down

# Hapus termasuk volumes (⚠️ DATA AKAN HILANG!)
docker-compose down -v

# Hapus folder data (opsional)
Remove-Item -Recurse -Force .\data
```

## 🐛 Troubleshooting

### Port sudah digunakan
```powershell
# Cek port 8000
netstat -ano | findstr :8000

# Cek port 3306
netstat -ano | findstr :3306

# Edit port di .env jika perlu
# APP_PORT=8001
```

### Container tidak start
```powershell
# Lihat logs error
docker-compose logs

# Restart Docker Desktop
```

### Database connection error
```powershell
# Cek MariaDB sudah ready
docker-compose exec mariadb mysqladmin ping -u root -proot_password_123

# Test koneksi dari app
docker-compose exec app ping mariadb
```

## 📚 Dokumentasi Lengkap

Lihat: **DOCKER-SETUP-MARIADB.md**

## 🎉 Selamat!

Setup Docker Anda sudah berhasil! Aplikasi siap digunakan.

---
**Catatan**: Ini adalah environment development. Untuk production, pastikan:
1. Ganti semua password
2. Set APP_DEBUG=false
3. Set APP_ENV=production
4. Gunakan HTTPS
5. Backup database secara berkala
