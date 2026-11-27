<?php
require_once("config/configuration.php");
require_once("config/connection.php");
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
$date=date("Y-m-d");

$id=$_GET['id'];
$user=$_GET['USERNAME'];
$Warning_Data = "";
$WarningNama = "";
$WarningTTL = "";
$WarningIbu = "";
if(isset($_POST['hold'])){
	$prospect_no = $_POST['prospect_no'];
	$nik = $_POST['nik'];
	$id = $_POST['id'];

	
		echo"<script>window.location='index.php?USERNAME=".$user."&page=cek-ulang-dukcapil'</script>";
		exit();
	
	
}
$call = "{call SP_GET_DETAIL_INFO_UNLOCK_DUKCAPIL(?)}";
$param = array(array($id, SQLSRV_PARAM_IN));
$options =  array( "Scrollable" => "buffered" );
$exec = sqlsrv_query( $conn, $call, $param, $options) or die( print_r( sqlsrv_errors(), true));
$data = sqlsrv_fetch_array($exec);

$call1 = "{call  SP_GET_UNLOCK_REJECT(?)}";
$param1 = array(array($id, SQLSRV_PARAM_IN));
$options1 =  array( "Scrollable" => "buffered" );
$exec1 = sqlsrv_query( $conn, $call1, $param1,$options1) or die( print_r( sqlsrv_errors(), true)); 
$numrows1 = sqlsrv_num_rows($exec1);
/*$call3 = "{call SP_GETDATA_INFO_CUSTOMER(?,?)}";
$param3 = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN));
$options3 =  array( "Scrollable" => "buffered" );
$exec3 = sqlsrv_query( $conn, $call3, $param3, $options3) or die( print_r( sqlsrv_errors(), true));
$data3 = sqlsrv_fetch_array($exec3);*/

/*$call3 = "{call SP_GETDATA_INFO_CUSTOMER_NEWVERSE(?)}";
$param3 = array(array($data['ID_NO'], SQLSRV_PARAM_IN));
$options3 =  array( "Scrollable" => "buffered" );
$exec3 = sqlsrv_query( $conn, $call3, $param3, $options3) or die( print_r( sqlsrv_errors(), true));
$data3 = sqlsrv_fetch_array($exec3);*/


$callCount = "{call SP_GET_COUNT_CHECK_DUKCAPIL(?,?,?)}";
$paramCount = array(array($id, SQLSRV_PARAM_IN),
				array($data['ID_NO'], SQLSRV_PARAM_IN),
				array($data['PROSPECT_NO'], SQLSRV_PARAM_IN));
$optionsCount =  array( "Scrollable" => "buffered" );
$execCount = sqlsrv_query( $conn, $callCount, $paramCount, $optionsCount) or die( print_r( sqlsrv_errors(), true));
$dataCount = sqlsrv_fetch_array($execCount);
$checkCount=sqlsrv_num_rows($execCount);

$callCount1 = "{call SP_GET_SISA_WAKTU_CHECK_DUKCAPIL(?,?,?)}";
$paramCount1 = array(array($id, SQLSRV_PARAM_IN),
				array($data['ID_NO'], SQLSRV_PARAM_IN),
				array($data['PROSPECT_NO'], SQLSRV_PARAM_IN));
$optionsCount1 =  array( "Scrollable" => "buffered" );
$execCount1 = sqlsrv_query( $conn, $callCount1, $paramCount1, $optionsCount1) or die( print_r( sqlsrv_errors(), true));
$dataCount1 = sqlsrv_fetch_array($execCount1);
//$checkCount=sqlsrv_num_rows($execCount);

if($dataCount1['SISA_HARI_PENGECEKAN'] == '0'){
	echo "<script>alert('Prospect ini telah melewati waktu 14 hari, silahkan lakukan cancel');history.back();</script>";
	exit();
}

if (strpos($data['PROSPECT_NO'], 'PRS') !== false) {
$call3 = "{call SP_GETDATA_INFO_CUSTOMER_NEWVERSE_2(?,?)}";
$param3 = array(array($data['ID_NO'], SQLSRV_PARAM_IN),
				array($data['PROSPECT_NO'], SQLSRV_PARAM_IN));
$options3 =  array( "Scrollable" => "buffered" );
$exec3 = sqlsrv_query( $conn, $call3, $param3, $options3) or die( print_r( sqlsrv_errors(), true));
$data3 = sqlsrv_fetch_array($exec3);

$date1=date("Y-m-d", strtotime($data3['TL']));

$callReason = "{call SP_GET_CANCEL_REASON_PROSPECT(?)}";
$paramReason = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN));
$optionsReason =  array( "Scrollable" => "buffered" );
$execReason = sqlsrv_query( $conn, $callReason, $paramReason, $optionsReason) or die( print_r( sqlsrv_errors(), true));
$dataReason = sqlsrv_fetch_array($execReason);
$checkReason=sqlsrv_num_rows($execReason);

if($checkReason > 0){
	echo "<script>alert('Prospect ini terkena cancel reject, dengan Reason ".$dataReason['REASON_DESCR']."');history.back();</script>";
	exit();
}


$siapanih = 'PENJAMIN';
}
else{
$call3 = "{call VBS_GET_DATA_CUSTOMER_KTP(?)}";
$param3 = array(array($data['ID_NO'], SQLSRV_PARAM_IN));
$options3 =  array( "Scrollable" => "buffered" );
$exec3 = sqlsrv_query( $conn, $call3, $param3, $options3) or die( print_r( sqlsrv_errors(), true));
$data3 = sqlsrv_fetch_array($exec3);

$callReason = "{call SP_GET_CANCEL_REASON_ORDER(?)}";
$paramReason = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN));
$optionsReason =  array( "Scrollable" => "buffered" );
$execReason = sqlsrv_query( $conn, $callReason, $paramReason, $optionsReason) or die( print_r( sqlsrv_errors(), true));
$dataReason = sqlsrv_fetch_array($execReason);
$checkReason=sqlsrv_num_rows($execReason);

