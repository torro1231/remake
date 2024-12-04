<?php
session_start();

$sesi_username			= isset($_SESSION['username']) ? $_SESSION['username'] : NULL;
$sesi_level				= isset($_SESSION['leveluser']) ? $_SESSION['leveluser'] : NULL;
$sesi_id_jab			= isset($_SESSION['id_jab']) ? $_SESSION['id_jab'] : NULL;
if ($sesi_level != '1' && $sesi_level != '3' && $sesi_level != '6' && $sesi_level != '7') {
	header('location:../index.php');
}

mb_internal_encoding('UTF-8');


$aColumns = array('NIP', 'NAMA', 'PENEMPATAN', 'PERIODE');


$sIndexColumn = 'NIP';

$sTable = 'slip';

// $sJoin = 'LEFT JOIN pegawai b ON slip.nip = b.nip';


$input = &$_POST;

$gaSql['charset']  = 'utf8';


include "../config/koneksi.php";


$sLimit = "";
if (isset($input['iDisplayStart']) && $input['iDisplayLength'] != '-1') {
	$sLimit = " LIMIT " . intval($input['iDisplayStart']) . ", " . intval($input['iDisplayLength']);
}


$aOrderingRules = array();
if (isset($input['iSortCol_0'])) {
	$iSortingCols = intval($input['iSortingCols']);
	for ($i = 0; $i < $iSortingCols; $i++) {
		if ($input['bSortable_' . intval($input['iSortCol_' . $i])] == 'true') {
			$aOrderingRules[] =
				"`" . $aColumns[intval($input['iSortCol_' . $i])] . "` "
				. ($input['sSortDir_' . $i] === 'desc' ? 'desc' : 'desc');
		}
	}
}

if (!empty($aOrderingRules)) {
	$sOrder = " ORDER BY " . implode(", ", $aOrderingRules);
} else {
	$sOrder = "";
}


$iColumnCount = count($aColumns);



if (isset($input['sSearch']) && $input['sSearch'] != "") {
	$aFilteringRules = array();
	for ($i = 0; $i < $iColumnCount; $i++) {
		if (isset($input['bSearchable_' . $i]) && $input['bSearchable_' . $i] == 'true') {

			$aFilteringRules[] = "`" . $aColumns[$i] . "` LIKE '%" . $mysqli->real_escape_string($input['sSearch']) . "%'";
		}
	}
	if (!empty($aFilteringRules)) {
		$aFilteringRules = array('(' . implode(" OR ", $aFilteringRules) . ')');
	}
}

// Individual column filtering
for ($i = 0; $i < $iColumnCount; $i++) {
	if (isset($input['bSearchable_' . $i]) && $input['bSearchable_' . $i] == 'true' && $input['sSearch_' . $i] != '') {
		$aFilteringRules[] = "`" . $aColumns[$i] . "` LIKE '%" . $mysqli->real_escape_string($input['sSearch_' . $i]) . "%'";
	}
}

if (!empty($aFilteringRules)) {
	$sWhere = " WHERE " . implode(" AND ", $aFilteringRules);
} else {
	$sWhere = "";
}


$aQueryColumns = array();
foreach ($aColumns as $col) {
	if ($col != ' ') {
		$aQueryColumns[] = $col;
	}
}

/*
     * SQL queries
     * Get data to display
     */
$sQuery = "
        SELECT SQL_CALC_FOUND_ROWS ID,nip,NAMA,PENEMPATAN,PERIODE,GAJIKOTOR,TOTALPOTONGAN,GAJIDITERIMA," . str_replace(" , ", " ", implode(", ", $aColumns)) . "
        FROM   $sTable
        $sWhere
        $sOrder
        $sLimit
    ";

$rResult = $mysqli->query($sQuery) or die($mysqli->error);


$sQuery = "SELECT FOUND_ROWS()";
$rResultFilterTotal = $mysqli->query($sQuery) or die($mysqli->error);
list($iFilteredTotal) = $rResultFilterTotal->fetch_row();


$sQuery = "SELECT COUNT(`" . $sIndexColumn . "`) FROM `" . $sTable . "`";
$rResultTotal = $mysqli->query($sQuery) or die($mysqli->error);
list($iTotal) = $rResultTotal->fetch_row();



$output = array(
	"sEcho"                => intval($input['sEcho']),
	"iTotalRecords"        => $iTotal,
	"iTotalDisplayRecords" => $iFilteredTotal,
	"aaData"               => array(),
);

while ($aRow = $rResult->fetch_assoc()) {
	$row = array();
	$btn = '
			<a class="green" href="cetak/slipgaji_admin.php?id=' . $aRow['ID'] . '" target="_blank">
				<i class="ace-icon fa fa-eye bigger-130"></i>
			</a>
			<a class="red" href="?id=data_slip&mod=del&ID=' . $aRow['ID'] . '" onclick="return confirm(\'Are you sure, you want to delete?\')"> 
				<i class="ace-icon fa fa-trash-o bigger-130"></i>
			</a>';



	for ($i = 0; $i < $iColumnCount; $i++) {
		$row[] = $aRow[$aColumns[$i]];
	}

	$row = array(
		$aRow['nip'],
		$aRow['NAMA'],
		$aRow['PENEMPATAN'],
		$aRow['PERIODE'],
		$aRow['GAJIKOTOR'],
		$aRow['TOTALPOTONGAN'],
		$aRow['GAJIDITERIMA'],
		$btn

	);

	$output['aaData'][] = $row;
}
echo json_encode($output);
