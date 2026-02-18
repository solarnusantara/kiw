# 03 Arsitektur Sistem

Dokumen ini menjelaskan arsitektur tingkat tinggi dari Platform E-commerce B2B KIW.

## Pola Arsitektur

Platform ini dibangun menggunakan pola arsitektur **Monolitik Modular** dengan pemisahan yang jelas antara _backend_ dan _frontend_.

* **Backend (Monolit):** Dibangun sebagai satu aplikasi tunggal menggunakan framework Laravel. Meskipun monolit, kodenya diorganisir secara modular. Terlihat dari adanya direktori seperti `app/Addons`, `app/Models`, `app/Http/Controllers`, dan pemisahan file rute (`routes/admin.php`, `routes/seller.php`, dll). Ini memungkinkan setiap fitur utama (seperti afiliasi, refund, POS) untuk dikelola dalam modulnya sendiri.
* **Frontend (Single Page Application - SPA):** Dibangun sebagai aplikasi terpisah menggunakan Vue.js. Aplikasi SPA ini berkomunikasi dengan backend melalui REST API. Ini memberikan pengalaman pengguna yang lebih cepat dan responsif karena halaman tidak perlu dimuat ulang sepenuhnya setiap kali ada interaksi.

## Arsitektur Tingkat Tinggi (High-Level Architecture)

```bash
+--------------------------------------------------------------------------+
|      Pengguna (Admin, Penjual, Pelanggan, Kurir, Afiliasi)               |
+--------------------------------------------------------------------------+
             | (melalui Web Browser atau Aplikasi Khusus)
             v
+--------------------------------------------------------------------------+
|                Aplikasi Frontend (Vue.js SPA)                            |
|--------------------------------------------------------------------------|
| - Antarmuka Pengguna (UI) dengan Vuetify                                 |
| - Manajemen State (Vuex)                                                 |
| - Routing (Vue Router)                                                   |
| - Tampilan berbeda berdasarkan peran pengguna                            |
+--------------------------------------------------------------------------+
             | (Permintaan HTTP/AJAX via REST API)
             v
+--------------------------------------------------------------------------+
|                     Aplikasi Backend (Laravel)                           |
|--------------------------------------------------------------------------|
|       Layer:                                                             |
|                                                                          |
|  [ Middleware ] <-- (Otentikasi, Otorisasi, Logging, CORS)               |
|       |                                                                  |
|  [ Routing ] <---- (routes/web.php, api.php, admin.php, dll)             |
|       |                                                                  |
|  [ Controllers ] <- (Logika bisnis untuk menangani permintaan)           |
|       |                                                                  |
|  [ Services ] <---- (Logika bisnis kompleks, reusable)                   |
|       |                                                                  |
|  [ Models / Eloquent ] <- (Abstraksi Database, Relasi)                   |
|       |                                                                  |
+--------------------------------------------------------------------------+
             | (Query SQL)
             v
+-----------------------+      +-------------------+      +----------------+
|   Database Utama      |      |   Cache / Antrian |      | Penyimpanan    |
|      (MySQL)          | <--> |      (Redis)      |      | File (S3/Lokal)|
+-----------------------+      +-------------------+      +----------------+
             |
             v
+--------------------------------------------------------------------------+
|                    Layanan Eksternal (via API)                           |
|--------------------------------------------------------------------------|
| - Payment Gateways (Stripe, Xendit, dll)                                 |
| - Layanan Pihak Ketiga Lainnya                                           |
+--------------------------------------------------------------------------+
```

### Deskripsi Komponen

1. **Aplikasi Frontend (Vue.js SPA):**
    * Bertanggung jawab untuk menyajikan antarmuka pengguna (UI) kepada semua jenis pengguna.
    * Berinteraksi dengan pengguna dan mengirimkan permintaan ke _backend_ API untuk mengambil atau memanipulasi data.
    * Mengelola _state_ aplikasi (seperti data pengguna yang login, isi keranjang belanja) menggunakan Vuex.
    * Vue Router menangani navigasi di sisi klien tanpa perlu me-reload halaman.

2. **Aplikasi Backend (Laravel):**
    * **Middleware:** Bertindak sebagai lapisan penjaga sebelum permintaan mencapai logika inti. Ini menangani otentikasi (memastikan pengguna sudah login), otorisasi (memastikan pengguna memiliki hak akses), logging, dan kebijakan CORS.
    * **Routing:** Memetakan URL permintaan ke _Controller_ yang sesuai. Pemisahan file rute per peran (`admin.php`, `seller.php`) membuat manajemen _endpoint_ lebih terorganisir.
    * **Controllers:** Berisi logika utama untuk menangani permintaan HTTP. _Controller_ menerima input, berinteraksi dengan _Service_ atau _Model_, dan mengembalikan respons (biasanya dalam format JSON).
    * **Services:** (jika digunakan) Berisi logika bisnis yang lebih kompleks dan dapat digunakan kembali di beberapa _controller_. Ini membantu menjaga _controller_ tetap ramping.
    * **Models (Eloquent ORM):** Merepresentasikan tabel dalam database dan menangani semua interaksi dengan database. Eloquent menyediakan cara yang mudah untuk melakukan operasi CRUD (_Create, Read, Update, Delete_) dan mengelola relasi antar tabel.

3. **Penyimpanan Data:**
    * **Database Utama (MySQL/PostgreSQL):** Menyimpan data persisten seperti data produk, pengguna, pesanan, dan data transaksional lainnya.
    * **Cache/Antrian (Redis):** Digunakan untuk menyimpan data yang sering diakses sementara waktu (_caching_) untuk mengurangi beban database dan mempercepat respons. Juga digunakan sebagai _message broker_ untuk antrian (_queues_), memungkinkan tugas-tugas yang memakan waktu (seperti mengirim email atau memproses gambar) dijalankan di latar belakang (_background job_) tanpa menghalangi respons ke pengguna.
    * **Penyimpanan File (File Storage):** Gambar produk, dokumen, dan aset lainnya dapat disimpan di _filesystem_ lokal atau di layanan penyimpanan cloud seperti Amazon S3 untuk skalabilitas dan keandalan yang lebih baik.

4. **Layanan Eksternal:**
    * Platform berinteraksi dengan API dari layanan eksternal, terutama untuk pemrosesan pembayaran. Komunikasi ini diamankan dan ditangani di sisi _backend_.

## Alur Data (Contoh: Proses Checkout)

1. **Frontend:** Pengguna menekan tombol "Bayar" di halaman checkout. Aplikasi Vue.js mengumpulkan data dari form (alamat, metode pengiriman, dll) dan mengirimkannya ke _endpoint_ API `POST /api/orders`.
2. **Backend:**
    * Permintaan diterima dan melewati _middleware_ otentikasi untuk memastikan pengguna valid.
    * _Router_ mengarahkan permintaan ke metode `store()` di `OrderController`.
    * _Controller_ memvalidasi data yang masuk.
    * _Controller_ membuat _record_ pesanan baru di tabel `orders` dan `order_details` menggunakan _Model_ Eloquent.
    * _Controller_ berinteraksi dengan _service_ pembayaran yang sesuai (misal: XenditService) untuk membuat sesi pembayaran.
    * _Controller_ mengembalikan respons JSON ke _frontend_ yang berisi ID pesanan dan detail pembayaran (misal: URL pembayaran Xendit).
3. **Frontend:** Aplikasi Vue.js menerima respons, lalu mengarahkan pengguna ke halaman pembayaran eksternal (Xendit) atau menampilkan instruksi pembayaran lebih lanjut.
