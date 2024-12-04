<?php
// panggil file koneksi.php
session_start();
$sesi_username			= isset($_SESSION['username']) ? $_SESSION['username'] : NULL;
if ($sesi_username != NULL || !empty($sesi_username) || $_SESSION['leveluser'] == '1') {

	include "../config/koneksi.php";
	error_reporting(0);




	$id_abs = $_POST['id'];

	$data = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM tbl_absen WHERE id_abs=" . $id_abs));


	if ($id_abs > 0) {
		$id_abs = $data['id_abs'];
		$shift = $data['shift'];
		$jam_masuk = $data['jam_masuk'];
		$jam_pulang = $data['jam_pulang'];
		$t_tugas = $data['t_tugas'];
		$l_tugas = $data['l_tugas'];

		// $uang_shift = $data['uang_shift'];
	} else {
		$id_abs = "";
		$shift = "";
		$jam_masuk = "";
		$jam_pulang = "";
		$t_tugas = "";
		$l_tugas = "";
		// $uang_shift = "";
	}

?>

	<!DOCTYPE html>
	<html lang="en">

	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>

	<body>
		<link rel="stylesheet" href="assets/css/bootstrap-timepicker.css" />

		<form class="form-horizontal" id="form-abs">

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="id">ID</label>
				<div class="col-sm-9">
					<input type="text" disabled="disabled" id="id_abs" class="input-medium" name="id_abs" value="<?php echo $id_abs ?>">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="shift">Shift</label>
				<div class="col-sm-9">
					<input type="text" id="shift" class="input-medium" name="shift" value="<?php echo $shift ?>">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="jam_masuk">Jam Masuk</label>
				<div class="col-sm-9">
					<div class="input-append bootstrap-timepicker">
						<input id="timepicker1" type="text" class="input-small" name="jam_masuk" value="<?php echo $jam_masuk ?>" />
						<span class="add-on">
							<i class="icon-time"></i>
						</span>
					</div>
				</div>
			</div>




			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="jam_pulang">Jam Pulang</label>
				<div class="col-sm-9">
					<div class="input-append bootstrap-timepicker">
						<input id="timepicker2" type="text" class="input-small" name="jam_pulang" value="<?php echo $jam_pulang ?>" />
						<span class="add-on">
							<i class="icon-time"></i>
						</span>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="t_tugas">Rekanan</label>
				<div class="col-sm-9">

					<select id="t_tugas" name="t_tugas" value="<?php echo $t_tugas ?>" required>
						<option>-- Rekanan --</option>
						<?php
						$qrekanan = mysqli_query($mysqli, "select * from klien order by n_klien");

						while ($arekanan = mysqli_fetch_array($qrekanan)) {

							if ($arekanan['n_klien'] == $t_tugas) {
								echo "<option value='$arekanan[2]' selected >$arekanan[2]</option>";
							} else {
								echo "<option value='$arekanan[2]'>$arekanan[2]</option>";
							}
						}

						?>

						<!-- <input type="text" id="transport" class="input-medium" name="transport" value=""> -->
					</select>


				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="l_tugas">Cabang</label>
				<div class="col-sm-9">
					<input type="text" id="l_tugas" class="input-medium" name="l_tugas" value="<?php echo $l_tugas ?>">
				</div>
			</div>


		</form>
		<script src="assets/js/date-time/bootstrap-timepicker.min.js"></script>
		<script type="text/javascript">
			$('#timepicker1').timepicker({
				minuteStep: 1,
				showSeconds: true,
				showMeridian: false
			});

			$('#timepicker2').timepicker({
				minuteStep: 1,
				showSeconds: true,
				showMeridian: false
			});
		</script>
	</body>

	</html>

	<?php

	?>
<?php
} else {
	session_destroy();
	header('Location:../index.php?status=Silahkan Login');
}
?>