<?php

session_start();

// Pengecekan session
if (isset($_SESSION['username']) && isset($_SESSION['leveluser'])) {
	$sesi_username = $_SESSION['username'];
	$sesi_level = $_SESSION['leveluser'];

	// Redirect berdasarkan level user
	switch ($sesi_level) {
		case '1':
			header("Location: media.php");
			exit;
			break;
		case '2':
			header("Location: pegawai.php");
			exit;
			break;
		case '3':
			header("Location: absen.php");
			exit;
			break;
		case '4':
			header("Location: payroll.php");
			exit;
			break;
		case '5':
			header("Location: user.php");
			exit;
			break;
		case '6':
			header("Location: kabag.php");
			exit;
			break;
		case '7':
			header("Location: manager.php");
			exit;
			break;
		case '8':
			header("Location: prinsipal.php");
			exit;
			break;
		default:
			// Jika level tidak sesuai, lakukan sesuatu
			exit;
			break;
	}
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<title>Sistem Kepegawaian CIGS</title>
	<link rel="shortcut icon" href="favicon.ico" />
	<meta name="description" content="User login page" />
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" /> -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

	<!-- bootstrap & fontawesome -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.1.0/css/font-awesome.min.css" />

	<link rel="stylesheet" href="assets/css/select2.css" />
	<!-- text fonts -->
	<link rel="stylesheet" href="assets/fonts/fonts.googleapis.com.css" />

	<!-- ace styles -->
	<link rel="stylesheet" href="assets/css/ace.min.css" />

	<!--[if lte IE 9]>
	<link rel="stylesheet" href="assets/css/ace-part2.min.css" />
	<![endif]-->
	<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />

	<!--[if lte IE 9]>
	<link rel="stylesheet" href="assets/css/ace-ie.min.css" />
	<![endif]-->
	<style>
		.paypalbox {
			position: relative;
			width: 250px;
			height: auto;
			position: fixed;
			bottom: 0;
			left: 60px;
		}

		.tombolpaypal {
			text-align: center;
			text-decoration: none;
			width: 240px;
			height: auto;
			background: #555;
			padding: 5px 5px 15px;
			display: none;
		}

		.paypal {
			background: #efefef;
			border: 0;
			margin: 0 auto;
			padding: 5px 18px;
			font-size: 18px;
			font-weight: 700;
			color: #333;
			text-align: center;
			display: inline-block;
			border-radius: 3px;
		}

		.paypal:hover {
			background: #ddd;
		}

		.paypalheader {
			background: #5090c1;
			border-radius: 3px 3px 0 0;
			margin: 0 auto;
			padding: 8px 23px;
			font-size: 18px;
			font-weight: 700;
			color: #fff;
			text-align: center;
			display: block;
			cursor: pointer;
		}

		.tombolpaypal a {
			text-decoration: none;
		}

		.tombolpaypal p {
			color: #ddd;
			font-size: 14px;
			margin: 5px 0 10px;
		}
	</style>

</head>

<body class="login-layout blur-login" onload="document.forms['login'].elements['username'].focus();">

	<div class="main-container">
		<div class="main-content">
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<div class="login-container">
						<div class="center">
							<h1>
								<i class="fa fa-users green" aria-hidden="true"></i>
								<span class="red">APLIKASI</span><span class="white">CIGS</span>
							</h1>
							<span class="white">
								<h5>Sistem Kepegawaian</h5>
							</span>
						</div>


						<div class="space-6"></div>
						<div id="loading" style="text-align: center"></div>
						<div class="position-relative">
							<div id="login-box" class="login-box visible widget-box no-border">
								<div class="widget-body">
									<div class="widget-main">
										<h4 class="header black lighter bigger">
											<i class="ace-icon fa fa-coffee red"></i>
											Masukkan user dan password
										</h4>

										<div class="space-6"></div>

										<form name="form" id="loginF" method="post" action="" class="form-horizontal">
											<fieldset>
												<div class="form-group">
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" name="username" id="username" value="" class="form-control" placeholder="Username" autocomplete="username" />
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>
												</div>

												<div class="form-group">
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" name="passlogin" value="" id="passlogin" class="form-control" placeholder="Password" autocomplete="current-password" />
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>
												</div>

												<div class="space"></div>

												<div class="clearfix">
													<label class="inline">
														<input type="checkbox" class="ace" />
														<span class="lbl"> Remember Me</span>
													</label>

													<div class="form-group">
														<button class="width-35 pull-right btn btn-sm btn-primary">
															<i class="ace-icon fa fa-key"></i>
															<span class="bigger-110">Login</span>
														</button>
													</div>
												</div>
											</fieldset>
										</form>

										<?php
										include "config/koneksi.php";
										$q_nm_pt = mysqli_query($mysqli, "SELECT nm_pt FROM master WHERE id='1'");
										if (!$q_nm_pt) {
											// Log error atau tampilkan pesan yang lebih aman
											error_log("Error: " . mysqli_error($mysqli));
											die("Terjadi kesalahan, silakan coba lagi nanti.");
										}
										// $q_nm_pt	    = mysqli_query($mysqli, "SELECT nm_pt FROM master WHERE id='1'") or die("Error: " . mysqli_error($mysqli));
										$a_nm_pt	    = mysqli_fetch_array($q_nm_pt);

										echo "<h4 class='blue'>&copy; $a_nm_pt[0]</h4>";
										?>
										<div class="social-or-login center">
											<span class="bigger-110">Contact Person</span>
										</div>

										<div class="space-6"></div>


									</div><!-- /.widget-main -->

									<div class="toolbar clearfix">
										<div>
											<a href="forgot.php" class="forgot-password-link">
												<i class="ace-icon fa fa-arrow-left"></i>
												Lupa Password
											</a>
										</div>

										<div>
											<a href="register.php" class="user-signup-link">
												Daftar
												<i class="ace-icon fa fa-arrow-right"></i>
											</a>
										</div>
									</div>
								</div><!-- /.widget-body -->
							</div><!-- /.login-box -->






						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.main-content -->
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="assets/js/jquery.2.1.1.min.js"></script>

		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/jquery.validate.min.js"></script>

		<!-- <![endif]-->
		<?php include "config/fungsi_login.php" ?>
		<!--[if IE]>
<script src="assets/js/jquery.1.11.1.min.js"></script>
<![endif]-->

		<!--[if IE]>
<script type="text/javascript">
	window.jQuery || document.write("<script src='assets/js/jquery1x.min.js'>"+"<"+"/script>");
</script>
<![endif]-->
		<script type="text/javascript">
			// Perbaikan kode untuk memuat script secara dinamis tanpa menggunakan document.write

			if ('ontouchstart' in document.documentElement) {
				var script = document.createElement('script');
				script.src = 'assets/js/jquery.mobile.custom.min.js';
				document.head.appendChild(script);
			}
			// if ('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
		</script>




		<!-- inline scripts related to this page -->
</body>

</html>