<?php
if($array['GetCustomReportResponse']['GetCustomReportResult']['aFinancials']['bFinancialStatementList']<>NULL){$FincStatment=$array['GetCustomReportResponse']['GetCustomReportResult']['aFinancials']['bFinancialStatementList'];}else{$FincStatment=NULL;}
		
$callFinancial = "{call SP_INSERT_FINANCIAL(?,?,?)}";
$paramsFinancial = array(
					array($mappingId, SQLSRV_PARAM_IN),
					array($pefindoId,SQLSRV_PARAM_IN),
					array($FincStatment,SQLSRV_PARAM_IN)
					);
$execFinancial = sqlsrv_query($conn, $callFinancial, $paramsFinancial) or die ( print_r( sqlsrv_errors(),true));
?>