<?php
if($array['GetCustomReportResponse']['GetCustomReportResult']['aReportInfo']['bCreated']<>NULL){$ReportCreated=date("Y-m-d", strtotime($array['GetCustomReportResponse']['GetCustomReportResult']['aReportInfo']['bCreated']));}else{$ReportCreated=NULL;}		
if($array['GetCustomReportResponse']['GetCustomReportResult']['aReportInfo']['bReferenceNumber']<>NULL){$ReportRefNumb=$array['GetCustomReportResponse']['GetCustomReportResult']['aReportInfo']['bReferenceNumber'];}else{$ReportRefNumb=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aReportInfo']['bReportStatus']<>NULL){$ReportStatus=$array['GetCustomReportResponse']['GetCustomReportResult']['aReportInfo']['bReportStatus'];}else{$ReportStatus=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aReportInfo']['bRequestedBy']<>NULL){$ReportReqBy=$array['GetCustomReportResponse']['GetCustomReportResult']['aReportInfo']['bRequestedBy'];}else{$ReportReqBy=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aReportInfo']['bVersion']<>NULL){$ReportVersion=$array['GetCustomReportResponse']['GetCustomReportResult']['aReportInfo']['bVersion'];}else{$ReportVersion=NULL;}		

$callReportInfo = "{call SP_INSERT_M_REPORT_INFO_COMPANY(?,?,?,?,?,?,?)}";
$paramsReportInfo = array(
					array($mappingId, SQLSRV_PARAM_IN),
					array($pefindoId,SQLSRV_PARAM_IN),
					array($ReportCreated,SQLSRV_PARAM_IN),
					array($ReportRefNumb,SQLSRV_PARAM_IN),
					array($ReportStatus,SQLSRV_PARAM_IN),
					array($ReportReqBy,SQLSRV_PARAM_IN),
					array($ReportVersion,SQLSRV_PARAM_IN)							
					);
$execReportInfo = sqlsrv_query($conn, $callReportInfo, $paramsReportInfo) or die ( print_r( sqlsrv_errors(),true));
?>