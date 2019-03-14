<?php
//ContractRelationList Company//
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bFullName'])){
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bContact']['cFixedLine']<>NULL){$CurrentRelatListContFixLine=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bContact']['cFixedLine'];}else{$CurrentRelatListContFixLine=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bContact']['cMobilePhone']<>NULL){$CurrentRelatListContPhone=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bContact']['cMobilePhone'];}else{$CurrentRelatListContPhone=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bCreditinfoId']<>NULL){$CurrentRelatListCreditFold=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bCreditinfoId'];}else{$CurrentRelatListCreditFold=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bFullName']<>NULL){$CurrentRelatListFullName=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bFullName'];}else{$CurrentRelatListFullName=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bIDNumber']<>NULL){$CurrentRelatListIdNumb=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bIDNumber'];}else{$CurrentRelatListIdNumb=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bIDNumberType']<>NULL){$CurrentRelatListIdNumbType=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bIDNumberType'];}else{$CurrentRelatListIdNumbType=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bMainAddress']['cAddressLine']<>NULL){$CurrentRelatAddrsLine=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bMainAddress']['cAddressLine'];}else{$CurrentRelatAddrsLine=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bMainAddress']['cCity']<>NULL){$CurrentRelatAddrsCity=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bMainAddress']['cCity'];}else{$CurrentRelatAddrsCity=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bMainAddress']['cCountry']<>NULL){$CurrentRelatAddrsCountry=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bMainAddress']['cCountry'];}else{$CurrentRelatAddrsCountry=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bMainAddress']['cDistrict']<>NULL){$CurrentRelatAddrsDistrict=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bMainAddress']['cDistrict'];}else{$CurrentRelatAddrsDistrict=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bMainAddress']['cParish']<>NULL){$CurrentRelatAddrsParish=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bMainAddress']['cParish'];}else{$CurrentRelatAddrsParish=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bMainAddress']['cPostalCode']<>NULL){$CurrentRelatAddrsCode=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bMainAddress']['cPostalCode'];}else{$CurrentRelatAddrsCode=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bMainAddress']['cStreet']<>NULL){$CurrentRelatAddrsStreet=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bMainAddress']['cStreet'];}else{$CurrentRelatAddrsStreet=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bRoleOfCustomer']<>NULL){$CurrentRelatListRoleCust=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bRoleOfCustomer'];}else{$CurrentRelatListRoleCust=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bSubjectType']<>NULL){$CurrentRelatListSubType=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bSubjectType'];}else{$CurrentRelatListSubType=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bValidFrom']<>NULL){$CurrentRelatListValidFrom=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation']['bValidFrom'];}else{$CurrentRelatListValidFrom=NULL;}			
	
	$callCurrentRelationsList = "{call SP_INSERT_CURRENT_RELATIONS_LIST_COMPANY(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramsCurrentRelationsList = array(
								array($mappingId, SQLSRV_PARAM_IN),
								array($pefindoId,SQLSRV_PARAM_IN),
								array($CurrentRelatListContFixLine,SQLSRV_PARAM_IN),
								array($CurrentRelatListContPhone,SQLSRV_PARAM_IN),
								array($CurrentRelatListCreditFold,SQLSRV_PARAM_IN),
								array($CurrentRelatListFullName,SQLSRV_PARAM_IN),
								array($CurrentRelatListIdNumb,SQLSRV_PARAM_IN),
								array($CurrentRelatListIdNumbType,SQLSRV_PARAM_IN),
								array($CurrentRelatAddrsLine,SQLSRV_PARAM_IN),
								array($CurrentRelatAddrsCity,SQLSRV_PARAM_IN),
								array($CurrentRelatAddrsCountry,SQLSRV_PARAM_IN),
								array($CurrentRelatAddrsDistrict,SQLSRV_PARAM_IN),
								array($CurrentRelatAddrsParish,SQLSRV_PARAM_IN),
								array($CurrentRelatAddrsCode,SQLSRV_PARAM_IN),
								array($CurrentRelatAddrsStreet,SQLSRV_PARAM_IN),
								array($CurrentRelatListRoleCust,SQLSRV_PARAM_IN),
								array($CurrentRelatListSubType,SQLSRV_PARAM_IN),
								array($CurrentRelatListValidFrom,SQLSRV_PARAM_IN)										
						);
	$execCurrentRelationsList = sqlsrv_query($conn , $callCurrentRelationsList, $paramsCurrentRelationsList) or die (print_r( sqlsrv_errors(),true ));
}else{
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation'])){
		foreach($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bContractRelationList']['bContractRelation'] as $item){
			if($item['bContact']['cFixedLine']<>NULL){$CurrentRelatListContFixLine=$item['bContact']['cFixedLine'];}else{$CurrentRelatListContFixLine=NULL;}			
			if($item['bContact']['cMobilePhone']<>NULL){$CurrentRelatListContPhone=$item['bContact']['cMobilePhone'];}else{$CurrentRelatListContPhone=NULL;}
			if($item['bCreditinfoId']<>NULL){$CurrentRelatListCreditFold=$item['bCreditinfoId'];}else{$CurrentRelatListCreditFold=NULL;}
			if($item['bFullName']<>NULL){$CurrentRelatListFullName=$item['bFullName'];}else{$CurrentRelatListFullName=NULL;}
			if($item['bIDNumber']<>NULL){$CurrentRelatListIdNumb=$item['bIDNumber'];}else{$CurrentRelatListIdNumb=NULL;}
			if($item['bIDNumberType']<>NULL){$CurrentRelatListIdNumbType=$item['bIDNumberType'];}else{$CurrentRelatListIdNumbType=NULL;}
			if($item['bMainAddress']['cAddressLine']<>NULL){$CurrentRelatAddrsLine=$item['bMainAddress']['cAddressLine'];}else{$CurrentRelatAddrsLine=NULL;}
			if($item['bMainAddress']['cCity']<>NULL){$CurrentRelatAddrsCity=$item['bMainAddress']['cCity'];}else{$CurrentRelatAddrsCity=NULL;}
			if($item['bMainAddress']['cCountry']<>NULL){$CurrentRelatAddrsCountry=$item['bMainAddress']['cCountry'];}else{$CurrentRelatAddrsCountry=NULL;}
			if($item['bMainAddress']['cDistrict']<>NULL){$CurrentRelatAddrsDistrict=$item['bMainAddress']['cDistrict'];}else{$CurrentRelatAddrsDistrict=NULL;}
			if($item['bMainAddress']['cParish']<>NULL){$CurrentRelatAddrsParish=$item['bMainAddress']['cParish'];}else{$CurrentRelatAddrsParish=NULL;}
			if($item['bMainAddress']['cPostalCode']<>NULL){$CurrentRelatAddrsCode=$item['bMainAddress']['cPostalCode'];}else{$CurrentRelatAddrsCode=NULL;}
			if($item['bMainAddress']['cStreet']<>NULL){$CurrentRelatAddrsStreet=$item['bMainAddress']['cStreet'];}else{$CurrentRelatAddrsStreet=NULL;}
			if($item['bRoleOfCustomer']<>NULL){$CurrentRelatListRoleCust=$item['bRoleOfCustomer'];}else{$CurrentRelatListRoleCust=NULL;}
			if($item['bSubjectType']<>NULL){$CurrentRelatListSubType=$item['bSubjectType'];}else{$CurrentRelatListSubType=NULL;}
			if($item['bValidFrom']<>NULL){$CurrentRelatListValidFrom=$item['bValidFrom'];}else{$CurrentRelatListValidFrom=NULL;}	

			$callCurrentRelationsList = "{call SP_INSERT_CURRENT_RELATIONS_LIST_COMPANY(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
			$paramsCurrentRelationsList = array(
										array($mappingId, SQLSRV_PARAM_IN),
										array($pefindoId,SQLSRV_PARAM_IN),
										array($CurrentRelatListContFixLine,SQLSRV_PARAM_IN),
										array($CurrentRelatListContPhone,SQLSRV_PARAM_IN),
										array($CurrentRelatListCreditFold,SQLSRV_PARAM_IN),
										array($CurrentRelatListFullName,SQLSRV_PARAM_IN),
										array($CurrentRelatListIdNumb,SQLSRV_PARAM_IN),
										array($CurrentRelatListIdNumbType,SQLSRV_PARAM_IN),
										array($CurrentRelatAddrsLine,SQLSRV_PARAM_IN),
										array($CurrentRelatAddrsCity,SQLSRV_PARAM_IN),
										array($CurrentRelatAddrsCountry,SQLSRV_PARAM_IN),
										array($CurrentRelatAddrsDistrict,SQLSRV_PARAM_IN),
										array($CurrentRelatAddrsParish,SQLSRV_PARAM_IN),
										array($CurrentRelatAddrsCode,SQLSRV_PARAM_IN),
										array($CurrentRelatAddrsStreet,SQLSRV_PARAM_IN),
										array($CurrentRelatListRoleCust,SQLSRV_PARAM_IN),
										array($CurrentRelatListSubType,SQLSRV_PARAM_IN),
										array($CurrentRelatListValidFrom,SQLSRV_PARAM_IN)										
								);
			$execCurrentRelationsList = sqlsrv_query($conn , $callCurrentRelationsList, $paramsCurrentRelationsList) or die (print_r( sqlsrv_errors(),true ));
		}
	}
}

