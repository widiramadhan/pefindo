<?php
/* Other Liabilities List Company*/
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bBranch'])){
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bBranch']<>NULL){$OtherLiabilitiesBranch = $array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bBranch'];}else{$OtherLiabilitiesBranch=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bConditionDate']<>NULL){$OtherLiabilitiesCondDate = $array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bConditionDate'];}else{$OtherLiabilitiesCondDate=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bContractCode']<>NULL){$OtherLiabilitiesContractDate = $array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bContractCode'];}else{$OtherLiabilitiesContractDate=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bContractStatus']<>NULL){$OtherLiabilitiesContractStat = $array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bContractStatus'];}else{$OtherLiabilitiesContractStat=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bContractType']<>NULL){$OtherLiabilitiesContractType = $array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bContractType'];}else{$OtherLiabilitiesContractType=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bCreditor']<>NULL){$OtherLiabilitiesCreditor = $array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bCreditor'];}else{$OtherLiabilitiesCreditor=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bCurrencyOfContract']<>NULL){$OtherLiabilitiesCurContract = $array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bCurrencyOfContract'];}else{$OtherLiabilitiesCurContract=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bDefaultDate']<>NULL){$OtherLiabilitiesDefaultDate = $array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bDefaultDate'];}else{$OtherLiabilitiesDefaultDate=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bDefaultReason']<>NULL){$OtherLiabilitiesDefaultReason = $array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bDefaultReason'];}else{$OtherLiabilitiesDefaultReason=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bDefaultReasonDescription']<>NULL){$OtherLiabilitiesDefaultReasonDesc = $array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bDefaultReasonDescription'];}else{$OtherLiabilitiesDefaultReasonDesc=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bDelinquencyDate']<>NULL){$OtherLiabilitiesDeliqDate = $array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bDelinquencyDate'];}else{$OtherLiabilitiesDeliqDate=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bDescription']<>NULL){$OtherLiabilitiesDesc= $array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bDescription'];}else{$OtherLiabilitiesDesc=NULL;}
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bInitialTotalAmount']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bInitialTotalAmount']['cCurrency']<>NULL){$OtherLiabilitiesInitTotAmountCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bInitialTotalAmount']['cCurrency'];}else{$OtherLiabilitiesInitTotAmountCur=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bInitialTotalAmount']['cValue']<>NULL){$OtherLiabilitiesInitTotAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bInitialTotalAmount']['cValue'];}else{$OtherLiabilitiesInitTotAmountVal=NULL;}
	}else{
		$OtherLiabilitiesInitTotAmountCur=NULL;
		$OtherLiabilitiesInitTotAmountVal=NULL;
	}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bInterestRate']<>NULL){$OtherLiabilitiesInterestRate= $array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bInterestRate'];}else{$OtherLiabilitiesInterestRate=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bIssueDate']<>NULL){$OtherLiabilitiesIssueDate= $array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bIssueDate'];}else{$OtherLiabilitiesIssueDate=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bLastUpdate']<>NULL){$OtherLiabilitiesLastUpt= $array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bLastUpdate'];}else{$OtherLiabilitiesLastUpt=NULL;}
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bMarketValue']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bMarketValue']['cCurrency']<>NULL){$OtherLiabilitiesMarketValCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bMarketValue']['cCurrency'];}else{$OtherLiabilitiesMarketValCur=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bMarketValue']['cValue']<>NULL){$OtherLiabilitiesMarketValVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bMarketValue']['cValue'];}else{$OtherLiabilitiesMarketValVal=NULL;}
	}else{
		$OtherLiabilitiesMarketValCur=NULL;
		$OtherLiabilitiesMarketValVal=NULL;
	}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bMaturityDate']<>NULL){$OtherLiabilitiesMaturyDate= $array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bMaturityDate'];}else{$OtherLiabilitiesMaturyDate=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bNegativeStatus']<>NULL){$OtherLiabilitiesNegativeStat= $array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bNegativeStatus'];}else{$OtherLiabilitiesNegativeStat=NULL;}
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bOutstandingAmount']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bOutstandingAmount']['cCurrency']<>NULL){$OtherLiabilitiesOutStandAmountCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bOutstandingAmount']['cCurrency'];}else{$OtherLiabilitiesOutStandAmountCur=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bOutstandingAmount']['cValue']<>NULL){$OtherLiabilitiesOutStandAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bOutstandingAmount']['cValue'];}else{$OtherLiabilitiesOutStandAmountVal=NULL;}
	}else{
		$OtherLiabilitiesOutStandAmountCur=NULL;
		$OtherLiabilitiesOutStandAmountVal=NULL;
	}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bPastDueDays']<>NULL){$OtherLiabilitiesPastDueDays= $array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bPastDueDays'];}else{$OtherLiabilitiesPastDueDays=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bPreviousContractCode']<>NULL){$OtherLiabilitiesPreviousContCode= $array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bPreviousContractCode'];}else{$OtherLiabilitiesPreviousContCode=NULL;}
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bPrincipalArrears']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bPrincipalArrears']['cCurrency']<>NULL){$OtherLiabilitiesPrincipalArreasCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bPrincipalArrears']['cCurrency'];}else{$OtherLiabilitiesPrincipalArreasCur=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bPrincipalArrears']['cValue']<>NULL){$OtherLiabilitiesPrincipalArreasVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bPrincipalArrears']['cValue'];}else{$OtherLiabilitiesPrincipalArreasVal=NULL;}
	}else{
		$OtherLiabilitiesPrincipalArreasCur=NULL;
		$OtherLiabilitiesPrincipalArreasVal=NULL;
	}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bRating']<>NULL){$OtherLiabilitiesRating= $array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bRating'];}else{$OtherLiabilitiesRating=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bRealEndDate']<>NULL){$OtherLiabilitiesRealDate= $array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability']['bRealEndDate'];}else{$OtherLiabilitiesRealDate=NULL;}

	$callOtherLiabilitiesList = "{call SP_INSERT_M_OTHER_LIABILITIES_LIST_COMPANY(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramsOtherLiabilitiesList = array(
						array($mappingId, SQLSRV_PARAM_IN),
						array($pefindoId,SQLSRV_PARAM_IN),
						array(NULL,SQLSRV_PARAM_IN),
						array($OtherLiabilitiesBranch,SQLSRV_PARAM_IN),					
						array($OtherLiabilitiesCondDate,SQLSRV_PARAM_IN),
						array($OtherLiabilitiesContractDate,SQLSRV_PARAM_IN),
						array($OtherLiabilitiesContractStat,SQLSRV_PARAM_IN),
						array($OtherLiabilitiesContractType,SQLSRV_PARAM_IN),
						array($OtherLiabilitiesCreditor,SQLSRV_PARAM_IN),					
						array($OtherLiabilitiesCurContract,SQLSRV_PARAM_IN),
						array($OtherLiabilitiesDefaultDate,SQLSRV_PARAM_IN),
						array($OtherLiabilitiesDefaultReason,SQLSRV_PARAM_IN),
						array($OtherLiabilitiesDefaultReasonDesc,SQLSRV_PARAM_IN),
						array($OtherLiabilitiesDeliqDate,SQLSRV_PARAM_IN),					
						array($OtherLiabilitiesDesc,SQLSRV_PARAM_IN),
						array($OtherLiabilitiesInitTotAmountCur,SQLSRV_PARAM_IN),
						array($OtherLiabilitiesInitTotAmountVal,SQLSRV_PARAM_IN),
						array($OtherLiabilitiesInterestRate,SQLSRV_PARAM_IN),
						array($OtherLiabilitiesIssueDate,SQLSRV_PARAM_IN),					
						array($OtherLiabilitiesLastUpt,SQLSRV_PARAM_IN),
						array($OtherLiabilitiesMarketValCur,SQLSRV_PARAM_IN),
						array($OtherLiabilitiesMarketValVal,SQLSRV_PARAM_IN),
						array($OtherLiabilitiesMaturyDate,SQLSRV_PARAM_IN),
						array($OtherLiabilitiesNegativeStat,SQLSRV_PARAM_IN),					
						array($OtherLiabilitiesOutStandAmountCur,SQLSRV_PARAM_IN),
						array($OtherLiabilitiesOutStandAmountVal,SQLSRV_PARAM_IN),
						array($OtherLiabilitiesPastDueDays,SQLSRV_PARAM_IN),
						array($OtherLiabilitiesPreviousContCode,SQLSRV_PARAM_IN),
						array($OtherLiabilitiesPrincipalArreasCur,SQLSRV_PARAM_IN),					
						array($OtherLiabilitiesPrincipalArreasVal,SQLSRV_PARAM_IN),
						array($OtherLiabilitiesRating,SQLSRV_PARAM_IN),
						array($OtherLiabilitiesRealDate,SQLSRV_PARAM_IN));
	$execOtherLiabilitiesList = sqlsrv_query($conn, $callOtherLiabilitiesList, $paramsOtherLiabilitiesList) or die ( print_r( sqlsrv_errors(),true));
}else{
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability'])){
		foreach($array['GetCustomReportResponse']['GetCustomReportResult']['aOtherLiabilities']['bOtherLiabilityList']['bOtherLiability'] as $itemOtherLiabilitiestList){
			if($itemOtherLiabilitiestList['bBranch']<>NULL){$OtherLiabilitiesBranch = $itemOtherLiabilitiestList['bBranch'];}else{$OtherLiabilitiesBranch=NULL;}
			if($itemOtherLiabilitiestList['bConditionDate']<>NULL){$OtherLiabilitiesCondDate = $itemOtherLiabilitiestList['bConditionDate'];}else{$OtherLiabilitiesCondDate=NULL;}
			if($itemOtherLiabilitiestList['bContractCode']<>NULL){$OtherLiabilitiesContractDate = $itemOtherLiabilitiestList['bContractCode'];}else{$OtherLiabilitiesContractDate=NULL;}
			if($itemOtherLiabilitiestList['bContractStatus']<>NULL){$OtherLiabilitiesContractStat = $itemOtherLiabilitiestList['bContractStatus'];}else{$OtherLiabilitiesContractStat=NULL;}
			if($itemOtherLiabilitiestList['bContractType']<>NULL){$OtherLiabilitiesContractType = $itemOtherLiabilitiestList['bContractType'];}else{$OtherLiabilitiesContractType=NULL;}
			if($itemOtherLiabilitiestList['bCreditor']<>NULL){$OtherLiabilitiesCreditor = $itemOtherLiabilitiestList['bCreditor'];}else{$OtherLiabilitiesCreditor=NULL;}
			if($itemOtherLiabilitiestList['bCurrencyOfContract']<>NULL){$OtherLiabilitiesCurContract = $itemOtherLiabilitiestList['bCurrencyOfContract'];}else{$OtherLiabilitiesCurContract=NULL;}
			if($itemOtherLiabilitiestList['bDefaultDate']<>NULL){$OtherLiabilitiesDefaultDate = $itemOtherLiabilitiestList['bDefaultDate'];}else{$OtherLiabilitiesDefaultDate=NULL;}
			if($itemOtherLiabilitiestList['bDefaultReason']<>NULL){$OtherLiabilitiesDefaultReason = $itemOtherLiabilitiestList['bDefaultReason'];}else{$OtherLiabilitiesDefaultReason=NULL;}
			if($itemOtherLiabilitiestList['bDefaultReasonDescription']<>NULL){$OtherLiabilitiesDefaultReasonDesc = $itemOtherLiabilitiestList['bDefaultReasonDescription'];}else{$OtherLiabilitiesDefaultReasonDesc=NULL;}
			if($itemOtherLiabilitiestList['bDelinquencyDate']<>NULL){$OtherLiabilitiesDeliqDate = $itemOtherLiabilitiestList['bDelinquencyDate'];}else{$OtherLiabilitiesDeliqDate=NULL;}
			if($itemOtherLiabilitiestList['bDescription']<>NULL){$OtherLiabilitiesDesc= $itemOtherLiabilitiestList['bDescription'];}else{$OtherLiabilitiesDesc=NULL;}
			if(isset($itemOtherLiabilitiestList['bInitialTotalAmount']['cCurrency'])){
				if($itemOtherLiabilitiestList['bInitialTotalAmount']['cCurrency']<>NULL){$OtherLiabilitiesInitTotAmountCur=$itemOtherLiabilitiestList['bInitialTotalAmount']['cCurrency'];}else{$OtherLiabilitiesInitTotAmountCur=NULL;}
				if($itemOtherLiabilitiestList['bInitialTotalAmount']['cValue']<>NULL){$OtherLiabilitiesInitTotAmountVal=$itemOtherLiabilitiestList['bInitialTotalAmount']['cValue'];}else{$OtherLiabilitiesInitTotAmountVal=NULL;}
			}else{
				$OtherLiabilitiesInitTotAmountCur=NULL;
				$OtherLiabilitiesInitTotAmountVal=NULL;
			}
			if($itemOtherLiabilitiestList['bInterestRate']<>NULL){$OtherLiabilitiesInterestRate= $itemOtherLiabilitiestList['bInterestRate'];}else{$OtherLiabilitiesInterestRate=NULL;}
			if($itemOtherLiabilitiestList['bIssueDate']<>NULL){$OtherLiabilitiesIssueDate= $itemOtherLiabilitiestList['bIssueDate'];}else{$OtherLiabilitiesIssueDate=NULL;}
			if($itemOtherLiabilitiestList['bLastUpdate']<>NULL){$OtherLiabilitiesLastUpt= $itemOtherLiabilitiestList['bLastUpdate'];}else{$OtherLiabilitiesLastUpt=NULL;}
			if(isset($itemOtherLiabilitiestList['bMarketValue']['cCurrency'])){
				if($itemOtherLiabilitiestList['bMarketValue']['cCurrency']<>NULL){$OtherLiabilitiesMarketValCur=$itemOtherLiabilitiestList['bMarketValue']['cCurrency'];}else{$OtherLiabilitiesMarketValCur=NULL;}
				if($itemOtherLiabilitiestList['bMarketValue']['cValue']<>NULL){$OtherLiabilitiesMarketValVal=$itemOtherLiabilitiestList['bMarketValue']['cValue'];}else{$OtherLiabilitiesMarketValVal=NULL;}
			}else{
				$OtherLiabilitiesMarketValCur=NULL;
				$OtherLiabilitiesMarketValVal=NULL;
			}
			if($itemOtherLiabilitiestList['bMaturityDate']<>NULL){$OtherLiabilitiesMaturyDate= $itemOtherLiabilitiestList['bMaturityDate'];}else{$OtherLiabilitiesMaturyDate=NULL;}
			if($itemOtherLiabilitiestList['bNegativeStatus']<>NULL){$OtherLiabilitiesNegativeStat= $itemOtherLiabilitiestList['bNegativeStatus'];}else{$OtherLiabilitiesNegativeStat=NULL;}
			if(isset($itemOtherLiabilitiestList['bOutstandingAmount']['cCurrency'])){
				if($itemOtherLiabilitiestList['bOutstandingAmount']['cCurrency']<>NULL){$OtherLiabilitiesOutStandAmountCur=$itemOtherLiabilitiestList['bOutstandingAmount']['cCurrency'];}else{$OtherLiabilitiesOutStandAmountCur=NULL;}
				if($itemOtherLiabilitiestList['bOutstandingAmount']['cValue']<>NULL){$OtherLiabilitiesOutStandAmountVal=$itemOtherLiabilitiestList['bOutstandingAmount']['cValue'];}else{$OtherLiabilitiesOutStandAmountVal=NULL;}
			}else{
				$OtherLiabilitiesOutStandAmountCur=NULL;
				$OtherLiabilitiesOutStandAmountVal=NULL;
			}
			if($itemOtherLiabilitiestList['bPastDueDays']<>NULL){$OtherLiabilitiesPastDueDays= $itemOtherLiabilitiestList['bPastDueDays'];}else{$OtherLiabilitiesPastDueDays=NULL;}
			if($itemOtherLiabilitiestList['bPreviousContractCode']<>NULL){$OtherLiabilitiesPreviousContCode= $itemOtherLiabilitiestList['bPreviousContractCode'];}else{$OtherLiabilitiesPreviousContCode=NULL;}
			if(isset($itemOtherLiabilitiestList['bPrincipalArrears']['cCurrency'])){
				if($itemOtherLiabilitiestList['bPrincipalArrears']['cCurrency']<>NULL){$OtherLiabilitiesPrincipalArreasCur=$itemOtherLiabilitiestList['bPrincipalArrears']['cCurrency'];}else{$OtherLiabilitiesPrincipalArreasCur=NULL;}
				if($itemOtherLiabilitiestList['bPrincipalArrears']['cValue']<>NULL){$OtherLiabilitiesPrincipalArreasVal=$itemOtherLiabilitiestList['bPrincipalArrears']['cValue'];}else{$OtherLiabilitiesPrincipalArreasVal=NULL;}
			}else{
				$OtherLiabilitiesPrincipalArreasCur=NULL;
				$OtherLiabilitiesPrincipalArreasVal=NULL;
			}
			if($itemOtherLiabilitiestList['bRating']<>NULL){$OtherLiabilitiesRating= $itemOtherLiabilitiestList['bRating'];}else{$OtherLiabilitiesRating=NULL;}
			if($itemOtherLiabilitiestList['bRealEndDate']<>NULL){$OtherLiabilitiesRealDate= $itemOtherLiabilitiestList['bRealEndDate'];}else{$OtherLiabilitiesRealDate=NULL;}

			$callOtherLiabilitiesList = "{call SP_INSERT_M_OTHER_LIABILITIES_LIST_COMPANY(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
			$paramsOtherLiabilitiesList = array(
								array($mappingId, SQLSRV_PARAM_IN),
								array($pefindoId,SQLSRV_PARAM_IN),
								array(NULL,SQLSRV_PARAM_IN),
								array($OtherLiabilitiesBranch,SQLSRV_PARAM_IN),					
								array($OtherLiabilitiesCondDate,SQLSRV_PARAM_IN),
								array($OtherLiabilitiesContractDate,SQLSRV_PARAM_IN),
								array($OtherLiabilitiesContractStat,SQLSRV_PARAM_IN),
								array($OtherLiabilitiesContractType,SQLSRV_PARAM_IN),
								array($OtherLiabilitiesCreditor,SQLSRV_PARAM_IN),					
								array($OtherLiabilitiesCurContract,SQLSRV_PARAM_IN),
								array($OtherLiabilitiesDefaultDate,SQLSRV_PARAM_IN),
								array($OtherLiabilitiesDefaultReason,SQLSRV_PARAM_IN),
								array($OtherLiabilitiesDefaultReasonDesc,SQLSRV_PARAM_IN),
								array($OtherLiabilitiesDeliqDate,SQLSRV_PARAM_IN),					
								array($OtherLiabilitiesDesc,SQLSRV_PARAM_IN),
								array($OtherLiabilitiesInitTotAmountCur,SQLSRV_PARAM_IN),
								array($OtherLiabilitiesInitTotAmountVal,SQLSRV_PARAM_IN),
								array($OtherLiabilitiesInterestRate,SQLSRV_PARAM_IN),
								array($OtherLiabilitiesIssueDate,SQLSRV_PARAM_IN),					
								array($OtherLiabilitiesLastUpt,SQLSRV_PARAM_IN),
								array($OtherLiabilitiesMarketValCur,SQLSRV_PARAM_IN),
								array($OtherLiabilitiesMarketValVal,SQLSRV_PARAM_IN),
								array($OtherLiabilitiesMaturyDate,SQLSRV_PARAM_IN),
								array($OtherLiabilitiesNegativeStat,SQLSRV_PARAM_IN),					
								array($OtherLiabilitiesOutStandAmountCur,SQLSRV_PARAM_IN),
								array($OtherLiabilitiesOutStandAmountVal,SQLSRV_PARAM_IN),
								array($OtherLiabilitiesPastDueDays,SQLSRV_PARAM_IN),
								array($OtherLiabilitiesPreviousContCode,SQLSRV_PARAM_IN),
								array($OtherLiabilitiesPrincipalArreasCur,SQLSRV_PARAM_IN),					
								array($OtherLiabilitiesPrincipalArreasVal,SQLSRV_PARAM_IN),
								array($OtherLiabilitiesRating,SQLSRV_PARAM_IN),
								array($OtherLiabilitiesRealDate,SQLSRV_PARAM_IN));
			$execOtherLiabilitiesList = sqlsrv_query($conn, $callOtherLiabilitiesList, $paramsOtherLiabilitiesList) or die ( print_r( sqlsrv_errors(),true));
		}
	}
}


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

$callOtherLiabilitiesSum = "{call SP_INSERT_OTHER_LIABILITIES_SUMMARY_COMPANY(?,?,?,?,?,?,?,?)}";
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