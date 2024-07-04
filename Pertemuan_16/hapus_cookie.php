<?php
//settheexpirationdatetoonehourago
setcookie("username","",time()- 3600);
setcookie("namalengkap","",time()- 3600);
echo"<h1>CookieBerhasildihapus.</h1>";
echo"<h2>Klik<a href='buat_cookie.php'>disini</a>untuk
buatcookies</h2>";
echo"<h2>Klik<a href='lihat_cookie.php'>disini</a>untuk
melihatisicookie</h2>";
?>