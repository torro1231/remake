<?php
error_reporting(0);

$mod 			= isset($_GET['mod']) ? $_GET['mod'] : NULL;
$id_slip 		= isset($_GET['ID']) ? $_GET['ID'] : NULL;

if ($mod == "del") {
	$q_del = mysqli_query($mysqli, "DELETE FROM slip WHERE ID = '$id_slip'");

	if ($q_del) {
		echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'><i class='icon-remove'></i></button><strong><i class='icon-ok'></i>BERHASIL</strong> Data Slip Pegawai Berhasil di hapus<br/></div>";
	} else {
		echo "<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'><i class='icon-remove'></i></button><strong><i class='icon-remove'></i>MAAF!</strong>" . mysqli_error($mysqli) . "<br/></div>";
	}
}


$sesi_username			= isset($_SESSION['username']) ? $_SESSION['username'] : NULL;

if ($sesi_username != NULL || !empty($sesi_username) || $_SESSION['leveluser'] == '1' || $_SESSION['leveluser'] == '3') {



?>

	<div class="row">
		<div class="col-xs-12">
			<h3 class="header smaller lighter blue">Data Slip Gaji</h3>

			<div class="col-xs-12">
				<a href="?id=importslip" class="btn btn-danger">Import Data Slip</a>
			</div>

			<div class="table-header">
				Daftar Data Slip Gaji
			</div>

			<!-- <div class="table-responsive"> -->

			<!-- <div class="dataTables_borderWrap"> -->
			<div class="table-responsive">
				<table id="sample-table-2" class="table table-striped table-bordered table-hover">
					<thead>
						<tr>

							<th>Nip</th>
							<th>Nama</th>
							<th>Penempatan</th>
							<th>Periode</th>
							<th>Gaji Kotor</th>
							<th>Total Potongan</th>
							<th>Gaji Bersih</th>
							<th>Aksi</th>

						</tr>
					</thead>

					<tbody>

					</tbody>
				</table>
			</div>
		</div>

	<?php
} else {
	echo "<script>alert('Mohon Maaf anda tidak bisa akses halaman ini'); window.location = '../index.php'</script>";
}
	?>