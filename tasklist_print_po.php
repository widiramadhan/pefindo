<?php
require_once("config/configuration.php");
require_once("config/connection.php");
$date = date("Y-m-d");

if (isset($_POST['submit'])) {
	$branch = $_POST['branch'];
	$prospect_no = $_POST['prospect_no'];
	$appno = $_POST['app_no'];
	$startDate = $_POST['startDate'];
	$endDate = $_POST['endDate'];
} else {
	$branch = "";
	$prospect_no = "";
	$appno = "";
	$startDate = date("Y-m-1");
	$endDate = date("Y-m-d");
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
				<h4 class="title">CETAK PO</h4>
				<p class="category">Cetak PO </p>
			</div>
			<div class="content">
				<div class="row">
					<form action="" method="post">
						<div class="col-md-3">
							<div class="form-group">
								<label>BRANCH</label>
								<select name="branch" class="form-control">
									<option value="">ALL BRANCH</option>
									<?php
									$call2 = "{call sp_COuserFindByBranchID (?)}";
									$param2 = array(array($_GET['USERNAME'], SQLSRV_PARAM_IN));
									$exec2 = sqlsrv_query($conn, $call2, $param2) or die(print_r(sqlsrv_errors(), true));
									while ($dataPO2 = sqlsrv_fetch_array($exec2)) {
									?>
										<option value="<?php echo $dataPO2['Branchid']; ?>" 
										<?php if ($dataPO2['Branchid'] == $branch) { 
											echo "selected"; 
										} ?>><?php echo $dataPO2['BranchName']; ?></option>
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
				</div>

				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label>Start Date</label>
							<div class="input-group date">
								<input type="text" class="form-control" name="startDate" id="startDate" autocomplete="off" value="<?php echo $startDate; ?>">
								<div class="input-group-addon">
									<span class="add-on"><i class="fa fa-calendar"></i></span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>End Date</label>
							<div class="input-group date">
								<input type="text" class="form-control" name="endDate" id="endDate" autocomplete="off" value="<?php echo $endDate; ?>">
								<div class="input-group-addon">
									<span class="add-on"><i class="fa fa-calendar"></i></span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						&nbsp;<br>
						<button type="submit" class="btn btn-custom" name="submit" style="width:100%;">CARI</button>
					</div>
				</div>
				</form>

				<div class="table-responsive">
					<table class="table table-bordered table-striped" id="history" style="font-size:10px;">
						<thead>
							<tr>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">BRANCH ID</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">BRANCH NAME</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">PROSPECT_NO</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">CUST NAME</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">STATUS APPROVAL RAK</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">PENGAJUAN</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 0;

							$callScore = "{call SP_TASKLIST_PO_RAK(?,?,?,?,?,?,?)}";
							$paramScore =  array(
								array($branch, SQLSRV_PARAM_IN),
								array($prospect_no, SQLSRV_PARAM_IN),
								array($appno, SQLSRV_PARAM_IN),
								array($user, SQLSRV_PARAM_IN),
								array($bid[0], SQLSRV_PARAM_IN),
								array($startDate, SQLSRV_PARAM_IN),
								array($endDate, SQLSRV_PARAM_IN)
							);
							$execScore = sqlsrv_query($conn, $callScore, $paramScore) or die(print_r(sqlsrv_errors(), true));

							while ($dataPO = sqlsrv_fetch_array($execScore)) {
								$no++;
							?>
								<tr>
									<td class="td-center"><?php echo $no; ?></td>
									<td class="td-center"><?php echo $dataPO['BRANCH_ID']; ?></td>
									<td class="td-center"><?php echo $dataPO['OFFICE_NAME']; ?></td>

									<td><?php echo $dataPO['APP_NO']; ?></td>
									<td><?php echo $dataPO['CUST_NAME']; ?></td>
									<td><?php echo $dataPO['FINAL_STATUS']; ?></td>
									<td><?php echo $dataPO['PENGAJUAN']; ?></td>
									<td class="td-center">
										<a href="cetak_po_tes.php?USERNAME=<?php echo $user; ?>&order=<?php echo $dataPO['PROSPECT_NO']; ?>" class="btn btn-custom btn-xs" target="_blank"><i class="fa fa-file"></i> Print Po</a>
										<a href="cetak_spp_bpkb.php?USERNAME=<?php echo $user; ?>&order=<?php echo $dataPO['PROSPECT_NO']; ?>" class="btn btn-custom btn-xs" target="_blank"><i class="fa fa-file"></i> BPKB</a>
									</td>
								</tr>
							<?php
							}

							$callPOCompany = "{call SP_RAK_CPY_TASKLIST_PO_RAK (?, ?, ?, ?, ?, ?)}";
							$paramPOCompany =  array(
								array($branch, SQLSRV_PARAM_IN),
								array($prospect_no, SQLSRV_PARAM_IN),
								array($appno, SQLSRV_PARAM_IN),
								array($startDate, SQLSRV_PARAM_IN),
								array($endDate, SQLSRV_PARAM_IN),
								array($user, SQLSRV_PARAM_IN)
							);
							$execPOCompany = sqlsrv_query($conn, $callPOCompany, $paramPOCompany) or die(print_r(sqlsrv_errors(), true));

							while ($dataPOCompany = sqlsrv_fetch_array($execPOCompany)) {
								$no++;
							?>
								<tr>
									<td class="td-center"><?php echo $no; ?></td>
									<td class="td-center"><?php echo $dataPOCompany['BRANCH_ID']; ?></td>
									<td class="td-center"><?php echo $dataPOCompany['OFFICE_NAME']; ?></td>
									<td><?php echo $dataPOCompany['APP_NO']; ?></td>
									<td><?php echo $dataPOCompany['CUST_NAME']; ?></td>
									<td><?php echo $dataPOCompany['FINAL_STATUS']; ?></td>
									<td><?php echo $dataPOCompany['PENGAJUAN']; ?></td>
									<td class="td-center">
										<a href="cetak-PO-company.php?USERNAME=<?php echo $user; ?>&ORDER_NO=<?php echo $dataPOCompany['PROSPECT_NO']; ?>" class="btn btn-custom btn-xs" target="_blank"><i class="fa fa-file"></i> Print PO</a>
										<a href="cetak-spp-bpkb-company.php?USERNAME=<?php echo $user; ?>&ORDER_NO=<?php echo $dataPOCompany['PROSPECT_NO']; ?>" class="btn btn-custom btn-xs" target="_blank"><i class="fa fa-file"></i> BPKB</a>
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