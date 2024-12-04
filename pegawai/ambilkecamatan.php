<?php
session_start();
$sesi_username = isset($_SESSION['username']) ? $_SESSION['username'] : NULL;
$sesi_level = isset($_SESSION['leveluser']) ? $_SESSION['leveluser'] : NULL;

if ($sesi_level != '1' && $sesi_level != '2' && $sesi_level != '3' && $sesi_level != '4' && $sesi_level != '5') {
    header('location:../index.php');
    exit; // Pastikan untuk keluar dari skrip setelah melempar header
}

include "../config/koneksi.php";
$kota = $_GET['kota'];

// Gunakan prepared statement untuk menghindari SQL Injection
$stmt = $mysqli->prepare("SELECT id_kec, nama_kec FROM kec WHERE id_kabkot = ? ORDER BY nama_kec");
$stmt->bind_param("s", $kota);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

echo "<option>-- Pilih Kecamatan --</option>";

while ($k = mysqli_fetch_array($result)) {
    echo "<option value=\"" . $k['id_kec'] . "\">" . $k['nama_kec'] . "</option>\n";
}
