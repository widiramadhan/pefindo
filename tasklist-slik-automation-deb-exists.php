<?php
require_once("config/configuration.php");
require_once("config/connection.php");
$date = date("Y-m-d");

$callCount = "{call SP_GET_COUNT_TASK_SLIK_AUTOMATION_DEB_EXISTS}";
$execCount = sqlsrv_query($conn, $callCount) or die(print_r(sqlsrv_errors(), true));
$dataCount = sqlsrv_fetch_array($execCount);


$callCount1 = "{call SP_GET_COUNT_TASK_SLIK_AUTOMATION_DEB_EXISTS_PARTIAL}";
$execCount1 = sqlsrv_query($conn, $callCount1) or die(print_r(sqlsrv_errors(), true));
$dataCount1 = sqlsrv_fetch_array($execCount1);

if (isset($_POST['submit'])) {
	// $startDate = $_POST['startDate'];
	// $endDate = $_POST['endDate'];
	$status = $_POST['status'];
	$cust_type = $_POST['cust_type'];
	// $tipe = $_POST['tipe'];
} else {
	// $startDate = date("Y-m-01");
	// $endDate = date("Y-m-d");
	$cust_type = '';
	// $status = "ON PROGRESS"; //testing purpose
	$status = "OPEN"; //default
	// $tipe = "";
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
				<p class="category">Debitur <span style="font-style: italic;">Existing</span></p>
			</div>
			<div class="content">
				<div class="row">
					<div class="col-md-2 text-center">
						<div class="card">
							<label>TASK SLIK OPEN</label>
							<br>
							<span style="font-size: x-large;"><?php echo $dataCount['COUNT_OPEN']; ?></span>

						</div>
					</div>
					<div class="col-md-2 text-center">
						<div class="card">
							<label>TASK SLIK ON PROGRESS</label>
							<br>
							<span style="font-size: x-large;"><?php echo $dataCount['COUNT_ONPROG']; ?></span>

						</div>
					</div>
					<div class="col col-md-8 text-right">
						<a href="index.php?USERNAME=<?php echo $_GET['USERNAME']; ?>&page=tasklist-slik-automation" class="btn btn-primary" type="button" title="OPEN TASK ">
							Slik Reguler <span class="badge">1</span>
						</a>
					</div>
					
				</div>
				<hr>
				<div class="row">
					<form action="" method="post">
						<div class="col-md-2">
							<div class="form-group">
								<label>STATUS</label>
								<select name="status" class="form-control" id="status">
									<option value="" <?= ('' == $status) ? "selected" : "" ?>>ALL STATUS</option>
									<option value="OPEN" <?= ('OPEN' == $status) ? "selected" : "" ?>>OPEN</option>
									<option value="ON PROGRESS" <?= ('ON PROGRESS' == $status) ? "selected" : "" ?>>ON
										PROGRESS</option>
								</select>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Cust Type</label>
								<select name="cust_type" class="form-control" id="cust_type">
									<option value="" <?= ('' == $status) ? "selected" : "" ?>>All</option>
									<option value="1" <?= ('1' == $status) ? "selected" : "" ?>>Pemohon</option>
									<option value="2" <?= ('2' == $status) ? "selected" : "" ?>>Pasangan</option>
									<option value="3" <?= ('3' == $status) ? "selected" : "" ?>>Penjamin</option>
									<option value="4" <?= ('4' == $status) ? "selected" : "" ?>>Pengurus</option>
								</select>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label for="">&nbsp</label>
								<button type="submit" class="btn btn-custom" name="submit" id="submit-cari" style="width:100%;">CARI</button>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label for="">&nbsp</label>
							
							<button class="btn btn-custom" name="downloadTxt" id="downloadTxt" style="width:100%;"> DOWNLOAD TXT </button>
								<!-- <a name="downloadTxt" id="downloadTxt" href="txt_slik_automation_existing.php?USERNAME=<?= $_GET['USERNAME'] . '&CUST_TYPE=' . $cust_type . '&STATUS=' . $status ?>" class="btn btn-custom" style="width:100%;" target="_blank"> DOWNLOAD TXT</a> -->
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label for="">&nbsp</label>
								<button class="btn btn-custom" name="button_check" id="button_check" style="width:100%;"> CHECK </button>
								<!-- <a href="test_upload_exist.php?USERNAME=<?php //echo $user; ?>" id="button_check" class="btn btn-custom" style="width:100%;"></i> CHECK</a> -->
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>&nbsp</label>
								<div class="dropdown ">
									<button class="btn btn-custom dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
										RESULT
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
										<li><a class="resultButton" id="0">OPEN</a></li>
										<li><a class="resultButton" id="2">TIDAK DITEMUKAN</a></li>
									</ul>
								</div>
							</div>
						</div>
					</form>
				</div>
				<hr>
				<form action="result_slik_marks.php?USERNAME=<?php echo $_GET['USERNAME']; ?>" method="post" id="massiveResultForm">
					<input type="hidden" name="masiveResultExist" id="masiveResult">
					<div class="table-responsive">
						<table class="table table-bordered table-striped" id="history" style="font-size:10px;">
							<thead>
								<tr>
									<th class="th-custom" style="color:#FFF;font-weight:bold;">
										<input type="checkbox" name="checkAll" id="checkAll">
									</th>
									<th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
									<th class="th-custom" style="color:#FFF;font-weight:bold;">NO GENERATE</th>
									<th class="th-custom" style="color:#FFF;font-weight:bold;">NO REGIST</th>
									<th class="th-custom" style="color:#FFF;font-weight:bold;">SUBJECT TYPE</th>
									<th class="th-custom" style="color:#FFF;font-weight:bold;">NO IDENTITAS</th>
									<th class="th-custom" style="color:#FFF;font-weight:bold;">NAMA</th>
									<th class="th-custom" style="color:#FFF;font-weight:bold;">TEMPAT LAHIR/PENDIRIAN</th>
									<th class="th-custom" style="color:#FFF;font-weight:bold;">TANGGAL LAHIR/PENDIRIAN</th>
									<th class="th-custom" style="color:#FFF;font-weight:bold;">TUJUAN PERMINTAAN</th>
									<th class="th-custom" style="color:#FFF;font-weight:bold;">STATUS</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$no = 0;
								$call = "{call SP_GET_TASKLIST_SLIK_AUTOMATION_DEB_EXISTS(?,?)}";
								$param = array(
									array($status, SQLSRV_PARAM_IN),
									array($cust_type, SQLSRV_PARAM_IN)
								);
								$exec = sqlsrv_query($conn, $call, $param) or die(print_r(sqlsrv_errors(), true));
								$custtype = 'PEMOHON';
								while ($data = sqlsrv_fetch_array($exec)) {
									$no++;
								?>
									<tr>
										<td class="td-center">
											<input type="checkbox" class="rowCheckbox" name="idSlik[]" id="idSlik[]" value="<?= $data['TASKLIST_SLIK_CHECK_ID'] ?>">
											<input type="hidden" name="tipeSlik[]" value="<?php echo $data['TIPE']; ?>">
										</td>
										<td class="td-center"><?php echo $no; ?></td>
										<td><?php echo $data['IDEB_NO']; ?></td>
										<td><?php echo $data['NOMOR_REGIST']; ?></td>
										<td class="td-center"><?php echo $data['SUBJECT_TYPE']; ?></td>
										<td><?php echo $data['ID_NO']; ?></td>
										<td><?php echo $data['NAMA']; ?></td>
										<td><?php echo $data['BIRTH_PLACE']; ?></td>
										<td><?php echo $data['BIRTH_DATE'] ? $data['BIRTH_DATE']->format("d F Y") : ''; ?></td>
										<td><?php echo $data['TIPE']; ?></td>
										<td class="td-center">
											<?php
											switch ($data['STAT_ID1']) {
												case '0':
													$color = 'background-color:#d9534f;';
													break;
												case '1':
													$color = 'background-color:#428bca;';
													break;
												case '2':
													$color = 'background-color:#5cb85c;';
													break;
												case '3':
													$color = 'background-color:#ffc107;';
													break;

												default:
													$color = 'background-color:#000;';
													break;
											}
											echo "<span class='badge' title='" . $data['STATUS'] . "' style='" . $color . "'>" . $data['STAT_ID1'] . "</span>";
											?>
										</td>
									</tr>
								<?php
								}
								?>
							</tbody>
						</table>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<!-- Modal -->
<!--
<div class="modal" id="myModal" role="dialog" tabindex="-1">
	<div class="modal-dialog">
-->
		<!-- Modal content
	
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title text-center">Downloading...</h4>
			</div>
			<div class="modal-body h-100">
				<div class="row">
					<span class="mr-3"><i class="pe-7s-refresh-2 progressDownload"></i><i class="pe-7s-check doneDownload text-success" style="display: none;"></i></span>
					<span id="downloadedFiles">0</span>
					<span id="totalFiles">/ <? //= ceil($dataCount1['COUNT_OPEN'] / 100); ?> Files</span>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" id="closeRefresh">Close and Refresh</button>
			</div>
		</div>

	</div>
</div>
-->
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
		actionButtonToggle();

		$('#status').on('input', function() {
			actionButtonToggle();
		});
		
		$('#downloadTxt').on('click', function(event) {
			
			event.preventDefault()
			this.disabled = true
			window.open(`txt_slik_automation_existing.php?USERNAME=<?= $_GET['USERNAME'] . '&CUST_TYPE=' . $cust_type . '&STATUS=' . $status ?>`, '_blank')
			window.setTimeout(function() {
				$('#submit-cari').click();
			}, 4000);
		});

			$('#button_check').on('click', function(event) {
			
			event.preventDefault()
			this.disabled = true
			window.open(`test_upload_exist.php?USERNAME=<?php echo $user; ?>`, '_blank')
		
		});
		//checkall
		$('#checkAll').on('change', function() {
			$('.rowCheckbox').prop('checked', $(this).prop('checked'))
		})

		//submit check
		$('.resultButton').on('click', function(e) {
			let buttonId = e.target.id;
			var selectedRows = [];
			// alert('ok');
			$('.rowCheckbox:checked').each(function() {
				var rowData = $(this).val();
				selectedRows.push(rowData);
				// alert(rowData);
			})

			if (selectedRows.length == 0) {
				alert('kosong')
			} else {
				console.log(selectedRows, buttonId);
				$('#masiveResult').val(buttonId);
				$('#massiveResultForm').submit();
			}
		});


		///////
		$('#closeRefresh').click(function() {
			$('#closeRefresh').data('terminate', true); // Set terminate flag to true
			window.setTimeout(function() {
				$('#submit-cari').click();
			}, 2000);
		});

	});

	function actionButtonToggle() {
		let status = $('#status').val();
		switch (status) {
			case 'OPEN':
				$('#downloadTxt').show();
				$('#dropdownMenu1').hide();
				$('#button_check').hide();
				break;
			case 'ON PROGRESS':
				$('#downloadTxt').hide();
				$('#dropdownMenu1').show();
				$('#button_check').show();
				break;

			default:
				$('#downloadTxt').hide();
				$('#dropdownMenu1').hide();
				$('#button_check').hide();
				break;
		}
	}
