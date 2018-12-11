<?php
$callPAQ = "{call SP_INSERT_CIQ_SUMMARY_COMPANY(?)}";
$paramsPAQ = array(array($id, SQLSRV_PARAM_IN));
$execPAQ = sqlsrv_query( $conn, $callPAQ, $paramsPAQ) or die( print_r( sqlsrv_errors(), true));
$dataPAQ = sqlsrv_fetch_array($execPAQ);
?>
<div id="Financial" class="tab-pane fade in active"> 
	<div class="card">
		<div class="header"><p class="name">PEFINDO Alert Quest (PAQ)</p></div>
			<div class="content">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-bordered" style="width:100%;">
								<thead>
									<tr>
										<th align ="left" class="bg-td"><b>Pefindo Quest Summary</th></b>
									</tr>
								</thead>	
								<tbody>
									<tr>
										<td width="30%;" class="bg-td"><b>No. of CIQ Fraud Alerts</b></td>
										<td width="20%;"><?php echo $dataPAQ['NUMBER_OF_FRAUD_ALERTS_PRIMARY_SUBJECT'];?></td>
										<td width="30%;" class="bg-td"><b>No. of CIQ Fraud Alerts - Third Party</b></td>
										<td width="20%;"><?php if($dataPAQ['NUMBER_OF_FRAUD_ALERTS_THIRD_PARTY']<> NULL){echo $dataPAQ['NUMBER_OF_FRAUD_ALERTS_THIRD_PARTY'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td width="30%;" class="bg-td"><b>Last Fraud Registration Date</b></td>
										<td width="20%;"><?php echo if($dataPAQ['DATE_OF_LAST_FRAUD_REGISTRATION_PRIMARY_SUBJECT']<> NULL){echo $dataPAQ['DATE_OF_LAST_FRAUD_REGISTRATION_PRIMARY_SUBJECT'];}else{echo"-";}?></td>
										<td width="30%;" class="bg-td"><b>Last Fraud Registration Date - Third Party</b></td>
										<td width="20%;"><?php if($dataPAQ['DATE_OF_LAST_FRAUD_REGISTRATION_THIRD_PARTY']<> NULL){echo $dataPAQ['DATE_OF_LAST_FRAUD_REGISTRATION_THIRD_PARTY'];}else{echo"-";}?></td>
									</tr>
								</tbody>
							</table>
						</div>		
					</div>
				</div>				
			</div>					
	</div>							
</div>