<?php
require_once("config/configuration.php");
require_once("config/connection.php");
$date=date("Y-m-d");


if(isset($_POST['submit'])){
	 $branch = $_POST['branch'];
	$prospect_no = $_POST['prospect_no'];
	$appno = $_POST['app_no'];
	$startDate = $_POST['startDate'];
	$endDate = $_POST['endDate'];
}else{
	$branch = "";
	$prospect_no = "";
	$appno = "";
	$startDate = date("Y-m-01");
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
</style>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">APPROVAL LOA VERIFIKASI</h4>
				<p class="category">Historical Kredit Eksternal</p>
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
												$exec2 = sqlsrv_query($conn, $call2,$param2) or die( print_r( sqlsrv_errors(), true));
												while($data2=sqlsrv_fetch_array($exec2)){
											?>
											<option value="<?php echo $data2['Branchid'];?>" <?php if($data2['Branchid']==$branch){ echo "selected"; }?>><?php echo $data2['BranchName'];?></option>
											<?php } ?>
										</select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								 <label>PROSPECT / ORDER NO</label>
                                
                                    <input type="text" class="form-control" name="prospect_no" id="prospect_no"  value="<?php echo $prospect_no;?>">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								 <label>APP NO</label>
                                
                                    <input type="text" class="form-control" name="app_no" id="app_no"  value="<?php echo $appno;?>">
							</div>
						</div>
						
				</div>
				<div class="row">
					
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
								<th class="th-custom" style="color:#FFF;font-weight:bold;">APP NO</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">APV_NO</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">STATUS APPROVAL</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">FINAL APPROVAL</th>
								
								<th class="th-custom" style="color:#FFF;font-weight:bold;">TANGGAL_PENGECEKAN_DUKCAPIL</th>
								
								<th class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>
								</tr>
						</thead>
						<tbody>
							<?php
								$no=0;
								$call = "{call SP_TASKLIST_APPROVAL_LOA_TDP_USER_INQUIRY_NEW(?,?,?,?,?,?,?)}";
								$param = array(array($branch, SQLSRV_PARAM_IN),array($prospect_no, SQLSRV_PARAM_IN),
												array($appno, SQLSRV_PARAM_IN),
												array($user, SQLSRV_PARAM_IN),
												array($bid[0], SQLSRV_PARAM_IN),
												array($startDate, SQLSRV_PARAM_IN),
												array($endDate, SQLSRV_PARAM_IN));
								$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
					
								while($data = sqlsrv_fetch_array($exec)){
									$no++;
							?>
							<tr>
								<td class="td-center"><?php echo $no;?></td>
								<td class="td-center"><?php echo $data['BRANCH_ID'];?></td>
								<td class="td-center"><?php echo $data['OFFICE_NAME'];?></td>
								<td class="td-center"><?php echo $data['PROSPECT_NO'];?></td>
								<td><?php echo $data['APP_NO'];?></td>
								<td><?php echo $data['APV_NO'];?></td>
								<td><?php echo $data['FINAL_STATUS'];?></td>
								<td><?php echo $data['FINAL_APPROVAL'];?></td>
								<td class="td-center"><?php echo $data['CREATE_DATE']->format("Y-m-d H:i:s");?></td>
									
								<td class="td-center">
						
								<?php /* if($data['BRANCH_ID'] == '1056' || $data['BRANCH_ID']=="1006" || $data['BRANCH_ID']=="1005" || $data['BRANCH_ID']=="1066" || $data['BRANCH_ID']=="1011" ||
										$data['BRANCH_ID']=="1026" || $data['BRANCH_ID']=="1034" || $data['BRANCH_ID']=="1045" || $data['BRANCH_ID']=="1056" ||
										$data['BRANCH_ID']=="1064" || $data['BRANCH_ID']=="1080" ||	$data['BRANCH_ID']=="1501" || $data['BRANCH_ID']=="1502" ||
										$data['BRANCH_ID']=="1506" || $data['BRANCH_ID']=="1507" || $data['BRANCH_ID']=="1512" || $data['BRANCH_ID']=="1516" ||
										$data['BRANCH_ID']=="1518" || $data['BRANCH_ID']=="1524" || $data['BRANCH_ID']=="1543" || $data['BRANCH_ID']=="1548" ){ */

								// if ($is_rak){ 		
								?>
								<a href="index.php?page=detail-approval-loa-tdp-inquiry-piloting&USERNAME=<?php echo $user;?>&prospect=<?php echo $data['PROSPECT_NO'];?>&app=<?php echo $data['APP_NO'];?>&apv_no=<?php echo $data['APV_NO'];?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
								<?php /* }ELSE{ ?>
								<a href="index.php?page=detail-approval-loa-tdp-inquiry&USERNAME=<?php echo $user;?>&prospect=<?php echo $data['PROSPECT_NO'];?>&app=<?php echo $data['APP_NO'];?>&apv_no=<?php echo $data['APV_NO'];?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
								<?php } */ ?>
							
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
} );
</script>