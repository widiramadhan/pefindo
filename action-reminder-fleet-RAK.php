<?php
require_once("config/configuration.php");

$user = $_GET['USERNAME'];
$order_no = $_GET['ORDER_NO'];

if (isset($user) && isset($order_no)) {

	# Kirim email 
	$callSPSendReminder = "{call SP_SEND_EMAIL_REMINDER_FLEET_RAK_COMPANY (?, ?)}";
	$paramsSendReminder = array(
		array($order_no, SQLSRV_PARAM_IN),
		array($user, SQLSRV_PARAM_IN)
	);
	
	$execSendReminder = sqlsrv_query($conn, $callSPSendReminder, $paramsSendReminder) or die(print_r(sqlsrv_errors(), true));

	# arahkan ke halaman scoring pefindo
	echo "<script>alert('Berhasil melakukan request fleet order ke HO.'); window.location=\"index.php?page=tasklist-rak&USERNAME=" . $user . "\";</script>";
	
	// die(var_dump([$order_no, $user]));
}
