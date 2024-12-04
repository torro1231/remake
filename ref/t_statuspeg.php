<?php
$id_statusp	= isset($_GET['idsp']) ? $_GET['idsp'] : NULL;
$mod 		= isset($_GET['mod']) ? $_GET['mod'] : NULL;	

		if ($mod == "del") {
			$q_delete_agama = mysqli_query($mysqli,"DELETE FROM tbl_statusp WHERE kdstatusp = '$id_statusp'");
			if ($q_delete_agama) {
				echo "<div class='alert alert-block alert-success'><button type='button' class='close' data-dismiss='alert'><i class=''></i></button><strong><i class='ace-icon fa fa-check'></i> BERHASIL</strong> Data Status Pegawai Berhasil di hapus<br/></div>";
			} else {
				echo "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><i class='icon-remove'></i></button><strong><i class='ace-icon fa fa-times'></i> MAAF! </strong>" .mysql_error()."<br/></div>";
			}
		}
		
		// ================ DATA FORM ( POST ) =====================//
		$display 		= "style='display: none'"; 	//default = formnya dihidden
		$tb_act 		= isset($_POST['tb_act']) ? $_POST['tb_act'] : NULL;				//ambil variabel POST value Tombol FOrm
		$p_id_statusp   	= isset($_POST['id_statusp']) ? $_POST['id_statusp'] : NULL;			//ambil variabel POST id_agama
		$p_nama_statusp 	= isset($_POST['nama_statusp']) ? $_POST['nama_statusp'] : NULL;		//ambil variabel POST nama_agama
		
		
		if ($tb_act == "Tambah") {
			$display = "style='display: none'";
			$q_tambah_statusp	= mysqli_query($mysqli,"INSERT INTO tbl_statusp VALUES (0,'$p_nama_statusp')");
			
			if ($q_tambah_statusp > 0 ) {
				echo "<div class='alert alert-block alert-success'><button type='button' class='close' data-dismiss='alert'><i class=''></i></button><strong><i class='ace-icon fa fa-check'></i> BERHASIL</strong> Data Status Pegawai Berhasil di simpan<br/></div>";
			} else {
				echo "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><i class='icon-remove'></i></button><strong><i class='ace-icon fa fa-times'></i> MAAF! </strong>" .mysqli_error($mysqli)."<br/></div>";
			}
		} else if ($tb_act == "Edit") {
			$display = "style='display: none'";
			$q_edit_statusp	= mysqli_query($mysqli,"UPDATE tbl_statusp SET nmstatusp = '$p_nama_statusp' WHERE kdstatusp = '$p_id_statusp'");
			if ($q_edit_statusp > 0 ) {
				echo "<div class='alert alert-block alert-success'><button type='button' class='close' data-dismiss='alert'><i class='icon-remove'></i></button><strong><i class='ace-icon fa fa-check'></i> BERHASIL</strong> Data Status Pegawai Berhasil di update<br/></div>";
			} else {
				echo "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><i class='icon-remove'></i></button><strong><i class='ace-icon fa fa-times'></i> MAAF! </strong>" .mysqli_error($mysqli)."<br/></div>";
			}
		} else {	
			$display = "style='display: none'";
		}
?>

		<h3 class="header smaller lighter blue">Referensi Status Pegawai</h3>
		<div class="module_content">
		<h5><a href="?id=statusp&mod=add" class="btn btn-primary" >Tambah Data</a></h5>
	
		
			
		<?php		
		// ================ TAMPILKAN DATANYA =====================//
		echo "<table id='sample-table-2' class='table table-striped table-bordered table-hover'><tr><th width='10%'>ID</th><th width='60%'>Status Pegawai</th><th width='30%'>Control</th></tr>";
		$q_statusp 	= mysqli_query($mysqli,"SELECT * FROM tbl_statusp ORDER BY kdstatusp ASC") or die (mysqli_error($mysqli));
		$j_data 	= mysqli_num_rows($q_statusp);

		if ($j_data == 0) {
			echo "<tr><td id='tengah' colspan='3'>-- Tidak Ada Data --</td></tr>";
		} else {

			while ($a_statusp = mysqli_fetch_array($q_statusp)) {
				echo "<tr><td id='tengah'>$a_statusp[0]</td><td>$a_statusp[1]</td>
				<td id='tengah'><a href='?id=statusp&mod=edit&idsp=$a_statusp[0]' ><span class='blue'><i class='ace-icon fa fa-pencil-square-o bigger-120'></i></span></a> |
					<a href='?id=statusp&mod=del&idsp=$a_statusp[0]' onclick=\"return confirm('Menghapus data $a_statusp[1]')\"><span class='red'><i class='ace-icon fa fa-trash-o bigger-120'></i></span></a>
				</tr>";
				$no++;
			}
		}
		echo "</table>";
		?>

		</div>


		<?php
		// ================ DATA URL "mod" ( GET ) =====================//

		if ($mod == "edit") {
			$display = "";
			$q_edit_statusp	= mysqli_query($mysqli,"SELECT * FROM tbl_statusp WHERE kdstatusp = '$id_statusp'");
			$a_edit_statusp	= mysqli_fetch_array($q_edit_statusp);
			
			$nama_statusp = $a_edit_statusp[1];
			$view = "Edit";
			
		} else if ($mod == "add") {
			$display = "";
			$id_statusp = "";
			$nama_statusp = "";
			$view = "Tambah";
		} else {
			$display = "style='display: none'";
		}

		?>


<div  <?php echo $display;?>>
    <header><h3 class="header smaller lighter blue"><?php echo $view;?> Data Status Pegawai</h3></header>
    <div class="form-group">
        <form action="?id=statusp" class="form-horizontal" method="post" id="ft_kpkrn">
            <table class="tbl_form">

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="kode">ID</label>
                    <div class="col-sm-9">
                        <input type="text" size="3" name="id_statusp" readonly value="<?php echo $id_statusp; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="kode">Status</label>
                    <div class="col-sm-9">
                        <input type="text" size="30" name="nama_statusp" value="<?php echo $nama_statusp; ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="kode"></label>
                    <div class="col-sm-9">
                        <input type="submit" class="btn btn-primary" name="tb_act" value="<?php echo $view; ?>">
                    </div>
                </div>

            </table>
    </div>
</div>