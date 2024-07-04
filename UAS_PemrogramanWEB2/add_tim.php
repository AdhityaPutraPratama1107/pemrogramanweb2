<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
    header("Location: index.php");
    exit();
}

require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $team = $_POST['team'];
    $menang = $_POST['menang'];
    $seri = $_POST['seri'];
    $kalah = $_POST['kalah'];
    $poin = $_POST['poin'];
    $pic = $_SESSION['username']; // Automatically set the PIC to the logged-in user

    $sql = "INSERT INTO teams (team, menang, seri, kalah, poin) VALUES ('$team', $menang, $seri, $kalah, $poin)";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboarduser.php"); // Redirect to a page to view all teams
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Team</title>
</head>
<body>
    <?php include 'menu1.php'; ?>
    <h1>Add Team</h1>
    <form method="post" action="">
        Team: <input type="text" name="team" required><br>
        Menang: <input type="number" name="menang" required><br>
        Seri: <input type="number" name="seri" required><br>
        Kalah: <input type="number" name="kalah" required><br>
        Poin: <input type="number" name="poin" required><br>
        <input type="hidden" name="pic" value="<?php echo $_SESSION['username']; ?>"><br>
        <input type="submit" value="Add Team">
    </form>
</body>
</html>
