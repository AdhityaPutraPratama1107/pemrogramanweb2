<?php
// Start session
session_start();

// Check session
if (!isset($_SESSION['login'])) {
    header('Location: ./login.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Home Remember Me</title>
</head>
<body>
    <h5>Selamat datang adhitya di halaman utama website </h5>
    <p><a href="./logout.php">Logout</a></p>
</body>
</html>
