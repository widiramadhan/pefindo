<?php
require_once("config/configuration.php");
require_once("config/connection.php");
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
$date=date("Y-m-d");

$Warning_Data = "";
$WarningNama = "";
$WarningTTL = "";
$WarningIbu = "";
	//echo "<script>alert('Error : (Pada saat pengecekan NIK ke Dukcapil.!)');history.back();</script>";
		//	exit();
//$id=$_GET['id'];
if(isset($_POST['hold'])){
	$id=$_POST['id'];
	$prospect=$_POST['prospect_no'];
	$no_ktp=$_POST['no_ktp'];
	$nama=$_POST['name'];
	$date = date("Y-m-d", strtotime($_POST['date']));
	//$date=$_POST['date'];
	$mother_nm=$_POST['mother_name'];
	$birth_place=$_POST['birth_place'];
	$siapanih=$_POST['tipe_cust'];
	$getUsername=$_GET['USERNAME'];
	
	
	
	
	$call6 = "{call SP_UPDATE_DUKCAPIL_HOLD(?,?,?)}";
	$param6 = array(array($prospect, SQLSRV_PARAM_IN),
					array($no_ktp, SQLSRV_PARAM_IN),
					array('4', SQLSRV_PARAM_IN));
	$exec6 = sqlsrv_query( $conn, $call6, $param6) or die( print_r( sqlsrv_defaults(), true)); 
	$data6= sqlsrv_fetch_array($exec6);
	
	if($exec6){
		echo"<script>alert('Data berhasil dihold');window.location='index.php?page=pefindonodata&USERNAME=".$getUsername."'</script>";
	}else{
		echo"<script>alert('Data gagal dihold');history.back();</script>";
	}
	
	

}else{
	$id=$_POST['id'];
	$prospect=$_POST['prospect_no'];
	$no_ktp=$_POST['no_ktp'];
	$nama=$_POST['name'];
	$date = date("Y-m-d", strtotime($_POST['date']));
	//$date=$_POST['date'];
	$mother_nm=$_POST['mother_name'];
	$birth_place=$_POST['birth_place'];
	$siapanih=$_POST['tipe_cust'];
	$getUsername=$_GET['USERNAME'];

}


 /*
$call = "{call SP_GET_DETAIL_INFO_UNLOCK_DUKCAPIL(?)}";
$param = array(array($id, SQLSRV_PARAM_IN));
$options =  array( "Scrollable" => "buffered" );
$exec = sqlsrv_query( $conn, $call, $param, $options) or die( print_r( sqlsrv_errors(), true));
$data = sqlsrv_fetch_array($exec);
*/
/*$call3 = "{call SP_GETDATA_INFO_CUSTOMER(?,?)}";
$param3 = array(array($prospect, SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN));
$options3 =  array( "Scrollable" => "buffered" );
$exec3 = sqlsrv_query( $conn, $call3, $param3, $options3) or die( print_r( sqlsrv_errors(), true));
$data3 = sqlsrv_fetch_array($exec3);*/
if (strpos($prospect, 'PRS') !== false) {
$call3 = "{call SP_GETDATA_INFO_CUSTOMER_NEWVERSE_2(?,?)}";
$param3 = array(array($no_ktp, SQLSRV_PARAM_IN),
				array($prospect, SQLSRV_PARAM_IN));
$options3 =  array( "Scrollable" => "buffered" );
$exec3 = sqlsrv_query( $conn, $call3, $param3, $options3) or die( print_r( sqlsrv_errors(), true));
$data3 = sqlsrv_fetch_array($exec3);
}
else{

$call3 = "{call VBS_GET_DATA_CUSTOMER(?,?)}";
$param3 = array(array($prospect, SQLSRV_PARAM_IN),
				array($siapanih, SQLSRV_PARAM_IN));
$options3 =  array( "Scrollable" => "buffered" );
$exec3 = sqlsrv_query( $conn, $call3, $param3, $options3) or die( print_r( sqlsrv_errors(), true));
$data3 = sqlsrv_fetch_array($exec3);
}

