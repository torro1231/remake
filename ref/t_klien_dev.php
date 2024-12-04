<?php
$id_klien		= isset($_GET['idklien']) ? $_GET['idklien'] : NULL;
$mod 		= isset($_GET['mod']) ? $_GET['mod'] : NULL;

if ($mod == "del") {
	$q_delete_klien = mysqli_query($mysqli, "DELETE FROM klien WHERE id_klien = '$id_klien'");
	if ($q_delete_klien) {
		echo "<div class='alert alert-block alert-success'><button type='button' class='close' data-dismiss='alert'><i class=''></i></button><strong><i class='ace-icon fa fa-check'></i> BERHASIL</strong> Data Klien Berhasil di hapus<br/></div>";
	} else {
		echo "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><i class='icon-remove'></i></button><strong><i class='ace-icon fa fa-times'></i> MAAF! </strong>" . mysqli_error($mysqli) . "<br/></div>";
	}
}


$display 		= "style='display: none'";
$tb_act 		= isset($_POST['tb_act']) ? $_POST['tb_act'] : NULL;
$p_id_klien  	= isset($_POST['id_klien']) ? $_POST['id_klien'] : NULL;

$p_kode_klien 	= isset($_POST['kd_klien']) ? $_POST['kd_klien'] : NULL;
$p_nama_klien 	= isset($_POST['n_klien']) ? $_POST['n_klien'] : NULL;
$p_nama_cabang 	= isset($_POST['n_cabang']) ? $_POST['n_cabang'] : NULL;
$p_koor_klien 	= isset($_POST['koor_klien']) ? $_POST['koor_klien'] : NULL;
$p_radius_absen 	= isset($_POST['radius_absen']) ? $_POST['radius_absen'] : NULL;

if ($tb_act == "Tambah") {
	$display = "style='display: none'";
	$q_tambah_klien	= mysqli_query($mysqli, "INSERT INTO klien VALUES ('','$p_kode_klien','$p_nama_klien','$p_nama_cabang','$p_koor_klien','$p_radius_absen')");
	if ($q_tambah_klien) {

		echo "<div class='alert alert-block alert-success'><button type='button' class='close' data-dismiss='alert'><i class=''></i></button><strong><i class='ace-icon fa fa-check'></i> BERHASIL</strong> Data Klien Berhasil di simpan<br/></div>";
	} else {
		echo "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><i class='icon-remove'></i></button><strong><i class='ace-icon fa fa-times'></i> MAAF! </strong>" . mysqli_error($mysqli) . "<br/></div>";
	}
} else if ($tb_act == "Edit") {
	$display = "style='display: none'";
	$q_edit_klien	= mysqli_query($mysqli, "UPDATE klien SET kd_klien = '$p_kode_klien', n_klien='$p_nama_klien', n_cabang='$p_nama_cabang', koor_klien='$p_koor_klien', radius_absen='$p_radius_absen' WHERE id_klien = '$p_id_klien'");
	if ($q_edit_klien) {
		echo "<div class='alert alert-block alert-success'><button type='button' class='close' data-dismiss='alert'><i class='icon-remove'></i></button><strong><i class='ace-icon fa fa-check'></i> BERHASIL</strong> Data Klien Berhasil di update<br/></div>";
	} else {
		echo "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><i class='icon-remove'></i></button><strong><i class='ace-icon fa fa-times'></i> MAAF! </strong>" . mysqli_error($mysqli) . "<br/></div>";
	}
} else {
	$display = "style='display: none'";
}
?>

