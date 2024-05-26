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
                        <div class="col-sm-8">
                            <h1 class="m-0"><b>Subkriteria</b> Kelayakan Angkutan</h1>
                            <a>Mengelola subkriteria tiap kriteria yang digunakan untuk menentukan kelayakan angkutan</a>
                        </div><!-- /.col -->
                        <!-- <div class="col-sm-4">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="beranda.php">Beranda</a></li>
                                <li class="breadcrumb-item active">Subkriteria</li>
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
                            <b>List SubKriteria</b>
                        </div>
                        <div class="card-body">

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#subtambahModal">
                                <i class="fas fa-plus-circle nav-icon "></i> Tambah
                            </button>

                            <!-- Table kriteria -->
                            <p></p>
                            <table class="table-bordered table-sm"  width="100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="text-center" width="5%">No</th>
                                        <th scope="col" class="text-center" width="20%">Nama Kriteria</th>
                                        <th scope="col" class="text-center" width="5%">Kode Subkriteria</th>
                                        <th scope="col" class="text-center" width="25%">Nama Subkriteria</th>
                                        <th scope="col" class="text-center" width="5%">Nilai Subkriteria</th>
                                        <th scope="col" class="text-center" width="25%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $query = mysqli_query($db, "SELECT *
                                                                FROM kriteria
                                                                INNER JOIN subkriteria 
                                                                ON kriteria.id_kriteria = subkriteria.id_kriteria
                                                                ORDER BY kriteria.id_kriteria ASC, subkriteria.id_subkriteria ASC");
                                    if (mysqli_num_rows($query) > 0) {
                                        while ($r = mysqli_fetch_assoc($query)) {
                                    ?>
                                            <tr>
                                                <td class="text-center no_urut"><?php echo $no++; ?></td>
                                                <td hidden class="subkri"><?php echo $r['id_subkriteria'];  ?></td>
                                                <td hidden class="kri"><?php echo $r['id_kriteria'];  ?></td>
                                                <td><?php echo $r['nama_kriteria'] ?></td>
                                                <td><?php echo $r['kode_subkriteria']; ?></td>
                                                <td><?php echo $r['nama_subkriteria'];?></td>
                                                <td><?php echo $r['nilai_subkriteria'];?></td>
                                                <td class="text-center">
                                                    <a href="#" class="btn btn-info btn-sm viewbtnsub"><i class="fas fa-info-circle nav-icon "></i> Detail</a>
                                                    <a href="#" class="btn btn-warning btn-sm editbtnsub"><i class="fas fa-edit nav-icon "></i> Edit</a>
                                                    <a href="#" class="btn btn-danger btn-sm deletebtnsub"><i class="fas fa-trash-alt nav-icon "></i> Hapus</a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="6" class="text-center"><i>Not Record Found</i></td>
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

    <!-- Modal Tambah Subkriteria -->
    <div class="modal fade" id="subtambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel"><b>Tambah Subkriteria</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="subkriteriaT.php" class="formtambahsubkriteria" novalidate>
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="id_kriteria">Kriteria</label>
                                        <select class="form-control" name="idkriteria">
                                            <option value="">== Pilih Kriteria ==</option>
                                            <?php 
                                                $sql=mysqli_query($db,"SELECT * FROM kriteria ORDER BY id_kriteria ASC");
                                                while ($data=mysqli_fetch_array($sql)) {
                                            ?>
                                                <option value="<?=$data['id_kriteria']?>"><?=$data['kode_kriteria']?> - <?=$data['nama_kriteria']?></option> 
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="kodekriteria" class="mb-1">Kode Subkriteria</label>
                                        <input type="text" id="kodesubkriteria" class="form-control" name="kodesubkriteria" placeholder="Masukkan kode sub kriteria disini…" autocomplete="off" maxlength="3" required>
                                        <div class="invalid-feedback">
                                            Please input subcriteria code !
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="namakriteria" class="mb-1">Nama Subkriteria</label>
                                        <input type="text" id="namasubkriteria" class="form-control" name="namasubkriteria" placeholder="Masukkan nama sub kriteria disini…" autocomplete="off" maxlength="100" required>
                                        <div class="invalid-feedback">
                                            Please input subcriteria name !
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="bobotsubkriteria" class="mb-1">Bobot Subkriteria</label>
                                        <input type="number" id="bobotsubkriteria" class="form-control" name="bobotsubkriteria" placeholder="Masukkan bobot sub kriteria disini…" autocomplete="off" maxlength="50" required>
                                        <div class="invalid-feedback">
                                            Please input subcriteria name !
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

                <!-- <form method="POST" action="kriteriaT.php" class="formtambahkriteria" novalidate>
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="kodekriteria" class="mb-1">Kode Kriteria</label>
                                        <input type="text" id="kodekriteria" class="form-control" name="kodekriteria" placeholder="Masukkan kode kriteria disini…" autocomplete="off" maxlength="3" required>
                                        <div class="invalid-feedback">
                                            Please input criteria code !
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="namakriteria" class="mb-1">Nama Kriteria</label>
                                        <input type="text" id="namakriteria" class="form-control" name="namakriteria" placeholder="Masukkan nama kriteria disini…" autocomplete="off" maxlength="50" required>
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
                </form> -->
            </div>
        </div>
    </div>
    <!-- /.modal tambah subkriteria -->

    <!-- Modal Edit Subkriteria -->
    <div class="modal fade" id="subeditModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel"><b>Edit Subkriteria</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="subkriteriaE.php" class="formeditsubkriteria" novalidate>
                    <div class="modal-body">
                        <div class="form-body">
                            <input type="hidden" class="form-control" id="idsub" name="idsubkriteria">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="id_kriteria">Kriteria</label>
                                        <select class="form-control" id="idk" name="idkriteria">
                                            <option disabled>== Pilih Kriteria ==</option>
                                            <?php 
                                                $sql=mysqli_query($db,"SELECT * FROM kriteria");
                                                while ($data=mysqli_fetch_array($sql)) {
                                            ?>
                                                <option value="<?=$data['id_kriteria']?>"><?=$data['nama_kriteria']?></option> 
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="kodekriteria" class="mb-1">Kode Subkriteria</label>
                                        <input type="text" id="kodesub" class="form-control" name="kodesubkriteria" placeholder="Masukkan kode sub kriteria disini…" autocomplete="off" maxlength="3" required>
                                        <div class="invalid-feedback">
                                            Please input subcriteria code !
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="namakriteria" class="mb-1">Nama Subkriteria</label>
                                        <input type="text" id="namasub" class="form-control" name="namasubkriteria" placeholder="Masukkan nama sub kriteria disini…" autocomplete="off" maxlength="100" required>
                                        <div class="invalid-feedback">
                                            Please input subcriteria name !
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="bobotsubkriteria" class="mb-1">Bobot Subkriteria</label>
                                        <input type="number" id="bobotsub" class="form-control" name="bobotsubkriteria" placeholder="Masukkan bobot sub kriteria disini…" autocomplete="off" maxlength="50" required>
                                        <div class="invalid-feedback">
                                            Please input subcriteria name !
                                        </div>
                                    </div>
                                </div>
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
    <!-- /.modal edit subkriteria -->

    <!-- Modal Detail Subkriteria -->
    <div class="modal fade" id="subdetailModal" tabindex="-1" role="dialog" aria-labelledby="subdetailModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="subdetailModalLabel"><b>Detail Subkriteria</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="view_subuser_data">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal detail subkriteria -->

    <script>
        // /* JQuary delete subkriteria */
        $(document).ready(function() {
            $('.deletebtnsub').click(function(e) {
                e.preventDefault();
                // console.log('hellow');

                var subkri = $(this).closest('tr').find('.subkri').text();
                // console.log(subkri);

                $.ajax({
                    method: "POST",
                    url: "subkriteriaH.php",
                    data: {
                        'click_deletesub_btn': true,
                        'subkri': subkri,
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

        /* JQuary edit subkriteria */
        $(document).ready(function() {
            $('.editbtnsub').click(function(e) {
                e.preventDefault();

                var subkri = $(this).closest('tr').find('.subkri').text();
                // console.log(no_urut); 

                $.ajax({
                    method: "POST",
                    url: "subkriteriaE.php",
                    data: {
                        'click_editsub_btn': true,
                        'subkri': subkri,
                    },
                    success: function(response) {
                        //   console.log(response);  

                        $.each(response, function(Key, value) {
                            // console.log(value['kode_kriteria']);
                            $('#idsub').val(value['id_subkriteria']);
                            $('#idk').val(value['id_kriteria']);
                            $('#kodesub').val(value['kode_subkriteria']);
                            $('#namasub').val(value['nama_subkriteria']);
                            $('#bobotsub').val(value['nilai_subkriteria']);
                        });
                        $('#subeditModal').modal('show');
                    }
                });
            });
        });

        /* JQuary detail subkriteria */
        $(document).ready(function() {
            $('.viewbtnsub').click(function(e) {
                e.preventDefault();


                var subkri = $(this).closest('tr').find('.subkri').text();


                $.ajax({
                    method: "POST",
                    url: "subkriteriaD.php",
                    data: {
                        'click_subview_btn': true,
                        'subkri': subkri,
                    },
                    success: function(response) {
                        // console.log(response);  
                        $('.view_subuser_data').html(response);
                        $('#subdetailModal').modal('show');
                    }
                });
            });
        });

        /* JQuary validation form tambah */
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('formtambahsubkriteria');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        /* JQuary validation form edit */
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('formeditsubkriteria');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
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