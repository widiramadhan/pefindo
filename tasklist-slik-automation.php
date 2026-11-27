<?php
require_once("config/configuration.php");
require_once("config/connection.php");
$date = date("Y-m-d");

$callCount = "{call SP_GET_COUNT_TASK_SLIK_AUTOMATION}";
$execCount = sqlsrv_query($conn, $callCount) or die(print_r(sqlsrv_errors(), true));
$dataCount = sqlsrv_fetch_array($execCount);



if (isset($_POST['submit'])) {
	// $startDate = $_POST['startDate'];
	// $endDate = $_POST['endDate'];
	$cust_type = $_POST['cust_type'];
	$status = $_POST['status'];
	// $tipe = $_POST['tipe'];
} else {
	// $startDate = date("Y-m-01");
	// $endDate = date("Y-m-d");
	$cust_type = '';
	$status = "OPEN";
	// $tipe = "";
}

if (isset($_POST['downloadTxt1'])) {
	//echo "<script>alert('Data Txt Berhasil Dibuat');window.location='index.php?page=tasklist-slik-automation'</script>";


	// $dateform = $_POST['startDate'];
	// $dateto = $_POST['endDate'];
	// $user = $_GET['USERNAME'];

	// $call = "{call SP_ACTION_SLIK_TXT(?,?,?)}";
	// $param = array(
	// 	array($dateform, SQLSRV_PARAM_IN),
	// 	array($dateto, SQLSRV_PARAM_IN),
	// 	array($user, SQLSRV_PARAM_IN)
	// );
	// $exec = sqlsrv_query($conn, $call, $param) or die(print_r(sqlsrv_errors(), true));
	// $data = sqlsrv_fetch_array($exec);
	// 	$call = "{call SP_ACTION_SLIK_TXT_select_test(?,?,?)}";
	// 	$param = array(
	// 		array($startDate, SQLSRV_PARAM_IN),
	// 		array($endDate, SQLSRV_PARAM_IN),
	// 		array('', SQLSRV_PARAM_IN)
	// 	);
	// 	$exec = sqlsrv_query($conn, $call, $param) or die(print_r(sqlsrv_errors(), true));
	// 	$dataTxt = [];
	// while ($data = sqlsrv_fetch_array($exec)) {

	//     $dataTxt[] = $data['IDEB_NO'] . '|' . $data['REQ_TYPE'] . '|' . $data['SUB_TYPE'] . '|' . $data['ID_NO'] . "\n";
	// }
	// //var_dump($dataTxt);
	// //echo '<pre>' . var_export($dataTxt, true) . '</pre>';
	// //exit();

	// //generate
	// // $text = '';

	// // foreach ($dataTxt as $row) {
	// //     $text .= $row . "\n";
	// // }
	// // echo '<pre>' . var_export($dataTxt, true) . '</pre>';
	// // exit();

	// // write to a file

	// $file = 'contoh.txt';
	// file_put_contents(
	//     $file,
	//     str_replace("\n\n", "\n", $dataTxt)
	// );
	// file_put_contents($file, $dataTxt);
	// // file_put_contents(
	// //     $file,
	// //     implode('', $dataTxt)
	// // );
	// //download
	// header('Content-disposition: attachment; filename=' . $file . '');
	// header('Content-type: application/download');
	// header("Content-length: " . filesize($file));
	// readfile($file);
	// unlink($file);

	// echo "<script>alert('Data Berhasil Disimpan');window.location='index.php?USERNAME=" . $_GET['USERNAME'] . "'</script>";
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
				<p class="category">Reguler</p>
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
						<a href="index.php?USERNAME=<?php echo $_GET['USERNAME']; ?>&page=tasklist-slik-automation-deb-exists" class="btn btn-primary" type="button" title="OPEN TASK ">
							Debitur Existing <span class="badge">2</span>
						</a>
					</div>
					
					<div class="col col-md-8 text-right">
						<a href="index.php?USERNAME=<?php echo $_GET['USERNAME']; ?>&page=pefindonodata-piloting" class="btn btn-primary" type="button" title="OPEN TASK ">
							Slik Company <span class="badge"><?php echo $dataCount['COUNT_COMPANY']; ?></span>
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
									<option value="ON PROGRESS" <?= ('ON PROGRESS' == $status) ? "selected" : "" ?>>ON PROGRESS</option>
								</select>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Cust Type</label>
								<select name="cust_type" class="form-control" id="cust_type">
									<option value="" <?= ('' == $status) ? "selected" : "" ?>>All</option>
									<option value="pemohon" <?= ('pemohon' == $status) ? "selected" : "" ?>>Pemohon</option>
									<option value="pasangan" <?= ('pasangan' == $status) ? "selected" : "" ?>>Pasangan</option>
									<option value="penjamin" <?= ('penjamin' == $status) ? "selected" : "" ?>>Penjamin</option>
									<option value="pengurus" <?= ('pengurus' == $status) ? "selected" : "" ?>>Pengurus</option>
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
								<a name="downloadTxt" id="downloadTxt" href="txt_slik_automation.php?USERNAME=<?= $_GET['USERNAME'] . '&CUST_TYPE=' . $cust_type . '&STATUS=' . $status ?>" class="btn btn-custom" style="width:100%;" target="_blank"> </i> DOWNLOAD TXT</a>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label for="">&nbsp</label>
								<a href="test_upload.php?USERNAME=<?php echo $user; ?>" id="button_check" class="btn btn-custom" style="width:100%;"></i> CHECK</a>
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
					<input type="hidden" name="masiveResult" id="masiveResult">
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
									<!-- <th class="th-custom" style="color:#FFF;font-weight:bold;">PEFINDO FOUND</th>				
									<th class="th-custom" style="color:#FFF;font-weight:bold;">PEFINDO STAT</th> -->	
									<th class="th-custom" style="color:#FFF;font-weight:bold;">FOUND CHECK</th>					
									<th class="th-custom" style="color:#FFF;font-weight:bold;">TUJUAN PERMINTAAN</th>
									<th class="th-custom" style="color:#FFF;font-weight:bold;">STATUS</th>
								</tr>
							</thead>
							<tbody>
								<button type="submit" style="display: none;"></button>
								<?php
								$no = 0;
								$call = "{call SP_GET_TASKLIST_SLIK_AUTOMATION_PEFINDO(?,?)}";
								$param = array(
									// array($startDate, SQLSRV_PARAM_IN),
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
										<!--<td><input type="checkbox" name="pef_stat" id="pef_stat" value="" <?php //if ($data['STAT_PEFINDO'] == 1) {echo 'checked';}?>  disabled></td>
										<td><?php //echo $data['STAT_CHECKED']; ?></td> -->
											<td class="td-center">
											<?php
											
											echo  $data['STAT_CHECKED_NUM'];
											?>
											</td>
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

		$('#downloadTxt').on('click', function(params) {
			window.setTimeout(function() {
				$('#submit-cari').click();
			}, 2000);
		});

		//checkall
		$('#checkAll').on('change', function() {
			$('.rowCheckbox').prop('checked', $(this).prop('checked'))
		})

		//submit check
		$('.resultButton').on('click', function(e) {
			let buttonId = e.target.id;
			var selectedRows = [];
			$('.rowCheckbox:checked').each(function() {
				var rowData = $(this).val();
				selectedRows.push(rowData);
			})

			if (selectedRows.length == 0) {
				alert('Tidak ada customer dipilih!')
			} else {
				$('#masiveResult').val(buttonId);
				$('#massiveResultForm').submit();
			}
		})
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
				// Ahmad Arkana Dhanisworo - 20250922
				$('#downloadTxt').show();
				// $('#downloadTxt').hide();
				// END
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
</script>