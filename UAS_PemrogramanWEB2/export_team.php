<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
    header("Location: index.php");
    exit();
}

require 'koneksi.php';

// Query untuk mengambil data teams
$sql = "SELECT id, team, menang, seri, kalah, poin FROM teams";
$result = $conn->query($sql);

// Membuat header file Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=team_data.xls");

// Membuat tabel header
echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Team</th>
            <th>Menang</th>
            <th>Seri</th>
            <th>Kalah</th>
            <th>Poin</th>
        </tr>";

// Menulis data baris
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
    echo "<td>" . htmlspecialchars($row['team']) . "</td>";
    echo "<td>" . htmlspecialchars($row['menang']) . "</td>";
    echo "<td>" . htmlspecialchars($row['seri']) . "</td>";
    echo "<td>" . htmlspecialchars($row['kalah']) . "</td>";
    echo "<td>" . htmlspecialchars($row['poin']) . "</td>";
    echo "</tr>";
}

// Menutup tabel HTML
echo "</table>";

// Mengakhiri proses PHP
exit;
?>
