<?php
/* select table cip */
$callCIPCOM = "{call SP_GET_TAB_DASHBOARD_TBL_CIP_COMPANY(?)}";
$paramsCIPCOM = array(array($id, SQLSRV_PARAM_IN));
$execCIPCOM = sqlsrv_query( $conn, $callCIPCOM, $paramsCIPCOM) or die( print_r( sqlsrv_errors(), true));
$dataCIPCOM = sqlsrv_fetch_array($execCIPCOM);

/* select table dashboard */
$callDashCOM = "{call SP_GET_TAB_DASHBOARD_TBL_DASHBOARD_COMPANY(?)}";
$paramsDashCOM = array(array($id, SQLSRV_PARAM_IN));
$execDashCOM = sqlsrv_query( $conn, $callDashCOM, $paramsDashCOM) or die( print_r( sqlsrv_errors(), true));
$dataDashCOM = sqlsrv_fetch_array($execDashCOM);
?>
<div class="card">
	<div class="header"><p class="name">Dashboard</p></div>
	<div class="content">
		<div class="card">
			<div class="header"><p class="name text-danger">PEFINDO Score (PS)</p></div>
			<div class="content">
				<div class="row">
					<div class="col-md-4">
						<table>
							<tr>
								<td>
									<?php
									if($dataCIPCOM['GRADE'] == "E3" || $dataCIPCOM['GRADE'] == "E2" || $dataCIPCOM['GRADE'] == "E1"){
										echo'<div class="box-red">';
									}else if($dataCIPCOM['GRADE'] == "D3" || $dataCIPCOM['GRADE'] == "D2" || $dataCIPCOM['GRADE'] == "D1"){
										echo'<div class="box-red" style="background-color:#f3334b;">';
									}else if($dataCIPCOM['GRADE'] == "C3" || $dataCIPCOM['GRADE'] == "C2" || $dataCIPCOM['GRADE'] == "C1"){
										echo'<div class="box-yellow">';
									}else if($dataCIPCOM['GRADE'] == "B3" || $dataCIPCOM['GRADE'] == "B2" || $dataCIPCOM['GRADE'] == "B1"){
										echo'<div class="box-green" style="background-color:#01b701;">';
									}else{
										echo'<div class="box-green">';
									}
									?>
										<center><?php echo $dataCIPCOM['GRADE'];?><!-- C3 --></center>
									</div>
								</td>
								<td style="vertical-align:middle;">
									<?php
									if($dataCIPCOM['GRADE'] == "E3" || $dataCIPCOM['GRADE'] == "E2" || $dataCIPCOM['GRADE'] == "E1"){
										echo'Risiko Sangat Tinggi';
									}else if($dataCIPCOM['GRADE'] == "D3" || $dataCIPCOM['GRADE'] == "D2" || $dataCIPCOM['GRADE'] == "D1"){
										echo'Risiko Tinggi';
									}else if($dataCIPCOM['GRADE'] == "C3" || $dataCIPCOM['GRADE'] == "C2" || $dataCIPCOM['GRADE'] == "C1"){
										echo'Risiko Sedang';
									}else if($dataCIPCOM['GRADE'] == "B3" || $dataCIPCOM['GRADE'] == "B2" || $dataCIPCOM['GRADE'] == "B1"){
										echo'Risiko Rendah';
									}else{
										echo'Risiko Sangat Rendah';
									}
									?>
									<!--Resiko Medium-->
								</td>
							</tr>
						</table>
					</div>
					<div class="col-md-4">
						<table>
							<tr>
								<td>
									<div class="box-white">
										<center>
											<?php
											if($dataCIPCOM['TREND'] == "Down"){
												echo'<i class="fa fa-arrow-down text-danger"></i>';
											}else if($dataCIPCOM['TREND'] == "Up"){
												echo'<i class="fa fa-arrow-up text-success"></i>';
											}else{
												echo'<i class="fa fa-arrow-right"></i>';
											}
											?>
										</center>
									</div>
								</td>
								<td style="vertical-align:middle;">Trend</td>
							</tr>
						</table>
					</div>
					<div class="col-md-4">
						<table>
							<tr>
								<td>
									<div class="box-white">
										<center><?php echo $dataCIPCOM['SCORE'];?></center>
									</div>
								</td>
								<td style="vertical-align:middle;">Nilai PS</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="header"><p class="name text-danger">Permintaan Informasi</p></div>
			<div class="content">
				<div class="row">
					<div class="col-md-4">
						<table>
							<tr>
								<td>
									<div class="box-red">
										<center><?php echo $dataDashCOM['INQUIRIES_FOR_LAST_12_MONTHS'];?><!--255--></center>
									</div>
								</td>
								<td style="vertical-align:middle;">Jumlah Permintaan Informasi dalam 12 bulan terakhir </td>
							</tr>
						</table>
					</div>
					<div class="col-md-4">
						<table>
							<tr>
								<td>
									<div class="box-green">
										<center><?php echo $dataDashCOM['INQUIRIES_SUBSCRIBERS_IN_LAST_12_MONTHS'];?><!--32--></center>
									</div>
								</td>
								<td style="vertical-align:middle;">Pencarian pelanggan selama 12 bulan terakhir</td>
							</tr>
						</table>
					</div>
					<div class="col-md-4"></div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="header"><p class="name text-danger">Fasilitas</p></div>
			<div class="content">
				<p class="name text-default">Profil Pembayaran</p>
				<div class="row">
					<div class="col-md-3">
						<table>
							<tr>
								<td>
									<div class="box-green">
										<center><i class="fa fa-money"></i></center>
									</div>
								</td>
								<td style="vertical-align:middle;">Status Profil Pembayaran</td>
							</tr>
						</table>
					</div>
					<div class="col-md-9">
						<div class="table-responsive">
							<table style="width:100%;">
								<tr>
									<td width="80%;">Jumlah nominal tunggakan (Fasilitas yang masih berjalan)</td>
									<td align="right"><?php echo $dataDashCOM['PAYMENTS_PAST_DUE_AMOUNT_SUM_CURRENCY']." ".number_format($dataDashCOM['PAYMENTS_PAST_DUE_AMOUNT_SUM_VALUE'],0,',','.');?> <i class="fa fa-arrow-right"></i></td>
								</tr>
								<tr>
									<td>Maks. Usia Tunggakan</td>
									<td align="right"><?php echo $dataDashCOM['PAYMENTS_WORST_PAST_DUE_DAYS_CURRENT'];?> Days</td>
								</tr>
								<tr>
									<td>Maks. Usia Tunggakan Dalam 12 Bulan Terakhir</td>
									<td align="right"><?php echo $dataDashCOM['PAYMENTS_WORST_PAST_DUE_DAY_FOR_LAST_12_MONTHS'];?> Days</td>
								</tr>
								<tr>
									<td>Jumlah Kreditur</td>
									<td align="right"><?php echo $dataDashCOM['PAYMENTS_NUMBER_OF_DIFFERENT_SUBSCRIBERS'];?></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<hr>
				<p class="name text-default">Fasilitas Aktif</p>
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>JENIS LEMBAGA</th>
								<th>JENIS FASILITAS</th>
								<th>TANGGAL PEMBUKAAN<br>TANGGAL PENGKINIAN</th>
								<th>PLAFON</th>
								<th>BAKI DEBET</th>
								<th>JATUH TEMPO</th>
							</tr>
						</thead>
						<tbody>
						<?php
							$totalPlafond = 0;
							$totalBakiDebet = 0;
							$totalJatuhTempo = 0;
							$callContractCOM = "{call SP_GET_TAB_DASHBOARD_TBL_CONTRACT_OPEN_COMPANY(?)}";
							$optionsContractCOM =  array( "Scrollable" => "buffered" );
							$paramsContractCOM = array(array($id, SQLSRV_PARAM_IN));
							$execContractCOM = sqlsrv_query($conn, $callContractCOM, $paramsContractCOM, $optionsContractCOM) or die( print_r( sqlsrv_errors(), true));
							$numRowsContractCOM = sqlsrv_num_rows($execContractCOM);
							while($dataContractCOM = sqlsrv_fetch_array($execContractCOM)){
								$totalPlafond =+ $totalPlafond + $dataContractCOM['TOTAL_AMOUNT_VALUE'];
								$totalBakiDebet =+ $totalBakiDebet + $dataContractCOM['OUTSTANDING_AMOUNT_VALUE'];
								$totalJatuhTempo =+ $totalJatuhTempo + $dataContractCOM['PASTDUE_AMOUNT_VALUE'];
						?>
							<tr>
								<td align="left"><?php echo $dataContractCOM['CREDITOR_TYPE'];?></td>
								<td align="left"><a href="#"><?php echo $dataContractCOM['CONTRACT_TYPE'];?></a></td>
								<td align="center"><?php if($dataContractCOM['START_DATE']<>NULL){echo $dataContractCOM['START_DATE']->format("d-m-Y");}else{echo"";}?><br><?php if($dataContractCOM['LAST_UPDATE']<>NULL){echo $dataContractCOM['LAST_UPDATE']->format("d-m-Y");}else{echo"";}?></td>
								<td align="right"><?php echo $dataContractCOM['TOTAL_AMOUNT_CURRENCY']." ".number_format($dataContractCOM['TOTAL_AMOUNT_VALUE'],0,',','.');?></td>
								<td align="right"><?php echo $dataContractCOM['OUTSTANDING_AMOUNT_CURRENCY']." ".number_format($dataContractCOM['OUTSTANDING_AMOUNT_VALUE'],0,',','.');?></td>
								<td align="right"><?php echo $dataContractCOM['PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataContractCOM['PASTDUE_AMOUNT_VALUE'],0,',','.');?><br><?php echo $dataContractCOM['PASTDUE_DAYS'];?> Days</td>
							</tr>
						<?php } ?>
							<tr>
								<td align="left" colspan="2"><b>Sum - Debtor / Co-debtor</b></td>
								<td align="center"><b><?php echo $numRowsContractCOM;?></b></td>
								<td align="right"><b>IDR <?php echo number_format($totalPlafond,0,',','.');?></b></td>
								<td align="right"><b>IDR <?php echo number_format($totalBakiDebet,0,',','.');?></b></td>
								<td align="right"><b>IDR <?php echo number_format($totalJatuhTempo,0,',','.');?></b></td>
							</tr>
						</tbody>
					</table>
				</div>
				<p class="name text-default">Fasilitas Non Aktif</p>
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>JENIS LEMBAGA</th>
								<th>JENIS FASILITAS</th>
								<th>DITUTUP<br>STATUS</th>
								<th>PLAFON</th>
								<th>BAKI DEBET</th>
								<th>JATUH TEMPO</th>
							</tr>
						</thead>
						<tbody>
						<?php
							$totalPlafond2 = 0;
							$totalBakiDebet2 = 0;
							$totalJatuhTempo2 = 0;
							$callContractCOM2 = "{call SP_GET_TAB_DASHBOARD_TBL_CONTRACT_CLOSED_COMPANY(?)}";
							$optionsContractCOM2 =  array( "Scrollable" => "buffered" );
							$paramsContractCOM2 = array(array($id, SQLSRV_PARAM_IN));
							$execContractCOM2 = sqlsrv_query($conn, $callContractCOM2, $paramsContractCOM2, $optionsContractCOM2) or die( print_r( sqlsrv_errors(), true));
							$numRowsContractCOM2 = sqlsrv_num_rows($execContractCOM2);
							while($dataContractCOM2 = sqlsrv_fetch_array($execContractCOM2)){
								$totalPlafond2 =+ $totalPlafond2 + $dataContractCOM2['TOTAL_AMOUNT_VALUE'];
								$totalBakiDebet2 =+ $totalBakiDebet2 + $dataContractCOM2['OUTSTANDING_AMOUNT_VALUE'];
								$totalJatuhTempo2 =+ $totalJatuhTempo2 + $dataContractCOM2['PASTDUE_AMOUNT_VALUE'];
						?>
							<tr>
								<td align="left"><?php echo $dataContractCOM2['CREDITOR_TYPE'];?></td>
								<td align="left"><a href="#"><?php echo $dataContractCOM2['CONTRACT_TYPE'];?></a></td>
								<td align="center"><?php if($dataContractCOM2['START_DATE']<>NULL){echo $dataContractCOM2['START_DATE']->format("d-m-Y");}else{echo"";}?><br><?php if($dataContractCOM2['LAST_UPDATE']<>NULL){echo $dataContractCOM2['LAST_UPDATE']->format("d-m-Y");}else{echo"";}?></td>
								<td align="right"><?php echo $dataContractCOM2['TOTAL_AMOUNT_CURRENCY']." ".number_format($dataContractCOM2['TOTAL_AMOUNT_VALUE'],0,',','.');?></td>
								<td align="right"><?php echo $dataContractCOM2['OUTSTANDING_AMOUNT_CURRENCY']." ".number_format($dataContractCOM2['OUTSTANDING_AMOUNT_VALUE'],0,',','.');?></td>
								<td align="right"><?php echo $dataContractCOM2['PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataContractCOM2['PASTDUE_AMOUNT_VALUE'],0,',','.');?><br><?php echo $dataContractCOM2['PASTDUE_DAYS'];?> Days</td>
							</tr>
						<?php } ?>
							<tr>
								<td align="left" colspan="2"><b>Sum - Debtor / Co-debtor</b></td>
								<td align="center"><b><?php echo $numRowsContractCOM2;?></b></td>
								<td align="right"><b>IDR <?php echo number_format($totalPlafond2,0,',','.');?></b></td>
								<td align="right"><b>IDR <?php echo number_format($totalBakiDebet2,0,',','.');?></b></td>
								<td align="right"><b>IDR <?php echo number_format($totalJatuhTempo2,0,',','.');?></b></td>
							</tr>
						</tbody>
					</table>
				</div>
				<p class="name text-default">Ringkasan Kalender Pembayaran untuk Seluruh Fasilitas</p>
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th width='20%'>BULAN / TAHUN</th>
								<?php
									$callCalList = "{call SP_GET_TAB_DASHBOARD_TBL_CONTRACT_SUMARY_PAYMENT_CALENDER_LISTCOM(?)}";
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
									$callCalList2 = "{call SP_GET_TAB_DASHBOARD_TBL_CONTRACT_SUMARY_PAYMENT_CALENDER_LISTCOM(?)}";
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
				<div id="accordion2">
					<div class="card">
						<div class="header">
							<div class="pull-left">
								<?php
								$callCalList3 = "{call SP_GET_TAB_DASHBOARD_TBL_CONTRACT_SUMARY_PAYMENT_CALENDER_LISTCOM(?)}";
								$paramsCalList3 = array(array($id, SQLSRV_PARAM_IN));
								$execCalList3 = sqlsrv_query($conn, $callCalList3, $paramsCalList3) or die( print_r( sqlsrv_errors(), true));
								$rowCalList = sqlsrv_fetch_array($execCalList3);
								?>
								<p class="name text-default">Pembayaran <?php if($rowCalList['START_DATE']<>NULL){echo $rowCalList['START_DATE']->format('m/Y');}else{echo"";}echo" - ";if($rowCalList['END_DATE']<>NULL){echo $rowCalList['END_DATE']->format('m/Y');}else{echo"";}?></p>
							</div>
							<div class="pull-right">
								<a class="card-link2" data-toggle="collapse" href="#collapseOne2">
									<i class="fa fa-chevron-down text-danger"></i>
								</a>
							</div>
							<div style="clear:both"></div>
						</div>
						<div id="collapseOne2" class="collapse content" data-parent="#accordion2">
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
										$callCalList4 = "{call SP_GET_TAB_DASHBOARD_TBL_CONTRACT_SUMARY_PAYMENT_CALENDER_LISTCOM(?)}";
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
		<div class="card">
			<div class="header"><p class="name text-danger">Jaminan</p></div>
			<div class="content">
				<div class="row">
					<div class="col-md-4">
						<table>
							<tr>
								<td>
									<div class="box-white">
										<center><?php echo $dataDashCOM['COLLATERALS_NUMBER_OF_COLLATERALS'];?></center>
									</div>
								</td>
								<td style="vertical-align:top;">Jumlah Jaminan</td>
							</tr>
						</table>
					</div>
					<div class="col-md-8">
						<table style="width:100%;">
							<tr>
								<td style="vertical-align:top;">Total Jaminan</td>
								<td align="right"><?php echo $dataDashCOM['COLLATERALS_TOTAL_COLLATERAL_VALUE_CURRENCY'];?><br><?php echo number_format($dataDashCOM['COLLATERALS_TOTAL_COLLATERAL_VALUE_VALUE'],0,',','.');?></td>
							</tr>
							<tr>
								<td style="vertical-align:top;">Nilai Jaminan Tertinggi</td>
								<td align="right"><?php echo $dataDashCOM['COLLATERALS_HIGHEST_COLLATERAL_VALUE_CURRENCY'];?><br><?php echo number_format($dataDashCOM['COLLATERALS_HIGHEST_COLLATERAL_VALUE_VALUE'],0,',','.');?></td>
							</tr>
							<tr>
								<td style="vertical-align:top;">Tipe Jaminan Dengan Nilai Tertinggi</td>
								<td align="right"><?php echo $dataDashCOM['COLLATERALS_HIGHEST_COLLATERAL_VALUE_TYPE'];?></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="header"><p class="name text-danger">Surat Berharga</p></div>
			<div class="content">
				<div class="row">
					<div class="col-md-4">
						<table>
							<tr>
								<td>
									<div class="box-green">
										<center><?php echo $dataDashCOM['SECURITY_NUMBER_OF_ACTIVE_SECURITIES'];?></center>
									</div>
								</td>
								<td style="vertical-align:middle;">Jumlah Surat Berharga Aktif</td>
							</tr>
						</table>
					</div>
					<div class="col-md-8"></div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="header"><p class="name text-danger">Tagihan Lainnya</p></div>
			<div class="content">
				<div class="row">
					<div class="col-md-4">
						<table>
							<tr>
								<td>
									<div class="box-green">
										<center><?php echo $dataDashCOM['OTHER_NUMBER_OF_OPEN_AGREEMENTS'];?></center>
									</div>
								</td>
								<td style="vertical-align:middle;">Jumlah Tagihan Berjalan</td>
							</tr>
						</table>
					</div>
					<div class="col-md-8"></div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="header"><p class="name text-danger">Penyertaan</p></div>
			<div class="content">
				<div class="row">
					<div class="col-md-4">
						<table>
							<tr>
								<td>
									<div class="box-green">
										<center><?php echo $dataDashCOM['INVOLEMENTS_NUMBER_OF_ACTIVE_INVOLMENTS'];?></center>
									</div>
								</td>
								<td style="vertical-align:middle;">Jumlah Penyertaan Aktif</td>
							</tr>
						</table>
					</div>
					<div class="col-md-8"></div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="header"><p class="name text-danger">Informasi pihak yang terkait dengan debitur</p></div>
			<div class="content">
				<div class="row">
					<div class="col-md-4">
						<table>
							<tr>
								<td>
									<div class="box-white">
										<center><?php echo $dataDashCOM['RELATIONS_NUMBER_OF_RELATIONS'];?></center>
									</div>
								</td>
								<td style="vertical-align:middle;">Jumlah Hubungan</td>
							</tr>
						</table>
					</div>
					<div class="col-md-4">
						<table>
							<tr>
								<td>
									<div class="box-white">
										<center><?php echo $dataDashCOM['RELATIONS_NUMBER_OF_INVOLVEMENTS'];?></center>
									</div>
								</td>
								<td style="vertical-align:middle;">Jumlah dari Penyertaan yang diketahui</td>
							</tr>
						</table>
					</div>
					<div class="col-md-4"></div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="header"><p class="name text-danger">PEFINDO Alert Quest (PAQ)</p></div>
			<div class="content">
				<div class="row">
					<div class="col-md-4">
						<table>
							<tr>
								<td>
									<div class="box-green">
										<center><?php echo $dataDashCOM['CIQ_FRAUD_ALERTS'];?></center>
									</div>
								</td>
								<td style="vertical-align:middle;">Jumlah PQ Fraud Alerts</td>
							</tr>
						</table>
					</div>
					<div class="col-md-4">
						<table>
							<tr>
								<td>
									<div class="box-white">
										<center><?php echo $dataDashCOM['CIQ_FRAUD_ALERTS_THIRD_PARTY'];?></center>
									</div>
								</td>
								<td style="vertical-align:middle;">Jumlah PQ Fraud Alerts Pihak Ketiga</td>
							</tr>
						</table>
					</div>
					<div class="col-md-4"></div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="header"><p class="name text-danger">Pengaduan</p></div>
			<div class="content">
				<div class="row">
					<div class="col-md-4">
						<table>
							<tr>
								<td>
									<div class="box-red">
										<center><?php echo $dataDashCOM['DISPUTES_ACTIVE_CONTRACT_DISPUTES'];?></center>
									</div>
								</td>
								<td style="vertical-align:middle;">Jumlah pengaduan yang belum diselesaikan</td>
							</tr>
						</table>
					</div>
					<div class="col-md-4">
						<table>
							<tr>
								<td>
									<div class="box-white">
										<center><?php echo $dataDashCOM['DISPUTES_FALSE_DISPUTES'];?></center>
									</div>
								</td>
								<td style="vertical-align:middle;">Jumlah pengaduan yang tidak sah di masa lalu</td>
							</tr>
						</table>
					</div>
					<div class="col-md-4">
						<table>
							<tr>
								<td>
									<div class="box-white">
										<center><?php echo $dataDashCOM['DISPUTES_NUMBER_OF_COURT_REGISTERED_DISPUTES'];?></center>
									</div>
								</td>
								<td style="vertical-align:middle;">Pengaduan di Pengadilan</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>