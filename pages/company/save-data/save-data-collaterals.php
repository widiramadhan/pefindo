<?php
/* Collateral List Company*/
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bAppraisalValue'])){
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bAppraisalValue']<>NULL){$AppraiseVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bAppraisalValue']['cCurrency']." ".$array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bAppraisalValue']['cValue'];}else{$AppraiseVal=NULL;}				
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bBankValue']['cCurrency']<>NULL){$BankCurency=$array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bBankValue']['cCurrency'];}else{$BankCurency=NULL;}				
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bBankValue']['cValue']<>NULL){$BankValue=$array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bBankValue']['cValue'];}else{$BankValue=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bCollateralCode']<>NULL){$ColCode=$array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bCollateralCode'];}else{$ColCode=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bCreditor']<>NULL){$ColCreditor=$array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bCreditor'];}else{$ColCreditor=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bDescription']<>NULL){$ColDesc=$array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bDescription'];}else{$ColDesc=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bInsurance']<>NULL){$ColInsurance=$array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bInsurance'];}else{$ColInsurance=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bLastUpdate']<>NULL){$ColLastUpt=$array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bLastUpdate'];}else{$ColLastUpt=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bOwnerName']<>NULL){$ColOwnerName=$array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bOwnerName'];}else{$ColOwnerName=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bOwnershipProof']<>NULL){$ColOwnerShip=$array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bOwnershipProof'];}else{$ColOwnerShip=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bProportion']<>NULL){$ColProportion=$array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bProportion'];}else{$ColProportion=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bSecurityAssignmentType']<>NULL){$ColSecAssigmnt=$array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bSecurityAssignmentType'];}else{$ColSecAssigmnt=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bTaxValue']['cCurrency']<>NULL){$ColTaxCurency=$array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bTaxValue']['cCurrency'];}else{$ColTaxCurency=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bTaxValue']['cValue']<>NULL){$ColTaxValue=$array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bTaxValue']['cValue'];}else{$ColTaxValue=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bType']<>NULL){$ColTaxType=$array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bType'];}else{$ColTaxType=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bValuationDate']<>NULL){$ColValDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral']['bValuationDate'];}else{$ColValDate=NULL;}
	
	
	$callCollateralList = "{call SP_INSERT_COLLATERAL_LIST_COMPANY(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramsCollateralList = array(
							array($mappingId, SQLSRV_PARAM_IN),
							array($pefindoId, SQLSRV_PARAM_IN),
							array($AppraiseVal, SQLSRV_PARAM_IN),
							array($BankCurency, SQLSRV_PARAM_IN),
							array($BankValue, SQLSRV_PARAM_IN),
							array($ColCode, SQLSRV_PARAM_IN),
							array($ColCreditor, SQLSRV_PARAM_IN),
							array($ColDesc, SQLSRV_PARAM_IN),
							array($ColInsurance, SQLSRV_PARAM_IN),
							array($ColLastUpt, SQLSRV_PARAM_IN),
							array($ColOwnerName, SQLSRV_PARAM_IN),
							array($ColOwnerShip, SQLSRV_PARAM_IN),
							array($ColProportion, SQLSRV_PARAM_IN),
							array($ColSecAssigmnt, SQLSRV_PARAM_IN),
							array($ColTaxCurency, SQLSRV_PARAM_IN),
							array($ColTaxValue, SQLSRV_PARAM_IN),
							array($ColTaxType, SQLSRV_PARAM_IN),
							array($ColValDate, SQLSRV_PARAM_IN)
						);
	$execCollateralList = sqlsrv_query( $conn, $callCollateralList, $paramsCollateralList) or die( print_r( sqlsrv_errors(), true));
}else{
	foreach($array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bCollateralList']['bCollateral'] as $itemCol_List){
		if($itemCol_List['bAppraisalValue']<>NULL){$AppraiseVal=$itemCol_List['bAppraisalValue']['cCurrency']." ".$itemCol_List['bAppraisalValue']['cValue'];}else{$AppraiseVal=NULL;}
		if($itemCol_List['bBankValue']['cCurrency']<>NULL){$BankCurency=$itemCol_List['bBankValue']['cCurrency'];}else{$BankCurency=NULL;}
		if($itemCol_List['bBankValue']['cValue']<>NULL){$BankValue=$itemCol_List['bBankValue']['cValue'];}else{$BankValue=NULL;}
		if($itemCol_List['bCollateralCode']<>NULL){$ColCode=$itemCol_List['bCollateralCode'];}else{$ColCode=NULL;}
		if($itemCol_List['bCreditor']<>NULL){$ColCreditor=$itemCol_List['bCreditor'];}else{$ColCreditor=NULL;}
		if($itemCol_List['bDescription']<>NULL){$ColDesc=$itemCol_List['bDescription'];}else{$ColDesc=NULL;}
		if($itemCol_List['bInsurance']<>NULL){$ColInsurance=$itemCol_List['bInsurance'];}else{$ColInsurance=NULL;}
		if($itemCol_List['bLastUpdate']<>NULL){$ColLastUpt=$itemCol_List['bLastUpdate'];}else{$ColLastUpt=NULL;}
		if($itemCol_List['bOwnerName']<>NULL){$ColOwnerName=$itemCol_List['bOwnerName'];}else{$ColOwnerName=NULL;}
		if($itemCol_List['bOwnershipProof']<>NULL){$ColOwnerShip=$itemCol_List['bOwnershipProof'];}else{$ColOwnerShip=NULL;}
		if($itemCol_List['bProportion']<>NULL){$ColProportion=$itemCol_List['bProportion'];}else{$ColProportion=NULL;}
		if($itemCol_List['bSecurityAssignmentType']<>NULL){$ColSecAssigmnt=$itemCol_List['bSecurityAssignmentType'];}else{$ColSecAssigmnt=NULL;}
		if($itemCol_List['bTaxValue']['cCurrency']<>NULL){$ColTaxCurency=$itemCol_List['bTaxValue']['cCurrency'];}else{$ColTaxCurency=NULL;}
		if($itemCol_List['bTaxValue']['cValue']<>NULL){$ColTaxValue=$itemCol_List['bTaxValue']['cValue'];}else{$ColTaxValue=NULL;}
		if($itemCol_List['bType']<>NULL){$ColTaxType=$itemCol_List['bType'];}else{$ColTaxType=NULL;}
		if($itemCol_List['bValuationDate']<>NULL){$ColValDate=$itemCol_List['bValuationDate'];}else{$ColValDate=NULL;}				
		
	//$AppraiseVal = NULL;
	//$BankCurency = NULL;
	//$BankValue = NULL;
	//$ColCode = NULL;
	//$ColCreditor = NULL;
	//$ColDesc = NULL;
	//$ColInsurance = NULL;
	//$ColLastUpt = NULL;
	//$ColOwnerName = NULL;
	//$ColOwnerShip = NULL;
	//$ColProportion = NULL;
	//$ColSecAssigmnt = NULL;
	//$ColTaxCurency = NULL;
	//$ColTaxValue = NULL;
	//$ColTaxType = NULL;
	//$ColValDate = NULL;
	
		$callCollateralList = "{call SP_INSERT_COLLATERAL_LIST_COMPANY(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
		$paramsCollateralList = array(
								array($mappingId, SQLSRV_PARAM_IN),
								array($pefindoId, SQLSRV_PARAM_IN),
								array($AppraiseVal, SQLSRV_PARAM_IN),
								array($BankCurency, SQLSRV_PARAM_IN),
								array($BankValue, SQLSRV_PARAM_IN),
								array($ColCode, SQLSRV_PARAM_IN),
								array($ColCreditor, SQLSRV_PARAM_IN),
								array($ColDesc, SQLSRV_PARAM_IN),
								array($ColInsurance, SQLSRV_PARAM_IN),
								array($ColLastUpt, SQLSRV_PARAM_IN),
								array($ColOwnerName, SQLSRV_PARAM_IN),
								array($ColOwnerShip, SQLSRV_PARAM_IN),
								array($ColProportion, SQLSRV_PARAM_IN),
								array($ColSecAssigmnt, SQLSRV_PARAM_IN),
								array($ColTaxCurency, SQLSRV_PARAM_IN),
								array($ColTaxValue, SQLSRV_PARAM_IN),
								array($ColTaxType, SQLSRV_PARAM_IN),
								array($ColValDate, SQLSRV_PARAM_IN)
							);
		$execCollateralList = sqlsrv_query( $conn, $callCollateralList, $paramsCollateralList) or die( print_r( sqlsrv_errors(), true));
	}
}

