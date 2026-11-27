<?php
require_once("config/configuration.php");
$Warning_Data = "";

if(isset($_POST['check'])){
	$prospect=$_POST['prospect_no'];
	$no_ktp=$_POST['no_ktp'];
	$nama=$_POST['name'];
	$date=$_POST['date'];
	$mother_nm=$_POST['mother_name'];
	$birth_place=$_POST['birth_place'];
	$siapanih=$_POST['tipe_cust'];
	$status_kawin=$_POST['status_kawin'];
	$getUsername=$_GET['USERNAME'];
	
	$call_bls = "{call SP_CHECK_PEFINDO_BLACKLIST(?,?,?,?,?,?,?)}";
	$params_bls = array(
					array($no_ktp, SQLSRV_PARAM_IN),
					array($nama, SQLSRV_PARAM_IN),
					array($date, SQLSRV_PARAM_IN),
					array($birth_place, SQLSRV_PARAM_IN),
					array($mother_nm, SQLSRV_PARAM_IN),
					array($prospect, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN)
				);
	$options =  array( "Scrollable" => "buffered" );
	$exec_bls = sqlsrv_query($conn, $call_bls, $params_bls, $options) or die( print_r( sqlsrv_errors(), true)); 
}else{
	$prospect=$_POST['prospect_no'];
	$no_ktp=$_POST['no_ktp'];
	$nama=$_POST['name'];
	$date=$_POST['date'];
	$mother_nm=$_POST['mother_name'];
	$birth_place=$_POST['birth_place'];
	$siapanih=$_POST['tipe_cust'];
	$status_kawin=$_POST['status_kawin'];
	$getUsername=$_GET['USERNAME'];
}

$call7 = "{call SP_CHECK_DUKCAPIL_ERROR_ALL(?,?)}";
$param7 = array(array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN));
$exec7 = sqlsrv_query( $conn, $call7, $param7) or die( print_r( sqlsrv_errors(), true));
$data7 = sqlsrv_fetch_array($exec7);

$callGetOrder = "{call SP_GET_ORDER_FROM_PROSPECT(?)}";
$paramGetOrder = array(array($prospect, SQLSRV_PARAM_IN));
$optionGetOrder = array( "Scrollable" => "buffered" );
$execGetOrder = sqlsrv_query($conn, $callGetOrder, $paramGetOrder,$optionGetOrder) or die( print_r( sqlsrv_errors(), true));
$dataGetOrder =  sqlsrv_fetch_array($execGetOrder);


$callChecked = "{call SP_GET_CHECKED_PEFINDO_SLIK(?,?)}";
$paramChecked = array(array($dataGetOrder['ORDER_NO'], SQLSRV_PARAM_IN),
						array($no_ktp, SQLSRV_PARAM_IN));
$optionChecked = array( "Scrollable" => "buffered" );
$execChecked = sqlsrv_query($conn, $callChecked, $paramChecked,$optionChecked) or die( print_r( sqlsrv_errors(), true));
$dataChecked =  sqlsrv_fetch_array($execChecked);
$dataCheckedLog=sqlsrv_num_rows($execChecked);

$callCheckedProspect = "{call SP_GET_CHECKED_PEFINDO_SLIK(?,?)}";
$paramCheckedProspect = array(array($prospect, SQLSRV_PARAM_IN),
						array($no_ktp, SQLSRV_PARAM_IN));
$optionCheckedProspect = array( "Scrollable" => "buffered" );
$execCheckedProspect = sqlsrv_query($conn, $callCheckedProspect, $paramCheckedProspect,$optionCheckedProspect) or die( print_r( sqlsrv_errors(), true));
$dataCheckedProspect =  sqlsrv_fetch_array($execCheckedProspect);
$dataCheckedLogProspect=sqlsrv_num_rows($execCheckedProspect);



$callDate = "{call SP_GET_DATE_SLIK}";
$execDate = sqlsrv_query( $conn, $callDate) or die( print_r( sqlsrv_errors(), true));
$dataDate = sqlsrv_fetch_array($execDate);
	

