<?php
// Validasi sesi pengguna
$sesi_username = $_SESSION['username'] ?? NULL;
$sesi_level = $_SESSION['leveluser'] ?? NULL;

if (!in_array($sesi_level, ['1', '3'])) {
    header('Location: ../index.php');
    exit;
}

// Inisialisasi variabel input
$mode_form   = $_GET['mod'] ?? "";
$p_idcuti    = $_POST['id_cuti'] ?? "";
$p_tombol    = $_POST['tb_act'] ?? "";
$p_tglawal   = $_POST['tgl_awal'] ?? "";
$p_tglakhir  = $_POST['tgl_akhir'] ?? "";
$p_lama      = $_POST['lama'] ?? "";
$p_alasan    = $_POST['alasan'] ?? "";
$p_nip       = $_POST['nipp'] ?? "";
$p_kd_approve = $_POST['kd_approve'] ?? "";

// Proses pengajuan cuti
if ($p_tombol === "SIMPAN") {
    if (empty($p_idcuti) || empty($p_tglawal) || empty($p_tglakhir) || empty($p_lama) || empty($p_alasan)) {
        echo "<div class='alert alert-danger'>Form isian masih belum lengkap, mohon dilengkapi.</div>";
    } else {
        $q_cari_id = mysqli_query($mysqli, "SELECT id FROM pegawai WHERE nip='$p_nip'");
        $c_id_pegawai = mysqli_fetch_array($q_cari_id)[0];

        $q_cek_ganda = mysqli_query($mysqli, "SELECT * FROM ajuancuti WHERE tgl_mulai='$p_tglawal' AND id='$c_id_pegawai'");
        if (mysqli_fetch_array($q_cek_ganda)) {
            echo "<div class='alert alert-danger'>Tanggal $p_tglawal Anda sudah mengajukan cuti.</div>";
        } else {
            if ($p_idcuti == 1) {
                $q_sisa_cuti = mysqli_query($mysqli, "SELECT sisa_cuti FROM tbl_jatahcuti WHERE nip='$p_nip'");
                $sisa_cuti = mysqli_fetch_array($q_sisa_cuti)['sisa_cuti'];

                $q_tgl_masuk = mysqli_query($mysqli, "SELECT tgl_masuk FROM pegawai WHERE nip='$p_nip'");
                $tahunkerja = MasaKerjaTahun(mysqli_fetch_array($q_tgl_masuk)[0], $tahunM, $bulanM, $tanggalM);

                if ($tahunkerja < 1) {
                    echo "<div class='alert alert-danger'>Masa kerja Anda belum 1 tahun, tidak bisa mengajukan cuti tahunan.</div>";
                } elseif ($p_lama > 12) {
                    echo "<div class='alert alert-danger'>Lama cuti tahunan tidak boleh lebih dari 12 hari.</div>";
                } elseif ($sisa_cuti < $p_lama) {
                    echo "<div class='alert alert-danger'>Lama cuti yang diajukan melebihi sisa cuti Anda.</div>";
                } else {
                    $q_daftar = mysqli_query($mysqli, "INSERT INTO ajuancuti (kdcuti, id, id_cuti, tgl_pengajuan, tgl_mulai, tgl_akhir, lama_cuti, alasan, kd_approve, nip) 
                        VALUES ('', '$c_id_pegawai', '$p_idcuti', NOW(), '$p_tglawal', '$p_tglakhir', '$p_lama', '$p_alasan', '3', '$p_nip')");

                    echo $q_daftar 
                        ? "<div class='alert alert-success'>Pengajuan cuti Anda berhasil disimpan.</div>" 
                        : "<div class='alert alert-danger'>Terjadi kesalahan: " . mysqli_error($mysqli) . "</div>";
                }
            } else {
                $q_daftar = mysqli_query($mysqli, "INSERT INTO ajuancuti (kdcuti, id, id_cuti, tgl_pengajuan, tgl_mulai, tgl_akhir, lama_cuti, alasan, kd_approve, nip) 
                    VALUES ('', '$c_id_pegawai', '$p_idcuti', NOW(), '$p_tglawal', '$p_tglakhir', '$p_lama', '$p_alasan', '$p_kd_approve', '$p_nip')");

                echo $q_daftar 
                    ? "<div class='alert alert-success'>Pengajuan cuti Anda berhasil disimpan.</div>" 
                    : "<div class='alert alert-danger'>Terjadi kesalahan: " . mysqli_error($mysqli) . "</div>";
            }
        }
    }
}
?>


    <div class="col-sm-12">
    <div class="tabbable">
        <ul class="nav nav-tabs" id="myTab">
            <li class="active">
                <a data-toggle="tab" href="#pl">
                    <i class="ace-icon fa fa-pencil-square-o bigger-160"></i>
                    Form Input Cuti
                </a>
            </li>
        </ul>

        <div class="tab-content profile-edit-tab-content">
            <div id="pl" class="tab-pane fade in active">
                <form class="form-horizontal" action="" method="post" role="form">

                    <!-- Tanggal Awal Cuti -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">Tanggal Awal Cuti:</label>
                        <div class="col-xs-8 col-sm-3">
                            <div class="input-group">
                                <input class="form-control date-picker" name="tgl_awal" id="tgl_awal" type="text" data-date-format="yyyy-mm-dd" />
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar bigger-110"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Tanggal Akhir Cuti -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">Tanggal Akhir Cuti:</label>
                        <div class="col-xs-8 col-sm-3">
                            <div class="input-group">
                                <input class="form-control date-picker" name="tgl_akhir" id="tgl_akhir" type="text" data-date-format="yyyy-mm-dd" />
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar bigger-110"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Lama Cuti -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">Lama Cuti:</label>
                        <div class="col-sm-9">
                            <input class="input-medium" type="text" name="lama" id="lama" readonly placeholder="Jumlah hari" />
                        </div>
                    </div>

                    <!-- Jenis Cuti -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">Jenis Cuti:</label>
                        <div class="col-sm-9">
                            <select name="id_cuti" id="id_cuti">
                                <option value="">-- Pilih Cuti --</option>
                                <?php
                                $q = mysqli_query($mysqli, "SELECT * FROM tbl_cuti");
                                while ($a = mysqli_fetch_array($q)) {
                                    $selected = ($a['0'] == $p_idcuti) ? 'selected' : '';
                                    echo "<option value='{$a[0]}' $selected>{$a[1]}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- NIP -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">NIP:</label>
                        <div class="col-xs-3 col-sm-2">
                            <div class="input-group">
                                <input type="text" class="form-control search_keyword" name="nipp" id="search_keyword_id" placeholder="Ketikkan NIP pegawai..." required />
                                <input type="text" class="form-control" name="nama" id="search_keyword_name" readonly />
                                <span id="result"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Alasan -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">Alasan:</label>
                        <div class="col-xs-20 col-sm-9">
                            <textarea id="alasan" maxlength="200" name="alasan" class="form-control"></textarea>
                        </div>
                    </div>

                    <!-- Konfirmasi -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">Konfirmasi:</label>
                        <div class="col-sm-9">
                            <select name="kd_approve" id="kd_approve">
                                <option>-- Pilih --</option>
                                <?php
                                $q = mysqli_query($mysqli, "SELECT * FROM status_app");
                                while ($a = mysqli_fetch_array($q)) {
                                    $selected = ($a['0'] == $c['10']) ? 'selected' : '';
                                    echo "<option value='{$a[0]}' $selected>{$a[1]}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right"></label>
                        <div>
                            <input type="submit" class="btn btn-info" name="tb_act" value="SIMPAN" />
                            <a href="?id=datacuti" class="btn btn-danger">Kembali</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
