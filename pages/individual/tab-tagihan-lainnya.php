<?php
/* select table OTHER_LIABILITIES_SUMMARY */
$callOTLISUM = "{call SP_GET_TAB_TAGIHAN_TBL_OTHER_LIABILITIES_SUMMARY(?)}";
$paramsOTLISUM = array(array($id, SQLSRV_PARAM_IN));
$execOTLISUM = sqlsrv_query( $conn, $callOTLISUM, $paramsOTLISUM) or die( print_r( sqlsrv_errors(), true));
$dataOTLISUM = sqlsrv_fetch_array($execOTLISUM);
?>
<div class="card">
	<div class="header">
		<p class="name">Tagihan Lainnya</p>
	</div>
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-bordered" style="width:100%;">
						<thead>
							<tr>
								<td colspan="6" class="bg-td"><p class="text-default" style="text-align:left;">RINGKASAN TAGIHAN LAINNYA</p></td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="bg-td" style="width:20%;"><b>Jumlah Tagihan Berjalan</td></b>
								<td colspan="2" style="width:30%;"><?php echo $dataOTLISUM['NUMBER_OF_OPEN_AGREEMENTS'];?></td>
								<td class="bg-td" style="width:20%;"><b>Total Nilai Pasar</td></b>
								<td colspan="2" style="width:30%;"><?php echo ($dataOTLISUM['TOTAL_MARKET_VALUE_CURRENCY']." ".number_format($dataOTLISUM['TOTAL_MARKET_VALUE_VALUE'],0,",","."));?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Jumlah Tagihan yang Sudah Ditutup</td></b>
								<td colspan="2"><?php echo $dataOTLISUM['NUMBER_OF_CLOSED_AGREEMENTS'];?></td>
								<td class="bg-td"><b>Total Tunggakan Pokok</td></b>
								<td colspan="2"><?php echo ($dataOTLISUM['TOTAL_PRINCIPAL_ARREARS_CURRENCY']." ".number_format($dataOTLISUM['TOTAL_PRINCIPAL_ARREARS_VALUE'],0,",","."));?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>		
		</div>
	</div>
</div>