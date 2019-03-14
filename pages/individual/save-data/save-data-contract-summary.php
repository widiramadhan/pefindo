<?php
/* CONTRACT SUMMARY DEBTOR*/
if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bDebtor']['bClosedContracts']<>NULL){$ContDebtorClosed=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bDebtor']['bClosedContracts'];}else{$ContDebtorClosed=NULL;}		
if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bDebtor']['bOpenContracts']<>NULL){$ContDebtorOpen=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bDebtor']['bOpenContracts'];}else{$ContDebtorOpen=NULL;}
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bDebtor']['bOutstandingAmountSum']['cCurrency'])){
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bDebtor']['bOutstandingAmountSum']['cCurrency']<>NULL){$ContDebtorAmountCurency=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bDebtor']['bOutstandingAmountSum']['cCurrency'];}else{$ContDebtorAmountCurency=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bDebtor']['bOutstandingAmountSum']['cValue']<>NULL){$ContDebtorAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bDebtor']['bOutstandingAmountSum']['cValue'];}else{$ContDebtorAmountVal=NULL;}
}else{
	$ContDebtorAmountCurency=NULL;
	$ContDebtorAmountVal=NULL;
}
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bDebtor']['bPastDueAmountSum']['cCurrency'])){
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bDebtor']['bPastDueAmountSum']['cCurrency']<>NULL){$ContDebtorPastDueAmountCurency=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bDebtor']['bPastDueAmountSum']['cCurrency'];}else{$ContDebtorPastDueAmountCurency=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bDebtor']['bPastDueAmountSum']['cValue']<>NULL){$ContDebtorPastDueAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bDebtor']['bPastDueAmountSum']['cValue'];}else{$ContDebtorPastDueAmountVal=NULL;}
}else{
	$ContDebtorPastDueAmountCurency=NULL;
	$ContDebtorPastDueAmountVal=NULL;
}
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bDebtor']['bTotalAmountSum']['cCurrency'])){
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bDebtor']['bTotalAmountSum']['cCurrency']<>NULL){$ContDebtorTotSumAmountCurency=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bDebtor']['bTotalAmountSum']['cCurrency'];}else{$ContDebtorTotSumAmountCurency=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bDebtor']['bTotalAmountSum']['cValue']<>NULL){$ContDebtorTotSumAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bDebtor']['bTotalAmountSum']['cValue'];}else{$ContDebtorTotSumAmountVal=NULL;}
}else{
	$ContDebtorTotSumAmountCurency=NULL;
	$ContDebtorTotSumAmountVal=NULL;
}	
$callContDebtor = "{call SP_INSERT_CONTRACT_SUM_DEBTOR(?,?,?,?,?,?,?,?,?,?)}";
$paramsContDebtor = array(
					array($mappingId, SQLSRV_PARAM_IN),
					array($pefindoId,SQLSRV_PARAM_IN),
					array($ContDebtorClosed,SQLSRV_PARAM_IN),
					array($ContDebtorOpen,SQLSRV_PARAM_IN),
					array($ContDebtorAmountCurency,SQLSRV_PARAM_IN),
					array($ContDebtorAmountVal,SQLSRV_PARAM_IN),
					array($ContDebtorPastDueAmountCurency,SQLSRV_PARAM_IN),
					array($ContDebtorPastDueAmountVal,SQLSRV_PARAM_IN),
					array($ContDebtorTotSumAmountCurency,SQLSRV_PARAM_IN),
					array($ContDebtorTotSumAmountVal,SQLSRV_PARAM_IN)
					);
$execContDebtor = sqlsrv_query($conn , $callContDebtor, $paramsContDebtor) or die (print_r( sqlsrv_errors(),true));

