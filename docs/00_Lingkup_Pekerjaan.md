# 00 Lingkup Pekerjaan

## 1. Gambaran Umum Lingkup Proyek

Dokumen ini menguraikan lingkup pekerjaan untuk pengembangan **Platform E-commerce KIW B2B**. Platform ini adalah solusi e-commerce komprehensif yang dirancang khusus untuk transaksi _Business-to-Business_ (B2B), namun tetap fleksibel untuk digunakan dalam skenario _Business-to-Consumer_ (B2C).

## 2. Lingkup Pengerjaan (In Scope)

Fitur-fitur dan fungsionalitas berikut akan dikembangkan dan diimplementasikan dalam platform.

### Fitur Inti Platform

* **Manajemen Produk:**
  * Pengelolaan katalog produk yang terstruktur.
  * Manajemen kategori, _brand_, dan atribut produk (seperti ukuran, warna, dll.).
  * Dukungan untuk produk fisik dan digital.
  * Impor dan ekspor data produk massal via Excel.
* **Manajemen Pesanan (Order Management):**
  * Pelacakan dan pengelolaan pesanan dari masuk hingga selesai.
  * Pembaruan status pesanan secara otomatis dan manual.
  * Pembuatan _invoice_ (faktur) secara otomatis.
* **Manajemen Pelanggan:**
  * Pengelolaan akun pelanggan dan perusahaan.
  * Pembagian peran dan hak akses untuk pengguna di level perusahaan.
* **Keranjang Belanja dan Checkout:**
  * Fungsionalitas keranjang belanja standar e-commerce.
  * Proses _checkout_ yang aman dan mudah.
* **Integrasi Gerbang Pembayaran (Payment Gateway):**
  * Integrasi dengan berbagai penyedia layanan pembayaran, termasuk:
    * Stripe
    * PayPal
    * Xendit
    * Flutterwave (Rave)
* **Dukungan Multi-Mata Uang:** Kemampuan untuk menampilkan harga dan menerima pembayaran dalam berbagai mata uang.
* **Dukungan Multi-Bahasa:** Antarmuka yang dapat diterjemahkan bilingual.

### Panel Admin

* **Dasbor Komprehensif:** Tampilan terpusat untuk memantau seluruh aktivitas platform.
* **Manajemen Pengguna dan Peran:** Kontrol penuh atas akun pengguna (admin, penjual, pelanggan) dan hak aksesnya menggunakan _Role-Based Access Control_ (RBAC).
* **Manajemen Produk dan Inventaris:** Pengelolaan lengkap atas semua produk, stok, dan gudang.
* **Manajemen Pesanan dan Pembayaran:** Pemantauan dan pengelolaan semua transaksi.
* **Laporan dan Analitik:** Laporan penjualan, pelanggan, dan performa produk.

### Portal Penjual (Seller Portal)

* **Portal Khusus:** Antarmuka khusus bagi penjual untuk mengelola operasional mereka.
* **Manajemen Produk dan Pesanan Penjual:** Penjual dapat mengunggah produk, mengelola stok, dan memproses pesanan mereka sendiri.
* **Manajemen Keuangan Penjual:** Laporan pendapatan, penarikan dana (_withdrawal_).
* **Pendaftaran dan Verifikasi Penjual:** Alur untuk pendaftaran dan persetujuan penjual baru.

### Manajemen Kurir (Delivery Boy)

* **Aplikasi/Portal Kurir:** Fungsionalitas untuk mengelola kurir.
* **Penugasan Pesanan:** Admin dapat menugaskan pesanan ke kurir tertentu.
* **Pelacakan Pengiriman:** Pembaruan status pengiriman secara _real-time_.

### Pemasaran Afiliasi (Affiliate Marketing)

* **Program Afiliasi:** Sistem untuk mengelola program afiliasi.
* **Pelacakan Kinerja:** Afiliasi dapat melacak klik, konversi, dan komisi.
* **Manajemen Komisi dan Pembayaran:** Perhitungan komisi dan proses pembayaran ke afiliasi.

### Point of Sale (POS)

* **Sistem POS:** Antarmuka kasir untuk melayani penjualan _offline_ (di toko fisik).
* **Sinkronisasi Stok:** Sinkronisasi inventaris antara penjualan _online_ dan _offline_.

### Fitur Lainnya

* **Manajemen Pengembalian Dana (Refund):** Sistem terstruktur untuk menangani permintaan pengembalian dana dari pelanggan.
* **Blog:** Sistem manajemen konten (CMS) untuk publikasi artikel dan berita.
* **Notifikasi:** Notifikasi via email dan sistem untuk berbagai kejadian (pesanan baru, pembaruan status, dll.).
* **API (Application Programming Interface):** REST API untuk integrasi dengan sistem pihak ketiga.

## 3. Di Luar Lingkup Pengerjaan (Out of Scope)

* Setiap fitur atau fungsionalitas yang tidak disebutkan secara eksplisit di bagian "Lingkup Pengerjaan" dianggap di luar lingkup proyek ini.
* Pengembangan aplikasi _mobile native_ (iOS/Android) untuk pelanggan akhir (hanya antarmuka web responsif).
* Integrasi dengan sistem _Enterprise Resource Planning_ (ERP) atau _Customer Relationship Management_ (CRM) pihak ketiga yang tidak disebutkan.
