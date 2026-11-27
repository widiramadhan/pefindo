<?php
require_once("config/configuration.php");
require_once("config/connection.php");
$date=date("Y-m-d");


if(isset($_POST['submit'])){
	$branch = $_POST['branch'];
	 $noRegist = $_POST['noRegist'];

	$startDate = $_POST['startDate'];
	$endDate = $_POST['endDate'];
}else{
	$branch = "";
	$noRegist = "";

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
.disabled-link {
    pointer-events: none;   /* disable click */
    color: #999;            /* gray text */
    text-decoration: none;
    cursor: default;
}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">HISTORY</h4>
				<p class="category">Pengecekan Dukcapil</p>
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
						<div class="col-md-2">
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
						<div class="col-md-2">
							<div class="form-group">
								<label>No Register</label>
								<input type="text" class="form-control" name="noRegist" id="noRegist" autocomplete="off" value="<?php echo $noRegist;?>">
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
								<th class="th-custom" style="color:#FFF;font-weight:bold;">CABANG</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">NIK</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">NAMA</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">TUJUAN PERMINTAAN</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">REQ BY</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">TANGGAL REQUEST</th>
								
								
								<th class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>
								</tr>
						</thead>
						<tbody>
							<?php
								$no=0;
								$call = "{call SP_HISTORY_DUKCAPIL_STAGING(?,?,?,?)}";
								$param = array(array($branch, SQLSRV_PARAM_IN),
												array($startDate, SQLSRV_PARAM_IN),
												array($endDate, SQLSRV_PARAM_IN),
												array($noRegist, SQLSRV_PARAM_IN));
								$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
					
								while($data = sqlsrv_fetch_array($exec)){
									$no++;
							?>
							<tr>
								<td class="td-center"><?php echo $no;?></td>
								<td class="td-center"><?php echo $data['NOMOR_REGIST'];?></td>
								<td><?php echo $data['OFFICE_CODE']." - ".$data['OFFICE_NAME'];?></td>
								<td><?php echo $data['ID_NO'];?></td>
								<td><?php echo $data['NAMA_PEMOHON'];?></td>
								<td><?php echo $data['DESCRIPTION'];?></td>
								<td><?php echo $data['CREATE_USER'];?></td>
								<td><?php echo $data['CREATE_DATE']->format('m-d-Y');?></td>
									
								<td class="td-center">
									<?php
								$callGetRole = "{call SP_GET_ROLE_BY_USERNAME(?)}";
								$paramGetRole = array(array($user, SQLSRV_PARAM_IN));
								$execGetRole = sqlsrv_query( $conn, $callGetRole, $paramGetRole) or die( print_r( sqlsrv_errors(), true));
								$dataGetRole = sqlsrv_fetch_array($execGetRole);
								if($dataGetRole['ID_DEPT'] == 59 || $dataGetRole['ID_DEPT'] == 78 || $user == $data['CREATE_USER'] || $user == $data['USER_APPROVE']){
							?>
									<a href="index.php?page=detail-history-cek-dukcapil&USERNAME=<?php echo $user;?>&REQ_ID=<?php echo $data['REQ_ID'];?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> RESULT</a>
							<?php
								}else{
							?>
									<a href="#" aria-disabled="true" class="disabled-link" tabindex="-1"><i class="fa fa-eye"></i> RESULT</a>
							<?php
									
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