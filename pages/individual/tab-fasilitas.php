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
								<td align="center"><?php if($dataCONT['START_DATE']<>NULL){echo $dataCONT['START_DATE']->format('Y-m-d');}?></td>
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
								<td><b></b></td>
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
									<i class="fa fa-chevron-down text-custom"></i>
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
											<th>UMUR TUNGGAKAN</th>
											<th>NOMINAL TUNGGAKAN</th>
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
				<p class="name text-custom">Ringkasan fasilitas dan penjaminan Perbankan</p>	
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
				<p class="name text-custom">Ringkasan fasilitas dan penjaminan NonBankingFinancialInstitutions</p>	
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
				<p class="name text-custom">Ringkasan fasilitas dan penjaminan Pegadaian</p>	
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
				<p class="name text-custom">Ringkasan fasilitas lainnya</p>	
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
				<a class="btn btn-success btn-xs" style="width:100%;" href="rincian_fasilitas.php?USERNAME=<?php echo $user;?>&id=<?php echo $id; ?>&prospect_no=<?php echo $prospect_no;?>"target="_blank"
											>Klik Untuk Melihat Rincian Fasilitas Aktif</a>
				<br>
				<br>
				<a class="btn btn-success btn-xs" style="width:100%;" href="rincian_fasilitas_not_aktif.php?USERNAME=<?php echo $user;?>&id=<?php echo $id; ?>&prospect_no=<?php echo $prospect_no;?>"target="_blank"
				>Klik Untuk Melihat Rincian Fasilitas Not Aktif</a>
				<br>
				<br>
				<a class="btn btn-success btn-xs" style="width:100%;" href="rincian_fasilitas_penjamin.php?USERNAME=<?php echo $user;?>&id=<?php echo $id; ?>&prospect_no=<?php echo $prospect_no;?>"target="_blank"
				>Klik Untuk Melihat Rincian Fasilitas Penjamin</a>


			</div>									
		</div>							
	</div>
</div>	