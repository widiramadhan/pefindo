<?php
require_once("config/configuration.php");
$Warning_Data = "";
$WarningNama = "";
$WarningTTL = "";
$WarningIbu = "";


if(isset($_POST['check'])){
	$prospect=$_POST['prospect_no'];
	$no_ktp=$_POST['no_ktp'];
	$nama=$_POST['name'];
	$date = date("Y-m-d", strtotime($_POST['date']));
	
	$dateCapil = date("d-m-Y", strtotime($_POST['date']));
	//$date=$_POST['date'];
	$mother_nm=$_POST['mother_name'];
	$status_kawin1=$_POST['status_kawin'];
	$birth_place=$_POST['birth_place'];
	$siapanih=$_POST['tipe_cust'];
	$getUsername=$_GET['USERNAME'];
	//echo $mother_nm;
	
	$call3 = "{call SP_GETDATA_INFO_CUSTOMER_NEWVERSE_2(?,?)}";
	$param3 = array(array($no_ktp, SQLSRV_PARAM_IN),
					array($prospect, SQLSRV_PARAM_IN));
	$options3 =  array( "Scrollable" => "buffered" );
	$exec3 = sqlsrv_query( $conn, $call3, $param3, $options3) or die( print_r( sqlsrv_errors(), true));
	$data3 = sqlsrv_fetch_array($exec3);
	
	
	$callStatVerf = "{call SP_GET_STATUS_VERIFIKASI(?,?)}";
	$paramsStatVerf = array(
					array($prospect, SQLSRV_PARAM_IN),
					array($no_ktp, SQLSRV_PARAM_IN)
				);
	$optionsStatVerf =  array( "Scrollable" => "buffered" );
	$execStatVerf = sqlsrv_query($conn, $callStatVerf, $paramsStatVerf, $optionsStatVerf) or die( print_r( sqlsrv_errors(), true)); 
	$dataStatVerf = sqlsrv_fetch_array($execStatVerf);
	$checkStatVerf=sqlsrv_num_rows($execStatVerf);
	
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
		
$NIK= $no_ktp;
$NAMA_LGKP= $nama;
$ALAMAT=$data3['ALAMAT'];


IF($checkStatVerf > 0){
		IF($dataStatVerf['PERUBAHAN_STATUS_KAWIN'] == ''){
			/*IF($data3['STATUS_KAWIN'] == "SUDAH KAWIN"){
				$STATUS_KAWIN= "KAWIN";
			}Else IF($data3['STATUS_KAWIN'] == "BELUM KAWIN"){
				$STATUS_KAWIN= "BELUM KAWIN";
			}Else{
				$STATUS_KAWIN=$data3['STATUS_KAWIN'];
			}
			*/
			$STATUS_KAWIN=$status_kawin1;
			$NAMA_LGKP_IBU= $dataStatVerf['PERUBAHAN_NAMA_IBU'];
		}else if ($dataStatVerf['PERUBAHAN_NAMA_IBU'] == ''){
			$STATUS_KAWIN= $dataStatVerf['PERUBAHAN_STATUS_KAWIN'];
			$NAMA_LGKP_IBU= $mother_nm;	
		}else{
				$STATUS_KAWIN= $dataStatVerf['PERUBAHAN_STATUS_KAWIN'];
			$NAMA_LGKP_IBU= $dataStatVerf['PERUBAHAN_NAMA_IBU'];
		}

}else{

/*
IF($data3['STATUS_KAWIN'] == "SUDAH KAWIN"){
	$STATUS_KAWIN= "KAWIN";
}Else IF($data3['STATUS_KAWIN'] == "BELUM KAWIN"){
	$STATUS_KAWIN= "BELUM KAWIN";
}Else{
	$STATUS_KAWIN=$data3['STATUS_KAWIN'];
}
*/
$STATUS_KAWIN=$status_kawin1;
$NAMA_LGKP_IBU=$mother_nm;
	
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
$JK = $data3['JENIS_KELAMIN'];
IF($JK == "LAKI-LAKI"){
$JENIS_KLMIN= "Laki-Laki";
}Else IF($JK == "PEREMPUAN"){
$JENIS_KLMIN= "Perempuan";
}else{
	$JENIS_KLMIN= $data3['JENIS_KELAMIN']; 
}
//$JENIS_KLMIN= $data3['JENIS_KELAMIN'];
$JENIS_PKRJN= $data3['PEKERJAAN'];
$TRESHOLD= "90";
//$USER_ID= "10643174202101271dummy_suzuki_finance";
$USER_ID= "25082022141010SUZUKI_FINANCE4288";
//$PASSWORD= "123456";
$PASSWORD= "MZ33CU";
$IP_USER= "172.16.2.5";


$callDup = "{call SP_CHECK_DUKCAPIL_DUP(?,?)}";
		$paramsDup = array(
						array($no_ktp, SQLSRV_PARAM_IN),
						array($prospect, SQLSRV_PARAM_IN),
					);
		$options =  array( "Scrollable" => "buffered" );
		$execDup = sqlsrv_query($conn, $callDup, $paramsDup, $options) or die( print_r( sqlsrv_errors(), true));
		$dataDup = sqlsrv_fetch_array($execDup);
		
		if($dataDup['STAT_DUKCAPIL'] == 'DUP'){

				$tgl_lahir_old = $dataDup['TGL_LAHIR']->format('Y-m-d');
				
				
				
			if ($date == $tgl_lahir_old){
				
			$callInsDup = "{call SP_CHECK_INSERT_DUKCAPIL_DUP(?,?,?,?)}";
			$paramsInsDup= array(
							array($prospect, SQLSRV_PARAM_IN),
							array($no_ktp, SQLSRV_PARAM_IN),
							array($getUsername, SQLSRV_PARAM_IN),
							array($siapanih, SQLSRV_PARAM_IN),
						);
			$options =  array( "Scrollable" => "buffered" );
			$execInsDup = sqlsrv_query($conn, $callInsDup, $paramsInsDup, $options) or die( print_r( sqlsrv_errors(), true));
			}else{
				
				require_once("script-dukcapil-individu.php");
			}
		
		
			
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
			
			echo "<script>alert('Warning : (Silahkan lakukan pengecekan ulang.!)');history.back();</script>";
			exit();
			/*
			$callSPLogDkUpilNtValid = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
			$paramsLogDkUpilNtValid = array(array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN), array($SourceLogDkUpilNtValid, SQLSRV_PARAM_IN),array($StatusLogDkUpilNtValid, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
			$execLogDkUpilNtValid = sqlsrv_query( $conn, $callSPLogDkUpilNtValid, $paramsLogDkUpilNtValid) or die( print_r( sqlsrv_errors(), true));
			if($execLogDkUpilNtValid === false){
				echo"<script>alert('Error insert log Dukcapil Not Valid');</script>";
			}*/
			//----# Insert LOG End

			//echo "<script>alert('Error : ".$StatusLogDkUpilNtValid." (Pada saat pengecekan No KTP di Dukcapil.!)')</script>";
			//$Warning_Data = $Warning_Data." - KTP TIDAK VALID (Pada saat pengecekan No KTP di Dukcapil.!) ";
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
					
					$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
					$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('5', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
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
					$callStatNikah = "{call SP_GET_VERIFIKASI_VERIFIED(?,?)}";
						$paramsStatNikah = array(
										array($prospect, SQLSRV_PARAM_IN),
										array($no_ktp, SQLSRV_PARAM_IN)
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
									
						if($checkStatNikah > 0){ 
								$StatusLogDkcpl3 = "VALID";
						}else{
						if($DkcplSTATUS_KAWIN == "Tidak Sesuai"){
								$StatusLogDkcpl3 = "DATA DITEMUKAN TIDAK SESUAI";
							
						}else{
							$StatusLogDkcpl3 = "VALID";
						}
							
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
						
							
						
							
							if($checkStatNikah == 0){
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
							}
									
						if($checkStatNikah == 0){ 		
						if($DkcplSTATUS_KAWIN == "Tidak Sesuai"){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$status_kawin1."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
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
	}


}else if(isset($_POST['slik'])){
	$prospect=$_POST['prospect_no'];
	$no_ktp=$_POST['no_ktp'];
	$nama=$_POST['name'];
	$date=$_POST['date'];
	$mother_nm=$_POST['mother_name'];
	$status_kawin1=$_POST['status_kawin'];
	$birth_place=$_POST['birth_place'];
	$siapanih=$_POST['tipe_cust'];
	$getUsername=$_GET['USERNAME'];
	
	$callCheck = "{call SP_CHECK_SLIK_CHECKED(?)}";
	$paramCheck = array(array($no_ktp, SQLSRV_PARAM_IN));
	$optionCheck = array( "Scrollable" => "buffered" );
	$execCheck = sqlsrv_query($conn, $callCheck, $paramCheck,$optionCheck) or die( print_r( sqlsrv_errors(), true));
	$dataCheck =  sqlsrv_fetch_array($execCheck);
	$rowsCheck =sqlsrv_num_rows($execCheck);
	
	$callCheck1 = "{call SP_CHECK_SLIK_CHECKED_PROSPECT(?,?)}";
	$paramCheck1 = array(array($no_ktp, SQLSRV_PARAM_IN),
						 array($prospect, SQLSRV_PARAM_IN));
	$optionCheck1 = array( "Scrollable" => "buffered" );
	$execCheck1 = sqlsrv_query($conn, $callCheck1, $paramCheck1,$optionCheck1) or die( print_r( sqlsrv_errors(), true));
	$dataCheck1 =  sqlsrv_fetch_array($execCheck1);
	$rowsCheck1 =sqlsrv_num_rows($execCheck1);
	
	
	
	
	$call3 = "{call SP_CHECK_DUKCAPIL_MAPPING_HOLD(?,?)}";
	$param3 = array(array($prospect, SQLSRV_PARAM_IN),
					array($no_ktp, SQLSRV_PARAM_IN));
	$options =  array( "Scrollable" => "buffered" );
	$exec3 = sqlsrv_query( $conn, $call3, $param3,$options) or die( print_r( sqlsrv_defaults(), true)); 
	$data3= sqlsrv_fetch_array($exec3);
	$checkData=sqlsrv_num_rows($exec3);
	/*if($rowsCheck1 > 0){
															
			echo"<script>alert('Customer ini pernah melakukan pengecekan SLIK pada tanggal ".$dataCheck1['CREATE_DATE']->format("d F Y")." ');window.location='index.php?USERNAME=".$user."&page=slik-detail&no=".$prospect."&custtype=".$siapanih."&id=".$dataCheck1['PEFINDO_MAPPING_ID']."'</script>";	
	
		
		
	}else if($checkData > 0){
		echo"<script>alert('Customer ini pernah melakukan pengecekan SLIK pada tanggal ;window.location='index.php?USERNAME=".$user."&page=slik-detail&no=".$prospect."&custtype=".$siapanih."&id=".$dataCheck1['PEFINDO_MAPPING_ID']."'</script>";	
		
	}else{*/
		$call6 = "{call SP_INSERT_DUKCAPIL_HOLD_1(?,?,?,?,?,?,?,?)}";
		$param6 = array(array($prospect, SQLSRV_PARAM_IN),
						array($no_ktp, SQLSRV_PARAM_IN),
						array($nama, SQLSRV_PARAM_IN),
						array($date, SQLSRV_PARAM_IN),
						array($siapanih, SQLSRV_PARAM_IN),
						array('KTP', SQLSRV_PARAM_IN),
						array($getUsername, SQLSRV_PARAM_IN),
						array('8', SQLSRV_PARAM_IN));
		$exec6 = sqlsrv_query( $conn, $call6, $param6) or die( print_r( sqlsrv_defaults(), true)); 
		$data6= sqlsrv_fetch_array($exec6);
		
		
		 if($_GET['USERNAME'] == 'iman.santoso' || $_GET['USERNAME'] == 'djoko.andrew' || $_GET['USERNAME'] == 'ramandona' || $_GET['USERNAME'] == 'IMAN.SANTOSO' || $_GET['USERNAME'] == 'DJOKO.ANDREW' || $_GET['USERNAME'] == 'RAMANDONA' || $_GET['USERNAME'] == 'NOVRIKAWATI' || $_GET['USERNAME'] == 'KIKI.AMALIA' || $_GET['USERNAME'] == 'novrikawati' || $_GET['USERNAME'] == 'kiki.amalia' || $_GET['USERNAME'] == 'AHMAD.HABIBI' ||$_GET['USERNAME'] == 'DENY.SAPUTRA' || $_GET['USERNAME'] == 'Haris.Siswanto' || $_GET['USERNAME'] == 'HARIS.SISWANTO' || $_GET['USERNAME'] == 'Yose.Kertapati' || $_GET['USERNAME'] == 'YOSE.KERTAPATI'	|| $_GET['USERNAME'] == 'Muhammad' || $_GET['USERNAME'] == 'MUHAMMAD' || $_GET['USERNAME'] == 'Ramandona.Dinara' || $_GET['USERNAME'] == 'RAMANDONA.DINARA' || $_GET['USERNAME'] == 'Jimmy.Sujana' || $_GET['USERNAME'] == 'JIMMY.SUJANA' || $_GET['USERNAME'] == 'Ricky.Randhita' || $_GET['USERNAME'] == 'RICKY.RANDHITA' || $_GET['USERNAME'] == 'Herberth.Simbolon' || $_GET['USERNAME'] == 'HERBERTH.SIMBOLON' || $_GET['USERNAME'] == 'Moh.Junaidi.Siyam' || $_GET['USERNAME'] == 'MOH.JUNAIDI.SIYAM' ){	  	  
						echo"<script>alert('Data Berhasil Terkirim ke tasklist');window.location='index.php?page=individual-ho-new&USERNAME=".$getUsername."'</script>";
					 }else {
						echo"<script>alert('Data Berhasil Terkirim ke tasklist');window.location='index.php?page=individual&USERNAME=".$getUsername."'</script>"; 
					 }
	//}
	

	
	
	
	
}else{
	$prospect=$_POST['prospect_no'];
	$no_ktp=$_POST['no_ktp'];
	$nama=$_POST['name'];
	$date = date("Y-m-d", strtotime($_POST['date']));
	//$date=$_POST['date'];
	$mother_nm=$_POST['mother_name'];
	$status_kawin1=$_POST['status_kawin'];
	$birth_place=$_POST['birth_place'];
	$siapanih=$_POST['tipe_cust'];
	$getUsername=$_GET['USERNAME'];
}
	$callGetError = "{call SP_GET_VALIDASI_DUKCAPIL(?,?)}";
					$options =  array( "Scrollable" => "buffered" );
					$paramsGetError = array(array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN));
					$execGetError = sqlsrv_query($conn, $callGetError, $paramsGetError,$options) or die(print_r(sqlsrv_errors(), true));	
					$dataGetError = sqlsrv_fetch_array($execGetError);
					$checkGetError=sqlsrv_num_rows($execGetError);

$call3 = "{call SP_GETDATA_INFO_CUSTOMER_NEWVERSE_2(?,?)}";
$param3 = array(array($no_ktp, SQLSRV_PARAM_IN),
				array($prospect, SQLSRV_PARAM_IN));
$options3 =  array( "Scrollable" => "buffered" );
$exec3 = sqlsrv_query( $conn, $call3, $param3, $options3) or die( print_r( sqlsrv_errors(), true));
$data3 = sqlsrv_fetch_array($exec3);

$callGetOrder = "{call SP_GET_ORDER_FROM_PROSPECT(?)}";
$paramGetOrder = array(array($prospect, SQLSRV_PARAM_IN));
$optionGetOrder = array( "Scrollable" => "buffered" );
$execGetOrder = sqlsrv_query($conn, $callGetOrder, $paramGetOrder,$optionGetOrder) or die( print_r( sqlsrv_errors(), true));
$dataGetOrder =  sqlsrv_fetch_array($execGetOrder);


$callChecked = "{call SP_GET_CHECKED_PEFINDO_SLIK(?,?)}";
$paramChecked = array(array($dataGetOrder['ORDER_NO'], SQLSRV_PARAM_IN),
						array($no_ktp, SQLSRV_PARAM_IN));
$optionChecked = array( "Scrollable" => "buffered" );
$execChecked = sqlsrv_query($conn, $callChecked, $paramChecked,$optionChecked) or die( print_r( sqlsrv_errors(), true));
$dataChecked =  sqlsrv_fetch_array($execChecked);
$dataCheckedLog=sqlsrv_num_rows($execChecked);

$callCheckedProspect = "{call SP_GET_CHECKED_PEFINDO_SLIK(?,?)}";
$paramCheckedProspect = array(array($prospect, SQLSRV_PARAM_IN),
						array($no_ktp, SQLSRV_PARAM_IN));
$optionCheckedProspect = array( "Scrollable" => "buffered" );
$execCheckedProspect = sqlsrv_query($conn, $callCheckedProspect, $paramCheckedProspect,$optionCheckedProspect) or die( print_r( sqlsrv_errors(), true));
$dataCheckedProspect =  sqlsrv_fetch_array($execCheckedProspect);
$dataCheckedLogProspect=sqlsrv_num_rows($execCheckedProspect);

	
	$callDate = "{call SP_GET_DATE_SLIK}";
	$execDate = sqlsrv_query( $conn, $callDate) or die( print_r( sqlsrv_errors(), true));
	$dataDate = sqlsrv_fetch_array($execDate);
	
		
	$callStatSlik = "{call SP_GET_STATUS_SLIK}";
	$execStatSlik = sqlsrv_query( $conn, $callStatSlik) or die( print_r( sqlsrv_errors(), true));
	$dataStatSlik = sqlsrv_fetch_array($execStatSlik);
		
		

?>
<style>
.th-custom{
	text-align:center;
	vertical-align:middle;
	font-weight:bold;
}
.td-custom{
	text-align:center;
	vertical-align:middle;
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
?>
<div class="row">
	<?php 
		if($checkGetError > 0 ){
			
			$Warning_Data = 'Silahkan lakukan pengkinian data ke dukcapil setempat';
		}
		if($checkLogError > 0){
			echo'<div class="col-md-12">
					<div class="alert alert-danger alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
						<strong>Perhatian !</strong> Silahkan lakukan pengkinian data ke dukcapil setempat
					</div>
				</div>';
		}else{
			if($Warning_Data <> ""){
				echo'<div class="col-md-12">
						<div class="alert alert-danger alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
							<strong>Perhatian !</strong> '.$Warning_Data.'
						</div>
					</div>';
			}
		}
	?>
	<?php if($dataDate['VOID'] == '1'){ ?> 
					<div class="alert alert-danger alert-dismissible">
										<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
										<strong>PERHATIAN  <br>
											UNTUK PENGECEKAN SLIK DIMULAI PUKUL 09:00 - 17:00 WIB<br>
									
										
							</div>
				<?php } ?>
	<div class="col-md-12">
		<?php 	if($dataCheckedLog > 0){ ?>
					<div class="alert alert-danger alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
							<strong>Perhatian !</strong><br>
							<strong>Nomor Order <?php echo $dataGetOrder['ORDER_NO']; ?> Sudah Pernah Melakukan Pengecekan Pefindo / Slik</strong><br>
							
						</div>
					<?php } ?>
						<?php 	if($dataCheckedLogProspect > 0){ ?>
					<div class="alert alert-danger alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
							<strong>Perhatian !</strong><br>
							<strong>Nomor Prospect <?php echo $prospect; ?> dan NIK : <?php echo $no_ktp;?> Sudah Pernah Melakukan Pengecekan Pefindo / Slik</strong><br>
						<?php } ?>	
						</div>
		<div class="card">
			<div class="header">
				<h4 class="title">Disdukcapil</h4>
				<p class="category">Pengecekan Disdukcapil</p>
				
			</div>
			<hr>
			<div class="content">
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
						<div style="float:right;">
							<?php
							IF($dataStatSlik['STATUS_SLIK_GENERAL'] == 'OFF1'){
								if($checkDukcapil > 0){
									if($checkGetError > 0 ){
										echo'<input type="button" class="btn btn-custom btn-xs" value="Check Slik" disabled>';
									}else{ ?>
									<form action="index.php?page=check-pefindo&USERNAME=<?php echo $user;?>" method="post">
									<input name='prospect_no' type='hidden' value='<?php echo $prospect;?>'>
									<input name='no_ktp' type='hidden' value='<?php echo $no_ktp;?>'>
									<input name='name' type='hidden' value="<?php echo $nama;?>">
									<input name='date' type='hidden' value='<?php echo $date;?>'>
									<input name='mother_name' type='hidden' value="<?php echo $mother_nm;?>">
									<input name='birth_place' type='hidden' value='<?php echo $birth_place;?>'>
									<input name='tipe_cust' type='hidden' value='<?php echo $siapanih;?>'>
									<input type="submit" class="btn btn-custom btn-xs" value="Lanjutkan">
								</form>
								<?php }  ?>
										
				<?php
				}else if($dataCheckedLog > 0){
											echo'<input type="button" class="btn btn-custom btn-xs" value="Check Slik" disabled>';
											
										}else if($dataCheckedLogProspect > 0){
											echo'<input type="button" class="btn btn-custom btn-xs" value="Check Slik" disabled>';
											
										}else{ 
											echo'<input type="button" class="btn btn-custom btn-xs" value="Check Slik" disabled>';
										} 
										
							}else{
									/*if($checkLogError > 0){
										echo'<input type="button" class="btn btn-custom btn-xs" value="Lanjutkan" disabled>';
									}else{
										if($WarningTTL == "" && $WarningIbu == ""){
											*/
							?>
						<?php			
					
							if($dataDate['VOID'] == '1'){ 
								echo'<input type="button" class="btn btn-custom btn-xs" value="Check Slik" disabled>';
							} else if($checkDukcapil > 0){
									if($checkGetError > 0 ){
										echo'<input type="button" class="btn btn-custom btn-xs" value="Check Slik" disabled>';
									}else if($dataCheckedLog > 0){
											echo'<input type="button" class="btn btn-custom btn-xs" value="Check Slik" disabled>';
											
										}else if($dataCheckedLogProspect > 0){
											echo'<input type="button" class="btn btn-custom btn-xs" value="Check Slik" disabled>';
											
										}else{ ?>
									<form action="" method="post">
									<input name='prospect_no' type='hidden' value='<?php echo $prospect;?>'>
									<input name='no_ktp' type='hidden' value='<?php echo $no_ktp;?>'>
									<input name='name' type='hidden' value="<?php echo $nama;?>">
									<input name='date' type='hidden' value='<?php echo $date;?>'>
									<input name='mother_name' type='hidden' value="<?php echo $mother_nm;?>">
									<input name="status_kawin" type="hidden" value="<?php echo $status_kawin1;?>">
									<input name='birth_place' type='hidden' value='<?php echo $birth_place;?>'>
									<input name='tipe_cust' type='hidden' value='<?php echo $siapanih;?>'>
									<input type="submit" class="btn btn-custom btn-xs" value="Request Slik" name="slik" onclick="return confirm('Apakah anda yakin ingin merequest data ini?')">
								</form>
									<?php }  ?>
								
				<?php
									/*if($checkLogError > 0){
										echo'<input type="button" class="btn btn-custom btn-xs" value="Lanjutkan" disabled>';
									}else{
										if($WarningTTL == "" && $WarningIbu == ""){
											*/
							?>
									
							<?php 
										}else if($dataCheckedLog > 0){
											echo'<input type="button" class="btn btn-custom btn-xs" value="Check Slik" disabled>';
											
										}else if($dataCheckedLogProspect > 0){
											echo'<input type="button" class="btn btn-custom btn-xs" value="Check Slik" disabled>';
											
										}else{ 
											echo'<input type="button" class="btn btn-custom btn-xs" value="Check Slik" disabled>';
										}
									}
									/*}
								}else{
									echo'<input type="button" class="btn btn-custom btn-xs" value="Lanjutkan" disabled>';
								} */
							?>
						</div>
						
						<div style="float:right;margin-right:10px;">
							<form action="" method="post">
								<input name='prospect_no' type='hidden' value='<?php echo $prospect;?>'>
								<input name='no_ktp' type='hidden' value='<?php echo $no_ktp;?>'>
								<input name='name' type='hidden' value="<?php echo $nama;?>">
								<input name='date' type='hidden' value='<?php echo $date;?>'>
								<input name='mother_name' type='hidden' value="<?php echo $mother_nm;?>">
								<input name="status_kawin" type="hidden" value="<?php echo $status_kawin1;?>">
								<input name='birth_place' type='hidden' value='<?php echo $birth_place;?>'>
								<input name='tipe_cust' type='hidden' value='<?php echo $siapanih;?>'>
								<input type="submit" class="btn btn-custom btn-xs" value="Check Dukcapil" name="check" onclick="return confirm('Apakah anda yakin ingin mengecek data ini? Pengecekan akan dikenakan biaya dan tercatat di log')">
							</form>
						</div>
					</div>
				</div>
				<br>
			</div>
		</div>
	</div>
</div>