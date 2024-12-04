<?php
session_start();
$sesi_username			= isset($_SESSION['username']) ? $_SESSION['username'] : NULL;
if ($sesi_username != NULL || !empty($sesi_username) || $_SESSION['leveluser'] == '1') {
	include "../config/koneksi.php";


	if (isset($_POST['hapus'])) {
		mysqli_query($mysqli, "DELETE FROM tbl_absen WHERE id_abs=" . $_POST['hapus']);
	} else {
		// deklarasikan variabel
		$id_abs	= $_POST['id_abs'];
		$shift	= $_POST['shift'];
		$jam_masuk	= $_POST['jam_masuk'];
		$jam_pulang	= $_POST['jam_pulang'];
		$t_tugas	= $_POST['t_tugas'];
		$l_tugas	= $_POST['l_tugas'];


		if ($shift != "") {



			if ($id_abs == 0) {
				mysqli_query($mysqli, "INSERT INTO tbl_absen VALUES('','$shift','$jam_masuk','$jam_pulang','$t_tugas','$l_tugas')");
			} else {
				mysqli_query($mysqli, "UPDATE tbl_absen SET
			shift = '$shift',
			jam_masuk = '$jam_masuk',
			jam_pulang = '$jam_pulang',
			t_tugas = '$t_tugas',
			l_tugas = '$l_tugas'
			WHERE id_abs= $id_abs
			");
			}
		}
	}


?>
<?php
} else {
	session_destroy();
	header('Location:../index.php?status=Silahkan Login');
}
?>	