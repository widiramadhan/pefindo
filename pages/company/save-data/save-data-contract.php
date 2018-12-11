<?php
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bBankBeneficiary'])){	
	$x=0;
	$y=0;
	$z=0;
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bBankBeneficiary']<>NULL){$ConctBankBenefic=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bBankBeneficiary'];}else{$ConctBankBenefic=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bBranch']<>NULL){$ConctBranch=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bBranch'];}else{$ConctBranch=NULL;}				
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bConditionDate']<>NULL){$ConctCondDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bConditionDate'];}else{$ConctCondDate=NULL;}				
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bContractCode']<>NULL){$ConctCode=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bContractCode'];}else{$ConctCode=NULL;}				
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bContractCurrency']<>NULL){$ConctCurency=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bContractCurrency'];}else{$ConctCurency=NULL;}				
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bContractStatus']<>NULL){$ConctStatus=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bContractStatus'];}else{$ConctStatus=NULL;}				
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bContractSubtype']<>NULL){$ConctSubType=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bContractSubtype'];}else{$ConctSubType=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bContractType']<>NULL){$ConctType=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bContractType'];}else{$ConctType=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bCreditCharacteristics']<>NULL){$ConctCreditChar=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bCreditCharacteristics'];}else{$ConctCreditChar=NULL;}				
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bCreditClassification']<>NULL){$ConctCreditClassifict=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bCreditClassification'];}else{$ConctCreditClassifict=NULL;}				
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bCreditUsageInLast30Days']<>NULL){$ConctCreditUsageLast30days=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bCreditUsageInLast30Days'];}else{$ConctCreditUsageLast30days=NULL;}				
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bCreditor']<>NULL){$ConctCreditor=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bCreditor'];}else{$ConctCreditor=NULL;}				
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bCreditorType']<>NULL){$ConctCreditorType=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bCreditorType'];}else{$ConctCreditorType=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bDefaultDate']<>NULL){$ConctDefaultDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bDefaultDate'];}else{$ConctDefaultDate=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bDefaultReason']<>NULL){$ConctDefaultReason=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bDefaultReason'];}else{$ConctDefaultReason=NULL;}				
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bDefaultReasonDescription']<>NULL){$ConctDefaultReasonDesc=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bDefaultReasonDescription'];}else{$ConctDefaultReasonDesc=NULL;}				
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bDelinquencyDate']<>NULL){$ConctDeleqDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bDelinquencyDate'];}else{$ConctDeleqDate=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bDescription']<>NULL){$ConctDescription=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bDescription'];}else{$ConctDescription=NULL;}				
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bDisbursementDate']<>NULL){$ConctDisBursDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bDisbursementDate'];}else{$ConctDisBursDate=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bDisputes']['bClosedDisputes']<>NULL){$ConctDispCloseDisp=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bDisputes']['bClosedDisputes'];}else{$ConctDispCloseDisp=NULL;}				
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bDisputes']['bDisputeList']<>NULL){$ConctDispList=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bDisputes']['bDisputeList'];}else{$ConctDispList=NULL;}				
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bDisputes']['bFalseDisputes']<>NULL){$ConctDispFalse=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bDisputes']['bFalseDisputes'];}else{$ConctDispFalse=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bEconomicSector']<>NULL){$ConctEconomicSector=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bEconomicSector'];}else{$ConctEconomicSector=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bGovernmentProgram']<>NULL){$ConctGovernProg=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bGovernmentProgram'];}else{$ConctGovernProg=NULL;}			
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bGuarantyDeposit']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bGuarantyDeposit']['cCurrency']<>NULL){$ConctGuarantDepoCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bGuarantyDeposit']['cCurrency'];}else{$ConctGuarantDepoCur=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bGuarantyDeposit']['cValue']<>NULL){$ConctGuarantDepoVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bGuarantyDeposit']['cValue'];}else{$ConctGuarantDepoVal=NULL;}		
	}else{
		$ConctGuarantDepoCur=NULL;
		$ConctGuarantDepoVal=NULL;
	}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bInitialAgreementDate']<>NULL){$ConctInitialAgrmntDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bInitialAgreementDate'];}else{$ConctInitialAgrmntDate=NULL;}				
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bInitialAgreementNumber']<>NULL){$ConctInitialAgrmntNumb=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bInitialAgreementNumber'];}else{$ConctInitialAgrmntNumb=NULL;}					
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bInitialInterestRate']<>NULL){$ConctInterestRate=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bInitialInterestRate'];}else{$ConctInterestRate=NULL;}				
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bInitialInterestRateType']<>NULL){$ConctInterestRateType=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bInitialInterestRateType'];}else{$ConctInterestRateType=NULL;}							
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bInitialRestructuringDate']<>NULL){$ConctInitRestcDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bInitialRestructuringDate'];}else{$ConctInitRestcDate=NULL;}				
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bInitialTotalAmount']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bInitialTotalAmount']['cCurrency']<>NULL){$ConctInitTotAmountCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bInitialTotalAmount']['cCurrency'];}else{$ConctInitTotAmountCur=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bInitialTotalAmount']['cValue']<>NULL){$ConctInitTotAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bInitialTotalAmount']['cValue'];}else{$ConctInitTotAmountVal=NULL;}				
	}else{
		$ConctInitTotAmountCur=NULL;
		$ConctInitTotAmountVal=NULL;
	}
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bInterestArrears']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bInterestArrears']['cCurrency']<>NULL){$ConctIntArreasCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bInterestArrears']['cCurrency'];}else{$ConctIntArreasCur=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bInterestArrears']['cValue']<>NULL){$ConctIntArreasVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bInterestArrears']['cValue'];}else{$ConctIntArreasVal=NULL;}				
	}else{
		$ConctIntArreasCur=NULL;
		$ConctIntArreasVal=NULL;
	}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bInterestArrearsFrequency']<>NULL){$ConctIntArrearsFreq=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bInterestArrearsFrequency'];}else{$ConctIntArrearsFreq=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bLastAgreementDate']<>NULL){$ConctLastAgrmntDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bLastAgreementDate'];}else{$ConctLastAgrmntDate=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bLastAgreementNumber']<>NULL){$ConctLastAgrmntNumb=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bLastAgreementNumber'];}else{$ConctLastAgrmntNumb=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bLastDelinquency90PlusDays']<>NULL){$ConctLastDeleq90days=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bLastDelinquency90PlusDays'];}else{$ConctLastDeleq90days=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bLastUpdate']<>NULL){$ConctLastUpdate=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bLastUpdate'];}else{$ConctLastUpdate=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bMaturityDate']<>NULL){$ConctMaturyDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bMaturityDate'];}else{$ConctMaturyDate=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bNameOfInsured']<>NULL){$ConctNameInsured=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bNameOfInsured'];}else{$ConctNameInsured=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bNegativeStatusOfContract']<>NULL){$ConctNegativeStatContact=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bNegativeStatusOfContract'];}else{$ConctNegativeStatContact=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bOrientationOfUse']<>NULL){$ConctOrietationUse=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bOrientationOfUse'];}else{$ConctOrietationUse=NULL;}			
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bOutstandingAmount']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bOutstandingAmount']['cCurrency']<>NULL){$ConctOutStandingAmountCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bOutstandingAmount']['cCurrency'];}else{$ConctOutStandingAmountCur=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bOutstandingAmount']['cValue']<>NULL){$ConctOutStandingAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bOutstandingAmount']['cValue'];}else{$ConctOutStandingAmountVal=NULL;}			
	}else{
		$ConctOutStandingAmountCur=NULL;
		$ConctOutStandingAmountVal=NULL;
	}
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPastDueAmount']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPastDueAmount']['cCurrency']<>NULL){$ConctPastDueAmountCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPastDueAmount']['cCurrency'];}else{$ConctPastDueAmountCur=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPastDueAmount']['cValue']<>NULL){$ConctPastDueAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPastDueAmount']['cValue'];}else{$ConctPastDueAmountVal=NULL;}			
	}else{
		$ConctPastDueAmountCur=NULL;
		$ConctPastDueAmountVal=NULL;
	}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPastDueDays']<>NULL){$ConctPastDueDays=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPastDueDays'];}else{$ConctPastDueDays=NULL;}			
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPastDueInterest']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPastDueInterest']['cCurrency']<>NULL){$ConctPastDueIntCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPastDueInterest']['cCurrency'];}else{$ConctPastDueIntCur=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPastDueInterest']['cValue']<>NULL){$ConctPastDueIntVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPastDueInterest']['cValue'];}else{$ConctPastDueIntVal=NULL;}		
	}else{
		$ConctPastDueIntCur=NULL;
		$ConctPastDueIntVal=NULL;
	}
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPenalty']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPenalty']['cCurrency']<>NULL){$ConctPenaltyCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPenalty']['cCurrency'];}else{$ConctPenaltyCur=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPenalty']['cValue']<>NULL){$ConctPenaltyVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPenalty']['cValue'];}else{$ConctPenaltyVal=NULL;}			
	}else{
		$ConctPenaltyCur=NULL;
		$ConctPenaltyVal=NULL;
	}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPhaseOfContract']<>NULL){$ConctPhaseConctract=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPhaseOfContract'];}else{$ConctPhaseConctract=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPrincipalArrearsFrequency']<>NULL){$ConctPrincipArreasFreq=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPrincipalArrearsFrequency'];}else{$ConctPrincipArreasFreq=NULL;}						
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPrincipalArrears']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPrincipalArrears']['cCurrency']<>NULL){$ConctPrincipArreasCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPrincipalArrears']['cCurrency'];}else{$ConctPrincipArreasCur=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPrincipalArrears']['cValue']<>NULL){$ConctPrincipArreasVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPrincipalArrears']['cValue'];}else{$ConctPrincipArreasVal=NULL;}			
	}else{
		$ConctPrincipArreasCur=NULL;
		$ConctPrincipArreasVal=NULL;
	}
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPrincipalBalance']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPrincipalBalance']['cCurrency']<>NULL){$ConctPrincipBalCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPrincipalBalance']['cCurrency'];}else{$ConctPrincipBalCur=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPrincipalBalance']['cValue']<>NULL){$ConctPrincipBalVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPrincipalBalance']['cValue'];}else{$ConctPrincipBalVal=NULL;}			
	}else{
		$ConctPrincipBalCur=NULL;
		$ConctPrincipBalVal=NULL;
	}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bProjectLocation']<>NULL){$ConctProjLoc=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bProjectLocation'];}else{$ConctProjLoc=NULL;}						
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bProjectValue']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bProjectValue']['cCurrency']<>NULL){$ConctProjValCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bProjectValue']['cCurrency'];}else{$ConctProjValCur=NULL;}			
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bProjectValue']['cValue']<>NULL){$ConctProjValVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bProjectValue']['cValue'];}else{$ConctProjValVal=NULL;}			
	}else{
		$ConctProjValCur=NULL;
		$ConctProjValVal=NULL;
	}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bProlongationCounter']<>NULL){$ConctProloCounter=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bProlongationCounter'];}else{$ConctProloCounter=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPurposeOfFinancing']<>NULL){$ConctPurposeFinance=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bPurposeOfFinancing'];}else{$ConctPurposeFinance=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bRealEndDate']<>NULL){$ConctRealandDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bRealEndDate'];}else{$ConctRealandDate=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bRestructuredCount']<>NULL){$ConctRestrucCount=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bRestructuredCount'];}else{$ConctRestrucCount=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bRestructuringDate']<>NULL){$ConctRestrucDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bRestructuringDate'];}else{$ConctRestrucDate=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bRestructuringReason']<>NULL){$ConctRestrucReason=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bRestructuringReason'];}else{$ConctRestrucReason=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bRoleOfClient']<>NULL){$ConctRoleOfClient=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bRoleOfClient'];}else{$ConctRoleOfClient=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bStartDate']<>NULL){$ConctStartDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bStartDate'];}else{$ConctStartDate=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bSyndicatedLoan']<>NULL){$ConctSydicatLoan=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bSyndicatedLoan'];}else{$ConctSydicatLoan=NULL;}			
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bTotalAmount']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bTotalAmount']['cCurrency']<>NULL){$ConctTotAmountCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bTotalAmount']['cCurrency'];}else{$ConctTotAmountCur=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bTotalAmount']['cValue']<>NULL){$ConctTotAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bTotalAmount']['cValue'];}else{$ConctTotAmountVal=NULL;}			
	}else{
		$ConctTotAmountCur=NULL;
		$ConctTotAmountVal=NULL;
	}
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bTotalFacilityAmount']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bTotalFacilityAmount']['cCurrency']<>NULL){$ConctTotFaciltyAmountCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bTotalFacilityAmount']['cCurrency'];}else{$ConctTotFaciltyAmountCur=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bTotalFacilityAmount']['cValue']<>NULL){$ConctTotFaciltyAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bTotalFacilityAmount']['cValue'];}else{$ConctTotFaciltyAmountVal=NULL;}			
	}else{
		$ConctTotFaciltyAmountCur=NULL;
		$ConctTotFaciltyAmountVal=NULL;
	}
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bTotalTakenAmount']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bTotalTakenAmount']['cCurrency']<>NULL){$ConctTotTakenAmountCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bTotalTakenAmount']['cCurrency'];}else{$ConctTotTakenAmountCur=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bTotalTakenAmount']['cValue']<>NULL){$ConctTotTakenAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bTotalTakenAmount']['cValue'];}else{$ConctTotTakenAmountVal=NULL;}			
	}else{
		$ConctTotTakenAmountCur=NULL;
		$ConctTotTakenAmountVal=NULL;
	}
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bWorstPastDueAmount']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bWorstPastDueAmount']['cCurrency']<>NULL){$ConctWorstPastDueAmountCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bWorstPastDueAmount']['cCurrency'];}else{$ConctWorstPastDueAmountCur=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bWorstPastDueAmount']['cValue']<>NULL){$ConctWorstPastDueAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bWorstPastDueAmount']['cValue'];}else{$ConctWorstPastDueAmountVal=NULL;}					
	}else{
		$ConctWorstPastDueAmountCur=NULL;
		$ConctWorstPastDueAmountVal=NULL;
	}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bWorstPastDueDays']<>NULL){$ConctWorstPastDueDays=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract']['bWorstPastDueDays'];}else{$ConctWorstPastDueDays=NULL;}

	$callContract = "{call sp_insert_M_contract_COMPANY(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramsContract = array(
						array($mappingId, SQLSRV_PARAM_IN),
						array($pefindoId,SQLSRV_PARAM_IN),
						array($ConctBankBenefic,SQLSRV_PARAM_IN),
						array($ConctBranch,SQLSRV_PARAM_IN),
						array($ConctCondDate,SQLSRV_PARAM_IN),
						array($ConctCode,SQLSRV_PARAM_IN),
						array($ConctCurency,SQLSRV_PARAM_IN),
						array($ConctStatus,SQLSRV_PARAM_IN),
						array($ConctSubType,SQLSRV_PARAM_IN),
						array($ConctType,SQLSRV_PARAM_IN),
						array($ConctCreditChar,SQLSRV_PARAM_IN),
						array($ConctCreditClassifict,SQLSRV_PARAM_IN),
						array($ConctCreditUsageLast30days,SQLSRV_PARAM_IN),
						array($ConctCreditor,SQLSRV_PARAM_IN),
						array($ConctCreditorType,SQLSRV_PARAM_IN),
						array($ConctDefaultDate,SQLSRV_PARAM_IN),
						array($ConctDefaultReason,SQLSRV_PARAM_IN),
						array($ConctDefaultReasonDesc,SQLSRV_PARAM_IN),
						array($ConctDeleqDate,SQLSRV_PARAM_IN),
						array($ConctDescription,SQLSRV_PARAM_IN),
						array($ConctDisBursDate,SQLSRV_PARAM_IN),
						array($ConctDispCloseDisp,SQLSRV_PARAM_IN),
						array(NULL,SQLSRV_PARAM_IN), //$ConctDispList
						array($ConctDispFalse,SQLSRV_PARAM_IN),
						array($ConctEconomicSector,SQLSRV_PARAM_IN),
						array($ConctGovernProg,SQLSRV_PARAM_IN),
						array($ConctGuarantDepoCur,SQLSRV_PARAM_IN), //$ConctGuarantDepoCur
						array($ConctGuarantDepoVal,SQLSRV_PARAM_IN),
						array($ConctInitialAgrmntDate,SQLSRV_PARAM_IN),
						array($ConctInitialAgrmntNumb,SQLSRV_PARAM_IN),
						array($ConctInterestRate,SQLSRV_PARAM_IN),
						array($ConctInterestRateType,SQLSRV_PARAM_IN),
						array($ConctInitRestcDate,SQLSRV_PARAM_IN),
						array($ConctInitTotAmountCur,SQLSRV_PARAM_IN),
						array($ConctInitTotAmountVal,SQLSRV_PARAM_IN),
						array($ConctIntArreasCur,SQLSRV_PARAM_IN),
						array($ConctIntArreasVal,SQLSRV_PARAM_IN),
						array($ConctIntArrearsFreq,SQLSRV_PARAM_IN),
						array($ConctLastAgrmntDate,SQLSRV_PARAM_IN),
						array($ConctLastAgrmntNumb,SQLSRV_PARAM_IN),
						array($ConctLastDeleq90days,SQLSRV_PARAM_IN),
						array($ConctLastUpdate,SQLSRV_PARAM_IN),
						array($ConctMaturyDate,SQLSRV_PARAM_IN),
						array($ConctNameInsured,SQLSRV_PARAM_IN),
						array($ConctNegativeStatContact,SQLSRV_PARAM_IN),
						array($ConctOrietationUse,SQLSRV_PARAM_IN),
						array($ConctOutStandingAmountCur,SQLSRV_PARAM_IN),
						array($ConctOutStandingAmountVal,SQLSRV_PARAM_IN),
						array($ConctPastDueAmountCur,SQLSRV_PARAM_IN),
						array($ConctPastDueAmountVal,SQLSRV_PARAM_IN),
						array($ConctPastDueDays,SQLSRV_PARAM_IN),
						array($ConctPastDueIntCur,SQLSRV_PARAM_IN),
						array($ConctPastDueIntVal,SQLSRV_PARAM_IN),
						array($ConctPenaltyCur,SQLSRV_PARAM_IN),
						array($ConctPenaltyVal,SQLSRV_PARAM_IN),
						array($ConctPhaseConctract,SQLSRV_PARAM_IN),
						array($ConctPrincipArreasCur,SQLSRV_PARAM_IN),
						array($ConctPrincipArreasVal,SQLSRV_PARAM_IN),
						array($ConctPrincipArreasFreq,SQLSRV_PARAM_IN),
						array($ConctPrincipBalCur,SQLSRV_PARAM_IN),
						array($ConctPrincipBalVal,SQLSRV_PARAM_IN),
						array($ConctProjLoc,SQLSRV_PARAM_IN),
						array($ConctProjValCur,SQLSRV_PARAM_IN), //$ConctProjValCur
						array($ConctProjValVal,SQLSRV_PARAM_IN),
						array($ConctProloCounter,SQLSRV_PARAM_IN),
						array($ConctPurposeFinance,SQLSRV_PARAM_IN),
						array($ConctRealandDate,SQLSRV_PARAM_IN),
						array($ConctRestrucCount,SQLSRV_PARAM_IN),
						array($ConctRestrucDate,SQLSRV_PARAM_IN),
						array($ConctRestrucReason,SQLSRV_PARAM_IN),
						array($ConctRoleOfClient,SQLSRV_PARAM_IN),
						array($ConctStartDate,SQLSRV_PARAM_IN),
						array($ConctSydicatLoan,SQLSRV_PARAM_IN),
						array($ConctTotAmountCur,SQLSRV_PARAM_IN),
						array($ConctTotAmountVal,SQLSRV_PARAM_IN),
						array($ConctTotFaciltyAmountCur,SQLSRV_PARAM_IN),
						array($ConctTotFaciltyAmountVal,SQLSRV_PARAM_IN),
						array($ConctTotTakenAmountCur,SQLSRV_PARAM_IN),
						array($ConctTotTakenAmountVal,SQLSRV_PARAM_IN),
						array($ConctWorstPastDueAmountCur,SQLSRV_PARAM_IN),
						array($ConctWorstPastDueAmountVal,SQLSRV_PARAM_IN),
						array($ConctWorstPastDueDays,SQLSRV_PARAM_IN)
					);
		$execContract = sqlsrv_query($conn, $callContract, $paramsContract) or die ( print_r( sqlsrv_errors(),true));
	
	/* Get ID Contract */
	$callContractID = "{call SP_GET_ID_M_CONTRACT_COMPANY(?,?)}";
	$paramsContractID = array(
							array($mappingId, SQLSRV_PARAM_IN),
							array($pefindoId,SQLSRV_PARAM_IN)
						);
	$execContractID = sqlsrv_query($conn, $callContractID, $paramsContractID) or die ( print_r( sqlsrv_errors(),true));
	$DataContract = sqlsrv_fetch_array($execContractID);
	$Contract_ID = $DataContract['M_CONTRACT_ID'];
	
	$x=0;
	/* Insert to collateral list where contract id */
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bAppraisalValue']['cCurrency'])){
		if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bAppraisalValue']['cCurrency']))
		{
			if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bAppraisalValue']['cCurrency']<>NULL){$ContCollatAppValueCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bAppraisalValue']['cCurrency'];}else{$ContCollatAppValueCur=NULL;}
			if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bAppraisalValue']['cValue']<>NULL){$ContCollatAppValueVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bAppraisalValue']['cValue'];}else{$ContCollatAppValueVal=NULL;}
		}else{
			$ContCollatAppValueVal=NULL;
			$ContCollatAppValueCur=NULL;
		}
		
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bBankValuationDate']['bBankValuationDate']<>NULL){$ContCollListBankValDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bBankValuationDate'];}else{$ContCollListBankValDate=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bBankValue']<>NULL){$ContCollListBankVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bBankValue'];}else{$ContCollListBankVal=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bBranch']<>NULL){$ContCollListBranch=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bBranch'];}else{$ContCollListBranch=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralAcceptanceDate']<>NULL){$ContCollListAccDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralAcceptanceDate'];}else{$ContCollListAccDate=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralAppraisalAuthority']<>NULL){$ContCollListAppAuthor=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralAppraisalAuthority'];}else{$ContCollListAppAuthor=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralCode']<>NULL){$ContCollListCode=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralCode'];}else{$ContCollListCode=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralDescription']<>NULL){$ContCollListDesc=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralDescription'];}else{$ContCollListDesc=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralOwnerName']<>NULL){$ContCollListOwnerName=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralOwnerName'];}else{$ContCollListOwnerName=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralRating']<>NULL){$ContCollListRating=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralRating'];}else{$ContCollListRating=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralStatus']<>NULL){$ContCollListStatus=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralStatus'];}else{$ContCollListStatus=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralType']<>NULL){$ContCollListType=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralType'];}else{$ContCollListType=NULL;}
		if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralValue']['cCurrency'])){
			if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralValue']['cCurrency']<>NULL){$ContCollListValueCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralValue']['cCurrency'];}else{$ContCollListValueCur=NULL;}
			if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralValue']['cValue']<>NULL){$ContCollListValueVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralValue']['cValue'];}else{$ContCollListValueVal=NULL;}
		}else{
			$ContCollListValueCur=NULL;
			$ContCollListValueVal=NULL;
		}
		
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bHasMultipleCollaterals']<>NULL){$ContCollListHasMultiColl=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bHasMultipleCollaterals'];}else{$ContCollListHasMultiColl=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bInsurance']<>NULL){$ContCollListInsurance=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bInsurance'];}else{$ContCollListInsurance=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bIsShared']<>NULL){$ContCollListIsShared=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bIsShared'];}else{$ContCollListIsShared=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bMainAddressAddressLine']<>NULL){$ContCollListMainAddLine=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bMainAddressAddressLine'];}else{$ContCollListMainAddLine=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bMainAddressCity']<>NULL){$ContCollListMainAddCity=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bMainAddressCity'];}else{$ContCollListMainAddCity=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bMainAddressStreet']<>NULL){$ContCollListMainAddStreet=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bMainAddressStreet'];}else{$ContCollListMainAddStreet=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bProofOfOwnership']<>NULL){$ContCollListProofOwner=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bProofOfOwnership'];}else{$ContCollListProofOwner=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bRatingAuthority']<>NULL){$ContCollListRatingAuthor=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bRatingAuthority'];}else{$ContCollListRatingAuthor=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bSecurityAssignmentType']<>NULL){$ContCollListSecAssgmnt=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bSecurityAssignmentType'];}else{$ContCollListSecAssgmnt=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bSharedPortion']<>NULL){$ContCollListSharedPortion=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bSharedPortion'];}else{$ContCollListSharedPortion=NULL;}			
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bValuationDate']<>NULL){$ContCollListValuationDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bValuationDate'];}else{$ContCollListValuationDate=NULL;}			
	
		$callContractCollateralList = "{call SP_INSERT_M_CONTRACT_COLLATERAL_LIST_COMPANY(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
		$paramsContractCollateralList = array(
										array($mappingId, SQLSRV_PARAM_IN),
										array($Contract_ID,SQLSRV_PARAM_IN),
										array($ContCollatAppValueCur,SQLSRV_PARAM_IN),
										array($ContCollatAppValueVal,SQLSRV_PARAM_IN),
										array($ContCollListBankValDate,SQLSRV_PARAM_IN),
										array($ContCollListBankVal,SQLSRV_PARAM_IN),
										array($ContCollListBranch,SQLSRV_PARAM_IN),
										array($ContCollListAccDate,SQLSRV_PARAM_IN),
										array($ContCollListAppAuthor,SQLSRV_PARAM_IN),
										array($ContCollListCode,SQLSRV_PARAM_IN),
										array($ContCollListDesc,SQLSRV_PARAM_IN),
										array($ContCollListOwnerName,SQLSRV_PARAM_IN),
										array($ContCollListRating,SQLSRV_PARAM_IN),
										array($ContCollListStatus,SQLSRV_PARAM_IN),
										array($ContCollListType,SQLSRV_PARAM_IN),
										array($ContCollListValueCur,SQLSRV_PARAM_IN),
										array($ContCollListValueVal,SQLSRV_PARAM_IN),
										array($ContCollListHasMultiColl,SQLSRV_PARAM_IN),
										array($ContCollListInsurance,SQLSRV_PARAM_IN),
										array($ContCollListIsShared,SQLSRV_PARAM_IN),
										array($ContCollListMainAddLine,SQLSRV_PARAM_IN),
										array($ContCollListMainAddCity,SQLSRV_PARAM_IN),
										array($ContCollListMainAddStreet,SQLSRV_PARAM_IN),
										array($ContCollListProofOwner,SQLSRV_PARAM_IN),
										array($ContCollListRatingAuthor,SQLSRV_PARAM_IN),
										array($ContCollListSecAssgmnt,SQLSRV_PARAM_IN),
										array($ContCollListSharedPortion,SQLSRV_PARAM_IN),
										array($ContCollListValuationDate,SQLSRV_PARAM_IN),
										);
		$execContractCollateralList = sqlsrv_query($conn, $callContractCollateralList, $paramsContractCollateralList) or die ( print_r( sqlsrv_errors(),true));
		$x++;
	}else{
		if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral'])){
			foreach($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral'] as $itemContCollList){								
				if(isset($itemContCollList['bAppraisalValue']['cCurrency'])){	
					if($itemContCollList['bAppraisalValue']['cCurrency']<>NULL){$ContCollatAppValueCur=$itemContCollList['bAppraisalValue']['cCurrency'];}else{$ContCollatAppValueCur=NULL;}
					if($itemContCollList['bAppraisalValue']['cValue']<>NULL){$ContCollatAppValueVal=$itemContCollList['bAppraisalValue']['cValue'];}else{$ContCollatAppValueVal=NULL;}						
				}else{
					$ContCollatAppValueCur=NULL;
					$ContCollatAppValueVal=NULL;
				}	
				if($itemContCollList['bBankValuationDate']<>NULL){$ContCollListBankValDate=$itemContCollList['bBankValuationDate'];}else{$ContCollListBankValDate=NULL;}						
				if($itemContCollList['bBankValue']<>NULL){$ContCollListBankVal=$itemContCollList['bBankValue'];}else{$ContCollListBankVal=NULL;}						
				if($itemContCollList['bBranch']<>NULL){$ContCollListBranch=$itemContCollList['bBranch'];}else{$ContCollListBranch=NULL;}
				if($itemContCollList['bCollateralAcceptanceDate']<>NULL){$ContCollListAccDate=$itemContCollList['bCollateralAcceptanceDate'];}else{$ContCollListAccDate=NULL;}					
				if($itemContCollList['bCollateralAppraisalAuthority']<>NULL){$ContCollListAppAuthor=$itemContCollList['bCollateralAppraisalAuthority'];}else{$ContCollListAppAuthor=NULL;}						
				if($itemContCollList['bCollateralCode']<>NULL){$ContCollListCode=$itemContCollList['bCollateralCode'];}else{$ContCollListCode=NULL;}						
				if($itemContCollList['bCollateralDescription']<>NULL){$ContCollListDesc=$itemContCollList['bCollateralDescription'];}else{$ContCollListDesc=NULL;}						
				if($itemContCollList['bCollateralOwnerName']<>NULL){$ContCollListOwnerName=$itemContCollList['bCollateralOwnerName'];}else{$ContCollListOwnerName=NULL;}						
				if($itemContCollList['bCollateralRating']<>NULL){$ContCollListRating=$itemContCollList['bCollateralRating'];}else{$ContCollListRating=NULL;}						
				if($itemContCollList['bCollateralStatus']<>NULL){$ContCollListStatus=$itemContCollList['bCollateralStatus'];}else{$ContCollListStatus=NULL;}						
				if($itemContCollList['bCollateralType']<>NULL){$ContCollListType=$itemContCollList['bCollateralType'];}else{$ContCollListType=NULL;}						
				if(isset($itemContCollList['bCollateralValue']['cCurrency'])){
					if($itemContCollList['bCollateralValue']['cCurrency']<>NULL){$ContCollListValueCur=$itemContCollList['bCollateralValue']['cCurrency'];}else{$ContCollListValueCur=NULL;}						
					if($itemContCollList['bCollateralValue']['cValue']<>NULL){$ContCollListValueVal=$itemContCollList['bCollateralValue']['cValue'];}else{$ContCollListValueVal=NULL;}						
				}else{
					$ContCollListValueCur=NULL;
					$ContCollListValueVal=NULL;
				}
				if($itemContCollList['bHasMultipleCollaterals']<>NULL){$ContCollListHasMultiColl=$itemContCollList['bHasMultipleCollaterals'];}else{$ContCollListHasMultiColl=NULL;}						
				if($itemContCollList['bInsurance']<>NULL){$ContCollListInsurance=$itemContCollList['bInsurance'];}else{$ContCollListInsurance=NULL;}						
				if($itemContCollList['bIsShared']<>NULL){$ContCollListIsShared=$itemContCollList['bIsShared'];}else{$ContCollListIsShared=NULL;}						
				if($itemContCollList['bMainAddressAddressLine']<>NULL){$ContCollListMainAddLine=$itemContCollList['bMainAddressAddressLine'];}else{$ContCollListMainAddLine=NULL;}						
				if($itemContCollList['bMainAddressCity']<>NULL){$ContCollListMainAddCity=$itemContCollList['bMainAddressCity'];}else{$ContCollListMainAddCity=NULL;}						
				if($itemContCollList['bMainAddressStreet']<>NULL){$ContCollListMainAddStreet=$itemContCollList['bMainAddressStreet'];}else{$ContCollListMainAddStreet=NULL;}						
				if($itemContCollList['bProofOfOwnership']<>NULL){$ContCollListProofOwner=$itemContCollList['bProofOfOwnership'];}else{$ContCollListProofOwner=NULL;}						
				if($itemContCollList['bRatingAuthority']<>NULL){$ContCollListRatingAuthor=$itemContCollList['bRatingAuthority'];}else{$ContCollListRatingAuthor=NULL;}						
				if($itemContCollList['bSecurityAssignmentType']<>NULL){$ContCollListSecAssgmnt=$itemContCollList['bSecurityAssignmentType'];}else{$ContCollListSecAssgmnt=NULL;}						
				if($itemContCollList['bSharedPortion']<>NULL){$ContCollListSharedPortion=$itemContCollList['bSharedPortion'];}else{$ContCollListSharedPortion=NULL;}									
				if($itemContCollList['bValuationDate']<>NULL){$ContCollListValuationDate=$itemContCollList['bValuationDate'];}else{$ContCollListValuationDate=NULL;}			
			
				$callContractCollateralList = "{call SP_INSERT_M_CONTRACT_COLLATERAL_LIST_COMPANY(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
				$paramsContractCollateralList = array(
												array($mappingId, SQLSRV_PARAM_IN),
												array($Contract_ID,SQLSRV_PARAM_IN),
												array($ContCollatAppValueCur,SQLSRV_PARAM_IN),
												array($ContCollatAppValueVal,SQLSRV_PARAM_IN),
												array($ContCollListBankValDate,SQLSRV_PARAM_IN),
												array($ContCollListBankVal,SQLSRV_PARAM_IN),
												array($ContCollListBranch,SQLSRV_PARAM_IN),
												array($ContCollListAccDate,SQLSRV_PARAM_IN),
												array($ContCollListAppAuthor,SQLSRV_PARAM_IN),
												array($ContCollListCode,SQLSRV_PARAM_IN),
												array($ContCollListDesc,SQLSRV_PARAM_IN),
												array($ContCollListOwnerName,SQLSRV_PARAM_IN),
												array($ContCollListRating,SQLSRV_PARAM_IN),
												array($ContCollListStatus,SQLSRV_PARAM_IN),
												array($ContCollListType,SQLSRV_PARAM_IN),
												array($ContCollListValueCur,SQLSRV_PARAM_IN),
												array($ContCollListValueVal,SQLSRV_PARAM_IN),
												array($ContCollListHasMultiColl,SQLSRV_PARAM_IN),
												array($ContCollListInsurance,SQLSRV_PARAM_IN),
												array($ContCollListIsShared,SQLSRV_PARAM_IN),
												array($ContCollListMainAddLine,SQLSRV_PARAM_IN),
												array($ContCollListMainAddCity,SQLSRV_PARAM_IN),
												array($ContCollListMainAddStreet,SQLSRV_PARAM_IN),
												array($ContCollListProofOwner,SQLSRV_PARAM_IN),
												array($ContCollListRatingAuthor,SQLSRV_PARAM_IN),
												array($ContCollListSecAssgmnt,SQLSRV_PARAM_IN),
												array($ContCollListSharedPortion,SQLSRV_PARAM_IN),
												array($ContCollListValuationDate,SQLSRV_PARAM_IN),
												);
				$execContractCollateralList = sqlsrv_query($conn, $callContractCollateralList, $paramsContractCollateralList) or die ( print_r( sqlsrv_errors(),true));
				$x++;
			}
		}
	}
	$x++;
	
	$y=0;
	/* Insert to payment calendar list where contract id */
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bDate'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bDate']<>NULL){$ContPayCalenderDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bDate'];}else{$ContPayCalenderDate=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bDelinquencyStatus']<>NULL){$ContPayCalenderDeliqStatus=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bDelinquencyStatus'];}else{$ContPayCalenderDeliqStatus=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bInterestRate']<>NULL){$ContPayCalenderIntRate=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bInterestRate'];}else{$ContPayCalenderIntRate=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bNegativeStatusOfContract']<>NULL){$ContPayCalenderNegativeStat=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bNegativeStatusOfContract'];}else{$ContPayCalenderNegativeStat=NULL;}
		if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bOutstandingAmount']['cCurrency'])){
			if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bOutstandingAmount']['cCurrency']<>NULL){$ContPayCalenderOutstandingCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bOutstandingAmount']['cCurrency'];}else{$ContPayCalenderOutstandingCur=NULL;}
			if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bOutstandingAmount']['cValue']<>NULL){$ContPayCalenderOutstandingVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bOutstandingAmount']['cValue'];}else{$ContPayCalenderOutstandingVal=NULL;}
		}else{
			$ContPayCalenderOutstandingCur=NULL;
			$ContPayCalenderOutstandingVal=NULL;
		}
		if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bPastDueAmount']['cCurrency'])){
			if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bPastDueAmount']['cCurrency']<>NULL){$ContPayCalenderPastDueAmountCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bPastDueAmount']['cCurrency'];}else{$ContPayCalenderPastDueAmountCur=NULL;}
			if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bPastDueAmount']['cValue']<>NULL){$ContPayCalenderPastDueAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bPastDueAmount']['cValue'];}else{$ContPayCalenderPastDueAmountVal=NULL;}
		}else{
			$ContPayCalenderPastDueAmountCur=NULL;
			$ContPayCalenderPastDueAmountVal=NULL;
		}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bPastDueDays']<>NULL){$ContPayCalenderPastDueDays=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bPastDueDays'];}else{$ContPayCalenderPastDueDays=NULL;}
		
		$callContractPayCalenderList = "{call SP_INSERT_M_CONTRACT_PAYMENT_CALENDAR_LIST_COMPANY(?,?,?,?,?,?,?,?,?,?,?)}";
		$paramsContractPayCalenderList = array(
										array($mappingId, SQLSRV_PARAM_IN),
										array($Contract_ID,SQLSRV_PARAM_IN),
										array($ContPayCalenderDate,SQLSRV_PARAM_IN),
										array($ContPayCalenderDeliqStatus,SQLSRV_PARAM_IN),
										array($ContPayCalenderIntRate,SQLSRV_PARAM_IN),
										array($ContPayCalenderNegativeStat,SQLSRV_PARAM_IN),
										array($ContPayCalenderOutstandingCur,SQLSRV_PARAM_IN),
										array($ContPayCalenderOutstandingVal,SQLSRV_PARAM_IN),
										array($ContPayCalenderPastDueAmountCur,SQLSRV_PARAM_IN),
										array($ContPayCalenderPastDueAmountVal,SQLSRV_PARAM_IN),
										array($ContPayCalenderPastDueDays,SQLSRV_PARAM_IN)												
										);
		$execContractPayCalenderList = sqlsrv_query($conn, $callContractPayCalenderList, $paramsContractPayCalenderList) or die ( print_r( sqlsrv_errors(),true));
		$y++;
	}else{
		if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem'])){
			foreach($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem'] as $ItemContPayCalenderList){
				if($ItemContPayCalenderList['bDate']<>NULL){$ContPayCalenderDate=$ItemContPayCalenderList['bDate'];}else{$ContPayCalenderDate=NULL;}				
				if($ItemContPayCalenderList['bDelinquencyStatus']<>NULL){$ContPayCalenderDeliqStatus=$ItemContPayCalenderList['bDelinquencyStatus'];}else{$ContPayCalenderDeliqStatus=NULL;}						
				if($ItemContPayCalenderList['bInterestRate']<>NULL){$ContPayCalenderIntRate=$ItemContPayCalenderList['bInterestRate'];}else{$ContPayCalenderIntRate=NULL;}						
				if($ItemContPayCalenderList['bNegativeStatusOfContract']<>NULL){$ContPayCalenderNegativeStat=$ItemContPayCalenderList['bNegativeStatusOfContract'];}else{$ContPayCalenderNegativeStat=NULL;}						
				if(isset($ItemContPayCalenderList['bOutstandingAmount']['cCurrency'])){	
					if($ItemContPayCalenderList['bOutstandingAmount']['cCurrency']<>NULL){$ContPayCalenderOutstandingCur=$ItemContPayCalenderList['bOutstandingAmount']['cCurrency'];}else{$ContPayCalenderOutstandingCur=NULL;}						
					if($ItemContPayCalenderList['bOutstandingAmount']['cValue']<>NULL){$ContPayCalenderOutstandingVal=$ItemContPayCalenderList['bOutstandingAmount']['cValue'];}else{$ContPayCalenderOutstandingVal=NULL;}			
				}else{
					$ContPayCalenderOutstandingCur=NULL;
					$ContPayCalenderOutstandingVal=NULL;
				}
				if(isset($ItemContPayCalenderList['bPastDueAmount']['cCurrency'])){
					if($ItemContPayCalenderList['bPastDueAmount']['cCurrency']<>NULL){$ContPayCalenderPastDueAmountCur=$ItemContPayCalenderList['bPastDueAmount']['cCurrency'];}else{$ContPayCalenderPastDueAmountCur=NULL;}				
					if($ItemContPayCalenderList['bPastDueAmount']['cValue']<>NULL){$ContPayCalenderPastDueAmountVal=$ItemContPayCalenderList['bPastDueAmount']['cValue'];}else{$ContPayCalenderPastDueAmountVal=NULL;}			
				}else{
					$ContPayCalenderPastDueAmountCur=NULL;
					$ContPayCalenderPastDueAmountVal=NULL;
				}
				if($ItemContPayCalenderList['bPastDueDays']<>NULL){$ContPayCalenderPastDueDays=$ItemContPayCalenderList['bPastDueDays'];}else{$ContPayCalenderPastDueDays=NULL;}									
				
				$callContractPayCalenderList = "{call SP_INSERT_M_CONTRACT_PAYMENT_CALENDAR_LIST_COMPANY(?,?,?,?,?,?,?,?,?,?,?)}";
				$paramsContractPayCalenderList = array(
												array($mappingId, SQLSRV_PARAM_IN),
												array($Contract_ID,SQLSRV_PARAM_IN),
												array($ContPayCalenderDate,SQLSRV_PARAM_IN),
												array($ContPayCalenderDeliqStatus,SQLSRV_PARAM_IN),
												array($ContPayCalenderIntRate,SQLSRV_PARAM_IN),
												array($ContPayCalenderNegativeStat,SQLSRV_PARAM_IN),
												array($ContPayCalenderOutstandingCur,SQLSRV_PARAM_IN),
												array($ContPayCalenderOutstandingVal,SQLSRV_PARAM_IN),
												array($ContPayCalenderPastDueAmountCur,SQLSRV_PARAM_IN),
												array($ContPayCalenderPastDueAmountVal,SQLSRV_PARAM_IN),
												array($ContPayCalenderPastDueDays,SQLSRV_PARAM_IN)												
												);
				$execContractPayCalenderList = sqlsrv_query($conn, $callContractPayCalenderList, $paramsContractPayCalenderList) or die ( print_r( sqlsrv_errors(),true));
				$y++;
			}
		}
	}
	$y++;
	
	/* Insert to related subject where contract id */
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bExpectedEndDate'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bExpectedEndDate']<>NULL){$ContRelatedSubExpect=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bExpectedEndDate'];}else{$ContRelatedSubExpect=NULL;}				
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bGuarancyDescription']<>NULL){$ContRelatedSubGuarancyDesc=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bGuarancyDescription'];}else{$ContRelatedSubGuarancyDesc=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bGuaranteeAmount']<>NULL){$ContRelatedSubGuarantAmount=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bGuaranteeAmount'];}else{$ContRelatedSubGuarantAmount=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bJointAccountSequence']<>NULL){$ContRelatedSubJointAccSeq=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bJointAccountSequence'];}else{$ContRelatedSubJointAccSeq=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bName']<>NULL){$ContRelatedSubName=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bName'];}else{$ContRelatedSubName=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bNationalID']<>NULL){$ContRelatedSubNational=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bNationalID'];}else{$ContRelatedSubNational=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bPassportNumber']<>NULL){$ContRelatedSubPassportNumb=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bPassportNumber'];}else{$ContRelatedSubPassportNumb=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bRealEndDate']<>NULL){$ContRelatedSubRealDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bRealEndDate'];}else{$ContRelatedSubRealDate=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bRegistrationNumber']<>NULL){$ContRelatedSubRegistNumb=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bRegistrationNumber'];}else{$ContRelatedSubRegistNumb=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bRoleOfClient']<>NULL){$ContRelatedSubRoleClient=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bRoleOfClient'];}else{$ContRelatedSubRoleClient=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bStartDate']<>NULL){$ContRelatedSubStartDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bStartDate'];}else{$ContRelatedSubStartDate=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bSubjectType']<>NULL){$ContRelatedSubType=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bSubjectType'];}else{$ContRelatedSubType=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bTaxNumber']<>NULL){$ContRelatedSubTaxNumb=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bTaxNumber'];}else{$ContRelatedSubTaxNumb=NULL;}	
	
		$callContractRelatedSubjec = "{call SP_INSERT_M_CONTRACT_RELATED_SUBJECT_COMPANY(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
		$paramsContractRelatedSubjec = array(
										array($mappingId, SQLSRV_PARAM_IN),
										array($Contract_ID,SQLSRV_PARAM_IN),
										array($ContRelatedSubExpect,SQLSRV_PARAM_IN),
										array($ContRelatedSubGuarancyDesc,SQLSRV_PARAM_IN),
										array($ContRelatedSubGuarantAmount,SQLSRV_PARAM_IN),
										array($ContRelatedSubJointAccSeq,SQLSRV_PARAM_IN),
										array($ContRelatedSubName,SQLSRV_PARAM_IN),
										array($ContRelatedSubNational,SQLSRV_PARAM_IN),
										array($ContRelatedSubPassportNumb,SQLSRV_PARAM_IN),
										array($ContRelatedSubRealDate,SQLSRV_PARAM_IN),
										array($ContRelatedSubRegistNumb,SQLSRV_PARAM_IN),
										array($ContRelatedSubRoleClient,SQLSRV_PARAM_IN),
										array($ContRelatedSubStartDate,SQLSRV_PARAM_IN),
										array($ContRelatedSubType,SQLSRV_PARAM_IN),
										array($ContRelatedSubTaxNumb,SQLSRV_PARAM_IN)
										);
		$execContractRelatedSubjec = sqlsrv_query($conn, $callContractRelatedSubjec, $paramsContractRelatedSubjec) or die ( print_r( sqlsrv_errors(),true));
		$z++;
	}else{
		if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject'])){
			foreach($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject'] as $ItemContRelatedSub){
				if($ItemContRelatedSub['bExpectedEndDate']<>NULL){$ContRelatedSubExpect=$ItemContRelatedSub['bExpectedEndDate'];}else{$ContRelatedSubExpect=NULL;}				
				if($ItemContRelatedSub['bGuarancyDescription']<>NULL){$ContRelatedSubGuarancyDesc=$ItemContRelatedSub['bGuarancyDescription'];}else{$ContRelatedSubGuarancyDesc=NULL;}
				if($ItemContRelatedSub['bGuaranteeAmount']<>NULL){$ContRelatedSubGuarantAmount=$ItemContRelatedSub['bGuaranteeAmount'];}else{$ContRelatedSubGuarantAmount=NULL;}
				if($ItemContRelatedSub['bJointAccountSequence']<>NULL){$ContRelatedSubJointAccSeq=$ItemContRelatedSub['bJointAccountSequence'];}else{$ContRelatedSubJointAccSeq=NULL;}
				if($ItemContRelatedSub['bName']<>NULL){$ContRelatedSubName=$ItemContRelatedSub['bName'];}else{$ContRelatedSubName=NULL;}
				if($ItemContRelatedSub['bNationalID']<>NULL){$ContRelatedSubNational=$ItemContRelatedSub['bNationalID'];}else{$ContRelatedSubNational=NULL;}
				if($ItemContRelatedSub['bPassportNumber']<>NULL){$ContRelatedSubPassportNumb=$ItemContRelatedSub['bPassportNumber'];}else{$ContRelatedSubPassportNumb=NULL;}
				if($ItemContRelatedSub['bRealEndDate']<>NULL){$ContRelatedSubRealDate=$ItemContRelatedSub['bRealEndDate'];}else{$ContRelatedSubRealDate=NULL;}
				if($ItemContRelatedSub['bRegistrationNumber']<>NULL){$ContRelatedSubRegistNumb=$ItemContRelatedSub['bRegistrationNumber'];}else{$ContRelatedSubRegistNumb=NULL;}
				if($ItemContRelatedSub['bRoleOfClient']<>NULL){$ContRelatedSubRoleClient=$ItemContRelatedSub['bRoleOfClient'];}else{$ContRelatedSubRoleClient=NULL;}
				if($ItemContRelatedSub['bStartDate']<>NULL){$ContRelatedSubStartDate=$ItemContRelatedSub['bStartDate'];}else{$ContRelatedSubStartDate=NULL;}
				if($ItemContRelatedSub['bSubjectType']<>NULL){$ContRelatedSubType=$ItemContRelatedSub['bSubjectType'];}else{$ContRelatedSubType=NULL;}
				if($ItemContRelatedSub['bTaxNumber']<>NULL){$ContRelatedSubTaxNumb=$ItemContRelatedSub['bTaxNumber'];}else{$ContRelatedSubTaxNumb=NULL;}	
				
				$callContractRelatedSubjec = "{call SP_INSERT_M_CONTRACT_RELATED_SUBJECT_COMPANY(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
				$paramsContractRelatedSubjec = array(
												array($mappingId, SQLSRV_PARAM_IN),
												array($Contract_ID,SQLSRV_PARAM_IN),
												array($ContRelatedSubExpect,SQLSRV_PARAM_IN),
												array($ContRelatedSubGuarancyDesc,SQLSRV_PARAM_IN),
												array($ContRelatedSubGuarantAmount,SQLSRV_PARAM_IN),
												array($ContRelatedSubJointAccSeq,SQLSRV_PARAM_IN),
												array($ContRelatedSubName,SQLSRV_PARAM_IN),
												array($ContRelatedSubNational,SQLSRV_PARAM_IN),
												array($ContRelatedSubPassportNumb,SQLSRV_PARAM_IN),
												array($ContRelatedSubRealDate,SQLSRV_PARAM_IN),
												array($ContRelatedSubRegistNumb,SQLSRV_PARAM_IN),
												array($ContRelatedSubRoleClient,SQLSRV_PARAM_IN),
												array($ContRelatedSubStartDate,SQLSRV_PARAM_IN),
												array($ContRelatedSubType,SQLSRV_PARAM_IN),
												array($ContRelatedSubTaxNumb,SQLSRV_PARAM_IN)
												);
				$execContractRelatedSubjec = sqlsrv_query($conn, $callContractRelatedSubjec, $paramsContractRelatedSubjec) or die ( print_r( sqlsrv_errors(),true));
				$z++;
			}
		}
	}
}else{
	$x=0;
	$y=0;
	$z=0;
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'])){
		foreach($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'] as $itemContract){
			if($itemContract['bBankBeneficiary']<>NULL){$ConctBankBenefic=$itemContract['bBankBeneficiary'];}else{$ConctBankBenefic=NULL;}			
			if($itemContract['bBranch']<>NULL){$ConctBranch=$itemContract['bBranch'];}else{$ConctBranch=NULL;}				
			if($itemContract['bConditionDate']<>NULL){$ConctCondDate=$itemContract['bConditionDate'];}else{$ConctCondDate=NULL;}				
			if($itemContract['bContractCode']<>NULL){$ConctCode=$itemContract['bContractCode'];}else{$ConctCode=NULL;}				
			if($itemContract['bContractCurrency']<>NULL){$ConctCurency=$itemContract['bContractCurrency'];}else{$ConctCurency=NULL;}				
			if($itemContract['bContractStatus']<>NULL){$ConctStatus=$itemContract['bContractStatus'];}else{$ConctStatus=NULL;}				
			if($itemContract['bContractSubtype']<>NULL){$ConctSubType=$itemContract['bContractSubtype'];}else{$ConctSubType=NULL;}
			if($itemContract['bContractType']<>NULL){$ConctType=$itemContract['bContractType'];}else{$ConctType=NULL;}			
			if($itemContract['bCreditCharacteristics']<>NULL){$ConctCreditChar=$itemContract['bCreditCharacteristics'];}else{$ConctCreditChar=NULL;}				
			if($itemContract['bCreditClassification']<>NULL){$ConctCreditClassifict=$itemContract['bCreditClassification'];}else{$ConctCreditClassifict=NULL;}				
			if($itemContract['bCreditUsageInLast30Days']<>NULL){$ConctCreditUsageLast30days=$itemContract['bCreditUsageInLast30Days'];}else{$ConctCreditUsageLast30days=NULL;}				
			if($itemContract['bCreditor']<>NULL){$ConctCreditor=$itemContract['bCreditor'];}else{$ConctCreditor=NULL;}				
			if($itemContract['bCreditorType']<>NULL){$ConctCreditorType=$itemContract['bCreditorType'];}else{$ConctCreditorType=NULL;}			
			if($itemContract['bDefaultDate']<>NULL){$ConctDefaultDate=$itemContract['bDefaultDate'];}else{$ConctDefaultDate=NULL;}			
			if($itemContract['bDefaultReason']<>NULL){$ConctDefaultReason=$itemContract['bDefaultReason'];}else{$ConctDefaultReason=NULL;}				
			if($itemContract['bDefaultReasonDescription']<>NULL){$ConctDefaultReasonDesc=$itemContract['bDefaultReasonDescription'];}else{$ConctDefaultReasonDesc=NULL;}				
			if($itemContract['bDelinquencyDate']<>NULL){$ConctDeleqDate=$itemContract['bDelinquencyDate'];}else{$ConctDeleqDate=NULL;}			
			if($itemContract['bDescription']<>NULL){$ConctDescription=$itemContract['bDescription'];}else{$ConctDescription=NULL;}				
			if($itemContract['bDisbursementDate']<>NULL){$ConctDisBursDate=$itemContract['bDisbursementDate'];}else{$ConctDisBursDate=NULL;}			
			if($itemContract['bDisputes']['bClosedDisputes']<>NULL){$ConctDispCloseDisp=$itemContract['bDisputes']['bClosedDisputes'];}else{$ConctDispCloseDisp=NULL;}				
			if($itemContract['bDisputes']['bDisputeList']<>NULL){$ConctDispList=$itemContract['bDisputes']['bDisputeList'];}else{$ConctDispList=NULL;}				
			if($itemContract['bDisputes']['bFalseDisputes']<>NULL){$ConctDispFalse=$itemContract['bDisputes']['bFalseDisputes'];}else{$ConctDispFalse=NULL;}
			if($itemContract['bEconomicSector']<>NULL){$ConctEconomicSector=$itemContract['bEconomicSector'];}else{$ConctEconomicSector=NULL;}			
			if($itemContract['bGovernmentProgram']<>NULL){$ConctGovernProg=$itemContract['bGovernmentProgram'];}else{$ConctGovernProg=NULL;}			
			if(isset($itemContract['bGuarantyDeposit']['cCurrency'])){
				if($itemContract['bGuarantyDeposit']['cCurrency']<>NULL){$ConctGuarantDepoCur=$itemContract['bGuarantyDeposit']['cCurrency'];}else{$ConctGuarantDepoCur=NULL;}
				if($itemContract['bGuarantyDeposit']['cValue']<>NULL){$ConctGuarantDepoVal=$itemContract['bGuarantyDeposit']['cValue'];}else{$ConctGuarantDepoVal=NULL;}		
			}else{
				$ConctGuarantDepoCur=NULL;
				$ConctGuarantDepoVal=NULL;
			}
			if($itemContract['bInitialAgreementDate']<>NULL){$ConctInitialAgrmntDate=$itemContract['bInitialAgreementDate'];}else{$ConctInitialAgrmntDate=NULL;}				
			if($itemContract['bInitialAgreementNumber']<>NULL){$ConctInitialAgrmntNumb=$itemContract['bInitialAgreementNumber'];}else{$ConctInitialAgrmntNumb=NULL;}					
			if($itemContract['bInitialInterestRate']<>NULL){$ConctInterestRate=$itemContract['bInitialInterestRate'];}else{$ConctInterestRate=NULL;}				
			if($itemContract['bInitialInterestRateType']<>NULL){$ConctInterestRateType=$itemContract['bInitialInterestRateType'];}else{$ConctInterestRateType=NULL;}							
			if($itemContract['bInitialRestructuringDate']<>NULL){$ConctInitRestcDate=$itemContract['bInitialRestructuringDate'];}else{$ConctInitRestcDate=NULL;}				
			if(isset($itemContract['bInitialTotalAmount']['cCurrency'])){
				if($itemContract['bInitialTotalAmount']['cCurrency']<>NULL){$ConctInitTotAmountCur=$itemContract['bInitialTotalAmount']['cCurrency'];}else{$ConctInitTotAmountCur=NULL;}
				if($itemContract['bInitialTotalAmount']['cValue']<>NULL){$ConctInitTotAmountVal=$itemContract['bInitialTotalAmount']['cValue'];}else{$ConctInitTotAmountVal=NULL;}				
			}else{
				$ConctInitTotAmountCur=NULL;
				$ConctInitTotAmountVal=NULL;
			}
			if(isset($itemContract['bInterestArrears']['cCurrency'])){
				if($itemContract['bInterestArrears']['cCurrency']<>NULL){$ConctIntArreasCur=$itemContract['bInterestArrears']['cCurrency'];}else{$ConctIntArreasCur=NULL;}
				if($itemContract['bInterestArrears']['cValue']<>NULL){$ConctIntArreasVal=$itemContract['bInterestArrears']['cValue'];}else{$ConctIntArreasVal=NULL;}				
			}else{
				$ConctIntArreasCur=NULL;
				$ConctIntArreasVal=NULL;
			}
			if($itemContract['bInterestArrearsFrequency']<>NULL){$ConctIntArrearsFreq=$itemContract['bInterestArrearsFrequency'];}else{$ConctIntArrearsFreq=NULL;}			
			if($itemContract['bLastAgreementDate']<>NULL){$ConctLastAgrmntDate=$itemContract['bLastAgreementDate'];}else{$ConctLastAgrmntDate=NULL;}			
			if($itemContract['bLastAgreementNumber']<>NULL){$ConctLastAgrmntNumb=$itemContract['bLastAgreementNumber'];}else{$ConctLastAgrmntNumb=NULL;}			
			if($itemContract['bLastDelinquency90PlusDays']<>NULL){$ConctLastDeleq90days=$itemContract['bLastDelinquency90PlusDays'];}else{$ConctLastDeleq90days=NULL;}			
			if($itemContract['bLastUpdate']<>NULL){$ConctLastUpdate=$itemContract['bLastUpdate'];}else{$ConctLastUpdate=NULL;}			
			if($itemContract['bMaturityDate']<>NULL){$ConctMaturyDate=$itemContract['bMaturityDate'];}else{$ConctMaturyDate=NULL;}			
			if($itemContract['bNameOfInsured']<>NULL){$ConctNameInsured=$itemContract['bNameOfInsured'];}else{$ConctNameInsured=NULL;}			
			if($itemContract['bNegativeStatusOfContract']<>NULL){$ConctNegativeStatContact=$itemContract['bNegativeStatusOfContract'];}else{$ConctNegativeStatContact=NULL;}			
			if($itemContract['bOrientationOfUse']<>NULL){$ConctOrietationUse=$itemContract['bOrientationOfUse'];}else{$ConctOrietationUse=NULL;}			
			if(isset($itemContract['bOutstandingAmount']['cCurrency'])){
				if($itemContract['bOutstandingAmount']['cCurrency']<>NULL){$ConctOutStandingAmountCur=$itemContract['bOutstandingAmount']['cCurrency'];}else{$ConctOutStandingAmountCur=NULL;}
				if($itemContract['bOutstandingAmount']['cValue']<>NULL){$ConctOutStandingAmountVal=$itemContract['bOutstandingAmount']['cValue'];}else{$ConctOutStandingAmountVal=NULL;}			
			}else{
				$ConctOutStandingAmountCur=NULL;
				$ConctOutStandingAmountVal=NULL;
			}
			if(isset($itemContract['bPastDueAmount']['cCurrency'])){
				if($itemContract['bPastDueAmount']['cCurrency']<>NULL){$ConctPastDueAmountCur=$itemContract['bPastDueAmount']['cCurrency'];}else{$ConctPastDueAmountCur=NULL;}
				if($itemContract['bPastDueAmount']['cValue']<>NULL){$ConctPastDueAmountVal=$itemContract['bPastDueAmount']['cValue'];}else{$ConctPastDueAmountVal=NULL;}			
			}else{
				$ConctPastDueAmountCur=NULL;
				$ConctPastDueAmountVal=NULL;
			}
			if($itemContract['bPastDueDays']<>NULL){$ConctPastDueDays=$itemContract['bPastDueDays'];}else{$ConctPastDueDays=NULL;}			
			if(isset($itemContract['bPastDueInterest']['cCurrency'])){
				if($itemContract['bPastDueInterest']['cCurrency']<>NULL){$ConctPastDueIntCur=$itemContract['bPastDueInterest']['cCurrency'];}else{$ConctPastDueIntCur=NULL;}
				if($itemContract['bPastDueInterest']['cValue']<>NULL){$ConctPastDueIntVal=$itemContract['bPastDueInterest']['cValue'];}else{$ConctPastDueIntVal=NULL;}		
			}else{
				$ConctPastDueIntCur=NULL;
				$ConctPastDueIntVal=NULL;
			}
			if(isset($itemContract['bPenalty']['cCurrency'])){
				if($itemContract['bPenalty']['cCurrency']<>NULL){$ConctPenaltyCur=$itemContract['bPenalty']['cCurrency'];}else{$ConctPenaltyCur=NULL;}
				if($itemContract['bPenalty']['cValue']<>NULL){$ConctPenaltyVal=$itemContract['bPenalty']['cValue'];}else{$ConctPenaltyVal=NULL;}			
			}else{
				$ConctPenaltyCur=NULL;
				$ConctPenaltyVal=NULL;
			}
			if($itemContract['bPhaseOfContract']<>NULL){$ConctPhaseConctract=$itemContract['bPhaseOfContract'];}else{$ConctPhaseConctract=NULL;}			
			if($itemContract['bPrincipalArrearsFrequency']<>NULL){$ConctPrincipArreasFreq=$itemContract['bPrincipalArrearsFrequency'];}else{$ConctPrincipArreasFreq=NULL;}						
			if(isset($itemContract['bPrincipalArrears']['cCurrency'])){
				if($itemContract['bPrincipalArrears']['cCurrency']<>NULL){$ConctPrincipArreasCur=$itemContract['bPrincipalArrears']['cCurrency'];}else{$ConctPrincipArreasCur=NULL;}
				if($itemContract['bPrincipalArrears']['cValue']<>NULL){$ConctPrincipArreasVal=$itemContract['bPrincipalArrears']['cValue'];}else{$ConctPrincipArreasVal=NULL;}			
			}else{
				$ConctPrincipArreasCur=NULL;
				$ConctPrincipArreasCur=NULL;
			}
			if(isset($itemContract['bPrincipalBalance']['cCurrency'])){
				if($itemContract['bPrincipalBalance']['cCurrency']<>NULL){$ConctPrincipBalCur=$itemContract['bPrincipalBalance']['cCurrency'];}else{$ConctPrincipBalCur=NULL;}
				if($itemContract['bPrincipalBalance']['cValue']<>NULL){$ConctPrincipBalVal=$itemContract['bPrincipalBalance']['cValue'];}else{$ConctPrincipBalVal=NULL;}			
			}else{
				$ConctPrincipBalCur=NULL;
				$ConctPrincipBalVal=NULL;
			}
			if($itemContract['bProjectLocation']<>NULL){$ConctProjLoc=$itemContract['bProjectLocation'];}else{$ConctProjLoc=NULL;}						
			if(isset($itemContract['bProjectValue']['cCurrency'])){
				if($itemContract['bProjectValue']['cCurrency']<>NULL){$ConctProjValCur=$itemContract['bProjectValue']['cCurrency'];}else{$ConctProjValCur=NULL;}			
				if($itemContract['bProjectValue']['cValue']<>NULL){$ConctProjValVal=$itemContract['bProjectValue']['cValue'];}else{$ConctProjValVal=NULL;}			
			}else{
				$ConctProjValCur=NULL;
				$ConctProjValVal=NULL;
			}
			if($itemContract['bProlongationCounter']<>NULL){$ConctProloCounter=$itemContract['bProlongationCounter'];}else{$ConctProloCounter=NULL;}			
			if($itemContract['bPurposeOfFinancing']<>NULL){$ConctPurposeFinance=$itemContract['bPurposeOfFinancing'];}else{$ConctPurposeFinance=NULL;}			
			if($itemContract['bRealEndDate']<>NULL){$ConctRealandDate=$itemContract['bRealEndDate'];}else{$ConctRealandDate=NULL;}			
			if($itemContract['bRestructuredCount']<>NULL){$ConctRestrucCount=$itemContract['bRestructuredCount'];}else{$ConctRestrucCount=NULL;}			
			if($itemContract['bRestructuringDate']<>NULL){$ConctRestrucDate=$itemContract['bRestructuringDate'];}else{$ConctRestrucDate=NULL;}			
			if($itemContract['bRestructuringReason']<>NULL){$ConctRestrucReason=$itemContract['bRestructuringReason'];}else{$ConctRestrucReason=NULL;}			
			if($itemContract['bRoleOfClient']<>NULL){$ConctRoleOfClient=$itemContract['bRoleOfClient'];}else{$ConctRoleOfClient=NULL;}			
			if($itemContract['bStartDate']<>NULL){$ConctStartDate=$itemContract['bStartDate'];}else{$ConctStartDate=NULL;}			
			if($itemContract['bSyndicatedLoan']<>NULL){$ConctSydicatLoan=$itemContract['bSyndicatedLoan'];}else{$ConctSydicatLoan=NULL;}			
			if(isset($itemContract['bTotalAmount']['cCurrency'])){
				if($itemContract['bTotalAmount']['cCurrency']<>NULL){$ConctTotAmountCur=$itemContract['bTotalAmount']['cCurrency'];}else{$ConctTotAmountCur=NULL;}
				if($itemContract['bTotalAmount']['cValue']<>NULL){$ConctTotAmountVal=$itemContract['bTotalAmount']['cValue'];}else{$ConctTotAmountVal=NULL;}			
			}else{
				$ConctTotAmountCur=NULL;
				$ConctTotAmountVal=NULL;
			}
			if(isset($itemContract['bTotalFacilityAmount']['cCurrency'])){
				if($itemContract['bTotalFacilityAmount']['cCurrency']<>NULL){$ConctTotFaciltyAmountCur=$itemContract['bTotalFacilityAmount']['cCurrency'];}else{$ConctTotFaciltyAmountCur=NULL;}
				if($itemContract['bTotalFacilityAmount']['cValue']<>NULL){$ConctTotFaciltyAmountVal=$itemContract['bTotalFacilityAmount']['cValue'];}else{$ConctTotFaciltyAmountVal=NULL;}			
			}else{
				$ConctTotFaciltyAmountCur=NULL;
				$ConctTotFaciltyAmountVal=NULL;
			}
			if(isset($itemContract['bTotalTakenAmount']['cCurrency'])){
				if($itemContract['bTotalTakenAmount']['cCurrency']<>NULL){$ConctTotTakenAmountCur=$itemContract['bTotalTakenAmount']['cCurrency'];}else{$ConctTotTakenAmountCur=NULL;}
				if($itemContract['bTotalTakenAmount']['cValue']<>NULL){$ConctTotTakenAmountVal=$itemContract['bTotalTakenAmount']['cValue'];}else{$ConctTotTakenAmountVal=NULL;}			
			}else{
				$ConctTotTakenAmountCur=NULL;
				$ConctTotTakenAmountVal=NULL;
			}
			if(isset($itemContract['bWorstPastDueAmount']['cCurrency'])){
				if($itemContract['bWorstPastDueAmount']['cCurrency']<>NULL){$ConctWorstPastDueAmountCur=$itemContract['bWorstPastDueAmount']['cCurrency'];}else{$ConctWorstPastDueAmountCur=NULL;}
				if($itemContract['bWorstPastDueAmount']['cValue']<>NULL){$ConctWorstPastDueAmountVal=$itemContract['bWorstPastDueAmount']['cValue'];}else{$ConctWorstPastDueAmountVal=NULL;}					
			}else{
				$ConctWorstPastDueAmountCur=NULL;
				$ConctWorstPastDueAmountVal=NULL;
			}
			if($itemContract['bWorstPastDueDays']<>NULL){$ConctWorstPastDueDays=$itemContract['bWorstPastDueDays'];}else{$ConctWorstPastDueDays=NULL;}
			
			$callContract = "{call sp_insert_M_contract_COMPANY(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
			$paramsContract = array(
										array($mappingId, SQLSRV_PARAM_IN),
										array($pefindoId,SQLSRV_PARAM_IN),
										array($ConctBankBenefic,SQLSRV_PARAM_IN),
										array($ConctBranch,SQLSRV_PARAM_IN),
										array($ConctCondDate,SQLSRV_PARAM_IN),
										array($ConctCode,SQLSRV_PARAM_IN),
										array($ConctCurency,SQLSRV_PARAM_IN),
										array($ConctStatus,SQLSRV_PARAM_IN),
										array($ConctSubType,SQLSRV_PARAM_IN),
										array($ConctType,SQLSRV_PARAM_IN),
										array($ConctCreditChar,SQLSRV_PARAM_IN),
										array($ConctCreditClassifict,SQLSRV_PARAM_IN),
										array($ConctCreditUsageLast30days,SQLSRV_PARAM_IN),
										array($ConctCreditor,SQLSRV_PARAM_IN),
										array($ConctCreditorType,SQLSRV_PARAM_IN),
										array($ConctDefaultDate,SQLSRV_PARAM_IN),
										array($ConctDefaultReason,SQLSRV_PARAM_IN),
										array($ConctDefaultReasonDesc,SQLSRV_PARAM_IN),
										array($ConctDeleqDate,SQLSRV_PARAM_IN),
										array($ConctDescription,SQLSRV_PARAM_IN),
										array($ConctDisBursDate,SQLSRV_PARAM_IN),
										array($ConctDispCloseDisp,SQLSRV_PARAM_IN),
										array(NULL,SQLSRV_PARAM_IN), //$ConctDispList
										array($ConctDispFalse,SQLSRV_PARAM_IN),
										array($ConctEconomicSector,SQLSRV_PARAM_IN),
										array($ConctGovernProg,SQLSRV_PARAM_IN),
										array($ConctGuarantDepoCur,SQLSRV_PARAM_IN), //$ConctGuarantDepoCur
										array($ConctGuarantDepoVal,SQLSRV_PARAM_IN),
										array($ConctInitialAgrmntDate,SQLSRV_PARAM_IN),
										array($ConctInitialAgrmntNumb,SQLSRV_PARAM_IN),
										array($ConctInterestRate,SQLSRV_PARAM_IN),
										array($ConctInterestRateType,SQLSRV_PARAM_IN),
										array($ConctInitRestcDate,SQLSRV_PARAM_IN),
										array($ConctInitTotAmountCur,SQLSRV_PARAM_IN),
										array($ConctInitTotAmountVal,SQLSRV_PARAM_IN),
										array($ConctIntArreasCur,SQLSRV_PARAM_IN),
										array($ConctIntArreasVal,SQLSRV_PARAM_IN),
										array($ConctIntArrearsFreq,SQLSRV_PARAM_IN),
										array($ConctLastAgrmntDate,SQLSRV_PARAM_IN),
										array($ConctLastAgrmntNumb,SQLSRV_PARAM_IN),
										array($ConctLastDeleq90days,SQLSRV_PARAM_IN),
										array($ConctLastUpdate,SQLSRV_PARAM_IN),
										array($ConctMaturyDate,SQLSRV_PARAM_IN),
										array($ConctNameInsured,SQLSRV_PARAM_IN),
										array($ConctNegativeStatContact,SQLSRV_PARAM_IN),
										array($ConctOrietationUse,SQLSRV_PARAM_IN),
										array($ConctOutStandingAmountCur,SQLSRV_PARAM_IN),
										array($ConctOutStandingAmountVal,SQLSRV_PARAM_IN),
										array($ConctPastDueAmountCur,SQLSRV_PARAM_IN),
										array($ConctPastDueAmountVal,SQLSRV_PARAM_IN),
										array($ConctPastDueDays,SQLSRV_PARAM_IN),
										array($ConctPastDueIntCur,SQLSRV_PARAM_IN),
										array($ConctPastDueIntVal,SQLSRV_PARAM_IN),
										array($ConctPenaltyCur,SQLSRV_PARAM_IN),
										array($ConctPenaltyVal,SQLSRV_PARAM_IN),
										array($ConctPhaseConctract,SQLSRV_PARAM_IN),
										array($ConctPrincipArreasCur,SQLSRV_PARAM_IN),
										array($ConctPrincipArreasVal,SQLSRV_PARAM_IN),
										array($ConctPrincipArreasFreq,SQLSRV_PARAM_IN),
										array($ConctPrincipBalCur,SQLSRV_PARAM_IN),
										array($ConctPrincipBalVal,SQLSRV_PARAM_IN),
										array($ConctProjLoc,SQLSRV_PARAM_IN),
										array($ConctProjValCur,SQLSRV_PARAM_IN), //$ConctProjValCur
										array($ConctProjValVal,SQLSRV_PARAM_IN),
										array($ConctProloCounter,SQLSRV_PARAM_IN),
										array($ConctPurposeFinance,SQLSRV_PARAM_IN),
										array($ConctRealandDate,SQLSRV_PARAM_IN),
										array($ConctRestrucCount,SQLSRV_PARAM_IN),
										array($ConctRestrucDate,SQLSRV_PARAM_IN),
										array($ConctRestrucReason,SQLSRV_PARAM_IN),
										array($ConctRoleOfClient,SQLSRV_PARAM_IN),
										array($ConctStartDate,SQLSRV_PARAM_IN),
										array($ConctSydicatLoan,SQLSRV_PARAM_IN),
										array($ConctTotAmountCur,SQLSRV_PARAM_IN),
										array($ConctTotAmountVal,SQLSRV_PARAM_IN),
										array($ConctTotFaciltyAmountCur,SQLSRV_PARAM_IN),
										array($ConctTotFaciltyAmountVal,SQLSRV_PARAM_IN),
										array($ConctTotTakenAmountCur,SQLSRV_PARAM_IN),
										array($ConctTotTakenAmountVal,SQLSRV_PARAM_IN),
										array($ConctWorstPastDueAmountCur,SQLSRV_PARAM_IN),
										array($ConctWorstPastDueAmountVal,SQLSRV_PARAM_IN),
										array($ConctWorstPastDueDays,SQLSRV_PARAM_IN)
									);
			$execContract = sqlsrv_query($conn, $callContract, $paramsContract) or die ( print_r( sqlsrv_errors(),true));

			/* Get ID Contract */
			$callContractID = "{call SP_GET_ID_M_CONTRACT_COMPANY(?,?)}";
			$paramsContractID = array(
									array($mappingId, SQLSRV_PARAM_IN),
									array($pefindoId,SQLSRV_PARAM_IN)
								);
			$execContractID = sqlsrv_query($conn, $callContractID, $paramsContractID) or die ( print_r( sqlsrv_errors(),true));
			$DataContract = sqlsrv_fetch_array($execContractID);
			$Contract_ID = $DataContract['M_CONTRACT_ID'];
			
			$x=0;
			/* Insert to collateral list where contract id */
			if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bAppraisalValue']['cCurrency'])){
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bAppraisalValue']['cCurrency']<>NULL){$ContCollatAppValueCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bAppraisalValue']['cCurrency'];}else{$ContCollatAppValueCur=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bAppraisalValue']['cValue']<>NULL){$ContCollatAppValueVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bAppraisalValue']['cValue'];}else{$ContCollatAppValueVal=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bBankValuationDate']<>NULL){$ContCollListBankValDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bBankValuationDate'];}else{$ContCollListBankValDate=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bBankValue']<>NULL){$ContCollListBankVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bBankValue'];}else{$ContCollListBankVal=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bBranch']<>NULL){$ContCollListBranch=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bBranch'];}else{$ContCollListBranch=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralAcceptanceDate']<>NULL){$ContCollListAccDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralAcceptanceDate'];}else{$ContCollListAccDate=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralAppraisalAuthority']<>NULL){$ContCollListAppAuthor=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralAppraisalAuthority'];}else{$ContCollListAppAuthor=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralCode']<>NULL){$ContCollListCode=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralCode'];}else{$ContCollListCode=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralDescription']<>NULL){$ContCollListDesc=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralDescription'];}else{$ContCollListDesc=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralOwnerName']<>NULL){$ContCollListOwnerName=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralOwnerName'];}else{$ContCollListOwnerName=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralRating']<>NULL){$ContCollListRating=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralRating'];}else{$ContCollListRating=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralStatus']<>NULL){$ContCollListStatus=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralStatus'];}else{$ContCollListStatus=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralType']<>NULL){$ContCollListType=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralType'];}else{$ContCollListType=NULL;}
				if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralValue']['cCurrency'])){
					if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralValue']['cCurrency']<>NULL){$ContCollListValueCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralValue']['cCurrency'];}else{$ContCollListValueCur=NULL;}
					if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralValue']['cValue']<>NULL){$ContCollListValueVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bCollateralValue']['cValue'];}else{$ContCollListValueVal=NULL;}
				}else{
					$ContCollListValueCur=NULL;
					$ContCollListValueVal=NULL;
				}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bHasMultipleCollaterals']<>NULL){$ContCollListHasMultiColl=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bHasMultipleCollaterals'];}else{$ContCollListHasMultiColl=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bInsurance']<>NULL){$ContCollListInsurance=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bInsurance'];}else{$ContCollListInsurance=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bIsShared']<>NULL){$ContCollListIsShared=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bIsShared'];}else{$ContCollListIsShared=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bMainAddressAddressLine']<>NULL){$ContCollListMainAddLine=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bMainAddressAddressLine'];}else{$ContCollListMainAddLine=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bMainAddressCity']<>NULL){$ContCollListMainAddCity=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bMainAddressCity'];}else{$ContCollListMainAddCity=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bMainAddressStreet']<>NULL){$ContCollListMainAddStreet=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bMainAddressStreet'];}else{$ContCollListMainAddStreet=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bProofOfOwnership']<>NULL){$ContCollListProofOwner=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bProofOfOwnership'];}else{$ContCollListProofOwner=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bRatingAuthority']<>NULL){$ContCollListRatingAuthor=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bRatingAuthority'];}else{$ContCollListRatingAuthor=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bSecurityAssignmentType']<>NULL){$ContCollListSecAssgmnt=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bSecurityAssignmentType'];}else{$ContCollListSecAssgmnt=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bSharedPortion']<>NULL){$ContCollListSharedPortion=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bSharedPortion'];}else{$ContCollListSharedPortion=NULL;}			
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bValuationDate']<>NULL){$ContCollListValuationDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral']['bValuationDate'];}else{$ContCollListValuationDate=NULL;}			
			
				$callContractCollateralList = "{call SP_INSERT_M_CONTRACT_COLLATERAL_LIST_COMPANY(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
				$paramsContractCollateralList = array(
												array($mappingId, SQLSRV_PARAM_IN),
												array($Contract_ID,SQLSRV_PARAM_IN),
												array($ContCollatAppValueCur,SQLSRV_PARAM_IN),
												array($ContCollatAppValueVal,SQLSRV_PARAM_IN),
												array($ContCollListBankValDate,SQLSRV_PARAM_IN),
												array($ContCollListBankVal,SQLSRV_PARAM_IN),
												array($ContCollListBranch,SQLSRV_PARAM_IN),
												array($ContCollListAccDate,SQLSRV_PARAM_IN),
												array($ContCollListAppAuthor,SQLSRV_PARAM_IN),
												array($ContCollListCode,SQLSRV_PARAM_IN),
												array($ContCollListDesc,SQLSRV_PARAM_IN),
												array($ContCollListOwnerName,SQLSRV_PARAM_IN),
												array($ContCollListRating,SQLSRV_PARAM_IN),
												array($ContCollListStatus,SQLSRV_PARAM_IN),
												array($ContCollListType,SQLSRV_PARAM_IN),
												array($ContCollListValueCur,SQLSRV_PARAM_IN),
												array($ContCollListValueVal,SQLSRV_PARAM_IN),
												array($ContCollListHasMultiColl,SQLSRV_PARAM_IN),
												array($ContCollListInsurance,SQLSRV_PARAM_IN),
												array($ContCollListIsShared,SQLSRV_PARAM_IN),
												array($ContCollListMainAddLine,SQLSRV_PARAM_IN),
												array($ContCollListMainAddCity,SQLSRV_PARAM_IN),
												array($ContCollListMainAddStreet,SQLSRV_PARAM_IN),
												array($ContCollListProofOwner,SQLSRV_PARAM_IN),
												array($ContCollListRatingAuthor,SQLSRV_PARAM_IN),
												array($ContCollListSecAssgmnt,SQLSRV_PARAM_IN),
												array($ContCollListSharedPortion,SQLSRV_PARAM_IN),
												array($ContCollListValuationDate,SQLSRV_PARAM_IN),
												);
				$execContractCollateralList = sqlsrv_query($conn, $callContractCollateralList, $paramsContractCollateralList) or die ( print_r( sqlsrv_errors(),true));
				$x++;
			}else{
				if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral'])){
					foreach($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$x]['bCollateralsList']['bCollateral'] as $itemContCollList){								
						if($itemContCollList['bAppraisalValue']['cCurrency']<>NULL){$ContCollatAppValueCur=$itemContCollList['bAppraisalValue']['cCurrency'];}else{$ContCollatAppValueCur=NULL;}
						if($itemContCollList['bAppraisalValue']['cValue']<>NULL){$ContCollatAppValueVal=$itemContCollList['bAppraisalValue']['cValue'];}else{$ContCollatAppValueVal=NULL;}						
						if($itemContCollList['bBankValuationDate']<>NULL){$ContCollListBankValDate=$itemContCollList['bBankValuationDate'];}else{$ContCollListBankValDate=NULL;}						
						if($itemContCollList['bBankValue']<>NULL){$ContCollListBankVal=$itemContCollList['bBankValue'];}else{$ContCollListBankVal=NULL;}						
						if($itemContCollList['bBranch']<>NULL){$ContCollListBranch=$itemContCollList['bBranch'];}else{$ContCollListBranch=NULL;}
						if($itemContCollList['bCollateralAcceptanceDate']<>NULL){$ContCollListAccDate=$itemContCollList['bCollateralAcceptanceDate'];}else{$ContCollListAccDate=NULL;}					
						if($itemContCollList['bCollateralAppraisalAuthority']<>NULL){$ContCollListAppAuthor=$itemContCollList['bCollateralAppraisalAuthority'];}else{$ContCollListAppAuthor=NULL;}						
						if($itemContCollList['bCollateralCode']<>NULL){$ContCollListCode=$itemContCollList['bCollateralCode'];}else{$ContCollListCode=NULL;}						
						if($itemContCollList['bCollateralDescription']<>NULL){$ContCollListDesc=$itemContCollList['bCollateralDescription'];}else{$ContCollListDesc=NULL;}						
						if($itemContCollList['bCollateralOwnerName']<>NULL){$ContCollListOwnerName=$itemContCollList['bCollateralOwnerName'];}else{$ContCollListOwnerName=NULL;}						
						if($itemContCollList['bCollateralRating']<>NULL){$ContCollListRating=$itemContCollList['bCollateralRating'];}else{$ContCollListRating=NULL;}						
						if($itemContCollList['bCollateralStatus']<>NULL){$ContCollListStatus=$itemContCollList['bCollateralStatus'];}else{$ContCollListStatus=NULL;}						
						if($itemContCollList['bCollateralType']<>NULL){$ContCollListType=$itemContCollList['bCollateralType'];}else{$ContCollListType=NULL;}						
						if(isset($itemContCollList['bCollateralValue']['cCurrency'])){	
							if($itemContCollList['bCollateralValue']['cCurrency']<>NULL){$ContCollListValueCur=$itemContCollList['bCollateralValue']['cCurrency'];}else{$ContCollListValueCur=NULL;}						
							if($itemContCollList['bCollateralValue']['cValue']<>NULL){$ContCollListValueVal=$itemContCollList['bCollateralValue']['cValue'];}else{$ContCollListValueVal=NULL;}						
						}else{
							$ContCollListValueCur=NULL;
							$ContCollListValueVal=NULL;
						}
						if($itemContCollList['bHasMultipleCollaterals']<>NULL){$ContCollListHasMultiColl=$itemContCollList['bHasMultipleCollaterals'];}else{$ContCollListHasMultiColl=NULL;}						
						if($itemContCollList['bInsurance']<>NULL){$ContCollListInsurance=$itemContCollList['bInsurance'];}else{$ContCollListInsurance=NULL;}						
						if($itemContCollList['bIsShared']<>NULL){$ContCollListIsShared=$itemContCollList['bIsShared'];}else{$ContCollListIsShared=NULL;}						
						if($itemContCollList['bMainAddressAddressLine']<>NULL){$ContCollListMainAddLine=$itemContCollList['bMainAddressAddressLine'];}else{$ContCollListMainAddLine=NULL;}						
						if($itemContCollList['bMainAddressCity']<>NULL){$ContCollListMainAddCity=$itemContCollList['bMainAddressCity'];}else{$ContCollListMainAddCity=NULL;}						
						if($itemContCollList['bMainAddressStreet']<>NULL){$ContCollListMainAddStreet=$itemContCollList['bMainAddressStreet'];}else{$ContCollListMainAddStreet=NULL;}						
						if($itemContCollList['bProofOfOwnership']<>NULL){$ContCollListProofOwner=$itemContCollList['bProofOfOwnership'];}else{$ContCollListProofOwner=NULL;}						
						if($itemContCollList['bRatingAuthority']<>NULL){$ContCollListRatingAuthor=$itemContCollList['bRatingAuthority'];}else{$ContCollListRatingAuthor=NULL;}						
						if($itemContCollList['bSecurityAssignmentType']<>NULL){$ContCollListSecAssgmnt=$itemContCollList['bSecurityAssignmentType'];}else{$ContCollListSecAssgmnt=NULL;}						
						if($itemContCollList['bSharedPortion']<>NULL){$ContCollListSharedPortion=$itemContCollList['bSharedPortion'];}else{$ContCollListSharedPortion=NULL;}									
						if($itemContCollList['bValuationDate']<>NULL){$ContCollListValuationDate=$itemContCollList['bValuationDate'];}else{$ContCollListValuationDate=NULL;}			
					
						$callContractCollateralList = "{call SP_INSERT_M_CONTRACT_COLLATERAL_LIST_COMPANY(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
						$paramsContractCollateralList = array(
														array($mappingId, SQLSRV_PARAM_IN),
														array($Contract_ID,SQLSRV_PARAM_IN),
														array($ContCollatAppValueCur,SQLSRV_PARAM_IN),
														array($ContCollatAppValueVal,SQLSRV_PARAM_IN),
														array($ContCollListBankValDate,SQLSRV_PARAM_IN),
														array($ContCollListBankVal,SQLSRV_PARAM_IN),
														array($ContCollListBranch,SQLSRV_PARAM_IN),
														array($ContCollListAccDate,SQLSRV_PARAM_IN),
														array($ContCollListAppAuthor,SQLSRV_PARAM_IN),
														array($ContCollListCode,SQLSRV_PARAM_IN),
														array($ContCollListDesc,SQLSRV_PARAM_IN),
														array($ContCollListOwnerName,SQLSRV_PARAM_IN),
														array($ContCollListRating,SQLSRV_PARAM_IN),
														array($ContCollListStatus,SQLSRV_PARAM_IN),
														array($ContCollListType,SQLSRV_PARAM_IN),
														array($ContCollListValueCur,SQLSRV_PARAM_IN),
														array($ContCollListValueVal,SQLSRV_PARAM_IN),
														array($ContCollListHasMultiColl,SQLSRV_PARAM_IN),
														array($ContCollListInsurance,SQLSRV_PARAM_IN),
														array($ContCollListIsShared,SQLSRV_PARAM_IN),
														array($ContCollListMainAddLine,SQLSRV_PARAM_IN),
														array($ContCollListMainAddCity,SQLSRV_PARAM_IN),
														array($ContCollListMainAddStreet,SQLSRV_PARAM_IN),
														array($ContCollListProofOwner,SQLSRV_PARAM_IN),
														array($ContCollListRatingAuthor,SQLSRV_PARAM_IN),
														array($ContCollListSecAssgmnt,SQLSRV_PARAM_IN),
														array($ContCollListSharedPortion,SQLSRV_PARAM_IN),
														array($ContCollListValuationDate,SQLSRV_PARAM_IN),
														);
						$execContractCollateralList = sqlsrv_query($conn, $callContractCollateralList, $paramsContractCollateralList) or die ( print_r( sqlsrv_errors(),true));
						$x++;
					}
				}
			}
			$x++;
			
			$y=0;
			/* Insert to payment calendar list where contract id */ 
			if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bDate'])){
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bDate']<>NULL){$ContPayCalenderDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bDate'];}else{$ContPayCalenderDate=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bDelinquencyStatus']<>NULL){$ContPayCalenderDeliqStatus=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bDelinquencyStatus'];}else{$ContPayCalenderDeliqStatus=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bInterestRate']<>NULL){$ContPayCalenderIntRate=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bInterestRate'];}else{$ContPayCalenderIntRate=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bNegativeStatusOfContract']<>NULL){$ContPayCalenderNegativeStat=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bNegativeStatusOfContract'];}else{$ContPayCalenderNegativeStat=NULL;}
				if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bOutstandingAmount']['cCurrency'])){
					if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bOutstandingAmount']['cCurrency']<>NULL){$ContPayCalenderOutstandingCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bOutstandingAmount']['cCurrency'];}else{$ContPayCalenderOutstandingCur=NULL;}
					if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bOutstandingAmount']['cValue']<>NULL){$ContPayCalenderOutstandingVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bOutstandingAmount']['cValue'];}else{$ContPayCalenderOutstandingVal=NULL;}
				}else{
					$ContPayCalenderOutstandingCur=NULL;
					$ContPayCalenderOutstandingVal=NULL;
				}
				if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bPastDueAmount']['cCurrency'])){
					if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bPastDueAmount']['cCurrency']<>NULL){$ContPayCalenderPastDueAmountCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bPastDueAmount']['cCurrency'];}else{$ContPayCalenderPastDueAmountCur=NULL;}
					if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bPastDueAmount']['cValue']<>NULL){$ContPayCalenderPastDueAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bPastDueAmount']['cValue'];}else{$ContPayCalenderPastDueAmountVal=NULL;}
				}else{
					$ContPayCalenderPastDueAmountCur=NULL;
					$ContPayCalenderPastDueAmountVal=NULL;
				}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bPastDueDays']<>NULL){$ContPayCalenderPastDueDays=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem']['bPastDueDays'];}else{$ContPayCalenderPastDueDays=NULL;}
				
				$callContractPayCalenderList = "{call SP_INSERT_M_CONTRACT_PAYMENT_CALENDAR_LIST_COMPANY(?,?,?,?,?,?,?,?,?,?,?)}";
				$paramsContractPayCalenderList = array(
												array($mappingId, SQLSRV_PARAM_IN),
												array($Contract_ID,SQLSRV_PARAM_IN),
												array($ContPayCalenderDate,SQLSRV_PARAM_IN),
												array($ContPayCalenderDeliqStatus,SQLSRV_PARAM_IN),
												array($ContPayCalenderIntRate,SQLSRV_PARAM_IN),
												array($ContPayCalenderNegativeStat,SQLSRV_PARAM_IN),
												array($ContPayCalenderOutstandingCur,SQLSRV_PARAM_IN),
												array($ContPayCalenderOutstandingVal,SQLSRV_PARAM_IN),
												array($ContPayCalenderPastDueAmountCur,SQLSRV_PARAM_IN),
												array($ContPayCalenderPastDueAmountVal,SQLSRV_PARAM_IN),
												array($ContPayCalenderPastDueDays,SQLSRV_PARAM_IN)												
												);
				$execContractPayCalenderList = sqlsrv_query($conn, $callContractPayCalenderList, $paramsContractPayCalenderList) or die ( print_r( sqlsrv_errors(),true));
				$y++;
			}else{
				if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem'])){
					foreach($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$y]['bPaymentCalendarList']['bCalendarItem'] as $ItemContPayCalenderList){
						if($ItemContPayCalenderList['bDate']<>NULL){$ContPayCalenderDate=$ItemContPayCalenderList['bDate'];}else{$ContPayCalenderDate=NULL;}				
						if($ItemContPayCalenderList['bDelinquencyStatus']<>NULL){$ContPayCalenderDeliqStatus=$ItemContPayCalenderList['bDelinquencyStatus'];}else{$ContPayCalenderDeliqStatus=NULL;}						
						if($ItemContPayCalenderList['bInterestRate']<>NULL){$ContPayCalenderIntRate=$ItemContPayCalenderList['bInterestRate'];}else{$ContPayCalenderIntRate=NULL;}						
						if($ItemContPayCalenderList['bNegativeStatusOfContract']<>NULL){$ContPayCalenderNegativeStat=$ItemContPayCalenderList['bNegativeStatusOfContract'];}else{$ContPayCalenderNegativeStat=NULL;}						
						if(isset($ItemContPayCalenderList['bOutstandingAmount']['cCurrency'])){	
							if($ItemContPayCalenderList['bOutstandingAmount']['cCurrency']<>NULL){$ContPayCalenderOutstandingCur=$ItemContPayCalenderList['bOutstandingAmount']['cCurrency'];}else{$ContPayCalenderOutstandingCur=NULL;}						
							if($ItemContPayCalenderList['bOutstandingAmount']['cValue']<>NULL){$ContPayCalenderOutstandingVal=$ItemContPayCalenderList['bOutstandingAmount']['cValue'];}else{$ContPayCalenderOutstandingVal=NULL;}			
						}else{
							$ContPayCalenderOutstandingCur=NULL;
							$ContPayCalenderOutstandingVal=NULL;
						}
						if(isset($ItemContPayCalenderList['bPastDueAmount']['cCurrency'])){
							if($ItemContPayCalenderList['bPastDueAmount']['cCurrency']<>NULL){$ContPayCalenderPastDueAmountCur=$ItemContPayCalenderList['bPastDueAmount']['cCurrency'];}else{$ContPayCalenderPastDueAmountCur=NULL;}				
							if($ItemContPayCalenderList['bPastDueAmount']['cValue']<>NULL){$ContPayCalenderPastDueAmountVal=$ItemContPayCalenderList['bPastDueAmount']['cValue'];}else{$ContPayCalenderPastDueAmountVal=NULL;}			
						}else{
							$ContPayCalenderPastDueAmountCur=NULL;
							$ContPayCalenderPastDueAmountVal=NULL;
						}
						if($ItemContPayCalenderList['bPastDueDays']<>NULL){$ContPayCalenderPastDueDays=$ItemContPayCalenderList['bPastDueDays'];}else{$ContPayCalenderPastDueDays=NULL;}									
						
						$callContractPayCalenderList = "{call SP_INSERT_M_CONTRACT_PAYMENT_CALENDAR_LIST_COMPANY(?,?,?,?,?,?,?,?,?,?,?)}";
						$paramsContractPayCalenderList = array(
														array($mappingId, SQLSRV_PARAM_IN),
														array($Contract_ID,SQLSRV_PARAM_IN),
														array($ContPayCalenderDate,SQLSRV_PARAM_IN),
														array($ContPayCalenderDeliqStatus,SQLSRV_PARAM_IN),
														array($ContPayCalenderIntRate,SQLSRV_PARAM_IN),
														array($ContPayCalenderNegativeStat,SQLSRV_PARAM_IN),
														array($ContPayCalenderOutstandingCur,SQLSRV_PARAM_IN),
														array($ContPayCalenderOutstandingVal,SQLSRV_PARAM_IN),
														array($ContPayCalenderPastDueAmountCur,SQLSRV_PARAM_IN),
														array($ContPayCalenderPastDueAmountVal,SQLSRV_PARAM_IN),
														array($ContPayCalenderPastDueDays,SQLSRV_PARAM_IN)												
														);
						$execContractPayCalenderList = sqlsrv_query($conn, $callContractPayCalenderList, $paramsContractPayCalenderList) or die ( print_r( sqlsrv_errors(),true));
						$y++;
					}
				}
			}
			$y++;
			
			/* Insert to related subject where contract id */
			if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bExpectedEndDate'])){
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bExpectedEndDate']<>NULL){$ContRelatedSubExpect=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bExpectedEndDate'];}else{$ContRelatedSubExpect=NULL;}				
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bGuarancyDescription']<>NULL){$ContRelatedSubGuarancyDesc=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bGuarancyDescription'];}else{$ContRelatedSubGuarancyDesc=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bGuaranteeAmount']<>NULL){$ContRelatedSubGuarantAmount=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bGuaranteeAmount'];}else{$ContRelatedSubGuarantAmount=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bJointAccountSequence']<>NULL){$ContRelatedSubJointAccSeq=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bJointAccountSequence'];}else{$ContRelatedSubJointAccSeq=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bName']<>NULL){$ContRelatedSubName=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bName'];}else{$ContRelatedSubName=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bNationalID']<>NULL){$ContRelatedSubNational=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bNationalID'];}else{$ContRelatedSubNational=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bPassportNumber']<>NULL){$ContRelatedSubPassportNumb=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bPassportNumber'];}else{$ContRelatedSubPassportNumb=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bRealEndDate']<>NULL){$ContRelatedSubRealDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bRealEndDate'];}else{$ContRelatedSubRealDate=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bRegistrationNumber']<>NULL){$ContRelatedSubRegistNumb=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bRegistrationNumber'];}else{$ContRelatedSubRegistNumb=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bRoleOfClient']<>NULL){$ContRelatedSubRoleClient=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bRoleOfClient'];}else{$ContRelatedSubRoleClient=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bStartDate']<>NULL){$ContRelatedSubStartDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bStartDate'];}else{$ContRelatedSubStartDate=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bSubjectType']<>NULL){$ContRelatedSubType=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bSubjectType'];}else{$ContRelatedSubType=NULL;}
				if($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bTaxNumber']<>NULL){$ContRelatedSubTaxNumb=$array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject']['bTaxNumber'];}else{$ContRelatedSubTaxNumb=NULL;}	
			
				$callContractRelatedSubjec = "{call SP_INSERT_M_CONTRACT_RELATED_SUBJECT_COMPANY(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
				$paramsContractRelatedSubjec = array(
												array($mappingId, SQLSRV_PARAM_IN),
												array($Contract_ID,SQLSRV_PARAM_IN),
												array($ContRelatedSubExpect,SQLSRV_PARAM_IN),
												array($ContRelatedSubGuarancyDesc,SQLSRV_PARAM_IN),
												array($ContRelatedSubGuarantAmount,SQLSRV_PARAM_IN),
												array($ContRelatedSubJointAccSeq,SQLSRV_PARAM_IN),
												array($ContRelatedSubName,SQLSRV_PARAM_IN),
												array($ContRelatedSubNational,SQLSRV_PARAM_IN),
												array($ContRelatedSubPassportNumb,SQLSRV_PARAM_IN),
												array($ContRelatedSubRealDate,SQLSRV_PARAM_IN),
												array($ContRelatedSubRegistNumb,SQLSRV_PARAM_IN),
												array($ContRelatedSubRoleClient,SQLSRV_PARAM_IN),
												array($ContRelatedSubStartDate,SQLSRV_PARAM_IN),
												array($ContRelatedSubType,SQLSRV_PARAM_IN),
												array($ContRelatedSubTaxNumb,SQLSRV_PARAM_IN)
												);
				$execContractRelatedSubjec = sqlsrv_query($conn, $callContractRelatedSubjec, $paramsContractRelatedSubjec) or die ( print_r( sqlsrv_errors(),true));
				$z++;
			}else{
				if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject'])){
					foreach($array['GetCustomReportResponse']['GetCustomReportResult']['aContracts']['bContractList']['bContract'][$z]['bRelatedSubjectsList']['bRelatedSubject'] as $ItemContRelatedSub){
						if($ItemContRelatedSub['bExpectedEndDate']<>NULL){$ContRelatedSubExpect=$ItemContRelatedSub['bExpectedEndDate'];}else{$ContRelatedSubExpect=NULL;}				
						if($ItemContRelatedSub['bGuarancyDescription']<>NULL){$ContRelatedSubGuarancyDesc=$ItemContRelatedSub['bGuarancyDescription'];}else{$ContRelatedSubGuarancyDesc=NULL;}
						if($ItemContRelatedSub['bGuaranteeAmount']<>NULL){$ContRelatedSubGuarantAmount=$ItemContRelatedSub['bGuaranteeAmount'];}else{$ContRelatedSubGuarantAmount=NULL;}
						if($ItemContRelatedSub['bJointAccountSequence']<>NULL){$ContRelatedSubJointAccSeq=$ItemContRelatedSub['bJointAccountSequence'];}else{$ContRelatedSubJointAccSeq=NULL;}
						if($ItemContRelatedSub['bName']<>NULL){$ContRelatedSubName=$ItemContRelatedSub['bName'];}else{$ContRelatedSubName=NULL;}
						if($ItemContRelatedSub['bNationalID']<>NULL){$ContRelatedSubNational=$ItemContRelatedSub['bNationalID'];}else{$ContRelatedSubNational=NULL;}
						if($ItemContRelatedSub['bPassportNumber']<>NULL){$ContRelatedSubPassportNumb=$ItemContRelatedSub['bPassportNumber'];}else{$ContRelatedSubPassportNumb=NULL;}
						if($ItemContRelatedSub['bRealEndDate']<>NULL){$ContRelatedSubRealDate=$ItemContRelatedSub['bRealEndDate'];}else{$ContRelatedSubRealDate=NULL;}
						if($ItemContRelatedSub['bRegistrationNumber']<>NULL){$ContRelatedSubRegistNumb=$ItemContRelatedSub['bRegistrationNumber'];}else{$ContRelatedSubRegistNumb=NULL;}
						if($ItemContRelatedSub['bRoleOfClient']<>NULL){$ContRelatedSubRoleClient=$ItemContRelatedSub['bRoleOfClient'];}else{$ContRelatedSubRoleClient=NULL;}
						if($ItemContRelatedSub['bStartDate']<>NULL){$ContRelatedSubStartDate=$ItemContRelatedSub['bStartDate'];}else{$ContRelatedSubStartDate=NULL;}
						if($ItemContRelatedSub['bSubjectType']<>NULL){$ContRelatedSubType=$ItemContRelatedSub['bSubjectType'];}else{$ContRelatedSubType=NULL;}
						if($ItemContRelatedSub['bTaxNumber']<>NULL){$ContRelatedSubTaxNumb=$ItemContRelatedSub['bTaxNumber'];}else{$ContRelatedSubTaxNumb=NULL;}	
						
						$callContractRelatedSubjec = "{call SP_INSERT_M_CONTRACT_RELATED_SUBJECT_COMPANY(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
						$paramsContractRelatedSubjec = array(
														array($mappingId, SQLSRV_PARAM_IN),
														array($Contract_ID,SQLSRV_PARAM_IN),
														array($ContRelatedSubExpect,SQLSRV_PARAM_IN),
														array($ContRelatedSubGuarancyDesc,SQLSRV_PARAM_IN),
														array($ContRelatedSubGuarantAmount,SQLSRV_PARAM_IN),
														array($ContRelatedSubJointAccSeq,SQLSRV_PARAM_IN),
														array($ContRelatedSubName,SQLSRV_PARAM_IN),
														array($ContRelatedSubNational,SQLSRV_PARAM_IN),
														array($ContRelatedSubPassportNumb,SQLSRV_PARAM_IN),
														array($ContRelatedSubRealDate,SQLSRV_PARAM_IN),
														array($ContRelatedSubRegistNumb,SQLSRV_PARAM_IN),
														array($ContRelatedSubRoleClient,SQLSRV_PARAM_IN),
														array($ContRelatedSubStartDate,SQLSRV_PARAM_IN),
														array($ContRelatedSubType,SQLSRV_PARAM_IN),
														array($ContRelatedSubTaxNumb,SQLSRV_PARAM_IN)
														);
						$execContractRelatedSubjec = sqlsrv_query($conn, $callContractRelatedSubjec, $paramsContractRelatedSubjec) or die ( print_r( sqlsrv_errors(),true));
						$z++;
					}
				}
			}
		}
	}
}
?>