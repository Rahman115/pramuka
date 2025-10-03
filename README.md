# PRAMUKA BUTON UTARA

Sistem Manajemen Data Organisasi Pramuka Kabupaten Buton Utara

## DESKRIPSI

Sistem ini merupakan aplikasi web untuk mengelola data organisasi Pramuka di wilayah Kabupaten Buton Utara. Aplikasi ini menyediakan fitur manajemen data anggota, gugus depan (gudep), kwarcab, dkc, pendamping, dan peserta didik.

## FITUR UTAMA

- **Dashboard** - Tampilan utama dengan ringkasan data
- **Manajemen Anggota** - Kelola data anggota pramuka
- **Manajemen Gudep** - Kelola data gugus depan
- **Manajemen Kwarcab** - Kelola data kwartir cabang
- **Manajemen DKC** - Kelola data dewan kerajatan cabang
- **Manajemen Pendamping** - Kelola data pendamping
- **Manajemen Peserta Didik** - Kelola data peserta didik

## TEKNOLOGI

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Architecture**: MVC (Model-View-Controller)
- **Styling**: CSS custom

## STRUKTUR FILE

```
pramuka-system/
├── index.php
├── config/
│   └── database.php
├── models/
│   ├── AnggotaModel.php
│   ├── GudepModel.php
│   ├── KwarcabModel.php
│   ├── DkcModel.php
│   ├── PendampingModel.php
│   └── PesertaDidikModel.php
├── views/
│   ├── header.php
│   ├── footer.php
│   ├── dashboard.php
│   ├── anggota/
│   │   ├── list.php
│   │   ├── form.php
│   │   └── detail.php
│   ├── gudep/
│   │   ├── list.php
│   │   ├── form.php
│   │   └── detail.php
│   ├── kwarcab/
│   │   ├── list.php
│   │   ├── form.php
│   │   └── detail.php
│   ├── dkc/
│   │   ├── list.php
│   │   ├── form.php
│   │   └── detail.php
│   ├── pendamping/
│   │   ├── list.php
│   │   ├── form.php
│   │   └── detail.php
│   └── peserta/
│       ├── list.php
│       ├── form.php
│       └── detail.php
└── assets/
    ├── css/
    │   └── style.css
    └── js/
        └── script.js
```

## INSTALASI

1. Clone atau download project ke folder web server (htdocs untuk XAMPP)
2. Setup database:

- Buat database baru di MySQL
- Import file SQL yang tersedia (jika ada)
- Sesuaikan konfigurasi di config/database.php

3. Konfigurasi:

- Edit file config/database.php dengan kredensial database yang sesuai
- Pastikan web server mendukung PHP

4. Akses aplikasi:

- Buka browser
- Akses http://localhost/pramuka-system

## KONFIGURASI DATABASE

Edit file config/database.php dengan informasi database Anda:

```php
<?php
$host = 'localhost';
$username = 'username_db';
$password = 'password_db';
$database = 'nama_database';
?>
```

## PENGGUNAAN

1. **Dashboard**: Akses halaman utama untuk melihat ringkasan data
2. **Manajemen Data**: Gunakan menu untuk mengelola berbagai entitas data
3. **CRUD Operations**: Setiap modul mendukung Create, Read, Update, Delete
4. **Navigasi**: Gunakan menu navigasi untuk berpindah antara modul

## KONTRIBUSI

Untuk berkontribusi dalam pengembangan sistem ini, silakan hubungi administrator.

## LISENSI

Sistem ini dikembangkan untuk internal organisasi Pramuka Kabupaten Buton Utara.

## DUKUNGAN

Untuk bantuan teknis atau pertanyaan, silakan hubungi:

- Tim IT Pramuka Buton Utara
- **Email**: support@pramukabutonutara.org

---

© 2025 Pramuka Kabupaten Buton Utara
