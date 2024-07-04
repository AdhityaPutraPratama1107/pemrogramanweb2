<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hitung luas segitiga</title>
</head>
<body>
<h2>Masukkan Data Alas dan Tinggi Segitiga</h2>
    <form method="post">
        <?php
        $alas = array();
        $tinggi = array();
        $luas_segitiga = array();

        for ($i = 0; $i < 5; $i++) {
            echo "Segitiga ke-" . ($i+1) . ":<br>";
            echo "Alas: <input type='text' name='alas[]'><br>";
            echo "Tinggi: <input type='text' name='tinggi[]'><br><br>";
        }
        ?>
        <input type="submit" value="Hitung">
    </form>
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $alas = $_POST['alas'];
        $tinggi = $_POST['tinggi'];

        foreach ($alas as $index => $a) {
            $luas = 0.5 * $a * $tinggi[$index];
            array_push($luas_segitiga, $luas);
        }

        echo "<br>Luas segitiga:<br>";
        foreach ($luas_segitiga as $key => $luas) {
            echo "Segitiga ke-" . ($key+1) . ": " . $luas . "<br>";
        }
    }
    ?>
</body>
</html>