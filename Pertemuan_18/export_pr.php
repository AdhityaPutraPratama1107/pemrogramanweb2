<?php
session_start();
require 'koneksi.php';

// Validasi sesi user dan peran
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

// Inisialisasi variabel untuk data PR
$id_barang = $kode_barang = $pr = $tanggal_permintaan = $item_description = '';
$qty = $unit = $qty_os = $tanggal_pengajuan = $jenis_pengajuan = $proses_pengajuan = '';
$proses_pencarian_vendor = $jenis_pembayaran = $proses_pembayaran = $tanggal_tempo = '';
$status = $jenis = $qty_dikirim = $keterangan = '';

// Jika ada parameter id_barang dari GET, ambil data PR untuk diedit
if (isset($_GET['id'])) {
    $id_barang = $_GET['id'];
    $sql = "SELECT * FROM pr WHERE id_barang = $id_barang";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Memuat nilai dari database ke variabel yang sesuai
        $id_barang = $row['id_barang'];
        $kode_barang = $row['kode_barang'];
        $pr = $row['pr'];
        $tanggal_permintaan = $row['tanggal_permintaan'];
        $item_description = $row['item_description'];
        $qty = $row['qty'];
        $unit = $row['unit'];
        $qty_os = $row['qty_os'];
        $tanggal_pengajuan = $row['tanggal_pengajuan'];
        $jenis_pengajuan = $row['jenis_pengajuan'];
        $proses_pengajuan = $row['proses_pengajuan'];
        $proses_pencarian_vendor = $row['proses_pencarian_vendor'];
        $jenis_pembayaran = $row['jenis_pembayaran'];
        $proses_pembayaran = $row['proses_pembayaran'];
        $tanggal_tempo = $row['tanggal_tempo'];
        $status = $row['status'];
        $jenis = $row['jenis'];
        $qty_dikirim = $row['qty_dikirim'];
        $keterangan = $row['keterangan'];
    } else {
        echo "Data not found.";
        exit();
    }
} else {
    echo "Parameter id_barang is missing.";
    exit();
}

// Jika metode request adalah POST, maka proses update PR
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_barang = $_POST['id_barang'];
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

    // Query untuk mengambil data PR sebelum diubah
    $sql_old_data = "SELECT * FROM pr WHERE id_barang = $id_barang";
    $result_old_data = $conn->query($sql_old_data);

    if ($result_old_data) {
        $old_data = $result_old_data->fetch_assoc();

        // Query untuk melakukan update data PR
        $sql_update = "UPDATE pr SET
                        kode_barang = '$kode_barang',
                        pr = '$pr',
                        tanggal_permintaan = '$tanggal_permintaan',
                        item_description = '$item_description',
                        qty = $qty,
                        unit = '$unit',
                        qty_os = $qty_os,
                        tanggal_pengajuan = '$tanggal_pengajuan',
                        jenis_pengajuan = '$jenis_pengajuan',
                        proses_pengajuan = '$proses_pengajuan',
                        proses_pencarian_vendor = '$proses_pencarian_vendor',
                        jenis_pembayaran = '$jenis_pembayaran',
                        proses_pembayaran = '$proses_pembayaran',
                        tanggal_tempo = '$tanggal_tempo',
                        status = '$status',
                        jenis = '$jenis',
                        qty_dikirim = '$qty_dikirim',
                        keterangan = '$keterangan'
                    WHERE id_barang = $id_barang";

        if ($conn->query($sql_update)) {
            // Query untuk menyimpan log perubahan
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
                            $id_barang, 'edit', '" . $_SESSION['username'] . "', 
                            '" . $old_data['kode_barang'] . "', '$kode_barang', 
                            '" . $old_data['pr'] . "', '$pr', 
                            '" . $old_data['tanggal_permintaan'] . "', '$tanggal_permintaan', 
                            '" . $old_data['item_description'] . "', '$item_description', 
                            '" . $old_data['qty'] . "', $qty, 
                            '" . $old_data['unit'] . "', '$unit', 
                            '" . $old_data['qty_os'] . "', $qty_os, 
                            '" . $old_data['tanggal_pengajuan'] . "', '$tanggal_pengajuan', 
                            '" . $old_data['jenis_pengajuan'] . "', '$jenis_pengajuan', 
                            '" . $old_data['proses_pengajuan'] . "', '$proses_pengajuan', 
                            '" . $old_data['proses_pencarian_vendor'] . "', '$proses_pencarian_vendor', 
                            '" . $old_data['jenis_pembayaran'] . "', '$jenis_pembayaran', 
                            '" . $old_data['proses_pembayaran'] . "', '$proses_pembayaran', 
                            '" . $old_data['tanggal_tempo'] . "', '$tanggal_tempo', 
                            '" . $old_data['status'] . "', '$status', 
                            '" . $old_data['jenis'] . "', '$jenis', 
                            '" . $old_data['qty_dikirim'] . "', '$qty_dikirim', 
                            '" . $old_data['keterangan'] . "', '$keterangan'
                        )";

            if ($conn->query($sql_log)) {
                header("Location: pr.php");
                exit();
            } else {
                echo "Error: " . $sql_log . "<br>" . $conn->error;
            }
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Error retrieving old data: " . $conn->error;
    }
}
// Query untuk mengambil data dari tabel jenis_pengajuan
$result_jenis_pengajuan = $conn->query("SELECT id, jenis_pengajuan FROM jenis_pengajuan");

