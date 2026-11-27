<?php
require_once("config/configuration.php");
require_once("config/connection.php");

$getUsername=$_GET['USERNAME'];
$req_id = $_GET['request_id'];


	$id=$_POST['id'];
	$no_ktp=$_POST['no_ktp'];
	$nama=$_POST['name'];
	$date=$_POST['date'];
	$mother_nm=$_POST['mother_name'];
	$siapanih=$_POST['tipe_cust'];
	$order_no = $_POST['order_no'];

	$call = "{call SP_GET_DETAIL_REQUEST_MH(?,?)}";
	$param = array(array($id, SQLSRV_PARAM_IN),array($req_id, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_defaults(), true)); 
	$data = sqlsrv_fetch_array($exec);
	
	$callCheck = "{call SP_CHECK_SLIK_CHECKED(?)}";
	$paramCheck = array(array($no_ktp, SQLSRV_PARAM_IN));
	$optionCheck = array( "Scrollable" => "buffered" );
	$execCheck = sqlsrv_query($conn, $callCheck, $paramCheck,$optionCheck) or die( print_r( sqlsrv_errors(), true));
	$dataCheck =  sqlsrv_fetch_array($execCheck);
	$rowsCheck =sqlsrv_num_rows($execCheck);
	
	$callCheck1 = "{call SP_CHECK_SLIK_CHECKED_PROSPECT(?,?)}";
	$paramCheck1 = array(array($no_ktp, SQLSRV_PARAM_IN),
						 array($order_no, SQLSRV_PARAM_IN));
	$optionCheck1 = array( "Scrollable" => "buffered" );
	$execCheck1 = sqlsrv_query($conn, $callCheck1, $paramCheck1,$optionCheck1) or die( print_r( sqlsrv_errors(), true));
	$dataCheck1 =  sqlsrv_fetch_array($execCheck1);
	$rowsCheck1 =sqlsrv_num_rows($execCheck1);

	if($no_ktp==""){
		echo"<script>alert('Nomor KTP tidak boleh kosong');history.back();</script>";
	}else if($nama==""){
		echo"<script>alert('Nama tidak boleh kosong');history.back();</script>";
	}else if($date==""){
		echo"<script>alert('Tanggal lahir tidak boleh kosong');history.back();</script>";
	}else if(substr($no_ktp,0,1) == "0"){
		echo"<script>alert('Nomor KTP tidak boleh berawalan 0');history.back();</script>";
	}else if(substr($no_ktp,-4) == "0000"){
		echo"<script>alert('4 Digit Nomor KTP tidak boleh 0000');history.back();</script>";
	}else if(strlen(trim($no_ktp)) <> 16){
		echo"<script>alert('NIK harus 16 digit');history.back();</script>";
	}else if(preg_match("/^[a-zA-Z]$/", $no_ktp)){
		echo"<script>alert('NIK tidak boleh mengandung alphabet');history.back();</script>";
	}else if($rowsCheck1 > 0){
			echo"<script>alert('Customer ini pernah melakukan pengecekan SLIK pada tanggal ".$dataCheck1['CREATE_DATE']->format("d F Y")." ');window.location='index.php?page=detail-pengecekan-mh-branch&USERNAME=".$getUsername."&id=".$id."&request_id=".$req_id."'</script>";	
	}else{
	  
		
		//echo"<script>alert('Masuk Else');history.back();</script>";
		
		/***** CHECK BLACKLIST *****/
		$call_bls = "{call SP_CHECK_BLACKLIST_REQ_MH(?,?,?,?,?,?,?,?,?)}";
		$params_bls = array(
						array($id, SQLSRV_PARAM_IN),
						array($req_id, SQLSRV_PARAM_IN),
						array($no_ktp, SQLSRV_PARAM_IN),
						array($nama, SQLSRV_PARAM_IN),
						array($date, SQLSRV_PARAM_IN),
						array($mother_nm, SQLSRV_PARAM_IN),
						array($data['ORDER_NO'], SQLSRV_PARAM_IN),
						array($getUsername, SQLSRV_PARAM_IN),
						array($siapanih, SQLSRV_PARAM_IN)
					);
		$options =  array( "Scrollable" => "buffered" );
		$exec_bls = sqlsrv_query($conn, $call_bls, $params_bls, $options) or die( print_r( sqlsrv_errors(), true));
		
		$callCheck = "{call PEFINDO_GETDATA_DATA_TASKLIST(?,?)}";
		$paramsCheck = array(
						array($data['ORDER_NO'], SQLSRV_PARAM_IN),
						array($no_ktp, SQLSRV_PARAM_IN)
					);
		$options =  array( "Scrollable" => "buffered" );
		$execCheck = sqlsrv_query($conn, $callCheck, $paramsCheck, $options) or die( print_r( sqlsrv_errors(), true));
		$dataCheck = sqlsrv_fetch_array($execCheck);
		
		if($dataCheck == ''){
				$call6 = "{call SP_INSERT_DUKCAPIL_HOLD_1(?,?,?,?,?,?,?,?)}";
		$param6 = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),
						array($no_ktp, SQLSRV_PARAM_IN),
						array($nama, SQLSRV_PARAM_IN),
						array($date, SQLSRV_PARAM_IN),
						array($siapanih, SQLSRV_PARAM_IN),
						array('KTP', SQLSRV_PARAM_IN),
						array($getUsername, SQLSRV_PARAM_IN),
						array('8', SQLSRV_PARAM_IN));
		$exec6 = sqlsrv_query( $conn, $call6, $param6) or die( print_r( sqlsrv_errors(), true)); 		
		}
		
	
		
		if($exec){
		echo"<script>alert('Data berhasil disimpan');window.location='index.php?page=detail-pengecekan-mh-branch&USERNAME=".$getUsername."&id=".$id."&request_id=".$req_id."'</script>";
		}else{
			echo"<script>alert('Data gagal disimpan');history.back();</script>";
		}
		/***** END CHECK BLACKLIST *****/	
		

	}

?>


<?php
/******** PROGRESS UPDATE STATUS ********/

/******** END PROGRESS UPDATE STATUS ********/
?>