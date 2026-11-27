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
				<h4 class="title">TASKLIST APPROVAL DEALER</h4>
				<p class="category">Tasklist</p>
			</div>
			<div class="content">
				<div class="row">
					<form action="" method="post">
						<!-- <div class="col-md-3">
							<div class="form-group">
								 <label>BRANCH</label>
                               <select name="branch" class="form-control">
											<option value="">ALL BRANCH</option>
											<?php
                                            /*
												$call2 = "{call sp_COuserFindByBranchID (?)}"; 
												$param2 = array(array($_GET['USERNAME'], SQLSRV_PARAM_IN));
												$exec2 = sqlsrv_query($conn, $call2,$param2) or die( print_r( sqlsrv_errors(), true));
												while($data2=sqlsrv_fetch_array($exec2)){
											
                                                ?>
											<option value="<?php echo $data2['Branchid'];?>" <?php if($data2['Branchid']==$branch){ echo "selected"; }?>><?php echo $data2['BranchName'];?></option>
											<?php }*/?>
										</select>
							</div>
						</div> -->
						
						<div class="col-md-3">
							<div class="form-group">
								 <label>STATUS</label>
                                
                                 <select name="stat" class="form-control">
											<option value=""  <?php if(''==$stat){ echo "selected"; }?>>ALL STATUS</option>
											<option value="OPEN" <?php if('OPEN'==$stat){ echo "selected"; }?> >OPEN</option>
											<option value="ON PROGRESS" <?php if('ON PROGRESS'==$stat){ echo "selected"; }?>>ON PROGRESS</option>
											<option value="REJECT" <?php if('REJECT'==$stat){ echo "selected"; }?>>REJECT</option>
											<option value="FINISH" <?php if('FINISH'==$stat){ echo "selected"; }?>>FINISH</option>
										
										
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
						<div class="col-md-2">
							&nbsp;<br>
							<button type="submit" class="btn btn-custom" name="submit" style="width:100%;">CARI</button>
						</div>
				
					</form>

                    </div>
				<div class="table-responsive">
					<table class="table table-bordered table-striped" id="history" style="font-size:10px;">
						<thead>
							<tr>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">NO REGISTER</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">NAMA</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">TIPE CUST</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">USER CREATE</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">USER PROSES</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">STATUS</th>
								
								
								<th class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>
								</tr>
						</thead>
						<tbody>
							<?php
								$no=0;
								$call = "{call SP_TASKLIST_PENGECEKAN_SLIK_DEALER_APPROVAL(?,?,?,?)}";
								$param = array(array($startDate, SQLSRV_PARAM_IN),
												array($endDate, SQLSRV_PARAM_IN),
												array($stat, SQLSRV_PARAM_IN),
												array($user, SQLSRV_PARAM_IN));
								$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
					
								while($data = sqlsrv_fetch_array($exec)){
									$no++;
							?>
							<tr>
								<td class="td-center"><?php echo $no;?></td>
								<td class="td-center"><?php echo $data['REQ_ID'];?></td>
								<td><?php echo $data['NAMA_CALON'];?></td>
								<td><?php echo $data['TIPE'];?></td>
								<td><?php echo $data['USER_CREATE'];?></td>
								<td><?php if($data['UPDATE_USER'] == null){ echo '-'; }else{ echo $data['UPDATE_USER']; }?></td>
								<td>	<?php
									if($data['FINAL_STATUS'] == "OPEN"){
										echo"<span class='badge' style='background-color:#d9534f;'>".$data['FINAL_STATUS']."</span>";
									}else if($data['FINAL_STATUS'] == "ON PROGRESS"){
										echo"<span class='badge' style='background-color:#428bca;'>".$data['FINAL_STATUS']."</span>";
                                    }else if($data['FINAL_STATUS'] == "REJECT"){
                                        echo"<span class='badge' style='background-color:#ffc107;'>".$data['FINAL_STATUS']."</span>";
									}else if($data['FINAL_STATUS'] == "HOLD DUKCAPIL"){
                                        echo"<span class='badge' style='background-color:#000000;'>".$data['FINAL_STATUS']."</span>";
									}else{
										echo"<span class='badge' style='background-color:#5cb85c;'>".$data['FINAL_STATUS']."</span>";
									}
								?>		</td>
									
								<td class="td-center">
								<?php if($data['FINAL_STATUS'] == "REJECT" ){ ?>		

								<a href="index.php?page=edit-slik-dealer&USERNAME=<?php echo $user;?>&REQ_ID=<?php echo $data['REQ_ID'];?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
								<?php  }else{ ?>
									<a href="index.php?page=approval-slik-dealer&USERNAME=<?php echo $user;?>&REQ_ID=<?php echo $data['REQ_ID'];?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
							
								<?php } ?>
							
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