<?php
session_start();
include 'koneksi.php';

// Jika user belum login, redirect ke halaman login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../index.php');
    exit;
}

if (isset($_POST['click_view_btn'])){
    $id = $_POST['idkri'];

    $query = mysqli_query($db,"SELECT * FROM kriteria WHERE id_kriteria='$id'");

        while ($r=mysqli_fetch_assoc($query)) 
        { 
        
        echo '
            <form>
                <div class="form-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="kodekriteria" class="mb-1">Kode Kriteria</label>
                                <input type="text" id="kodekriteria" class="form-control" name="kodekriteria"  value="'.$r['kode_kriteria'].'" readonly>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="namakriteria" class="mb-1">Nama Kriteria</label>
                                <input type="text" id="namakriteria" class="form-control" name="namakriteria"  value="'.$r['nama_kriteria'].'" readonly>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="bobotkriteria" class="mb-1">Bobot Kriteria</label>
                                <input type="text" id="bobotkriteria" class="form-control" name="bobotkriteria"  value="'.$r['bobot_kriteria'].'" readonly>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="minkriteria" class="mb-1">Min</label>
                                <input type="text" id="minkriteria" class="form-control" name="minkriteria"  value="'.$r['min'].'" readonly>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="maxkriteria" class="mb-1">Max</label>
                                <input type="text" id="maxkriteria" class="form-control" name="maxkriteria"  value="'.$r['max'].'" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        ';
        }
}
?>