$call4 = "{call SP_GET_PENGKINIAN_DATA_BY_ORDER_NO_KK(?)}";
$param4 = array(array($no_ktp, SQLSRV_PARAM_IN));
$options4 =  array( "Scrollable" => "buffered" );
$exec4 = sqlsrv_query( $conn, $call4, $param4, $options4) or die( print_r( sqlsrv_errors(), true));
$data4 = sqlsrv_fetch_array($exec4);
$numrows4 = sqlsrv_num_rows($exec4);

	
$NIK= $no_ktp;
$NAMA_LGKP= $nama;
$ALAMAT=$data3['ALAMAT'];
$dateCapil = date("d-m-Y", strtotime($date));
IF($data3['STATUS_KAWIN'] == "SUDAH KAWIN"){
	$STATUS_KAWIN= "KAWIN";
}Else IF($data3['STATUS_KAWIN'] == "BELUM KAWIN"){
	$STATUS_KAWIN= "BELUM KAWIN";
}Else{
	$STATUS_KAWIN=$data3['STATUS_KAWIN'];
}
	
	
$TMPT_LHR= "";
/*
$TGL_LHR1= $data3['TL'];
$TGL_LHR2 = strtotime($TGL_LHR1);
$TGL_LHR =  date("d-m-Y", $TGL_LHR2);
*/
$TGL_LHR = $dateCapil;

// $TGL_LHR= "06-07-1987";
$KAB_NAME= " ";
$KEC_NAME= " ";
$KEL_NAME= " ";
$PROP_NAME= "";
$NO_RT= "";
$NO_RW= "";
$JENIS_KLMIN= $data3['JENIS_KELAMIN'];
$JENIS_PKRJN= $data3['PEKERJAAN'];
$NAMA_LGKP_IBU= $data3['NAMA_IBU'];
$TRESHOLD= "90";
//$USER_ID= "10643174202101271dummy_suzuki_finance";
$USER_ID= "25082022141010SUZUKI_FINANCE4288";
//$PASSWORD= "123456";
$PASSWORD= "MZ33CU";
$IP_USER= "172.16.2.5";







