<?php
/* select table OTHER_LIABILITIES_SUMMARY */
$callINVOL = "{call SP_GET_TAB_PENYERTAAN_TBL_INVOLVEMENTS_SUMMARY(?)}";
$paramsINVOL = array(array($id, SQLSRV_PARAM_IN));
$execINVOL = sqlsrv_query( $conn, $callINVOL, $paramsINVOL) or die( print_r( sqlsrv_errors(), true));
$dataINVOL = sqlsrv_fetch_array($execINVOL);
?>
<div class="card">
	<div class="header">
		<p class="name">Penyertaan</p>
	</div>
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-bordered" style="width:100%;">
						<thead>
							<tr>
								<td colspan="4" class="bg-td"><p class="text-default" style="text-align:left;">RINGKASAN PENYERTAAN</p></td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="bg-td" style="width:20%;"><b>Jumlah Penyertaan Aktif</td></b>
								<td style="width:30%;"><?php echo $dataINVOL['NUMBER_OF_ACTIVE_INVOLVEMENTS'];?></td>
								<td class="bg-td" style="width:20%;"><b>Total Penyertaan Aktif</td></b>
								<td style="width:30%;"><?php echo $dataINVOL['TOTAL_AMOUNT_OF_ACTIVE_INVOLVEMENTS_CURRENCY']." ".number_format($dataINVOL['TOTAL_AMOUNT_OF_ACTIVE_INVOLVEMENTS_VALUE'],0,",",".");?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Jumlah Penyertaan Non-Aktif</td></b>
								<td colspan="4"><?php echo $dataINVOL['NUMBER_OF_PAST_INVOLVEMENTS'];?></td>
							</tr>
						</tbody>	
					</table>
				</div>
			</div>	
		</div>
	</div>
</div>