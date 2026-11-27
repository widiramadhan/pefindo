<?php
require_once("config/configuration.php");
require_once("config/connection.php");
date_default_timezone_set('Asia/Jakarta');


$user = $_POST['user'];
$request = $_POST['request'];
$ps_no = $_POST['no_prospect'];
$no_ktp = $_POST['no_ktp'];
$pefindoId = '0000';
$siapanih = $_POST['type_customer'];
$date = date("Y-m-d");
$period = date("Ymd");

if ($request == "individual") {
	/* cek ke database apakah id ini sudah ada didalam database ? */
	$call = "{call SP_CHECK_PEFINDO_ID(?,?,?,?)}";
	$params = array(array($pefindoId, SQLSRV_PARAM_IN), array($ps_no, SQLSRV_PARAM_IN), array($no_ktp, SQLSRV_PARAM_IN), array($period, SQLSRV_PARAM_IN));
	$options =  array("Scrollable" => "buffered");
	$exec = sqlsrv_query($conn, $call, $params, $options) or die(print_r(sqlsrv_errors(), true));
	$data = sqlsrv_fetch_array($exec);
	$check = sqlsrv_num_rows($exec);

	$call9 = "{call SP_UPDATE_DUKCAPIL_HOLD(?,?,?)}";
	$param9 = array(
		array($ps_no, SQLSRV_PARAM_IN),
		array($no_ktp, SQLSRV_PARAM_IN),
		array('9', SQLSRV_PARAM_IN)
	);
	$exec9 = sqlsrv_query($conn, $call9, $param9) or die(print_r(sqlsrv_errors(), true));

	/* jika sudah ada tampilkan dari database dan data tidak bisa di cek untuk ke 2 kalinya */
	if ($check > 0) {
		$cekdata = $data['CREATE_DATE']->format('d-m-Y');
		//$databranch = $data['OFFICE_NAME'];
		echo "<script>alert('Data sudah pernah di cek pada tanggal $cekdata')</script>";
		echo "<script>window.location='index.php?USERNAME=" . $user . "&page=scoring-individual&id=" . $data['PEFINDO_MAPPING_ID'] . "&prospect_no=" . $ps_no . "'</script>";
		/* jika tidak ada, request ke Pefindo kemudian save ke database dan tampilkan dari database */
	} else {
		/* INSERT TO PEFINDO_MAPPING */
		$callSPInsert = "{call SP_INSERT_PEFINDO_ID(?,?,?,?,?)}";
		$paramsInsert = array(array($pefindoId, SQLSRV_PARAM_IN), array($ps_no, SQLSRV_PARAM_IN), array($no_ktp, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN), array($siapanih, SQLSRV_PARAM_IN));
		$execInsert = sqlsrv_query($conn, $callSPInsert, $paramsInsert) or die(print_r(sqlsrv_errors(), true));


		$callSP2 = "{call SP_GET_PEFINDO_ID(?)}";
		$params2 = array(array($pefindoId, SQLSRV_PARAM_IN));
		$exec2 = sqlsrv_query($conn, $callSP2, $params2) or die(print_r(sqlsrv_errors(), true));
		$data2 = sqlsrv_fetch_array($exec2);


		$call44 = "{call SP_CHECK_PEFINDO_ID(?,?,?,?)}";
		$params44 = array(array($pefindoId, SQLSRV_PARAM_IN), array($ps_no, SQLSRV_PARAM_IN), array($no_ktp, SQLSRV_PARAM_IN), array($period, SQLSRV_PARAM_IN));
		$options44 =  array("Scrollable" => "buffered");
		$exec44 = sqlsrv_query($conn, $call44, $params44, $options44) or die(print_r(sqlsrv_errors(), true));
		$data44 = sqlsrv_fetch_array($exec44);
		$check = sqlsrv_num_rows($exec44);


		echo "<script>window.location='index.php?USERNAME=" . $user . "&page=scoring-individual&id=" . $data44['PEFINDO_MAPPING_ID'] . "&prospect_no=" . $ps_no . "'</script>";
	}
} elseif ($request == "pengurus") {
	/* cek ke database apakah id ini sudah ada didalam database ? */
	$call = "{call SP_CHECK_PEFINDO_ID(?,?,?,?)}";
	$params = array(array($pefindoId, SQLSRV_PARAM_IN), array($ps_no, SQLSRV_PARAM_IN), array($no_ktp, SQLSRV_PARAM_IN), array($period, SQLSRV_PARAM_IN));
	$options =  array("Scrollable" => "buffered");
	$exec = sqlsrv_query($conn, $call, $params, $options) or die(print_r(sqlsrv_errors(), true));
	$data = sqlsrv_fetch_array($exec);
	$check = sqlsrv_num_rows($exec);

	$id_type = 'KTP';
	// // $siapanih = 'PENGURUS';

	$callDetail = "{call CPY_PEFINDO_GETDATA_DETAIL_PENGURUS(?,?,?)}";
	$paramDetail = array(
		array($ps_no, SQLSRV_PARAM_IN),
		array('', SQLSRV_PARAM_IN),
		array($no_ktp, SQLSRV_PARAM_IN),
	);
	$execDetail = sqlsrv_query($conn, $callDetail, $paramDetail) or die(print_r(sqlsrv_errors(), true));
	$dataDetail = sqlsrv_fetch_array($execDetail);


	# update data tasklist
	$callInsert = "{call CPY_UPDATE_TASKLIST_RESULT(?, ?, ?, ?, ?)}";
	$paramInsert = array(
		array($ps_no, SQLSRV_PARAM_IN),
		array($dataDetail['ID_NO'], SQLSRV_PARAM_IN),
		array('802', SQLSRV_PARAM_IN),
		array('28', SQLSRV_PARAM_IN),
		array($user, SQLSRV_PARAM_IN),
	);
	$execInsert = sqlsrv_query($conn, $callInsert, $paramInsert) or die(print_r(sqlsrv_errors(), true));


	# update is_checked
	$callSPUpdateChecked = "{call CPY_UPDATE_CHECKED_DATA(?,?,?,?)}";
	$paramsUpdateChecked = array(
		array($ps_no, SQLSRV_PARAM_IN),
		array($dataDetail['ID_NO'], SQLSRV_PARAM_IN),
		array($id_type, SQLSRV_PARAM_IN),
		array($user, SQLSRV_PARAM_IN)
	);
	$execUpdateChecked = sqlsrv_query($conn, $callSPUpdateChecked, $paramsUpdateChecked) or die(print_r(sqlsrv_errors(), true));

	/* jika sudah ada tampilkan dari database dan data tidak bisa di cek untuk ke 2 kalinya */
	if ($check > 0) {
		$cekdata = $data['CREATE_DATE']->format('d-m-Y');
		//$databranch = $data['OFFICE_NAME'];
		echo "<script>alert('Data sudah pernah di cek pada tanggal $cekdata')</script>";
		echo "<script>window.location='index.php?USERNAME=" . $user . "&page=scoring-individual&id=" . $data['PEFINDO_MAPPING_ID'] . "&prospect_no=" . $ps_no . "'</script>";
		/* jika tidak ada, request ke Pefindo kemudian save ke database dan tampilkan dari database */
	} else {
		/* INSERT TO PEFINDO_MAPPING */
		$callSPInsert = "{call SP_INSERT_PEFINDO_ID(?,?,?,?,?)}";
		$paramsInsert = array(array($pefindoId, SQLSRV_PARAM_IN), array($ps_no, SQLSRV_PARAM_IN), array($no_ktp, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN), array($siapanih, SQLSRV_PARAM_IN));
		$execInsert = sqlsrv_query($conn, $callSPInsert, $paramsInsert) or die(print_r(sqlsrv_errors(), true));


		// // $callSP2 = "{call SP_GET_PEFINDO_ID(?)}";
		// // $params2 = array(array($pefindoId, SQLSRV_PARAM_IN));
		// // $exec2 = sqlsrv_query($conn, $callSP2, $params2) or die(print_r(sqlsrv_errors(), true));
		// // $data2 = sqlsrv_fetch_array($exec2);


		$call44 = "{call SP_CHECK_PEFINDO_ID(?,?,?,?)}";
		$params44 = array(array($pefindoId, SQLSRV_PARAM_IN), array($ps_no, SQLSRV_PARAM_IN), array($no_ktp, SQLSRV_PARAM_IN), array($period, SQLSRV_PARAM_IN));
		$options44 =  array("Scrollable" => "buffered");
		$exec44 = sqlsrv_query($conn, $call44, $params44, $options44) or die(print_r(sqlsrv_errors(), true));
		$data44 = sqlsrv_fetch_array($exec44);
		$check = sqlsrv_num_rows($exec44);


		echo "<script>window.location='index.php?USERNAME=" . $user . "&page=scoring-individual&id=" . $data44['PEFINDO_MAPPING_ID'] . "&prospect_no=" . $ps_no . "'</script>";
	}
}
