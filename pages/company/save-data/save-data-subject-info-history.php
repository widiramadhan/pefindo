<?php
/* Subject Info Header */
$callSubInfoHistory = "{call SP_INSERT_SUBJECT_INFO_HISTORY_COMPANY(?,?)}";
$paramsSubInfoHistory = array(array($mappingId, SQLSRV_PARAM_IN),array($pefindoId,SQLSRV_PARAM_IN));
$execSubInfoHistory = sqlsrv_query($conn, $callSubInfoHistory, $paramsSubInfoHistory) or die ( print_r( sqlsrv_errors(),true));

/* Get subject info header */
$callSubInfoHistoryID = "{call SP_GET_ID_M_SUBJECT_INFO_HISTORY_COMPANY(?,?)}";
$paramsSubInfoHistoryID = array(array($mappingId,SQLSRV_PARAM_IN),array($pefindoId,SQLSRV_PARAM_IN));
$execSubInfoHistoryID = sqlsrv_query($conn, $callSubInfoHistoryID, $paramsSubInfoHistoryID) or die ( print_r( sqlsrv_errors(),true));
$dataSubInfoHis = sqlsrv_fetch_array($execSubInfoHistoryID);
$subjectInfoId = $dataSubInfoHis['SUBJECT_INFO_HISTORY_ID'];

/* Insert to AddressList */
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bAddressList']['bAddress']['bItem'])){
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bAddressList']['bAddress']['bItem']<>NULL){$SubInfoAddListItem = $array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bAddressList']['bAddress']['bItem'];}else{$SubInfoAddListItem=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bAddressList']['bAddress']['bSubscriber']<>NULL){$SubInfoAddListSubc = $array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bAddressList']['bAddress']['bSubscriber'];}else{$SubInfoAddListSubc=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bAddressList']['bAddress']['bValidFrom']<>NULL){$SubInfoAddListValidFrom = $array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bAddressList']['bAddress']['bValidFrom'];}else{$SubInfoAddListValidFrom=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bAddressList']['bAddress']['bValidTo']<>NULL){$SubInfoAddListValidTo = $array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bAddressList']['bAddress']['bValidTo'];}else{$SubInfoAddListValidTo=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bAddressList']['bAddress']['bValue']<>NULL){$SubInfoAddListVal = $array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bAddressList']['bAddress']['bValue'];}else{$SubInfoAddLisVal=NULL;}

	$callSubInfoHisAddList = "{call SP_INSERT_SUBJECT_INFO_HISTORY_ADDRESS_LIST_COMPANY(?,?,?,?,?,?,?)}";
	$paramsSubInfoHisAddList = array(
							array($mappingId, SQLSRV_PARAM_IN),
							array($subjectInfoId,SQLSRV_PARAM_IN),
							array($SubInfoAddListItem,SQLSRV_PARAM_IN),
							array($SubInfoAddListSubc,SQLSRV_PARAM_IN),
							array($SubInfoAddListValidFrom,SQLSRV_PARAM_IN),
							array($SubInfoAddListValidTo,SQLSRV_PARAM_IN),
							array($SubInfoAddListVal,SQLSRV_PARAM_IN)
							);
	$execSubInfoHisAddList = sqlsrv_query($conn, $callSubInfoHisAddList, $paramsSubInfoHisAddList) or die ( print_r( sqlsrv_errors(),true));
}else{
	foreach($array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bAddressList']['bAddress'] as $ItemSubInfoAdd){
		if($ItemSubInfoAdd['bItem']<>NULL){$SubInfoAddListItem = $ItemSubInfoAdd['bItem'];}else{$SubInfoAddListItem=NULL;}
		if($ItemSubInfoAdd['bSubscriber']<>NULL){$SubInfoAddListSubc = $ItemSubInfoAdd['bSubscriber'];}else{$SubInfoAddListSubc=NULL;}
		if($ItemSubInfoAdd['bValidFrom']<>NULL){$SubInfoAddListValidFrom = $ItemSubInfoAdd['bValidFrom'];}else{$SubInfoAddListValidFrom=NULL;}
		if($ItemSubInfoAdd['bValidTo']<>NULL){$SubInfoAddListValidTo = $ItemSubInfoAdd['bValidTo'];}else{$SubInfoAddListValidTo=NULL;}
		if($ItemSubInfoAdd['bValue']<>NULL){$SubInfoAddListVal = $ItemSubInfoAdd['bValue'];}else{$SubInfoAddLisVal=NULL;}
	
		$callSubInfoHisAddList = "{call SP_INSERT_SUBJECT_INFO_HISTORY_ADDRESS_LIST_COMPANY(?,?,?,?,?,?,?)}";
		$paramsSubInfoHisAddList = array(
								array($mappingId, SQLSRV_PARAM_IN),
								array($subjectInfoId,SQLSRV_PARAM_IN),
								array($SubInfoAddListItem,SQLSRV_PARAM_IN),
								array($SubInfoAddListSubc,SQLSRV_PARAM_IN),
								array($SubInfoAddListValidFrom,SQLSRV_PARAM_IN),
								array($SubInfoAddListValidTo,SQLSRV_PARAM_IN),
								array($SubInfoAddListVal,SQLSRV_PARAM_IN)
								);
		$execSubInfoHisAddList = sqlsrv_query($conn, $callSubInfoHisAddList, $paramsSubInfoHisAddList) or die ( print_r( sqlsrv_errors(),true));
	}
}

