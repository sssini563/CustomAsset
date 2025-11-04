@echo off
REM ============================================
REM Snipe-IT Docker Management Script
REM ============================================

:menu
cls
echo ============================================
echo   Snipe-IT Docker Management
echo ============================================
echo.
echo [1] Start Containers
echo [2] Stop Containers
echo [3] Restart Containers
echo [4] View Status
echo [5] View Logs (All)
echo [6] View Logs (App Only)
echo [7] View Logs (MariaDB Only)
echo [8] Run Migrations
echo [9] Clear Cache
echo [10] Backup Database
echo [11] Open in Browser
echo [0] Exit
echo.
set /p choice="Pilih opsi (0-11): "

if "%choice%"=="1" goto start
if "%choice%"=="2" goto stop
if "%choice%"=="3" goto restart
if "%choice%"=="4" goto status
if "%choice%"=="5" goto logs_all
if "%choice%"=="6" goto logs_app
if "%choice%"=="7" goto logs_db
if "%choice%"=="8" goto migrate
if "%choice%"=="9" goto cache
if "%choice%"=="10" goto backup
if "%choice%"=="11" goto browser
if "%choice%"=="0" goto end
goto menu

:start
echo.
echo Starting containers...
docker-compose up -d
echo.
echo Done!
pause
goto menu

:stop
echo.
echo Stopping containers...
docker-compose down
echo.
echo Done!
pause
goto menu

:restart
echo.
echo Restarting containers...
docker-compose restart
echo.
echo Done!
pause
goto menu

:status
echo.
docker-compose ps
echo.
pause
goto menu

:logs_all
echo.
echo Menampilkan logs (Ctrl+C untuk stop)...
docker-compose logs -f
pause
goto menu

:logs_app
echo.
echo Menampilkan logs aplikasi (Ctrl+C untuk stop)...
docker-compose logs -f app
pause
goto menu

:logs_db
echo.
echo Menampilkan logs database (Ctrl+C untuk stop)...
docker-compose logs -f mariadb
pause
goto menu

:migrate
echo.
echo Running migrations...
docker-compose exec app php artisan migrate --force
echo.
echo Done!
pause
goto menu

:cache
echo.
echo Clearing cache...
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan view:clear
echo.
echo Done!
pause
goto menu

:backup
echo.
set timestamp=%date:~10,4%%date:~4,2%%date:~7,2%-%time:~0,2%%time:~3,2%%time:~6,2%
set timestamp=%timestamp: =0%
set filename=backup-%timestamp%.sql
echo Creating backup: %filename%
docker-compose exec mariadb mysqldump -u root -proot_password_123 snipeit > %filename%
echo.
echo Backup saved to: %filename%
pause
goto menu

:browser
echo.
echo Opening http://localhost:8000 in browser...
start http://localhost:8000
pause
goto menu

:end
echo.
echo Goodbye!
exit