//InvolvementList 
/*if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bInvolvementList']<>NULL){$involvementList=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bInvolvementList'];}else{$involvementList=NULL;}
$callInvolvementList = "{call SP_INSERT_CURRENT_RELATIONS_INVOLMENT_LIST(?,?)}";
$paramsInvolvementList = array(
							array($pefindoId,SQLSRV_PARAM_IN),
							array($involvementList,SQLSRV_PARAM_IN)										
					);
$execInvolvementList = sqlsrv_query($conn , $callInvolvementList, $paramsInvolvementList) or die (print_r( sqlsrv_errors(),true ));
	*/
	
//RelatedPartyList Company//
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bFullName'])){
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bContact']['cFixedLine']<>NULL){$CurrentRelatPartyLine=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bContact']['cFixedLine'];}else{$CurrentRelatPartyLine=NULL;}				
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bContact']['cMobilePhone']<>NULL){$CurrentRelatPartyPhone=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bContact']['cMobilePhone'];}else{$CurrentRelatPartyPhone=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bCreditinfoId']<>NULL){$CurrentRelatPartyCreditFold=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bCreditinfoId'];}else{$CurrentRelatPartyCreditFold=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bFullName']<>NULL){$CurrentRelatPartyFullname=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bFullName'];}else{$CurrentRelatPartyFullname=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bGender']<>NULL){$CurrentRelatPartyGender=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bGender'];}else{$CurrentRelatPartyGender=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bIDNumber']<>NULL){$CurrentRelatPartyIdNumb=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bIDNumber'];}else{$CurrentRelatPartyIdNumb=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bIDNumberType']<>NULL){$CurrentRelatPartyIdNumbType=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bIDNumberType'];}else{$CurrentRelatPartyIdNumbType=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bLTV']<>NULL){$CurrentRelatPartyLtv=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bLTV'];}else{$CurrentRelatPartyLtv=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bMainAddress']['cAddressLine']<>NULL){$CurrentRelatPartyAddLine=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bMainAddress']['cAddressLine'];}else{$CurrentRelatPartyAddLine=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bMainAddress']['cCity']<>NULL){$CurrentRelatPartyAddCity=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bMainAddress']['cCity'];}else{$CurrentRelatPartyAddCity=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bMainAddress']['cCountry']<>NULL){$CurrentRelatPartyAddCountry=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bMainAddress']['cCountry'];}else{$CurrentRelatPartyAddCountry=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bMainAddress']['cDistrict']<>NULL){$CurrentRelatPartyAddDistrict=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bMainAddress']['cDistrict'];}else{$CurrentRelatPartyAddDistrict=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bMainAddress']['cParish']<>NULL){$CurrentRelatPartyAddParish=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bMainAddress']['cParish'];}else{$CurrentRelatPartyAddParish=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bMainAddress']['cPostalCode']<>NULL){$CurrentRelatPartyAddCode=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bMainAddress']['cPostalCode'];}else{$CurrentRelatPartyAddCode=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bMainAddress']['cStreet']<>NULL){$CurrentRelatPartyAddStreet=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bMainAddress']['cStreet'];}else{$CurrentRelatPartyAddStreet=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bOwnershipShare']<>NULL){$CurrentRelatPartyOwnerShip=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bOwnershipShare'];}else{$CurrentRelatPartyOwnerShip=NULL;}
	//if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bProcura']['bProcuraRecordNumber']<>NULL){$CurrentRelatPartyProcuraRecordNumb=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bProcura']['bProcuraRecordNumber'];}else{$CurrentRelatPartyProcuraRecordNumb=NULL;}
	//if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bProcura']['bRegistrationDate']<>NULL){$CurrentRelatPartyProcuraRegistDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bProcura']['bRegistrationDate'];}else{$CurrentRelatPartyProcuraRegistDate=NULL;}
	//if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bProcura']['bTerminationDate']<>NULL){$CurrentRelatPartyProcuraTermintDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bProcura']['bTerminationDate'];}else{$CurrentRelatPartyProcuraTermintDate=NULL;}
	//if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bSubjectStatus']<>NULL){$CurrentRelatPartySubStatus=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bSubjectStatus'];}else{$CurrentRelatPartySubStatus=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bSubjectType']<>NULL){$CurrentRelatPartySubType=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bSubjectType'];}else{$CurrentRelatPartySubType=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bTypeOfRelation']<>NULL){$CurrentRelatPartyTypeRelation=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bTypeOfRelation'];}else{$CurrentRelatPartyTypeRelation=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bValidFrom']<>NULL){$CurrentRelatPartyValidFrom=$array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty']['bValidFrom'];}else{$CurrentRelatPartyValidFrom=NULL;}						

	$callCurrentRelatParty = "{call SP_INSERT_CURRENT_RELATIONS_RELATED_PARTY_LIST_COMPANY(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramsCurrentRelatParty = array(
								array($mappingId, SQLSRV_PARAM_IN),
								array($pefindoId,SQLSRV_PARAM_IN),
								array($CurrentRelatPartyLine,SQLSRV_PARAM_IN),
								array($CurrentRelatPartyPhone,SQLSRV_PARAM_IN),
								array($CurrentRelatPartyCreditFold,SQLSRV_PARAM_IN),
								array($CurrentRelatPartyFullname,SQLSRV_PARAM_IN),
								array($CurrentRelatPartyGender,SQLSRV_PARAM_IN),
								array($CurrentRelatPartyIdNumb,SQLSRV_PARAM_IN),
								array($CurrentRelatPartyIdNumbType,SQLSRV_PARAM_IN),
								array($CurrentRelatPartyLtv,SQLSRV_PARAM_IN),
								array($CurrentRelatPartyAddLine,SQLSRV_PARAM_IN),
								array($CurrentRelatPartyAddCity,SQLSRV_PARAM_IN),
								array($CurrentRelatPartyAddCountry,SQLSRV_PARAM_IN),
								array($CurrentRelatPartyAddDistrict,SQLSRV_PARAM_IN),
								array($CurrentRelatPartyAddParish,SQLSRV_PARAM_IN),
								array($CurrentRelatPartyAddCode,SQLSRV_PARAM_IN),
								array($CurrentRelatPartyAddStreet,SQLSRV_PARAM_IN),
								array($CurrentRelatPartyOwnerShip,SQLSRV_PARAM_IN),
								array(NULL,SQLSRV_PARAM_IN),//$CurrentRelatPartyProcuraRecordNumb
								array(NULL,SQLSRV_PARAM_IN),//$CurrentRelatPartyProcuraRegistDate
								array(NULL,SQLSRV_PARAM_IN),//$CurrentRelatPartyProcuraTermintDate
								array(NULL,SQLSRV_PARAM_IN),//$CurrentRelatPartySubStatus
								array($CurrentRelatPartySubType,SQLSRV_PARAM_IN),
								array($CurrentRelatPartyTypeRelation,SQLSRV_PARAM_IN),
								array($CurrentRelatPartyValidFrom,SQLSRV_PARAM_IN)
							);
	$execCurrentRelatParty = sqlsrv_query($conn, $callCurrentRelatParty, $paramsCurrentRelatParty) or die (print_r( sqlsrv_errors(),true));		
}else{
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty'])){
		foreach($array['GetCustomReportResponse']['GetCustomReportResult']['aCurrentRelations']['bRelatedPartyList']['bRelatedParty'] as $itemCurentRelatPartyList){
			if($itemCurentRelatPartyList['bContact']['cFixedLine']<>NULL){$CurrentRelatPartyLine=$itemCurentRelatPartyList['bContact']['cFixedLine'];}else{$CurrentRelatPartyLine=NULL;}				
			if($itemCurentRelatPartyList['bContact']['cMobilePhone']<>NULL){$CurrentRelatPartyPhone=$itemCurentRelatPartyList['bContact']['cMobilePhone'];}else{$CurrentRelatPartyPhone=NULL;}					
			if($itemCurentRelatPartyList['bCreditinfoId']<>NULL){$CurrentRelatPartyCreditFold=$itemCurentRelatPartyList['bCreditinfoId'];}else{$CurrentRelatPartyCreditFold=NULL;}					
			if($itemCurentRelatPartyList['bFullName']<>NULL){$CurrentRelatPartyFullname=$itemCurentRelatPartyList['bFullName'];}else{$CurrentRelatPartyFullname=NULL;}					
			if($itemCurentRelatPartyList['bGender']<>NULL){$CurrentRelatPartyGender=$itemCurentRelatPartyList['bGender'];}else{$CurrentRelatPartyGender=NULL;}					
			if($itemCurentRelatPartyList['bIDNumber']<>NULL){$CurrentRelatPartyIdNumb=$itemCurentRelatPartyList['bIDNumber'];}else{$CurrentRelatPartyIdNumb=NULL;}				
			if($itemCurentRelatPartyList['bIDNumberType']<>NULL){$CurrentRelatPartyIdNumbType=$itemCurentRelatPartyList['bIDNumberType'];}else{$CurrentRelatPartyIdNumbType=NULL;}				
			if($itemCurentRelatPartyList['bLTV']<>NULL){$CurrentRelatPartyLtv=$itemCurentRelatPartyList['bLTV'];}else{$CurrentRelatPartyLtv=NULL;}					
			if($itemCurentRelatPartyList['bMainAddress']['cAddressLine']<>NULL){$CurrentRelatPartyAddLine=$itemCurentRelatPartyList['bMainAddress']['cAddressLine'];}else{$CurrentRelatPartyAddLine=NULL;}					
			if($itemCurentRelatPartyList['bMainAddress']['cCity']<>NULL){$CurrentRelatPartyAddCity=$itemCurentRelatPartyList['bMainAddress']['cCity'];}else{$CurrentRelatPartyAddCity=NULL;}					
			if($itemCurentRelatPartyList['bMainAddress']['cCountry']<>NULL){$CurrentRelatPartyAddCountry=$itemCurentRelatPartyList['bMainAddress']['cCountry'];}else{$CurrentRelatPartyAddCountry=NULL;}					
			if($itemCurentRelatPartyList['bMainAddress']['cDistrict']<>NULL){$CurrentRelatPartyAddDistrict=$itemCurentRelatPartyList['bMainAddress']['cDistrict'];}else{$CurrentRelatPartyAddDistrict=NULL;}					
			if($itemCurentRelatPartyList['bMainAddress']['cParish']<>NULL){$CurrentRelatPartyAddParish=$itemCurentRelatPartyList['bMainAddress']['cParish'];}else{$CurrentRelatPartyAddParish=NULL;}					
			if($itemCurentRelatPartyList['bMainAddress']['cPostalCode']<>NULL){$CurrentRelatPartyAddCode=$itemCurentRelatPartyList['bMainAddress']['cPostalCode'];}else{$CurrentRelatPartyAddCode=NULL;}				
			if($itemCurentRelatPartyList['bMainAddress']['cStreet']<>NULL){$CurrentRelatPartyAddStreet=$itemCurentRelatPartyList['bMainAddress']['cStreet'];}else{$CurrentRelatPartyAddStreet=NULL;}								
			if($itemCurentRelatPartyList['bOwnershipShare']<>NULL){$CurrentRelatPartyOwnerShip=$itemCurentRelatPartyList['bOwnershipShare'];}else{$CurrentRelatPartyOwnerShip=NULL;}				
			if($itemCurentRelatPartyList['bProcura']['bProcuraRecordNumber']<>NULL){$CurrentRelatPartyProcuraRecordNumb=$itemCurentRelatPartyList['bProcura']['bProcuraRecordNumber'];}else{$CurrentRelatPartyProcuraRecordNumb=NULL;}					
			if($itemCurentRelatPartyList['bProcura']['bRegistrationDate']<>NULL){$CurrentRelatPartyProcuraRegistDate=$itemCurentRelatPartyList['bProcura']['bRegistrationDate'];}else{$CurrentRelatPartyProcuraRegistDate=NULL;}
			if($itemCurentRelatPartyList['bProcura']['bTerminationDate']<>NULL){$CurrentRelatPartyProcuraTermintDate=$itemCurentRelatPartyList['bProcura']['bTerminationDate'];}else{$CurrentRelatPartyProcuraTermintDate=NULL;}
			if($itemCurentRelatPartyList['bSubjectStatus']<>NULL){$CurrentRelatPartySubStatus=$itemCurentRelatPartyList['bSubjectStatus'];}else{$CurrentRelatPartySubStatus=NULL;}
			if($itemCurentRelatPartyList['bSubjectType']<>NULL){$CurrentRelatPartySubType=$itemCurentRelatPartyList['bSubjectType'];}else{$CurrentRelatPartySubType=NULL;}
			if($itemCurentRelatPartyList['bTypeOfRelation']<>NULL){$CurrentRelatPartyTypeRelation=$itemCurentRelatPartyList['bTypeOfRelation'];}else{$CurrentRelatPartyTypeRelation=NULL;}
			if($itemCurentRelatPartyList['bValidFrom']<>NULL){$CurrentRelatPartyValidFrom=$itemCurentRelatPartyList['bValidFrom'];}else{$CurrentRelatPartyValidFrom=NULL;}						
		
			$callCurrentRelatParty = "{call SP_INSERT_CURRENT_RELATIONS_RELATED_PARTY_LIST_COMPANY(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
			$paramsCurrentRelatParty = array(
										array($mappingId, SQLSRV_PARAM_IN),
										array($pefindoId,SQLSRV_PARAM_IN),
										array($CurrentRelatPartyLine,SQLSRV_PARAM_IN),
										array($CurrentRelatPartyPhone,SQLSRV_PARAM_IN),
										array($CurrentRelatPartyCreditFold,SQLSRV_PARAM_IN),
										array($CurrentRelatPartyFullname,SQLSRV_PARAM_IN),
										array($CurrentRelatPartyGender,SQLSRV_PARAM_IN),
										array($CurrentRelatPartyIdNumb,SQLSRV_PARAM_IN),
										array($CurrentRelatPartyIdNumbType,SQLSRV_PARAM_IN),
										array($CurrentRelatPartyLtv,SQLSRV_PARAM_IN),
										array($CurrentRelatPartyAddLine,SQLSRV_PARAM_IN),
										array($CurrentRelatPartyAddCity,SQLSRV_PARAM_IN),
										array($CurrentRelatPartyAddCountry,SQLSRV_PARAM_IN),
										array($CurrentRelatPartyAddDistrict,SQLSRV_PARAM_IN),
										array($CurrentRelatPartyAddParish,SQLSRV_PARAM_IN),
										array($CurrentRelatPartyAddCode,SQLSRV_PARAM_IN),
										array($CurrentRelatPartyAddStreet,SQLSRV_PARAM_IN),
										array($CurrentRelatPartyOwnerShip,SQLSRV_PARAM_IN),
										array($CurrentRelatPartyProcuraRecordNumb,SQLSRV_PARAM_IN),
										array($CurrentRelatPartyProcuraRegistDate,SQLSRV_PARAM_IN),
										array($CurrentRelatPartyProcuraTermintDate,SQLSRV_PARAM_IN),
										array($CurrentRelatPartySubStatus,SQLSRV_PARAM_IN),
										array($CurrentRelatPartySubType,SQLSRV_PARAM_IN),
										array($CurrentRelatPartyTypeRelation,SQLSRV_PARAM_IN),
										array($CurrentRelatPartyValidFrom,SQLSRV_PARAM_IN)
									);
			$execCurrentRelatParty = sqlsrv_query($conn, $callCurrentRelatParty, $paramsCurrentRelatParty) or die (print_r( sqlsrv_errors(),true));
		}
	}
}
?>