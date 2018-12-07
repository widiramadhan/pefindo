<?php
/* CIQ Detail Company*/		
if($array['GetCustomReportResponse']['GetCustomReportResult']['aCIQ']['bDetail']['bNumberOfCancelledClosedContracts']<>NULL){$NumbCancel=$array['GetCustomReportResponse']['GetCustomReportResult']['aCIQ']['bDetail']['bNumberOfCancelledClosedContracts'];}else{$NumbCancel=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aCIQ']['bDetail']['bNumberOfSubscribersMadeInquiriesLast14Days']<>NULL){$Numb14days=$array['GetCustomReportResponse']['GetCustomReportResult']['aCIQ']['bDetail']['bNumberOfSubscribersMadeInquiriesLast14Days'];}else{$Numb14days=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aCIQ']['bDetail']['bNumberOfSubscribersMadeInquiriesLast2Days']<>NULL){$Numb12days=$array['GetCustomReportResponse']['GetCustomReportResult']['aCIQ']['bDetail']['bNumberOfSubscribersMadeInquiriesLast2Days'];}else{$Numb12days=NULL;}

$callCIQ_D = "{call SP_INSERT_CIQ_DETAIL_COMPANY(?,?,?,?,?)}";
$paramsCIQ_D = array(
					array($mappingId, SQLSRV_PARAM_IN),
					array($pefindoId, SQLSRV_PARAM_IN),
					array($NumbCancel, SQLSRV_PARAM_IN),
					array($Numb14days, SQLSRV_PARAM_IN),
					array($Numb12days, SQLSRV_PARAM_IN)
			);
$execCIQ_D = sqlsrv_query( $conn, $callCIQ_D, $paramsCIQ_D) or die( print_r( sqlsrv_errors(), true));

/*CIQ_SUMMARY*/
if($array['GetCustomReportResponse']['GetCustomReportResult']['aCIQ']['bSummary']['bDateOfLastFraudRegistrationPrimarySubject']<>NULL){$DateOfLastprimary=$array['GetCustomReportResponse']['GetCustomReportResult']['aCIQ']['bSummary']['bDateOfLastFraudRegistrationPrimarySubject'];}else{$DateOfLastprimary=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aCIQ']['bSummary']['bDateOfLastFraudRegistrationThirdParty']<>NULL){$DateOfLastThird=$array['GetCustomReportResponse']['GetCustomReportResult']['aCIQ']['bSummary']['bDateOfLastFraudRegistrationThirdParty'];}else{$DateOfLastThird=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aCIQ']['bSummary']['bNumberOfFraudAlertsPrimarySubject']<>NULL){$NumbOfLastPrimary=$array['GetCustomReportResponse']['GetCustomReportResult']['aCIQ']['bSummary']['bNumberOfFraudAlertsPrimarySubject'];}else{$NumbOfLastPrimary=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aCIQ']['bSummary']['bNumberOfFraudAlertsThirdParty']<>NULL){$NumbOfLastThird=$array['GetCustomReportResponse']['GetCustomReportResult']['aCIQ']['bSummary']['bNumberOfFraudAlertsThirdParty'];}else{$NumbOfLastThird=NULL;}

$callCIQ_SUM = "{call SP_INSERT_CIQ_SUMMARY_COMPANY(?,?,?,?,?,?)}";
$paramsCIQ_SUM = array(
					array($mappingId, SQLSRV_PARAM_IN),
					array($pefindoId,SQLSRV_PARAM_IN),
					array($DateOfLastprimary,SQLSRV_PARAM_IN),
					array($DateOfLastThird,SQLSRV_PARAM_IN),
					array($NumbOfLastPrimary,SQLSRV_PARAM_IN),
					array($NumbOfLastThird,SQLSRV_PARAM_IN)
				);
$execCIQ_SUM = sqlsrv_query($conn, $callCIQ_SUM, $paramsCIQ_SUM) or die (print_r(sqlsrv_errors(),true));
?>