# Snipe-IT Custom Asset - Deployment Guide# Panduan Deploy Aplikasi (Docker)



Panduan lengkap deployment Snipe-IT Custom Asset di Ubuntu Server 22.04 menggunakan Docker.Dokumen ini menjelaskan cara menjalankan aplikasi (Snipe-IT + kustomisasi Documents) menggunakan Docker dengan image overlay yang membake seluruh kode, serta data upload/storage yang disimpan di host (di luar container).



---## Prasyarat



## Prerequisites- Ubuntu 20.04/22.04 (atau setara)

- Docker Engine dan Docker Compose plugin

- Ubuntu Server 22.04 LTS   - Cek: `docker --version` dan `docker compose version`

- Docker & Docker Compose V2 installed- Akses ke database MySQL/MariaDB (server terpisah atau yang sudah tersedia)

- Git installed

- External MariaDB/MySQL database accessible## Struktur Penting di Repo

- Minimal 2GB RAM, 2 CPU cores

- Port 8000 available (atau sesuaikan)- `docker-compose.yml` (default): build image overlay dari `Dockerfile.overlay` dan menjalankan container app

- `Dockerfile.overlay`: derive dari `snipe/snipe-it:<tag>` dan menyalin semua kode dari repo ke dalam image

---- `.env.dc`: environment untuk container (APP_URL, DB, session/cache, dll)

- `docker/php-custom.ini`: override memory/upload PHP

## 🚀 Quick Start- `data/` (host): folder untuk penyimpanan persisten

   - `data/snipeit` → `/var/lib/snipeit` (data internal aplikasi)

### 1. Install Docker & Docker Compose (jika belum)   - `data/storage` → `/var/www/html/storage` (log, cache, file Laravel)

   - `data/uploads` → `/var/www/html/public/uploads` (upload publik)

