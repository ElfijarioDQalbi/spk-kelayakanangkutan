<?php
session_start();
include 'koneksi.php';

// // Jika user belum login, redirect ke halaman login
// if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
//     header('Location: index.php');
//     exit;
// }
// if(!isset($_SESSION['username'])){
//     header('location:../index.php');
// }
// elseif($_SESSION['level'] != "petugas"){
//     header('location:../index.php');
// }

$query_kri = mysqli_query($db, "SELECT id_kriteria, kode_kriteria, nama_kriteria, bobot_kriteria, min, max, normalisasi FROM kriteria ORDER BY id_kriteria");
$kri_array = array();
while ($row = mysqli_fetch_object($query_kri)) {
    $kri_array[$row->kode_kriteria] = array(
        'id_kriteria' => $row->id_kriteria,
        'kode_kriteria' => $row->kode_kriteria,
        'nama_kriteria' => $row->nama_kriteria,
        'bobot_kriteria' => $row->bobot_kriteria,
        'min_kriteria' => $row->min,
        'max_kriteria' => $row->max,
        'norm' => $row->normalisasi,
    );
}

$query_alt = mysqli_query($db, "SELECT id_alternatif, kode_alternatif, nama_alternatif FROM alternatif ORDER BY id_alternatif ASC");
$alt_array = array();
while ($row = mysqli_fetch_object($query_alt)) {
    $alt_array[$row->kode_alternatif] = array(
        'id_alt' => $row->id_alternatif,
        'kode_alt' => $row->kode_alternatif,
        'nama_alt' => $row->nama_alternatif,
    );
}

