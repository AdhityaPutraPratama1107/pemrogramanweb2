<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
    header("Location: index.php");
    exit();
}

require 'koneksi.php';

$sql = "SELECT * FROM teams";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
</head>
<body>
    <?php include 'menu1.php'; ?>
    <h1>Welcome, User!</h1>
    <p>This is the user dashboard.</p>
    <a href="logout.php">Logout</a>
    <div class="content">
        
        <div class="container-fluid py-3 d-flex flex-wrap justify-content-between">
            <div class="judul">
                <h4><b>EURO</b></h4>
            </div>
            <div class="menu d-flex flex-wrap">
                <div class="dropdown me-2 mb-2">
                <form action="export_team.php" method="post">
                    <button type="submit" name="export" class="btn bg-white shadow-sm text-primary">Export</button>
                </form>
                </div>

                <div class="dropdown">
                    <a class="btn bg-white shadow-sm text-primary" href="add_tim.php">
                        Add Team
                    </a>
            </div>
            </div>
        </div>
        
        <div class="container-fluid pt-3 position-relative">
            <div class="table-responsive">
                <table id="example" class="table table-striped">
                    <thead>
                    <tr>
                        <th class="text-center"><input type="checkbox" id="selectAll"></th>
                        <th>No</th>
                        <th>TIM</th>
                        <th>Menang</th>
                        <th>Seri</th>
                        <th>Kalah</th>
                        <th>Poin</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td class='text-center'><input type='checkbox'></td> <!-- Tambahkan checkbox di sini -->
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['team']); ?></td>
                                <td><?php echo htmlspecialchars($row['menang']); ?></td>
                                <td><?php echo htmlspecialchars($row['seri']); ?></td>
                                <td><?php echo htmlspecialchars($row['kalah']); ?></td>
                                <td><?php echo htmlspecialchars($row['poin']); ?></td>
                                <td>
                                    <a href="edit_team.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary action-btn">Edit</a>
                                    <a href="delete_team.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger action-btn" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="jarak mb-5"></div>

    </div>
        <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Custom JavaScript -->
    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                lengthChange: false,
                pageLength: 5,
                info: false,
                columnDefs: [{
                    targets: 0,
                    orderable: false,
                    className: 'dt-body-center',
                    render: function(data, type, full, meta) {
                        return '<input type="checkbox">';
                    }
                }]
            });

            // Remove sorting ability from the first column header
            $('#example thead th:first-child').removeClass('sorting_asc sorting_desc sorting');

            // Remove sorting ability from the last column header initially
            $('#example thead th:last-child').removeClass('sorting_asc sorting_desc sorting');

            // Menghapus kelas sorting dari kolom terakhir setelah pengurutan kolom lain
            $('#example').on('order.dt', function() {
                $('#example thead th:last-child').removeClass('sorting_asc sorting_desc sorting');
            });

            // Menambahkan event listener untuk kotak centang "Select All"
            $('#selectAll').on('change', function() {
                table.rows({
                    search: 'applied'
                }).nodes().to$().find('input[type="checkbox"]').prop('checked', this.checked);
            });

            // DataTable custom search field
            $('#searchInput').keyup(function() {
                table.search(this.value).draw();
                $('#example thead th:first-child').removeClass('sorting_asc sorting_desc sorting');
                $('#example thead th:last-child').removeClass('sorting_asc sorting_desc sorting')
            });
        });

        $(document).ready(function() {
        $('#fileInput').change(function() {
            var file = this.files[0];
            var formData = new FormData();
            formData.append('file', file);

            $.ajax({
                url: 'import_pr.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert(response); // Tampilkan pesan dari PHP setelah import berhasil
                    location.reload(); // Muat ulang halaman setelah import selesai
                },
                error: function() {
                    alert('Error: Tidak dapat mengunggah file.'); // Tampilkan pesan kesalahan jika gagal unggah
                }
            });
        });
    
    });
    </script>
</body>
</html>
