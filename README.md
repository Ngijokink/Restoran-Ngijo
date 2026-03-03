# 🍽️ RESTORAN NGIJO

### Sistem Manajemen Restoran Berbasis Laravel

---

## 🟢 Tentang Project

**RESTORAN NGIJO** adalah sistem manajemen restoran berbasis **Laravel** yang dibuat untuk membantu pengelolaan:

* 🧾 Pemesanan makanan
* 💰 Transaksi & pembayaran
* 📦 Manajemen menu & stok
* 👨‍🍳 Dashboard admin & kasir
* 📊 Laporan penjualan

Project ini dibuat dengan konsep modern, clean, dan dominan warna hijau sesuai nama *NGIJO* 🌿

---

## 🚀 Fitur Utama

✨ **Authentication System**

* Login & Register
* Role: Admin / Kasir

🍔 **Manajemen Menu**

* Tambah, edit, hapus menu
* Upload gambar menu
* Kategori makanan & minuman
* Stok otomatis berkurang saat transaksi

🛒 **Sistem Pemesanan**

* Tambah ke keranjang
* Hitung total otomatis
* Pajak & diskon (optional)

💳 **Transaksi**

* Cetak struk
* Status pembayaran
* Riwayat transaksi

📊 **Dashboard**

* Total pendapatan
* Total transaksi
* Menu terlaris
* Grafik penjualan

📦 **Database Relasi**

* Users
* Categories
* Menus
* Orders
* Order Details
* Transactions

---

## 🛠️ Tech Stack

* ⚡ Laravel
* 🐘 MySQL
* 🎨 Bootstrap / Tailwind
* 🧠 JavaScript
* 📦 Composer
* 🔐 Laravel Auth

---

## 📂 Struktur Folder Penting

```
app/
 ├── Http/
 │    ├── Controllers/
 │    ├── Middleware/
 │
database/
 ├── migrations/
 ├── seeders/
 
resources/
 ├── views/
 ├── css/
 ├── js/
 
routes/
 ├── web.php
```

---

## ⚙️ Cara Install Project

### 1️⃣ Clone Repository

```bash
git clone https://github.com/username/restoran-ngijo.git
cd restoran-ngijo
```

### 2️⃣ Install Dependency

```bash
composer install
npm install
```

### 3️⃣ Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4️⃣ Buat Database

Buat database di MySQL dengan nama:

```
restongijo
```

Lalu atur `.env`:

```
DB_DATABASE=restongijo
DB_USERNAME=root
DB_PASSWORD=
```

### 5️⃣ Migrasi Database

```bash
php artisan migrate --seed
```

### 6️⃣ Jalankan Server

```bash
php artisan serve
```

Akses di:

```
http://127.0.0.1:8000
```

---

## 📸 Preview Tampilan

### 🟢 Halaman Dashboard

* Statistik penjualan
* Grafik transaksi
* Ringkasan menu

### 🍽️ Halaman Menu

* Card menu modern
* Gambar makanan
* Tombol tambah ke keranjang

### 🧾 Halaman Transaksi

* Detail pesanan
* Total harga
* Tombol bayar & cetak

---

## 🧩 Relasi Database (ERD Sederhana)

```
User
 └── hasMany Orders

Order
 └── hasMany OrderDetails

Menu
 └── belongsTo Category
```

---

## 🔥 Future Improvement

* 📱 Responsive lebih maksimal
* 🖨️ Print thermal receipt
* 📊 Export laporan ke Excel
* 💳 Payment Gateway
* 🧠 Sistem rekomendasi menu

---

## 👨‍💻 Developer

Dikembangkan oleh:
**NgijoKink** 🚀

SMK RPL — Future Web Developer

---

## 📜 License

Project ini dibuat untuk kebutuhan pembelajaran dan portfolio.


Tinggal bilang aja, kita bikin makin gila tampilannya 🔥
