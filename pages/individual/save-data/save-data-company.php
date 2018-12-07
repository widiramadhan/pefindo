<?php
/* COMPANY */
if($array['GetCustomReportResponse']['GetCustomReportResult']['aCompany']<>NULL){$company=$array['GetCustomReportResponse']['GetCustomReportResult']['aCompany'];}else{$company=NULL;}

$callCompany = "{call SP_INSERT_COMPANY(?,?,?)}";
$paramsCompany = array(
					array($mappingId, SQLSRV_PARAM_IN),
					array($pefindoId,SQLSRV_PARAM_IN),
					array($company,SQLSRV_PARAM_IN)
);
$execCompany = sqlsrv_query($conn, $callCompany, $paramsCompany) or die (print_r( sqlsrv_errors(),true ));
?>