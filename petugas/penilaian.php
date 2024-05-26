<?php
session_start();
include 'koneksi.php';

// // Jika user belum login, redirect ke halaman login
// if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
//     header('Location: index.php');
//     exit;
// }
// if (!isset($_SESSION['username'])) {
//     header('location:../index.php');
// } elseif ($_SESSION['level'] != "petugas") {
//     header('location:../index.php');
// }

$query_alt = mysqli_query($db, "SELECT id_alternatif, kode_alternatif, nama_alternatif FROM alternatif ORDER BY id_alternatif ASC");
$alt_array = array();
while ($row = mysqli_fetch_object($query_alt)) {
    $alt_array[$row->kode_alternatif] = $row->nama_alternatif;
}

$query_kri = mysqli_query($db, "SELECT id_kriteria, kode_kriteria, nama_kriteria FROM kriteria ORDER BY id_kriteria");
$kri_array = array();
while ($row = mysqli_fetch_object($query_kri)) {
    $kri_array[$row->kode_kriteria] = $row->nama_kriteria;
}

$query_sub = mysqli_query($db, "SELECT k.kode_kriteria, s.kode_subkriteria, s.nama_subkriteria 
FROM subkriteria s
INNER JOIN kriteria k ON k.id_kriteria=s.id_kriteria
ORDER BY kode_subkriteria");
$sub_array = array();
while ($row = mysqli_fetch_object($query_sub)) {
    $sub_array[$row->kode_subkriteria] = array(
        'nama_sub' => $row->nama_subkriteria,
        'kode_kriteria' => $row->kode_kriteria,
    );
}

// Fungsi untuk mendapatkan data bobot alternatif
function get_penilaian($db)
{
    $query = "SELECT a.id_alternatif, a.kode_alternatif, k.id_kriteria, k.kode_kriteria, s.kode_subkriteria
              FROM penilaian ba 
              INNER JOIN kriteria k ON k.id_kriteria=ba.id_kriteria
              INNER JOIN alternatif a ON a.id_alternatif = ba.id_alternatif
              LEFT JOIN subkriteria s ON s.id_subkriteria=ba.id_subkriteria
              ORDER BY a.id_alternatif, k.id_kriteria";

    $result = mysqli_query($db, $query);
    if (!$result) {
        // Handle error jika query gagal
        echo "Error: " . mysqli_error($db);
        return null;
    }

    $arr = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $arr[$row['kode_alternatif']][$row['kode_kriteria']] = $row['kode_subkriteria'];
    }
    return $arr;
}
// Mendapatkan data bobot alternatif
$data = get_penilaian($db);

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
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
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
                            <h1 class="m-0"><Strong>Penilaian</Strong> Kelayakan Angkutan</h1>
                            <a>Menentukan nilai bobot untuk setiap alternatif angkutan dengan menentukan nilai kriteria dan subkriteria nya masing-masing</a>
                        </div><!-- /.col -->
                        <!-- <div class="col-sm-4">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard v1</li>
                            </ol>
                        </div>/.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <div class="col-sm-6" id="alert">
                        <?php
                        if (isset($_SESSION['pesan'])) :
                        ?>
                            <div class="alert alert-warning alert-dismissible fade show">
                                <i class="fas fa-exclamation-triangle nav-icon"></i>
                                <strong><?php echo $_SESSION['pesan']; ?></strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php
                            session_destroy();
                            ?>
                        <?php
                        elseif (isset($_SESSION['berhasil'])) :
                        ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="	fas fa-check-circle nav-icon"></i>
                                <strong><?php echo $_SESSION['berhasil']; ?></strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php
                            session_destroy();
                            ?>
                        <?php
                        elseif (isset($_SESSION['gagal'])) :
                        ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="	fas fa-check-circle nav-icon"></i>
                                <strong><?php echo $_SESSION['gagal']; ?></strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php
                            session_destroy();
                        endif;
                        ?>
                    </div>

                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <b>Nilai Bobot per Alternatif</b>
                        </div>
                        <div class="card-body">
                            <!-- Tabel Bobot Alternatif -->
                            <div class="table-responsive">
                                <table class="table-bordered table-sm" width="100%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center">Kode</th>
                                            <th class="text-center" width="10%">Nama Alternatif</th>
                                            <?php foreach ($kri_array as $key => $val) : ?>
                                                <th class="text-center"><?= $val ?></th>
                                            <?php endforeach ?>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($data) {
                                            foreach ($data as $key => $val) : ?>
                                                <tr>
                                                    <td class="text-center"><?= $key ?></td>
                                                    <td><?= $alt_array[$key] ?></td>
                                                    <?php foreach ($val as $k => $v) : ?>
                                                        <td><?= isset($sub_array[$v]['nama_sub']) ? $sub_array[$v]['nama_sub'] : '' ?></td>
                                                    <?php endforeach ?>
                                                    <!-- Placeholder for new criteria columns -->
                                                    <?php for ($i = count($val); $i < count($kri_array); $i++) : ?>
                                                        <td></td>
                                                    <?php endfor; ?>
                                                    <td>
                                                        <center>
                                                            <a class="btn btn-xs btn-warning" href="penilaianE.php?id=<?= $key ?>"><i class="fas fa-edit nav-icon "></i></a>
                                                        </center>
                                                    </td>
                                                </tr>
                                        <?php endforeach;
                                        } else {
                                            // Handle jika data tidak ditemukan
                                            echo "<tr><td colspan='" . (count($kri_array) + 3) . "'>Data tidak ditemukan</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
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

    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="plugins/sparklines/sparkline.js"></script>
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
</body>

</html>