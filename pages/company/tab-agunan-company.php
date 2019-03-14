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
<?php
/* select table COLLATERALS_SUMMARY_COMPANY */
$callCOLSUMCOM = "{call SP_GET_TAB_AGUNAN_TBL_COLLATERALS_SUMMARY_COMPANY(?)}";
$paramsCOLSUMCOM = array(array($id, SQLSRV_PARAM_IN));
$execCOLSUMCOM = sqlsrv_query( $conn, $callCOLSUMCOM, $paramsCOLSUMCOM) or die( print_r( sqlsrv_errors(), true));
$dataCOLSUMCOM = sqlsrv_fetch_array($execCOLSUMCOM);
?>
<div id="Agunan" class="tab-pane fade in active">
	<div class="card">
		<div class="header"><p class="name">AGUNAN</p></div>
			<div class="content">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-bordered" style="width:100%;">
								<thead>
									<tr>
										<td colspan="6" class="bg-td"><p><b>RINGKASAN AGUNAN</p></td></b>
									</tr>
								</thead>	
								<tbody>	
									<tr>
										<td class="bg-td" style="width:20%;"><b>Jumlah Agunan Tunai</td></b>
										<td colspan="2" style="width:20%;"><?php echo $dataCOLSUMCOM['NUMBER_OF_CASH_COLLATERALS'];?></td>
										<td class="bg-td" style="width:20%;"><b>Total Nilai Agunan Non Tunai</td></b>
										<td colspan="2" style="width:20%;"><?php echo $dataCOLSUMCOM['TOTAL_VALUE_OF_NON_CASH_COLLATERALS_CURRENCY']." ".number_format($dataCOLSUMCOM['TOTAL_VALUE_OF_NON_CASH_COLLATERALS_VALUE_VALUE'],0,',','.');?></td>
									</tr>
									<tr>
										<td class="bg-td" style="width:20%;"><b>Jumlah Agunan Non Tunai</td></b>
										<td colspan="2"><?php echo $dataCOLSUMCOM['NUMBER_OF_NON_CASH_COLLATERALS'];?></td>
									</tr>
								</tbody>	
							</table>
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
								/* select table COLLATERALS_LIST_COMPANY */
								$callCOLISTCOM = "{call SP_GET_TAB_AGUNAN_TBL_COLLATERALS_LIST_COMPANY(?)}";
								$paramsCOLISTCOM = array(array($id, SQLSRV_PARAM_IN));
								$execCOLISTCOM = sqlsrv_query( $conn, $callCOLISTCOM, $paramsCOLISTCOM) or die( print_r( sqlsrv_errors(), true));
								while($dataCOLISTCOM = sqlsrv_fetch_array($execCOLISTCOM)){
								?>
									<tr class="header expand">
										<td align="center"><?php echo $dataCOLISTCOM['TYPE'];?></td>
										<td align="center"><?php echo number_format($dataCOLISTCOM['TAX_VALUE_VALUE'],0,',','.');?></td>
										<td align="center"><?php echo round((float)$dataCOLISTCOM['PROPORTION']).'%';?></td>
										<td align="center"><?php echo $dataCOLISTCOM['LAST_UPDATE']-> format('Y-m-d');?><i class="fa fa-caret-square-o-down"></i></td>
									</tr>
									<tr>
										<td colspan="4">
											<table class="table table-bordered">
												<tr>
													<td class="bg-td"><b>Nilai Agunan</td></b>
													<td align="right"><?php echo number_format($dataCOLISTCOM['BANK_VALUE_VALUE'],0,',','.');?></td>
													<td class="bg-td"><b>Keterangan</td></b>
													<td align="right"><?php echo $dataCOLISTCOM['DESCRIPTION'];?></td>
												</tr>
												<tr>
													<td class="bg-td"><b>Nilai Penaksiran</td></b>
													<td align="right"><?php echo $dataCOLISTCOM['APPRAISALVALUE'];?></td>
													<td class="bg-td"><b>Nama Pemilik</td></b>
													<td align="right"><?php echo $dataCOLISTCOM['OWNER_NAME'];?></td>
												</tr>
												<tr>
													<td class="bg-td"><b>Tanggal Penilaian</td></b>
													<td align="right"><?php echo $dataCOLISTCOM['VALUATION_DATE']->format('Y-m-d');?></td>
													<td class="bg-td"><b>Bukti Kepemilikan</td></b>
													<td align="right"><?php echo $dataCOLISTCOM['OWNER_SHIP_PROOF'];?></td>
												</tr>
												<tr>
													<td class="bg-td"><b>Jenis Pengikatan</td></b>
													<td align="right"><?php echo $dataCOLISTCOM['SECURITY_ASSIGMENT_TYPE'];?></td>
													<td class="bg-td"><b>Kode Agunan</td></b>
													<td align="right"><?php echo $dataCOLISTCOM['COLLATERAL_CODE'];?></td>
												</tr>
												<tr>
													<td class="bg-td"><b>Asuransi</td></b>
													<td align="right"><?php echo $dataCOLISTCOM['INSURANCE'];?></td>
													<td class="bg-td"><b>Kreditur</td></b>
													<td align="right"><?php echo $dataCOLISTCOM['CREDITOR'];?></td>
												</tr>
												<tr>
													<td class="bg-td"><b>Address</td></b>
													<td colspan="3"></td>
												</tr>
											</table>
										</td>
									</tr>
									<?php
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
	</div>
</div>