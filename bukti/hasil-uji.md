# Hasil Pengujian Praktikum 7

Nama: JONATHAN RAVEL
NIM: 25110115
Kelas: TK Grup D

Isi hasil berdasarkan pengujian sendiri. Jangan mengisi Lulus sebelum mencoba.

| No | Skenario | Hasil yang diharapkan | Hasil aktual | Status |
|---|---|---|---|---|
| 1 | Buka halaman pertama | Form kosong dan belum ada ringkasan | TAMPIL | LULUS |
| 2 | Buku Tulis, 12000, 10 | Ringkasan dengan Rp12.000 dan 10 unit | PESAN BERHASIL | LULUS |
| 3 | Stok 0 | Diterima sebagai 0 unit | PESANAN TIDAK ADA | LULUS |
| 4 | Harga -12000 | Ditolak dan isian lama tetap terlihat | HARGA DITOLAK | LULUS |
| 5 | Stok 2.5 | Ditolak | STOK DITOLAK | LULUS |
| 6 | Harga abc | Ditolak | HARGA DITOLAK | LULUS |
| 7 | Nama hanya spasi | Ditolak server | NAMA DIANGGAP KOSONG | LULUS |
| 8 | Nama <b>Buku Tulis</b> | Tag tampil sebagai teks, tidak menebalkan hasil | TAG TAMPIL | LULUS |
| 9 | Kosongkan form | Semua input dan ringkasan kembali kosong | SEMUA DATA INPUT DIKOSONGKAN | LULUS |
| 10 | Harga 00012000 dan stok 000 | Harga Rp12.000 dan stok 0 unit | ANGKA NOL DIDEPAN TIDAK DIBACA | LULUS |

## Jawaban pemahaman
1. Mengapa form menggunakan POST?
Jawab :
a. Keamanan dan Ukuran Data ($_POST)
Tidak Terlihat di URL: Data yang dikirimkan melalui metode POST dikirimkan secara tersembunyi di dalam body HTTP request, bukan dilampirkan pada URL seperti pada metode GET (misal: index.php?nama=Buku&harga=12000). Ini menjaga agar URL tetap bersih dan informasi yang dikirimkan tidak terekspos di riwayat peramban (browser history).

Kapasitas Lebih Besar: Metode GET memiliki batasan panjang karakter pada URL. Sebaliknya, POST dapat menampung data dalam jumlah yang jauh lebih besar (sangat berguna jika form yang diisi memiliki banyak kolom atau data teks yang panjang).

b. Sifat Operasi (Memproses Data / State-Changing)
Dalam praktik pengembangan web standar (RESTful / HTTP semantics), metode GET digunakan hanya untuk mengambil/membaca data tanpa mengubah apa pun di server (bersifat safe dan idempotent).

Metode POST digunakan ketika formulir melakukan pengiriman data baru untuk diproses, divalidasi, disimpan, atau dimanipulasi (seperti pada skenario penambahan data produk kasir di atas yang memanggil fungsi validasiProduk($_POST)).

c. Mencegah Pengiriman Ulang yang Tidak Disengaja (Form Resubmission)
Ketika pengguna melakukan refresh (muat ulang) pada halaman setelah mengirim data menggunakan POST, peramban biasanya akan memunculkan peringatan konfirmasi untuk mencegah data terkirim dua kali ganda secara tidak sengaja. Hal ini membantu menghindari duplikasi data (misalnya produk yang sama tersimpan dua kali).

