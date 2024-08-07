<?php
session_start();
include 'koneksi.php';

// Jika user belum login, redirect ke halaman login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="dist/img/dishub.png">
    <title>SPK Kelayakan Angkutan | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">

        <?php
        include 'layer/navbar.php';
        include 'layer/sidebar.php';
        ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><strong>Hasil</strong> Kelayakan Angkutan</h1>
                            <a>Menampilkan hasil akhir proses perhitungan penentuan kelayakan angkutan</a>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <div class="card">
                        <div class="card-header bg-blue">
                            <b>Hasil Akhir</b>
                        </div>
                        <div class="card-body">
                            <form class="form-inline" method="get" action="">
                                <input class="form-control mr-sm-2" type="search" name="search" placeholder="Cari Nomor Angkutan....." aria-label="Search">
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Cari</button>
                                <a href="hasil.php" class="btn btn-outline-secondary my-2 my-sm-0 ml-2">Refresh</a>
                            </form>
                            <br>
                            <div class="table-responsive">
                                <table class="table-bordered table-hover table-sm" width="100%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nama Kendaraan</th>
                                            <th class="text-center">Nilai</th>
                                            <th class="text-center">Keterangan</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        // Batasan dan halaman
                                        $batas = 5;
                                        $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
                                        $posisi = ($halaman - 1) * $batas;
                                        $no = $posisi + 1;

                                        // Pencarian
                                        $search = isset($_GET['search']) ? $_GET['search'] : '';

                                        // Query dengan pencarian
                                        $query = $db->prepare("SELECT * FROM alternatif WHERE nama_alternatif LIKE ? ORDER BY id_alternatif ASC LIMIT ?, ?");
                                        $search_param = "%{$search}%";
                                        $query->bind_param('sii', $search_param, $posisi, $batas);
                                        $query->execute();
                                        $result = $query->get_result();

                                        if ($result->num_rows > 0) {
                                            while ($r = $result->fetch_assoc()) {
                                        ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center"><?php echo $r['nama_alternatif']; ?></td>
                                                    <td class="text-center"><?php echo round($r['nilai_alternatif'], 3); ?></td>
                                                    <td class="text-center">
                                                        <?php if ($r['keterangan'] == 'Layak') : ?>
                                                            <span class="badge badge-success"><?php echo $r['keterangan']; ?></span>
                                                        <?php elseif ($r['keterangan'] == 'Tidak Layak') : ?>
                                                            <span class="badge badge-danger"><?php echo $r['keterangan']; ?></span>
                                                        <?php else : ?>
                                                            <span><?php echo $r['keterangan']; ?></span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <a class="btn btn-primary btn-sm" href="cetak.php?kode_alternatif=<?php echo $r['kode_alternatif']; ?>" target="_blank">
                                                            <i class="fas fa-print nav-icon "></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="5" class="text-center"><i>Not Record Found</i></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <br>
                                <?php
                                // Pagination
                                $query2 = $db->prepare("SELECT COUNT(*) as total FROM alternatif WHERE nama_alternatif LIKE ?");
                                $query2->bind_param('s', $search_param);
                                $query2->execute();
                                $result2 = $query2->get_result();
                                $row = $result2->fetch_assoc();
                                $jlhdata = $row['total'];
                                $jlhhalaman = ceil($jlhdata / $batas);
                                ?>
                                <nav>
                                    <ul class="pagination justify-content">
                                        <?php
                                        if ($halaman > 1) {
                                            $previous = $halaman - 1;
                                            echo "<li class='page-item'><a class='page-link' href='?halaman=$previous&search=$search'>Previous</a></li>";
                                        }

                                        for ($i = 1; $i <= $jlhhalaman; $i++) {
                                            if ($i != $halaman) {
                                                echo "<li class='page-item'><a class='page-link' href='?halaman=$i&search=$search'>$i</a></li>";
                                            } else {
                                                echo "<li class='page-item active'><a class='page-link' href='#'>$i</a></li>";
                                            }
                                        }

                                        if ($halaman < $jlhhalaman) {
                                            $next = $halaman + 1;
                                            echo "<li class='page-item'><a class='page-link' href='?halaman=$next&search=$search'>Next</a></li>";
                                        }
                                        ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->

        </div>
        <!-- /.content-wrapper -->

        <?php
        include 'layer/footbar.php';
        ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>

        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard.js"></script>
</body>

</html>