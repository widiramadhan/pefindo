<?php
/* select table OTHER_LIABILITIES_SUMMARY */
$callOTLISUM = "{call SP_GET_TAB_TAGIHAN_TBL_OTHER_LIABILITIES_SUMMARY_COMPANY(?)}";
$paramsOTLISUM = array(array($id, SQLSRV_PARAM_IN));
$execOTLISUM = sqlsrv_query( $conn, $callOTLISUM, $paramsOTLISUM) or die( print_r( sqlsrv_errors(), true));
$dataOTLISUM = sqlsrv_fetch_array($execOTLISUM);
?>

<?php
/* select table OTHER_LIABILITIES_SUMMARY */
$callOTLISUMLIST = "{call SP_GET_TAB_TAGIHAN_TBL_OTHER_LIABILITIES_LIST_COMPANY(?)}";
$paramsOTLISUMLIST = array(array($id, SQLSRV_PARAM_IN));
$execOTLISUMLIST = sqlsrv_query( $conn, $callOTLISUMLIST, $paramsOTLISUMLIST) or die( print_r( sqlsrv_errors(), true));
$dataOTLISUMLIST = sqlsrv_fetch_array($execOTLISUMLIST);
?>
<div class="card">
	<div class="header"><p class="name">Tagihan Lainnya</p></div>
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-bordered" style="width:100%;">
						<thead>
							<tr>
								<td colspan="6" class="bg-td"><p><b>RINGKASAN TAGIHAN LAINNYA</p></td></b>
							</tr>
							<tr>
								<td class="bg-td" style="width:20%;"><b>Jumlah Tagihan Berjalan</td></b>
								<td colspan="2" style="width:20%;"><?php echo $dataOTLISUM['NUMBER_OF_OPEN_AGREEMENTS'];?></td>
								<td class="bg-td" style="width:20%;"><b>Total Nilai Pasar</td></b>
								<td colspan="2" style="width:20%;"><?php echo ($dataOTLISUM['TOTAL_MARKET_VALUE_CURRENCY']." ".number_format($dataOTLISUM['TOTAL_MARKET_VALUE_VALUE'],0,",","."));?></td>
							</tr>
							<tr>
								<td class="bg-td" style="width:20%;"><b>Jumlah Tagihan yang Sudah Ditutup</td></b>
								<td colspan="2"><?php echo $dataOTLISUM['NUMBER_OF_CLOSED_AGREEMENTS'];?></td>
								<td class="bg-td" style="width:20%;"><b>Total Tunggakan Pokok</td></b>
								<td colspan="2" style="width:20%;"><?php echo number_format($dataOTLISUM['TOTAL_PRINCIPAL_ARREARS_VALUE'],0,",",".");?></td>
							</tr>
						</thead>	
					</table>
				</div>
				<br>
				<div class="table-responsive">
					<table class="table table-bordered" style="width:100%;">
						<thead>
							<tr>
								<td colspan="5" class="bg-td"><p><b>Uraian Tagihan Lainnya</p></td></b>
							</tr>
							<tr>
								<th class="bg-td"><b>JENIS</th></b>
								<th class="bg-td"><b>STATUS</th></b>
								<th class="bg-td"><b>TANGGAL DIKELUARKAN</th></b>
								<th class="bg-td"><b>TANGGAL AKHIR</th></b>
								<th class="bg-td"><b>NILAI PASAR</th></b>
							</tr>
						</thead>
						<tbody>
							<tr class="header expand">
								<td align="center"><?php echo $dataOTLISUMLIST['CONTRACT_TYPE'];?></td>
								<td align="center"><?php echo $dataOTLISUMLIST['CONTRACT_STATUS'];?></td>
								<td align="center"><?php if($dataOTLISUMLIST['ISSUE_DATE']<>NULL){echo $dataOTLISUMLIST['ISSUE_DATE']->format('Y-m-d');}else{echo"";}?></td>
								<td align="center"><?php echo $dataOTLISUMLIST['REAL_DATE'];?></td>
								<td align="center"><?php echo $dataOTLISUMLIST['MARKET_VALUE_CURRENCY']." ".number_format($dataOTLISUMLIST['MARKET_VALUE_VALUE'],0,',','.');?><i class="fa fa-caret-square-o-down"></i></td>
							</tr>
							<tr class="child">
								<td colspan="6">
									<table class="table table-bordered">
										<tr>
											<td class="bg-td"><b>Nomor Rekening</td></b>
											<td align="right"><?php echo $dataOTLISUMLIST['CONTRACT_CODE'];?></td>
											<td class="bg-td"><b>Branch</td></b>
											<td align="right"><?php echo $dataOTLISUMLIST['BRANCH'];?></td>
										</tr>
										<tr>
											<td class="bg-td"><b>Nominal Awal</td></b>
											<td align="right"><?php echo $dataOTLISUMLIST['INITIAL_TOTAL_AMOUNT_CURRENCY']." ".number_format($dataOTLISUMLIST['INITIAL_TOTAL_AMOUNT_VALUE'],0,',','.');?></td>
											<td class="bg-td"><b>Tunggakan Pokok</td></b>
											<td align="right"><?php echo $dataOTLISUMLIST['PRINCIPAL_ARREARS_CURRENCY']." ".number_format($dataOTLISUMLIST['PRINCIPAL_ARREARS_VALUE'],0,',','.');?></td>
										</tr>
										<tr>
											<td class="bg-td"><b>Baki Debet</td></b>
											<td align="right"><?php echo $dataOTLISUMLIST['OUTSTANDING_AMOUNT_CURRENCY']." ".number_format($dataOTLISUMLIST['OUTSTANDING_AMOUNT_VALUE'],0,',','.');?></td>
											<td class="bg-td"><b>Jumlah Hari Tunggakan</td></b>
											<td align="right"><?php echo $dataOTLISUMLIST['PASTDUEDAY'];?></td>
										</tr>
										<tr>
											<td class="bg-td"><b>Valuta</td></b>
											<td align="right"><?php echo $dataOTLISUMLIST['CURRENCY_CONTRACT'];?></td>
											<td class="bg-td"><b>Kolektibilitas</td></b>
											<td align="right"><?php echo $dataOTLISUMLIST['NEGATIVE_STATUS'];?></td>
										</tr>
										<tr>
											<td class="bg-td"><b>Peringkat</td></b>
											<td align="right"><?php echo $dataOTLISUMLIST['RATING'];?></td>
											<td class="bg-td"><b>Tanggal Macet</td></b>
											<td align="right"><?php echo $dataOTLISUMLIST['DELIQUENCY_DATE'];?></td>
										</tr>
										<tr>
											<td class="bg-td"><b>Suku Bunga</td></b>
											<td align="right"><?php echo $dataOTLISUMLIST['INTEREST_RATE'];?></td>
											<td class="bg-td"><b>Tanggal Wanprestasi</td></b>
											<td align="right"><?php if($dataOTLISUMLIST['DEFAULT_DATE']<>NULL){echo $dataOTLISUMLIST['DEFAULT_DATE']->format('Y-m-d');}else{echo"";}?></td>
										</tr>
										<tr>
											<td class="bg-td"><b>Tanggal Jatuh Tempo</td></b>
											<td align="right"><?php if($dataOTLISUMLIST['MATURITY_DATE']<>NULL){echo $dataOTLISUMLIST['MATURITY_DATE']->format('Y-m-d');}else{echo"";}?></td>
											<td class="bg-td"><b>Sebab Macet</td></b>
											<td align="right"><?php echo $dataOTLISUMLIST['DEFAULT_REASON'];?></td>
										</tr>
										<tr>
											<td class="bg-td"><b>Tanggal Kondisi</td></b>
											<td align="right"><?php if($dataOTLISUMLIST['CONDITION_DATE']<>NULL){echo $dataOTLISUMLIST['CONDITION_DATE']->format('Y-m-d');}else{echo"";}?></td>
											<td class="bg-td"><b>Keterangan  Macet</td></b>
											<td align="right"><?php echo $dataOTLISUMLIST['DEFAULT_REASON_DESCRIPTION'];?></td>
										</tr>
										<tr>
											<td class="bg-td"><b>Tanggal Pengkinian Terakhir</td></b>
											<td align="right"><?php if($dataOTLISUMLIST['LAST_UPDATE']<>NULL){echo $dataOTLISUMLIST['LAST_UPDATE']->format('Y-m-d');}else{echo"";}?></td>
											<td class="bg-td"><b>ID Bank</td></b>
											<td align="right"><?php echo $dataOTLISUMLIST['CREDITOR'];?></td>
										</tr>
										<tr>
											<td class="bg-td"><b>Keterangan</td></b>
											<td align="right"><?php echo $dataOTLISUMLIST['DESCRIPTION'];?></td>
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