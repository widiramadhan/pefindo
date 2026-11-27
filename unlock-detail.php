<?php
require_once("config/configuration.php");
require_once("config/connection.php");
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
ini_set('sqlsrv.ClientBufferMaxKBSize','524288'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size','524288'); 
$date=date("Y-m-d");

$id=$_GET['id'];
$user=$_GET['USERNAME'];

$call = "{call SP_GET_DETAIL_INFO_UNLOCK_DUKCAPIL(?)}";
$param = array(array($id, SQLSRV_PARAM_IN));
$options =  array( "Scrollable" => "buffered" );
$exec = sqlsrv_query( $conn, $call, $param, $options) or die( print_r( sqlsrv_errors(), true));
$data = sqlsrv_fetch_array($exec);


$call1 = "{call  SP_GET_UNLOCK_REJECT(?)}";
$param1 = array(array($id, SQLSRV_PARAM_IN));
$options1 =  array( "Scrollable" => "buffered" );
$exec1 = sqlsrv_query( $conn, $call1, $param1,$options1) or die( print_r( sqlsrv_errors(), true)); 
$numrows1 = sqlsrv_num_rows($exec1);

/*$call3 = "{call SP_GETDATA_INFO_CUSTOMER(?,?)}";
$param3 = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN));
$options3 =  array( "Scrollable" => "buffered" );
$exec3 = sqlsrv_query( $conn, $call3, $param3, $options3) or die( print_r( sqlsrv_errors(), true));
$data3 = sqlsrv_fetch_array($exec3);*/
/*
$call3 = "{call SP_GETDATA_INFO_CUSTOMER_NEWVERSE(?)}";
$param3 = array(array($data['ID_NO'], SQLSRV_PARAM_IN));
$options3 =  array( "Scrollable" => "buffered" );
$exec3 = sqlsrv_query( $conn, $call3, $param3, $options3) or die( print_r( sqlsrv_errors(), true));
$data3 = sqlsrv_fetch_array($exec3);
*/


if (strpos($data['PROSPECT_NO'], 'PRS') !== false) {
$call3 = "{call SP_GETDATA_INFO_CUSTOMER_NEWVERSE_2(?,?)}";
$param3 = array(array($data['ID_NO'], SQLSRV_PARAM_IN),
				array($data['PROSPECT_NO'], SQLSRV_PARAM_IN));
$options3 =  array( "Scrollable" => "buffered" );
$exec3 = sqlsrv_query( $conn, $call3, $param3, $options3) or die( print_r( sqlsrv_errors(), true));
$data3 = sqlsrv_fetch_array($exec3);
}
else{
$call3 = "{call VBS_GET_DATA_CUSTOMER_KTP(?)}";
$param3 = array(array($data['ID_NO'], SQLSRV_PARAM_IN));
$options3 =  array( "Scrollable" => "buffered" );
$exec3 = sqlsrv_query( $conn, $call3, $param3, $options3) or die( print_r( sqlsrv_errors(), true));
$data3 = sqlsrv_fetch_array($exec3);
}

$call4 = "{call SP_GET_PENGKINIAN_DATA_BY_ORDER_NO_KK(?)}";
$param4 = array(array($data3['ID_NO'], SQLSRV_PARAM_IN));
$options4 =  array( "Scrollable" => "buffered" );
$exec4 = sqlsrv_query( $conn, $call4, $param4, $options4) or die( print_r( sqlsrv_errors(), true));
$data4 = sqlsrv_fetch_array($exec4);
$numrows4 = sqlsrv_num_rows($exec4);

$param_dukcapil_array= array('nik' => $data['ID_NO'], 'user_id' => "singlesuzukifinance", 'password' => "s3Jsm8K9", 'IP_USER' => $user);
$param_dukcapil = json_encode($param_dukcapil_array);
$curlDkUpil = curl_init();
curl_setopt_array($curlDkUpil, array(
	CURLOPT_URL => "http://172.16.160.128:8000/dukcapil/get_json/SUZUKI_FINANCE/CALL_NIK",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 60,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => "$param_dukcapil",
	CURLOPT_HTTPHEADER => array(
		"Authorization: Basic " . base64_encode("singlesuzukifinance:s3Jsm8K9"),
		"Content-Type: application/json",
		"Postman-Token: ae0ace2e-aa92-4d66-8d14-d67edb42fa84",
		"cache-control: no-cache"
	),
));

$responseDkUpil = curl_exec($curlDkUpil);
$errDkUpil = curl_error($curlDkUpil);
curl_close($curlDkUpil);
$resultDukcapil = json_decode($responseDkUpil, true);

if(empty($resultDukcapil)){
	//----# Insert LOG
	$SourceLogDkUpilNtValid = "DUKCAPIL";
	$StatusLogDkUpilNtValid = "KTP TIDAK VALID";

	/*$callSPLogDkUpilNtValid = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
	$paramsLogDkUpilNtValid = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN), array($SourceLogDkUpilNtValid, SQLSRV_PARAM_IN),array($StatusLogDkUpilNtValid, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
	$execLogDkUpilNtValid = sqlsrv_query( $conn, $callSPLogDkUpilNtValid, $paramsLogDkUpilNtValid) or die( print_r( sqlsrv_errors(), true));*/
	//----# Insert LOG End
}else{
	if($errDkUpil){
		//----# Insert LOG
		$SourceLogDkUpil = "DUKCAPIL";
		$StatusLogDkUpil = "ERROR";

		/*$callSPLogDkUpil = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
		$paramsLogDkUpil = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN),array($SourceLogDkUpil, SQLSRV_PARAM_IN),array($StatusLogDkUpil, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
		$execLogDkUpil = sqlsrv_query( $conn, $callSPLogDkUpil, $paramsLogDkUpil) or die( print_r( sqlsrv_errors(), true));
		if($execLogDkUpil === false){
			echo"<script>alert('Error insert log Dukcapil');</script>";
		}*/
		//----# Insert LOG End
		echo "<script>alert('Error : ".$errDkUpil." (Pada saat pengecekan No KTP di Dukcapil..!)')</script>";
	}else{
		if(isset($resultDukcapil['content'][0]['RESPON'])) {
			//----# Insert LOG
			$SourceLogDkUpilnotfound = "DUKCAPIL";
			$StatusLogDkUpilnotfound = strtoupper($resultDukcapil['content'][0]['RESPON']);

			/*$callSPLogDkUpilnotfound = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
			$paramsLogDkUpilnotfound = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN),array($SourceLogDkUpilnotfound, SQLSRV_PARAM_IN),array($StatusLogDkUpilnotfound, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
			$execLogDkUpilnotfound = sqlsrv_query( $conn, $callSPLogDkUpilnotfound, $paramsLogDkUpilnotfound) or die( print_r( sqlsrv_errors(), true));*/
			//----# Insert LOG End
			
			echo "<script>alert('Error : ".$StatusLogDkUpilnotfound." (Pada saat pengecekan No KTP di Dukcapil!)')</script>";
			
			$DkcplCustType = "";
			$DkcplNIK = "";
			$DkcplNAMA_LGKP = "";
			$DkcplJENIS_KLMIN = "";
			$DkcplTMPT_LHR =  "";
			$DkcplTGL_LHR = "";
			$DkcplSTATUS_KAWIN = "";
			$DkcplNAMA_LGKP_IBU = "";
			$DkcplJENIS_PKRJN = "";
			$DkcplALAMAT = "";
			$DkcplNO_RT = "";
			$DkcplNO_RW = "";
			$DkcplNO_PROP = "";
			$DkcplPROP_NAME = "";
			$DkcplNO_KAB = "";
			$DkcplKAB_NAME = "";
			$DkcplKEC_NAME = "";
			$DkcplNO_KEL = "";
			$DkcplNO_KEC = "";
			$DkcplKEL_NAME = "";
		}else{
			//----# Insert LOG
			/*$SourceLogDkcpl = "DUKCAPIL";
			$StatusLogDkcpl = "VALID";

			$callSPLogDkcpl = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
			$paramsLogDkcpl = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN),array($SourceLogDkcpl, SQLSRV_PARAM_IN),array($StatusLogDkcpl, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
			$execLogDkcpl = sqlsrv_query( $conn, $callSPLogDkcpl, $paramsLogDkcpl) or die( print_r( sqlsrv_errors(), true));*/
			//----# Insert LOG End
			
			foreach($resultDukcapil['content'] as $contentdata){
				$DkcplNIK = number_format($contentdata['NIK'], 0, '', '');
				$DkcplNAMA_LGKP = $contentdata['NAMA_LGKP'];
				$DkcplJENIS_KLMIN = $contentdata['JENIS_KLMIN'];
				$DkcplTMPT_LHR = $contentdata['TMPT_LHR'];
				$DkcplTGL_LHR = $contentdata['TGL_LHR'];
				$DkcplSTATUS_KAWIN = $contentdata['STATUS_KAWIN'];
				$DkcplNAMA_LGKP_IBU = $contentdata['NAMA_LGKP_IBU'];
				$DkcplJENIS_PKRJN = $contentdata['JENIS_PKRJN'];
				$DkcplALAMAT = $contentdata['ALAMAT'];
				$DkcplNO_RT = $contentdata['NO_RT'];
				$DkcplNO_RW = $contentdata['NO_RW'];
				$DkcplNO_PROP = $contentdata['NO_PROP'];
				$DkcplPROP_NAME = $contentdata['PROP_NAME'];
				$DkcplNO_KAB = $contentdata['NO_KAB'];
				$DkcplKAB_NAME = $contentdata['KAB_NAME'];
				$DkcplKEC_NAME = $contentdata['KEC_NAME'];
				$DkcplNO_KEL = $contentdata['NO_KEL'];
				$DkcplNO_KEC = $contentdata['NO_KEC'];
				$DkcplKEL_NAME = $contentdata['KEL_NAME'];
			}	
		}
	}
}

$callHold = "{call SP_GET_CHECK_SOURCE_DETAIL_STATUS(?,?,?)}";
$paramHold = array(array($id, SQLSRV_PARAM_IN),
				array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),
				array($data['ID_NO'], SQLSRV_PARAM_IN));