if($no_ktp==""){
		echo"<script>alert('Nomor KTP tidak boleh kosong, silahkan lakukan edit data di CONFINS');history.back();</script>";
	}else if($nama==""){
		echo"<script>alert('Nama tidak boleh kosong, silahkan lakukan edit data di CONFINS');history.back();</script>";
	}else if($date==""){
		echo"<script>alert('Tanggal lahir tidak boleh kosong, silahkan lakukan edit data di CONFINS');history.back();</script>";
	}else if(substr($no_ktp,0,1) == "0"){
		echo"<script>alert('Nomor KTP tidak boleh berawalan 0');history.back();</script>";
	}else if(substr($no_ktp,-4) == "0000"){
		echo"<script>alert('4 Digit Nomor KTP tidak boleh 0000');history.back();</script>";
	}else if(strlen(trim($no_ktp)) <> 16){
		echo"<script>alert('NIK harus 16 digit');history.back();</script>";
	}else if(preg_match("/^[a-zA-Z]$/", $no_ktp)){
		echo"<script>alert('NIK tidak boleh mengandung alphabet');history.back();</script>";
	}else{
	
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
										//'param' => '[{"id_lembaga": "041148","NIK": "'.$no_ktp.'" ,"indexno": "0"},{ "id_lembaga": "041148","NO_ORDER":  "'.$prospect.'","indexno": "1"}]'),
										'param' => '[{"NO_CIF": "'.$prospect.'"}]'),
										
			  CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer nkqAt2em3pjIc9bR4xJJMNG8PT7yqVFLlu2RpfJNHHLPRNb70eZLnSf5A1cG8HcX5hrXpF4Av8A3C8YqVNxzdpuBZ4VZgvDmoAgB',
				'Cookie: adminduk_session=eyJpdiI6ImZvSkY1SG1SeXJOa01xcHpGUUhkN0E9PSIsInZhbHVlIjoidDhsbjBrbEdSQ015NE8rS29OcDRzd0YybW9CbTJacmI4ZG5UZno3XC81R2lnOTllbFBXRklSSnFhcjVOZG9zcGVYVmlqTXBrZ0ZYZjZEWHZCV0p4akxBPT0iLCJtYWMiOiI5OWNkZDMxZWM1OGI5MzU2NmE4NDhkNGM0NTQzOWZiNWMxZDM3ZWZiZGUxM2I1NTkzOTE0MTIwMzY1ZDhhY2QyIn0%3D'
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);


			$response_balikan = str_replace('"',"",$response);
				
			$callSPLogDkUpilNtValid = "{call SP_INSERT_LOG_DATA_BALIKAN(?,?,?,?)}";
			$paramsLogDkUpilNtValid = array(array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN), array($response_balikan, SQLSRV_PARAM_IN),array($getUsername, SQLSRV_PARAM_IN));
			$execLogDkUpilNtValid = sqlsrv_query( $conn, $callSPLogDkUpilNtValid, $paramsLogDkUpilNtValid) or die( print_r( sqlsrv_errors(), true));	
		
		
		if(empty($resultDukcapil)){
			//----# Insert LOG
			$SourceLogDkUpilNtValid = "DUKCAPIL";
			$StatusLogDkUpilNtValid = "KTP TIDAK VALID";
			echo "<script>alert('Error : ".$StatusLogDkUpilNtValid." (Pada saat pengecekan NIK ke Dukcapil.!)');history.back();</script>";
			exit();
			
			//----# Insert LOG End

			//echo "<script>alert('Error : ".$StatusLogDkUpilNtValid." (Pada saat pengecekan No KTP di Dukcapil.!)')</script>";
			$Warning_Data = $Warning_Data." - KTP TIDAK VALID (Pada saat pengecekan No KTP di Dukcapil.!) ";
		}else{
			if($errDkUpil){
				//----# Insert LOG
				$SourceLogDkUpil = "DUKCAPIL";
				$StatusLogDkUpil = "ERROR";

				$callSPLogDkUpil = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
				$paramsLogDkUpil = array(array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkUpil, SQLSRV_PARAM_IN),array($StatusLogDkUpil, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
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
					$paramsLogDkUpilnotfound = array(array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkUpilnotfound, SQLSRV_PARAM_IN),array($StatusLogDkUpilnotfound, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
					$execLogDkUpilnotfound = sqlsrv_query( $conn, $callSPLogDkUpilnotfound, $paramsLogDkUpilnotfound) or die( print_r( sqlsrv_errors(), true));
					
					$callGetLog = "{call SP_GET_LOG_ID_DUKCAPIL_NOT_FOUND(?,?)}";
					$paramsGetLog = array(array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN));
					$execGetLog = sqlsrv_query( $conn, $callGetLog, $paramsGetLog) or die( print_r( sqlsrv_errors(), true));
					$dataGetLog = sqlsrv_fetch_array($execGetLog);
					$idLog = $dataGetLog['LOG_CHECK_BYSOURCE_ID'];
				
					
					$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL(?,?,?,?,?)}";
					$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array(5, SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
			
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
					//----# Insert LOG
				
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
						
	 	
						if(strtoupper($siapanih) == "PEMOHON"){
								if($DkcplNAMA_LGKP_IBU != "Sesuai (100)"  && $DkcplNAMA_LGKP_IBU != "Sesuai (99)" && $DkcplNAMA_LGKP_IBU != "Sesuai (98)" && $DkcplNAMA_LGKP_IBU != "Sesuai (97)" 
															 && $DkcplNAMA_LGKP_IBU != "Sesuai (96)" && $DkcplNAMA_LGKP_IBU != "Sesuai (95)" && $DkcplNAMA_LGKP_IBU != "Sesuai (94)"
															 && $DkcplNAMA_LGKP_IBU != "Sesuai (93)" && $DkcplNAMA_LGKP_IBU != "Sesuai (92)" && $DkcplNAMA_LGKP_IBU != "Sesuai (91)"
															 && $DkcplNAMA_LGKP_IBU != "Sesuai (90)"){
								$StatusLogDkcpl4 = "DATA DITEMUKAN TIDAK SESUAI";
							
								}else{
									$StatusLogDkcpl4 = "VALID";
								}
									
						if($STATUS_KAWIN == "Tidak Sesuai"){
						$StatusLogDkcpl3 = "DATA DITEMUKAN TIDAK SESUAI";
					
						}else{
							$StatusLogDkcpl3 = "VALID";
						}			
							
					}else{
						$StatusLogDkcpl4 = "VALID";
						$StatusLogDkcpl3 = "VALID";
					}
				}
					
					
						$SourceLogDkcpl = "DUKCAPIL";
						//$StatusLogDkcpl = "VALID";
						
						if($StatusLogDkcpl1 == "VALID" && $StatusLogDkcpl2 == "VALID" && $StatusLogDkcpl3 == "VALID" && $StatusLogDkcpl4 == "VALID"){
						$StatusLogDkcpl = "VALID";
						}else{
							$StatusLogDkcpl = "DATA DITEMUKAN TIDAK SESUAI";
						}
						$callSPLogDkcpl = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
					$paramsLogDkcpl = array(array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkcpl, SQLSRV_PARAM_IN),array($StatusLogDkcpl, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
					$execLogDkcpl = sqlsrv_query( $conn, $callSPLogDkcpl, $paramsLogDkcpl) or die( print_r( sqlsrv_errors(), true));
						
						//GET LOG ID
					$callGetLog = "{call SP_GET_LOG_ID_DUKCAPIL(?,?)}";
					$paramsGetLog = array(array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN));
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
													array($prospect, SQLSRV_PARAM_IN),
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
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningNama = "Perbedaan Nama Lengkap :<br>Data CONFINS : <b>".$nama."</b><br>Data Dukcapil : <b>".$DkcplNAMA_LGKP."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('1', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
						}
						
						if($DkcplTGL_LHR == "Tidak Sesuai"){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningTTL = "Perbedaan Tanggal lahir :<br>Data CONFINS : <b>".$date."</b><br>Data Dukcapil : <b>".$DkcplTGL_LHR."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('2', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
						}
						
							
						
							
							 	
						if(strtoupper($siapanih) == "PEMOHON"){
								if($DkcplNAMA_LGKP_IBU != "Sesuai (100)"  && $DkcplNAMA_LGKP_IBU != "Sesuai (99)" && $DkcplNAMA_LGKP_IBU != "Sesuai (98)" && $DkcplNAMA_LGKP_IBU != "Sesuai (97)" 
															 && $DkcplNAMA_LGKP_IBU != "Sesuai (96)" && $DkcplNAMA_LGKP_IBU != "Sesuai (95)" && $DkcplNAMA_LGKP_IBU != "Sesuai (94)"
															 && $DkcplNAMA_LGKP_IBU != "Sesuai (93)" && $DkcplNAMA_LGKP_IBU != "Sesuai (92)" && $DkcplNAMA_LGKP_IBU != "Sesuai (91)"
															 && $DkcplNAMA_LGKP_IBU != "Sesuai (90)"){
									$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
									$WarningIbu = "Perbedaan Nama Ibu Kandung :<br>Data CONFINS : <b>".$mother_nm."</b><br>Data Dukcapil : <b>".$DkcplNAMA_LGKP_IBU."</b><br>";
									
									$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
									$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('3', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
									$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
								}
									
						if($DkcplSTATUS_KAWIN == "Tidak Sesuai"){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$data3['STATUS_KAWIN']."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));		
							}
							
							
							
						}
						$Is_Similar = 0;
						if($Warning_Data != ""){
							$Is_Similar = 1;
						}
					}
				
				/*	
					if($dataGetError > 0 ){
					 if($_GET['USERNAME'] == 'iman.santoso' || $_GET['USERNAME'] == 'djoko.andrew' || $_GET['USERNAME'] == 'ramandona' || $_GET['USERNAME'] == 'IMAN.SANTOSO' || $_GET['USERNAME'] == 'DJOKO.ANDREW' || $_GET['USERNAME'] == 'RAMANDONA' || $_GET['USERNAME'] == 'NOVRIKAWATI' || $_GET['USERNAME'] == 'KIKI.AMALIA' || $_GET['USERNAME'] == 'novrikawati' || $_GET['USERNAME'] == 'kiki.amalia' || $_GET['USERNAME'] == 'AHMAD.HABIBI' ||$_GET['USERNAME'] == 'DENY.SAPUTRA' || $_GET['USERNAME'] == 'Haris.Siswanto' || $_GET['USERNAME'] == 'HARIS.SISWANTO' || $_GET['USERNAME'] == 'Yose.Kertapati' || $_GET['USERNAME'] == 'YOSE.KERTAPATI'	|| $_GET['USERNAME'] == 'Muhammad' || $_GET['USERNAME'] == 'MUHAMMAD' || $_GET['USERNAME'] == 'Ramandona.Dinara' || $_GET['USERNAME'] == 'RAMANDONA.DINARA' || $_GET['USERNAME'] == 'Jimmy.Sujana' || $_GET['USERNAME'] == 'JIMMY.SUJANA' || $_GET['USERNAME'] == 'Ricky.Randhita' || $_GET['USERNAME'] == 'RICKY.RANDHITA' || $_GET['USERNAME'] == 'Herberth.Simbolon' || $_GET['USERNAME'] == 'HERBERTH.SIMBOLON' || $_GET['USERNAME'] == 'Moh.Junaidi.Siyam' || $_GET['USERNAME'] == 'MOH.JUNAIDI.SIYAM' ){	  	  
						echo"<script>alert('Data terkena validasi dukcapil, silahkan lakukan pengkinian data');window.location='index.php?page=individual-ho-new&USERNAME=".$getUsername."'</script>";
					 }else {
						echo"<script>alert('Data terkena validasi dukcapil, silahkan lakukan pengkinian data');window.location='index.php?page=individual&USERNAME=".$getUsername."'</script>"; 
					 }
					}		*/			
				}
			}
		}
	}



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
<?php
/***** CEK DUKCAPIL *****/
$call = "{call SP_CHECK_LOG_DUKCAPIL(?,?)}";
$params = array(
				array($prospect, SQLSRV_PARAM_IN),
				array($no_ktp, SQLSRV_PARAM_IN)
			);
