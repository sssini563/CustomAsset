# Panduan Deploy Aplikasi (Docker)

Dokumen ini menjelaskan cara menjalankan aplikasi (Snipe-IT + kustomisasi Documents) menggunakan Docker dengan image overlay yang membake seluruh kode, serta data upload/storage yang disimpan di host (di luar container).

## Prasyarat

- Ubuntu 20.04/22.04 (atau setara)
- Docker Engine dan Docker Compose plugin
   - Cek: `docker --version` dan `docker compose version`
- Akses ke database MySQL/MariaDB (server terpisah atau yang sudah tersedia)

## Struktur Penting di Repo

- `docker-compose.yml` (default): build image overlay dari `Dockerfile.overlay` dan menjalankan container app
- `Dockerfile.overlay`: derive dari `snipe/snipe-it:<tag>` dan menyalin semua kode dari repo ke dalam image
- `.env.dc`: environment untuk container (APP_URL, DB, session/cache, dll)
- `docker/php-custom.ini`: override memory/upload PHP
- `data/` (host): folder untuk penyimpanan persisten
   - `data/snipeit` → `/var/lib/snipeit` (data internal aplikasi)
   - `data/storage` → `/var/www/html/storage` (log, cache, file Laravel)
   - `data/uploads` → `/var/www/html/public/uploads` (upload publik)

Folder `data/*` sudah otomatis di-mount melalui compose untuk memastikan data tidak hilang saat rebuild/recreate container.

## Konfigurasi Environment (.env.dc)

Edit file `.env.dc` di root repo:

- URL aplikasi: `APP_URL=http://IP-ATAU-DOMAIN:8008`
- Database eksternal:
   - `DB_HOST=...`, `DB_PORT=3306`, `DB_DATABASE=...`, `DB_USERNAME=...`, `DB_PASSWORD=...`
- Session & cache (stabil tanpa Redis):
   - `SESSION_DRIVER=file`
   - `CACHE_DRIVER=file`
- Storage:
   - `PRIVATE_FILESYSTEM_DISK=local`
   - `PUBLIC_FILESYSTEM_DISK=local` (atau gunakan `public_uploads` bila ingin symlink publik)

Simpan `.env.dc` sebelum build.

## Build & Run (Pertama Kali)

```bash
# 1) Ambil kode terbaru
git pull

# 2) Build image overlay (tanpa cache agar pasti fresh)
docker compose build --no-cache

# 3) Jalankan container
docker compose up -d --force-recreate

# 4) (Opsional) Perbaiki permission bila ada error write
docker exec -it snipeit-app bash -lc 'chown -R www-data:www-data /var/www/html/storage /var/www/html/public/uploads /var/lib/snipeit'

# 5) Bersihkan & cache ulang konfigurasi
docker exec -it snipeit-app php artisan optimize:clear
docker exec -it snipeit-app php artisan config:cache
docker exec -it snipeit-app php artisan route:cache

# 6) Migrasi database
docker exec -it snipeit-app php artisan migrate --no-interaction --force
```

Akses aplikasi: `http://IP-ATAU-DOMAIN:8008`.

Jika database masih kosong (install baru), ikuti wizard Setup di `/setup` untuk membuat admin pertama.

## Redeploy / Update

```bash
git pull
docker compose build --no-cache
docker compose up -d --force-recreate
docker exec -it snipeit-app php artisan optimize:clear
docker exec -it snipeit-app php artisan config:cache
docker exec -it snipeit-app php artisan route:cache
```

## Pin Versi Image Upstream

`docker-compose.yml` membangun image dari `snipe/snipe-it:<tag>` melalui argumen build `SNIPE_IT_TAG`.

- Default: `v8.3.3` (ubah ke `latest` jika tag tidak tersedia)
- Lokasi pengaturan:

```yaml
build:
   args:
      SNIPE_IT_TAG: v8.3.3
```

Catatan: Vendor bawaan dari image upstream dipertahankan; kode kustom dibake via `Dockerfile.overlay` untuk menghindari mismatch.

## Uploads & Storage

- Semua upload dan file Laravel disimpan di host pada `./data/*` sesuai mapping:
   - `./data/uploads` → `/var/www/html/public/uploads`
   - `./data/storage` → `/var/www/html/storage`
   - `./data/snipeit` → `/var/lib/snipeit`
- Pastikan permission benar jika ada error tulis (lihat perintah chown di atas).

Jika ingin memakai disk publik `public_uploads` (symlink):

```bash
# Ubah PUBLIC_FILESYSTEM_DISK=public_uploads di .env.dc
docker exec -it snipeit-app php artisan storage:link
docker exec -it snipeit-app php artisan optimize:clear
docker exec -it snipeit-app php artisan config:cache
```

## Redis (Opsional)

Default menggunakan file untuk session & cache. Bila ingin Redis:

- Pastikan Redis dapat diakses
- Set di `.env.dc`:
   - `SESSION_DRIVER=redis`, `CACHE_DRIVER=redis`
   - `REDIS_HOST=...`, `REDIS_PORT=6379`
- Recreate container dan refresh cache.

Jika Redis bermasalah, kembalikan ke `file` agar login stabil.

## Troubleshooting

- 500 saat login (Redis/session):
   - Pakai `SESSION_DRIVER=file` dan `CACHE_DRIVER=file`, lalu clear cache.

- Memory exhausted di PHP:
   - `docker/php-custom.ini` sudah menaikkan memory_limit=2048M. Verifikasi:
      ```bash
      docker exec -it snipeit-app php -i | grep -i memory_limit
      docker exec -it snipeit-app php -i | grep -i "additional .ini files"
      ```

- Perubahan kode tidak terlihat:
   - Build ulang tanpa cache, lalu jalankan `optimize:clear`, `config:cache`, `route:cache`.

- Cek log cepat:
   - Laravel: `./data/storage/logs/laravel.log`
   - Apache: `docker exec -it snipeit-app bash -lc 'tail -n 200 /var/log/apache2/error.log'`

## Backup & Restore (Host Mounts)

Karena data dipetakan ke host, cukup backup folder `data/` dan database.

```bash
# Backup database (contoh MySQL)
mysqldump -h <DB_HOST> -u <DB_USER> -p <DB_NAME> > backup_$(date +%Y%m%d).sql

# Backup files (uploads, storage, snipeit internal)
tar -czf snipeit_data_$(date +%Y%m%d).tar.gz data/
```

Restore dengan mengekstrak kembali `data/` ke lokasi repo dan restore database dump.

## Ringkasan Perintah Cepat

```bash
# Build & Run
docker compose build --no-cache
docker compose up -d --force-recreate

# Migrasi
docker exec -it snipeit-app php artisan migrate --no-interaction --force

# Cache
docker exec -it snipeit-app php artisan optimize:clear
docker exec -it snipeit-app php artisan config:cache
docker exec -it snipeit-app php artisan route:cache

# Log aplikasi
docker exec -it snipeit-app bash -lc 'tail -n 200 storage/logs/laravel.log'
```
