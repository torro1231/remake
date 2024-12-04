<?php
// ob_start();
// session_start();
// $sesi_username			= isset($_SESSION['username']) ? $_SESSION['username'] : NULL;
// $sesi_level				= isset($_SESSION['leveluser']) ? $_SESSION['leveluser'] : NULL;
// if ($sesi_level != '5') {
// 	header('location:../index.php');
// }
include "../fpdf17/fpdf.php";
include "../config/koneksi.php";
$ID     		= $_GET['ID'];
// $gabung		 	= "" . $p_awal . "";

$pdf = new FPDF('P', 'cm', 'A4');
$pdf->AddPage();

$query = mysqli_query($mysqli, "SELECT * FROM master");
while ($data1 = mysqli_fetch_row($query)) {
	$nm_pt		= $data1[1];
	$alamat		= $data1[2];
	$logo		= $data1[5];
	$email_pt	= $data1[6];
	$web		= $data1[7];
	$gabung2	= "Web:" . $web . " Email:" . $email_pt . "";


	$pdf->SetFont('Arial', 'B', 14);
	$pdf->Image('../' . $logo, 1, 1, 2, 2);

	$pdf->SetX(3);
	$pdf->MultiCell(19.5, 0.5, $nm_pt, 0, 'L');

	$pdf->SetFont('Arial', 'B', 10);
	$pdf->SetX(3);
	$pdf->MultiCell(19.5, 0.5, 'Slip Gaji Karyawan ', 0, 'L');

	$pdf->SetFont('Arial', 'B', 10);
	$pdf->SetX(3);
	$pdf->MultiCell(19.5, 0.5, $alamat, 0, 'L');

	$pdf->SetX(3);
	$pdf->MultiCell(19.5, 0.5, $gabung2, 0, 'L');

	$pdf->Line(1, 3.1, 20, 3.1);
	$pdf->SetLineWidth(0.1);
	$pdf->Line(1, 3.2, 20, 3.2);
}
$pdf->SetLineWidth(0);
$pdf->Ln();



$querynm = mysqli_query($mysqli, "SELECT * FROM slip where ID='$_GET[id]'");
$data2 = mysqli_fetch_array($querynm);

