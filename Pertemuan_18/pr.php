<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

require 'koneksi.php';



// Query untuk mengambil data PR (termasuk filter jika diperlukan)
$filter = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['filter'])) {
    $filter = $_POST['filter'];
}
$sql = "SELECT * FROM pr WHERE kode_barang LIKE '%$filter%'";
$result = $conn->query($sql);

// Query untuk menghitung total PR
$sql_total = "SELECT COUNT(*) AS total_pr FROM pr WHERE kode_barang LIKE '%$filter%'";
$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_pr = $row_total['total_pr'];

$sql_total_open = "SELECT COUNT(*) AS total_open FROM pr WHERE status = 'Open' AND kode_barang LIKE '%$filter%'";
$result_total_open = $conn->query($sql_total_open);
$row_total_open = $result_total_open->fetch_assoc();
$total_open = $row_total_open['total_open'];

// Query untuk menghitung total PR Close
$sql_total_close = "SELECT COUNT(*) AS total_close FROM pr WHERE status = 'Close' AND kode_barang LIKE '%$filter%'";
$result_total_close = $conn->query($sql_total_close);
$row_total_close = $result_total_close->fetch_assoc();
$total_close = $row_total_close['total_close'];

// Query untuk menghitung total PR Parsial
$sql_total_parsial = "SELECT COUNT(*) AS total_parsial FROM pr WHERE status = 'Parsial' AND kode_barang LIKE '%$filter%'";
$result_total_parsial = $conn->query($sql_total_parsial);
$row_total_parsial = $result_total_parsial->fetch_assoc();
$total_parsial = $row_total_parsial['total_parsial'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data PR</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .action-btn {
            width: 80px; /* Ubah sesuai kebutuhan Anda */
            display: inline-block;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include 'menu.php'; ?>
    <div class="content">
        
        <div class="container-fluid py-3 d-flex flex-wrap justify-content-between">
            <div class="judul">
                <h4><b>Employees</b></h4>
            </div>
            <div class="menu d-flex flex-wrap">
                <div class="dropdown me-2 mb-2">
                <form action="export_pr.php" method="post">
                    <button type="submit" name="export" class="btn bg-white shadow-sm text-primary">Export</button>
                </form>
                </div>
                <div class="me-2 mb-2">
                <label for="fileInput" class="btn bg-white shadow-sm text-primary">Import</label>
                 <input type="file" id="fileInput" name="file" accept=".xls" style="display: none;">
                </div>

                <div class="dropdown">
                    <a class="btn bg-white shadow-sm text-primary" href="add_pr.php">
                        Add PR
                    </a>
            </div>
            </div>
        </div>
        <div class="container-fluid d-lg-flex justify-content-between">
            <div class="kolom1 d-lg-flex">
                <div class="kolom1Menu1 d-flex flex-wrap mb-2 me-lg-2">
                    <div class="border rounded col-12 col-lg-auto text-center px-2 py-2 d-flex justify-content-between">
                        <div class="icon1 me-lg-3">
                            <i class="bi bi-card-list"></i><a href="#" class="ms-2 text-black text-decoration-none"></a>
                        </div>
                        <div class="icon2">
                            <i class="bi bi-diagram-3"></i><a href="#" class="ms-2 text-black text-decoration-none"></a>
                        </div>
                    </div>
                </div>
                <div class="kolom1Menu2 mb-2">
                    <div class="p-1 border rounded-3">
                        <select class="form-select border-0" aria-label="Default select example" style="padding-right: 8.5rem">
                            <option selected>Filter (1)</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="kolom2 d-flex flex-wrap justify-content-between">
                <div class="search col-12 col-md-auto">
                    <input id="searchInput" class="form-control" type="search" placeholder="Search" aria-label="Search">
                </div>
            </div>
        </div>
        <div class="container-fluid mt-3">
            <div class="border rounded py-3 px-3 d-flex flex-wrap justify-content-between text-center text-sm-start">
                <div class="tanggal col-12 col-sm-6 col-lg-auto mt-2 mb-2">
                    <span>Tanggal</span>
                    <h5><b><?php echo date("F j, Y"); ?></b></h5>
                </div>
                <div class="totalEmployees col-12 col-sm-6 col-lg-auto mt-2 mb-2">
                    <p class="mb-0 fw-light">Total Input</p>
                    <h5><b><?php echo $total_pr; ?></b></h5>
                </div>
                <div class="newHire col-12 col-sm-6 col-lg-auto mt-2 mb-2">
                    <p class="mb-0 fw-light">Total Open</p>
                    <h5><b><?php echo $total_open; ?></b></h5>
                </div>
                <div class="leaving col-12 col-sm-6 col-lg-auto mt-2 mb-2">
                    <p class="mb-0 fw-light">Total Close</p>
                    <h5><b><?php echo $total_close; ?></b></h5>
                </div>
                <div class="leaving col-12 col-sm-6 col-lg-auto mt-2 mb-2">
                    <p class="mb-0 fw-light">Total Parsial</p>
                    <h5><b><?php echo $total_parsial; ?></b></h5>
                </div>
                <div class="detail d-flex align-items-center col-12 col-sm-6 col-lg-auto mt-2 mb-2 justify-content-center justify-content-sm-start">
                    
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
                        <th>Kode Barang</th>
                        <th>PR</th>
                        <th>Tanggal Permintaan</th>
                        <th>Item Description</th>
                        <th>Qty</th>
                        <th>Unit</th>
                        <th>Qty OS</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Jenis Pengajuan</th>
                        <th>Proses Pengajuan</th>
                        <th>Proses Pencarian Vendor</th>
                        <th>Jenis Pembayaran</th>
                        <th>Proses Pembayaran</th>
                        <th>Tanggal Tempo</th>
                        <th>Status</th>
                        <th>Jenis</th>
                        <th>Qty Dikirim</th>
                        <th>Keterangan</th>
                        <th>PIC</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td class='text-center'><input type='checkbox'></td> <!-- Tambahkan checkbox di sini -->
                                <td><?php echo htmlspecialchars($row['id_barang']); ?></td>
                                <td><?php echo htmlspecialchars($row['kode_barang']); ?></td>
                                <td><?php echo htmlspecialchars($row['pr']); ?></td>
                                <td><?php echo date("d F Y", strtotime($row['tanggal_permintaan'])); ?></td>
                                <td><?php echo htmlspecialchars($row['item_description']); ?></td>
                                <td><?php echo htmlspecialchars($row['qty']); ?></td>
                                <td><?php echo htmlspecialchars($row['unit']); ?></td>
                                <td><?php echo htmlspecialchars($row['qty_os']); ?></td>
                                <td><?php echo date("d F Y", strtotime($row['tanggal_pengajuan'])); ?></td>
                                <td><?php echo htmlspecialchars($row['jenis_pengajuan']); ?></td>
                                <td><?php echo htmlspecialchars($row['proses_pengajuan']); ?></td>
                                <td><?php echo htmlspecialchars($row['proses_pencarian_vendor']); ?></td>
                                <td><?php echo htmlspecialchars($row['jenis_pembayaran']); ?></td>
                                <td><?php echo htmlspecialchars($row['proses_pembayaran']); ?></td>
                                <td><?php echo date("d F Y", strtotime($row['tanggal_tempo'])); ?></td>
                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                                <td><?php echo htmlspecialchars($row['jenis']); ?></td>
                                <td><?php echo htmlspecialchars($row['qty_dikirim']); ?></td>
                                <td><?php echo htmlspecialchars($row['keterangan']); ?></td>
                                <td><?php echo htmlspecialchars($row['pic']); ?></td>
                                <td>
                                    <a href="edit_pr.php?id=<?php echo $row['id_barang']; ?>" class="btn btn-sm btn-primary action-btn">Edit</a>
                                    <a href="delete_pr.php?id=<?php echo $row['id_barang']; ?>" class="btn btn-sm btn-danger action-btn" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                                    <a href="history_pr.php?id=<?php echo $row['id_barang']; ?>" class="btn btn-sm btn-info action-btn">History</a>
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