/* CONTRACT SUMMARY GUARANTOR */
if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bGuarantor']['bClosedContracts']<>NULL){$ContGuarantClosed=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bGuarantor']['bClosedContracts'];}else{$ContGuarantClosed=NULL;}		
if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bGuarantor']['bOpenContracts']<>NULL){$ContGuarantOpen=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bGuarantor']['bOpenContracts'];}else{$ContGuarantOpen=NULL;}
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bGuarantor']['bOutstandingAmountSum']['cCurrency'])){
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bGuarantor']['bOutstandingAmountSum']['cCurrency']<>NULL){$ContGuarantAmountCurency=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bGuarantor']['bOutstandingAmountSum']['cCurrency'];}else{$ContGuarantAmountCurency=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bGuarantor']['bOutstandingAmountSum']['cValue']<>NULL){$ContGuarantAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bGuarantor']['bOutstandingAmountSum']['cValue'];}else{$ContGuarantAmountVal=NULL;}
}else{
	$ContGuarantAmountCurency=NULL;
	$ContGuarantAmountVal=NULL;
}
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bGuarantor']['bPastDueAmountSum']['cCurrency'])){
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bGuarantor']['bPastDueAmountSum']['cCurrency']<>NULL){$ContGuarantPastDueAmountCurency=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bGuarantor']['bPastDueAmountSum']['cCurrency'];}else{$ContGuarantPastDueAmountCurency=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bGuarantor']['bPastDueAmountSum']['cValue']<>NULL){$ContGuarantPastDueAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bGuarantor']['bPastDueAmountSum']['cValue'];}else{$ContGuarantPastDueAmountVal=NULL;}
}else{
	$ContGuarantPastDueAmountCurency=NULL;
	$ContGuarantPastDueAmountVal=NULL;
}
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bGuarantor']['bTotalAmountSum']['cCurrency'])){
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bGuarantor']['bTotalAmountSum']['cCurrency']<>NULL){$ContGuarantTotSumAmountCurency=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bGuarantor']['bTotalAmountSum']['cCurrency'];}else{$ContGuarantTotSumAmountCurency=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bGuarantor']['bTotalAmountSum']['cValue']<>NULL){$ContGuarantTotSumAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bGuarantor']['bTotalAmountSum']['cValue'];}else{$ContGuarantTotSumAmountVal=NULL;}
}else{
	$ContGuarantTotSumAmountCurency=NULL;
	$ContGuarantTotSumAmountVal=NULL;
}

$callContGuarantor = "{call SP_INSERT_CONTRACT_SUM_GUARANTOR(?,?,?,?,?,?,?,?,?,?)}";
$paramsContGuarantor = array(
					array($mappingId, SQLSRV_PARAM_IN),
					array($pefindoId,SQLSRV_PARAM_IN),
					array($ContGuarantClosed,SQLSRV_PARAM_IN),
					array($ContGuarantOpen,SQLSRV_PARAM_IN),
					array($ContGuarantAmountCurency,SQLSRV_PARAM_IN),
					array($ContGuarantAmountVal,SQLSRV_PARAM_IN),
					array($ContGuarantPastDueAmountCurency,SQLSRV_PARAM_IN),
					array($ContGuarantPastDueAmountVal,SQLSRV_PARAM_IN),
					array($ContGuarantTotSumAmountCurency,SQLSRV_PARAM_IN),
					array($ContGuarantTotSumAmountVal,SQLSRV_PARAM_IN)
					);
$execContGuarantor = sqlsrv_query($conn , $callContGuarantor, $paramsContGuarantor) or die (print_r( sqlsrv_errors(),true));

