<?php
function deret_bilangan_ganjil_dibagi_3($awal, $akhir) {
    $deret = [];
    $jumlah_deret = 0;
    $total = 0;

    for ($i = $awal; $i <= $akhir; $i++) {
        if ($i % 2 != 0 && $i % 3 == 0) {
            $deret[] = $i;
            $jumlah_deret++;
            $total += $i;
        }
    }

    return [
        'deret' => $deret,
        'jumlah_deret' => $jumlah_deret,
        'total' => $total
    ];
}

// Input nilai awal dan akhir dari pengguna
$awal = intval(readline("Masukkan nilai awal: "));
$akhir = intval(readline("Masukkan nilai akhir: "));

// Memanggil fungsi dan mendapatkan hasil
$hasil = deret_bilangan_ganjil_dibagi_3($awal, $akhir);

// Menampilkan hasil
echo "Deret bilangan ganjil yang habis dibagi 3 dari $awal hingga $akhir: " . implode(', ', $hasil['deret']) . PHP_EOL;
echo "Banyaknya deret bilangan: {$hasil['jumlah_deret']}" . PHP_EOL;
echo "Jumlah dari deret bilangan: {$hasil['total']}" . PHP_EOL;
?>
