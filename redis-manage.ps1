# Redis Management Script for Windows
# Usage: .\redis-manage.ps1 [start|stop|restart|status|logs|cli|flush]

param(
    [Parameter(Position=0)]
    [ValidateSet('start', 'stop', 'restart', 'status', 'logs', 'cli', 'flush', 'test')]
    [string]$Action = 'status'
)

$ErrorActionPreference = "Stop"

function Write-Color {
    param([string]$Text, [string]$Color = "White")
    Write-Host $Text -ForegroundColor $Color
}

function Get-RedisPassword {
    $envFile = ".\.env"
    if (Test-Path $envFile) {
        $content = Get-Content $envFile
        $passwordLine = $content | Where-Object { $_ -match '^REDIS_PASSWORD=' }
        if ($passwordLine) {
            return $passwordLine -replace '^REDIS_PASSWORD=', ''
        }
    }
    return "snipeit_redis"
}

$redisPassword = Get-RedisPassword

switch ($Action) {
    'start' {
        Write-Color "`n=== Starting Redis ===" "Cyan"
        docker-compose up -d redis
        Write-Color "✓ Redis started!" "Green"
        Write-Color "Run './redis-manage.ps1 status' to check health`n" "Gray"
    }
    
    'stop' {
        Write-Color "`n=== Stopping Redis ===" "Cyan"
        docker-compose stop redis
        Write-Color "✓ Redis stopped!`n" "Green"
    }
    
    'restart' {
        Write-Color "`n=== Restarting Redis ===" "Cyan"
        docker-compose restart redis
        Write-Color "✓ Redis restarted!`n" "Green"
    }
    
    'status' {
        Write-Color "`n=== Redis Status ===" "Cyan"
        docker-compose ps redis
        
        $running = docker ps --filter "name=snipe-redis" --format "{{.Status}}"
        if ($running) {
            Write-Color "`n✓ Redis is running" "Green"
            
            # Get Redis info
            $info = docker exec snipe-redis redis-cli -a $redisPassword info server 2>$null
            if ($info) {
                $version = ($info | Select-String "redis_version:(.+)").Matches.Groups[1].Value
                $uptime = ($info | Select-String "uptime_in_seconds:(.+)").Matches.Groups[1].Value
                Write-Color "  Version: $version" "Gray"
                Write-Color "  Uptime: $uptime seconds" "Gray"
            }
        } else {
            Write-Color "`n✗ Redis is not running" "Red"
            Write-Color "Run './redis-manage.ps1 start' to start it`n" "Yellow"
        }
    }
    
    'logs' {
        Write-Color "`n=== Redis Logs (Ctrl+C to exit) ===" "Cyan"
        docker-compose logs -f redis
    }
    
    'cli' {
        Write-Color "`n=== Redis CLI (type 'exit' to quit) ===" "Cyan"
        docker exec -it snipe-redis redis-cli -a $redisPassword
    }
    
    'flush' {
        Write-Color "`n=== Flushing Redis Cache ===" "Yellow"
        $confirm = Read-Host "Are you sure? This will clear all cached data (y/N)"
        if ($confirm -eq 'y' -or $confirm -eq 'Y') {
            docker exec snipe-redis redis-cli -a $redisPassword FLUSHDB
            Write-Color "✓ Cache flushed!`n" "Green"
        } else {
            Write-Color "Cancelled`n" "Gray"
        }
    }
    
    'test' {
        Write-Color "`n=== Testing Redis Connection ===" "Cyan"
        php scripts/test_redis.php
    }
}
