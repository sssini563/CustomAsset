@echo off
REM ============================================
REM Quick Start Script untuk Snipe-IT Docker
REM ============================================

echo ============================================
echo   Snipe-IT Docker Quick Start
echo ============================================
echo.

REM Cek Docker
echo [1/4] Mengecek Docker...
docker --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ERROR: Docker tidak ditemukan! Pastikan Docker Desktop sudah berjalan.
    pause
    exit /b 1
)
echo OK: Docker terdeteksi
echo.

REM Buat folder data
echo [2/4] Membuat folder data...
if not exist "data\uploads" mkdir data\uploads
if not exist "data\storage\framework\views" mkdir data\storage\framework\views
if not exist "data\storage\framework\sessions" mkdir data\storage\framework\sessions
if not exist "data\storage\framework\cache" mkdir data\storage\framework\cache
if not exist "data\storage\app" mkdir data\storage\app
if not exist "data\storage\logs" mkdir data\storage\logs
if not exist "data\snipeit" mkdir data\snipeit
echo OK: Folder berhasil dibuat
echo.

REM Copy .env jika belum ada
echo [3/4] Setup environment file...
if not exist ".env" (
    copy .env.docker .env >nul
    echo OK: File .env dibuat dari .env.docker
) else (
    echo OK: File .env sudah ada
)
echo.

REM Start Docker containers
echo [4/4] Menjalankan Docker containers...
docker-compose up -d
echo.

echo ============================================
echo   Setup selesai!
echo ============================================
echo.
echo Tunggu 30 detik untuk MariaDB siap, lalu:
echo   docker-compose exec app php artisan migrate --force
echo.
echo Akses aplikasi di: http://localhost:8000
echo.
echo Untuk melihat logs:
echo   docker-compose logs -f
echo.
pause
