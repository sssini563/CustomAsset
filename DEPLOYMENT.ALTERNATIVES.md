# Alternatif Deploy (Lebih Fleksibel/Custom)

Dokumen ini memberikan opsi alternatif selain image upstream `snipe/snipe-it`, untuk kasus yang butuh fleksibilitas lebih.

## Opsi A: Custom PHP 8.3 + Apache (single container)

File terkait:
- `Dockerfile.custom-apache`
- `docker-compose.custom-apache.yml`

### Kapan dipakai?
- Ingin kontrol penuh atas PHP extensions dan runtime
- Ingin build vendor sendiri (tanpa dev packages)
- Tidak ingin mengandalkan entrypoint logic dari image upstream

### Cara pakai

```bash
# Build image custom
docker compose -f docker-compose.custom-apache.yml build --no-cache

# Jalankan
docker compose -f docker-compose.custom-apache.yml up -d --force-recreate

# Setelah up: publish asset Livewire (opsional, tergantung kebutuhan)
docker exec -it snipeit-app-apache php artisan vendor:publish --force --tag=livewire:assets

# Refresh cache Laravel
docker exec -it snipeit-app-apache php artisan optimize:clear
docker exec -it snipeit-app-apache php artisan config:cache
docker exec -it snipeit-app-apache php artisan route:cache

# Migrasi DB
docker exec -it snipeit-app-apache php artisan migrate --no-interaction --force
```

Port default: `8009` (lihat compose). Data persisten tetap di `./data/*` seperti setup utama.

Scheduler service (`schedule:work`) sudah disiapkan sebagai service terpisah bernama `scheduler` di compose.

### Catatan Teknis
- Composer dijalankan dengan `--no-scripts` di tahap build untuk menghindari eksekusi artisan saat build. Discovery/publish akan terjadi saat runtime melalui perintah artisan di atas.
- PHP extensions terpasang: `gd pdo_mysql exif zip bcmath intl`, plus `opcache` aktif. Tambah sesuai kebutuhan Anda.
- Apache module aktif: `rewrite, headers, expires`.

---

## Opsi B: PHP-FPM + Nginx (dipersiapkan bila diperlukan)

Jika ingin arsitektur terpisah (web server Nginx + PHP-FPM), kita bisa siapkan:
- `Dockerfile.custom-fpm` (basis `php:8.3-fpm`, install extensions, composer vendor)
- `docker/nginx/default.conf` (konfigurasi vhost ke `/var/www/html/public`)
- `docker-compose.custom-fpm.yml` (services: `php-fpm`, `nginx`, `scheduler`)

Silakan beri tahu jika Anda ingin opsi ini, saya akan generate file-file tersebut menyesuaikan kebutuhan port dan reverse proxy Anda.

---

## Perbandingan Singkat

- Upstream overlay (saat ini dipakai):
  - Pro: Stabil, cepat, minim konfigurasi; vendor bawaan image.
  - Kontra: Lebih sedikit fleksibel pada runtime/ekstensi.

- Custom Apache (opsi A):
  - Pro: Penuh kontrol (ext, php ini, build vendor sendiri).
  - Kontra: Build time lebih lama; perlu langkah runtime artisan.

- FPM + Nginx (opsi B):
  - Pro: Arsitektur yang umum di production; performa baik.
  - Kontra: Setup lebih kompleks (dua container + config Nginx).

---

## Reuse Storage & Uploads

Semua opsi memakai mapping persisten yang sama:
- `./data/snipeit` → `/var/lib/snipeit`
- `./data/storage` → `/var/www/html/storage`
- `./data/uploads` → `/var/www/html/public/uploads`

Pastikan permission:
```bash
docker exec -it <nama-container-app> bash -lc 'chown -R www-data:www-data /var/www/html/storage /var/www/html/public/uploads /var/lib/snipeit'
```

---

Butuh penyesuaian lain (ekstensi PHP tambahan, mailer, proxy/SSL)? Beri tahu, saya sesuaikan Dockerfile dan compose-nya. 
