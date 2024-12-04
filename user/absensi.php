<?php
error_reporting(0);
$sesi_username			= isset($_SESSION['username']) ? $_SESSION['username'] : NULL;
if ($sesi_username != NULL || !empty($sesi_username) || $_SESSION['leveluser'] == '5') {
	date_default_timezone_set('Asia/Jakarta');
	$date         	= date("Y-m-d");
	$day          	= date("D");
	$date_sekarang 	= tgl_indo($date);
	$day_date      	= $date_sekarang;
	$waktu      	= gmdate('H:i', gmdate('U') + 25200);


	$Q_absen = mysqli_query($mysqli, "select * from absensi where nip='$nip' and tanggal_absen='$date'");
	$d_absen = mysqli_fetch_array($Q_absen);
	$id_abs	= $d_absen['id_abs'];
	$jam_in	= $d_absen['jam_in'];
	$jam_out = $d_absen['jam_out'];


	$querysetabsen = mysqli_query($mysqli, "SELECT * FROM master");
	$datasetabsensi = mysqli_fetch_array($querysetabsen);

	if ($datasetabsensi['absensi'] == 'Y') {



?>

		<div class="col-xs-6 col-sm-4 pricing-box">
			<div class="widget-box widget-color-orange">
				<div class="widget-header">
					<h5 class="widget-title bigger lighter"><?php echo "$day_date"; ?></h5>
				</div>
				<?php
				$p_nip = isset($_POST['nip']) ? $_POST['nip'] : "";
				$p_shift = isset($_POST['shift']) ? $_POST['shift'] : "";
				$Q_penempatan = mysqli_query($mysqli, "select * from pegawai where nip='$nip'");
				$d_penempatan = mysqli_fetch_array($Q_penempatan);
				$p_penempatan = $d_penempatan['klien'];
				$nama = $d_penempatan['nama'];
				$Q_shift = mysqli_query($mysqli, "select * from tbl_absen where id_abs='$p_shift'");
				$d_shift = mysqli_fetch_array($Q_shift);
				$jam_masuk  = $d_shift['jam_masuk'];
				$jam_keluar = $d_shift['jam_pulang'];
				// $lokasiAbsen = "-6.335508,106.869043";
				// $lokasiKantor = "-6.335508,106.869043";
				$lokasiAbsen = isset($_POST['lokasiAbsen']) ? $_POST['lokasiAbsen'] : "";
				$lokasiKantor = isset($_POST['lokasiKantor']) ? $_POST['lokasiKantor'] : "";
				$lokKantor = explode(',', $lokasiKantor);
				$lokUser = explode(',', $lokasiAbsen);
				$latKantor = $lokKantor[0];
				$longKantor = $lokKantor[1];
				$latUser = $lokUser[0];
				$longUser = $lokUser[1];

				//Menghitung Jarak
				function distance($lat1, $lon1, $lat2, $lon2)
				{
					$theta = $lon1 - $lon2;
					$miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
					$miles = acos($miles);
					$miles = rad2deg($miles);
					$miles = $miles * 60 * 1.1515;
					$feet = $miles * 5280;
					$yards = $feet / 3;
					$kilometers = $miles * 1.609344;
					$meters = $kilometers * 1000;
					return compact('meters');
				}



				if ($waktu > $jam_masuk) {
					$terlambat = "Y";
				} else {
					$terlambat = "N";
				}


				$Q_radius = mysqli_query($mysqli, "select * from klien where n_klien ='$p_penempatan'");
				$R_radius = mysqli_fetch_assoc($Q_radius);



				$jarak = distance($latKantor, $longKantor, $latUser, $longUser);

				if (isset($_POST['absen_masuk'])) {

					$radius = round($jarak['meters']);
					if ($radius > $R_radius['radius_absen']) {

						echo "<div class='alert alert-danger'>Anda Berada $radius meter dari Radius Kantor !!!</div>";
					} else {
						if ($lokasiAbsen == 0) {
							echo "<div class='alert alert-danger'>Lokasi Anda Tidak Terditeksi !!!</div>";
						} else {
							if ($p_shift == 0) {
								echo "<div class='alert alert-danger'>Shift Belum di isi !!!</div>";
							} else {
								$hari_ini = new DateTime();
								$kemarin = $hari_ini->modify('-1 day');
								$tanggal_kemarin = $kemarin->format('Y-m-d');

								$Q_cek = mysqli_query($mysqli, "select jam_out from absensi where nip='$nip' and tanggal_absen='$tanggal_kemarin'");
								$d_cek = mysqli_fetch_assoc($Q_cek);
								$Q_cek4 = mysqli_query($mysqli, "select jam_out from absensi where nip='$nip' and tanggal_absen='$date'");
								$d_cek4 = mysqli_fetch_assoc($Q_cek4);

								if ($d_cek['jam_out'] == '00:00:00') {
									echo "<div class='alert alert-danger'>Anda belum Absen pulang Pada Tanggal $tanggal_kemarin !!!</div>";
								} else {
									if ($d_cek4 > 0) {

										echo "<div class='alert alert-danger'>Anda Sudah Absen Pada Tanggal $date  !!!</div>";
									} else {
										$query_in = mysqli_query($mysqli, "INSERT into absensi values (0,'$p_shift',0,'$date','$waktu',0,'Y','Y','Y','$terlambat','Y','$p_nip','$p_penempatan',NOW(),'$lokasiAbsen','$lokasiKantor')");
										if ($query_in > 0) {
											echo "<div class='alert alert-info'>Berhasil Absen Masuk, Selamat Bekerja $nama !!!</div>";
										} else {
											echo "<div class='alert alert-danger'>" . mysqli_error($mysqli) . "</div>";
										}
									}
								}
							}
						}
					}
				}


				?>
				<div class="widget-body">
					<form action="" class="form-horizontal" method="POST">
						<div class="widget-main">
							<ul class="list-unstyled spaced2">
								<div class="form-group">

									<label class="col-sm-3 control-label no-padding-right" for="form-field-username">NIP <?php echo "$Q_lok[radius_absen]"; ?></label>
									<div class="col-sm-5">
										<input class="col-xs-12 col-sm-10" type="text" readonly="readonly" id="nip" name="nip" value="<?php echo "$nip"; ?>" />

									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-penempatan">PENEMPATAN</label>
									<div class="col-sm-5">
										<input class="col-xs-12 col-sm-10" type="text" readonly="readonly" id="penempatan" name="penempatan" value="<?php echo "$p_penempatan"; ?>" />
									</div>
								</div>



								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-username">JAM MASUK</label>
									<div class="col-sm-5">
										<input class="col-xs-12 col-sm-10" type="text" readonly="readonly" id="jam_in" name="jam_in" value="<?php echo "$jam_in" ?>" />


									</div>
								</div>


								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="cuti">SHIFT</label>
									<div class="col-sm-9">
										<select name="shift" value="0" id="shift">
											<option value="" selected>-- Pilih Shift--</option>
											<?php
											$q = mysqli_query($mysqli, "select * from tbl_absen where t_tugas='$p_penempatan'");

											while ($a = mysqli_fetch_array($q)) {
												echo "<option value='$a[0]' >$a[1]</option>";
											}
											?>
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-username">CURRENT TIME</label>
									<div class="col-sm-5">

										<span id="the-time2">00:00:00</span>

									</div>
								</div>

								<div class="form-group">

									<div class="col-sm-5">
										<input class="col-xs-12 col-sm-10" type="hidden" readonly id="lokasiAbsen" name="lokasiAbsen" />
									</div>
									<div class="col-sm-5">
										<?php
										$Q_koor = mysqli_query($mysqli, "select * from klien where n_klien ='$p_penempatan'");
										$Q_lok = mysqli_fetch_assoc($Q_koor);
										?>
										<input class="col-xs-12 col-sm-10" type="hidden" readonly id="lokasiKantor" name="lokasiKantor" value="<?php echo "$Q_lok[koor_klien]" ?>" />
									</div>
								</div>

							</ul>

						</div>

						<div>

							<input type="submit" name="absen_masuk" class="btn btn-block btn-warning" value="Absen Masuk" onclick="return confirm(' Apakah Anda Yakin ?')" title="Silahkan Klik Disini Untuk Absen Masuk" />

						</div>
					</form>
				</div>
			</div>
		</div>



		<div class="col-xs-6 col-sm-4 pricing-box">
			<div class="widget-box widget-color-blue">
				<div class="widget-header">
					<h5 class="widget-title bigger lighter"><?php echo "$day_date"; ?></h5>
				</div>
				<?php
				$p_nip2 = isset($_POST['nip2']) ? $_POST['nip2'] : "";
				if ($waktu > $jam_keluar) {
					$pulang_cepat = "Y";
				} else {
					$pulang_cepat = "N";
				}

				$hari_ini = new DateTime();
				$kemarin = $hari_ini->modify('-1 day');
				$tanggal_kemarin = $kemarin->format('Y-m-d');

				if (isset($_POST['absen_keluar'])) {

					$Q_cek2 = mysqli_query($mysqli, "select * from absensi where nip='$nip' and tanggal_absen='$date'");
					$d_cek2 = mysqli_fetch_array($Q_cek2);
					$Q_cek3 = mysqli_query($mysqli, "select * from absensi where nip='$nip' and tanggal_absen='$tanggal_kemarin'");
					$d_cek3 = mysqli_fetch_array($Q_cek3);

					if ($d_cek3['jam_out'] == '00:00:00') {
						$query_out = mysqli_query($mysqli, "update absensi set jam_out='$waktu',pulangcepat='$pulang_cepat',status_keluar='Y',time_update=now() where tanggal_absen='$tanggal_kemarin' and nip='$nip' ");
						if ($query_out > 0) {
							echo "<div class='alert alert-info'>Berhasil !!!</div>";
						}
					} else {
						if ($d_cek2['jam_out'] == '00:00:00') {
							$query_out = mysqli_query($mysqli, "update absensi set jam_out='$waktu',pulangcepat='$pulang_cepat',status_keluar='Y',time_update=now() where tanggal_absen='$date' and nip='$nip' ");
							if ($query_out > 0) {
								echo "<div class='alert alert-info'>Berhasil !!!</div>";
							} else {
								echo "<div class='alert alert-danger'>" . mysqli_error($mysqli) . "</div>";
							}
						} else {
							echo "<div class='alert alert-danger'>Anda sudah absen Pulang !!!</div>";
						}
					}
				}



				?>

				<div class="widget-body">
					<form action="" class="form-horizontal" method="POST">
						<div class="widget-main">
							<ul class="list-unstyled spaced2">
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-username">NIP</label>
									<div class="col-sm-5">
										<input class="col-xs-12 col-sm-10" type="text" readonly="readonly" id="nip2" name="nip2" value="<?php echo "$nip" ?>" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-penempatan">PENEMPATAN</label>
									<div class="col-sm-5">
										<input class="col-xs-12 col-sm-10" type="text" readonly="readonly" id="penempatan" name="penempatan" value="<?php echo "$p_penempatan"; ?>" />
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-username">JAM KELUAR</label>
									<div class="col-sm-5">
										<input class="col-xs-12 col-sm-10" type="text" readonly="readonly" id="jam_in" name="jam_in" value="<?php echo "$jam_out" ?>" />


									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-username">SHIFT</label>
									<div class="col-sm-5">
										<select name="shift" value="" id="shift" disabled>
											<?php
											$q2 = mysqli_query($mysqli, "select * from tbl_absen");

											while ($a2 = mysqli_fetch_array($q2)) {
												if ($a2['0'] == $id_abs) {
													echo "<option value='$a2[0]' selected>$a2[1]</option>";
												} else {
													echo "<option value='$a2[0]'>$a2[1]</option>";
												}
											}
											?>
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-username">CURRENT TIME</label>
									<div class="col-sm-5">
										<span id="the-time3">00:00:00</span>
									</div>
								</div>


							</ul>


						</div>

						<div>

							<input type="submit" name="absen_keluar" class="btn btn-block btn-primary" onclick="return confirm('Apakah Anda Yakin ?')" value="Absen Keluar" Title="Silahkan Klik Disini Untuk Absen Keluar" />

						</div>
					</form>
				</div>


			</div>

		</div>





<?php
	} else {
		echo "<div class='alert alert-danger'>Maaf Halaman Disabled Admin</div>";
	}
} else {
	header('Location:../index.php?status=Silahkan Login');
}
?>