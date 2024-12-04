﻿<?php
error_reporting(0);
$sesi_username			= isset($_SESSION['username']) ? $_SESSION['username'] : NULL;

if ($sesi_username != NULL || !empty($sesi_username) || $_SESSION['leveluser'] == '1' || $_SESSION['leveluser'] == '2') {


?>



	<h3 class="header smaller lighter blue">Tabel Pengumuman</h3>

	<!-- textbox untuk pencarian -->
	<div class="input-prepend pull-center">
		<span class="add-on"><i class="icon-search"></i></span>
		<input class="span8" id="prependedInput" type="text" name="pencarian" placeholder="Pencarian..">



		<thead>
			<a href="#dialog-peng" id="0" class="tambah btn btn-app btn-purple btn-xs" data-toggle="modal">
				<i class="ace-icon fa fa-pencil-square-o bigger-160"></i>
				Tambah
				<span class="badge badge-warning badge-right"></span>
			</a>

			<a href="?id=pengumuman" class="btn btn-app btn-success btn-xs">
				<i class="ace-icon fa fa-refresh bigger-160"></i>
				Refresh
			</a>
	</div>




	<div id="data-peng"></div>

	</thead>



	<!-- awal untuk modal dialog -->
	<div id="dialog-peng" class="modal fade" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header no-padding">
					<div class="table-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							<span class="white">&times;</span>
						</button>
						<i id="myModalLabel">Tambah Data </i>
					</div>
				</div>


				<div class="modal-body">

					<div class="modal-content">

					</div>
				</div>

				<div class="modal-footer">
					<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Batal</button>
					<button id="simpan-peng" class="btn btn-success" data-dismiss="collapse" aria-hidden="true">Simpan</button>
				</div>
			</div>
		</div>
	</div>




<?php
} else {
	echo "<script>alert('Mohon Maaf anda tidak bisa akses halaman ini'); window.location = '../index.php'</script>";
}
?>