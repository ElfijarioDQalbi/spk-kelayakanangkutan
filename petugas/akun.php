<?php
session_start();
include 'koneksi.php';

// // Jika user belum login, redirect ke halaman login
// if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
//     header('Location:../index.php');
//     exit;
// }
// if (!isset($_SESSION['username'])) {
//     header('location:../index.php');
// } elseif ($_SESSION['level'] != "petugas") {
//     header('location:../index.php');
// }
// if (isset($_SESSION['level'])=="petugas" && !isset($_SESSION['username'])) {
//     header('location: ../index.php');
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
                            <h1 class="m-0"><strong>Akun</strong> Petugas</h1>
                            <a>Melakukan pengelolaan akun yang dimiliki petugas</a>
                        </div><!-- /.col -->
                        <!-- <div class="col-sm-6">
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

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-header bg-gradient-blue">
                                    <b>Account Petugas</b>
                                </div>
                                <div class="card-body">
                                    <p><b>ID Akun Petugas : </b><?php echo $_SESSION['id_user']; ?></p>
                                    <p><b>Nama Petugas : </b><?php echo $_SESSION['nama_petugas']; ?></p>
                                    <p><b>Username : </b><?php echo $_SESSION['username']; ?></p>
                                    <p><b>Password : </b><?php echo $_SESSION['password']; ?></p>
                                    <p><b>Level User : </b><?php echo $_SESSION['level']; ?></p>
                                </div>
                                <div class="card-footer">
                                    <i>Official Account Petugas</i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="card">
                                <div class="card-header bg-lightblue">
                                    <b>Kelola Account</b>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col" class="text-center">No</th>
                                                    <th scope="col" class="text-center">Nama Petugas</th>
                                                    <th scope="col" class="text-center">Username</th>
                                                    <th scope="col" class="text-center">Password</th>
                                                    <th scope="col" class="text-center">Level</th>
                                                    <th scope="col" class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">1</td>
                                                    <td hidden class="idakun"><?php echo $_SESSION['id_user']; ?></td>
                                                    <td><?php echo $_SESSION['nama_petugas']; ?></td>
                                                    <td><?php echo $_SESSION['username']; ?></td>
                                                    <td><?php echo $_SESSION['password']; ?></td>
                                                    <td><?php echo $_SESSION['level']; ?></td>
                                                    <td class="text-center">
                                                        <a href="#" class="btn btn-warning btn-sm editakunbtn"><i class="fas fa-edit nav-icon "></i></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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

    <!-- Modal Edit Akun -->
    <div class="modal fade" id="editakunModal" tabindex="-1" role="dialog" aria-labelledby="editakunModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editakunModalLabel"><b>Edit Akun</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="akunE.php" class="formeditkriteria" novalidate>
                    <div class="modal-body">
                        <div class="form-body">
                            <input type="hidden" class="form-control" id="id" name="iduser">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="username" class="mb-1">Username</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="username" class="form-control" name="usrname" placeholder="Masukkan username default disini…" autocomplete="off" maxlength="100" required>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-envelope"></span>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">
                                                Please input default username !
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="password" class="mb-1">Password</label>
                                        <div class="input-group mb-3">
                                            <input type="password" id="password" class="form-control" name="pass" placeholder="Masukkan password default disini…" autocomplete="off" maxlength="100" required>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <a id="togglePassword"><i class="fas fa-eye-slash"></i></a>
                                                </div>
                                                <span class="input-group-text">
                                                    <span class="fas fa-lock"></span>
                                                </span>
                                            </div>
                                            <div class="invalid-feedback">
                                                Please input default password !
                                            </div>
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
    <!-- /.modal edit akun -->

    <script>
        /* JQuary edit akun */
        $(document).ready(function() {
            $('.editakunbtn').click(function(e) {
                e.preventDefault();

                var idakun = $(this).closest('tr').find('.idakun').text();

                $.ajax({
                    method: "POST",
                    url: "akunE.php",
                    data: {
                        'click_editakun_btn': true,
                        'idakun': idakun,
                    },
                    success: function(response) {
                        //   console.log(response);  

                        $.each(response, function(Key, value) {
                            $('#id').val(value['id_user']);
                            $('#username').val(value['username']);
                            $('#password').val(value['password']);
                        });
                        $('#editakunModal').modal('show');
                    }
                });
            });
        });

        /* JQuary validation form edit */
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('formeditakun');
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

        $(document).ready(function() {
            $('#togglePassword').click(function() {
                var passwordField = $('#password');
                var passwordFieldType = passwordField.attr('type');
                if (passwordFieldType == 'password') {
                    passwordField.attr('type', 'text');
                    $(this).html('<i class="fas fa-eye"></i>');
                } else {
                    passwordField.attr('type', 'password');
                    $(this).html('<i class="fas fa-eye-slash"></i>');
                }
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