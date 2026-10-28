# Praktikum 7 — Form Produk Kasir

- Nama: JONATHAN RAVEL
- NIM: 25110115
- Kelas: TK Grup D
- Mata kuliah: Pemrograman WEB II
- Dosen: Juni Ismail, S.Kom., M.Kom.

## Tujuan
Membuat form POST, validasi server, pesan kesalahan, mempertahankan isian lama,
dan encoding keluaran HTML menggunakan htmlspecialchars.

## Menjalankan
1. Gunakan XAMPP dengan PHP 8.0 atau lebih baru.
2. Simpan folder proyek di C:\xampp\htdocs\kasir-web-p07-NIM.
3. Ganti NIM pada nama folder dengan NIM mahasiswa.
4. Jalankan Apache melalui XAMPP Control Panel.
5. Buka http://localhost/kasir-web-p07-NIM/ dengan nama folder yang sebenarnya.
6. Tidak memerlukan MySQL, Composer, atau koneksi internet untuk menjalankan aplikasi lokal.

## Isi proyek
- index.php: form dan tampilan hasil.
- helpers.php: fungsi validasi, format Rupiah, dan encoding HTML.
- assets/css/style.css: tampilan responsif.
- bukti/hasil-uji.md: catatan pengujian mahasiswa.
- bukti/screenshots/: tangkapan layar pekerjaan mahasiswa.

## Aturan input
Nama wajib diisi, maksimal 100 karakter. Harga berupa digit 1–1000000000.
Stok berupa digit 0–1000000. Angka tidak menggunakan Rp, titik, koma, atau tanda plus/minus.
Nol di depan dan spasi pada tepi input dinormalisasi.

## Batas aplikasi
Data hanya diproses pada request saat ini. Belum disimpan ke database atau session.
Aplikasi ini belum menjadi sistem kasir produksi. Ringkasan berisi harga satuan dan stok,
bukan jumlah pembelian atau total transaksi.

## Bukti
Lihat bukti/hasil-uji.md dan bukti/screenshots/.