<?php
/* SECURITY LIST */
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bContractCode'])){
	//if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bAcquisitionAmount']<>NULL){$SecurityAcquisitionAmount=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bAcquisitionAmount'];}else{$SecurityAcquisitionAmount=NULL;}
	//if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bAcquisitionDate']<>NULL){$SecurityAcquisitionDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bAcquisitionDate'];}else{$SecurityAcquisitionDate=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bBranch']<>NULL){$SecurityBranch=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bBranch'];}else{$SecurityBranch=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bConditionDate']<>NULL){$SecurityCondDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bConditionDate'];}else{$SecurityCondDate=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bContractCode']<>NULL){$SecurityContractCode=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bContractCode'];}else{$SecurityContractCode=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bStatus']<>NULL){$SecurityContractStatus=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bStatus'];}else{$SecurityContractStatus=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bCreditor']<>NULL){$SecurityCreditor=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bCreditor'];}else{$SecurityCreditor=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bCurrencyOfContract']<>NULL){$SecurityCurContract=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bCurrencyOfContract'];}else{$SecurityCurContract=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bDefaultDate']<>NULL){$SecurityDefaultDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bDefaultDate'];}else{$SecurityDefaultDate=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bDefaultReason']<>NULL){$SecurityDefaultReason=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bDefaultReason'];}else{$SecurityDefaultReason=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bDefaultReasonDescription']<>NULL){$SecurityDefaultReasonDesc=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bDefaultReasonDescription'];}else{$SecurityDefaultReasonDesc=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bDelinquencyDate']<>NULL){$SecurityDeliqDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bDelinquencyDate'];}else{$SecurityDeliqDate=NULL;}
	//if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bDescription']<>NULL){$SecurityDesc=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bDescription'];}else{$SecurityDesc=NULL;}
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bInitialTotalAmount']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bInitialTotalAmount']['cCurrency']<>NULL){$SecurityInitTotAmountCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bInitialTotalAmount']['cCurrency'];}else{$SecurityInitTotAmountCur=NULL;}	
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bInitialTotalAmount']['cValue']<>NULL){$SecurityInitTotAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bInitialTotalAmount']['cValue'];}else{$SecurityInitTotAmountVal=NULL;}	
	}else{
		$SecurityInitTotAmountCur=NULL;
		$SecurityInitTotAmountVal=NULL;
	}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bInterestRate']<>NULL){$SecurityInterestRate=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bInterestRate'];}else{$SecurityInterestRate=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bIssueDate']<>NULL){$SecurityIssueDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bIssueDate'];}else{$SecurityIssueDate=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bIssuerName']<>NULL){$SecurityIssueName=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bIssuerName'];}else{$SecurityIssueName=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bLastUpdate']<>NULL){$SecurityLastUpt=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bLastUpdate'];}else{$SecurityLastUpt=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bMarketListed']<>NULL){$SecurityMarketListed=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bMarketListed'];}else{$SecurityMarketListed=NULL;}
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bMarketValue']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bMarketValue']['cCurrency']<>NULL){$SecurityMarketValCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bMarketValue']['cCurrency'];}else{$SecurityMarketValCur=NULL;}	
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bMarketValue']['cValue']<>NULL){$SecurityMarketValVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bMarketValue']['cValue'];}else{$SecurityMarketValVal=NULL;}	
	}else{
		$SecurityMarketValVal=NULL;
		$SecurityMarketValCur=NULL;
	}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bMaturityDate']<>NULL){$SecurityMarturyDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bMaturityDate'];}else{$SecurityMarturyDate=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bNegativeStatus']<>NULL){$SecurityNegativeStat=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bNegativeStatus'];}else{$SecurityNegativeStat=NULL;}
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bOutstandingAmount']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bOutstandingAmount']['cCurrency']<>NULL){$SecurityOutStandTotAmountCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bOutstandingAmount']['cCurrency'];}else{$SecurityOutStandTotAmountCur=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bOutstandingAmount']['cValue']<>NULL){$SecurityOutStandTotAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bOutstandingAmount']['cValue'];}else{$SecurityOutStandTotAmountVal=NULL;}	
	}else{
		$SecurityOutStandTotAmountCur=NULL;
		$SecurityOutStandTotAmountVal=NULL;
	}
	//if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bPastDueDays']<>NULL){$SecurityPastDueDays=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bPastDueDays'];}else{$SecurityPastDueDays=NULL;}
	//if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bPreviousContractCode']<>NULL){$SecurityPreviousCode=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bPreviousContractCode'];}else{$SecurityPreviousCode=NULL;}
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bPrincipalArrears']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bPrincipalArrears']['cCurrency']<>NULL){$SecurityPripcipalArreasCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bPrincipalArrears']['cCurrency'];}else{$SecurityPripcipalArreasCur=NULL;}	
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bPrincipalArrears']['cValue']<>NULL){$SecurityPripcipalArreasVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bPrincipalArrears']['cValue'];}else{$SecurityPripcipalArreasVal=NULL;}	
	}else{
		$SecurityPripcipalArreasCur=NULL;
		$SecurityPripcipalArreasVal=NULL;
	}
	//if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bPurposeOfOwnership']<>NULL){$SecurityPurposeOwnerShip=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bPurposeOfOwnership'];}else{$SecurityPurposeOwnerShip=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bRating']<>NULL){$SecurityRating=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bRating'];}else{$SecurityRating=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bRealEndDate']<>NULL){$SecurityRealDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bRealEndDate'];}else{$SecurityRealDate=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bType']<>NULL){$SecurityType=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bType'];}else{$SecurityType=NULL;}
	//if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bSovereignRate']<>NULL){$SecuritySovereignRate=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bSovereignRate'];}else{$SecuritySovereignRate=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bTypeofInterestRate']<>NULL){$SecurityTypeInterestRate=$array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity']['bTypeofInterestRate'];}else{$SecurityTypeInterestRate=NULL;}
	
	$callSecuritiesList = "{call SP_INSERT_SECURITIES_LIST_COMPANY(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramsSecuritiesList = array(
						array($mappingId, SQLSRV_PARAM_IN),
						array($pefindoId,SQLSRV_PARAM_IN),
						array(NULL,SQLSRV_PARAM_IN),
						array(NULL,SQLSRV_PARAM_IN),//$SecurityAcquisitionAmount
						array(NULL,SQLSRV_PARAM_IN),//$SecurityAcquisitionDate
						array($SecurityBranch,SQLSRV_PARAM_IN),
						array($SecurityCondDate,SQLSRV_PARAM_IN),
						array($SecurityContractCode,SQLSRV_PARAM_IN),
						array($SecurityContractStatus,SQLSRV_PARAM_IN),
						array($SecurityCreditor,SQLSRV_PARAM_IN),
						array($SecurityCurContract,SQLSRV_PARAM_IN),
						array($SecurityDefaultDate,SQLSRV_PARAM_IN),
						array($SecurityDefaultReason,SQLSRV_PARAM_IN),
						array($SecurityDefaultReasonDesc,SQLSRV_PARAM_IN),					
						array($SecurityDeliqDate,SQLSRV_PARAM_IN),
						array(NULL,SQLSRV_PARAM_IN),//$SecurityDesc					
						array($SecurityInitTotAmountVal,SQLSRV_PARAM_IN),
						array($SecurityInitTotAmountCur,SQLSRV_PARAM_IN),
						array($SecurityInterestRate,SQLSRV_PARAM_IN),
						array($SecurityIssueDate,SQLSRV_PARAM_IN),
						array($SecurityIssueName,SQLSRV_PARAM_IN),
						array($SecurityLastUpt,SQLSRV_PARAM_IN),
						array($SecurityMarketListed,SQLSRV_PARAM_IN),
						array($SecurityMarketValVal,SQLSRV_PARAM_IN),
						array($SecurityMarketValCur,SQLSRV_PARAM_IN),
						array($SecurityMarturyDate,SQLSRV_PARAM_IN),
						array($SecurityNegativeStat,SQLSRV_PARAM_IN),
						array($SecurityOutStandTotAmountVal,SQLSRV_PARAM_IN),
						array($SecurityOutStandTotAmountCur,SQLSRV_PARAM_IN),
						array(NULL,SQLSRV_PARAM_IN),//$SecurityPastDueDays
						array(NULL,SQLSRV_PARAM_IN),//$SecurityPreviousCode
						array($SecurityPripcipalArreasVal,SQLSRV_PARAM_IN),
						array($SecurityPripcipalArreasCur,SQLSRV_PARAM_IN),
						array(NULL,SQLSRV_PARAM_IN),//$SecurityPurposeOwnerShip
						array($SecurityRating,SQLSRV_PARAM_IN),
						array($SecurityRealDate,SQLSRV_PARAM_IN),
						array($SecurityType,SQLSRV_PARAM_IN),
						array(NULL,SQLSRV_PARAM_IN),//$SecuritySovereignRate
						array($SecurityTypeInterestRate,SQLSRV_PARAM_IN)										
						);
	$execSecuritiesList = sqlsrv_query($conn, $callSecuritiesList, $paramsSecuritiesList) or die ( print_r( sqlsrv_errors(),true));	
}else{
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity'])){
		foreach($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSecurityList']['bSecurity'] as $itemSecuritiesList){
			//if($itemSecuritiesList['bAcquisitionDate']<>NULL){$SecurityAcquisitionDate=$itemSecuritiesList['bAcquisitionDate'];}else{$SecurityAcquisitionDate=NULL;}
			if($itemSecuritiesList['bBranch']<>NULL){$SecurityBranch=$itemSecuritiesList['bBranch'];}else{$SecurityBranch=NULL;}
			if($itemSecuritiesList['bConditionDate']<>NULL){$SecurityCondDate=$itemSecuritiesList['bConditionDate'];}else{$SecurityCondDate=NULL;}
			if($itemSecuritiesList['bContractCode']<>NULL){$SecurityContractCode=$itemSecuritiesList['bContractCode'];}else{$SecurityContractCode=NULL;}
			if($itemSecuritiesList['bStatus']<>NULL){$SecurityContractStatus=$itemSecuritiesList['bStatus'];}else{$SecurityContractStatus=NULL;}
			if($itemSecuritiesList['bCreditor']<>NULL){$SecurityCreditor=$itemSecuritiesList['bCreditor'];}else{$SecurityCreditor=NULL;}
			if($itemSecuritiesList['bCurrencyOfContract']<>NULL){$SecurityCurContract=$itemSecuritiesList['bCurrencyOfContract'];}else{$SecurityCurContract=NULL;}
			if($itemSecuritiesList['bDefaultDate']<>NULL){$SecurityDefaultDate=$itemSecuritiesList['bDefaultDate'];}else{$SecurityDefaultDate=NULL;}
			if($itemSecuritiesList['bDefaultReason']<>NULL){$SecurityDefaultReason=$itemSecuritiesList['bDefaultReason'];}else{$SecurityDefaultReason=NULL;}
			if($itemSecuritiesList['bDefaultReasonDescription']<>NULL){$SecurityDefaultReasonDesc=$itemSecuritiesList['bDefaultReasonDescription'];}else{$SecurityDefaultReasonDesc=NULL;}
			if($itemSecuritiesList['bDelinquencyDate']<>NULL){$SecurityDeliqDate=$itemSecuritiesList['bDelinquencyDate'];}else{$SecurityDeliqDate=NULL;}
			//if($itemSecuritiesList['bDescription']<>NULL){$SecurityDesc=$itemSecuritiesList['bDescription'];}else{$SecurityDesc=NULL;}
			if(isset($itemSecuritiesList['bInitialTotalAmount']['cCurrency'])){
				if($itemSecuritiesList['bInitialTotalAmount']['cCurrency']<>NULL){$SecurityInitTotAmountCur=$itemSecuritiesList['bInitialTotalAmount']['cCurrency'];}else{$SecurityInitTotAmountCur=NULL;}	
				if($itemSecuritiesList['bInitialTotalAmount']['cValue']<>NULL){$SecurityInitTotAmountVal=$itemSecuritiesList['bInitialTotalAmount']['cValue'];}else{$SecurityInitTotAmountVal=NULL;}	
			}else{
				$SecurityInitTotAmountCur=NULL;
				$SecurityInitTotAmountVal=NULL;
			}
			if($itemSecuritiesList['bInterestRate']<>NULL){$SecurityInterestRate=$itemSecuritiesList['bInterestRate'];}else{$SecurityInterestRate=NULL;}
			if($itemSecuritiesList['bIssueDate']<>NULL){$SecurityIssueDate=$itemSecuritiesList['bIssueDate'];}else{$SecurityIssueDate=NULL;}
			if($itemSecuritiesList['bIssuerName']<>NULL){$SecurityIssueName=$itemSecuritiesList['bIssuerName'];}else{$SecurityIssueName=NULL;}
			if($itemSecuritiesList['bLastUpdate']<>NULL){$SecurityLastUpt=$itemSecuritiesList['bLastUpdate'];}else{$SecurityLastUpt=NULL;}
			if($itemSecuritiesList['bMarketListed']<>NULL){$SecurityMarketListed=$itemSecuritiesList['bMarketListed'];}else{$SecurityMarketListed=NULL;}
			if(isset($itemSecuritiesList['bMarketValue']['cCurrency'])){
				if($itemSecuritiesList['bMarketValue']['cCurrency']<>NULL){$SecurityMarketValCur=$itemSecuritiesList['bMarketValue']['cCurrency'];}else{$SecurityMarketValCur=NULL;}	
				if($itemSecuritiesList['bMarketValue']['cValue']<>NULL){$SecurityMarketValVal=$itemSecuritiesList['bMarketValue']['cValue'];}else{$SecurityMarketValVal=NULL;}	
			}else{
				$SecurityMarketValVal=NULL;
				$SecurityMarketValCur=NULL;
			}
			if($itemSecuritiesList['bMaturityDate']<>NULL){$SecurityMarturyDate=$itemSecuritiesList['bMaturityDate'];}else{$SecurityMarturyDate=NULL;}
			if($itemSecuritiesList['bNegativeStatus']<>NULL){$SecurityNegativeStat=$itemSecuritiesList['bNegativeStatus'];}else{$SecurityNegativeStat=NULL;}
			if(isset($itemSecuritiesList['bOutstandingAmount']['cCurrency'])){
				if($itemSecuritiesList['bOutstandingAmount']['cCurrency']<>NULL){$SecurityOutStandTotAmountCur=$itemSecuritiesList['bOutstandingAmount']['cCurrency'];}else{$SecurityOutStandTotAmountCur=NULL;}
				if($itemSecuritiesList['bOutstandingAmount']['cValue']<>NULL){$SecurityOutStandTotAmountVal=$itemSecuritiesList['bOutstandingAmount']['cValue'];}else{$SecurityOutStandTotAmountVal=NULL;}	
			}else{
				$SecurityOutStandTotAmountCur=NULL;
				$SecurityOutStandTotAmountVal=NULL;
			}
			//if($itemSecuritiesList['bPastDueDays']<>NULL){$SecurityPastDueDays=$itemSecuritiesList['bPastDueDays'];}else{$SecurityPastDueDays=NULL;}
			//if($itemSecuritiesList['bPreviousContractCode']<>NULL){$SecurityPreviousCode=$itemSecuritiesList['bPreviousContractCode'];}else{$SecurityPreviousCode=NULL;}
			if(isset($itemSecuritiesList['bPrincipalArrears']['cCurrency'])){
				if($itemSecuritiesList['bPrincipalArrears']['cCurrency']<>NULL){$SecurityPripcipalArreasCur=$itemSecuritiesList['bPrincipalArrears']['cCurrency'];}else{$SecurityPripcipalArreasCur=NULL;}	
				if($itemSecuritiesList['bPrincipalArrears']['cValue']<>NULL){$SecurityPripcipalArreasVal=$itemSecuritiesList['bPrincipalArrears']['cValue'];}else{$SecurityPripcipalArreasVal=NULL;}	
			}else{
				$SecurityPripcipalArreasCur=NULL;
				$SecurityPripcipalArreasVal=NULL;
			}
			//if($itemSecuritiesList['bPurposeOfOwnership']<>NULL){$SecurityPurposeOwnerShip=$itemSecuritiesList['bPurposeOfOwnership'];}else{$SecurityPurposeOwnerShip=NULL;}
			if($itemSecuritiesList['bRating']<>NULL){$SecurityRating=$itemSecuritiesList['bRating'];}else{$SecurityRating=NULL;}
			if($itemSecuritiesList['bRealEndDate']<>NULL){$SecurityRealDate=$itemSecuritiesList['bRealEndDate'];}else{$SecurityRealDate=NULL;}
			if($itemSecuritiesList['bType']<>NULL){$SecurityType=$itemSecuritiesList['bType'];}else{$SecurityType=NULL;}
			if($itemSecuritiesList['bSovereignRate']<>NULL){$SecuritySovereignRate=$itemSecuritiesList['bSovereignRate'];}else{$SecuritySovereignRate=NULL;}
			if($itemSecuritiesList['bTypeofInterestRate']<>NULL){$SecurityTypeInterestRate=$itemSecuritiesList['bTypeofInterestRate'];}else{$SecurityTypeInterestRate=NULL;}
			
			$callSecuritiesList = "{call SP_INSERT_SECURITIES_LIST_COMPANY(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
			$paramsSecuritiesList = array(
								array($mappingId, SQLSRV_PARAM_IN),
								array($pefindoId,SQLSRV_PARAM_IN),
								array(NULL,SQLSRV_PARAM_IN),
								array(NULL,SQLSRV_PARAM_IN),//$SecurityAcquisitionAmount
								array(NULL,SQLSRV_PARAM_IN),//$SecurityAcquisitionDate
								array($SecurityBranch,SQLSRV_PARAM_IN),//$SecurityBranch
								array($SecurityCondDate,SQLSRV_PARAM_IN),//$SecurityCondDate
								array($SecurityContractCode,SQLSRV_PARAM_IN),//$SecurityContractCode
								array($SecurityContractStatus,SQLSRV_PARAM_IN),//$SecurityContractStatus
								array($SecurityCreditor,SQLSRV_PARAM_IN),//$SecurityCreditor
								array($SecurityCurContract,SQLSRV_PARAM_IN),//$SecurityCurContract
								array($SecurityDefaultDate,SQLSRV_PARAM_IN),//$SecurityDefaultDate
								array($SecurityDefaultReason,SQLSRV_PARAM_IN),//$SecurityDefaultReason
								array($SecurityDefaultReasonDesc,SQLSRV_PARAM_IN),//$SecurityDefaultReasonDesc					
								array($SecurityDeliqDate,SQLSRV_PARAM_IN),//$SecurityDeliqDate
								array(NULL,SQLSRV_PARAM_IN),//$SecurityDesc					
								array($SecurityInitTotAmountVal,SQLSRV_PARAM_IN),
								array($SecurityInitTotAmountCur,SQLSRV_PARAM_IN),
								array($SecurityInterestRate,SQLSRV_PARAM_IN),//$SecurityInterestRate
								array($SecurityIssueDate,SQLSRV_PARAM_IN),//$SecurityIssueDate
								array($SecurityIssueName,SQLSRV_PARAM_IN),//$SecurityIssueName
								array($SecurityLastUpt,SQLSRV_PARAM_IN),//$SecurityLastUpt
								array($SecurityMarketListed,SQLSRV_PARAM_IN),//$SecurityMarketListed
								array($SecurityMarketValVal,SQLSRV_PARAM_IN),//$SecurityMarketValVal
								array($SecurityMarketValCur,SQLSRV_PARAM_IN),//$SecurityMarketValCur
								array($SecurityMarturyDate,SQLSRV_PARAM_IN),//$SecurityMarturyDate
								array($SecurityNegativeStat,SQLSRV_PARAM_IN),//$SecurityNegativeStat
								array($SecurityOutStandTotAmountVal,SQLSRV_PARAM_IN),
								array($SecurityOutStandTotAmountCur,SQLSRV_PARAM_IN),
								array(NULL,SQLSRV_PARAM_IN),//$SecurityPastDueDays
								array(NULL,SQLSRV_PARAM_IN),//$SecurityPreviousCode
								array($SecurityPripcipalArreasVal,SQLSRV_PARAM_IN),
								array($SecurityPripcipalArreasCur,SQLSRV_PARAM_IN),
								array(NULL,SQLSRV_PARAM_IN),//$SecurityPurposeOwnerShip
								array($SecurityRating,SQLSRV_PARAM_IN),//$SecurityRating
								array($SecurityRealDate,SQLSRV_PARAM_IN),//$SecurityRealDate
								array($SecurityType,SQLSRV_PARAM_IN),//$SecurityType
								array(NULL,SQLSRV_PARAM_IN),//$SecuritySovereignRate
								array($SecurityTypeInterestRate,SQLSRV_PARAM_IN)//$SecurityTypeInterestRate										
								);
			$execSecuritiesList = sqlsrv_query($conn, $callSecuritiesList, $paramsSecuritiesList) or die ( print_r( sqlsrv_errors(),true));	
		}
	}
}
/* SECURITY SUMMARY */	
if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSummary']['bNumberOfActiveSecurities']<>NULL){$SecSumNumbActive = $array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSummary']['bNumberOfActiveSecurities'];}else{$SecSumNumbActive=NULL;}		
if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSummary']['bNumberOfPastSecurities']<>NULL){$SecSumNumbPast = $array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSummary']['bNumberOfPastSecurities'];}else{$SecSumNumbPast=NULL;}
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSummary']['bTotalMarketValue']['cCurrency'])){
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSummary']['bTotalMarketValue']['cCurrency']<>NULL){$SecSumTotMarkCur = $array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSummary']['bTotalMarketValue']['cCurrency'];}else{$SecSumTotMarkCur=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSummary']['bTotalMarketValue']['cValue']<>NULL){$SecSumTotMarkVal = $array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSummary']['bTotalMarketValue']['cValue'];}else{$SecSumTotMarkVal=NULL;}
}else{
	$SecSumTotMarkCur=NULL;
	$SecSumTotMarkVal=NULL;
}
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSummary']['bTotalPrincipalArrears']['cCurrency'])){
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSummary']['bTotalPrincipalArrears']['cCurrency']<>NULL){$SecSumTotPrincpCur = $array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSummary']['bTotalPrincipalArrears']['cCurrency'];}else{$SecSumTotPrincpCur=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSummary']['bTotalPrincipalArrears']['cValue']<>NULL){$SecSumTotPrincpVal = $array['GetCustomReportResponse']['GetCustomReportResult']['aSecurities']['bSummary']['bTotalPrincipalArrears']['cValue'];}else{$SecSumTotPrincpVal=NULL;}	
}else{
	$SecSumTotPrincpCur=NULL;
	$SecSumTotPrincpVal=NULL;
}
$callSecuritiesSum = "{call SP_INSERT_SECURITIES_SUMMARY_COMPANY(?,?,?,?,?,?,?,?)}";
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