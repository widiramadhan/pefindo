<?php
require_once("config/configuration.php");
require_once("config/connection.php");
$date=date("Y-m-d");


if(isset($_POST['submit'])){
	 $branch = $_POST['branch'];
	$startDate = $_POST['startDate'];
	$endDate = $_POST['endDate'];
	$order_no = $_POST['order_no'];
	$stat = $_POST['stat'];
}else{
	$branch = "";
	$startDate = date("Y-m-d");
	$endDate = date("Y-m-d");
	$order_no = '';
	$stat = '';
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
				<h4 class="title">List Hasil Mobile Survey </h4>
				<p class="category">Hasil Survey MOS</p>
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
						<div class="col-md-2">
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
						<div class="col-md-2">
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
								<label>ORDER NO</label>
									<input type="text" class="form-control" name="order_no" id="order_no"  value="<?php echo $order_no;?>">
								
								
							</div>
						</div>
						</div>
						<div class="row">
				
					
						<div class="col-md-3">
							<div class="form-group">
								 <label>STATUS</label>
                               <select name="stat" class="form-control">
											<option value="">ALL STATUS</option>
											<!--<option value="">ALL BRANCH</option>-->
											<?php
												$call4 = "{call SP_GET_ASSIGNMENT_CODE}"; 
												$exec4 = sqlsrv_query($conn, $call4) or die( print_r( sqlsrv_errors(), true));
												while($data4=sqlsrv_fetch_array($exec4)){
											?>
											<option value="<?php echo $data4['STATUS_SURVEY_ID'];?>" <?php if($data4['STATUS_SURVEY_DESC']==$stat){ echo "selected"; }?>><?php echo $data4['STATUS_SURVEY_DESC'];?></option>
											<?php } ?>
										</select>
							</div>
						</div>
						
						<div class="col-md-2">
							&nbsp;<br>
							<button type="submit" class="btn btn-custom" name="submit" style="width:100%;">CARI</button>
							<br>
					
						</div>
						
					
					</form>
					</div>
					<br>
		
				<div class="table-responsive">
					<table class="table table-bordered table-striped" id="history" style="font-size:10px;">
						<thead>
							<tr>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">OFFICE NAME</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">ORDER NO</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">CUST NAME</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">TGL SUBMIT ORDER</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">STATUS</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">PRINT</th>
								</tr>
						</thead>
						<tbody>
							<?php
								$no=0;
								$call = "{call SP_GET_HASIL_SURVEY_MOS(?,?,?,?,?,?)}";
								$param = array(array($branch, SQLSRV_PARAM_IN),array($startDate, SQLSRV_PARAM_IN),array($endDate, SQLSRV_PARAM_IN),array($order_no, SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN),array($stat, SQLSRV_PARAM_IN));
								$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
							
								while($data = sqlsrv_fetch_array($exec)){
									$no++;
							?>
							<tr>
								<td class="td-center"><?php echo $no;?></td>
								<td class="td-center"><?php echo $data['OFFICE_NAME'];?></td>
								<td class="td-center"><?php echo $data['ORDER_NO'];?></td>
								<td><?php echo $data['CUSTOMER_NAME'];?></td>
								<td class="td-center"><?php echo $data['SUBMIT_DATE']->format("Y-m-d H:i:s");?></td>
								<td><?php echo $data['ASSINGMENT_STATUS'];?></td>
								
								<td class="td-center">
								<a href="https://sfimos.sfi.co.id/mos_new/Survey_Frame/surveidetail_new/<?php echo $data['ORDER_NO'];?>" target="_blank" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
								</td>
							 <td style="vertical-align:middle;text-align:center;">
												 <a href="cetak_fapp.php?USERNAME=<?php echo $user;?>&order=<?php echo $data['ORDER_NO'];?>" class="btn btn-custom btn-xs" target="_blank" ><i class="fa fa-file"></i>Print FAPP</a>
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