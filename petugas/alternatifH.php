<?php
session_start();
include 'koneksi.php';

// Jika user belum login, redirect ke halaman login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../index.php');
    exit;
}

if (isset($_POST['click_altdelete_btn'])) {
    $id = $_POST['altdi'];

    // Hapus data dari tabel bobotkriteria
    $query = "DELETE FROM penilaian
            WHERE id_alternatif = '$id'";
    $result = mysqli_query($db, $query);

    $query = "DELETE FROM perhitungan
            WHERE id_alternatif = '$id'";
    $result = mysqli_query($db, $query);

    $query = "DELETE FROM alternatif
    WHERE id_alternatif='$id'";
    $result = mysqli_query($db, $query);

    if ($result) {
        echo 'Data berhasil dihapuskan';
        $_SESSION['berhasil'] = "Data berhasil dihapuskan";
        exit();
    } else {
        echo 'Data gagal dihapuskan';
        $_SESSION['gagal'] = "Data gagal dihapuskan";
        exit();
    }
}
?>