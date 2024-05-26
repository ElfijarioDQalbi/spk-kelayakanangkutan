<?php
session_start();
include 'koneksi.php';

//edit form
if (isset($_POST['click_edit_btn'])) {
    $id = $_POST['idkri'];
    $arrayresult = [];

    $query = mysqli_query($db, "SELECT * FROM kriteria WHERE id_kriteria='$id'");
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
    $id = $_POST['idkriteria'];
    $kodekriteria = strtoupper($_POST['kodekriteria']);
    $namakriteria = ucwords($_POST['namakriteria']);
    $bobotkriteria = $_POST['bobotkriteria'];

    $query = "UPDATE kriteria 
        SET kode_kriteria = '$kodekriteria',
        nama_kriteria = '$namakriteria',
        bobot_kriteria = '$bobotkriteria'
        WHERE id_kriteria='$id'";
        $result = mysqli_query($db, $query);

        if ($result) {
            $_SESSION['berhasil'] = "Data berhasil diperbarui";
            header('Location: kriteria.php');
            exit();
        } else {
            $_SESSION['gagal'] = "gagal diperbarui";
            header('Location: kriteria.php');
            exit();
        }
}
?>