// Query untuk mengambil data dari tabel proses_pengajuan
$result_proses_pengajuan = $conn->query("SELECT id, proses_pengajuan FROM proses_pengajuan");

// Query untuk mengambil data dari tabel jenis_pembayaran
$result_jenis_pembayaran = $conn->query("SELECT id, jenis_pembayaran FROM jenis_pembayaran");

// Query untuk mengambil data dari tabel proses_pembayaran
$result_proses_pembayaran = $conn->query("SELECT id, proses_pembayaran FROM proses_pembayaran");

// Query untuk mengambil data dari tabel jenis
$result_jenis = $conn->query("SELECT id, jenis FROM jenis");

// Query untuk mengambil data dari tabel status
$result_status = $conn->query("SELECT id, status FROM status")
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit PR</title>
</head>
<body>
    <?php include 'menu.php'; ?>
    <h1>Edit PR</h1>
    <form method="post" action="">
        <input type="hidden" name="id_barang" value="<?php echo $id_barang; ?>">
        Kode Barang: <input type="text" name="kode_barang" value="<?php echo $kode_barang; ?>" required><br>
        PR: <input type="text" name="pr" value="<?php echo $pr; ?>" required><br>
        Tanggal Permintaan: <input type="date" name="tanggal_permintaan" value="<?php echo $tanggal_permintaan; ?>" required><br>
        Item Description: <input type="text" name="item_description" value="<?php echo $item_description; ?>" required><br>
        Qty: <input type="number" name="qty" value="<?php echo $qty; ?>" required><br>
        Unit: <input type="text" name="unit" value="<?php echo $unit; ?>" required><br>
        Qty OS: <input type="number" name="qty_os" value="<?php echo $qty_os; ?>" required><br>
        Tanggal Pengajuan: <input type="date" name="tanggal_pengajuan" value="<?php echo $tanggal_pengajuan; ?>" required><br>
        <label for="jenis_pengajuan">Jenis Pengajuan:</label>
        <select id="jenis_pengajuan" name="jenis_pengajuan">
            <?php while($row = $result_jenis_pengajuan->fetch_assoc()) { ?>
                <option value="<?php echo $row['jenis_pengajuan']; ?>" <?php if ($jenis_pengajuan == $row['jenis_pengajuan']) echo 'selected'; ?>><?php echo $row['jenis_pengajuan']; ?></option>
            <?php } ?>
        </select><br>
       <label for="proses_pengajuan">Proses Pengajuan:</label>
        <select id="proses_pengajuan" name="proses_pengajuan">
            <?php while($row = $result_proses_pengajuan->fetch_assoc()) { ?>
                <option value="<?php echo $row['proses_pengajuan']; ?>" <?php if ($proses_pengajuan == $row['proses_pengajuan']) echo 'selected'; ?>><?php echo $row['proses_pengajuan']; ?></option>
            <?php } ?>
        </select><br>
        Proses Pencarian Vendor: <input type="text" name="proses_pencarian_vendor" value="<?php echo $proses_pencarian_vendor; ?>" required><br>
        <label for="jenis_pembayaran">Jenis Pembayaran:</label>
        <select id="jenis_pembayaran" name="jenis_pembayaran">
            <?php while($row = $result_jenis_pembayaran->fetch_assoc()) { ?>
                <option value="<?php echo $row['jenis_pembayaran']; ?>" <?php if ($jenis_pembayaran == $row['jenis_pembayaran']) echo 'selected'; ?>><?php echo $row['jenis_pembayaran']; ?></option>
            <?php } ?>
        </select><br>

        <label for="proses_pembayaran">Proses Pembayaran:</label>
        <select id="proses_pembayaran" name="proses_pembayaran">
            <?php while($row = $result_proses_pembayaran->fetch_assoc()) { ?>
                <option value="<?php echo $row['proses_pembayaran']; ?>" <?php if ($proses_pembayaran == $row['proses_pembayaran']) echo 'selected'; ?>><?php echo $row['proses_pembayaran']; ?></option>
            <?php } ?>
        </select><br>
        Tanggal Tempo: <input type="date" name="tanggal_tempo" value="<?php echo $tanggal_tempo; ?>" required><br>
        <label for="status">Status:</label>
          <select id="status" name="status">
            <?php while($row = $result_status->fetch_assoc()) { ?>
                <option value="<?php echo $row['status']; ?>" <?php if ($status == $row['status']) echo 'selected'; ?>><?php echo $row['status']; ?></option>
            <?php } ?>
        </select><br>

        <label for="jenis">Jenis:</label>
        <select id="jenis" name="jenis">
            <?php while($row = $result_jenis->fetch_assoc()) { ?>
                <option value="<?php echo $row['jenis']; ?>" <?php if ($jenis == $row['jenis']) echo 'selected'; ?>><?php echo $row['jenis']; ?></option>
            <?php } ?>
        </select><br>
        Qty Dikirim: <input type="text" name="qty_dikirim" value="<?php echo $qty_dikirim; ?>" required><br>
        Keterangan: <textarea name="keterangan" required><?php echo $keterangan; ?></textarea><br>
        <input type="submit" value="Update PR">
    </form>
</body>
</html>
