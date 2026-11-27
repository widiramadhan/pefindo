<?php
$date=date("Y-m-d");
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
				<h4 class="title">Check Data</h4>
				<p class="category">Check Data Request MH</p>
			</div>
			<div class="content">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-bordered table-striped" id="MH_Train" style="font-size:10px;">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
											<th class="th-custom" style="color:#FFF;font-weight:bold;">BRANCH</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">BRANCH NAME</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">NO ORDER</th>
									
										<th class="th-custom" style="color:#FFF;font-weight:bold;">NO KTP</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">NAMA PEMOHON</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">TANGGAL LAHIR</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">NAMA IBU KANDUNG</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$no=0;
										$call = "{call  SP_GET_CHECK_REQUEST_MH(?)}";
										$param = array(array($CA, SQLSRV_PARAM_IN));
										$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
										while($data = sqlsrv_fetch_array($exec)){
											$no++;
									//?> 
									<tr>
										
										<td class="td-center"><?php echo $no;?></td>
										<td class="td-center"><?php echo $data['BRANCH_ID'];?></td>
										<td class="td-center"><?php echo $data['OFFICE_NAME'];?></td>
										<td class="td-center"><?php echo $data['ORDER_NO'];?></td>
										
										<td class="td-center"><?php echo $data['ID_NO'];?></td>
										<td><?php echo strtoupper($data['CUST_NAME']);?></td>
										<td class="td-center"><?php if($data['BIRTH_DATE']<>NULL){echo $data['BIRTH_DATE']->format('Y-m-d');}?></td>
										<td><?php echo strtoupper($data['MOTHER_NAME']);?></td>
										<td class="td-center">
											<?php /* if($data['BRANCH_ID'] == '1006' || $data['BRANCH_ID'] == '1506' )      {?>
											<a href="index.php?page=detail-pengecekan-mh-branch1&USERNAME=<?php echo $user;?>&id=<?php echo $data['MOBILE_ASSIGNMENT_ID']?>&request_id=<?php echo $data['MOBILE_REQUEST_ID'];?>" class="btn btn-custom btn-sm"><i class="fa fa-search"></i> PILIH</a>
											<?php } else if($data['BRANCH_ID'] == '1502' || $data['BRANCH_ID'] == '1011' )      {?>
											<a href="index.php?page=detail-pengecekan-mh-branch&USERNAME=<?php echo $user;?>&id=<?php echo $data['MOBILE_ASSIGNMENT_ID']?>&request_id=<?php echo $data['MOBILE_REQUEST_ID'];?>" class="btn btn-custom btn-sm"><i class="fa fa-search"></i> PILIH</a>
											<?php }else{ */?>
											<a href="index.php?page=detail-pengecekan-mh&USERNAME=<?php echo $user;?>&id=<?php echo $data['MOBILE_ASSIGNMENT_ID']?>&request_id=<?php echo $data['MOBILE_REQUEST_ID'];?>" class="btn btn-custom btn-sm"><i class="fa fa-search"></i> PILIH</a>
											<?php// } ?>
										</td>
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