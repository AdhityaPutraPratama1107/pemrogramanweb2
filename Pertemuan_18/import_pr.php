<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

require 'koneksi.php'; // Sesuaikan dengan file koneksi database Anda

// Proses import jika ada file yang diunggah
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file']['tmp_name'];

    // Load library PHPExcel
    require_once 'PHPExcel/PHPExcel.php'; // Sesuaikan dengan lokasi file PHPExcel.php

    $inputFileType = PHPExcel_IOFactory::identify($file);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($file);

    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();

    // Mulai dari baris kedua, karena baris pertama biasanya berisi header
    for ($row = 2; $row <= $highestRow; $row++) {
        // Mendapatkan data dari setiap kolom
        $kode_barang = $sheet->getCellByColumnAndRow(0, $row)->getValue();
        $pr = $sheet->getCellByColumnAndRow(1, $row)->getValue();
        $tanggal_permintaan = $sheet->getCellByColumnAndRow(2, $row)->getValue();
        $item_description = $sheet->getCellByColumnAndRow(3, $row)->getValue();
        $qty = $sheet->getCellByColumnAndRow(4, $row)->getValue();
        $unit = $sheet->getCellByColumnAndRow(5, $row)->getValue();
        $qty_os = $sheet->getCellByColumnAndRow(6, $row)->getValue();
        $tanggal_pengajuan = $sheet->getCellByColumnAndRow(7, $row)->getValue();
        $jenis_pengajuan = $sheet->getCellByColumnAndRow(8, $row)->getValue();
        $proses_pengajuan = $sheet->getCellByColumnAndRow(9, $row)->getValue();
        $proses_pencarian_vendor = $sheet->getCellByColumnAndRow(10, $row)->getValue();
        $jenis_pembayaran = $sheet->getCellByColumnAndRow(11, $row)->getValue();
        $proses_pembayaran = $sheet->getCellByColumnAndRow(12, $row)->getValue();
        $tanggal_tempo = $sheet->getCellByColumnAndRow(13, $row)->getValue();
        $status = $sheet->getCellByColumnAndRow(14, $row)->getValue();
        $jenis = $sheet->getCellByColumnAndRow(15, $row)->getValue();
        $qty_dikirim = $sheet->getCellByColumnAndRow(16, $row)->getValue();
        $keterangan = $sheet->getCellByColumnAndRow(17, $row)->getValue();

        // Query untuk cek apakah data sudah ada berdasarkan kode_barang
        $check_sql = "SELECT * FROM pr WHERE kode_barang = '$kode_barang'";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            // Jika data sudah ada, lakukan UPDATE
            $update_sql = "UPDATE pr SET 
                pr = '$pr',
                tanggal_permintaan = '$tanggal_permintaan',
                item_description = '$item_description',
                qty = '$qty',
                unit = '$unit',
                qty_os = '$qty_os',
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
                WHERE kode_barang = '$kode_barang'";
            
            if ($conn->query($update_sql) === TRUE) {
                echo "Data dengan kode barang $kode_barang berhasil diupdate.<br>";
            } else {
                echo "Error: " . $update_sql . "<br>" . $conn->error;
            }
        } else {
            // Jika data belum ada, lakukan INSERT
            $insert_sql = "INSERT INTO pr (kode_barang, pr, tanggal_permintaan, item_description, qty, unit, qty_os, tanggal_pengajuan, jenis_pengajuan, proses_pengajuan, proses_pencarian_vendor, jenis_pembayaran, proses_pembayaran, tanggal_tempo, status, jenis, qty_dikirim, keterangan) 
                    VALUES ('$kode_barang', '$pr', '$tanggal_permintaan', '$item_description', '$qty', '$unit', '$qty_os', '$tanggal_pengajuan', '$jenis_pengajuan', '$proses_pengajuan', '$proses_pencarian_vendor', '$jenis_pembayaran', '$proses_pembayaran', '$tanggal_tempo', '$status', '$jenis', '$qty_dikirim', '$keterangan')";

            if ($conn->query($insert_sql) === TRUE) {
                echo "Data dengan kode barang $kode_barang berhasil diimpor.<br>";
            } else {
                echo "Error: " . $insert_sql . "<br>" . $conn->error;
            }
        }
    }
}

$conn->close();
?>
