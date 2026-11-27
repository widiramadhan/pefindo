<?php
require_once("config/configuration.php");
require_once("config/connection.php");
if(isset($_POST['submit'])){
	
	$status=$_POST['status'];
	$nik=$_POST['nik'];
	$startDate =$_POST['startDate'];
	$endDate = $_POST['endDate'];
	$call = "{call SP_GET_LOCK_DATA_BY_BRANCH_NEW_3(?,?,?,?,?)}";
	$param = array(array($user, SQLSRV_PARAM_IN),
				   array($nik,SQLSRV_PARAM_IN),
				   array($status,SQLSRV_PARAM_IN),
				   array($startDate,SQLSRV_PARAM_IN),
				   array($endDate,SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 			

	
}
else{
	$status="";
	$nik="";
	$startDate = date("Y-m-d");
	$endDate = date("Y-m-d");
	$call = "{call SP_GET_LOCK_DATA_BY_BRANCH_NEW_3(?,?,?,?,?)}";
	$param = array(array($user, SQLSRV_PARAM_IN),
				   array($nik,SQLSRV_PARAM_IN),
				   array($status,SQLSRV_PARAM_IN),
				    array('1999-04-26',SQLSRV_PARAM_IN),
				   array('1999-04-26',SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 	
//	$prs= '';
	//$nik= '';
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
				<h4 class="title">Cek Ulang Dukcapil</h4>
				<p class="category">Pilih data untuk dicek data dukcapilnya</p>
			</div>
			<div class="content">
			
					 <form action="" method="post">
						<div class="col-md-3">
							<div class="form-group">
								<label>Status</label>
								<select name="status" class="form-control">
									<option value="1" <?php if($status=='1') {echo 'selected';} ?>> ALL STATUS</option>
									<option value="2" <?php if($status=='2') {echo 'selected';} ?>>SUDAH UPLOAD RESI</option>
									<option value="3" <?php if($status=='3') {echo 'selected';} ?>>BELUM UPLOAD RESI</option>
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
						<div class="col-md-3">
							<div class="form-group">
								<label>NIK</label>
									<input type="text" class="form-control" name="nik" id="nik" value="<?php echo $nik;?>">
							</div>
						</div>
				
					<div class="pull-right">
						<input type="submit" name="submit" class="btn btn-custom" value="CARI">
					</div>
					<div style="clear:both;"></div>
				</form>
				<hr>
				
				<div class="table-responsive">
					<table class="table table-bordered table-striped" id="history" style="font-size:10px;">
						<thead>
							<tr>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">PROSPECT NO / ORDER NO</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">NIK</th>
								<!--<th class="th-custom" style="color:#FFF;font-weight:bold;">CUST NAME</th>-->
								<th class="th-custom" style="color:#FFF;font-weight:bold;">TIPE</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">USER REQUEST</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">LOCK DATE</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">STATUS DUKCAPIL</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">JUMLAH PENGECEKAN</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">TGL TERAKHIR PENGECEKAN</th>
								<th class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$no=0;
								
								while($data = sqlsrv_fetch_array($exec)){
									$no++;
							
										$callLast = "{call SP_GET_STATUS_DUKCAPIL_TERAKHIR(?,?)}";
										$paramLast = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),
													   array($data['ID_NO'],SQLSRV_PARAM_IN));
										$execLast = sqlsrv_query( $conn, $callLast, $paramLast) or die( print_r( sqlsrv_errors(), true)); 
										$dataLast= sqlsrv_fetch_array($execLast);	
										
										$callTipe = "{call SP_GET_TIPE_CUSTOMER(?,?)}";
										$paramTipe = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),
													   array($data['ID_NO'],SQLSRV_PARAM_IN));
										$execTipe = sqlsrv_query( $conn, $callTipe, $paramTipe) or die( print_r( sqlsrv_errors(), true)); 
										$dataTipe= sqlsrv_fetch_array($execTipe);		
														
							?>
							<tr>
								<td class="td-center"><?php echo $no;?></td>
								<td class="td-center"><?php echo $data['PROSPECT_NO'];?></td>
								<td class="td-center"><?php echo $data['ID_NO'];?></td>
								<!--<td class="td-center"><?php //echo $data['CUST_NAME'];?></td>-->
								<?php if (strpos($data['PROSPECT_NO'], 'PRS') !== false) { ?>
								<td class="td-center"><?php echo $dataTipe['TIPE'];?></td>
								<?php }else{ ?>
								<td class="td-center"><?php echo $data['TYPE'];?></td>
								<?php } ?>
								<td class="td-center"><?php echo $data['CREATE_USER'];?></td>
								<td class="td-center"><?php echo $data['CREATE_DATE']->format("Y-m-d H:i:s");?></td>
							
							<td class="td-center"><?php echo $dataLast['STATUS'];?>
							<td class="td-center"><?php echo $data['VOID'];?>
						
							<td class="td-center">	<?php if($data['TGL_PENGECEKAN']<>NULL){echo $data['TGL_PENGECEKAN']->format('Y-m-d H:i:s');}else{echo"-";}?>
							</td>
								<td class="td-center">
								<?php  IF ($data['STATUS_DUKCAPIL'] == 'ERROR DUKCAPIL'){?>
								<a href="index.php?USERNAME=<?php echo $user;?>&page=cek-ulang-dukcapil-detail-new&id=<?php echo $data['LOG_CHECK_BYSOURCE_ID'];?>" class="btn btn-custom btn-xs" onclick="return confirm('Proses unlock akan dikenakan biaya hit ke Dukcapil, apakah anda yakin ingin proses?')">CHECK</a>
								<?php }else{ ?>
									<a href="index.php?USERNAME=<?php echo $user;?>&page=cek-ulang-dukcapil-detail-new&id=<?php echo $data['LOG_CHECK_BYSOURCE_ID'];?>" class="btn btn-custom btn-xs" onclick="return confirm('Proses unlock akan dikenakan biaya hit ke Dukcapil, apakah anda yakin ingin proses?')">CHECK</a>
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