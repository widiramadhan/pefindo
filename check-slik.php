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

$call = "{call SP_INSERT_PEFINDO_NODATA(?,?,?,?,?,?,?,?)}";
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