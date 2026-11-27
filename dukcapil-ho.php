<?php
require_once("config/configuration.php");
require_once("config/connection.php");
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
ini_set('sqlsrv.ClientBufferMaxKBSize','524288'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size','524288'); 
$date=date("Y-m-d");

$Warning_Data = "";
$WarningNama = "";
$WarningTTL = "";
$WarningIbu = "";

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
$param3 = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN));
$options3 =  array( "Scrollable" => "buffered" );
$exec3 = sqlsrv_query( $conn, $call3, $param3, $options3) or die( print_r( sqlsrv_errors(), true));
$data3 = sqlsrv_fetch_array($exec3);*/
/*
$call3 = "{call SP_GETDATA_INFO_CUSTOMER_NEWVERSE(?)}";
$param3 = array(array($no_ktp, SQLSRV_PARAM_IN));
$options3 =  array( "Scrollable" => "buffered" );
$exec3 = sqlsrv_query( $conn, $call3, $param3, $options3) or die( print_r( sqlsrv_errors(), true));
$data3 = sqlsrv_fetch_array($exec3);
*/
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

if($no_ktp==""){
		echo"<script>alert('Nomor KTP tidak boleh kosong, silahkan lakukan edit data di CONFINS');history.back();</script>";
	}else if($nama==""){
		echo"<script>alert('Nama tidak boleh kosong, silahkan lakukan edit data di CONFINS');history.back();</script>";
	}else if($date==""){
		echo"<script>alert('Tanggal lahir tidak boleh kosong, silahkan lakukan edit data di CONFINS');history.back();</script>";
	}else if(substr($no_ktp,0,1) == "0"){
		echo"<script>alert('Nomor KTP tidak boleh berawalan 0');history.back();</script>";
	}else if(substr($no_ktp,-4) == "0000"){
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
		echo"<script>alert('4 Digit Nomor KTP tidak boleh 0000');history.back();</script>";
	}else if(strlen(trim($no_ktp)) <> 16){
		echo"<script>alert('NIK harus 16 digit');history.back();</script>";
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
										'param' => '[{"NO_CIF":  "MANUAL"}]'),
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
			}
			//----# Insert LOG End

			//echo "<script>alert('Error : ".$StatusLogDkUpilNtValid." (Pada saat pengecekan No KTP di Dukcapil.!)')</script>";
			$Warning_Data = $Warning_Data." - KTP TIDAK VALID (Pada saat pengecekan No KTP di Dukcapil.!) ";
			*/
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
					
					$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL(?,?,?,?,?)}";
					$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('5', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
									
					
					if($execLogDkUpilnotfound === false){
						echo"<script>alert('NIK Tersebut Tidak ditemukan di Dukcapil.!');</script>";
					}
					//----# Insert LOG End
					
					echo "<script>alert('Error : ".$StatusLogDkUpilnotfound." (Pada saat pengecekan No KTP di Dukcapil!)')</script>";
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
					$SourceLogDkcpl = "DUKCAPIL";
					$StatusLogDkcpl = "VALID";

					$callSPLogDkcpl = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
					$paramsLogDkcpl = array(array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkcpl, SQLSRV_PARAM_IN),array($StatusLogDkcpl, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
					$execLogDkcpl = sqlsrv_query( $conn, $callSPLogDkcpl, $paramsLogDkcpl) or die( print_r( sqlsrv_errors(), true));
					//----# Insert LOG End
					
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
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('1', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
						}
						if($DkcplTGL_LHR != $date){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningTTL = "Perbedaan Tanggal lahir :<br>Data CONFINS : <b>".$date."</b><br>Data Dukcapil : <b>".$DkcplTGL_LHR."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL(?,?,?,?,?)}";
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
									
									$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL(?,?,?,?,?)}";
									$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('3', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
									$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
								}
							}
							if($DkcplSTATUS_KAWIN == "KAWIN" && $data3['STATUS_KAWIN'] == "BELUM KAWIN"){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$data3['STATUS_KAWIN']."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));		
							}
							
							else if ($DkcplSTATUS_KAWIN == "KAWIN" && $data3['STATUS_KAWIN'] == ""){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$data3['STATUS_KAWIN']."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));		
							
						
							}else if($DkcplSTATUS_KAWIN == "BELUM KAWIN" && $data3['STATUS_KAWIN'] == "SUDAH KAWIN"){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$data3['STATUS_KAWIN']."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));			
							}
							else if($DkcplSTATUS_KAWIN == "BELUM KAWIN" && $data3['STATUS_KAWIN'] == ""){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$data3['STATUS_KAWIN']."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));			
						
							
							}else if ($DkcplSTATUS_KAWIN == "CERAI MATI" && $data3['STATUS_KAWIN'] == "BELUM KAWIN"){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$data3['STATUS_KAWIN']."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));		
							
							
							}else if ($DkcplSTATUS_KAWIN == "CERAI MATI" && $data3['STATUS_KAWIN'] == "SUDAH KAWIN"){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$data3['STATUS_KAWIN']."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));	

							}else if ($DkcplSTATUS_KAWIN == "CERAI MATI" && $data3['STATUS_KAWIN'] == ""){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$data3['STATUS_KAWIN']."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));		
							
							}else if ($DkcplSTATUS_KAWIN == "CERAI HIDUP" && $data3['STATUS_KAWIN'] == "BELUM KAWIN"){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$data3['STATUS_KAWIN']."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));		
							
						
							}else if ($DkcplSTATUS_KAWIN == "CERAI HIDUP" && $data3['STATUS_KAWIN'] == "SUDAH KAWIN"){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$data3['STATUS_KAWIN']."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('4', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));	

							}else if ($DkcplSTATUS_KAWIN == "CERAI HIDUP" && $data3['STATUS_KAWIN'] == ""){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
							$WarningKawin = "Perbedaan Status kawin :<br>Data CONFINS : <b>".$data3['STATUS_KAWIN']."</b><br>Data Dukcapil : <b>".$DkcplSTATUS_KAWIN."</b><br>";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL(?,?,?,?,?)}";
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

?>
<div class="row">

	<?php 
		if($checkLogError > 0){?>
				
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
				</div>
				
				</div>
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
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DATA VBS / CONFINS</td>
									</tr>
									<tr>
										<td style="width:50%;">NIK</td>
										<td style="width:50%;"><?php echo $data3['ID_NO'];?></td>
									</tr>
									<tr>
										<td >Nama Lengkap</td>
										<td><?php echo $data3['CUST_NAME'];?></td>
									</tr>
									<tr>
										<td>TTL</td>
										<td><?php echo $data3['TTL'];?></td>
									</tr>
									<tr>
										<td>Jenis Kelamin</td>
										<td><?php echo $data3['JENIS_KELAMIN'];?></td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td><?php echo $data3['ALAMAT'];?></td>
									</tr>
									<tr>
										<td>RT/RW</td>
										<td><?php echo $data3['RT_RW'];?></td>
									</tr>
									<tr>
										<td>Kelurahan/Desa</td>
										<td><?php echo $data3['KELURAHAN'];?></td>
									</tr>
									<tr>
										<td>Kecamatan</td>
										<td><?php echo $data3['KECAMATAN'];?></td>
									</tr>
									<tr>
										<td>Kabupaten</td>
										<td><?php echo $data3['KABUPATEN'];?></td>
									</tr>
									<tr>
										<td>Provinsi</td>
										<td><?php echo $data3['PROVINSI'];?></td>
									</tr>
									<tr>
										<td>Status Kawin</td>
										<td><?php echo $data3['STATUS_KAWIN'];?></td>
									</tr>
									<tr>
										<td>Nama Ibu Kandung</td>
										<td><?php echo $data3['NAMA_IBU'];?></td>
									</tr>
									<tr>
										<td>Pekerjaan</td>
										<td><?php echo $data3['PEKERJAAN'];?></td>
									</tr>
								</table>
							</div>
							<div class="col-md-4">
								<table class="table table-bordered table-stiped" style="font-size:10px;">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DATA DUKCAPIL</td>
									</tr>
									<!--
									<tr>
										<td style="width:50%;">NIK</td>
										<td style="width:50%;"><?php// echo $DkcplNIK;?></td>
									</tr>
										-->
									<tr>
										<td >Nama Lengkap</td>
										<td><?php echo $DkcplNAMA_LGKP;?></td>
									</tr>
									<tr>
									<?php /*
										<td>TTL</td>
										<td><?php echo $DkcplTMPT_LHR.", ".$DkcplTGL_LHR;?></td>
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
										<td><?php echo $DkcplNO_RT."/".$DkcplNO_RW;?></td>
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
									*/?>
									<td>Nama Ibu Kandung</td>
										<td><?php echo $DkcplNAMA_LGKP_IBU;?></td>
									</tr>
									<!--
									<tr>
										<td>Pekerjaan</td>
										<td><?php //echo $DkcplJENIS_PKRJN;?></td>
									</tr>
									-->
								</table>
							</div>
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
									if($checkDukcapil > 0){ ?>
										
										<tr>
											<td style='width:33%;'>Hasil Pengecekan</td>
											<td style='width:33%;'><?php if($data['STATUS']=='VALID'){ ?>
											DITEMUKAN 
											<?php } ?>
										<?php} else { 
												TIDAK DITEMUKAN 
											} 	?></td>
											<td style='width:33%;'> Checked by  <?php echo $data['CREATE_USER'];?> . <?php echo $data['CREATE_DATE']->format("Y-m-d H:i:s");?></td>
										</tr>
									<?php }else{
										echo"
										<tr>
											<td style='width:33%;'>Hasil Pengecekan</td>
											<td style='width:33%;'>BELUM PERNAH DI CEK</td>
											<td style='width:33%;'>-</td>
										</tr>";
									}
									?>
									<?php
									/*
									if($checkDukcapil > 0){
										echo"
										<tr>
											<td style='width:33%;'>Hasil Pengecekan</td>
											<td style='width:33%;'>".$data['STATUS']."</td>
											<td style='width:33%;'>Checked by ".$data['CREATE_USER']." (".$data['CREATE_DATE']->format("Y-m-d H:i:s")." )</td>
										</tr>";
									}else{
										echo"
										<tr>
											<td style='width:33%;'>Hasil Pengecekan</td>
											<td style='width:33%;'>BELUM PERNAH DI CEK</td>
											<td style='width:33%;'>-</td>
										</tr>";
									}*/
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