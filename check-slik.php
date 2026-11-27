<?php
require_once("config/configuration.php");
require_once("config/connection.php");

$prospect_no=$_POST['prospect_no'];
$no_ktp=$_POST['no_ktp'];
$nama=$_POST['nama'];
$birth_dt=$_POST['birth_dt'];
$cust_type=$_POST['cust_type'];
$id_type=$_POST['id_type'];
$username=$_POST['username'];
$tipe_cust=$_POST['tipe_cust'];

if($no_ktp==""){
	echo"<script>alert('Nomor KTP tidak boleh kosong, silahkan lakukan edit data di CONFINS');history.back();</script>";
}else if($nama==""){
	echo"<script>alert('Nama tidak boleh kosong, silahkan lakukan edit data di CONFINS');history.back();</script>";
}else if($birth_dt==""){
	echo"<script>alert('Tanggal lahir tidak boleh kosong, silahkan lakukan edit data di CONFINS');history.back();</script>";
}else if(substr($no_ktp,0,1) == "0"){
	echo"<script>alert('Nomor KTP tidak boleh berawalan 0');history.back();</script>";
}else if(substr($no_ktp,-4) == "0000"){
	echo"<script>alert('4 Digit Nomor KTP tidak boleh 0000');history.back();</script>";
}else if(strlen(trim($no_ktp)) <> 16){
	echo"<script>alert('NIK harus 16 digit');history.back();</script>";
}else if(preg_match("/^[a-zA-Z]$/", $no_ktp)){
	echo"<script>alert('NIK tidak boleh mengandung alphabet');history.back();</script>";
}else{
	//----# Insert LOG
	$SourceLogPfndNtfnd = "PEFINDO";
	$StatusLogPfndNtfnd = "DATA TIDAK DITEMUKAN";

	$callSPLogPfndNtfnd = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
	$paramsLogPfndNtfnd = array(array($prospect_no, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogPfndNtfnd, SQLSRV_PARAM_IN),array($StatusLogPfndNtfnd, SQLSRV_PARAM_IN), array($username, SQLSRV_PARAM_IN));
	$execLogPfndNtfnd = sqlsrv_query( $conn, $callSPLogPfndNtfnd, $paramsLogPfndNtfnd) or die( print_r( sqlsrv_errors(), true));
	//----# Insert LOG End
	
	//cek ke pefindo mapping no data
	$cek = "{call SP_CHECK_EXPIRE_DATE_SLIK(?,?)}";
	$paramsCek = array(
					array($prospect_no, SQLSRV_PARAM_IN),
					array($tipe_cust, SQLSRV_PARAM_IN)
				);
	$optionsCek =  array( "Scrollable" => "buffered" );
	$execCek = sqlsrv_query( $conn, $cek, $paramsCek, $optionsCek) or die( print_r( sqlsrv_errors(), true));
	$dataCek = sqlsrv_fetch_array($execCek);
	$numrows=sqlsrv_num_rows($execCek);
	
	if($numrows <> 0){
		date_default_timezone_set('Asia/Jakarta');
		$newDate=new Datetime(date('Y-m-d'));
		$dateFromDB=$dataCek['CREATE_DATE'];
		$interval=$dateFromDB->diff($newDate);
		
		if($interval->days > 31){
			$call = "{call SP_INSERT_PEFINDO_NODATA_NEW(?,?,?,?,?,?,?,?)}";
			$params = array(
							array($prospect_no, SQLSRV_PARAM_IN),
							array($no_ktp, SQLSRV_PARAM_IN),
							array($nama, SQLSRV_PARAM_IN),
							array($birth_dt, SQLSRV_PARAM_IN),
							array($cust_type, SQLSRV_PARAM_IN),
							array($id_type, SQLSRV_PARAM_IN),
							array($username, SQLSRV_PARAM_IN),
							array($tipe_cust, SQLSRV_PARAM_IN)
						);
			$options =  array( "Scrollable" => "buffered" );
			$exec = sqlsrv_query( $conn, $call, $params, $options) or die( print_r( sqlsrv_errors(), true));
			if($exec){
				echo"<script>window.location='index.php?USERNAME=".$username."&page=pefindonodata'</script>";
			}else{
				echo"<script>window.location='index.php?USERNAME=".$username."&page=error'</script>";
			}
		}else{
			echo"<script>alert('Data sudah pernah di cek pada tanggal ".$dataCek['CREATE_DATE']->format('Y-m-d')." oleh $dataCek[CREATE_USER]. Silahkan cek di Menu Tasklist SLIK atau History');</script>";
			echo"<script>history.back();</script>";
		}
	}else{
		$call = "{call SP_INSERT_PEFINDO_NODATA_NEW(?,?,?,?,?,?,?,?)}";
		$params = array(
						array($prospect_no, SQLSRV_PARAM_IN),
						array($no_ktp, SQLSRV_PARAM_IN),
						array($nama, SQLSRV_PARAM_IN),
						array($birth_dt, SQLSRV_PARAM_IN),
						array($cust_type, SQLSRV_PARAM_IN),
						array($id_type, SQLSRV_PARAM_IN),
						array($username, SQLSRV_PARAM_IN),
						array($tipe_cust, SQLSRV_PARAM_IN)
					);
		$options =  array( "Scrollable" => "buffered" );
		$exec = sqlsrv_query( $conn, $call, $params, $options) or die( print_r( sqlsrv_errors(), true));
		if($exec){
			echo"<script>window.location='index.php?USERNAME=".$username."&page=pefindonodata'</script>";
		}else{
			echo"<script>window.location='index.php?USERNAME=".$username."&page=error'</script>";
		}
	}
}