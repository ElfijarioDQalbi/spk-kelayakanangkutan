<?php
session_start();
include 'koneksi.php';

// // Jika pengguna sudah login, arahkan mereka ke halaman beranda
// if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
//     if ($_SESSION['level'] == 'admin') {
//         header('Location: admin/beranda.php');
//     } elseif ($_SESSION['level'] == 'petugas') {
//         header('Location: petugas/beranda.php');
//     } else {
//         // Jika level tidak sesuai, arahkan ke halaman beranda default
//         header('Location: beranda.php');
//     }
//     exit();
// }

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Lakukan sanitasi input dan hindari SQL injection
    $username = mysqli_real_escape_string($db, $username);
    $password = mysqli_real_escape_string($db, $password);

    // Lakukan query ke database
    $query = "SELECT * FROM user WHERE username ='$username' AND password ='$password'";
    $result = mysqli_query($db, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        session_regenerate_id(true); // Tambahkan ini untuk keamanan

        $_SESSION['logged_in'] = true; // Set session untuk menandai bahwa pengguna telah masuk
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['nama_petugas'] = $user['nama_petugas'];
        $_SESSION['username'] = $username; // Simpan username dalam session jika perlu
        $_SESSION['password'] = $password;
        $_SESSION['level'] = $user['level']; // Simpan level pengguna dalam session
        
        if ($user['level'] == 'admin') {
            header('Location: admin/beranda.php');
        } elseif ($user['level'] == 'petugas') {
            header('Location: petugas/beranda.php');
        } else {
            // Jika level tidak sesuai, arahkan ke halaman beranda default
            header('Location: index.php');
        }
        exit();
    } else {
        // Jika login gagal, arahkan kembali ke halaman login
        $_SESSION['gagal'] = "Gagal Log In. Periksa kembali username / password anda !";
        header('Location: index.php');
        exit();
    }
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
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a class="h4">Sistem Pendukung Keputusan Penentuan Kelayakan Angkutan</a>
            </div>
            <div class="card-body">
                <div id="alert">
                    <?php
                    if (isset($_SESSION['gagal'])) :
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

                <p class="login-box-msg"><b>Log in Account</b></p>

                <form method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Username" name="username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <a id="togglePassword"><i class="fas fa-eye-slash"></i></a>
                            </div>
                            <span class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Kolom pertama untuk input -->
                        <div class="col">
                            &nbsp; <!-- Digunakan untuk memberikan spasi jika diperlukan -->
                        </div>
                        <!-- Kolom kedua untuk tombol "Sign In" -->
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary btn-block" name="login">Sign In</button>
                        </div>
                    </div>
                </form>

                <p class="mb-0">
                    Belum punya akun ? <a class="text-center">Hubungi admin !</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
</body>

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
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

</html>