<?php 
require_once("../config/connection.php");
require_once "../assets/plugins/PHPExcel/Classes/PHPExcel.php"; 

$pefindoId=$_GET['id'];
$type=$_GET['type'];

if($type=="P"){
	$callSummary = "{call SP_GET_TAB_SUMMARY(?)}";
}else{
	$callSummary = "{call SP_GET_TAB_SUMMARY_COMPANY(?)}";
}
$paramsSummary = array(array($pefindoId, SQLSRV_PARAM_IN));
$optionsSummary =  array( "Scrollable" => "buffered" );
$execSummary = sqlsrv_query($conn, $callSummary, $paramsSummary, $optionsSummary) or die( print_r( sqlsrv_errors(), true));
$numRowsSummary = sqlsrv_num_rows($execSummary);

$lancar=0;
$days_1_30=0;
$days_31_60=0;
$days_61_90=0;
$days_91_120=0;
$days_121_150=0;
$days_151_180=0;
$lebih180=0;
while($dataSummary = sqlsrv_fetch_array($execSummary)){
	if($type=="P"){
		$ktp=$dataSummary['KTP'];
		$nama=$dataSummary['FULL_NAME'];
	}else{
		$ktp=$dataSummary['NPWP'];
		$nama=$dataSummary['COMPANY_NAME'];
	}
	$duedays=$dataSummary['PASTDUE_DAYS'];
	if($duedays == 0){
		$lancar++;
	}else if($duedays >= 1 && $duedays <= 30){
		$days_1_30++;
	}else if($duedays >= 31 && $duedays <= 60){
		$days_31_60++;
	}else if($duedays >= 61 && $duedays <= 90){
		$days_61_90++;
	}else if($duedays >= 91 && $duedays <= 120){
		$days_91_120++;
	}else if($duedays >= 121 && $duedays <= 150){
		$days_121_150++;
	}else if($duedays >= 151 && $duedays <= 180){
		$days_151_180++;
	}else if($duedays > 180){
		$lebih180++;
	}
}	

/* select table cip */
if($type=="P"){
	$callCIP = "{call SP_GET_TAB_DASHBOARD_TBL_CIP(?)}";
}else{
	$callCIP = "{call SP_GET_TAB_DASHBOARD_TBL_CIP_COMPANY(?)}";
}
$paramsCIP = array(array($pefindoId, SQLSRV_PARAM_IN));
$execCIP = sqlsrv_query( $conn, $callCIP, $paramsCIP) or die( print_r( sqlsrv_errors(), true));
$dataCIP = sqlsrv_fetch_array($execCIP);

$totalPlafond2 = 0;
$totalBakiDebet2 = 0;
$totalJatuhTempo2 = 0;
$totalUsiaTunggakan2 = 0;

if($type=="P"){
	$callCONT2 = "{call SP_GET_TAB_CONTRACT_MAINDEBTOR(?)}";
}else{
	$callCONT2 = "{call SP_GET_TAB_CONTRACT_MAINDEBTOR_COMPANY(?)}";
}
$optionsCONT2 =  array( "Scrollable" => "buffered" );
$paramsCONT2 = array(array($pefindoId, SQLSRV_PARAM_IN));
$execCONT2 = sqlsrv_query( $conn, $callCONT2, $paramsCONT2,$optionsCONT2) or die( print_r( sqlsrv_errors(), true));
						
while($dataCONT2 = sqlsrv_fetch_array($execCONT2)){
	$totalPlafond2 =+ $totalPlafond2 + $dataCONT2['TOTAL_AMOUNT_VALUE'];
	$totalBakiDebet2 =+ $totalBakiDebet2 + $dataCONT2['OUTSTANDING_AMOUNT_VALUE'];
	$totalJatuhTempo2 =+ $totalJatuhTempo2 + $dataCONT2['PASTDUE_AMOUNT_VALUE'];
	$totalUsiaTunggakan2 =+ $totalUsiaTunggakan2 + $dataCONT2['PASTDUE_DAYS'];
}

date_default_timezone_set("Asia/Jakarta");
$date=date('Ymd');
$time=date('His');
$title="SummaryReportPefindo_".$pefindoId;
/*start - BLOCK PROPERTIES FILE EXCEL*/
	$file = new PHPExcel ();
	$file->getProperties ()->setCreator ( "Suzuki Finance" );
	$file->getProperties ()->setLastModifiedBy ( "Suzuki Finance" );
	$file->getProperties ()->setTitle ( $title );
	$file->getProperties ()->setSubject ( "" );
	$file->getProperties ()->setDescription ( "" );
	$file->getProperties ()->setKeywords ( "" );
	$file->getProperties ()->setCategory ( "" );
/*end - BLOCK PROPERTIES FILE EXCEL*/
 
/*start - BLOCK SETUP SHEET*/
	$file->createSheet ( NULL,0);
	$file->setActiveSheetIndex ( 0 );
	$sheet = $file->getActiveSheet ( 0 );
	//memberikan title pada sheet
	$sheet->setTitle ( $title );
/*end - BLOCK SETUP SHEET*/
 
