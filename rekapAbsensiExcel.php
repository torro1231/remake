<?php
error_reporting(0);
$sesi_username            = isset($_SESSION['username']) ? $_SESSION['username'] : NULL;
if ($sesi_username != NULL || !empty($sesi_username) || $_SESSION['leveluser'] == '1' || $_SESSION['leveluser'] == '2') {

?>

    <div class="col-xs-12 col-sm-12 widget-container-col">
        <div class="widget-box widget-color-blue">
            <div class="widget-header">
                <h5 class="widget-title">Export Absensi Excel </h5>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="1 ace-icon fa fa-chevron-up bigger-125"></i>
                    </a>
                </div>

                <div class="widget-toolbar no-border">

                    *Switch ON terlebih dahulu

                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">

                    <form class="form-horizontal" method="post" action="hasilexcel.php">


                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="kode">Nama Pegawai :</label>
                            <div class="col-sm-9">
                                <input type="text" id="name" class="col-xs-10 col-sm-5" name="name" placeholder="Isikan nama pegawai..." value="">

                                <input id="idnama" name="idnama" checked="" type="checkbox" class="ace ace-switch ace-switch-4" />
                                <span class="lbl middle"></span>

                            </div>
                        </div>
                        <!-- penempatan -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Penempatan :</label>
                            <div class="col-sm-9">
                                <select name="penempatan" id="penempatan" class="" value="">
                                    <option value="">-- Pilih Penempatan --</option>
                                    <?php
                                    $q = mysqli_query($mysqli, "select * from klien order by n_klien ");
                                    while ($a = mysqli_fetch_array($q)) {
                                        if ($a[0] == "") {
                                            echo "<option value='$a[2]' selected>$a[2]</option>";
                                        } else {
                                            echo "<option value='$a[2]' >$a[2]</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <input id="penempatan" name="penempatan" checked="" type="checkbox" class="ace ace-switch ace-switch-4" />
                                <span class="lbl middle"></span>
                            </div>
                        </div>
                        <!-- Akhir div penempatan -->



                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-tanggal">Periode :</label>
                            <div class="col-sm-1">
                                <label></label>
                                <input class="col-xs-12 date-picker" id="id-date-picker-1" name="awal" type="text" data-date-format="yyyy-mm-dd" />

                            </div>
                            <div class="col-sm-1">
                                <label>s/d</label>
                            </div>
                            <div class="col-sm-1">
                                <label></label>
                                <input class="col-xs-12 date-picker" id="id-date-picker-1" name="akhir" type="text" data-date-format="yyyy-mm-dd" />

                            </div>
                            <input id="periode" name="periode" checked="" type="checkbox" class="ace ace-switch ace-switch-4" />
                            <span class="lbl middle"></span>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right"></label>
                            <div class="col-sm-9">
                                <input class="btn btn-success btn-big btn-next" type="submit" name="kirim_excel" value="Export Xls" />
                            </div>
                        </div>
                </div>

                </form>

            </div>


            <div class="widget-toolbox padding-8 clearfix">


                <div id="myModal" class="modal fade" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header no-padding">
                                <div class="table-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                        <span class="white">&times;</span>
                                    </button>
                                    <i id="myModalLabel3">Hasil Pencarian </i>
                                </div>
                            </div>


                            <div class="modal-body">

                                <div id="hasilabsensi"></div>

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Batal</button>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
        </div>
    </div>
    </div>
    </div>



<?php
} else {
    header('Location:index.php?status=Silahkan Login');
}
?>