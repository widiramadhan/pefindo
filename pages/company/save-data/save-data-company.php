<?php
/* COMPANY */
if($array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bGeneral']['bCompanyName']<>NULL){$company=$array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bGeneral']['bCompanyName'];}else{$company=NULL;}

if($array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bContact']['bEmail']<>NULL){$CompanyEmail=$array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bContact']['bEmail'];}else{$CompanyEmail=NULL;}

if($array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bContact']['bFixedLine']<>NULL){$CompanyFixedLine=$array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bContact']['bFixedLine'];}else{$CompanyFixedLine=NULL;}

if($array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bContact']['bMobilePhone']<>NULL){$CompanyMobilePhone=$array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bContact']['bMobilePhone'];}else{$CompanyMobilePhone=NULL;}

if($array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bGeneral']['bCategory']<>NULL){$CompanyCategory=$array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bGeneral']['bCategory'];}else{$CompanyCategory=NULL;}

if($array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bGeneral']['bCompanyName']<>NULL){$CompanyCompanyName=$array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bGeneral']['bCompanyName'];}else{$CompanyCompanyName=NULL;}

if($array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bGeneral']['bCompanyNameLocal']<>NULL){$CompanyCompanyNameLocal=$array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bGeneral']['bCompanyNameLocal'];}else{$CompanyCompanyNameLocal=NULL;}

if($array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bGeneral']['bEconomicSector']<>NULL){$CompanyEconomiSector=$array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bGeneral']['bEconomicSector'];}else{$CompanyEconomiSector=NULL;}

if($array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bGeneral']['bEstablishmentDate']<>NULL){$CompanyEstabilishmentDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bGeneral']['bEstablishmentDate'];}else{$CompanyEstabilishmentDate=NULL;}

if($array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bGeneral']['bEstablishmentLocation']<>NULL){$CompanyEstabilishmentLocation=$array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bGeneral']['bEstablishmentLocation'];}else{$CompanyEstabilishmentLocation=NULL;}

if($array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bGeneral']['bGroupName']<>NULL){$CompanyGroupName=$array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bGeneral']['bGroupName'];}else{$CompanyGroupName=NULL;}

if($array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bGeneral']['bLegalForm']<>NULL){$CompanyLegalForm=$array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bGeneral']['bLegalForm'];}else{$CompanyLegalForm=NULL;}

if($array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bGeneral']['bMarketListed']<>NULL){$CompanyMarketListed=$array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bGeneral']['bMarketListed'];}else{$CompanyMarketListed=NULL;}

if($array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bGeneral']['bRating']<>NULL){$CompanyRating=$array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bGeneral']['bRating'];}else{$CompanyRating=NULL;}

if($array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bGeneral']['bRatingAuthority']<>NULL){$CompanyRatingAuthority=$array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bGeneral']['bRatingAuthority'];}else{$CompanyRatingAuthority=NULL;}

if($array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bGeneral']['bRatingDate']<>NULL){$CompanyRatingDate=$array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bGeneral']['bRatingDate'];}else{$CompanyRatingDate=NULL;}

if($array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bIdentifications']['bLatestDateOfDeed']<>NULL){$CompanyLastDateDeed = $array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bIdentifications']['bLatestDateOfDeed'];}else{$CompanyLastDateDeed=NULL;}

if($array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bIdentifications']['bLatestDeedNumber']<>NULL){$CompanyLastDeedNumb = $array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bIdentifications']['bLatestDeedNumber'];}else{$CompanyLastDeedNumb=NULL;}

if($array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bIdentifications']['bNPWP']<>NULL){$CompanyNpwp = $array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bIdentifications']['bNPWP'];}else{$CompanyNpwp=NULL;}

if($array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bIdentifications']['bRegistrationNumber']<>NULL){$CompanyRegistrationNumb = $array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bIdentifications']['bRegistrationNumber'];}else{$CompanyRegistrationNumb=NULL;}

if($array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bMainAddress']['bAddressLine']<>NULL){$CompanyAddressLine=$array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bMainAddress']['bAddressLine'];}else{$CompanyAddressLine=NULL;}

if($array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bMainAddress']['bCity']<>NULL){$CompanyCity=$array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bMainAddress']['bCity'];}else{$CompanyCity=NULL;}

if($array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bMainAddress']['bCountry']<>NULL){$CompanyCountry=$array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bMainAddress']['bCountry'];}else{$CompanyCountry=NULL;}

if($array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bMainAddress']['bDistrict']<>NULL){$CompanyDistrict=$array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bMainAddress']['bDistrict'];}else{$CompanyDistrict=NULL;}

if($array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bMainAddress']['bParish']<>NULL){$CompanyParish=$array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bMainAddress']['bParish'];}else{$CompanyParish=NULL;}

if($array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bMainAddress']['bPostalCode']<>NULL){$CompanyPostalCode=$array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bMainAddress']['bPostalCode'];}else{$CompanyPostalCode=NULL;}

if($array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bMainAddress']['bStreet']<>NULL){$CompanyStreet=$array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']['bMainAddress']['bStreet'];}else{$CompanyStreet=NULL;}


$callCompany = "{call SP_INSERT_COMPANY_COMPANY(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
$paramsCompany = array(
					array($mappingId, SQLSRV_PARAM_IN),
					array($pefindoId,SQLSRV_PARAM_IN),
					array($company,SQLSRV_PARAM_IN),
					array($CompanyEmail,SQLSRV_PARAM_IN),
					array($CompanyFixedLine,SQLSRV_PARAM_IN),
					array($CompanyMobilePhone,SQLSRV_PARAM_IN),
					array($CompanyCategory,SQLSRV_PARAM_IN),
					array($CompanyCompanyName,SQLSRV_PARAM_IN),
					array($CompanyCompanyNameLocal,SQLSRV_PARAM_IN),
					array($CompanyEconomiSector,SQLSRV_PARAM_IN),
					array($CompanyEstabilishmentDate,SQLSRV_PARAM_IN),
					array($CompanyEstabilishmentLocation,SQLSRV_PARAM_IN),
					array($CompanyGroupName,SQLSRV_PARAM_IN),
					array($CompanyLegalForm,SQLSRV_PARAM_IN),
					array($CompanyMarketListed,SQLSRV_PARAM_IN),
					array($CompanyRating,SQLSRV_PARAM_IN),
					array($CompanyRatingAuthority,SQLSRV_PARAM_IN),
					array($CompanyRatingDate,SQLSRV_PARAM_IN),
					array($CompanyLastDateDeed,SQLSRV_PARAM_IN),
					array($CompanyLastDeedNumb,SQLSRV_PARAM_IN),
					array($CompanyNpwp,SQLSRV_PARAM_IN),
					array($CompanyRegistrationNumb,SQLSRV_PARAM_IN),
					array($CompanyAddressLine,SQLSRV_PARAM_IN),
					array($CompanyCity,SQLSRV_PARAM_IN),
					array($CompanyCountry,SQLSRV_PARAM_IN),
					array($CompanyDistrict,SQLSRV_PARAM_IN),
					array($CompanyParish,SQLSRV_PARAM_IN),
					array($CompanyPostalCode,SQLSRV_PARAM_IN),
					array($CompanyStreet,SQLSRV_PARAM_IN)					
);
$execCompany = sqlsrv_query($conn, $callCompany, $paramsCompany) or die (print_r( sqlsrv_errors(),true ));
?>