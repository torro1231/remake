<?php
$id_cuti = $_GET['idcuti'] ?? NULL;
$mod = $_GET['mod'] ?? NULL;

// Proses hapus data
if ($mod == "del") {
    $q_delete_cuti = mysqli_query($mysqli, "DELETE FROM tbl_cuti WHERE id_cuti='$id_cuti'");
    $message = $q_delete_cuti 
        ? "<div class='alert alert-success'>Data Cuti Berhasil dihapus</div>" 
        : "<div class='alert alert-danger'>Gagal menghapus: " . mysqli_error($mysqli) . "</div>";
    echo $message;
}

$tb_act = $_POST['tb_act'] ?? NULL;
$p_id_cuti = $_POST['id_cuti'] ?? NULL;
$p_nama_cuti = $_POST['n_cuti'] ?? NULL;
$p_jatah_cuti = $_POST['jatah_cuti'] ?? NULL;

// Proses tambah atau edit data
if ($tb_act) {
    if ($tb_act == "Tambah") {
        $query = "INSERT INTO tbl_cuti VALUES (0,'$p_nama_cuti','$p_jatah_cuti')";
    } elseif ($tb_act == "Edit") {
        $query = "UPDATE tbl_cuti SET n_cuti='$p_nama_cuti', jatah_cuti='$p_jatah_cuti' WHERE id_cuti='$p_id_cuti'";
    }
    $q_execute = mysqli_query($mysqli, $query);
    $message = $q_execute 
        ? "<div class='alert alert-success'>Data Cuti Berhasil disimpan</div>" 
        : "<div class='alert alert-danger'>Gagal menyimpan: " . mysqli_error($mysqli) . "</div>";
    echo $message;
}
?>

<h3 class="header smaller lighter blue">Referensi Cuti</h3>
<div class="module_content">
    <h5><a href="?id=cuti&mod=add" class="btn btn-primary">Tambah Data</a></h5>

    <table id='sample-table-2' class='table table-striped table-bordered table-hover'>
        <tr>
            <th>ID</th><th>Cuti</th><th>Jatah Cuti</th><th>Control</th>
        </tr>
        <?php
        $q_cuti = mysqli_query($mysqli, "SELECT * FROM tbl_cuti ORDER BY id_cuti ASC") or die(mysqli_error($mysqli));
        if (mysqli_num_rows($q_cuti) == 0) {
            echo "<tr><td colspan='4'>-- Tidak Ada Data --</td></tr>";
        } else {
            while ($a_cuti = mysqli_fetch_array($q_cuti)) {
                echo "<tr>
                    <td>{$a_cuti['id_cuti']}</td>
                    <td>{$a_cuti['n_cuti']}</td>
                    <td>{$a_cuti['jatah_cuti']}</td>
                    <td>
                        <a href='?id=cuti&mod=edit&idcuti={$a_cuti['id_cuti']}'><span class='blue'><i class='fa fa-pencil-square-o'></i></span></a> |
                        <a href='?id=cuti&mod=del&idcuti={$a_cuti['id_cuti']}' onclick=\"return confirm('Hapus data {$a_cuti['n_cuti']}?')\"><span class='red'><i class='fa fa-trash-o'></i></span></a>
                    </td>
                </tr>";
            }
        }
        ?>
    </table>
</div>

<?php
if ($mod == "edit") {
    $q_edit_cuti = mysqli_query($mysqli, "SELECT * FROM tbl_cuti WHERE id_cuti='$id_cuti'");
    $a_edit_cuti = mysqli_fetch_array($q_edit_cuti);
    $n_cuti = $a_edit_cuti['n_cuti'];
    $j_cuti = $a_edit_cuti['jatah_cuti'];
    $view = "Edit";
} elseif ($mod == "add") {
    $id_cuti = $n_cuti = $j_cuti = "";
    $view = "Tambah";
} else {
    return;
}
?>

<div>
    <header>
        <h3 class="header smaller lighter blue"><?php echo $view; ?> Data Cuti</h3>
    </header>
    <form action="?id=cuti" class="form-horizontal" method="post">
        <div class="form-group">
            <label for="id_cuti">ID</label>
            <input type="text" name="id_cuti" value="<?php echo $id_cuti; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="n_cuti">Cuti</label>
            <input type="text" name="n_cuti" value="<?php echo $n_cuti; ?>" required>
        </div>
        <div class="form-group">
            <label for="jatah_cuti">Jatah Cuti</label>
            <input type="text" name="jatah_cuti" value="<?php echo $j_cuti; ?>">
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="tb_act" value="<?php echo $view; ?>">
        </div>
    </form>
</div>
