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
/*
if($dataCount1['SISA_HARI_PENGECEKAN'] == '0'){
	echo "<script>alert('Prospect ini telah melewati waktu 14 hari, silahkan lakukan cancel');history.back();</script>";
	exit();
}
*/
if (strpos($data['PROSPECT_NO'], 'PRS') !== false) {
$call3 = "{call SP_GETDATA_INFO_CUSTOMER_NEWVERSE_2(?,?)}";
$param3 = array(array($data['ID_NO'], SQLSRV_PARAM_IN),
				array($data['PROSPECT_NO'], SQLSRV_PARAM_IN));
$options3 =  array( "Scrollable" => "buffered" );
$exec3 = sqlsrv_query( $conn, $call3, $param3, $options3) or die( print_r( sqlsrv_errors(), true));
$data3 = sqlsrv_fetch_array($exec3);

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
$call3 = "{call VBS_GET_DATA_CUSTOMER_KTP_1(?,?)}";
$param3 = array(array($data['ID_NO'], SQLSRV_PARAM_IN),
			array($data['PROSPECT_NO'], SQLSRV_PARAM_IN));
$options3 =  array( "Scrollable" => "buffered" );
$exec3 = sqlsrv_query( $conn, $call3, $param3, $options3) or die( print_r( sqlsrv_errors(), true));
$data3 = sqlsrv_fetch_array($exec3);

$callReason = "{call SP_GET_CANCEL_REASON_ORDER(?)}";
$paramReason = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN));
$optionsReason =  array( "Scrollable" => "buffered" );
$execReason = sqlsrv_query( $conn, $callReason, $paramReason, $optionsReason) or die( print_r( sqlsrv_errors(), true));
$dataReason = sqlsrv_fetch_array($execReason);
$checkReason=sqlsrv_num_rows($execReason);

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
}else{
$datePengecekan = $date;	
}
/*
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
*/
$call4 = "{call SP_GET_PENGKINIAN_DATA_BY_ORDER_NO_KK(?)}";
$param4 = array(array($data3['ID_NO'], SQLSRV_PARAM_IN));
$options4 =  array( "Scrollable" => "buffered" );
$exec4 = sqlsrv_query( $conn, $call4, $param4, $options4) or die( print_r( sqlsrv_errors(), true));
$data4 = sqlsrv_fetch_array($exec4);
$numrows4 = sqlsrv_num_rows($exec4);

	$callStatVerf = "{call SP_GET_STATUS_VERIFIKASI(?,?)}";
	$paramsStatVerf = array(
					array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),
					array($data['ID_NO'], SQLSRV_PARAM_IN)
				);
	$optionsStatVerf =  array( "Scrollable" => "buffered" );
	$execStatVerf = sqlsrv_query($conn, $callStatVerf, $paramsStatVerf, $optionsStatVerf) or die( print_r( sqlsrv_errors(), true)); 
	$dataStatVerf = sqlsrv_fetch_array($execStatVerf);
	$checkStatVerf=sqlsrv_num_rows($execStatVerf);


$NIK= $data['ID_NO'];
$NAMA_LGKP= $data3['CUST_NAME'];
$ALAMAT=$data3['ALAMAT'];

IF($checkStatVerf > 0){
		IF($dataStatVerf['PERUBAHAN_STATUS_KAWIN'] == ''){
			IF($data3['STATUS_KAWIN'] == "SUDAH KAWIN"){
				$STATUS_KAWIN= "KAWIN";
			}Else IF($data3['STATUS_KAWIN'] == "BELUM KAWIN"){
				$STATUS_KAWIN= "BELUM KAWIN";
			}Else{
				$STATUS_KAWIN=$data3['STATUS_KAWIN'];
			}
			
			$NAMA_LGKP_IBU= $dataStatVerf['PERUBAHAN_NAMA_IBU'];
		}else if ($dataStatVerf['PERUBAHAN_NAMA_IBU'] == ''){
			$STATUS_KAWIN= $dataStatVerf['PERUBAHAN_STATUS_KAWIN'];
			$NAMA_LGKP_IBU= $data3['NAMA_IBU'];	
		}else{
				$STATUS_KAWIN= $dataStatVerf['PERUBAHAN_STATUS_KAWIN'];
			$NAMA_LGKP_IBU= $dataStatVerf['PERUBAHAN_NAMA_IBU'];
		}

}else{

IF($data3['STATUS_KAWIN'] == "SUDAH KAWIN"){
	$STATUS_KAWIN= "KAWIN";
}Else IF($data3['STATUS_KAWIN'] == "BELUM KAWIN"){
	$STATUS_KAWIN= "BELUM KAWIN";
}Else{
	$STATUS_KAWIN=$data3['STATUS_KAWIN'];
}
$NAMA_LGKP_IBU= $data3['NAMA_IBU'];	

}

