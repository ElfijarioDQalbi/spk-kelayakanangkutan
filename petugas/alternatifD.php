<?php
session_start();
include 'koneksi.php';

// Jika user belum login, redirect ke halaman login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../index.php');
    exit;
}

if(isset($_POST['click_altview_btn'])){
    $id = $_POST['altdi'];

    $query = mysqli_query($db,"SELECT * FROM alternatif WHERE id_alternatif='$id'");

        while ($r=mysqli_fetch_assoc($query)) 
        { 
        
        echo '
            <form>
                <div class="form-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="kodealternatif" class="mb-1">Kode Alternatif</label>
                                <input type="text" id="kodealternatif" class="form-control" name="kodealternatif"  value="'.$r['kode_alternatif'].'" readonly>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="namaalternatif" class="mb-1">Nama Alternatif</label>
                                <input type="text" id="namaalternatif" class="form-control" name="namaalternatif"  value="'.$r['nama_alternatif'].'" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        ';
        }
}
?>