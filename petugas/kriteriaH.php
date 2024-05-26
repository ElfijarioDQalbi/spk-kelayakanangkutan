<?php
session_start();
include 'koneksi.php';

// Jika user belum login, redirect ke halaman login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../index.php');
    exit;
}

if (isset($_POST['click_delete_btn'])) {
    $idk = $_POST['idkri'];

    // Hapus data dari tabel subkriteria
    $query = "DELETE FROM subkriteria WHERE id_kriteria='$idk'";
    $result = mysqli_query($db, $query);
    
    // Hapus data dari tabel kriteria
    $query = "DELETE FROM kriteria WHERE id_kriteria='$idk'";
    $result = mysqli_query($db, $query);

    if ($result) {
        $_SESSION['berhasil'] = "Data berhasil dihapuskan";
        exit();
    } else {
        $_SESSION['gagal'] = "Data gagal dihapuskan " . mysqli_error($db);
        exit();
    }
}