$TMPT_LHR= "";
if (strpos($data['PROSPECT_NO'], 'PRS') !== false) {
$TGL_LHR1= $data3['TL'];
}else{
$TGL_LHR1= $data3['TL'];
}
$TGL_LHR2 = strtotime($TGL_LHR1);
$TGL_LHR =  date("d-m-Y", $TGL_LHR2);

// $TGL_LHR= "06-07-1987";
$KAB_NAME= " ";
$KEC_NAME= " ";
$KEL_NAME= " ";
$PROP_NAME= "";
$NO_RT= "";
$NO_RW= "";
IF ($data3['JENIS_KELAMIN'] == 'LAKI-LAKI'){
	$JK="Laki-Laki";
}else{
	$JK =$data3['JENIS_KELAMIN']; 
}

$JENIS_KLMIN= $JK;
$JENIS_PKRJN= $data3['PEKERJAAN'];
$TRESHOLD= "90";
//$USER_ID= "10643174202101271dummy_suzuki_finance";
$USER_ID= "25082022141010SUZUKI_FINANCE4288";
//$PASSWORD= "123456";
$PASSWORD= "MZ33CU";
$IP_USER= "172.16.2.5";


$param_dukcapil_array= array('NIK' => $NIK, 'NAMA_LGKP' => $NAMA_LGKP, 'ALAMAT' => $ALAMAT, 'STATUS_KAWIN' => $STATUS_KAWIN, 'TMPT_LHR' => $TMPT_LHR, 'TGL_LHR' => $TGL_LHR, 
								'KAB_NAME' => $KAB_NAME, 'KEC_NAME' => $KEC_NAME, 'KEL_NAME' => $KEL_NAME, 'PROP_NAME' => $PROP_NAME, 'NO_RT' => $NO_RT, 'JENIS_KLMIN' => $JENIS_KLMIN, 
								'JENIS_PKRJN' => $JENIS_PKRJN, 'NAMA_LGKP_IBU' => $NAMA_LGKP_IBU, 'TRESHOLD' => $TRESHOLD, 'USER_ID' => $USER_ID, 'PASSWORD' => $PASSWORD, 'IP_USER' => $IP_USER);

	$param_dukcapil = json_encode($param_dukcapil_array);
	$curlDkUpil = curl_init();
	curl_setopt_array($curlDkUpil, array(

		//CURLOPT_URL => "https://172.16.160.177:8000/dukcapil/get_json/SUZUKI_FINANCE/CALL_VERIFY_BY_ELEMEN",
		CURLOPT_URL => "http://172.16.160.186:8000/dukcapil/get_json/990040921021160/CALL_VERIFY_BY_ELEMEN",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
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

		if(empty($resultDukcapil)){
			//----# Insert LOG
			$SourceLogDkUpilNtValid = "DUKCAPIL";
			$StatusLogDkUpilNtValid = "KTP TIDAK VALID";
			echo "<script>alert('Error : ".$StatusLogDkUpilNtValid." (Pada saat pengecekan NIK ke Dukcapil.!)');history.back();</script>";
		
			
			//----# Insert LOG End

			//echo "<script>alert('Error : ".$StatusLogDkUpilNtValid." (Pada saat pengecekan No KTP di Dukcapil.!)')</script>";
			$Warning_Data = $Warning_Data." - KTP TIDAK VALID (Pada saat pengecekan No KTP di Dukcapil.!) ";
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
			
				echo "<script>alert('Error : ".$errDkUpil." (Pada saat pengecekan No KTP di Dukcapil..!)')</script>";
			}else{
				if(isset($resultDukcapil['content'][0]['RESPONSE'])) {
					//----# Insert LOG
					$SourceLogDkUpilnotfound = "DUKCAPIL";
					$StatusLogDkUpilnotfound = strtoupper($resultDukcapil['content'][0]['RESPONSE']);

					$callSPLogDkUpilnotfound = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
					$paramsLogDkUpilnotfound = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN),array($SourceLogDkUpilnotfound, SQLSRV_PARAM_IN),array($StatusLogDkUpilnotfound, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
					$execLogDkUpilnotfound = sqlsrv_query( $conn, $callSPLogDkUpilnotfound, $paramsLogDkUpilnotfound) or die( print_r( sqlsrv_errors(), true));
					
					$callGetLog = "{call SP_GET_LOG_ID_DUKCAPIL_NOT_FOUND(?,?)}";
					$paramsGetLog = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN));
					$execGetLog = sqlsrv_query( $conn, $callGetLog, $paramsGetLog) or die( print_r( sqlsrv_errors(), true));
					$dataGetLog = sqlsrv_fetch_array($execGetLog);
					$idLog = $dataGetLog['LOG_CHECK_BYSOURCE_ID'];
				
					
					$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
					$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN),array(5, SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
			
						$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
						
					
					if($execLogDkUpilnotfound === false){
						echo"<script>alert('NIK Tersebut Tidak ditemukan di Dukcapil.!');</script>";
					}
					//----# Insert LOG End
					
					echo "<script>alert('Error : ".$StatusLogDkUpilnotfound." (Pada saat pengecekan No KTP di Dukcapil!)');</script>";
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
			//----# Insert LOG
					$callStatNikah = "{call SP_GET_VERIFIKASI_VERIFIED(?,?)}";
					$paramsStatNikah = array(
									array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),
									array($data['ID_NO'], SQLSRV_PARAM_IN)
								);
					$optionsStatNikah =  array( "Scrollable" => "buffered" );
					$execStatNikah = sqlsrv_query($conn, $callStatNikah, $paramsStatNikah, $optionsStatNikah) or die( print_r( sqlsrv_errors(), true)); 
					$checkStatNikah=sqlsrv_num_rows($execStatNikah);
					
				
						
					//validasi logcheck
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
							
							
							
	
						//echo $namaTanpaSpasiP;
						//echo strlen($namaTanpaSpasiP);
						
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
							
							 	
						//if(strtoupper($siapanih) == "PEMOHON"){
							if($checkStatNikah > 0){ 
								$StatusLogDkcpl4 = "VALID";
								}else{
								if($DkcplNAMA_LGKP_IBU != "Sesuai (100)"  && $DkcplNAMA_LGKP_IBU != "Sesuai (99)" && $DkcplNAMA_LGKP_IBU != "Sesuai (98)" && $DkcplNAMA_LGKP_IBU != "Sesuai (97)" 
															 && $DkcplNAMA_LGKP_IBU != "Sesuai (96)" && $DkcplNAMA_LGKP_IBU != "Sesuai (95)" && $DkcplNAMA_LGKP_IBU != "Sesuai (94)"
															 && $DkcplNAMA_LGKP_IBU != "Sesuai (93)" && $DkcplNAMA_LGKP_IBU != "Sesuai (92)" && $DkcplNAMA_LGKP_IBU != "Sesuai (91)"
															 && $DkcplNAMA_LGKP_IBU != "Sesuai (90)"){
								$StatusLogDkcpl4 = "DATA DITEMUKAN TIDAK SESUAI";
							
								}else{
									$StatusLogDkcpl4 = "VALID";
								}
							}
									
							/*				
							}else{
										$StatusLogDkcpl4 = "VALID";
									}
									*/
						}
					
					
					
					
			
					$SourceLogDkcpl = "DUKCAPIL";
					//$StatusLogDkcpl = "VALID";
					if($StatusLogDkcpl1 == "VALID" && $StatusLogDkcpl2 == "VALID" && $StatusLogDkcpl3 == "VALID" && $StatusLogDkcpl4 == "VALID"){
						$StatusLogDkcpl = "VALID";
					}else{
						$StatusLogDkcpl = "DATA DITEMUKAN TIDAK SESUAI";
					}
					
					$callSPLogDkcpl = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
					$paramsLogDkcpl = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN),array($SourceLogDkcpl, SQLSRV_PARAM_IN),array($StatusLogDkcpl, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
					$execLogDkcpl = sqlsrv_query( $conn, $callSPLogDkcpl, $paramsLogDkcpl) or die( print_r( sqlsrv_errors(), true));
					//----# Insert LOG End
				
					//GET LOG ID
					$callGetLog = "{call SP_GET_LOG_ID_DUKCAPIL(?,?)}";
					$paramsGetLog = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN));
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
													array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),
													array($data['ID_NO'], SQLSRV_PARAM_IN),
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
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningNama = "Perbedaan Nama Lengkap :<br>Data CONFINS : <b>".$NAMA_LGKP."</b><br>Data Dukcapil : <b>".$DkcplNAMA_LGKP."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN),array('1', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
						}
						
						if($DkcplTGL_LHR == "Tidak Sesuai"){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningTTL = "Perbedaan Tanggal lahir :<br>Data CONFINS : <b>".$TGL_LHR."</b><br>Data Dukcapil : <b>".$DkcplTGL_LHR."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN),array('2', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
						}
						
						if($checkStatNikah == 0){ 			
						if($DkcplSTATUS_KAWIN == "Tidak Sesuai"){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$STATUS_KAWIN."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));		
							}
						}
							
							 	
					//	if(strtoupper($siapanih) == "PEMOHON"){
						if($checkStatNikah == 0){
								if($DkcplNAMA_LGKP_IBU != "Sesuai (100)"  && $DkcplNAMA_LGKP_IBU != "Sesuai (99)" && $DkcplNAMA_LGKP_IBU != "Sesuai (98)" && $DkcplNAMA_LGKP_IBU != "Sesuai (97)" 
															 && $DkcplNAMA_LGKP_IBU != "Sesuai (96)" && $DkcplNAMA_LGKP_IBU != "Sesuai (95)" && $DkcplNAMA_LGKP_IBU != "Sesuai (94)"
															 && $DkcplNAMA_LGKP_IBU != "Sesuai (93)" && $DkcplNAMA_LGKP_IBU != "Sesuai (92)" && $DkcplNAMA_LGKP_IBU != "Sesuai (91)"
															 && $DkcplNAMA_LGKP_IBU != "Sesuai (90)"){
									$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
									$WarningIbu = "Perbedaan Nama Ibu Kandung :<br>Data CONFINS : <b>".$data3['NAMA_IBU']."</b><br>Data Dukcapil : <b>".$DkcplNAMA_LGKP_IBU."</b><br>";
									
									$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
									$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN),array('3', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
									$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
							//	}
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

$callGetError = "{call SP_GET_VALIDASI_DUKCAPIL(?,?)}";
$options =  array( "Scrollable" => "buffered" );
$paramsGetError = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN));
$execGetError = sqlsrv_query($conn, $callGetError, $paramsGetError,$options) or die(print_r(sqlsrv_errors(), true));	
$dataGetError = sqlsrv_fetch_array($execGetError);
$checkGetError=sqlsrv_num_rows($execGetError);


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
				<h4 class="title">Cek Ulang Dukcapil</h4>
				<p class="category">Detail Cek Ulang Dukcapil</p>
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
					<?php /*
						<div class="row">
						<?php ?>
							<div class="col-md-4">
								<table class="table table-bordered table-stiped" style="font-size:10px;">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DATA CONFINS</td>
									</tr>
									<tr>
										<td style="width:50%;">NIK</td>
										<td style="width:50%;"><?php echo $NIK;?></td>
									</tr>
									<tr>
										<td >Nama Lengkap</td>
										<td><?php echo $NAMA_LGKP;?></td>
									</tr>
									<tr>
										<td>Tempat Lahir</td>
										<td><?php echo $TMPT_LHR;?></td>
									</tr>
										<td>Tanggal Lahir</td>
										<td><?php echo $TGL_LHR;?></td>
									</tr>
									
									<tr>
										<td>Jenis Kelamin</td>
										<td><?php echo $JENIS_KLMIN;?></td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td><?php echo $ALAMAT;?></td>
									</tr>
									<tr>
										<td>RT</td>
										<td><?php echo $NO_RT;?></td>
									</tr>
									
									<tr>
										<td>RW</td>
										<td><?php echo $NO_RW;?></td>
									</tr>
									<tr>
										<td>Kelurahan/Desa</td>
										<td><?php echo $KEL_NAME;?></td>
									</tr>
									<tr>
										<td>Kecamatan</td>
										<td><?php echo $KEC_NAME;?></td>
									</tr>
									<tr>
										<td>Kabupaten</td>
										<td><?php echo  $KAB_NAME;?></td>
									</tr>
									<tr>
										<td>Provinsi</td>
										<td><?php echo $PROP_NAME;?></td>
									</tr>
									<tr>
										<td>Status Kawin</td>
										<td><?php echo $STATUS_KAWIN;?></td>
									</tr>
									<tr>
										<td>Nama Ibu Kandung</td>
										<td><?php echo $NAMA_LGKP_IBU;?></td>
									</tr>
									<tr>
										<td>Pekerjaan</td>
										<td><?php echo $JENIS_PKRJN;?></td>
									</tr>
								</table>
							</div>
							<div class="col-md-4">
								<table class="table table-bordered table-stiped" style="font-size:10px;">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DATA DUKCAPIL</td>
									</tr>
									
									<tr>
										<td style="width:50%;">NIK</td>
										<td style="width:50%;"><?php echo $DkcplNIK;?></td>
									</tr>
									<tr>
									
										<td >Nama Lengkap</td>
										<td><?php echo $DkcplNAMA_LGKP;?></td>
									</tr>
									<tr>
									
										<td>Tempat Lahir</td>
										<td><?php echo $DkcplTMPT_LHR;?></td>
									</tr>
									<tr>
									
										<td>Tanggal Lahir</td>
										<td><?php echo $DkcplTGL_LHR;?></td>
									</tr>
									<tr>
										<td>Jenis Kelamin</td>
										<td><?php echo $DkcplJENIS_KLMIN;?></td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td><?php echo $DkcplALAMAT;?></td>
									</tr>
									<tr>
										<td>RT/RW</td>
										<td><?php echo $DkcplNO_RT;?></td>
									</tr>
									<tr>
										<td>RW</td>
										<td><?php echo $DkcplNO_RW;?></td>
									</tr>
									<tr>
										<td>Kelurahan/Desa</td>
										<td><?php echo $DkcplKEL_NAME;?></td>
									</tr>
									<tr>
										<td>Kecamatan</td>
										<td><?php echo $DkcplKEC_NAME;?></td>
									</tr>
									<tr>
										<td>Kabupaten</td>
										<td><?php echo $DkcplKAB_NAME;?></td>
									</tr>
									<tr>
										<td>Provinsi</td>
										<td><?php echo $DkcplPROP_NAME;?></td>
									</tr>
									<tr>
										<td>Status Kawin</td>
										<td><?php echo $DkcplSTATUS_KAWIN;?></td>
									</tr>
									<tr>
									
									<td>Nama Ibu Kandung</td>
										<td><?php echo $DkcplNAMA_LGKP_IBU;?></td>
									</tr>
									
									<tr>
										<td>Pekerjaan</td>
										<td><?php echo $DkcplJENIS_PKRJN;?></td>
									</tr>
									
								</table>
							</div>
							<?php ?>
							<!--<div class="col-md-4">
								<table class="table table-bordered table-stiped" style="font-size:10px;width:100%;">
									<tr>
										<td style="background-color:#035c7a;color:#FFF;font-weight:bold;">RESI PENGKINIAN DATA & FOTO KK</td>
									</tr>
									<tr>
										<td>
											<?php //if($numrows4 == 0){ ?>
												<img src="assets/img/default.jpg" style="width:100%;">
											<?php// }else{ ?>
												<div style="width:100%;">
													<img src="data:image/jpeg;base64,<?php// echo base64_encode($data4['IMG_SRC']);?>" style="width:100%;">
												</div>
											<?php //} ?>
										</td>
									<tr>
										<td>
											<?php //if($numrows4 == 0 && $data4['IMG_KK']== NULL){ ?>
												<img src="assets/img/default.jpg" style="width:100%;">
											<?php //}else{ ?>
												<div style="width:100%;">
													<img src="data:image/jpeg;base64,<?php //echo base64_encode($data4['IMG_KK']);?>" style="width:100%;">
												</div>
											<?php// } ?>
										</td>
									</tr>
									</tr>
								</table>
							</div>-->
						</div>
						 */ ?>
					</div>
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
								$callCheckDuk = "{call SP_GET_RESPONSE_RESULT_ERROR_DETAIL_DUKCAPIL(?,?)}";
												$paramCheckDuk = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN));
												$execCheckDuk = sqlsrv_query( $conn, $callCheckDuk, $paramCheckDuk) or die( print_r( sqlsrv_defaults(), true)); 
												$dataCheckDuk = sqlsrv_fetch_array($execCheckDuk);
									if($checkDukcapil44 > 0){
										if($checkGetError > 0 ){
												
													
											echo"
																<tr>
																	<td style='width:33%;'>Hasil Pengecekan</td>
																	<td style='width:33%;'>".strtoupper($dataCheckDuk['MSG_NAME'])."</td>
																	<td style='width:33%;'>Checked by ".$data44['CREATE_USER']." (".$data44['CREATE_DATE']->format("Y-m-d H:i:s")." )</td>
																</tr>";
											}
									else if($Warning_Data <> ""){
												echo"
																<tr>
																	<td style='width:33%;'>Hasil Pengecekan</td>
																	<td style='width:33%;'>".strtoupper($dataCheckDuk['MSG_NAME'])."</td>
																	<td style='width:33%;'>Checked by ".$data44['CREATE_USER']." (".$data44['CREATE_DATE']->format("Y-m-d H:i:s")." )</td>
																</tr>";
											} ELSE{
													echo"
															<tr>
																<td style='width:33%;'>Hasil Pengecekan</td>
																<td style='width:33%;'>".strtoupper($dataCheckDuk['MSG_NAME'])."</td>
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