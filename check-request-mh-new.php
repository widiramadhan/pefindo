<?php
require_once("config/configuration.php");
require_once("config/connection.php");

ini_set('memory_limit','256M'); // This also needs to be increased in some cases. Can be changed to a higher value as per need)
ini_set('sqlsrv.ClientBufferMaxKBSize','524288'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size','524288'); // Setting to 512M - for pdo_sqlsrv

$getUsername=$_GET['USERNAME'];
$req_id = $_GET['request_id'];

if(isset($_POST['submit'])){
	$assignment_id = $_POST['assignment_id'];
	$order_no = $_POST['order_no'];
	$status = $_POST['status'];
	$notes = $_POST['notes'];
	
	$call = "{call SP_INSERT_RESPONSE_REQUEST_MH(?,?,?,?,?,?)}";
	$param = array(array($assignment_id, SQLSRV_PARAM_IN),array($req_id, SQLSRV_PARAM_IN),array($order_no, SQLSRV_PARAM_IN),array($status, SQLSRV_PARAM_IN),array($notes, SQLSRV_PARAM_IN),array($getUsername, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_defaults(), true)); 
	
	//update status jadi finish
	$call4 = "{call UPDATE_STATUS_REQUEST_MH(?,?,?)}";
	$param4 = array(array($assignment_id, SQLSRV_PARAM_IN),array($req_id, SQLSRV_PARAM_IN),array('3', SQLSRV_PARAM_IN));
	$exec4 = sqlsrv_query( $conn, $call4, $param4) or die( print_r( sqlsrv_defaults(), true)); 
	$data4= sqlsrv_fetch_array($exec4);
	
	if($exec){
		echo"<script>alert('Data berhasil disimpan');window.location='index.php?page=hasil-pengecekan&USERNAME=".$getUsername."'</script>";
	}else{
		echo"<script>alert('Data gagal disimpan');history.back();</script>";
	}
}else{
	$id=$_POST['id'];
	$no_ktp=$_POST['no_ktp'];
	$nama=$_POST['name'];
	$date=$_POST['date'];
	$mother_nm=$_POST['mother_name'];
	$siapanih=$_POST['tipe_cust'];

	$call = "{call SP_GET_DETAIL_REQUEST_MH(?,?)}";
	$param = array(array($id, SQLSRV_PARAM_IN),array($req_id, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_defaults(), true)); 
	$data = sqlsrv_fetch_array($exec);


$call9 = "{call VBS_GET_DATA_CUSTOMER(?,?)}";
$param9 = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),
				array($siapanih, SQLSRV_PARAM_IN));
$options9 =  array( "Scrollable" => "buffered" );
$exec9 = sqlsrv_query( $conn, $call9, $param9, $options9) or die( print_r( sqlsrv_errors(), true));
$data9 = sqlsrv_fetch_array($exec9);

$callDuk = "{call SP_CHECK_LOG_DUKCAPIL_VBS(?,?)}";
$paramsDuk = array(
				array($data['ORDER_NO'], SQLSRV_PARAM_IN),
				array($no_ktp, SQLSRV_PARAM_IN)
			);
$options =  array( "Scrollable" => "buffered" );
$execDuk = sqlsrv_query($conn, $callDuk, $paramsDuk, $options) or die( print_r( sqlsrv_errors(), true)); 
$dataDuk = sqlsrv_fetch_array($execDuk);
$checkDukcapil=sqlsrv_num_rows($execDuk);
	
$callUnlock = "{call SP_GET_VALIDASI_DUKCAPIL_UNLOCK(?,?)}";
$paramsUnlock = array(
				array($data['ORDER_NO'], SQLSRV_PARAM_IN),
				array($no_ktp, SQLSRV_PARAM_IN)
			);
$options =  array( "Scrollable" => "buffered" );
$execUnlock = sqlsrv_query($conn, $callUnlock, $paramsUnlock, $options) or die( print_r( sqlsrv_errors(), true)); 
$dataUnlock = sqlsrv_fetch_array($execUnlock);
$checkUnlock=sqlsrv_num_rows($execUnlock);

$call7 = "{call SP_CHECK_DUKCAPIL_ERROR_VBS(?,?)}";
$param7 = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),
				array($no_ktp, SQLSRV_PARAM_IN));
$exec7 = sqlsrv_query( $conn, $call7, $param7) or die( print_r( sqlsrv_errors(), true));
$data7 = sqlsrv_fetch_array($exec7);

$callDate = "{call SP_GET_DATE_SLIK}";
$execDate = sqlsrv_query( $conn, $callDate) or die( print_r( sqlsrv_errors(), true));
$dataDate = sqlsrv_fetch_array($execDate);

