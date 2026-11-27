<?php
require_once("config/configuration.php");
require_once("config/connection.php");
$date = date("Y-m-d");

if (isset($_POST['submit'])) {
    $startDate = $_POST['startDate'];
    $endDate   = $_POST['endDate'];
} else {
    $startDate = date("Y-m-01"); 
    $endDate   = date("Y-m-d");  
}

$user     = isset($_GET['USERNAME']) ? $_GET['USERNAME'] : '';
$order_no  = isset($_GET['order_no']) ? $_GET['order_no'] : '';

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
						<div class="col-md-2">
							&nbsp;<br>
							<button type="submit" class="btn btn-custom" name="submit" style="width:100%;">CARI</button>
							<br>
						</div>
					</form>
				</div>

                <div class="row">
                    <div class="col-md-3">
                        &nbsp;
                        <a href="index.php?page=cust-non-checker&USERNAME=<?php echo $user; ?>&prospect=<?php echo $order_no; ?>" 
                        class="btn btn-custom" 
                        style="width:100%;">
                            Tambah Penjamin
                        </a>
                        <br>
                        <br>
                    </div>
                </div>

				<div class="table-responsive">
					<table class="table table-bordered table-striped" id="history" style="font-size:10px;">
						<thead>
							<tr>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">NAMA PENJAMIN</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">KTP</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>
							</tr>
						</thead>
                        <tbody>
                            <?php
                            $no = 0;
                            $call = "{call SP_TASKLIST_SLIK_CUST_NON_CHECKER_DETAIL(?,?,?,?)}";
                            $param = array(
                                array($startDate, SQLSRV_PARAM_IN),
                                array($endDate, SQLSRV_PARAM_IN),
                                array($user, SQLSRV_PARAM_IN),
                                array($order_no, SQLSRV_PARAM_IN)
                            );
                            $exec = sqlsrv_query($conn, $call, $param) or die(print_r(sqlsrv_errors(), true));

                            while ($data = sqlsrv_fetch_array($exec)) {
                                $no++;

                                $nama_penjamin = $data['NAMA_PENJAMIN_TAMBAHAN'];
                                $no_ktp = $data['NO_KTP'];
                                $mapping_id = $data['PEFINDO_MAPPING_ID'];
                            ?>
                                <tr>
                                    <td class="td-center"><?php echo $no; ?></td>
                                    <td class="td-center"><?php echo $nama_penjamin; ?></td>
                                    <td class="td-center"><?php echo $no_ktp; ?></td>
                                    <td class="td-center">
                                        <?php if (!empty($mapping_id)) { ?>
                                            <a href="index.php?page=cust-non-checker-detail&USERNAME=<?php echo $user; ?>&order_no=<?php echo $order_no; ?>&no_ktp=<?php echo $no_ktp; ?>"
                                                class="btn btn-custom btn-xs" style="margin-bottom:3px;">
                                                <i class="fa fa-eye"></i> DETAIL
                                            </a>
                                            <a href="index.php?page=summary-slik&USERNAME=<?php echo $user; ?>&order_no=<?php echo $order_no; ?>&no_ktp=<?php echo $no_ktp; ?>&mapping_id=<?php echo $mapping_id; ?>"
                                                class="btn btn-custom btn-xs" style="margin-bottom:3px;">
                                                <i class="fa fa-eye"></i> SUMMARY SLIK
                                            </a>
                                            <a href="index.php?page=slik-detail-new&USERNAME=<?php echo $user; ?>&no=<?php echo $order_no; ?>&custtype=ADDITIONAL&id=<?php echo $mapping_id; ?>"
                                                class="btn btn-custom btn-xs">
                                                <i class="fa fa-eye"></i> DETAIL SLIK
                                            </a>
                                        <?php } else { ?>
                                            <a href="index.php?page=cust-non-checker&USERNAME=<?php echo $user; ?>&prospect=<?php echo $order_no; ?>&no_ktp=<?php echo $no_ktp; ?>"
                                                class="btn btn-custom btn-xs">
                                                <i class="fa fa-pencil"></i> Lanjut isi data penjamin
                                            </a>
                                        <?php } ?>
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