/*CONTRACT OVERALL*/
if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bOverall']['bLastDelinquency90PlusDays']<>NULL){$ContOveralldeleq=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bOverall']['bLastDelinquency90PlusDays'];}else{$ContOveralldeleq=NULL;}		
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bOverall']['bWorstPastDueAmount']['cCurrency'])){
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bOverall']['bWorstPastDueAmount']['cCurrency']<>NULL){$ContOveralldueAmountCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bOverall']['bWorstPastDueAmount']['cCurrency'];}else{$ContOveralldueAmountCur=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bOverall']['bWorstPastDueAmount']['cValue']<>NULL){$ContOveralldueAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bOverall']['bWorstPastDueAmount']['cValue'];}else{$ContOveralldueAmountVal=NULL;}
}else{
	$ContOveralldueAmountCur=NULL;
	$ContOveralldueAmountVal=NULL;
}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bOverall']['bWorstPastDueDays']<>NULL){$ContOveralldueDays=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bOverall']['bWorstPastDueDays'];}else{$ContOveralldueDays=NULL;}		

$callContOverall = "{call SP_INSERT_CONTRACT_SUM_OVERALL(?,?,?,?,?,?)}";
$paramsContOverall = array(
						array($mappingId, SQLSRV_PARAM_IN),
						array($pefindoId,SQLSRV_PARAM_IN),
						array($ContOveralldeleq,SQLSRV_PARAM_IN),
						array($ContOveralldueAmountCur,SQLSRV_PARAM_IN),
						array($ContOveralldueAmountVal,SQLSRV_PARAM_IN),
						array($ContOveralldueDays,SQLSRV_PARAM_IN)
					);
$execContOverall = sqlsrv_query($conn , $callContOverall, $paramsContOverall) or die (print_r( sqlsrv_errors(),true));

