<?php
session_start();
error_reporting(0);
include "config/timeout.php";
include "config/koneksi.php";
include "config/fungsi_ago.php";
include "config/fungsi_indotgl.php";
include "config/fungsi_masakerja.php";
include "config/page_user.php";


$id_user = $_SESSION['kode'];
$nip = $_SESSION['nip'];
$id_daf = $_SESSION['id_daftar'];
$nm_user = $_SESSION['username'];
$iduser = $_SESSION['id_daftar'];


$sesi_username			= isset($_SESSION['username']) ? $_SESSION['username'] : NULL;
$sesi_id_jab			= isset($_SESSION['id_jab']) ? $_SESSION['id_jab'] : NULL;
if ($sesi_username != NULL || !empty($sesi_username) || $_SESSION['leveluser'] == '5') {
	if (!login_check()) {
		echo "
  <script>alert('Expired, Anda Harus login lagi');document.location='logout.php';</script>";

		exit(0);
	} else {

?>

		<!DOCTYPE html>
		<html lang="en">

		<head>
			<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
			<meta charset="utf-8" />
			<title>Dashboard - Pegawai</title>

			<meta name="description" content="overview &amp; stats" />
			<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
			<link rel="shortcut icon" href="favicon.ico" />
			<!-- bootstrap & fontawesome -->
			<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
			<link rel="stylesheet" href="assets/font-awesome/4.1.0/css/font-awesome.min.css" />

			<link rel="stylesheet" href="<?php echo $ambilcss1; ?>" />
			<link rel="stylesheet" href="<?php echo $ambilcss2; ?>" />
			<link rel="stylesheet" href="<?php echo $ambilcss3; ?>" />
			<link rel="stylesheet" href="<?php echo $ambilcss4; ?>" />
			<link rel="stylesheet" href="<?php echo $ambilcss5; ?>" />
			<link rel="stylesheet" href="<?php echo $ambilcss6; ?>" />
			<link rel="stylesheet" href="<?php echo $ambilcss7; ?>" />
			<link rel="stylesheet" href="<?php echo $ambilcss8; ?>" />
			<link rel="stylesheet" href="<?php echo $ambilcss9; ?>" />
			<link rel="stylesheet" href="<?php echo $ambilcss10; ?>" />

			<!-- page specific plugin styles -->

			<!-- text fonts -->
			<link rel="stylesheet" href="assets/fonts/fonts.googleapis.com.css" />

			<!-- ace styles -->
			<link rel="stylesheet" href="assets/css/ace.min.css" id="main-ace-style" />

			<!--[if lte IE 9]>
	<link rel="stylesheet" href="assets/css/ace-part2.min.css" />
	<![endif]-->
			<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
			<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />

			<!--[if lte IE 9]>
	<link rel="stylesheet" href="assets/css/ace-ie.min.css" />
	<![endif]-->

			<!-- inline styles related to this page -->
			<!-- Leaflet -->
			<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
			<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
			<!-- ace settings handler -->
			<script src="assets/js/ace-extra.min.js"></script>
			<script src="assets/js/time.js" type="text/javascript"></script>
			<script src="<?php echo $ambiljs0; ?>"></script>
			<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->
			<?php include $ambilfungsi2; ?>
			<!--[if lte IE 8]>
	<script src="assets/js/html5shiv.min.js"></script>
	<script src="assets/js/respond.min.js"></script>
	<![endif]-->
		</head>

		<?php
		$queryskin = mysqli_query($mysqli, "select skin from master");
		$rowskin = mysqli_fetch_array($queryskin);
		echo "<body class='" . $rowskin[0] . "'>";
		?>
		<!-- Preloader -->

		<div id="navbar" class="navbar navbar-default">
			<script type="text/javascript">
				try {
					ace.settings.check('navbar', 'fixed')
				} catch (e) {}
			</script>

			<div class="navbar-container" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
					<a href="#" class="navbar-brand">
						<small>
							<i class="fa fa-eye"></i>
							SISPEG User
						</small>
					</a>
				</div>

				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">

						<li class="purple">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-bell icon-animated-bell"></i>
								<span class="badge badge-important">
									<?php

									$hasilict = mysqli_query($mysqli, "select count(id)as jumcuti from ajuancuti where kd_approve='1' and kdnotif='1' and id=$id_daf");
									$dataict = mysqli_fetch_array($hasilict);
									$jumlahct = $dataict['jumcuti'];

									echo "$jumlahct";
									?></span>
							</a>

							<ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-exclamation-triangle"></i>
									<?php

									$ct = "";
									$hasilict = mysqli_query($mysqli, "select count(id)as jumcuti from ajuancuti where kd_approve='1' and kdnotif='1' and id=$id_daf");
									$dataict = mysqli_fetch_array($hasilict);
									$jumlahct = $dataict['jumcuti'];

									echo "$jumlahct Pemberitahuan";
									?>

								</li>



								<?php
								$data = mysqli_query($mysqli, "select count(nip)as jumcuti from ajuancuti where kd_approve='1' and kdnotif='1' and nip=$nip ");
								while ($b = mysqli_fetch_array($data)) {
									if ($b['jumcuti'] == 0) {
										echo "<span> --Tidak ada Pemberitahuan--</span>";
									} else {
										echo "
						<li>
						<a href='?id=ajuan_cuti&mod=konf'>
						<div class='clearfix'>
											<span class='pull-left'>
												<i class='btn btn-xs no-hover btn-success fa fa-shopping-cart'></i>
												Data Cuti Sudah di konfirmasi
											</span>
						
						<span class='pull-right badge badge-success'>" . $b['jumcuti'] . "</span>
						      </div>
						</a>
						</li>";
									}
								}
								?>



								<li class="dropdown-footer">
									<a href="#">
										See all notifications
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>

						<li class="green">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-envelope icon-animated-vertical"></i>
								<?php
								$data = mysqli_query($mysqli, "select count(sudahbaca)as jum2 from tabel_pesan where sudahbaca='N' and kepada='$nm_user'");
								while ($b = mysqli_fetch_array($data)) {
									echo "<span class='badge badge-success'>" . $b['jum2'] . "</span>";
								}
								?>



							</a>

							<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<?php

									$count = mysqli_query($mysqli, "select count(kepada)as jum from tabel_pesan where kepada='$nm_user' and sudahbaca='N'");
									while ($row4 = mysqli_fetch_array($count)) {
										echo "<span class='ace-icon fa fa-envelope-o'> " . $row4['jum'] . " Pesan</span>";
									}
									?>

									<?php
									$pesan = mysqli_query($mysqli, "select tabel_pesan.waktu,dari,kepada,pesan,tbl_user.photo, sudahbaca,subject from tabel_pesan,tbl_user where kepada='$nm_user'
                and tabel_pesan.dari=tbl_user.username
                and tabel_pesan.sudahbaca='N'
                GROUP BY dari order by waktu asc ");
									while ($row3 = mysqli_fetch_array($pesan)) {

									?>
								<li class="dropdown-content">
									<ul class="dropdown-menu dropdown-navbar">
										<li>
											<a href="?id=msg">
												<img src='<?php echo $row3['photo']; ?>' class="msg-photo" alt="Alex's Avatar" />
												<span class="msg-body">
													<span class="msg-title">
														<span class="blue"><?php echo $row3['dari']; ?>:</span>
														<?php echo $row3['subject']; ?>
													</span>

													<span class="msg-time">
														<i class="ace-icon fa fa-clock-o"></i>
														<span><?php echo relative_format($row3['waktu']); ?></span>
													</span>
												</span>
											</a>
										</li>

									</ul>
								</li>
							<?php
									}
							?>
							<li class="dropdown-footer">
								<a href="?id=msg">
									See all messages
									<i class="ace-icon fa fa-arrow-right"></i>
								</a>
							</li>
							</ul>
						</li>

						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<?php

								$user = mysqli_query($mysqli, "select * from tbl_user where id_user=$id_user");
								while ($rowuser = mysqli_fetch_array($user)) {
									echo "<img class='nav-user-photo' src='" . $rowuser['photo'] . "' alt='Jason's Photo' />";
									echo "<span class='user-info'>";
									echo "<small>Welcome,</small>";
									echo "" . $rowuser['username'] . "";
									echo "</span>";
								}
								?>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="?id=set">
										<i class="ace-icon fa fa-cog"></i>
										Settings
									</a>
								</li>

								<li>
									<a href="?id=profil">
										<i class="ace-icon fa fa-user"></i>
										Profile
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<button class="btn btn-minier btn-danger" id="bootbox-confirm"><i class="ace-icon glyphicon glyphicon-off"></i>logout</button>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div><!-- /.navbar-container -->
		</div>

		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try {
					ace.settings.check('main-container', 'fixed')
				} catch (e) {}
			</script>

			<div id="sidebar" class="sidebar responsive">
				<script type="text/javascript">
					try {
						ace.settings.check('sidebar', 'fixed')
					} catch (e) {}
				</script>

				<div class="sidebar-shortcuts" id="sidebar-shortcuts">
					<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
						<button class="btn btn-success">
							<i class="ace-icon fa fa-signal"></i>
						</button>

						<button class="btn btn-info">
							<i class="ace-icon fa fa-pencil"></i>
						</button>



						<a href="#" class="btn btn-warning">
							<i class="ace-icon fa fa-users"></i>
						</a>


						<button class="btn btn-danger">
							<i class="ace-icon fa fa-cogs"></i>
						</button>
					</div>

					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>

						<span class="btn btn-info"></span>

						<span class="btn btn-warning"></span>

						<span class="btn btn-danger"></span>
					</div>
				</div><!-- /.sidebar-shortcuts -->

				<ul class="nav nav-list">
					<li class="<?php echo $classmenu1 ?>">
						<a href="?id=home">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Dashboard </span>
						</a>

						<b class="arrow"></b>
					</li>


					<li class="<?php echo $classmenu2 ?>">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa 	fa-user"></i>
							<span class="menu-text"> Data Pribadi </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="<?php echo $classmenu3 ?>">
								<a href="?id=profil">
									<i class="menu-icon fa fa-caret-right"></i>
									Profil
								</a>

								<b class="arrow"></b>
							</li>

						</ul>
					</li>


					<li class="<?php echo $classmenu4 ?>">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon glyphicon glyphicon-time"></i>
							<span class="menu-text"> Absen,Cuti & Slip </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="<?php echo $classmenu5 ?>">
								<a href="?id=ajuan_cuti">
									<i class="menu-icon fa fa-caret-right"></i>
									Pengajuan Cuti
								</a>
								<b class="arrow"></b>
							</li>


							<?php
							$querysetabsen = mysqli_query($mysqli, "SELECT * FROM master");
							$datasetabsensi = mysqli_fetch_array($querysetabsen);
							if ($datasetabsensi['absensi'] == 'Y') {
								echo "<li class='" . $classmenu6 . "'>
                <a href='?id=absensi'>
                    <i class='menu-icon fa fa-caret-right'></i>
                    Absen
                </a>
                <b class='arrow'></b>
            </li> ";
							} else {
								echo "";
							}

							?>


							<li class="<?php echo $classmenu7 ?>">
								<a href="?id=lapabsensi">
									<i class="menu-icon fa fa-caret-right"></i>
									Laporan Absensi
								</a>
								<b class="arrow"></b>
							</li>
							<li class="<?php echo $classmenu8 ?>">
								<a href="?id=slipgaji">
									<i class="menu-icon fa fa-caret-right"></i>
									Slip Gaji
								</a>
								<b class="arrow"></b>
							</li>

						</ul>

						<b class="arrow"></b>



					</li>
					<!--[if IE]>
    <li class="">
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-credit-card"></i>
            <span class="menu-text"> Data Payroll </span>

            <b class="arrow fa fa-angle-down"></b>
        </a>

        <b class="arrow"></b>

        <ul class="submenu">
            <li class="">
                <a href="?id=ajuan_cuti">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Slip Gaji
                </a>

                <b class="arrow"></b>
            </li>

        </ul>
    </li>

<![endif]-->


					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-tag"></i>
							<span class="menu-text"> More Pages </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">

							<li class="">
								<a href="?id=databerkas" id="berkas">
									<i class="menu-icon fa fa-caret-right"></i>
									DataBerkas
								</a>

								<b class="arrow"></b>
							</li>


							<li class="">
								<a href="logout.php" id="logout" onclick="return confirm('Apakah Anda yakin?')">
									<i class="menu-icon fa fa-caret-right"></i>
									Logout
								</a>

								<b class="arrow"></b>
							</li>

						</ul>
					</li>


				</ul><!-- /.nav-list -->

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>

				<script type="text/javascript">
					try {
						ace.settings.check('sidebar', 'collapsed')
					} catch (e) {}
				</script>
			</div>

			<div class="main-content">
				<div class="breadcrumbs" id="breadcrumbs">
					<script type="text/javascript">
						try {
							ace.settings.check('breadcrumbs', 'fixed')
						} catch (e) {}
					</script>

					<ul class="breadcrumb">
						<li>
							<i class="ace-icon fa fa-home home-icon"></i>
							<a href="#">Home</a>
						</li>
						<li class="active"><?php echo $nav; ?></li>
					</ul><!-- /.breadcrumb -->

					<small>
						<i class="icon-double-angle-right"></i>
						<span id="dates"><span id="the-day">Hari, 00 Bulan 0000</span> <span id="the-time">00:00:00</span> </span>
					</small>




					<!-- /.nav-search -->
				</div>

				<div class="page-content">
					<div class="ace-settings-container" id="ace-settings-container">
						<div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
							<i class="ace-icon fa  fa-bullhorn   bigger-150"></i>
						</div>

						<div class="ace-settings-box clearfix" id="ace-settings-box">
							<div class="pull-left width-50">

							</div>
							<!-- /.pull-left -->
							<?php
							$querypeng = mysqli_query($mysqli, "SELECT * FROM tbl_peng where id_pes=(select max(id_pes) from tbl_peng)");
							$datapeng = mysqli_fetch_array($querypeng);
							$header = $datapeng['header'];
							$body 	= $datapeng['body'];
							$footer = $datapeng['footer'];

							echo "
			<div class='pull-left width-50'>
			<div class='ace-settings-item'>

				<label class='lbl' for='ace-settings-hover'><strong>" . $header . "</strong></label>
			</div>

			<div class='ace-settings-item'>
				<label class='lbl' for='ace-settings-compact'>" . $body . "</label>
			</div>

			<div class='ace-settings-item'>
				<label class='lbl' for='ace-settings-highlight'>" . $footer . "</label>
			</div>
		</div>
			
			";

							?>

						</div><!-- /.ace-settings-box -->
					</div><!-- /.ace-settings-container -->


					<div class="page-content-area">


						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<?php include $ambil; ?>

								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content-area -->
				</div><!-- /.page-content -->
			</div><!-- /.main-content -->

			<div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
						<span class="bigger-120">
							<span class="blue bolder">TORROTECH</span>
							&copy; 2023 <?php
										$q_nm_pt	    = mysqli_query($mysqli, "SELECT nm_pt FROM master WHERE id='1'");
										$a_nm_pt	    = mysqli_fetch_array($q_nm_pt);
										echo "<span class='blue'>$a_nm_pt[0]</span>";
										?>
						</span>

						<!-- <span class="action-buttons">
							<a href=""#"">
								<i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
							</a>

							<a href="http://www.facebook.com/siswt">
								<i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
							</a>

							<a href="#">
								<i class="ace-icon fa fa-rss-square orange bigger-150"></i>
							</a>
						</span> -->
					</div>
				</div>
			</div>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->




		<!-- <![endif]-->

		<!--[if IE]>
<script src="assets/js/jquery.1.11.1.min.js"></script>
<![endif]-->

		<!--[if IE]>
<script type="text/javascript">
	window.jQuery || document.write("<script src='assets/js/jquery1x.min.js'>"+"<"+"/script>");
</script>
<![endif]-->
		<script type="text/javascript">
			if ('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>

		<script src="<?php echo $ambiljs1; ?>"></script>
		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
<script src="assets/js/excanvas.min.js"></script>
<![endif]-->
		<script src="assets/js/jquery-ui.custom.min.js"></script>
		<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="assets/js/bootbox.min.js"></script>


		<script src="<?php echo $ambiljs2; ?>"></script>
		<script src="<?php echo $ambiljs3; ?>"></script>
		<script src="<?php echo $ambiljs4; ?>"></script>
		<script src="<?php echo $ambiljs5; ?>"></script>
		<script src="<?php echo $ambiljs6; ?>"></script>
		<script src="<?php echo $ambiljs7; ?>"></script>
		<script src="<?php echo $ambiljs8; ?>"></script>
		<script src="<?php echo $ambiljs9; ?>"></script>
		<script src="<?php echo $ambiljs10; ?>"></script>
		<script src="<?php echo $ambiljs11; ?>"></script>
		<script src="<?php echo $ambiljs12; ?>"></script>



		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>
		<script src="assets/js/jquery.validate.min.js"></script>
		<?php include $ambilfungsi; ?>
		<!-- inline scripts related to this page -->


		<script type="text/javascript">
			jQuery(function($) {

				$("#bootbox-confirm").on(ace.click_event, function() {
					bootbox.confirm("Apakah anda yakin ingin keluar?", function(result) {
						if (result) {
							window.location = 'logout.php';
						}
					});
				});


			});
		</script>
		<!-- perbaikan skrip geolokasi -->
		<script type="text/javascript">
			document.addEventListener('DOMContentLoaded', function() {
				var lokasi = document.getElementById("lokasiAbsen");
				// 
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
				} else {
					swal({
						title: 'Oops!',
						text: 'Maaf, browser Anda tidak mendukung geolokasi HTML5.',
						icon: 'error',
						timer: 3000,
					});
				};

				// Define callback function for successful attempt
				function successCallback(position) {
					lokasi.value = position.coords.latitude + "," + position.coords.longitude;
				}

				// Define callback function for failed attempt
				function errorCallback(error) {
					if (error.code == 1) {
						swal({
							title: 'Oops!',
							text: 'Anda telah memutuskan untuk tidak membagikan posisi Anda, tetapi tidak apa-apa. Kami tidak akan meminta Anda lagi.',
							icon: 'error',
							timer: 3000,
						});
					} else if (error.code == 2) {
						swal({
							title: 'Oops!',
							text: 'Jaringan tidak aktif atau layanan penentuan posisi tidak dapat dijangkau.',
							icon: 'error',
							timer: 3000,
						});
					} else if (error.code == 3) {
						swal({
							title: 'Oops!',
							text: 'Waktu percobaan habis sebelum bisa mendapatkan data lokasi.',
							icon: 'error',
							timer: 3000,
						});
					} else {
						swal({
							title: 'Oops!',
							text: 'Waktu percobaan habis sebelum bisa mendapatkan data lokasi.',
							icon: 'error',
							timer: 3000,
						});
					}
				}
			});
		</script>

		<!--end perbaikan skrip geolokasi -->



		<!-- skrip geolokasi -->
		<!-- <script type="text/javascript">
			var lokasi = document.getElementById("lokasiAbsen");
			// 
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
			} else {
				swal({
					title: 'Oops!',
					text: 'Maaf, browser Anda tidak mendukung geolokasi HTML5.',
					icon: 'error',
					timer: 3000,
				});
			};

			// Define callback function for successful attempt
			function successCallback(position) {
				lokasi.value = "" + position.coords.latitude + "," + position.coords.longitude + "";
			}

			// Define callback function for failed attempt
			function errorCallback(error) {
				if (error.code == 1) {
					swal({
						title: 'Oops!',
						text: 'Anda telah memutuskan untuk tidak membagikan posisi Anda, tetapi tidak apa-apa. Kami tidak akan meminta Anda lagi.',
						icon: 'error',
						timer: 3000,
					});
				} else if (error.code == 2) {
					swal({
						title: 'Oops!',
						text: 'Jaringan tidak aktif atau layanan penentuan posisi tidak dapat dijangkau.',
						icon: 'error',
						timer: 3000,
					});
				} else if (error.code == 3) {
					swal({
						title: 'Oops!',
						text: 'Waktu percobaan habis sebelum bisa mendapatkan data lokasi.',
						icon: 'error',
						timer: 3000,
					});
				} else {
					swal({
						title: 'Oops!',
						text: 'Waktu percobaan habis sebelum bisa mendapatkan data lokasi.',
						icon: 'error',
						timer: 3000,
					});
				}
			}
// akhir scrip lama


			// var map = L.map('map').setView([51.505, -0.09], 13);
			// L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
			// 	maxZoom: 19,
			// 	attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
			// }).addTo(map);
			// var marker = L.marker([51.5, -0.09]).addTo(map);
			// var circle = L.circle([51.508, -0.11], {
			// 	color: 'red',
			// 	fillColor: '#f03',
			// 	fillOpacity: 0.5,
			// 	radius: 500
			// }).addTo(map);


			// start webcame
			// Webcam.set({
			// 	width: 590,
			// 	height: 460,
			// 	image_format: 'jpeg',
			// 	jpeg_quality: 80,
			// });

			// var cameras = new Array(); //create empty array to later insert available devices
			// navigator.mediaDevices.enumerateDevices() // get the available devices found in the machine
			// 	.then(function(devices) {
			// 		devices.forEach(function(device) {
			// 			var i = 0;
			// 			if (device.kind === "videoinput") { //filter video devices only
			// 				cameras[i] = device.deviceId; // save the camera id's in the camera array
			// 				i++;
			// 			}
			// 		});
			// 	})

			// Webcam.set('constraints', {
			// 	width: 590,
			// 	height: 460,
			// 	image_format: 'jpeg',
			// 	jpeg_quality: 80,
			// 	sourceId: cameras[0]
			// });

			// Webcam.attach('.webcam-capture');
			// // preload shutter audio clip
			// var shutter = new Audio();
			// //shutter.autoplay = true;
			// shutter.src = navigator.userAgent.match(/Firefox/) ? './mod/assets/js/webcamjs/shutter.ogg' : './mod/assets/js/webcamjs/shutter.mp3';

			// function captureimage() {
			// 	var latitude = $('.latitude').html();
			// 	// play sound effect
			// 	shutter.play();
			// 	// take snapshot and get image data
			// 	Webcam.snap(function(data_uri) {
			// 		// display results in page
			// 		Webcam.upload(data_uri, './sw-proses?action=present&latitude=' + latitude + '', function(code, text) {
			// 			$data = '' + text + '';
			// 			var results = $data.split("/");
			// 			$results = results[0];
			// 			$results2 = results[1];
			// 			if ($results == 'success') {
			// 				swal({
			// 					title: 'Berhasil!',
			// 					text: $results2,
			// 					icon: 'success',
			// 					timer: 3500,
			// 				});
			// 				setTimeout("location.href = './';", 3600);
			// 			} else {
			// 				swal({
			// 					title: 'Oops!',
			// 					text: text,
			// 					icon: 'error',
			// 					timer: 3500,
			// 				});
			// 			}
			// 		});
			// 	});
			// }
		</script> -->
		<!-- end lokasi -->

		</body>

		</html>
<?php
	}
} else {
	session_destroy();
	header('Location:index.php?status=Silahkan Login');
}
?>