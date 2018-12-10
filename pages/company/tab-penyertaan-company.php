<?php
/* select table INVOLVEMENTS_SUMMARY_COMPANY */
$callINVOLCOM = "{call SP_GET_TAB_PENYERTAAN_TBL_INVOLVEMENTS_SUMMARY_COMPANY(?)}";
$paramsINVOLCOM = array(array($id, SQLSRV_PARAM_IN));
$execINVOLCOM = sqlsrv_query( $conn, $callINVOLCOM, $paramsINVOLCOM) or die( print_r( sqlsrv_errors(), true));
$dataINVOLCOM = sqlsrv_fetch_array($execINVOLCOM);
?>

<?php
/* select table INVOLVEMENTS_LIST_COMPANY */
$callINVOLCOMLIST = "{call SP_GET_TAB_PENYERTAAN_TBL_INVOLVEMENTS_LIST_COMPANY(?)}";
$paramsINVOLCOMLIST = array(array($id, SQLSRV_PARAM_IN));
$execINVOLCOMLIST = sqlsrv_query( $conn, $callINVOLCOMLIST, $paramsINVOLCOMLIST) or die( print_r( sqlsrv_errors(), true));
$dataINVOLCOMLIST = sqlsrv_fetch_array($execINVOLCOMLIST);
?>
<div class="card">
	<div class="header"><p class="name">Penyertaan</p></div>
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-bordered" style="width:100%;">
						<thead>
							<tr>
								<td colspan="4" class="bg-td"><p><b>RINGKASAN PENYERTAAN</p></td></b>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="bg-td" style="width:20%;"><b>Jumlah Penyertaan Aktif</td></b>
								<td style="width:20%;"><?php echo $dataINVOLCOM['NUMBER_OF_ACTIVE_INVOLVEMENTS'];?></td>
								<td class="bg-td" style="width:20%;"><b>Total Penyertaan Aktif</td></b>
								<td style="width:20%;"><?php echo $dataINVOLCOM['TOTAL_AMOUNT_OF_ACTIVE_INVOLVEMENTS_CURRENCY']." ".number_format($dataINVOLCOM['TOTAL_AMOUNT_OF_ACTIVE_INVOLVEMENTS_VALUE'],0,",",".");?></td>
							</tr>
							<tr>
								<td class="bg-td" style="width:20%;"><b>Jumlah Penyertaan Non-Aktif</td></b>
								<td colspan="4"><?php echo $dataINVOLCOM['NUMBER_OF_PAST_INVOLVEMENTS'];?></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="table-responsive">
					<table class="table table-bordered" style="width:100%;">
						<thead>
							<tr>
								<td colspan="5" class="bg-td"><p><b>URAIAN PENYERTAAN</p></td></b>
							</tr>
							<tr>
								<th class="bg-td"><b>TUJUAN PENYERTAAN</th></b>
								<th class="bg-td"><b>STATUS</th></b>
								<th class="bg-td"><b>TANGGAL MULAI</th></b>
								<th class="bg-td"><b>TANGGAL AKHIR</th></b>
								<th class="bg-td"><b>NILAI PENYERTAAN</th></b>
							</tr>
						</thead>
						<tbody>
							<tr class="header expand">
								<td align="center"><?php echo $dataINVOLCOMLIST['INVOLVEMENT_PURPOSE'];?></td>
								<td align="center"><?php echo $dataINVOLCOMLIST['STATUS'];?></td>
								<td align="center"><?php if($dataINVOLCOMLIST['START_DATE']<>NULL){echo $dataINVOLCOMLIST['START_DATE']->format('Y-m-d');}else{echo"";}?></td>
								<td align="center"><?php echo $dataINVOLCOMLIST['REAL_DATE'];?></td>
								<td align="center"><?php echo $dataINVOLCOMLIST ['TOTAL_AMOUNT_CURRENCY']." ".number_format($dataINVOLCOMLIST['TOTAL_AMOUNT_VALUE'],0,',','.');?><i class="fa fa-caret-square-o-down"></i></td>
							</tr>
							<tr class="child">
								<td colspan="6">
									<table class="table table-bordered">
										<tr>
											<td class="bg-td"><b>Nilai Penyertaan Awal</td></b>
											<td align="right"><?php echo $dataINVOLCOMLIST ['INITIAL_TOTAL_AMOUNT_CURRENCY']." ".number_format($dataINVOLCOMLIST['INITIAL_TOTAL_AMOUNT_VALUE'],0,',','.');?></td>
											<td class="bg-td"><b>Kolektibilitas</td></b>
											<td align="right"><?php echo $dataINVOLCOMLIST['NEGATIVE_STATUS'];?></td>
										</tr>
										<tr>
											<td class="bg-td"><b>Valuta</td></b>
											<td align="right"><?php echo $dataINVOLCOMLIST['CURRENCY_CONTRACT'];?></td>
											<td class="bg-td"><b>Tanggal Wanprestasi</td></b>
											<td align="right"><?php echo $dataINVOLCOMLIST['DEFAULT_DATE'];?></td>
										</tr>
										<tr>
											<td class="bg-td"><b>Tanggal Kondisi</td></b>
											<td align="right"><?php echo $dataINVOLCOMLIST['CONDITION_DATE'];?></td>
											<td class="bg-td"><b>Sebab Macet</td></b>
											<td align="right"><?php echo $dataINVOLCOMLIST['DEFAULT_REASON'];?></td>
										</tr>
										<tr>
											<td class="bg-td"><b>ID Bank</td></b>
											<td align="right"><?php echo $dataINVOLCOMLIST['CREDITOR'];?></td>
											<td class="bg-td"><b>Keterangan Macet</td></b>
											<td align="right"><?php echo $dataINVOLCOMLIST['DEFAULT_REASON_DESCRIPTION'];?></td>
										</tr>
										<tr>
											<td class="bg-td"><b>Nomor Rekening</td></b>
											<td align="right"><?php echo $dataINVOLCOMLIST['CONTRACT_CODE'];?></td>
											<td class="bg-td"><b>Tanggal Pengkinian Terakhir</td></b>
											<td align="right"><?php if($dataINVOLCOMLIST['LAST_UPDATE']<>NULL){echo $dataINVOLCOMLIST['LAST_UPDATE']->format('Y-m-d');}else{echo"";}?></td>
										</tr>
									</table>
								</td>	
							</tr>												
						</tbody>	
					</table>										
				</div>
			</div>	
		</div>
	</div>
</div>