$date1=date("Y-m-d", strtotime($data3['TTL']));

if($checkReason > 0){
	echo "<script>alert('Prospect ini terkena cancel reject, dengan Reason ".$dataReason['REASON_DESCR']."');history.back();</script>";
	exit();
}

$siapanih = $data3['TYPE'];
$mother_nm = $data3['NAMA_IBU'];
$date1=date("Y-m-d", strtotime($data3['TTL']));

}
if($checkCount > 0){
$datePengecekan = $dataCount['CREATE_DATE']->format('Y-m-d');
}Else{
	$datePengecekan = $date;
}

if($dataCount['VOID'] == 3 && $datePengecekan == $date){
	echo "<script>alert('Hari ini sudah melakukan pengecekan dukcapil sebanyak 3x, Lakukan Cek Dukcapil kembali Besok');history.back();</script>";
}else if($dataCount['VOID'] == 3 && $datePengecekan <> $date){
	$callCountInsert = "{call SP_INSERT_COUNT_CHECK_DUKCAPIL(?,?,?,?)}";
	$paramCountInsert = array(array($id, SQLSRV_PARAM_IN),
					array($data['ID_NO'], SQLSRV_PARAM_IN),
					array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$optionsCountInsert =  array( "Scrollable" => "buffered" );
	$execCountInsert = sqlsrv_query( $conn, $callCountInsert, $paramCountInsert, $optionsCountInsert) or die( print_r( sqlsrv_errors(), true));
	$dataCountInsert = sqlsrv_fetch_array($execCountInsert);
}Else{
	
	$callCountInsert = "{call SP_INSERT_COUNT_CHECK_DUKCAPIL(?,?,?,?)}";
	$paramCountInsert = array(array($id, SQLSRV_PARAM_IN),
					array($data['ID_NO'], SQLSRV_PARAM_IN),
					array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$optionsCountInsert =  array( "Scrollable" => "buffered" );
	$execCountInsert = sqlsrv_query( $conn, $callCountInsert, $paramCountInsert, $optionsCountInsert) or die( print_r( sqlsrv_errors(), true));
	$dataCountInsert = sqlsrv_fetch_array($execCountInsert);
	
}

$call4 = "{call SP_GET_PENGKINIAN_DATA_BY_ORDER_NO_KK(?)}";
$param4 = array(array($data3['ID_NO'], SQLSRV_PARAM_IN));
$options4 =  array( "Scrollable" => "buffered" );
$exec4 = sqlsrv_query( $conn, $call4, $param4, $options4) or die( print_r( sqlsrv_errors(), true));
$data4 = sqlsrv_fetch_array($exec4);
$numrows4 = sqlsrv_num_rows($exec4);



$param_dukcapil_array= array('nik' => $data['ID_NO'], 'user_id' => "singlesuzukifinance", 'password' => "s3Jsm8K9", 'IP_USER' => $user);
$param_dukcapil = json_encode($param_dukcapil_array);
$curlDkUpil = curl_init();
curl_setopt_array($curlDkUpil, array(
	CURLOPT_URL => "http://172.16.160.128:8000/dukcapil/get_json/SUZUKI_FINANCE/CALL_NIK",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 60,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => "$param_dukcapil",
	CURLOPT_HTTPHEADER => array(
		"Authorization: Basic " . base64_encode("singlesuzukifinance:s3Jsm8K9"),
		"Content-Type: application/json",
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
  CURLOPT_POSTFIELDS =>array('nik' => $data['ID_NO'],
							'id_lembaga' => '041148', 
							'nama_lembaga' => 'PT. SUZUKI FINANCE INDONESIA', 
							'param' => '[{"NO_CIF":  "'.$data['PROSPECT_NO'].'"}]'),
  CURLOPT_HTTPHEADER => array(
	'Authorization: Bearer nkqAt2em3pjIc9bR4xJJMNG8PT7yqVFLlu2RpfJNHHLPRNb70eZLnSf5A1cG8HcX5hrXpF4Av8A3C8YqVNxzdpuBZ4VZgvDmoAgB',
	'Cookie: adminduk_session=eyJpdiI6ImZvSkY1SG1SeXJOa01xcHpGUUhkN0E9PSIsInZhbHVlIjoidDhsbjBrbEdSQ015NE8rS29OcDRzd0YybW9CbTJacmI4ZG5UZno3XC81R2lnOTllbFBXRklSSnFhcjVOZG9zcGVYVmlqTXBrZ0ZYZjZEWHZCV0p4akxBPT0iLCJtYWMiOiI5OWNkZDMxZWM1OGI5MzU2NmE4NDhkNGM0NTQzOWZiNWMxZDM3ZWZiZGUxM2I1NTkzOTE0MTIwMzY1ZDhhY2QyIn0%3D'
  ),
));

$response = curl_exec($curl);

curl_close($curl);


$response_balikan = str_replace('"',"",$response);
	
$callSPLogDkUpilNtValid = "{call SP_INSERT_LOG_DATA_BALIKAN(?,?,?,?)}";
$paramsLogDkUpilNtValid = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN), array($response_balikan, SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
$execLogDkUpilNtValid = sqlsrv_query( $conn, $callSPLogDkUpilNtValid, $paramsLogDkUpilNtValid) or die( print_r( sqlsrv_errors(), true));	
			
				



if(empty($resultDukcapil)){
	//----# Insert LOG
	$SourceLogDkUpilNtValid = "DUKCAPIL";
	$StatusLogDkUpilNtValid = "KTP TIDAK VALID";
	echo "<script>alert('Error : ".$StatusLogDkUpilNtValid." (Pada saat pengecekan NIK ke Dukcapil.!)');history.back();</script>";


					//GET LOG ID
						$callGetLog = "{call SP_GET_LOG_ID_DUKCAPIL(?,?)}";
						$paramsGetLog = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN));
						$execGetLog = sqlsrv_query( $conn, $callGetLog, $paramsGetLog) or die( print_r( sqlsrv_errors(), true));
						$dataGetLog = sqlsrv_fetch_array($execGetLog);
						$idLog = $dataGetLog['LOG_CHECK_BYSOURCE_ID'];
						
				$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
				$paramsInsertError = array(array($dataGetLog['LOG_CHECK_BYSOURCE_ID'], SQLSRV_PARAM_IN),array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN),array('5', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
				$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
				echo "<script>alert('Error : ".$StatusLogDkUpilNtValid." (Pada saat pengecekan NIK ke Dukcapil.!)');history.back();</script>";
						
						
	/*$callSPLogDkUpilNtValid = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
	$paramsLogDkUpilNtValid = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN), array($SourceLogDkUpilNtValid, SQLSRV_PARAM_IN),array($StatusLogDkUpilNtValid, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
	$execLogDkUpilNtValid = sqlsrv_query( $conn, $callSPLogDkUpilNtValid, $paramsLogDkUpilNtValid) or die( print_r( sqlsrv_errors(), true));*/
	//----# Insert LOG End
}else{
	if($errDkUpil){
		//----# Insert LOG
		$SourceLogDkUpil = "DUKCAPIL";
		$StatusLogDkUpil = "ERROR";

		$callSPLogDkUpil = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
		$paramsLogDkUpil = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN),array($SourceLogDkUpil, SQLSRV_PARAM_IN),array($StatusLogDkUpil, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
		$execLogDkUpil = sqlsrv_query( $conn, $callSPLogDkUpil, $paramsLogDkUpil) or die( print_r( sqlsrv_errors(), true));
		if($execLogDkUpil === false){
			echo"<script>alert('Error insert log Dukcapil');</script>";
		}
		//----# Insert LOG End
		echo "<script>alert('Error : ".$errDkUpil." (Pada saat pengecekan No KTP di Dukcapil..!)');history.back();</script>";
	}else{
			if(isset($resultDukcapil['content'][0]['RESPON'])) {
					//----# Insert LOG
					$SourceLogDkUpilnotfound = "DUKCAPIL";
					$StatusLogDkUpilnotfound = strtoupper($resultDukcapil['content'][0]['RESPON']);

					$callSPLogDkUpilnotfound = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
					$paramsLogDkUpilnotfound = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN),array($SourceLogDkUpilnotfound, SQLSRV_PARAM_IN),array($StatusLogDkUpilnotfound, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
					$execLogDkUpilnotfound = sqlsrv_query( $conn, $callSPLogDkUpilnotfound, $paramsLogDkUpilnotfound) or die( print_r( sqlsrv_errors(), true));
					
					$callGetLog = "{call SP_GET_LOG_ID_DUKCAPIL_NOT_FOUND(?,?)}";
					$paramsGetLog = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN));
					$execGetLog = sqlsrv_query( $conn, $callGetLog, $paramsGetLog) or die( print_r( sqlsrv_errors(), true));
					$dataGetLog = sqlsrv_fetch_array($execGetLog);
					$idLog = $dataGetLog['LOG_CHECK_BYSOURCE_ID'];
					
					$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
					$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN),array('5', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
									
					
					
					if($execLogDkUpilnotfound === false){
						echo"<script>alert('NIK Tersebut Tidak ditemukan di Dukcapil.!');history.back();</script>";
					}
					//----# Insert LOG End
					
					echo "<script>alert('Error : ".$StatusLogDkUpilnotfound." (Pada saat pengecekan No KTP di Dukcapil!)');history.back();</script>";
					$Warning_Data = $Warning_Data."  ".$StatusLogDkUpilnotfound."  (Pada saat pengecekan NO KTP di Dukcapil.!) ";
					
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

					
					foreach($resultDukcapil['content'] as $contentdata){
						$DkcplCustType = "PEMOHON";
						$DkcplNIK = number_format($contentdata['NIK'], 0, '', '');
						$DkcplNAMA_LGKP = $contentdata['NAMA_LGKP'];
						$DkcplJENIS_KLMIN = $contentdata['JENIS_KLMIN'];
						$DkcplTMPT_LHR = $contentdata['TMPT_LHR'];
						$DkcplTGL_LHR = date("Y-m-d", strtotime($contentdata['TGL_LHR']));
						//$DkcplTGL_LHR = $contentdata['TGL_LHR'];
						$DkcplSTATUS_KAWIN = $contentdata['STATUS_KAWIN'];
						$DkcplNAMA_LGKP_IBU = $contentdata['NAMA_LGKP_IBU'];
						$DkcplJENIS_PKRJN = $contentdata['JENIS_PKRJN'];
						$DkcplALAMAT = $contentdata['ALAMAT'];
						$DkcplNO_RT = $contentdata['NO_RT'];
						$DkcplNO_RW = $contentdata['NO_RW'];
						$DkcplNO_PROP = $contentdata['NO_PROP'];
						$DkcplPROP_NAME = $contentdata['PROP_NAME'];
						$DkcplNO_KAB = $contentdata['NO_KAB'];
						$DkcplKAB_NAME = $contentdata['KAB_NAME'];
						$DkcplKEC_NAME = $contentdata['KEC_NAME'];
						$DkcplNO_KEL = $contentdata['NO_KEL'];
						$DkcplNO_KEC = $contentdata['NO_KEC'];
						$DkcplKEL_NAME = $contentdata['KEL_NAME'];

						$namaTanpaTitikD = str_replace("."," ",$DkcplNAMA_LGKP);
						$namaTanpaKomaD = str_replace(","," ",$namaTanpaTitikD);
						$namaTanpaPetikD = str_replace("'"," ",$namaTanpaKomaD);
						$namaTanpaStripD = str_replace("-"," ",$namaTanpaPetikD); 
						$namaTanpaSpasiDoubleD = str_replace("  "," ",$namaTanpaStripD);
						$namaTanpaSpasiD = strtoupper(trim(preg_replace('/[\t|\s{2,}]/', '', $namaTanpaSpasiDoubleD)));
						//echo $namaTanpaSpasiD;
						//echo strlen($namaTanpaSpasiD);
						
						$namaTanpaTitikP = str_replace("."," ",$data3['CUST_NAME']);
						$namaTanpaKomaP = str_replace(","," ",$namaTanpaTitikP);
						$namaTanpaPetikP = str_replace("'"," ",$namaTanpaKomaP);
						$namaTanpaStripP =  str_replace("-"," ",$namaTanpaPetikP);
						$namaTanpaSpasiDoubleP = str_replace("  "," ",$namaTanpaStripP);
						$namaTanpaSpasiP = strtoupper(trim(preg_replace('/[\t|\s{2,}]/', '', $namaTanpaSpasiDoubleP)));
						//echo $namaTanpaSpasiP;
						//echo strlen($namaTanpaSpasiP);
						
						if($namaTanpaSpasiD != $namaTanpaSpasiP){
							$StatusLogDkcpl1 = "DATA DITEMUKAN TIDAK SESUAI";
							
						}else{
							$StatusLogDkcpl1 = "VALID";
						}

						if($DkcplTGL_LHR != $date1){
							$StatusLogDkcpl2 = "DATA DITEMUKAN TIDAK SESUAI";
							
						}else{
							$StatusLogDkcpl2 = "VALID";
						}
						
							
						if($DkcplSTATUS_KAWIN == "KAWIN" && $data3['STATUS_KAWIN'] == "BELUM KAWIN"){
							$StatusLogDkcpl3 = "DATA DITEMUKAN TIDAK SESUAI";
							
							}
							
							else if ($DkcplSTATUS_KAWIN == "KAWIN" && $data3['STATUS_KAWIN'] == ""){
							$StatusLogDkcpl3 = "DATA DITEMUKAN TIDAK SESUAI";
							
							
						
							}else if($DkcplSTATUS_KAWIN == "BELUM KAWIN" && $data3['STATUS_KAWIN'] == "SUDAH KAWIN"){
							$StatusLogDkcpl3 = "DATA DITEMUKAN TIDAK SESUAI";
							
							}
							else if($DkcplSTATUS_KAWIN == "BELUM KAWIN" && $data3['STATUS_KAWIN'] == ""){
							$StatusLogDkcpl3 = "DATA DITEMUKAN TIDAK SESUAI";
							
							
							}else if ($DkcplSTATUS_KAWIN == "CERAI MATI" && $data3['STATUS_KAWIN'] == "BELUM KAWIN"){
							$StatusLogDkcpl3 = "DATA DITEMUKAN TIDAK SESUAI";
							
							}else if ($DkcplSTATUS_KAWIN == "CERAI MATI" && $data3['STATUS_KAWIN'] == "KAWIN"){
							$StatusLogDkcpl3 = "DATA DITEMUKAN TIDAK SESUAI";
					

							}else if ($DkcplSTATUS_KAWIN == "CERAI MATI" && $data3['STATUS_KAWIN'] == ""){
							$StatusLogDkcpl3 = "DATA DITEMUKAN TIDAK SESUAI";
							
							}else if ($DkcplSTATUS_KAWIN == "CERAI MATI" && $data3['STATUS_KAWIN'] == "CERAI"){
							$StatusLogDkcpl3 = "VALID";
							}else if ($DkcplSTATUS_KAWIN == "CERAI HIDUP" && $data3['STATUS_KAWIN'] == "CERAI"){
							$StatusLogDkcpl3 = "VALID";
							
							
							}else{
								$StatusLogDkcpl3 = "VALID";
							}
							 	
								
					
					
						if(strtoupper($siapanih) == "PEMOHON"){
							$namaIbuTanpaTitikD = str_replace("."," ",$DkcplNAMA_LGKP_IBU);
							$namaIbuTanpaKomaD = str_replace(","," ",$namaIbuTanpaTitikD);
							$namaIbuTanpaPetikD = str_replace("'"," ",$namaIbuTanpaKomaD);
							$namaIbuTanpaStripD = str_replace("-"," ",$namaIbuTanpaPetikD); 
							$namaIbuTanpaSpasiDoubleD = str_replace("  "," ",$namaIbuTanpaStripD);
							$namaIbuTanpaSpasiD = strtoupper(trim(preg_replace('/[\t|\s{2,}]/', '', $namaIbuTanpaSpasiDoubleD)));
							//echo $namaIbuTanpaSpasiD;
							
							$namaIbuTanpaTitikP = str_replace("."," ",$mother_nm);
							$namaIbuTanpaKomaP = str_replace(","," ",$namaIbuTanpaTitikP);
							$namaIbuTanpaPetikP = str_replace("'"," ",$namaIbuTanpaKomaP);
							$namaIbuTanpaStripP = str_replace("-"," ",$namaIbuTanpaPetikP);
							$namaIbuTanpaSpasiDoubleP = str_replace("  "," ",$namaIbuTanpaStripP);
							$namaIbuTanpaSpasiP = strtoupper(trim(preg_replace('/[\t|\s{2,}]/', '', $namaIbuTanpaSpasiDoubleP)));
							//echo $_POST['mother_name'];
							//echo $namaIbuTanpaSpasiP;
							
							if($namaIbuTanpaSpasiD <> ""){
								if($namaIbuTanpaSpasiD != $namaIbuTanpaSpasiP){
									$StatusLogDkcpl4 = "DATA DITEMUKAN TIDAK SESUAI";
									
								}else{
									$StatusLogDkcpl4 = "VALID";
								}
							}else{
									$StatusLogDkcpl4 = "VALID";
									}
						}else{
								$StatusLogDkcpl4 = "VALID";
							}
					}
			
			
			//----# Insert LOG
					$SourceLogDkcpl = "DUKCAPIL";
					

				if($StatusLogDkcpl1 == "VALID" && $StatusLogDkcpl2 == "VALID" && $StatusLogDkcpl3 == "VALID" && $StatusLogDkcpl4 == "VALID"){
						$StatusLogDkcpl = "VALID";
					}else{
						$StatusLogDkcpl = "DATA DITEMUKAN TIDAK SESUAI";
					}
					$callSPLogDkcpl = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
					$paramsLogDkcpl = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN),array($SourceLogDkcpl, SQLSRV_PARAM_IN),array($StatusLogDkcpl, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
					$execLogDkcpl = sqlsrv_query( $conn, $callSPLogDkcpl, $paramsLogDkcpl) or die( print_r( sqlsrv_errors(), true));
					
					
					//GET LOG ID
					$callGetLog = "{call SP_GET_LOG_ID_DUKCAPIL(?,?)}";
					$paramsGetLog = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN));
					$execGetLog = sqlsrv_query( $conn, $callGetLog, $paramsGetLog) or die( print_r( sqlsrv_errors(), true));
					$dataGetLog = sqlsrv_fetch_array($execGetLog);
					$idLog = $dataGetLog['LOG_CHECK_BYSOURCE_ID'];
					
					foreach($resultDukcapil['content'] as $contentdata){
						$DkcplCustType = "PEMOHON";
						$DkcplNIK = number_format($contentdata['NIK'], 0, '', '');
						$DkcplNAMA_LGKP = $contentdata['NAMA_LGKP'];
						$DkcplJENIS_KLMIN = $contentdata['JENIS_KLMIN'];
						$DkcplTMPT_LHR = $contentdata['TMPT_LHR'];
						$DkcplTGL_LHR = date("Y-m-d", strtotime($contentdata['TGL_LHR']));
						//$DkcplTGL_LHR = $contentdata['TGL_LHR'];
						$DkcplSTATUS_KAWIN = $contentdata['STATUS_KAWIN'];
						$DkcplNAMA_LGKP_IBU = $contentdata['NAMA_LGKP_IBU'];
						$DkcplJENIS_PKRJN = $contentdata['JENIS_PKRJN'];
						$DkcplALAMAT = $contentdata['ALAMAT'];
						$DkcplNO_RT = $contentdata['NO_RT'];
						$DkcplNO_RW = $contentdata['NO_RW'];
						$DkcplNO_PROP = $contentdata['NO_PROP'];
						$DkcplPROP_NAME = $contentdata['PROP_NAME'];
						$DkcplNO_KAB = $contentdata['NO_KAB'];
						$DkcplKAB_NAME = $contentdata['KAB_NAME'];
						$DkcplKEC_NAME = $contentdata['KEC_NAME'];
						$DkcplNO_KEL = $contentdata['NO_KEL'];
						$DkcplNO_KEC = $contentdata['NO_KEC'];
						$DkcplKEL_NAME = $contentdata['KEL_NAME'];

						$namaTanpaTitikD = str_replace("."," ",$DkcplNAMA_LGKP);
						$namaTanpaKomaD = str_replace(","," ",$namaTanpaTitikD);
						$namaTanpaPetikD = str_replace("'"," ",$namaTanpaKomaD);
						$namaTanpaStripD = str_replace("-"," ",$namaTanpaPetikD); 
						$namaTanpaSpasiDoubleD = str_replace("  "," ",$namaTanpaStripD);
						$namaTanpaSpasiD = strtoupper(trim(preg_replace('/[\t|\s{2,}]/', '', $namaTanpaSpasiDoubleD)));
						//echo $namaTanpaSpasiD;
						//echo strlen($namaTanpaSpasiD);
						
						$namaTanpaTitikP = str_replace("."," ",$data3['CUST_NAME']);
						$namaTanpaKomaP = str_replace(","," ",$namaTanpaTitikP);
						$namaTanpaPetikP = str_replace("'"," ",$namaTanpaKomaP);
						$namaTanpaStripP =  str_replace("-"," ",$namaTanpaPetikP);
						$namaTanpaSpasiDoubleP = str_replace("  "," ",$namaTanpaStripP);
						$namaTanpaSpasiP = strtoupper(trim(preg_replace('/[\t|\s{2,}]/', '', $namaTanpaSpasiDoubleP)));
						//echo $namaTanpaSpasiP;
						//echo strlen($namaTanpaSpasiP);
						
						if($namaTanpaSpasiD != $namaTanpaSpasiP){
							$StatusLogDkcpl1 = "DATA DITEMUKAN TIDAK SESUAI";
							
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningNama = "Perbedaan Nama Lengkap :<br>Data CONFINS : <b>".$data3['CUST_NAME']."</b><br>Data Dukcapil : <b>".$DkcplNAMA_LGKP."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN),array('1', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
						}else{
							$StatusLogDkcpl1 = "VALID";
						}

						if($DkcplTGL_LHR != $date1){
							$StatusLogDkcpl2 = "DATA DITEMUKAN TIDAK SESUAI";
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningTTL = "Perbedaan Tanggal lahir :<br>Data CONFINS : <b>".$date1."</b><br>Data Dukcapil : <b>".$DkcplTGL_LHR."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN),array('2', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
						}else{
							$StatusLogDkcpl2 = "VALID";
						}
						
							
						if($DkcplSTATUS_KAWIN == "KAWIN" && $data3['STATUS_KAWIN'] == "BELUM KAWIN"){
							$StatusLogDkcpl3 = "DATA DITEMUKAN TIDAK SESUAI";
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$data3['STATUS_KAWIN']."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));		
							}
							
							else if ($DkcplSTATUS_KAWIN == "KAWIN" && $data3['STATUS_KAWIN'] == ""){
							$StatusLogDkcpl3 = "DATA DITEMUKAN TIDAK SESUAI";
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$data3['STATUS_KAWIN']."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));		
							
						
							}else if($DkcplSTATUS_KAWIN == "BELUM KAWIN" && $data3['STATUS_KAWIN'] == "SUDAH KAWIN"){
							$StatusLogDkcpl3 = "DATA DITEMUKAN TIDAK SESUAI";
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$data3['STATUS_KAWIN']."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));			
							}
							else if($DkcplSTATUS_KAWIN == "BELUM KAWIN" && $data3['STATUS_KAWIN'] == ""){
							$StatusLogDkcpl3 = "DATA DITEMUKAN TIDAK SESUAI";
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$data3['STATUS_KAWIN']."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));			
						
							
							}else if ($DkcplSTATUS_KAWIN == "CERAI MATI" && $data3['STATUS_KAWIN'] == "BELUM KAWIN"){
							$StatusLogDkcpl3 = "DATA DITEMUKAN TIDAK SESUAI";
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$data3['STATUS_KAWIN']."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));		
							
							
							}else if ($DkcplSTATUS_KAWIN == "CERAI MATI" && $data3['STATUS_KAWIN'] == "KAWIN"){
							$StatusLogDkcpl3 = "DATA DITEMUKAN TIDAK SESUAI";
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$data3['STATUS_KAWIN']."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));	

							}else if ($DkcplSTATUS_KAWIN == "CERAI MATI" && $data3['STATUS_KAWIN'] == ""){
							$StatusLogDkcpl3 = "DATA DITEMUKAN TIDAK SESUAI";
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$data3['STATUS_KAWIN']."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));		
							
							}else if ($DkcplSTATUS_KAWIN == "CERAI MATI" && $data3['STATUS_KAWIN'] == "CERAI"){
							$StatusLogDkcpl3 = "VALID";
							}else if ($DkcplSTATUS_KAWIN == "CERAI HIDUP" && $data3['STATUS_KAWIN'] == "CERAI"){
							$StatusLogDkcpl3 = "VALID";
							
							
							}else{
								$StatusLogDkcpl3 = "VALID";
							}
							 	
						if(strtoupper($siapanih) == "PEMOHON"){
							$namaIbuTanpaTitikD = str_replace("."," ",$DkcplNAMA_LGKP_IBU);
							$namaIbuTanpaKomaD = str_replace(","," ",$namaIbuTanpaTitikD);
							$namaIbuTanpaPetikD = str_replace("'"," ",$namaIbuTanpaKomaD);
							$namaIbuTanpaStripD = str_replace("-"," ",$namaIbuTanpaPetikD); 
							$namaIbuTanpaSpasiDoubleD = str_replace("  "," ",$namaIbuTanpaStripD);
							$namaIbuTanpaSpasiD = strtoupper(trim(preg_replace('/[\t|\s{2,}]/', '', $namaIbuTanpaSpasiDoubleD)));
							//echo $namaIbuTanpaSpasiD;
							
							$namaIbuTanpaTitikP = str_replace("."," ",$mother_nm);
							$namaIbuTanpaKomaP = str_replace(","," ",$namaIbuTanpaTitikP);
							$namaIbuTanpaPetikP = str_replace("'"," ",$namaIbuTanpaKomaP);
							$namaIbuTanpaStripP = str_replace("-"," ",$namaIbuTanpaPetikP);
							$namaIbuTanpaSpasiDoubleP = str_replace("  "," ",$namaIbuTanpaStripP);
							$namaIbuTanpaSpasiP = strtoupper(trim(preg_replace('/[\t|\s{2,}]/', '', $namaIbuTanpaSpasiDoubleP)));
							//echo $_POST['mother_name'];
							//echo $namaIbuTanpaSpasiP;
							
							if($namaIbuTanpaSpasiD <> ""){
								if($namaIbuTanpaSpasiD != $namaIbuTanpaSpasiP){
									$StatusLogDkcpl4 = "DATA DITEMUKAN TIDAK SESUAI";
									$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
									$WarningIbu = "Perbedaan Nama Ibu Kandung :<br>Data CONFINS : <b>".$mother_nm."</b><br>Data Dukcapil : <b>".$DkcplNAMA_LGKP_IBU."</b><br>";
									
									$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
									$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN),array('3', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
									$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
								}else{
									$StatusLogDkcpl4 = "VALID";
								}
							}
							
						}
						$Is_Similar = 0;
						if($Warning_Data != ""){
							$Is_Similar = 1;
						}
					}
					
					
					
		}
	}
}
	
