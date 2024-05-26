<?php
session_start();
include 'koneksi.php';


if (isset($_POST['click_deletesub_btn'])) {
    $idsub = $_POST['subkri'];

    // Hapus data dari tabel kriteria
    $query = "DELETE FROM subkriteria WHERE id_subkriteria= '$idsub'";
    $result = mysqli_query($db, $query);

    if ($result) {
        $_SESSION['berhasil'] = "Data berhasil dihapuskan";
        exit();
    } else {
        $_SESSION['gagal'] = "Data gagal dihapuskan";
        exit();
    }
}