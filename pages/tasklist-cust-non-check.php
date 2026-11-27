<?php
require_once("config/configuration.php");
require_once("config/connection.php");
$date = date("Y-m-d");

if (isset($_POST['submit'])) {
    $startDate = $_POST['startDate'];
    $endDate   = $_POST['endDate'];
    $order_no  = $_POST['order_no'];
} else {
    $startDate = date("Y-m-01"); 
    $endDate   = date("Y-m-d");    
    $order_no  = '';
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
				<h4 class="title">TASKLIST SLIK</h4>
			</div>
			<div class="content">
				<div class="row">
					<form action="" method="post">
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
						<div class="col-md-3">
							<div class="form-group">
								<label>ORDER NO</label>
								<input type="text" class="form-control" name="order_no" id="order_no" value="<?php echo $order_no; ?>">
							</div>
						</div>
						<div class="col-md-2">
							&nbsp;<br>
							<button type="submit" class="btn btn-custom" name="submit" style="width:100%;">CARI</button>
							<br>
						</div>
					</form>
				</div>

				<div class="table-responsive">
					<table class="table table-bordered table-striped" id="history" style="font-size:10px;">
						<thead>
							<tr>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">ORDER NO</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">NAMA PEMOHON</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">KTP</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">STATUS</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 0;
							$call = "{call SP_TASKLIST_SLIK_CUST_NON_CHECKER(?,?,?,?)}";
							$param = array(
								array($startDate, SQLSRV_PARAM_IN), array($endDate, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN),
								array($order_no, SQLSRV_PARAM_IN)
							);
							$exec = sqlsrv_query($conn, $call, $param) or die(print_r(sqlsrv_errors(), true));

							while ($data = sqlsrv_fetch_array($exec)) {
								$no++;
							?>
								<tr>
									<td class="td-center"><?php echo $no; ?></td>
									<td><?php echo $data['ORDER_NO']; ?></td>
									<td class="td-center"><?php echo $data['NAMA_PEMOHON']; ?></td>
									<td><?php echo $data['KTP']; ?></td>
									<td><?php echo $data['STATUS_SLIK']; ?></td>                                    
									<td class="td-center">
                                        <a href="index.php?page=tasklist-cust-non-check-detail&USERNAME=<?php echo $user; ?>&order_no=<?php echo $data['ORDER_NO']; ?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
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