<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../index.php');
    exit();
}

if (isset($_POST['submit'])) {
    $nama = $_POST['namapetugas'];
    $username = $_POST['username'];
    $level = $_POST['level'];
    $password = $_POST['password'];
    
    $query = "INSERT INTO user (nama_petugas, level, username, password) 
                VALUES ('$nama', '$level', '$username', '$password')";
    $result = mysqli_query($db, $query);

    if ($result) {
        $_SESSION['berhasil'] = "Data akun berhasil ditambahkan";
    } else {
        $_SESSION['gagal'] = "Data akun gagal ditambahkan";
    }
    header('Location: user.php');
}
?>