?>
<style>
.th-custom{
	text-align:center;
	vertical-align:middle;
	font-weight:bold;
}
.td-custom{
	text-align:center;
	vertical-align:middle;
}
</style>
<div class="row">
	<?php if($Warning_Data <> ""){?>
	<div class="alert alert-danger fade in">
		<strong>Danger!</strong><br>
		<?php echo $Warning_Data;?>
	</div>
	<br>
	<?php } ?>
	<br>
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Blacklist Internal</h4>
				<p class="category">Pengecekan Blacklist Internal</p>
			</div>
			<hr>
			<div class="content">
				<div class="row">
					<div class="col-md-12">
							
					<?php if($dataDate['VOID'] == '1'){ ?> 
					<div class="alert alert-danger alert-dismissible">
										<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
										<strong>PERHATIAN ! <br>
										UNTUK PENGECEKAN SLIK DIMULAI PUKUL 09:00 - 17:00 WIB<br>
									
										
					</div>
					<?php } ?>
								<?php
						$no=0;
						$callErr = "{call SP_GET_VALIDASI_DUKCAPIL_NEW(?,?)}";
						$paramErr =  array(array($prospect, SQLSRV_PARAM_IN),
									 array($no_ktp, SQLSRV_PARAM_IN));
						$execErr = sqlsrv_query( $conn, $callErr, $paramErr) or die( print_r( sqlsrv_errors(), true));
						while($dataErr = sqlsrv_fetch_array($execErr)){
						
						?>
							<div class="alert alert-danger alert-dismissible">
								<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
							<h5 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> WARNING!</h5>
							Terdapat <?php echo $dataErr['MSG_NAME'];?> <b></b>.
						</div>
					<?php } ?>
					
					
					
						<?php if($data7['RESULT_PEMOHON'] == "1"){ ?>
						<div class="alert alert-danger" role="alert">
							<h5 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> WARNING!</h5>
							Terdapat perbedaan data pada <b><?php $siapanih; ?></b>. Silahkan lakukan pengkinian data lalu upload resi pengkinian data
						</div>
						<?php } ?>
						
						<div class="table-responsive">
							<table class="table table-bordered table-striped" style="width:100%;font-size:12px;">
								<thead></thead>
								<tbody>
									<tr>
										<td colspan="3" style="color:#FFF;background-color:#035c7a;"><b>BLACKLIST INTERNAL</td>
									</tr>
									<?php
									/***** CEK BLACKLIST *****/
									$call = "{call SP_CHECK_LOG_BLACKLIST(?,?)}";
									$params = array(
													array($prospect, SQLSRV_PARAM_IN),
													array($no_ktp, SQLSRV_PARAM_IN)
												);
									$options =  array( "Scrollable" => "buffered" );
									$exec = sqlsrv_query($conn, $call, $params, $options) or die( print_r( sqlsrv_errors(), true)); 
									$data = sqlsrv_fetch_array($exec);
									$checkBlacklist=sqlsrv_num_rows($exec);

									if($checkBlacklist > 0){
										echo"
										<tr>
											<td style='width:33%;'>Hasil Pengecekan</td>
											<td style='width:33%;'>".$data['STATUS']." DI INTERNAL BLACKLIST</td>
											<td style='width:33%;'>Checked by ".$data['CREATE_USER']." (".$data['CREATE_DATE']->format("Y-m-d H:i:s")." )</td>
										</tr>";
									}else{
										echo"
										<tr>
											<td style='width:33%;'>Hasil Pengecekan</td>
											<td style='width:33%;'>BELUM PERNAH DI CEK</td>
											<td style='width:33%;'>-</td>
										</tr>";
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div style="float:right;">
							<?php
							$call1 = "{call SP_CHECK_LOG_DUKCAPIL(?,?)}";
							$params1 = array(
											array($prospect, SQLSRV_PARAM_IN),
											array($no_ktp, SQLSRV_PARAM_IN)
										);
							$options =  array( "Scrollable" => "buffered" );
							$exec1 = sqlsrv_query($conn, $call1, $params1, $options) or die( print_r( sqlsrv_errors(), true)); 
							$data1 = sqlsrv_fetch_array($exec1);
							$checkDukcapil=sqlsrv_num_rows($exec1);
							$id_log = $data1['LOG_CHECK_BYSOURCE_ID'];

							if($checkBlacklist > 0){
								
									if($data['STATUS']=='DITEMUKAN'){ 
									?>
									<input type="button" class="btn btn-custom btn-xs" value="Lanjutkan" disabled>
								
								<?php }
								else if($checkDukcapil > 0){
															?>
									<form action="index.php?page=check-dukcapil-slik-new&USERNAME=<?php echo $user;?>" method="post">
								<input name="prospect_no" type="hidden" value="<?php echo $prospect;?>">
								<input name="no_ktp" type="hidden" value="<?php echo $no_ktp;?>">
								<input name="name" type="hidden" value="<?php echo $nama;?>">
								<input name="date" type="hidden" value="<?php echo $date;?>">
								<input name="mother_name" type="hidden" value="<?php echo $mother_nm;?>">
								<input name="status_kawin" type="hidden" value="<?php echo $status_kawin;?>">
								<input name="birth_place" type="hidden" value="<?php echo $birth_place;?>">
								<input name="tipe_cust" type="hidden" value="<?php echo $siapanih;?>">
								<input type="submit" class="btn btn-custom btn-xs" value="Lanjutkan Check Dukcapil">
								</form>
								<?php

								/*}else if($dataCheckedLog > 0){ ?>
							<input type="button" class="btn btn-custom btn-xs" value="Lanjutkan" disabled>
							<?php */}else if($data7['RESULT_PEMOHON'] == "1"){ ?>
							<input type="button" class="btn btn-custom btn-xs" value="Lanjutkan" disabled>
							<?php }
										else if($checkDukcapil > 0){
							?>
									<form action="index.php?page=check-dukcapil-slik-new&USERNAME=<?php echo $user;?>" method="post">
								<input name="prospect_no" type="hidden" value="<?php echo $prospect;?>">
								<input name="no_ktp" type="hidden" value="<?php echo $no_ktp;?>">
								<input name="name" type="hidden" value="<?php echo $nama;?>">
								<input name="date" type="hidden" value="<?php echo $date;?>">
								<input name="mother_name" type="hidden" value="<?php echo $mother_nm;?>">
								<input name="status_kawin" type="hidden" value="<?php echo $status_kawin;?>">
								<input name="birth_place" type="hidden" value="<?php echo $birth_place;?>">
								<input name="tipe_cust" type="hidden" value="<?php echo $siapanih;?>">
								<input type="submit" class="btn btn-custom btn-xs" value="Lanjutkan Check Dukcapil">
								</form>
								
							
							
							
							
							
									<?php }else{?>
							<form action="index.php?page=check-dukcapil-slik-new&USERNAME=<?php echo $user;?>" method="post">
								<input name="prospect_no" type="hidden" value="<?php echo $prospect;?>">
								<input name="no_ktp" type="hidden" value="<?php echo $no_ktp;?>">
								<input name="name" type="hidden" value="<?php echo $nama;?>">
								<input name="date" type="hidden" value="<?php echo $date;?>">
								<input name="mother_name" type="hidden" value="<?php echo $mother_nm;?>">
								<input name="status_kawin" type="hidden" value="<?php echo $status_kawin;?>">
								<input name="birth_place" type="hidden" value="<?php echo $birth_place;?>">
								<input name="tipe_cust" type="hidden" value="<?php echo $siapanih;?>">
								<input type="submit" class="btn btn-custom btn-xs" value="Lanjutkan Check Dukcapil">
							</form>
							<?php 	} /*}else if($dataCheckedLog > 0){ ?>
							<input type="button" class="btn btn-custom btn-xs" value="Lanjutkan" disabled>
									<?php */ }else if($data7['RESULT_PEMOHON'] == "1"){ ?>
							<input type="button" class="btn btn-custom btn-xs" value="Lanjutkan" disabled>
								<?php }else{ ?>
							<input type="button" class="btn btn-custom btn-xs" value="Lanjutkan" disabled>
							<?php } ?>
						</div>
						<div style="float:right;margin-right:10px;">
							<form action="" method="post">
								<input name="prospect_no" type="hidden" value="<?php echo $prospect;?>">
								<input name="no_ktp" type="hidden" value="<?php echo $no_ktp;?>">
								<input name="name" type="hidden" value="<?php echo $nama;?>">
								<input name="date" type="hidden" value="<?php echo $date;?>">
								<input name="mother_name" type="hidden" value="<?php echo $mother_nm;?>	">
								<input name="status_kawin" type="hidden" value="<?php echo $status_kawin;?>">
								<input name="birth_place" type="hidden" value="<?php echo $birth_place;?>">
								<input name="tipe_cust" type="hidden" value="<?php echo $siapanih;?>">
									<?php 	/*if($dataCheckedLog > 0){ ?>
									<input type="button" class="btn btn-custom btn-xs" value="Check Blacklist" disabled>
									<?php //}else{ */?>
								<input type="submit" class="btn btn-custom btn-xs" value="Check Blacklist" name="check" onclick="return confirm('Apakah anda yakin ingin mengecek data ini?')">
							<?php// } ?>
							</form>
						</div>
					</div>
				</div>
				<br>
			</div>
		</div>
	</div>
</div>