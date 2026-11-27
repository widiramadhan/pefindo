<?php
require_once("config/configuration.php");
require_once("config/connection.php");
if(isset($_POST['submit'])){
	
	$status=$_POST['status'];
	$nik=$_POST['nik'];
	$startDate =$_POST['startDate'];
	$endDate = $_POST['endDate'];
	$call = "{call SP_GET_LOCK_DATA_BY_BRANCH_NEW_2(?,?,?,?,?)}";
	$param = array(array($user, SQLSRV_PARAM_IN),
				   array($nik,SQLSRV_PARAM_IN),
				   array($status,SQLSRV_PARAM_IN),
				   array($startDate,SQLSRV_PARAM_IN),
				   array($endDate,SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 			

	
}
else{
	$status="";
	$nik="";
	$startDate = date("Y-m-01");
	$endDate = date("Y-m-d");
	$call = "{call SP_GET_LOCK_DATA_BY_BRANCH_NEW_2(?,?,?,?,?)}";
	$param = array(array($user, SQLSRV_PARAM_IN),
				   array($nik,SQLSRV_PARAM_IN),
				   array($status,SQLSRV_PARAM_IN),
				   array($startDate,SQLSRV_PARAM_IN),
				   array($endDate,SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 	
	
	}
	
?>
<style>
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
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Unlock Dukcapil</h4>
				<p class="category">Pilih data untuk unlock data dukcapil</p>
			</div>
			<div class="content">
			
					 <form action="" method="post">
						<div class="col-md-3">
							<div class="form-group">
								<label>Status</label>
								<select name="status" class="form-control">
									<option value="1" <?php if($status=='1') {echo 'selected';} ?>> ALL STATUS</option>
									<option value="2" <?php if($status=='2') {echo 'selected';} ?>>SUDAH UPLOAD RESI</option>
									<option value="3" <?php if($status=='3') {echo 'selected';} ?>>BELUM UPLOAD RESI</option>
								</select>
							</div>
						</div>
						
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
						<div class="col-md-3">
							<div class="form-group">
								<label>NIK</label>
									<input type="text" class="form-control" name="nik" id="nik" value="<?php echo $nik;?>">
							</div>
						</div>
				
					<div class="pull-right">
						<input type="submit" name="submit" class="btn btn-custom" value="CARI">
					</div>
					<div style="clear:both;"></div>
				</form>
				<hr>
				
				<div class="table-responsive">
					<table class="table table-bordered table-striped" id="history" style="font-size:10px;">
						<thead>
							<tr>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">PROSPECT / ORDER NO</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">NIK</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">USER REQUEST</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">LOCK DATE</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">STATUS</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">STATUS UNLOCK</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$no=0;
								
								while($data = sqlsrv_fetch_array($exec)){
									$no++;
							?>
							<tr>
								<td class="td-center"><?php echo $no;?></td>
								<td class="td-center"><?php echo $data['PROSPECT_NO'];?></td>
								<td class="td-center"><?php echo $data['ID_NO'];?></td>
								<td class="td-center"><?php echo $data['CREATE_USER'];?></td>
								<td class="td-center"><?php echo $data['CREATE_DATE']->format("Y-m-d H:i:s");?></td>
								<td class="td-center"><?php echo $data['IMG_SRC'];?></td>
								<td class="td-center">
								<?php
									if($data['DESKRIPSI'] == "UNLOCK"){
										echo"<span class='badge' style='background-color:#5cb85c;'>".'FINISH'."</span>";
									}else if($data['STATUS'] == "1"){
										echo"<span class='badge' style='background-color:#5cb85c;'>".$data['STATUS_DESC']."</span>";
									}else if($data['STATUS'] == "3"){
                                        echo"<span class='badge' style='background-color:#000000;'>".$data['STATUS_DESC']."</span>";
									}else if($data['STATUS'] == "2"){
                                        echo"<span class='badge' style='background-color:#ffc107;'>".$data['STATUS_DESC']."</span>";
									}else{
										echo"<span class='badge' style='background-color:#d9534f;'>".'OPEN'."</span>";
									}
								?>		
							</td>
								<td class="td-center">
									<a href="index.php?USERNAME=<?php echo $user;?>&page=unlock-detail&id=<?php echo $data['LOG_CHECK_BYSOURCE_ID'];?>" class="btn btn-custom btn-xs" onclick="return confirm('Proses unlock akan dikenakan biaya hit ke Dukcapil, apakah anda yakin ingin proses?')">DETAIL</a>
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
} );
</script>