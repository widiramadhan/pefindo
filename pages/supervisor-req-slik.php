<?php
require_once("config/configuration.php");
require_once("config/connection.php");
$date=date("Y-m-d");


if(isset($_POST['period'])){
	$period = $_POST['period'];
}else if(isset($_POST['period_comments'])){
	$period = $_POST['period_comments'];
}else if(isset($_GET['period'])){
	$period = $_GET['period'];
}
else{
	$period = null;
}

$months = [
    1 => "Januari",
    2 => "Februari",
    3 => "Maret",
    4 => "April",
    5 => "Mei",
    6 => "Juni",
    7 => "Juli",
    8 => "Agustus",
    9 => "September",
    10 => "Oktober",
    11 => "November",
    12 => "Desember"
];

// Bulan & tahun sekarang
$currentYear = date("Y");
$currentMonth = date("n");

// Jumlah bulan ke belakang (misalnya 12 bulan)
$limit = 12;

if(isset($_POST['period_comments'])){
	$call = "{call SP_INSERT_CONTROL_REQUEST_SLIK_COMMENTS(?,?,?)}";
	$param = array(array($_POST['period_comments'], SQLSRV_PARAM_IN),array($_POST['comments'], SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
	$exec4 = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
}

if(isset($_POST['upload_file_btn'])){
	$upload_jenis = isset($_POST['jenis_file']) && !empty($_POST['jenis_file']) ? $_POST['jenis_file'] : 'DOKUMEN SLIK';
	$defaultPeriod = str_pad($currentMonth, 2, "0", STR_PAD_LEFT) . $currentYear;
	$upload_period = isset($_POST['period']) && !empty($_POST['period']) ? $_POST['period'] : ($period ? $period : $defaultPeriod);
	
	if(isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] == 0){
		$file_name = $_FILES['file_upload']['name'];
		$file_tmp = $_FILES['file_upload']['tmp_name'];
		
		$target_dir = "uploads/control_request_slik/";
		if (!file_exists($target_dir)) {
			@mkdir($target_dir, 0777, true);
		}
		
		$saved_file_name = time() . "_" . preg_replace("/[^a-zA-Z0-9\._-]/", "_", $file_name);
		$target_file = $target_dir . $saved_file_name;
		
		if(@move_uploaded_file($file_tmp, $target_file)){
			$callUpload = "{call SP_INSERT_CONTROL_REQUEST_SLIK_FILES(?,?,?,?,?)}";
			$paramUpload = array(
				array($upload_period, SQLSRV_PARAM_IN),
				array($file_name, SQLSRV_PARAM_IN),
				array($target_file, SQLSRV_PARAM_IN),
				array($upload_jenis, SQLSRV_PARAM_IN),
				array($user, SQLSRV_PARAM_IN)
			);
			$execUpload = sqlsrv_query($conn, $callUpload, $paramUpload);
			if($execUpload){
				echo "<script>alert('File berhasil diupload!'); window.location='index.php?USERNAME=".$user."&page=supervisor-req-slik&period=".$upload_period."';</script>";
				exit();
			} else {
				$sql_err = "";
				if(($errors = sqlsrv_errors()) != null) {
					foreach($errors as $error) {
						$sql_err .= $error['message'] . " ";
					}
				}
				$clean_err = addslashes(str_replace(array("\r", "\n"), " ", $sql_err));
				echo "<script>alert('Gagal menyimpan metadata file ke database: " . $clean_err . "'); window.location='index.php?USERNAME=".$user."&page=supervisor-req-slik&period=".$upload_period."';</script>";
				exit();
			}
		} else {
			echo "<script>alert('Gagal mengupload file ke web server. Pastikan folder uploads/control_request_slik/ memiliki akses write.'); window.location='index.php?USERNAME=".$user."&page=supervisor-req-slik&period=".$upload_period."';</script>";
			exit();
		}
	} else {
		$upload_err_code = isset($_FILES['file_upload']['error']) ? $_FILES['file_upload']['error'] : 'no_file';
		echo "<script>alert('Silakan pilih file yang akan diupload (Error code: ".$upload_err_code.").'); window.location='index.php?USERNAME=".$user."&page=supervisor-req-slik&period=".$upload_period."';</script>";
		exit();
	}
}

?>

<style>
#modalUploadFile {
	z-index: 1060 !important;
}
.modal-backdrop {
	z-index: 1040 !important;
}
.th-custom{
	text-align:center;
	background-color:#035c7a;
}
.td-center{
	text-align:center;
}
.pagination > li > a, .pagination > li > span{
	background-color:#FFF;
	color:#035c7a;
}
.pagination > li.active > a, .pagination > li.active > span{
	background-color:#035c7a;
	color:#FFF;
}
.pagination > li.active > a:hover, .pagination > li.active > span:hover{
	background-color:#035c7a;
	color:#FFF;
}
.pagination > li.focus > a, .pagination > li.focus > span:hover{
	background-color:#035c7a;
	color:#FFF;
}
.pagination > li.active > a.page-link, .pagination > li.active > span.page-link{
	background-color:#035c7a;
	color:#FFF;
}
</style>
<?php
$no=0;
if($period == null){
	$dataList = [];
}
else{
	$call = "{call SP_GET_TASKLIST_SLIK_CONTROL_REQUEST(?,?,?)}";
	$param = array(array('', SQLSRV_PARAM_IN),array('', SQLSRV_PARAM_IN),array($period, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
	$dataList = [];
	while ($row = sqlsrv_fetch_array($exec, SQLSRV_FETCH_ASSOC)) {
		$dataList[] = $row; // Store each row in an array
	}
}

$rowCount = count($dataList);
?>
<?php
$no1=0;
if($period == null){
	$dataList1 = [];
}
else{
	$call = "{call SP_GET_CONTROL_PENGECEKAN_SLIK(?)}";
	$param = array(array($period, SQLSRV_PARAM_IN));
	$exec1 = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
	$row1 = sqlsrv_num_rows($exec1);
	$dataList1 = [];
	while ($row1 = sqlsrv_fetch_array($exec1, SQLSRV_FETCH_ASSOC)) {
		$dataList1[] = $row1; // Store each row in an array
	}
}

$rowCount1 = count($dataList1);
?>

<?php
$no2=0;
if($period == null){
	$dataList2 = [];
}
else{
	$call = "{call SP_GET_TASKLIST_SLIK_CONTROL_REQUEST_LOG(?,?,?)}";
	$param = array(array('', SQLSRV_PARAM_IN),array('', SQLSRV_PARAM_IN),array($period, SQLSRV_PARAM_IN));
	$exec2 = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
	$row2 = sqlsrv_num_rows($exec2);
	$dataList2 = [];
	while ($row2 = sqlsrv_fetch_array($exec2, SQLSRV_FETCH_ASSOC)) {
		$dataList2[] = $row2; // Store each row in an array
	}
}

$rowCount2 = count($dataList2);
?>

<?php
if($period == null){
	$data_comments = [];
}
else{
	$call = "{call SP_GET_CONTROL_PENGECEKAN_SLIK_COMMENTS(?)}";
	$param = array(array($period, SQLSRV_PARAM_IN));
	$exec3 = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
	$data_comments = sqlsrv_fetch_array($exec3);
}

$callF = "{call SP_GET_CONTROL_REQUEST_SLIK_FILES(?)}";
$paramF = array(array($period != null ? $period : '', SQLSRV_PARAM_IN));
$execF = sqlsrv_query( $conn, $callF, $paramF); 
$data_files = [];
if($execF){
	while ($rowF = sqlsrv_fetch_array($execF, SQLSRV_FETCH_ASSOC)) {
		$data_files[] = $rowF;
	}
}
?>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Tasklist Control Request Slik</h4>
				<p class="category">Regular</p>
			</div>
			<div class="content">
				<!--<div class="row">
					<form action="" method="post">
						<div class="col-md-3">
							<div class="form-group">
								<label>Start Date</label>
								<div class="input-group date">
									<input type="text" class="form-control" name="startDate" id="startDate" autocomplete="off" value="<?php echo $startDate;?>">
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
									<input type="text" class="form-control" name="endDate" id="endDate" autocomplete="off" value="<?php echo $endDate;?>">
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
						<div class="col-md-2">
							&nbsp;<br>
							
							<a href="action_log_pefindo.php?startDate=<?php echo $startDate;?>&endDate=<?php echo $endDate;?>" class="btn btn-custom" style="width:100%;">EXPORT TO EXCEL</a>
						</div>
					</form>
				</div>-->
				<div class="row">
					<div class="col-md-2">
						<div class="card card-stats">
							<div class="content all-icons" style="padding:30px;">
								<div class="row">
									<div style="text-align: center;">
										<h6 class="card-title text-uppercase text-muted mb-0">Task Slik Request</h6>
										<span class="h2 font-weight-bold mb-0"><?php echo $rowCount > 0 ? $rowCount : '0'; ?></span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="card card-stats">
							<div class="content all-icons" style="padding:30px;">
								<div class="row">
									<div  style="text-align: center;">
										<h6 class="card-title text-uppercase text-muted mb-0">Control Pengecekan Slik</h6>
										<span class="h2 font-weight-bold mb-0"><?php echo $rowCount1 > 0 ? $rowCount1 : '0'; ?></span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="card card-stats">
							<div class="content all-icons" style="padding:30px;">
								<div class="row">
									<div  style="text-align: center;">
										<h6 class="card-title text-uppercase text-muted mb-0">Control Pengecekan Slik Valid</h6>
										<span class="h2 font-weight-bold mb-0"><?php echo $rowCount2 > 0 ? $rowCount2 : '0'; ?></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<form action="" method="post">
						<div class="col-md-2">
							<div class="form-group">
								<label>Period</label>
								<select name="period" class="form-control" id="cust_type">
									<?php
									for ($i = 0; $i < $limit; $i++) {
										// Hitung bulan & tahun mundur
										$monthNum = $currentMonth - $i;
										$year = $currentYear;

										if ($monthNum <= 0) {
											$monthNum += 12;
											$year--;
										}

										$val = str_pad($monthNum, 2, "0", STR_PAD_LEFT) . $year; // contoh 092025
										$label = $months[$monthNum] . " " . $year;

										$selected = ($val == $period) ? "selected" : "";
										echo "<option value='$val' $selected>$label</option>";
									}
									?>
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
								<a href="upload_control_request_slik.php?USERNAME=<?php echo $user; ?>&PERIODE=<?php echo $period; ?>" id="button_check" class="btn btn-custom" style="width:100%;"></i> UPLOAD TXT</a>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label for="">&nbsp</label>
								<button type="button" class="btn btn-custom" data-toggle="modal" data-target="#modalUploadFile" style="width:100%;"><i class="fa fa-upload"></i> UPLOAD FILE</button>
							</div>
						</div>
						<div class="col-md-2" <?php echo $period ? "" : "hidden='hidden'"; ?>>
							<div class="form-group">
								<label for="">&nbsp</label>
								<a href="check_control_request_slik.php?USERNAME=<?php echo $user; ?>&PERIODE=<?php echo $period; ?>" id="button_check" class="btn btn-custom" style="width:100%;"></i> CHECK</a>
							</div>
						</div>
					</form>
				</div>
				<hr>
				<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
					<div class="table-responsive">
						<div style="text-align: center;">
							<h4 class="title">Tasklist Request Slik</h4>	
						</div>
						<br>
						<table class="table table-bordered table-striped" id="history" style="font-size:10px;">
							<thead>
								<tr>
									<th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
									<th class="th-custom" style="color:#FFF;font-weight:bold;">NO GENERATE</th>
									<th class="th-custom" style="color:#FFF;font-weight:bold;">NO IDENTITAS</th>
									<th class="th-custom" style="color:#FFF;font-weight:bold;">NAMA</th>
									<th class="th-custom" style="color:#FFF;font-weight:bold;">CREATE DATE</th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach($dataList as $data){
										$no++;
								?>
								<tr>
									<td class="td-center"><?php echo $no;?></td>
									<td class="td-center"><?php echo $data['IDEB_NO'];?></td>
									<td class="td-center"><?php echo $data['ID_NO'];?></td>
									<td class="td-center"><?php echo $data['NAMA'];?></td>
									<td class="td-center"><?php echo $data['CREATE_DATE']->format("Y-m-d H:i:s");?></td>
								</tr>
								<?php
									}
								?>
							</tbody>
						</table>
					</div>
					<div class="table-responsive">
						<div style="text-align: center;">
							<h4 class="title">Control Pengecekan Slik</h4>
						</div>
						<br>
						<table class="table table-bordered table-striped" id="history2" style="font-size:10px;">
							<thead>
								<tr>
									<th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
									<th class="th-custom" style="color:#FFF;font-weight:bold;">NO GENERATE</th>
									<th class="th-custom" style="color:#FFF;font-weight:bold;">NO IDENTITAS</th>
									<th class="th-custom" style="color:#FFF;font-weight:bold;">NAMA</th>
									<th class="th-custom" style="color:#FFF;font-weight:bold;">CREATE DATE</th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach($dataList1 as $data){
										$no1++;
								?>
								<tr>
									<td class="td-center"><?php echo $no1;?></td>
									<td class="td-center"><?php echo $data['IDEB_NO'];?></td>
									<td class="td-center"><?php echo $data['ID_NO'];?></td>
									<td class="td-center"><?php echo $data['NAMA'];?></td>
									<td class="td-center"><?php echo $data['TANGGAL_PERMINTAAN']->format("Y-m-d H:i:s");?></td>
								</tr>
								<?php
									}       
								?>
							</tbody>
						</table>
					</div>
				</div>
				<hr>
				<div style="display: grid; grid-template-columns: 1fr; gap: 20px;" <?php echo $period ? "" : "hidden='hidden'"; ?>>
					<form action="" method="post">
						<div style="width: 100%;">
							<div class="form-group">
								<label>COMMENTS</label>
								<textarea name="comments" id="comments" class="form-control" rows="5"><?php echo isset($data_comments['COMMENTS']) ? $data_comments['COMMENTS'] : '' ?></textarea>
							</div>
						</div>
						<input type="text" name="period_comments" id="period_comments" value="<?php echo $period;?>" hidden>
						<div style="width: 100%; display: flex; justify-content: space-between;">
							<div></div>
							<div class="col-md-2">
								<div class="form-group">
									<label for="">&nbsp</label>
									<button type="submit" class="btn btn-custom" name="submit" id="submit-cari" style="width:100%;">SAVE COMMENTS</button>
								</div>
							</div>
						</div>
					</form>
				</div>

				<!-- TABEL DAFTAR FILE UPLOAD -->
				<hr>
				<div style="display: grid; grid-template-columns: 1fr; gap: 20px;">
					<div class="table-responsive">
						<div style="text-align: center;">
							<h4 class="title">Daftar File Upload Supervisor (Periode: <?php echo $period; ?>)</h4>
						</div>
						<br>
						<table class="table table-bordered table-striped" id="historyUploadFiles" style="font-size:10px;">
							<thead>
								<tr>
									<th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
									<th class="th-custom" style="color:#FFF;font-weight:bold;">NAMA FILE</th>
									<th class="th-custom" style="color:#FFF;font-weight:bold;">JENIS FILE</th>
									<th class="th-custom" style="color:#FFF;font-weight:bold;">USER CREATE</th>
									<th class="th-custom" style="color:#FFF;font-weight:bold;">CREATE DATE</th>
									<th class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>
								</tr>
							</thead>
							<tbody>
								<?php
									if(!empty($data_files)){
										$noF = 0;
										foreach($data_files as $df){
											$noF++;
											$fileDate = isset($df['CREATE_DATE']) && $df['CREATE_DATE'] instanceof DateTime ? $df['CREATE_DATE']->format("Y-m-d H:i:s") : (isset($df['CREATE_DATE']) ? $df['CREATE_DATE'] : '-');
								?>
								<tr>
									<td class="td-center"><?php echo $noF;?></td>
									<td><?php echo htmlspecialchars($df['NAMA_FILE']);?></td>
									<td class="td-center"><span class="badge" style="background-color:#035c7a;"><?php echo htmlspecialchars($df['JENIS_FILE']);?></span></td>
									<td class="td-center"><?php echo htmlspecialchars($df['USER_CREATE']);?></td>
									<td class="td-center"><?php echo $fileDate;?></td>
									<td class="td-center">
										<a href="<?php echo htmlspecialchars($df['FILE_PATH']);?>" target="_blank" class="btn btn-custom btn-xs"><i class="fa fa-download"></i> DOWNLOAD / VIEW</a>
									</td>
								</tr>
								<?php
										}
									} else {
										echo "<tr><td colspan='6' class='text-center'>Belum ada file yang diupload.</td></tr>";
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

<script>
$(document).ready(function() {
    $('#modalUploadFile').appendTo("body");
    $('#history').DataTable({
		"bPaginate": true,
		"bLengthChange": true,
        "bFilter": true,
        "bInfo": true
	});
	$('#history2').DataTable({
		"bPaginate": true,
		"bLengthChange": true,
        "bFilter": true,
        "bInfo": true
	});
	$('#historyUploadFiles').DataTable({
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
} );
</script>

<!-- MODAL UPLOAD FILE -->
<div class="modal fade" id="modalUploadFile" tabindex="-1" role="dialog" aria-labelledby="modalUploadFileLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="period" value="<?php echo $period ? $period : str_pad($currentMonth, 2, "0", STR_PAD_LEFT) . $currentYear; ?>">
        <input type="hidden" name="jenis_file" value="DOKUMEN SLIK">
        <div class="modal-header" style="background-color:#035c7a; color:#fff;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff;"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modalUploadFileLabel"><i class="fa fa-upload"></i> Upload File Supervisor</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Pilih File <span class="text-danger">*</span></label>
            <input type="file" name="file_upload" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">BATAL</button>
          <button type="submit" name="upload_file_btn" class="btn btn-custom"><i class="fa fa-upload"></i> UPLOAD</button>
        </div>
      </form>
    </div>
  </div>
</div>