<?php
/* select table COLLATERALS_SUMMARY */
$callCOLSUM = "{call SP_GET_TAB_AGUNAN_TBL_COLLATERALS_SUMMARY(?)}";
$paramsCOLSUM = array(array($id, SQLSRV_PARAM_IN));
$execCOLSUM = sqlsrv_query( $conn, $callCOLSUM, $paramsCOLSUM) or die( print_r( sqlsrv_errors(), true));
$dataCOLSUM = sqlsrv_fetch_array($execCOLSUM);
?>
<div class="card">
	<div class="header">
		<p class="name">AGUNAN</p>
	</div>
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-bordered" style="width:100%;">
						<thead>
							<tr>
								<td colspan="4" class="bg-td"><p><b>RINGKASAN AGUNAN</p></td></b>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="bg-td" style="width:20%;"><b>Jumlah Agunan Tunai</td></b>
								<td style="width:30%;"><?php echo $dataCOLSUM['NUMBER_OF_CASH_COLLATERALS'];?></td>
								<td class="bg-td" style="width:20%;"><b>Total Nilai Agunan Non Tunai</td></b>
								<td style="width:30%;"><?php echo $dataCOLSUM['TOTAL_VALUE_OF_NON_CASH_COLLATERALS_CURRENCY']." ".number_format($dataCOLSUM['TOTAL_VALUE_OF_NON_CASH_COLLATERALS_VALUE_VALUE'],0,',','.');?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Jumlah Agunan Non Tunai</td></b>
								<td colspan="3"><?php echo $dataCOLSUM['NUMBER_OF_NON_CASH_COLLATERALS'];?></td>
							</tr>
						</tbody>	
					</table>
				</div>
				<div class="table-responsive">
					<table class="table table-bordered" style="width:100%;">
						<thead>
							<tr>
								<th class="bg-td" width = "30%">JENIS</th>
								<th class="bg-td" width = "20%">NILAI PAJAK</th>
								<th class="bg-td" width = "30%">PROPORSI</th>
								<th class="bg-td" width = "20%">PENGIRIMAN TERAKHIR</th>
							</tr>
						</thead>
						<tbody>
							<?php
								/* select table COLLATERALS_LIST */
								$callCOLIST = "{call SP_GET_TAB_AGUNAN_TBL_COLLATERALS_LIST(?)}";
								$paramsCOLIST = array(array($id, SQLSRV_PARAM_IN));
								$execCOLIST = sqlsrv_query( $conn, $callCOLIST, $paramsCOLIST) or die( print_r( sqlsrv_errors(), true));
								while($dataCOLIST = sqlsrv_fetch_array($execCOLIST)){
							?>
							<tr class="header expand">
								<td align="center"><?php echo $dataCOLIST['TYPE'];?></td>
								<td align="center"><?php echo number_format($dataCOLIST['TAX_VALUE_VALUE'],0,',','.');?></td>
								<td align="center"><?php echo round((float)$dataCOLIST['PROPORTION']).'%';?></td>
								<td align="center"><?php echo $dataCOLIST['LAST_UPDATE']-> format('Y-m-d');?><i class="fa fa-caret-square-o-down"></i></td>
							</tr>
							<tr class="child">
								<td colspan="4">
									<table class="table table-bordered">
										<tr>
											<td class="bg-td"><b>Bank Value</td></b>
											<td align="right"><?php echo number_format($dataCOLIST['BANK_VALUE_VALUE'],0,',','.');?></td>
											<td class="bg-td"><b>Description</td></b>
											<td align="right"><?php echo $dataCOLIST['DESCRIPTION'];?></td>
										</tr>
										<tr>
											<td class="bg-td"><b>Appraisal Value</td></b>
											<td align="right"><?php echo $dataCOLIST['APPRAISALVALUE'];?></td>
											<td class="bg-td"><b>Owner Name</td></b>
											<td align="right"><?php echo $dataCOLIST['OWNER_NAME'];?></td>
										</tr>
										<tr>
											<td class="bg-td"><b>Valuation Date</td></b>
											<td align="right"><?php echo $dataCOLIST['VALUATION_DATE']->format('Y-m-d');?></td>
											<td class="bg-td"><b>Ownership Proof</td></b>
											<td align="right"><?php echo $dataCOLIST['OWNER_SHIP_PROOF'];?></td>
										</tr>
										<tr>
											<td class="bg-td"><b>Security Assignment Type</td></b>
											<td align="right"><?php echo $dataCOLIST['SECURITY_ASSIGMENT_TYPE'];?></td>
											<td class="bg-td"><b>Collateral Code</td></b>
											<td align="right"><?php echo $dataCOLIST['COLLATERAL_CODE'];?></td>
										</tr>
										<tr>
											<td class="bg-td"><b>Insurance</td></b>
											<td align="right"><?php echo $dataCOLIST['INSURANCE'];?></td>
											<td class="bg-td"><b>Creditor</td></b>
											<td align="right"><?php echo $dataCOLIST['CREDITOR'];?></td>
										</tr>
										<tr>
											<td class="bg-td"><b>Address</td></b>
											<td colspan="3"></td>
										</tr>
									</table>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>			
		</div>
	</div>
</div>