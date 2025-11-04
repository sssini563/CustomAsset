# Performance Optimization Guide

## Current Setup
- ✅ Redis cache enabled (CACHE_DRIVER=redis)
- ✅ Redis sessions enabled (SESSION_DRIVER=redis)
- ✅ Login profiling enabled (LOGIN_PROFILING=true)

## Performance Analysis Results

Based on testing:
- Database connection: ~37ms
- Settings cache: ~27ms (first) → 0.01ms (cached)
- User lookup: ~10ms
- Redis operations: ~5ms average

**Total overhead: ~123ms** ✓ Good performance

## Common Login Slowness Causes

### 1. **LDAP Authentication** ⚠️ BIGGEST CAUSE
**Status**: LDAP is ENABLED in your setup

LDAP can add **5-30 seconds** to login time if:
- LDAP server is slow or unreachable
- Network latency to LDAP server is high
- LDAP directory is large

**Solution**: If you're NOT using LDAP, disable it in Admin → Settings → LDAP.

To disable LDAP via database:
```sql
UPDATE settings SET ldap_enabled = 0;
```

### 2. **Database Network Latency**
Your database is at `10.10.10.100` (external server).

**Typical times**:
- Local DB: 1-5ms
- Same network: 10-50ms ✓ (your current ~37ms)
- Remote/VPN: 100-500ms ⚠️

**Solutions**:
- Use faster network connection
- Enable persistent DB connections (already enabled via DB_STICKY=true)
- Consider database connection pooling

### 3. **Large Session Data**
Redis sessions are fast, but if session data is huge, serialization can be slow.

**Check session size**:
```php
php artisan tinker
>>> strlen(serialize(session()->all()))
```

### 4. **External Service Timeouts**
Check these settings:
- SAML authentication (if enabled)
- Google SSO
- Microsoft Teams/Slack notifications on login

## Optimization Checklist

### ✅ Already Optimized
- [x] Redis cache (10-100x faster than file)
- [x] Redis sessions (no file I/O)
- [x] Database sticky connections
- [x] Setting::getSettings() internal cache

### 🔧 Additional Optimizations

#### 1. Disable LDAP if Not Used
```env
# In .env (requires database setting to match)
# Or disable via Admin UI → Settings → LDAP
```

#### 2. Optimize Database Queries
Add indexes to frequently queried columns:
```sql
-- Check if indexes exist
SHOW INDEX FROM users;

-- Add indexes if missing (usually already exist)
CREATE INDEX idx_username_active ON users(username, activated, deleted_at);
```

#### 3. Enable OPcache (PHP)
Add to `docker/php-custom.ini`:
```ini
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=10000
opcache.revalidate_freq=2
```

#### 4. Preload Settings Cache
Add to `app/Providers/AppServiceProvider.php` boot method:
```php
// Warm up settings cache on boot
if (!$this->app->runningInConsole()) {
    \App\Models\Setting::getSettings();
}
```

#### 5. Use Route Caching (Production)
```bash
php artisan route:cache
php artisan config:cache
php artisan view:cache
```

#### 6. Database Query Caching
For frequently accessed data, add caching:
```php
// Example: Cache user lookup
$user = Cache::remember("user_{$username}", 3600, function() use ($username) {
    return User::where('username', $username)->first();
});
```

## Testing Login Performance

### 1. Enable Profiling
```env
LOGIN_PROFILING=true
```

### 2. Test Login
Login via web browser, then check logs:
```powershell
Get-Content storage/logs/laravel.log | Select-String "LOGIN_PROF" | Select-Object -Last 10
```

### 3. Analyze Results
Look for slow operations:
- `validate`: Should be <50ms
- `throttle-check`: Should be <10ms
- `ldap-login-total`: If >1000ms, LDAP is the problem
- `local-auth-attempt`: Should be <100ms
- `TOTAL-login`: Target <500ms for good UX

## Performance Monitoring

### Redis Stats
```powershell
.\redis-manage.ps1 cli
> INFO stats
> SLOWLOG GET 10  # Show slow queries
```

### Database Performance
```sql
-- Show slow queries
SHOW PROCESSLIST;

-- Check table status
SHOW TABLE STATUS LIKE 'users';
```

### PHP Performance
Check execution time in browser DevTools:
- Network tab → Initial document load
- Should be <1s for good UX

## Expected Performance Targets

| Metric | Target | Your Current |
|--------|--------|--------------|
| Database ping | <50ms | ~37ms ✓ |
| Settings load | <30ms | ~27ms ✓ |
| User lookup | <20ms | ~10ms ✓ |
| Cache read | <5ms | ~3ms ✓ |
| Total login | <500ms | ⚠️ Test needed |

## Next Steps

1. **Disable LDAP** if not used (likely main cause of slowness)
2. **Test actual login** with profiling enabled
3. **Check logs** for LOGIN_PROF entries to find bottleneck
4. **Monitor** Redis and database performance
5. **Consider** adding OPcache for PHP

## Troubleshooting

### Login still slow after Redis?
- Check if LDAP is trying to connect to unreachable server
- Monitor network latency to database (10.10.10.100)
- Check if any middleware is running slow operations
- Review browser DevTools Network tab for actual timing

### Redis not being used?
- Run: `php scripts/test_redis.php`
- Check: `php artisan config:show cache.default` → should be "redis"
- Clear cache: `php artisan config:clear && php artisan cache:clear`
