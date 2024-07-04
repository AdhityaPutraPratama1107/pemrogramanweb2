<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php

$alas = array(4, 2, 4, 4, 6);  
$tinggi = array(6, 9, 5, 7, 8); 
$luas_segitiga = array();

for ($i = 0; $i < count($alas); $i++) {
    $luas = 0.5 * $alas[$i] * $tinggi[$i];
    array_push($luas_segitiga, $luas);
}

echo "Luas segitiga:<br>";
foreach ($luas_segitiga as $key => $luas) {
    echo "Segitiga ke-" . ($key+1) . ": " . $luas . "<br>";
}
?>
</body>
</html>