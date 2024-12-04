<?php
error_reporting(0);
$sesi_username            = isset($_SESSION['username']) ? $_SESSION['username'] : NULL;
if ($sesi_username != NULL || !empty($sesi_username) || $_SESSION['leveluser'] == '1' || $_SESSION['leveluser'] == '2') {

?>
    <div class="col-xs-12 col-sm-12 widget-container-col">
        <div class="widget-box widget-color-dark light-border">
            <div class="widget-header">
                <h5 class="widget-title smaller">Import Data Slip Gaji</h5>

                <div class="widget-toolbar">
                    <span class="badge badge-danger">Alert</span>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main padding-6">

                    <form name="myForm" id="myForm" class="form-horizontal" onSubmit="return validateForm()" action="#" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="col-sm-9">
                                <div class="col-xs-5">
                                    <input type="file" id="slipgaji" name="slipgaji" />
                                </div>
                                <input type="submit" class="btn btn-info btn-big btn-next" name="submit" value="Importslip" />
                                <a href="config/slipgaji.xls" class="btn btn-success btn-big btn-next">Download</a> Contoh format Excel
                            </div>
                        </div>
                    </form>

                    <?php
                    if (isset($_POST['submit'])) {
                    ?>
                        <div id="progress"></div>
                        <div id="info"></div>
                    <?php
                    }
                    ?>

                    <script type="text/javascript">
                        //    validasi form (hanya file .xls yang diijinkan)
                        function validateForm() {
                            function hasExtension(inputID, exts) {
                                var fileName = document.getElementById(inputID).value;
                                return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
                            }

                            if (!hasExtension('slipgaji', ['.xls'])) {
                                alert("Hanya file XLS (Excel 2003) yang diijinkan.");
                                return false;
                            }
                        }
                    </script>

                    <?php
                    require "config/excel_reader2.php";


                    if (isset($_POST['submit'])) {

                        $target = basename($_FILES['slipgaji']['name']);
                        move_uploaded_file($_FILES['slipgaji']['tmp_name'], $target);

                        $data = new Spreadsheet_Excel_Reader($_FILES['slipgaji']['name'], false);


                        $baris = $data->rowcount($sheet_index = 0);

                        for ($i = 2; $i <= $baris; $i++) {

                            $barisreal = $baris - 1;
                            $k = $i - 1;

                            $percent = intval($k / $barisreal * 100) . "%";


                            $nip            = $data->val($i, 1);
                            $NAMA = $data->val($i, 2);
                            $BAGIAN   = $data->val($i, 3);
                            $PENEMPATAN  = $data->val($i, 4);
                            $HADIR         = $data->val($i, 5);
                            $ABSENT         = $data->val($i, 6);
                            $GAJIPOKOK         = $data->val($i, 7);
                            $TUNJJABATAN      = $data->val($i, 8);
                            $TUNJKEHADIRAN         = $data->val($i, 9);
                            $MEAL         = $data->val($i, 10);
                            $TRANSPORT           = $data->val($i, 11);
                            $TUNJTETAP           = $data->val($i, 12);
                            $LEMBURRUPIAH           = $data->val($i, 13);
                            $PULSA         = $data->val($i, 14);
                            $OTHERALLOWANCE      = $data->val($i, 15);
                            $Pendapatanlain2          = $data->val($i, 16);
                            $THR          = $data->val($i, 17);
                            $BONUSTAHUNAN        = $data->val($i, 18);
                            $KPKWT      = $data->val($i, 19);
                            $GAJIKOTOR      = $data->val($i, 20);
                            $BPJSTKJHT        = $data->val($i, 21);
                            $BPJSTKJP         = $data->val($i, 22);
                            $POTBPJSKES        = $data->val($i, 23);
                            $PPH21         = $data->val($i, 24);
                            $POTABSEN         = $data->val($i, 25);
                            $PINJAMAN           = $data->val($i, 26);
                            $POTLAIN2      = $data->val($i, 27);
                            $PotKOPERASI    = $data->val($i, 28);
                            $ADMINBANK    = $data->val($i, 29);
                            $TOTALPOTONGAN    = $data->val($i, 30);
                            $GAJIDITERIMA    = $data->val($i, 31);
                            $NOBPJSTK    = $data->val($i, 32);
                            $NOBPJSKES    = $data->val($i, 33);
                            $NOREKENING    = $data->val($i, 34);
                            $NAMABANK    = $data->val($i, 35);
                            $NAMAREKENING    = $data->val($i, 36);
                            $PERIODE    = $data->val($i, 37);



                            $query = "INSERT into slip (nip,NAMA,BAGIAN,PENEMPATAN,HADIR,ABSENT,GAJIPOKOK,TUNJJABATAN,TUNJKEHADIRAN,MEAL,TRANSPORT,TUNJTETAP,LEMBURRUPIAH,PULSA,OTHERALLOWANCE,Pendapatanlain2,THR,BONUSTAHUNAN,KPKWT,GAJIKOTOR,BPJSTKJHT,BPJSTKJP,POTBPJSKES,PPH21,POTABSEN,PINJAMAN,POTLAIN2,PotKOPERASI,ADMINBANK,TOTALPOTONGAN,GAJIDITERIMA,NOBPJSTK,NOBPJSKES,NOREKENING,NAMABANK,NAMAREKENING,PERIODE)
        values('$nip','$NAMA','$BAGIAN','$PENEMPATAN','$HADIR','$ABSENT','$GAJIPOKOK','$TUNJJABATAN','$TUNJKEHADIRAN','$MEAL','$TRANSPORT','$TUNJTETAP','$LEMBURRUPIAH','$PULSA','$OTHERALLOWANCE','$Pendapatanlain2','$THR','$BONUSTAHUNAN','$KPKWT','$GAJIKOTOR','$BPJSTKJHT','$BPJSTKJP','$POTBPJSKES','$PPH21','$POTABSEN','$PINJAMAN','$POTLAIN2','$PotKOPERASI','$ADMINBANK','$TOTALPOTONGAN','$GAJIDITERIMA','$NOBPJSTK','$NOBPJSKES','$NOREKENING','$NAMABANK','$NAMAREKENING','$PERIODE')";
                            $hasil = mysqli_query($mysqli, $query);

                            if ($hasil > 0) {
                                echo '<script language="javascript">
        document.getElementById("progress").innerHTML="<div class=\'progress progress-mini progress-striped active\'><div class=\'progress-bar progress-bar-success\' style=\'width:' . $percent . '; \'>&nbsp;</div></div>";
        document.getElementById("info").innerHTML="<div class=\'alert alert-info\'>' . $k . ' data berhasil diinsert (' . $percent . ' selesai).</div>";
        </script>';
                            } else {
                                echo '<script language="javascript">
        document.getElementById("info").innerHTML="<div class=\'alert alert-warning\'>' . $k . ' data gagal di import(' . $percent . ' selesai).</div>";
        </script>';
                            }

                            flush();
                        }

                        unlink($_FILES['slipgaji']['name']);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>


<?php
} else {
    header('Location:index.php?status=Silahkan Login');
}
?>