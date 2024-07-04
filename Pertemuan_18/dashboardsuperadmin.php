<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'super') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
<?php
    include "menu.php";
?>
<h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    <p>This is the admin dashboard.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
