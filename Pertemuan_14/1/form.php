<?php
// koneksi database
include 'koneksi.php';

// Menangani form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Menampung data yang dikirim oleh form
    $kode = $_POST['kode'];
    $jumlah = $_POST['jumlah'];

    // Menginput data ke database
    $query = "CALL update_datatable('$kode', '$jumlah')";
    if (mysqli_query($koneksi, $query)) {
        // Mengalihkan halaman kembali ke form.php
        header("Location: form.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Form Kirim Barang</title>
</head>
<body>
    <h2>Tabel 1</h2>
    <table border="1">
        <tr>
            <th>kode</th>
            <th>nama barang</th>
            <th>jumlah</th>
        </tr>
        <?php
        $tabel1 = mysqli_query($koneksi, "SELECT * FROM tabel_1");
        while ($dataku = mysqli_fetch_row($tabel1)) {
            echo "<tr>
                <td>{$dataku[0]}</td>
                <td>{$dataku[1]}</td>
                <td>{$dataku[2]}</td>
            </tr>";
        }
        ?>
    </table>
    
    <h2>Tabel 2</h2>
    <table border="1">
        <tr>
            <th>kode</th>
            <th>nama barang</th>
            <th>jumlah</th>
        </tr>
        <?php
        $tabel2 = mysqli_query($koneksi, "SELECT * FROM tabel_2");
        while ($data2 = mysqli_fetch_row($tabel2)) {
            echo "<tr>
                <td>{$data2[0]}</td>
                <td>{$data2[1]}</td>
                <td>{$data2[2]}</td>
            </tr>";
        }
        ?>
    </table>
    
    <h2>Kirim Barang</h2>
    <form action="form.php" method="post">
        <label>Kode Barang:</label>
        <select name="kode">
            <?php
            $tabel1 = mysqli_query($koneksi, "SELECT * FROM tabel_1");
            while ($data1 = mysqli_fetch_row($tabel1)) {
                echo '<option value="' . $data1[0] . '">' . $data1[0] . '/' . $data1[1] . '</option>';
            }
            ?>
        </select><br><br>
        <label>Jumlah:</label><input type="number" name="jumlah"><br><br>
        <input type="submit" value="Kirim">
    </form>
</body>
</html>