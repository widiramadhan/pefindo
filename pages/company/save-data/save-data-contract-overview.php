<?php
//Contract Overview Company//
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract']['bContractStatus']))
{
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract']['bContractStatus']<>NULL){$ContViewContStatus=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract']['bContractStatus'];}else{$ContViewContStatus=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract']['bOutstandingAmount']['cCurrency']<>NULL){$ContViewOutStandAmountCurency=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract']['bOutstandingAmount']['cCurrency'];}else{$ContViewOutStandAmountCurency=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract']['bOutstandingAmount']['cValue']<>NULL){$ContViewOutStandAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract']['bOutstandingAmount']['cValue'];}else{$ContViewOutStandAmountVal=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract']['bPastDueAmount']['cCurrency']<>NULL){$ContViewPastDueAmountCurency=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract']['bPastDueAmount']['cCurrency'];}else{$ContViewPastDueAmountCurency=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract']['bPastDueAmount']['cValue']<>NULL){$ContViewPastDueAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract']['bPastDueAmount']['cValue'];}else{$ContViewPastDueAmountVal=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract']['bPastDueDays']<>NULL){$ContViewPastDueDays=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract']['bPastDueDays'];}else{$ContViewPastDueDays=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract']['bPhaseOfContract']<>NULL){$ContViewPhaseOfCont=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract']['bPhaseOfContract'];}else{$$ContViewPhaseOfCont=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract']['bRoleOfClient']<>NULL){$ContViewRoleClient=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract']['bRoleOfClient'];}else{$ContViewRoleClient=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract']['bSector']<>NULL){$ContViewSector=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract']['bSector'];}else{$ContViewSector=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract']['bStartDate']<>NULL){$ContViewStartDt=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract']['bStartDate'];}else{$ContViewRoleClient=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract']['bTotalAmount']['cCurrency']<>NULL){$ContViewTotAmountCurency=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract']['bTotalAmount']['cCurrency'];}else{$ContViewTotAmountCurency=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract']['bTotalAmount']['cValue']<>NULL){$ContViewTotAmountVal=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract']['bTotalAmount']['cValue'];}else{$ContViewTotAmountVal=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract']['bTypeOfContract']<>NULL){$ContViewTypeCont=$array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract']['bTypeOfContract'];}else{$ContViewTypeCont=NULL;}
	
	$callContOverview = "{call SP_INSERT_CONTRACT_OVERVIEW_COMPANY(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramsContOverview = array(
						array($mappingId, SQLSRV_PARAM_IN),
						array($pefindoId,SQLSRV_PARAM_IN),
						array($ContViewContStatus,SQLSRV_PARAM_IN),
						array($ContViewOutStandAmountCurency,SQLSRV_PARAM_IN),
						array($ContViewOutStandAmountVal,SQLSRV_PARAM_IN),
						array($ContViewPastDueAmountCurency,SQLSRV_PARAM_IN),
						array($ContViewPastDueAmountVal,SQLSRV_PARAM_IN),
						array($ContViewPastDueDays,SQLSRV_PARAM_IN),
						array($ContViewPhaseOfCont,SQLSRV_PARAM_IN),
						array($ContViewRoleClient,SQLSRV_PARAM_IN),
						array($ContViewSector,SQLSRV_PARAM_IN),
						array($ContViewStartDt,SQLSRV_PARAM_IN),
						array($ContViewTotAmountCurency,SQLSRV_PARAM_IN),
						array($ContViewTotAmountVal,SQLSRV_PARAM_IN),
						array($ContViewTypeCont,SQLSRV_PARAM_IN)
					);
	$execContOverview = sqlsrv_query($conn, $callContOverview, $paramsContOverview) or die (print_r( sqlsrv_errors(),true ));
}else{
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract'])){
		foreach($array['GetCustomReportResponse']['GetCustomReportResult']['aContractOverview']['bContractList']['bContract'] as $itemContView){
			if($itemContView['bContractStatus']<>NULL){$ContViewContStatus=$itemContView['bContractStatus'];}else{$ContViewContStatus=NULL;}				
			if($itemContView['bOutstandingAmount']['cCurrency']<>NULL){$ContViewOutStandAmountCurency=$itemContView['bOutstandingAmount']['cCurrency'];}else{$ContViewOutStandAmountCurency=NULL;}				
			if($itemContView['bOutstandingAmount']['cValue']<>NULL){$ContViewOutStandAmountVal=$itemContView['bOutstandingAmount']['cValue'];}else{$ContViewOutStandAmountVal=NULL;}
			if($itemContView['bPastDueAmount']['cCurrency']<>NULL){$ContViewPastDueAmountCurency=$itemContView['bPastDueAmount']['cCurrency'];}else{$ContViewPastDueAmountCurency=NULL;}				
			if($itemContView['bPastDueAmount']['cValue']<>NULL){$ContViewPastDueAmountVal=$itemContView['bPastDueAmount']['cValue'];}else{$ContViewPastDueAmountVal=NULL;}				
			if($itemContView['bPastDueDays']<>NULL){$ContViewPastDueDays=$itemContView['bPastDueDays'];}else{$ContViewPastDueDays=NULL;}			
			if($itemContView['bPhaseOfContract']<>NULL){$ContViewPhaseOfCont=$itemContView['bPhaseOfContract'];}else{$$ContViewPhaseOfCont=NULL;}	
			if($itemContView['bRoleOfClient']<>NULL){$ContViewRoleClient=$itemContView['bRoleOfClient'];}else{$ContViewRoleClient=NULL;}				
			if($itemContView['bSector']<>NULL){$ContViewSector=$itemContView['bSector'];}else{$ContViewSector=NULL;}				
			if($itemContView['bStartDate']<>NULL){$ContViewStartDt=$itemContView['bStartDate'];}else{$ContViewRoleClient=NULL;}				
			if($itemContView['bTotalAmount']['cCurrency']<>NULL){$ContViewTotAmountCurency=$itemContView['bTotalAmount']['cCurrency'];}else{$ContViewTotAmountCurency=NULL;}				
			if($itemContView['bTotalAmount']['cValue']<>NULL){$ContViewTotAmountVal=$itemContView['bTotalAmount']['cValue'];}else{$ContViewTotAmountVal=NULL;}
			if($itemContView['bTypeOfContract']<>NULL){$ContViewTypeCont=$itemContView['bTypeOfContract'];}else{$ContViewTypeCont=NULL;}
			
			$callContOverview = "{call SP_INSERT_CONTRACT_OVERVIEW_COMPANY(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
			$paramsContOverview = array(
								array($mappingId, SQLSRV_PARAM_IN),
								array($pefindoId,SQLSRV_PARAM_IN),
								array($ContViewContStatus,SQLSRV_PARAM_IN),
								array($ContViewOutStandAmountCurency,SQLSRV_PARAM_IN),
								array($ContViewOutStandAmountVal,SQLSRV_PARAM_IN),
								array($ContViewPastDueAmountCurency,SQLSRV_PARAM_IN),
								array($ContViewPastDueAmountVal,SQLSRV_PARAM_IN),
								array($ContViewPastDueDays,SQLSRV_PARAM_IN),
								array($ContViewPhaseOfCont,SQLSRV_PARAM_IN),
								array($ContViewRoleClient,SQLSRV_PARAM_IN),
								array($ContViewSector,SQLSRV_PARAM_IN),
								array($ContViewStartDt,SQLSRV_PARAM_IN),
								array($ContViewTotAmountCurency,SQLSRV_PARAM_IN),
								array($ContViewTotAmountVal,SQLSRV_PARAM_IN),
								array($ContViewTypeCont,SQLSRV_PARAM_IN)
							);
			$execContOverview = sqlsrv_query($conn, $callContOverview, $paramsContOverview) or die (print_r( sqlsrv_errors(),true ));
		}
	}
}
?>