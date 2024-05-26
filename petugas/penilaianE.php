<?php
session_start();
include 'koneksi.php';

// Jika user belum login, redirect ke halaman login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../index.php');
    exit;
}

$result = $db->query("SELECT * FROM alternatif WHERE kode_alternatif='" . $db->real_escape_string($_GET['id']) . "'");
$row = $result->fetch_assoc();

if (isset($_POST['save'])) {
    foreach ((array) $_POST['nilai'] as $key => $val) {
        $db->query("UPDATE penilaian SET id_subkriteria='$val' WHERE id_penilaian='$key'");
    }
    header("location:penilaian.php");
    exit();
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
                        <div class="col-sm-8">
                            <h1 class="m-0"><Strong>Update </Strong>penilaian alternatif</h1>
                            <a>Melakukan update penilaian dari alternatif untuk tiap kriteria</a>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    
                    <div class="card">
                        <div class="card-header bg-gradient-blue">
                            <h5 class="m-0"><b>Form nilai alternatif</b> &raquo; <small><?= $row['nama_alternatif'] ?></small></h5>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="row">
                                    <?php
                                    // Eksekusi query dengan objek koneksi database
                                    $query = $db->query("SELECT ba.id_penilaian, k.id_kriteria, k.nama_kriteria, s.kode_subkriteria
                                    FROM penilaian ba 
                                    INNER JOIN alternatif a ON a.id_alternatif= ba.id_alternatif
                                    INNER JOIN kriteria k ON k.id_kriteria=ba.id_kriteria  
                                    LEFT JOIN subkriteria s ON s.id_subkriteria = ba.id_subkriteria
                                    WHERE a.kode_alternatif='" . $db->real_escape_string($_GET['id']) . "' ORDER BY kode_kriteria");

                                    // Periksa apakah query berhasil dieksekusi
                                    if ($query && $query->num_rows > 0) {
                                        // Lakukan iterasi pada hasil query
                                        while ($row = $query->fetch_object()) {
                                    ?>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?= $row->nama_kriteria ?></label>
                                                    <select class="form-control" name="nilai[<?= $row->id_penilaian ?>]">
                                                        <option disabled selected>Pilih Subkriteria</option>
                                                        <?php
                                                        // Query untuk mendapatkan opsi subkriteria
                                                        $sub_query = $db->query("SELECT id_subkriteria, kode_subkriteria, nama_subkriteria FROM subkriteria WHERE id_kriteria='" . $row->id_kriteria . "' ORDER BY kode_subkriteria");

                                                        // Periksa apakah query subkriteria berhasil dieksekusi
                                                        if ($sub_query && $sub_query->num_rows > 0) {

                                                            // Lakukan iterasi pada hasil query subkriteria
                                                            while ($sub_row = $sub_query->fetch_object()) {

                                                                $selected = ($sub_row->kode_subkriteria == $row->kode_subkriteria) ? 'selected' : '';
                                                                echo '<option value="' . $sub_row->id_subkriteria . '" ' . $selected . '>' . $sub_row->kode_subkriteria . ' - ' . $sub_row->nama_subkriteria . '</option>';
                                                            }
                                                            // Bebaskan hasil query subkriteria
                                                            $sub_query->free();
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                        // Bebaskan hasil query
                                        $query->free();
                                    } else {
                                        echo 'Tidak ada data yang ditemukan.';
                                    }
                                    ?>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" name="save"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                                    <a class="btn btn-danger" href="penilaian.php"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
                                </div>
                            </form>
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