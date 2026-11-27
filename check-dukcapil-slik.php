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
	//$date=$_POST['date'];
	$mother_nm=$_POST['mother_name'];
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
		$param_dukcapil_array= array('nik' => $no_ktp, 'user_id' => "singlesuzukifinance", 'password' => "s3Jsm8K9", 'IP_USER' => $getUsername);
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
				if(isset($resultDukcapil['content'][0]['RESPON'])) {
					//----# Insert LOG
					$SourceLogDkUpilnotfound = "DUKCAPIL";
					$StatusLogDkUpilnotfound = strtoupper($resultDukcapil['content'][0]['RESPON']);

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
					foreach($resultDukcapil['content'] as $contentdata){
							$DkcplCustType = $siapanih;
							$DkcplNIK = number_format($contentdata['NIK'], 0, '', '');
							$DkcplNAMA_LGKP = $contentdata['NAMA_LGKP'];
							$DkcplJENIS_KLMIN = $contentdata['JENIS_KLMIN'];
							$DkcplTMPT_LHR = $contentdata['TMPT_LHR'];
							$DkcplTGL_LHR = $contentdata['TGL_LHR'];
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
							
							$namaTanpaTitikP = str_replace("."," ",$nama);
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
							
							if($DkcplTGL_LHR != $date){
								$StatusLogDkcpl2 = "DATA DITEMUKAN TIDAK SESUAI";
							
							}else{
							$StatusLogDkcpl2 = "VALID";
							}
							
							
							if(strtoupper($siapanih) == "PEMOHON") {
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
														
								if($namaIbuTanpaSpasiD <> ""){
									if($namaIbuTanpaSpasiD != $namaIbuTanpaSpasiP){
										$StatusLogDkcpl4 = "DATA DITEMUKAN TIDAK SESUAI";
									
									}else{
									$StatusLogDkcpl4 = "VALID";
									}
									
								}else{
									$StatusLogDkcpl4 = "VALID";
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
							
							}else if ($DkcplSTATUS_KAWIN == "CERAI MATI" && $data3['STATUS_KAWIN'] == "SUDAH KAWIN"){
							$StatusLogDkcpl3 = "DATA DITEMUKAN TIDAK SESUAI";
							
							}else if ($DkcplSTATUS_KAWIN == "CERAI MATI" && $data3['STATUS_KAWIN'] == ""){
							$StatusLogDkcpl3 = "DATA DITEMUKAN TIDAK SESUAI";
							
						
							}else if ($DkcplSTATUS_KAWIN == "CERAI HIDUP" && $data3['STATUS_KAWIN'] == "SUDAH KAWIN"){
							$StatusLogDkcpl3 = "DATA DITEMUKAN TIDAK SESUAI";
							

							}else if ($DkcplSTATUS_KAWIN == "CERAI HIDUP" && $data3['STATUS_KAWIN'] == ""){
							$StatusLogDkcpl3 = "DATA DITEMUKAN TIDAK SESUAI";
						
						
							}else if ($DkcplSTATUS_KAWIN == "CERAI MATI" && $data3['STATUS_KAWIN'] == "CERAI"){
							$StatusLogDkcpl3 = "VALID";
							}else if ($DkcplSTATUS_KAWIN == "CERAI HIDUP" && $data3['STATUS_KAWIN'] == "CERAI"){
							$StatusLogDkcpl3 = "VALID";
							
						
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
						
						$namaTanpaTitikP = str_replace("."," ",$nama);
						$namaTanpaKomaP = str_replace(","," ",$namaTanpaTitikP);
						$namaTanpaPetikP = str_replace("'"," ",$namaTanpaKomaP);
						$namaTanpaStripP =  str_replace("-"," ",$namaTanpaPetikP);
						$namaTanpaSpasiDoubleP = str_replace("  "," ",$namaTanpaStripP);
						$namaTanpaSpasiP = strtoupper(trim(preg_replace('/[\t|\s{2,}]/', '', $namaTanpaSpasiDoubleP)));
						//echo $namaTanpaSpasiP;
						//echo strlen($namaTanpaSpasiP);
						
						if($namaTanpaSpasiD != $namaTanpaSpasiP){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningNama = "Perbedaan Nama Lengkap :<br>Data CONFINS : <b>".$nama."</b><br>Data Dukcapil : <b>".$DkcplNAMA_LGKP."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('1', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
						}
						if($DkcplTGL_LHR != $date){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningTTL = "Perbedaan Tanggal lahir :<br>Data CONFINS : <b>".$date."</b><br>Data Dukcapil : <b>".$DkcplTGL_LHR."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('2', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
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
									$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
									$WarningIbu = "Perbedaan Nama Ibu Kandung :<br>Data CONFINS : <b>".$mother_nm."</b><br>Data Dukcapil : <b>".$DkcplNAMA_LGKP_IBU."</b><br>";
									
									$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
									$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('3', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
									$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
								}
							}
							if($DkcplSTATUS_KAWIN == "KAWIN" && $data3['STATUS_KAWIN'] == "BELUM KAWIN"){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$data3['STATUS_KAWIN']."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));		
							}
							
							else if ($DkcplSTATUS_KAWIN == "KAWIN" && $data3['STATUS_KAWIN'] == ""){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$data3['STATUS_KAWIN']."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));		
							
						
							}else if($DkcplSTATUS_KAWIN == "BELUM KAWIN" && $data3['STATUS_KAWIN'] == "SUDAH KAWIN"){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$data3['STATUS_KAWIN']."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));			
							}
							else if($DkcplSTATUS_KAWIN == "BELUM KAWIN" && $data3['STATUS_KAWIN'] == ""){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$data3['STATUS_KAWIN']."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));			
						
							
							}else if ($DkcplSTATUS_KAWIN == "CERAI MATI" && $data3['STATUS_KAWIN'] == "BELUM KAWIN"){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$data3['STATUS_KAWIN']."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));		
							
							
							}else if ($DkcplSTATUS_KAWIN == "CERAI MATI" && $data3['STATUS_KAWIN'] == "SUDAH KAWIN"){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$data3['STATUS_KAWIN']."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));	

							}else if ($DkcplSTATUS_KAWIN == "CERAI MATI" && $data3['STATUS_KAWIN'] == ""){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$data3['STATUS_KAWIN']."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));		
							
							}else if ($DkcplSTATUS_KAWIN == "CERAI HIDUP" && $data3['STATUS_KAWIN'] == "BELUM KAWIN"){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$data3['STATUS_KAWIN']."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));		
							
						
							}else if ($DkcplSTATUS_KAWIN == "CERAI HIDUP" && $data3['STATUS_KAWIN'] == "SUDAH KAWIN"){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$data3['STATUS_KAWIN']."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));	

							}else if ($DkcplSTATUS_KAWIN == "CERAI HIDUP" && $data3['STATUS_KAWIN'] == ""){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$data3['STATUS_KAWIN']."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL_1(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));		
							
							}else if ($DkcplSTATUS_KAWIN == "CERAI MATI" && $data3['STATUS_KAWIN'] == "CERAI"){
							
							}else if ($DkcplSTATUS_KAWIN == "CERAI HIDUP" && $data3['STATUS_KAWIN'] == "CERAI"){
							
							
						
							}else{
								
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
}else if(isset($_POST['slik'])){
	$prospect=$_POST['prospect_no'];
	$no_ktp=$_POST['no_ktp'];
	$nama=$_POST['name'];
	$date=$_POST['date'];
	$mother_nm=$_POST['mother_name'];
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
								if($checkDukcapil > 0){
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
									<input name='birth_place' type='hidden' value='<?php echo $birth_place;?>'>
									<input name='tipe_cust' type='hidden' value='<?php echo $siapanih;?>'>
									<input type="submit" class="btn btn-custom btn-xs" value="Request Slik" name="slik" onclick="return confirm('Apakah anda yakin ingin merequest data ini?')">
								</form>
									<?php } ?>
										
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