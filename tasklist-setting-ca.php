<?php
require_once("config/configuration.php");
require_once("config/connection.php");
$date=date("Y-m-d");


if(isset($_POST['submit'])){
	 $stat = $_POST['stat'];
	
	$startDate = $_POST['startDate'];
	$endDate = $_POST['endDate'];
}else{
	$stat = "";

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
				<h4 class="title">Setting CA Non Aktif</h4>
				<p class="category">List Cabang CA Non Aktif</p>
			</div>
			<div class="content">
				<div class="row">
					<form action="" method="post">
						
						<div class="col-md-2">
							
                            <a href="index.php?page=add-setting-ca&USERNAME=<?php echo $user;?>" class="btn btn-primary btn-sm" id="<?php echo $data['M_MUTASI_ID']; ?>"> <i class="fa fa-plus"></i>Add Cabang Baru</a>
							
						</div>
				
					</form>

                    </div>
				<div class="table-responsive">
					<table class="table table-bordered table-striped" id="history" style="font-size:10px;">
						<thead>
							<tr>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">BRANCH CODE</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">BRANCH NAME</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">CREATE DATE</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">USER CREATE</th>
								
								
								<th class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>
								</tr>
						</thead>
						<tbody>
							<?php
								$no=0;
								$call = "{call SP_GET_SETTING_CA_NON }";
							
								$exec = sqlsrv_query( $conn, $call) or die( print_r( sqlsrv_errors(), true)); 
					
								while($data = sqlsrv_fetch_array($exec)){
									$no++;
							?>
							<tr>
								<td class="td-center"><?php echo $no;?></td>
								<td class="td-center"><?php echo $data['BRANCH_ID'];?></td>
								<td class="td-center"><?php echo $data['OFFICE_NAME'];?></td>
								<td><?php echo $data['DTM_CRT'] ? $data['DTM_CRT']->format("Y-m-d") : ''; ?></td>
								
								<td><?php echo $data['USR_CRT'];?></td>
								<td class="td-center">
									<a href="index.php?page=detail-setting-ca&USERNAME=<?php echo $user;?>&branch_id=<?php echo $data['BRANCH_ID'];?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
                                    &nbsp;
                                    <a onclick="myFunction1()" href="index.php?page=delete-setting-ca&USERNAME=<?php echo $user;?>&branch_id=<?php echo $data['BRANCH_ID'];?>" class="btn btn-danger btn-xs" > <i class="fa fa-trash"></i>Delete</a>
							
							
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
function myFunction1() {
    alert("Yakin ingin menghapus cabang ini ?");
}
</script>
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