<?php
/* Involment List */
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bConditionDate'])){
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']<>NULL){$Involments=$array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement'];}else{$Involments=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bConditionDate']<>NULL){$involmentCondDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bConditionDate'];}else{$involmentCondDate=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bContractCode']<>NULL){$involmentContractDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bContractCode'];}else{$involmentContractDateDate=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bCreditor']<>NULL){$involmentCreditor=$array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bCreditor'];}else{$involmentCreditor=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bCurrencyOfContract']<>NULL){$involmentCurrOfContract=$array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bCurrencyOfContract'];}else{$involmentCurrOfContract=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bDefaultDate']<>NULL){$involmentDefaultDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bDefaultDate'];}else{$involmentDefaultDate=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bDefaultReason']<>NULL){$involmentDefaultReason=$array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bDefaultReason'];}else{$involmentDefaultReason=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bDefaultReasonDescription']<>NULL){$involmentDefaultReasonDesc=$array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bDefaultReasonDescription'];}else{$involmentDefaultReasonDesc=NULL;}
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bInitialTotalAmount']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bInitialTotalAmount']['cCurrency']<>NULL){$involmentInitTotAmountCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bInitialTotalAmount']['cCurrency'];}else{$involmentInitTotAmountCur=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bInitialTotalAmount']['cValue']<>NULL){$involmentInitTotAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bInitialTotalAmount']['cValue'];}else{$involmentInitTotAmountVal=NULL;}	
	}else{
		$involmentInitTotAmountCur=NULL;
		$involmentInitTotAmountVal=NULL;
	}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bInvolvementPurpose']<>NULL){$involmentPurpose=$array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bInvolvementPurpose'];}else{$involmentPurpose=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bLastUpdate']<>NULL){$involmentLastUpt=$array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bLastUpdate'];}else{$involmentLastUpt=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bNegativeStatus']<>NULL){$involmentNegativeStat=$array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bNegativeStatus'];}else{$involmentNegativeStat=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bRealEndDate']<>NULL){$involmentRealDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bRealEndDate'];}else{$involmentRealDate=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bStartDate']<>NULL){$involmentStartDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bStartDate'];}else{$involmentStartDate=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bStatus']<>NULL){$involmentStatus=$array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bStatus'];}else{$involmentStatus=NULL;}
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bTotalAmount']['cCurrency'])){
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bTotalAmount']['cCurrency']<>NULL){$involmentTotAmountCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bTotalAmount']['cCurrency'];}else{$involmentTotAmountCur=NULL;}
		if($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bTotalAmount']['cValue']<>NULL){$involmentTotAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement']['bTotalAmount']['cValue'];}else{$involmentTotAmountVal=NULL;}	
	}else{
		$involmentTotAmountCur=NULL;
		$involmentTotAmountVal=NULL;
	}

	$callInvolmentsList = "{call SP_INSERT_INVOLVEMENTS_LIST_COMPANY(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramsInvolmentsList = array(
						array($mappingId, SQLSRV_PARAM_IN),
						array($pefindoId,SQLSRV_PARAM_IN),
						array(NULL,SQLSRV_PARAM_IN),
						array($involmentCondDate,SQLSRV_PARAM_IN),
						array($involmentContractDate,SQLSRV_PARAM_IN),
						array($involmentCreditor,SQLSRV_PARAM_IN),
						array($involmentCurrOfContract,SQLSRV_PARAM_IN),
						array($involmentDefaultDate,SQLSRV_PARAM_IN),
						array($involmentDefaultReason,SQLSRV_PARAM_IN),
						array($involmentDefaultReasonDesc,SQLSRV_PARAM_IN),
						array($involmentInitTotAmountCur,SQLSRV_PARAM_IN),
						array($involmentInitTotAmountVal,SQLSRV_PARAM_IN),
						array($involmentPurpose,SQLSRV_PARAM_IN),
						array($involmentLastUpt,SQLSRV_PARAM_IN),
						array($involmentNegativeStat,SQLSRV_PARAM_IN),
						array($involmentRealDate,SQLSRV_PARAM_IN),
						array($involmentStartDate,SQLSRV_PARAM_IN),
						array($involmentStatus,SQLSRV_PARAM_IN),
						array($involmentTotAmountCur,SQLSRV_PARAM_IN),
						array($involmentTotAmountVal,SQLSRV_PARAM_IN));
	$execInvolmentsList = sqlsrv_query($conn, $callInvolmentsList, $paramsInvolmentsList) or die ( print_r( sqlsrv_errors(),true));
}else{
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement'])){
		foreach($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bInvolvementList']['bInvolvement'] as $itemInvolvementList){
			if($itemInvolvementList['bConditionDate']<>NULL){$involmentCondDate=$itemInvolvementList['bConditionDate'];}else{$involmentCondDate=NULL;}
			if($itemInvolvementList['bContractCode']<>NULL){$involmentContractDate=$itemInvolvementList['bContractCode'];}else{$involmentContractDateDate=NULL;}
			if($itemInvolvementList['bCreditor']<>NULL){$involmentCreditor=$itemInvolvementList['bCreditor'];}else{$involmentCreditor=NULL;}
			if($itemInvolvementList['bCurrencyOfContract']<>NULL){$involmentCurrOfContract=$itemInvolvementList['bCurrencyOfContract'];}else{$involmentCurrOfContract=NULL;}
			if($itemInvolvementList['bDefaultDate']<>NULL){$involmentDefaultDate=$itemInvolvementList['bDefaultDate'];}else{$involmentDefaultDate=NULL;}
			if($itemInvolvementList['bDefaultReason']<>NULL){$involmentDefaultReason=$itemInvolvementList['bDefaultReason'];}else{$involmentDefaultReason=NULL;}
			if($itemInvolvementList['bDefaultReasonDescription']<>NULL){$involmentDefaultReasonDesc=$itemInvolvementList['bDefaultReasonDescription'];}else{$involmentDefaultReasonDesc=NULL;}
			if(isset($itemInvolvementList['bInitialTotalAmount']['cCurrency'])){
				if($itemInvolvementList['bInitialTotalAmount']['cCurrency']<>NULL){$involmentInitTotAmountCur=$itemInvolvementList['bInitialTotalAmount']['cCurrency'];}else{$involmentInitTotAmountCur=NULL;}
				if($itemInvolvementList['bInitialTotalAmount']['cValue']<>NULL){$involmentInitTotAmountVal=$itemInvolvementList['bInitialTotalAmount']['cValue'];}else{$involmentInitTotAmountVal=NULL;}	
			}else{
				$involmentInitTotAmountCur=NULL;
				$involmentInitTotAmountVal=NULL;
			}
			if($itemInvolvementList['bInvolvementPurpose']<>NULL){$involmentPurpose=$itemInvolvementList['bInvolvementPurpose'];}else{$involmentPurpose=NULL;}
			if($itemInvolvementList['bLastUpdate']<>NULL){$involmentLastUpt=$itemInvolvementList['bLastUpdate'];}else{$involmentLastUpt=NULL;}
			if($itemInvolvementList['bNegativeStatus']<>NULL){$involmentNegativeStat=$itemInvolvementList['bNegativeStatus'];}else{$involmentNegativeStat=NULL;}
			if($itemInvolvementList['bRealEndDate']<>NULL){$involmentRealDate=$itemInvolvementList['bRealEndDate'];}else{$involmentRealDate=NULL;}
			if($itemInvolvementList['bStartDate']<>NULL){$involmentStartDate=$itemInvolvementList['bStartDate'];}else{$involmentStartDate=NULL;}
			if($itemInvolvementList['bStatus']<>NULL){$involmentStatus=$itemInvolvementList['bStatus'];}else{$involmentStatus=NULL;}
			if(isset($itemInvolvementList['bTotalAmount']['cCurrency'])){
				if($itemInvolvementList['bTotalAmount']['cCurrency']<>NULL){$involmentTotAmountCur=$itemInvolvementList['bTotalAmount']['cCurrency'];}else{$involmentTotAmountCur=NULL;}
				if($itemInvolvementList['bTotalAmount']['cValue']<>NULL){$involmentTotAmountVal=$itemInvolvementList['bTotalAmount']['cValue'];}else{$involmentTotAmountVal=NULL;}	
			}else{
				$involmentTotAmountCur=NULL;
				$involmentTotAmountVal=NULL;
			}
			
			$callInvolmentsList = "{call SP_INSERT_INVOLVEMENTS_LIST_COMPANY(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
			$paramsInvolmentsList = array(
								array($mappingId, SQLSRV_PARAM_IN),
								array($pefindoId,SQLSRV_PARAM_IN),
								array(NULL,SQLSRV_PARAM_IN),
								array($involmentCondDate,SQLSRV_PARAM_IN),
								array($involmentContractDate,SQLSRV_PARAM_IN),
								array($involmentCreditor,SQLSRV_PARAM_IN),
								array($involmentCurrOfContract,SQLSRV_PARAM_IN),
								array($involmentDefaultDate,SQLSRV_PARAM_IN),
								array($involmentDefaultReason,SQLSRV_PARAM_IN),
								array($involmentDefaultReasonDesc,SQLSRV_PARAM_IN),
								array($involmentInitTotAmountCur,SQLSRV_PARAM_IN),
								array($involmentInitTotAmountVal,SQLSRV_PARAM_IN),
								array($involmentPurpose,SQLSRV_PARAM_IN),
								array($involmentLastUpt,SQLSRV_PARAM_IN),
								array($involmentNegativeStat,SQLSRV_PARAM_IN),
								array($involmentRealDate,SQLSRV_PARAM_IN),
								array($involmentStartDate,SQLSRV_PARAM_IN),
								array($involmentStatus,SQLSRV_PARAM_IN),
								array($involmentTotAmountCur,SQLSRV_PARAM_IN),
								array($involmentTotAmountVal,SQLSRV_PARAM_IN));
			$execInvolmentsList = sqlsrv_query($conn, $callInvolmentsList, $paramsInvolmentsList) or die ( print_r( sqlsrv_errors(),true));
		}
	}
}

