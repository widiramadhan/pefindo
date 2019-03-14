<div class="card">
	<div class="header"><p class="name">Daftar Fasilitas</p></div>
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-bordered" style="width:100%;">
						<thead>
							<tr>
								<th class="bg-td">JENIS LEMBAGA</th>
								<th class="bg-td">JENIS FASILITAS</th>
								<th class="bg-td">TANGGAL PEMBUKAAN</th>
								<th class="bg-td">STATUS</th>
								<th class="bg-td">PLAFON</th>
								<th class="bg-td">BAKI DEBET</th>
								<th class="bg-td">JATUH TEMPO</th>
								<th class="bg-td">USIA TUNGGAKAN</th>
							</tr>
						</thead>						
						<tbody>
						<?php
							$totalPlafond = 0;
							$totalBakiDebet = 0;
							$totalJatuhTempo = 0;
							$totalUsiaTunggakan = 0;
							
							$callCONT = "{call SP_GET_TAB_CONTRACT_MAINDEBTOR(?)}";
							$optionsCONT =  array( "Scrollable" => "buffered" );
							$paramsCONT = array(array($id, SQLSRV_PARAM_IN));
							$execCONT = sqlsrv_query( $conn, $callCONT, $paramsCONT,$optionsCONT) or die( print_r( sqlsrv_errors(), true));
							while($dataCONT = sqlsrv_fetch_array($execCONT)){
								$totalPlafond =+ $totalPlafond + $dataCONT['TOTAL_AMOUNT_VALUE'];
								$totalBakiDebet =+ $totalBakiDebet + $dataCONT['OUTSTANDING_AMOUNT_VALUE'];
								$totalJatuhTempo =+ $totalJatuhTempo + $dataCONT['PASTDUE_AMOUNT_VALUE'];
								$totalUsiaTunggakan =+ $totalUsiaTunggakan + $dataCONT['PASTDUE_DAYS'];
						?>
							<tr>
								<td align="left"><?php echo $dataCONT['CREDITOR_TYPE'];?></td>
								<td align="left"><a href="#"><?php echo $dataCONT['CONTRACT_TYPE'];?></a></td>
								<td align="center"><?php echo $dataCONT['START_DATE']->format('Y-m-d');?></td>
								<td align="left"><?php echo $dataCONT['CONTRACT_STATUS'];?>
								<td align="right"><?php echo $dataCONT['TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONT['TOTAL_AMOUNT_VALUE'],0,',','.');?></td>
								<td align="right"><?php echo $dataCONT['OUTSTANDING_AMOUNT_CURRENCY']." ".number_format($dataCONT['OUTSTANDING_AMOUNT_VALUE'],0,',','.');?></td>
								<td align="right"><?php echo $dataCONT['PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONT['PASTDUE_AMOUNT_VALUE'],0,',','.');?></td>
								<td align="right"><?php echo $dataCONT['PASTDUE_DAYS'];?> Days</td>
							</tr>
							<?php
								}
							?>
							<tr>
								<td align="left" colspan="4"><b>Jumlah</b></td>
								<td align="right"><b>IDR <?php echo number_format($totalPlafond,0,',','.');?></b></td>
								<td align="right"><b>IDR <?php echo number_format($totalBakiDebet,0,',','.');?></b></td>
								<td align="right"><b>IDR <?php echo number_format($totalJatuhTempo,0,',','.');?></b></td>
								<td align="right"><b><?php echo $totalUsiaTunggakan;?> Days</b></td>
							</tr>
						</tbody>
					</table>
				</div>
				<br>
				<p class="name">Daftar Garansi atau Penjaminan yang Diberikan</p>
				<div class="table-responsive">
					<table class="table table-bordered" style="width:100%;">
						<thead>
							<tr>
								<th class="bg-td">JENIS LEMBAGA</th>
								<th class="bg-td">JENIS FASILITAS</th>
								<th class="bg-td">TANGGAL PEMBUKAAN</th>
								<th class="bg-td">STATUS</th>
								<th class="bg-td">PLAFON</th>
								<th class="bg-td">BAKI DEBET</th>
								<th class="bg-td">JATUH TEMPO</th>
								<th class="bg-td">USIA TUNGGAKAN</th>
							</tr>
						</thead>						
						<tbody>
						<?php
							$totalPlafond = 0;
							$totalBakiDebet = 0;
							$totalJatuhTempo = 0;
							$totalUsiaTunggakan = 0;
							
							$callCONT = "{call SP_GET_TAB_CONTRACT_GUARANTOR(?)}";
							$optionsCONT =  array( "Scrollable" => "buffered" );
							$paramsCONT = array(array($id, SQLSRV_PARAM_IN));
							$execCONT = sqlsrv_query( $conn, $callCONT, $paramsCONT,$optionsCONT) or die( print_r( sqlsrv_errors(), true));
							$numRowsCONT = sqlsrv_num_rows($execCONT);
							$checkCONT=sqlsrv_num_rows($execCONT);
							while($dataCONT = sqlsrv_fetch_array($execCONT)){
									$totalPlafond =+ $totalPlafond + $dataCONT['TOTAL_AMOUNT_VALUE'];
									$totalBakiDebet =+ $totalBakiDebet + $dataCONT['OUTSTANDING_AMOUNT_VALUE'];
									$totalJatuhTempo =+ $totalJatuhTempo + $dataCONT['PASTDUE_AMOUNT_VALUE'];
									$totalUsiaTunggakan =+ $totalUsiaTunggakan + $dataCONT['PASTDUE_DAYS'];
						?>
							<tr>
								<td align="left"><?php echo $dataCONT['CREDITOR_TYPE'];?></td>
								<td align="left"><a href="#"><?php echo $dataCONT['CONTRACT_TYPE'];?></a></td>
								<td align="center"><?php echo $dataCONT['START_DATE']->format('Y-m-d');?></td>
								<td align="left"><?php echo $dataCONT['CONTRACT_STATUS'];?>
								<td align="right"><?php echo $dataCONT['TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONT['TOTAL_AMOUNT_VALUE'],0,',','.');?></td>
								<td align="right"><?php echo $dataCONT['OUTSTANDING_AMOUNT_CURRENCY']." ".number_format($dataCONT['OUTSTANDING_AMOUNT_VALUE'],0,',','.');?></td>
								<td align="right"><?php echo $dataCONT['PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONT['PASTDUE_AMOUNT_VALUE'],0,',','.');?></td>
								<td align="right"><?php echo $dataCONT['PASTDUE_DAYS'];?> Days</td>
							</tr>
							<?php
								}
							?>
							<tr>
								<td align="left" colspan="4"><b>Jumlah</b></td>
								<td align="right"><b>IDR <?php echo number_format($totalPlafond,0,',','.');?></b></td>
								<td align="right"><b>IDR <?php echo number_format($totalBakiDebet,0,',','.');?></b></td>
								<td align="right"><b>IDR <?php echo number_format($totalJatuhTempo,0,',','.');?></b></td>
								<td align="right"><b><?php echo $totalUsiaTunggakan;?> Days</b></td>
							</tr>
						</tbody>
					</table>
				</div>
				<br>
				<?php
					/* select table COLLATERALS_SUMMARY_OVERALL */
					$callCONSUMOV = "{call SP_GET_TAB_CONTRACT_SUMMARY_OVERALL(?)}";
					$paramsCONSUMOV = array(array($id, SQLSRV_PARAM_IN));
					$execCONSUMOV = sqlsrv_query( $conn, $callCONSUMOV, $paramsCONSUMOV) or die( print_r( sqlsrv_errors(), true));
					$dataCONSUMOV = sqlsrv_fetch_array($execCONSUMOV);
					
					/* select table CONTRACT_SUMMARY_DEBTOR */
					$callCONSUMDEB = "{call SP_GET_TAB_CONTRACT_SUMMARY_DEBTOR(?)}";
					$paramsCONSUMDEB = array(array($id, SQLSRV_PARAM_IN));
					$execCONSUMDEB = sqlsrv_query( $conn, $callCONSUMDEB, $paramsCONSUMDEB) or die( print_r( sqlsrv_errors(), true));
					$dataCONSUMDEB = sqlsrv_fetch_array($execCONSUMDEB);
					
					/* select table CONTRACT_SUMMARY_GUARANTOR */
					$callCONSUMGUA = "{call SP_GET_TAB_CONTRACT_SUMMARY_GUARANTOR(?)}";
					$paramsCONSUMGUA = array(array($id, SQLSRV_PARAM_IN));
					$execCONSUMGUA = sqlsrv_query( $conn, $callCONSUMGUA, $paramsCONSUMGUA) or die( print_r( sqlsrv_errors(), true));
					$dataCONSUMGUA = sqlsrv_fetch_array($execCONSUMGUA);
				?>
				<p class="name">Ringkasan Fasilitas</p>
				<div class="table-responsive">
					<table class="table table-bordered" style="width:100%;">
						<tr>
							<td colspan="4" class="bg-td"><p class="name text-default">RINGKASAN DARI SEMUA FASILITAS</p></td>
						</tr>				
						<tr>
							<td class="bg-td" width="30%;"><b>Nominal Tunggakan Terbesar</b></td>
							<td width="20%;"><?php echo $dataCONSUMOV['WORS_PAST_DUE_AMOUNT_CURRENCY']." ".number_format($dataCONSUMOV['WORST_PAST_DUE_AMOUNT_VALUE_VALUE'],0,',','.');?></td>
							<td class="bg-td" width="30%;"><b>Tanggal Terakhir Tunggakan Lebih dari 90 Hari</b></td>
							<td width="20%;"><?php if($dataCONSUMOV['LAST_DELINQUENCY_90PLUS_DAYS'] <> NULL){echo $dataCONSUMOV['LAST_DELINQUENCY_90PLUS_DAYS'];}else{echo"";}?></td>
						</tr>					
						<tr>
							<td class="bg-td"><b>Usia Tunggakan Terlama (hari)</td></b>
							<td colspan="3"><?php echo $dataCONSUMOV['WORST_PAST_DUE_DAYS'];?></td>
						</tr>					
						<tr>
							<td colspan="4" class="bg-td"><p class="name text-default">SEBAGAI DEBITUR / DEBITUR BERSAMA - FASILITAS YANG MASIH BERJALAN</p></td>
						</tr>					
						<tr>
							<td class="bg-td"><b>Nilai Keseluruhan</td></b>
							<td align="right"><?php if(number_format($dataCONSUMDEB['TOTAL_AMOUNT_SUM_VALUE_VALUE'],0,',','.') <> NULL){echo $dataCONSUMDEB['TOTAL_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUMDEB['TOTAL_AMOUNT_SUM_VALUE_VALUE'],0,',','.');}else{echo"-";}?></td>
							<td class="bg-td"><b>Jumlah Fasilitas Aktif</td></b>
							<td align="right"><?php echo $dataCONSUMDEB['OPEN_CONTRACTS'];?></td>
						</tr>
						<tr>
							<td class="bg-td"><b>Nominal Tunggakan</td></b>
							<td align="right"><?php if(number_format($dataCONSUMDEB['PAST_DUE_AMOUNT_SUM_VALUE_VALUE'],0,',','.') <> NULL){echo $dataCONSUMDEB['PAST_DUE_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUMDEB['PAST_DUE_AMOUNT_SUM_VALUE_VALUE'],0,',','.');}else{echo"-";}?></td>
							<td class="bg-td"><b>Jumlah Fasilitas Non Aktif</td></b>
							<td align="right"><?php echo $dataCONSUMDEB['CLOSED_CONTRACTS'];?></td>
						</tr>								
						<tr>
							<td class="bg-td"><b>Baki Debet</td></b>
							<td align="right"><?php if(number_format($dataCONSUMDEB['OUT_STANDING_AMOUNT_SUM_VALUE_VALUE'],0,',','.') <> NULL){echo $dataCONSUMDEB['OUT_STANDING_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUMDEB['OUT_STANDING_AMOUNT_SUM_VALUE_VALUE'],0,',','.');}else{echo"-";}?></td>
							<td colspan="2"></td>
						</tr>				
						<tr>
							<td colspan="4" class="bg-td"><p class="name text-default">SEBAGAI PENJAMIN - FASILITAS YANG MASIH BERJALAN</p></td>
						</tr>					
						<tr>
							<td class="bg-td"><b>Nilai Keseluruhan</td></b>
							<td align="right"><?php if(number_format($dataCONSUMGUA['TOTAL_AMOUNT_SUM_VALUE'],0,',','.') <> NULL){echo $dataCONSUMGUA['TOTAL_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUMGUA['TOTAL_AMOUNT_SUM_VALUE'],0,',','.');}else{echo"-";}?></td>
							<td class="bg-td"><b>Jumlah Fasilitas Aktif</td></b>
							<td align="right"><?php echo $dataCONSUMGUA['OPEN_CONTRACT'];?></td>
						</tr>
						<tr>
							<td class="bg-td"><b>Nominal Tunggakan</td></b>
							<td align="right"><?php if(number_format($dataCONSUMGUA['PAST_DUE_AMOUNT_SUM_VALUE'],0,',','.') <> NULL){echo $dataCONSUMGUA['PAST_DUE_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUMGUA['PAST_DUE_AMOUNT_SUM_VALUE'],0,',','.');}else{echo"-";}?></td>
							<td class="bg-td"><b>Jumlah Fasilitas Non Aktif</td></b>
							<td align="right"><?php echo $dataCONSUMGUA['CLOSED_CONTRACT'];?></td>
						</tr>								
						<tr>
							<td class="bg-td"><b>Baki Debet</td></b>
							<td align="right"><?php if(number_format($dataCONSUMGUA['OUTSTANDING_AMOUNT_SUM_VALUE'],0,',','.') <> NULL){echo $dataCONSUMGUA['OUTSTANDING_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUMGUA['OUTSTANDING_AMOUNT_SUM_VALUE'],0,',','.');}else{echo"-";}?></td>
							<td colspan="2"></td>
						</tr>
					</table>
				</div>
				<br>
				<p class="name">Ringkasan Pembayaran</p>
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th width='20%'>BULAN / TAHUN</th>
								<?php
									/* select table CONTRACT_SUMMARY_PAYMENT_CALENDERLIST */
									$callCONSUMPACAL = "{call SP_GET_TAB_CONTRACT_SUMMARY_PAYMENT_CALENDERLIST(?)}";
									$paramsCONSUMPACAL = array(array($id, SQLSRV_PARAM_IN));
									$execCONSUMPACAL = sqlsrv_query( $conn, $callCONSUMPACAL, $paramsCONSUMPACAL) or die( print_r( sqlsrv_errors(), true));
									while($dataCONSUMPACAL = sqlsrv_fetch_array($execCONSUMPACAL)){
										echo "<th>".$dataCONSUMPACAL['DATE']->format('m/Y')."</th>";
									}
								?>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><b>Status Macet</b></td>
								<?php
								/* select table CONTRACT_SUMMARY_PAYMENT_CALENDERLIST */
								$callCalList2 = "{call SP_GET_TAB_CONTRACT_SUMMARY_PAYMENT_CALENDERLIST(?)}";
								$paramsCalList2 = array(array($id, SQLSRV_PARAM_IN));
								$execCalList2 = sqlsrv_query($conn, $callCalList2, $paramsCalList2) or die( print_r( sqlsrv_errors(), true));
								while($dataCalList2=sqlsrv_fetch_array($execCalList2)){
									$pastDueDay2 = $dataCalList2['PAST_DUE_DAYS'];
									if($pastDueDay2 >= 0 && $pastDueDay2 <= 30){
										echo'<td><center><div class="circle-green"><i class="fa fa-check"></i></div></center></td>';
									}else if($pastDueDay2 >= 31 && $pastDueDay2 <= 89){
										echo'<td><center><div class="circle-yellow"><i class="fa fa-check"></i></div></center></td>';
									}else if($pastDueDay2 >= 90 && $pastDueDay2 <= 100){
										echo'<td><center><div class="circle-red"><i class="fa fa-check"></i></div></center></td>';
									}else if($pastDueDay2 == 999){
										echo'<td><center><div class="circle-default">N/A</div></center></td>';
									}
								}
								?>
							</tr>
						</tbody>
					</table>
				</div>
				<div id="accordion22">
					<div class="card">
						<div class="header">
							<div class="pull-left">
								<?php
								$callCalList3 = "{call SP_GET_TAB_DASHBOARD_TBL_CONTRACT_SUMARY_PAYMENT_CALENDER_LIST(?)}";
								$paramsCalList3 = array(array($id, SQLSRV_PARAM_IN));
								$execCalList3 = sqlsrv_query($conn, $callCalList3, $paramsCalList3) or die( print_r( sqlsrv_errors(), true));
								$rowCalList = sqlsrv_fetch_array($execCalList3);
								?>
								<p class="name text-default">Pembayaran <?php if($rowCalList['START_DATE']<>NULL){echo $rowCalList['START_DATE']->format('m/Y');}else{echo"";}echo" - ";if($rowCalList['END_DATE']<>NULL){echo $rowCalList['END_DATE']->format('m/Y');}else{echo"";}?></p>
							</div>
							<div class="pull-right">
								<a class="card-link2" data-toggle="collapse" href="#collapseOne22">
									<i class="fa fa-chevron-down text-danger"></i>
								</a>
							</div>
							<div style="clear:both"></div>
						</div>
						<div id="collapseOne22" class="collapse content" data-parent="#accordion22">
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>PERIODE</th>
											<th>JUMLAH FASILITAS</th>
											<th>NOMINAL TUNGGAKAN</th>
											<th>UMUR TUNGGAKAN</th>
											<th>KOLEKTIBILITAS</th>
											<th>SALDO TERUTANG</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$callCalList4 = "{call SP_GET_TAB_DASHBOARD_TBL_CONTRACT_SUMARY_PAYMENT_CALENDER_LIST(?)}";
											$paramsCalList4 = array(array($id, SQLSRV_PARAM_IN));
											$execCalList4 = sqlsrv_query($conn, $callCalList4, $paramsCalList4) or die( print_r( sqlsrv_errors(), true));
											while($dataCalList4=sqlsrv_fetch_array($execCalList4)){
										?>
										<tr>
											<td align="center"><?php echo $dataCalList4['DATE']->format('m/Y');?></center></td>
											<td align="center"><?php echo $dataCalList4['CONTRACT_SUBMITTED'];?></center></td>
											<td align="right"><?php if($dataCalList4['PAST_DUE_DAYS'] == 999){ echo "No Data";}else{echo $dataCalList4['PAST_DUE_DAYS'];}?></td>
											<td align="right"><?php if($dataCalList4['PAST_DUE_AMOUNT_VALUE_VALUE'] == NULL){echo"No Data";}else{echo $dataCalList4['PAST_DUE_AMOUNT_CURRENCY']." ".number_format($dataCalList4['PAST_DUE_AMOUNT_VALUE_VALUE'],0,',','.');}?></td>
											<td align="center"><?php echo $dataCalList4['NEGATIVE_STATUS_OF_CONTRACT'];?></td>
											<td align="right"><?php if($dataCalList4['OUT_STANDING_AMOUNT_VALUE_VALUE'] == NULL){echo"No Data";}else{echo $dataCalList4['OUT_STANDING_AMOUNT_CURRENCY']." ".number_format($dataCalList4['OUT_STANDING_AMOUNT_VALUE_VALUE'],0,',','.');}?></td>
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
				<p class="name text-danger">Ringkasan fasilitas dan penjaminan Perbankan</p>	
				<?php
					/* select table M_CONTRACT_SUMMARY_SECTOR_INFO_LIST */
					$callCONSUSEC = "{call SP_GET_TAB_CONTRACT_SUMMARY_SECTOR_INFOLIST(?,?)}";
					$paramsCONSUSEC = array(array($id, SQLSRV_PARAM_IN),array("Banks", SQLSRV_PARAM_IN));
					$execCONSUSEC = sqlsrv_query( $conn, $callCONSUSEC, $paramsCONSUSEC) or die( print_r( sqlsrv_errors(), true));
					$dataCONSUSEC = sqlsrv_fetch_array($execCONSUSEC);
				?>
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<td colspan="4" class="bg-td"><p class="name text-default">SEBAGAI DEBITUR / DEBITUR BERSAMA - FASILITAS YANG MASIH BERJALAN</p></td>
							</tr>
						</thead>	
						<tbody>
							<tr>
								<td class="bg-td" width="30%"><b>Jumlah plafon keseluruhan</td></b>
								<td align="right" width="20%"><?php echo $dataCONSUSEC['DEBTOR_TOTAL_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUSEC['DEBTOR_TOTAL_AMOUNT_SUM_VALUE_VALUE'],0,',','.');?></td>
								<td class="bg-td" width="30%"><b>Jumlah Fasilitas Aktif</td></b>
								<td width="20%"align="right"><?php echo $dataCONSUSEC['DEBTOR_OPEN_CONTRACT'];?></td>
							</tr>
							<tr>	
								<td class="bg-td"><b>Nominal Tunggakan</td></b>
								<td align="right"><?php echo $dataCONSUSEC['DEBTOR_PAST_DUE_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUSEC['DEBTOR_PAST_DUE_AMOUNT_SUM_VALUE_VALUE'],0,',','.');?></td>
								<td class="bg-td"><b>Jumlah Fasilitas Non Aktif</td></b>
								<td align="right"><?php echo $dataCONSUSEC['DEBTOR_CLOSED_CONTRACT'];?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Total Jumlah Terutang</td></b>
								<td align="right"><?php echo $dataCONSUSEC['DEBTOR_OUTSTANDING_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUSEC['DEBTOR_OUTSTANDING_AMOUNT_SUM_VALUE_VALUE'],0,',','.');?></td>
								<td colspan="2"></td>
							</tr>
							<tr>
								<td colspan="4" class="bg-td"><p class="name text-default">SEBAGAI PENJAMIN - FASILITAS YANG MASIH BERJALAN</p></td>
							</tr>
							<tr>
								<td class="bg-td" width="30%"><b>Jumlah plafon keseluruhan</td></b>
								<td align="right" width="20%"><?php echo $dataCONSUSEC['GUARANTOR_TOTAL_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUSEC['GUARANTOR_TOTAL_AMOUNT_SUM_VALUE_VALUE'],0,',','.');?></td>
								<td class="bg-td" width="30%"><b>Jumlah Fasilitas Aktif</td></b>
								<td width="20%"align="right"><?php echo $dataCONSUSEC['GURANTOR_OPEN_CONTRACTS'];?></td>
							</tr>
							<tr>	
								<td class="bg-td"><b>Nominal Tunggakan</td></b>
								<td align="right"><?php echo $dataCONSUSEC['GUARANTOR_PAST_DUE_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUSEC['GUARANTOR_PAST_DUE_AMOUNT_SUM_VALUE_VALUE'],0,',','.');?></td>
								<td class="bg-td"><b>Jumlah Fasilitas Non Aktif</td></b>
								<td align="right"><?php echo $dataCONSUSEC['GUARANTOR_CLOSED_CONTRACTS'];?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Total Jumlah Terutang</td></b>
								<td align="right"><?php echo $dataCONSUSEC['GURANTOR_OUTSTANDING_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUSEC['GUARANTOR_OUTSTANDING_AMOUNT_SUM_VALUE_VALUE'],0,',','.');?></td>
								<td colspan="2"></td>
							</tr>
						</tbody>
					</table>
				</div>
				<p class="name text-danger">Ringkasan fasilitas dan penjaminan NonBankingFinancialInstitutions</p>	
				<?php
					/* select table M_CONTRACT_SUMMARY_SECTOR_INFO_LIST */
					$callCONSUSEC2 = "{call SP_GET_TAB_CONTRACT_SUMMARY_SECTOR_INFOLIST(?,?)}";
					$paramsCONSUSEC2 = array(array($id, SQLSRV_PARAM_IN),array("NonBankingFinancialInstitutions", SQLSRV_PARAM_IN));
					$execCONSUSEC2 = sqlsrv_query( $conn, $callCONSUSEC2, $paramsCONSUSEC2) or die( print_r( sqlsrv_errors(), true));
					$dataCONSUSEC2 = sqlsrv_fetch_array($execCONSUSEC2);
				?>
				<div class="table-responsive">	
					<table class="table table-bordered">
						<tr>
							<td class="bg-td" width="30%"><b>Jumlah plafon keseluruhan</td></b>
							<td align="right" width="20%"><?php echo $dataCONSUSEC2['DEBTOR_TOTAL_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUSEC2['DEBTOR_TOTAL_AMOUNT_SUM_VALUE_VALUE'],0,',','.');?></td>
							<td class="bg-td" width="30%"><b>Jumlah Fasilitas Aktif</td></b>
							<td width="20%"align="right"><?php echo $dataCONSUSEC2['DEBTOR_OPEN_CONTRACT'];?></td>
						</tr>
						<tr>	
							<td class="bg-td"><b>Nominal Tunggakan</td></b>
							<td align="right"><?php echo $dataCONSUSEC2['DEBTOR_PAST_DUE_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUSEC2['DEBTOR_PAST_DUE_AMOUNT_SUM_VALUE_VALUE'],0,',','.');?></td>
							<td class="bg-td"><b>Jumlah Fasilitas Non Aktif</td></b>
							<td align="right"><?php echo $dataCONSUSEC2['DEBTOR_CLOSED_CONTRACT'];?></td>
						</tr>
						<tr>
							<td class="bg-td"><b>Total Jumlah Terutang</td></b>
							<td align="right"><?php echo $dataCONSUSEC2['DEBTOR_OUTSTANDING_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUSEC2['DEBTOR_OUTSTANDING_AMOUNT_SUM_VALUE_VALUE'],0,',','.');?></td>
							<td colspan="2"></td>
						</tr>
						<tr>
							<td colspan="4" class="bg-td"><p class="name text-default">SEBAGAI PENJAMIN - FASILITAS YANG MASIH BERJALAN</p></td>
						</tr>
						<tr>
							<td class="bg-td" width="30%"><b>Jumlah plafon keseluruhan</td></b>
							<td align="right" width="20%"><?php echo $dataCONSUSEC2['GUARANTOR_TOTAL_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUSEC2['GUARANTOR_TOTAL_AMOUNT_SUM_VALUE_VALUE'],0,',','.');?></td>
							<td class="bg-td" width="30%"><b>Jumlah Fasilitas Aktif</td></b>
							<td width="20%"align="right"><?php echo $dataCONSUSEC2['GURANTOR_OPEN_CONTRACTS'];?></td>
						</tr>
						<tr>	
							<td class="bg-td"><b>Nominal Tunggakan</td></b>
							<td align="right"><?php echo $dataCONSUSEC2['GUARANTOR_PAST_DUE_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUSEC2['GUARANTOR_PAST_DUE_AMOUNT_SUM_VALUE_VALUE'],0,',','.');?></td>
							<td class="bg-td"><b>Jumlah Fasilitas Non Aktif</td></b>
							<td align="right"><?php echo $dataCONSUSEC2['GUARANTOR_CLOSED_CONTRACTS'];?></td>
						</tr>
						<tr>
							<td class="bg-td"><b>Total Jumlah Terutang</td></b>
							<td align="right"><?php echo $dataCONSUSEC2['GURANTOR_OUTSTANDING_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUSEC2['GUARANTOR_OUTSTANDING_AMOUNT_SUM_VALUE_VALUE'],0,',','.');?></td>
							<td colspan="2"></td>
						</tr>
					</table>
				</div>
				<p class="name text-danger">Ringkasan fasilitas dan penjaminan Pegadaian</p>	
				<?php
					/* select table M_CONTRACT_SUMMARY_SECTOR_INFO_LIST */
					$callCONSUSEC3 = "{call SP_GET_TAB_CONTRACT_SUMMARY_SECTOR_INFOLIST(?,?)}";
					$paramsCONSUSEC3 = array(array($id, SQLSRV_PARAM_IN),array("Pawnshop", SQLSRV_PARAM_IN));
					$execCONSUSEC3 = sqlsrv_query( $conn, $callCONSUSEC3, $paramsCONSUSEC3) or die( print_r( sqlsrv_errors(), true));
					$dataCONSUSEC3 = sqlsrv_fetch_array($execCONSUSEC3);
				?>
				<div class="table-responsive">	
					<table class="table table-bordered">
						<tr>
							<td colspan="4" class="bg-td"><p class="name text-default">SEBAGAI DEBITUR / DEBITUR BERSAMA - FASILITAS YANG MASIH BERJALAN</p></td>
						</tr>
						<tr>
							<td class="bg-td" width="30%"><b>Jumlah plafon keseluruhan</td></b>
							<td align="right" width="20%"><?php echo $dataCONSUSEC3['DEBTOR_TOTAL_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUSEC3['DEBTOR_TOTAL_AMOUNT_SUM_VALUE_VALUE'],0,',','.');?></td>
							<td class="bg-td" width="30%"><b>Jumlah Fasilitas Aktif</td></b>
							<td width="20%"align="right"><?php echo $dataCONSUSEC3['DEBTOR_OPEN_CONTRACT'];?></td>
						</tr>
						<tr>	
							<td class="bg-td"><b>Nominal Tunggakan</td></b>
							<td align="right"><?php echo $dataCONSUSEC3['DEBTOR_PAST_DUE_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUSEC3['DEBTOR_PAST_DUE_AMOUNT_SUM_VALUE_VALUE'],0,',','.');?></td>
							<td class="bg-td"><b>Jumlah Fasilitas Non Aktif</td></b>
							<td align="right"><?php echo $dataCONSUSEC3['DEBTOR_CLOSED_CONTRACT'];?></td>
						</tr>
						<tr>
							<td class="bg-td"><b>Total Jumlah Terutang</td></b>
							<td align="right"><?php echo $dataCONSUSEC3['DEBTOR_OUTSTANDING_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUSEC3['DEBTOR_OUTSTANDING_AMOUNT_SUM_VALUE_VALUE'],0,',','.');?></td>
							<td colspan="2"></td>
						</tr>
						<tr>
							<td colspan="4" class="bg-td"><p class="name text-default">SEBAGAI PENJAMIN - FASILITAS YANG MASIH BERJALAN</p></td>
						</tr>
						<tr>
							<td class="bg-td" width="30%"><b>Jumlah plafon keseluruhan</td></b>
							<td align="right" width="20%"><?php echo $dataCONSUSEC3['GUARANTOR_TOTAL_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUSEC3['GUARANTOR_TOTAL_AMOUNT_SUM_VALUE_VALUE'],0,',','.');?></td>
							<td class="bg-td" width="30%"><b>Jumlah Fasilitas Aktif</td></b>
							<td width="20%"align="right"><?php echo $dataCONSUSEC3['GURANTOR_OPEN_CONTRACTS'];?></td>
						</tr>
						<tr>	
							<td class="bg-td"><b>Nominal Tunggakan</td></b>
							<td align="right"><?php echo $dataCONSUSEC3['GUARANTOR_PAST_DUE_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUSEC3['GUARANTOR_PAST_DUE_AMOUNT_SUM_VALUE_VALUE'],0,',','.');?></td>
							<td class="bg-td"><b>Jumlah Fasilitas Non Aktif</td></b>
							<td align="right"><?php echo $dataCONSUSEC3['GUARANTOR_CLOSED_CONTRACTS'];?></td>
						</tr>
						<tr>
							<td class="bg-td"><b>Total Jumlah Terutang</td></b>
							<td align="right"><?php echo $dataCONSUSEC3['GURANTOR_OUTSTANDING_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUSEC3['GUARANTOR_OUTSTANDING_AMOUNT_SUM_VALUE_VALUE'],0,',','.');?></td>
							<td colspan="2"></td>
						</tr>
					</table>
				</div>
				<p class="name text-danger">Ringkasan fasilitas lainnya</p>	
				<?php
					/* select table M_CONTRACT_SUMMARY_SECTOR_INFO_LIST */
					$callCONSUSEC4 = "{call SP_GET_TAB_CONTRACT_SUMMARY_SECTOR_INFOLIST(?,?)}";
					$paramsCONSUSEC4 = array(array($id, SQLSRV_PARAM_IN),array("Other", SQLSRV_PARAM_IN));
					$execCONSUSEC4 = sqlsrv_query( $conn, $callCONSUSEC4, $paramsCONSUSEC4) or die( print_r( sqlsrv_errors(), true));
					$dataCONSUSEC4 = sqlsrv_fetch_array($execCONSUSEC4);
				?>
				<div class="table-responsive">	
					<table class="table table-bordered">
						<tr>
							<td colspan="4" class="bg-td"><p class="name text-default">SEBAGAI DEBITUR / DEBITUR BERSAMA - FASILITAS YANG MASIH BERJALAN</p></td>
						</tr>
						<tr>
							<td class="bg-td" width="30%"><b>Jumlah plafon keseluruhan</td></b>
							<td align="right" width="20%"><?php echo $dataCONSUSEC4['DEBTOR_TOTAL_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUSEC4['DEBTOR_TOTAL_AMOUNT_SUM_VALUE_VALUE'],0,',','.');?></td>
							<td class="bg-td" width="30%"><b>Jumlah Fasilitas Aktif</td></b>
							<td width="20%"align="right"><?php echo $dataCONSUSEC4['DEBTOR_OPEN_CONTRACT'];?></td>
						</tr>
						<tr>	
							<td class="bg-td"><b>Nominal Tunggakan</td></b>
							<td align="right"><?php echo $dataCONSUSEC4['DEBTOR_PAST_DUE_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUSEC4['DEBTOR_PAST_DUE_AMOUNT_SUM_VALUE_VALUE'],0,',','.');?></td>
							<td class="bg-td"><b>Jumlah Fasilitas Non Aktif</td></b>
							<td align="right"><?php echo $dataCONSUSEC4['DEBTOR_CLOSED_CONTRACT'];?></td>
						</tr>
						<tr>
							<td class="bg-td"><b>Total Jumlah Terutang</td></b>
							<td align="right"><?php echo $dataCONSUSEC4['DEBTOR_OUTSTANDING_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUSEC4['DEBTOR_OUTSTANDING_AMOUNT_SUM_VALUE_VALUE'],0,',','.');?></td>
							<td colspan="2"></td>
						</tr>
						<tr>
							<td colspan="4" class="bg-td"><p class="name text-default">SEBAGAI PENJAMIN - FASILITAS YANG MASIH BERJALAN</p></td>
						</tr>
						<tr>
							<td class="bg-td" width="30%"><b>Jumlah plafon keseluruhan</td></b>
							<td align="right" width="20%"><?php echo $dataCONSUSEC4['GUARANTOR_TOTAL_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUSEC4['GUARANTOR_TOTAL_AMOUNT_SUM_VALUE_VALUE'],0,',','.');?></td>
							<td class="bg-td" width="30%"><b>Jumlah Fasilitas Aktif</td></b>
							<td width="20%"align="right"><?php echo $dataCONSUSEC4['GURANTOR_OPEN_CONTRACTS'];?></td>
						</tr>
						<tr>	
							<td class="bg-td"><b>Nominal Tunggakan</td></b>
							<td align="right"><?php echo $dataCONSUSEC4['GUARANTOR_PAST_DUE_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUSEC4['GUARANTOR_PAST_DUE_AMOUNT_SUM_VALUE_VALUE'],0,',','.');?></td>
							<td class="bg-td"><b>Jumlah Fasilitas Non Aktif</td></b>
							<td align="right"><?php echo $dataCONSUSEC4['GUARANTOR_CLOSED_CONTRACTS'];?></td>
						</tr>
						<tr>
							<td class="bg-td"><b>Total Jumlah Terutang</td></b>
							<td align="right"><?php echo $dataCONSUSEC4['GURANTOR_OUTSTANDING_AMOUNT_SUM_CURRENCY']." ".number_format($dataCONSUSEC4['GUARANTOR_OUTSTANDING_AMOUNT_SUM_VALUE_VALUE'],0,',','.');?></td>
							<td colspan="2"></td>
						</tr>
					</table>
				</div>
				<!-- RINCIAN FASILITAS -->
				<br>
				<p class="name">Rincian Fasilitas</p>	
				<p class="name text-danger">Fasilitas Aktif</p>	
				<?php
					$no=100;
					$callCONSUSECX = "{call SP_GET_TAB_CONTRACT(?,?,?)}";
					$paramsCONSUSECX = array(array($id, SQLSRV_PARAM_IN),array("MainDebtor", SQLSRV_PARAM_IN),array("Open", SQLSRV_PARAM_IN));
					$options =  array( "Scrollable" => "buffered" );
					$execCONSUSECX = sqlsrv_query( $conn, $callCONSUSECX, $paramsCONSUSECX,$options) or die( print_r( sqlsrv_errors(), true));
					$nums = sqlsrv_num_rows($execCONSUSECX);
					if($nums == 0 ){
						echo"<div style='border:1px solid #EEE;padding:5px;'> Tidak ada fasilitas</div>";
					}else{
					while($dataCONSUSECX = sqlsrv_fetch_array($execCONSUSECX)){
						$no++;
				?>
				<div id="accordion<?php echo $no;?>">
					<div class="card">
						<div class="header">
							<div class="pull-left">
								<p class="name" style="font-size:14px;"><?php echo $dataCONSUSECX['CONTRACT_TYPE'];?></p>
							</div>
							<div class="pull-right">
								<a class="card-link2" data-toggle="collapse" href="#collapseOne<?php echo $no;?>">
									<i class="fa fa-chevron-down text-danger"></i>
								</a>
							</div>
							<div style="clear:both"></div>
						</div>
						<div id="collapseOne<?php echo $no;?>" class="collapse content" data-parent="#accordion<?php echo $no;?>">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>RINCIAN FASILITAS</b></p></td>
									</tr>
									<tr>
										<td width="30%" class="bg-td"><b>Peran Nasabah</b></td>
										<td width="20%"><?php echo $dataCONSUSECX['ROLE_OF_CLIENT'];?></td>
										<td width="30%" class="bg-td"><b>Fase Fasilitas</b></td>
										<td width="20%"><?php echo $dataCONSUSECX['PHASE_OF_CONTRACT'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Tipe Fasilitas</b></td>
										<td><?php echo $dataCONSUSECX['CONTRACT_TYPE'];?></td>
										<td class="bg-td"><b>Status Fasilitas</b></td>
										<td><?php echo $dataCONSUSECX['CONTRACT_STATUS'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Kolektibilitas</b></td>
										<td><?php echo $dataCONSUSECX['NEGATIVE_STATUS_OF_CONTRACT'];?></td>
										<td class="bg-td"><b>Tujuan Pendanaan</b></td>
										<td><?php echo $dataCONSUSECX['PURPOSE_OF_FINANCING'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Sektor Ekonomi</b></td>
										<td><?php echo $dataCONSUSECX['ECONOMIC_SECTOR'];?></td>
										<td class="bg-td"><b>Pinjaman sindikasi</b></td>
										<td><?php echo $dataCONSUSECX['SYNDICATED_LOAN'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Kode Kategori Debitur</b></td>
										<td><?php echo $dataCONSUSECX['CREDIT_CLASIFICATION'];?></td>
										<td class="bg-td"><b>Nama Tertanggung</b></td>
										<td><?php if($dataCONSUSECX['NAME_OF_INSURED']<>NULL){echo $dataCONSUSECX['NAME_OF_INSURED'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Mata Uang Fasilitas</b></td>
										<td><?php echo $dataCONSUSECX['CONTRACT_CURRENCY'];?></td>
										<td class="bg-td"><b>Kode Fasilitas</b></td>
										<td><?php echo $dataCONSUSECX['CONTRACT_CODE'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Pemberi Pinjaman</b></td>
										<td><?php echo $dataCONSUSECX['CREDITOR'];?></td>
										<td class="bg-td"><b>Jenis Pemberi Pinjaman</b></td>
										<td><?php echo $dataCONSUSECX['CREDITOR_TYPE'];?></td>
									</tr>
								</table>
							</div>
							<br>
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>TANGGAL FASILITAS</b></p></td>
									</tr>
									<tr>
										<td width="30%" class="bg-td"><b>Tanggal Pencairan</b></td>
										<td width="20%"><?php if($dataCONSUSECX['DISBURSEMENT_DATE']<>NULL){echo $dataCONSUSECX['DISBURSEMENT_DATE']->format('Y-m-d');}else{echo"-";}?></td>
										<td width="30%" class="bg-td"><b>Tanggal Restrukturisasi Akhir</b></td>
										<td width="20%"><?php if($dataCONSUSECX['RESTRUCTURING_DATE']<>NULL){echo $dataCONSUSECX['RESTRUCTURING_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Tanggal Mulai</b></td>
										<td><?php if($dataCONSUSECX['START_DATE']<>NULL){echo $dataCONSUSECX['START_DATE']->format('Y-m-d');}else{echo"-";}?></td>
										<td class="bg-td"><b>Tanggal Restrukturisasi Awal</b></td>
										<td><?php if($dataCONSUSECX['INITIAL_RESTRUCTURING_DATE']<>NULL){echo $dataCONSUSECX['INITIAL_RESTRUCTURING_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Pengkinian Terakhir</b></td>
										<td><?php if($dataCONSUSECX['LAST_UPDATE']<>NULL){echo $dataCONSUSECX['LAST_UPDATE']->format('Y-m-d');}else{echo"-";}?></td>
										<td class="bg-td"><b>Tanggal Jatuh Tempo</b></td>
										<td><?php if($dataCONSUSECX['MATURITY_DATE']<>NULL){echo $dataCONSUSECX['MATURITY_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Tanggal Kondisi</b></td>
										<td><?php if($dataCONSUSECX['CONDITION_DATE']<>NULL){echo $dataCONSUSECX['CONDITION_DATE']->format('Y-m-d');}else{echo"-";}?></td>
										<td class="bg-td"><b>Tanggal pelunasan</b></td>
										<td><?php if($dataCONSUSECX['REAL_END_DATE']<>NULL){echo $dataCONSUSECX['REAL_END_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>RINCIAN KONTRAK AWAL</b></p></td>
									</tr>
									<tr>
										<td width="30%" class="bg-td"><b>Jumlah Plafond</b></td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td"><b>Nomor Akad Awal</b></td>
										<td align="right"><?php if($dataCONSUSECX['INITIAL_AGREEMENT_NUMBER']<>NULL){echo $dataCONSUSECX['INITIAL_AGREEMENT_NUMBER'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Plafond Awal</b></td>
										<td align="right"><?php if($dataCONSUSECX['INITIAL_TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['INITIAL_TOTAL_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['INITIAL_TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['INITIAL_TOTAL_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td"><b>Tanggal Akad Awal</b></td>
										<td align="right"><?php if($dataCONSUSECX['INITIAL_AGREEMENT_DATE']<>NULL){echo $dataCONSUSECX['INITIAL_AGREEMENT_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Baki Debet</b></td>
										<td align="right"><?php if($dataCONSUSECX['TOTAL_TAKEN_AMOUNT_CURRENCY']<>NULL){echo $dataCONSUSECX['TOTAL_TAKEN_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_TAKEN_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
									</tr>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>INFORMASI FASILITAS TERKINI</b></p></td>
									</tr>
									<tr>
										<td width="30%" class="bg-td">Total Plafon Fasilitas</td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['TOTAL_FACILITY_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_FACILITY_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['TOTAL_FACILITY_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_FACILITY_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td width="30%" class="bg-td">Nomor Akad Terakhir</td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['LAST_AGREEMENT_NUMBER']<>NULL){echo $dataCONSUSECX['LAST_AGREEMENT_NUMBER'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Saldo Terutang</td>
										<td align="right"><?php if($dataCONSUSECX['OUTSTANDING_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['OUTSTANDING_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['OUTSTANDING_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['OUTSTANDING_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Tanggal Akad Terakhir</td>
										<td align="right"><?php if($dataCONSUSECX['LAST_AGREEMENT_DATE']<>NULL){echo $dataCONSUSECX['LAST_AGREEMENT_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Saldo Pokok</td>
										<td align="right"><?php if($dataCONSUSECX['PRINCIPAL_BALANCE_CURRENCY']." ".number_format($dataCONSUSECX['PRINCIPAL_BALANCE_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PRINCIPAL_BALANCE_CURRENCY']." ".number_format($dataCONSUSECX['PRINCIPAL_BALANCE_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Penggunaan Kredit Dalam 30 Hari Terakhir</td>
										<td align="right"><?php if($dataCONSUSECX['CREDIT_USAGE_LAST_30_DAYS']<>NULL){echo $dataCONSUSECX['CREDIT_USAGE_LAST_30_DAYS'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Denda</td>
										<td align="right"><?php if($dataCONSUSECX['PENALTY_CURRENCY']." ".number_format($dataCONSUSECX['PENALTY_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PENALTY_CURRENCY']." ".number_format($dataCONSUSECX['PENALTY_VALUE'],0,',','.');}else{echo"-";}?></td>
									</tr>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>STATUS TUNGGAKAN</b></p></td>
									</tr>
									<tr>
										<td width="30%" class="bg-td">Nominal Tunggakan</td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['PASTDUE_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['PASTDUE_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td width="30%" class="bg-td">Umur Tunggakan</td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['PASTDUE_DAYS']<>NUll){echo $dataCONSUSECX['PASTDUE_DAYS'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Bunga Jatuh Tempo</td>
										<td align="right"><?php if($dataCONSUSECX['PASTDUE_INTEREST_CURRENCY']." ".number_format($dataCONSUSECX['PASTDUE_INTEREST_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PASTDUE_INTEREST_CURRENCY']." ".number_format($dataCONSUSECX['PASTDUE_INTEREST_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Terjadinya tunggakan terakhir (lewat lebih dari 90 hari)</td>
										<td align="right"><?php if($dataCONSUSECX['LAST_DELINQUENCY_90_PLUS_DAYS']<>NULL){echo $dataCONSUSECX['LAST_DELINQUENCY_90_PLUS_DAYS'];}else {echo "-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Jumlah keterlambatan terbesar</td>
										<td align="right"><?php if($dataCONSUSECX['WORST_PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['WORST_PASTDUE_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['WORST_PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['WORST_PASTDUE_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Tanggal Macet</td>
										<td align="right"><?php if($dataCONSUSECX['DELINQUENCY_DATE']<>NULL){echo $dataCONSUSECX['DELINQUENCY_DATE']->format('Y-m-d');}else{echo"-";}?></td>
										
									</tr>
									<tr>
										<td class="bg-td">Tunggakan Pokok</td>
										<td align="right"><?php if($dataCONSUSECX['PRINCIPAL_AREAS_CURRENCY']." ".number_format($dataCONSUSECX['PRINCIPAL_AREAS_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PRINCIPAL_AREAS_CURRENCY']." ".number_format($dataCONSUSECX['PRINCIPAL_AREAS_VALUE'],0,',','.');}else{echo"-";}?></td>										
										<td class="bg-td">Tanggal Wanprestasi</td>
										<td align="right"><?php if($dataCONSUSECX['DEFAULT_DATE']<>NULL){echo $dataCONSUSECX['DEFAULT_DATE']->format('Y-m-d');}else{echo"-";}?></td>										
									</tr>
									<tr>
										<td class="bg-td">Frekuensi Tunggakan Pokok</td>
										<td align="right"><?php if($dataCONSUSECX['PRINCIPAL_ARREARS_FREQUENCY']<>NULL){echo $dataCONSUSECX['PRINCIPAL_ARREARS_FREQUENCY'];}else {echo "-";}?></td>
										<td class="bg-td">Sebab Macet</td>
										<td align="right"><?php if($dataCONSUSECX['DEFAULT_REASON']<>NULL){echo $dataCONSUSECX['DEFAULT_REASON'];}else {echo "-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Tunggakan Bunga</td>
										<td align="right"><?php if($dataCONSUSECX['INTEREST_ARREARS_CURRENCY']." ".number_format($dataCONSUSECX['INTEREST_ARREARS_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['INTEREST_ARREARS_CURRENCY']." ".number_format($dataCONSUSECX['INTEREST_ARREARS_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Keterangan Macet</td>
										<td align="right"><?php if($dataCONSUSECX['DEFAULT_REASON_DESCRIPTION']<>NULL){echo $dataCONSUSECX['DEFAULT_REASON_DESCRIPTION'];}else {echo "-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Frekuensi Tunggakan Bunga</td>
										<td align="right"><?php if($dataCONSUSECX['INTEREST_ARREARS_FREQUENCY']<>NULL){echo $dataCONSUSECX['INTEREST_ARREARS_FREQUENCY'];}else {echo "-";}?></td>
										<td class="bg-td">Keterlambatan Terlama (hari)</td>
										<td align="right"><?php if($dataCONSUSECX['WORST_PASTDUE_DAYS']<>NULL){echo $dataCONSUSECX['WORST_PASTDUE_DAYS'];}else {echo "-";}?></td>
									</tr>
								</table>
							</div>
							
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>DEBITUR YANG BERSANGKUTAN LAINNYA</b></p></td>
									</tr>
									<tr>
										<td width="20%" class="bg-td" > <b>NAMA</b> </td>
										<td width="20%" class="bg-td" > <b>PERAN</b> </td>
										<td width="40%" class="bg-td" > <b>JOINT ACCOUNT SEQUENCE</b> </td>
										<td width="20%" class="bg-td" > <b>KETERANGAN PENJAMIN<b> </td>
									</tr>
									<?php
										$callCORELSUB = "{call SP_GET_TAB_CONTRACT_RELATED_SUBJECT(?)}";
										$paramsCORELSUB = array(array($id, SQLSRV_PARAM_IN));
										$optionsCORELSUB =  array( "Scrollable" => "buffered" );
										$execCORELSUB = sqlsrv_query( $conn, $callCORELSUB, $paramsCORELSUB) or die( print_r( sqlsrv_errors(), true));
										$checkCORELSUB=sqlsrv_num_rows($execCORELSUB);
										while($dataCORELSUB = sqlsrv_fetch_array($execCORELSUB)){
									?>
									<tr>
										<td><?php if( $dataCORELSUB['NAME']<>NULL){echo $dataCORELSUB['NAME'];}else{echo "-";}?></td>
										<td><?php if( $dataCORELSUB['ROLE_OF_CLIENT']<>NULL){echo $dataCORELSUB['ROLE_OF_CLIENT'];}else{echo "-";}?></td>
										<td><?php if( $dataCORELSUB['JOINT_ACCOUNT_SEQUENCE']<>NULL){echo $dataCORELSUB['JOINT_ACCOUNT_SEQUENCE'];}else{echo "-";}?></td>
										<td><?php if( $dataCORELSUB['GUARANCY_DESCRIPTION']<>NULL){echo $dataCORELSUB['GUARANCY_DESCRIPTION'];}else{echo "-";}?></td>
									</tr>
									<?php }?>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>Pengaduan</b></p></td>
									</tr>
									<tr>
										<td width="30%" class="bg-td">Jumlah Pengaduan yang telah ditutup</td>
										<td width="20%" align="right"><?php echo $dataCONSUSECX['CLOSED_DISPUTES'];?></td>
										<td width="30%" class="bg-td">Jumlah Pengaduan yang tidak sah</td>
										<td width="20%" align="right"><?php echo $dataCONSUSECX['FALSE_DISPUTES'];?></td>
									</tr>									
								</table>
							</div>						
							
							<p class="name text-default">Ringkasan Kalender Pembayaran untuk Seluruh Fasilitas</p>
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th width='20%'>BULAN / TAHUN</th>
											<?php
												$callCalList = "{call SP_GET_TAB_DASHBOARD_TBL_CONTRACT_SUMARY_PAYMENT_CALENDER_LIST(?)}";
												$paramsCalList = array(array($id, SQLSRV_PARAM_IN));
												$execCalList = sqlsrv_query($conn, $callCalList, $paramsCalList) or die( print_r( sqlsrv_errors(), true));
												while($dataCalList=sqlsrv_fetch_array($execCalList)){
													echo "<th>".$dataCalList['DATE']->format('m/Y')."</th>";
												} 
											?>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><b>Status Macet</b></td>
											<?php
												$callCalList2 = "{call SP_GET_TAB_DASHBOARD_TBL_CONTRACT_SUMARY_PAYMENT_CALENDER_LIST(?)}";
												$paramsCalList2 = array(array($id, SQLSRV_PARAM_IN));
												$execCalList2 = sqlsrv_query($conn, $callCalList2, $paramsCalList2) or die( print_r( sqlsrv_errors(), true));
												while($dataCalList2=sqlsrv_fetch_array($execCalList2)){
													$pastDueDay2 = $dataCalList2['PAST_DUE_DAYS'];
													if($pastDueDay2 >= 0 && $pastDueDay2 <= 30){
														echo'<td><center><div class="circle-green"><i class="fa fa-check"></i></div></center></td>';
													}else if($pastDueDay2 >= 31 && $pastDueDay2 <= 89){
														echo'<td><center><div class="circle-yellow"><i class="fa fa-check"></i></div></center></td>';
													}else if($pastDueDay2 >= 90 && $pastDueDay2 <= 100){
														echo'<td><center><div class="circle-red"><i class="fa fa-check"></i></div></center></td>';
													}else if($pastDueDay2 == 999){
														echo'<td><center><div class="circle-default">N/A</div></center></td>';
													}
												}
											?>
										</tr>
									</tbody>
								</table>
							</div>
							<div id="accordion212">
								<div class="card">
									<div class="header">
										<div class="pull-left">
											<?php
											$callCalList3 = "{call SP_GET_TAB_DASHBOARD_TBL_CONTRACT_SUMARY_PAYMENT_CALENDER_LIST(?)}";
											$paramsCalList3 = array(array($id, SQLSRV_PARAM_IN));
											$execCalList3 = sqlsrv_query($conn, $callCalList3, $paramsCalList3) or die( print_r( sqlsrv_errors(), true));
											$rowCalList = sqlsrv_fetch_array($execCalList3);
											?>
											<p class="name text-default">Pembayaran <?php if($rowCalList['START_DATE']<>NULL){echo $rowCalList['START_DATE']->format('m/Y');}else{echo"";}echo" - ";if($rowCalList['END_DATE']<>NULL){echo $rowCalList['END_DATE']->format('m/Y');}else{echo"";}?></p>
										</div>
										<div class="pull-right">
											<a class="card-link2" data-toggle="collapse" href="#collapseOne212">
												<i class="fa fa-chevron-down text-danger"></i>
											</a>
										</div>
										<div style="clear:both"></div>
									</div>
									<div id="collapseOne212" class="collapse content" data-parent="#accordion212">
										<div class="table-responsive">
											<table class="table table-bordered">
												<thead>
													<tr>
														<th>PERIODE</th>
														<th>JUMLAH FASILITAS</th>
														<th>NOMINAL TUNGGAKAN</th>
														<th>UMUR TUNGGAKAN</th>
														<th>KOLEKTIBILITAS</th>
														<th>SALDO TERUTANG</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$callCalList4 = "{call SP_GET_TAB_DASHBOARD_TBL_CONTRACT_SUMARY_PAYMENT_CALENDER_LIST(?)}";
														$paramsCalList4 = array(array($id, SQLSRV_PARAM_IN));
														$execCalList4 = sqlsrv_query($conn, $callCalList4, $paramsCalList4) or die( print_r( sqlsrv_errors(), true));
														while($dataCalList4=sqlsrv_fetch_array($execCalList4)){
													?>
													<tr>
														<td align="center"><?php echo $dataCalList4['DATE']->format('m/Y');?></center></td>
														<td align="center"><?php echo $dataCalList4['CONTRACT_SUBMITTED'];?></center></td>
														<td align="right"><?php if($dataCalList4['PAST_DUE_DAYS'] == 999){ echo "No Data";}else{echo $dataCalList4['PAST_DUE_DAYS'];}?></td>
														<td align="right"><?php if($dataCalList4['PAST_DUE_AMOUNT_VALUE_VALUE'] == NULL){echo"No Data";}else{echo $dataCalList4['PAST_DUE_AMOUNT_CURRENCY']." ".number_format($dataCalList4['PAST_DUE_AMOUNT_VALUE_VALUE'],0,',','.');}?></td>
														<td align="center"><?php echo $dataCalList4['NEGATIVE_STATUS_OF_CONTRACT'];?></td>
														<td align="right"><?php if($dataCalList4['OUT_STANDING_AMOUNT_VALUE_VALUE'] == NULL){echo"No Data";}else{echo $dataCalList4['OUT_STANDING_AMOUNT_CURRENCY']." ".number_format($dataCalList4['OUT_STANDING_AMOUNT_VALUE_VALUE'],0,',','.');}?></td>
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
				</div>
				<?php
					}
					}
				?>
				<!-- FASILITAS NON-AKTIF-->
				<p class="name text-danger">Fasilitas Non-Aktif</p>	
				<?php
					$no=200;
					$callCONSUSECX = "{call SP_GET_TAB_CONTRACT(?,?,?)}";
					$paramsCONSUSECX = array(array($id, SQLSRV_PARAM_IN),array("MainDebtor", SQLSRV_PARAM_IN),array("Closed", SQLSRV_PARAM_IN));
					$options =  array( "Scrollable" => "buffered" );
					$execCONSUSECX = sqlsrv_query( $conn, $callCONSUSECX, $paramsCONSUSECX,$options) or die( print_r( sqlsrv_errors(), true));
					$nums = sqlsrv_num_rows($execCONSUSECX);
					if($nums == 0 ){
						echo"<div style='border:1px solid #EEE;padding:5px;'> Tidak ada fasilitas</div>";
					}else{
					while($dataCONSUSECX = sqlsrv_fetch_array($execCONSUSECX)){
						$no++;
				?>
				<div id="accordion<?php echo $no;?>">
					<div class="card">
						<div class="header">
							<div class="pull-left">
								<p class="name" style="font-size:14px;"><?php echo $dataCONSUSECX['CONTRACT_TYPE'];?></p>
							</div>
							<div class="pull-right">
								<a class="card-link2" data-toggle="collapse" href="#collapseOne<?php echo $no;?>">
									<i class="fa fa-chevron-down text-danger"></i>
								</a>
							</div>
							<div style="clear:both"></div>
						</div>
						<div id="collapseOne<?php echo $no;?>" class="collapse content" data-parent="#accordion<?php echo $no;?>">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>RINCIAN FASILITAS</b></p></td>
									</tr>
									<tr>
										<td width="30%" class="bg-td"><b>Peran Nasabah</b></td>
										<td width="20%"><?php echo $dataCONSUSECX['ROLE_OF_CLIENT'];?></td>
										<td width="30%" class="bg-td"><b>Fase Fasilitas</b></td>
										<td width="20%"><?php echo $dataCONSUSECX['PHASE_OF_CONTRACT'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Tipe Fasilitas</b></td>
										<td><?php echo $dataCONSUSECX['CONTRACT_TYPE'];?></td>
										<td class="bg-td"><b>Status Fasilitas</b></td>
										<td><?php echo $dataCONSUSECX['CONTRACT_STATUS'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Tujuan Pendanaan</b></td>
										<td><?php echo $dataCONSUSECX['PURPOSE_OF_FINANCING'];?></td>
										<td class="bg-td"><b>Kolektibilitas</b></td>
										<td><?php echo $dataCONSUSECX['NEGATIVE_STATUS_OF_CONTRACT'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Sektor Ekonomi</b></td>
										<td><?php echo $dataCONSUSECX['ECONOMIC_SECTOR'];?></td>
										<td class="bg-td"><b>Pinjaman sindikasi</b></td>
										<td><?php echo $dataCONSUSECX['SYNDICATED_LOAN'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Klasifikasi Kredit</b></td>
										<td><?php echo $dataCONSUSECX['CREDIT_CLASIFICATION'];?></td>
										<td class="bg-td"><b>Nama Tertanggung</b></td>
										<td><?php if($dataCONSUSECX['NAME_OF_INSURED']<>NULL){echo $dataCONSUSECX['NAME_OF_INSURED'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Mata Uang Fasilitas</b></td>
										<td><?php echo $dataCONSUSECX['CONTRACT_CURRENCY'];?></td>
										<td class="bg-td"><b>Jenis Pemberi Pinjaman</b></td>
										<td><?php echo $dataCONSUSECX['CREDITOR_TYPE'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Kode Fasilitas</b></td>
										<td><?php echo $dataCONSUSECX['CONTRACT_CODE'];?></td>
										<td class="bg-td"><b>Pemberi Pinjaman</b></td>
										<td><?php echo $dataCONSUSECX['CREDITOR'];?></td>
									</tr>
								</table>
							</div>
							<br>
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>TANGGAL FASILITAS</b></p></td>
									</tr>
									<tr>
										<td width="30%" class="bg-td"><b>Tanggal Pencairan</b></td>
										<td width="20%"><?php if($dataCONSUSECX['DISBURSEMENT_DATE']<>NULL){echo $dataCONSUSECX['DISBURSEMENT_DATE']->format('Y-m-d');}else{echo"-";}?></td>
										<td width="30%" class="bg-td"><b>Tanggal Restrukturisasi Akhir</b></td>
										<td width="20%"><?php if($dataCONSUSECX['RESTRUCTURING_DATE']<>NULL){echo $dataCONSUSECX['RESTRUCTURING_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Tanggal Mulai</b></td>
										<td><?php if($dataCONSUSECX['START_DATE']<>NULL){echo $dataCONSUSECX['START_DATE']->format('Y-m-d');}else{echo"-";}?></td>
										<td class="bg-td"><b>Tanggal Jatuh Tempo</b></td>
										<td><?php if($dataCONSUSECX['MATURITY_DATE']<>NULL){echo $dataCONSUSECX['MATURITY_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Pengkinian Terakhir</b></td>
										<td><?php if($dataCONSUSECX['LAST_UPDATE']<>NULL){echo $dataCONSUSECX['LAST_UPDATE']->format('Y-m-d');}else{echo"-";}?></td>
										<td class="bg-td"><b>Tanggal pelunasan</b></td>
										<td><?php if($dataCONSUSECX['REAL_END_DATE']<>NULL){echo $dataCONSUSECX['REAL_END_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Tanggal Kondisi</b></td>
										<td><?php if($dataCONSUSECX['CONDITION_DATE']<>NULL){echo $dataCONSUSECX['CONDITION_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>RINCIAN KONTRAK AWAL</b></p></td>
									</tr>
									<tr>
										<td width="30%" class="bg-td"><b>Jumlah Plafond</b></td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Plafond Awal</b></td>
										<td align="right"><?php if($dataCONSUSECX['INITIAL_TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['INITIAL_TOTAL_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['INITIAL_TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['INITIAL_TOTAL_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td"><b>Nomor Akad Awal</b></td>
										<td align="right"><?php if($dataCONSUSECX['INITIAL_AGREEMENT_NUMBER']<>NULL){echo $dataCONSUSECX['INITIAL_AGREEMENT_NUMBER'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Baki Debet</b></td>
										<td align="right"><?php if($dataCONSUSECX['TOTAL_TAKEN_AMOUNT_CURRENCY']<>NULL){echo $dataCONSUSECX['TOTAL_TAKEN_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_TAKEN_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td"><b>Tanggal Akad Awal</b></td>
										<td align="right"><?php $dataCONSUSECX['INITIAL_AGREEMENT_DATE'];?></td>
									</tr>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>INFORMASI FASILITAS TERKINI</b></p></td>
									</tr>
									<tr>
										<td width="30%" class="bg-td">Total Plafon Fasilitas</td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['TOTAL_FACILITY_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_FACILITY_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['TOTAL_FACILITY_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_FACILITY_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td width="30%" class="bg-td">Nomor Akad Terakhir</td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['LAST_AGREEMENT_NUMBER']<>NULL){echo $dataCONSUSECX['LAST_AGREEMENT_NUMBER'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Saldo Terutang</td>
										<td align="right"><?php if($dataCONSUSECX['OUTSTANDING_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['OUTSTANDING_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['OUTSTANDING_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['OUTSTANDING_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Tanggal Akad Terakhir</td>
										<td align="right"><?php if($dataCONSUSECX['LAST_AGREEMENT_DATE']<>NULL){echo $dataCONSUSECX['LAST_AGREEMENT_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Saldo Pokok</td>
										<td align="right"><?php if($dataCONSUSECX['PRINCIPAL_BALANCE_CURRENCY']." ".number_format($dataCONSUSECX['PRINCIPAL_BALANCE_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PRINCIPAL_BALANCE_CURRENCY']." ".number_format($dataCONSUSECX['PRINCIPAL_BALANCE_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Penggunaan Kredit Dalam 30 Hari Terakhir</td>
										<td align="right"><?php if($dataCONSUSECX['CREDIT_USAGE_LAST_30_DAYS']<>NULL){echo $dataCONSUSECX['CREDIT_USAGE_LAST_30_DAYS'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Denda</td>
										<td align="right"><?php if($dataCONSUSECX['PENALTY_CURRENCY']." ".number_format($dataCONSUSECX['PENALTY_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PENALTY_CURRENCY']." ".number_format($dataCONSUSECX['PENALTY_VALUE'],0,',','.');}else{echo"-";}?></td>
									</tr>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>STATUS TUNGGAKAN</b></p></td>
									</tr>
									<tr>
										<td width="30%" class="bg-td">Nominal Tunggakan</td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['PASTDUE_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['PASTDUE_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td width="30%" class="bg-td">Umur Tunggakan</td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['PASTDUE_DAYS']<>NUll){echo $dataCONSUSECX['PASTDUE_DAYS'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Bunga Jatuh Tempo</td>
										<td align="right"><?php if($dataCONSUSECX['PASTDUE_INTEREST_CURRENCY']." ".number_format($dataCONSUSECX['PASTDUE_INTEREST_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PASTDUE_INTEREST_CURRENCY']." ".number_format($dataCONSUSECX['PASTDUE_INTEREST_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Terjadinya tunggakan terakhir (lewat lebih dari 90 hari)</td>
										<td align="right"><?php if($dataCONSUSECX['LAST_DELINQUENCY_90_PLUS_DAYS']<>NULL){echo $dataCONSUSECX['LAST_DELINQUENCY_90_PLUS_DAYS'];}else {echo "-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Jumlah keterlambatan terbesar</td>
										<td align="right"><?php if($dataCONSUSECX['WORST_PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['WORST_PASTDUE_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['WORST_PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['WORST_PASTDUE_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Tanggal Macet</td>
										<td align="right"><?php if($dataCONSUSECX['DELINQUENCY_DATE']<>NULL){echo $dataCONSUSECX['DELINQUENCY_DATE']->format('Y-m-d');}else{echo"-";}?></td>
										
									</tr>
									<tr>
										<td class="bg-td">Tunggakan Pokok</td>
										<td align="right"><?php if($dataCONSUSECX['PRINCIPAL_AREAS_CURRENCY']." ".number_format($dataCONSUSECX['PRINCIPAL_AREAS_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PRINCIPAL_AREAS_CURRENCY']." ".number_format($dataCONSUSECX['PRINCIPAL_AREAS_VALUE'],0,',','.');}else{echo"-";}?></td>										
										<td class="bg-td">Tanggal Wanprestasi</td>
										<td align="right"><?php if($dataCONSUSECX['DEFAULT_DATE']<>NULL){echo $dataCONSUSECX['DEFAULT_DATE']->format('Y-m-d');}else{echo"-";}?></td>										
									</tr>
									<tr>
										<td class="bg-td">Frekuensi Tunggakan Pokok</td>
										<td align="right"><?php if($dataCONSUSECX['PRINCIPAL_ARREARS_FREQUENCY']<>NULL){echo $dataCONSUSECX['PRINCIPAL_ARREARS_FREQUENCY'];}else {echo "-";}?></td>
										<td class="bg-td">Sebab Macet</td>
										<td align="right"><?php if($dataCONSUSECX['DEFAULT_REASON']<>NULL){echo $dataCONSUSECX['DEFAULT_REASON'];}else {echo "-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Tunggakan Bunga</td>
										<td align="right"><?php if($dataCONSUSECX['INTEREST_ARREARS_CURRENCY']." ".number_format($dataCONSUSECX['INTEREST_ARREARS_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['INTEREST_ARREARS_CURRENCY']." ".number_format($dataCONSUSECX['INTEREST_ARREARS_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Keterangan Macet</td>
										<td align="right"><?php if($dataCONSUSECX['DEFAULT_REASON_DESCRIPTION']<>NULL){echo $dataCONSUSECX['DEFAULT_REASON_DESCRIPTION'];}else {echo "-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Frekuensi Tunggakan Bunga</td>
										<td align="right"><?php if($dataCONSUSECX['INTEREST_ARREARS_FREQUENCY']<>NULL){echo $dataCONSUSECX['INTEREST_ARREARS_FREQUENCY'];}else {echo "-";}?></td>
										<td class="bg-td">Keterlambatan Terlama (hari)</td>
										<td align="right"><?php if($dataCONSUSECX['WORST_PASTDUE_DAYS']<>NULL){echo $dataCONSUSECX['WORST_PASTDUE_DAYS'];}else {echo "-";}?></td>
									</tr>
								</table>
							</div>
							
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>DEBITUR YANG BERSANGKUTAN LAINNYA</b></p></td>
									</tr>
									<tr>
										<td width="20%" class="bg-td" > <b>NAMA</b> </td>
										<td width="20%" class="bg-td" > <b>PERAN</b> </td>
										<td width="40%" class="bg-td" > <b>JOINT ACCOUNT SEQUENCE</b> </td>
										<td width="20%" class="bg-td" > <b>KETERANGAN PENJAMIN<b> </td>
									</tr>
									<?php
										$callCORELSUB = "{call SP_GET_TAB_CONTRACT_RELATED_SUBJECT(?)}";
										$paramsCORELSUB = array(array($id, SQLSRV_PARAM_IN));
										$optionsCORELSUB =  array( "Scrollable" => "buffered" );
										$execCORELSUB = sqlsrv_query( $conn, $callCORELSUB, $paramsCORELSUB) or die( print_r( sqlsrv_errors(), true));
										$checkCORELSUB=sqlsrv_num_rows($execCORELSUB);
										while($dataCORELSUB = sqlsrv_fetch_array($execCORELSUB)){
										
									?>
									<tr>
										<td><?php if( $dataCORELSUB['NAME']<>NULL){echo $dataCORELSUB['NAME'];}else{echo "-";}?></td>
										<td><?php if( $dataCORELSUB['ROLE_OF_CLIENT']<>NULL){echo $dataCORELSUB['ROLE_OF_CLIENT'];}else{echo "-";}?></td>
										<td><?php if( $dataCORELSUB['JOINT_ACCOUNT_SEQUENCE']<>NULL){echo $dataCORELSUB['JOINT_ACCOUNT_SEQUENCE'];}else{echo "-";}?></td>
										<td><?php if( $dataCORELSUB['GUARANCY_DESCRIPTION']<>NULL){echo $dataCORELSUB['GUARANCY_DESCRIPTION'];}else{echo "-";}?></td>
									</tr>
									<?php }?>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>Pengaduan</b></p></td>
									</tr>
									<tr>
										<td width="30%" class="bg-td">Jumlah Pengaduan yang telah ditutup</td>
										<td width="20%" align="right"><?php echo $dataCONSUSECX['CLOSED_DISPUTES'];?></td>
										<td width="30%" class="bg-td">Jumlah Pengaduan yang tidak sah</td>
										<td width="20%" align="right"><?php echo $dataCONSUSECX['FALSE_DISPUTES'];?></td>
									</tr>									
								</table>
							</div>
							<p class="name text-default">Ringkasan Kalender Pembayaran untuk Seluruh Fasilitas</p>
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th width='20%'>BULAN / TAHUN</th>
											<?php
												$callCalList = "{call SP_GET_TAB_DASHBOARD_TBL_CONTRACT_SUMARY_PAYMENT_CALENDER_LIST(?)}";
												$paramsCalList = array(array($id, SQLSRV_PARAM_IN));
												$execCalList = sqlsrv_query($conn, $callCalList, $paramsCalList) or die( print_r( sqlsrv_errors(), true));
												while($dataCalList=sqlsrv_fetch_array($execCalList)){
													echo "<th>".$dataCalList['DATE']->format('m/Y')."</th>";
												} 
											?>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><b>Status Macet</b></td>
											<?php
												$callCalList2 = "{call SP_GET_TAB_DASHBOARD_TBL_CONTRACT_SUMARY_PAYMENT_CALENDER_LIST(?)}";
												$paramsCalList2 = array(array($id, SQLSRV_PARAM_IN));
												$execCalList2 = sqlsrv_query($conn, $callCalList2, $paramsCalList2) or die( print_r( sqlsrv_errors(), true));
												while($dataCalList2=sqlsrv_fetch_array($execCalList2)){
													$pastDueDay2 = $dataCalList2['PAST_DUE_DAYS'];
													if($pastDueDay2 >= 0 && $pastDueDay2 <= 30){
														echo'<td><center><div class="circle-green"><i class="fa fa-check"></i></div></center></td>';
													}else if($pastDueDay2 >= 31 && $pastDueDay2 <= 89){
														echo'<td><center><div class="circle-yellow"><i class="fa fa-check"></i></div></center></td>';
													}else if($pastDueDay2 >= 90 && $pastDueDay2 <= 100){
														echo'<td><center><div class="circle-red"><i class="fa fa-check"></i></div></center></td>';
													}else if($pastDueDay2 == 999){
														echo'<td><center><div class="circle-default">N/A</div></center></td>';
													}
												}
											?>
										</tr>
									</tbody>
								</table>
							</div>
						<div id="accordion213">
							<div class="card">
								<div class="header">
									<div class="pull-left">
										<?php
										$callCalList3 = "{call SP_GET_TAB_DASHBOARD_TBL_CONTRACT_SUMARY_PAYMENT_CALENDER_LIST(?)}";
										$paramsCalList3 = array(array($id, SQLSRV_PARAM_IN));
										$execCalList3 = sqlsrv_query($conn, $callCalList3, $paramsCalList3) or die( print_r( sqlsrv_errors(), true));
										$rowCalList = sqlsrv_fetch_array($execCalList3);
										?>
										<p class="name text-default">Pembayaran <?php if($rowCalList['START_DATE']<>NULL){echo $rowCalList['START_DATE']->format('m/Y');}else{echo"";}echo" - ";if($rowCalList['END_DATE']<>NULL){echo $rowCalList['END_DATE']->format('m/Y');}else{echo"";}?></p>
									</div>
									<div class="pull-right">
										<a class="card-link2" data-toggle="collapse" href="#collapseOne213">
											<i class="fa fa-chevron-down text-danger"></i>
										</a>
									</div>
									<div style="clear:both"></div>
								</div>
								<div id="collapseOne213" class="collapse content" data-parent="#accordion213">
									<div class="table-responsive">
										<table class="table table-bordered">
											<thead>
												<tr>
													<th>PERIODE</th>
													<th>JUMLAH FASILITAS</th>
													<th>NOMINAL TUNGGAKAN</th>
													<th>UMUR TUNGGAKAN</th>
													<th>KOLEKTIBILITAS</th>
													<th>SALDO TERUTANG</th>
												</tr>
											</thead>
											<tbody>
											<?php
												$callCalList4 = "{call SP_GET_TAB_DASHBOARD_TBL_CONTRACT_SUMARY_PAYMENT_CALENDER_LIST(?)}";
												$paramsCalList4 = array(array($id, SQLSRV_PARAM_IN));
												$execCalList4 = sqlsrv_query($conn, $callCalList4, $paramsCalList4) or die( print_r( sqlsrv_errors(), true));
												while($dataCalList4=sqlsrv_fetch_array($execCalList4)){
											?>
											<tr>
												<td align="center"><?php echo $dataCalList4['DATE']->format('m/Y');?></center></td>
												<td align="center"><?php echo $dataCalList4['CONTRACT_SUBMITTED'];?></center></td>
												<td align="right"><?php if($dataCalList4['PAST_DUE_DAYS'] == 999){ echo "No Data";}else{echo $dataCalList4['PAST_DUE_DAYS'];}?></td>
												<td align="right"><?php if($dataCalList4['PAST_DUE_AMOUNT_VALUE_VALUE'] == NULL){echo"No Data";}else{echo $dataCalList4['PAST_DUE_AMOUNT_CURRENCY']." ".number_format($dataCalList4['PAST_DUE_AMOUNT_VALUE_VALUE'],0,',','.');}?></td>
												<td align="center"><?php echo $dataCalList4['NEGATIVE_STATUS_OF_CONTRACT'];?></td>
												<td align="right"><?php if($dataCalList4['OUT_STANDING_AMOUNT_VALUE_VALUE'] == NULL){echo"No Data";}else{echo $dataCalList4['OUT_STANDING_AMOUNT_CURRENCY']." ".number_format($dataCalList4['OUT_STANDING_AMOUNT_VALUE_VALUE'],0,',','.');}?></td>
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
			</div>
			<?php
				}	}
			?>
				
				<!-- PENJAMIN AKTIF-->
				<p class="name text-danger">Penjamin Aktif</p>	
				<?php
					$no=300;
					$callCONSUSECX = "{call SP_GET_TAB_CONTRACT(?,?,?)}";
					$paramsCONSUSECX = array(array($id, SQLSRV_PARAM_IN),array("Guarantor", SQLSRV_PARAM_IN),array("Open", SQLSRV_PARAM_IN));
					$options =  array( "Scrollable" => "buffered" );
					$execCONSUSECX = sqlsrv_query( $conn, $callCONSUSECX, $paramsCONSUSECX,$options) or die( print_r( sqlsrv_errors(), true));
					$nums = sqlsrv_num_rows($execCONSUSECX);
					if($nums == 0 ){
						echo"<div style='border:1px solid #EEE;padding:5px;'> Tidak ada fasilitas</div>";
					}else{
					while($dataCONSUSECX = sqlsrv_fetch_array($execCONSUSECX)){
						$no++;

				?>
				
				<div id="accordion<?php echo $no;?>">
					<div class="card">
						<div class="header">
							<div class="pull-left">
								<p class="name" style="font-size:14px;"><?php echo $dataCONSUSECX['CONTRACT_TYPE'];?></p>
							</div>
							<div class="pull-right">
								<a class="card-link2" data-toggle="collapse" href="#collapseOne<?php echo $no;?>">
									<i class="fa fa-chevron-down text-danger"></i>
								</a>
							</div>
							<div style="clear:both"></div>
						</div>
						<div id="collapseOne<?php echo $no;?>" class="collapse content" data-parent="#accordion<?php echo $no;?>">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>RINCIAN FASILITAS</b></p></td>
									</tr>
									<tr>
										<td width="30%" class="bg-td"><b>Peran Nasabah</b></td>
										<td width="20%"><?php echo $dataCONSUSECX['ROLE_OF_CLIENT'];?></td>
										<td width="30%" class="bg-td"><b>Fase Fasilitas</b></td>
										<td width="20%"><?php echo $dataCONSUSECX['PHASE_OF_CONTRACT'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Tipe Fasilitas</b></td>
										<td><?php echo $dataCONSUSECX['CONTRACT_TYPE'];?></td>
										<td class="bg-td"><b>Status Fasilitas</b></td>
										<td><?php echo $dataCONSUSECX['CONTRACT_STATUS'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Sifat Kredit</b></td>
										<td><?php echo $dataCONSUSECX['CREDIT_CHARACTERISTIC'];?></td>
										<td class="bg-td"><b>Kolektibilitas</b></td>
										<td><?php echo $dataCONSUSECX['NEGATIVE_STATUS_OF_CONTRACT'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Tujuan Pendanaan</b></td>
										<td><?php echo $dataCONSUSECX['PURPOSE_OF_FINANCING'];?></td>
										<td class="bg-td"><b>Orientasi Penggunaan</b></td>
										<td><?php echo $dataCONSUSECX['ORIENTATION_OF_USE'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Sektor Ekonomi</b></td>
										<td><?php echo $dataCONSUSECX['ECONOMIC_SECTOR'];?></td>
										<td class="bg-td"><b>Pinjaman sindikasi</b></td>
										<td><?php echo $dataCONSUSECX['[SYNDICATED_LOAN]'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Kode Kategori Debitur</b></td>
										<td><?php echo $dataCONSUSECX['CREDIT_CLASIFICATION'];?></td>
										<td class="bg-td"><b>Nama Tertanggung</b></td>
										<td><?php if($dataCONSUSECX['NAME_OF_INSURED']<>NULL){echo $dataCONSUSECX['NAME_OF_INSURED'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Mata Uang Fasilitas</b></td>
										<td><?php echo $dataCONSUSECX['CONTRACT_CURRENCY'];?></td>
										<td class="bg-td"><b>Lokasi Proyek</b></td>
										<td><?php if($dataCONSUSECX['PROJECT_LOCATION']<>NULL){echo $dataCONSUSECX['PROJECT_LOCATION'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Kode Fasilitas</b></td>
										<td><?php echo $dataCONSUSECX['CONTRACT_CODE'];?></td>
										<td class="bg-td"><b>Nilai Proyek</b></td>
										<td><?php if($dataCONSUSECX['PROJECT_VALUE']<>NULL){echo $dataCONSUSECX['PROJECT_VALUE'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Program Pemerintah</b></td>
										<td><?php echo $dataCONSUSECX['GOVERMENT_PROGRAM'];?></td>
										<td class="bg-td"><b>Jenis Pemberi Pinjaman</b></td>
										<td><?php echo $dataCONSUSECX['CREDITOR_TYPE'];?></td>
									</tr>
									<tr>
										<td colspan="2"></td>
										<td class="bg-td"><b>Pemberi Pinjaman</b></td>
										<td><?php echo $dataCONSUSECX['CREDITOR'];?></td>
									</tr>
									<tr>
										<td colspan="2"></td>
										<td class="bg-td"><b>Branch</b></td>
										<td><?php if($dataCONSUSECX['BRANCH']<>NULL){echo $dataCONSUSECX['BRANCH'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td colspan="2"></td>
										<td class="bg-td"><b>Akad Kredit</b></td>
										<td><?php echo $dataCONSUSECX['CONTRACT_SUB_TYPE'];?></td>
									</tr>
								</table>
							</div>
							<br>
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>TANGGAL FASILITAS</b></p></td>
									</tr>
									<tr>
										<td width="30%" class="bg-td"><b>Tanggal Pencairan</b></td>
										<td width="20%"><?php if($dataCONSUSECX['DISBURSEMENT_DATE']<>NULL){echo $dataCONSUSECX['DISBURSEMENT_DATE']->format('Y-m-d');}else{echo"-";}?></td>
										<td width="30%" class="bg-td"><b>Tanggal Restrukturisasi Akhir</b></td>
										<td width="20%"><?php if($dataCONSUSECX['RESTRUCTURING_DATE']<>NULL){echo $dataCONSUSECX['RESTRUCTURING_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Tanggal Mulai</b></td>
										<td><?php if($dataCONSUSECX['START_DATE']<>NULL){echo $dataCONSUSECX['START_DATE']->format('Y-m-d');}else{echo"-";}?></td>
										<td class="bg-td"><b>Tanggal Restrukturisasi Awal</b></td>
										<td><?php if($dataCONSUSECX['INITIAL_RESTRUCTURING_DATE']<>NULL){echo $dataCONSUSECX['INITIAL_RESTRUCTURING_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Pengkinian Terakhir</b></td>
										<td><?php if($dataCONSUSECX['LAST_UPDATE']<>NULL){echo $dataCONSUSECX['LAST_UPDATE']->format('Y-m-d');}else{echo"-";}?></td>
										<td class="bg-td"><b>Tanggal Jatuh Tempo</b></td>
										<td><?php if($dataCONSUSECX['MATURITY_DATE']<>NULL){echo $dataCONSUSECX['MATURITY_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Tanggal Kondisi</b></td>
										<td><?php if($dataCONSUSECX['CONDITION_DATE']<>NULL){echo $dataCONSUSECX['CONDITION_DATE']->format('Y-m-d');}else{echo"-";}?></td>
										<td class="bg-td"><b>Tanggal pelunasan</b></td>
										<td><?php if($dataCONSUSECX['REAL_END_DATE']<>NULL){echo $dataCONSUSECX['REAL_END_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>RINCIAN KONTRAK AWAL</b></p></td>
									</tr>
									<tr>
										<td width="30%" class="bg-td"><b>Jumlah Plafond</b></td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td width="30%" class="bg-td"><b>Suku Bunga</b></td>
										
									</tr>
									<tr>
										<td class="bg-td"><b>Plafond Awal</b></td>
										<td align="right"><?php if($dataCONSUSECX['INITIAL_TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['INITIAL_TOTAL_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['INITIAL_TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['INITIAL_TOTAL_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td"><b>Nomor Akad Awal</b></td>
										<td align="right"><?php if($dataCONSUSECX['INITIAL_AGREEMENT_NUMBER']<>NULL){echo $dataCONSUSECX['INITIAL_AGREEMENT_NUMBER'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Baki Debet</b></td>
										<td align="right"><?php if($dataCONSUSECX['TOTAL_TAKEN_AMOUNT_CURRENCY']<>NULL){echo $dataCONSUSECX['TOTAL_TAKEN_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_TAKEN_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td"><b>Tanggal Akad Awal</b></td>
										<td align="right"><?php if($dataCONSUSECX['INITIAL_AGREEMENT_DATE']->format('Y-m-d')<>NULL){echo $dataCONSUSECX['INITIAL_AGREEMENT_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td width="30%" class="bg-td">Total Plafon Fasilitas</td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['TOTAL_FACILITY_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_FACILITY_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['TOTAL_FACILITY_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_FACILITY_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td width="30%" class="bg-td">Nomor Akad Terakhir</td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['LAST_AGREEMENT_NUMBER']<>NULL){echo $dataCONSUSECX['LAST_AGREEMENT_NUMBER'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Saldo Terutang</td>
										<td align="right"><?php if($dataCONSUSECX['OUTSTANDING_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['OUTSTANDING_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['OUTSTANDING_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['OUTSTANDING_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Tanggal Akad Terakhir</td>
										<td align="right"><?php if($dataCONSUSECX['LAST_AGREEMENT_DATE']<>NULL){echo $dataCONSUSECX['LAST_AGREEMENT_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Saldo Pokok</td>
										<td align="right"><?php if($dataCONSUSECX['PRINCIPAL_BALANCE_CURRENCY']." ".number_format($dataCONSUSECX['PRINCIPAL_BALANCE_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PRINCIPAL_BALANCE_CURRENCY']." ".number_format($dataCONSUSECX['PRINCIPAL_BALANCE_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Penggunaan Kredit Dalam 30 Hari Terakhir</td>
										<td align="right"><?php if($dataCONSUSECX['CREDIT_USAGE_LAST_30_DAYS']<>NULL){echo $dataCONSUSECX['CREDIT_USAGE_LAST_30_DAYS'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Bank Beneficiery</td>
										<td align="right"><?php if($dataCONSUSECX['BANK_BENEFICIARY']<>NULL){echo $dataCONSUSECX['BANK_BENEFICIARY'];}else{echo"-";}?></td>
										<td class="bg-td">Denda</td>
										<td align="right"><?php if($dataCONSUSECX['PENALTY_CURRENCY']." ".number_format($dataCONSUSECX['PENALTY_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PENALTY_CURRENCY']." ".number_format($dataCONSUSECX['PENALTY_VALUE'],0,',','.');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Suku Bunga</td>
										<td align="right"><?php if($dataCONSUSECX['LAST_INTEREST_RATE']<>NULL){echo $dataCONSUSECX['LAST_INTEREST_RATE'];}else {echo "0";}?>%</td>
										<td class="bg-td">Setoran Jaminan</td>
										<td align="right"><?php if($dataCONSUSECX['GUARANTY_DEPOSIT']<>NULL){echo $dataCONSUSECX['GUARANTY_DEPOSIT'];}else {echo "-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Frekuensi Restrukturisasi</td>
										<td align="right"><?php if($dataCONSUSECX['RESTRUCTURED_COUNT']<>NULL){echo $dataCONSUSECX['RESTRUCTURED_COUNT'];}else {echo "-";}?></td>
										<td class="bg-td">Jenis Suku Bunga</td>
										<td align="right"><?php if($dataCONSUSECX['LAST_INTEREST_RATE_TYPE']<>NULL){echo $dataCONSUSECX['LAST_INTEREST_RATE_TYPE'];}else {echo "-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Kode Cara Restrukturisasi</td>
										<td align="right"><?php if($dataCONSUSECX['RESTRUCTURING_REASON']<>NULL){echo $dataCONSUSECX['RESTRUCTURING_REASON'];}else{echo"-";}?></td>
										<td class="bg-td">Frekuensi Perpanjangan</td>
										<td align="right"><?php if($dataCONSUSECX['PROLONGATION_COUNTER']<>NULL){echo $dataCONSUSECX['PROLONGATION_COUNTER'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Keterangan</td>
										<td align="right" colspan="3"></td>
									</tr>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td width="30%" class="bg-td">Nominal Tunggakan</td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['PASTDUE_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['PASTDUE_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td width="30%" class="bg-td">Umur Tunggakan</td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['PASTDUE_DAYS']<>NUll){echo $dataCONSUSECX['PASTDUE_DAYS'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Bunga Jatuh Tempo</td>
										<td align="right"><?php if($dataCONSUSECX['PASTDUE_INTEREST_CURRENCY']." ".number_format($dataCONSUSECX['PASTDUE_INTEREST_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PASTDUE_INTEREST_CURRENCY']." ".number_format($dataCONSUSECX['PASTDUE_INTEREST_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Terjadinya tunggakan terakhir (lewat lebih dari 90 hari)</td>
										<td align="right"><?php if($dataCONSUSECX['LAST_DELINQUENCY_90_PLUS_DAYS']<>NULL){echo $dataCONSUSECX['[LAST_DELINQUENCY_90_PLUS_DAYS]'];}else {echo "-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Jumlah keterlambatan terbesar</td>
										<td align="right"><?php if($dataCONSUSECX['WORST_PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['WORST_PASTDUE_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['WORST_PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['WORST_PASTDUE_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Tanggal Macet</td>
										<td align="right"><?php if($dataCONSUSECX['DELINQUENCY_DATE']<>NULL){echo $dataCONSUSECX['DELINQUENCY_DATE']->format('Y-m-d');}else{echo"-";}?></td>
										
									</tr>
									<tr>
										<td class="bg-td">Tunggakan Pokok</td>
										<td align="right"><?php if($dataCONSUSECX['PRINCIPAL_AREAS_CURRENCY']." ".number_format($dataCONSUSECX['PRINCIPAL_AREAS_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PRINCIPAL_AREAS_CURRENCY']." ".number_format($dataCONSUSECX['PRINCIPAL_AREAS_VALUE'],0,',','.');}else{echo"-";}?></td>										
										<td class="bg-td">Tanggal Wanprestasi</td>
										<td align="right"><?php if($dataCONSUSECX['DEFAULT_DATE']<>NULL){echo $dataCONSUSECX['DEFAULT_DATE']->format('Y-m-d');}else{echo"-";}?></td>										
									</tr>
									<tr>
										<td class="bg-td">Frekuensi Tunggakan Pokok</td>
										<td align="right"><?php if($dataCONSUSECX['PRINCIPAL_ARREARS_FREQUENCY']<>NULL){echo $dataCONSUSECX['PRINCIPAL_ARREARS_FREQUENCY'];}else {echo "-";}?></td>
										<td class="bg-td">Sebab Macet</td>
										<td align="right"><?php if($dataCONSUSECX['DEFAULT_REASON']<>NULL){echo $dataCONSUSECX['DEFAULT_REASON'];}else {echo "-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Tunggakan Bunga</td>
										<td align="right"><?php if($dataCONSUSECX['INTEREST_ARREARS_CURRENCY']." ".number_format($dataCONSUSECX['INTEREST_ARREARS_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['INTEREST_ARREARS_CURRENCY']." ".number_format($dataCONSUSECX['INTEREST_ARREARS_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Keterangan Macet</td>
										<td align="right"><?php if($dataCONSUSECX['DEFAULT_REASON_DESCRIPTION']<>NULL){echo $dataCONSUSECX['DEFAULT_REASON_DESCRIPTION'];}else {echo "-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Frekuensi Tunggakan Bunga</td>
										<td align="right"><?php if($dataCONSUSECX['INTEREST_ARREARS_FREQUENCY']<>NULL){echo $dataCONSUSECX['INTEREST_ARREARS_FREQUENCY'];}else {echo "-";}?></td>
										<td class="bg-td">Keterlambatan Terlama (hari)</td>
										<td align="right"><?php if($dataCONSUSECX['WORST_PASTDUE_DAYS']<>NULL){echo $dataCONSUSECX['WORST_PASTDUE_DAYS'];}else {echo "-";}?></td>
									</tr>
								</table>
							</div>
							
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>DEBITUR YANG BERSANGKUTAN LAINNYA</b></p></td>
									</tr>
									<tr>
										<td width="20%" class="bg-td" > <b>NAMA</b> </td>
										<td width="20%" class="bg-td" > <b>PERAN</b> </td>
										<td width="40%" class="bg-td" > <b>JOINT ACCOUNT SEQUENCE</b> </td>
										<td width="20%" class="bg-td" > <b>KETERANGAN PENJAMIN<b> </td>
									</tr>
									<?php
										$callCORELSUB = "{call SP_GET_TAB_CONTRACT_RELATED_SUBJECT(?)}";
										$paramsCORELSUB = array(array($id, SQLSRV_PARAM_IN));
										$optionsCORELSUB =  array( "Scrollable" => "buffered" );
										$execCORELSUB = sqlsrv_query( $conn, $callCORELSUB, $paramsCORELSUB) or die( print_r( sqlsrv_errors(), true));
										$checkCORELSUB=sqlsrv_num_rows($execCORELSUB);
										while($dataCORELSUB = sqlsrv_fetch_array($execCORELSUB)){
									?>
									<tr>
										<td><?php if( $dataCORELSUB['NAME']<>NULL){echo $dataCORELSUB['NAME'];}else{echo "-";}?></td>
										<td><?php if( $dataCORELSUB['ROLE_OF_CLIENT']<>NULL){echo $dataCORELSUB['ROLE_OF_CLIENT'];}else{echo "-";}?></td>
										<td><?php if( $dataCORELSUB['JOINT_ACCOUNT_SEQUENCE']<>NULL){echo $dataCORELSUB['JOINT_ACCOUNT_SEQUENCE'];}else{echo "-";}?></td>
										<td><?php if( $dataCORELSUB['GUARANCY_DESCRIPTION']<>NULL){echo $dataCORELSUB['GUARANCY_DESCRIPTION'];}else{echo "-";}?></td>
									</tr>
									<?php }?>
								</table>
							</div>
						</div>
					</div>
				</div>
				<?php
					}	}
				?>
				
				<br>
				
				<!-- PENJAMIN NON AKTIF-->
				<p class="name text-danger">Penjamin Non Aktif</p>	
				<?php
					$no=300;
					$callCONSUSECX = "{call SP_GET_TAB_CONTRACT(?,?,?)}";
					$paramsCONSUSECX = array(array($id, SQLSRV_PARAM_IN),array("Guarantor", SQLSRV_PARAM_IN),array("Closed", SQLSRV_PARAM_IN));
					$options =  array( "Scrollable" => "buffered" );
					$execCONSUSECX = sqlsrv_query( $conn, $callCONSUSECX, $paramsCONSUSECX,$options) or die( print_r( sqlsrv_errors(), true));
					$nums = sqlsrv_num_rows($execCONSUSECX);
					if($nums == 0 ){
						echo"<div style='border:1px solid #EEE;padding:5px;'> Tidak ada fasilitas</div>";
					}else{
					while($dataCONSUSECX = sqlsrv_fetch_array($execCONSUSECX)){
						$no++;

				?>
				
				<div id="accordion<?php echo $no;?>">
					<div class="card">
						<div class="header">
							<div class="pull-left">
								<p class="name" style="font-size:14px;"><?php echo $dataCONSUSECX['CONTRACT_TYPE'];?></p>
							</div>
							<div class="pull-right">
								<a class="card-link2" data-toggle="collapse" href="#collapseOne<?php echo $no;?>">
									<i class="fa fa-chevron-down text-danger"></i>
								</a>
							</div>
							<div style="clear:both"></div>
						</div>
						<div id="collapseOne<?php echo $no;?>" class="collapse content" data-parent="#accordion<?php echo $no;?>">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>RINCIAN FASILITAS</b></p></td>
									</tr>
									<tr>
										<td width="30%" class="bg-td"><b>Peran Nasabah</b></td>
										<td width="20%"><?php echo $dataCONSUSECX['ROLE_OF_CLIENT'];?></td>
										<td width="30%" class="bg-td"><b>Fase Fasilitas</b></td>
										<td width="20%"><?php echo $dataCONSUSECX['PHASE_OF_CONTRACT'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Tipe Fasilitas</b></td>
										<td><?php echo $dataCONSUSECX['CONTRACT_TYPE'];?></td>
										<td class="bg-td"><b>Status Fasilitas</b></td>
										<td><?php echo $dataCONSUSECX['CONTRACT_STATUS'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Sifat Kredit</b></td>
										<td><?php echo $dataCONSUSECX['CREDIT_CHARACTERISTIC'];?></td>
										<td class="bg-td"><b>Kolektibilitas</b></td>
										<td><?php echo $dataCONSUSECX['NEGATIVE_STATUS_OF_CONTRACT'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Tujuan Pendanaan</b></td>
										<td><?php echo $dataCONSUSECX['PURPOSE_OF_FINANCING'];?></td>
										<td class="bg-td"><b>Orientasi Penggunaan</b></td>
										<td><?php echo $dataCONSUSECX['ORIENTATION_OF_USE'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Sektor Ekonomi</b></td>
										<td><?php echo $dataCONSUSECX['ECONOMIC_SECTOR'];?></td>
										<td class="bg-td"><b>Pinjaman sindikasi</b></td>
										<td><?php echo $dataCONSUSECX['[SYNDICATED_LOAN]'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Kode Kategori Debitur</b></td>
										<td><?php echo $dataCONSUSECX['CREDIT_CLASIFICATION'];?></td>
										<td class="bg-td"><b>Nama Tertanggung</b></td>
										<td><?php if($dataCONSUSECX['NAME_OF_INSURED']<>NULL){echo $dataCONSUSECX['NAME_OF_INSURED'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Mata Uang Fasilitas</b></td>
										<td><?php echo $dataCONSUSECX['CONTRACT_CURRENCY'];?></td>
										<td class="bg-td"><b>Lokasi Proyek</b></td>
										<td><?php if($dataCONSUSECX['PROJECT_LOCATION']<>NULL){echo $dataCONSUSECX['PROJECT_LOCATION'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Kode Fasilitas</b></td>
										<td><?php echo $dataCONSUSECX['CONTRACT_CODE'];?></td>
										<td class="bg-td"><b>Nilai Proyek</b></td>
										<td><?php if($dataCONSUSECX['PROJECT_VALUE']<>NULL){echo $dataCONSUSECX['PROJECT_VALUE'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Program Pemerintah</b></td>
										<td><?php echo $dataCONSUSECX['GOVERMENT_PROGRAM'];?></td>
										<td class="bg-td"><b>Jenis Pemberi Pinjaman</b></td>
										<td><?php echo $dataCONSUSECX['CREDITOR_TYPE'];?></td>
									</tr>
									<tr>
										<td colspan="2"></td>
										<td class="bg-td"><b>Pemberi Pinjaman</b></td>
										<td><?php echo $dataCONSUSECX['CREDITOR'];?></td>
									</tr>
									<tr>
										<td colspan="2"></td>
										<td class="bg-td"><b>Branch</b></td>
										<td><?php if($dataCONSUSECX['BRANCH']<>NULL){echo $dataCONSUSECX['BRANCH'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td colspan="2"></td>
										<td class="bg-td"><b>Akad Kredit</b></td>
										<td><?php echo $dataCONSUSECX['CONTRACT_SUB_TYPE'];?></td>
									</tr>
								</table>
							</div>
							<br>
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>TANGGAL FASILITAS</b></p></td>
									</tr>
									<tr>
										<td width="30%" class="bg-td"><b>Tanggal Pencairan</b></td>
										<td width="20%"><?php if($dataCONSUSECX['DISBURSEMENT_DATE']<>NULL){echo $dataCONSUSECX['DISBURSEMENT_DATE']->format('Y-m-d');}else{echo"-";}?></td>
										<td width="30%" class="bg-td"><b>Tanggal Restrukturisasi Akhir</b></td>
										<td width="20%"><?php if($dataCONSUSECX['RESTRUCTURING_DATE']<>NULL){echo $dataCONSUSECX['RESTRUCTURING_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Tanggal Mulai</b></td>
										<td><?php if($dataCONSUSECX['START_DATE']<>NULL){echo $dataCONSUSECX['START_DATE']->format('Y-m-d');}else{echo"-";}?></td>
										<td class="bg-td"><b>Tanggal Restrukturisasi Awal</b></td>
										<td><?php if($dataCONSUSECX['INITIAL_RESTRUCTURING_DATE']<>NULL){echo $dataCONSUSECX['INITIAL_RESTRUCTURING_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Pengkinian Terakhir</b></td>
										<td><?php if($dataCONSUSECX['LAST_UPDATE']<>NULL){echo $dataCONSUSECX['LAST_UPDATE']->format('Y-m-d');}else{echo"-";}?></td>
										<td class="bg-td"><b>Tanggal Jatuh Tempo</b></td>
										<td><?php if($dataCONSUSECX['MATURITY_DATE']<>NULL){echo $dataCONSUSECX['MATURITY_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Tanggal Kondisi</b></td>
										<td><?php if($dataCONSUSECX['CONDITION_DATE']<>NULL){echo $dataCONSUSECX['CONDITION_DATE']->format('Y-m-d');}else{echo"-";}?></td>
										<td class="bg-td"><b>Tanggal pelunasan</b></td>
										<td><?php if($dataCONSUSECX['REAL_END_DATE']<>NULL){echo $dataCONSUSECX['REAL_END_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>RINCIAN KONTRAK AWAL</b></p></td>
									</tr>
									<tr>
										<td width="30%" class="bg-td"><b>Jumlah Plafond</b></td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td width="30%" class="bg-td"><b>Suku Bunga</b></td>
										
									</tr>
									<tr>
										<td class="bg-td"><b>Plafond Awal</b></td>
										<td align="right"><?php if($dataCONSUSECX['INITIAL_TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['INITIAL_TOTAL_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['INITIAL_TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['INITIAL_TOTAL_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td"><b>Nomor Akad Awal</b></td>
										<td align="right"><?php if($dataCONSUSECX['INITIAL_AGREEMENT_NUMBER']<>NULL){echo $dataCONSUSECX['INITIAL_AGREEMENT_NUMBER'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Baki Debet</b></td>
										<td align="right"><?php if($dataCONSUSECX['TOTAL_TAKEN_AMOUNT_CURRENCY']<>NULL){echo $dataCONSUSECX['TOTAL_TAKEN_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_TAKEN_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td"><b>Tanggal Akad Awal</b></td>
										<td align="right"><?php if($dataCONSUSECX['INITIAL_AGREEMENT_DATE']->format('Y-m-d')<>NULL){echo $dataCONSUSECX['INITIAL_AGREEMENT_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td width="30%" class="bg-td">Total Plafon Fasilitas</td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['TOTAL_FACILITY_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_FACILITY_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['TOTAL_FACILITY_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_FACILITY_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td width="30%" class="bg-td">Nomor Akad Terakhir</td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['LAST_AGREEMENT_NUMBER']<>NULL){echo $dataCONSUSECX['LAST_AGREEMENT_NUMBER'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Saldo Terutang</td>
										<td align="right"><?php if($dataCONSUSECX['OUTSTANDING_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['OUTSTANDING_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['OUTSTANDING_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['OUTSTANDING_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Tanggal Akad Terakhir</td>
										<td align="right"><?php if($dataCONSUSECX['LAST_AGREEMENT_DATE']<>NULL){echo $dataCONSUSECX['LAST_AGREEMENT_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Saldo Pokok</td>
										<td align="right"><?php if($dataCONSUSECX['PRINCIPAL_BALANCE_CURRENCY']." ".number_format($dataCONSUSECX['PRINCIPAL_BALANCE_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PRINCIPAL_BALANCE_CURRENCY']." ".number_format($dataCONSUSECX['PRINCIPAL_BALANCE_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Penggunaan Kredit Dalam 30 Hari Terakhir</td>
										<td align="right"><?php if($dataCONSUSECX['CREDIT_USAGE_LAST_30_DAYS']<>NULL){echo $dataCONSUSECX['CREDIT_USAGE_LAST_30_DAYS'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Bank Beneficiery</td>
										<td align="right"><?php if($dataCONSUSECX['BANK_BENEFICIARY']<>NULL){echo $dataCONSUSECX['BANK_BENEFICIARY'];}else{echo"-";}?></td>
										<td class="bg-td">Denda</td>
										<td align="right"><?php if($dataCONSUSECX['PENALTY_CURRENCY']." ".number_format($dataCONSUSECX['PENALTY_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PENALTY_CURRENCY']." ".number_format($dataCONSUSECX['PENALTY_VALUE'],0,',','.');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Suku Bunga</td>
										<td align="right"><?php if($dataCONSUSECX['LAST_INTEREST_RATE']<>NULL){echo $dataCONSUSECX['LAST_INTEREST_RATE'];}else {echo "0";}?>%</td>
										<td class="bg-td">Setoran Jaminan</td>
										<td align="right"><?php if($dataCONSUSECX['GUARANTY_DEPOSIT']<>NULL){echo $dataCONSUSECX['GUARANTY_DEPOSIT'];}else {echo "-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Frekuensi Restrukturisasi</td>
										<td align="right"><?php if($dataCONSUSECX['RESTRUCTURED_COUNT']<>NULL){echo $dataCONSUSECX['RESTRUCTURED_COUNT'];}else {echo "-";}?></td>
										<td class="bg-td">Jenis Suku Bunga</td>
										<td align="right"><?php if($dataCONSUSECX['LAST_INTEREST_RATE_TYPE']<>NULL){echo $dataCONSUSECX['LAST_INTEREST_RATE_TYPE'];}else {echo "-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Kode Cara Restrukturisasi</td>
										<td align="right"><?php if($dataCONSUSECX['RESTRUCTURING_REASON']<>NULL){echo $dataCONSUSECX['RESTRUCTURING_REASON'];}else{echo"-";}?></td>
										<td class="bg-td">Frekuensi Perpanjangan</td>
										<td align="right"><?php if($dataCONSUSECX['PROLONGATION_COUNTER']<>NULL){echo $dataCONSUSECX['PROLONGATION_COUNTER'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Keterangan</td>
										<td align="right" colspan="3"></td>
									</tr>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td width="30%" class="bg-td">Nominal Tunggakan</td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['PASTDUE_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['PASTDUE_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td width="30%" class="bg-td">Umur Tunggakan</td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['PASTDUE_DAYS']<>NUll){echo $dataCONSUSECX['PASTDUE_DAYS'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Bunga Jatuh Tempo</td>
										<td align="right"><?php if($dataCONSUSECX['PASTDUE_INTEREST_CURRENCY']." ".number_format($dataCONSUSECX['PASTDUE_INTEREST_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PASTDUE_INTEREST_CURRENCY']." ".number_format($dataCONSUSECX['PASTDUE_INTEREST_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Terjadinya tunggakan terakhir (lewat lebih dari 90 hari)</td>
										<td align="right"><?php if($dataCONSUSECX['LAST_DELINQUENCY_90_PLUS_DAYS']<>NULL){echo $dataCONSUSECX['[LAST_DELINQUENCY_90_PLUS_DAYS]'];}else {echo "-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Jumlah keterlambatan terbesar</td>
										<td align="right"><?php if($dataCONSUSECX['WORST_PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['WORST_PASTDUE_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['WORST_PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['WORST_PASTDUE_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Tanggal Macet</td>
										<td align="right"><?php if($dataCONSUSECX['DELINQUENCY_DATE']<>NULL){echo $dataCONSUSECX['DELINQUENCY_DATE']->format('Y-m-d');}else{echo"-";}?></td>
										
									</tr>
									<tr>
										<td class="bg-td">Tunggakan Pokok</td>
										<td align="right"><?php if($dataCONSUSECX['PRINCIPAL_AREAS_CURRENCY']." ".number_format($dataCONSUSECX['PRINCIPAL_AREAS_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PRINCIPAL_AREAS_CURRENCY']." ".number_format($dataCONSUSECX['PRINCIPAL_AREAS_VALUE'],0,',','.');}else{echo"-";}?></td>										
										<td class="bg-td">Tanggal Wanprestasi</td>
										<td align="right"><?php if($dataCONSUSECX['DEFAULT_DATE']<>NULL){echo $dataCONSUSECX['DEFAULT_DATE']->format('Y-m-d');}else{echo"-";}?></td>										
									</tr>
									<tr>
										<td class="bg-td">Frekuensi Tunggakan Pokok</td>
										<td align="right"><?php if($dataCONSUSECX['PRINCIPAL_ARREARS_FREQUENCY']<>NULL){echo $dataCONSUSECX['PRINCIPAL_ARREARS_FREQUENCY'];}else {echo "-";}?></td>
										<td class="bg-td">Sebab Macet</td>
										<td align="right"><?php if($dataCONSUSECX['DEFAULT_REASON']<>NULL){echo $dataCONSUSECX['DEFAULT_REASON'];}else {echo "-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Tunggakan Bunga</td>
										<td align="right"><?php if($dataCONSUSECX['INTEREST_ARREARS_CURRENCY']." ".number_format($dataCONSUSECX['INTEREST_ARREARS_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['INTEREST_ARREARS_CURRENCY']." ".number_format($dataCONSUSECX['INTEREST_ARREARS_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Keterangan Macet</td>
										<td align="right"><?php if($dataCONSUSECX['DEFAULT_REASON_DESCRIPTION']<>NULL){echo $dataCONSUSECX['DEFAULT_REASON_DESCRIPTION'];}else {echo "-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Frekuensi Tunggakan Bunga</td>
										<td align="right"><?php if($dataCONSUSECX['INTEREST_ARREARS_FREQUENCY']<>NULL){echo $dataCONSUSECX['INTEREST_ARREARS_FREQUENCY'];}else {echo "-";}?></td>
										<td class="bg-td">Keterlambatan Terlama (hari)</td>
										<td align="right"><?php if($dataCONSUSECX['WORST_PASTDUE_DAYS']<>NULL){echo $dataCONSUSECX['WORST_PASTDUE_DAYS'];}else {echo "-";}?></td>
									</tr>
								</table>
							</div>
							
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>DEBITUR YANG BERSANGKUTAN LAINNYA</b></p></td>
									</tr>
									<tr>
										<td width="20%" class="bg-td" > <b>NAMA</b> </td>
										<td width="20%" class="bg-td" > <b>PERAN</b> </td>
										<td width="40%" class="bg-td" > <b>JOINT ACCOUNT SEQUENCE</b> </td>
										<td width="20%" class="bg-td" > <b>KETERANGAN PENJAMIN<b> </td>
									</tr>
									<?php
										$callCORELSUB = "{call SP_GET_TAB_CONTRACT_RELATED_SUBJECT(?)}";
										$paramsCORELSUB = array(array($id, SQLSRV_PARAM_IN));
										$optionsCORELSUB =  array( "Scrollable" => "buffered" );
										$execCORELSUB = sqlsrv_query( $conn, $callCORELSUB, $paramsCORELSUB) or die( print_r( sqlsrv_errors(), true));
										$checkCORELSUB=sqlsrv_num_rows($execCORELSUB);
										while($dataCORELSUB = sqlsrv_fetch_array($execCORELSUB)){
									?>
									<tr>
										<td><?php if( $dataCORELSUB['NAME']<>NULL){echo $dataCORELSUB['NAME'];}else{echo "-";}?></td>
										<td><?php if( $dataCORELSUB['ROLE_OF_CLIENT']<>NULL){echo $dataCORELSUB['ROLE_OF_CLIENT'];}else{echo "-";}?></td>
										<td><?php if( $dataCORELSUB['JOINT_ACCOUNT_SEQUENCE']<>NULL){echo $dataCORELSUB['JOINT_ACCOUNT_SEQUENCE'];}else{echo "-";}?></td>
										<td><?php if( $dataCORELSUB['GUARANCY_DESCRIPTION']<>NULL){echo $dataCORELSUB['GUARANCY_DESCRIPTION'];}else{echo "-";}?></td>
									</tr>
									<?php }?>
								</table>
							</div>
						</div>
					</div>
				</div>
				<?php
					}	}
				?>

			</div>									
		</div>							
	</div>
</div>	