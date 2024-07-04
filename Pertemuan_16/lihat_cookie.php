<?php
if(isset($_COOKIE['username'])){
echo"<h1>Cookie'username'ada.Isinya:".
$_COOKIE['username'];
}else{
echo"<h1>Cookie'username'TIDAKada.</h1>";
}
if(isset($_COOKIE['namalengkap'])){
echo"<h1>Cookie'namalengkap'ada.Isinya:".
$_COOKIE['namalengkap'];
}else{
echo"<h1>Cookie'namalengkap'TIDAKada.</h1>";
}
echo"<h2>Klik<a href='buat_cookie.php'>disini</a>untuk
penciptaancookies</h2>";
echo"<h2>Klik<a href='ubah_cookie.php'>disini</a>untuk
ubahcookies</h2>";
echo"<h2>Klik<a href='hapus_cookie.php'>disini</a>untuk
penghapusancookies</h2>";
?>