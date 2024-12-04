<?php
session_start();

$sesi_username            = isset($_SESSION['username']) ? $_SESSION['username'] : NULL;
$sesi_level                = isset($_SESSION['leveluser']) ? $_SESSION['leveluser'] : NULL;
if ($sesi_level == '1' && $sesi_level == '3') {
    header('location:index.php');
}
include('config/koneksi.php');
if (isset($_POST['penempatan'])) {
    $penempatan = $_POST['penempatan'];

    // Query untuk mengambil shift berdasarkan penempatan
    $query = "SELECT id_abs, shift_name FROM tbl_absen WHERE penempatan = '$penempatan' ORDER BY id_abs";
    $result = mysqli_query($mysqli, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='{$row['id_abs']}'>{$row['shift_name']}</option>";
        }
    } else {
        echo "<option>-- Tidak ada shift tersedia --</option>";
    }
}
