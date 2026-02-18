# 01 Gambaran Umum Proyek

## Platform E-commerce B2B KIW

### Gambaran Umum

Platform E-commerce B2B KIW adalah sebuah solusi perangkat lunak multi-fungsi yang dirancang untuk memfasilitasi penjualan online untuk berbagai jenis bisnis. Fokus utamanya adalah pada model bisnis _Business-to-Business_ (B2B), namun platform ini juga menyertakan fungsionalitas yang dapat diadaptasi untuk model _Business-to-Consumer_ (B2C).

Platform ini mendukung berbagai peran pengguna, termasuk **Administrator**, **Penjual (Seller)**, **Kurir (Delivery Boy)**, dan **Afiliasi (Affiliate)**, di mana setiap peran memiliki antarmuka dan fungsionalitas khususnya masing-masing. Arsitektur multi-tenant (multi-penjual) memungkinkan berbagai penjual untuk bergabung, mengelola produk, dan menjual barang mereka dalam satu platform terpadu.

### Tujuan Proyek

* **Menyediakan Platform yang Tangguh dan Skalabel:** Membangun fondasi e-commerce yang kuat, aman, dan dapat berkembang seiring pertumbuhan bisnis.
* **Memfasilitasi Model Multi-Penjual:** Memungkinkan berbagai penjual untuk mengelola toko online mereka sendiri secara mandiri di bawah satu atap.
* **Meningkatkan Efisiensi Operasional:** Mengoptimalkan proses pemenuhan pesanan (order fulfillment) dengan sistem manajemen pengiriman yang terintegrasi.
* **Mendorong Pemasaran dan Penjualan:** Memberikan insentif untuk pemasaran dan penjualan melalui program afiliasi yang terintegrasi.
* **Menawarkan Pengalaman Pembayaran yang Mulus:** Menyediakan proses pembayaran yang aman dan mudah dengan berbagai pilihan gerbang pembayaran (payment gateway).
* **Memberikan Kontrol Penuh:** Menyediakan panel admin yang komprehensif bagi administrator untuk kontrol penuh atas seluruh aspek platform.

### Pengguna Target

* **Administrator Platform:** Bertanggung jawab atas pengelolaan keseluruhan platform, mengawasi semua operasional, mengelola pengguna, dan mengkonfigurasi sistem.
* **Penjual (Vendor/Seller):** Perusahaan atau individu yang menjual produk mereka di platform. Mereka memiliki akses ke portal penjual untuk mengelola produk, pesanan, dan keuangan mereka.
* **Pelanggan (Customer):** Perusahaan (dalam skenario B2B) atau individu (dalam skenario B2C) yang membeli produk dari platform.
* **Kurir (Delivery Boy):** Personil yang bertanggung jawab untuk pengiriman pesanan kepada pelanggan. Mereka memiliki akses ke aplikasi atau portal khusus untuk mengelola tugas pengiriman.
* **Afiliasi (Affiliate):** Pengguna atau pemasar yang mempromosikan produk di platform untuk mendapatkan komisi dari setiap penjualan yang berhasil.

### Domain dan Lingkungan Penggunaan

Platform ini akan diakses melalui beberapa antarmuka (domain) yang berbeda, disesuaikan untuk setiap peran pengguna:

* **Aplikasi Web Utama (Storefront):** Toko online utama yang diakses oleh pelanggan untuk melihat produk dan melakukan pembelian.
* **Panel Admin:** Antarmuka berbasis web untuk Administrator Platform.
* **Portal Penjual:** Antarmuka berbasis web untuk Penjual terdaftar.
* **Aplikasi/Portal Kurir:** Antarmuka yang dioptimalkan untuk Kurir (bisa berupa PWA atau aplikasi web responsif).
* **Portal Afiliasi:** Antarmuka berbasis web untuk para Afiliasi untuk melacak kinerja dan pendapatan mereka.
