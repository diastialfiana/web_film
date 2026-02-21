# movie_web
🎬 Movie App – Laravel 5

Aplikasi web berbasis Laravel 5 yang menampilkan daftar film menggunakan OMDb API, dilengkapi fitur login, pencarian, detail movie, favorite movie, multi-language (EN/ID), infinite scroll, dan lazy load gambar.

📌 Features

🔐 Login Authentication (Static Credential)

🎥 List Movie (Infinite Scroll)

🔎 Search Movie (Multiple Parameters)

📄 Detail Movie

❤️ Add / Remove Favorite Movie

🌍 Multi Language (EN / ID) – Default EN

🖼 Lazy Load Image

❌ Error Message jika credential salah

🏗 Architecture

Aplikasi ini menggunakan arsitektur MVC (Model-View-Controller) yang diterapkan oleh Laravel.

Struktur MVC:

Model

Movie

Favorite

User (default Laravel)

View

Blade Template

Localization (resources/lang/en & id)

Controller

AuthController

MovieController

FavoriteController

Flow Aplikasi:

User Login

Jika valid → Redirect ke List Movie

User dapat:

Search Movie

Scroll untuk load data berikutnya (Infinite Scroll)

Klik Movie → Detail

Tambah / Hapus Favorite

Favorite Movie tersimpan di database

🛠 Libraries & Technologies Used
Library / Tools	Keterangan
Laravel 5.x	PHP Framework
Bootstrap	UI Styling
jQuery	DOM Manipulation & AJAX
OMDb API	Movie Data Source
Axios / AJAX	Fetch API Data
MySQL	Database
Laravel Localization	Multi Language
🔐 Login Credential

Sebelum mengakses List Movie dan Detail Movie, user wajib login menggunakan:

Username : aldmic
Password : 123abc123

Jika credential salah → sistem akan menampilkan pesan error:

"Invalid username or password"

🎥 Halaman List Movie

Fitur:

Menampilkan daftar movie dari OMDb API

Infinite Scroll untuk load data selanjutnya

Lazy Load untuk gambar movie

Search berdasarkan:

Title

Year

Type (Movie / Series / Episode)

Tombol Add to Favorite

📄 Halaman Detail Movie

Menampilkan:

Poster

Title

Year

Genre

Director

Plot

Rating

Tombol Add / Remove Favorite

❤️ Halaman Favorite Movie

Menampilkan daftar movie yang sudah ditambahkan ke favorite.

Fitur:

List favorite movie

Remove dari favorite

Data tersimpan di database

🌍 Multi Language (EN / ID)

Default language: English

User dapat mengganti bahasa

Berlaku hanya untuk static text (button, label, message)

Tidak berlaku untuk data dari OMDb API

Contoh file:

resources/lang/en/messages.php
resources/lang/id/messages.php
🖼 Infinite Scroll Implementation

Menggunakan AJAX request untuk load page berikutnya saat user scroll ke bawah.

🖼 Lazy Load Image Implementation

Menggunakan:

loading="lazy" (HTML5) atau

jQuery Lazy Load Plugin

⚙️ Installation
git clone <repository-url>
cd movie-app
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve

Akses di:

http://localhost:8000
📸 Screenshot
1️⃣ Halaman Login

Form Username & Password

Error message jika salah

<img width="1884" height="883" alt="image" src="https://github.com/user-attachments/assets/ce8d8f07-ba24-45a5-a179-2658a11e1dd8" />


2️⃣ Halaman List Movie

Infinite Scroll

Search Form

Add Favorite Button

<img width="1871" height="848" alt="image" src="https://github.com/user-attachments/assets/e3a93496-3161-455c-9d69-d5d9ee52d0a8" />
<img width="1870" height="866" alt="image" src="https://github.com/user-attachments/assets/3919f8cf-41a0-4b2b-80fd-a37fdba89b3d" />


3️⃣ Halaman Detail Movie

Detail lengkap movie
<img width="1836" height="875" alt="image" src="https://github.com/user-attachments/assets/78a1e921-00b5-4ccf-b03d-b48e2e5df49f" />
<img width="1872" height="870" alt="image" src="https://github.com/user-attachments/assets/43515d84-294e-4045-b429-2294495e2388" />
<img width="1879" height="869" alt="image" src="https://github.com/user-attachments/assets/ca88a25e-2b43-4236-a495-9bf9be04b596" />


Add / Remove Favorite
<img width="1872" height="869" alt="image" src="https://github.com/user-attachments/assets/61b8742e-f2ac-4871-be37-ca4cc653fd8e" />
<img width="1883" height="871" alt="image" src="https://github.com/user-attachments/assets/f209c4e0-eed4-4dc3-b26f-8941f61d81ca" />

