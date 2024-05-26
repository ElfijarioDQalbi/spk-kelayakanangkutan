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
                            <h1 class="m-0"><b>Kriteria</b> Kelayakan Angkutan</h1>
                            <a>Mengelola kriteria yang digunakan untuk menentukan kelayakan angkutan</a>
                        </div><!-- /.col -->
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
                            unset($_SESSION['pesan']);
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
                            unset($_SESSION['berhasil']);
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
                        unset($_SESSION['gagal']);
                        endif;
                        ?>
                    </div>

                    <div></div>
                    <div class="callout callout-info">
                        <h5><b>Perhatian!</b></h5>
                        <p>Nilai dari Total bobot kriteria harus <b>bernilai 100.</b> </p>
                    </div>

                    <div class="card">
                        <div class="card-header bg-gradient-blue">
                            <b>List Kriteria</b>
                        </div>
                        <div class="card-body">

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambahModal">
                                <i class="fas fa-plus-circle nav-icon "></i> Tambah
                            </button>

                            <!-- Table kriteria -->
                            <p></p>
                            <table class="table-bordered table-sm" width="100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode Kriteria</th>
                                        <th scope="col" class="text-center">Nama Kriteria</th>
                                        <th scope="col" class="text-center">Bobot</th>
                                        <th scope="col" class="text-center">Action</th>
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
                                                <td class="text-center">
                                                    <a href="#" class="btn btn-info btn-sm viewbtn"><i class="fas fa-info-circle nav-icon "></i> Detail</a>
                                                    <a href="#" class="btn btn-warning btn-sm editbtn"><i class="fas fa-edit nav-icon "></i> Edit</a>
                                                    <a href="#" class="btn btn-danger btn-sm deletebtn"><i class="fas fa-trash-alt nav-icon "></i> Hapus</a>
                                                    <!-- <a href="#" class="btn btn-danger btn-sm confirmdeletebtn"><i class="fas fa-trash-alt nav-icon "></i> Confirm Hapus</a> -->
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="3" class="text-center"><b>Total Bobot</b></td>
                                            <!-- total bobot kriteria -->
                                            <td colspan="2"><b><?php echo $total_bobot; ?></b></td>
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

    <!-- Modal Tambah Kriteria -->
    <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel"><b>Tambah Kriteria</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="kriteriaT.php" class="formtambahkriteria" novalidate>
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
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="bobotkriteria" class="mb-1">Bobot Kriteria</label>
                                        <input type="number" id="bobotkriteria" class="form-control" name="bobotkriteria" placeholder="Masukkan bobot kriteria disini…" autocomplete="off" maxlength="50" required>
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
    <!-- /.modal tambah kriteria -->

    <!-- Modal Detail Kriteria -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel"><b>Detail Kriteria</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="view_user_data">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal detail kriteria -->

    <!-- Modal Edit Kriteria -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel"><b>Edit Kriteria</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="kriteriaE.php" class="formeditkriteria" novalidate>
                    <div class="modal-body">
                        <div class="form-body">
                            <input type="hidden" class="form-control" id="id" name="idkriteria" placeholder="Masukkan kode kriteria disini…">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="kodekriteria" class="mb-1">Kode Kriteria</label>
                                        <input type="text" class="form-control" id="kode" name="kodekriteria" placeholder="Masukkan kode kriteria disini…" autocomplete="off" maxlength="3" required>
                                        <div class="invalid-feedback">
                                            Please input criteria code !
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="namakriteria" class="mb-1">Nama Kriteria</label>
                                        <input type="text" class="form-control" id="nama" name="namakriteria" placeholder="Masukkan nama kriteria disini…" autocomplete="off" maxlength="50" required>
                                        <div class="invalid-feedback">
                                            Please input criteria name !
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="bobotkriteria" class="mb-1">Bobot Kriteria</label>
                                        <input type="number" id="bobot" class="form-control" name="bobotkriteria" placeholder="Masukkan bobot kriteria disini…" autocomplete="off" maxlength="3" required>
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
                        <button type="submit" class="btn btn-primary me-1 mb-1" name="save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.modal edit kriteria -->

    <script>
        /* JQuary detail kriteria */
        $(document).ready(function() {
            $('.viewbtn').click(function(e) {
                e.preventDefault();

                var idkri = $(this).closest('tr').find('.idkri').text();

                $.ajax({
                    method: "POST",
                    url: "kriteriaD.php",
                    data: {
                        'click_view_btn': true,
                        'idkri': idkri,
                    },
                    success: function(response) {
                        // console.log(response);  
                        $('.view_user_data').html(response);
                        $('#detailModal').modal('show');
                    }
                });
            });
        });

        /* JQuary edit kriteria */
        $(document).ready(function() {
            $('.editbtn').click(function(e) {
                e.preventDefault();

                var idkri = $(this).closest('tr').find('.idkri').text();
                // console.log(no_urut); 

                $.ajax({
                    method: "POST",
                    url: "kriteriaE.php",
                    data: {
                        'click_edit_btn': true,
                        'idkri': idkri,
                    },
                    success: function(response) {
                        //   console.log(response);  

                        $.each(response, function(Key, value) {
                            // console.log(value['kode_kriteria']);
                            $('#id').val(value['id_kriteria']);
                            $('#kode').val(value['kode_kriteria']);
                            $('#nama').val(value['nama_kriteria']);
                            $('#bobot').val(value['bobot_kriteria']);
                        });
                        $('#editModal').modal('show');
                    }
                });
            });
        });

        // /* JQuary delete kriteria */
        $(document).ready(function() {
            $('.deletebtn').click(function(e) {
                e.preventDefault();
                // console.log('hellow');

                var idkri = $(this).closest('tr').find('.idkri').text();

                // console.log(no_urut);

                $.ajax({
                    method: "POST",
                    url: "kriteriaH.php",
                    data: {
                        'click_delete_btn': true,
                        'idkri': idkri,
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

        /* JQuary validation form tambah */
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('formtambahkriteria');
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
                var forms = document.getElementsByClassName('formeditkriteria');
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