/* Insert to ContactList */ 
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bContactList']['bContact']['bItem'])){
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bContactList']['bContact']['bItem']<>NULL){$SubInfoHistContItem = $array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bContactList']['bContact']['bItem'];}else{$SubInfoHistContItem=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bContactList']['bContact']['bSubscriber']<>NULL){$SubInfoHistContSubs = $array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bContactList']['bContact']['bSubscriber'];}else{$SubInfoHistContSubs=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bContactList']['bContact']['bValidFrom']<>NULL){$SubInfoHistContValidFrom = $array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bContactList']['bContact']['bValidFrom'];}else{$SubInfoHistContValidFrom=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bContactList']['bContact']['bValidTo']<>NULL){$SubInfoHistContValidTo = $array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bContactList']['bContact']['bValidTo'];}else{$SubInfoHistContValidTo=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bContactList']['bContact']['bValue']<>NULL){$SubInfoHistContVal = $array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bContactList']['bContact']['bValue'];}else{$SubInfoHistContVal=NULL;}

	$callSubInfoHisContList = "{call SP_INSERT_SUBJECT_INFO_HISTORY_CONTACTLIST_COMPANY(?,?,?,?,?,?,?)}";
	$paramsSubInfoHisContList = array(
									array($mappingId, SQLSRV_PARAM_IN),
									array($subjectInfoId,SQLSRV_PARAM_IN),
									array($SubInfoHistContItem,SQLSRV_PARAM_IN),
									array($SubInfoHistContSubs,SQLSRV_PARAM_IN),
									array($SubInfoHistContValidFrom,SQLSRV_PARAM_IN),
									array($SubInfoHistContValidTo,SQLSRV_PARAM_IN),
									array($SubInfoHistContVal,SQLSRV_PARAM_IN)
								);
	$execSubInfoHisContList = sqlsrv_query($conn, $callSubInfoHisContList, $paramsSubInfoHisContList) or die ( print_r( sqlsrv_errors(),true));
}else{
	foreach($array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bContactList']['bContact'] as $itemSubInfoCont){
		if($itemSubInfoCont['bItem']<>NULL){$SubInfoHistContItem = $itemSubInfoCont['bItem'];}else{$SubInfoHistContItem=NULL;}
		if($itemSubInfoCont['bSubscriber']<>NULL){$SubInfoHistContSubs = $itemSubInfoCont['bSubscriber'];}else{$SubInfoHistContSubs=NULL;}
		if($itemSubInfoCont['bValidFrom']<>NULL){$SubInfoHistContValidFrom = $itemSubInfoCont['bValidFrom'];}else{$SubInfoHistContValidFrom=NULL;}
		if($itemSubInfoCont['bValidTo']<>NULL){$SubInfoHistContValidTo = $itemSubInfoCont['bValidTo'];}else{$SubInfoHistContValidTo=NULL;}
		if($itemSubInfoCont['bValue']<>NULL){$SubInfoHistContVal = $itemSubInfoCont['bValue'];}else{$SubInfoHistContVal=NULL;}
		$a=NULL;
		$callSubInfoHisContList = "{call SP_INSERT_SUBJECT_INFO_HISTORY_CONTACTLIST_COMPANY(?,?,?,?,?,?,?)}";
		$paramsSubInfoHisContList = array(
										array($mappingId, SQLSRV_PARAM_IN),
										array($subjectInfoId,SQLSRV_PARAM_IN),
										array($SubInfoHistContItem,SQLSRV_PARAM_IN),
										array($SubInfoHistContSubs,SQLSRV_PARAM_IN),
										array($SubInfoHistContValidFrom,SQLSRV_PARAM_IN),
										array($SubInfoHistContValidTo,SQLSRV_PARAM_IN),
										array($SubInfoHistContVal,SQLSRV_PARAM_IN)
									);
		$execSubInfoHisContList = sqlsrv_query($conn, $callSubInfoHisContList, $paramsSubInfoHisContList) or die ( print_r( sqlsrv_errors(),true));
	}
}

