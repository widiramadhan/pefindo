<?php
require_once("config/configuration.php");
require_once("config/connection.php");
$date=date("Y-m-d");


if(isset($_POST['submit'])){
	$startDate = $_POST['startDate'];
	$endDate = $_POST['endDate'];
}else{
	$startDate = date("Y-m-d");
	$endDate = date("Y-m-d");
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
.text-custom{
	color:#035c7a;
}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Log Dukcapil</h4>
				<p class="category">Log penggunaan Dukcapil</p>
			</div>
			<div class="content">
				<form action="" method="post">
					<div class="row">
						<div class="col-md-3">
							<label>Start Date</label>
						</div>
						<div class="col-md-3">
							<label>End Date</label>
						</div>
					
					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
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
								<div class="input-group date">
									<input type="text" class="form-control" name="endDate" id="endDate" autocomplete="off" value="<?php echo $endDate;?>">
									<div class="input-group-addon">
										<span class="add-on"><i class="fa fa-calendar"></i></span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<button type="submit" class="btn btn-custom" name="submit" style="width:100%;">CARI</button>
						</div>
						<div class="col-md-2">
							<a href="pages/export-dukcapil.php?startDate=<?php echo $startDate;?>&endDate=<?php echo $endDate;?>" class="btn btn-custom" style="width:100%;">EXPORT TO EXCEL</a>
						</div>
					</div>
				</form>
				<div class="table-responsive">
					<table class="table table-bordered table-striped" id="history" style="font-size:9px;">
						<thead>
							<tr>
								<th class="th-custom" style="color:#FFF;font-weight:bold;font-size:9px;">NO</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;font-size:9px;">NOMOR PROSPEK</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;font-size:9px;">NIK</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;font-size:9px;">TOTAL HIT</th>
								<!--
								<th class="th-custom" style="color:#FFF;font-weight:bold;font-size:9px;">CASE NAMA LENGKAP</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;font-size:9px;">CASE TGL LAHIR</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;font-size:9px;">CASE IBU KANDUNG</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;font-size:9px;">CASE STATUS KAWIN</th>
								-->
								<th class="th-custom" style="color:#FFF;font-weight:bold;font-size:9px;">STATUS TERAKHIR</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;font-size:9px;">TANGGAL PENGECEKAN</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;font-size:9px;">AREA NAME</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;font-size:9px;">CABANG</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;font-size:9px;">TIPE</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;font-size:9px;">VEHICLE</th>
								
								<th class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$no=0;
								$call = "{call SP_REPORT_SUMMARY_DUKCAPIL(?,?)}";
								$param = array(array($startDate, SQLSRV_PARAM_IN),array($endDate, SQLSRV_PARAM_IN));
								$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
								while($data = sqlsrv_fetch_array($exec)){
									$no++;
							?>
							<tr>
								<td class="td-center"><?php echo $no;?></td>
								<td><?php echo $data['PROSPECT_NO'];?></td>
								<td class="td-center"><?php echo $data['ID_NO'];?></td>
								<td class="td-center"><?php echo $data['Total_HIT'];?></td>
								<?php /* 
								<td class="td-center">
									<?php //echo $data['Jumlah_case_Nama'];
										if($data['Jumlah_case_Nama'] == 1){
											echo"<i class='fa fa-check-circle text-custom'></i>";
										}else{
											echo"<i class='fa fa-minus-circle text-danger'></i>";
										}
									?>
								</td>
								<td class="td-center">
									<?php //echo $data['Jumlah_case_TglLhr'];
										if($data['Jumlah_case_TglLhr'] == 1){
											echo"<i class='fa fa-check-circle text-custom'></i>";
										}else{
											echo"<i class='fa fa-minus-circle text-danger'></i>";
										}
									?>
								</td>
								<td class="td-center">
									<?php //echo $data['Jumlah_case_Ibu'];
										if($data['Jumlah_case_Ibu'] == 1){
											echo"<i class='fa fa-check-circle text-custom'></i>";
										}else{
											echo"<i class='fa fa-minus-circle text-danger'></i>";
										}
									?>
								</td>
								<td class="td-center">
									<?php //echo $data['Jumlah_case_Stts'];
										if($data['Jumlah_case_Stts'] == 1){
											echo"<i class='fa fa-check-circle text-custom'></i>";
										}else{
											echo"<i class='fa fa-minus-circle text-danger'></i>";
										}
									?>
								</td>
								*/?>
								<td class="td-center"><?php echo $data['STATUS'];?></td>
								<td class="td-center"><?php if($data['CREATE_DATE']<>NULL){echo $data['CREATE_DATE']->format('Y-m-d H:i:s');}else{echo"-";}?></td>
								<td class="td-center"><?php echo $data['AREA_NAME'];?></td>
								<td class="td-center"><?php echo $data['OFFICE_CODE'];?></td>
								<td class="td-center"><?php echo $data['TYPE'];?></td>
								<td class="td-center"><?php echo $data['SCHEME_ID'];?></td>
								<td class="td-center"><a href="index.php?USERNAME=<?php echo $user;?>&page=detail-log-dukcapil&no=<?php echo $data['PROSPECT_NO'];?>&nik=<?php echo $data['ID_NO'];?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> Detail</a></td>
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
} );
</script>