$options =  array( "Scrollable" => "buffered" );
$exec = sqlsrv_query($conn, $call, $params, $options) or die( print_r( sqlsrv_errors(), true)); 
$data = sqlsrv_fetch_array($exec);
$checkDukcapil=sqlsrv_num_rows($exec);
$id_log = $data['LOG_CHECK_BYSOURCE_ID'];

/***** CEK LOG ERROR *****/
$callChekLogError = "{call SP_CHECK_LOG_ERROR_DUKCAPIL(?)}";
$paramsChekLogError = array(
				array($id_log, SQLSRV_PARAM_IN)
			);
$optionsChekLogError =  array( "Scrollable" => "buffered" );
$execChekLogError = sqlsrv_query($conn, $callChekLogError, $paramsChekLogError, $optionsChekLogError) or die( print_r( sqlsrv_errors(), true)); 
$checkLogError=sqlsrv_num_rows($execChekLogError);
/***** END CEK LOG ERROR *****/

$call1 = "{call SP_CHECK_STATUS_DUKCAPIL_RESULT_1(?,?)}";
$param1 = array(array($prospect, SQLSRV_PARAM_IN),
				array($no_ktp, SQLSRV_PARAM_IN));
$exec1 = sqlsrv_query( $conn, $call1, $param1) or die( print_r( sqlsrv_errors(), true));

