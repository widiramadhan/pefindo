<?php
require_once("config/configuration.php");


	$branch = $_GET['branch_id'];
	$user = $_GET['USERNAME'];
	//pemohon 
	$callIns = "{call SP_GET_DELETE_SETTING_CA_NON(?,?)}";
	$paramIns = array(	array($branch, SQLSRV_PARAM_IN),
						array($user, SQLSRV_PARAM_IN));
	$execIns = sqlsrv_query( $conn, $callIns, $paramIns) or die( print_r( sqlsrv_errors(), true)); 

	
	if($execIns){
		//update status jadi on progress
		
		echo"<script>alert('Data Berhasil Di Hapus');window.location='index.php?page=tasklist-setting-ca&USERNAME=".$_GET['USERNAME']."'</script>";
	}else{
		echo"<script>alert('Data Gagal Disimpan');history.back();</script>";
	}
?>