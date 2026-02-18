# 06 Alur Bisnis B2B (B2B Business Flow)

Dokumen ini menjelaskan alur kerja dan fitur-fitur spesifik yang mendukung model bisnis _Business-to-Business_ (B2B) pada Platform E-commerce KIW.

## 1. Struktur Perusahaan Pelanggan (Company Structure)

Tidak seperti B2C di mana setiap pelanggan adalah individu, dalam B2B, pelanggan sering kali adalah sebuah perusahaan dengan banyak pengguna. Platform ini mengakomodasi hal tersebut melalui struktur berikut:

1. **Registrasi Perusahaan:** Perusahaan pelanggan mendaftar di platform. Akun pertama yang mendaftar akan bertindak sebagai **Admin Perusahaan**.
2. **Manajemen Pengguna Internal:** Admin Perusahaan dapat mengundang dan menambahkan pengguna lain dari perusahaan mereka (misal: staf pembelian, manajer) ke dalam platform.
3. **Peran & Hak Akses Internal:** Admin Perusahaan dapat menetapkan peran untuk setiap pengguna di dalam perusahaannya. Contoh peran:
    * **Staf Pembelian (Purchaser):** Dapat membuat keranjang belanja dan mengajukan pesanan untuk persetujuan.
    * **Manajer (Approver):** Dapat menyetujui atau menolak pesanan yang diajukan oleh Staf Pembelian dan melakukan _checkout_.
    * **Keuangan (Finance):** Dapat melihat riwayat transaksi dan mengunduh faktur.

## 2. Alur Transaksi (Transaction Flow)

Alur transaksi B2B memiliki beberapa perbedaan kunci dibandingkan B2C.

### 2.1. Penemuan Produk & Negosiasi (Opsional)

* **Katalog Tersegmentasi:** Harga produk dapat ditampilkan berbeda untuk grup pelanggan yang berbeda (misal: Pelanggan Gold mendapatkan diskon 10% untuk semua produk). Ini dikelola oleh Admin Platform melalui fitur _Offers_ atau kustomisasi pada level grup pelanggan.
* **Permintaan Penawaran (Request for Quote - RFQ):** Pelanggan B2B dapat mengumpulkan produk dalam jumlah besar ke dalam keranjang dan mengajukan RFQ alih-alih langsung _checkout_. Admin Platform kemudian dapat merespons dengan harga khusus.

### 2.2. Alur Pemesanan & Persetujuan

Berikut adalah contoh alur pemesanan di dalam satu perusahaan pelanggan:

1. **Pembuatan Pesanan oleh Staf:** `Staf Pembelian` login, memasukkan produk ke keranjang belanja, dan melanjutkan ke halaman _checkout_.
2. **Pengajuan untuk Persetujuan:** Alih-alih langsung membayar, `Staf Pembelian` akan melihat tombol "Ajukan untuk Persetujuan". Pesanan akan dibuat dengan status "Menunggu Persetujuan".
3. **Notifikasi ke Manajer:** `Manajer (Approver)` akan menerima notifikasi (email atau di dalam platform) bahwa ada pesanan baru yang memerlukan persetujuan.
4. **Proses Persetujuan:** `Manajer` login, meninjau detail pesanan. Dia dapat:
    * **Menyetujui Pesanan:** Pesanan berubah status menjadi "Disetujui, Menunggu Pembayaran". `Manajer` atau `Staf Keuangan` kemudian dapat melanjutkan ke proses pembayaran.
    * **Menolak Pesanan:** Pesanan dibatalkan. `Staf Pembelian` akan menerima notifikasi penolakan.
5. **Pembayaran:** Setelah disetujui, pembayaran dilakukan. Metode pembayaran B2B yang umum didukung:
    * **Transfer Bank (dengan konfirmasi manual/otomatis):** Sangat umum untuk transaksi B2B.
    * **Kartu Kredit Korporat.**
    * **Term of Payment (TOP) / Invoice:** Pembayaran dilakukan di kemudian hari setelah invoice diterbitkan (misal: 30 hari). Alur ini memerlukan persetujuan kredit manual dari Admin Platform.

### 2.3. Pemenuhan Pesanan

Setelah pembayaran dikonfirmasi, alur selanjutnya mirip dengan B2C:

1. Admin Penjual/Platform memproses pesanan.
2. Barang disiapkan dan dikirim.
3. Status pengiriman diperbarui dan dapat dilacak oleh pelanggan.

## 3. Fitur-Fitur Khusus B2B

Platform ini mendukung beberapa fitur kunci yang penting untuk lingkungan B2B:

* **Pemesanan Massal (Bulk Ordering):**
  * Antarmuka yang dioptimalkan untuk memesan banyak SKU sekaligus, sering kali dengan mengunggah file CSV atau melalui form _quick order_.
  * Fungsionalitas "Pesan Ulang" (_Reorder_) yang memudahkan untuk mengulang transaksi sebelumnya.
* **Manajemen Faktur (Invoice Management):**
  * Semua faktur dari transaksi yang telah selesai akan diarsipkan.
  * Pengguna dari perusahaan pelanggan (dengan izin yang sesuai) dapat mengunduh faktur dalam format PDF kapan saja.
* **Pelacakan dan Pelaporan:**
  * Admin Perusahaan dapat melihat laporan lengkap mengenai aktivitas pembelian semua pengguna di dalam organisasinya.
* **Kredit Pelanggan (Customer Credit Limit):**
  * Admin Platform dapat menetapkan batas kredit untuk pelanggan B2B terpercaya, memungkinkan mereka untuk melakukan pembelian dengan metode pembayaran _Term of Payment_.
