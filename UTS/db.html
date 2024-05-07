<?php
session_start();


if (!isset($_SESSION['tims'])) {
    $_SESSION['tims'] = array();
}


function addTeam($data) {
    $_SESSION['tims'][] = $data;
    saveDataToFile($_SESSION['tims']); 
    header("Location: ".$_SERVER['REQUEST_URI']); 
    exit;
}


function saveDataToFile($data) {
    $file = 'file.txt';
    $serializedData = serialize($data);
    file_put_contents($file, $serializedData);
}


if(isset($_POST['submit'])){
   $negara = $_POST['negara'];
    $pertandingan = $_POST['pertandingan'];
    $menang = $_POST['menang'];
    $seri = $_POST['seri'];
    $kalah = $_POST['kalah'];
    $point = $_POST['point'];
    $operator = $_POST['operator'];
    $nim = $_POST['nim'];

    addTeam(array(
        'negara' => $negara,
        'pertandingan' => $pertandingan,
        'menang' => $menang,
        'seri' => $seri,
        'kalah' => $kalah,
        'point' => $point,
        'operator' => $operator,
        'nim' => $nim
    ));
}


if(isset($_POST['save_file'])) {
    if (!empty($_SESSION['tims'])) {
        saveDataToFile($_SESSION['tims']);
        $file = 'file.txt';
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    } else {
        echo "Tidak ada data untuk disimpan.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Formulir Data Tim Sepak Bola</title>
<style>
  table {
    border-collapse: collapse;
    width: 100%;
  }
  th, td {
    border: 1px solid black;
    padding: 8px;
    text-align: left;
  }
</style>
</head>
<body>

<form action="" method="POST">
  <label for="negara">Nama Negara:</label>
  <select id="negara" name="negara">
    <option value="Korea Selatan U-23">Korea Selatan U-23</option>
    <option value="Jepang U-23">Jepang U-23</option>
    <option value="Tiongkok U-23">Tiongkok U-23</option>
    <option value="Uni Emirat Arab U-23">Uni Emirat Arab U-23</option>
  </select>
  <br><br>

  <label for="pertandingan">Jumlah Pertandingan (P):</label>
  <input type="number" id="pertandingan" name="pertandingan" min="0">
  <br><br>

  <label for="menang">Jumlah Menang (M):</label>
  <input type="number" id="menang" name="menang" min="0">
  <br><br>

  <label for="seri">Jumlah Seri (S):</label>
  <input type="number" id="seri" name="seri" min="0">
  <br><br>

  <label for="kalah">Jumlah Kalah (K):</label>
  <input type="number" id="kalah" name="kalah" min="0">
  <br><br>

  <label for="point">Jumlah Point (Point):</label>
  <input type="number" id="point" name="point" min="0">
  <br><br>

  <label for="operator">Nama Operator:</label>
  <input type="text" id="operator" name="operator">
  <br><br>

  <label for="nim">NIM Mahasiswa:</label>
  <input type="text" id="nim" name="nim">
  <br><br>

  <input type="submit" name="submit" value="Submit">
  
  <input type="submit" name="save_file" value="Simpan ke File">
</form>

<?php

if(!empty($_SESSION['tims'])){
    echo "<h2>Data Tim Sepak Bola</h2>";
    echo "<table>";
    echo "<tr><th>Nama Negara</th><th>Jumlah Pertandingan (P)</th><th>Jumlah Menang (M)</th><th>Jumlah Seri (S)</th><th>Jumlah Kalah (K)</th><th>Jumlah Point</th><th>Nama Operator</th><th>NIM Mahasiswa</th></tr>";
    foreach ($_SESSION['tims'] as $team) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($team['negara']) . "</td>";
        echo "<td>" . htmlspecialchars($team['pertandingan']) . "</td>";
        echo "<td>" . htmlspecialchars($team['menang']) . "</td>";
        echo "<td>" . htmlspecialchars($team['seri']) . "</td>";
        echo "<td>" . htmlspecialchars($team['kalah']) . "</td>";
        echo "<td>" . htmlspecialchars($team['point']) . "</td>";
        echo "<td>" . htmlspecialchars($team['operator']) . "</td>";
        echo "<td>" . htmlspecialchars($team['nim']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>

</body>
</html>