/*
$callHold = "{call SP_GET_CHECK_SOURCE_DETAIL_STATUS(?,?,?)}";
$paramHold = array(array($id, SQLSRV_PARAM_IN),
				array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),
				array($data['ID_NO'], SQLSRV_PARAM_IN));
$optionsHold =  array( "Scrollable" => "buffered" );
$execHold = sqlsrv_query( $conn, $callHold, $paramHold, $optionsHold) or die( print_r( sqlsrv_errors(), true));
$dataHold = sqlsrv_fetch_array($execHold);
$checkHold=sqlsrv_num_rows($execHold);
if($checkHold == 0){
	$callInsertStat = "{call SP_INSERT_STATUS_UNLOCK_DUKCAPIL(?,?,?,?,?)}";
	$paramsInsertStat = array(array($id, SQLSRV_PARAM_IN),array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN), array('3', SQLSRV_PARAM_IN));
	$execInsertStat = sqlsrv_query( $conn, $callInsertStat, $paramsInsertStat) or die( print_r( sqlsrv_errors(), true));
	
}
*/

/*else if(isset($_POST['reject'])){
	$prospect_no = $_POST['prospect_no'];
	$nik = $_POST['nik'];
	$id = $_POST['id'];

	$callInsertStat = "{call SP_INSERT_STATUS_UNLOCK_DUKCAPIL(?,?,?,?,?)}";
	$paramsInsertStat = array(array($id, SQLSRV_PARAM_IN),array($prospect_no, SQLSRV_PARAM_IN),array($nik, SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN), array('2', SQLSRV_PARAM_IN));
	$execInsertStat = sqlsrv_query( $conn, $callInsertStat, $paramsInsertStat) or die( print_r( sqlsrv_errors(), true));
	
	
	
	if($execInsertStat){
		echo"<script>alert('Reject Berhasil, Silahkan untuk melakukan pengkinian data ulang ');window.location='index.php?USERNAME=".$user."&page=unlock-dukcapil'</script>";
	}else{
		echo"<script>alert('Reject Gagal, Silahkan hubungi IT HO');history.back();</script>";
	}
	
}
*/

