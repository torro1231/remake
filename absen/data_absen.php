<?php
error_reporting(0);

$mod 			= isset($_GET['mod']) ? $_GET['mod'] : NULL;
$id_absensi 		= isset($_GET['id_absensi']) ? $_GET['id_absensi'] : NULL;

if ($mod == "del") {
	$q_del = mysqli_query($mysqli, "DELETE FROM absensi WHERE id_absensi = '$id_absensi'");

	if ($q_del) {
		echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'><i class='icon-remove'></i></button><strong><i class='icon-ok'></i>BERHASIL</strong> Data Absensi Pegawai Berhasil di hapus<br/></div>";
	} else {
		echo "<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'><i class='icon-remove'></i></button><strong><i class='icon-remove'></i>MAAF!</strong>" . mysqli_error($mysqli) . "<br/></div>";
	}
}


$sesi_username			= isset($_SESSION['username']) ? $_SESSION['username'] : NULL;

if ($sesi_username != NULL || !empty($sesi_username) || $_SESSION['leveluser'] == '1' || $_SESSION['leveluser'] == '3') {



?>

	<div class="row">
		<div class="col-xs-12">
			<h3 class="header smaller lighter blue">Data Absensi</h3>

			<div class="col-xs-12">
				<a href="?id=inputabsen" class="btn btn-danger">Input Absen</a>
				<a href="?id=inputijin" class="btn btn-info">Input Ijin</a>
				<a href="?id=rekapabsen" class="btn btn-success">Rekap Absensi</a>
				<a href="?id=cekalfa" class="btn btn-danger">Cek Alfa</a>
			</div>

			<div class="table-header">
				Daftar Data Absensi
			</div>

			<!-- <div class="table-responsive"> -->

			<!-- <div class="dataTables_borderWrap"> -->
			<div class="table-responsive">
				<table id="sample-table-2" class="table table-striped table-bordered table-hover">
					<thead>
						<tr>

							<th>Nip</th>
							<th>Nama</th>
							<th class="hidden-480">Tanggal</th>
							<th>Shift</th>
							<th>Jam In</th>
							<th>Jam Out</th>
							<th>Terlambat</th>
							<th>Pulang Cepat</th>
							<th>Sakit/Ijin/alfa</th>
							<th>Penempatan Tugas</th>
							<th>Lokasi Absen</th>
							<!-- <th>Lokasi Kantor</th> -->
							<th>Aksi</th>
						</tr>
					</thead>

					<tbody>

					</tbody>
				</table>
			</div>
		</div>
		<!-- Awal Modal -->
		<div class="modal fade" id="modal-location">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Lokasi Absen <span class="modal-title-name"></span></h4>
					</div>
					<div class="modal-body">
						<div id="iframe-map"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->
	<?php
} else {
	echo "<script>alert('Mohon Maaf anda tidak bisa akses halaman ini'); window.location = '../index.php'</script>";
}


	?>