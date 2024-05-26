<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="dist/img/dishub.png">
    <title>Cetak Hasil Kelayakan Angkutan</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS tambahan jika diperlukan */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 8px;
        }
    </style>
</head>

<body>
    <center>
        <h2>Hasil Kelayakan Angkutan dengan Metode SMART</h2>
    </center>

    <?php
    session_start();
    include 'koneksi.php';

    // Jika user belum login, redirect ke halaman login
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header('Location: ../index.php');
        exit;
    }

    if (isset($_GET['kode_alternatif'])) {
        $kode_alternatif = $_GET['kode_alternatif'];
        $query = mysqli_query($db, "SELECT * FROM alternatif WHERE kode_alternatif = '$kode_alternatif'");
        $r = mysqli_fetch_assoc($query);
    ?>
        <table class="table-bordered table-hover table-sm" width="100%">
            <thead class="thead-light">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Nama Kendaraan</th>
                    <th class="text-center">Nilai</th>
                    <th class="text-center">Keterangan</th>
                </tr>
                <tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td class="text-center"><?php echo $r['nama_alternatif']; ?></td>
                    <td class="text-center"><?php echo round($r['nilai_alternatif'], 3); ?></td>
                    <td class="text-center">
                        <?php if ($r['keterangan'] == 'Layak') : ?>
                            <span class="badge badge-success"><?php echo $r['keterangan']; ?></span>
                        <?php elseif ($r['keterangan'] == 'Tidak Layak') : ?>
                            <span class="badge badge-danger"><?php echo $r['keterangan']; ?></span>
                        <?php else : ?>
                            <span><?php echo $r['keterangan']; ?></span>
                        <?php endif; ?>
                    </td>
                </tr>

            </tbody>
        </table>
    <?php
    } else {
        echo "Kode alternatif tidak valid";
    }
    ?>
    <script>
        window.print();
    </script>
</body>

</html>