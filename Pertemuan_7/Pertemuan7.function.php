<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pertemuan 7 - Soal Latihan 1</title>
</head>
<body>
    <h1>Materi Pemrograman PHP</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="material">Pilih Materi</label><br>
        <input type="number" id="material" name="material" min="1" max="4" required><label>[1][2][3][4]</label><br>
        <label for="materi1">[1] Deret Bilangan Ganjil</label><br>
        <label for="materi2">[2] Buku Tamu</label><br>
        <label for="materi3">[3] Menghitung Luas Segitiga</label><br>
        <label for="materi4">[4] Perkalian</label><br><br>
        <input type="submit" value="Kirim">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $material = $_POST['material'];
        
        if ($material == 1) {
            header("Location: Pertemuan4.deretbilanganganjil.php");
            exit;
        } elseif ($material == 2) {
            header("Location: Pertemuan5.bukutamu.php");
            exit;
        } elseif ($material == 3) {
            header("Location: Pertemuan6.Menghitung Luas Segitiga dengan Data dalam Array.php");
            exit;
        } elseif ($material == 4) {
            header("Pertemuan4.perkalian.php");
            exit;
        } else {
            echo "Hanya Pilih Angka 1 - 4!";
        }
    }
    ?>
</body>
</html>