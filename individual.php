<style>
th{
	text-align:center;
	font-weight:bold;
}
td{
	text-align:center;
}
.loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 99999999999999999999999999999;
    background: url('assets/img/loading.gif') 50% 50% no-repeat rgb(255,255,255);
    opacity: 1;
}
</style>
<?php
	require_once("config/configuration.php");
	error_reporting(0);

	if(isset($_POST['select'])){
		$prospect_no=$_POST['prospect_no'];
		$id_no=$_POST['id_no'];
		$cust_name=$_POST['cust_name'];
		$birth_dt=$_POST['birth_dt'];
		$birth_plc=$_POST['birth_plc'];
		$mother_nm=$_POST['mother_nm'];
	}else{
		$prospect_no="";
		$id_no="";
		$cust_name="";
		$birth_dt="";
		$birth_plc="";
		$mother_nm="";
	}	

	$opt = "0";

	if(isset($_POST['submit'])){
		$prospect=$_POST['prospect_no'];
		$date=$_POST['date'];
		$nama=$_POST['name'];
		$no_ktp=$_POST['no_ktp'];

		$birth_dt_sbmt=$_POST['date'];
		$birth_plc_sbmt=$_POST['birth_plc'];
		$mother_nm_sbmt=$_POST['mother_nm'];
		$opt="1";
		$Warning_Data ="";

		//--# Cek Dukcapil
		$param_dukcapil_array= array('nik' => $no_ktp, 'user_id' => "devsuzukif", 'password' => "XNcPZp41", 'IP_USER' => "10.162.130.2");
		//$param_dukcapil_array= array('nik' => "3174999999332", 'user_id' => "devsuzukif", 'password' => "XNcPZp41", 'IP_USER' => "10.162.130.2");
		$param_dukcapil = json_encode($param_dukcapil_array);
		//echo"<script>alert('$nama $no_ktp $date');</script>";
		//echo"<script>alert('$smartSearchIndividual');</script>";
	}else{
		$prospect="";
		$date="";
		$nama="";
		$no_ktp="";
		$birth_dt_sbmt="";
		$birth_plc_sbmt="";
		$mother_nm_sbmt="";
		$opt="0";
		$Warning_Data ="";
	}
	$type=$_GET['MR_ID_TYPE'];
	$CUST_TYPE=$_GET['CUST_TYPE'];

	if($opt=="1")
	{
		$call_bls = "{call SP_CHECK_PEFINDO_BLACKLIST(?,?,?,?,?,?,?)}";
		$params_bls = array(array($no_ktp, SQLSRV_PARAM_IN),array($nama, SQLSRV_PARAM_IN),array($birth_dt_sbmt, SQLSRV_PARAM_IN),array($birth_plc_sbmt, SQLSRV_PARAM_IN),array($mother_nm_sbmt, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
		$options =  array( "Scrollable" => "buffered" );
		$exec_bls = sqlsrv_query( $conn, $call_bls, $params_bls, $options) or die( print_r( sqlsrv_errors(), true)); 
		$data = sqlsrv_fetch_array($exec_bls);
		$checkBlacklist=sqlsrv_num_rows($exec_bls);


		//echo"<script>alert('".$check."');</script>";
		//echo 'blacklist : '.$no_ktp.' - '.$nama.' - '.$birth_dt_sbmt.' - '.$birth_plc_sbmt.' - '.$mother_nm_sbmt;

		if($checkBlacklist > 0){	//----# Cek Blacklist
			echo"<script>alert('Customer tersebut terdaftar di Customer Blacklist Internal.');</script>";
			//echo 'blacklist'.$no_ktp.' - '.$nama.' - '.$birth_dt_sbmt.' - '.$birth_plc_sbmt.' - '.$mother_nm_sbmt;
			$Warning_Data = $Warning_Data." - Customer ini terdaftar di Customer Blacklist Internal.!<br>";
		}
		
		//----# Cek Dukcapil
		$curlDkUpil = curl_init();
		curl_setopt_array($curlDkUpil, array(
		  CURLOPT_URL => "http://172.16.160.128:8000/dukcapil/get_json/SUZUKI_FINANCE/CALL_NIK",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "$param_dukcapil",
		  CURLOPT_HTTPHEADER => array(
			"Authorization: Basic " . base64_encode("devsuzukif:XNcPZp41"),
		    "Content-Type: application/json",
		    "Postman-Token: ae0ace2e-aa92-4d66-8d14-d67edb42fa84",
		    "cache-control: no-cache"
		  ),
		));

		$responseDkUpil = curl_exec($curlDkUpil);
		$errDkUpil = curl_error($curlDkUpil);
					
		curl_close($curlDkUpil);

		$resultDukcapil = json_decode($responseDkUpil, true);

		if(empty($resultDukcapil))
		{
			//----# Insert LOG
			$SourceLogDkUpilNtValid = "DUKCAPIL";
			$StatusLogDkUpilNtValid = "KTP TIDAK VALID";

			$callSPLogDkUpilNtValid = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?)}";
			$paramsLogDkUpilNtValid = array(array($prospect, SQLSRV_PARAM_IN),array($SourceLogDkUpilNtValid, SQLSRV_PARAM_IN),array($StatusLogDkUpilNtValid, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
			$execLogDkUpilNtValid = sqlsrv_query( $conn, $callSPLogDkUpilNtValid, $paramsLogDkUpilNtValid) or die( print_r( sqlsrv_errors(), true));
			if($execLogDkUpilNtValid === false){
				echo"<script>alert('Error insert log Dukcapil Not Valid');</script>";
			}
			//----# Insert LOG End

			//echo"<script>window.location='index.php?USERNAME=".$user."&page=error'</script>";
			echo "<script>alert('Error : ".$StatusLogDkUpilNtValid." (Pada saat pengecekan No KTP di Dukcapil.!)<br>')</script>";
			$Warning_Data = $Warning_Data." - KTP TIDAK VALID (Pada saat pengecekan No KTP di Dukcapil.!) ";
		}
		else
		{
			if ($errDkUpil) 
			{
				//----# Insert LOG
				$SourceLogDkUpil = "DUKCAPIL";
				$StatusLogDkUpil = "ERROR";

				$callSPLogDkUpil = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?)}";
				$paramsLogDkUpil = array(array($prospect, SQLSRV_PARAM_IN),array($SourceLogDkUpil, SQLSRV_PARAM_IN),array($StatusLogDkUpil, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
				$execLogDkUpil = sqlsrv_query( $conn, $callSPLogDkUpil, $paramsLogDkUpil) or die( print_r( sqlsrv_errors(), true));
				if($execLogDkUpil === false){
					echo"<script>alert('Error insert log Dukcapil');</script>";
				}
				//----# Insert LOG End
				echo "<script>alert('Error : ".$errDkUpil." (Pada saat pengecekan No KTP di Dukcapil.!)')</script>";

				//echo"<script>window.location='index.php?USERNAME=".$user."&page=error'</script>";
			}
			else
			{

				if (isset($resultDukcapil['content'][0]['RESPON'])) {
				    //echo $resultDukcapil['content'][0]['RESPON'];
				    //echo "<br /><br />111";

				    //----# Insert LOG
					$SourceLogDkUpilnotfound = "DUKCAPIL";
					$StatusLogDkUpilnotfound = strtoupper($resultDukcapil['content'][0]['RESPON']);

					$callSPLogDkUpilnotfound = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?)}";
					$paramsLogDkUpilnotfound = array(array($prospect, SQLSRV_PARAM_IN),array($SourceLogDkUpilnotfound, SQLSRV_PARAM_IN),array($StatusLogDkUpilnotfound, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
					$execLogDkUpilnotfound = sqlsrv_query( $conn, $callSPLogDkUpilnotfound, $paramsLogDkUpilnotfound) or die( print_r( sqlsrv_errors(), true));
					if($execLogDkUpilnotfound === false){
						echo"<script>alert('NIK Tersebut Tidak ditemukan di Dukcapil.!');</script>";
					}
					//----# Insert LOG End

					echo "<script>alert('Error : ".$StatusLogDkUpilnotfound." (Pada saat pengecekan No KTP di Dukcapil.!)')</script>";
					$Warning_Data = $Warning_Data."  ".$StatusLogDkUpilnotfound."  (Pada saat pengecekan No KTP di Dukcapil.!) ";
				}
				// else
				// {
					foreach($resultDukcapil['content'] as $contentdata)
					{
						// echo "<br /><br /><br />";
						// echo $contentdata['NIK']."<br />";
						// echo $contentdata['NAMA_LGKP']."<br />";
						// echo "<br />";
						$DkcplCustType = "PEMOHON";
						$DkcplNIK = number_format($contentdata['NIK'], 0, '', '');
						//$DkcplNIK = "317322222001";
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

						
						if($DkcplNAMA_LGKP != $nama)
						{
							$Warning_Data = $Warning_Data." - Nama Lengkap Tidak Sama dengan data di Dukcapil.!<br>";
						}
						if($DkcplTGL_LHR != $birth_dt_sbmt)
						{
							$Warning_Data = $Warning_Data." - Tanggal Lahir Tidak Sama dengan data di Dukcapil.!<br>";
						}
						if($DkcplNAMA_LGKP_IBU != $mother_nm_sbmt)
						{
							$Warning_Data = $Warning_Data." - Nama Ibu Kandung Tidak Sama dengan data di Dukcapil.!<br>";
						}

						$Is_Similar = 0;
						if($Warning_Data != "")
						{
							$Is_Similar = 1;
						}


						$callSPDukcapil = "{call SP_INSERT_DUKCAPIL(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
						$paramsDukcapil = array(array($prospect, SQLSRV_PARAM_IN),array($DkcplCustType, SQLSRV_PARAM_IN),array($DkcplNIK, SQLSRV_PARAM_IN),array($DkcplNAMA_LGKP, SQLSRV_PARAM_IN),array($DkcplJENIS_KLMIN, SQLSRV_PARAM_IN),array($DkcplTMPT_LHR, SQLSRV_PARAM_IN),array($DkcplTGL_LHR, SQLSRV_PARAM_IN),array($DkcplSTATUS_KAWIN, SQLSRV_PARAM_IN),array($DkcplNAMA_LGKP_IBU, SQLSRV_PARAM_IN),array($DkcplJENIS_PKRJN, SQLSRV_PARAM_IN),array($DkcplALAMAT, SQLSRV_PARAM_IN),array($DkcplNO_RT, SQLSRV_PARAM_IN),array($DkcplNO_RW, SQLSRV_PARAM_IN),array($DkcplNO_PROP, SQLSRV_PARAM_IN),array($DkcplPROP_NAME, SQLSRV_PARAM_IN),array($DkcplNO_KAB, SQLSRV_PARAM_IN),array($DkcplKAB_NAME, SQLSRV_PARAM_IN),array($DkcplKEC_NAME, SQLSRV_PARAM_IN),array($DkcplNO_KEL, SQLSRV_PARAM_IN),array($DkcplNO_KEC, SQLSRV_PARAM_IN),array($DkcplKEL_NAME, SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN),array($Is_Similar, SQLSRV_PARAM_IN));
						$execDukcapil = sqlsrv_query( $conn, $callSPDukcapil, $paramsDukcapil) or die( print_r( sqlsrv_errors(), true));
						if($execDukcapilg === false){
							echo"<script>alert('Error insert Data Dukcapil');</script>";
						}
					}

					//----# Insert LOG
					$SourceLogDkcpl = "DUKCAPIL";
					$StatusLogDkcpl = "VALID";

					$callSPLogDkcpl = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?)}";
					$paramsLogDkcpl = array(array($prospect, SQLSRV_PARAM_IN),array($SourceLogDkcpl, SQLSRV_PARAM_IN),array($StatusLogDkcpl, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
					$execLogDkcpl = sqlsrv_query( $conn, $callSPLogDkcpl, $paramsLogDkcpl) or die( print_r( sqlsrv_errors(), true));
					if($execLogDkcpl === false){
						echo"<script>alert('Error insert log');</script>";
					}
					//----# Insert LOG End


					//--# CEK PEFINDO
					$curl = curl_init();

					curl_setopt_array($curl, array(
					  CURLOPT_URL => "https://bo.pefindobirokredit.com/WsReport/v5.31/Service.svc",
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => "",
					  CURLOPT_MAXREDIRS => 10,
					  CURLOPT_TIMEOUT => 30,
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

					if ($err) {
						//echo "cURL Error #:" . $err;
						//----# Insert LOG
						$SourceLog = "PEFINDO";
						$StatusLog = "ERROR";

						$callSPLogPfnd = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?)}";
						$paramsLogPfnd = array(array($prospect, SQLSRV_PARAM_IN),array($SourceLog, SQLSRV_PARAM_IN),array($StatusLog, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
						$execLogPfnd = sqlsrv_query( $conn, $callSPLogPfnd, $paramsLogPfnd) or die( print_r( sqlsrv_errors(), true));
						if($execLogPfnd === false){
							echo"<script>alert('Error insert log');</script>";
						}
						//----# Insert LOG End

						echo"<script>window.location='index.php?USERNAME=".$user."&page=error'</script>";
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

								$callSPLogPfndScss = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?)}";
								$paramsLogPfndScss = array(array($prospect, SQLSRV_PARAM_IN),array($SourceLogPfndScss, SQLSRV_PARAM_IN),array($StatusLogPfndScss, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
								$execLogPfndScss = sqlsrv_query( $conn, $callSPLogPfndScss, $paramsLogPfndScss) or die( print_r( sqlsrv_errors(), true));
								if($execLogPfndScss === false){
									echo"<script>alert('Error insert log Pefindo DataFound');</script>";
								}
								//----# Insert LOG End
							}else{
								//----# Insert LOG
								$SourceLogPfndScssMlti = "PEFINDO";
								$StatusLogPfndScssMlti = "DATA DITEMUKAN - MULTI PEFINDO ID";

								$callSPLogPfndScssMlti = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?)}";
								$paramsLogPfndScssMlti = array(array($prospect, SQLSRV_PARAM_IN),array($SourceLogPfndScssMlti, SQLSRV_PARAM_IN),array($StatusLogPfndScssMlti, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
								$execLogPfndScssMlti = sqlsrv_query( $conn, $callSPLogPfndScssMlti, $paramsLogPfndScssMlti) or die( print_r( sqlsrv_errors(), true));
								if($execLogPfndScssMlti === false){
									echo"<script>alert('Error insert log Pefindo DataFoundMulti');</script>";
								}
								//----# Insert LOG End
							}
						}else{
							$callCheckSLIK = "{call SP_CHECK_DATA_SLIK(?)}";
							$optionsCheckSLIK =  array( "Scrollable" => "buffered" );
							$paramsCheckSLIK = array(array($prospect, SQLSRV_PARAM_IN));
							$execCheckSLIK = sqlsrv_query( $conn, $callCheckSLIK, $paramsCheckSLIK, $optionsCheckSLIK) or die( print_r( sqlsrv_errors(), true));
							$dataCheckSLIK = sqlsrv_fetch_array($execCheckSLIK);
							$numrowsCheckSLIK = sqlsrv_num_rows($execCheckSLIK);
							if($numrowsCheckSLIK <> 0){
								//----# Insert LOG
								$SourceLogSLIKScss = "SLIK";
								$StatusLogSLIKScss = "DATA DITEMUKAN";

								$callSPLogSLIKScss = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?)}";
								$paramsLogSLIKScss = array(array($prospect, SQLSRV_PARAM_IN),array($SourceLogSLIKScss, SQLSRV_PARAM_IN),array($StatusLogSLIKScss, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
								$execLogSLIKScss = sqlsrv_query( $conn, $callSPLogSLIKScss, $paramsLogSLIKScss) or die( print_r( sqlsrv_errors(), true));
								if($execLogSLIKScss === false){
									echo"<script>alert('Error insert log SLIK DataFound');</script>";
								}
								//----# Insert LOG End
								
								$cekdata = $dataCheckSLIK['CREATE_DATE']->format('d-m-Y');
								$databranch = $dataCheckSLIK['OFFICE_NAME'];
								echo"<script>alert('Data sudah pernah di cek pada tanggal $cekdata oleh cabang $databranch')</script>";
								if($dataCheckSLIK['SUB_PARAM_ID'] == 2){
									echo"<script>window.location='index.php?USERNAME=".$user."&page=slik-detail&id=".$prospect."'</script>";
								}else{
									echo"<script>window.location='index.php?USERNAME=".$user."&page=pefindonodata'</script>";
								}
							}else{
								#
								//----# Insert LOG
								$SourceLogSLIKNtfnd = "SLIK";
								$StatusLogSLIKNtfnd = "DATA TIDAK DITEMUKAN";

								$callSPLogSLIKNtfnd = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?)}";
								$paramsLogSLIKNtfnd = array(array($prospect, SQLSRV_PARAM_IN),array($SourceLogSLIKNtfnd, SQLSRV_PARAM_IN),array($StatusLogSLIKNtfnd, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
								$execLogSLIKNtfnd = sqlsrv_query( $conn, $callSPLogSLIKNtfnd, $paramsLogSLIKNtfnd) or die( print_r( sqlsrv_errors(), true));
								if($execLogSLIKNtfnd === false){
									echo"<script>alert('Error insert log Pefindo DataFound');</script>";
								}
								//----# Insert LOG End
								
								//----# Insert LOG
								$SourceLogPfndNtfnd = "PEFINDO";
								$StatusLogPfndNtfnd = "DATA TIDAK DITEMUKAN";

								$callSPLogPfndNtfnd = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?)}";
								$paramsLogPfndNtfnd = array(array($prospect, SQLSRV_PARAM_IN),array($SourceLogPfndNtfnd, SQLSRV_PARAM_IN),array($StatusLogPfndNtfnd, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
								$execLogPfndNtfnd = sqlsrv_query( $conn, $callSPLogPfndNtfnd, $paramsLogPfndNtfnd) or die( print_r( sqlsrv_errors(), true));
								if($execLogPfndNtfnd === false){
									echo"<script>alert('Error insert log Pefindo DataFound');</script>";
								}
								//----# Insert LOG End

								//----# Insert Table NoData
								$callSPNoData = "{call SP_INSERT_PEFINDO_NODATA(?,?,?,?,?,?,?,?)}";
								$paramsNoData = array(array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($nama, SQLSRV_PARAM_IN), array($birth_dt_sbmt, SQLSRV_PARAM_IN), array("P", SQLSRV_PARAM_IN), array("KTP", SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN), array("PEMOHON", SQLSRV_PARAM_IN));
								$execNoData = sqlsrv_query( $conn, $callSPNoData, $paramsNoData) or die( print_r( sqlsrv_errors(), true));
								if($execNoData === false){
									echo"<script>alert('Error insert To Table NoData.!');</script>";
								}

								echo"<script>alert('Prospek atas nama ".$nama." dengan NIK ".$no_ktp." tidak mempunyai record di Pefindo, silahkan cek kembali lewat SLIK');window.location='index.php?USERNAME=".$user."&page=pefindonodata'</script>";
								//----# Insert Table NoData
							}
						}
					}
				// }
			}
		}
	}
	else if($opt=="0")
	{

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://bo.pefindobirokredit.com/WsReport/v5.31/Service.svc",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
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

		if ($err) {
			//echo "cURL Error #:" . $err;
			echo"<script>window.location='index.php?USERNAME=".$user."&page=error'</script>";
		} else {
			$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
			$xml = new SimpleXMLElement($response);
			$body = $xml->xpath('//sBody')[0];
			$array = json_decode(json_encode((array)$body), TRUE); 
			//print_r($array);
		}
	}
?>

<div class="loader" id="loader"></div>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Individual</h4>
				<p class="category">Sistem Informasi Debitur</p>
			</div>
			<div class="content">
				<form action="" method="post">
					<div class="row">
						<div class="col-md-3">
							<label>Prospect Number</label>	
							<div class="input-group date">
								<input type="text" name="no_prospect" class="form-control" placeholder="Prospect Number" value="<?php echo $prospect_no;?>" disabled style="cursor:pointer;">
								<input type="hidden" name="prospect_no" value="<?php echo $prospect_no;?>">
								<div class="input-group-addon" data-target="#prospect" data-toggle="modal" style="cursor:pointer;">
									<i class="fa fa-search"></i>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>KTP Number</label>
								<input type="text" class="form-control" placeholder="KTP Number" value="<?php echo $id_no;?>" disabled>
								<input type="hidden" name="no_ktp" value="<?php echo $id_no;?>">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Fullname</label>
								<input type="text" name="name" class="form-control" placeholder="Fullname" value="<?php echo $cust_name;?>" disabled>
								<input type="hidden" name="name" value="<?php echo $cust_name;?>">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Date of Birth</label>
								<div class="input-group date">
									<input type="text" class="form-control pull-right" name="date" id="datepicker" readonly="true" placeholder="Date" value="<?php echo $birth_dt;?>" disabled>
									<input type="hidden" name="date" id="datepicker" value="<?php echo $birth_dt;?>">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="pull-right">
						<button type="submit" name="submit" class="btn btn-primary">Search</button>
						<button type="reset" class="btn btn-danger">Cancel</button>
					</div>
					<div style="clear:both;"></div>
				</form>
				<hr>
				<table class="table table-bordered table-stripped">
					<thead>
						<tr>
							<th>No</th>
							<th>KTP Number</th>
							<th>Fullname</th>
							<th>Date of Birth</th>
							<th>Address</th>
							<th style="width:10%;">Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
						if($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aStatus'] == 'SubjectFound'){
							if($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aPefindoId'] <> NULL){
					?>
						<tr>
							<td>1</td>
							<td>
								<a href="#" data-target="#dataDukcapil" data-toggle="modal" style="cursor:pointer; color: blue;">
									<?php echo $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aKTP'];?>
								</a>
							</td>
							<td><?php echo $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aFullName'];?></td>
							<td><?php echo date('d-m-Y', strtotime($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aDateOfBirth']));?></td>
							<td><?php echo $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aAddress'];?></td>
							<td>
								<a href="check.php?USERNAME=<?php echo $user;?>&request=individual&no=<?php echo $prospect;?>&id=<?php echo $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aPefindoId'];?>" class="btn btn-success"><i class="fa fa-search"></i> Check Scoring</a>
							</td>
						</tr>
					<?php
							}else{
								$no=0;
								foreach($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord'] as $item) {
									$no++;
					?>
						<tr>
							<td><?php echo $no;?></td>
							<td><a href="#" data-target="#dataDukcapil" data-toggle="modal" style="cursor:pointer; color: blue;"><?php echo $item['aKTP'];?></a></td>
							<td><?php echo $item['aFullName'];?></td>
							<td><?php echo date('d-m-Y', strtotime($item['aDateOfBirth']));?></td>
							<td><?php echo $item['aAddress'];?></td>
							<td>
								<a href="check.php?USERNAME=<?php echo $user;?>&request=individual&no=<?php echo $prospect;?>&id=<?php echo $item['aPefindoId'];?>" class="btn btn-success"><i class="fa fa-search"></i> Check Scoring</a>								
							</td>
						</tr>
					<?php		
								}
							}
						}else{
							if(isset($_POST['submit'])){
								//echo"<script>alert('Prospek atas nama ".$nama." dengan NIK ".$no_ktp." tidak mempunyai record di Pefindo, silahkan cek kembali lewat SLIK')</script>";
							}
					?>
						<tr>
							<td colspan="6" style="text-align:center;">Not Found</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>

				<b><label style="color:red; font-size: 14px"><?php echo $Warning_Data;?></label></b>
			</div>
		</div>
	</div>
</div>
<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$(window).on("load", function(){
		setTimeout(function(){
			$("#loader").fadeOut("slow");
		}, 2000);
	});
</script>