$checkRows=sqlsrv_num_rows($exec1);

	$call44 = "{call SP_GET_LOCK_DATA_NIK(?,?)}";
	$param44 = array(array($getUsername, SQLSRV_PARAM_IN),
				   array($no_ktp,SQLSRV_PARAM_IN));
	$exec44 = sqlsrv_query( $conn, $call44, $param44) or die( print_r( sqlsrv_errors(), true)); 	
	$data44 = sqlsrv_fetch_array($exec44);
	$logid= $data44['LOG_CHECK_BYSOURCE_ID'];
	
		$callGetError = "{call SP_GET_VALIDASI_DUKCAPIL(?,?)}";
					$options =  array( "Scrollable" => "buffered" );
					$paramsGetError = array(array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN));
					$execGetError = sqlsrv_query($conn, $callGetError, $paramsGetError,$options) or die(print_r(sqlsrv_errors(), true));	
					$dataGetError = sqlsrv_fetch_array($execGetError);
					$checkGetError=sqlsrv_num_rows($execGetError);
/*
	
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
							'param' => '[{"id_lembaga": "041148","NIK": "'.$no_ktp.'" ,"indexno": "0"},{ "id_lembaga": "041148","NO_ORDER":  "'.$prospect.'","indexno": "1"}]'),
  CURLOPT_HTTPHEADER => array(
	'Authorization: Bearer nkqAt2em3pjIc9bR4xJJMNG8PT7yqVFLlu2RpfJNHHLPRNb70eZLnSf5A1cG8HcX5hrXpF4Av8A3C8YqVNxzdpuBZ4VZgvDmoAgB',
	'Cookie: adminduk_session=eyJpdiI6ImZvSkY1SG1SeXJOa01xcHpGUUhkN0E9PSIsInZhbHVlIjoidDhsbjBrbEdSQ015NE8rS29OcDRzd0YybW9CbTJacmI4ZG5UZno3XC81R2lnOTllbFBXRklSSnFhcjVOZG9zcGVYVmlqTXBrZ0ZYZjZEWHZCV0p4akxBPT0iLCJtYWMiOiI5OWNkZDMxZWM1OGI5MzU2NmE4NDhkNGM0NTQzOWZiNWMxZDM3ZWZiZGUxM2I1NTkzOTE0MTIwMzY1ZDhhY2QyIn0%3D'
  ),
));

$response = curl_exec($curl);

curl_close($curl);


$response_balikan = str_replace('"',"",$response);
	
$callSPLogDkUpilNtValid = "{call SP_INSERT_LOG_DATA_BALIKAN(?,?,?,?)}";
$paramsLogDkUpilNtValid = array(array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN), array($response_balikan, SQLSRV_PARAM_IN),array($getUsername, SQLSRV_PARAM_IN));
$execLogDkUpilNtValid = sqlsrv_query( $conn, $callSPLogDkUpilNtValid, $paramsLogDkUpilNtValid) or die( print_r( sqlsrv_errors(), true));	
*/


