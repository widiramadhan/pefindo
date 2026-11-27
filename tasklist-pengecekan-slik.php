<?php
require_once("config/configuration.php");
require_once("config/connection.php");
$date=date("Y-m-d");


if(isset($_POST['submit'])){
	$startDate = $_POST['startDate'];
	$endDate = $_POST['endDate'];
	 $status = $_POST['status'];
	  $tipe = $_POST['tipe'];
	  $ktp = $_POST['ktp'];
	  $kontrak = $_POST['kontrak'];
}else{
	$startDate = date("Y-m-01");
	$endDate = date("Y-m-d");
	 $status = "OPEN";
	  $tipe = "";
	  $ktp = "";
	   $kontrak = "";
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
				<h4 class="title">TASKLIST SLIK</h4>
				<p class="category">TASKLIST SLIK</p>
			</div>
			<div class="content">
				<div class="row">
					<form action="" method="post">
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
						 <div class="col-md-1">
                            <div class="form-group">
                                <label>STATUS</label>
                                <select name="status" class="form-control">
                                    <option value="" <?= ('' == $status) ? "selected" : "" ?>>ALL STATUS</option>
                                    <option value="OPEN" <?= ('OPEN' == $status) ? "selected" : "" ?>>OPEN</option>
                                    <option value="ON PROGRESS" <?= ('ON PROGRESS' == $status) ? "selected" : "" ?>>ON
                                        PROGRESS</option>
                                    <option value="REJECT" <?= ('REJECT' == $status) ? "selected" : "" ?>>REJECT</option>
                                    <option value="FINISH" <?= ('FINISH' == $status) ? "selected" : "" ?>>FINISH</option>
                                </select>
                            </div>
                        </div>
						 <div class="col-md-1">
                            <div class="form-group">
                                <label>TIPE</label>
                                <select name="tipe" class="form-control">
                                    <option value="" <?= ('' == $tipe) ? "selected" : "" ?>>ALL TIPE</option>
                                    <option value="03. Monitoring debitur existing" <?= ('03. Monitoring debitur existing' == $tipe) ? "selected" : "" ?>>03. Monitoring debitur existing</option>
                                    <option value="07. Penilaian karyawan/calon karyawan" <?= ('07. Penilaian karyawan/calon karyawan' == $tipe) ? "selected" : "" ?>>07. Penilaian karyawan/calon karyawan</option>
                                    <option value="08. Penilaian calon vendor" <?= ('08. Penilaian calon vendor' == $tipe) ? "selected" : "" ?>>08. Penilaian calon vendor</option>
                             
                                </select>
                            </div>
                        </div>
						<div class="col-md-2">
							<div class="form-group">
								<label>ID NO</label>
								
									<input type="text" class="form-control" name="ktp" id="ktp"  value="<?php echo $ktp;?>">
									
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Nomor Kontrak</label>
							
									<input type="text" class="form-control" name="kontrak" id="kontrak"  value="<?php echo $kontrak;?>">
									
								
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
								<th class="th-custom" style="color:#FFF;font-weight:bold;">REQ_ID</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">NOMOR REGIST</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">TIPE</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">NAMA</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">ID NO</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">STATUS</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">CHECKED BY</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">CREATE DATE</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$no=0;
								$call = "{call SP_GET_TASKLIST_SLIK_V3_USER(?,?,?,?,?,?,?)}";
								$param = array(array($startDate, SQLSRV_PARAM_IN),array($endDate, SQLSRV_PARAM_IN),
										  array($status, SQLSRV_PARAM_IN),array($tipe, SQLSRV_PARAM_IN),
										  array($ktp, SQLSRV_PARAM_IN),array($kontrak, SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
								$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
								$custtype = 'PEMOHON';
								while($data = sqlsrv_fetch_array($exec)){
									$no++;
									$reqPrefix = substr($data['REQ_ID'], 0, 7);
									$reqType = ($reqPrefix == 'REQ_V_I') ? 'INDIVIDU' : (($reqPrefix == 'REQ_C_I') ? 'COMPANY' : 'INDIVIDU');
							?>
							<tr>
								<td class="td-center"><?php echo $no;?></td>
								<td class="td-center"><?php echo $data['REQ_ID'];?></td>
								<td><?php echo $data['NOMOR_REGIST'];?></td>
								<td><?php echo $data['TIPE'];?></td>
								<td><?php echo $data['NAMA'];?></td>
								<td><?php echo $data['ID_NO'];?></td>
								<td class="td-center">
									<?php
									if($data['STATUS'] == "OPEN"){
										echo"<span class='badge' style='background-color:#d9534f;'>".$data['STATUS']."</span>";
									}else if($data['STATUS'] == "ON PROGRESS"){
										echo"<span class='badge' style='background-color:#428bca;'>".$data['STATUS']."</span>";
                                    }else if($data['STATUS'] == "REJECT"){
                                        echo"<span class='badge' style='background-color:#ffc107;'>".$data['STATUS']."</span>";
									}else if($data['STATUS'] == "HOLD DUKCAPIL"){
                                        echo"<span class='badge' style='background-color:#000000;'>".$data['STATUS']."</span>";
									}else{
										echo"<span class='badge' style='background-color:#5cb85c;'>".$data['STATUS']."</span>";
									}
								?>	
								</td>
								<td><?php echo $data['USER_PROSES'];?></td>
								<td class="td-center"><?php echo $data['CREATE_DATE']->format("Y-m-d H:i:s");?></td>
								<td class="td-center">
								<?php 
								if($data['STATUS'] == "FINISH"){
								if($data['STATUS'] == "FINISH" && $data['TIPE'] == '03. Monitoring debitur existing'){?>
								
								<a href="index.php?page=slik-detail-new-mapping-mix&USERNAME=<?php echo $user;?>&id=<?php echo $data['TASKLIST_SLIK_CHECK_ID'];?>&no=<?php echo $data['NOMOR_REGIST'];?>&custtype=<?php echo $custtype;?>&tipe=<?php echo $data['TIPE'];;?>&nik=<?php echo $data['ID_NO'];?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
								<?php }else if($data['STATUS'] == "FINISH" && $data['TIPE'] == '08. Penilaian Calon Vendor' && $reqType == 'COMPANY'){?>
								
								<a href="index.php?page=slik-detail-new-company&USERNAME=<?php echo $user;?>&id=<?php echo $data['TASKLIST_SLIK_CHECK_ID'];?>&no=<?php echo $data['NOMOR_REGIST'];?>&custtype=<?php echo $custtype;?>&tipe=<?php echo $data['TIPE'];;?>&nik=<?php echo $data['ID_NO'];?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
								<?php }else if($data['STATUS'] == "FINISH" && $data['TIPE'] == '08. Penilaian Calon Vendor' && $reqType == 'INDIVIDU'){?>
								
								<a href="index.php?page=slik-detail-new-mapping&USERNAME=<?php echo $user;?>&id=<?php echo $data['TASKLIST_SLIK_CHECK_ID'];?>&no=<?php echo $data['NOMOR_REGIST'];?>&custtype=<?php echo $custtype;?>&tipe=<?php echo $data['TIPE'];;?>&nik=<?php echo $data['ID_NO'];?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
								<?php }else{ ?>
								<a href="index.php?page=slik-detail-new-mapping&USERNAME=<?php echo $user;?>&id=<?php echo $data['TASKLIST_SLIK_CHECK_ID'];?>&no=<?php echo $data['NOMOR_REGIST'];?>&custtype=<?php echo $custtype;?>&tipe=<?php echo $data['TIPE'];;?>&nik=<?php echo $data['ID_NO'];?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
								<?php } }
								if($data['STATUS'] == "REJECT"){ ?>
										
								<a href="index.php?page=note-detail-new-mapping&USERNAME=<?php echo $user;?>&id=<?php echo $data['TASKLIST_SLIK_CHECK_ID'];?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
							<?php } else if($data['TIPE'] == '08. Penilaian calon vendor' && $data['STATUS'] == "OPEN" ){ ?>
										
								<a href="index.php?page=detail-calon-vendor&USERNAME=<?php echo $user;?>&req_id=<?php echo $data['TASKLIST_SLIK_CHECK_ID'];?>&req_id1=<?php echo $data['REQ_ID'];?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
								<?php } else if($data['TIPE'] == '08. Penilaian calon vendor' && $data['STATUS'] == "ON PROGRESS" ){ ?>
										
								<a href="index.php?page=detail-calon-vendor&USERNAME=<?php echo $user;?>&req_id=<?php echo $data['TASKLIST_SLIK_CHECK_ID'];?>&req_id1=<?php echo $data['REQ_ID'];?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
							<?php }else if($data['TIPE'] == '03. Monitoring debitur existing' && $data['STATUS'] == "OPEN" ){ ?>
										
								<a href="index.php?page=detail-debitur-existing&USERNAME=<?php echo $user;?>&req_id=<?php echo $data['TASKLIST_SLIK_CHECK_ID'];?>&req_id1=<?php echo $data['REQ_ID'];?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
							<?php }else if($data['TIPE'] == '03. Monitoring debitur existing' && $data['STATUS'] == "ON PROGRESS" ){ ?>
										
								<a href="index.php?page=detail-debitur-existing&USERNAME=<?php echo $user;?>&req_id=<?php echo $data['TASKLIST_SLIK_CHECK_ID'];?>&req_id1=<?php echo $data['REQ_ID'];?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
							<?php }else if($data['TIPE'] == '07. Penilaian karyawan/calon karyawan' && $data['STATUS'] == "OPEN" ) {?>
								<a href="index.php?page=detail-karyawan-baru&USERNAME=<?php echo $user;?>&req_id=<?php echo $data['TASKLIST_SLIK_CHECK_ID'];?>&req_id1=<?php echo $data['REQ_ID'];?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
								<?php }else if($data['TIPE'] == '07. Penilaian karyawan/calon karyawan' && $data['STATUS'] == "ON PROGRESS" ) {?>
								<a href="index.php?page=detail-karyawan-baru&USERNAME=<?php echo $user;?>&req_id=<?php echo $data['TASKLIST_SLIK_CHECK_ID'];?>&req_id1=<?php echo $data['REQ_ID'];?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
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