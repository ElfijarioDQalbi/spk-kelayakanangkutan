<?php
session_start();
include 'koneksi.php';

// // Jika user belum login, redirect ke halaman login
// if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
//     header('Location:../index.php');
//     exit();
// }
// if(!isset($_SESSION['username'])){
//     header('location:../index.php');
// }
// elseif($_SESSION['level'] != "petugas"){
//     header('location:../index.php');
// }
// if (isset($_SESSION['level'])=="petugas" && !isset($_SESSION['username'])) {
//     header('location: ../');
//     exit;
// }
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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
                            <h1 class="m-0"><b>Alternatif</b> Kelayakan Angkutan</h1>
                            <a>Mengelola alternatif angkutan yang akan diperiksa kelayakannya</a>
                        </div><!-- /.col -->
                        <!-- <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php.php">Beranda</a></li>
                                <li class="breadcrumb-item active">Alternatif</li>
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
                        <div class="card-header bg-gradient-blue">
                            <b>List Alternatif Angkutan</b>
                        </div>
                        <div class="card-body">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#alttambahModal">
                                <i class="fas fa-plus-circle nav-icon "></i> Tambah
                            </button>

                            <!-- Table kriteria -->
                            <p></p>
                            <table class="table-bordered table-sm" width="100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="text-center" style="width: 50px;">No</th>
                                        <th scope="col" class="text-center">Kode Alternatif</th>
                                        <th scope="col" class="text-center">Nama Alternatif</th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $query = mysqli_query($db, "SELECT * FROM alternatif ORDER BY id_alternatif ASC");
                                    if (mysqli_num_rows($query) > 0) {
                                        while ($r = mysqli_fetch_assoc($query)) {
                                    ?>
                                            <tr>
                                                <td class="text-center no_urut"><?php echo $no++; ?></td>
                                                <td hidden class="altdi"><?php echo $r['id_alternatif']; ?></td>
                                                <td><?php echo $r['kode_alternatif']; ?></td>
                                                <td><?php echo $r['nama_alternatif']; ?></td>
                                                <td class="text-center">
                                                    <a href="#" class="btn btn-info btn-sm viewbtnalt"><i class="fas fa-info-circle nav-icon "></i> Detail</a>
                                                    <a href="#" class="btn btn-warning btn-sm editbtnalt"><i class="fas fa-edit nav-icon "></i> Edit</a>
                                                    <a href="#" class="btn btn-danger btn-sm deletebtnalt"><i class="fas fa-trash-alt nav-icon "></i> Hapus</a>
                                                    <!-- <a href="#" class="btn btn-danger btn-sm confirmdeletebtn"><i class="fas fa-trash-alt nav-icon "></i> Confirm Hapus</a> -->
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="4" class="text-center"><i>Not Record Found</i></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
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

    <!-- Modal Tambah Alternatif -->
    <div class="modal fade" id="alttambahModal" tabindex="-1" role="dialog" aria-labelledby="alttambahModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alttambahModalLabel"><b>Tambah Alternatif</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="alternatifT.php">
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="kodealternatif" class="mb-1">Kode Alternatif</label>
                                        <input type="text" id="kodealternatif" class="form-control" name="kodealternatif" placeholder="Masukkan kode alternatif disini…" autocomplete="off" maxlength="3" required>
                                        <div class="invalid-feedback">
                                            Please input criteria code !
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="namaalternatif" class="mb-1">Nama Alternatif</label>
                                        <input type="text" id="namaalternatif" class="form-control" name="namaalternatif" placeholder="Masukkan nama alternatif disini…" autocomplete="off" maxlength="50" required>
                                        <div class="invalid-feedback">
                                            Please input criteria name !
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary me-1 mb-1">Reset</button>
                        <button type="submit" class="btn btn-primary me-1 mb-1" name="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.modal tambah alternatif -->

    <!-- Modal Edit Alternatif -->
    <div class="modal fade" id="alteditModal" tabindex="-1" role="dialog" aria-labelledby="alteditModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alteditModalLabel"><b>Edit Alternatif</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="alternatifE.php">
                    <div class="modal-body">
                        <div class="form-body">
                            <input type="hidden" class="form-control" id="idalt" name="idalternatif" placeholder="Masukkan id alternatif disini…">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="kodealternatif" class="mb-1">Kode Alternatif</label>
                                        <input type="text" class="form-control" id="kodealt" name="kodealternatif" placeholder="Masukkan kode alternatif disini…" autocomplete="off" maxlength="3" required>
                                        <div class="invalid-feedback">
                                            Please input criteria code !
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="namaalternatif" class="mb-1">Nama Alternatif</label>
                                        <input type="text" class="form-control" id="namaalt" name="namaalternatif" placeholder="Masukkan nama alternatif disini…" autocomplete="off" maxlength="50" required>
                                        <div class="invalid-feedback">
                                            Please input criteria name !
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="namapemilik" class="mb-1">Nama Pemilik</label>
                                        <input type="text" class="form-control" id="namapmlk" name="namapemilik" placeholder="Masukkan nama pemilik disini…" autocomplete="off" maxlength="50" required>
                                        <div class="invalid-feedback">
                                            Please input owner name !
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="alamatpemilik" class="mb-1">Alamat Pemilik</label>
                                        <input type="text" class="form-control" id="alamatpmlk" name="alamatpemilik" placeholder="Masukkan alamat pemilik disini…" autocomplete="off" maxlength="50" required>
                                        <div class="invalid-feedback">
                                            Please input owner address !
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="merktipe" class="mb-1">Merk / Tipe</label>
                                        <input type="text" class="form-control" id="merktipe" name="merktipe" placeholder="Masukkan merk/tipe angkutan disini…" autocomplete="off" maxlength="50" required>
                                        <div class="invalid-feedback">
                                            Please input brand/type !
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="tanggalpemeriksaan" class="mb-1">Tanggal Pemeriksaan</label>
                                        <input type="date" class="form-control" id="tglperiksa" name="tanggalpemeriksaan" placeholder="Masukkan alamat pemilik disini…" autocomplete="off" maxlength="50" required>
                                        <div class="invalid-feedback">
                                            Please input inspection date !
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary me-1 mb-1">Reset</button>
                        <button type="submit" class="btn btn-primary me-1 mb-1" name="save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.modal edit alternatif -->

    <!-- Modal Detail Kriteria -->
    <div class="modal fade" id="altdetailModal" tabindex="-1" role="dialog" aria-labelledby="altdetailModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="altdetailModalLabel"><b>Detail Alternatif</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="view_altuser_data">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal detail kriteria -->
    
    <script>
        /* JQuary edit kriteria */
        $(document).ready(function() {
            $('.editbtnalt').click(function(e) {
                e.preventDefault();

                var altdi = $(this).closest('tr').find('.altdi').text();
                // console.log(no_urut); 

                $.ajax({
                    method: "POST",
                    url: "alternatifE.php",
                    data: {
                        'click_altedit_btn': true,
                        'altdi': altdi,
                    },
                    success: function(response) {
                        //   console.log(response);  

                        $.each(response, function(Key, value) {
                            // console.log(value['kode_kriteria']);
                            $('#idalt').val(value['id_alternatif']);
                            $('#kodealt').val(value['kode_alternatif']);
                            $('#namaalt').val(value['nama_alternatif']);
                        });
                        $('#alteditModal').modal('show');
                    }
                });
            });
        });

        // /* JQuary delete kriteria */
        $(document).ready(function() {
            $('.deletebtnalt').click(function(e) {
                e.preventDefault();
                // console.log('hellow');

                var altdi = $(this).closest('tr').find('.altdi').text();
                // console.log(no_urut);

                $.ajax({
                    method: "POST",
                    url: "alternatifH.php",
                    data: {
                        'click_altdelete_btn': true,
                        'altdi': altdi,
                    },
                    success: function(response) {
                        window.location.reload();
                        // $('#alert').html(
                        //     `
                        //         <div class="alert alert-success alert-dismissible fade show">
                        //             <i class="	fas fa-check-circle nav-icon"></i>
                        //             <strong>` + response + `</strong>
                        //             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        //                 <span aria-hidden="true">&times;</span>
                        //             </button>
                        //         </div>
                        //     `
                        // )
                    }
                });

            });
        });

        /* JQuary detail kriteria */
        $(document).ready(function() {
            $('.viewbtnalt').click(function(e) {
                e.preventDefault();


                var altdi = $(this).closest('tr').find('.altdi').text();


                $.ajax({
                    method: "POST",
                    url: "alternatifD.php",
                    data: {
                        'click_altview_btn': true,
                        'altdi': altdi,
                    },
                    success: function(response) {
                        // console.log(response);  
                        $('.view_altuser_data').html(response);
                        $('#altdetailModal').modal('show');
                    }
                });
            });
        });
    </script>

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