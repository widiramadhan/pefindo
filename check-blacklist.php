<?php
require_once("config/configuration.php");
$Warning_Data = "";
	$prospect=$_POST['prospect_no'];
	$no_ktp=$_POST['no_ktp'];
	$nama=$_POST['name'];
	$date=$_POST['date'];
	$mother_nm=$_POST['mother_name'];
	$birth_place=$_POST['birth_place'];
	$siapanih=$_POST['tipe_cust'];
	$getUsername=$_GET['USERNAME'];
	$Warning_Data = "";

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
		
	

if(isset($_POST['check'])){
	$prospect=$_POST['prospect_no'];
	$no_ktp=$_POST['no_ktp'];
	$nama=$_POST['name'];
	$date=$_POST['date'];
	$mother_nm=$_POST['mother_name'];
	$birth_place=$_POST['birth_place'];
	$siapanih=$_POST['tipe_cust'];
	$getUsername=$_GET['USERNAME'];
	
	$callCheck = "{call SP_CHECK_SLIK_CHECKED(?)}";
	$paramCheck = array(array($no_ktp, SQLSRV_PARAM_IN));
	$optionCheck = array( "Scrollable" => "buffered" );
	$execCheck = sqlsrv_query($conn, $callCheck, $paramCheck,$optionCheck) or die( print_r( sqlsrv_errors(), true));
	$dataCheck =  sqlsrv_fetch_array($execCheck);
	$rowsCheck =sqlsrv_num_rows($execCheck);
	
	$callCheck1 = "{call SP_CHECK_SLIK_CHECKED_PROSPECT(?,?)}";
	$paramCheck1 = array(array($no_ktp, SQLSRV_PARAM_IN),
						 array($prospect, SQLSRV_PARAM_IN));
	$optionCheck1 = array( "Scrollable" => "buffered" );
	$execCheck1 = sqlsrv_query($conn, $callCheck1, $paramCheck1,$optionCheck1) or die( print_r( sqlsrv_errors(), true));
	$dataCheck1 =  sqlsrv_fetch_array($execCheck1);
	$rowsCheck1 =sqlsrv_num_rows($execCheck1);
	
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
	
	
	$call3 = "{call SP_CHECK_DUKCAPIL_MAPPING_HOLD(?,?)}";
	$param3 = array(array($prospect, SQLSRV_PARAM_IN),
					array($no_ktp, SQLSRV_PARAM_IN));
	$options =  array( "Scrollable" => "buffered" );
	$exec3 = sqlsrv_query( $conn, $call3, $param3,$options) or die( print_r( sqlsrv_defaults(), true)); 
	$data3= sqlsrv_fetch_array($exec3);
	$checkData=sqlsrv_num_rows($exec3);
	if($rowsCheck1 > 0){
															
			echo"<script>alert('Customer ini pernah melakukan pengecekan SLIK pada tanggal ".$dataCheck1['CREATE_DATE']->format("d F Y")." ');window.location='index.php?USERNAME=".$user."&page=slik-detail&no=".$prospect."&custtype=".$siapanih."&id=".$dataCheck1['PEFINDO_MAPPING_ID']."'</script>";	
	
		
		
	}else if($checkData > 0){
		
		
	}else{
		$call6 = "{call SP_INSERT_DUKCAPIL_HOLD_1(?,?,?,?,?,?,?,?)}";
		$param6 = array(array($prospect, SQLSRV_PARAM_IN),
						array($no_ktp, SQLSRV_PARAM_IN),
						array($nama, SQLSRV_PARAM_IN),
						array($date, SQLSRV_PARAM_IN),
						array($siapanih, SQLSRV_PARAM_IN),
						array('KTP', SQLSRV_PARAM_IN),
						array($getUsername, SQLSRV_PARAM_IN),
						array('8', SQLSRV_PARAM_IN));
		$exec6 = sqlsrv_query( $conn, $call6, $param6) or die( print_r( sqlsrv_defaults(), true)); 
		$data6= sqlsrv_fetch_array($exec6);
	}
	

	
	
	
	
}else{
	$prospect=$_POST['prospect_no'];
	$no_ktp=$_POST['no_ktp'];
	$nama=$_POST['name'];
	$date=$_POST['date'];
	$mother_nm=$_POST['mother_name'];
	$birth_place=$_POST['birth_place'];
	$siapanih=$_POST['tipe_cust'];
	$getUsername=$_GET['USERNAME'];
}
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
					<?php 	if($dataCheckedLog > 0){ ?>
					<div class="alert alert-danger alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
							<strong>Perhatian !</strong><br>
							<strong>Nomor Order <?php echo $dataGetOrder['ORDER_NO']; ?> Sudah Pernah Melakukan Pengecekan Pefindo / Slik</strong><br>
							
						</div>
					<?php } ?>
					<?php 	if($dataCheckedLogProspect > 0){ ?>
					<div class="alert alert-danger alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
							<strong>Perhatian !</strong><br>
							<strong>Nomor Prospect <?php echo $prospect; ?> dan NIK : <?php echo $no_ktp;?> Sudah Pernah Melakukan Pengecekan Pefindo / Slik</strong><br>
							
						</div>
					<?php } ?>
					<?php if($dataDate['VOID'] == '1'){ ?> 
					<div class="alert alert-danger alert-dismissible">
										<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
										<strong>PERHATIAN ! <br>
										UNTUK PENGECEKAN SLIK DIMULAI PUKUL 09:00 - 17:00 WIB<br>
									
										
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
							<?php if($checkBlacklist > 0){
								if($_GET['USERNAME'] == 'iman.santoso' || $_GET['USERNAME'] == 'djoko.andrew' || $_GET['USERNAME'] == 'ramandona' || $_GET['USERNAME'] == 'IMAN.SANTOSO' || $_GET['USERNAME'] == 'DJOKO.ANDREW' || $_GET['USERNAME'] == 'RANI.VEMIA' || $_GET['USERNAME'] == 'rani.vemia' || $_GET['USERNAME'] == 'RAMANDONA' || $_GET['USERNAME'] == 'NOVRIKAWATI' || $_GET['USERNAME'] == 'KIKI.AMALIA' || $_GET['USERNAME'] == 'novrikawati' || $_GET['USERNAME'] == 'kiki.amalia' || $_GET['USERNAME'] == 'AHMAD.HABIBI' ||$_GET['USERNAME'] == 'DENY.SAPUTRA' || $_GET['USERNAME'] == 'Haris.Siswanto' || $_GET['USERNAME'] == 'HARIS.SISWANTO' || $_GET['USERNAME'] == 'Yose.Kertapati' || $_GET['USERNAME'] == 'YOSE.KERTAPATI'	|| $_GET['USERNAME'] == 'Muhammad' || $_GET['USERNAME'] == 'MUHAMMAD' || $_GET['USERNAME'] == 'Ramandona.Dinara' || $_GET['USERNAME'] == 'RAMANDONA.DINARA'){	   ?>
							<!--<form action="index.php?page=check-dukcapil&USERNAME=<?php// echo $user;?>" method="post">-->
								<form action="index.php?USERNAME=<?php echo $user;?>&page=individual-ho-new" method="post">
								<input name="prospect_no" type="hidden" value="<?php echo $prospect;?>">
								<input name="no_ktp" type="hidden" value="<?php echo $no_ktp;?>">
								<input name="name" type="hidden" value="<?php echo $nama;?>">
								<input name="date" type="hidden" value="<?php echo $date;?>">
								<input name="mother_name" type="hidden" value="<?php echo $mother_nm;?>">
								<input name="birth_place" type="hidden" value="<?php echo $birth_place;?>">
								<input name="tipe_cust" type="hidden" value="<?php echo $siapanih;?>">
								<input type="submit" class="btn btn-custom btn-xs" value="Lanjutkan">
							</form>
							<?php }else{ ?>
							<form action="index.php?USERNAME=<?php echo $user;?>&page=individual" method="post">
								<input name="prospect_no" type="hidden" value="<?php echo $prospect;?>">
								<input name="no_ktp" type="hidden" value="<?php echo $no_ktp;?>">
								<input name="name" type="hidden" value="<?php echo $nama;?>">
								<input name="date" type="hidden" value="<?php echo $date;?>">
								<input name="mother_name" type="hidden" value="<?php echo $mother_nm;?>">
								<input name="birth_place" type="hidden" value="<?php echo $birth_place;?>">
								<input name="tipe_cust" type="hidden" value="<?php echo $siapanih;?>">
								<input type="submit" class="btn btn-custom btn-xs" value="Lanjutkan">
							</form>
							<?php 	
							}
							}
							 else{ ?>
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
								<input name="birth_place" type="hidden" value="<?php echo $birth_place;?>">
								<input name="tipe_cust" type="hidden" value="<?php echo $siapanih;?>">
								<?php 	if($dataCheckedLog > 0){ ?>
									<input type="button" class="btn btn-custom btn-xs" value="Check Blacklist" disabled>
								<?php }else if($dataCheckedLogProspect > 0){ ?> 
									<input type="button" class="btn btn-custom btn-xs" value="Check Blacklist" disabled>
									<?php }else if($dataDate['VOID'] == '1'){ ?> 
									<input type="button" class="btn btn-custom btn-xs" value="Check Blacklist" disabled>
									<?php }else{ ?>
								<input type="submit" class="btn btn-custom btn-xs" value="Check Blacklist" name="check" onclick="return confirm('Apakah anda yakin ingin mengecek data ini?')">
							<?php } ?>
							</form>
						</div>
					</div>
				</div>
				<br>
			</div>
		</div>
	</div>
</div>