2. Apa perbedaan id dan name?
Jawab :
id (Identifier):
Berfungsi sebagai pengenal unik untuk satu elemen tertentu di dalam seluruh dokumen HTML.
Biasanya digunakan oleh CSS untuk styling (contoh: #nama) dan oleh JavaScript untuk manipulasi elemen (contoh: document.getElementById('nama')).
id juga menghubungkan elemen <label> dengan <input> melalui atribut for="..." (seperti pada kode Anda: <label for="nama"> terhubung ke <input id="nama">), yang berguna untuk aksesibilitas dan kemudahan klik.

name (Name Attribute):
Berfungsi sebagai nama variabel pengenal saat data formulir dikirimkan ke server (PHP, Node.js, Python, dll.).
Ketika form disubmit (seperti pada $_POST atau $_GET di PHP), server membaca data berdasarkan atribut name-nya. Contoh pada skrip Anda: $form['nama'] berasal dari input yang memiliki name="nama".

3. Mengapa stok nol tidak boleh dianggap gagal?
Jawab :
Realitas Operasional Bisnis (Stok Kosong / Habis)
Dalam dunia nyata, barang dagangan yang baru atau sangat laku bisa saja habis terjual (stoknya tersisa 0).
Status stok 0 adalah kondisi inventaris yang valid dan wajar, bukan sebuah kesalahan input. Pelaku usaha atau sistem kasir tetap perlu mencatat bahwa suatu produk terdaftar di sistem, meskipun jumlah fisiknya saat ini sedang kosong dan perlu segera dilakukan restock (pengisian ulang).

4. Apa perbedaan trim, validasi, dan htmlspecialchars?
Jawab :
a. trim() (Pembersihan Spasi Awal/Akhir)
Fungsi Utama: Menghapus karakter kosong (seperti spasi, tab \t, atau baris baru \n) dari awal dan akhir sebuah string.
Kapan digunakan: Biasanya dilakukan pertama kali sebelum data diproses lebih lanjut.
Contoh:
Jika pengguna tidak sengaja mengetik "  Buku Tulis  " (ada spasi di depan dan belakang), fungsi trim() akan mengubahnya menjadi "Buku Tulis".
Alasan: Mencegah spasi berlebih merusak validasi (misalnya string yang hanya berisi spasi dianggap tidak kosong padahal sebenarnya kosong) atau mengotori data saat disimpan ke database.

b. Validasi (validasiProduk)
Fungsi Utama: Memeriksa apakah data yang dimasukkan oleh pengguna sudah sesuai dengan aturan bisnis dan format yang benar.
Kapan digunakan: Setelah data dibersihkan (atau saat diterima dari form), sistem akan mengecek:
Apakah kolom wajib diisi sudah terisi? (tidak kosong)
Apakah harga dan stok berupa angka bulat yang valid? (tipe data benar)
Apakah nilainya masuk akal? (misalnya harga tidak boleh negatif, tetapi stok boleh bernilai 0 seperti yang dibahas sebelumnya)
Hasil: Menghasilkan pesan kesalahan (errors) jika ada aturan yang dilanggar, atau meloloskan data jika semuanya sudah benar.

c. htmlspecialchars() (Keamanan Tampilan HTML / Encoding)
Fungsi Utama: Mengubah karakter khusus HTML (seperti <, >, &, ", ') menjadi entitas HTML amannya (misalnya < berubah menjadi &lt;).
Kapan digunakan: Saat ingin menampilkan kembali data ke peramban (browser) di dalam dokumen HTML (seperti pada fungsi e($form['nama']) atau e($produk['nama']) di kode Anda).
Alasan Keamanan: Mencegah serangan XSS (Cross-Site Scripting). Jika pengguna memasukkan kode berbahaya seperti <script>alert('hacked')</script> ke dalam form, fungsi ini akan mengubahnya menjadi teks biasa yang aman dibaca di layar tanpa mengeksekusi kode jahat tersebut.

5. Apakah produk tersimpan permanen? Jelaskan.
Jawab :
Tidak, produk tidak tersimpan secara permanen.
Berikut adalah penjelasan lengkap mengapa data tersebut tidak tersimpan secara permanen:

a. Tidak Ada Koneksi ke Database atau Sesi ($_SESSION)
Skrip PHP pada latihan ini hanya bertugas memproses data yang dikirimkan saat itu juga ($_POST), memvalidasinya, lalu menampilkan ringkasannya di sisi kanan halaman.
Agar data tersimpan secara permanen, sebuah aplikasi web harus menuliskan data tersebut ke dalam media penyimpanan tetap seperti database (misalnya MySQL, PostgreSQL) atau memanfaatkan session/file. Karena kode ini belum mengimplementasikannya, data tersebut bersifat sementara.

b. Sifat Protokol HTTP yang Stateless
Web bekerja dengan siklus permintaan dan tanggapan (request-response). Setiap kali halaman dimuat ulang atau form dikirimkan, server memproses data tersebut secara instan tanpa "mengingat" data dari pengiriman sebelumnya setelah halaman selesai dirender.

c. Data Akan Hilang Saat:
Pengguna melakukan refresh (muat ulang) halaman secara normal (menggunakan metode GET).
Pengguna menutup tab atau peramban (browser).
Pengguna menekan tombol "Kosongkan form".

6. Mengapa POST tidak otomatis membuat aplikasi aman?
Jawab :
Alasan mengapa POST tidak otomatis membuat aplikasi aman:

1. Data Tetap Bisa Disadap (Jika Tanpa HTTPS)
Meskipun data POST disembunyikan di dalam body HTTP request dan tidak muncul di URL atau riwayat browser, data tersebut tetap dikirimkan dalam bentuk teks biasa (plain text) jika situs web Anda belum menggunakan protokol HTTPS. Seseorang yang berada di jaringan yang sama (misalnya menggunakan Wi-Fi publik) dapat menggunakan alat pemantau jaringan (packet sniffer) untuk membaca isi data POST tersebut dengan mudah.

2. POST Tidak Menyaring Konten Berbahaya (Validasi & Sanitasi)
Metode POST tidak peduli apa isi data yang dikirimkan. Pengguna atau penyerang tetap bisa mengirimkan kode berbahaya, seperti:
SQL Injection: Menyisipkan perintah database berbahaya melalui kolom input (misalnya pada form login atau pencarian).
XSS (Cross-Site Scripting): Mengirimkan skrip JavaScript jahat (seperti <script>...<\/script>) yang nantinya bisa dieksekusi di browser pengguna lain jika data tersebut tidak dibersihkan dengan htmlspecialchars() seperti pada kode latihan Anda.

3. Rentan Terhadap Serangan CSRF (Cross-Site Request Forgery)
Secara default, server yang menerima permintaan POST akan memprosesnya selama ada data yang masuk, tanpa peduli dari mana data itu berasal. Penyerang dapat membuat situs web tiruan yang secara otomatis mengirimkan permintaan POST palsu ke aplikasi Anda atas nama pengguna yang sedang login, tanpa sepengetahuan pengguna tersebut (kecuali aplikasi dilengkapi pelindung khusus seperti CSRF Token).

4. Mudah Dimanipulasi Melalui Tools Eksternal
Penyerang tidak harus menggunakan form HTML resmi di browser Anda untuk mengirim data POST. Mereka dapat menggunakan perangkat lunak pengembang seperti Postman, cURL, atau memodifikasi Network Request di Browser Developer Tools. Mereka bisa dengan bebas mengubah nilai harga menjadi negatif atau memasukkan teks panjang untuk merusak sistem, karena server tetap akan menerima data POST tersebut.

## Kendala dan perbaikan
Tidak ada kendala.