/* Insert to GeneralList */ 
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bGeneralList']['bGeneral']['bItem'])){
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bGeneralList']['bGeneral']['bItem']<>NULL){$SubInfoHistGenItem = $array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bGeneralList']['bGeneral']['bItem'];}else{$SubInfoHistGenItem=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bGeneralList']['bGeneral']['bSubscriber']<>NULL){$SubInfoHistGenSubs = $array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bGeneralList']['bGeneral']['bSubscriber'];}else{$SubInfoHistGenSubs=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bGeneralList']['bGeneral']['bValidFrom']<>NULL){$SubInfoHistGenValidFrom = $array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bGeneralList']['bGeneral']['bValidFrom'];}else{$SubInfoHistGenValidFrom=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bGeneralList']['bGeneral']['bValidTo']<>NULL){$SubInfoHistGenValidTo = $array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bGeneralList']['bGeneral']['bValidTo'];}else{$SubInfoHistGenValidTo=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bGeneralList']['bGeneral']['bValue']<>NULL){$SubInfoHistGenVal = $array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bGeneralList']['bGeneral']['bValue'];}else{$SubInfoHistGenVal=NULL;}

	$callSubInfoHisGenList = "{call SP_INSERT_SUBJECT_INFO_HISTORY_GENERALLIST_COMPANY(?,?,?,?,?,?,?)}";
	$paramsSubInfoHisGenList = array(
								array($mappingId, SQLSRV_PARAM_IN),
								array($subjectInfoId,SQLSRV_PARAM_IN),
								array($SubInfoHistGenItem,SQLSRV_PARAM_IN),
								array($SubInfoHistGenSubs,SQLSRV_PARAM_IN),
								array($SubInfoHistGenValidFrom,SQLSRV_PARAM_IN),
								array($SubInfoHistGenValidTo,SQLSRV_PARAM_IN),
								array($SubInfoHistGenVal,SQLSRV_PARAM_IN)
								);
	$execSubInfoHisGenList = sqlsrv_query($conn, $callSubInfoHisGenList, $paramsSubInfoHisGenList) or die ( print_r( sqlsrv_errors(),true));
}else{
	foreach($array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bGeneralList']['bGeneral'] as $itemSubInfoGen){
		if($itemSubInfoGen['bItem']<>NULL){$SubInfoHistGenItem = $itemSubInfoGen['bItem'];}else{$SubInfoHistGenItem=NULL;}
		if($itemSubInfoGen['bSubscriber']<>NULL){$SubInfoHistGenSubs = $itemSubInfoGen['bSubscriber'];}else{$SubInfoHistGenSubs=NULL;}
		if($itemSubInfoGen['bValidFrom']<>NULL){$SubInfoHistGenValidFrom = $itemSubInfoGen['bValidFrom'];}else{$SubInfoHistGenValidFrom=NULL;}
		if($itemSubInfoGen['bValidTo']<>NULL){$SubInfoHistGenValidTo = $itemSubInfoGen['bValidTo'];}else{$SubInfoHistGenValidTo=NULL;}
		if($itemSubInfoGen['bValue']<>NULL){$SubInfoHistGenVal = $itemSubInfoGen['bValue'];}else{$SubInfoHistGenVal=NULL;}

		$callSubInfoHisGenList = "{call SP_INSERT_SUBJECT_INFO_HISTORY_GENERALLIST_COMPANY(?,?,?,?,?,?,?)}";
		$paramsSubInfoHisGenList = array(
									array($mappingId, SQLSRV_PARAM_IN),
									array($subjectInfoId,SQLSRV_PARAM_IN),
									array($SubInfoHistGenItem,SQLSRV_PARAM_IN),
									array($SubInfoHistGenSubs,SQLSRV_PARAM_IN),
									array($SubInfoHistGenValidFrom,SQLSRV_PARAM_IN),
									array($SubInfoHistGenValidTo,SQLSRV_PARAM_IN),
									array($SubInfoHistGenVal,SQLSRV_PARAM_IN)
									);
		$execSubInfoHisGenList = sqlsrv_query($conn, $callSubInfoHisGenList, $paramsSubInfoHisGenList) or die ( print_r( sqlsrv_errors(),true));
	}
}

