# Toko Online - CodeIgniter 4 (UAS Pemrograman Web Lanjut)

Aplikasi Toko Online berbasis **CodeIgniter 4** yang dilengkapi dengan fitur manajemen produk, keranjang belanja, integrasi ongkir otomatis (RajaOngkir), manajemen diskon, serta RESTful API. Proyek ini dikerjakan untuk memenuhi Ujian Akhir Semester (UAS) mata kuliah Pemrograman Web Lanjut.

## 🚀 Fitur Utama
- **Autentikasi User & Admin** (Login/Logout)
- **Katalog Produk** (Admin CRUD & Tampilan Home)
- **Keranjang Belanja (Cart) & Checkout**
- **Integrasi RajaOngkir** (Cek ongkos kirim otomatis)
- **Manajemen Diskon (New!)** 
  - CRUD diskon (Admin only) dengan validasi tanggal unik.
  - Tampilan otomatis harga coret dan badge diskon di frontend.
  - Perhitungan otomatis pemotongan harga di keranjang dan checkout.
- **Manajemen Pembelian (New!)** 
  - Admin dapat memantau seluruh transaksi dan mengubah status pesanan.
- **RESTful Webservice API** 
  - Endpoint API untuk Produk (`/api/products`)
  - Endpoint API untuk Diskon (`/api/discounts`)
  - Endpoint API untuk Transaksi (`/api/transactions`)

## 🛠️ Persyaratan Sistem
- PHP >= 8.1
- MySQL / MariaDB
- Composer
- Ekstensi PHP: `intl`, `mbstring`, `json`, `curl`

## ⚙️ Instalasi dan Setup

1. **Clone repository ini**
   ```bash
   git clone <url-repo-anda>
   cd belajar-ci
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Konfigurasi Environment (.env)**
   - Copy file `env` menjadi `.env`:
     ```bash
     cp env .env
     ```
   - Buka file `.env` dan atur konfigurasi database, pastikan Anda juga sudah membuat database (misalnya `ci4`) di MySQL Anda:
     ```env
     database.default.hostname = localhost
     database.default.database = ci4
     database.default.username = root
     database.default.password = 
     database.default.DBDriver = MySQLi
     ```

4. **Jalankan Migrasi & Seeder**
   Untuk membuat seluruh tabel dan mengisi data dummy (User, Product, Discount):
   ```bash
   php spark migrate
   php spark db:seed UserSeeder
   php spark db:seed ProductSeeder
   php spark db:seed DiscountSeeder
   ```

5. **Jalankan Server Lokal**
   ```bash
   php spark serve
   ```
   Aplikasi dapat diakses melalui `http://localhost:8080`

## 🧪 Testing REST API
Project ini menyediakan file `.rest` yang bisa digunakan dengan ekstensi **REST Client** di VS Code untuk menguji API secara langsung:
- `tests/api/products.rest` (CRUD Produk)
- `tests/api/discount.rest` (CRUD Diskon)
- `tests/api/transactions.rest` (Transaksi)
- `tests/api/destinations.rest` (Ongkir)

## 👤 Akun Default (Admin)
- **Username**: aris (sesuaikan dengan data `UserSeeder`)
- **Password**: admin123 (sesuaikan dengan `UserSeeder`)
- **Role**: Admin

*(Silakan cek database atau `UserSeeder` jika login gagal untuk memastikan kredensial yang tepat).*
