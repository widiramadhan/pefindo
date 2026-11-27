<?php 
require_once("../config/connection.php");
require_once "../assets/plugins/PHPExcel/Classes/PHPExcel.php"; 

$id=$_GET['id'];

$callSP2 = "{call SP_GET_DATA_BY_PEFINDO_MAPPING_ID(?)}";
$parameter2 = array(array($id, SQLSRV_PARAM_IN));
$exec2 = sqlsrv_query( $conn, $callSP2, $parameter2) or die( print_r( sqlsrv_errors(), true));
$data = sqlsrv_fetch_array($exec2);

date_default_timezone_set("Asia/Jakarta");
$date=date('Ymd');
$time=date('His');
$title="SummaryReportPefindo_".$id;
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
		->setCellValue ( "E1", "TOTAL FASILITAS" )
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
	
	if($data['CUST_TYPE']<>"COMPANY"){
		$callSP = "{call SP_GET_EXCEL_SUMMARY_REPORT_PEFINDO(?)}";
	}else{
		$callSP = "{call SP_GET_EXCEL_SUMMARY_REPORT_PEFINDO_COMPANY(?)}";
	}
	$parameter = array(array($id, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn2, $callSP, $parameter) or die( print_r( sqlsrv_errors(), true));
	$nomor=1;
	$no=0;
	while($row=sqlsrv_fetch_array($exec)){
		$nomor++;
		$no++;
		$sheet	->setCellValue ( "A".$nomor,  $no )
			->setCellValue ( "B".$nomor,  $row['NIK'] )
			->setCellValue ( "C".$nomor,  $row['CUSTOMER_NAME'] )
			->setCellValue ( "D".$nomor,  $row['SCORE'] )
			->setCellValue ( "E".$nomor,  $row['TOTAL_FASILITAS'] )
			->setCellValue ( "F".$nomor,  $row['TOTAL_PLAFOND'] )
			->setCellValue ( "G".$nomor,  $row['TOTAL_BAKI_DEBET'] )
			->setCellValue ( "H".$nomor,  $row['LANCAR'] )
			->setCellValue ( "I".$nomor,  $row['THAN_1_30'] )
			->setCellValue ( "J".$nomor,  $row['THAN_31_60'] )
			->setCellValue ( "K".$nomor,  $row['THAN_61_90'] )
			->setCellValue ( "L".$nomor,  $row['THAN_91_120'] )
			->setCellValue ( "M".$nomor,  $row['THAN_121_150'] )
			->setCellValue ( "N".$nomor,  $row['THAN_151_180'] )
			->setCellValue ( "O".$nomor,  $row['THAN_180'] );
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
/* end - BLOCK MEMBUAT LINK DOWNLOAD*/
?>
