<?php
session_start();
include 'koneksi.php';

//edit form
if (isset($_POST['click_altedit_btn'])) {
    $id = $_POST['altdi'];
    $arrayresult = [];

    $query = mysqli_query($db, "SELECT * FROM alternatif WHERE id_alternatif='$id'");
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
    $id = $_POST['idalternatif'];
    $kodealt = strtoupper($_POST['kodealternatif']);
    $namaalt = strtoupper($_POST['namaalternatif']);

    $cekduplikat    = mysqli_num_rows(mysqli_query($db, "SELECT * FROM alternatif WHERE kode_alternatif='$kodealt' 
                                                                                    and nama_alternatif='$namaalt' "));

    if ($cekduplikat > 0) {
        $_SESSION['pesan'] = " Maaf, Data sudah ada sebelumnya";
        header('Location: alternatif.php');
    } else {
        $query = "UPDATE alternatif 
                SET kode_alternatif = '$kodealt',
                nama_alternatif = '$namaalt' 
                WHERE id_alternatif='$id'";
        $result = mysqli_query($db, $query);

        if ($result) {
            $_SESSION['berhasil'] = "Data berhasil diperbarui";
            header('Location: alternatif.php');
            exit();
        } else {
            $_SESSION['gagal'] = "gagal diperbarui";
            header('Location: alternatif.php');
            exit();
        }
    }
}
