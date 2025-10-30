# Cara Enable Kamera di Chrome untuk HTTP (Development)

## Metode 1: Chrome Flags (Paling Mudah)

1. Buka Chrome, ketik di address bar:
   ```
   chrome://flags/#unsafely-treat-insecure-origin-as-secure
   ```

2. Di field "Insecure origins treated as secure", masukkan:
   ```
   http://127.0.0.1:8000
   ```

3. Ubah dropdown menjadi **"Enabled"**

4. Klik tombol **"Relaunch"** untuk restart Chrome

5. Buka kembali `http://127.0.0.1:8000` dan test scan kamera

---

## Metode 2: Firefox (Alternatif Browser)

Firefox lebih permisif untuk localhost:

1. Install Firefox jika belum ada
2. Buka `http://127.0.0.1:8000`
3. Klik tombol scan kamera
4. Klik "Allow" saat popup muncul
5. ✅ Langsung jalan!

---

## Metode 3: Microsoft Edge

1. Buka Edge, ketik di address bar:
   ```
   edge://flags/#unsafely-treat-insecure-origin-as-secure
   ```

2. Masukkan: `http://127.0.0.1:8000`

3. Enable dan restart Edge

---

## ⚠️ CATATAN PENTING

Setting di atas **HANYA untuk development**. 
Untuk production, WAJIB menggunakan HTTPS!

---

## 🎯 Solusi Tanpa Setting (Recommended)

Gunakan fitur yang sudah tersedia:

1. **Upload Gambar** - Ambil foto QR code, lalu upload
2. **Input Manual** - Ketik kode asset langsung

Kedua metode ini **100% work** tanpa perlu kamera!
