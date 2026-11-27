<?php
$id=$_GET['id'];
$req_id=$_GET['request_id'];
$getUsername=$_GET['USERNAME'];

$flag=0;
$pengkinian_data=0;

$call2 = "{call SP_GET_DETAIL_CHECK_REQUEST_MH(?,?)}";
$param2 = array(array($id, SQLSRV_PARAM_IN),array($req_id, SQLSRV_PARAM_IN));
$exec2 = sqlsrv_query( $conn, $call2, $param2) or die( print_r( sqlsrv_errors(), true));

while($row=sqlsrv_fetch_array($exec2)){
	if($row['TYPE'] == "PASANGAN" || $row['TYPE'] == "PENJAMIN"){
		$flag = 1;
	}
}
$call5 = "{call SP_GET_DETAIL_CHECK_REQUEST_MH(?,?)}";
$param5 = array(array($id, SQLSRV_PARAM_IN),array($req_id, SQLSRV_PARAM_IN));
$exec5 = sqlsrv_query( $conn, $call5, $param5) or die( print_r( sqlsrv_errors(), true));
$data2 = sqlsrv_fetch_array($exec5);

$call3 = "{call SP_CHECK_PENGECEKAN_BY_ORDER_NO(?)}";
$param3 = array(array($data2['ORDER_NO'], SQLSRV_PARAM_IN));
$exec3 = sqlsrv_query( $conn, $call3, $param3) or die( print_r( sqlsrv_errors(), true));
$data3 = sqlsrv_fetch_array($exec3);

/*
echo "Blacklist Pemohon : ".$data3['BLACKLIST_PEMOHON'];
echo "<br>Blacklist Pasangan/Penjamin : ".$data3['BLACKLIST_PENJAMIN_PASANGAN'];
echo "<br>Dukcapil Pemohon : ".$data3['DUKCAPIL_PEMOHON'];
echo "<br>Dukcapil Pasangan/Penjamin : ".$data3['DUKCAPIL_PENJAMIN_PASANGAN'];
echo "<br>Pefindo/SLIK Pemohon : ".$data3['PEFINDO_SLIK_PEMOHON'];
echo "<br>Pefindo/SLIK Pasangan/Penjamin : ".$data3['PEFINDO_SLIK_PENJAMIN_PASANGAN'];
*/

$call7 = "{call SP_CHECK_DUKCAPIL_ERROR(?)}";
$param7 = array(array($data2['ORDER_NO'], SQLSRV_PARAM_IN));
$exec7 = sqlsrv_query( $conn, $call7, $param7) or die( print_r( sqlsrv_errors(), true));
$data7 = sqlsrv_fetch_array($exec7);


if(isset($_POST['submit_data'])){
	$assignment_id = $_POST['assignment_id'];
	$order_no = $_POST['order_no'];
	$request_id = $_POST['request_id'];
	
	$call5 = "{call SP_INSERT_RESPONSE_REQUEST_MH_NEW(?,?,?,?)}";
	$param5 = array(array($assignment_id, SQLSRV_PARAM_IN),array($request_id, SQLSRV_PARAM_IN),array($order_no, SQLSRV_PARAM_IN),array($_GET['USERNAME'], SQLSRV_PARAM_IN));
	$exec5 = sqlsrv_query( $conn, $call5, $param5) or die( print_r( sqlsrv_errors(), true));
	
	//update status jadi finish
	$call6 = "{call UPDATE_STATUS_REQUEST_MH(?,?,?)}";
	$param6 = array(array($assignment_id, SQLSRV_PARAM_IN),array($request_id, SQLSRV_PARAM_IN),array('13', SQLSRV_PARAM_IN));
	$exec6 = sqlsrv_query( $conn, $call6, $param6) or die( print_r( sqlsrv_defaults(), true)); 
	$data6= sqlsrv_fetch_array($exec6);
	
	if($exec5){
		echo"<script>alert('Data berhasil disimpan');window.location='index.php?page=hasil-pengecekan&USERNAME=".$getUsername."'</script>";
	}else{
		echo"<script>alert('Data gagal disimpan');history.back();</script>";
	}
}


