<?php
ob_start();
include "../config/koneksi.php";
require_once("../dompdf/dompdf_config.inc.php");
include "../config/fungsi_indotgl.php";
$nip 		= isset($_GET['nip']) ? $_GET['nip'] : "";
$kd_cuti 	= isset($_GET['kdcuti']) ? $_GET['kdcuti'] : "";

$query = mysqli_query($mysqli, "select a.nama,a.nip,a.klien,b.n_jab from pegawai a  
	left join jabatan b on a.id_jab=b.kode 
	where nip='$nip'");

$row = mysqli_fetch_array($query);

$query2 = mysqli_query($mysqli, "select *,year(tgl_pengajuan) as tahun from ajuancuti where kdcuti='$kd_cuti'");

$row2 = mysqli_fetch_array($query2);
// mysqli_query($mysqli,"update ajuancuti set cetak='1' where kdcuti='$kd_cuti'");
// reference the Dompdf namespace
// use Dompdf\Dompdf;

// instantiate and use the dompdf class

$html = "
<html>
<body>
<div style='text-align: center;'>
<h1></h1>
</div>
<div style='text-align: right;'>
	<p><i>".tgl_indo($row2['tgl_approve'])."</i></p>
</div>
<div style='text-align: center;'>
	<p>
		<u><i>SURAT IZIN CUTI KARENA ALASAN PENTING</i></u><br>
		Nomor : 
	</p>
</div>
<div style='text-align: left;'>
	<table>
		<tr>
			<td>1.</td>
			<td></td>
			<td colspan='3'>Diberikan cuti bersalin kepada :</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>Nama</td>
			<td>: ".$row['nama']."</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>Nomor Induk Pegawai</td>
			<td>: ".$row['nip']."</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>Pangkat/gol.ruang</td>
			<td>: ".$row['gol']."</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>Jabatan</td>
			<td>: ".$row['n_jab']."</td>
		</tr>
		
		<tr>
			<td></td>
			<td></td>
			<td colspan='2'>Selama <i>".$row2['lama_cuti']." </i> hari, terhitung mulai tanggal <i>".tgl_indo($row2['tgl_mulai'])."</i> sampai dengan tanggal <i>".tgl_indo($row2['tgl_akhir'])."</i> dengan ketentuan sebagai berikut :</td>
		</tr>
		<tr>
			<td></td>
			<td>a. </td>
			<td colspan='2'>
				Sebelum menjalankan cuti karena alasan penting wajib menyerahkan pekerjaannya kepada atasan langsungnya atau pejabat yang ditunjuk.
			</td>
		</tr>
		<tr>
			<td></td>
			<td>b. </td>
			<td colspan='2'>
				Setelah selesai menjalankan cuti karena alasan penting wajib melaporkan diri kepada atasan langsungnya dan bekerja kembali sebagaimana biasa.
			</td>
		</tr>
		<tr>
			<td>2.</td>
			<td></td>
			<td colspan='2'>Demikian surat izin cuti karena alasan penting ini dibuat untuk dapat digunakan sebagaimana mestinya.</td>
		</tr>
		<tr>
			<td colspan='3'></td>
			<td>
				<i>
					Pejabat Cuti<br><br><br><br>
					<br>
					NIP. ......................
				</i>
			</td>
		</tr>
	</table>
</div>
</body>
</html>";
 
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper('A4', 'potrait');
$dompdf->render();
$dompdf->stream('surat_cuti_alasanpenting.pdf');
