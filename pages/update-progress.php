<?php
require_once("../config/connection.php");
$id=$_GET['id'];
$user=$_GET['USERNAME'];
$flag=$_GET['flag'];

if($flag==0){
	//update progress
	$call = "{call SP_UPDATE_SLIK_RESULT(?,?)}";
	$param = array(array($id, SQLSRV_PARAM_IN),array(1, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));
	if($exec){
		echo"<script>alert('Silahkan kirim hasil cek di SLIK ke cabang');window.location='../index.php?USERNAME=".$user."&page=pefindonodata';</script>";
	}else{
		echo"<script>alert('Error, hubungi administrator');history.back();</script>";
	}
}else{
	//update progress
	$call = "{call SP_UPDATE_SLIK_RESULT(?,?)}";
	$param = array(array($id, SQLSRV_PARAM_IN),array(2, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));
	if($exec){
		echo"<script>alert('Terimakasih sudah mengerjakan tasklist, selanjutnya cabang dapat menginput hasil SLIK');window.location='../index.php?USERNAME=".$user."&page=pefindonodata';</script>";
	}else{
		echo"<script>alert('Error, hubungi administrator');history.back();</script>";
	}
}



?>