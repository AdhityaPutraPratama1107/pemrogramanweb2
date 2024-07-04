<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

require 'koneksi.php';

header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=data_export.xls");
header("Pragma: no-cache");
header("Expires: 0");

$sql = "SELECT * FROM data";
$result = $conn->query($sql);

echo "<table border='1'>";
echo "<tr><th>ID</th><th>Name</th><th>Description</th></tr>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['description'] . "</td>";
        echo "</tr>";
    }
}

echo "</table>";
?>
