<style>
	.th-custom {
		text-align: center;
		vertical-align: middle;
		background-color: #035c7a;
	}

	.td-custom {
		text-align: center;
		vertical-align: middle;
	}

	.pagination>li>a,
	.pagination>li>span {
		background-color: #FFF;
		color: #035c7a;
	}

	.pagination>li.active>a,
	.pagination>li.active>span {
		background-color: #035c7a;
		color: #FFF;
	}

	.pagination>li.active>a:hover,
	.pagination>li.active>span:hover {
		background-color: #035c7a;
		color: #FFF;
	}

	.pagination>li.focus>a,
	.pagination>li.focus>span:hover {
		background-color: #035c7a;
		color: #FFF;
	}

	.pagination>li.active>a.page-link,
	.pagination>li.active>span.page-link {
		background-color: #035c7a;
		color: #FFF;
	}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Data Company</h4>
				<p class="category">Silahkan pilih prospek yang akan di cek</p>
			</div>
			<hr>
			<div class="content">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table id="datatable" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">No</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Nomor Prospek</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">NPWP</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Nama Perusahaan</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$isAllowedUser = (strtoupper($_GET['USERNAME']) == 'IMAN.SANTOSO' || strtoupper($_GET['USERNAME']) == 'DJOKO.ANDREW'|| strtoupper($_GET['USERNAME']) == 'RAMANDONA' || strtoupper($_GET['USERNAME']) == 'NOVRIKAWATI' || strtoupper($_GET['USERNAME']) == 'KIKI.AMALIA' || strtoupper($_GET['USERNAME']) == 'AHMAD.HABIBI' || strtoupper($_GET['USERNAME']) == 'DENY.SAPUTRA' || strtoupper($_GET['USERNAME']) == 'HARIS.SISWANTO' || strtoupper($_GET['USERNAME']) == 'YOSE.KERTAPATI' || strtoupper($_GET['USERNAME']) == 'MUHAMMAD' || strtoupper($_GET['USERNAME']) == 'RAMANDONA.DINARA' || strtoupper($_GET['USERNAME']) == 'JIMMY.SUJANA' || strtoupper($_GET['USERNAME']) == 'RICKY.RANDHITA' || strtoupper($_GET['USERNAME']) == 'HERBERTH.SIMBOLON' || strtoupper($_GET['USERNAME']) == 'MOH.JUNAIDI.SIYAM');
									////$isAllowedUser = ($_GET['USERNAME'] == 'iman.santoso' || $_GET['USERNAME'] == 'djoko.andrew' || $_GET['USERNAME'] == 'ramandona' || $_GET['USERNAME'] == 'IMAN.SANTOSO' || $_GET['USERNAME'] == 'DJOKO.ANDREW' || $_GET['USERNAME'] == 'RAMANDONA' || $_GET['USERNAME'] == 'NOVRIKAWATI' || $_GET['USERNAME'] == 'KIKI.AMALIA' || $_GET['USERNAME'] == 'novrikawati' || $_GET['USERNAME'] == 'kiki.amalia' || $_GET['USERNAME'] == 'AHMAD.HABIBI' || $_GET['USERNAME'] == 'DENY.SAPUTRA' || $_GET['USERNAME'] == 'Haris.Siswanto' || $_GET['USERNAME'] == 'HARIS.SISWANTO' || $_GET['USERNAME'] == 'Yose.Kertapati' || $_GET['USERNAME'] == 'YOSE.KERTAPATI'    || $_GET['USERNAME'] == 'Muhammad' || $_GET['USERNAME'] == 'MUHAMMAD' || $_GET['USERNAME'] == 'Ramandona.Dinara' || $_GET['USERNAME'] == 'RAMANDONA.DINARA' || $_GET['USERNAME'] == 'Jimmy.Sujana' || $_GET['USERNAME'] == 'JIMMY.SUJANA' || $_GET['USERNAME'] == 'Ricky.Randhita' || $_GET['USERNAME'] == 'RICKY.RANDHITA' || $_GET['USERNAME'] == 'Herberth.Simbolon' || $_GET['USERNAME'] == 'HERBERTH.SIMBOLON' || $_GET['USERNAME'] == 'Moh.Junaidi.Siyam' || $_GET['USERNAME'] == 'MOH.JUNAIDI.SIYAM');

									$callGetProspect = "{call CPY_GET_PROSPEK_NUMBER_COMPANY}";
									$options =  array("Scrollable" => "buffered");
									$params = array();
									$execGetProspect = sqlsrv_query($conn, $callGetProspect, $params, $options) or die(print_r(sqlsrv_errors(), true));
									$num_rows = sqlsrv_num_rows($execGetProspect);
									$no = 0;
									$i = 0;

									while ($rowGetProspect = sqlsrv_fetch_array($execGetProspect)) {
										$no++;
										$percent = intval($i / $num_rows * 100) . "%";
									?>
										<tr>
											<td class="td-custom" style="padding:5px;"><?php echo $no; ?></td>
											<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspect['PROSPECT_NO']; ?></td>
											<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspect['NPWP']; ?></td>
											<td class="" style="padding:5px;"><?php echo $rowGetProspect['CUST_NAME']; ?></td>
											<td class="td-custom" style="padding:5px;">
												<table align="center">
													<tr>
														<td>
															<form action="index.php?page=company-prospek-piloting&USERNAME=<?php echo $user; ?>" method="post">
																<input type="hidden" name="prospect_no" value="<?php echo $rowGetProspect['PROSPECT_NO']; ?>">
																<input type="hidden" name="npwp" value="<?php echo $rowGetProspect['NPWP']; ?>">
																<input type="hidden" name="name" value="<?php echo $rowGetProspect['CUST_NAME']; ?>">
																<button type="submit" name="select" class="btn btn-custom btn-sm"><i class="fa fa-search"></i> PILIH</button>
															</form>
														</td>
														<?php if ($isAllowedUser) : ?>

															<!-- Hanya user yang diberi akses -->
															<?php if ($rowGetProspect["SUB_PARAM_ID"] == "28") : ?>

																<!-- Sudah FINISH status Cek Pefindo -->
																<td style="padding-left:10px;">

																	
																	<?php if ($rowGetProspect["IS_SLIK_EXIST"] == "1") : ?>
																		<!-- Sudah memiliki SLIK -->
																		<form action="#" method="post">
																			<button type="submit" name="select" class="btn btn-custom btn-sm" disabled><i class="fa fa-pencil"></i> OPEN CEK SLIK</button>
																		</form>

																	<?php elseif ($rowGetProspect["IS_SLIK_EXIST"] == "0") : ?>
																		<!-- Belum memiliki SLIK -->
																		<form action="company-request-open-slik.php" method="post">
																			<input type="hidden" name="prospect_no" value="<?php echo $rowGetProspect['PROSPECT_NO']; ?>">
																			<input type="hidden" name="npwp" value="<?php echo $rowGetProspect['NPWP']; ?>">
																			<input type="hidden" name="user" value="<?php echo $user; ?>">
																			<button type="submit" name="select" class="btn btn-custom btn-sm"><i class="fa fa-pencil"></i> OPEN CEK SLIK</button>
																		</form>
																	<?php endif; ?>
																</td>
															<?php elseif (!is_null($rowGetProspect["SUB_PARAM_ID"])) : ?>
																<td style="padding-left:10px;">
																	<form action="#" method="post">
																		<button type="submit" name="select" class="btn btn-custom btn-sm" disabled><i class="fa fa-pencil"></i> OPEN CEK SLIK</button>
																	</form>
																</td>
															<?php endif; ?>
														<?php endif; ?>
													</tr>
												</table>
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
<script>
	$(document).ready(function() {
		$('#datatable').DataTable({
			/*"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "data.php",
			"aoColumns": [
			  null,
			  null,
			  null,
			  {
				"mData": "0", <!-- Ini adalah untuk Link ID urutan kolom seperti table mulai dari 0 untuk data pertama -->
				"mRender": function ( data, type, full ) {
					return '<a href="#" onclick="alert(\'ID adalah = '+data+'\')"><span class="label label-primary">Link ID<span></a>';
				  }
			  }
			]*/
		});
	});
</script>