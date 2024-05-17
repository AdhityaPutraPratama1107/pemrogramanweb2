<?php
$servername = "localhost";
$username = "root";  // Ganti dengan username database Anda
$password = "";  // Ganti dengan password database Anda
$dbname = "dbBerita";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi untuk menambahkan kategori
if (isset($_POST['add_kategori'])) {
    $nama_kategori = $_POST['nama_kategori'];
    $sql = "INSERT INTO tblKategori (nama_kategori) VALUES ('$nama_kategori')";
    if ($conn->query($sql) === TRUE) {
        echo "Kategori berhasil ditambahkan.<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fungsi untuk menambahkan berita
if (isset($_POST['add_berita'])) {
    $idKategori = $_POST['idKategori'];
    $judulberita = $_POST['judulberita'];
    $isiberita = $_POST['isiberita'];
    $penulis = $_POST['penulis'];
    $tgldipublish = date('Y-m-d H:i:s');
    $sql = "INSERT INTO tblBerita (idKategori, judulberita, isiberita, penulis, tgldipublish) VALUES ('$idKategori', '$judulberita', '$isiberita', '$penulis', '$tgldipublish')";
    if ($conn->query($sql) === TRUE) {
        echo "Berita berhasil ditambahkan.<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fungsi untuk mengedit berita
if (isset($_POST['edit_berita'])) {
    $idBerita = $_POST['idBerita'];
    $idKategori = $_POST['idKategori'];
    $judulberita = $_POST['judulberita'];
    $isiberita = $_POST['isiberita'];
    $penulis = $_POST['penulis'];
    $sql = "UPDATE tblBerita SET idKategori='$idKategori', judulberita='$judulberita', isiberita='$isiberita', penulis='$penulis' WHERE idBerita='$idBerita'";
    if ($conn->query($sql) === TRUE) {
        echo "Berita berhasil diubah.<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fungsi untuk menghapus berita
if (isset($_GET['delete'])) {
    $idBerita = $_GET['delete'];
    $sql = "DELETE FROM tblBerita WHERE idBerita='$idBerita'";
    if ($conn->query($sql) === TRUE) {
        echo "Berita berhasil dihapus.<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Berita</title>
</head>
<body>
    <h1>Manajemen Berita</h1>

    <h2>Tambah Kategori</h2>
    <form method="POST" action="">
        Nama Kategori: <input type="text" name="nama_kategori" required>
        <input type="submit" name="add_kategori" value="Tambah Kategori">
    </form>

    <h2>Tambah Berita</h2>
    <form method="POST" action="">
        Kategori:
        <select name="idKategori" required>
            <?php
            $sql = "SELECT * FROM tblKategori";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['idKategori'] . "'>" . $row['nama_kategori'] . "</option>";
            }
            ?>
        </select><br>
        Judul Berita: <input type="text" name="judulberita" required><br>
        Isi Berita: <textarea name="isiberita" required></textarea><br>
        Penulis: <input type="text" name="penulis" required><br>
        <input type="submit" name="add_berita" value="Tambah Berita">
    </form>

    <h2>Daftar Berita</h2>
    <table border="1">
        <tr>
            <th>Kategori</th>
            <th>Judul Berita</th>
            <th>Isi Berita</th>
            <th>Penulis</th>
            <th>Tanggal Publish</th>
            <th>Aksi</th>
        </tr>
        <?php
        $sql = "SELECT b.idBerita, k.nama_kategori, b.judulberita, b.isiberita, b.penulis, b.tgldipublish 
                FROM tblBerita b 
                JOIN tblKategori k ON b.idKategori = k.idKategori 
                ORDER BY b.tgldipublish DESC";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['nama_kategori'] . "</td>
                    <td>" . $row['judulberita'] . "</td>
                    <td>" . $row['isiberita'] . "</td>
                    <td>" . $row['penulis'] . "</td>
                    <td>" . $row['tgldipublish'] . "</td>
                    <td>
                        <a href='?edit=" . $row['idBerita'] . "'>Edit</a>
                        <a href='?delete=" . $row['idBerita'] . "' onclick='return confirm(\"Yakin ingin menghapus?\")'>Delete</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>

    <?php
    if (isset($_GET['edit'])) {
        $idBerita = $_GET['edit'];
        $sql = "SELECT * FROM tblBerita WHERE idBerita='$idBerita'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
    ?>
    <h2>Edit Berita</h2>
    <form method="POST" action="">
        <input type="hidden" name="idBerita" value="<?php echo $row['idBerita']; ?>">
        Kategori:
        <select name="idKategori" required>
            <?php
            $sql = "SELECT * FROM tblKategori";
            $result = $conn->query($sql);
            while($kategori = $result->fetch_assoc()) {
                $selected = ($kategori['idKategori'] == $row['idKategori']) ? "selected" : "";
                echo "<option value='" . $kategori['idKategori'] . "' $selected>" . $kategori['nama_kategori'] . "</option>";
            }
            ?>
        </select><br>
        Judul Berita: <input type="text" name="judulberita" value="<?php echo $row['judulberita']; ?>" required><br>
        Isi Berita: <textarea name="isiberita" required><?php echo $row['isiberita']; ?></textarea><br>
        Penulis: <input type="text" name="penulis" value="<?php echo $row['penulis']; ?>" required><br>
        <input type="submit" name="edit_berita" value="Edit Berita">
    </form>
    <?php
    }
    ?>

</body>
</html>

<?php
// Menutup koneksi
$conn->close();
?>