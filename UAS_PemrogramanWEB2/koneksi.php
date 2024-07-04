<?php
$servername = "localhost";
$username = "adhityap_uas";
$password = "uas@2024";
$dbname = "adhityap_uas";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