/***** CEK DUKCAPIL *****/
$call44 = "{call SP_CHECK_LOG_DUKCAPIL(?,?)}";
$params44 = array(
				array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),
				array($data['ID_NO'], SQLSRV_PARAM_IN)
			);
$options44 =  array( "Scrollable" => "buffered" );
$exec44 = sqlsrv_query($conn, $call44, $params44, $options44) or die( print_r( sqlsrv_errors(), true)); 
$data44 = sqlsrv_fetch_array($exec44);
$checkDukcapil44=sqlsrv_num_rows($exec44);
$id_log = $data44['LOG_CHECK_BYSOURCE_ID'];

$callChekLogError = "{call SP_CHECK_LOG_ERROR_DUKCAPIL(?)}";
$paramsChekLogError = array(
				array($id_log, SQLSRV_PARAM_IN)
			);
$optionsChekLogError =  array( "Scrollable" => "buffered" );
$execChekLogError = sqlsrv_query($conn, $callChekLogError, $paramsChekLogError, $optionsChekLogError) or die( print_r( sqlsrv_errors(), true)); 
$checkLogError=sqlsrv_num_rows($execChekLogError);

$callGetError = "{call SP_GET_VALIDASI_DUKCAPIL(?,?)}";
$options =  array( "Scrollable" => "buffered" );
$paramsGetError = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN));
$execGetError = sqlsrv_query($conn, $callGetError, $paramsGetError,$options) or die(print_r(sqlsrv_errors(), true));	
$dataGetError = sqlsrv_fetch_array($execGetError);
$checkGetError=sqlsrv_num_rows($execGetError);

