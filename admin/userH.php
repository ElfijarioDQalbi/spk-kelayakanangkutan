<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../index.php');
    exit();
}

if (isset($_POST['click_deleteuser_btn'])) {
    $id = $_POST['iduser'];

    $query = "DELETE FROM user
    WHERE id_user='$id'";
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