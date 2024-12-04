<?php
error_reporting(0);

$mod = $_GET['mod'] ?? NULL;

if ($mod == "del") {
    $q_del = mysqli_query($mysqli, "DELETE FROM tbl_jatahcuti");

    echo $q_del > 0
        ? "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'><i class='icon-remove'></i></button><strong><i class='icon-ok'></i>BERHASIL</strong> Data Jatah Cuti Pegawai Berhasil dihapus<br/></div>"
        : "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><i class='icon-remove'></i></button><strong><i class='icon-remove'></i>MAAF!</strong>" . mysqli_error($mysqli) . "<br/></div>";
} elseif (isset($_POST['tahun'])) {
    $tahun = $_POST['tahun'];
    $cektbl_jatah = mysqli_query($mysqli, "SELECT tahun FROM tbl_jatahcuti WHERE tahun = $tahun");
    
    if (mysqli_num_rows($cektbl_jatah) > 0) {
        echo "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><i class='icon-remove'></i></button><strong><i class='icon-remove'></i>MAAF!</strong> Jatah Cuti Tahun ini sudah dibuat </div>";
    } else {
        $cekjatah = mysqli_query($mysqli, "SELECT jatah_cuti FROM tbl_cuti WHERE id_cuti = '1'");
        $lamacuti = mysqli_fetch_array($cekjatah)[0];

        $querypeg = mysqli_query($mysqli, "SELECT nip FROM pegawai WHERE kdstatusp NOT IN ('0', '4')");
        while ($rowquerypeg = mysqli_fetch_assoc($querypeg)) {
            $nippeg = $rowquerypeg['nip'];
            $sql = mysqli_query($mysqli, "INSERT INTO tbl_jatahcuti VALUES ('', '$nippeg', '$lamacuti', '', '', '$tahun')");
        }

        echo $sql > 0
            ? "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'><i class='icon-remove'></i></button><strong><i class='icon-ok'></i>BERHASIL</strong> Membuat Jatah Cuti di tahun ini<br/></div>"
            : "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><i class='icon-remove'></i></button><strong><i class='icon-remove'></i>MAAF!</strong>" . mysqli_error($mysqli) . "<br/></div>";
    }
}

$sesi_username = $_SESSION['username'] ?? NULL;

if ($sesi_username && ($_SESSION['leveluser'] == '1' || $_SESSION['leveluser'] == '3')) {
?>

<div class="row">
    <div class="col-xs-12">
        <h3 class="header smaller lighter blue">Data Jatah Cuti</h3>
        <div class="col-xs-12">
            <a href="cetak/lap_jatahcuti.php" class="btn btn-danger" target="_blank">Cetak PDF</a>
            <a href="?id=datajatah&mod=del" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin menghapus semua Jatah Cuti?')">Hapus Semua</a>
            <button class="btn btn-info" data-toggle="modal" data-target="#modalCreateJatah">Buat Jatah</button>
            <!-- <button class="btn btn-success" data-toggle="modal" data-target="#modalCreateJatahNama">Buat Jatah Pernama</button> -->
        </div>

        <div class="table-header">Jatah Cuti</div>
        <div class="table-responsive">
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Jatah Cuti</th>
                        <th>Cuti Diambil</th>
                        <th>Sisa Cuti</th>
                        <th class="hidden-480">Tahun</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data tabel akan diisi di sini -->
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modalCreateJatah">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title">Masukkan Tahun</h5>
                </div>
                <form action="?id=datajatah" method="post" class="form-horizontal">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="tahun">Tahun</label>
                            <div class="col-sm-5">
                                <input type="text" name="tahun" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Buat Jatah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- <div class="modal fade" id="modalCreateJatahNama">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title">Masukkan Data</h5>
                </div>
                <form action="?id=datajatah" method="post" class="form-horizontal">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="tahun">Tahun Kontrak</label>
                            <div class="col-sm-5">
                                <input type="text" name="tahunKontrak" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="nama">Nama</label>
                            <div class="col-sm-5">
                                <input type="text" name="nama" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Buat Jatah</button>
                    </div>
                </form>
            </div>
        </div>
    </div> -->
</div>

<?php
} else {
    echo "<script>alert('Mohon maaf, Anda tidak memiliki akses ke halaman ini'); window.location = '../index.php';</script>";
}
?>