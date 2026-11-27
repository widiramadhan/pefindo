<?php
$prospek = $_GET['no'];

// $call1 = "{call PEFINDO_GETDATA_PASANGAN_1(?)}";
// $param1 = array(array($prospek, SQLSRV_PARAM_IN));
// $exec1 = sqlsrv_query($conn, $call1, $param1) or die(print_r(sqlsrv_errors(), true));
// $data1 = sqlsrv_fetch_array($exec1);

// $callGetProspect = "{call SP_GET_PROSPEK_NUMBER_TASKLIST(?)}";
// $options =  array("Scrollable" => "buffered");
// $param31 = array(array($data1['PROSPECT_NO'], SQLSRV_PARAM_IN));
// $execGetProspect = sqlsrv_query($conn, $callGetProspect, $param31, $options) or die(print_r(sqlsrv_errors(), true));
// $data31 = sqlsrv_fetch_array($execGetProspect);

// if ($data1['Pasangan_Noktp'] == "" || $data1['Pasangan_Noktp'] == NULL) {
// 	$siapanih = "Penjamin";
// 	$ktpsaya = $data1['Penjamin_Noktp'];
// 	$namasaya = $data1['Penjamin_Nama'];
// 	$tgllahirsaya = $data1['Penjamin_TglLahir'];
// 	$tempatlahirsaya = $data1['Penjamin_TempatLahir'];
// } else {
// 	$siapanih = "Pasangan";
// 	$ktpsaya = $data1['Pasangan_Noktp'];
// 	$namasaya = $data1['Pasangan_Nama'];
// 	$tgllahirsaya = $data1['Pasangan_TglLahir'];
// 	$tempatlahirsaya = $data1['Pasangan_TempatLahir'];
// }
?>
<style>
	.th-custom {
		text-align: center;
		font-weight: bold;
		background-color: #035c7a;
	}

	.td-center {
		text-align: center;
	}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">PROSPEK GROUP / ORDER GROUP</h4>
				<p class="category">Nomor Prospek : <?php echo $prospek; ?></p>
			</div>
			<hr>
			<div class="content">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table id="datatable" class="table table-bordered" style="width:100%;font-size:10px;">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">No</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Nomor Identitas</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Nama PT & Pengurus</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Tipe</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Create Date</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Status</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 0;
									$call = "{call CPY_PROSPEK_GROUP(?)}";
									$param = array(array($prospek, SQLSRV_PARAM_IN));
									$options =  array("Scrollable" => "buffered");
									$exec = sqlsrv_query($conn, $call, $param, $options) or die(print_r(sqlsrv_errors(), true));
									while ($data = sqlsrv_fetch_array($exec)) {
										$no++;

										// $call5 = "{call PEFINDO_GETDATA_SCORING_SOURCEBY(?,?)}";
										// $param5 = array(
										// 	array($prospek, SQLSRV_PARAM_IN),
										// 	array($data['ID_NO'], SQLSRV_PARAM_IN)
										// );
										// $options5 =  array("Scrollable" => "buffered");
										// $exec5 = sqlsrv_query($conn, $call5, $param5, $options5) or die(print_r(sqlsrv_errors(), true));
										// $data5 = sqlsrv_fetch_array($exec5)
									?>
										<tr>
											<td class="td-center"><?php echo $no; ?></td>
											<td class="td-center"><?php echo $data['ID_NO']; ?></td>
											<td class="td-center"><?php echo $data['CUST_NAME']; ?></td>
											<?php
											$tipe = $data['TIPE_CUST'];
											$seq = $data['SEQ_ID'];
											$cust_type = "{$tipe} {$seq}";
											?>
											<td class="td-center"><?php echo $cust_type; ?></td>
											<?php if ($data['CREATE_DATE'] <> NULL) {
												$created = $data['CREATE_DATE']->format("Y-m-d H:i:s");
											} else {
												$created = "-";
											} ?>
											<td class="td-center"><?php echo $created; ?></td>
											<td class="td-center">
												<?php
												$paramId = $data['SUB_PARAM_ID'];
												if ($paramId == "21" || $paramId == "26") {
													echo "<span class='badge' style='background-color:#d9534f;'>OPEN</span>";
												} else if ($paramId == "22" || $paramId == "27") {
													echo "<span class='badge' style='background-color:#428bca;'>ON PROGRESS</span>";
												} else if ($paramId == "23" || $paramId == "28") {
													echo "<span class='badge' style='background-color:#5cb85c;'>FINISH</span>";
												} else if ($paramId == "24" || $paramId == "29") {
													echo "<span class='badge' style='background-color:#ffc107;'>REJECT</span>";
												}
												?>
											</td>
											<td class="td-center">
												<div class="dropdown">
													<button class="btn btn-custom btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
														<span class="caret"></span></button>
													<ul class="dropdown-menu">

														<?php

														// // if ($paramId == "21" || $paramId == "22") {
														// // 	echo '<li><a href="#" disabled style="pointer-events:none;color:#AAA">Input Hasil SLIK</a></li>';
														// // } else 

														if ($paramId == "23") {
															echo '<li><a href="index.php?USERNAME=' . $user . '&page=slik-detail-new-company&no=' . $data['PROSPECT_NO'] . '&custtype=' . $data['TIPE_CUST'] . '&id=' . $data['PEFINDO_MAPPING_ID'] . '">Hasil SLIK</a></li>';
														} else if ($paramId == "24") {
															echo '<li><a href="index.php?page=note-detail-company&USERNAME=' . $user . '&id=' . $data['PEFINDO_MAPPING_ID'] . '">Detail</a></li>';
														} else if ($paramId == "28") {

															# Cari pefindo ID yang masih berlaku, agar ketika di-cek scoring akan menampilkan halaman scoring saja
															$callActiveId = "{call SP_CHECK_PEFINDO_ID(?,?,?,?)}";
															$paramsActiveId = array(
																array('', SQLSRV_PARAM_IN),
																array($prospek, SQLSRV_PARAM_IN),
																array($data['ID_NO'], SQLSRV_PARAM_IN),
																array(date("Ymd"), SQLSRV_PARAM_IN)
															);
															$optionsActiveId =  array("Scrollable" => "buffered");
															$execActiveId = sqlsrv_query($conn, $callActiveId, $paramsActiveId, $optionsActiveId) or die(print_r(sqlsrv_errors(), true));
															$dataActiveId = sqlsrv_fetch_array($execActiveId);
															//var_dump($dataActiveId);

															if ($tipe == "COMPANY")
															{
																echo '<li><a href="index.php?page=scoring-company-piloting&USERNAME=' . $user . '&id=' . $dataActiveId['PEFINDO_MAPPING_ID'] . '&no=' . $data['PROSPECT_NO'] . '">Hasil Scoring</a></li>';
															}
															elseif ($tipe == "PENGURUS")
															{
																echo '<li><a href="index.php?page=scoring-individual&USERNAME=' . $user . '&id=' . $dataActiveId['PEFINDO_MAPPING_ID'] . '&prospect_no=' . $data['PROSPECT_NO'] . '">Hasil Scoring</a></li>';
															}
														}

														if ($_GET['USERNAME'] == 'iman.santoso' || $_GET['USERNAME'] == 'djoko.andrew' || $_GET['USERNAME'] == 'ramandona' || $_GET['USERNAME'] == 'IMAN.SANTOSO' || $_GET['USERNAME'] == 'DJOKO.ANDREW' || $_GET['USERNAME'] == 'RAMANDONA' || $_GET['USERNAME'] == 'LUDY.HARDIYAN' || $_GET['USERNAME'] == 'KIKI.AMALIA' || $_GET['USERNAME'] == 'novrikawati' || $_GET['USERNAME'] == 'kiki.amalia' || $_GET['USERNAME'] == 'AHMAD.HABIBI' || $_GET['USERNAME'] == 'DENY.SAPUTRA' || $_GET['USERNAME'] == 'Haris.Siswanto' || $_GET['USERNAME'] == 'HARIS.SISWANTO' || $_GET['USERNAME'] == 'Yose.Kertapati' || $_GET['USERNAME'] == 'YOSE.KERTAPATI'	|| $_GET['USERNAME'] == 'Muhammad' || $_GET['USERNAME'] == 'MUHAMMAD' || $_GET['USERNAME'] == 'Ramandona.Dinara' || $_GET['USERNAME'] == 'RAMANDONA.DINARA') {
															if ($paramId == "21" || $paramId == "22") {
																// // if (strtoupper($tipe) == "PENGURUS") {
																// // 	echo '<li><a href="index.php?page=detail-informasi-company&USERNAME=' . $user .
																// // 		'&id=' . $data['PEFINDO_MAPPING_ID'] .
																// // 		'&prospect_no=' . $data['PROSPECT_NO'] .
																// // 		'&id_no=' . $data['ID_NO'] .
																// // 		'&name=' . $data['CUST_NAME'] .
																// // 		'&ack_date=' . $data['ACK_DT']->format('Y-m-d') .
																// // 		'&ack_place=' . $data['ACK_PLACE'] .
																// // 		'&tipe_cust=' . $data['TIPE_CUST'] . '">Proses</a></li>';
																// // } else if (strtoupper($tipe) == "COMPANY") {
																// // 	echo '<li><a href="index.php?page=detail-informasi-company&USERNAME=' . $user .
																// // 		'&id=' . $data['PEFINDO_MAPPING_ID'] .
																// // 		'&prospect_no=' . $data['PROSPECT_NO'] .
																// // 		'&id_no=' . $data['ID_NO'] .
																// // 		'&name=' . $data['CUST_NAME'] .
																// // 		'&ack_date=' . $data['ACK_DT']->format('Y-m-d') .
																// // 		'&ack_place=' . $data['ACK_PLACE'] .
																// // 		'&tipe_cust=' . $data['TIPE_CUST'] . '">Proses</a></li>';
																// // }
																echo '<li><a href="index.php?page=detail-informasi-company&USERNAME=' . $user .
																	'&id=' . $data['PEFINDO_MAPPING_ID'] .
																	'&prospect_no=' . $data['PROSPECT_NO'] .
																	'&id_no=' . $data['ID_NO'] .
																	'&name=' . $data['CUST_NAME'] .
																	'&ack_date=' . $data['ACK_DT']->format('Y-m-d') .
																	'&ack_place=' . $data['ACK_PLACE'] .
																	'&tipe_cust=' . $data['TIPE_CUST'] . '">Proses</a></li>';
															} else if ($paramId == "23") {
																echo '<li><a href="#" disabled style="pointer-events:none;color:#AAA">Selesai</a></li>';
															} else if ($paramId == "24") {
																echo '<li><a href="#" disabled style="pointer-events:none;color:#AAA">Proses</a></li>';
															}
														}
														?>
													</ul>
												</div>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
<script>
	function alertdukcapilPenjamin() {
		if (confirm('Apakah anda yakin ingin mengecek data ini? Pengecekan akan dikenakan biaya dan tercatat di log')) {
			document.getElementById('formJaminanDukcapil').submit();
		};
	}

	function alertdukcapilPemohon() {
		if (confirm('Apakah anda yakin ingin mengecek data ini? Pengecekan akan dikenakan biaya dan tercatat di log')) {
			document.getElementById('formPemohonDukcapil').submit();
		};
	}

	function formPemohon() {
		document.getElementById('formPemohon').submit();

	}

	function formJaminan() {
		document.getElementById('formJaminan').submit();

	}
</script>