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
}
.td-center{
	text-align:center;
}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">History</h4>
				<p class="category">History Activity Request</p>
			</div>
			<div class="content">
				<div class="row">
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
							<button type="submit" class="btn btn-primary" name="submit" style="width:100%;">Cari</button>
						</div>
					</form>
				</div>
				<table class="table table-bordered table-striped" id="history" style="font-size:10px;">
					<thead>
						<tr>
							<th class="th-custom">NO</th>
							<th class="th-custom">PROSPECT NO</th>
							<!--<th class="th-custom">PEFINDO ID</th>-->
							<th class="th-custom">ID NO</th>
							<th class="th-custom">NAME</th>
							<th class="th-custom">SEARCH TYPE</th>
							<th class="th-custom">CUSTOMER TYPE</th>
							<th class="th-custom">CHECKED BY</th>
							<th class="th-custom">CREATE DATE</th>
							<th class="th-custom" width="200">ACTION</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$no=0;
							$call = "{call PEFINDO_GETDATA_HISTORY_SOURCEBY(?,?)}";
							$param = array(array($startDate, SQLSRV_PARAM_IN),array($endDate, SQLSRV_PARAM_IN));
							$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
							while($data = sqlsrv_fetch_array($exec)){
								$no++;
						?>
						<tr>
							<td class="td-center"><?php echo $no;?></td>
							<td class="td-center"><?php echo $data['PROSPECT_NO'];?></td>
							<!--<td class="td-center"><?php //echo $data['PEFINDO_ID'];?></td>-->
							<td class="td-center"><?php echo $data['ID_NO'];?></td>
							<td class=""><?php echo $data['CUST_NAME'];?></td>
							<td class="td-center"><?php if($data['CUST_TYPE']=="P"){echo"Individual";}else{echo"Company";}?></td>
							<td class="td-center"><?php echo $data['TYPE'];?></td>
							<td class="td-center"><?php echo $data['SOURCE_BY'];?></td>
							<td class="td-center"><?php echo $data['CREATE_DATE']->format("d-m-Y");?></td>
							<td class="td-center">
								<?php 
								if($data['CUST_TYPE']=="P" && $data['SOURCE_BY'] == "PEFINDO"){
									echo'<a href="index.php?USERNAME='.$user.'&page=scoring-individual&id='.$data['PEFINDO_ID'].'&no='.$data['PROSPECT_NO'].'" class="btn btn-primary btn-sm" title="detail"><i class="fa fa-eye"></i></a>';
								}else if($data['CUST_TYPE']=="C" && $data['SOURCE_BY'] == "PEFINDO"){
									echo'<a href="index.php?USERNAME='.$user.'&page=scoring-company&id='.$data['PEFINDO_ID'].'&no='.$data['PROSPECT_NO'].'" class="btn btn-primary btn-sm" title="detail"><i class="fa fa-eye"></i></a>';
								}else if($data['CUST_TYPE']=="P" && $data['SOURCE_BY'] == "SLIK"){
									echo'<a href="index.php?USERNAME='.$user.'&page=slik-detail&id='.$data['PROSPECT_NO'].'" class="btn btn-primary btn-sm" title="detail"><i class="fa fa-eye"></i></a>';
								}else if($data['CUST_TYPE']=="C" && $data['SOURCE_BY'] == "SLIK"){
									echo'<a href="index.php?USERNAME='.$user.'&page=slik-detail&id='.$data['PROSPECT_NO'].'" class="btn btn-primary btn-sm" title="detail"><i class="fa fa-eye"></i></a>';
								}
								?>	
								<a href="pages/getExcel.php?USERNAME=<?php echo $user;?>&id=<?php echo $data['PEFINDO_ID'];?>&type=<?php echo $data['CUST_TYPE'];?>" target="_blank" title="Export to Excel" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i></a>
								<?php 
									if($_GET['USERNAME'] == 'iman.santoso' || $_GET['USERNAME'] == 'djoko.andrew' || $_GET['USERNAME'] == 'ramandona'){
										if($data['SOURCE_BY'] == "PEFINDO"){
											echo'<a href="pages/history-delete.php?USERNAME='.$user.'&id='.$data['PEFINDO_MAPPING_ID'].'&type='.$data['CUST_TYPE'].'&flag=1" class="btn btn-danger btn-sm" title="delete" onclick="return confirm(\'Apakah anda yakin ingin menghapus data ini ?\');"><i class="fa fa-trash-o"></i></a>';
										}else{
											echo'<a href="pages/history-delete.php?USERNAME='.$user.'&id='.$data['PEFINDO_MAPPING_ID'].'&type='.$data['CUST_TYPE'].'&flag=2" class="btn btn-danger btn-sm" title="delete" onclick="return confirm(\'Apakah anda yakin ingin menghapus data ini ?\');"><i class="fa fa-trash-o"></i></a>';
										}
									}else{
										echo'';
									}
								?>
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
<script src="assets/js/jquery.3.2.1.min.js"></script>
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