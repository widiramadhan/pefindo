<?php
require_once("config/configuration.php");
require_once("config/connection.php");
date_default_timezone_set('Asia/Jakarta');

$pefindoId=$_GET['id'];
$ps_no=$_GET['no'];
$request=$_GET['request'];
$date=date("Y-m-d");
$user=$_GET['username'];


if($request == "individual"){
	/* cek ke database apakah id ini sudah ada didalam database ? */
	$call = "{call SP_CHECK_PEFINDO_ID(?,?)}";
	$params = array(array($pefindoId, SQLSRV_PARAM_IN),array($ps_no, SQLSRV_PARAM_IN));
	$options =  array( "Scrollable" => "buffered" );
	$exec = sqlsrv_query( $conn, $call, $params, $options) or die( print_r( sqlsrv_errors(), true)); 
	$data = sqlsrv_fetch_array($exec);
	$check=sqlsrv_num_rows($exec);
	
	/* jika sudah ada tampilkan dari database */
	if($check > 0){ 
		echo"<script>window.location='index.php?username=".$user."&page=scoring-individual&id=".$pefindoId."'</script>";
	/* jika tidak ada, request ke Pefindo kemudian save ke database dan tampilkan dari database */
	}else{
		/* request ke pefindo menggunakan curl */
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $pefindoURL,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"\r\nxmlns:cb5=\"http://creditinfo.com/CB5\"\r\nxmlns:cus=\"http://creditinfo.com/CB5/v5.31/CustomReport\"\r\nxmlns:arr=\"http://schemas.microsoft.com/2003/10/Serialization/Arrays\">\r\n <soapenv:Header/>\r\n <soapenv:Body>\r\n <cb5:GetCustomReport>\r\n <cb5:parameters>\r\n <cus:Consent>true</cus:Consent>\r\n <cus:IDNumber>".$pefindoId."</cus:IDNumber>\r\n <cus:IDNumberType>PefindoId</cus:IDNumberType>\r\n <cus:InquiryReason>ProvidingFacilities</cus:InquiryReason>\r\n <cus:InquiryReasonText/>\r\n <cus:ReportDate>".$date."</cus:ReportDate>\r\n <cus:Sections>\r\n <!--Zero or more repetitions:-->\r\n <arr:string>SubjectInfo</arr:string>\r\n <arr:string>PEFINDOScore</arr:string>\r\n </cus:Sections>\r\n <cus:SubjectType>Individual</cus:SubjectType>\r\n </cb5:parameters>\r\n </cb5:GetCustomReport>\r\n </soapenv:Body>\r\n</soapenv:Envelope>",
			CURLOPT_HTTPHEADER => array(
									"Authorization: Basic " . base64_encode("$username:$password"),
									"Content-Type: text/xml",
									"Postman-Token: ae0ace2e-aa92-4d66-8d14-d67edb42fa84",
									"SOAPAction: ".$getCustomReport,
									"cache-control: no-cache"
								),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
			//echo "cURL Error #:" . $err;
			echo"<script>window.location='index.php?username=".$user."&page=error'</script>";
		} else {
			$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
			$xml = new SimpleXMLElement($response);
			$body = $xml->xpath('//sBody')[0];
			$array = json_decode(json_encode((array)$body), TRUE); 
			//print_r($array);
		}
		
		/* INSERT TO PEFINDO_MAPPING */
		$callSPInsert = "{call SP_INSERT_PEFINDO_ID(?,?)}";
		$paramsInsert = array(array($pefindoId, SQLSRV_PARAM_IN),array($ps_no, SQLSRV_PARAM_IN));
		$execInsert = sqlsrv_query( $conn, $callSPInsert, $paramsInsert) or die( print_r( sqlsrv_errors(), true));
		
		/* GET MAPPING ID */
		$callMappingId = "{call SP_GET_PEFINDO_MAPPING_ID(?)}";
		$paramsMappingId = array(array($pefindoId, SQLSRV_PARAM_IN));
		$execMappingId = sqlsrv_query( $conn, $callMappingId, $paramsMappingId) or die( print_r( sqlsrv_errors(), true)); 
		$dataMappingId = sqlsrv_fetch_array($execMappingId);
		$mappingId = $dataMappingId['PEFINDO_MAPPING_ID'];
		
		/* ================= proses simpan ke database ================= */
		/* CIP */ require_once("pages/individual/save-data/save-data-cip.php");			
		/* CIQ */ require_once("pages/individual/save-data/save-data-ciq.php");
		/* COLLATERALS */ require_once("pages/individual/save-data/save-data-collaterals.php");
		/* COMPANY */ require_once("pages/individual/save-data/save-data-company.php");	
		/* CONTRACT OVERVIEW */ require_once("pages/individual/save-data/save-data-contract-overview.php");
		/* CONTRACT SUMMARY */ require_once("pages/individual/save-data/save-data-contract-summary.php");
		/* CONTRACT */ require_once("pages/individual/save-data/save-data-contract.php");
		/* CURRENT RELATIONS */ require_once("pages/individual/save-data/save-data-current-relations.php");
		/* DASHBOARD */ require_once("pages/individual/save-data/save-data-dashboard.php");
		/* DISPUTE */ require_once("pages/individual/save-data/save-data-disputes.php");
		/* FINANCIAL */ require_once("pages/individual/save-data/save-data-financial.php");
		/* INDIVIDUAL */ require_once("pages/individual/save-data/save-data-individual.php");
		/* INQUIRIES */ require_once("pages/individual/save-data/save-data-inquiries.php");
		/* INVOLVEMENT */ require_once("pages/individual/save-data/save-data-involvement.php");
		/* LIABILITIES */ require_once("pages/individual/save-data/save-data-other-liabilities.php");
		/* PARAMETERS */ require_once("pages/individual/save-data/save-data-parameters.php");
		/* REPORT INFO */ require_once("pages/individual/save-data/save-data-report-info.php");
		/* SECURITY */ require_once("pages/individual/save-data/save-data-security.php");	
		/* SUBJECT INFO HISTORY */ require_once("pages/individual/save-data/save-data-subject-info-history.php");	
		
		echo"<script>window.location='index.php?username=".$user."&page=scoring-individual&id=".$pefindoId."'</script>";	
	}
}else{
	/* cek ke database apakah id ini sudah ada didalam database ? */
	$call = "{call SP_CHECK_PEFINDO_ID(?,?)}";
	$params = array(array($pefindoId, SQLSRV_PARAM_IN),array($ps_no, SQLSRV_PARAM_IN));
	$options =  array( "Scrollable" => "buffered" );
	$exec = sqlsrv_query( $conn, $call, $params, $options) or die( print_r( sqlsrv_errors(), true)); 
	$data = sqlsrv_fetch_array($exec);
	$check=sqlsrv_num_rows($exec);
	
	
	/* jika sudah ada tampilkan dari database */
	if($check > 0){
		echo"<script>window.location='index.php?username=".$user."&page=scoring-company&id=".$pefindoId."'</script>";
	/* jika tidak ada request ke Pefindo kemudian save ke database dan tampilkan dari database */
	}else{
		/* request ke pefindo menggunakan curl */
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $pefindoURL,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"\r\nxmlns:cb5=\"http://creditinfo.com/CB5\"\r\nxmlns:cus=\"http://creditinfo.com/CB5/v5.31/CustomReport\"\r\nxmlns:arr=\"http://schemas.microsoft.com/2003/10/Serialization/Arrays\">\r\n <soapenv:Header/>\r\n <soapenv:Body>\r\n <cb5:GetCustomReport>\r\n <cb5:parameters>\r\n <cus:Consent>true</cus:Consent>\r\n <cus:IDNumber>".$pefindoId."</cus:IDNumber>\r\n <cus:IDNumberType>PefindoId</cus:IDNumberType>\r\n <cus:InquiryReason>ProvidingFacilities</cus:InquiryReason>\r\n <cus:InquiryReasonText/>\r\n <cus:ReportDate>".$date."</cus:ReportDate>\r\n <cus:Sections>\r\n <arr:string>PEFINDOScore</arr:string>\r\n </cus:Sections>\r\n <cus:SubjectType>Company</cus:SubjectType>\r\n </cb5:parameters>\r\n </cb5:GetCustomReport>\r\n </soapenv:Body>\r\n</soapenv:Envelope>",
			CURLOPT_HTTPHEADER => array(
									"Authorization: Basic " . base64_encode("$username:$password"),
									"Content-Type: text/xml",
									"Postman-Token: ae0ace2e-aa92-4d66-8d14-d67edb42fa84",
									"SOAPAction:".$getCustomReport,
									"cache-control: no-cache"
								),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
			//echo "cURL Error #:" . $err;
			echo"<script>window.location='index.php?username=".$user."&page=error'</script>";
		} else {
			$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
			$xml = new SimpleXMLElement($response);
			$body = $xml->xpath('//sBody')[0];
			$array = json_decode(json_encode((array)$body), TRUE); 
			//print_r($array);
		}
		
		/* INSERT TO PEFINDO_MAPPING */
		$callSPInsert = "{call SP_INSERT_PEFINDO_ID(?,?)}";
		$paramsInsert = array(array($pefindoId, SQLSRV_PARAM_IN),array($ps_no, SQLSRV_PARAM_IN));
		$execInsert = sqlsrv_query( $conn, $callSPInsert, $paramsInsert) or die( print_r( sqlsrv_errors(), true));
		
		/* GET MAPPING ID */
		$callMappingId = "{call SP_GET_PEFINDO_MAPPING_ID(?)}";
		$paramsMappingId = array(array($pefindoId, SQLSRV_PARAM_IN));
		$execMappingId = sqlsrv_query( $conn, $callMappingId, $paramsMappingId) or die( print_r( sqlsrv_errors(), true)); 
		$dataMappingId = sqlsrv_fetch_array($execMappingId);
		$mappingId = $dataMappingId['PEFINDO_MAPPING_ID'];
		
		/* ================= proses simpan ke database ================= */		
		/* CIP */ require_once("pages/company/save-data/save-data-cip.php");
		/* CIQ */ require_once("pages/company/save-data/save-data-ciq.php");
		/* COLLATERALS */ require_once("pages/company/save-data/save-data-collaterals.php");
		/* COMPANY */ require_once("pages/company/save-data/save-data-company.php");	
		/* CONTRACT OVERVIEW */ require_once("pages/company/save-data/save-data-contract-overview.php");
		/* CONTRACT SUMMARY */ require_once("pages/company/save-data/save-data-contract-summary.php");
		/* CONTRACT */ require_once("pages/company/save-data/save-data-contract.php");
		/* CURRENT RELATIONS */ require_once("pages/company/save-data/save-data-current-relations.php");
		/* DASHBOARD */ require_once("pages/company/save-data/save-data-dashboard.php");
		/* DISPUTE */ require_once("pages/company/save-data/save-data-disputes.php");
		/* FINANCIAL */ require_once("pages/company/save-data/save-data-financial.php");
		/* INDIVIDUAL */ require_once("pages/company/save-data/save-data-individual.php");
		/* INQUIRIES */ require_once("pages/company/save-data/save-data-inquiries.php");
		/* INVOLVEMENT */ require_once("pages/company/save-data/save-data-involvement.php");
		/* LIABILITIES */ require_once("pages/company/save-data/save-data-other-liabilities.php");
		/* PARAMETERS */ require_once("pages/company/save-data/save-data-parameters.php");
		/* REPORT INFO */ require_once("pages/company/save-data/save-data-report-info.php");
		/* SECURITY */ require_once("pages/company/save-data/save-data-security.php");	
		/* SUBJECT INFO HISTORY */ require_once("pages/company/save-data/save-data-subject-info-history.php");	
		
		echo"<script>window.location='index.php?username=".$user."&page=scoring-company&id=".$pefindoId."'</script>";	
	}
}
?>