<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
    header("Location: index.php");
    exit();
}

require 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM teams WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "No record found";
        exit();
    }

    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $team = $_POST['team'];
    $menang = $_POST['menang'];
    $seri = $_POST['seri'];
    $kalah = $_POST['kalah'];
    $poin = $_POST['poin'];

    $sql = "UPDATE teams SET team = ?, menang = ?, seri = ?, kalah = ?, poin = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siiiii", $team, $menang, $seri, $kalah, $poin, $id);

    if ($stmt->execute()) {
        header("Location: dashboarduser.php");
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Team</title>
</head>
<body>
    <?php include 'menu1.php'; ?>
    <h1>Edit Team</h1>
    <form method="post" action="">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
        Team: <input type="text" name="team" value="<?php echo htmlspecialchars($row['team']); ?>" required><br>
        Menang: <input type="number" name="menang" value="<?php echo htmlspecialchars($row['menang']); ?>" required><br>
        Seri: <input type="number" name="seri" value="<?php echo htmlspecialchars($row['seri']); ?>" required><br>
        Kalah: <input type="number" name="kalah" value="<?php echo htmlspecialchars($row['kalah']); ?>" required><br>
        Poin: <input type="number" name="poin" value="<?php echo htmlspecialchars($row['poin']); ?>" required><br>
        <input type="submit" value="Update Team">
    </form>
</body>
</html>
