# 05 Panduan Admin

Dokumen ini adalah panduan untuk mengelola Platform E-commerce B2B KIW melalui Panel Admin.

**URL Akses:** `https://domain-anda.com/admin`

## 1. Dasbor (Dashboard)

Setelah login, Anda akan disambut oleh Dasbor utama. Halaman ini memberikan ringkasan statistik penting dari seluruh platform, seperti:

* Total penjualan
* Jumlah pesanan
* Jumlah pelanggan
* Jumlah penjual (jika fitur multi-vendor aktif)
* Grafik penjualan dalam rentang waktu tertentu.

## 2. Manajemen Katalog Produk

Bagian ini digunakan untuk mengelola semua aspek yang berkaitan dengan produk.

### 2.1. Produk

* **Lokasi:** `Produk > Produk`
* **Fungsi:**
  * **Tambah Produk Baru:** Membuat produk baru, baik fisik maupun digital. Anda dapat mengisi detail seperti nama, deskripsi, harga, stok, gambar, dan varian.
  * **Edit & Hapus Produk:** Mengubah detail produk yang sudah ada atau menghapusnya.
  * **Kelola Varian:** Menentukan varian produk berdasarkan atribut (misal: Baju dengan varian Ukuran S/M/L dan Warna Merah/Biru).
  * **Publikasi:** Mengatur status produk (dipublikasikan atau draft).
  * **Persetujuan Produk Penjual:** Jika multi-vendor aktif, admin dapat menyetujui atau menolak produk yang diunggah oleh penjual.

### 2.2. Kategori, Merek, dan Atribut

* **Lokasi:** `Produk > Kategori` / `Merek` / `Atribut`
* **Fungsi:**
  * **Kategori:** Membuat dan mengelola struktur kategori produk (misal: Elektronik > Handphone).
  * **Merek (Brand):** Mengelola daftar merek produk yang tersedia.
  * **Atribut:** Mendefinisikan atribut yang dapat digunakan untuk varian produk (misal: Ukuran, Warna, Bahan).

### 2.3. Impor & Ekspor Massal

* **Lokasi:** `Produk > Impor/Ekspor Massal`
* **Fungsi:**
  * **Ekspor Produk:** Mengunduh data semua produk dalam format CSV/Excel.
  * **Impor Produk:** Menambahkan atau memperbarui produk dalam jumlah besar dengan mengunggah file CSV/Excel. Ini sangat menghemat waktu dibandingkan input satu per satu. Tersedia template file yang bisa diunduh.

## 3. Penjualan

Bagian ini mencakup semua fungsionalitas yang terkait dengan proses penjualan dan pesanan.

### 3.1. Pesanan (Orders)

* **Lokasi:** `Penjualan > Pesanan`
* **Fungsi:**
  * Melihat daftar semua pesanan yang masuk.
  * Memfilter pesanan berdasarkan status (Menunggu Pembayaran, Diproses, Dikirim, Selesai, Dibatalkan).
  * Melihat detail setiap pesanan, termasuk produk yang dibeli, alamat pengiriman, dan informasi pelanggan.
  * **Memperbarui Status:** Mengubah status pembayaran (misal: dari `unpaid` menjadi `paid`) dan status pengiriman (misal: dari `processing` menjadi `shipped`).
  * **Cetak Faktur (Invoice):** Menghasilkan dan mengunduh faktur dalam format PDF untuk setiap pesanan.

### 3.2. Kupon & Penawaran

* **Lokasi:** `Pemasaran > Kupon` / `Penawaran`
* **Fungsi:**
  * **Kupon:** Membuat kode kupon diskon (potongan harga tetap atau persentase) yang dapat digunakan pelanggan saat checkout.
  * **Penawaran (Offers):** Membuat kampanye promosi atau diskon untuk produk atau kategori tertentu dalam periode waktu terbatas.

## 4. Manajemen Pengguna

### 4.1. Pelanggan

* **Lokasi:** `Pelanggan > Daftar Pelanggan`
* **Fungsi:**
  * Melihat daftar semua pelanggan yang terdaftar.
  * Melihat detail profil pelanggan.
  * **Ban/Unban:** Memblokir atau membuka blokir akses pelanggan.
  * **Login as Customer:** Masuk sebagai pelanggan tertentu untuk melihat tampilan dari sisi mereka atau membantu menyelesaikan masalah.

### 4.2. Staf & Peran

* **Lokasi:** `Pengaturan > Staf` / `Peran Staf`
* **Fungsi:**
  * **Peran (Roles):** Membuat peran baru (misal: Manajer Gudang, Staf Keuangan) dan menentukan izin (permissions) apa saja yang dimiliki oleh peran tersebut.
  * **Staf:** Menambahkan akun staf baru dan menetapkan peran yang sesuai. Ini memungkinkan pendelegasian tugas tanpa memberikan akses penuh ke panel admin.

## 5. Pengaturan Situs Web

Bagian ini digunakan untuk mengkonfigurasi tampilan dan konten situs web.

* **Lokasi:** `Pengaturan Situs Web`
* **Fungsi:**
  * **Header & Footer:** Mengatur elemen yang muncul di bagian atas dan bawah situs.
  * **Halaman (Pages):** Membuat halaman statis seperti "Tentang Kami", "Kebijakan Privasi", atau "Syarat & Ketentuan".
  * **Tampilan (Appearance):** Mengubah logo, favicon, dan skema warna dasar situs.
  * **Blog:** Mengelola kategori dan postingan blog untuk keperluan content marketing.

## 6. Konfigurasi Sistem

Bagian ini berisi pengaturan teknis dan fungsional platform.

* **Lokasi:** `Pengaturan`
* **Fungsi:**
  * **Pengaturan Umum:** Mengatur nama aplikasi, zona waktu, mata uang default, dll.
  * **Metode Pembayaran:** Mengaktifkan/menonaktifkan dan mengkonfigurasi kredensial untuk setiap gerbang pembayaran (Stripe, Xendit, dll.).
  * **Konfigurasi Pengiriman:** Mengatur zona pengiriman, negara/provinsi/kota yang dijangkau, dan biaya pengiriman.
  * **Pengaturan SMTP:** Mengkonfigurasi server email yang digunakan untuk mengirim semua email transaksional (notifikasi pesanan, reset password, dll.).
  * **Bahasa:** Mengelola bahasa yang tersedia di platform dan menambahkan terjemahan baru.
  * **Pajak (Taxes):** Mengatur tarif pajak yang berbeda jika diperlukan.

## 7. Komunikasi

* **Lokasi:** `Pertanyaan Produk` / `Obrolan (Chats)`
* **Fungsi:**
  * **Pertanyaan Produk:** Membalas pertanyaan yang diajukan oleh pelanggan pada halaman detail produk.
  * **Obrolan:** Jika fitur live chat diaktifkan, admin dapat berkomunikasi langsung dengan pengunjung situs.

## Catatan Penting

* **Hati-hati saat menghapus:** Data seperti produk, pesanan, atau pelanggan yang dihapus umumnya tidak dapat dikembalikan.
* **Cache:** Setelah melakukan perubahan pada konfigurasi, terkadang Anda perlu membersihkan cache agar perubahan tersebut diterapkan. Gunakan tombol **Clear Cache** yang biasanya tersedia di menu admin.
* **Peran & Izin:** Manfaatkan sistem peran dan izin dengan baik untuk menjaga keamanan dan membatasi akses staf hanya pada bagian yang mereka butuhkan.