$callCekDuk = "{call SP_GET_RESPONSE_RESULT_CHECK_DUKCAPIL(?,?)}";
$paramCekDuk = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN));
$execCekDuk = sqlsrv_query( $conn, $callCekDuk, $paramCekDuk) or die( print_r( sqlsrv_errors(), true));
$dataCekDuk =sqlsrv_fetch_array($execCekDuk);
/*
var_dump($checkDukcapil);
var_dump($data7);
var_dump($checkUnlock);
*/
if($dataCekDuk['DUKCAPIL']==1){
	
}else if($checkDukcapil >= 0){
	if($data7['RESULT'] == '1'){
		if($checkUnlock >= 1){
		
		}else{
			echo"<script>alert('Data terkena validasi dukcapil, silahkan lakukan pengkinian data');history.back();</script>";

		}
		
		
	}else{
		
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
	}else{		
		//echo"<script>alert('Masuk Else');history.back();</script>";

$NIK= $no_ktp;
$NAMA_LGKP= $nama;
$ALAMAT="";

IF($data9['STATUS_KAWIN'] == "SUDAH KAWIN"){
	$STATUS_KAWIN= "KAWIN";
}Else IF($data9['STATUS_KAWIN'] == "BELUM KAWIN"){
	$STATUS_KAWIN= "BELUM KAWIN";
}Else{
	$STATUS_KAWIN=$data9['STATUS_KAWIN'];
}
	
	
$TMPT_LHR= "";
$TGL_LHR1= $date;
$TGL_LHR2 = strtotime($TGL_LHR1);
$TGL_LHR =  date("d-m-Y", $TGL_LHR2);

// $TGL_LHR= "06-07-1987";
$KAB_NAME= " ";
$KEC_NAME= " ";
$KEL_NAME= " ";
$PROP_NAME= "";
$NO_RT= "";
$NO_RW= "";
$JENIS_KLMIN= "";
$JENIS_PKRJN= "";
$NAMA_LGKP_IBU= $mother_nm;
$TRESHOLD= "90";
//$USER_ID= "10643174202101271dummy_suzuki_finance";
$USER_ID= "25082022141010SUZUKI_FINANCE4288";
//$PASSWORD= "123456";
$PASSWORD= "MZ33CU";
$IP_USER= "172.16.2.5";

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
		/***** END CHECK BLACKLIST *****/	
		
		$call_sd = "{call SP_GET_DUKCAPIL_RESULT(?,?)}";
		$params_sd = array(
						array($data['ORDER_NO'], SQLSRV_PARAM_IN),
						array($no_ktp, SQLSRV_PARAM_IN)
					);
		$options =  array( "Scrollable" => "buffered" );
		$exec_sd = sqlsrv_query($conn, $call_sd, $params_sd, $options) or die( print_r( sqlsrv_errors(), true));
		$num_rows = sqlsrv_num_rows($exec_sd);
		if($num_rows == 0){
			/***** CHECK DUKCAPIL *****/
			$param_dukcapil_array= array('NIK' => $NIK, 'NAMA_LGKP' => $NAMA_LGKP, 'ALAMAT' => $ALAMAT, 'STATUS_KAWIN' => $STATUS_KAWIN, 'TMPT_LHR' => $TMPT_LHR, 'TGL_LHR' => $TGL_LHR, 
								'KAB_NAME' => $KAB_NAME, 'KEC_NAME' => $KEC_NAME, 'KEL_NAME' => $KEL_NAME, 'PROP_NAME' => $PROP_NAME, 'NO_RT' => $NO_RT, 'JENIS_KLMIN' => $JENIS_KLMIN, 
								'JENIS_PKRJN' => $JENIS_PKRJN, 'NAMA_LGKP_IBU' => $NAMA_LGKP_IBU, 'TRESHOLD' => $TRESHOLD, 'USER_ID' => $USER_ID, 'PASSWORD' => $PASSWORD, 'IP_USER' => $IP_USER);

			$param_dukcapil = json_encode($param_dukcapil_array);
			$curlDkUpil = curl_init();
			curl_setopt_array($curlDkUpil, array(
				//CURLOPT_URL => "http://172.16.160.84:8000/dukcapil/get_json/suzuki_finance/nik_verifby_elemen",
				//CURLOPT_URL => "http://172.16.160.128:8000/dukcapil/get_json/suzuki_finance/nik_verifby_elemen",
				//CURLOPT_URL => "https://172.16.160.177:8000/dukcapil/get_json/SUZUKI_FINANCE/CALL_VERIFY_BY_ELEMEN",
				CURLOPT_URL => "http://172.16.160.186:8000/dukcapil/get_json/990040921021160/CALL_VERIFY_BY_ELEMEN",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 60,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => "$param_dukcapil",
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_HTTPHEADER => array(
					'Accept: application/json',
					'Content-Type: application/json',
					"Postman-Token: ae0ace2e-aa92-4d66-8d14-d67edb42fa84",
					"cache-control: no-cache"
				),
			));

			$responseDkUpil = curl_exec($curlDkUpil);
			$errDkUpil = curl_error($curlDkUpil);
			curl_close($curlDkUpil);
			$resultDukcapil = json_decode($responseDkUpil, true);
			
			
			
			
							
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'http://172.16.160.189/data_balikan/public/Api/Nik_store',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>array('nik' => $no_ktp,
										'id_lembaga' => '041148', 
										'nama_lembaga' => 'PT. SUZUKI FINANCE INDONESIA', 
										//'param' => '[{"id_lembaga": "041148","NIK": "'.$no_ktp.'" ,"indexno": "0"},{ "id_lembaga": "041148","NO_ORDER":  "'.$data['ORDER_NO'].'","indexno": "1"}]'),
										'param' => '[{"NO_CIF": "'.$data['ORDER_NO'].'"}]'),
			  CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer nkqAt2em3pjIc9bR4xJJMNG8PT7yqVFLlu2RpfJNHHLPRNb70eZLnSf5A1cG8HcX5hrXpF4Av8A3C8YqVNxzdpuBZ4VZgvDmoAgB',
				'Cookie: adminduk_session=eyJpdiI6ImZvSkY1SG1SeXJOa01xcHpGUUhkN0E9PSIsInZhbHVlIjoidDhsbjBrbEdSQ015NE8rS29OcDRzd0YybW9CbTJacmI4ZG5UZno3XC81R2lnOTllbFBXRklSSnFhcjVOZG9zcGVYVmlqTXBrZ0ZYZjZEWHZCV0p4akxBPT0iLCJtYWMiOiI5OWNkZDMxZWM1OGI5MzU2NmE4NDhkNGM0NTQzOWZiNWMxZDM3ZWZiZGUxM2I1NTkzOTE0MTIwMzY1ZDhhY2QyIn0%3D'
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);


			$response_balikan = str_replace('"',"",$response);
				
			$callSPLogDkUpilNtValid = "{call SP_INSERT_LOG_DATA_BALIKAN(?,?,?,?)}";
			$paramsLogDkUpilNtValid = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN), array($response_balikan, SQLSRV_PARAM_IN),array($getUsername, SQLSRV_PARAM_IN));
			$execLogDkUpilNtValid = sqlsrv_query( $conn, $callSPLogDkUpilNtValid, $paramsLogDkUpilNtValid) or die( print_r( sqlsrv_errors(), true));	
					
						
			
			if(empty($resultDukcapil)){
				//----# Insert LOG
				$SourceLogDkUpilNtValid = "DUKCAPIL";
				$StatusLogDkUpilNtValid = "KTP TIDAK VALID";
				
					echo "<script>alert('Warning : (Silahkan lakukan pengecekan ulang.!)');history.back();</script>";
					
				/*
				$callSPLogDkUpilNtValid = "{call SP_INSERT_LOG_BYSOURCE_NEWVERSE(?,?,?,?,?)}";
				$paramsLogDkUpilNtValid = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN), array($SourceLogDkUpilNtValid, SQLSRV_PARAM_IN),array($StatusLogDkUpilNtValid, SQLSRV_PARAM_IN), array($getUsername, SQLSRV_PARAM_IN));
				$execLogDkUpilNtValid = sqlsrv_query( $conn, $callSPLogDkUpilNtValid, $paramsLogDkUpilNtValid) or die( print_r( sqlsrv_errors(), true));				
				//----# Insert LOG End
				
				//cancel order otomatis saat NIK tidak ditemukan di DUKCAPIL
				$callCancel = "{call SP_UPDATE_ASSIGNMENT_STATUS(?,?,?,?,?,?)}";
				$paramsCancel = array(array($id, SQLSRV_PARAM_IN),array($req_id, SQLSRV_PARAM_IN), array($no_ktp, SQLSRV_PARAM_IN),array($data['ORDER_NO'], SQLSRV_PARAM_IN), array($getUsername, SQLSRV_PARAM_IN),array($siapanih, SQLSRV_PARAM_IN));
				$execCancel = sqlsrv_query( $conn, $callCancel, $paramsCancel) or die( print_r( sqlsrv_errors(), true));			
					//GET LOG ID
						$callGetLog = "{call SP_GET_LOG_ID_DUKCAPIL(?,?)}";
						$paramsGetLog = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN));
						$execGetLog = sqlsrv_query( $conn, $callGetLog, $paramsGetLog) or die( print_r( sqlsrv_errors(), true));
						$dataGetLog = sqlsrv_fetch_array($execGetLog);
						$idLog = $dataGetLog['LOG_CHECK_BYSOURCE_ID'];
						
				$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
				$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('5', SQLSRV_PARAM_IN),array($getUsername, SQLSRV_PARAM_IN));
				$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
				echo "<script>alert('Error : ".$StatusLogDkUpilNtValid." (Pada saat pengecekan NIK ke Dukcapil.!)');history.back();</script>";
				*/		
				//echo "<script>alert('Error : ".$StatusLogDkUpilNtValid." (Pada saat pengecekan No KTP di Dukcapil.!)')</script>";
				//$Warning_Data = $Warning_Data." - KTP TIDAK VALID (Pada saat pengecekan No KTP di Dukcapil.!) ";
			}else{
		
				if($errDkUpil){
					//----# Insert LOG
					$SourceLogDkUpil = "DUKCAPIL";
					$StatusLogDkUpil = "ERROR";
			
					$callSPLogDkUpil = "{call SP_INSERT_LOG_BYSOURCE_NEWVERSE(?,?,?,?,?)}";
					$paramsLogDkUpil = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkUpil, SQLSRV_PARAM_IN),array($StatusLogDkUpil, SQLSRV_PARAM_IN), array($getUsername, SQLSRV_PARAM_IN));
					$execLogDkUpil = sqlsrv_query( $conn, $callSPLogDkUpil, $paramsLogDkUpil) or die( print_r( sqlsrv_errors(), true));
					
					//cancel order otomatis saat NIK tidak ditemukan di DUKCAPIL
					$callCancel = "{call SP_UPDATE_ASSIGNMENT_STATUS(?,?,?,?,?,?)}";
					$paramsCancel = array(array($id, SQLSRV_PARAM_IN),array($req_id, SQLSRV_PARAM_IN), array($no_ktp, SQLSRV_PARAM_IN),array($data['ORDER_NO'], SQLSRV_PARAM_IN), array($getUsername, SQLSRV_PARAM_IN),array($siapanih, SQLSRV_PARAM_IN));
					$execCancel = sqlsrv_query( $conn, $callCancel, $paramsCancel) or die( print_r( sqlsrv_errors(), true));
					
					//----# Insert LOG End
					echo "<script>alert('Error : ".$errDkUpil." (Pada saat pengecekan NIK ke Dukcapil.!)');
						window.location='index.php?page=hasil-pengecekan&USERNAME=".$getUsername."'</script>";
				}else{
				
					if(isset($resultDukcapil['content'][0]['RESPONSE'])) {
						//----# Insert LOG
							
						$SourceLogDkUpilnotfound = "DUKCAPIL";
						$StatusLogDkUpilnotfound = strtoupper($resultDukcapil['content'][0]['RESPONSE']);

						$callSPLogDkUpilnotfound = "{call SP_INSERT_LOG_BYSOURCE_NEWVERSE(?,?,?,?,?)}";
						$paramsLogDkUpilnotfound = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkUpilnotfound, SQLSRV_PARAM_IN),array($StatusLogDkUpilnotfound, SQLSRV_PARAM_IN), array($getUsername, SQLSRV_PARAM_IN));
						$execLogDkUpilnotfound = sqlsrv_query( $conn, $callSPLogDkUpilnotfound, $paramsLogDkUpilnotfound) or die( print_r( sqlsrv_errors(), true));
						
							
						$callGetLog = "{call SP_GET_LOG_ID_DUKCAPIL_NOT_FOUND(?,?)}";
						$paramsGetLog = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN));
						$execGetLog = sqlsrv_query( $conn, $callGetLog, $paramsGetLog) or die( print_r( sqlsrv_errors(), true));
						$dataGetLog = sqlsrv_fetch_array($execGetLog);
						$idLog = $dataGetLog['LOG_CHECK_BYSOURCE_ID'];
						
						$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
						$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('5', SQLSRV_PARAM_IN),array($getUsername, SQLSRV_PARAM_IN));
						$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
						
						
						if($execLogDkUpilnotfound === false){
							echo"<script>alert('NIK Tersebut Tidak ditemukan di Dukcapil.!');history.back();</script>";
						}
						//----# Insert LOG End
						
						echo "<script>alert('Error : ".$StatusLogDkUpilnotfound." (Pada saat pengecekan NIK di Dukcapil!)');history.back();</script>";
						
						//$Warning_Data = $Warning_Data."  ".$StatusLogDkUpilnotfound."  (Pada saat pengecekan NO KTP di Dukcapil.!) ";
						
						$DkcplCustType = "";
						$DkcplNIK = "";
						$DkcplNAMA_LGKP = "";
						$DkcplJENIS_KLMIN = "";
						$DkcplTMPT_LHR =  "";
						$DkcplTGL_LHR = "";
						$DkcplSTATUS_KAWIN = "";
						$DkcplNAMA_LGKP_IBU = "";
						$DkcplJENIS_PKRJN = "";
						$DkcplALAMAT = "";
						$DkcplNO_RT = "";
						$DkcplNO_RW = "";
						$DkcplNO_PROP = "";
						$DkcplPROP_NAME = "";
						$DkcplNO_KAB = "";
						$DkcplKAB_NAME = "";
						$DkcplKEC_NAME = "";
						$DkcplNO_KEL = "";
						$DkcplNO_KEC = "";
						$DkcplKEL_NAME = "";
					}else{
						$callStatNikah = "{call SP_GET_VERIFIKASI_VERIFIED(?,?)}";
						$paramsStatNikah = array(
										array($data['ORDER_NO'], SQLSRV_PARAM_IN),
										array($no_ktp, SQLSRV_PARAM_IN)
									);
						$optionsStatNikah =  array( "Scrollable" => "buffered" );
						$execStatNikah = sqlsrv_query($conn, $callStatNikah, $paramsStatNikah, $optionsStatNikah) or die( print_r( sqlsrv_errors(), true)); 
						$checkStatNikah=sqlsrv_num_rows($execStatNikah);
						//----# Insert LOG
						foreach($resultDukcapil['content'] as $contentdata){
						$DkcplCustType = "PEMOHON";
							$DkcplNIK = $contentdata['NIK'];
							$DkcplNAMA_LGKP = $contentdata['NAMA_LGKP'];
							$DkcplJENIS_KLMIN = $contentdata['JENIS_KLMIN'];
							$DkcplTMPT_LHR = $contentdata['TMPT_LHR'];
							$DkcplTGL_LHR = $contentdata['TGL_LHR'];
							//$DkcplTGL_LHR = $contentdata['TGL_LHR'];
							$DkcplSTATUS_KAWIN = $contentdata['STATUS_KAWIN'];
							$DkcplNAMA_LGKP_IBU = $contentdata['NAMA_LGKP_IBU'];
							$DkcplJENIS_PKRJN = $contentdata['JENIS_PKRJN'];
							$DkcplALAMAT = $contentdata['ALAMAT'];
							$DkcplNO_RT = $contentdata['NO_RT'];
							$DkcplNO_RW = $contentdata['NO_RW'];
							$DkcplPROP_NAME = $contentdata['PROP_NAME'];
							$DkcplKAB_NAME = $contentdata['KAB_NAME'];
							$DkcplKEC_NAME = $contentdata['KEC_NAME'];
							$DkcplKEL_NAME = $contentdata['KEL_NAME'];
							
						if($DkcplNAMA_LGKP != "Sesuai (100)" && $DkcplNAMA_LGKP != "Sesuai (99)" && $DkcplNAMA_LGKP != "Sesuai (98)" && $DkcplNAMA_LGKP != "Sesuai (97)" 
															 && $DkcplNAMA_LGKP != "Sesuai (96)" && $DkcplNAMA_LGKP != "Sesuai (95)" && $DkcplNAMA_LGKP != "Sesuai (94)"
															 && $DkcplNAMA_LGKP != "Sesuai (93)" && $DkcplNAMA_LGKP != "Sesuai (92)" && $DkcplNAMA_LGKP != "Sesuai (91)"
															 && $DkcplNAMA_LGKP != "Sesuai (90)"){
							$StatusLogDkcpl1 = "DATA DITEMUKAN TIDAK SESUAI";
							
						}else{
							$StatusLogDkcpl1 = "VALID";
						}
						
						if($DkcplTGL_LHR == "Tidak Sesuai"){
							$StatusLogDkcpl2 = "DATA DITEMUKAN TIDAK SESUAI";
							
						}else{
							$StatusLogDkcpl2 = "VALID";
						}
						
							
						if($checkStatNikah > 0){ 
								$StatusLogDkcpl3 = "VALID";
								}else{
						if($DkcplSTATUS_KAWIN == "Tidak Sesuai"){
								$StatusLogDkcpl3 = "DATA DITEMUKAN TIDAK SESUAI";
							
						}else{
							$StatusLogDkcpl3 = "VALID";
						}
							
							}
							
							 	
						/* if(strtoupper($siapanih) == "PEMOHON"){ */
							if($DkcplNAMA_LGKP_IBU != "Sesuai (100)"  && $DkcplNAMA_LGKP_IBU != "Sesuai (99)" && $DkcplNAMA_LGKP_IBU != "Sesuai (98)" && $DkcplNAMA_LGKP_IBU != "Sesuai (97)" 
															 && $DkcplNAMA_LGKP_IBU != "Sesuai (96)" && $DkcplNAMA_LGKP_IBU != "Sesuai (95)" && $DkcplNAMA_LGKP_IBU != "Sesuai (94)"
															 && $DkcplNAMA_LGKP_IBU != "Sesuai (93)" && $DkcplNAMA_LGKP_IBU != "Sesuai (92)" && $DkcplNAMA_LGKP_IBU != "Sesuai (91)"
															 && $DkcplNAMA_LGKP_IBU != "Sesuai (90)"){
								$StatusLogDkcpl4 = "DATA DITEMUKAN TIDAK SESUAI";
							
								}else{
									$StatusLogDkcpl4 = "VALID";
								}
									
							/*				
							}else{
										$StatusLogDkcpl4 = "VALID";
									} */
						}						
						
						
						$SourceLogDkcpl = "DUKCAPIL";
						//$StatusLogDkcpl = "VALID";
						
						if($StatusLogDkcpl1 == "VALID" && $StatusLogDkcpl2 == "VALID" && $StatusLogDkcpl3 == "VALID" && $StatusLogDkcpl4 == "VALID"){
						$StatusLogDkcpl = "VALID";
						}else{
							$StatusLogDkcpl = "DATA DITEMUKAN TIDAK SESUAI";
						}

						$callSPLogDkcpl = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
						$paramsLogDkcpl = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkcpl, SQLSRV_PARAM_IN),array($StatusLogDkcpl, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
						$execLogDkcpl = sqlsrv_query( $conn, $callSPLogDkcpl, $paramsLogDkcpl) or die( print_r( sqlsrv_errors(), true));
							
					
						//----# Insert LOG End
						
						//GET LOG ID
						
						$callGetLog = "{call SP_GET_LOG_ID_DUKCAPIL(?,?)}";
						$paramsGetLog = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN));
						$execGetLog = sqlsrv_query( $conn, $callGetLog, $paramsGetLog) or die( print_r( sqlsrv_errors(), true));
						$dataGetLog = sqlsrv_fetch_array($execGetLog);
						$idLog = $dataGetLog['LOG_CHECK_BYSOURCE_ID'];
						
						foreach($resultDukcapil['content'] as $contentdata){
						$DkcplCustType = "PEMOHON";
							$DkcplNIK = $contentdata['NIK'];
							$DkcplNAMA_LGKP = $contentdata['NAMA_LGKP'];
							$DkcplJENIS_KLMIN = $contentdata['JENIS_KLMIN'];
							$DkcplTMPT_LHR = $contentdata['TMPT_LHR'];
							$DkcplTGL_LHR = $contentdata['TGL_LHR'];
							//$DkcplTGL_LHR = $contentdata['TGL_LHR'];
							$DkcplSTATUS_KAWIN = $contentdata['STATUS_KAWIN'];
							$DkcplNAMA_LGKP_IBU = $contentdata['NAMA_LGKP_IBU'];
							$DkcplJENIS_PKRJN = $contentdata['JENIS_PKRJN'];
							$DkcplALAMAT = $contentdata['ALAMAT'];
							$DkcplNO_RT = $contentdata['NO_RT'];
							$DkcplNO_RW = $contentdata['NO_RW'];
							$DkcplPROP_NAME = $contentdata['PROP_NAME'];
							$DkcplKAB_NAME = $contentdata['KAB_NAME'];
							$DkcplKEC_NAME = $contentdata['KEC_NAME'];
							$DkcplKEL_NAME = $contentdata['KEL_NAME'];
							
							$callLogScore = "{call SP_INSERT_LOG_SCORING_DUKCAPIL(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
							$paramsLogScore = array(array($idLog, SQLSRV_PARAM_IN),
													array($data['ORDER_NO'], SQLSRV_PARAM_IN),
													array($no_ktp, SQLSRV_PARAM_IN),
													array($user, SQLSRV_PARAM_IN),
													array($NIK, SQLSRV_PARAM_IN),
													array($DkcplNIK, SQLSRV_PARAM_IN),
													array($NAMA_LGKP, SQLSRV_PARAM_IN),
													array($DkcplNAMA_LGKP, SQLSRV_PARAM_IN),
													array($ALAMAT, SQLSRV_PARAM_IN),
													array($DkcplALAMAT, SQLSRV_PARAM_IN),
													array($STATUS_KAWIN, SQLSRV_PARAM_IN),
													array($DkcplSTATUS_KAWIN, SQLSRV_PARAM_IN),
													array($TMPT_LHR, SQLSRV_PARAM_IN),
													array($DkcplTMPT_LHR, SQLSRV_PARAM_IN),
													array($TGL_LHR, SQLSRV_PARAM_IN),
													array($DkcplTGL_LHR, SQLSRV_PARAM_IN),
													array($JENIS_KLMIN, SQLSRV_PARAM_IN),
													array($DkcplJENIS_KLMIN, SQLSRV_PARAM_IN),
													array($NAMA_LGKP_IBU, SQLSRV_PARAM_IN),
													array($DkcplNAMA_LGKP_IBU, SQLSRV_PARAM_IN),
													array($JENIS_PKRJN, SQLSRV_PARAM_IN),
													array($DkcplJENIS_PKRJN, SQLSRV_PARAM_IN));
							$execLogScore = sqlsrv_query( $conn, $callLogScore, $paramsLogScore) or die( print_r( sqlsrv_errors(), true));
			
						//echo $namaTanpaSpasiP;
						//echo strlen($namaTanpaSpasiP);
						
						if($DkcplNAMA_LGKP != "Sesuai (100)" && $DkcplNAMA_LGKP != "Sesuai (99)" && $DkcplNAMA_LGKP != "Sesuai (98)" && $DkcplNAMA_LGKP != "Sesuai (97)" 
															 && $DkcplNAMA_LGKP != "Sesuai (96)" && $DkcplNAMA_LGKP != "Sesuai (95)" && $DkcplNAMA_LGKP != "Sesuai (94)"
															 && $DkcplNAMA_LGKP != "Sesuai (93)" && $DkcplNAMA_LGKP != "Sesuai (92)" && $DkcplNAMA_LGKP != "Sesuai (91)"
															 && $DkcplNAMA_LGKP != "Sesuai (90)"){
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
								$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('1', SQLSRV_PARAM_IN),array($getUsername, SQLSRV_PARAM_IN));
								$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
						}
						
						if($DkcplTGL_LHR == "Tidak Sesuai"){
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
								$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('2', SQLSRV_PARAM_IN),array($getUsername, SQLSRV_PARAM_IN));
								$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
						}
						
							
						if($checkStatNikah == 0){ 
							if($DkcplSTATUS_KAWIN == "Tidak Sesuai"){
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));		
							}	
						}
							
						/*	 	
						if(strtoupper($siapanih) == "PEMOHON"){*/
								if($DkcplNAMA_LGKP_IBU != "Sesuai (100)"  && $DkcplNAMA_LGKP_IBU != "Sesuai (99)" && $DkcplNAMA_LGKP_IBU != "Sesuai (98)" && $DkcplNAMA_LGKP_IBU != "Sesuai (97)" 
															 && $DkcplNAMA_LGKP_IBU != "Sesuai (96)" && $DkcplNAMA_LGKP_IBU != "Sesuai (95)" && $DkcplNAMA_LGKP_IBU != "Sesuai (94)"
															 && $DkcplNAMA_LGKP_IBU != "Sesuai (93)" && $DkcplNAMA_LGKP_IBU != "Sesuai (92)" && $DkcplNAMA_LGKP_IBU != "Sesuai (91)"
															 && $DkcplNAMA_LGKP_IBU != "Sesuai (90)"){
									$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
										$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('3', SQLSRV_PARAM_IN),array($getUsername, SQLSRV_PARAM_IN));
										$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
								}
									

							
							
						/*	
							} */
						
						}
						
						$callGetError = "{call SP_GET_VALIDASI_DUKCAPIL(?,?)}";
						$options =  array( "Scrollable" => "buffered" );
						$paramsGetError = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN));
						$execGetError = sqlsrv_query($conn, $callGetError, $paramsGetError,$options) or die(print_r(sqlsrv_errors(), true));	
						$dataGetError = sqlsrv_fetch_array($execGetError);
						$checkGetError=sqlsrv_num_rows($execGetError);
						if($dataGetError > 0 ){
							echo"<script>alert('Data terkena validasi dukcapil, silahkan lakukan pengkinian data');window.location='index.php?page=detail-pengecekan-mh&USERNAME=".$getUsername."&id=".$id."&request_id=".$req_id."'</script>";
							
						}
			
					}
				}
			}
			/***** END CHECK DUKCAPIL *****/
		}
	}
	}

	
}else {
	
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
	}else{		

$NIK= $no_ktp;
$NAMA_LGKP= $nama;
$ALAMAT="";

IF($data9['STATUS_KAWIN'] == "SUDAH KAWIN"){
	$STATUS_KAWIN= "KAWIN";
}Else IF($data9['STATUS_KAWIN'] == "BELUM KAWIN"){
	$STATUS_KAWIN= "BELUM KAWIN";
}Else{
	$STATUS_KAWIN=$data9['STATUS_KAWIN'];
}
	

$TGL_LHR1= $date;
$TGL_LHR2 = strtotime($TGL_LHR1);
$TGL_LHR =  date("d-m-Y", $TGL_LHR2);

// $TGL_LHR= "06-07-1987";
$KAB_NAME= " ";
$KEC_NAME= " ";
$KEL_NAME= " ";
$PROP_NAME= "";
$NO_RT= "";
$NO_RW= "";
$JENIS_KLMIN= "";
$JENIS_PKRJN= "";
$NAMA_LGKP_IBU= $mother_nm;
$TRESHOLD= "90";
//$USER_ID= "10643174202101271dummy_suzuki_finance";
$USER_ID= "25082022141010SUZUKI_FINANCE4288";
//$PASSWORD= "123456";
$PASSWORD= "MZ33CU";
$IP_USER= "172.16.2.5";
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
		/***** END CHECK BLACKLIST *****/	
		
		$call_sd = "{call SP_GET_DUKCAPIL_RESULT(?,?)}";
		$params_sd = array(
						array($data['ORDER_NO'], SQLSRV_PARAM_IN),
						array($no_ktp, SQLSRV_PARAM_IN)
					);
		$options =  array( "Scrollable" => "buffered" );
		$exec_sd = sqlsrv_query($conn, $call_sd, $params_sd, $options) or die( print_r( sqlsrv_errors(), true));
		$num_rows = sqlsrv_num_rows($exec_sd);
		if($num_rows == 0){
			/***** CHECK DUKCAPIL *****/
			$param_dukcapil_array= array('NIK' => $NIK, 'NAMA_LGKP' => $NAMA_LGKP, 'ALAMAT' => $ALAMAT, 'STATUS_KAWIN' => $STATUS_KAWIN, 'TMPT_LHR' => $TMPT_LHR, 'TGL_LHR' => $TGL_LHR, 
								'KAB_NAME' => $KAB_NAME, 'KEC_NAME' => $KEC_NAME, 'KEL_NAME' => $KEL_NAME, 'PROP_NAME' => $PROP_NAME, 'NO_RT' => $NO_RT, 'JENIS_KLMIN' => $JENIS_KLMIN, 
								'JENIS_PKRJN' => $JENIS_PKRJN, 'NAMA_LGKP_IBU' => $NAMA_LGKP_IBU, 'TRESHOLD' => $TRESHOLD, 'USER_ID' => $USER_ID, 'PASSWORD' => $PASSWORD, 'IP_USER' => $IP_USER);

			$param_dukcapil = json_encode($param_dukcapil_array);
			$curlDkUpil = curl_init();
			curl_setopt_array($curlDkUpil, array(
				//CURLOPT_URL => "http://172.16.160.84:8000/dukcapil/get_json/suzuki_finance/nik_verifby_elemen",
				//CURLOPT_URL => "http://172.16.160.128:8000/dukcapil/get_json/suzuki_finance/nik_verifby_elemen",
				//CURLOPT_URL => "https://172.16.160.177:8000/dukcapil/get_json/SUZUKI_FINANCE/CALL_VERIFY_BY_ELEMEN",
				CURLOPT_URL => "http://172.16.160.186:8000/dukcapil/get_json/990040921021160/CALL_VERIFY_BY_ELEMEN",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 60,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => "$param_dukcapil",
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_HTTPHEADER => array(
					'Accept: application/json',
					'Content-Type: application/json',
					"Postman-Token: ae0ace2e-aa92-4d66-8d14-d67edb42fa84",
					"cache-control: no-cache"
				),
			));
			$responseDkUpil = curl_exec($curlDkUpil);
			$errDkUpil = curl_error($curlDkUpil);
			curl_close($curlDkUpil);
			$resultDukcapil = json_decode($responseDkUpil, true);
			
							
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'http://172.16.160.189/data_balikan/public/Api/Nik_store',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>array('nik' => $no_ktp,
										'id_lembaga' => '041148', 
										'nama_lembaga' => 'PT. SUZUKI FINANCE INDONESIA', 
										//'param' => '[{"id_lembaga": "041148","NIK": "'.$no_ktp.'" ,"indexno": "0"},{ "id_lembaga": "041148","NO_ORDER":  "'.$data['ORDER_NO'].'","indexno": "1"}]'),
										'param' => '[{"NO_CIF": "'.$data['ORDER_NO'].'"}]'),
			  CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer nkqAt2em3pjIc9bR4xJJMNG8PT7yqVFLlu2RpfJNHHLPRNb70eZLnSf5A1cG8HcX5hrXpF4Av8A3C8YqVNxzdpuBZ4VZgvDmoAgB',
				'Cookie: adminduk_session=eyJpdiI6ImZvSkY1SG1SeXJOa01xcHpGUUhkN0E9PSIsInZhbHVlIjoidDhsbjBrbEdSQ015NE8rS29OcDRzd0YybW9CbTJacmI4ZG5UZno3XC81R2lnOTllbFBXRklSSnFhcjVOZG9zcGVYVmlqTXBrZ0ZYZjZEWHZCV0p4akxBPT0iLCJtYWMiOiI5OWNkZDMxZWM1OGI5MzU2NmE4NDhkNGM0NTQzOWZiNWMxZDM3ZWZiZGUxM2I1NTkzOTE0MTIwMzY1ZDhhY2QyIn0%3D'
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);


			$response_balikan = str_replace('"',"",$response);
				
			$callSPLogDkUpilNtValid = "{call SP_INSERT_LOG_DATA_BALIKAN(?,?,?,?)}";
			$paramsLogDkUpilNtValid = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN), array($response_balikan, SQLSRV_PARAM_IN),array($getUsername, SQLSRV_PARAM_IN));
			$execLogDkUpilNtValid = sqlsrv_query( $conn, $callSPLogDkUpilNtValid, $paramsLogDkUpilNtValid) or die( print_r( sqlsrv_errors(), true));	
						
						
			
			
			
			if(empty($resultDukcapil)){
				//----# Insert LOG
				$SourceLogDkUpilNtValid = "DUKCAPIL";
				$StatusLogDkUpilNtValid = "KTP TIDAK VALID";
				echo "<script>alert('Error : ".$StatusLogDkUpilNtValid." (Pada saat pengecekan NIK ke Dukcapil.!)');history.back();</script>";
						
			   /*
				$callSPLogDkUpilNtValid = "{call SP_INSERT_LOG_BYSOURCE_NEWVERSE(?,?,?,?,?)}";
				$paramsLogDkUpilNtValid = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN), array($SourceLogDkUpilNtValid, SQLSRV_PARAM_IN),array($StatusLogDkUpilNtValid, SQLSRV_PARAM_IN), array($getUsername, SQLSRV_PARAM_IN));
				$execLogDkUpilNtValid = sqlsrv_query( $conn, $callSPLogDkUpilNtValid, $paramsLogDkUpilNtValid) or die( print_r( sqlsrv_errors(), true));				
				//----# Insert LOG End
				
				//cancel order otomatis saat NIK tidak ditemukan di DUKCAPIL
				$callCancel = "{call SP_UPDATE_ASSIGNMENT_STATUS(?,?,?,?,?,?)}";
				$paramsCancel = array(array($id, SQLSRV_PARAM_IN),array($req_id, SQLSRV_PARAM_IN), array($no_ktp, SQLSRV_PARAM_IN),array($data['ORDER_NO'], SQLSRV_PARAM_IN), array($getUsername, SQLSRV_PARAM_IN),array($siapanih, SQLSRV_PARAM_IN));
				$execCancel = sqlsrv_query( $conn, $callCancel, $paramsCancel) or die( print_r( sqlsrv_errors(), true));			
					//GET LOG ID
						$callGetLog = "{call SP_GET_LOG_ID_DUKCAPIL(?,?)}";
						$paramsGetLog = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN));
						$execGetLog = sqlsrv_query( $conn, $callGetLog, $paramsGetLog) or die( print_r( sqlsrv_errors(), true));
						$dataGetLog = sqlsrv_fetch_array($execGetLog);
						$idLog = $dataGetLog['LOG_CHECK_BYSOURCE_ID'];
						
				$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
				$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('5', SQLSRV_PARAM_IN),array($getUsername, SQLSRV_PARAM_IN));
				$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
				echo "<script>alert('Error : ".$StatusLogDkUpilNtValid." (Pada saat pengecekan NIK ke Dukcapil.!)');history.back();</script>";
				*/		
				//echo "<script>alert('Error : ".$StatusLogDkUpilNtValid." (Pada saat pengecekan No KTP di Dukcapil.!)')</script>";
				//$Warning_Data = $Warning_Data." - KTP TIDAK VALID (Pada saat pengecekan No KTP di Dukcapil.!) ";
			}else{
				
				if($errDkUpil){
					//----# Insert LOG
					$SourceLogDkUpil = "DUKCAPIL";
					$StatusLogDkUpil = "ERROR";

					$callSPLogDkUpil = "{call SP_INSERT_LOG_BYSOURCE_NEWVERSE(?,?,?,?,?)}";
					$paramsLogDkUpil = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkUpil, SQLSRV_PARAM_IN),array($StatusLogDkUpil, SQLSRV_PARAM_IN), array($getUsername, SQLSRV_PARAM_IN));
					$execLogDkUpil = sqlsrv_query( $conn, $callSPLogDkUpil, $paramsLogDkUpil) or die( print_r( sqlsrv_errors(), true));
					
					//cancel order otomatis saat NIK tidak ditemukan di DUKCAPIL
					$callCancel = "{call SP_UPDATE_ASSIGNMENT_STATUS(?,?,?,?,?,?)}";
					$paramsCancel = array(array($id, SQLSRV_PARAM_IN),array($req_id, SQLSRV_PARAM_IN), array($no_ktp, SQLSRV_PARAM_IN),array($data['ORDER_NO'], SQLSRV_PARAM_IN), array($getUsername, SQLSRV_PARAM_IN),array($siapanih, SQLSRV_PARAM_IN));
					$execCancel = sqlsrv_query( $conn, $callCancel, $paramsCancel) or die( print_r( sqlsrv_errors(), true));
					
					//----# Insert LOG End
					echo "<script>alert('Error : ".$errDkUpil." (Pada saat pengecekan NIK ke Dukcapil.!)');
						window.location='index.php?page=hasil-pengecekan&USERNAME=".$getUsername."'</script>";
				}else{
					if(isset($resultDukcapil['content'][0]['RESPONSE'])) {
						//----# Insert LOG
						$SourceLogDkUpilnotfound = "DUKCAPIL";
						$StatusLogDkUpilnotfound = strtoupper($resultDukcapil['content'][0]['RESPONSE']);
				
						$callSPLogDkUpilnotfound = "{call SP_INSERT_LOG_BYSOURCE_NEWVERSE(?,?,?,?,?)}";
						$paramsLogDkUpilnotfound = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkUpilnotfound, SQLSRV_PARAM_IN),array($StatusLogDkUpilnotfound, SQLSRV_PARAM_IN), array($getUsername, SQLSRV_PARAM_IN));
						$execLogDkUpilnotfound = sqlsrv_query( $conn, $callSPLogDkUpilnotfound, $paramsLogDkUpilnotfound) or die( print_r( sqlsrv_errors(), true));
						
							
						$callGetLog = "{call SP_GET_LOG_ID_DUKCAPIL_NOT_FOUND(?,?)}";
						$paramsGetLog = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN));
						$execGetLog = sqlsrv_query( $conn, $callGetLog, $paramsGetLog) or die( print_r( sqlsrv_errors(), true));
						$dataGetLog = sqlsrv_fetch_array($execGetLog);
						$idLog = $dataGetLog['LOG_CHECK_BYSOURCE_ID'];
						
						$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
						$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('5', SQLSRV_PARAM_IN),array($getUsername, SQLSRV_PARAM_IN));
						$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
						
						
						if($execLogDkUpilnotfound === false){
							echo"<script>alert('NIK Tersebut Tidak ditemukan di Dukcapil.!');history.back();</script>";
						}
						//----# Insert LOG End
						
						echo "<script>alert('Error : ".$StatusLogDkUpilnotfound." (Pada saat pengecekan NIK di Dukcapil!)');history.back();</script>";
						
						//$Warning_Data = $Warning_Data."  ".$StatusLogDkUpilnotfound."  (Pada saat pengecekan NO KTP di Dukcapil.!) ";
						
						$DkcplCustType = "";
						$DkcplNIK = "";
						$DkcplNAMA_LGKP = "";
						$DkcplJENIS_KLMIN = "";
						$DkcplTMPT_LHR =  "";
						$DkcplTGL_LHR = "";
						$DkcplSTATUS_KAWIN = "";
						$DkcplNAMA_LGKP_IBU = "";
						$DkcplJENIS_PKRJN = "";
						$DkcplALAMAT = "";
						$DkcplNO_RT = "";
						$DkcplNO_RW = "";
						$DkcplNO_PROP = "";
						$DkcplPROP_NAME = "";
						$DkcplNO_KAB = "";
						$DkcplKAB_NAME = "";
						$DkcplKEC_NAME = "";
						$DkcplNO_KEL = "";
						$DkcplNO_KEC = "";
						$DkcplKEL_NAME = "";
					}else{
						
						$callStatNikah = "{call SP_GET_VERIFIKASI_VERIFIED(?,?)}";
						$paramsStatNikah = array(
										array($data['ORDER_NO'], SQLSRV_PARAM_IN),
										array($no_ktp, SQLSRV_PARAM_IN)
									);
						$optionsStatNikah =  array( "Scrollable" => "buffered" );
						$execStatNikah = sqlsrv_query($conn, $callStatNikah, $paramsStatNikah, $optionsStatNikah) or die( print_r( sqlsrv_errors(), true)); 
						$checkStatNikah=sqlsrv_num_rows($execStatNikah);
						
						foreach($resultDukcapil['content'] as $contentdata){
						$DkcplCustType = "PEMOHON";
							$DkcplNIK = $contentdata['NIK'];
							$DkcplNAMA_LGKP = $contentdata['NAMA_LGKP'];
							$DkcplJENIS_KLMIN = $contentdata['JENIS_KLMIN'];
							$DkcplTMPT_LHR = $contentdata['TMPT_LHR'];
							$DkcplTGL_LHR = $contentdata['TGL_LHR'];
							//$DkcplTGL_LHR = $contentdata['TGL_LHR'];
							$DkcplSTATUS_KAWIN = $contentdata['STATUS_KAWIN'];
							$DkcplNAMA_LGKP_IBU = $contentdata['NAMA_LGKP_IBU'];
							$DkcplJENIS_PKRJN = $contentdata['JENIS_PKRJN'];
							$DkcplALAMAT = $contentdata['ALAMAT'];
							$DkcplNO_RT = $contentdata['NO_RT'];
							$DkcplNO_RW = $contentdata['NO_RW'];
							$DkcplPROP_NAME = $contentdata['PROP_NAME'];
							$DkcplKAB_NAME = $contentdata['KAB_NAME'];
							$DkcplKEC_NAME = $contentdata['KEC_NAME'];
							$DkcplKEL_NAME = $contentdata['KEL_NAME'];
							
						if($DkcplNAMA_LGKP != "Sesuai (100)" && $DkcplNAMA_LGKP != "Sesuai (99)" && $DkcplNAMA_LGKP != "Sesuai (98)" && $DkcplNAMA_LGKP != "Sesuai (97)" 
															 && $DkcplNAMA_LGKP != "Sesuai (96)" && $DkcplNAMA_LGKP != "Sesuai (95)" && $DkcplNAMA_LGKP != "Sesuai (94)"
															 && $DkcplNAMA_LGKP != "Sesuai (93)" && $DkcplNAMA_LGKP != "Sesuai (92)" && $DkcplNAMA_LGKP != "Sesuai (91)"
															 && $DkcplNAMA_LGKP != "Sesuai (90)"){
							$StatusLogDkcpl1 = "DATA DITEMUKAN TIDAK SESUAI";
							
						}else{
							$StatusLogDkcpl1 = "VALID";
						}
						
						if($DkcplTGL_LHR == "Tidak Sesuai"){
							$StatusLogDkcpl2 = "DATA DITEMUKAN TIDAK SESUAI";
							
						}else{
							$StatusLogDkcpl2 = "VALID";
						}
						
							
						if($checkStatNikah > 0){ 
								$StatusLogDkcpl3 = "VALID";
								}else{
						if($DkcplSTATUS_KAWIN == "Tidak Sesuai"){
								$StatusLogDkcpl3 = "DATA DITEMUKAN TIDAK SESUAI";
							
						}else{
							$StatusLogDkcpl3 = "VALID";
						}
							
							}
							
						/*	 	
						if(strtoupper($siapanih) == "PEMOHON"){ */
								if($DkcplNAMA_LGKP_IBU != "Sesuai (100)"  && $DkcplNAMA_LGKP_IBU != "Sesuai (99)" && $DkcplNAMA_LGKP_IBU != "Sesuai (98)" && $DkcplNAMA_LGKP_IBU != "Sesuai (97)" 
															 && $DkcplNAMA_LGKP_IBU != "Sesuai (96)" && $DkcplNAMA_LGKP_IBU != "Sesuai (95)" && $DkcplNAMA_LGKP_IBU != "Sesuai (94)"
															 && $DkcplNAMA_LGKP_IBU != "Sesuai (93)" && $DkcplNAMA_LGKP_IBU != "Sesuai (92)" && $DkcplNAMA_LGKP_IBU != "Sesuai (91)"
															 && $DkcplNAMA_LGKP_IBU != "Sesuai (90)"){
								$StatusLogDkcpl4 = "DATA DITEMUKAN TIDAK SESUAI";
							
								}else{
									$StatusLogDkcpl4 = "VALID";
								}
									
							/*				
							}else{
										$StatusLogDkcpl4 = "VALID";
									} */
						}						
						
						
						$SourceLogDkcpl = "DUKCAPIL";
						//$StatusLogDkcpl = "VALID";
						
						if($StatusLogDkcpl1 == "VALID" && $StatusLogDkcpl2 == "VALID" && $StatusLogDkcpl3 == "VALID" && $StatusLogDkcpl4 == "VALID"){
						$StatusLogDkcpl = "VALID";
						}else{
							$StatusLogDkcpl = "DATA DITEMUKAN TIDAK SESUAI";
						}

						$callSPLogDkcpl = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
						$paramsLogDkcpl = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkcpl, SQLSRV_PARAM_IN),array($StatusLogDkcpl, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
						$execLogDkcpl = sqlsrv_query( $conn, $callSPLogDkcpl, $paramsLogDkcpl) or die( print_r( sqlsrv_errors(), true));
							
					
						//----# Insert LOG End
						
						//GET LOG ID
						
						$callGetLog = "{call SP_GET_LOG_ID_DUKCAPIL(?,?)}";
						$paramsGetLog = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN));
						$execGetLog = sqlsrv_query( $conn, $callGetLog, $paramsGetLog) or die( print_r( sqlsrv_errors(), true));
						$dataGetLog = sqlsrv_fetch_array($execGetLog);
						$idLog = $dataGetLog['LOG_CHECK_BYSOURCE_ID'];
						
						foreach($resultDukcapil['content'] as $contentdata){
						$DkcplCustType = "PEMOHON";
							$DkcplNIK = $contentdata['NIK'];
							$DkcplNAMA_LGKP = $contentdata['NAMA_LGKP'];
							$DkcplJENIS_KLMIN = $contentdata['JENIS_KLMIN'];
							$DkcplTMPT_LHR = $contentdata['TMPT_LHR'];
							$DkcplTGL_LHR = $contentdata['TGL_LHR'];
							//$DkcplTGL_LHR = $contentdata['TGL_LHR'];
							$DkcplSTATUS_KAWIN = $contentdata['STATUS_KAWIN'];
							$DkcplNAMA_LGKP_IBU = $contentdata['NAMA_LGKP_IBU'];
							$DkcplJENIS_PKRJN = $contentdata['JENIS_PKRJN'];
							$DkcplALAMAT = $contentdata['ALAMAT'];
							$DkcplNO_RT = $contentdata['NO_RT'];
							$DkcplNO_RW = $contentdata['NO_RW'];
							$DkcplPROP_NAME = $contentdata['PROP_NAME'];
							$DkcplKAB_NAME = $contentdata['KAB_NAME'];
							$DkcplKEC_NAME = $contentdata['KEC_NAME'];
							$DkcplKEL_NAME = $contentdata['KEL_NAME'];
							
							$callLogScore = "{call SP_INSERT_LOG_SCORING_DUKCAPIL(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
							$paramsLogScore = array(array($idLog, SQLSRV_PARAM_IN),
													array($data['ORDER_NO'], SQLSRV_PARAM_IN),
													array($no_ktp, SQLSRV_PARAM_IN),
													array($user, SQLSRV_PARAM_IN),
													array($NIK, SQLSRV_PARAM_IN),
													array($DkcplNIK, SQLSRV_PARAM_IN),
													array($NAMA_LGKP, SQLSRV_PARAM_IN),
													array($DkcplNAMA_LGKP, SQLSRV_PARAM_IN),
													array($ALAMAT, SQLSRV_PARAM_IN),
													array($DkcplALAMAT, SQLSRV_PARAM_IN),
													array($STATUS_KAWIN, SQLSRV_PARAM_IN),
													array($DkcplSTATUS_KAWIN, SQLSRV_PARAM_IN),
													array($TMPT_LHR, SQLSRV_PARAM_IN),
													array($DkcplTMPT_LHR, SQLSRV_PARAM_IN),
													array($TGL_LHR, SQLSRV_PARAM_IN),
													array($DkcplTGL_LHR, SQLSRV_PARAM_IN),
													array($JENIS_KLMIN, SQLSRV_PARAM_IN),
													array($DkcplJENIS_KLMIN, SQLSRV_PARAM_IN),
													array($NAMA_LGKP_IBU, SQLSRV_PARAM_IN),
													array($DkcplNAMA_LGKP_IBU, SQLSRV_PARAM_IN),
													array($JENIS_PKRJN, SQLSRV_PARAM_IN),
													array($DkcplJENIS_PKRJN, SQLSRV_PARAM_IN));
							$execLogScore = sqlsrv_query( $conn, $callLogScore, $paramsLogScore) or die( print_r( sqlsrv_errors(), true));
	
						//echo $namaTanpaSpasiP;
						//echo strlen($namaTanpaSpasiP);
						
						if($DkcplNAMA_LGKP != "Sesuai (100)" && $DkcplNAMA_LGKP != "Sesuai (99)" && $DkcplNAMA_LGKP != "Sesuai (98)" && $DkcplNAMA_LGKP != "Sesuai (97)" 
															 && $DkcplNAMA_LGKP != "Sesuai (96)" && $DkcplNAMA_LGKP != "Sesuai (95)" && $DkcplNAMA_LGKP != "Sesuai (94)"
															 && $DkcplNAMA_LGKP != "Sesuai (93)" && $DkcplNAMA_LGKP != "Sesuai (92)" && $DkcplNAMA_LGKP != "Sesuai (91)"
															 && $DkcplNAMA_LGKP != "Sesuai (90)"){
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
								$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('1', SQLSRV_PARAM_IN),array($getUsername, SQLSRV_PARAM_IN));
								$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
						}
						
						if($DkcplTGL_LHR == "Tidak Sesuai"){
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
								$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('2', SQLSRV_PARAM_IN),array($getUsername, SQLSRV_PARAM_IN));
								$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
						}
						
							
						if($checkStatNikah == 0){ 
							if($DkcplSTATUS_KAWIN == "Tidak Sesuai"){
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));		
							}	
						}
							
						/*	 	
						if(strtoupper($siapanih) == "PEMOHON"){ */
								if($DkcplNAMA_LGKP_IBU != "Sesuai (100)"  && $DkcplNAMA_LGKP_IBU != "Sesuai (99)" && $DkcplNAMA_LGKP_IBU != "Sesuai (98)" && $DkcplNAMA_LGKP_IBU != "Sesuai (97)" 
															 && $DkcplNAMA_LGKP_IBU != "Sesuai (96)" && $DkcplNAMA_LGKP_IBU != "Sesuai (95)" && $DkcplNAMA_LGKP_IBU != "Sesuai (94)"
															 && $DkcplNAMA_LGKP_IBU != "Sesuai (93)" && $DkcplNAMA_LGKP_IBU != "Sesuai (92)" && $DkcplNAMA_LGKP_IBU != "Sesuai (91)"
															 && $DkcplNAMA_LGKP_IBU != "Sesuai (90)"){
									$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
										$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('3', SQLSRV_PARAM_IN),array($getUsername, SQLSRV_PARAM_IN));
										$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
								}
									

							
							
						/*	
							} */
						
						}
						
						$callGetError = "{call SP_GET_VALIDASI_DUKCAPIL(?,?)}";
						$options =  array( "Scrollable" => "buffered" );
						$paramsGetError = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN));
						$execGetError = sqlsrv_query($conn, $callGetError, $paramsGetError,$options) or die(print_r(sqlsrv_errors(), true));	
						$dataGetError = sqlsrv_fetch_array($execGetError);
						$checkGetError=sqlsrv_num_rows($execGetError);
						/*if($dataGetError > 0 ){
							echo"<script>alert('Data terkena validasi dukcapil, silahkan lakukan pengkinian data');window.location='index.php?page=detail-pengecekan-mh&USERNAME=".$getUsername."&id=".$id."&request_id=".$req_id."'</script>";
							
						}*/
						
					}
				}
			}
			/***** END CHECK DUKCAPIL *****/
		}
	}
}
}

