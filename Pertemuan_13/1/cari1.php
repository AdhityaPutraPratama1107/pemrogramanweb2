<?php
echo "<html>
<body>";
$koneksi = mysqli_connect("localhost", "root", "", "pertemuan_13");
// mysql_select_db("lat_dbase");
$cari = $_POST['nama'];
$hasil = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE nama LIKE '%$cari%' ORDER BY nama ASC");
echo "<table>
<tr>
<th>NIM</th>
<th>Nama</th>
<th>Alamat</th>
<th>Jurusan</th>
</tr>";
while ($data = mysqli_fetch_array($hasil)) {
    echo "<tr>
<td>" . $data['nim'] . "</td>
<td>" . $data['nama'] . "</td>
<td>" . $data['alamat'] . "</td>
<td>" . $data['jurusan'] . "</td>
</tr>";
}
echo "</table>
</body>
</html>";
?>