<?php
//mulaisession
session_start();
session_destroy();
if(isset($_COOKIE['login']))
{
$time=time();
setcookie("login",$time- 3600);
}
header('Location:./login.php');
exit();
?>