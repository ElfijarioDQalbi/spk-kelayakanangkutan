<?php
session_start();
include 'koneksi.php';

if (isset($_POST['submit'])) {
    $kodealt = strtoupper($_POST['kodealternatif']);
    $namaalt = strtoupper($_POST['namaalternatif']);

    $cekduplikat    = mysqli_num_rows(mysqli_query($db, "SELECT * FROM alternatif WHERE kode_alternatif='$kodealt' 
                                                                                or nama_alternatif='$namaalt'"));

    if ($cekduplikat > 0) {
        $_SESSION['pesan'] = " Maaf, Data sudah ada sebelumnya";
        header('Location: alternatif.php');
    } else {
        $query= "INSERT INTO alternatif (kode_alternatif,nama_alternatif) 
                VALUES ('$kodealt','$namaalt')";
        $result = mysqli_query($db, $query);

        $query= "INSERT INTO penilaian (id_alternatif, id_kriteria, id_subkriteria) 
        SELECT alt.id_alternatif, kri.id_kriteria, NULL
        FROM alternatif alt, kriteria kri 
        WHERE kode_alternatif='$kodealt'";
        $result = mysqli_query($db, $query);

        $query= "INSERT INTO perhitungan (id_alternatif, id_kriteria, nilai_alternatif_per_kriteria, nilai_utility) 
        SELECT alt.id_alternatif, kri.id_kriteria, NULL, NULL
        FROM alternatif alt, kriteria kri 
        WHERE kode_alternatif='$kodealt'";
        $result = mysqli_query($db, $query);

        if ($result) {
            $_SESSION['berhasil'] = " Data berhasil ditambahkan";
            header('Location: alternatif.php');
            exit();
        } else {
            $_SESSION['gagal'] = " Data gagal ditambahkan" . mysqli_error($db);
            header('Location: alternatif.php');
            exit();
        }
    }
}
?>