/* Involment Summary */
if($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bSummary']['bNumberOfActiveInvolvements']<>NULL){$InvolNumbActive=$array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bSummary']['bNumberOfActiveInvolvements'];}else{$InvolNumbActive=NULL;}	
if($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bSummary']['bNumberOfPastInvolvements']<>NULL){$InvolNumbPast=$array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bSummary']['bNumberOfPastInvolvements'];}else{$InvolNumbPast=NULL;}
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bSummary']['bTotalAmountOfActiveInvolvements']['cCurrency'])){
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bSummary']['bTotalAmountOfActiveInvolvements']['cCurrency']<>NULL){$InvolTotAmountActiveCur=$array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bSummary']['bTotalAmountOfActiveInvolvements']['cCurrency'];}else{$InvolTotAmountActiveCur=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bSummary']['bTotalAmountOfActiveInvolvements']['cValue']<>NULL){$InvolTotAmountActiveVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aInvolvements']['bSummary']['bTotalAmountOfActiveInvolvements']['cValue'];}else{$InvolTotAmountActiveVal=NULL;}	
}else{
	$InvolTotAmountActiveCur = NULL;
	$InvolTotAmountActiveVal = NULL;
}
$callInvolmentsSum = "{call SP_INSERT_INVOLVEMENTS_SUMMARY_COMPANY(?,?,?,?,?,?)}";
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