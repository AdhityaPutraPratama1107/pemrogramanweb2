<?php
$value='Adhitya';
$value2='AdhityaPutraPratama';
setcookie("username",$value);
setcookie("namalengkap",$value2,time()+3600);/*expirein1
hour*/
echo"<h1>HalamanUbahcookie</h1>";
echo"<h2>Klik<a href='lihat_cookie.php'>disini</a>untuk
lihatcookie</h2>";
?>