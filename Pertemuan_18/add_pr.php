<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_barang = $_POST['kode_barang'];
    $pr = $_POST['pr'];
    $tanggal_permintaan = $_POST['tanggal_permintaan'];
    $item_description = $_POST['item_description'];
    $qty = $_POST['qty'];
    $unit = $_POST['unit'];
    $qty_os = $_POST['qty_os'];
    $tanggal_pengajuan = $_POST['tanggal_pengajuan'];
    $jenis_pengajuan = $_POST['jenis_pengajuan'];
    $proses_pengajuan = $_POST['proses_pengajuan'];
    $proses_pencarian_vendor = $_POST['proses_pencarian_vendor'];
    $jenis_pembayaran = $_POST['jenis_pembayaran'];
    $proses_pembayaran = $_POST['proses_pembayaran'];
    $tanggal_tempo = $_POST['tanggal_tempo'];
    $status = $_POST['status'];
    $jenis = $_POST['jenis'];
    $qty_dikirim = $_POST['qty_dikirim'];
    $keterangan = $_POST['keterangan'];
    $pic = $_SESSION['username']; // Automatically set the PIC to the logged-in user

    $sql = "INSERT INTO pr (
                kode_barang, pr, tanggal_permintaan, item_description, 
                qty, unit, qty_os, tanggal_pengajuan, 
                jenis_pengajuan, proses_pengajuan, proses_pencarian_vendor, 
                jenis_pembayaran, proses_pembayaran, tanggal_tempo, 
                status, jenis, qty_dikirim, keterangan, pic
            ) VALUES (
                '$kode_barang', '$pr', '$tanggal_permintaan', '$item_description', 
                $qty, '$unit', $qty_os, '$tanggal_pengajuan', 
                '$jenis_pengajuan', '$proses_pengajuan', '$proses_pencarian_vendor', 
                '$jenis_pembayaran', '$proses_pembayaran', '$tanggal_tempo', 
                '$status', '$jenis', $qty_dikirim, '$keterangan', '$pic'
            )";

    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        $sql_log = "INSERT INTO pr_log (
                        data_id, action, edited_by, 
                        old_kode_barang, new_kode_barang, 
                        old_pr, new_pr, 
                        old_tanggal_permintaan, new_tanggal_permintaan, 
                        old_item_description, new_item_description, 
                        old_qty, new_qty, 
                        old_unit, new_unit, 
                        old_qty_os, new_qty_os, 
                        old_tanggal_pengajuan, new_tanggal_pengajuan, 
                        old_jenis_pengajuan, new_jenis_pengajuan, 
                        old_proses_pengajuan, new_proses_pengajuan, 
                        old_proses_pencarian_vendor, new_proses_pencarian_vendor, 
                        old_jenis_pembayaran, new_jenis_pembayaran, 
                        old_proses_pembayaran, new_proses_pembayaran, 
                        old_tanggal_tempo, new_tanggal_tempo, 
                        old_status, new_status, 
                        old_jenis, new_jenis, 
                        old_qty_dikirim, new_qty_dikirim, 
                        old_keterangan, new_keterangan
                    ) VALUES (
                        $last_id, 'add', '".$_SESSION['username']."', 
                        '', '$kode_barang', 
                        '', '$pr', 
                        NULL, '$tanggal_permintaan', 
                        '', '$item_description', 
                        NULL, $qty, 
                        '', '$unit', 
                        NULL, $qty_os, 
                        NULL, '$tanggal_pengajuan', 
                        '', '$jenis_pengajuan', 
                        '', '$proses_pengajuan', 
                        '', '$proses_pencarian_vendor', 
                        '', '$jenis_pembayaran', 
                        '', '$proses_pembayaran', 
                        NULL, '$tanggal_tempo', 
                        '', '$status', 
                        '', '$jenis', 
                        '', $qty_dikirim, 
                        '', '$keterangan'
                    )";
        $conn->query($sql_log);
        header("Location: pr.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Query untuk mengambil data dari tabel jenis_pengajuan
$sql_jenis_pengajuan = "SELECT id, jenis_pengajuan FROM jenis_pengajuan";
$result_jenis_pengajuan = $conn->query($sql_jenis_pengajuan);

// Query untuk mengambil data dari tabel proses_pengajuan
$sql_proses_pengajuan = "SELECT id, proses_pengajuan FROM proses_pengajuan";
$result_proses_pengajuan = $conn->query($sql_proses_pengajuan);

// Query untuk mengambil data dari tabel jenis_pembayaran
$sql_jenis_pembayaran = "SELECT id, jenis_pembayaran FROM jenis_pembayaran";
$result_jenis_pembayaran = $conn->query($sql_jenis_pembayaran);

// Query untuk mengambil data dari tabel proses_pembayaran
$sql_proses_pembayaran = "SELECT id, proses_pembayaran FROM proses_pembayaran";
$result_proses_pembayaran = $conn->query($sql_proses_pembayaran);

// Query untuk mengambil data dari tabel jenis
$sql_jenis = "SELECT id, jenis FROM jenis";
$result_jenis = $conn->query($sql_jenis);

// Query untuk mengambil data dari tabel status
$sql_status = "SELECT id, status FROM status";
$result_status = $conn->query($sql_status);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Add PR</title>
</head>
<body>
    <?php include 'menu.php'; ?>
    <h1>Add PR</h1>
    <form method="post" action="">
        Kode Barang: <input type="text" name="kode_barang" required><br>
        PR: <input type="text" name="pr" required><br>
        Tanggal Permintaan: <input type="date" name="tanggal_permintaan" required><br>
        Item Description: <input type="text" name="item_description" required><br>
        Qty: <input type="number" name="qty" required><br>
        Unit: <input type="text" name="unit" required><br>
        Qty OS: <input type="number" name="qty_os" required><br>
        Tanggal Pengajuan: <input type="date" name="tanggal_pengajuan" required><br>
        Jenis Pengajuan: 
        <select name="jenis_pengajuan" required>
            <?php
            if ($result_jenis_pengajuan->num_rows > 0) {
                while ($row = $result_jenis_pengajuan->fetch_assoc()) {
                    echo "<option value='" . $row['jenis_pengajuan'] . "'>" . $row['jenis_pengajuan'] . "</option>";
                }
            }
            ?>
        </select><br>
        Proses Pengajuan: 
        <select name="proses_pengajuan" required>
            <?php
            if ($result_proses_pengajuan->num_rows > 0) {
                while ($row = $result_proses_pengajuan->fetch_assoc()) {
                    echo "<option value='" . $row['proses_pengajuan'] . "'>" . $row['proses_pengajuan'] . "</option>";
                }
            }
            ?>
        </select><br>
        Proses Pencarian Vendor: <input type="text" name="proses_pencarian_vendor" required><br>
        Jenis Pembayaran: 
        <select name="jenis_pembayaran" required>
            <?php
            if ($result_jenis_pembayaran->num_rows > 0) {
                while ($row = $result_jenis_pembayaran->fetch_assoc()) {
                    echo "<option value='" . $row['jenis_pembayaran'] . "'>" . $row['jenis_pembayaran'] . "</option>";
                }
            }
            ?>
        </select><br>
        Proses Pembayaran: 
        <select name="proses_pembayaran" required>
            <?php
            if ($result_proses_pembayaran->num_rows > 0) {
                while ($row = $result_proses_pembayaran->fetch_assoc()) {
                    echo "<option value='" . $row['proses_pembayaran'] . "'>" . $row['proses_pembayaran'] . "</option>";
                }
            }
            ?>
        </select><br>
        Tanggal Tempo: <input type="date" name="tanggal_tempo" required><br>
        Status:
        <select name="status" required>
            <?php
            if ($result_status->num_rows > 0) {
                while ($row = $result_status->fetch_assoc()) {
                    echo "<option value='" . $row['status'] . "'>" . $row['status'] . "</option>";
                }
            }
            ?>
        </select><br>
        Jenis: 
        <select name="jenis" required>
            <?php
            if ($result_jenis->num_rows > 0) {
                while ($row = $result_jenis->fetch_assoc()) {
                    echo "<option value='" . $row['jenis'] . "'>" . $row['jenis'] . "</option>";
                }
            }
            ?>
        </select><br>
        Qty Dikirim: <input type="number" name="qty_dikirim" required><br>
        Keterangan: <textarea name="keterangan" required></textarea><br>
        <input type="hidden" name="pic" value="<?php echo $_SESSION['username']; ?>"><br>
        <input type="submit" value="Add PR">
    </form>
</body>
</html>
