# ============================================
# Snipe-IT Docker Setup Script
# ============================================
# Script untuk setup awal Snipe-IT dengan Docker

Write-Host "============================================" -ForegroundColor Cyan
Write-Host "  Snipe-IT Docker Setup dengan MariaDB" -ForegroundColor Cyan
Write-Host "============================================" -ForegroundColor Cyan
Write-Host ""

# Cek Docker
Write-Host "🔍 Mengecek Docker Desktop..." -ForegroundColor Yellow
try {
    $dockerVersion = docker --version
    Write-Host "✅ Docker terdeteksi: $dockerVersion" -ForegroundColor Green
} catch {
    Write-Host "❌ Docker tidak terdeteksi! Pastikan Docker Desktop sudah berjalan." -ForegroundColor Red
    exit 1
}

Write-Host ""

# Cek docker-compose
Write-Host "🔍 Mengecek Docker Compose..." -ForegroundColor Yellow
try {
    $composeVersion = docker-compose --version
    Write-Host "✅ Docker Compose terdeteksi: $composeVersion" -ForegroundColor Green
} catch {
    Write-Host "❌ Docker Compose tidak terdeteksi!" -ForegroundColor Red
    exit 1
}

Write-Host ""

# Copy .env file jika belum ada
if (-not (Test-Path ".env")) {
    Write-Host "📋 Membuat file .env dari .env.docker..." -ForegroundColor Yellow
    Copy-Item ".env.docker" ".env"
    Write-Host "✅ File .env berhasil dibuat" -ForegroundColor Green
} else {
    Write-Host "✅ File .env sudah ada" -ForegroundColor Green
}

Write-Host ""

# Buat folder data
Write-Host "📁 Membuat folder untuk data persistent..." -ForegroundColor Yellow

$folders = @(
    ".\data\uploads",
    ".\data\storage\framework\views",
    ".\data\storage\framework\sessions",
    ".\data\storage\framework\cache",
    ".\data\storage\app",
    ".\data\storage\logs",
    ".\data\snipeit"
)

foreach ($folder in $folders) {
    if (-not (Test-Path $folder)) {
        New-Item -ItemType Directory -Force -Path $folder | Out-Null
        Write-Host "  ✅ $folder" -ForegroundColor Green
    } else {
        Write-Host "  ✓ $folder (sudah ada)" -ForegroundColor Gray
    }
}

Write-Host ""

# Pull images
Write-Host "📦 Mengunduh Docker images..." -ForegroundColor Yellow
Write-Host "Ini mungkin memakan waktu beberapa menit..." -ForegroundColor Gray
docker-compose pull

Write-Host ""

# Build dan start containers
Write-Host "🚀 Menjalankan Docker containers..." -ForegroundColor Yellow
docker-compose up -d

Write-Host ""

# Tunggu MariaDB ready
Write-Host "⏳ Menunggu MariaDB siap..." -ForegroundColor Yellow
$maxAttempts = 30
$attempt = 0
$isReady = $false

while (-not $isReady -and $attempt -lt $maxAttempts) {
    $attempt++
    Start-Sleep -Seconds 2
    
    try {
        $result = docker-compose exec -T mariadb mysqladmin ping -h localhost -u root -proot_password_123 2>&1
        if ($result -match "mysqld is alive") {
            $isReady = $true
            Write-Host "✅ MariaDB sudah siap!" -ForegroundColor Green
        }
    } catch {
        Write-Host "." -NoNewline
    }
}

if (-not $isReady) {
    Write-Host ""
    Write-Host "⚠️ MariaDB timeout, tapi container sudah berjalan." -ForegroundColor Yellow
    Write-Host "Silakan cek logs: docker-compose logs mariadb" -ForegroundColor Yellow
}

Write-Host ""

# Generate APP_KEY jika belum ada
Write-Host "🔑 Memeriksa APP_KEY..." -ForegroundColor Yellow
$envContent = Get-Content ".env" -Raw
if ($envContent -notmatch 'APP_KEY=base64:') {
    Write-Host "Generating APP_KEY..." -ForegroundColor Yellow
    docker-compose exec -T app php artisan key:generate --force
    Write-Host "✅ APP_KEY berhasil di-generate" -ForegroundColor Green
} else {
    Write-Host "✅ APP_KEY sudah ada" -ForegroundColor Green
}

Write-Host ""

# Run migrations
Write-Host "🗄️ Menjalankan database migrations..." -ForegroundColor Yellow
docker-compose exec -T app php artisan migrate --force

Write-Host ""

# Status containers
Write-Host "📊 Status Containers:" -ForegroundColor Cyan
docker-compose ps

Write-Host ""
Write-Host "============================================" -ForegroundColor Cyan
Write-Host "  ✅ Setup Selesai!" -ForegroundColor Green
Write-Host "============================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Aplikasi berjalan di: " -NoNewline
Write-Host "http://localhost:8000" -ForegroundColor Yellow
Write-Host ""
Write-Host "Untuk melihat logs:" -ForegroundColor Gray
Write-Host "  docker-compose logs -f" -ForegroundColor White
Write-Host ""
Write-Host "Untuk stop containers:" -ForegroundColor Gray
Write-Host "  docker-compose down" -ForegroundColor White
Write-Host ""
Write-Host "Untuk informasi lebih lanjut, baca:" -ForegroundColor Gray
Write-Host "  DOCKER-SETUP-MARIADB.md" -ForegroundColor White
Write-Host ""
