# 07 Keamanan & Kontrol Akses

Dokumen ini menguraikan langkah-langkah keamanan, praktik terbaik, dan mekanisme kontrol akses yang diimplementasikan dalam Platform E-commerce B2B KIW.

## 1. Otentikasi (Authentication)

Otentikasi adalah proses verifikasi identitas pengguna. Platform ini menggunakan metode yang berbeda untuk mengamankan berbagai bagiannya.

* **Otentikasi Web (Frontend & Panel Admin):**
  * Menggunakan sistem otentikasi sesi bawaan Laravel (`laravel/ui`).
  * Saat pengguna login, sebuah sesi dibuat di server dan _cookie_ sesi yang aman (terenkripsi) dikirim ke _browser_ pengguna untuk menjaga status login.
* **Otentikasi API:**
  * Menggunakan **Laravel Passport** (implementasi OAuth2).
  * Setiap kali aplikasi _frontend_ (Vue.js) perlu berkomunikasi dengan API _backend_, ia harus menyertakan _access token_ di dalam _header_ permintaan.
  * _Middleware_ `auth:api` pada rute API akan memvalidasi _token_ ini untuk memastikan permintaan berasal dari sumber yang sah.
* **Login Sosial (Socialite):**
  * Memungkinkan pengguna untuk mendaftar dan login menggunakan akun pihak ketiga seperti Google atau Facebook, mengurangi kebutuhan pengguna untuk mengingat kata sandi baru.

## 2. Otorisasi (Authorization) - Kontrol Akses

Otorisasi adalah proses menentukan apakah pengguna yang terotentikasi memiliki izin untuk mengakses sumber daya atau melakukan tindakan tertentu.

* **Pola: Role-Based Access Control (RBAC)**
  * Platform ini menggunakan pustaka `spatie/laravel-permission` untuk menerapkan RBAC.
  * **Izin (Permission):** Tindakan spesifik yang dapat dilakukan (misal: `edit_products`, `delete_users`, `access_admin_dashboard`).
  * **Peran (Role):** Sekumpulan izin. Sebuah peran (misal: "Admin", "Manajer Toko", "Penjual") dapat memiliki beberapa izin.
  * **Penetapan:** Setiap pengguna diberi satu atau lebih peran. Akses mereka ke fitur-fitur tertentu kemudian ditentukan oleh izin yang dimiliki oleh peran mereka.

* **Implementasi:**
  * **Middleware Rute:** Rute-rute penting dilindungi oleh _middleware_ `permission`. Contoh di `routes/admin.php`:

        ```php
        Route::group(['middleware' => ['auth', 'admin']], function () {
            // Hanya pengguna dengan peran 'admin' yang bisa mengakses rute di grup ini.
        });

        Route::view('/system/server-status', 'backend.system.server_status')
             ->middleware('permission:server_status') // Hanya pengguna dengan izin 'server_status'
             ->name('server_status');
        ```

  * **Pengecekan di Kode:** Di dalam _controller_ atau _view_, logika dapat ditambahkan untuk memeriksa peran atau izin pengguna sebelum menampilkan tombol atau mengeksekusi tindakan.

## 3. Praktik Keamanan Platform

Platform ini menerapkan berbagai praktik keamanan standar untuk melindungi dari ancaman umum.

### Keamanan Aplikasi Web

* **Pencegahan Cross-Site Scripting (XSS):**
  * Laravel Blade (`{{ }}`) secara otomatis menyaring _(escapes)_ semua output untuk mencegah kode berbahaya dieksekusi di _browser_ pengguna.
  * Vue.js juga secara inheren menyaring output pada _template_-nya.
* **Pencegahan Cross-Site Request Forgery (CSRF):**
  * Semua permintaan `POST`, `PUT`, `PATCH`, atau `DELETE` ke aplikasi web secara otomatis diverifikasi untuk token CSRF. Ini mencegah pihak ketiga jahat untuk membuat permintaan atas nama pengguna yang sedang login.
* **Pencegahan SQL Injection:**
  * Penggunaan **Eloquent ORM** dan **Query Builder** Laravel secara default menggunakan _PHP PDO parameter binding_. Ini memastikan bahwa input dari pengguna tidak dapat dimanipulasi untuk menjalankan query SQL yang berbahaya.
* **Enkripsi Kata Sandi:**
  * Semua kata sandi pengguna di-_hash_ menggunakan algoritma `bcrypt` yang kuat sebelum disimpan ke database. Kata sandi asli tidak pernah disimpan.
* **Enkripsi Data Sensitif:**
  * Laravel menyediakan fungsi enkripsi bawaan yang dapat digunakan untuk mengenkripsi data sensitif (misal: API keys) sebelum menyimpannya di database.

### Keamanan Pihak Ketiga

* **Google reCAPTCHA:**
  * Diimplementasikan pada form-form penting seperti registrasi dan login untuk mencegah serangan _bot_ otomatis.
* **Manajemen Kredensial:**
  * Semua kunci API dan kredensial untuk layanan pihak ketiga (seperti payment gateway, AWS S3) disimpan dengan aman di dalam file `.env` dan tidak pernah dimasukkan langsung ke dalam kode (_hardcoded_) atau repositori Git.

## 4. Catatan Produksi

* **HTTPS/SSL:** Sangat penting untuk menginstal sertifikat SSL/TLS di server produksi. Ini akan mengenkripsi semua komunikasi antara _browser_ pengguna dan server, melindungi data dari penyadapan.
* **File `.env`:** Pastikan file `.env` tidak dapat diakses secara publik dari web. Konfigurasi web server (Nginx/Apache) yang benar akan mencegah akses ke file ini.
* **Mode Debug:** Di lingkungan produksi, pastikan `APP_DEBUG` di file `.env` diatur ke `false`. Ini akan mencegah tampilan informasi _error_ yang detail yang dapat dieksploitasi oleh penyerang.
* **Pembaruan Reguler:** Selalu perbarui _framework_ Laravel dan dependensi lainnya secara berkala untuk mendapatkan _patch_ keamanan terbaru.
