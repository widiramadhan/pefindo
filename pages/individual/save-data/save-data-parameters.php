<?php
/* Parameters */
if($array['GetCustomReportResponse']['GetCustomReportResult']['aParameters']['aConsent']<>NULL){$ParamsConsent=$array['GetCustomReportResponse']['GetCustomReportResult']['aParameters']['aConsent'];}else{$ParamsConsent=NULL;}	
if($array['GetCustomReportResponse']['GetCustomReportResult']['aParameters']['aIDNumber']<>NULL){$ParamsIdNumb=$array['GetCustomReportResponse']['GetCustomReportResult']['aParameters']['aIDNumber'];}else{$ParamsIdNumb=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aParameters']['aIDNumberType']<>NULL){$ParamsIdNumbType=$array['GetCustomReportResponse']['GetCustomReportResult']['aParameters']['aIDNumberType'];}else{$ParamsIdNumbType=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aParameters']['aInquiryReason']<>NULL){$ParamsInqReason=$array['GetCustomReportResponse']['GetCustomReportResult']['aParameters']['aInquiryReason'];}else{$ParamsInqReason=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aParameters']['aInquiryReasonText']<>NULL){$ParamsInqReasonText=$array['GetCustomReportResponse']['GetCustomReportResult']['aParameters']['aInquiryReasonText'];}else{$ParamsInqReasonText=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aParameters']['aReportDate']<>NULL){$ParamsReportDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aParameters']['aReportDate'];}else{$ParamsReportDate=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aParameters']['aSubjectType']<>NULL){$ParamsSubType=$array['GetCustomReportResponse']['GetCustomReportResult']['aParameters']['aSubjectType'];}else{$ParamsSubType=NULL;}		

$callParameter = "{call SP_INSERT_PARAMETERS(?,?,?,?,?,?,?,?,?)}";
$paramsParameter = array(
					array($mappingId, SQLSRV_PARAM_IN),
					array($pefindoId,SQLSRV_PARAM_IN),
					array($ParamsConsent,SQLSRV_PARAM_IN),
					array($ParamsIdNumb,SQLSRV_PARAM_IN),
					array($ParamsIdNumbType,SQLSRV_PARAM_IN),
					array($ParamsInqReason,SQLSRV_PARAM_IN),
					array($ParamsInqReasonText,SQLSRV_PARAM_IN),
					array($ParamsReportDate,SQLSRV_PARAM_IN),
					array($ParamsSubType,SQLSRV_PARAM_IN)
					);
$execParameter = sqlsrv_query($conn, $callParameter, $paramsParameter) or die ( print_r( sqlsrv_errors(),true));

/* Get Parameter */
$callGetParameter = "{call SP_GET_PARAMETERS(?,?)}";
$paramsGetParameter = array(
					array($mappingId, SQLSRV_PARAM_IN),
					array($pefindoId,SQLSRV_PARAM_IN)
				);
$execGetParameter = sqlsrv_query($conn, $callGetParameter, $paramsGetParameter) or die ( print_r( sqlsrv_errors(),true));
$data = sqlsrv_fetch_array($execGetParameter);
$parametersId=$data['M_PARAMETERS_ID'];
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aParameters']['aSections'])){
	$count=count($array['GetCustomReportResponse']['GetCustomReportResult']['aParameters']['aSections']['bstring']);
	for($i=0;$i<$count;$i++){
		/* insert to section */
		$callSection = "{call SP_INSERT_PARAMETERS_SECTIONS(?,?,?)}";
		$paramsSection = array(
							array($mappingId, SQLSRV_PARAM_IN),
							array($parametersId,SQLSRV_PARAM_IN),
							array($array['GetCustomReportResponse']['GetCustomReportResult']['aParameters']['aSections']['bstring'][$i],SQLSRV_PARAM_IN)
						);
		$execSection = sqlsrv_query($conn, $callSection, $paramsSection) or die ( print_r( sqlsrv_errors(),true));
	}
}
?>