<?php
error_reporting(0);
$sesi_username            = isset($_SESSION['username']) ? $_SESSION['username'] : NULL;
if ($sesi_username != NULL || !empty($sesi_username) || $_SESSION['leveluser'] == '1' || $_SESSION['leveluser'] == '3') {
?>

    <div class="col-xs-12 col-sm-6 widget-container-col">
        <div class="widget-box widget-color-red">
            <div class="widget-header widget-header-small">
                <h6 class="widget-title">
                    <i class="ace-icon fa fa-sort"></i>
                    Rekapitulasi Berdasarkan Tanggal Absensi
                </h6>

                <div class="widget-toolbar">
                    Klik disini

                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-plus" data-icon-show="fa-plus" data-icon-hide="fa-minus"></i>
                    </a>

                    <a href="#" data-action="close">
                        <i class="ace-icon fa fa-times"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">

                    <form action="cetak/lap_absensirekapharian.php" target="_blank" class="form-horizontal" method="POST">
                        <div class="widget-main">
                            <ul class="list-unstyled spaced2">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-username">Tanggal</label>
                                    <div class="col-sm-3">

                                        <input class="col-xs-12 date-picker" id="id-date-picker-1" name="awal" type="text" data-date-format="yyyy-mm-dd" />

                                    </div>
                                    <label class="col-sm-1 control-label no-padding-right" for="form-field-username">s/d</label>
                                    <div class="col-sm-3">
                                        <input class="col-xs-12 date-picker" id="id-date-picker-1" name="akhir" type="text" data-date-format="yyyy-mm-dd" />

                                    </div>
                                </div>



                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-username">Tanda Tangan</label>
                                    <div class="col-sm-5">
                                        <input class="col-xs-12 " id="ttd" name="ttd" type="text" placeholder="Isikan nama " />

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-username"></label>
                                    <div class="col-sm-5">

                                        <input type="submit" name="hari" class="btn btn-info" value="Cetak" />
                                    </div>
                                </div>

                            </ul>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-6 widget-container-col">
        <div class="widget-box widget-color-red">
            <div class="widget-header widget-header-small">
                <h6 class="widget-title">
                    <i class="ace-icon fa fa-sort"></i>
                    Rekapitulasi Berdasarkan Tanggal Per-Klien
                </h6>

                <div class="widget-toolbar">
                    Klik disini

                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-plus" data-icon-show="fa-plus" data-icon-hide="fa-minus"></i>
                    </a>

                    <a href="#" data-action="close">
                        <i class="ace-icon fa fa-times"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">

                    <form action="cetak/lap_absensirekapklien.php" target="_blank" class="form-horizontal" method="POST">
                        <div class="widget-main">
                            <ul class="list-unstyled spaced2">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-username">Tanggal</label>
                                    <div class="col-sm-3">

                                        <input class="col-xs-12 date-picker" id="id-date-picker-1" name="awal" type="text" data-date-format="yyyy-mm-dd" />

                                    </div>
                                    <label class="col-sm-1 control-label no-padding-right" for="form-field-username">s/d</label>
                                    <div class="col-sm-3">
                                        <input class="col-xs-12 date-picker" id="id-date-picker-1" name="akhir" type="text" data-date-format="yyyy-mm-dd" />

                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Penempatan :</label>
                                    <div class="col-sm-9">

                                        <select name="penempatan" value="">
                                            <option>-- Penempatan --</option>
                                            <?php
                                            $q = mysqli_query($mysqli, "select * from klien order by n_klien");

                                            while ($a = mysqli_fetch_array($q)) {
                                                if ($a[1] == $p_penempatan) {
                                                    echo "<option value='$a[2]' selected>$a[2]</option>";
                                                } else {
                                                    echo "<option value='$a[2]'>$a[2]</option>";
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>

                                </div>
                                <!-- <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-username">Tanda Tangan</label>
                                    <div class="col-sm-5">
                                        <input class="col-xs-12 " id="ttd" name="ttd" type="text" placeholder="Isikan nama " />

                                    </div>
                                </div> -->

                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-username"></label>
                                    <div class="col-sm-5">

                                        <input type="submit" name="hariklien" class="btn btn-info" value="Cetak" />
                                    </div>
                                </div>

                            </ul>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>



    <div class="col-xs-12 col-sm-6 widget-container-col">
        <div class="widget-box widget-color-red">
            <div class="widget-header widget-header-small">
                <h6 class="widget-title">
                    <i class="ace-icon fa fa-sort"></i>
                    Rekapitulasi Berdasarkan Bulan Absensi
                </h6>

                <div class="widget-toolbar">
                    Klik disini

                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-plus" data-icon-show="fa-plus" data-icon-hide="fa-minus"></i>
                    </a>

                    <a href="#" data-action="close">
                        <i class="ace-icon fa fa-times"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">

                    <form action="cetak/lap_absensirekapbulan.php" target="_blank" class="form-horizontal" method="POST">
                        <div class="widget-main">
                            <ul class="list-unstyled spaced2">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-username">Bulan</label>
                                    <div class="col-sm-5">
                                        <select name="bulan" value="" id="bulan">
                                            <option value=''>-- Pilih Bulan--</option>
                                            <option value='01'>Januari</option>
                                            <option value='02'>Februari</option>
                                            <option value='03'>Maret</option>
                                            <option value='04'>April</option>
                                            <option value='05'>Mei</option>
                                            <option value='06'>Juni</option>
                                            <option value='07'>Juli</option>
                                            <option value='08'>Agustus</option>
                                            <option value='09'>September</option>
                                            <option value='10'>Oktober</option>
                                            <option value='11'>Nopember</option>
                                            <option value='12'>Desember</option>


                                        </select>


                                    </div>
                                    <label class="col-sm-1 control-label no-padding-right" for="form-field-username">Tahun</label>
                                    <div class="col-sm-2">

                                        <select name="tahun" value="" id="tahun">
                                            <option value=''>-- Pilih Tahun--</option>
                                            <option value='2020'>2020</option>
                                            <option value='2021'>2021</option>
                                            <option value='2022'>2022</option>
                                            <option value='2023'>2023</option>
                                            <option value='2024'>2024</option>
                                            <option value='2025'>2025</option>
                                            <option value='2026'>2026</option>


                                        </select>


                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-username">Tanda Tangan</label>
                                    <div class="col-sm-5">
                                        <input class="col-xs-12 " id="ttd" name="ttd" type="text" placeholder="Isikan nama " />

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-username"></label>
                                    <div class="col-sm-5">

                                        <input type="submit" name="hari" class="btn btn-info" value="Cetak" />
                                    </div>
                                </div>


                            </ul>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-6 widget-container-col">
        <div class="widget-box widget-color-red">
            <div class="widget-header widget-header-small">
                <h6 class="widget-title">
                    <i class="ace-icon fa fa-sort"></i>
                    Rekapitulasi Berdasarkan Penempatan
                </h6>

                <div class="widget-toolbar">
                    Klik disini

                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-plus" data-icon-show="fa-plus" data-icon-hide="fa-minus"></i>
                    </a>

                    <a href="#" data-action="close">
                        <i class="ace-icon fa fa-times"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">

                    <form action="cetak/lap_absensi_user_klien.php" target="_blank" class="form-horizontal" method="POST">
                        <div class="widget-main">
                            <ul class="list-unstyled spaced2">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-username">Tanggal</label>
                                    <div class="col-sm-3">

                                        <input class="col-xs-12 date-picker" id="id-date-picker-1" name="awal" type="text" data-date-format="yyyy-mm-dd" />

                                    </div>
                                    <label class="col-sm-1 control-label no-padding-right" for="form-field-username">s/d</label>
                                    <div class="col-sm-3">
                                        <input class="col-xs-12 date-picker" id="id-date-picker-1" name="akhir" type="text" data-date-format="yyyy-mm-dd" />

                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Penempatan :</label>
                                    <div class="col-sm-9">

                                        <select name="penempatan" value="">
                                            <option>-- Penempatan --</option>
                                            <?php
                                            $q = mysqli_query($mysqli, "select * from klien order by n_klien");

                                            while ($a = mysqli_fetch_array($q)) {
                                                if ($a[1] == $p_penempatan) {
                                                    echo "<option value='$a[2]' selected>$a[2]</option>";
                                                } else {
                                                    echo "<option value='$a[2]'>$a[2]</option>";
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>

                                </div>


                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-username"></label>
                                    <div class="col-sm-5">

                                        <input type="submit" name="hariklien" class="btn btn-info" value="Cetak" />
                                    </div>
                                </div>

                            </ul>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-6 widget-container-col">
        <div class="widget-box widget-color-red">
            <div class="widget-header widget-header-small">
                <h6 class="widget-title">
                    <i class="ace-icon fa fa-sort"></i>
                    Rekapitulasi Berdasarkan Nama
                </h6>

                <div class="widget-toolbar">
                    Klik disini

                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-plus" data-icon-show="fa-plus" data-icon-hide="fa-minus"></i>
                    </a>

                    <a href="#" data-action="close">
                        <i class="ace-icon fa fa-times"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">

                    <form action="cetak/lap_absensi_user_nama.php" target="_blank" class="form-horizontal" method="POST">
                        <div class="widget-main">
                            <ul class="list-unstyled spaced2">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-username">Tanggal</label>
                                    <div class="col-sm-3">

                                        <input class="col-xs-12 date-picker" id="id-date-picker-1" name="awal" type="text" data-date-format="yyyy-mm-dd" />

                                    </div>
                                    <label class="col-sm-1 control-label no-padding-right" for="form-field-username">s/d</label>
                                    <div class="col-sm-3">
                                        <input class="col-xs-12 date-picker" id="id-date-picker-1" name="akhir" type="text" data-date-format="yyyy-mm-dd" />

                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Nama Karyawan :</label>
                                    <div class="col-sm-9">

                                        <select name="nip" value="">
                                            <option>-- Nama Karyawan --</option>
                                            <?php
                                            $q = mysqli_query($mysqli, "select * from pegawai order by nama");

                                            while ($a = mysqli_fetch_array($q)) {
                                                if ($a[2] == $p_nama) {
                                                    echo "<option value='$a[1]' selected>$a[2]</option>";
                                                } else {
                                                    echo "<option value='$a[1]'>$a[2]</option>";
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>

                                </div>


                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-username"></label>
                                    <div class="col-sm-5">


                                        <input type="submit" name="hariuser" class="btn btn-info" value="Cetak" />
                                        <!-- <input type="submit" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false" value="Excel">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                        </input>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="cetak/downloadxls.php" target="_blank" class="btn-print">EXCEL</a></li>
                                        </ul> -->
                                    </div>
                                </div>

                            </ul>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Ekport Excel -->
    <div class="col-xs-12 col-sm-6 widget-container-col">
        <div class="widget-box widget-color-red">
            <div class="widget-header widget-header-small">
                <h6 class="widget-title">
                    <i class="ace-icon fa fa-sort"></i>
                    Export Excel Berdasarkan Penempatan
                </h6>

                <div class="widget-toolbar">
                    Klik disini

                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-plus" data-icon-show="fa-plus" data-icon-hide="fa-minus"></i>
                    </a>

                    <a href="#" data-action="close">
                        <i class="ace-icon fa fa-times"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">

                    <form action="hasilexcel.php" target="_blank" class="form-horizontal" method="POST">
                        <div class="widget-main">
                            <ul class="list-unstyled spaced2">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-username">Tanggal</label>
                                    <div class="col-sm-3">

                                        <input class="col-xs-12 date-picker" id="id-date-picker-1" name="awal" type="text" data-date-format="yyyy-mm-dd" />

                                    </div>
                                    <label class="col-sm-1 control-label no-padding-right" for="form-field-username">s/d</label>
                                    <div class="col-sm-3">
                                        <input class="col-xs-12 date-picker" id="id-date-picker-1" name="akhir" type="text" data-date-format="yyyy-mm-dd" />

                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Penempatan :</label>
                                    <div class="col-sm-9">

                                        <select name="penempatan" value="">
                                            <option>-- Penempatan --</option>
                                            <?php
                                            $q = mysqli_query($mysqli, "select * from klien order by n_klien");

                                            while ($a = mysqli_fetch_array($q)) {
                                                if ($a[1] == $p_penempatan) {
                                                    echo "<option value='$a[2]' selected>$a[2]</option>";
                                                } else {
                                                    echo "<option value='$a[2]'>$a[2]</option>";
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>

                                </div>


                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-username"></label>
                                    <div class="col-sm-5">

                                        <input type="submit" name="exportexcel" class="btn btn-info" value="Cetak" />
                                    </div>
                                </div>

                            </ul>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- akhir export -->


<?php
} else {
    header('Location:../index.php?status=Silahkan Login');
}
?>