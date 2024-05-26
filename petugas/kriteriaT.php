<?php
session_start();
include 'koneksi.php';

if (isset($_POST['submit'])) {
    $kodekriteria = strtoupper($_POST['kodekriteria']);
    $namakriteria = ucwords($_POST['namakriteria']);
    $bobotkriteria = $_POST['bobotkriteria'];
    
    // Cek duplikat data
    $cekduplikat = mysqli_num_rows(mysqli_query($db, "SELECT * FROM kriteria WHERE kode_kriteria ='$kodekriteria' OR nama_kriteria='$namakriteria'"));

    if ($cekduplikat > 0) {
        $_SESSION['pesan'] = " Maaf, Data sudah ada sebelumnya";
    } else {
        // Hitung total bobot kriteria yang ada
        $queryTotalBobot = "SELECT SUM(bobot_kriteria) AS total_bobot FROM kriteria";
        $resultTotalBobot = mysqli_query($db, $queryTotalBobot);
        $row = mysqli_fetch_assoc($resultTotalBobot);
        $totalBobotSaatIni = $row['total_bobot'];

        // Cek apakah total bobot melebihi 100 setelah penambahan bobot baru
        if ($totalBobotSaatIni + $bobotkriteria > 100) {
            $_SESSION['pesan'] = " Maaf, Total bobot kriteria tidak boleh lebih dari 100";
            header('Location: kriteria.php');
            exit();
        } else {
            $query = "INSERT INTO kriteria (kode_kriteria, nama_kriteria, bobot_kriteria) 
                      VALUES ('$kodekriteria', '$namakriteria', '$bobotkriteria')";
            $result = mysqli_query($db, $query);

            if ($result) {
                $_SESSION['berhasil'] = " Data berhasil ditambahkan";
                header('Location: kriteria.php');
                exit();
            } else {
                $_SESSION['gagal'] = " Data gagal ditambahkan: " . mysqli_error($db);
                header('Location: kriteria.php');
                exit();
            }
        }
    }
}
?>