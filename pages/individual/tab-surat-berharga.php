<?php
/* select table SECURITIES_SUMMARY */
$callSRT = "{call SP_GET_TAB_SRTBERHARGA_TBL_SECURITIES_SUMMARY(?)}";
$paramsSRT = array(array($id, SQLSRV_PARAM_IN));
$execSRT = sqlsrv_query( $conn, $callSRT, $paramsSRT) or die( print_r( sqlsrv_errors(), true));
$dataSRT = sqlsrv_fetch_array($execSRT);
?>

<div class="card">
	<div class="header">
		<p class="name">Surat Berharga</p>
	</div>
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-bordered" style="width:100%;">
						<thead>
							<tr>
								<th colspan="6" class="bg-td"><p class="text-default" style="text-align:left;">Ringkasan Surat Berharga</p></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="bg-td" style="width:20%;"><b>Jumlah Surat Berharga Aktif</td></b>
								<td colspan="2" style="width:30%;"><?php echo $dataSRT['NUMBER_OF_ACTIVE_SECURITIES'];?></td>
								<td class="bg-td" style="width:20%;"><b>Total Nilai Pasar</td></b>
								<td colspan="2" style="width:30%;"><?php echo $dataSRT['TOTAL_MARKET_VALUE_CURRENCY']." ".number_format($dataSRT['TOTAL_MARKET_VALUE_VALUE'],0,",",".");?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Jumlah Surat Berharga non-Aktif</td></b>
								<td colspan="2"><?php echo $dataSRT['NUMBER_OF_PAST_SECURITIES'];?></td>
								<td class="bg-td"><b>Total Tunggakan Pokok</td></b>
								<td colspan="2"><?php echo $dataSRT['TOTAL_PRINCIPAL_ARREARS_CURRENCY']." ".number_format($dataSRT['TOTAL_PRINCIPAL_ARREARS_VALUE'],0,",",".");?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>	
					
		</div>
	</div>
</div>
	