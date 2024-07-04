<?php
// Static variables
$user = 'admin';
$pass = md5('admin');

// Mulai sesi
session_start();

// Tampung data dari form
$username = $_POST['username'];
$password = $_POST['password'];

// Cek login
if ($username == $user && md5($password) == $pass) {
    // Set session
    $_SESSION['login'] = TRUE;
    $_SESSION['username'] = $username; // Menyimpan nama pengguna di sesi

    // Cek remember me
    if (isset($_POST['remember'])) {
        // Set waktu saat ini
        $time = time();
        // Set cookie
        setcookie('login', $user, $time + 3600, "/"); // Cookie berlaku selama 1 jam
        setcookie('saved_username', $username, $time + 3600, "/");
        setcookie('saved_password', md5($password), $time + 3600, "/"); // Menyimpan hash password di cookie
        setcookie('saved_remember', 'true', $time + 3600, "/");
    } else {
        // Hapus cookie jika remember me tidak dicentang
        setcookie('saved_username', '', time() - 3600, "/");
        setcookie('saved_password', '', time() - 3600, "/");
        setcookie('saved_remember', '', time() - 3600, "/");
    }

    // Redirect ke halaman utama
    header('Location: ./home.php');
    exit();
} else {
    header('Location: ./login.php');
    exit();
}
?>