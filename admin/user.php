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
                            <h1 class="m-0">Pengelolaan <strong>User</strong></h1>
                            <a>Melakukan kelola akun user dari sistem pendukung keputusan penentuan kelayakan angkutan</a>
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

                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <b>Kelola user</b>
                        </div>
                        <div class="card-body">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#tambahuserModal">
                                <i class="fas fa-plus-circle nav-icon "></i> Register
                            </button>
                            <div class="clearfix"></div>
                            <p></p>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-sm">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">Nama Petugas</th>
                                            <th scope="col" class="text-center">Level</th>
                                            <th scope="col" class="text-center">Username</th>
                                            <th scope="col" class="text-center">Password</th>
                                            <th scope="col" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $query = mysqli_query($db, "SELECT * FROM user ORDER BY id_user ASC");
                                        if (mysqli_num_rows($query) > 0) {
                                            while ($r = mysqli_fetch_assoc($query)) {
                                        ?>
                                                <tr>
                                                    <td class="text-center no_urut"><?php echo $no++; ?></td>
                                                    <td hidden class="iduser"><?php echo $r['id_user']; ?></td>
                                                    <td><?php echo $r['nama_petugas']; ?></td>
                                                    <td><?php echo $r['level']; ?></td>
                                                    <td><?php echo $r['username']; ?></td>
                                                    <td><?php echo $r['password']; ?></td>
                                                    <td class="text-center">
                                                        <a href="#" class="btn btn-danger btn-sm deletebtnuser"><i class="fas fa-trash-alt nav-icon "></i></a>
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

    <!-- ./wrapper -->

    <!-- Modal Tambah User -->
    <div class="modal fade" id="tambahuserModal" tabindex="-1" role="dialog" aria-labelledby="tambahuserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahuserModalLabel"><b>Register Akun Petugas</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="userT.php" class="formtambahuser" novalidate>
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="namapetugas" class="mb-1">Nama Petugas</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="namapetugas" class="form-control" name="namapetugas" placeholder="Masukkan nama petugas disini…" autocomplete="off" maxlength="100" required>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-user"></span>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">
                                                Please input officer name !
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="username" class="mb-1">Username</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="username" class="form-control" name="username" placeholder="Masukkan username default disini…" autocomplete="off" maxlength="100" required>
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
                                            <input type="password" id="password" class="form-control" name="password" placeholder="Masukkan password default disini…" autocomplete="off" maxlength="100" required>
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
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="level" class="mb-1">Level</label>
                                        <div class="input-group mb-3">
                                            <select class="form-control" id="level" name="level" required>
                                                <option value="" disabled selected>--Pilih--</option>
                                                <option value="admin">Admin</option>
                                                <option value="petugas">Petugas</option>
                                            </select>
                                            <!-- <input type="level" id="level" class="form-control" name="level" placeholder="Masukkan level duser disini…" autocomplete="off" maxlength="100" required> -->
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <span class="fas fa-users"></span>
                                                </span>
                                            </div>
                                            <div class="invalid-feedback">
                                                Please input level user !
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary me-1 mb-1">Reset</button>
                        <button type="submit" class="btn btn-primary me-1 mb-1" name="submit">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.modal tambah user -->

    <script>
        // /* JQuary delete user */
        $(document).ready(function() {
            $('.deletebtnuser').click(function(e) {
                e.preventDefault();
                // console.log('hellow');

                var iduser = $(this).closest('tr').find('.iduser').text();
                // console.log(no_urut);

                $.ajax({
                    method: "POST",
                    url: "userH.php",
                    data: {
                        'click_deleteuser_btn': true,
                        'iduser': iduser,
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

        /* JQuary validation form tambah */
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('formtambahuser');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        var level = form.querySelector('#level');
                        if (level.value === "") {
                            // If level is not selected
                            event.preventDefault();
                            event.stopPropagation();
                            level.classList.add('is-invalid');
                        } else {
                            level.classList.remove('is-invalid');
                        }
                        form.classList.add('was-validated');

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