$query_sub = mysqli_query($db, "SELECT k.kode_kriteria, s.kode_subkriteria, s.nama_subkriteria, s.nilai_subkriteria 
FROM subkriteria s
INNER JOIN kriteria k ON k.id_kriteria=s.id_kriteria
ORDER BY kode_subkriteria");
$sub_array = array();
while ($row = mysqli_fetch_object($query_sub)) {
    $sub_array[$row->kode_subkriteria] = array(
        'nama_sub' => $row->nama_subkriteria,
        'kode_kriteria' => $row->kode_kriteria,
        'nilai_sub' => $row->nilai_subkriteria,
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
                        <div class="col-sm-9">
                            <h1 class="m-0"><strong>Perhitungan</strong> Kelayakan Angkutan Metode SMART</h1>
                            <a>Melakukan perhitungan kelayakan angkutan dengan metode SMART (Simple Multi Atrribute Rating Technique) berdasarkan nilai yang didapatkan pada
                                penilaian</a>
                        </div><!-- /.col -->
                        <!-- <div class="col-sm-3">
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

                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <b>Nilai Alternatif</b>
                        </div>
                        <div class="card-body">
                            <!-- Tabel nilai alternatif -->
                            <div class="table-responsive">
                                <table class="table-bordered table-hover table-sm">
                                    <thead class="thead-light">
                                        <tr>
                                            <th rowspan="2" class="text-center">Kode</th>
                                            <th rowspan="2" class="text-center">Nama Alternatif</th>
                                            <?php foreach ($kri_array as $key => $val) : ?>
                                                <th class="text-center"><?= $val['nama_kriteria'] ?></th>
                                            <?php endforeach ?>
                                        </tr>
                                        <tr>
                                            <?php foreach ($kri_array as $key => $val) : ?>
                                                <th class="text-center"><?= round($val['bobot_kriteria'], 5) ?></th>
                                            <?php endforeach ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($data) {
                                            foreach ($data as $key => $val) : ?>
                                                <tr>
                                                    <td class="text-center"><?= $alt_array[$key]['kode_alt'] ?></td>
                                                    <td><?= $alt_array[$key]['nama_alt'] ?></td>
                                                    <?php foreach ($val as $k => $v) : ?>
                                                        <?php
                                                        // Periksa apakah 'nilai_sub' ada dan tidak kosong
                                                        $nilai_sub = isset($sub_array[$v]['nilai_sub']) ? $sub_array[$v]['nilai_sub'] : null;

                                                        // Format nilai yang akan ditampilkan di tabel
                                                        $display_value = $nilai_sub != 0 ? round($nilai_sub, 5) : '';
                                                        ?>
                                                        <td class="text-center"><?= $display_value ?></td>
                                                        <?php
                                                        $id_alt = $alt_array[$key]['id_alt'];
                                                        $id_kri = $kri_array[$k]['id_kriteria'];
                                                        $nilai_altperkri = $nilai_sub;

                                                        mysqli_query($db, "UPDATE perhitungan SET nilai_alternatif_per_kriteria = '$nilai_altperkri' WHERE id_alternatif = '$id_alt' AND id_kriteria = '$id_kri'");
                                                        ?>
                                                    <?php endforeach ?>
                                                </tr>
                                        <?php endforeach;
                                        } else {
                                            // Handle jika data tidak ditemukan
                                            echo "<tr><td colspan='" . (count($kri_array) + 3) . "'>Data tidak ditemukan</td></tr>";
                                        }
                                        ?>
                                        <tr>
                                            <th class="text-center" colspan="2">Min</th>
                                            <?php foreach ($kri_array as $key => $val) : ?>
                                                <td class="text-center"><?= round($val['min_kriteria']) ?></td>
                                            <?php endforeach ?>
                                        </tr>
                                        <tr>
                                            <th class="text-center" colspan="2">Max</th>
                                            <?php foreach ($kri_array as $key => $val) : ?>
                                                <td class="text-center"><?= round($val['max_kriteria']) ?></td>
                                            <?php endforeach ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <b>Nilai Utility</b>
                        </div>
                        <div class="card-body">
                            <!-- Tabel nilai utility -->
                            <div class="table-responsive">
                                <table class="table-bordered table-hover table-sm">
                                    <thead class="thead-light">
                                        <tr>
                                            <th rowspan="2" class="text-center">Kode</th>
                                            <th rowspan="2" class="text-center">Nama Alternatif</th>
                                            <?php foreach ($kri_array as $key => $val) : ?>
                                                <th class="text-center"><?= $val['nama_kriteria'] ?></th>
                                            <?php endforeach ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($data) {
                                            foreach ($data as $key => $val) : ?>
                                                <tr>
                                                    <td class="text-center"><?= $alt_array[$key]['kode_alt'] ?></td>
                                                    <td><?= $alt_array[$key]['nama_alt'] ?></td>
                                                    <?php foreach ($val as $k => $v) :
                                                        $nilai_sub = isset($sub_array[$v]['nilai_sub']) ? $sub_array[$v]['nilai_sub'] : 0;
                                                        $min_kriteria = $kri_array[$k]['min_kriteria'];
                                                        $max_kriteria = $kri_array[$k]['max_kriteria'];
                                                        // Hitung nilai berdasarkan rumus
                                                        if ($nilai_sub !== null && $nilai_sub !== 0) {
                                                            $nilai_utility = (($nilai_sub - $min_kriteria) / ($max_kriteria - $min_kriteria)) * 100;
                                                        } else {
                                                            $nilai_utility = null;
                                                        }
                                                        $id_alt = $alt_array[$key]['id_alt'];
                                                        $id_kri = $kri_array[$k]['id_kriteria'];

                                                        mysqli_query($db, "UPDATE perhitungan SET nilai_utility = '$nilai_utility' WHERE id_alternatif = '$id_alt' AND id_kriteria = '$id_kri'");
                                                    ?>
                                                        <td class="text-center">
                                                            <?php echo $nilai_utility !== null ? round($nilai_utility, 5) : ''; ?>
                                                        </td>
                                                    <?php endforeach ?>
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

                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <b>Normalisasi Bobot</b>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="table-responsive">
                                        <table class="table-bordered table-hover table-sm" width="100%">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col" class="text-center">No</th>
                                                    <th scope="col" class="text-center">Kode Kriteria</th>
                                                    <th scope="col" class="text-center">Nama Kriteria</th>
                                                    <th scope="col" class="text-center">Bobot</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                $total_bobot = 0;
                                                $query = mysqli_query($db, "SELECT * FROM kriteria ORDER BY id_kriteria ASC");
                                                if (mysqli_num_rows($query) > 0) {
                                                    while ($r = mysqli_fetch_assoc($query)) {
                                                        $total_bobot += $r['bobot_kriteria'];
                                                ?>
                                                        <tr>
                                                            <td class="text-center no_urut"><?php echo $no++; ?></td>
                                                            <td hidden class="idkri"><?php echo $r['id_kriteria']; ?></td>
                                                            <td><?php echo $r['kode_kriteria']; ?></td>
                                                            <td><?php echo $r['nama_kriteria']; ?></td>
                                                            <td><?php echo $r['bobot_kriteria']; ?></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td colspan="3" class="text-center"><b>Total Bobot</b></td>
                                                        <!-- total bobot kriteria -->
                                                        <td><b><?php echo $total_bobot; ?></b></td>
                                                    </tr>
                                                <?php
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
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="table-responsive">
                                        <table class="table-bordered table-hover table-sm" width="100%">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col" class="text-center">No</th>
                                                    <th scope="col" class="text-center">Kode Kriteria</th>
                                                    <th scope="col" class="text-center">Bobot</th>
                                                    <th scope="col" class="text-center">Normalisasi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                $query = mysqli_query($db, "SELECT * FROM kriteria ORDER BY id_kriteria ASC");
                                                if (mysqli_num_rows($query) > 0) {
                                                    while ($r = mysqli_fetch_assoc($query)) {
                                                        $normalisasi = $r['bobot_kriteria'] / $total_bobot;
                                                        // Update normalisasi pada tabel
                                                        $kode_kriteria = $r['kode_kriteria'];
                                                        mysqli_query($db, "UPDATE kriteria SET normalisasi = '$normalisasi' WHERE kode_kriteria = '$kode_kriteria'");
                                                ?>
                                                        <tr>
                                                            <td class="text-center no_urut"><?php echo $no++; ?></td>
                                                            <td hidden class="idkri"><?php echo $r['id_kriteria']; ?></td>
                                                            <td><?php echo $r['kode_kriteria']; ?></td>
                                                            <td><?php echo $r['bobot_kriteria']; ?></td>
                                                            <td><?php echo $normalisasi; ?></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                <?php
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <b>Nilai Akhir</b>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-sm">
                                    <thead class="thead-light">
                                        <tr>
                                            <th rowspan="2" scope="col" class="text-center" width="10%">Kode Alternatif</th>
                                            <th rowspan="2" scope="col" class="text-center" width="10%">Nama Alternatif</th>
                                            <th colspan="<?= count($kri_array) ?>" scope="col" class="text-center">Kriteria</th>
                                            <th rowspan="2" scope="col" class="text-center" width="10%">Jumlah</th>
                                        </tr>
                                        <tr>
                                            <?php foreach ($kri_array as $key => $val) : ?>
                                                <th class="text-center"><?= $val['kode_kriteria'] ?></th>
                                            <?php endforeach ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($data) {
                                            foreach ($data as $key => $val) :
                                                // Inisialisasi total hasil per baris alternatif
                                                $total_hasil = 0;
                                        ?>
                                                <tr>
                                                    <td class="text-center"><?= $alt_array[$key]['kode_alt'] ?></td>
                                                    <td class="text-center"><?= $alt_array[$key]['nama_alt'] ?></td>
                                                    <?php foreach ($val as $k => $v) :
                                                        $nilai_sub = isset($sub_array[$v]['nilai_sub']) ? $sub_array[$v]['nilai_sub'] : 0;
                                                        $min_kriteria = $kri_array[$k]['min_kriteria'];
                                                        $max_kriteria = $kri_array[$k]['max_kriteria'];
                                                        $normalisasi = $kri_array[$k]['norm'];
                                                        // Hitung nilai berdasarkan rumus
                                                        if ($nilai_sub !== null && $nilai_sub !== 0) {
                                                            $nilai_utility = (($nilai_sub - $min_kriteria) / ($max_kriteria - $min_kriteria)) * 100;
                                                        } else {
                                                            $nilai_utility = null;
                                                        }
                                                        $hasil = $nilai_utility * $normalisasi;
                                                        // Tambahkan nilai hasil pada total hasil per baris alternatif
                                                        $total_hasil += $hasil;

                                                        $id_alt = $alt_array[$key]['id_alt'];

                                                        if ($total_hasil >= 84 && $total_hasil <= 100) {
                                                            $kelayakan = "Layak";
                                                        } elseif ($total_hasil >= 67 && $total_hasil <= 83) {
                                                            $kelayakan = "Layak";
                                                        } elseif ($total_hasil >= 50 && $total_hasil <= 66) {
                                                            $kelayakan = "Tidak Layak";
                                                        } elseif ($total_hasil >= 33 && $total_hasil <= 49) {
                                                            $kelayakan = "Tidak Layak";
                                                        } else {
                                                            $kelayakan = "Tidak Layak";
                                                        }
                                                        mysqli_query($db, "UPDATE alternatif SET nilai_alternatif = '$total_hasil', keterangan = '$kelayakan'
                                                        WHERE id_alternatif = '$id_alt'");
                                                    ?>
                                                        <td class="text-center">
                                                            <?php echo $hasil !== null ? round($hasil, 5) : ''; ?>
                                                        </td>
                                                    <?php endforeach ?>
                                                    <!-- Placeholder for new criteria columns -->
                                                    <?php for ($i = count($val); $i < count($kri_array); $i++) : ?>
                                                        <td></td>
                                                    <?php endfor; ?>
                                                    <td class="text-center"><?= round($total_hasil, 5) ?></td>
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