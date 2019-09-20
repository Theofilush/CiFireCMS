# CiFireCMS - Makes You Feel Home
CiFireCMS adalah platform CMS open source gratis dibuat dengan framework CodeIgniter3. CiFireCMS sangat cocok bagi pengguna yang familiar dengan engine PopojiCMS namun ingin merasakan performa dari framework CodeIgniter3.

## Sersyaratan System
CiFireCMS baik dijalankan pada web server Apache 2.4.x PHP 7.3.x dan PHP 5.6.x (PHP 5.6-Native Not recommended).

#### Ekstensi PHP yang harus diperhatikan
* pdo_mysql  ``ON``
* pdo_sqlite ``ON``
* json       ``ON``
* fileinfo   ``ON``
* intl       ``ON``

## Instalasi
1. Download source code CiFireCMS dari github atau dari situs resmi https://www.alweak.com. Pastikan ekstensi file adalah ``zip`` jika bukan silahkan ubah dan sesuaikan nama ekstensinya.
2. Extract file cifirecms.zip di directory web Anda. Pastikan file ``.htaccess`` ter-copy dengan baik.
3. Buat database baru untuk menampung semua tabel konfigurasi CiFireCMS.
```
# konfigurasi databse.
Database  = db_database
Collation = utf8_general_ci
```
4. Jalankan browser dan masuk ke alamat web anda. Jika tidak ada kesalahan, anda akan langsung di arahkan ke halaman instalasi CiFireCMS.
5. Ikuti dengan benar prosedur dan langkah-langkah instalasi.
6. Jika instalasi sudah selesai dan berhasil, jangan lupa untuk menghapus folder ``install`` dan file-file lainnya selain file ``index.php`` dan ``.htaccess``.
7. CiFireCMS siap digunakan.


## Konfigurasi Lanjutan

### Permission
Ubah user permission pada folder berikut menjadi 775.
```
folder-web-anda
├── content
│   ├── tmp     --> 775
│   ├── thumbs  --> 775
└── └── uploads --> 775
```

### Redirect
Konfigurasi file **.htaccess** standart seperti berikut.
```
RewriteEngine On
RewriteCond $1 !^(index\.php|resources|robots\.txt)
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L,QSA]
```

Untuk menentukan web anda di akses dengan alamat **http** atau **https** silahkan ubah konfigurasi file **.htaccess** tambahkan kode berikut di bawah baris kode ``RewriteEngine On``.

#### Redirect HTTP to HTTPS

```
# non-www to www.
RewriteCond %{HTTPS} off [OR]
RewriteCond %{HTTP_HOST} !^www\. [NC]
RewriteCond %{HTTP_HOST} ^(?:www\.)?(.+)$ [NC]
RewriteRule ^ https://www.%1%{REQUEST_URI} [L,NE,R=301]

# www to non-www.
RewriteCond %{HTTPS} off [OR]
RewriteCond %{HTTP_HOST} ^www\. [NC]
RewriteCond %{HTTP_HOST} ^(?:www\.)?(.+)$ [NC]
RewriteRule ^ https://%1%{REQUEST_URI} [L,NE,R=301]
```

#### Redirect HTTPS to HTTP
```
# non-www to www.
RewriteCond %{HTTPS} on [OR]
RewriteCond %{HTTP_HOST} !^www\. [NC]
RewriteCond %{HTTP_HOST} ^(?:www\.)?(.+)$ [NC]
RewriteRule ^ http://www.%1%{REQUEST_URI} [L,NE,R=301]

# www to non-www.
RewriteCond %{HTTPS} on [OR]
RewriteCond %{HTTP_HOST} ^www\. [NC]
RewriteCond %{HTTP_HOST} ^(?:www\.)?(.+)$ [NC]
RewriteRule ^ http://%1%{REQUEST_URI} [L,NE,R=301]
```

### Production
Jika web sudah di online-kan silahkan ubah kode pada **index.php**
Cari baris kode berikut :
```
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');
```
Ubah menjadi seperti berikut :
```
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'production');
```

## Halaman Administrator

* Masuk ke alamat ``http://nama-web-anda/l-admin``
* Masukkan data login seperti yg telah diinputkan pada saat proses instalasi.

#### Konfigurasi Mail SMTP.
```
 protocol    = SMTP or smtp
 smtp_host   = ssl://nama.smtp.host
 smtp_port   = 465
 smtp_crypto = ssl
 mailtype    = html
 charset     = iso-8859-1
```

# Terima Kasih Kepada
1. Tuhan Yang Maha Esa.
2. Semua rekan-rekan yang berkontribusi untuk CiFireCMS.
3. Codeigniter3 sebagai inti engine CiFireCMS.
4. Cizthemes (greeky) sebagai pembuat template frontend.
5. SemiColonWeb (Canvas) sebagai pembuat template frontend.
6. Kopyov (Limitless) sebagai pembuat template backend.
7. Creative-tim (Light Bootstrap Dashboard) sebagai pembuat template dasbor member.
8. Easy Menu Manager sebagai pembuat component menu manager.
9. Jquery, Bootstrap dan semua plugins jquery yang dipakai pada CiFireCMS.
10. DwiraSurvivor PopojiCMS untuk inspirasi, saran serta rekomendasi sehingga engine CiFireCMS bisa rilis.


# Lisensi

CiFireCMS dilisensikan di bawah MIT License.