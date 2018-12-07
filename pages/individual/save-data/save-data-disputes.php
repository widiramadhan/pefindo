<?php
/* Disputes List */
if($array['GetCustomReportResponse']['GetCustomReportResult']['aDisputes']['bDisputeList']<>NULL){$disputeList=$array['GetCustomReportResponse']['GetCustomReportResult']['aDisputes']['bDisputeList'];}else{$disputeList=NULL;}

$callDisputesList = "{call SP_INSERT_DISPUTES_LIST(?,?,?)}";
$paramsDisputesList = array(
					array($mappingId, SQLSRV_PARAM_IN),
					array($pefindoId,SQLSRV_PARAM_IN),
					array($disputeList,SQLSRV_PARAM_IN)
					);
$execDisputesList = sqlsrv_query($conn, $callDisputesList, $paramsDisputesList) or die ( print_r( sqlsrv_errors(),true));

/* Dispute Summary */
if($array['GetCustomReportResponse']['GetCustomReportResult']['aDisputes']['bSummary']['bNumberOfActiveDisputesContracts']<>NULL){$DispSumNumbActiveCont=$array['GetCustomReportResponse']['GetCustomReportResult']['aDisputes']['bSummary']['bNumberOfActiveDisputesContracts'];}else{$DispSumNumbActiveCont=NULL;}		
if($array['GetCustomReportResponse']['GetCustomReportResult']['aDisputes']['bSummary']['bNumberOfActiveDisputesInCourt']<>NULL){$DispSumNumbActiveCourt=$array['GetCustomReportResponse']['GetCustomReportResult']['aDisputes']['bSummary']['bNumberOfActiveDisputesInCourt'];}else{$DispSumNumbActiveCourt=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aDisputes']['bSummary']['bNumberOfActiveDisputesSubjectData']<>NULL){$DispSumNumbActiveSubData=$array['GetCustomReportResponse']['GetCustomReportResult']['aDisputes']['bSummary']['bNumberOfActiveDisputesSubjectData'];}else{$DispSumNumbActiveSubData=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aDisputes']['bSummary']['bNumberOfClosedDisputesContracts']<>NULL){$DispSumNumbCloseCont=$array['GetCustomReportResponse']['GetCustomReportResult']['aDisputes']['bSummary']['bNumberOfClosedDisputesContracts'];}else{$DispSumNumbCloseCont=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aDisputes']['bSummary']['bNumberOfClosedDisputesSubjectData']<>NULL){$DispSumNumbCloseSubData=$array['GetCustomReportResponse']['GetCustomReportResult']['aDisputes']['bSummary']['bNumberOfClosedDisputesSubjectData'];}else{$DispSumNumbCloseSubData=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aDisputes']['bSummary']['bNumberOfFalseDisputes']<>NULL){$DispSumNumbFalse=$array['GetCustomReportResponse']['GetCustomReportResult']['aDisputes']['bSummary']['bNumberOfFalseDisputes'];}else{$DispSumNumbFalse=NULL;}

$callDisputesSum = "{call SP_INSERT_DISPUTES_SUMMARY(?,?,?,?,?,?,?,?)}";
$paramsDisputesSum = array(
					array($mappingId, SQLSRV_PARAM_IN),
					array($pefindoId,SQLSRV_PARAM_IN),
					array($DispSumNumbActiveCont,SQLSRV_PARAM_IN),
					array($DispSumNumbActiveCourt,SQLSRV_PARAM_IN),
					array($DispSumNumbActiveSubData,SQLSRV_PARAM_IN),
					array($DispSumNumbCloseCont,SQLSRV_PARAM_IN),
					array($DispSumNumbCloseSubData,SQLSRV_PARAM_IN),
					array($DispSumNumbFalse,SQLSRV_PARAM_IN)
					);
$execDisputesSum = sqlsrv_query($conn, $callDisputesSum, $paramsDisputesSum) or die ( print_r( sqlsrv_errors(),true));
?>