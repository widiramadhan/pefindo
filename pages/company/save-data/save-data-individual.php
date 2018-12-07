<?php
/* COMPANY */
if($array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual']<>NULL){$individual=$array['GetCustomReportResponse']['GetCustomReportResult']['aIndividual'];}else{$individual=NULL;}

$callindividual = "{call sp_insert_INDIVIDUAL_COMPANY(?,?,?)}";
$paramsindividual = array(
					array($mappingId, SQLSRV_PARAM_IN),
					array($pefindoId,SQLSRV_PARAM_IN),
					array($individual,SQLSRV_PARAM_IN)
);
$execindividual = sqlsrv_query($conn, $callindividual, $paramsindividual) or die (print_r( sqlsrv_errors(),true ));
?>