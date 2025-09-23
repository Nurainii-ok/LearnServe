# Payment Sync Guide - LearnServe

## 🚨 Masalah: Payment Status Tidak Sinkron

Jika payment di Midtrans sudah "Settlement" tapi di aplikasi masih "Pending", gunakan panduan ini untuk memperbaikinya.

## 🔧 Solusi yang Sudah Diterapkan

### 1. **Manual Sync Individual Payment**
- Masuk ke **Admin Dashboard** → **Payments**
- Klik tombol **🔄 Sync** di kolom Actions untuk payment yang bermasalah
- Status akan otomatis diupdate sesuai dengan Midtrans

### 2. **Sync All Pending Payments**
- Di halaman Payments Management, klik tombol **"Sync All Pending"**
- Semua payment dengan status pending akan di-sync sekaligus
- Progress akan ditampilkan secara real-time

### 3. **Check Status Individual**
- Klik tombol **🔍 Check** untuk melihat perbandingan status
- Menampilkan status lokal vs status Midtrans
- Otomatis sync jika ada perbedaan

## 🛠 API Endpoints Baru

### Manual Sync Payment
```
POST /payment/sync/{orderId}
```

### Check Payment Status
```
GET /payment/status/{orderId}
```

### Test Webhook (Development)
```
POST /payment/test-webhook
Body: { "order_id": "ORDER-123456" }
```

## 📋 Cara Penggunaan

### Untuk Presentasi/Demo:

1. **Buka Admin Dashboard**
   ```
   http://localhost/admin/payments
   ```

2. **Sync Payment yang Bermasalah**
   - Cari payment dengan status "Pending"
   - Klik tombol "Sync" di kolom Actions
   - Status akan berubah menjadi "Settlement" jika sudah dibayar di Midtrans

3. **Sync Semua Sekaligus**
   - Klik "Sync All Pending" di header tabel
   - Tunggu proses selesai
   - Halaman akan refresh otomatis

## 🔍 Troubleshooting

### Jika Webhook Tidak Berjalan:

1. **Periksa URL Webhook di Midtrans Dashboard:**
   ```
   http://yourdomain.com/payment/notification
   ```

2. **Pastikan CSRF Exception:**
   File: `app/Http/Middleware/VerifyCsrfToken.php`
   ```php
   protected $except = [
       'payment/notification',
       'payment/notification/*',
   ];
   ```

3. **Test Webhook Manual:**
   ```bash
   curl -X POST http://localhost/payment/test-webhook \
   -H "Content-Type: application/json" \
   -d '{"order_id":"ORDER-1234567890-ABC12"}'
   ```

### Jika SSL Error (Development):

File `.env`:
```env
MIDTRANS_DISABLE_SSL_VERIFY=true
```

## 📊 Monitoring

### Check Laravel Logs:
```bash
tail -f storage/logs/laravel.log
```

### Log yang Penting:
- `Payment notification received`
- `Payment synced successfully`
- `Auto-enrollment process`

## 🎯 Untuk Presentasi

### Skenario Demo:

1. **Tunjukkan masalah:**
   - Buka Midtrans Dashboard (Settlement)
   - Buka Admin Payments (Pending)

2. **Tunjukkan solusi:**
   - Klik "Sync All Pending"
   - Tunjukkan status berubah real-time

3. **Tunjukkan fitur tambahan:**
   - Individual sync button
   - Check status feature
   - Auto-enrollment setelah payment

## 🚀 Fitur Baru yang Ditambahkan

✅ **Manual Sync Payment Status**  
✅ **Bulk Sync All Pending Payments**  
✅ **Real-time Status Check**  
✅ **Auto-enrollment after successful payment**  
✅ **Comprehensive error handling**  
✅ **User-friendly notifications**  
✅ **Progress tracking for bulk operations**  

## 📝 Notes untuk Presentasi

- **Webhook URL harus accessible dari internet untuk production**
- **Untuk development, gunakan ngrok atau similar**
- **Manual sync adalah backup solution jika webhook gagal**
- **Semua transaksi Midtrans dapat di-track dan di-sync**

## 🔗 Quick Links

- **Admin Payments:** `/admin/payments`
- **Test Midtrans:** `/payment/test`
- **Webhook URL:** `/payment/notification`

---

**Good luck dengan presentasinya! 🎉**