/*start - BLOCK HEADER*/
	$sheet	->setCellValue ( "A1", "No" )
		->setCellValue ( "B1", "NIK" )
		->setCellValue ( "C1", "CUSTOMER NAME" )
		->setCellValue ( "D1", "PEFINDO SCORE" )
		->setCellValue ( "E1", "TOTAL FACILITAS" )
		->setCellValue ( "F1", "TOTAL PLAFOND" )
		->setCellValue ( "G1", "TOTAL BAKI DEBET" )
		->setCellValue ( "H1", "LANCAR" )
		->setCellValue ( "I1", "1-30" )
		->setCellValue ( "J1", "31-60" )
		->setCellValue ( "K1", "61-90" )
		->setCellValue ( "L1", "91-120" )
		->setCellValue ( "M1", "121-150" )
		->setCellValue ( "N1", "151-180" )
		->setCellValue ( "O1", "> 180" );
/*end - BLOCK HEADER*/
 
/* start - BLOCK MEMASUKAN DATABASE*/
	$config_serverName2 = '172.22.0.27';
	$config_db2 = 'H2H_PEFINDO';
	$config_uid2 = 'UserPefindo';
	$config_pwd2 = 'user.1123';
	$connectionInfo2 = array( "Database"=>$config_db2, "UID"=>$config_uid2, "PWD"=>$config_pwd2 );
	$conn2 = sqlsrv_connect($config_serverName2, $connectionInfo2);
	
	ini_set('max_execution_time', 0);
	//echo ini_get('max_execution_time');
	
	if($type=="P"){
		$callSP = "{call SP_GET_SUMMARY_REPORT_PEFINDO(?)}"; 
	}else{
		$callSP = "{call SP_GET_SUMMARY_REPORT_PEFINDO(?)}"; 
	}
	$parameter = array(array($pefindoId, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn2, $callSP, $parameter) or die( print_r( sqlsrv_errors(), true));

	$nomor=1;
	$no=0;
	while($row=sqlsrv_fetch_array($exec)){
		$nomor++;
		$no++;
		$sheet	->setCellValue ( "A".$nomor,  $no )
			->setCellValue ( "B".$nomor,  $ktp )
			->setCellValue ( "C".$nomor,  $nama )
			->setCellValue ( "D".$nomor,  $dataCIP['SCORE'] )
			->setCellValue ( "E".$nomor,  $numRowsSummary )
			->setCellValue ( "F".$nomor,  $totalPlafond2 )
			->setCellValue ( "G".$nomor,  $totalBakiDebet2 )
			->setCellValue ( "H".$nomor,  $lancar )
			->setCellValue ( "I".$nomor,  $days_1_30 )
			->setCellValue ( "J".$nomor,  $days_31_60 )
			->setCellValue ( "K".$nomor,  $days_61_90 )
			->setCellValue ( "L".$nomor,  $days_91_120 )
			->setCellValue ( "M".$nomor,  $days_121_150 )
			->setCellValue ( "N".$nomor,  $days_151_180 )
			->setCellValue ( "O".$nomor,  $lebih180 );
	}
/* end - BLOCK MEMASUKAN DATABASE*/

/*start - BLOK AUTOSIZE*/
	$sheet ->getColumnDimension ( "A" )->setAutoSize ( true );
	$sheet ->getColumnDimension ( "B" )->setAutoSize ( true );
	$sheet ->getColumnDimension ( "C" )->setAutoSize ( true );
	$sheet ->getColumnDimension ( "D" )->setAutoSize ( true );
	$sheet ->getColumnDimension ( "E" )->setAutoSize ( true );
	$sheet ->getColumnDimension ( "F" )->setAutoSize ( true );
	$sheet ->getColumnDimension ( "G" )->setAutoSize ( true );
	$sheet ->getColumnDimension ( "H" )->setAutoSize ( true );
	$sheet ->getColumnDimension ( "I" )->setAutoSize ( true );
	$sheet ->getColumnDimension ( "J" )->setAutoSize ( true );
	$sheet ->getColumnDimension ( "K" )->setAutoSize ( true );
	$sheet ->getColumnDimension ( "L" )->setAutoSize ( true );
	$sheet ->getColumnDimension ( "M" )->setAutoSize ( true );
	$sheet ->getColumnDimension ( "N" )->setAutoSize ( true );
	$sheet ->getColumnDimension ( "O" )->setAutoSize ( true );
/*end - BLOG AUTOSIZE*/
 
/* start - BLOCK MEMBUAT LINK DOWNLOAD*/
	ob_end_clean();
	header ( 'Content-Type: application/vnd.ms-excel' );
	//namanya adalah Data Order.xls
	header ( 'Content-Disposition: attachment;filename="'.$title.'.xls"' ); 
	header ( 'Cache-Control: max-age=0' );
	$writer = PHPExcel_IOFactory::createWriter ( $file, 'Excel5' );
	$writer->save ( 'php://output' );
	//ob_end_clean();
/* start - BLOCK MEMBUAT LINK DOWNLOAD*/
?>
