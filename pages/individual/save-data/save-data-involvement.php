<?php
/* Involment List */
if($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']<>NULL){$involment=$array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList'];}else{$involment=NULL;}
$callInvolmentsList = "{call SP_INSERT_INVOLVEMENTS_LIST(?,?,?)}";
$paramsInvolmentsList = array(
					array($mappingId, SQLSRV_PARAM_IN),
					array($pefindoId,SQLSRV_PARAM_IN),
					array($involment,SQLSRV_PARAM_IN)
					);
$execInvolmentsList = sqlsrv_query($conn, $callInvolmentsList, $paramsInvolmentsList) or die ( print_r( sqlsrv_errors(),true));

/* Involment Summary */
if($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bSummary']['bNumberOfActiveInvolvements']<>NULL){$InvolNumbActive=$array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bSummary']['bNumberOfActiveInvolvements'];}else{$InvolNumbActive=NULL;}	
if($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bSummary']['bNumberOfPastInvolvements']<>NULL){$InvolNumbPast=$array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bSummary']['bNumberOfPastInvolvements'];}else{$InvolNumbPast=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bSummary']['bTotalAmountOfActiveInvolvements']['cCurrency']<>NULL){$InvolTotAmountActiveCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bSummary']['bTotalAmountOfActiveInvolvements']['cCurrency'];}else{$InvolTotAmountActiveCur=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bSummary']['bTotalAmountOfActiveInvolvements']['cValue']<>NULL){$InvolTotAmountActiveVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bSummary']['bTotalAmountOfActiveInvolvements']['cValue'];}else{$InvolTotAmountActiveVal=NULL;}	

$callInvolmentsSum = "{call SP_INSERT_INVOLVEMENTS_SUMMARY(?,?,?,?,?,?)}";
$paramsInvolmentsSum = array(
					array($mappingId, SQLSRV_PARAM_IN),
					array($pefindoId,SQLSRV_PARAM_IN),
					array($InvolNumbActive,SQLSRV_PARAM_IN),
					array($InvolNumbPast,SQLSRV_PARAM_IN),
					array($InvolTotAmountActiveCur,SQLSRV_PARAM_IN),
					array($InvolTotAmountActiveVal,SQLSRV_PARAM_IN)
					);
$execInvolmentsSum = sqlsrv_query($conn, $callInvolmentsSum, $paramsInvolmentsSum) or die ( print_r( sqlsrv_errors(),true));
?>