if(isset($_POST['submit_koreksi'])){
	$assignment_id = $_POST['assignment_id'];
	$order_no = $_POST['order_no'];
	$request_id = $_POST['request_id'];
	

	$call6 = "{call SP_UPDATE_IS_CHECK_ASSIGNMENT(?,?,?,?,?)}";
	$param6 = array(array($assignment_id, SQLSRV_PARAM_IN),
					array($request_id, SQLSRV_PARAM_IN),
					array($order_no, SQLSRV_PARAM_IN),
					array(3, SQLSRV_PARAM_IN),
					array($getUsername, SQLSRV_PARAM_IN));
	$exec6 = sqlsrv_query( $conn, $call6, $param6) or die( print_r( sqlsrv_errors(), true));
	
	$call7 = "{call UPDATE_STATUS_REQUEST_MH(?,?,?)}";
	$param7 = array(array($assignment_id, SQLSRV_PARAM_IN),array($request_id, SQLSRV_PARAM_IN),array('9', SQLSRV_PARAM_IN));
	$exec7 = sqlsrv_query( $conn, $call7, $param7) or die( print_r( sqlsrv_defaults(), true)); 
	$data7= sqlsrv_fetch_array($exec7);
	

	
	if($exec6){
		echo"<script>alert('Data berhasil dikirim ke mh untuk di koreksi');window.location='index.php?page=hasil-pengecekan&USERNAME=".$getUsername."'</script>";
	}else{
		echo"<script>alert('Data gagal dikirim');history.back();</script>";
	}
}

