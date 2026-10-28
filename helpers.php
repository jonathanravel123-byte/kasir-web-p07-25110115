<?php
declare(strict_types=1);

function e(string $nilai): string
{
    return htmlspecialchars($nilai, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function rupiah(int $nilai): string
{
    return 'Rp' . number_format($nilai, 0, ',', '.');
}

function bacaTeks(array $sumber, string $kunci): string
{
    $nilai = $sumber[$kunci] ?? '';
    return is_string($nilai) ? trim($nilai) : '';
}

function bilanganBulat(string $teks, int $minimum, int $maksimum): ?int
{
    if (preg_match('/\A[0-9]+\z/D', $teks) !== 1) {
        return null;
    }
    // Hilangkan nol di depan tanpa mengubah nilai nol menjadi string kosong.
    $normal = ltrim($teks, '0');
    $normal = $normal === '' ? '0' : $normal;
    $nilai = filter_var($normal, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => $minimum, 'max_range' => $maksimum],
    ]);
    return $nilai === false ? null : $nilai;
}

function validasiProduk(array $sumber): array
{
    $form = [
        'nama' => bacaTeks($sumber, 'nama'),
        'harga' => bacaTeks($sumber, 'harga'),
        'stok' => bacaTeks($sumber, 'stok'),
    ];
    $errors = [];
    $jumlahKarakter = preg_match_all('/./us', $form['nama']);

    if ($form['nama'] === '') {
        $errors['nama'] = 'Nama produk wajib diisi.';
    } elseif ($jumlahKarakter === false) {
        $errors['nama'] = 'Nama produk harus berupa teks UTF-8 yang valid.';
    } elseif ($jumlahKarakter > 100) {
        $errors['nama'] = 'Nama produk maksimal 100 karakter.';
    } elseif (preg_match('/[\x00-\x1F\x7F]/', $form['nama']) === 1) {
        $errors['nama'] = 'Nama produk tidak boleh mengandung karakter kontrol.';
    }

    $harga = bilanganBulat($form['harga'], 1, 1000000000);
    $stok = bilanganBulat($form['stok'], 0, 1000000);
    if ($harga === null) {
        $errors['harga'] = 'Harga harus berupa angka bulat 1 sampai 1000000000, tanpa Rp atau pemisah.';
    }
    if ($stok === null) {
        $errors['stok'] = 'Stok harus berupa angka bulat 0 sampai 1000000.';
    }

    $produk = $errors === [] ? [
        'nama' => $form['nama'],
        'harga' => $harga,
        'stok' => $stok,
    ] : null;

    return ['form' => $form, 'errors' => $errors, 'produk' => $produk];
}