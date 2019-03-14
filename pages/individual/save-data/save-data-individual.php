<?php
/* Contact */
//if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bContact']['bEmail']<>NULL){$indivContEmail=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bContact']['bEmail'];}else{$indivContEmail=NULL;}		
if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bContact']['bFixedLine']<>NULL){$indivContFixLine=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bContact']['bFixedLine'];}else{$indivContFixLine=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bContact']['bMobilePhone']<>NULL){$indivContPhone=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bContact']['bMobilePhone'];}else{$indivContPhone=NULL;}
/* General */
if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bAlias']<>NULL){$IndivGenAlias=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bAlias'];}else{$IndivGenAlias=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bCitizenship']<>NULL){$IndivGenCitizen=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bCitizenship'];}else{$IndivGenCitizen=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bClassificationOfIndividual']<>NULL){$IndivGenClassification=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bClassificationOfIndividual'];}else{$IndivGenClassification=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bDateOfBirth']<>NULL){$IndivGenDateBirth=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bDateOfBirth'];}else{$IndivGenDateBirth=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bEducation']<>NULL){$IndivGenEducation=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bEducation'];}else{$IndivGenEducation=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bEmployerName']<>NULL){$IndivGenEmpname=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bEmployerName'];}else{$IndivGenEmpname=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bEmployerSector']<>NULL){$IndivGenEmpSec=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bEmployerSector'];}else{$IndivGenEmpSec=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bEmployment']<>NULL){$IndivGenEmployee=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bEmployment'];}else{$IndivGenEmployee=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bFullName']<>NULL){$IndivGenFullname=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bFullName'];}else{$IndivGenFullname=NULL;}
//if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bFullNameLocal']<>NULL){$IndivGenFullnmLocal=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bFullNameLocal'];}else{$IndivGenFullnmLocal=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bGender']<>NULL){$IndivGenGender=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bGender'];}else{$IndivGenGender=NULL;}
//if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bMaritalStatus']<>NULL){$IndivGenMartStatus=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bMaritalStatus'];}else{$IndivGenMartStatus=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bMotherMaidenName']<>NULL){$IndivGenMotherName=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bMotherMaidenName'];}else{$IndivGenMotherName=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bPlaceOfBirth']<>NULL){$IndivGenPlaceBirth=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bPlaceOfBirth'];}else{$IndivGenPlaceBirth=NULL;}
//if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bResidency']<>NULL){$IndivGenResidency=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bResidency'];}else{$IndivGenResidency=NULL;}	
if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bSocialStatus']<>NULL){$IndivGenSocStatus=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bGeneral']['bSocialStatus'];}else{$IndivGenSocStatus=NULL;}
/* Identifications */
if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bIdentifications']['bKTP']<>NULL){$IndivIdentKTP=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bIdentifications']['bKTP'];}else{$IndivIdentKTP=NULL;}		
if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bIdentifications']['bNPWP']<>NULL){$IndivIdentNPWP=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bIdentifications']['bNPWP'];}else{$IndivIdentNPWP=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bIdentifications']['bPassportIssuerCountry']<>NULL){$IndivIdentPassCountry=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bIdentifications']['bPassportIssuerCountry'];}else{$IndivIdentPassCountry=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bIdentifications']['bPassportNumber']<>NULL){$IndivIdentPassNumb=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bIdentifications']['bPassportNumber'];}else{$IndivIdentPassNumb=NULL;}
/* MainAdress */
if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bMainAddress']['bAddressLine']<>NULL){$IndivMainAddLine=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bMainAddress']['bAddressLine'];}else{$IndivMainAddLine=NULL;}	
if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bMainAddress']['bCity']<>NULL){$IndivMainAddCity=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bMainAddress']['bCity'];}else{$IndivMainAddCity=NULL;}	
if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bMainAddress']['bCountry']<>NULL){$IndivMainAddCountry=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bMainAddress']['bCountry'];}else{$IndivMainAddCountry=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bMainAddress']['bDistrict']<>NULL){$IndivMainAddDistrict=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bMainAddress']['bDistrict'];}else{$IndivMainAddDistrict=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bMainAddress']['bParish']<>NULL){$IndivMainAddParish=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bMainAddress']['bParish'];}else{$IndivMainAddParish=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bMainAddress']['bPostalCode']<>NULL){$IndivMainAddPostCode=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bMainAddress']['bPostalCode'];}else{$IndivMainAddPostCode=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bMainAddress']['bStreet']<>NULL){$IndivMainAddStreet=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']['bMainAddress']['bStreet'];}else{$IndivMainAddStreet=NULL;}

$callIndividual = "{call SP_INSERT_INDIVIDUAL(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
$paramsIndividual = array(
					array($mappingId, SQLSRV_PARAM_IN),
					array($pefindoId,SQLSRV_PARAM_IN),
					array(NULL,SQLSRV_PARAM_IN),//$indivContEmail
					array($indivContFixLine,SQLSRV_PARAM_IN),
					array($indivContPhone,SQLSRV_PARAM_IN),
					array($IndivGenAlias,SQLSRV_PARAM_IN),
					array($IndivGenCitizen,SQLSRV_PARAM_IN),
					array($IndivGenClassification,SQLSRV_PARAM_IN),
					array($IndivGenDateBirth,SQLSRV_PARAM_IN),
					array($IndivGenEducation,SQLSRV_PARAM_IN),
					array($IndivGenEmpname,SQLSRV_PARAM_IN),
					array($IndivGenEmpSec,SQLSRV_PARAM_IN),
					array($IndivGenEmployee,SQLSRV_PARAM_IN),
					array($IndivGenFullname,SQLSRV_PARAM_IN),
					array(NULL,SQLSRV_PARAM_IN),//$IndivGenFullnmLocal
					array($IndivGenGender,SQLSRV_PARAM_IN),
					array(NULL,SQLSRV_PARAM_IN),//$IndivGenMartStatus
					array($IndivGenMotherName,SQLSRV_PARAM_IN),
					array($IndivGenPlaceBirth,SQLSRV_PARAM_IN),
					array(null,SQLSRV_PARAM_IN), //$IndivGenResidency
					array($IndivGenSocStatus,SQLSRV_PARAM_IN),
					array($IndivIdentKTP,SQLSRV_PARAM_IN),
					array($IndivIdentNPWP,SQLSRV_PARAM_IN),
					array($IndivIdentPassCountry,SQLSRV_PARAM_IN),
					array($IndivIdentPassNumb,SQLSRV_PARAM_IN),
					array($IndivMainAddLine,SQLSRV_PARAM_IN),
					array($IndivMainAddCity,SQLSRV_PARAM_IN),
					array($IndivMainAddCountry,SQLSRV_PARAM_IN),
					array($IndivMainAddDistrict,SQLSRV_PARAM_IN),
					array($IndivMainAddParish,SQLSRV_PARAM_IN),
					array($IndivMainAddPostCode,SQLSRV_PARAM_IN),
					array($IndivMainAddStreet,SQLSRV_PARAM_IN)
					);
$execIndividual = sqlsrv_query($conn, $callIndividual, $paramsIndividual) or die ( print_r( sqlsrv_errors(),true));
?>