/*
	$('#downloadTxt').on('click', function() {
		//set parameters 
		const delayIntervalTimeSet = 7000;
		const limitFiles = 100;


		$('#myModal').modal('show');
		$('.modal-backdrop.in').remove();
		const totalFiles = '<?php echo ceil($dataCount1['COUNT_OPEN'] / 100); ?>';
		let downloadedFiles = 0;

		function processNext() {
			let terminate = $('#closeRefresh').data('terminate');

			if (terminate) {
				console.log("Process terminated.");
				$('#submit-cari').click();
				return;
			}

			if (downloadedFiles < totalFiles) {
				window.location.href = `txt_slik_automation_existing.php?USERNAME=<?= $_GET['USERNAME'] . '&CUST_TYPE=' . $cust_type . '&STATUS=' . $status ?>`;
				window.setTimeout(function() {
					downloadedFiles++;
					$('#downloadedFiles').html(downloadedFiles.toString());
					window.setTimeout(function() {
						processNext();
					}, 5000);
				}, delayIntervalTimeSet);
			} else if (downloadedFiles == totalFiles) {
				window.location.href = `txt_slik_automation_existing.php?USERNAME=<?= $_GET['USERNAME'] . '&CUST_TYPE=' . $cust_type . '&STATUS=' . $status ?>`;
				window.setTimeout(function() {
					$('#downloadedFiles').html(downloadedFiles.toString());
					$('.progressDownload').hide();
					$('.doneDownload').show();
					downloadedFiles++;
				}, delayIntervalTimeSet);
			} else {
				// End of data, exit loop
				return;
			}
		}

		// Start the loop
		if (totalFiles > 0 && totalFiles <= limitFiles) {
			processNext();
		}
	})
	*/
</script>