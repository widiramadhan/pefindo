<?php
require_once("connection.php");

$callConfig = "{call SP_GET_PEFINDO_CONFIG}";
$execConfig = sqlsrv_query($conn, $callConfig) or die( print_r( sqlsrv_errors(), true)); 
while($dataConfig = sqlsrv_fetch_array($execConfig)){
	$label=$dataConfig['LABEL'];
	if($label == "USERNAME"){
		$username = $dataConfig['VALUE'];
	}
	if($label == "PASSWORD"){
		$password = $dataConfig['VALUE'];
	}
	if($label == "PEFINDO_URL"){
		$pefindoURL = $dataConfig['VALUE'];
	}
	if($label == "SMART_SEARCH_INDIVIDUAL"){
		$smartSearchIndividual = $dataConfig['VALUE'];
	}
	if($label == "SMART_SEARCH_COMPANY"){
		$smartSearchCompany = $dataConfig['VALUE'];
	}
	if($label == "GET_CUSTOM_REPORT"){
		$getCustomReport = $dataConfig['VALUE'];
	}
	if($label == "GET_REPORT_PDF"){
		$getReportPDF = $dataConfig['VALUE'];
	}
}
?>