?>
<div class="row">



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

	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Detail Dukcapil</h4>
				<p class="category">Detail Dukcapil</p>
			</div>
			<div class="content">
				<div class="row">
					<div class="col-md-12">
						<!--<div class="alert alert-danger alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
							<strong>Perhatian !</strong><br>
							<?php
								/*$call2 = "{call SP_GET_DETAIL_ERROR_UNLOCK_DUKCAPIL(?)}";
								$param2 = array(array($id, SQLSRV_PARAM_IN));
								$options2 =  array( "Scrollable" => "buffered" );
								$exec2 = sqlsrv_query( $conn, $call2, $param2, $options2) or die( print_r( sqlsrv_errors(), true)); 
								$numrows2 = sqlsrv_num_rows($exec2);
								while($data2 = sqlsrv_fetch_array($exec2)){
									echo $data2['MSG_NAME']."<br>";
								}*/
							?>
						</div>-->
						<div class="row">
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
							<!--
							<div class="col-md-4">
								<table class="table table-bordered table-stiped" style="font-size:10px;">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DATA DUKCAPIL</td>
									</tr>
									
									<tr>
										<td style="width:50%;">NIK</td>
										<td style="width:50%;"><?php// echo $DkcplNIK;?></td>
									</tr>
									<tr>
									
										<td >Nama Lengkap</td>
										<td><?php //echo $DkcplNAMA_LGKP;?></td>
									</tr>
									<tr>
									
										<td>Tempat Lahir</td>
										<td><?php// echo $DkcplTMPT_LHR;?></td>
									</tr>
									<tr>
									
										<td>Tanggal Lahir</td>
										<td><?php// echo $DkcplTGL_LHR;?></td>
									</tr>
									<tr>
										<td>Jenis Kelamin</td>
										<td><?php// echo $DkcplJENIS_KLMIN;?></td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td><?php //echo $DkcplALAMAT;?></td>
									</tr>
									<tr>
										<td>RT/RW</td>
										<td><?php //echo $DkcplNO_RT;?></td>
									</tr>
									<tr>
										<td>RW</td>
										<td><?php //echo $DkcplNO_RW;?></td>
									</tr>
									<tr>
										<td>Kelurahan/Desa</td>
										<td><?php// echo $DkcplKEL_NAME;?></td>
									</tr>
									<tr>
										<td>Kecamatan</td>
										<td><?php //echo $DkcplKEC_NAME;?></td>
									</tr>
									<tr>
										<td>Kabupaten</td>
										<td><?php// echo $DkcplKAB_NAME;?></td>
									</tr>
									<tr>
										<td>Provinsi</td>
										<td><?php// echo $DkcplPROP_NAME;?></td>
									</tr>
									<tr>
										<td>Status Kawin</td>
										<td><?php //echo $DkcplSTATUS_KAWIN;?></td>
									</tr>
									<tr>
									
									<td>Nama Ibu Kandung</td>
										<td><?php //echo $DkcplNAMA_LGKP_IBU;?></td>
									</tr>
									
									<tr>
										<td>Pekerjaan</td>
										<td><?php //echo $DkcplJENIS_PKRJN;?></td>
									</tr>
									
								</table>
							</div>-->
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
												$paramCheckDuk = array(array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN));
												$execCheckDuk = sqlsrv_query( $conn, $callCheckDuk, $paramCheckDuk) or die( print_r( sqlsrv_defaults(), true)); 
												$dataCheckDuk = sqlsrv_fetch_array($execCheckDuk);
									if($checkDukcapil > 0){
										if($checkGetError > 0 ){
												
													
											echo"
																<tr>
																	<td style='width:33%;'>Hasil Pengecekan</td>
																	<td style='width:33%;'>".strtoupper($dataCheckDuk['MSG_NAME'])."</td>
																	<td style='width:33%;'>Checked by ".$data['CREATE_USER']." (".$data['CREATE_DATE']->format("Y-m-d H:i:s")." )</td>
																</tr>";
											}
									else if($Warning_Data <> ""){
												echo"
																<tr>
																	<td style='width:33%;'>Hasil Pengecekan</td>
																	<td style='width:33%;'>".strtoupper($dataCheckDuk['MSG_NAME'])."</td>
																	<td style='width:33%;'>Checked by ".$data['CREATE_USER']." (".$data['CREATE_DATE']->format("Y-m-d H:i:s")." )</td>
																</tr>";
											} ELSE{
													echo"
															<tr>
																<td style='width:33%;'>Hasil Pengecekan</td>
																<td style='width:33%;'>".strtoupper($dataCheckDuk['MSG_NAME'])."</td>
																<td style='width:33%;'>Checked by ".$data['CREATE_USER']." (".$data['CREATE_DATE']->format("Y-m-d H:i:s")." )</td>
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
						<i class="text-danger"><b>*Data yang dicompare adalah Nama Lengkap, Tanggal Lahir, Nama Ibu Kandung, dan Status Kawin</b></i>
						<hr>
						<div class="row">
							<div class="col-md-4">
								<form action="" method="post">
									<input name='id' type='hidden' value='<?php echo $id;?>'>
									<input name='prospect_no' type='hidden' value='<?php echo $prospect;?>'>
									<input name='no_ktp' type='hidden' value='<?php echo $no_ktp;?>'>
									<input name='name' type='hidden' value="<?php echo $nama;?>">
									<input name='date' type='hidden' value='<?php echo $date;?>'>
									<input name='mother_name' type='hidden' value="<?php echo $mother_nm;?>">
									<input name='birth_place' type='hidden' value='<?php echo $birth_place;?>'>
									<input name='tipe_cust' type='hidden' value='<?php echo $siapanih;?>'>
									<input type="submit" class="btn btn-custom" name="hold" value="HOLD CEK DUKCAPIL" onclick="return confirm('Apakah anda yakin ingin me-hold data ini?');" style="width:100%;">
								</form>
							</div>
							<div class="col-md-4">
							<form  action="index.php?page=dukcapil-reject&USERNAME=<?php echo $user;?>" method="post" enctype="multipart/form-data" id="ff">
											<!--<li><a href="index.php?page=dukcapil-ho&USERNAME=<?php /*echo $user;?>&no=<?php echo $no;?>&nik=<?php echo $nik;*/?>">Cek Dukcapil</a></li>-->
										
												<input name='id' type='hidden' value='<?php echo $id;?>'>
											<input name='prospect_no' type='hidden' value='<?php echo $prospect;?>'>
											<input name='no_ktp' type='hidden' value='<?php echo $no_ktp;?>'>
											<input name='name' type='hidden' value="<?php echo $nama;?>">
											<input name='date' type='hidden' value='<?php echo $date;?>'>
											<input name='mother_name' type='hidden' value="<?php echo $mother_nm;?>">
											<input name='birth_place' type='hidden' value='<?php echo $birth_place;?>'>
											<input name='tipe_cust' type='hidden' value='<?php echo $siapanih;?>'>
												<button type="submit" class="btn btn-custom" style="width:100%;">REJECT</button>
										</form>
							
							</div>
							<div class="col-md-4">
							<?php 	if($checkRows > 0){?>
								<form  action="index.php?page=detail-informasi-dukcapil&USERNAME=<?php echo $user;?>" method="post" enctype="multipart/form-data" id="proses">
											<!--<li><a href="index.php?page=dukcapil-ho&USERNAME=<?php /*echo $user;?>&no=<?php echo $no;?>&nik=<?php echo $ ;*/?>">Cek Dukcapil</a></li>-->
											<input name='id' type='hidden' value='<?php echo $id;?>'>
											<input name='prospect_no' type='hidden' value='<?php echo $prospect;?>'>
											<input name='no_ktp' type='hidden' value='<?php echo $no_ktp;?>'>
											<input name='name' type='hidden' value="<?php echo $nama;?>">
											<input name='date' type='hidden' value='<?php echo $date;?>'>
											<input name='mother_name' type='hidden' value="<?php echo $mother_nm;?>">
											<input name='birth_place' type='hidden' value='<?php echo $birth_place;?>'>
											<input name='tipe_cust' type='hidden' value='<?php echo $siapanih;?>'>
											
											<button type="submit" class="btn btn-custom" style="width:100%;" onclick="return confirm('Apakah anda yakin bahwa tidak ada perbedaan data ?');">PROSES</button>
								</form>
							<?php }else{?>
								<form  action="index.php?page=detail-informasi-dukcapil&USERNAME=<?php echo $user;?>" method="post" enctype="multipart/form-data" id="proses">
											<!--<li><a href="index.php?page=dukcapil-ho&USERNAME=<?php /*echo $user;?>&no=<?php echo $no;?>&nik=<?php echo $nik;*/?>">Cek Dukcapil</a></li>-->
										    <input name='id' type='hidden' value='<?php echo $id;?>'>
											<input name='prospect_no' type='hidden' value='<?php echo $prospect;?>'>
											<input name='no_ktp' type='hidden' value='<?php echo $no_ktp;?>'>
											<input name='name' type='hidden' value="<?php echo $nama;?>">
											<input name='date' type='hidden' value='<?php echo $date;?>'>
											<input name='mother_name' type='hidden' value="<?php echo $mother_nm;?>">
											<input name='birth_place' type='hidden' value='<?php echo $birth_place;?>'>
											<input name='tipe_cust' type='hidden' value='<?php echo $siapanih;?>'>
											
											<button type="submit" class="btn btn-custom" style="width:100%;" onclick="return confirm('Apakah anda yakin bahwa tidak ada perbedaan data ?');" >PROSES</button>
								</form>
							<?php }?>
								
							</div>
						</div>
						<br><br>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>