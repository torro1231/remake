<?php
session_start();
$sesi_username = $_SESSION['username'] ?? NULL;
if ($sesi_username !== NULL || !empty($sesi_username) || $_SESSION['leveluser'] == '1') {
	include "../config/koneksi.php";
	error_reporting(0);

	// buat koneksi ke database mysql

	// proses menghapus data mahasiswa
	if (isset($_POST['hapus1'])) {
		mysqli_query($mysqli, "DELETE FROM klien WHERE id_klien=" . $_POST['hapus1']);
	} else {
		// deklarasikan variabel
		$id_klien = $_POST['id_klien'] ?? '';
		$kd_klien = $_POST['kd_klien'] ?? '';
		$n_klien = $_POST['n_klien'] ?? '';
		$n_cabang = $_POST['n_cabang'] ?? '';
		$koor_klien = $_POST['koor_klien'] ?? '';
		$radius_absen = $_POST['radius_absen'] ?? '';

		// validasi agar tidak ada data yang kosong
		if ($kd_klien !== "") {
			// proses tambah data klien
			if ($id_klien == 0) {
				mysqli_query($mysqli, "INSERT INTO klien VALUES('$id_klien','$kd_klien','$n_klien','$n_cabang','$koor_klien','$radius_absen')");
				// mysqli_query($mysqli, "INSERT INTO jabatan VALUES('$id_jab','$kode','$n_jab')");
				// proses ubah data klien
			} else {
				$q_klien = mysqli_query($mysqli, "UPDATE klien SET 
				kd_klien = '$kd_klien',
				n_klien = '$n_klien',
				n_cabang = '$n_cabang',
				koor_klien = '$koor_klien',
				radius_absen = '$radius_absen'
				WHERE id_klien= $id_klien
				");

				if ($q_klien) {
					echo "<h4 class='alert_success'>Data berhasil ditambahkan <a href=''>Cetak</a><span id='close'>[<a href='#'>X</a>]</span></h4>";
				} else {
					echo "<h4 class='alert_error'>" . mysqli_error($mysqli) . "<span id='close'>[<a href='#'>X</a>]</span></h4>";
				}
			}
		}
	}
} else {
	session_destroy();
	header('Location:../index.php?status=Silahkan Login');
}
