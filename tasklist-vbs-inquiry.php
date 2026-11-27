<?php
$date=date("Y-m-d");

if(isset($_POST['submit'])){
	$startDate = $_POST['startDate'];
	$endDate = $_POST['endDate'];
	$orderNo = $_POST['order_no'];
}else{
	$startDate = date("Y-m-d");
	$endDate = date("Y-m-d");
	$orderNo = "";
}
$CA=$_GET['USERNAME'];
?>

<style>
.th-custom{
	text-align:center;
	background-color:#035c7a;
}
.td-center{
	text-align:center;
	 padding: -12px;
}
.loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 99999999999999999999999999999;
    background: url('assets/img/basicloader.gif') 50% 50% no-repeat rgb(255,255,255);
    opacity: 1;
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

.table-condensed>thead>tr>th, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>tbody>tr>td, .table-condensed>tfoot>tr>td{
    padding-top: 5px;
	padding-bottom: 5px;
	padding-right: 3px;
	padding-left: 2px;
}

.form-control{
	padding-top: 0px;
	padding-bottom: 0px;
	padding-right: 2px;
	padding-left: 7px;
	font-size:11px;
}



</style>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title"></h4>
				<p class="category"></p>
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
						<div class="col-md-3">
							<div class="form-group">
								<label>NOMOR ORDER</label>
								<div class="input-group date">
									<input type="text" class="form-control" name="order_no" autocomplete="off" value="<?php echo $orderNo;?>" placeholder="Nomor Order">
									<div class="input-group-addon">
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-2">
							&nbsp;<br>
							<button type="submit" class="btn btn-custom" name="submit" style="width:100%;">CARI</button>
						</div>
					</form>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-condensed" id="MH_Train" style="font-size:10px;">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">NO ORDER</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">CABANG</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">NAMA KONSUMEN</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">KTP</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">TANGGAL SUBMIT DATA</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$no=0;
										$call = "{call  SP_GET_VBS_RESULT_INQUIRY(?,?,?,?)}";
										$param = array(array($startDate, SQLSRV_PARAM_IN),
													   array($endDate, SQLSRV_PARAM_IN),
													    array($CA, SQLSRV_PARAM_IN),
													   array($orderNo, SQLSRV_PARAM_IN));
										$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
										while($data = sqlsrv_fetch_array($exec)){
											$no++;
											
									?> 
									<tr>
										
										<td class="td-center"><?php echo $no;?></td>
										<td class="td-center"><?php echo $data['ORDER_NO'];?></td>
										<td class="td-center"><?php echo $data['Branchname'];?></td>
										<td><?php echo $data['CUST_NAME']?></td>
										<td class="td-center"><?php echo $data['ID_NO'];?></td>
										<td class="td-center"><?php if($data['CREATE_DATE']<>NULL){echo $data['CREATE_DATE']->format('Y-m-d H:i:s');}?></td>
										<td class="td-center">
								
										<a href="index.php?USERNAME=<?php echo $user;?>&page=detail-request-mh-view&id=<?php echo $data['MOBILE_SURVEY_ASSIGNMENT_ID'];?>&request_id=<?php echo $data['MOBILE_REQUEST_ID'];?>&order_no=<?php echo $data['ORDER_NO']; ?>" class="btn btn-custom btn-xs">VIEW</a>
									
										
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
	</div>
</div>
<script type="text/javascript">
	$(window).on("load", function(){
		setTimeout(function(){
			$("#loader").fadeOut("slow");
		}, 2000);
	});
</script>
<script>
$(document).ready(function() {
    $('#MH_Train').DataTable({
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