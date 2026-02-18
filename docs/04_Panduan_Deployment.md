# 04 Panduan Deployment

Dokumen ini memberikan panduan langkah demi langkah untuk melakukan _deployment_ (pemasangan) aplikasi E-commerce B2B KIW di server produksi.

## Prasyarat Server

Pastikan server produksi Anda memenuhi persyaratan berikut:

* **Sistem Operasi:** Linux (Ubuntu 22.04 LTS direkomendasikan)
* **Web Server:** Nginx (direkomendasikan) atau Apache
* **PHP:** Versi 8.2 atau lebih tinggi, dengan ekstensi berikut:
  * `Ctype`, `cURL`, `DOM`, `Fileinfo`, `Filter`, `Hash`, `Mbstring`, `OpenSSL`, `PCRE`, `PDO`, `Session`, `Tokenizer`, `XML`, `GD`, `Zip`
* **Database:** MySQL 8.0 atau lebih tinggi
* **Cache/Queue:** Redis Server
* **Tools:**
  * `Git` (untuk mengambil kode dari repositori)
  * `Composer` (untuk menginstal dependensi PHP)
  * `Node.js` (v18 atau lebih tinggi) dan `Yarn`/`NPM` (untuk membangun aset frontend)
  * `Supervisor` (untuk menjalankan proses antrian/queue di latar belakang)

## Langkah-langkah Deployment

### 1. Dapatkan Kode Aplikasi

Clone repositori proyek dari sumbernya ke direktori server Anda (misal: `/var/www/kiw-ecommerce`).

```bash
git clone [URL repositori Anda] /var/www/kiw-ecommerce
cd /var/www/kiw-ecommerce
```

### 2. Konfigurasi Backend (Laravel)

1. **Instal Dependensi PHP:**

    ```bash
    composer install --no-dev --optimize-autoloader
    ```

    * `--no-dev`: Mengabaikan paket yang hanya dibutuhkan untuk pengembangan.
    * `--optimize-autoloader`: Mengoptimalkan autoloader Composer untuk performa.

2. **Buat File Konfigurasi Lingkungan (`.env`):**
    Salin file contoh `.env.example` menjadi `.env`.

    ```bash
    cp .env.example .env
    ```

3. **Hasilkan Kunci Aplikasi:**
    Ini penting untuk enkripsi dan keamanan.

    ```bash
    php artisan key:generate
    ```

4. **Konfigurasi `.env`:**
    Buka file `.env` dan sesuaikan variabel berikut sesuai dengan lingkungan produksi Anda:

    ```ini
    # Informasi Aplikasi
    APP_NAME="KIW Commerce"
    APP_ENV=production
    APP_DEBUG=false
    APP_URL=https://domain-anda.com

    # Koneksi Database
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database_anda
    DB_USERNAME=user_database_anda
    DB_PASSWORD=password_database_anda

    # Koneksi Redis
    REDIS_HOST=127.0.0.1
    REDIS_PASSWORD=null
    REDIS_PORT=6379

    # Konfigurasi Antrian (Queue)
    QUEUE_CONNECTION=redis

    # Konfigurasi Email (Contoh menggunakan SMTP)
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.mailgun.org
    MAIL_PORT=587
    MAIL_USERNAME=user_smtp
    MAIL_PASSWORD=pass_smtp
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS="noreply@domain-anda.com"
    MAIL_FROM_NAME="${APP_NAME}"

    # Konfigurasi API Key Pihak Ketiga
    # (Stripe, Xendit, AWS S3, dll.)
    STRIPE_KEY=...
    XENDIT_SECRET_KEY=...
    AWS_ACCESS_KEY_ID=...
    # ... dan seterusnya
    ```

5. **Jalankan Migrasi dan Seeder Database:**
    Perintah ini akan membuat semua tabel database yang diperlukan. Jalankan _seeder_ hanya jika diperlukan untuk data awal.

    ```bash
    php artisan migrate --force
    # Opsional: php artisan db:seed --force
    ```

    * `--force`: Diperlukan saat menjalankan migrasi di lingkungan produksi untuk melewati konfirmasi.

6. **Buat Symbolic Link untuk Penyimpanan:**
    Ini akan membuat folder `public/storage` dapat diakses secara publik.

    ```bash
    php artisan storage:link
    ```

7. **Optimasi Konfigurasi:**
    Cache file konfigurasi dan rute untuk meningkatkan performa.

    ```bash
    php artisan config:cache
    php artisan route:cache
    ```

### 3. Bangun Aset Frontend (Vue.js)

1. **Instal Dependensi Frontend:**

    ```bash
    yarn install
    # atau jika menggunakan npm:
    # npm install
    ```

2. **Bangun Aset untuk Produksi:**
    Perintah ini akan mengkompilasi dan mem-bundle semua file JavaScript dan CSS ke dalam direktori `public/build`.

    ```bash
    yarn build
    # atau jika menggunakan npm:
    # npm run build
    ```

### 4. Konfigurasi Web Server (Contoh Nginx)

Buat file konfigurasi server baru untuk domain Anda di `/etc/nginx/sites-available/domain-anda.com`.

```nginx
server {
    listen 80;
    server_name domain-anda.com www.domain-anda.com;
    root /var/www/kiw-ecommerce/public;

    # Redirect http to https
    # location / {
    #    return 301 https://$server_name$request_uri;
    # }
}

server {
    listen 443 ssl http2;
    server_name domain-anda.com www.domain-anda.com;
    root /var/www/kiw-ecommerce/public;

    # SSL configuration (jika menggunakan HTTPS)
    # ssl_certificate /etc/letsencrypt/live/domain-anda.com/fullchain.pem;
    # ssl_certificate_key /etc/letsencrypt/live/domain-anda.com/privkey.pem;
    # include /etc/letsencrypt/options-ssl-nginx.conf;
    # ssl_dhparam /etc/letsencrypt/ssl-dhparams.pem;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Aktifkan situs dan restart Nginx:

```bash
sudo ln -s /etc/nginx/sites-available/domain-anda.com /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

### 5. Konfigurasi Supervisor

Supervisor akan memastikan proses antrian (queue worker) tetap berjalan. Buat file konfigurasi baru di `/etc/supervisor/conf.d/kiw-worker.conf`.

```ini
[program:kiw-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/kiw-ecommerce/artisan queue:work redis --sleep=3 --tries=3 --daemon
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/kiw-ecommerce/storage/logs/worker.log
```

Muat ulang dan mulai Supervisor:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start kiw-worker:*
```

### 6. Atur Hak Akses (Permissions)

Pastikan web server memiliki hak tulis ke direktori `storage` dan `bootstrap/cache`.

```bash
sudo chown -R www-data:www-data /var/www/kiw-ecommerce
sudo find /var/www/kiw-ecommerce -type f -exec chmod 644 {} \;
sudo find /var/www/kiw-ecommerce -type d -exec chmod 755 {} \;
sudo chmod -R 775 /var/www/kiw-ecommerce/storage
sudo chmod -R 775 /var/www/kiw-ecommerce/bootstrap/cache
```

Setelah semua langkah ini selesai, aplikasi Anda seharusnya sudah dapat diakses melalui domain yang telah dikonfigurasi.