/***** END CEK LOG ERROR *****/

$call14 = "{call SP_CHECK_STATUS_DUKCAPIL_RESULT_1(?,?)}";
$param14 = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),
				array($data['ID_NO'], SQLSRV_PARAM_IN));
$exec14 = sqlsrv_query( $conn, $call14, $param14) or die( print_r( sqlsrv_errors(), true));

$checkRows=sqlsrv_num_rows($exec1);

/*
	$call44 = "{call SP_GET_LOCK_DATA_NIK(?,?)}";
	$param44 = array(array($user, SQLSRV_PARAM_IN),
				   array($data['ID_NO'],SQLSRV_PARAM_IN));
	$exec44 = sqlsrv_query( $conn, $call44, $param44) or die( print_r( sqlsrv_errors(), true)); 	
	$data44 = sqlsrv_fetch_array($exec44);
	$logid= $data44['LOG_CHECK_BYSOURCE_ID'];
*/	
	


$callCount1 = "{call SP_GET_COUNT_CHECK_DUKCAPIL(?,?,?)}";
$paramCount1 = array(array($id, SQLSRV_PARAM_IN),
				array($data['ID_NO'], SQLSRV_PARAM_IN),
				array($data['PROSPECT_NO'], SQLSRV_PARAM_IN));
$optionsCount1 =  array( "Scrollable" => "buffered" );
$execCount1 = sqlsrv_query( $conn, $callCount1, $paramCount1, $optionsCount1) or die( print_r( sqlsrv_errors(), true));
$dataCount1 = sqlsrv_fetch_array($execCount1);

