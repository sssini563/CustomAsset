# Setup Local Development Database (SQLite)
# Run this to enable local artisan commands without external MariaDB

# Backup original .env
if (!(Test-Path ".env.backup")) {
    Copy-Item .env .env.backup
    Write-Host "[OK] Backed up .env to .env.backup" -ForegroundColor Green
}

# Create .env.local for development
$envLocal = @"
# Local Development Environment
APP_ENV=local
APP_DEBUG=true
APP_KEY=base64:3ilviXqB9u6DX1NRcyWGJ+sjySF+H18CPDGb3+IVwMQ=
APP_URL=http://localhost:8000
APP_TIMEZONE=Asia/Jakarta
APP_LOCALE=id-ID

# SQLite for local development
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

# File storage
PRIVATE_FILESYSTEM_DISK=local
PUBLIC_FILESYSTEM_DISK=local_public

# Disable external services for local dev
MAIL_DRIVER=log
QUEUE_DRIVER=sync
SESSION_DRIVER=file
CACHE_DRIVER=file

MAX_RESULTS=500
"@

Set-Content -Path ".env.local" -Value $envLocal
Write-Host "[OK] Created .env.local" -ForegroundColor Green

# Create SQLite database file
$dbDir = "database"
if (!(Test-Path $dbDir)) {
    New-Item -ItemType Directory -Path $dbDir | Out-Null
}

$dbFile = "$dbDir\database.sqlite"
if (!(Test-Path $dbFile)) {
    New-Item -ItemType File -Path $dbFile | Out-Null
    Write-Host "[OK] Created SQLite database: $dbFile" -ForegroundColor Green
}

# Copy .env.local to .env for local development
Copy-Item .env.local .env -Force
Write-Host "[OK] Activated local development environment" -ForegroundColor Green

Write-Host "`nLocal development setup complete!" -ForegroundColor Cyan
Write-Host "You can now run:" -ForegroundColor Yellow
Write-Host "  php artisan migrate" -ForegroundColor White
Write-Host "  php artisan db:seed" -ForegroundColor White
Write-Host "  php artisan serve" -ForegroundColor White
Write-Host "`nTo restore production .env, run:" -ForegroundColor Yellow
Write-Host "  Copy-Item .env.backup .env -Force" -ForegroundColor White