?>
<div class="row">
	<div class="col-md-12">
	<?php if($dataDate['VOID'] == '1'){ ?> 
					<div class="alert alert-danger alert-dismissible">
										<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
										<strong>PERHATIAN  <br>
											UNTUK PENGECEKAN SLIK DIMULAI PUKUL 09:00 - 17:00 WIB<br>
									
										
							</div>
				<?php } ?>
		<div class="card">
			<div class="header">
				<h4 class="title"></h4>
				<p class="category"></p>
			</div>
			<div class="content">		
				<div class="row">
				
					<div class="col-md-6">
						<table class="table">
							<tr>
								<td>Nomor Order</td>
								<td>:</td>
								<td><?php echo $data['ORDER_NO'];?></td>
							</tr>
							<tr>
								<td>NIK</td>
								<td>:</td>
								<td><?php echo $no_ktp;?></td>
							</tr>
							<tr>
								<td>Nama Customer</td>
								<td>:</td>
								<td><?php echo $nama;?></td>
							</tr>
						</table>
					</div>
					<div class="col-md-6">
						<table class="table">
							<tr>
								<td>Nama Dealer</td>
								<td>:</td>
								<td><?php echo $data['DEALER_NAME'];?></td>
							</tr>
							<tr>
								<td>User Request</td>
								<td>:</td>
								<td><?php echo $data['MH'];?></td>
							</tr>
							<tr>
								<td>Tanggal Request</td>
								<td>:</td>
								<td><?php echo $data['CREATE_DATE']->format('Y-m-d H:i:s');?></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title"></h4>
				<p class="category"></p>
			</div>
			<div class="content">		
				<div class="row">
					<div class="col-md-12">
						<?php
						$call2 = "{call SP_GET_RESPONSE_RESULT_DUKCAPIL(?,?)}";
						$param2 = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN));
						$exec2 = sqlsrv_query( $conn, $call2, $param2) or die( print_r( sqlsrv_defaults(), true)); 
						while($data2 = sqlsrv_fetch_array($exec2)){
							if($data2['SOURCE'] == "PEFINDO BIRO KREDIT / SLIK"){
								/***** CHECK PEFINDO *****/
								$curl = curl_init();
								curl_setopt_array($curl, array(
									CURLOPT_URL => "https://bo.pefindobirokredit.com/WsReport/v5.31/Service.svc",
									CURLOPT_RETURNTRANSFER => true,
									CURLOPT_ENCODING => "",
									CURLOPT_MAXREDIRS => 10,
									CURLOPT_TIMEOUT => 60,
									CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
									CURLOPT_CUSTOMREQUEST => "POST",
									CURLOPT_POSTFIELDS => "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"\r\nxmlns:cb5=\"http://creditinfo.com/CB5\"\r\nxmlns:smar=\"http://creditinfo.com/CB5/v5.31/SmartSearch\">\r\n <soapenv:Header/>\r\n <soapenv:Body>\r\n <cb5:SmartSearchIndividual>\r\n <cb5:query>\r\n <smar:InquiryReason>ProvidingFacilities</smar:InquiryReason>\r\n <smar:InquiryReasonText/>\r\n <smar:Parameters>\r\n <smar:DateOfBirth>".$date."</smar:DateOfBirth>\r\n <smar:FullName>".$nama."</smar:FullName>\r\n <smar:IdNumbers>\r\n <smar:IdNumberPairIndividual>\r\n <smar:IdNumber>".$no_ktp."</smar:IdNumber>\r\n <smar:IdNumberType>KTP</smar:IdNumberType>\r\n </smar:IdNumberPairIndividual>\r\n </smar:IdNumbers>\r\n </smar:Parameters>\r\n </cb5:query>\r\n </cb5:SmartSearchIndividual>\r\n </soapenv:Body>\r\n</soapenv:Envelope>\r\n",
									CURLOPT_HTTPHEADER => array(
										"Authorization: Basic " . base64_encode("$username:$password"),
										"Content-Type: text/xml",
										"Postman-Token: ae0ace2e-aa92-4d66-8d14-d67edb42fa84",
										"SOAPAction: http://creditinfo.com/CB5/IReportPublicServiceBase/SmartSearchIndividual",
										"cache-control: no-cache"
									),
								));

								$response = curl_exec($curl);
								$err = curl_error($curl);
								curl_close($curl);
								
								if ($err) { //jika pemintaan request pefindo error
									//echo "cURL Error #:" . $err;		
									//----# Insert LOG
									$SourceLog = "PEFINDO";
									$StatusLog = "ERROR";

									$callSPLogPfnd = "{call SP_INSERT_LOG_BYSOURCE_NEWVERSE(?,?,?,?,?)}";
									$paramsLogPfnd = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLog, SQLSRV_PARAM_IN),array($StatusLog, SQLSRV_PARAM_IN), array($getUsername, SQLSRV_PARAM_IN));
									$execLogPfnd = sqlsrv_query( $conn, $callSPLogPfnd, $paramsLogPfnd) or die( print_r( sqlsrv_errors(), true));
									if($execLogPfnd === false){
										echo"<script>alert('Error insert log');</script>";
									}
									//----# Insert LOG End

									echo"<script>window.location='index.php?USERNAME=".$getUsername."&page=error'</script>";
								} else {
									$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
									$xml = new SimpleXMLElement($response);
									$body = $xml->xpath('//sBody')[0];
									$array = json_decode(json_encode((array)$body), TRUE); 
									//print_r($array);

									if($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aStatus'] == 'SubjectFound'){
										if($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aPefindoId'] <> NULL){
											//----# Insert LOG
											$SourceLogPfndScss = "PEFINDO";
											$StatusLogPfndScss = "DATA DITEMUKAN";

											$callSPLogPfndScss = "{call SP_INSERT_LOG_BYSOURCE_NEWVERSE(?,?,?,?,?)}";
											$paramsLogPfndScss = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogPfndScss, SQLSRV_PARAM_IN),array($StatusLogPfndScss, SQLSRV_PARAM_IN), array($getUsername, SQLSRV_PARAM_IN));
											$execLogPfndScss = sqlsrv_query( $conn, $callSPLogPfndScss, $paramsLogPfndScss) or die( print_r( sqlsrv_errors(), true));
											if($execLogPfndScss === false){
												echo"<script>alert('Error insert log Pefindo DataFound');</script>";
											}
											//----# Insert LOG End
										}else{
											//----# Insert LOG
											$SourceLogPfndScssMlti = "PEFINDO";
											$StatusLogPfndScssMlti = "DATA DITEMUKAN - MULTI PEFINDO ID";

											$callSPLogPfndScssMlti = "{call SP_INSERT_LOG_BYSOURCE_NEWVERSE(?,?,?,?,?)}";
											$paramsLogPfndScssMlti = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogPfndScssMlti, SQLSRV_PARAM_IN),array($StatusLogPfndScssMlti, SQLSRV_PARAM_IN), array($getUsername, SQLSRV_PARAM_IN));
											$execLogPfndScssMlti = sqlsrv_query( $conn, $callSPLogPfndScssMlti, $paramsLogPfndScssMlti) or die( print_r( sqlsrv_errors(), true));
											if($execLogPfndScssMlti === false){
												echo"<script>alert('Error insert log Pefindo DataFoundMulti');</script>";
											}
											//----# Insert LOG End
										}
									}else{
										//----# Insert LOG
										$SourceLogPfndNtfnd = "PEFINDO";
										$StatusLogPfndNtfnd = "DATA TIDAK DITEMUKAN";

										$callSPLogPfndNtfnd = "{call SP_INSERT_LOG_BYSOURCE_NEWVERSE(?,?,?,?,?)}";
										$paramsLogPfndNtfnd = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogPfndNtfnd, SQLSRV_PARAM_IN),array($StatusLogPfndNtfnd, SQLSRV_PARAM_IN), array($getUsername, SQLSRV_PARAM_IN));
										$execLogPfndNtfnd = sqlsrv_query( $conn, $callSPLogPfndNtfnd, $paramsLogPfndNtfnd) or die( print_r( sqlsrv_errors(), true));
										if($execLogPfndNtfnd === false){
											echo"<script>alert('Error insert log Pefindo DataFound');</script>";
										}
										//----# Insert LOG End
									}
								}
								/***** END CHECK PEFINDO *****/
						?>
						<table class="table table-bordered" style="width:100%;font-size:12px;">
							<thead>
								<tr>
									<th style="color:#FFF;font-weight:bold;background-color:#035c7a;" colspan="2">RESPONSE PEFINDO BIRO KREDIT</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<table class="table table-bordered table-stripped" style="width:100%;font-size:12px;">
											<thead>
												<tr>
													<th class="th-custom" style="font-weight:bold;text-align:center;">No</th>
													<th class="th-custom" style="font-weight:bold;text-align:center;">Nomor KTP</th>
													<th class="th-custom" style="font-weight:bold;text-align:center;">Nama Lengkap</th>
													<th class="th-custom" style="font-weight:bold;text-align:center;">Tanggal Lahir</th>
													<th class="th-custom" style="font-weight:bold;text-align:center;">Alamat</th>
													<th class="th-custom" style="font-weight:bold;text-align:center;">Action</th>
												</tr>
											</thead>
											<tbody>
											<?php
												if($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aStatus'] == 'SubjectFound'){
													if($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aPefindoId'] <> NULL){
												
												$ktpPefindo = $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aKTP'];
												$namaPefindo1 = $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aFullName'];
												$tglPefindo = date('Y-m-d', strtotime($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aDateOfBirth']));
												$namaOrder1 = str_replace(' ', '', $nama);
												$nameOrder = strtoupper($namaOrder1);
												$namaPefindo = strtoupper(str_replace(' ', '', $namaPefindo1));
												
												?> 
												<!--
												<input type="text" class="form-control" name="prospect_no" id="prospect_no"  value="<?php //echo $no_ktp;?>">
												<input type="text" class="form-control" name="prospect_no" id="prospect_no"  value="<?php //echo $ktpPefindo;?>">
												<input type="text" class="form-control" name="prospect_no" id="prospect_no"  value="<?php //echo $nameOrder;?>">
												<input type="text" class="form-control" name="prospect_no" id="prospect_no"  value="<?php// echo $namaPefindo;?>">
												<input type="text" class="form-control" name="prospect_no" id="prospect_no"  value="<?php //echo $date;?>">
												<input type="text" class="form-control" name="prospect_no" id="prospect_no"  value="<?php //echo $tglPefindo;?>">
												-->
												<?php 
												if ($no_ktp == $ktpPefindo && $nameOrder == $namaPefindo && $date == $tglPefindo){
											?>
												<!----- SINGLE ------>
												
												<tr>
													<td style="text-align:center;">1</td>
													<td style="text-align:center;">
															<?php //echo $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aKTP'];?>
																<?php ///ini cara biar tau nilainya, pake print_r. kalo diliat kan hasilnya kosong tuh . yang kecetak yg bawah doang/print_r($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aKTP'], true);?>
															<?php 
																if($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aKTP']<>NULL){ 
																	echo $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aKTP'];
																}else{
																	echo"-";
																}?>
													</td>
													<td><?php echo strtoupper($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aFullName']);?></td>
													<td style="text-align:center;"><?php echo date('Y-m-d', strtotime($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aDateOfBirth']));?></td>
													<td><?php if($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aAddress']<>NULL){ 
																	echo $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aAddress'];
																}else{
																	echo"-";
																}?></td></td>
													<td style="text-align:center;">
														<form action="check-mh.php" method="post">
															<input type="hidden" name="user" value="<?php echo $getUsername;?>">
															<input type="hidden" name="request" value="individual">
															<input type="hidden" name="no_prospect" value="<?php echo $data['ORDER_NO'];?>">
															<input type="hidden" name="no_ktp" value="<?php echo $no_ktp;?>">
															<input type="hidden" name="pefindo_id" value="<?php echo $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aPefindoId'];?>">
															<input type="hidden" name="type_customer" value="<?php echo $siapanih;?>">
															<input type="hidden" name="request_id" value="<?php echo $req_id;?>">
															<input type="submit" class="btn btn-custom btn-xs" value="Check Scoring">
														</form>
													</td>
												</tr>
											<?php }else{ ?> 
												<tr>
													<td colspan="6" style="text-align:center;">Data tidak ditemukan</td>
												</tr>
											<?php }
											}else{
													
											?>
												<!------ MULTIPLE ------>
												<tr>
													<td colspan="6" style="text-align:center;">Data tidak ditemukan</td>
												</tr>
											<?php		
														
													}
												}else{
											?>
												<tr>
													<td colspan="6" style="text-align:center;">Data tidak ditemukan</td>
												</tr>
											<?php } ?>
											</tbody>
										</table>
									</td>
								</tr>
								<tr>
									<td>
									
										<div class="row">
											<div class="col-md-6">
												<i class="text-danger"><b>*Jika data tidak ada di Pefindo, maka klik tombol "Pefindo Tidak Ditemukan"</b></i>
											</div>
											<div class="col-md-6">
														
											
												<form action="check-notfound.php" method="post">
													<input type="hidden" name="user" value="<?php echo $user;?>">
													<input type="hidden" name="request" value="individual">
													<input type="hidden" name="no_prospect" value="<?php echo $data['ORDER_NO'];?>">
													<input type="hidden" name="no_ktp" value="<?php echo $no_ktp;?>">
													<input type="hidden" name="pefindo_id" value="00">
													<input type="hidden" name="type_customer" value="<?php echo $siapanih;?>">
													<?php
														
													?>
													<input type="submit" class="btn btn-custom btn-xs" style="width:100%;" value="Pefindo Tidak Ditemukan">
											
												</form>
						 
									<?php /*
												<form action='check-slik.php' method='post'>
													<input name='prospect_no' type='hidden' value='<?php echo $data['ORDER_NO'];?>'>
													<input name='no_ktp' type='hidden' value='<?php echo $no_ktp;?>'>
													<input name='nama' type='hidden' value="<?php echo $nama;?>">
													<input name='birth_dt' type='hidden' value='<?php echo $date;?>'>
													<input name='cust_type' type='hidden' value='P'>
													<input name='id_type' type='hidden' value="KTP">
													<input name='username' type='hidden' value="<?php echo $user;?>">
													<input name='tipe_cust' type='hidden' value="<?php echo $siapanih;?>">
													<?php if($dataDate['VOID'] == '1'){ ?> 
													<button type='submit' class='btn btn-custom btn-sm' style="width:100%;" disabled>AJUKAN CEK SLIK</button>
													<?php }else{ ?>
													<button type='submit' class='btn btn-custom btn-sm' style="width:100%;" >AJUKAN CEK SLIK</button>
													<?php } ?>
												</form>
												 */?>
											</div>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						<?php
							}else{
						?>
						<table class="table table-bordered" style="width:100%;font-size:12px;">
							<thead>
								<tr>
									<th style="color:#FFF;font-weight:bold;background-color:#035c7a;" colspan="2">HASIL PENGECEKAN <?php echo $data2['SOURCE'];?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td style="width:50%;">Hasil Pengecekan</td>
									<td style="width:50%;">
										<?php 
											if($data2['RESULT'] == "PENGKINIAN DATA"){
												$call3 = "{call SP_GET_RESPONSE_RESULT_ERROR_DETAIL(?,?)}";
												$param3 = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN));
												$exec3 = sqlsrv_query( $conn, $call3, $param3) or die( print_r( sqlsrv_defaults(), true)); 
												while($data3 = sqlsrv_fetch_array($exec3)){
													echo strtoupper($data3['MSG_NAME']).", ";
												}
											}else{
												//echo substr($data2['RESULT'],0,strlen(-2));
												echo $data2['RESULT'];
											}
										?>
									</td>
								</tr>
								<tr>
									<td style="width:50%;">Checked By</td>
									<td style="width:50%;"><?php echo $data2['USER_CREATE'];?></td>
								</tr>
								<tr>
									<td style="width:50%;">Checked Date</td>
									<td style="width:50%;"><?php if($data2['CREATE_DATE']<>NULL){echo $data2['CREATE_DATE']->format('Y-m-d H:i:s');}?></td>
								</tr>
							</tbody>
						</table>
						<?php } } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
 window.onbeforeunload = function () {
        $("input[type=submit]").attr("disabled", "disabled");
    };

</script>	
<?php
/******** PROGRESS UPDATE STATUS ********/

/******** END PROGRESS UPDATE STATUS ********/
?>