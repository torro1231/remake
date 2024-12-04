<?php
session_start();
$sesi_username			= isset($_SESSION['username']) ? $_SESSION['username'] : NULL;
if ($sesi_username != NULL || !empty($sesi_username) || $_SESSION['leveluser'] == '1') {

	include "../config/koneksi.php";





	$id_klien = $_POST['id'];


	$data = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM klien WHERE id_klien=" . $id_klien));


	if ($id_klien > 0) {
		$id_klien = $data['id_klien'];
		$kd_klien = $data['kd_klien'];
		$n_klien = $data['n_klien'];
		$n_cabang = $data['n_cabang'];
		$koor_klien = $data['koor_klien'];
		$radius_absen = $data['radius_absen'];
	} else {

		$kd_klien = "";
		$n_klien = "";
		$n_cabang = "";
		$koor_klien = "";
		$radius_absen = "";
	}

?>

	<form class="form-horizontal" id="form-klien">



		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="id">ID</label>
			<div class="col-sm-9">
				<input type="text" disabled="disabled" id="id_klien" class="input-medium" name="id_klien" value="<?php echo $id_klien ?>">
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="kd_klien">Kode Klien</label>
			<div class="col-sm-9">
				<input type="text" id="kd_klien" class="input-medium" name="kd_klien" value="<?php echo $kd_klien ?>" required>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="n_klien">Nama Klien</label>
			<div class="col-sm-9">
				<input type="text" id="n_klien" class="input-medium" name="n_klien" value="<?php echo $n_klien ?>" required>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="n_cabang">Cabang</label>
			<div class="col-sm-9">
				<input type="text" id="n_cabang" class="input-medium" name="n_cabang" value="<?php echo $n_cabang ?>">
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="koor_klien">Kordinat Kantor</label>
			<div class="col-sm-9">
				<input type="text" id="koor_klien" class="input-medium" name="koor_klien" value="<?php echo $koor_klien ?>">
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="radius_absen">Radius Absen</label>
			<div class="col-sm-9">
				<input type="text" id="radius_absen" class="input-medium" name="radius_absen" value="<?php echo $radius_absen ?>">
			</div>
		</div>

	</form>

	<?php

	?>
<?php
} else {
	session_destroy();
	header('Location:../index.php?status=Silahkan Login');
}
?>