/*CONTRACT PAYMENT CALENDER LIST */
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bPaymentCalendarList']['bPaymentCalendar']['bContractsSubmitted'])){
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bPaymentCalendarList']['bPaymentCalendar']['bContractsSubmitted']<>NULL){$ContPaymentSubmited=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bPaymentCalendarList']['bPaymentCalendar']['bContractsSubmitted'];}else{$ContPaymentSubmited=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bPaymentCalendarList']['bPaymentCalendar']['bDate']<>NULL){$ContPaymentDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bPaymentCalendarList']['bPaymentCalendar']['bDate'];}else{$ContPaymentDate=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bPaymentCalendarList']['bPaymentCalendar']['bNegativeStatusOfContract']<>NULL){$ContPaymentNegativeStat=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bPaymentCalendarList']['bPaymentCalendar']['bNegativeStatusOfContract'];}else{$ContPaymentNegativeStat=NULL;}
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bPaymentCalendarList']['bPaymentCalendar']['bOutstandingAmount']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bPaymentCalendarList']['bPaymentCalendar']['bOutstandingAmount']['cCurrency']<>NULL){$ContPaymentStandAmountCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bPaymentCalendarList']['bPaymentCalendar']['bOutstandingAmount']['cCurrency'];}else{$ContPaymentStandAmountCur=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bPaymentCalendarList']['bPaymentCalendar']['bOutstandingAmount']['cValue']<>NULL){$ContPaymentStandAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bPaymentCalendarList']['bPaymentCalendar']['bOutstandingAmount']['cValue'];}else{$ContPaymentStandAmountVal=NULL;}
	}else{
		$ContPaymentStandAmountCur=NULL;
		$ContPaymentStandAmountVal=NULL;
	}
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bPaymentCalendarList']['bPaymentCalendar']['bPastDueAmount']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bPaymentCalendarList']['bPaymentCalendar']['bPastDueAmount']['cCurrency']<>NULL){$ContPaymentPastDueAmountCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bPaymentCalendarList']['bPaymentCalendar']['bPastDueAmount']['cCurrency'];}else{$ContPaymentPastDueAmountCur=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bPaymentCalendarList']['bPaymentCalendar']['bPastDueAmount']['cValue']<>NULL){$ContPaymentPastDueAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bPaymentCalendarList']['bPaymentCalendar']['bPastDueAmount']['cValue'];}else{$ContPaymentPastDueAmountVal=NULL;}
	}else{
		$ContPaymentPastDueAmountCur=NULL;
		$ContPaymentPastDueAmountVal=NULL;
	}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bPaymentCalendarList']['bPaymentCalendar']['bPastDueDays']<>NULL){$ContPaymentPastDueDays=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bPaymentCalendarList']['bPaymentCalendar']['bPastDueDays'];}else{$ContPaymentPastDueDays=NULL;}
	
	$callContPaymentList = "{call SP_INSERT_CONTRACT_SUM_PAYMENT_LIST(?,?,?,?,?,?,?,?,?,?)}";
	$paramsContPaymentList = array(
						array($mappingId, SQLSRV_PARAM_IN),
						array($pefindoId,SQLSRV_PARAM_IN),
						array($ContPaymentSubmited,SQLSRV_PARAM_IN),
						array($ContPaymentDate,SQLSRV_PARAM_IN),
						array($ContPaymentNegativeStat,SQLSRV_PARAM_IN),
						array($ContPaymentStandAmountCur,SQLSRV_PARAM_IN),
						array($ContPaymentStandAmountVal,SQLSRV_PARAM_IN),
						array($ContPaymentPastDueAmountCur,SQLSRV_PARAM_IN),
						array($ContPaymentPastDueAmountVal,SQLSRV_PARAM_IN),
						array($ContPaymentPastDueDays,SQLSRV_PARAM_IN)
					);
	$execContPaymentList = sqlsrv_query($conn , $callContPaymentList, $paramsContPaymentList) or die (print_r( sqlsrv_errors(),true));			
}else{
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bPaymentCalendarList']['bPaymentCalendar'])){
		foreach($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bPaymentCalendarList']['bPaymentCalendar'] as $itemContPayment){
			if($itemContPayment['bContractsSubmitted']<>NULL){$ContPaymentSubmited=$itemContPayment['bContractsSubmitted'];}else{$ContPaymentSubmited=NULL;}
			if($itemContPayment['bDate']<>NULL){$ContPaymentDate=$itemContPayment['bDate'];}else{$ContPaymentDate=NULL;}		
			if($itemContPayment['bNegativeStatusOfContract']<>NULL){$ContPaymentNegativeStat=$itemContPayment['bNegativeStatusOfContract'];}else{$ContPaymentNegativeStat=NULL;}				
			if(isset($itemContPayment['bOutstandingAmount']['cCurrency'])){
				if($itemContPayment['bOutstandingAmount']['cCurrency']<>NULL){$ContPaymentStandAmountCur=$itemContPayment['bOutstandingAmount']['cCurrency'];}else{$ContPaymentStandAmountCur=NULL;}			
				if($itemContPayment['bOutstandingAmount']['cValue']<>NULL){$ContPaymentStandAmountVal=$itemContPayment['bOutstandingAmount']['cValue'];}else{$ContPaymentStandAmountVal=NULL;}				
			}else{
				$ContPaymentStandAmountCur=NULL;
				$ContPaymentStandAmountVal=NULL;
			}
			if(isset($itemContPayment['bPastDueAmount']['cCurrency'])){
				if($itemContPayment['bPastDueAmount']['cCurrency']<>NULL){$ContPaymentPastDueAmountCur=$itemContPayment['bPastDueAmount']['cCurrency'];}else{$ContPaymentPastDueAmountCur=NULL;}				
				if($itemContPayment['bPastDueAmount']['cValue']<>NULL){$ContPaymentPastDueAmountVal=$itemContPayment['bPastDueAmount']['cValue'];}else{$ContPaymentPastDueAmountVal=NULL;}				
			}else{
				$ContPaymentPastDueAmountCur=NULL;
				$ContPaymentPastDueAmountVal=NULL;
			}
			if($itemContPayment['bPastDueDays']<>NULL){$ContPaymentPastDueDays=$itemContPayment['bPastDueDays'];}else{$ContPaymentPastDueDays=NULL;}
			
			$callContPaymentList = "{call SP_INSERT_CONTRACT_SUM_PAYMENT_LIST(?,?,?,?,?,?,?,?,?,?)}";
			$paramsContPaymentList = array(
								array($mappingId, SQLSRV_PARAM_IN),
								array($pefindoId,SQLSRV_PARAM_IN),
								array($ContPaymentSubmited,SQLSRV_PARAM_IN),
								array($ContPaymentDate,SQLSRV_PARAM_IN),
								array($ContPaymentNegativeStat,SQLSRV_PARAM_IN),
								array($ContPaymentStandAmountCur,SQLSRV_PARAM_IN),
								array($ContPaymentStandAmountVal,SQLSRV_PARAM_IN),
								array($ContPaymentPastDueAmountCur,SQLSRV_PARAM_IN),
								array($ContPaymentPastDueAmountVal,SQLSRV_PARAM_IN),
								array($ContPaymentPastDueDays,SQLSRV_PARAM_IN)
							);
			$execContPaymentList = sqlsrv_query($conn , $callContPaymentList, $paramsContPaymentList) or die (print_r( sqlsrv_errors(),true	));		
		}
	}
}

