<?php
session_start();
include 'koneksi.php';

//edit form
if (isset($_POST['click_editsub_btn'])) {
    $id = $_POST['subkri'];
    $arrayresult = [];

    $query = mysqli_query($db, "SELECT *
                                FROM subkriteria, kriteria
                                WHERE subkriteria.id_kriteria = kriteria.id_kriteria
                                AND id_subkriteria='$id';");
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
    $id = $_POST['idsubkriteria'];
    $idkriteria = $_POST['idkriteria'];
    $kodesubk = strtoupper($_POST['kodesubkriteria']);
    $namasubk = ucfirst($_POST['namasubkriteria']);
    $bobotsubk = $_POST['bobotsubkriteria'];

    $cekduplikat = mysqli_num_rows(mysqli_query($db, "SELECT * FROM subkriteria WHERE id_kriteria = '$idkriteria'
                                                                                    and kode_subkriteria='$kodesubk' 
                                                                                    and nama_subkriteria='$namasubk' 
                                                                                    and nilai_subkriteria='$bobotsubk' "));

    if ($cekduplikat > 0) {
        $_SESSION['pesan'] = " Maaf, Data sudah ada sebelumnya";
        header('Location: subkriteria.php');
    } else {
        $query = "UPDATE subkriteria
        SET
        id_kriteria = '$idkriteria',
        kode_subkriteria = '$kodesubk',
        nama_subkriteria = '$namasubk',
        nilai_subkriteria = '$bobotsubk'
        WHERE id_subkriteria = '$id'";
        $result = mysqli_query($db, $query);

        if ($result) {
            $_SESSION['berhasil'] = "Data berhasil diperbarui";
            // Setelah berhasil memperbarui data subkriteria, update nilai min dan max pada tabel kriteria
            $min = mysqli_fetch_assoc(mysqli_query($db, "SELECT MIN(nilai_subkriteria) AS min FROM subkriteria WHERE id_kriteria='$idkriteria'"))['min'];
            $max = mysqli_fetch_assoc(mysqli_query($db, "SELECT MAX(nilai_subkriteria) AS max FROM subkriteria WHERE id_kriteria='$idkriteria'"))['max'];

            // Update nilai min dan max pada tabel kriteria
            $query2 = "UPDATE kriteria SET min='$min', max='$max' WHERE id_kriteria='$idkriteria'";
            $result2 = mysqli_query($db, $query2);

            if ($result2) {
                header('Location: subkriteria.php');
                exit();
            } else {
                $_SESSION['gagal'] = "gagal memperbarui nilai min dan max" . mysqli_error($db);
                header('Location: subkriteria.php');
                exit();
            }
        } else {
            $_SESSION['gagal'] = "gagal diperbarui" . mysqli_error($db);
            header('Location: subkriteria.php');
            exit();
        }
    }
}