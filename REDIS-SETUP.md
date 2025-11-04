# Redis Cache Setup

## Quick Start

1. **Start Redis container:**
   ```powershell
   docker-compose up -d redis
   ```

2. **Test Redis connection:**
   ```powershell
   php scripts/test_redis.php
   ```

3. **Clear cache:**
   ```powershell
   php artisan cache:clear
   ```

## Configuration

Redis is configured in `.env`:

```env
# Cache & Session
CACHE_DRIVER=redis
SESSION_DRIVER=redis

# Redis Configuration
REDIS_HOST=redis
REDIS_PASSWORD=snipeit_redis
REDIS_PORT=6379
REDIS_DB=0
REDIS_CACHE_DB=1
REDIS_SESSION_DB=2
```

## Performance Benefits

Using Redis for cache and sessions provides:

- **Faster login**: Session data retrieved from memory instead of file I/O
- **Shared sessions**: Multiple app instances can share session data
- **Better caching**: In-memory cache is 10-100x faster than file cache
- **Persistence**: Data survives app restarts

## Docker Compose Services

### Production (docker-compose.yml)
```yaml
services:
  app:
    depends_on:
      - redis
  redis:
    image: redis:7-alpine
    volumes:
      - redis_data:/data
```

### Development (docker-compose.dev.yml)
Same setup but with build context for custom Dockerfile.

## Redis Commands

### Connect to Redis CLI:
```bash
docker exec -it snipe-redis redis-cli -a snipeit_redis
```

### Monitor Redis:
```bash
docker exec -it snipe-redis redis-cli -a snipeit_redis monitor
```

### Check Redis stats:
```bash
docker exec -it snipe-redis redis-cli -a snipeit_redis info
```

### Flush cache (careful in production!):
```bash
docker exec -it snipe-redis redis-cli -a snipeit_redis FLUSHDB
```

## Troubleshooting

### "Connection refused" error
- Make sure Redis container is running: `docker ps | grep redis`
- Check Redis health: `docker-compose ps redis`

### "NOAUTH Authentication required"
- Password mismatch between `.env` REDIS_PASSWORD and docker-compose

### Performance still slow
1. Enable login profiling:
   ```env
   LOGIN_PROFILING=true
   ```

2. Check logs:
   ```bash
   tail -f storage/logs/laravel.log | grep LOGIN_PROF
   ```

3. Look for bottlenecks (LDAP, database queries, etc.)

## Database Separation

Redis uses separate databases for different purposes:
- DB 0: Default/general purpose
- DB 1: Application cache (`CACHE_DRIVER=redis`)
- DB 2: Session storage (`SESSION_DRIVER=redis`)

This prevents cache clears from affecting sessions.
