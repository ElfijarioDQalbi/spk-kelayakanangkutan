<?php
session_start();
include 'koneksi.php';

//edit form
if (isset($_POST['click_editakun_btn'])) {
    $id = $_POST['idakun'];
    $arrayresult = [];
    
    $query = mysqli_query($db, "SELECT * FROM user WHERE id_user='$id'");
    if (mysqli_num_rows($query) > 0) {
        while ($r = mysqli_fetch_assoc($query)) {
            array_push($arrayresult, $r);
            header('content-type: application/json');
            echo json_encode($arrayresult);
        }
    } else {
        echo '<h4>Not Record Found</h4>';
    }
}

//update data
if (isset($_POST['save'])) {
    $id = $_POST['iduser'];
    $username = $_POST['usrname'];
    $password = $_POST['pass'];

    $query = "UPDATE user
    SET username = '$username', password = '$password'
    WHERE id_user = '$id'";
    $result = mysqli_query($db, $query);

    if ($result) {
        $_SESSION['berhasil'] = "Data akun berhasil digantikan, Silahkan login kembali !";
        header('Location: akun.php');
        exit();
    } else {
        $_SESSION['gagal'] = "Data akun gagal digantikan !";
        header('Location: akun.php');
        exit();
    }
}
    // $cekduplikat    = mysqli_num_rows(mysqli_query($db, "SELECT * FROM kriteria WHERE kode_kriteria ='$kodekriteria' and nama_kriteria='$namakriteria'"));

    // if ($cekduplikat > 0) {
    //     $_SESSION['pesan'] = " Maaf, Data sudah ada sebelumnya";
    //     header('Location: kriteria.php');
    // } else {
    //     $query = "UPDATE kriteria 
    //     SET kode_kriteria = '$kodekriteria',
    //     nama_kriteria = '$namakriteria' 
    //     WHERE id_kriteria='$id'";
    //     $result = mysqli_query($db, $query);

    //     if ($result) {
    //         $_SESSION['berhasil'] = "Data berhasil diperbarui";
    //         header('Location: kriteria.php');
    //     } else {
    //         $_SESSION['gagal'] = "gagal diperbarui";
    //         header('Location: kriteria.php');
    //     }
    // }