/*echo "BL Pemohon : ".$data3['BLACKLIST_PEMOHON'];
echo"<br>";
echo "BL PJ : ".$data3['BLACKLIST_PENJAMIN_PASANGAN'];
echo"<br>";
echo "Dukcapil Pemohon : ".$data3['DUKCAPIL_PEMOHON'];
echo"<br>";
echo "Dukcapil PJ : ".$data3['DUKCAPIL_PENJAMIN_PASANGAN'];
echo"<br>";
echo "Eksternal Pemohon : ".$data3['PEFINDO_SLIK_PEMOHON'];
echo"<br>";
echo "Eksternal PJ : ".$data3['PEFINDO_SLIK_PENJAMIN_PASANGAN'];
echo"<br>";*/
?>
<style>
.th-custom{
	text-align:center;
	vertical-align:middle;
	font-weight:bold;
	background-color:#035c7a;
}
.td-custom{
	text-align:center;
	vertical-align:middle;
}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title" style="color:#035c7a;"><b><?php echo $data2['ORDER_NO'];?></b></h4>
				<p class="category">Nomor Order berdasarkan data yang dipilih</p>
			</div>
			<hr>
			<div class="content">
				<div class="row">
					<div class="col-md-12">
						<?php if($flag == 0){ ?>
						<div class="alert alert-danger" role="alert">
							<h5 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> WARNING!</h5>
							Mohon lengkapi data <b>PASANGAN / PENJAMIN</b> anda <a href="index.php?USERNAME=<?php echo $_GET['USERNAME'];?>&page=detail-request-mh&id=<?php echo $id;?>&request_id=<?php echo $req_id;?>" style="color:#FFF;font-weight:bold;">disini</a>
						</div>
						<?php } ?>
						<?php if($data7['RESULT_PEMOHON'] == "1"){ ?>
						<div class="alert alert-danger" role="alert">
							<h5 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> WARNING!</h5>
							Terdapat perbedaan data pada <b>PEMOHON</b>. Silahkan lakukan pengkinian data lalu upload resi pengkinian data
						</div>
						<?php } ?>
						<?php if($data7['RESULT_PENJAMIN'] == "1"){ ?>
						<div class="alert alert-danger" role="alert">
							<h5 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> WARNING!</h5>
							Terdapat perbedaan data pada <b>PENJAMIN</b>. Silahkan lakukan pengkinian data lalu upload resi pengkinian data
						</div>
						<?php } ?>
						<?php if($data7['RESULT_PASANGAN'] == "1"){ ?>
						<div class="alert alert-danger" role="alert">
							<h5 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> WARNING!</h5>
							Terdapat perbedaan data pada <b>PASANGAN</b>. Silahkan lakukan pengkinian data lalu upload resi pengkinian data
						</div>
						<?php } ?>
						<div class="table-responsive">
							<table class="table table-bordered" style="width:100%;font-size:10px;">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">No</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Nomor KTP</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Nama Lengkap</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Tanggal Lahir</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Tipe</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Nama Ibu Kandung</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Status</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$no=0;
										$call = "{call SP_GET_DETAIL_CHECK_REQUEST_MH(?,?)}";
										$param = array(array($id, SQLSRV_PARAM_IN),array($req_id, SQLSRV_PARAM_IN));
										$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));
										while($data = sqlsrv_fetch_array($exec)){
											$no++;

											$call4 = "{call SP_GET_RESPONSE_RESULT_CHECK_DUKCAPIL(?,?)}";
											$param4 = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN));
											$exec4 = sqlsrv_query( $conn, $call4, $param4) or die( print_r( sqlsrv_errors(), true));
											$data4 =sqlsrv_fetch_array($exec4);
									?>
								
									<tr>
										<td class="td-custom"><?php echo $no;?></td>
										<td class="td-custom"><?php echo $data['ID_NO'];?></td>
										<td><?php echo strtoupper($data['CUST_NAME']);?></td>
										<td class="td-custom"><?php if( $data['BIRTH_DATE']<>NULL){echo $data['BIRTH_DATE']->format('d-m-Y');}?></td>
										<td class="td-custom"><?php echo $data['TYPE'];?></td>
										<td><?php echo strtoupper($data['MOTHER_NAME']);?></td>
										<td class="td-custom"><?php if ($data4['BLACKLIST']==1 && $data4['DUKCAPIL']==1 && $data4['PEFINDO_SLIK']==1){echo "SUDAH DICEK";}else{echo "BELUM DICEK";};?></td>
										<td class="td-custom">
											<?php if ($data4['BLACKLIST']==1 && $data4['DUKCAPIL']==1 && $data4['PEFINDO_SLIK']==1){ //kalo BL && DKCPL && PFND ==1
													/*$callGenerateDP = "{call SP_GENERATE_MINIMUM_DP(?)}";
													$paramsGenerateDP = array(array($data2['ORDER_NO'], SQLSRV_PARAM_IN));
													$optionsGenerateDP =  array( "Scrollable" => "buffered" );
													$execGenerateDP = sqlsrv_query($conn, $callGenerateDP, $paramsGenerateDP, $optionsGenerateDP) or die( print_r( sqlsrv_errors(), true)); 
													$dataGenerateDP = sqlsrv_fetch_array($execGenerateDP); 
													
													$callUpdateDP = "{call SP_UPDATE_DP_IDEB(?,?,?)}";
													$paramsUpdateDP = array(array($data2['ORDER_NO'], SQLSRV_PARAM_IN),
																			array($dataGenerateDP['DP_AMOUNT'], SQLSRV_PARAM_IN),
																			array($dataGenerateDP['DP_PERCENT'], SQLSRV_PARAM_IN));
													$optionsUpdateDP =  array( "Scrollable" => "buffered" );
													$execUpdateDP = sqlsrv_query($conn, $callUpdateDP, $paramsUpdateDP, $optionsUpdateDP) or die( print_r( sqlsrv_errors(), true)); 
													$dataUpdateDP = sqlsrv_fetch_array($execUpdateDP); 
													*/
												?>
												<a href="index.php?page=detail-check&USERNAME=<?php echo $_GET['USERNAME'];?>&order_no=<?php echo $data['ORDER_NO'];?>&nik=<?php echo $data['ID_NO'];?>&id=<?php echo $id;?>&request_id=<?php echo $req_id;?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
											<?php /*} else if($data4['BLACKLIST']==1 && $data4['PEFINDO_SLIK']==1 ) { ?>
												<button type="submit" class="btn btn-custom btn-xs" disabled><i class="fa fa-search"></i> CEK DATA</button>
											<?php */ } else{ ?>
											<form action="index.php?page=check-request-mh-blacklist-new&USERNAME=<?php echo $user;?>&request_id=<?php echo $data['MOBILE_REQUEST_ID'];?>" method="post">
												<input type="hidden" name="id" value="<?php echo $id;?>">
												<input type="hidden" name="no_ktp" value="<?php echo $data['ID_NO'];?>">
												<input type="hidden" name="name" value="<?php echo $data['CUST_NAME'];?>">
												<input type="hidden" name="date" value="<?php if($data['BIRTH_DATE']<>NULL){echo $data['BIRTH_DATE']->format('Y-m-d');}?>">
												<input type="hidden" name="mother_name" value="<?php echo $data['MOTHER_NAME'];?>">
												<input type="hidden" name="tipe_cust" value="<?php echo $data['TYPE'];?>">
												<input type="hidden" name="order_no" value="<?php echo $data2['ORDER_NO'];?>">
												<button type="submit" class="btn btn-custom btn-xs"><i class="fa fa-search"></i> CEK DATA</button>
											</form>
											<?php } ?>
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						
					</div>
				</div>
				<br>
			</div>
		</div>
							<?php
						
							
							$call88 = "{call  SP_GET_STATUS_REQUEST_MH_KOREKSI(?)}";
							$param88 = array(array($data2['ORDER_NO'], SQLSRV_PARAM_IN));
							$exec88 = sqlsrv_query( $conn, $call88, $param88)  or die( print_r( sqlsrv_defaults(), true));
						    $data88 = sqlsrv_fetch_array($exec88);
						
					
							
							
							?>
		<div class="card">
		
			<div class="content">
				<div class="row">
					<div class="col-md-12">
						<?php if ($data4['BLACKLIST']==1 && $data4['DUKCAPIL']==1 && $data4['PEFINDO_SLIK']==1){ //kalo BL && DKCPL && PFND ==1 ?>
							<table class="table">
							<?php 
								
							$callDP = "{call SP_GET_DP_VBS_STAGING_ORDER(?)}";
							$paramsDP = array(array($data2['ORDER_NO'], SQLSRV_PARAM_IN));
							$optionsDP =  array( "Scrollable" => "buffered" );
							$execDP = sqlsrv_query($conn, $callDP, $paramsDP, $optionsDP)or die( print_r( sqlsrv_errors(), true));
							$dataDP = sqlsrv_fetch_array($execDP); 
							
							$callDPAwal = "{call SP_GET_DP_VBS_STAGING_ORDER_PERCENT(?,?)}";
							$paramsDPAwal = array(array($data2['ORDER_NO'], SQLSRV_PARAM_IN),
													array(str_replace(",","",$dataDP['TDP']), SQLSRV_PARAM_IN));
							$optionsDPAwal =  array( "Scrollable" => "buffered" );
							$execDPAwal = sqlsrv_query($conn, $callDPAwal, $paramsDPAwal, $optionsDPAwal)  or die( print_r( sqlsrv_defaults(), true));
							$dataDPAwal = sqlsrv_fetch_array($execDPAwal); 
					
							$callDPMH = "{call SP_GET_DP_VBS_STAGING_ORDER_PERCENT(?,?)}";
							$paramsDPMH = array(array($data2['ORDER_NO'], SQLSRV_PARAM_IN),
												array(str_replace(",","",$dataDP['DP_MH']), SQLSRV_PARAM_IN));
							$optionsDPMH =  array( "Scrollable" => "buffered" );
							$execDPMH = sqlsrv_query($conn, $callDPMH, $paramsDPMH, $optionsDPMH)  or die( print_r( sqlsrv_defaults(), true));
							$dataDPMH = sqlsrv_fetch_array($execDPMH); 
							
							?>
						
								<tr>
									<td style="width:300px;">DP AWAL</td>
									<td style="width:10px;">:</td>
									<td style="width:150px;"><input type="text" name="assignment_id" class="form-control" value="<?php echo $dataDPAwal['DP_PERCENT'];?> "readonly></td>
									<td style="width:50px;">%</td>
									<td><input type="text" name="assignment_id" class="form-control" value="<?php echo $dataDP['TDP'];?> "readonly></td>
							
								</tr>
								
								<tr>
									<td>DP MH</td>
									<td>:</td>
									<td style="width:150px;"><input type="text" name="assignment_id" class="form-control" value="<?php echo $dataDPMH['DP_PERCENT'];?> "readonly></td>
									<td style="width:50px;">%</td>
									<td><input type="text" name="assignment_id" class="form-control" value="<?php echo $dataDP['DP_MH'];?> "readonly></td>
								</tr>
								<tr>
									<td>DP REKOMENDASI </td>
									<td>:</td>
									<td style="width:150px;"><input type="text" name="assignment_id" class="form-control" value="<?php echo $dataDP['DP_IDEB_PERSEN'];?> "readonly></td>
									<td style="width:50px;">%</td>
										<td><input type="text" name="assignment_id" class="form-control" value="<?php echo $dataDP['DP_IDEB'];?> "readonly></td>
										
								</tr>
							
								
							</table>
						<?php }  ?>
							<div class="pull-right">
							<?php 
								if($data3['BLACKLIST_PEMOHON']==1 && $data3['BLACKLIST_PENJAMIN_PASANGAN']==1 && $data3['DUKCAPIL_PEMOHON']==1 && $data3['DUKCAPIL_PENJAMIN_PASANGAN']==1 && $data3['PEFINDO_SLIK_PEMOHON']==1 && $data3['PEFINDO_SLIK_PENJAMIN_PASANGAN']==1){
							?>
								<table>
							<tr>
							<td>
							<form action="" method="post">
									<input type="hidden" name="assignment_id" value="<?php echo $id;?>">
									<input type="hidden" name="request_id" value="<?php echo $req_id;?>">
									<input type="hidden" name="order_no" value="<?php echo $data2['ORDER_NO'];?>">
									<input type="submit" name="submit_koreksi" class="btn btn-custom" value="KOREKSI DP">
							</form>
							</td>
							<td>&nbsp;</td>
							<td>
								<form action="" method="post">
									<input type="hidden" name="assignment_id" value="<?php echo $id;?>">
									<input type="hidden" name="request_id" value="<?php echo $req_id;?>">
									<input type="hidden" name="order_no" value="<?php echo $data2['ORDER_NO'];?>">
									<input type="submit" name="submit_data" class="btn btn-custom" value="FINISH">
								</form>
							</td>
							</tr>
							</table>
							<?php 
								} else if($data88['MOBILE_STATUS_ID'] == '10'){ ?>
								<form action="" method="post">
									<input type="hidden" name="assignment_id" value="<?php echo $id;?>">
									<input type="hidden" name="request_id" value="<?php echo $req_id;?>">
									<input type="hidden" name="order_no" value="<?php echo $data2['ORDER_NO'];?>">
									<a href="index.php?page=reject-order&USERNAME=<?php echo $getUsername;?>&no=<?php echo $data2['ORDER_NO']?>" class="btn btn-custom btn-xs">REJECT</a>
								</form>
								
									
							<?php } else{ 
									if($data3['NIK_PEMOHON'] == $data3['NIK_PENJAMIN']){
							?>
							<table>
							<tr>
							<td>
							<form action="" method="post">
									<input type="hidden" name="assignment_id" value="<?php echo $id;?>">
									<input type="hidden" name="request_id" value="<?php echo $req_id;?>">
									<input type="hidden" name="order_no" value="<?php echo $data2['ORDER_NO'];?>">
									<input type="submit" name="submit_koreksi" class="btn btn-custom" value="KOREKSI DP">
							</form>
							</td>
							
							<td>&nbsp;</td>
							<td>
								<form action="" method="post">
									<input type="hidden" name="assignment_id" value="<?php echo $id;?>">
									<input type="hidden" name="request_id" value="<?php echo $req_id;?>">
									<input type="hidden" name="order_no" value="<?php echo $data2['ORDER_NO'];?>">
									<input type="submit" name="submit_data" class="btn btn-custom" value="FINISH">
								</form>
							</td>
							</tr>
							</table>
							<?php
									}else{
							?>
								<button type="button" class="btn btn-custom" disabled>KOREKSI DP</button>
								<button type="button" class="btn btn-custom" disabled>FINISH</button>
								<?php } }  ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>						