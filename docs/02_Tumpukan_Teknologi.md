# 02 Tumpukan Teknologi (Tech Stack)

Dokumen ini merinci teknologi, _framework_, dan pustaka (libraries) yang digunakan dalam pengembangan Platform E-commerce B2B KIW.

## Backend

* **Bahasa Pemrograman:** PHP 8.2
* **Framework Utama:** Laravel 10
* **Manajemen Dependensi:** Composer
* **API & Otentikasi:**
  * **Laravel Passport:** Untuk otentikasi API berbasis OAuth2, digunakan untuk mengamankan _endpoint_ API.
  * **Laravel Sanctum/UI:** Untuk otentikasi sesi pada aplikasi web.
* **Manajemen Peran & Hak Akses:**
  * **Spatie Laravel Permission:** Untuk mengelola peran (_roles_) dan izin (_permissions_) pengguna secara dinamis.
* **Integrasi Pihak Ketiga:**
  * **Guzzle HTTP Client:** Untuk melakukan pemanggilan HTTP ke API eksternal.
  * **Laravel Socialite:** Untuk fungsionalitas login menggunakan akun media sosial (misal: Google, Facebook).
* **Pemrosesan Data & File:**
  * **Maatwebsite/Laravel-Excel:** Untuk fungsionalitas impor dan ekspor data dalam format Excel.
  * **Intervention/Image:** Untuk memanipulasi dan memproses gambar (misal: _resizing_, _cropping_, _watermarking_).
  * **Niklasravnsborg/laravel-pdf:** Untuk generate dokumen PDF (misal: invoice).
  * **League/Flysystem (AWS S3 Adapter):** Untuk abstraksi _filesystem_, memungkinkan penyimpanan file di layanan seperti Amazon S3.
* **Integrasi Pembayaran:**
  * `stripe/stripe-php`
  * `paypal/paypal-checkout-sdk`
  * `xendit/xendit-php`
  * `kingflamez/laravelrave` (Flutterwave)
* **Lainnya:**
  * **Laravolt/Indonesia:** Untuk data wilayah administratif Indonesia (provinsi, kota/kabupaten).

## Frontend

* **Framework Utama:** Vue.js 3
* **Build Tool & Development Server:** Vite
* **Manajemen Dependensi:** Yarn / NPM
* **Manajemen State (State Management):** Vuex
* **Routing:** Vue Router
* **UI Framework & Komponen:**
  * **Vuetify:** Framework komponen Material Design untuk membangun antarmuka pengguna yang kaya fitur.
  * **Swiper & Vue Slick Carousel:** Untuk komponen _slider_ dan _carousel_.
  * **Line Awesome & MDI Font:** Untuk ikonografi.
* **Komunikasi dengan Backend:**
  * **Axios:** Untuk melakukan permintaan HTTP ke API backend.
* **Styling:**
  * **Sass (SCSS):** _Preprocessor_ CSS untuk penulisan gaya yang lebih terstruktur.
* **Internasionalisasi (i18n):**
  * **Vue-i18n:** Untuk mendukung multi-bahasa pada antarmuka frontend.
* **Lainnya:**
  * **Vue-Lazyload:** Untuk _lazy loading_ gambar, meningkatkan performa _loading_ halaman.
  * **Vuelidate:** Untuk validasi form di sisi klien.

## Infrastruktur & Database

* **Database Relasional:** MySQL. Konfigurasi detail terdapat di `config/database.php`.
* **Database In-Memory / Cache:** Redis (terindikasi dari adanya file `dump.rdb`). Digunakan untuk _caching_, _session storage_, dan _queue management_ untuk meningkatkan performa.
* **Web Server:** Apache atau Nginx (umum digunakan untuk aplikasi Laravel). File `.htaccess` mengindikasikan kemungkinan penggunaan Apache.
* **Lingkungan Pengembangan Lokal:** Laravel Sail (berbasis Docker) atau XAMPP/WAMP.

## Perkakas Pengembangan (Dev Tools)

* **Debugging:**
  * **Barryvdh/Laravel-Debugbar:** Menambahkan _toolbar_ debug pada aplikasi untuk memudahkan inspeksi _request_, _query_, dll.
  * **Spatie/Laravel-Ignition:** Halaman _error_ yang informatif untuk Laravel.
* **Code Quality & Helpers:**
  * **Barryvdh/Laravel-ide-helper:** Menghasilkan file _helper_ untuk meningkatkan _autocompletion_ di IDE.
  * **Laravel Pint:** _Code formatter_ untuk menjaga konsistensi gaya penulisan kode PHP.