$optionsHold =  array( "Scrollable" => "buffered" );
$execHold = sqlsrv_query( $conn, $callHold, $paramHold, $optionsHold) or die( print_r( sqlsrv_errors(), true));
$dataHold = sqlsrv_fetch_array($execHold);
$checkHold=sqlsrv_num_rows($execHold);
if($checkHold == 0){
	$callInsertStat = "{call SP_INSERT_STATUS_UNLOCK_DUKCAPIL(?,?,?,?,?)}";
	$paramsInsertStat = array(array($id, SQLSRV_PARAM_IN),array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN), array('3', SQLSRV_PARAM_IN));
	$execInsertStat = sqlsrv_query( $conn, $callInsertStat, $paramsInsertStat) or die( print_r( sqlsrv_errors(), true));
	
}

if(isset($_POST['unlock'])){
	$prospect_no = $_POST['prospect_no'];
	$nik = $_POST['nik'];
	$id = $_POST['id'];
	
	//----# Insert LOG
	$source = "DUKCAPIL";
	$status = "VALID";
	
	if($prospect_no <> NULL || $prospect_no <> ""){
		$prs=$prospect_no;
	}else{
		$callSP = "{call SP_GET_ORDER_NO_BY_PROSPECT_NO(?)}";
		$parameter = array(array($prospect_no, SQLSRV_PARAM_IN));
		$stmt = sqlsrv_query( $conn, $callSP, $parameter) or die( print_r( sqlsrv_errors(), true));
		$datastmt = sqlsrv_fetch_array($stmt);
		$prs=$datastmt['ORDER_NO'];
	}
	
	
	$callSPLogPfndScssMlti = "{call SP_INSERT_LOG_BYSOURCE_UNLOCK(?,?,?,?,?)}";
	$paramsLogPfndScssMlti = array(array($prs, SQLSRV_PARAM_IN),array($nik, SQLSRV_PARAM_IN),array($source, SQLSRV_PARAM_IN),array($status, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
	$execLogPfndScssMlti = sqlsrv_query( $conn, $callSPLogPfndScssMlti, $paramsLogPfndScssMlti) or die( print_r( sqlsrv_errors(), true));
	//----# Insert LOG End
	$callInsertStat = "{call SP_INSERT_STATUS_UNLOCK_DUKCAPIL(?,?,?,?,?)}";
	$paramsInsertStat = array(array($id, SQLSRV_PARAM_IN),array($prs, SQLSRV_PARAM_IN),array($nik, SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN), array('1', SQLSRV_PARAM_IN));
	$execInsertStat = sqlsrv_query( $conn, $callInsertStat, $paramsInsertStat) or die( print_r( sqlsrv_errors(), true));
	
	
	
	if($execLogPfndScssMlti){
		echo"<script>alert('Unlock Berhasil, Cabang dapat melanjutkan proses cek scoring');window.location='index.php?USERNAME=".$user."&page=unlock-dukcapil'</script>";
	}else{
		echo"<script>alert('Unlock Gagal, Silahkan hubungi IT HO');history.back();</script>";
	}
}
else if(isset($_POST['hold'])){
	$prospect_no = $_POST['prospect_no'];
	$nik = $_POST['nik'];
	$id = $_POST['id'];

	
		echo"<script>alert('Hold Dukcapil Berhasil');window.location='index.php?USERNAME=".$user."&page=unlock-dukcapil'</script>";
	
	
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
				<h4 class="title">Unlock Dukcapil</h4>
				<p class="category">Detail unlock dukcapil</p>
			</div>
			<div class="content">
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-danger alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
						<strong>Perhatian !</strong><br>
							TERDAPAT PERBEDAAN DATA DUKCAPIL
							<?php
							/*
								$call2 = "{call SP_GET_DETAIL_ERROR_UNLOCK_DUKCAPIL(?)}";
								$param2 = array(array($id, SQLSRV_PARAM_IN));
								$options2 =  array( "Scrollable" => "buffered" );
								$exec2 = sqlsrv_query( $conn, $call2, $param2, $options2) or die( print_r( sqlsrv_errors(), true)); 
								$numrows2 = sqlsrv_num_rows($exec2);
								while($data2 = sqlsrv_fetch_array($exec2)){
									echo $data2['MSG_NAME']."<br>";
								}
							*/
							?>
						</div>
								
				<?php if($numrows1 > 0){ ?>
			
					<div class="alert alert-warning alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
							<strong>Perhatian !</strong><br>
							
							<?php
							
								while($dataNote = sqlsrv_fetch_array($exec1)){ ?>
									Note Reject UNLOCK : <?php echo $dataNote['NOTES']."<br>";
								}
							?>
						</div>	
						
					<?php } ?>
					
						<div class="row">
							<div class="col-md-4">
								<table class="table table-bordered table-stiped" style="font-size:10px;">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DATA CONFINS</td>
									</tr>
									<tr>
										<td style="width:50%;">NIK</td>
										<td style="width:50%;"><?php echo $data3['ID_NO'];?></td>
									</tr>
									<tr>
										<td >Nama Lengkap</td>
										<td><?php echo $data3['CUST_NAME'];?></td>
									</tr>
									<tr>
										<td>TTL</td>
										<td><?php echo $data3['TTL'];?></td>
									</tr>
									<tr>
										<td>Jenis Kelamin</td>
										<td><?php echo $data3['JENIS_KELAMIN'];?></td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td><?php echo $data3['ALAMAT'];?></td>
									</tr>
									<tr>
										<td>RT/RW</td>
										<td><?php echo $data3['RT_RW'];?></td>
									</tr>
									<tr>
										<td>Kelurahan/Desa</td>
										<td><?php echo $data3['KELURAHAN'];?></td>
									</tr>
									<tr>
										<td>Kecamatan</td>
										<td><?php echo $data3['KECAMATAN'];?></td>
									</tr>
									<tr>
										<td>Kabupaten</td>
										<td><?php echo $data3['KABUPATEN'];?></td>
									</tr>
									<tr>
										<td>Provinsi</td>
										<td><?php echo $data3['PROVINSI'];?></td>
									</tr>
									<tr>
										<td>Status Kawin</td>
										<td><?php echo $data3['STATUS_KAWIN'];?></td>
									</tr>
									<tr>
										<td>Nama Ibu Kandung</td>
										<td><?php echo $data3['NAMA_IBU'];?></td>
									</tr>
									<tr>
										<td>Pekerjaan</td>
										<td><?php echo $data3['PEKERJAAN'];?></td>
									</tr>
								</table>
							</div>
							<div class="col-md-4">
								<table class="table table-bordered table-stiped" style="font-size:10px;">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DATA DUKCAPIL</td>
									</tr>
									<!--
									<tr>
										<td style="width:50%;">NIK</td>
										<td style="width:50%;"><?php //echo $DkcplNIK;?></td>
									</tr>
									-->
							
									<tr>
										<td >Nama Lengkap</td>
										<td><?php echo $DkcplNAMA_LGKP;?></td>
									</tr>
											<?php /* ?>
									<tr>
										<td>TTL</td>
										<td><?php echo $DkcplTMPT_LHR.", ".$DkcplTGL_LHR;?></td>
									</tr>
									<tr>
										<td>Jenis Kelamin</td>
										<td><?php echo $DkcplJENIS_KLMIN;?></td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td><?php echo $DkcplALAMAT;?></td>
									</tr>
									<tr>
										<td>RT/RW</td>
										<td><?php echo $DkcplNO_RT."/".$DkcplNO_RW;?></td>
									</tr>
									<tr>
										<td>Kelurahan/Desa</td>
										<td><?php echo $DkcplKEL_NAME;?></td>
									</tr>
									<tr>
										<td>Kecamatan</td>
										<td><?php echo $DkcplKEC_NAME;?></td>
									</tr>
									<tr>
										<td>Kabupaten</td>
										<td><?php echo $DkcplKAB_NAME;?></td>
									</tr>
									<tr>
										<td>Provinsi</td>
										<td><?php echo $DkcplPROP_NAME;?></td>
									</tr>
									<tr>
										<td>Status Kawin</td>
										<td><?php echo $DkcplSTATUS_KAWIN;?></td>
									</tr>
									*/ ?>
									<tr>
										<td>Nama Ibu Kandung</td>
										<td><?php echo $DkcplNAMA_LGKP_IBU;?></td>
									</tr>
									<!--
									<tr>
										<td>Pekerjaan</td>
										<td><?php// echo $DkcplJENIS_PKRJN;?></td>
									</tr>
									-->
								</table>
							</div>
							<div class="col-md-4">
								<table class="table table-bordered table-stiped" style="font-size:10px;width:100%;">
									<tr>
										<td style="background-color:#035c7a;color:#FFF;font-weight:bold;">RESI PENGKINIAN DATA & FOTO KK</td>
									</tr>
									<tr>
										<td>
											<?php if($numrows4 == 0){ ?>
												<img src="assets/img/default.jpg" style="width:100%;">
											<?php }else{ ?>
												<div style="width:100%;">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($data4['IMG_SRC']);?>" style="width:100%;">
												</div>
											<?php } ?>
										</td>
									<tr>
										<td>
											<?php if($numrows4 == 0 && $data4['IMG_KK']== NULL){ ?>
												<img src="assets/img/default.jpg" style="width:100%;">
											<?php }else{ ?>
												<div style="width:100%;">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($data4['IMG_KK']);?>" style="width:100%;">
												</div>
											<?php } ?>
										</td>
									</tr>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<i class="text-danger"><b>*Data yang dicompare adalah Nama Lengkap, Tanggal Lahir, Nama Ibu Kandung, dan Status Kawin</b></i>
						<hr>
						<div class="row">
							<div class="col-md-4">
								<form action="" method="post">
									<input type="hidden" name="prospect_no" value="<?php echo $data['PROSPECT_NO'];?>">
									<input type="hidden" name="nik" value="<?php echo $data['ID_NO'];?>">
									<input type="hidden" name="id" value="<?php echo $id;?>">
									<input type="submit" class="btn btn-custom" name="unlock" value="UNLOCK" onclick="return confirm('Apakah anda yakin ingin meng-unlock data ini?');" style="width:100%;">
								</form>
							</div>
								<div class="col-md-4">
								
							<form action="index.php?page=unlock-reject&USERNAME=<?php echo $user;?>" method="post" enctype="multipart/form-data" id="ff">
									<input type="hidden" name="prospect_no" value="<?php echo $data['PROSPECT_NO'];?>">
									<input type="hidden" name="nik" value="<?php echo $data['ID_NO'];?>">
									<input type="hidden" name="id" value="<?php echo $id;?>">
									<input type="submit" class="btn btn-custom" name="reject" value="REJECT" onclick="return confirm('Apakah anda yakin ingin reject data ini?');" style="width:100%;">
								</form>
								</div>
							<div class="col-md-4">
								
							<form action="" method="post" >
									<input type="hidden" name="prospect_no" value="<?php echo $data['PROSPECT_NO'];?>">
									<input type="hidden" name="nik" value="<?php echo $data['ID_NO'];?>">
									<input type="hidden" name="id" value="<?php echo $id;?>">
									<input type="submit" class="btn btn-custom" name="hold" value="HOLD DUKCAPIL" style="width:100%;">
								</form>
								</div>
						</div>
						<br><br>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>