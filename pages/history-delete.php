<?php
require_once("../config/connection.php");

$id=$_GET['id'];
$type=$_GET['type'];
$user=$_GET['username'];

$call = "{call SP_DELETE_HISTORY(?,?)}";
$params = array(array($id, SQLSRV_PARAM_IN),array($type, SQLSRV_PARAM_IN));
$exec = sqlsrv_query( $conn, $call, $params) or die( print_r( sqlsrv_errors(), true)); 
if($exec){
	echo"<script>alert('Data berhasil dihapus');
		window.location='../index.php?username=".$user."&page=history'</script>";
}else{
	echo"<script>alert('Data gagal dihapus');
		history.back();</script>";
}
?>