?>
<style>
.th-custom{
	text-align:center;
	background-color:#035c7a;
}
.td-center{
	text-align:center;
}
.pagination > li > a, .pagination > li > span{
	background-color:#FFF;
	color:#035c7a;
}
.pagination > li.active > a, .pagination > li.active > span{
	background-color:#035c7a;
	color:#FFF;
}
.pagination > li.active > a:hover, .pagination > li.active > span:hover{
	background-color:#035c7a;
	color:#FFF;
}
.pagination > li.focus > a, .pagination > li.focus > span:hover{
	background-color:#035c7a;
	color:#FFF;
}
.pagination > li.active > a.page-link, .pagination > li.active > span.page-link{
	background-color:#035c7a;
	color:#FFF;
}
</style>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Unlock Dukcapil</h4>
				<p class="category">Detail unlock dukcapil</p>
			</div>
			<div class="content">
				<div class="row">
					<div class="col-md-12">
					
						<div class="alert alert-danger alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
							<strong>SUDAH MELAKUKAN PENGECEKAN DUKCAPIL SEBANYAK  <?php echo $dataCount1['VOID']; ?> KALI (Maksimal Pengecekan 3x Dalam Sehari)</strong><br>
							
			
						</div>
				
						<?php if($checkLogError > 0){?>
				
		<?php
			echo'<div class="col-md-12">
					<div class="alert alert-danger alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
						<strong>Perhatian !</strong> Silahkan lakukan pengkinian data ke dukcapil setempat
					</div>
				</div>'; ?>
				<div class="alert alert-danger alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
							<strong>Perhatian !</strong><br>
							TERDAPAT PERBEDAAN DATA DUKCAPIL
							<?php
							/*
								$call2 = "{call SP_GET_DETAIL_ERROR_UNLOCK_DUKCAPIL(?)}";
								$param2 = array(array($logid, SQLSRV_PARAM_IN));
								$options2 =  array( "Scrollable" => "buffered" );
								$exec2 = sqlsrv_query( $conn, $call2, $param2, $options2) or die( print_r( sqlsrv_errors(), true)); 
								$numrows2 = sqlsrv_num_rows($exec2);
								while($data2 = sqlsrv_fetch_array($exec2)){
									echo $data2['MSG_NAME']."<br>";
								}
							*/
							?>
				</div>
				
				</div>
		<?php }else{
			if($Warning_Data <> ""){
				echo'<div class="col-md-12">
						<div class="alert alert-danger alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
							<strong>Perhatian !</strong> '.$Warning_Data.'
						</div>';
						?>
				<div class="alert alert-danger alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
							<strong>Perhatian !</strong><br>
								TERDAPAT PERBEDAAN DATA DUKCAPIL
							<?php
							/*
								$call2 = "{call SP_GET_DETAIL_ERROR_UNLOCK_DUKCAPIL(?)}";
								$param2 = array(array($logid, SQLSRV_PARAM_IN));
								$options2 =  array( "Scrollable" => "buffered" );
								$exec2 = sqlsrv_query( $conn, $call2, $param2, $options2) or die( print_r( sqlsrv_errors(), true)); 
								$numrows2 = sqlsrv_num_rows($exec2);
								while($data2 = sqlsrv_fetch_array($exec2)){
									echo $data2['MSG_NAME']."<br>";
								}
								*/
							?>
						</div></div>
			<?php }
		}
	?>
						
				<?php if($numrows1 > 0){ ?>
			
					<div class="alert alert-warning alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
							<strong>Perhatian !</strong><br>
							
							<?php
							
								while($dataNote = sqlsrv_fetch_array($exec1)){ ?>
									Note Reject UNLOCK : <?php echo $dataNote['NOTES']."<br>";
								}
							?>
						</div>	
						
					<?php } ?>
					
						
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-bordered table-striped" style="width:100%;font-size:12px;">
								<thead></thead>
								<tbody>
									<tr>
										<td colspan="3" style="color:#FFF;background-color:#035c7a;"><b>DISDUKCAPIL</td>
									</tr>
									<?php
									if($checkDukcapil44 > 0){
										if($checkGetError > 0 ){
												
											echo"
																<tr>
																	<td style='width:33%;'>Hasil Pengecekan</td>
																	<td style='width:33%;'>DATA TIDAK DITEMUKAN</td>
																	<td style='width:33%;'>Checked by ".$data44['CREATE_USER']." (".$data44['CREATE_DATE']->format("Y-m-d H:i:s")." )</td>
																</tr>";
											}
									else if($Warning_Data <> ""){
												echo"
																<tr>
																	<td style='width:33%;'>Hasil Pengecekan</td>
																	<td style='width:33%;'>DITEMUKAN, DATA TIDAK SESUAI</td>
																	<td style='width:33%;'>Checked by ".$data44['CREATE_USER']." (".$data44['CREATE_DATE']->format("Y-m-d H:i:s")." )</td>
																</tr>";
											} ELSE{
													echo"
															<tr>
																<td style='width:33%;'>Hasil Pengecekan</td>
																<td style='width:33%;'>DITEMUKAN, DATA SESUAI</td>
																<td style='width:33%;'>Checked by ".$data44['CREATE_USER']." (".$data44['CREATE_DATE']->format("Y-m-d H:i:s")." )</td>
															</tr>";
												}
									
									}else{
										echo"
										<tr>
											<td style='width:33%;'>Hasil Pengecekan</td>
											<td style='width:33%;'>BELUM PERNAH DI CEK</td>
											<td style='width:33%;'>-</td>
										</tr>";
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<!--<i class="text-danger"><b>*Data yang dicompare adalah Nama Lengkap, Tanggal Lahir, Nama Ibu Kandung, dan Status Kawin</b></i>-->
						<hr>
						<div class="row">
						<?php /*
							<div class="col-md-4">
								<form action="" method="post">
									<input type="hidden" name="prospect_no" value="<?php echo $data['PROSPECT_NO'];?>">
									<input type="hidden" name="nik" value="<?php echo $data['ID_NO'];?>">
									<input type="hidden" name="id" value="<?php echo $id;?>">
									<input type="submit" class="btn btn-custom" name="unlock" value="UNLOCK" onclick="return confirm('Apakah anda yakin ingin meng-unlock data ini?');" style="width:100%;">
								</form>
							</div>
								<div class="col-md-4">
								
							<form action="index.php?page=unlock-reject&USERNAME=<?php echo $user;?>" method="post" enctype="multipart/form-data" id="ff">
									<input type="hidden" name="prospect_no" value="<?php echo $data['PROSPECT_NO'];?>">
									<input type="hidden" name="nik" value="<?php echo $data['ID_NO'];?>">
									<input type="hidden" name="id" value="<?php echo $id;?>">
									<input type="submit" class="btn btn-custom" name="reject" value="REJECT" onclick="return confirm('Apakah anda yakin ingin reject data ini?');" style="width:100%;">
								</form>
								</div>
							<div class="col-md-4">
								*/ ?>
							<form action="" method="post" >
									<input type="hidden" name="prospect_no" value="<?php echo $data['PROSPECT_NO'];?>">
									<input type="hidden" name="nik" value="<?php echo $data['ID_NO'];?>">
									<input type="hidden" name="id" value="<?php echo $id;?>">
									<input type="submit" class="btn btn-custom" name="hold" value="Back" style="width:100%;">
								</form>
								</div>
						</div>
						<br><br>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>