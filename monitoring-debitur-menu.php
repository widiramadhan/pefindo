<?php
require_once("config/configuration.php");
require_once("config/connection.php");
$date=date("Y-m-d");


if(isset($_POST['submit'])){
	 $status = 'FINISH';
	  $tipe = '03. Monitoring debitur existing';
	  $ktp = $_POST['ktp'];
	  $kontrak = $_POST['kontrak'];
}else{
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
				<h4 class="title">Monitoring Debitur</h4>
				<p class="category">Monitoring Debitur</p>
			</div>
			<div class="content">
				<div class="row">
					<form action="" method="post">
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
					<table class="table table-bordered table-striped" id="history" style="font-size:10px;" data-search="false">
						<thead>
							<tr>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">NOMOR KONTRAK</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">NAMA</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">ID NO</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">PERIOD</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>
							</tr>
						</thead>
						<tbody>
						
							<?php
								$no=0;
								$call = "{call SP_GET_TASKLIST_SLIK_V4(?,?,?,?)}";
								$param = array(array($status, SQLSRV_PARAM_IN),array($tipe, SQLSRV_PARAM_IN),array($ktp, SQLSRV_PARAM_IN),array($kontrak, SQLSRV_PARAM_IN));
								$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
								$custtype = 'PEMOHON';
								while($data = sqlsrv_fetch_array($exec)){
									$no++;
							?>
							<tr>
								<td class="td-center"><?php echo $no ;?></td>
								<td><?php echo $data['NOMOR_REGIST'];?></td>
								<td><?php echo $data['NAMA'];?></td>
								<td><?php echo $data['ID_NO'];?></td>
								<td class="td-center"><?php echo $data['CREATE_DATE']->format("Y-m");?></td>
								<td class="td-center">
								<?php 
								
								if($data['USER_PROSES'] == 'IT'){?>
								<a href="index.php?page=slik-detail-new-mapping-mix&USERNAME=<?php echo $user;?>&id=<?php echo $data['TASKLIST_SLIK_CHECK_ID'];?>&no=<?php echo $data['NOMOR_REGIST'];?>&custtype=<?php echo $custtype;?>&tipe=<?php echo $data['TIPE'];;?>&nik=<?php echo $data['ID_NO'];?>" class="btn btn-custom btn-xs" style="width:100%;margin-bottom:2%"> DETAIL</a>
								<?php }else{ ?>
								<a href="index.php?page=slik-detail-new-mapping&USERNAME=<?php echo $user;?>&id=<?php echo $data['TASKLIST_SLIK_CHECK_ID'];?>&no=<?php echo $data['NOMOR_REGIST'];?>&custtype=<?php echo $custtype;?>&tipe=<?php echo $data['TIPE'];?>&nik=<?php echo $data['ID_NO'];?>" class="btn btn-custom btn-xs" style="width:100%;margin-bottom:2%"> DETAIL</a>
	
								<?php } ?>
								<a href="index.php?page=slik-detail-summary&USERNAME=<?php echo $user;?>&id=<?php echo $data['TASKLIST_SLIK_CHECK_ID'];?>&no=<?php echo $data['NOMOR_REGIST'];?>&custtype=<?php echo $custtype;?>&tipe=<?php echo $data['TIPE'];?>&nik=<?php echo $data['ID_NO'];?>" class="btn btn-custom btn-xs" style="width:100%"> SUMMARY </a>
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
        "bFilter": false,
        "bInfo": true
	});
} );
</script>