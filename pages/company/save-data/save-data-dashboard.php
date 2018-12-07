<?php
//Dashboard Company//

if($array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bCIQ']['bFraudAlerts']<>NULL){$DashCIQFraudAlt=$array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bCIQ']['bFraudAlerts'];}else{$DashCIQFraudAlt=NULL;}	
if($array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bCIQ']['bFraudAlertsThirdParty']<>NULL){$DashCIQFraudAltThirdParty=$array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bCIQ']['bFraudAlertsThirdParty'];}else{$DashCIQFraudAltThirdParty=NULL;}
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bCollaterals']['bHighestCollateralValue']['cCurrency'])){
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bCollaterals']['bHighestCollateralValue']['cCurrency']<>NULL){$DashCollCurency=$array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bCollaterals']['bHighestCollateralValue']['cCurrency'];}else{$DashCollCurency=NULL;}	
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bCollaterals']['bHighestCollateralValue']['cValue']<>NULL){$DashCollVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bCollaterals']['bHighestCollateralValue']['cValue'];}else{$DashCollVal=NULL;}
}else{
	$DashCollCurency=NULL;
	$DashCollVal=NULL;
}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bCollaterals']['bHighestCollateralValueType']<>NULL){$DashCollValType=$array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bCollaterals']['bHighestCollateralValueType'];}else{$DashCollValType=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bCollaterals']['bNumberOfCollaterals']<>NULL){$DashCollNumbOfCollat=$array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bCollaterals']['bNumberOfCollaterals'];}else{$DashCollNumbOfCollat=NULL;}
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bCollaterals']['bTotalCollateralValue']['cCurrency'])){
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bCollaterals']['bTotalCollateralValue']['cCurrency']<>NULL){$DashCollTotValTypeCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bCollaterals']['bTotalCollateralValue']['cCurrency'];}else{$DashCollTotValTypeCur=NULL;}	
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bCollaterals']['bTotalCollateralValue']['cValue']<>NULL){$DashCollTotValTypeVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bCollaterals']['bTotalCollateralValue']['cValue'];}else{$DashCollTotValTypeVal=NULL;}			
}else{
	$DashCollTotValTypeCur=NULL;
	$DashCollTotValTypeVal=NULL;
}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bDisputes']['bActiveContractDisputes']<>NULL){$DashDispCont=$array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bDisputes']['bActiveContractDisputes'];}else{$DashDispCont=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bDisputes']['bFalseDisputes']<>NULL){$DashDispFalse=$array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bDisputes']['bFalseDisputes'];}else{$DashDispFalse=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bDisputes']['bNumberOfCourtRegisteredDisputes']<>NULL){$DashDispNumbRegist=$array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bDisputes']['bNumberOfCourtRegisteredDisputes'];}else{$DashDispNumbRegist=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bInquiries']['bInquiriesForLast12Months']<>NULL){$DashInqLastMonths = $array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bInquiries']['bInquiriesForLast12Months'];}else{$DashInqLastMonths=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bInquiries']['bSubscribersInLast12Months']<>NULL){$DashInqSubsLastMonths = $array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bInquiries']['bSubscribersInLast12Months'];}else{$DashInqSubsLastMonths=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bInvolvements']['bNumberOfActiveInvolvements']<>NULL){$DashNumbActiveInvolvement = $array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bInvolvements']['bNumberOfActiveInvolvements'];}else{$DashNumbActiveInvolvement=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bOtherLiabilities']['bNumberOfOpenAgreements']<>NULL){$DashNumbOpenAgreement = $array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bOtherLiabilities']['bNumberOfOpenAgreements'];}else{$DashNumbOpenAgreement=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bPaymentsProfile']['bNumberOfDifferentSubscribers']<>NULL){$DashNumbDiffSubs = $array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bPaymentsProfile']['bNumberOfDifferentSubscribers'];}else{$DashNumbDiffSubs=NULL;}
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bPaymentsProfile']['bPastDueAmountSum']['cCurrency'])){
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bPaymentsProfile']['bPastDueAmountSum']['cCurrency']<>NULL){$DashPastDueAmountSum = $array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bPaymentsProfile']['bPastDueAmountSum']['cCurrency'];}else{$DashPastDueAmountSum=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bPaymentsProfile']['bPastDueAmountSum']['cValue']<>NULL){$DashPastDueAmountSumVal = $array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bPaymentsProfile']['bPastDueAmountSum']['cValue'];}else{$DashPastDueAmountSumVal=NULL;}
}else{
	$DashPastDueAmountSum=NULL;
	$DashPastDueAmountSumVal=NULL;
}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bPaymentsProfile']['bWorstPastDueDaysCurrent']<>NULL){$DashWorstPastDueDaysCurrent = $array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bPaymentsProfile']['bWorstPastDueDaysCurrent'];}else{$DashWorstPastDueDaysCurrent=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bPaymentsProfile']['bWorstPastDueDaysForLast12Months']<>NULL){$DashWorstPastDueDaysForLast12Months = $array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bPaymentsProfile']['bWorstPastDueDaysForLast12Months'];}else{$DashWorstPastDueDaysForLast12Months=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bRelations']['bNumberOfInvolvements']<>NULL){$DashNumberOfInvolvements=$array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bRelations']['bNumberOfInvolvements'];}else{$DashNumberOfInvolvements=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bRelations']['bNumberOfRelations']<>NULL){$DashNumberOfRelations=$array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bRelations']['bNumberOfRelations'];}else{$DashNumberOfRelations=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bSecurities']['bNumberOfActiveSecurities']<>NULL){$DashNumberOfActiveSecurities=$array['GetCustomReportResponse']['GetCustomReportResult']['aDashboard']['bSecurities']['bNumberOfActiveSecurities'];}else{$DashNumberOfActiveSecurities=NULL;}

$callDashboard = "{call SP_INSERT_DASHBOARD_COMPANY(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
$paramsDashboard = array(
				array($mappingId, SQLSRV_PARAM_IN),
				array($pefindoId, SQLSRV_PARAM_IN),
				array($DashCIQFraudAlt, SQLSRV_PARAM_IN),
				array($DashCIQFraudAltThirdParty, SQLSRV_PARAM_IN),
				array($DashCollCurency, SQLSRV_PARAM_IN),
				array($DashCollVal, SQLSRV_PARAM_IN),
				array($DashCollValType, SQLSRV_PARAM_IN),
				array($DashCollNumbOfCollat, SQLSRV_PARAM_IN),
				array($DashCollTotValTypeCur, SQLSRV_PARAM_IN),
				array($DashCollTotValTypeVal, SQLSRV_PARAM_IN),
				array($DashDispCont, SQLSRV_PARAM_IN),
				array($DashDispFalse, SQLSRV_PARAM_IN),
				array($DashDispNumbRegist, SQLSRV_PARAM_IN),
				array($DashInqLastMonths, SQLSRV_PARAM_IN),
				array($DashInqSubsLastMonths, SQLSRV_PARAM_IN),
				array($DashNumbActiveInvolvement, SQLSRV_PARAM_IN),
				array($DashNumbOpenAgreement, SQLSRV_PARAM_IN),
				array($DashNumbDiffSubs, SQLSRV_PARAM_IN),
				array($DashPastDueAmountSum, SQLSRV_PARAM_IN),
				array($DashPastDueAmountSumVal, SQLSRV_PARAM_IN),
				array($DashWorstPastDueDaysCurrent, SQLSRV_PARAM_IN),
				array($DashWorstPastDueDaysForLast12Months, SQLSRV_PARAM_IN),
				array($DashNumberOfInvolvements, SQLSRV_PARAM_IN),
				array($DashNumberOfRelations, SQLSRV_PARAM_IN),
				array($DashNumberOfActiveSecurities, SQLSRV_PARAM_IN)
			);
$execDashboard = sqlsrv_query( $conn, $callDashboard, $paramsDashboard) or die( print_r( sqlsrv_errors(), true));
?>