<?php
require_once("config/configuration.php");
require_once("config/connection.php");
$date = date("Y-m-d");


if (isset($_POST['submit'])) {
	$branch = $_POST['branch'];
	$prospect_no = $_POST['prospect_no'];
	$appno = $_POST['app_no'];
} else {
	$branch = "";
	$prospect_no = "";
	$appno = "";
}

?>
<style>
	.th-custom {
		text-align: center;
		background-color: #035c7a;
	}

	.td-center {
		text-align: center;
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
				<h4 class="title">APPROVAL LOA RAK</h4>
				<p class="category">Tasklist</p>
			</div>
			<div class="content">
				<div class="row">
					<form action="" method="post">
						<div class="col-md-3">
							<div class="form-group">
								<label>BRANCH</label>
								<select name="branch" class="form-control">
									<option value="">ALL BRANCH</option>
									<!--<option value="">ALL BRANCH</option>-->
									<?php
									$call2 = "{call sp_COuserFindByBranchID (?)}";
									$param2 = array(array($_GET['USERNAME'], SQLSRV_PARAM_IN));
									$exec2 = sqlsrv_query($conn, $call2, $param2) or die(print_r(sqlsrv_errors(), true));
									while ($data2 = sqlsrv_fetch_array($exec2)) {
									?>
										<option value="<?php echo $data2['Branchid']; ?>" <?php if ($data2['Branchid'] == $branch) {
											echo "selected";
										} ?>><?php echo $data2['BranchName']; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>PROSPECT / ORDER NO</label>

								<input type="text" class="form-control" name="prospect_no" id="prospect_no" value="<?php echo $prospect_no; ?>">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>APP NO</label>

								<input type="text" class="form-control" name="app_no" id="app_no" value="<?php echo $appno; ?>">
							</div>
						</div>
						<div class="col-md-2">
							&nbsp;<br>
							<button type="submit" class="btn btn-custom" name="submit" style="width:100%;">CARI</button>
						</div>

					</form>
				</div>
				<div class="table-responsive">
					<table class="table table-bordered table-striped" id="history" style="font-size:10px;">
						<thead>
							<tr>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">BRANCH ID</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">BRANCH NAME</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">APP NO</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">APV_NO</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">STATUS APPROVAL</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">FINAL APPROVAL</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">STATUS UP DP</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 0;
							$call = "{call SP_TASKLIST_APPROVAL_LOA_RAK_USER(?,?,?,?)}";
							$param = array(
								array($branch, SQLSRV_PARAM_IN), array($prospect_no, SQLSRV_PARAM_IN),
								array($appno, SQLSRV_PARAM_IN),
								array($user, SQLSRV_PARAM_IN)
							);
							$exec = sqlsrv_query($conn, $call, $param) or die(print_r(sqlsrv_errors(), true));
							$app = substr($data['APP_NO'], 4, 3);

							while ($data = sqlsrv_fetch_array($exec)) {
								$no++;
								$app = substr($data['APP_NO'], 4, 3);
							?>
								<tr>
									<td class="td-center"><?php echo $no; ?></td>
									<td class="td-center"><?php echo $data['BRANCH_ID']; ?></td>
									<td class="td-center"><?php echo $data['OFFICE_NAME']; ?></td>

									<td><?php echo $data['APP_NO']; ?></td>
									<td><?php echo $data['APV_NO']; ?></td>
									<td><?php echo $data['FINAL_STATUS']; ?></td>
									<td><?php echo $data['FINAL_APPROVAL']; ?></td>

									<td><?php echo $data['UP_DP']; ?></td>

									<td class="td-center">
										<?php if ($data['ROLE_CODE'] == 'CA') { ?>
											<a href="index.php?page=detail-rak-ca-mos&USERNAME=<?php echo $user; ?>&prospect=<?php echo $data['PROSPECT_NO']; ?>&app=<?php echo $data['APP_NO']; ?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
										<?php } else if ($data['ROLE_CODE'] == 'BM' && $app == 'APP') { ?>
											<a href="index.php?page=detail-rak-bm&USERNAME=<?php echo $user; ?>&prospect=<?php echo $data['PROSPECT_NO']; ?>&app=<?php echo $data['APP_NO']; ?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
											<?php } else if ($data['ROLE_CODE'] == 'BM' && $app != 'APP') {
											if ($data['CONFINS_STEP'] == 'XXX') { ?>
												<a disabled class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
											<?php } else { ?>
												<a href="index.php?page=detail-rak-bm-mos&USERNAME=<?php echo $user; ?>&prospect=<?php echo $data['PROSPECT_NO']; ?>&app=<?php echo $data['APP_NO']; ?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
											<?php }
										} else if ($data['ROLE_CODE'] == 'AM' && $app == 'APP') { ?>
											<a href="index.php?page=detail-rak-am&USERNAME=<?php echo $user; ?>&prospect=<?php echo $data['PROSPECT_NO']; ?>&app=<?php echo $data['APP_NO']; ?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
											<?php } else if ($data['ROLE_CODE'] == 'AM' && $app != 'APP') {
											if ($data['CONFINS_STEP'] == 'XXX') { ?>
												<a disabled class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
											<?php } else { ?>
												<a href="index.php?page=detail-rak-am-mos&USERNAME=<?php echo $user; ?>&prospect=<?php echo $data['PROSPECT_NO']; ?>&app=<?php echo $data['APP_NO']; ?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
											<?php }
										} else if ($data['ROLE_CODE'] == 'CRDHO' && $app != 'APP') {
											if ($data['CONFINS_STEP'] == 'XXX') { ?>
												<a disabled class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
											<?php } else { ?>
												<a href="index.php?page=detail-rak-ho-mos&USERNAME=<?php echo $user; ?>&prospect=<?php echo $data['PROSPECT_NO']; ?>&app=<?php echo $data['APP_NO']; ?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
											<?php }
										} else if ($data['ROLE_CODE'] == 'CRDM' && $app != 'APP') {
											if ($data['CONFINS_STEP'] == 'XXX') { ?>
												<a disabled class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
											<?php } else { ?>
												<a href="index.php?page=detail-rak-ho-mos&USERNAME=<?php echo $user; ?>&prospect=<?php echo $data['PROSPECT_NO']; ?>&app=<?php echo $data['APP_NO']; ?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
											<?php }
										} else if ($data['ROLE_CODE'] == 'MKTM' && $app != 'APP') {
											if ($data['CONFINS_STEP'] == 'XXX') { ?>
												<a disabled class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
											<?php } else { ?>
												<a href="index.php?page=detail-rak-ho-mos&USERNAME=<?php echo $user; ?>&prospect=<?php echo $data['PROSPECT_NO']; ?>&app=<?php echo $data['APP_NO']; ?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
											<?php }
										} else if ($data['ROLE_CODE'] == 'MKTHO' && $app != 'APP') {
											if ($data['CONFINS_STEP'] == 'XXX') { ?>
												<a disabled class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
											<?php } else { ?>
												<a href="index.php?page=detail-rak-ho-mos&USERNAME=<?php echo $user; ?>&prospect=<?php echo $data['PROSPECT_NO']; ?>&app=<?php echo $data['APP_NO']; ?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
											<?php }
										} else if ($data['ROLE_CODE'] == 'GM' && $app != 'APP') {
											if ($data['CONFINS_STEP'] == 'XXX') { ?>
												<a disabled class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
											<?php } else { ?>
												<a href="index.php?page=detail-rak-ho-mos&USERNAME=<?php echo $user; ?>&prospect=<?php echo $data['PROSPECT_NO']; ?>&app=<?php echo $data['APP_NO']; ?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
											<?php }
										} else if ($data['ROLE_CODE'] == 'DGM' && $app != 'APP') {
											if ($data['CONFINS_STEP'] == 'XXX') { ?>
												<a disabled class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
											<?php } else { ?>
												<a href="index.php?page=detail-rak-ho-mos&USERNAME=<?php echo $user; ?>&prospect=<?php echo $data['PROSPECT_NO']; ?>&app=<?php echo $data['APP_NO']; ?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
											<?php }
										} else if ($data['ROLE_CODE'] == 'COO' && $app != 'APP') {
											if ($data['CONFINS_STEP'] == 'XXX') { ?>
												<a disabled class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
											<?php } else { ?>
												<a href="index.php?page=detail-rak-ho-mos&USERNAME=<?php echo $user; ?>&prospect=<?php echo $data['PROSPECT_NO']; ?>&app=<?php echo $data['APP_NO']; ?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
											<?php }
										} else if ($data['ROLE_CODE'] == 'VP' && $app != 'APP') {
											if ($data['CONFINS_STEP'] == 'XXX') { ?>
												<a disabled class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
											<?php } else { ?>
												<a href="index.php?page=detail-rak-ho-mos&USERNAME=<?php echo $user; ?>&prospect=<?php echo $data['PROSPECT_NO']; ?>&app=<?php echo $data['APP_NO']; ?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
											<?php }
										} else if ($data['ROLE_CODE'] == 'PD' && $app != 'APP') {
											if ($data['CONFINS_STEP'] == 'XXX') { ?>
												<a disabled class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
											<?php } else { ?>
												<a href="index.php?page=detail-rak-ho-mos&USERNAME=<?php echo $user; ?>&prospect=<?php echo $data['PROSPECT_NO']; ?>&app=<?php echo $data['APP_NO']; ?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>

											<?php }
										} else { ?>
											<a href="index.php?page=detail-rak-ho&USERNAME=<?php echo $user; ?>&prospect=<?php echo $data['PROSPECT_NO']; ?>&app=<?php echo $data['APP_NO']; ?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
										<?php } ?>
									</td>


								</tr>
							<?php
							}

							# tasklist approval company
							$callCpy = "{call SP_RAK_CPY_GET_TASKLIST_APPROVAL(?,?,?,?)}";
							$paramCpy = array(
								array($branch, SQLSRV_PARAM_IN), 
								array($prospect_no, SQLSRV_PARAM_IN),
								array($appno, SQLSRV_PARAM_IN),
								array($user, SQLSRV_PARAM_IN)
							);
							$execCpy = sqlsrv_query($conn, $callCpy, $paramCpy) or die(print_r(sqlsrv_errors(), true));

							$roleCabang = array("CA", "BM", "AM");
							$roleHO = array("CRDHO", "CRDM", "GM", "GM", "DGM", "COO", "VP", "PD");

							while ($dataCpy = sqlsrv_fetch_array($execCpy)) :
								$no++;
							?>
								<tr>
									<td class="td-center"><?php echo $no; ?></td>
									<td class="td-center"><?php echo $dataCpy['BRANCH_ID']; ?></td>
									<td class="td-center"><?php echo $dataCpy['OFFICE_NAME']; ?></td>

									<td><?php echo $dataCpy['PROSPECT_NO']; ?></td>
									<td><?php echo $dataCpy['APV_NO']; ?></td>
									<td><?php echo $dataCpy['FINAL_STATUS']; ?></td>
									<td><?php echo $dataCpy['FINAL_APPROVAL']; ?></td>

									<td><?php echo $dataCpy['UP_DP']; ?></td>

									<td class="td-center">
										<?php if ($dataCpy['CONFINS_STEP'] == 'XXX') : ?>
											<a disabled class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
										<?php else :
										
											if (in_array($dataCpy['ROLE_CODE'], $roleCabang, true) ) : ?>
											<a href="index.php?page=detail-rak-company-branch&USERNAME=<?= $user ?>&APV_NO=<?= $dataCpy['APV_NO'] ?>&ROLE_CODE=<?= $dataCpy['ROLE_CODE'] ?>&ID=<?= $dataCpy['ID'] ?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
										
											<?php elseif (in_array($dataCpy['ROLE_CODE'], $roleHO, true) ) : ?>
												<a href="index.php?page=detail-rak-company-HO&USERNAME=<?= $user ?>&APV_NO=<?= $dataCpy['APV_NO'] ?>&ROLE_CODE=<?= $dataCpy['ROLE_CODE'] ?>&ID=<?= $dataCpy['ID'] ?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>	
										<?php
											endif;
										endif;	
										?>
									</td>
								</tr>
							<?php endwhile; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$('#history').DataTable({
			"bPaginate": true,
			"bLengthChange": true,
			"bFilter": true,
			"bInfo": true
		});
		$('#startDate').datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			showButtonPanel: true,
			onClose: function(selectedDate) {
				$('#endDate').datepicker("option", "minDate", selectedDate);
			}
		});
		$('#endDate').datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			showButtonPanel: true,
			onClose: function(selectedDate) {
				$('#startDate').datepicker("option", "maxDate", selectedDate);
			}
		});
	});
</script>