/* Insert to IdentificationList */ 
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bIdentificationsList']['bIdentifications']['bItem'])){
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bIdentificationsList']['bIdentifications']['bItem']<>NULL){$SubInfoHisIdentItem = $array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bIdentificationsList']['bIdentifications']['bItem'];}else{$SubInfoHisIdentItem=NULL;}	
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bIdentificationsList']['bIdentifications']['bSubscriber']<>NULL){$SubInfoHisIdentSubs = $array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bIdentificationsList']['bIdentifications']['bSubscriber'];}else{$SubInfoHisIdentSubs=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bIdentificationsList']['bIdentifications']['bValidFrom']<>NULL){$SubInfoHisIdentValidFrom = $array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bIdentificationsList']['bIdentifications']['bValidFrom'];}else{$SubInfoHisIdentValidFrom=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bIdentificationsList']['bIdentifications']['bValidTo']<>NULL){$SubInfoHisIdentbValidTo = $array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bIdentificationsList']['bIdentifications']['bValidTo'];}else{$SubInfoHisIdentbValidTo=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bIdentificationsList']['bIdentifications']['bValue']<>NULL){$SubInfoHisIdentVal = $array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bIdentificationsList']['bIdentifications']['bValue'];}else{$SubInfoHisIdentVal=NULL;}			
	
	$callSubInfoHisIdentList = "{call SP_INSERT_SUBJECT_INFO_HISTORY_IDENTIFICATIONSLIST_COMPANY(?,?,?,?,?,?,?)}";
	$paramsSubInfoHisIdentList = array(
								array($mappingId, SQLSRV_PARAM_IN),
								array($subjectInfoId,SQLSRV_PARAM_IN),
								array($SubInfoHisIdentItem,SQLSRV_PARAM_IN),
								array($SubInfoHisIdentSubs,SQLSRV_PARAM_IN),
								array($SubInfoHisIdentValidFrom,SQLSRV_PARAM_IN),
								array($SubInfoHisIdentbValidTo,SQLSRV_PARAM_IN),
								array($SubInfoHisIdentVal,SQLSRV_PARAM_IN)
								);
	$execSubInfoHisIdentList = sqlsrv_query($conn, $callSubInfoHisIdentList, $paramsSubInfoHisIdentList) or die ( print_r( sqlsrv_errors(),true));
}else{
	foreach($array['GetCustomReportResponse']['GetCustomReportResult']['aSubjectInfoHistory']['bIdentificationsList']['bIdentifications'] as $ItemSubInfoIdent){
		if($ItemSubInfoIdent['bItem']<>NULL){$SubInfoHisIdentItem = $ItemSubInfoIdent['bItem'];}else{$SubInfoHisIdentItem=NULL;}
		if($ItemSubInfoIdent['bSubscriber']<>NULL){$SubInfoHisIdentSubs = $ItemSubInfoIdent['bSubscriber'];}else{$SubInfoHisIdentSubs=NULL;}
		if($ItemSubInfoIdent['bValidFrom']<>NULL){$SubInfoHisIdentValidFrom = $ItemSubInfoIdent['bValidFrom'];}else{$SubInfoHisIdentValidFrom=NULL;}
		if($ItemSubInfoIdent['bValidTo']<>NULL){$SubInfoHisIdentbValidTo = $ItemSubInfoIdent['bValidTo'];}else{$SubInfoHisIdentbValidTo=NULL;}
		if($ItemSubInfoIdent['bValue']<>NULL){$SubInfoHisIdentVal = $ItemSubInfoIdent['bValue'];}else{$SubInfoHisIdentVal=NULL;}		
		
		$callSubInfoHisIdentList = "{call SP_INSERT_SUBJECT_INFO_HISTORY_IDENTIFICATIONSLIST_COMPANY(?,?,?,?,?,?,?)}";
		$paramsSubInfoHisIdentList = array(
									array($mappingId, SQLSRV_PARAM_IN),
									array($subjectInfoId,SQLSRV_PARAM_IN),
									array($SubInfoHisIdentItem,SQLSRV_PARAM_IN),
									array($SubInfoHisIdentSubs,SQLSRV_PARAM_IN),
									array($SubInfoHisIdentValidFrom,SQLSRV_PARAM_IN),
									array($SubInfoHisIdentbValidTo,SQLSRV_PARAM_IN),
									array($SubInfoHisIdentVal,SQLSRV_PARAM_IN)
									);
		$execSubInfoHisIdentList = sqlsrv_query($conn, $callSubInfoHisIdentList, $paramsSubInfoHisIdentList) or die ( print_r( sqlsrv_errors(),true));
	}
}
?>