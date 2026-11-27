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
							<table class="table table-bordered table-striped" id="MH_Train" style="font-size:10px;">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">NO ORDER</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">NAMA KONSUMEN</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">DEALER_NAME</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">CA</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">ID_NO</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">TANGGAL_REQUEST</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">TANGGAL_ORDER</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">STATUS</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$no=0;
										$call = "{call  SP_GETLIST_VERIFIKASI_DOC_FINAL(?,?,?,?)}";
										$param = array(array($startDate, SQLSRV_PARAM_IN),
													   array($endDate, SQLSRV_PARAM_IN),
													   array($orderNo, SQLSRV_PARAM_IN),
													   array($CA, SQLSRV_PARAM_IN));
										$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
										while($data = sqlsrv_fetch_array($exec)){
											$no++;
											$call4 = "{call  SP_GETLIST_APV_NO(?)}";
											$param4 = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN));
											$exec4 = sqlsrv_query( $conn, $call4, $param4) or die( print_r( sqlsrv_errors(), true)); 
											$data4 = sqlsrv_fetch_array($exec4)
									?> 
									<tr>
										
										<td class="td-center"><?php echo $no;?></td>
										<td class="td-center"><?php echo $data['ORDER_NO']?></td>
										<td><?php echo $data['CUSTOMER_NAME']?></td>
										<td class="td-center"><?php echo $data['DEALER_NAME'];?></td>
										<td class="td-center"><?php echo $data['CA'];?></td>
										<td class="td-center"><?php echo $data['ID_NO'];?></td>
										
										<td class="td-center"><?php if($data['TANGGAL_REQUEST']<>NULL){echo $data['TANGGAL_REQUEST']->format('Y-m-d H:i:s');}?></td>
										<td class="td-center"><?php if($data['TANGGAL_ORDER']<>NULL){echo $data['TANGGAL_ORDER']->format('Y-m-d H:i:s');}?></td>
										<td class="td-center"><b><?php echo $data['STATUS'];?></b></td>
										<td class="td-center">
										<?php if($data4['IS_VERIFIED']=='2'){?>
										<a href="index.php?USERNAME=<?php echo $user;?>&page=return-approval&id=<?php echo $data['MOBILE_ASSIGNMENT_ID'];?>&request_id=<?php echo $data['MOBILE_REQUEST_ID'];?>&order_no=<?php echo $data['ORDER_NO']; 
										?>&apvno=<?php echo $data4['APV_NO'];?>&user=<?php echo $data4['CREATE_USER'];?>" class="btn btn-custom btn-xs">DETAIL</a>
										<?php }else {?>
										<a href="index.php?USERNAME=<?php echo $user;?>&page=detail-koreksi-mh&id=<?php echo $data['MOBILE_ASSIGNMENT_ID'];?>&request_id=<?php echo $data['MOBILE_REQUEST_ID'];?>&order_no=<?php echo $data['ORDER_NO']; ?>" class="btn btn-custom btn-xs">DETAIL</a>
										
										</td>
									</tr>
									<?php
										} }
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