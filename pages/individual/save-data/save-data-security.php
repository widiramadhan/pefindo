<?php
/* SECURITY LIST */
if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']<>NULL){$SecuritiesList=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList'];}else{$SecuritiesList=NULL;}
$callSecuritiesList = "{call SP_INSERT_SECURITIES_LIST(?,?,?)}";
$paramsSecuritiesList = array(
					array($mappingId, SQLSRV_PARAM_IN),
					array($pefindoId,SQLSRV_PARAM_IN),
					array($SecuritiesList,SQLSRV_PARAM_IN)
					);
$execSecuritiesList = sqlsrv_query($conn, $callSecuritiesList, $paramsSecuritiesList) or die ( print_r( sqlsrv_errors(),true));	

/* SECURITY SUMMARY */	
if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSummary']['bNumberOfActiveSecurities']<>NULL){$SecSumNumbActive = $array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSummary']['bNumberOfActiveSecurities'];}else{$SecSumNumbActive=NULL;}		
if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSummary']['bNumberOfPastSecurities']<>NULL){$SecSumNumbPast = $array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSummary']['bNumberOfPastSecurities'];}else{$SecSumNumbPast=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSummary']['bTotalMarketValue']['cCurrency']<>NULL){$SecSumTotMarkCur = $array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSummary']['bTotalMarketValue']['cCurrency'];}else{$SecSumTotMarkCur=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSummary']['bTotalMarketValue']['cValue']<>NULL){$SecSumTotMarkVal = $array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSummary']['bTotalMarketValue']['cValue'];}else{$SecSumTotMarkVal=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSummary']['bTotalPrincipalArrears']['cCurrency']<>NULL){$SecSumTotPrincpCur = $array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSummary']['bTotalPrincipalArrears']['cCurrency'];}else{$SecSumTotPrincpCur=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSummary']['bTotalPrincipalArrears']['cValue']<>NULL){$SecSumTotPrincpVal = $array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSummary']['bTotalPrincipalArrears']['cValue'];}else{$SecSumTotPrincpVal=NULL;}	

$callSecuritiesSum = "{call SP_INSERT_SECURITIES_SUMMARY(?,?,?,?,?,?,?,?)}";
$paramsSecuritiesSum = array(
					array($mappingId, SQLSRV_PARAM_IN),
					array($pefindoId,SQLSRV_PARAM_IN),
					array($SecSumNumbActive,SQLSRV_PARAM_IN),
					array($SecSumNumbPast,SQLSRV_PARAM_IN),
					array($SecSumTotMarkCur,SQLSRV_PARAM_IN),
					array($SecSumTotMarkVal,SQLSRV_PARAM_IN),
					array($SecSumTotPrincpCur,SQLSRV_PARAM_IN),
					array($SecSumTotPrincpVal,SQLSRV_PARAM_IN),
					);
$execSecuritiesSum = sqlsrv_query($conn, $callSecuritiesSum, $paramsSecuritiesSum) or die ( print_r( sqlsrv_errors(),true));
?>