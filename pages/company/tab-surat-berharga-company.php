<?php
/* select table SECURITIES_SUMMARY */
$callSRTCOM = "{call SP_GET_TAB_SRTBERHARGA_TBL_SECURITIES_SUMMARY_COMPANY(?)}";
$paramsSRTCOM = array(array($id, SQLSRV_PARAM_IN));
$execSRTCOM = sqlsrv_query( $conn, $callSRTCOM, $paramsSRTCOM) or die( print_r( sqlsrv_errors(), true));
$dataSRTCOM = sqlsrv_fetch_array($execSRTCOM);
?>

<?php
/* select table SECURITIES_SUMMARY */
$callSRTCOMLIST = "{call SP_GET_TAB_SRTBERHARGA_TBL_SECURITIES_LIST_COMPANY(?)}";
$paramsSRTCOMLIST = array(array($id, SQLSRV_PARAM_IN));
$execSRTCOMLIST = sqlsrv_query( $conn, $callSRTCOMLIST, $paramsSRTCOMLIST) or die( print_r( sqlsrv_errors(), true));
$dataSRTCOMLIST = sqlsrv_fetch_array($execSRTCOMLIST);
?>
<style>
tr.header{
    cursor:pointer;
}
.header .sign:after{
  content:"+";
  display:inline-block;      
}
.header.expand .sign:after{
  content:"-";
 }
 </style>