/*Collateral Summary*/
if($array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bSummary']['bNumberOfCashCollaterals']<>NULL){$ColSumNumbCash=$array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bSummary']['bNumberOfCashCollaterals'];}else{$$ColSumNumbCash=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bSummary']['bNumberOfNonCashCollaterals']<>NULL){$ColSumNumbNonCash=$array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bSummary']['bNumberOfNonCashCollaterals'];}else{$ColSumNumbNonCash=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bSummary']['bTotalValueOfCashCollaterals']['cCurrency']<>NULL){$ColSumTotalValCashCurency=$array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bSummary']['bTotalValueOfCashCollaterals']['cCurrency'];}else{$ColSumTotalValCashCurency=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bSummary']['bTotalValueOfCashCollaterals']['cValue']<>NULL){$ColSumTotalValCashVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bSummary']['bTotalValueOfCashCollaterals']['cValue'];}else{$ColSumTotalValCashVal=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bSummary']['bTotalValueOfNonCashCollaterals']['cCurrency']<>NULL){$ColSumTotalValnonCashCurency=$array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bSummary']['bTotalValueOfNonCashCollaterals']['cCurrency'];}else{$ColSumTotalValnonCashCurency=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bSummary']['bTotalValueOfNonCashCollaterals']['cValue']<>NULL){$ColSumTotalValnonCashVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aCollaterals']['bSummary']['bTotalValueOfNonCashCollaterals']['cValue'];}else{$ColSumTotalValnonCashVal=NULL;}

$callCollateralSUM = "{call SP_INSERT_COLLATERAL_SUMMARY_COMPANY(?,?,?,?,?,?,?,?)}";
$paramsCollateralSUM = array(
						array($mappingId, SQLSRV_PARAM_IN),
						array($pefindoId,SQLSRV_PARAM_IN),
						array($ColSumNumbCash,SQLSRV_PARAM_IN),
						array($ColSumNumbNonCash,SQLSRV_PARAM_IN),
						array($ColSumTotalValCashCurency,SQLSRV_PARAM_IN),
						array($ColSumTotalValCashVal,SQLSRV_PARAM_IN),
						array($ColSumTotalValnonCashCurency,SQLSRV_PARAM_IN),
						array($ColSumTotalValnonCashVal,SQLSRV_PARAM_IN)
					);
$execCollateralSUM = sqlsrv_query( $conn, $callCollateralSUM, $paramsCollateralSUM) or die (print_r( sqlsrv_errors(),true));
?>