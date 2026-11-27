<?php
require_once("config/configuration.php");
require_once("config/connection.php");
date_default_timezone_set('Asia/Jakarta');


$user=$_POST['user'];
$request=$_POST['request'];
$ps_no=$_POST['no_prospect'];
$no_ktp=$_POST['no_ktp'];
$pefindoId='0000';
$siapanih=$_POST['type_customer'];
$date=date("Y-m-d");
$period=date("Ymd");

if($request == "individual"){
	/* cek ke database apakah id ini sudah ada didalam database ? */
	$call = "{call SP_CHECK_PEFINDO_ID(?,?,?,?)}";
	$params = array(array($pefindoId, SQLSRV_PARAM_IN),array($ps_no, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($period, SQLSRV_PARAM_IN));
	$options =  array( "Scrollable" => "buffered" );
	$exec = sqlsrv_query( $conn, $call, $params, $options) or die( print_r( sqlsrv_errors(), true)); 
	$data = sqlsrv_fetch_array($exec);
	$check=sqlsrv_num_rows($exec);
	
	/* jika sudah ada tampilkan dari database dan data tidak bisa di cek untuk ke 2 kalinya */
	if($check > 0){ 
		$cekdata = $data['CREATE_DATE']->format('d-m-Y');
		//$databranch = $data['OFFICE_NAME'];
			$callCopy = "{call SP_COPY_PEFINDO_OLD_TO_NEW(?,?)}";
		$paramsCopy =  array(array($ps_no, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN));
		
		$execCopy = sqlsrv_query( $conn, $callCopy, $paramsCopy) or die( print_r( sqlsrv_errors(), true)); 
		echo"<script>alert('Hasil Pefindo Telah Disalin,Data sudah pernah di cek pada tanggal $cekdata')</script>";
		echo"<script>window.location='index.php?USERNAME=".$user."&page=scoring-individual&id=".$data['PEFINDO_MAPPING_ID']."&prospect_no=".$ps_no."'</script>";
	/* jika tidak ada, request ke Pefindo kemudian save ke database dan tampilkan dari database */
	}else{
	/* INSERT TO PEFINDO_MAPPING */
		$callSPInsert = "{call SP_INSERT_PEFINDO_ID(?,?,?,?,?)}";
		$paramsInsert = array(array($pefindoId, SQLSRV_PARAM_IN),array($ps_no, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN),array($siapanih, SQLSRV_PARAM_IN));
		$execInsert = sqlsrv_query( $conn, $callSPInsert, $paramsInsert) or die( print_r( sqlsrv_errors(), true));
		
		
		$callSP2 = "{call SP_GET_PEFINDO_ID(?)}";
		$params2 = array(array($pefindoId, SQLSRV_PARAM_IN));
		$exec2 = sqlsrv_query( $conn, $callSP2, $params2) or die( print_r( sqlsrv_errors(), true));
		$data2 = sqlsrv_fetch_array($exec2);
		
		
			$call44 = "{call SP_CHECK_PEFINDO_ID(?,?,?,?)}";
			$params44 = array(array($pefindoId, SQLSRV_PARAM_IN),array($ps_no, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($period, SQLSRV_PARAM_IN));
			$options44 =  array( "Scrollable" => "buffered" );
			$exec44 = sqlsrv_query( $conn, $call44, $params44, $options44) or die( print_r( sqlsrv_errors(), true)); 
			$data44 = sqlsrv_fetch_array($exec44);
			$check=sqlsrv_num_rows($exec44);
				
		
		echo"<script>window.location='index.php?USERNAME=".$user."&page=scoring-individual&id=".$data44['PEFINDO_MAPPING_ID']."&prospect_no=".$ps_no."'</script>";
	}
}
?>