```bash

# Update systemFolder `data/*` sudah otomatis di-mount melalui compose untuk memastikan data tidak hilang saat rebuild/recreate container.

sudo apt update && sudo apt upgrade -y

## Konfigurasi Environment (.env.dc)

# Install Docker

curl -fsSL https://get.docker.com -o get-docker.shEdit file `.env.dc` di root repo:

sudo sh get-docker.sh

- URL aplikasi: `APP_URL=http://IP-ATAU-DOMAIN:8008`

# Add user to docker group- Database eksternal:

sudo usermod -aG docker $USER   - `DB_HOST=...`, `DB_PORT=3306`, `DB_DATABASE=...`, `DB_USERNAME=...`, `DB_PASSWORD=...`

newgrp docker- Session & cache (stabil tanpa Redis):

   - `SESSION_DRIVER=file`

# Verify installation   - `CACHE_DRIVER=file`

docker --version- Storage:

docker compose version   - `PRIVATE_FILESYSTEM_DISK=local`

```   - `PUBLIC_FILESYSTEM_DISK=local` (atau gunakan `public_uploads` bila ingin symlink publik)



### 2. Clone RepositorySimpan `.env.dc` sebelum build.



```bash## Build & Run (Pertama Kali)

# Clone dari GitHub

cd /home/it```bash

git clone https://github.com/sssini563/CustomAsset.git snipeit# 1) Ambil kode terbaru

cd snipeitgit pull

```

# 2) Build image overlay (tanpa cache agar pasti fresh)

### 3. Setup Environment Configurationdocker compose build --no-cache



```bash# 3) Jalankan container

# Copy .env exampledocker compose up -d --force-recreate

cp .env.example .env

# 4) (Opsional) Perbaiki permission bila ada error write

# Edit .env filedocker exec -it snipeit-app bash -lc 'chown -R www-data:www-data /var/www/html/storage /var/www/html/public/uploads /var/lib/snipeit'

nano .env

```# 5) Bersihkan & cache ulang konfigurasi

docker exec -it snipeit-app php artisan optimize:clear

**Konfigurasi `.env` yang WAJIB diubah:**docker exec -it snipeit-app php artisan config:cache

docker exec -it snipeit-app php artisan route:cache

```env

# Application# 6) Migrasi database

APP_ENV=productiondocker exec -it snipeit-app php artisan migrate --no-interaction --force

APP_DEBUG=false```

APP_KEY=                    # Generate nanti dengan artisan

APP_URL=http://your-server-ip:8000Akses aplikasi: `http://IP-ATAU-DOMAIN:8008`.

APP_TIMEZONE=Asia/Jakarta

APP_LOCALE=id-IDJika database masih kosong (install baru), ikuti wizard Setup di `/setup` untuk membuat admin pertama.



# Database (External MariaDB)## Redeploy / Update

DB_CONNECTION=mysql

DB_HOST=10.10.10.100```bash

DB_PORT=3306git pull

DB_DATABASE=snipeitdocker compose build --no-cache

DB_USERNAME=rootdocker compose up -d --force-recreate

DB_PASSWORD=AKD@2025!docker exec -it snipeit-app php artisan optimize:clear

docker exec -it snipeit-app php artisan config:cache

# Redis Cache & Sessiondocker exec -it snipeit-app php artisan route:cache

CACHE_DRIVER=redis```

SESSION_DRIVER=redis

REDIS_HOST=redis## Pin Versi Image Upstream

REDIS_PASSWORD=snipeit_redis

````docker-compose.yml` membangun image dari `snipe/snipe-it:<tag>` melalui argumen build `SNIPE_IT_TAG`.



**Simpan file** dengan `Ctrl+O`, `Enter`, lalu `Ctrl+X`.- Default: `v8.3.3` (ubah ke `latest` jika tag tidak tersedia)

- Lokasi pengaturan:

### 4. Generate Application Key

```yaml

```bashbuild:

# Generate APP_KEY   args:

docker run --rm -v $(pwd)/.env:/var/www/html/.env snipe/snipe-it:latest php artisan key:generate --force      SNIPE_IT_TAG: v8.3.3

```

# Verify APP_KEY

grep APP_KEY .envCatatan: Vendor bawaan dari image upstream dipertahankan; kode kustom dibake via `Dockerfile.overlay` untuk menghindari mismatch.

```

## Uploads & Storage

### 5. Start Docker Services

- Semua upload dan file Laravel disimpan di host pada `./data/*` sesuai mapping:

```bash   - `./data/uploads` → `/var/www/html/public/uploads`

# Start services   - `./data/storage` → `/var/www/html/storage`

docker-compose up -d   - `./data/snipeit` → `/var/lib/snipeit`

- Pastikan permission benar jika ada error tulis (lihat perintah chown di atas).

# Monitor logs

docker logs snipeit-app-1 -fJika ingin memakai disk publik `public_uploads` (symlink):

```

```bash

### 6. Run Database Migrations# Ubah PUBLIC_FILESYSTEM_DISK=public_uploads di .env.dc

docker exec -it snipeit-app php artisan storage:link

```bashdocker exec -it snipeit-app php artisan optimize:clear

# Setup databasedocker exec -it snipeit-app php artisan config:cache

docker exec snipeit-app-1 php artisan migrate --force```

```

## Redis (Opsional)

### 7. Create Admin User (Fresh Install)

Default menggunakan file untuk session & cache. Bila ingin Redis:

```bash

# Create admin interaktif- Pastikan Redis dapat diakses

docker exec -it snipeit-app-1 php artisan snipeit:create-admin- Set di `.env.dc`:

```   - `SESSION_DRIVER=redis`, `CACHE_DRIVER=redis`

   - `REDIS_HOST=...`, `REDIS_PORT=6379`

### 8. Optimize Application- Recreate container dan refresh cache.



```bashJika Redis bermasalah, kembalikan ke `file` agar login stabil.

# Cache everything

docker exec snipeit-app-1 php artisan config:cache## Troubleshooting

docker exec snipeit-app-1 php artisan route:cache

docker exec snipeit-app-1 php artisan view:cache- 500 saat login (Redis/session):

```   - Pakai `SESSION_DRIVER=file` dan `CACHE_DRIVER=file`, lalu clear cache.



### 9. Access Application- Memory exhausted di PHP:

   - `docker/php-custom.ini` sudah menaikkan memory_limit=2048M. Verifikasi:

Buka browser:      ```bash

```      docker exec -it snipeit-app php -i | grep -i memory_limit

http://your-server-ip:8000      docker exec -it snipeit-app php -i | grep -i "additional .ini files"

```      ```



---- Perubahan kode tidak terlihat:

   - Build ulang tanpa cache, lalu jalankan `optimize:clear`, `config:cache`, `route:cache`.

## 🔧 Troubleshooting

- Cek log cepat:

### Error 500   - Laravel: `./data/storage/logs/laravel.log`

   - Apache: `docker exec -it snipeit-app bash -lc 'tail -n 200 /var/log/apache2/error.log'`

```bash

docker logs snipeit-app-1 --tail 100## Backup & Restore (Host Mounts)

docker exec snipeit-app-1 php artisan config:clear

docker-compose restart appKarena data dipetakan ke host, cukup backup folder `data/` dan database.

```

```bash

### Permission Errors# Backup database (contoh MySQL)

mysqldump -h <DB_HOST> -u <DB_USER> -p <DB_NAME> > backup_$(date +%Y%m%d).sql

```bash

docker exec -u root snipeit-app-1 chown -R docker:staff /var/www/html/storage# Backup files (uploads, storage, snipeit internal)

docker exec -u root snipeit-app-1 chmod -R 775 /var/www/html/storagetar -czf snipeit_data_$(date +%Y%m%d).tar.gz data/

``````



### Redis Connection RefusedRestore dengan mengekstrak kembali `data/` ke lokasi repo dan restore database dump.



```bash## Ringkasan Perintah Cepat

# Fix REDIS_HOST di .env

docker exec snipeit-app-1 sed -i 's/REDIS_HOST=127.0.0.1/REDIS_HOST=redis/g' /var/www/html/.env```bash

docker-compose restart app# Build & Run

```docker compose build --no-cache

docker compose up -d --force-recreate

---

# Migrasi

## 🔄 Updatedocker exec -it snipeit-app php artisan migrate --no-interaction --force



```bash# Cache

cd /home/it/snipeitdocker exec -it snipeit-app php artisan optimize:clear

git pull origin maindocker exec -it snipeit-app php artisan config:cache

docker-compose downdocker exec -it snipeit-app php artisan route:cache

docker-compose up -d

docker exec snipeit-app-1 php artisan migrate --force# Log aplikasi

docker exec snipeit-app-1 php artisan optimize:cleardocker exec -it snipeit-app bash -lc 'tail -n 200 storage/logs/laravel.log'

``````


---

## 📦 Maintenance

```bash
# View logs
docker logs snipeit-app-1 -f

# Restart
docker-compose restart

# Execute commands
docker exec snipeit-app-1 php artisan <command>

# Shell access
docker exec -it snipeit-app-1 bash
```

---

**Happy deploying! 🚀**
