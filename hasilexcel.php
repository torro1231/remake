<?php
session_start();
error_reporting(0);
$sesi_username            = isset($_SESSION['username']) ? $_SESSION['username'] : NULL;
$sesi_level                = isset($_SESSION['leveluser']) ? $_SESSION['leveluser'] : NULL;
if ($sesi_level != '1' && $sesi_level != '2') {
    header('location:index.php');
}
include "config/koneksi.php";
if (isset($_POST['exportexcel'])) {
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=hasil.xls");
    $p_awal          = isset($_POST['awal']) ? $_POST['awal'] : "";
    $p_akhir          = isset($_POST['akhir']) ? $_POST['akhir'] : "";
    $penempatan             = isset($_POST['penempatan']) ? $_POST['penempatan'] : "";

    $query = "SELECT id_absensi,absensi.id_ijin,d.nm_ijin,absensi.nip,absensi.penempatan,b.nama,tanggal_absen,c.shift,jam_in,c.jam_masuk,jam_out,c.jam_pulang, TIMESTAMPDIFF(HOUR,c.jam_pulang,jam_out)as lembur_jam,TIMEDIFF(jam_out,c.jam_pulang)as lembur,status_masuk,status_keluar,terlambat,pulangcepat,ket,TIMEDIFF(jam_in,c.jam_masuk)as jam_telat, TIMEDIFF(c.jam_pulang,jam_out)as jam_p_cepat from absensi 
	LEFT JOIN pegawai b ON absensi.nip = b.nip
	LEFT JOIN tbl_absen c ON absensi.id_abs = c.id_abs 
	LEFT JOIN tbl_ijin d ON absensi.id_ijin=d.id_ijin 
	WHERE tanggal_absen BETWEEN '$p_awal' AND '$p_akhir' AND penempatan='$penempatan'
	ORDER BY nama AND tanggal_absen ASC ";

    $hasil = mysqli_query($mysqli, $query);
    $j_data = mysqli_num_rows($hasil);
    echo "<div style='padding:5px;overflow: auto;height: 400px ;border:1px class='table-responsive'>";

    echo "<table id='sample-table-1' class='table table-striped table-bordered table-hover'>";
    // Head Edit
    echo "<tr><b>
    <td>No</td>
    <td>NIP</td>
    <td>Nama</td>
    <td>Penempatan</td>
    <td>Tanggal Absen</td>
    <td>Jam In</td>
    <td>Jam Out</td>
    </b></tr>";
    // end Edit
    if ($hasil == 0) {
        echo "<tr><td id='tengah' colspan='12'>-- Tidak Ada Data --</td></tr>";
    } else {
        $no = 1;
        while ($data = mysqli_fetch_array($hasil)) {
            echo "<div>
            <tr>
            <td>$no</td>
            <td>" . $data[3] . "</td>
            <td>" . $data[5] . "</td>
            <td>" . $data[4] . "</td>
            <td>" . $data[6] . "</td>
            <td>" . $data[8] . "</td>
            <td>" . $data[10] . "</td>
            
            </div>";
            $no++;
        }
    }
    echo "</table></div>Jumlah data yang di cari : $j_data ";
}