/*CONTRACT SECTOR LIST */
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bDebtorClosedContracts'])){
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bDebtorClosedContracts']<>NULL){$ContSectorDebClose=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bDebtorClosedContracts'];}else{$ContSectorDebClose=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bDebtorOpenContracts']<>NULL){$ContSectorDebOpen=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bDebtorOpenContracts'];}else{$ContSectorDebOpen=NULL;}
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bDebtorOutstandingAmountSum']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bDebtorOutstandingAmountSum']['cCurrency']<>NULL){$ContSectorDebStandAmountCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bDebtorOutstandingAmountSum']['cCurrency'];}else{$ContSectorDebStandAmountCur=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bDebtorOutstandingAmountSum']['cValue']<>NULL){$ContSectorDebStandAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bDebtorOutstandingAmountSum']['cValue'];}else{$ContSectorDebStandAmountVal=NULL;}
	}else{
		$ContSectorDebStandAmountCur=NULL;
		$ContSectorDebStandAmountVal=NULL;
	}
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bDebtorPastDueAmountSum']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bDebtorPastDueAmountSum']['cCurrency']<>NULL){$ContSectorDebPastDueAmountCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bDebtorPastDueAmountSum']['cCurrency'];}else{$ContSectorDebPastDueAmountCur=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bDebtorPastDueAmountSum']['cValue']<>NULL){$ContSectorDebPastDueAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bDebtorPastDueAmountSum']['cValue'];}else{$ContSectorDebPastDueAmountVal=NULL;}
	}else{
		$ContSectorDebPastDueAmountCur=NULL;
		$ContSectorDebPastDueAmountVal=NULL;
	}
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bDebtorTotalAmountSum']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bDebtorTotalAmountSum']['cCurrency']<>NULL){$ContSectorDebTotSumAmountCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bDebtorTotalAmountSum']['cCurrency'];}else{$ContSectorDebTotSumAmountCur=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bDebtorTotalAmountSum']['cValue']<>NULL){$ContSectorDebTotSumAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bDebtorTotalAmountSum']['cValue'];}else{$ContSectorDebTotSumAmountVal=NULL;}
	}else{
		$ContSectorDebTotSumAmountCur=NULL;
		$ContSectorDebTotSumAmountVal=NULL;
	}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bGuarantorClosedContracts']<>NULL){$ContSectorGuarantCloseCont=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bGuarantorClosedContracts'];}else{$ContSectorGuarantCloseCont=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bGuarantorOpenContracts']<>NULL){$ContSectorGuarantOpenCont=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bGuarantorOpenContracts'];}else{$ContSectorGuarantOpenCont=NULL;}
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bGuarantorOutstandingAmountSum']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bGuarantorOutstandingAmountSum']['cCurrency']<>NULL){$ContSectorGuarantStandAmountCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bDebtorPastDueAmountSum']['cCurrency'];}else{$ContSectorGuarantStandAmountCur=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bGuarantorOutstandingAmountSum']['cValue']<>NULL){$ContSectorGuarantStandAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bGuarantorOutstandingAmountSum']['cValue'];}else{$ContSectorGuarantStandAmountVal=NULL;}
	}else{
		$ContSectorGuarantStandAmountCur=NULL;
		$ContSectorGuarantStandAmountVal=NULL;
	}
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bGuarantorPastDueAmountSum']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bGuarantorPastDueAmountSum']['cCurrency']<>NULL){$ContSectorGuarantPastDueCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bGuarantorPastDueAmountSum']['cCurrency'];}else{$ContSectorGuarantPastDueCur=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bGuarantorPastDueAmountSum']['cValue']<>NULL){$ContSectorGuarantPastDueVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bGuarantorPastDueAmountSum']['cValue'];}else{$ContSectorGuarantPastDueVal=NULL;}
	}else{
		$ContSectorGuarantPastDueCur=NULL;
		$ContSectorGuarantPastDueVal=NULL;
	}
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bGuarantorTotalAmountSum']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bGuarantorTotalAmountSum']['cCurrency']<>NULL){$ContSectorGuarantTotSumCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bGuarantorTotalAmountSum']['cCurrency'];}else{$ContSectorGuarantTotSumCur=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bGuarantorTotalAmountSum']['cValue']<>NULL){$ContSectorGuarantTotSumVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bGuarantorTotalAmountSum']['cValue'];}else{$ContSectorGuarantTotSumVal=NULL;}
	}else{
		$ContSectorGuarantTotSumCur=NULL;
		$ContSectorGuarantTotSumVal=NULL;
	}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bSector']<>NULL){$ContSectorSec=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo']['bSector'];}else{$ContSectorSec=NULL;}
	
	$callContSector = "{call SP_INSERT_CONTRACTS_SUM_SECTOR_INFO(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramsContSector = array(
							array($mappingId, SQLSRV_PARAM_IN),
							array($pefindoId,SQLSRV_PARAM_IN),
							array($ContSectorDebClose,SQLSRV_PARAM_IN),
							array($ContSectorDebOpen,SQLSRV_PARAM_IN),
							array($ContSectorDebStandAmountCur,SQLSRV_PARAM_IN),
							array($ContSectorDebStandAmountVal,SQLSRV_PARAM_IN),
							array($ContSectorDebPastDueAmountCur,SQLSRV_PARAM_IN),
							array($ContSectorDebPastDueAmountVal,SQLSRV_PARAM_IN),
							array($ContSectorDebTotSumAmountCur,SQLSRV_PARAM_IN),
							array($ContSectorDebTotSumAmountVal,SQLSRV_PARAM_IN),
							array($ContSectorGuarantCloseCont,SQLSRV_PARAM_IN),
							array($ContSectorGuarantOpenCont,SQLSRV_PARAM_IN),
							array($ContSectorGuarantStandAmountCur,SQLSRV_PARAM_IN),
							array($ContSectorGuarantStandAmountVal,SQLSRV_PARAM_IN),
							array($ContSectorGuarantPastDueCur,SQLSRV_PARAM_IN),
							array($ContSectorGuarantPastDueVal,SQLSRV_PARAM_IN),
							array($ContSectorGuarantTotSumCur,SQLSRV_PARAM_IN),
							array($ContSectorGuarantTotSumVal,SQLSRV_PARAM_IN),
							array($ContSectorSec,SQLSRV_PARAM_IN)
						);
	$execContSector = sqlsrv_query($conn , $callContSector, $paramsContSector) or die (print_r( sqlsrv_errors(),true	));		
}else{
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo'])){
		foreach($array['GetCustomReportResponse']['GetCustomReportResult']['aContractSummary']['bSectorInfoList']['bSectorInfo'] as $itemConSector){
			if($itemConSector['bDebtorClosedContracts']<>NULL){$ContSectorDebClose=$itemConSector['bDebtorClosedContracts'];}else{$ContSectorDebClose=NULL;}
			if($itemConSector['bDebtorOpenContracts']<>NULL){$ContSectorDebOpen=$itemConSector['bDebtorOpenContracts'];}else{$ContSectorDebOpen=NULL;}
			if(isset($itemConSector['bDebtorOutstandingAmountSum']['cCurrency'])){
				if($itemConSector['bDebtorOutstandingAmountSum']['cCurrency']<>NULL){$ContSectorDebStandAmountCur=$itemConSector['bDebtorOutstandingAmountSum']['cCurrency'];}else{$ContSectorDebStandAmountCur=NULL;}
				if($itemConSector['bDebtorOutstandingAmountSum']['cValue']<>NULL){$ContSectorDebStandAmountVal=$itemConSector['bDebtorOutstandingAmountSum']['cValue'];}else{$ContSectorDebStandAmountVal=NULL;}
			}else{
				$ContSectorDebStandAmountCur=NULL;
				$ContSectorDebStandAmountVal=NULL;
			}
			if(isset($itemConSector['bDebtorPastDueAmountSum']['cCurrency'])){
				if($itemConSector['bDebtorPastDueAmountSum']['cCurrency']<>NULL){$ContSectorDebPastDueAmountCur=$itemConSector['bDebtorPastDueAmountSum']['cCurrency'];}else{$ContSectorDebPastDueAmountCur=NULL;}				
				if($itemConSector['bDebtorPastDueAmountSum']['cValue']<>NULL){$ContSectorDebPastDueAmountVal=$itemConSector['bDebtorPastDueAmountSum']['cValue'];}else{$ContSectorDebPastDueAmountVal=NULL;}				
			}else{
				$ContSectorDebPastDueAmountCur=NULL;
				$ContSectorDebPastDueAmountVal=NULL;
			}
			if(isset($itemConSector['bDebtorTotalAmountSum']['cCurrency'])){
				if($itemConSector['bDebtorTotalAmountSum']['cCurrency']<>NULL){$ContSectorDebTotSumAmountCur=$itemConSector['bDebtorTotalAmountSum']['cCurrency'];}else{$ContSectorDebTotSumAmountCur=NULL;}				
				if($itemConSector['bDebtorTotalAmountSum']['cValue']<>NULL){$ContSectorDebTotSumAmountVal=$itemConSector['bDebtorTotalAmountSum']['cValue'];}else{$ContSectorDebTotSumAmountVal=NULL;}				
			}else{
				$ContSectorDebTotSumAmountCur=NULL;
				$ContSectorDebTotSumAmountVal=NULL;
			}
			if($itemConSector['bGuarantorClosedContracts']<>NULL){$ContSectorGuarantCloseCont=$itemConSector['bGuarantorClosedContracts'];}else{$ContSectorGuarantCloseCont=NULL;}				
			if($itemConSector['bGuarantorOpenContracts']<>NULL){$ContSectorGuarantOpenCont=$itemConSector['bGuarantorOpenContracts'];}else{$ContSectorGuarantOpenCont=NULL;}				
			if(isset($itemConSector['bGuarantorOutstandingAmountSum']['cCurrency'])){
				if($itemConSector['bGuarantorOutstandingAmountSum']['cCurrency']<>NULL){$ContSectorGuarantStandAmountCur=$itemConSector['bDebtorPastDueAmountSum']['cCurrency'];}else{$ContSectorGuarantStandAmountCur=NULL;}			
				if($itemConSector['bGuarantorOutstandingAmountSum']['cValue']<>NULL){$ContSectorGuarantStandAmountVal=$itemConSector['bGuarantorOutstandingAmountSum']['cValue'];}else{$ContSectorGuarantStandAmountVal=NULL;}		
			}else{
				$ContSectorGuarantStandAmountCur=NULL;
				$ContSectorGuarantStandAmountVal=NULL;
			}
			if(isset($itemConSector['bGuarantorPastDueAmountSum']['cCurrency'])){
				if($itemConSector['bGuarantorPastDueAmountSum']['cCurrency']<>NULL){$ContSectorGuarantPastDueCur=$itemConSector['bGuarantorPastDueAmountSum']['cCurrency'];}else{$ContSectorGuarantPastDueCur=NULL;}		
				if($itemConSector['bGuarantorPastDueAmountSum']['cValue']<>NULL){$ContSectorGuarantPastDueVal=$itemConSector['bGuarantorPastDueAmountSum']['cValue'];}else{$ContSectorGuarantPastDueVal=NULL;}				
			}else{
				$ContSectorGuarantPastDueCur=NULL;
				$ContSectorGuarantPastDueVal=NULL;
			}
			if(isset($itemConSector['bGuarantorTotalAmountSum']['cCurrency'])){
				if($itemConSector['bGuarantorTotalAmountSum']['cCurrency']<>NULL){$ContSectorGuarantTotSumCur=$itemConSector['bGuarantorTotalAmountSum']['cCurrency'];}else{$ContSectorGuarantTotSumCur=NULL;}				
				if($itemConSector['bGuarantorTotalAmountSum']['cValue']<>NULL){$ContSectorGuarantTotSumVal=$itemConSector['bGuarantorTotalAmountSum']['cValue'];}else{$ContSectorGuarantTotSumVal=NULL;}				
			}else{
				$ContSectorGuarantTotSumCur=NULL;
				$ContSectorGuarantTotSumVal=NULL;
			}
			if($itemConSector['bSector']<>NULL){$ContSectorSec=$itemConSector['bSector'];}else{$ContSectorSec=NULL;}
			
			$callContSector = "{call SP_INSERT_CONTRACTS_SUM_SECTOR_INFO(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
			$paramsContSector = array(
									array($mappingId, SQLSRV_PARAM_IN),
									array($pefindoId,SQLSRV_PARAM_IN),
									array($ContSectorDebClose,SQLSRV_PARAM_IN),
									array($ContSectorDebOpen,SQLSRV_PARAM_IN),
									array($ContSectorDebStandAmountCur,SQLSRV_PARAM_IN),
									array($ContSectorDebStandAmountVal,SQLSRV_PARAM_IN),
									array($ContSectorDebPastDueAmountCur,SQLSRV_PARAM_IN),
									array($ContSectorDebPastDueAmountVal,SQLSRV_PARAM_IN),
									array($ContSectorDebTotSumAmountCur,SQLSRV_PARAM_IN),
									array($ContSectorDebTotSumAmountVal,SQLSRV_PARAM_IN),
									array($ContSectorGuarantCloseCont,SQLSRV_PARAM_IN),
									array($ContSectorGuarantOpenCont,SQLSRV_PARAM_IN),
									array($ContSectorGuarantStandAmountCur,SQLSRV_PARAM_IN),
									array($ContSectorGuarantStandAmountVal,SQLSRV_PARAM_IN),
									array($ContSectorGuarantPastDueCur,SQLSRV_PARAM_IN),
									array($ContSectorGuarantPastDueVal,SQLSRV_PARAM_IN),
									array($ContSectorGuarantTotSumCur,SQLSRV_PARAM_IN),
									array($ContSectorGuarantTotSumVal,SQLSRV_PARAM_IN),
									array($ContSectorSec,SQLSRV_PARAM_IN)
								);
			$execContSector = sqlsrv_query($conn , $callContSector, $paramsContSector) or die (print_r( sqlsrv_errors(),true ));		
		}
	}
}	
?>