<?php
// panggil fungsi validasi xss dan injection
require_once('fungsi_validasi.php');
// definisikan koneksi ke database
// hostcigs-network

$server = "localhost";
$usermysql = "u829206377_cigs_network";
$password = "Alfatih06;";
$database = "u829206377_pegawai_cigs";

// // databaselocal
// $server = "localhost";
// $usermysql = "root";
// $password = "";
// $database = "db_pegawai";

// Koneksi dan memilih database di server
$mysqli = new mysqli($server, $usermysql, $password, $database);
if ($mysqli->connect_error) {
	error_log("Connection failed: " . $mysqli->connect_error);
	die("Koneksi ke database gagal. Silakan coba lagi nanti.");
}


$val = new Lokovalidasi;
