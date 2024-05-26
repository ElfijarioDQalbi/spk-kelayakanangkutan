<?php
session_start();
include 'koneksi.php';

// Jika user belum login, redirect ke halaman login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../index.php');
    exit;
}

if (isset($_POST['submit'])) {
    $idkriteria = $_POST['idkriteria'];
    $kodesubk = strtoupper($_POST['kodesubkriteria']);
    $namasubk = ucfirst($_POST['namasubkriteria']);
    $bobotsubk = $_POST['bobotsubkriteria'];

    $cekduplikat = mysqli_num_rows(mysqli_query($db, "SELECT * FROM subkriteria WHERE kode_subkriteria='$kodesubk' or nama_subkriteria='$namasubk'"));
    if ($cekduplikat > 0) {
        $_SESSION['pesan'] = " Maaf, Data sudah ada sebelumnya";
        header('Location: subkriteria.php');
    } else {
        $query = "INSERT INTO subkriteria (id_kriteria, kode_subkriteria, nama_subkriteria, nilai_subkriteria)
                VALUES ('$idkriteria', '$kodesubk', '$namasubk', '$bobotsubk')";
        $result = mysqli_query($db, $query);

        if ($result) {
            // Jika data berhasil ditambahkan, maka kita dapat mengupdate nilai min dan max pada tabel kriteria
            $min = mysqli_fetch_assoc(mysqli_query($db, "SELECT MIN(nilai_subkriteria) AS min FROM subkriteria WHERE id_kriteria='$idkriteria'"))['min'];
            $max = mysqli_fetch_assoc(mysqli_query($db, "SELECT MAX(nilai_subkriteria) AS max FROM subkriteria WHERE id_kriteria='$idkriteria'"))['max'];

            // Update nilai min dan max pada tabel kriteria
            $query2 = "UPDATE kriteria SET min='$min', max='$max' WHERE id_kriteria='$idkriteria'";
            $result2 = mysqli_query($db, $query2);

            if ($result2) {
                $_SESSION['berhasil'] = " Data berhasil ditambahkan";
                header('Location: subkriteria.php');
                exit();
            } else {
                $_SESSION['gagal'] = " Data gagal ditambahkan" . mysqli_error($db);
                header('Location: subkriteria.php');
                exit();
            }
        } else {
            $_SESSION['gagal'] = " Data gagal ditambahkan" . mysqli_error($db);
            header('Location: subkriteria.php');
            exit();
        }
    }
}