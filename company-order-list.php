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
				<p class="category">Silahkan pilih order yang akan di cek</p>
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
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Nomor Order</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Nomor Prospek</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">NPWP</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Nama Perusahaan</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$users = array('IMAN.SANTOSO','DJOKO.ANDREW','RAMANDONA','NOVRIKAWATI','KIKI.AMALIA','AHMAD.HABIBI','DENY.SAPUTRA','HARIS.SISWANTO','YOSE.KERTAPATI','MUHAMMAD','RAMANDONA.DINARA','JIMMY.SUJANA','RICKY.RANDHITA','HERBERTH.SIMBOLON','MOH.JUNAIDI.SIYAM');
									$isAllowedUser = in_array($_GET['USERNAME'], $users);

									$callGetOrder = "{call CPY_GET_ORDER_NUMBER_COMPANY}";
									$options =  array("Scrollable" => "buffered");
									$params = array();
									$execGetOrder = sqlsrv_query($conn, $callGetOrder, $params, $options) or die(print_r(sqlsrv_errors(), true));
									$no = 0;
									$i = 0;

									while ($row = sqlsrv_fetch_array($execGetOrder)) {
										$no++;
									?>
										<tr>
											<td class="td-custom" style="padding:5px;"><?php echo $no; ?></td>
											<td class="td-custom" style="padding:5px;"><?php echo $row['ORDER_NO']; ?></td>
											<td class="td-custom" style="padding:5px;"><?php echo $row['PROSPECT_NO']; ?></td>
											<td class="td-custom" style="padding:5px;"><?php echo $row['NPWP']; ?></td>
											<td class="" style="padding:5px;"><?php echo $row['CUST_NAME']; ?></td>
											<td class="td-custom" style="padding:5px;">
												<table align="center">
													<tr>
														<td>
															<form action="index.php?page=company-prospek-piloting&USERNAME=<?php echo $user; ?>" method="post">
																<input type="hidden" name="prospect_no" value="<?php echo $row['PROSPECT_NO']; ?>">
																<input type="hidden" name="order_no" value="<?php echo $row['ORDER_NO']; ?>">
																<button type="submit" name="select" class="btn btn-custom btn-sm"><i class="fa fa-search"></i> PILIH</button>
															</form>
														</td>
														<td>
															<?php if ($row['IS_DUKCAPIL_FINISH'] == '1' && $row['IS_CHECKED'] == '0') : ?>
																<form action="index.php?page=company-edit&USERNAME=<?php echo $user; ?>" method="post">
																	<input type="hidden" name="prospect_no" value="<?php echo $row['PROSPECT_NO']; ?>">
																	<input type="hidden" name="order_no" value="<?php echo $row['ORDER_NO']; ?>">
																	<input type="hidden" name="action" value="ACTION_CHECK">
																	<button type="submit" class="btn btn-custom btn-sm" style="margin-left: 1rem;"><i class="fa fa-pencil-square-o"></i> UPLOAD LEGAL OPINION (LO)</button>
																</form>
															<?php else : ?>
																<form action="#" method="post">
																	<button type="button" class="btn btn-custom btn-sm" style="margin-left: 1rem;" disabled><i class="fa fa-pencil-square-o" ></i> UPLOAD LEGAL OPINION (LO)</button>
																</form>
															<?php endif; ?>														
														</td>
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