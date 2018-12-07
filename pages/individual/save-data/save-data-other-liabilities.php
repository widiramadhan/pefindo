<?php
/* Other Liabilities List */
if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']<>NULL){$OtherLiabilitiesList = $array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList'];}else{$OtherLiabilitiesList=NULL;}

$callOtherLiabilitiesList = "{call SP_INSERT_OTHER_LIABILITIES_LIST(?,?,?)}";
$paramsOtherLiabilitiesList = array(
					array($mappingId, SQLSRV_PARAM_IN),
					array($pefindoId,SQLSRV_PARAM_IN),
					array($OtherLiabilitiesList,SQLSRV_PARAM_IN)							
					);
$execOtherLiabilitiesList = sqlsrv_query($conn, $callOtherLiabilitiesList, $paramsOtherLiabilitiesList) or die ( print_r( sqlsrv_errors(),true));

/* Other Liabilities Summary */
if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bSummary']['bNumberOfClosedAgreements']<>NULL){$OtherLiabilityNumbCloseAgrmnt=$array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bSummary']['bNumberOfClosedAgreements'];}else{$OtherLiabilityNumbCloseAgrmnt=NULL;}	
if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bSummary']['bNumberOfOpenAgreements']<>NULL){$OtherLiabilityNumbOpenAgrmnt=$array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bSummary']['bNumberOfOpenAgreements'];}else{$OtherLiabilityNumbOpenAgrmnt=NULL;}
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bSummary']['bTotalMarketValue']['cCurrency'])){
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bSummary']['bTotalMarketValue']['cCurrency']<>NULL){$OtherLiabilityTotMarCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bSummary']['bTotalMarketValue']['cCurrency'];}else{$OtherLiabilityTotMarCur=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bSummary']['bTotalMarketValue']['cValue']<>NULL){$OtherLiabilityTotMarVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bSummary']['bTotalMarketValue']['cValue'];}else{$OtherLiabilityTotMarVal=NULL;}
}else{
	$OtherLiabilityTotMarCur=NULL;
	$OtherLiabilityTotMarVal=NULL;
}
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bSummary']['bTotalPrincipalArrears']['cCurrency'])){
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bSummary']['bTotalPrincipalArrears']['cCurrency']<>NULL){$OtherLiabilityTotPrinArrCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bSummary']['bTotalPrincipalArrears']['cCurrency'];}else{$OtherLiabilityTotPrinArrCur=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bSummary']['bTotalPrincipalArrears']['cValue']<>NULL){$OtherLiabilityTotPrinArrCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bSummary']['bTotalPrincipalArrears']['cValue'];}else{$OtherLiabilityTotPrinArrCur=NULL;}		
}else{
	$OtherLiabilityTotPrinArrCur=NULL;
	$OtherLiabilityTotPrinArrCur=NULL;
}

$callOtherLiabilitiesSum = "{call SP_INSERT_OTHER_LIABILITIES_SUMMARY(?,?,?,?,?,?,?,?)}";
$paramsOtherLiabilitiesSum = array(
					array($mappingId, SQLSRV_PARAM_IN),
					array($pefindoId,SQLSRV_PARAM_IN),
					array($OtherLiabilityNumbCloseAgrmnt,SQLSRV_PARAM_IN),
					array($OtherLiabilityNumbOpenAgrmnt,SQLSRV_PARAM_IN),
					array($OtherLiabilityTotMarCur,SQLSRV_PARAM_IN),
					array($OtherLiabilityTotMarVal,SQLSRV_PARAM_IN),
					array($OtherLiabilityTotPrinArrCur,SQLSRV_PARAM_IN),
					array($OtherLiabilityTotPrinArrCur,SQLSRV_PARAM_IN)							
					);
$execOtherLiabilitiesSum = sqlsrv_query($conn, $callOtherLiabilitiesSum, $paramsOtherLiabilitiesSum) or die ( print_r( sqlsrv_errors(),true));
?>