<?php
session_start();
include 'koneksi.php';

// Jika user belum login, redirect ke halaman login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../index.php');
    exit;
}

if (isset($_POST['click_subview_btn'])) {
    $id = $_POST['subkri'];

    $query = mysqli_query($db,"SELECT *
                                FROM subkriteria , kriteria
                                WHERE subkriteria.id_kriteria = kriteria.id_kriteria
                                AND id_subkriteria='$id';");

    if (!$query) {
        die("Error: " . mysqli_error($db));
    }
    
    while ($r = mysqli_fetch_assoc($query)) {
        echo '
                <form>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="namakriteria" class="mb-1">Kode Kriteria</label>
                                    <input type="text" id="namakriteria" class="form-control" name="namakriteria"  value="'.$r['kode_kriteria'].'"  readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="namakriteria" class="mb-1">Nama Kriteria</label>
                                    <input type="text" id="namakriteria" class="form-control" name="namakriteria"  value="'.$r['nama_kriteria'].'"  readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="kodekriteria" class="mb-1">Kode Subkriteria</label>
                                    <input type="text" id="kodesubkriteria" class="form-control" name="kodesubkriteria"    value="'.$r['kode_subkriteria'].'" readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="namakriteria" class="mb-1">Nama Subkriteria</label>
                                    <input type="text" id="namasubkriteria" class="form-control" name="namasubkriteria"    value="'.$r['nama_subkriteria'].'"  readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="nilaikriteria" class="mb-1">Bobot Subkriteria</label>
                                    <input type="text" id="nilaisubkriteria" class="form-control" name="nilaisubkriteria"    value="'.$r['nilai_subkriteria'].'"  readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            ';
    }
}
