<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

require 'koneksi.php';

if (isset($_GET['id'])) {
    $id_barang = $_GET['id'];
    $sql_select = "SELECT * FROM pr WHERE id_barang = $id_barang";
    $result_select = $conn->query($sql_select);

    if ($result_select->num_rows == 1) {
        $row = $result_select->fetch_assoc();

        $sql_delete = "DELETE FROM pr WHERE id_barang = $id_barang";

        if ($conn->query($sql_delete) === TRUE) {
            // Log deletion
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
                        ) SELECT
                            $id_barang, 'delete', '".$_SESSION['username']."', 
                            old_kode_barang, NULL, 
                            old_pr, NULL, 
                            old_tanggal_permintaan, NULL, 
                            old_item_description, NULL, 
                            old_qty, NULL, 
                            old_unit, NULL, 
                            old_qty_os, NULL, 
                            old_tanggal_pengajuan, NULL, 
                            old_jenis_pengajuan, NULL, 
                            old_proses_pengajuan, NULL, 
                            old_proses_pencarian_vendor, NULL, 
                            old_jenis_pembayaran, NULL, 
                            old_proses_pembayaran, NULL, 
                            old_tanggal_tempo, NULL, 
                            old_status, NULL, 
                            old_jenis, NULL, 
                            old_qty_dikirim, NULL, 
                            old_keterangan, NULL
                        FROM (
                            SELECT
                                kode_barang AS old_kode_barang, pr AS old_pr, 
                                tanggal_permintaan AS old_tanggal_permintaan, 
                                item_description AS old_item_description, 
                                qty AS old_qty, unit AS old_unit, 
                                qty_os AS old_qty_os, 
                                tanggal_pengajuan AS old_tanggal_pengajuan, 
                                jenis_pengajuan AS old_jenis_pengajuan, 
                                proses_pengajuan AS old_proses_pengajuan, 
                                proses_pencarian_vendor AS old_proses_pencarian_vendor, 
                                jenis_pembayaran AS old_jenis_pembayaran, 
                                proses_pembayaran AS old_proses_pembayaran, 
                                tanggal_tempo AS old_tanggal_tempo, 
                                status AS old_status, jenis AS old_jenis, 
                                qty_dikirim AS old_qty_dikirim, 
                                keterangan AS old_keterangan
                            FROM pr
                            WHERE id_barang = $id_barang
                        ) AS old_data";

            $conn->query($sql_log);

            header("Location: pr.php");
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Data not found.";
    }
} else {
    echo "Parameter id_barang is missing.";
}
?>
