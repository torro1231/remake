<?php
ob_start();
session_start();
$sesi_username			= isset($_SESSION['username']) ? $_SESSION['username'] : NULL;
$sesi_level				= isset($_SESSION['leveluser']) ? $_SESSION['leveluser'] : NULL;
if ($sesi_level != '1' && $sesi_level != '3') {
	header('location:../index.php');
}
include "../config/koneksi.php";

$p_awal      	= isset($_POST['awal']) ? $_POST['awal'] : "";
$p_akhir      	= isset($_POST['akhir']) ? $_POST['akhir'] : "";
$nip     		= isset($_POST['nip']) ? $_POST['nip'] : "";
$gabung		 	= "" . $p_awal . " s/d " . $p_akhir . "";


// code baru 

header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=absensi.xls");
header("Pragma: no-cache");
header("Expires: 0");

$output = "";
$output .= "<table border='1'>";
$output .= "<tr>";
$output .= "<th>No</th>";
$output .= "<th>NIP</th>";
$output .= "<th>Nama</th>";
$output .= "<th>Tanggal</th>";
$output .= "<th>Jam Masuk</th>";
$output .= "<th>Jam Keluar</th>";
$output .= "<th>Keterangan</th>";
$output .= "</tr>";

$no = 1;
$hasil = mysqli_query($mysqli, "

	SELECT id_absensi,absensi.id_ijin,d.nm_ijin,absensi.nip,b.nama,tanggal_absen,c.shift,jam_in,c.jam_masuk,jam_out,c.jam_pulang, TIMESTAMPDIFF(HOUR,c.jam_pulang,jam_out)as lembur_jam,TIMEDIFF(jam_out,c.jam_pulang)as lembur,status_masuk,status_keluar,terlambat,pulangcepat,ket,TIMEDIFF(jam_in,c.jam_masuk)as jam_telat, TIMEDIFF(c.jam_pulang,jam_out)as jam_p_cepat from absensi 
	LEFT JOIN pegawai b ON absensi.nip = b.nip 
	LEFT JOIN tbl_absen c ON absensi.id_abs = c.id_abs 
	LEFT JOIN tbl_ijin d ON absensi.id_ijin=d.id_ijin 
	where tanggal_absen BETWEEN '$p_awal' AND '$p_akhir'
	AND absensi.nip='$nip' order by absensi.tanggal_absen asc




	");

while ($data = mysqli_fetch_row($hasil)) {
	$nip		= $data[3];
	$shift		= $data[6];
	$tanggal	= $data[5];
	$jamin 		= $data[7];
	$jamout 	= $data[9];
	$ket 		= $data[15];

	$output .= "<tr>";
	$output .= "<td>" . $no++ . "</td>";
	$output .= "<td>" . $nip . "</td>";
	$output .= "<td>" . $nama . "</td>";
	$output .= "<td>" . $tanggal . "</td>";
	$output .= "<td>" . $jamin . "</td>";
	$output .= "<td>" . $jamout . "</td>";
	$output .= "<td>" . $ket . "</td>";
	$output .= "</tr>";
}


$output .= "</table>";
echo $output;

$conn->close();
?>

// end code baru