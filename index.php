<?php
declare(strict_types=1);
require_once __DIR__ . '/helpers.php';

$form = ['nama' => '', 'harga' => '', 'stok' => ''];
$errors = [];
$produk = null;
$isPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
if ($isPost) {
    $hasil = validasiProduk($_POST);
    $form = $hasil['form'];
    $errors = $hasil['errors'];
    $produk = $hasil['produk'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Lab | Praktikum 7</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<main class="container">
    <header class="hero">
        <p class="eyebrow">PEMROGRAMAN WEB II / PRAKTIKUM 07</p>
        <h1>Form Produk Kasir</h1>
        <p>Isi data produk, periksa hasilnya, dan pelajari validasi input PHP.</p>
    </header>

    <div class="layout">
        <section class="panel" aria-labelledby="judul-form">
            <h2 id="judul-form">Tambah produk</h2>
            <p class="muted">Semua kolom wajib diisi. Harga dan stok menggunakan angka bulat.</p>

            <?php if ($isPost && $errors !== []): ?>
                <div class="notice error" role="alert">
                    Data belum valid. Perbaiki kolom yang memiliki pesan kesalahan.
                </div>
            <?php elseif ($produk !== null): ?>
                <div class="notice success" role="status">
                    Data valid. Ringkasan produk berhasil ditampilkan.
                </div>
            <?php endif; ?>

            <form action="index.php" method="post">
                <div class="field">
                    <label for="nama">Nama produk</label>
                    <input type="text" id="nama" name="nama" maxlength="100"
                           value="<?= e($form['nama']) ?>" required
                           aria-describedby="nama-pesan"
                           aria-invalid="<?= isset($errors['nama']) ? 'true' : 'false' ?>">
                    <p id="nama-pesan" class="<?= isset($errors['nama']) ? 'field-error' : 'hint' ?>">
                        <?= e($errors['nama'] ?? 'Contoh: Buku Tulis. Maksimal 100 karakter.') ?>
                    </p>
                </div>

                <div class="field">
                    <label for="harga">Harga satuan (Rupiah)</label>
                    <input type="text" id="harga" name="harga" inputmode="numeric"
                           value="<?= e($form['harga']) ?>" required
                           aria-describedby="harga-pesan"
                           aria-invalid="<?= isset($errors['harga']) ? 'true' : 'false' ?>">
                    <p id="harga-pesan" class="<?= isset($errors['harga']) ? 'field-error' : 'hint' ?>">
                        <?= e($errors['harga'] ?? 'Contoh: 12000. Tanpa Rp, titik, atau koma.') ?>
                    </p>
                </div>

                <div class="field">
                    <label for="stok">Stok tersedia</label>
                    <input type="text" id="stok" name="stok" inputmode="numeric"
                           value="<?= e($form['stok']) ?>" required
                           aria-describedby="stok-pesan"
                           aria-invalid="<?= isset($errors['stok']) ? 'true' : 'false' ?>">
                    <p id="stok-pesan" class="<?= isset($errors['stok']) ? 'field-error' : 'hint' ?>">
                        <?= e($errors['stok'] ?? 'Contoh: 10. Nilai 0 diperbolehkan.') ?>
                    </p>
                </div>

                <div class="actions">
                    <button type="submit">Proses produk</button>
                    <a class="secondary" href="index.php">Kosongkan form</a>
                </div>
            </form>
        </section>

        <section class="panel result" aria-labelledby="judul-hasil">
            <p class="eyebrow">HASIL PEMERIKSAAN</p>
            <h2 id="judul-hasil">Ringkasan produk</h2>
            <?php if ($produk === null): ?>
                <div class="empty">
                    <h3>Belum ada ringkasan</h3>
                    <p>Lengkapi form lalu tekan <strong>Proses produk</strong>.</p>
                    <p>Jika data salah, perbaiki pesan pada masing-masing kolom.</p>
                </div>
            <?php else: ?>
                <dl class="summary">
                    <dt>Nama produk</dt>
                    <dd><?= e($produk['nama']) ?></dd>
                    <dt>Harga satuan</dt>
                    <dd class="price"><?= e(rupiah($produk['harga'])) ?></dd>
                    <dt>Stok tersedia</dt>
                    <dd><?= e((string) $produk['stok']) ?> unit</dd>
                </dl>
            <?php endif; ?>
            <p class="note">Latihan ini belum menyimpan data ke database atau session.
                Ringkasan hanya berasal dari pengiriman form saat ini.</p>
        </section>
    </div>
    <footer>Praktikum 7 · Form POST, validasi server, dan encoding keluaran HTML</footer>
</main>
</body>
</html>