<h3 class="header smaller lighter blue">Referensi </h3>
<div class="module_content">
	<h5><a href="?id=klien&mod=add" class="btn btn-primary">Tambah Data</a></h5>



	<?php
	// ================ TAMPILKAN DATANYA =====================//
	echo "<table id='sample-table-2' class='table table-striped table-bordered table-hover'><tr><th width='5%'>ID</th><th width='10%'>Kode</th><th width='25%'>Klien</th><th width='25%'>Cabang</th><th width='28%'>Kordinat Absen Kantor</th><th width='10%'>Radius Absen</th><th width='10%'>Aksi</th></tr>";
	$q_klien 	= mysqli_query($mysqli, "SELECT * FROM klien ORDER BY id_klien ASC") or die(mysqli_error($mysqli));
	$j_data 	= mysqli_num_rows($q_klien);

	if ($j_data == 0) {
		echo "<tr><td id='tengah' colspan='3'>-- Tidak Ada Data --</td></tr>";
	} else {
		$no = 1;
		while ($a_klien = mysqli_fetch_array($q_klien)) {
			echo "<tr>
				<td>$a_klien[0]</td>
				<td>$a_klien[1]</td>
				<td>$a_klien[2]</td>
				<td>$a_klien[3]</td>
				<td>$a_klien[4]</td>
				<td>$a_klien[5]</td>
				<td><a href='?id=klien&mod=edit&idklien=$a_klien[0]' ><span class='blue'><i class='ace-icon fa fa-pencil-square-o bigger-120'></i></span></a> |
					<a href='?id=klien&mod=del&idklien=$a_klien[0]' onclick=\"return confirm('Menghapus data $a_klien[1]')\"><span class='red'><i class='ace-icon fa fa-trash-o bigger-120'></i></span></a>
				</tr>";
			$no++;
		}
	}
	echo "</table>";
	?>

</div>


<?php
// ================ DATA URL "mod" ( GET ) =====================//

if ($mod == "edit") {
	$display = "";
	$q_edit_klien	= mysqli_query($mysqli, "SELECT * FROM klien WHERE id_klien = '$id_klien'");
	$a_edit_klien	= mysqli_fetch_array($q_edit_klien);

	$kd_klien = $a_edit_klien[1];
	$n_klien = $a_edit_klien[2];
	$n_cabang = $a_edit_klien[3];
	$koor_klien = $a_edit_klien[4];
	$radius_absen = $a_edit_klien[5];
	$view = "Edit";
} else if ($mod == "add") {
	$display = "";
	$id_klien = "";
	$kd_klien = "";
	$n_klien = "";
	$n_cabang = "";
	$koor_klien = "";
	$radius_absen = "";
	$view = "Tambah";
} else {
	$display = "style='display: none'";
}

?>

<div <?php echo $display; ?>>
	<header>
		<h3 class="header smaller lighter blue"><?php echo $view; ?> Data Klien</h3>
	</header>
	<form action="?id=klien" class="form-horizontal" method="post" id="ft_klien">

		<div class="form-group" style='display: none'>
			<label class="col-sm-3 control-label no-padding-right" for="kode">ID</label>
			<div class="col-sm-9">
				<input type="text" size="3" name="id_klien" readonly value="<?php echo $id_klien; ?>">
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="kode">Kode Klien</label>
			<div class="col-sm-9">
				<input type="text" size="30" name="kd_klien" value="<?php echo $kd_klien; ?>" required>
			</div>
		</div>


		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="kode">Nama Klien</label>
			<div class="col-sm-9">
				<input type="text" size="30" name="n_klien" value="<?php echo $n_klien; ?>" required>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="kode">Nama Cabang</label>
			<div class="col-sm-9">
				<input type="text" size="30" name="n_cabang" value="<?php echo $n_cabang; ?>" required>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="kode">Koordinat Klien</label>
			<div class="col-sm-9">
				<input type="text" size="30" name="koor_klien" value="<?php echo $koor_klien; ?>" required>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="kode">Radius Absensi</label>
			<div class="col-sm-9">
				<input type="text" size="30" name="radius_absen" value="<?php echo $radius_absen; ?>" required>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="kode"></label>
			<div class="col-sm-9">
				<input type="submit" class="btn btn-primary" name="tb_act" value="<?php echo $view; ?>">
			</div>
		</div>

	</form>
</div>