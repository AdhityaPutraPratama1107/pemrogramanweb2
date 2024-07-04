<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

require 'koneksi.php';

$data_id = $_GET['id'];

$sql_data = "SELECT * FROM pr WHERE id_barang = $data_id";
$result_data = $conn->query($sql_data);
$data = $result_data->fetch_assoc();

$sql_history = "SELECT * FROM pr_log WHERE data_id = $data_id ORDER BY edited_at DESC";
$result_history = $conn->query($sql_history);
?>

<!DOCTYPE html>
<html>
<head>
    <title>PR History</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: px;
            text-align: left;
        }
        .highlight {
            background-color: yellow;
        }
    </style>
</head>
<body>
<?php include "menu.php"; ?>

<h1>PR History for: <?php echo $data['kode_barang']; ?></h1>
<p><strong>PR:</strong> <?php echo $data['pr']; ?></p>

<table>
    <tr>
        <th>Action</th>
        <th>Edited By</th>
        <th>Edited At</th>
        <th>Field</th>
        <th>Old Value</th>
        <th>New Value</th>
    </tr>
    <?php
    if ($result_history->num_rows > 0) {
        while($row = $result_history->fetch_assoc()) {
            echo "<tr>";
            echo "<tr>";
            echo "<td>" . ucfirst($row['action']) . "</td>";
            echo "<td>" . $row['edited_by'] . "</td>";
            echo "<td>" . $row['edited_at'] . "</td>";
            $fields = [
                'kode_barang' => 'Kode Barang',
                'pr' => 'PR',
                'item_description' => 'Item Description',
                'qty' => 'Qty',
                'unit' => 'Unit',
                'qty_os' => 'Qty OS',
                'tanggal_pengajuan' => 'Tanggal Pengajuan',
                'jenis_pengajuan' => 'Jenis Pengajuan',
                'proses_pengajuan' => 'Proses Pengajuan',
                'proses_pencarian_vendor' => 'Proses Pencarian Vendor',
                'jenis_pembayaran' => 'Jenis Pembayaran',
                'proses_pembayaran' => 'Proses Pembayaran',
                'tanggal_tempo' => 'Tanggal Tempo',
                'status' => 'Status',
                'jenis' => 'Jenis',
                'qty_dikirim' => 'Qty Dikirim',
                'keterangan' => 'Keterangan'
            ];
            foreach ($fields as $field => $label) {
                $old_field = "old_" . $field;
                $new_field = "new_" . $field;
                $highlight_class = $row[$old_field] != $row[$new_field] ? "highlight" : "";
                echo "<tr>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td>$label</td>";
                echo "<td class='$highlight_class'>" . $row[$old_field] . "</td>";
                echo "<td class='$highlight_class'>" . $row[$new_field] . "</td>";
                echo "</tr>";
            }
        }
    } else {
        echo "<tr><td colspan='6'>No history available</td></tr>";
    }
    ?>
</table>

</body>
</html>