// data karyawan
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(2.5, 0.5, 'NIP', 0, 0, 'L');
$pdf->Cell(1, 0.5, ':', 0, 0, 'C');
$pdf->Cell(7, 0.5, $data2['nip'], 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(2.5, 0.5, 'NO REKENING', 0, 0, 'L');
$pdf->Cell(1, 0.5, ':', 0, 0, 'C');
$pdf->MultiCell(19.5, 0.5, $data2['NOREKENING'], 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(2.5, 0.5, 'NAMA', 0, 0, 'L');
$pdf->Cell(1, 0.5, ':', 0, 0, 'C');
$pdf->Cell(7, 0.5, $data2['NAMA'], 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(2.5, 0.5, 'NO BPJS KES', 0, 0, 'L');
$pdf->Cell(1, 0.5, ':', 0, 0, 'C');
$pdf->MultiCell(19.5, 0.5, $data2['NOBPJSKES'], 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(2.5, 0.5, 'JABATAN', 0, 0, 'L');
$pdf->Cell(1, 0.5, ':', 0, 0, 'C');
$pdf->Cell(7, 0.5, $data2['BAGIAN'], 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(2.5, 0.5, 'NO BPJS TK', 0, 0, 'L');
$pdf->Cell(1, 0.5, ':', 0, 0, 'C');
$pdf->MultiCell(19.5, 0.5, $data2['NOBPJSTK'], 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(2.5, 0.5, 'PENEMPATAN', 0, 0, 'L');
$pdf->Cell(1, 0.5, ':', 0, 0, 'C');
$pdf->Cell(7, 0.5, $data2['PENEMPATAN'], 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(2.5, 0.5, 'PERIODE', 0, 0, 'L');
$pdf->Cell(1, 0.5, ':', 0, 0, 'C');
$pdf->MultiCell(19.5, 0.5, $data2['PERIODE'], 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(2.5, 0.5, 'HADIR', 0, 0, 'L');
$pdf->Cell(1, 0.5, ':', 0, 0, 'C');
$pdf->Cell(7, 0.5, $data2['HADIR'], 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(2.5, 0.5, 'ABSENT', 0, 0, 'L');
$pdf->Cell(1, 0.5, ':', 0, 0, 'C');
$pdf->MultiCell(19.5, 0.5, $data2['ABSENT'], 0, 'L');
$pdf->Ln();
// end data bagian

// TH
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 1, 'PENDAPATAN', 1, 0, 'C');
$pdf->Cell(9, 1, 'POTONGAN', 1, 0, 'C');
$pdf->Ln();
$pdf->Ln();
// end TH
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(3, 0.5, 'Gaji Pokok', 0, 0, 'L');
$pdf->Cell(1, 0.5, ':', 0, 0, 'C');
$pdf->Cell(7, 0.5, $data2['GAJIPOKOK'], 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(2, 0.5, 'Pot. Kehadiran', 0, 0, 'L');
$pdf->Cell(3, 0.5, ':', 0, 0, 'C');
$pdf->Cell(3, 0.5, $data2['POTABSEN'], 0, 'L');
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(3, 0.5, 'Tunj. Kehadiran', 0, 0, 'L');
$pdf->Cell(1, 0.5, ':', 0, 0, 'C');
$pdf->Cell(7, 0.5, $data2['TUNJKEHADIRAN'], 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(2, 0.5, 'Pot. BPJS TK JHT', 0, 0, 'L');
$pdf->Cell(3, 0.5, ':', 0, 0, 'C');
$pdf->Cell(3, 0.5, $data2['BPJSTKJHT'], 0, 'L');
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(3, 0.5, 'Tunj. Jabatan', 0, 0, 'L');
$pdf->Cell(1, 0.5, ':', 0, 0, 'C');
$pdf->Cell(7, 0.5, $data2['TUNJJABATAN'], 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(2, 0.5, 'Pot. BPJS JP', 0, 0, 'L');
$pdf->Cell(3, 0.5, ':', 0, 0, 'C');
$pdf->Cell(3, 0.5, $data2['BPJSTKJP'], 0, 'L');
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(3, 0.5, 'Tunj. Makan', 0, 0, 'L');
$pdf->Cell(1, 0.5, ':', 0, 0, 'C');
$pdf->Cell(7, 0.5, $data2['MEAL'], 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(2, 0.5, 'Pot. BPJS KES', 0, 0, 'L');
$pdf->Cell(3, 0.5, ':', 0, 0, 'C');
$pdf->Cell(3, 0.5, $data2['POTBPJSKES'], 0, 'L');
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(3, 0.5, 'Tunj. Transport', 0, 0, 'L');
$pdf->Cell(1, 0.5, ':', 0, 0, 'C');
$pdf->Cell(7, 0.5, $data2['TRANSPORT'], 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(2, 0.5, 'Pot. Pph 21', 0, 0, 'L');
$pdf->Cell(3, 0.5, ':', 0, 0, 'C');
$pdf->Cell(3, 0.5, $data2['PPH21'], 0, 'L');
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(3, 0.5, 'Tunj. Tetap', 0, 0, 'L');
$pdf->Cell(1, 0.5, ':', 0, 0, 'C');
$pdf->Cell(7, 0.5, $data2['TUNJTETAP'], 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(2, 0.5, 'Pot. Pinjaman', 0, 0, 'L');
$pdf->Cell(3, 0.5, ':', 0, 0, 'C');
$pdf->Cell(3, 0.5, $data2['PINJAMAN'], 0, 'L');
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(3, 0.5, 'Lembur', 0, 0, 'L');
$pdf->Cell(1, 0.5, ':', 0, 0, 'C');
$pdf->Cell(7, 0.5, $data2['LEMBURRUPIAH'], 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(2, 0.5, 'Pot. Lain Lain', 0, 0, 'L');
$pdf->Cell(3, 0.5, ':', 0, 0, 'C');
$pdf->Cell(3, 0.5, $data2['POTLAIN2'], 0, 'L');
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(3, 0.5, 'Tunj. Kehadiran', 0, 0, 'L');
$pdf->Cell(1, 0.5, ':', 0, 0, 'C');
$pdf->Cell(7, 0.5, $data2['TUNJKEHADIRAN'], 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(2, 0.5, 'Pot. Koperasi', 0, 0, 'L');
$pdf->Cell(3, 0.5, ':', 0, 0, 'C');
$pdf->Cell(3, 0.5, $data2['PotKOPERASI'], 0, 'L');
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(3, 0.5, 'Pulsa', 0, 0, 'L');
$pdf->Cell(1, 0.5, ':', 0, 0, 'C');
$pdf->Cell(7, 0.5, $data2['PULSA'], 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(2, 0.5, 'Pot. Payroll Bank', 0, 0, 'L');
$pdf->Cell(3, 0.5, ':', 0, 0, 'C');
$pdf->Cell(3, 0.5, $data2['ADMINBANK'], 0, 'L');
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(3, 0.5, 'Insentif', 0, 0, 'L');
$pdf->Cell(1, 0.5, ':', 0, 0, 'C');
$pdf->Cell(7, 0.5, $data2['OTHERALLOWANCE'], 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(2, 0.5, '', 0, 0, 'L');
$pdf->Cell(3, 0.5, '', 0, 0, 'C');
$pdf->Cell(3, 0.5, '', 0, 'L');
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(3, 0.5, 'THR', 0, 0, 'L');
$pdf->Cell(1, 0.5, ':', 0, 0, 'C');
$pdf->Cell(7, 0.5, $data2['THR'], 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(2, 0.5, '', 0, 0, 'L');
$pdf->Cell(3, 0.5, '', 0, 0, 'C');
$pdf->Cell(3, 0.5, '', 0, 'L');
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(3, 0.5, 'Bonus Tahunan', 0, 0, 'L');
$pdf->Cell(1, 0.5, ':', 0, 0, 'C');
$pdf->Cell(7, 0.5, $data2['BONUSTAHUNAN'], 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(2, 0.5, '', 0, 0, 'L');
$pdf->Cell(3, 0.5, '', 0, 0, 'C');
$pdf->Cell(3, 0.5, '', 0, 'L');
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(3, 0.5, 'Kompensasi', 0, 0, 'L');
$pdf->Cell(1, 0.5, ':', 0, 0, 'C');
$pdf->Cell(7, 0.5, $data2['KPKWT'], 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(2, 0.5, '', 0, 0, 'L');
$pdf->Cell(3, 0.5, '', 0, 0, 'C');
$pdf->Cell(3, 0.5, '', 0, 'L');
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(3, 0.5, 'Pen. Lainnya', 0, 0, 'L');
$pdf->Cell(1, 0.5, ':', 0, 0, 'C');
$pdf->Cell(7, 0.5, $data2['Pendapatanlain2'], 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(2, 0.5, '', 0, 0, 'L');
$pdf->Cell(3, 0.5, '', 0, 0, 'C');
$pdf->Cell(3, 0.5, '', 0, 'L');
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(4, 0.5, 'TOTAL PENDAPATAN', 0, 0, 'L');
$pdf->Cell(1, 0.5, ':', 0, 0, 'C');
$pdf->Cell(6, 0.5, $data2['GAJIKOTOR'], 0, 'L');

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(4, 0.5, 'TOTAL POTONGAN', 0, 0, 'L');
$pdf->Cell(1, 0.5, ':', 0, 0, 'C');
$pdf->Cell(4, 0.5, $data2['TOTALPOTONGAN'], 0, 'L');
$pdf->Ln();
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 12, 1, 1);
$pdf->Cell(2, 0.5, 'GAJI BERSIH', 0, 0, 'B');
$pdf->Cell(3, 0.5, ':', 0, 0, 'C');
$pdf->Cell(3, 0.5, $data2['GAJIDITERIMA'], 0, 0, 'B');
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX(1);
$pdf->MultiCell(15, 3, 'Karyawan', 0, 'R');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX(1);
$pdf->MultiCell(15, 0.5, $data2['NAMA'], 0, 'R');


$pdf->Ln();
$pdf->Output();
