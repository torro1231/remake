<?php
$id_cuti = $_GET['kdcuti'] ?? NULL;
$mod = $_GET['mod'] ?? NULL;

// Data form (POST)
$display = "style='display: none'";
$tb_act = $_POST['tb_act'] ?? NULL;
$p_kd_cuti = $_POST['kdcuti'] ?? NULL;
$p_kd_approve = $_POST['kd_approve'] ?? NULL;
$p_id_cuti = $_POST['id_cuti'] ?? NULL;
$p_pesan_approve = $_POST['pesan'] ?? NULL;
$nip_u = $_POST['nip'] ?? NULL;
$tgl_awal = $_POST['tgl_awal'] ?? NULL;
$tgl_akhir = $_POST['tgl_akhir'] ?? NULL;
$lama = $_POST['lama'] ?? NULL;
$alasan = $_POST['alasan'] ?? NULL;

// Hitung jatah cuti
$queryjatahcuti = mysqli_query($mysqli, "SELECT * FROM tbl_jatahcuti WHERE nip='$nip_u'");
$rowjatah = mysqli_fetch_array($queryjatahcuti);
$jatahcuti = $rowjatah['jatahcuti'];
$cutiambil = $rowjatah['cutiambil'];
$sisacuti = $rowjatah['sisacuti'];
$hasilcutidiambil = $cutiambil + $lama;
$hasilsisa = $jatahcuti - $hasilcutidiambil;

// Hapus data cuti
if ($mod == "del") {
    $q_del = mysqli_query($mysqli, "DELETE FROM ajuancuti WHERE kdcuti='$id_cuti'");
    echo $q_del ? 
        "<div class='alert alert-info'><strong>BERHASIL</strong> Data Cuti Pegawai Berhasil dihapus</div>" : 
        "<div class='alert alert-error'><strong>MAAF!</strong>" . mysqli_error($mysqli) . "</div>";
}

// Konfirmasi data cuti
if ($tb_act == "Konfirmasi") {
    $querycek = "SELECT * FROM ajuancuti WHERE nip='$nip_u' AND tgl_mulai='$tgl_awal' AND tgl_akhir='$tgl_akhir' AND kd_approve='1'";
    $ketemu = mysqli_num_rows(mysqli_query($mysqli, $querycek));

    if ($ketemu > 0) {
        echo "<div class='alert alert-danger'><strong>MAAF!</strong> Anda sudah Approve data ini sebelumnya</div>";
    } else {
        $update_cuti = "UPDATE ajuancuti SET kd_approve='$p_kd_approve', tgl_approve=NOW(), pesan_approve='$p_pesan_approve', kdnotif='1' WHERE kdcuti='$p_kd_cuti'";
        $q_edit_cuti = mysqli_query($mysqli, $update_cuti);

        if ($p_kd_approve == 1 && $p_id_cuti == 1 && $_SESSION['leveluser'] == '1') {
            mysqli_query($mysqli, "UPDATE tbl_jatahcuti SET cutiambil='$hasilcutidiambil', sisacuti='$hasilsisa' WHERE tahun=YEAR(NOW()) AND nip='$nip_u'");
        }

        echo $q_edit_cuti ? 
            "<div class='alert alert-success'><strong>BERHASIL</strong> Data Cuti Berhasil dikonfirmasi</div>" : 
            "<div class='alert alert-danger'><strong>MAAF!</strong>" . mysqli_error($mysqli) . "</div>";
    }
}

// Cek sesi user
$sesi_username = $_SESSION['username'] ?? NULL;
if ($sesi_username && in_array($_SESSION['leveluser'], ['1', '3', '6', '7'])) {
?>

<div class="row">
    <div class="col-xs-12">
        <h3>Data Cuti Pegawai</h3>
        <a href="?id=inputcuti" class="btn btn-success">Input Cuti</a>
        <a href="?id=rekapcuti" class="btn btn-danger">Rekap Cuti</a>
        <a href="?id=datajatah" class="btn btn-warning">Jatah Cuti</a>
        <div class="table-header">Semua Daftar</div>
        <table id="sample-table-2" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>NIP</th>
                    <th>NAMA</th>
                    <th>TANGGAL</th>
                    <th>CUTI</th>
                    <th>Tanggal Awal</th>
                    <th>Tanggal Akhir</th>
                    <th>Lama Cuti</th>
                    <th>Alasan</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<?php
} else {
    echo "<script>alert('Mohon Maaf anda tidak bisa akses halaman ini'); window.location = '../index.php'</script>";
}
?>