<div class="card">
	<div class="header"><p class="name">Surat Berharga</p></div>
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-bordered" style="width:100%;">
						<thead>
							<tr>
								<td colspan="6" class="bg-td"><p><b>Ringkasan Surat Berharga</p></td></b>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="bg-td" style="width:20%;"><b>Jumlah Surat Berharga Aktif</td></b>
								<td colspan="2" style="width:20%;"><?php echo $dataSRTCOM['NUMBER_OF_ACTIVE_SECURITIES'];?></td>
								<td class="bg-td" style="width:20%;"><b>Total Nilai Pasar</td></b>
								<td colspan="2" style="width:20%;"><?php echo $dataSRTCOM['TOTAL_MARKET_VALUE_CURRENCY']." ".number_format($dataSRTCOM['TOTAL_MARKET_VALUE_VALUE'],0,",",".");?></td>
							</tr>
							<tr>
								<td class="bg-td" style="width:20%;"><b>Jumlah Surat Berharga non-Aktif</td></b>
								<td colspan="2"><?php echo $dataSRTCOM['NUMBER_OF_PAST_SECURITIES'];?></td>
								<td class="bg-td" style="width:20%;"><b>Total Tunggakan Pokok</td></b>
								<td colspan="2" style="width:20%;"><?php echo $dataSRTCOM['TOTAL_PRINCIPAL_ARREARS_CURRENCY']." ".number_format($dataSRTCOM['TOTAL_PRINCIPAL_ARREARS_VALUE'],0,",",".");?></td>
							</tr>
						</tbody>	
					</table>
					<br>
					<div class="table-responsive">
						<table class="table table-bordered" style="width:100%;">
							<thead>
								<tr>
									<td colspan="5" class="bg-td"><p><b>Uraian Surat Berharga</p></td></b>
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
									<td align="center"><?php echo $dataSRTCOMLIST['SECURITY_TYPE'];?></td>
									<td align="center"><?php echo $dataSRTCOMLIST['CONTRACT_STATUS'];?></td>
									<td align="center"><?php if($dataSRTCOMLIST['ISSUE_DATE']<>NULL){echo $dataSRTCOMLIST['ISSUE_DATE']->format('Y-m-d');}else{echo"";}?></td>
									<td align="center"><?php echo $dataSRTCOMLIST['REAL_DATE'];?></td>
									<td align="center"><?php echo $dataSRTCOMLIST['MARKET_VALUE_CURRENCY']." ".number_format($dataSRTCOMLIST['MARKET_VALUE_VALUE'],0,',','.');?><i class="fa fa-caret-square-o-down"></i></td>
								</tr>
								<tr class="child">
									<td colspan="6">
										<table class="table table-bordered">
											<tr>
												<td class="bg-td"><b>Contract Code</td></b>
												<td align="right"><?php echo $dataSRTCOMLIST['CONTRACT_CODE'];?></td>
												<td class="bg-td"><b>Branch</td></b>
												<td align="right"><?php echo $dataSRTCOMLIST['BRANCH'];?></td>
											</tr>
											<tr>
												<td class="bg-td"><b>Initial Total Amount</td></b>
												<td align="right"><?php echo $dataSRTCOMLIST['INITIAL_TOTAL_AMOUNT_CURRENCY']." ".number_format($dataSRTCOMLIST['INITIAL_TOTAL_AMOUNT_VALUE'],0,',','.');?></td>
												<td class="bg-td"><b>Purpose of Ownership</td></b>
												<td align="right"><?php echo $dataSRTCOMLIST['PURPOSE_OWNERSHIP'];?></td>
											</tr>
											<tr>
												<td class="bg-td"><b>Acquisition Value</td></b>
												<td align="right"><?php echo $dataSRTCOMLIST['ACQUISITION_AMOUNT'];?></td>
												<td class="bg-td"><b>Acquisition Date</td></b>
												<td align="right"><?php if($dataSRTCOMLIST['ACQUISITION_DATE']<>NULL){echo $dataSRTCOMLIST['ACQUISITION_DATE']->format('Y-m-d');}else{echo"";}?></td>
											</tr>
											<tr>
												<td class="bg-td"><b>Outstanding Amount</td></b>
												<td align="right"><?php echo $dataSRTCOMLIST['OUTSTANDING_AMOUNT_CURRENCY']." ".number_format($dataSRTCOMLIST['OUTSTANDING_AMOUNT_VALUE'],0,',','.');?></td>
												<td class="bg-td"><b>Principal Arrears</td></b>
												<td align="right"><?php echo $dataSRTCOMLIST['PRINCIPAL_ARREARS_CURRENCY']." ".number_format($dataSRTCOMLIST['PRINCIPAL_ARREARS_VALUE'],0,',','.');?></td>
											</tr>
											<tr>
												<td class="bg-td"><b>Currency of Contract</td></b>
												<td align="right"><?php echo $dataSRTCOMLIST['CURRENCY_CONTRACT'];?></td>
												<td class="bg-td"><b>No. of Days in Arrears</td></b>
												<td align="right"><?php echo $dataSRTCOMLIST['PASTDUEDAY'];?></td>
											</tr>
											<tr>
												<td class="bg-td"><b>Issuer Name</td></b>
												<td align="right"><?php echo $dataSRTCOMLIST['ISSUE_NAME'];?></td>
												<td class="bg-td"><b>Negative Status</td></b>
												<td align="right"><?php echo $dataSRTCOMLIST['NEGATIVE_STATUS'];?></td>
											</tr>
											<tr>
												<td class="bg-td"><b>Interest Rate</td></b>
												<td align="right"><?php echo $dataSRTCOMLIST['INTEREST_RATE'];?></td>
												<td class="bg-td"><b>Delinquency Date</td></b>
												<td align="right"><?php if($dataSRTCOMLIST['DELIQUENCY_DATE']<>NULL){echo $dataSRTCOMLIST['DELIQUENCY_DATE']->format('Y-m-d');}else{echo"";}?></td>
											</tr>
											<tr>
												<td class="bg-td"><b>Type of Interest Rate</td></b>
												<td align="right"><?php echo $dataSRTCOMLIST['TYPE_INTEREST_RATE'];?></td>
												<td class="bg-td"><b>Default Date</td></b>
												<td align="right"><?php echo $dataSRTCOMLIST['DEFAULT_DATE'];?></td>
											</tr>
											<tr>
												<td class="bg-td"><b>Market Listed</td></b>
												<td align="right"><?php echo $dataSRTCOMLIST['MARKET_LISTED'];?></td>
												<td class="bg-td"><b>Default Reason</td></b>
												<td align="right"><?php echo $dataSRTCOMLIST['DEFAULT_REASON'];?></td>
											</tr>
											<tr>
												<td class="bg-td"><b>Rating</td></b>
												<td align="right"><?php echo $dataSRTCOMLIST['RATING'];?></td>
												<td class="bg-td"><b>Default Description</td></b>
												<td align="right"><?php echo $dataSRTCOMLIST['DEFAULT_REASON_DESCRIPTION'];?></td>
											</tr>
											<tr>
												<td class="bg-td"><b>Sovereign Rate</td></b>
												<td align="right"><?php echo $dataSRTCOMLIST['SOVEREIGN_RATE'];?></td>
												<td class="bg-td"><b>Condition Date</td></b>
												<td align="right"><?php echo $dataSRTCOMLIST['CONDITION_DATE'];?></td>
											</tr>
											<tr>
												<td class="bg-td"><b>Maturity Date</td></b>
												<td align="right"><?php if($dataSRTCOMLIST['MATURITY_DATE']<>NULL){echo $dataSRTCOMLIST['MATURITY_DATE']->format('Y-m-d');}else{echo"";}?></td>
												<td class="bg-td"><b>Creditor</td></b>
												<td align="right"><?php echo $dataSRTCOMLIST['CREDITOR'];?></td>
											</tr>
											<tr>
												<td class="bg-td"><b>Last Update</td></b>
												<td align="right"><?php if($dataSRTCOMLIST['LAST_UPDATE']<>NULL){echo $dataSRTCOMLIST['LAST_UPDATE']->format('Y-m-d');}else{echo"";}?></td>
											</tr>
											<tr>
												<td class="bg-td"><b>Description</td></b>
												<td align="right"><?php echo $dataSRTCOMLIST['DESCRIPTION'];?></td>
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
</div>