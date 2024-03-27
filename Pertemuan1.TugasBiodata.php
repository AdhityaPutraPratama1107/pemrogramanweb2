<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biodata</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .biodata-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .biodata-container h2 {
            text-align: center;
            color: #333;
        }
        .biodata-info {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<?php
// Biodata
$nama = "Adhitya Putra Pratama";
$email = "adhityaputrapratama1107@gmail.com";
$jurusan = "Teknik Informatika";
$hobi = "Catur";

// Menampilkan biodata
echo '<div class="biodata-container">';
echo '<h2>Biodata</h2>';
echo '<div class="biodata-info"><strong>Nama:</strong> ' . $nama . '</div>';
echo '<div class="biodata-info"><strong>Email:</strong> ' . $email . '</div>';
echo '<div class="biodata-info"><strong>Jurusan:</strong> ' . $jurusan . '</div>';
echo '<div class="biodata-info"><strong>Hobi:</strong> ' . $hobi . '</div>';
echo '</div>';
?>

</body>
</html>
