# Test Camera Scanner - Production Checklist

## ✅ Checklist untuk Memastikan Camera Jalan di Production

### 1. **Security Headers Check**
Pastikan Feature-Policy dan Permissions-Policy sudah allow camera:
```bash
curl -I https://asset-it.kindairyfactory.com/hardware/qr-scan | grep -i "policy"
```

Expected output:
```
Feature-Policy: accelerometer 'none';autoplay 'none';camera 'self';...
Permissions-Policy: camera=(self), microphone=(), geolocation=()...
```

### 2. **HTTPS Verification**
Pastikan situs berjalan di HTTPS:
```bash
curl -I https://asset-it.kindairyfactory.com | grep -i "strict-transport"
```

Expected: `Strict-Transport-Security` header ada

### 3. **Browser Console Test**
Buka browser console (F12) di production, jalankan:
```javascript
// Check secure context
console.log('Is Secure Context:', window.isSecureContext); // Should be: true

// Check mediaDevices API
console.log('MediaDevices available:', !!navigator.mediaDevices); // Should be: true

// Test camera access
navigator.mediaDevices.getUserMedia({video: true})
  .then(stream => {
    console.log('✅ Camera access granted!', stream);
    stream.getTracks().forEach(track => track.stop());
  })
  .catch(err => {
    console.error('❌ Camera access denied:', err.name, err.message);
  });
```

### 4. **Expected Results**

#### ✅ **HTTPS Production (https://asset-it.kindairyfactory.com)**
- ✅ `window.isSecureContext` = `true`
- ✅ `navigator.mediaDevices` = Available
- ✅ Camera permission popup appears
- ✅ Scanner works after allowing camera

#### ✅ **HTTP Localhost (http://localhost:8000)**
- ✅ `window.isSecureContext` = `true` (localhost is exception)
- ✅ `navigator.mediaDevices` = Available
- ✅ Camera permission popup appears
- ✅ Scanner works after allowing camera

#### ❌ **HTTP 127.0.0.1 (http://127.0.0.1:8000)**
- ⚠️ Shows warning to switch to localhost
- ⚠️ Camera blocked (by design for security)

---

## 🔧 Troubleshooting

### Problem: Camera permission denied on HTTPS
**Solution:**
1. Click lock icon 🔒 in address bar
2. Click "Site settings"
3. Camera → Change to "Allow"
4. Refresh page

### Problem: "Permissions policy violation"
**Solution:**
Already fixed! SecurityHeaders middleware now sets:
- `camera 'self'` in Feature-Policy
- `camera=(self)` in Permissions-Policy

### Problem: Library not loading
**Solution:**
Library is now local (`public/js/html5-qrcode.min.js`), no CDN dependency.

---

## 📦 Deploy Commands

```bash
# SSH to production server
ssh user@your-server

# Navigate to project
cd /path/to/snipe-it

# Pull latest changes
git pull origin main

# Restart Docker
docker-compose restart app

# Or if not using Docker
php artisan config:clear
php artisan cache:clear
```

---

## ✨ Feature Summary

**Camera Scanner akan jalan di:**
- ✅ Production HTTPS (`https://asset-it.kindairyfactory.com`)
- ✅ Development localhost (`http://localhost:8000`)
- ❌ Development IP (`http://127.0.0.1:8000`) - by design, shows warning

**Browser Requirements:**
- Chrome 60+
- Firefox 55+
- Safari 11+
- Edge 79+

**Security:**
- Feature-Policy: `camera 'self'` ✅
- Permissions-Policy: `camera=(self)` ✅
- HTTPS enforced in production ✅
- Local html5-qrcode library (no CDN) ✅
