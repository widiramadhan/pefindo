<?php
$date=date("Y-m-d");

if(isset($_POST['submit'])){
	$orderNo = $_POST['order_no'];
	$dealerName = $_POST['dealer_name'];
	$custName = $_POST['cust_name'];
}else{
	$orderNo = "";
	$dealerName = "";
	$custName = "";
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
				<form action="" method="post">
					<div class="row">
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
						<div class="col-md-3">
							<div class="form-group">
								<label>NAMA DEALER</label>
								<div class="input-group date">
									<input type="text" class="form-control" name="dealer_name" autocomplete="off" value="<?php echo $dealerName;?>" placeholder="Nama Dealer">
									<div class="input-group-addon">
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>NAMA KONSUMEN</label>
								<div class="input-group date">
									<input type="text" class="form-control" name="cust_name" autocomplete="off" value="<?php echo $custName;?>" placeholder="Nama Konsumen">
									<div class="input-group-addon">
									</div>
								</div>
							</div>
						</div>
						<!-- <div class="col-md-3">
							<div class="form-group">
								<label>CA</label>
								<div class="input-group date">
									<input type="text" class="form-control" name="cust_name" autocomplete="off" value="<?php //echo $custName;?>">
									<div class="input-group-addon">
									</div>
								</div>
							</div>
						</div> -->
					</div>
					<div class="row">	
						<div class="col-md-12">
							<button type="submit" class="btn btn-custom" name="submit">CARI</button>
							<button type="reset" class="btn btn-custom" name="reset" >BATAL</button>
						</div>
					</div>
				</form>
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
										<th class="th-custom" style="color:#FFF;font-weight:bold;">ALAMAT</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">NAMA DEALER</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">TGL ORDER</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">TGL REQUEST</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">STATUS</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$no=0;
										$call = "{call  SP_GET_REQUEST_MH(?,?,?,?)}";
										$param = array(array($orderNo, SQLSRV_PARAM_IN),array($dealerName, SQLSRV_PARAM_IN),array($custName, SQLSRV_PARAM_IN),array($CA, SQLSRV_PARAM_IN));
										$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
										while($data = sqlsrv_fetch_array($exec)){
											$no++;
									?> 
									<tr>
										
										<td class="td-center"><?php echo $no;?></td>
										<td class="td-center"><?php echo $data['ORDER_NO']?></td>
										<td><?php echo $data['CUSTOMER_NAME']?></td>
										<td><?php echo strtoupper($data['CUSTOMER_ADDRESS']);?></td>
										<td><?php echo $data['DEALER_NAME']?></td>
										<td class="td-center"><?php if($data['TANGGAL_ORDER']<>NULL){echo $data['TANGGAL_ORDER']->format('Y-m-d H:i:s');}?></td>
										<td class="td-center"><?php if($data['TANGGAL_REQUEST']<>NULL){echo $data['TANGGAL_REQUEST']->format('Y-m-d H:i:s');}?></td>
										<td class="td-center">
										<b><?php echo  $data['STATUS'];?></b>
											<?php
											
												/*
												if($data['MOBILE_STATUS_ID'] == 1){
													echo"<span class='badge' style='background-color:#d9534f'>OPEN</span>";
												}else if($data['MOBILE_STATUS_ID'] == 2){
													echo"<span class='badge' style='background-color:#428bca'>ON PROGRESS</span>";
												}else if($data['MOBILE_STATUS_ID'] == 3){
													echo"<span class='badge' style='background-color:#5cb85c'>FINISH</span>";
												}*/
											?>
										</td>
										<td class="td-center">
										
										
											<a href="index.php?USERNAME=<?php echo $user;?>&page=detail-request-mh1&id=<?php echo $data['MOBILE_ASSIGNMENT_ID'];?>&request_id=<?php echo $data['MOBILE_REQUEST_ID'];?>&order_no=<?php echo $data['ORDER_NO']; ?>" class="btn btn-custom btn-xs">DETAIL</a>
											
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