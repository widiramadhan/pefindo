<?php
date_default_timezone_set('Asia/Jakarta');

$id=$_GET['id'];
$no=$_GET['no'];
$nik=$_GET['nik'];
$nama=$_GET['name'];
$userlogin=$_GET['USERNAME'];
$startDate=date("Y-m-d H:i:s");
$siapanih1=$_GET['custtype'];
if($siapanih1 == 'PEMOHON'){
		$siapanih3 = '1';
	}else if ($siapanih1 == 'PASANGAN'){
		$siapanih3 = '2';
	}else if ($siapanih1 == 'PENJAMIN'){
		$siapanih3 = '3';
	}else{
		$siapanih3 = '0';
	}
$callGenerate = "{call SP_GENERATE_SLIK_GETDATA_DEBITUR(?,?)}";
	$paramGenerate = array(array($no, SQLSRV_PARAM_IN),
						 array($nik, SQLSRV_PARAM_IN));
	$execGenerate = sqlsrv_query( $conn, $callGenerate, $paramGenerate) or die( print_r( sqlsrv_errors(), true));
	$dataGenerate = sqlsrv_fetch_array($execGenerate);
	

if (strpos($no, 'PRS') !== false) {
	//echo "true";
	$securityDeposit = "0";
	$callBranch = "{call SP_GET_BRANCH_STATUS_PROSPECT(?,?)}";
	$paramBranch = array(array($no, SQLSRV_PARAM_IN),array('PROSPECT_NO', SQLSRV_PARAM_IN));
	$execBranch = sqlsrv_query( $conn, $callBranch, $paramBranch) or die( print_r( sqlsrv_errors(), true));
	$dataBranch = sqlsrv_fetch_array($execBranch);
	
    $call = "{call PEFINDO_GETDATA_PASANGAN_1(?)}";
	$param = array(array($no, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));
	$data = sqlsrv_fetch_array($exec);
	
	$call4 = "{call  SP_GET_IMG_SPK(?)}";
	$param4 = array(array($nik, SQLSRV_PARAM_IN));
	$exec4 = sqlsrv_query( $conn, $call4, $param4) or die( print_r( sqlsrv_errors(), true)); 
	$data4 = sqlsrv_fetch_array($exec4);
	
	$callNikah = "{call  SP_GET_IMAGES_STATUS_NIKAH(?,?)}";
	$paramNikah = array(array($no, SQLSRV_PARAM_IN),
						array($nik, SQLSRV_PARAM_IN));
	$execNikah = sqlsrv_query( $conn, $callNikah, $paramNikah) or die( print_r( sqlsrv_errors(), true)); 
	$dataNikah = sqlsrv_fetch_array($execNikah);
	
	$callKk = "{call  SP_GET_IMAGES_KK_PASANGAN(?,?)}";
	$paramKk = array(array($no, SQLSRV_PARAM_IN),
						array($nik, SQLSRV_PARAM_IN));
	$execKk = sqlsrv_query( $conn, $callKk, $paramKk) or die( print_r( sqlsrv_errors(), true)); 
	$dataKk = sqlsrv_fetch_array($execKk);

	if($data['Pasangan_Noktp'] == "" || $data['Pasangan_Noktp'] == NULL){
		$siapanih = "Penjamin";
		$ktpsaya = $data['Penjamin_Noktp'];
		$namasaya = $data['Penjamin_Nama'];
		if($data['Penjamin_TglLahir']<>NULL){$tgllahirsaya = $data['Penjamin_TglLahir']->format("d F Y");}else{$tgllahirsaya="";}
		$tempatlahirsaya = $data['Penjamin_TempatLahir'];
		$namaibusaya = $data['Penjamin_Ibu'];
		$alamatsaya = $data['Penjamin_Alamat'];
	}else{
		$siapanih = "Pasangan";
		$ktpsaya = $data['Pasangan_Noktp'];
		$namasaya = $data['Pasangan_Nama'];
		if($data['Pasangan_TglLahir']<>NULL){$tgllahirsaya = $data['Pasangan_TglLahir']->format("d F Y");}else{$tgllahirsaya="";}
		$tempatlahirsaya = $data['Pasangan_TempatLahir'];
		$namaibusaya = $data['Pasangan_Ibu'];
		$alamatsaya = $data['Pasangan_alamat'];
	}
}else{
	

	$callBranch = "{call SP_GET_BRANCH_STATUS_PROSPECT(?,?)}";
	$paramBranch = array(array($no, SQLSRV_PARAM_IN),array('ORDER_NO', SQLSRV_PARAM_IN));
	$execBranch = sqlsrv_query( $conn, $callBranch, $paramBranch) or die( print_r( sqlsrv_errors(), true));
	$dataBranch = sqlsrv_fetch_array($execBranch);
	//echo "false";
		if($dataBranch['OFFICE_CODE']=="1025" || $dataBranch['OFFICE_CODE']=="1535" ){
	$securityDeposit = "1";
	}else{
		$securityDeposit = "0";
	}
	
	$call4 = "{call  SP_GET_IMG_SPK(?)}";
	$param4 = array(array($nik, SQLSRV_PARAM_IN));
	$exec4 = sqlsrv_query( $conn, $call4, $param4) or die( print_r( sqlsrv_errors(), true)); 
	$data4 = sqlsrv_fetch_array($exec4);
	
	$callNikah = "{call  SP_GET_IMAGES_STATUS_NIKAH(?,?)}";
	$paramNikah = array(array($no, SQLSRV_PARAM_IN),
						array($nik, SQLSRV_PARAM_IN));
	$execNikah = sqlsrv_query( $conn, $callNikah, $paramNikah) or die( print_r( sqlsrv_errors(), true)); 
	$dataNikah = sqlsrv_fetch_array($execNikah);
	
	$callKk = "{call  SP_GET_IMAGES_KK_PASANGAN(?,?)}";
	$paramKk = array(array($no, SQLSRV_PARAM_IN),
						array($nik, SQLSRV_PARAM_IN));
	$execKk = sqlsrv_query( $conn, $callKk, $paramKk) or die( print_r( sqlsrv_errors(), true)); 
	$dataKk = sqlsrv_fetch_array($execKk);
	
	$call = "{call PEFINDO_GETDATA_PASANGAN_BY_ORDER_NO_1(?)}";
	$param = array(array($no, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));
	$data = sqlsrv_fetch_array($exec);
	
	$siapanih = $data['TYPE'];
	$ktpsaya = $data['NIK_PASANGAN_PENJAMIN'];
	$namasaya = $data['NAMA_PASANGAN_PENJAMIN'];
	if($data['TTL_PASANGAN_PENJAMIN']<>NULL){$tgllahirsaya = $data['TTL_PASANGAN_PENJAMIN']->format("d F Y");}else{$tgllahirsaya="";}
	$tempatlahirsaya = "";
	$namaibusaya = $data['NAMA_IBU_PASANGAN_PNJMN'];
	$alamatsaya = $data['ALAMAT_PSGN_PNJMN'];
	
	
	
	$call9 = "{call VBS_GET_DATA_CUSTOMER(?,?)}";
	$param9 = array(array($no, SQLSRV_PARAM_IN),
					array($siapanih, SQLSRV_PARAM_IN));
	$options9 =  array( "Scrollable" => "buffered" );
	$exec9 = sqlsrv_query( $conn, $call9, $param9, $options9) or die( print_r( sqlsrv_errors(), true));
	$data9 = sqlsrv_fetch_array($exec9);
}



if(isset($_POST['submit_col']) ){
	
	$id=$_POST['id'];
	$prospect=$_POST['prospect_no'];
	$no=$_POST['prospect_no'];
	$no_ktp=$_POST['no_ktp'];
	$nik=$_POST['no_ktp'];
	$nama=$_POST['name'];
	//$date = $_POST['date'];
	//$date=$_POST['date'];
	//$mother_nm=$_POST['mother_name'];
	//$birth_place=$_POST['birth_place'];
	$siapanih1=$_POST['tipe_cust'];
	if($siapanih1 == 'PEMOHON'){
		$siapanih3 = '1';
	}else if ($siapanih1 == 'PASANGAN'){
		$siapanih3 = '2';
	}else if ($siapanih1 == 'PENJAMIN'){
		$siapanih3 = '3';
	}else{
		$siapanih3 = '0';
	}
	$userlogin=$_GET['USERNAME'];
	$getUsername=$_GET['USERNAME'];
	$startDate=date("Y-m-d H:i:s");
	$inquiryDate=date("Y-m-d");
	$branch_id = $_POST['branch_id'];
	$kategori = $_POST['kategori'];

	
	$callBranch1 = "{call SP_GENERATE_DEBSLIK_INSERT_DEBITUR_H2H(?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramBranch1 = array(array($siapanih3, SQLSRV_PARAM_IN),
						 array($kategori, SQLSRV_PARAM_IN),
						 array($branch_id, SQLSRV_PARAM_IN),
						 array('PERSONAL', SQLSRV_PARAM_IN),
						 array($inquiryDate, SQLSRV_PARAM_IN),
						 array($nama, SQLSRV_PARAM_IN),
						 array('01', SQLSRV_PARAM_IN),
						 array($prospect, SQLSRV_PARAM_IN),
						 array('', SQLSRV_PARAM_IN),	 
					     array($nik, SQLSRV_PARAM_IN),
						 array('', SQLSRV_PARAM_IN),
						 array($userlogin, SQLSRV_PARAM_IN),
						 array('1', SQLSRV_PARAM_IN));
	
	$execBranch1 = sqlsrv_query( $conn, $callBranch1, $paramBranch1) or die( print_r( sqlsrv_errors(), true));
	$dataBranch1 = sqlsrv_fetch_array($execBranch1);
	
		
	$callGenerate = "{call SP_GENERATE_SLIK_GETDATA_DEBITUR(?,?)}";
	$paramGenerate = array(array($prospect, SQLSRV_PARAM_IN),
						 array($nik, SQLSRV_PARAM_IN));
	$execGenerate = sqlsrv_query( $conn, $callGenerate, $paramGenerate) or die( print_r( sqlsrv_errors(), true));
	$dataGenerate = sqlsrv_fetch_array($execGenerate);
	
	
}
/*
$call = "{call PEFINDO_GETDATA_PASANGAN(?)}";
$param = array(array($no, SQLSRV_PARAM_IN));
$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));
$data = sqlsrv_fetch_array($exec);

if($data['Pasangan_Noktp'] == "" || $data['Pasangan_Noktp'] == NULL){
	$siapanih = "Penjamin";
	$ktpsaya = $data['Penjamin_Noktp'];
	$namasaya = $data['Penjamin_Nama'];
	if($data['Penjamin_TglLahir']<>NULL){$tgllahirsaya = $data['Penjamin_TglLahir']->format("d F Y");}else{$tgllahirsaya="";}
	$tempatlahirsaya = $data['Penjamin_TempatLahir'];
}else{
	$siapanih = "Pasangan";
	$ktpsaya = $data['Pasangan_Noktp'];
	$namasaya = $data['Pasangan_Nama'];
	if($data['Pasangan_TglLahir']<>NULL){$tgllahirsaya = $data['Pasangan_TglLahir']->format("d F Y");}else{$tgllahirsaya="";}
	$tempatlahirsaya = $data['Pasangan_TempatLahir'];
}
*/

$call1 = "{call SP_CHECK_STATUS_SLIK(?)}";
$param1 = array(array($id, SQLSRV_PARAM_IN));
$exec1 = sqlsrv_query( $conn, $call1, $param1) or die( print_r( sqlsrv_errors(), true));
$data1 = sqlsrv_fetch_array($exec1);

if($data1['SUB_PARAM_ID'] == 2){
	//jika sudah done maka tidak diupdate ke on progress
}else{
	//jika selain done maka bisa diupdate ke on progress
	$call2 = "{call SP_UPDATE_SLIK_RESULT(?,?)}";
	$param2 = array(array($id, SQLSRV_PARAM_IN),array(1, SQLSRV_PARAM_IN));
	$exec2 = sqlsrv_query( $conn, $call2, $param2) or die( print_r( sqlsrv_errors(), true));
}

$call3 = "{call SP_GET_PERFORMANCE_ACTIVITY(?)}";
$param3 = array(array($id, SQLSRV_PARAM_IN));
$option3 = array( "Scrollable" => "buffered" );
$exec3 = sqlsrv_query($conn, $call3, $param3, $option3) or die( print_r( sqlsrv_errors(), true));
$numrows3 = sqlsrv_num_rows($exec3);


	$call4 = "{call SP_INSERT_PERFORMANCE_ACTIVITY(?,?,?,?)}";
	$param4 = array(array($id, SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN),array($startDate, SQLSRV_PARAM_IN),array(NULL, SQLSRV_PARAM_IN));
	$exec4 = sqlsrv_query($conn, $call4, $param4) or die( print_r( sqlsrv_errors(), true));

	
$callFasilitas = "{call SP_CHECK_FASILITAS_SLIK(?)}";
	$paramFasilitas = array(array($nik, SQLSRV_PARAM_IN));
	$optionFasilitas = array( "Scrollable" => "buffered" );
	$execFasilitas = sqlsrv_query($conn, $callFasilitas, $paramFasilitas,$optionFasilitas) or die( print_r( sqlsrv_errors(), true));
	$dataFasilitas =  sqlsrv_fetch_array($execFasilitas);
$checkFasilitas =sqlsrv_num_rows($execFasilitas);

$callReject= "{call SP_GET_REJECT_NOTES(?,?,?)}";
$paramReject = array(array($no, SQLSRV_PARAM_IN),
					 array($nik, SQLSRV_PARAM_IN),
					 array($id, SQLSRV_PARAM_IN));
$optionReject = array( "Scrollable" => "buffered" );
$execReject = sqlsrv_query($conn, $callReject, $paramReject, $optionReject) or die( print_r( sqlsrv_errors(), true));
$numrowsReject = sqlsrv_num_rows($execReject);

$callAfa= "{call SP_GET_NOTES_AFA_UNLOCK(?,?)}";
$paramAfa = array(array($no, SQLSRV_PARAM_IN),
					 array($nik, SQLSRV_PARAM_IN));
$optionAfa = array( "Scrollable" => "buffered" );
$execAfa = sqlsrv_query($conn, $callAfa, $paramAfa, $optionAfa) or die( print_r( sqlsrv_errors(), true));
$dataAfa = sqlsrv_fetch_array($execAfa);
$numrowsAfa = sqlsrv_num_rows($execAfa);

?>
<style>
.title-content{
	font-size:18px;
	font-weight:bold;
	color:#035c7a;
}
.sub-title-content{
	font-size:14px;
	font-weight:bold;
	color:#035c7a;
}
</style>

<link rel="stylesheet" href="assets/css/lightbox.css" type="text/css" media="screen" />
<div class="row">
    <div class="col-md-12">
		<?php if($checkFasilitas > 0){ ?> 
		<div class="alert alert-danger alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
							<strong>Customer ini pernah melakukan pengecekan SLIK pada tanggal <?php if($dataFasilitas['TANGGAL_CHECK']<>NULL){echo $dataFasilitas['TANGGAL_CHECK']->format("d F Y");}?> 
							User yang mengecek <?php echo $dataFasilitas['USER_CHECK']."<br>";?> </strong><br>
							
				</div>
	<?php } ?>
		<?php if($numrowsAfa > 0){ ?> 
		<div class="alert alert-danger alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
							<strong>Pengajuan ini sudah Request by AFA <br>
							NOTES : <?php echo $dataAfa['NOTES'];?><br>
							Dibuat pada tanggal <?php if($dataAfa['CREATE_DATE']<>NULL){echo $dataAfa['CREATE_DATE']->format("d F Y");}?> </strong><br>
							
				</div>
	<?php } ?>
		<?php if($securityDeposit == "1" ){ ?> 
		<div class="alert alert-danger alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
							<strong>Pengajuan ini sudah Request by AFA Penggunaan Security Deposit Dealer NSCB <br>
							
							
				</div>
	<?php } ?>
        <div class="card">
            <div class="header">
                <h4 class="title">Detail Informasi</h4>
                <p class="category">Informasi Detail untuk prospek</p>
				<hr>
            </div>
            <div class="content">
				<div class="">
					<div class="row">
						<div class="col-md-6">
							<div class="table-responsive">
								<table class="table table-bordered table-striped" style="width:100%;">
									<tr>
										<td colspan="3" style="color:#FFF;background-color:#035c7a;font-weight:bold;">PEMOHON</td>
									</tr>
									<tr>
										<td>Nomor Prospek / Nomor Order</td>
										<td>:</td>
										<td><?php echo strtoupper($no);?></td>
									</tr>
									<tr>
										<td>Nomor Identitas (KTP)</td>
										<td>:</td>
										<td><?php echo strtoupper($data['ID_NO']);?></td>
									</tr>
									<tr>
										<td>Nama Pemohon</td>
										<td>:</td>
										<td><?php echo strtoupper($data['CUST_NAME']);?></td>
									</tr>
									<tr>
										<td>Tempat, Tanggal Lahir</td>
										<td>:</td>
										<td><?php echo strtoupper($data['BIRTH_PLACE']).", ";?> <?php if($data['BIRTH_DT']<>NULL){echo $data['BIRTH_DT']->format("d F Y");}?></td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td>:</td>
										<td><?php echo strtoupper($data['ADDR']);?></td>
									</tr>
									<tr>
										<td>Nama Ibu Kandung</td>
										<td>:</td>
										<td><?php echo strtoupper($data['MOTHER_MAIDEN_NAME']);?></td>
									</tr>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered table-striped" style="width:100%;">
									<tr>
										<td colspan="3" style="color:#FFF;background-color:#035c7a;font-weight:bold;"><?php echo strtoupper($siapanih);?></td>
									</tr>
									<tr>
										<td>Nomor Identitas (KTP)</td>
										<td>:</td>
										<td><?php echo $ktpsaya;?></td>
									</tr>
									<tr>
										<td>Nama <?php echo $siapanih;?></td>
										<td>:</td>
										<td><?php echo strtoupper($namasaya);?></td>
									</tr>
									<tr>
										<td>Tempat, Tanggal Lahir</td>
										<td>:</td>
										<td><?php echo strtoupper($tempatlahirsaya);?>, <?php echo strtoupper($tgllahirsaya);?></td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td>:</td>
										<td><?php echo strtoupper($alamatsaya);?></td>
									</tr>
									<tr>
										<td>Nama Ibu Kandung</td>
										<td>:</td>
										<td><?php echo strtoupper($namaibusaya);?></td>
									</tr>
								</table>
							</div>
						</div>
						<div class="col-md-6">
							<div class="table-responsive">
							<!-- mosnew -->
							
							<?php if($data['STAT_MOS'] == "NEW" ){
											
							
								?>
							<table class="table table-bordered" style="width:100%;">
									<tr>
										<td colspan="3" style="color:#FFF;background-color:#035c7a;font-weight:bold;">DOKUMEN</td>
									</tr>
									<tr>
										<td>KTP Pemohon</td>
										<td>:</td>
										<td>
											<a href="data:image/jpeg;base64,<?php echo $data['Pemohon_FotoKTP'];?>" data-lightbox="property">
												<button type="button" class="btn btn-custom btn-xs img-polaroid" style="width:180px;"><i class="fa fa-image"></i> Foto KTP Pemohon</button>
											</a>
										</td>
									</tr>
									<tr>
										<td>KTP <?php echo $siapanih;?></td>
										<td>:</td>
										<td>
											<?php if($siapanih == "Penjamin" || $siapanih == "PENJAMIN"){ ?>
												<a href="data:image/jpeg;base64,<?php echo $data['Penjamin_Fotoktp'];?>" data-lightbox="property">
											<?php }else if($siapanih == "Pasangan" || $siapanih == "PASANGAN"){ ?>
												<a href="data:image/jpeg;base64,<?php echo $data['Pasangan_Fotoktp'];?>" data-lightbox="property">
											<?php } else { echo"<a href='#'>"; } ?>
												<button type="button" class="btn btn-custom btn-xs img-polaroid" style="width:180px;"><i class="fa fa-image"></i> Foto KTP <?php echo $siapanih;?></button>
											</a>
										</td>
									</tr>
									<tr>
										<td>Kartu Keluarga (KK) Pemohon</td>
										<td>:</td>
										<td>
											<a href="data:image/jpeg;base64,<?php echo $data['Pemohon_FotoKK'];?>" data-lightbox="property">
												<button type="button" class="btn btn-custom btn-xs img-polaroid" style="width:180px;"><i class="fa fa-image"></i> Kartu Keluarga (KK)</button>
											</a>
										</td>
									</tr>
									<?php
									if($siapanih == "Penjamin"){
									?>
									<tr>
										<td>Kartu Keluarga (KK) Penjamin</td>
										<td>:</td>
										<td>
											<a href="data:image/jpeg;base64,<?php echo $data['Penjamin_FotoKK'];?>" data-lightbox="property">
												<button type="button" class="btn btn-custom btn-xs img-polaroid" style="width:180px;"><i class="fa fa-image"></i> Kartu Keluarga (KK)</button>
											</a>
										</td>
									</tr>
									<?php } ?>
									<?php
									if (strpos($no, 'PRS') !== false) {
									?>
									<!--<tr>
										<td>FOTO SPK</td>
										<td>:</td>
										<td>
											<?php// if($data4['IMG_SPK'] == ''){ echo"<a href='#'>";  ?>
											
										
										
												<a href="data:image/jpeg;base64,<?php// echo base64_encode($data4['IMG_SPK']);?>" data-lightbox="property">
											
												<button type="button" class="btn btn-custom btn-xs img-polaroid" style="width:180px;"><i class="fa fa-image"></i> Foto SPK </button>
											</a>
										</td>
									</tr>-->
									<tr>
										<td>FOTO BUKU NIKAH</td>
										<td>:</td>
										<td>
											<?php if($dataNikah['IMG_SRC'] == NULL){ echo"<a href='#'>";  ?>
											
										
											<?php  }else { ?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($dataNikah['IMG_SRC']);?>" data-lightbox="property">
											<?php } ?>
												<button type="button" class="btn btn-custom btn-xs img-polaroid" style="width:180px;"><i class="fa fa-image"></i> FOTO BUKU NIKAH </button>
											</a>
										</td>
									</tr>
									
									<tr>
										<td>FOTO KK PASANGAN / PENJAMIN</td>
										<td>:</td>
										<td>
											<?php if($dataKk['IMG_SRC'] == NULL){ echo"<a href='#'>";  ?>
											
										
											<?php  }else { ?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($dataKk['IMG_SRC']);?>" data-lightbox="property">
											<?php } ?>
												<button type="button" class="btn btn-custom btn-xs img-polaroid"><i class="fa fa-image"></i> Foto KK PASANGAN / PENJAMIN </button>
											</a>
										</td>
									</tr>
									<?php }else{ ?>
									
									
									<tr>
										<td>FOTO SPK</td>
										<td>:</td>
										<td>
											<?php if($data['FOTO_SPK'] == NULL){ echo"<a href='#'>";  ?>
											
										
											<?php  }else { ?>
												<a href="data:image/jpeg;base64,<?php echo $data['FOTO_SPK'];?>" data-lightbox="property">
											<?php } ?>
												<button type="button" class="btn btn-custom btn-xs img-polaroid" style="width:180px;"><i class="fa fa-image"></i> Foto SPK </button>
											</a>
										</td>
									</tr>
									
									<tr>
										<td>FOTO BUKU NIKAH</td>
										<td>:</td>
										<td>
											<?php if($dataNikah['IMG_SRC'] == NULL){ echo"<a href='#'>";  ?>
											
										
											<?php  }else { ?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($dataNikah['IMG_SRC']);?>" data-lightbox="property">
											<?php } ?>
												<button type="button" class="btn btn-custom btn-xs img-polaroid" style="width:180px;"><i class="fa fa-image"></i> FOTO BUKU NIKAH </button>
											</a>
										</td>
									</tr>
									
									<tr>
										<td>FOTO KK PASANGAN / PENJAMIN</td>
										<td>:</td>
										<td>
											<?php if($dataKk['IMG_SRC'] == NULL){ echo"<a href='#'>";  ?>
											
										
											<?php  }else { ?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($dataKk['IMG_SRC']);?>" data-lightbox="property">
											<?php } ?>
												<button type="button" class="btn btn-custom btn-xs img-polaroid"><i class="fa fa-image"></i> Foto KK PASANGAN / PENJAMIN </button>
											</a>
										</td>
									</tr>
									
									<?php } ?>
								</table>
									<?php }else{ ?>
							<!-- mosold -->
								<table class="table table-bordered" style="width:100%;">
									<tr>
										<td colspan="3" style="color:#FFF;background-color:#035c7a;font-weight:bold;">DOKUMEN</td>
									</tr>
									<tr>
										<td>KTP Pemohon</td>
										<td>:</td>
										<td>
											<a href="data:image/jpeg;base64,<?php echo base64_encode($data['Pemohon_FotoKTP']);?>" data-lightbox="property">
												<button type="button" class="btn btn-custom btn-xs img-polaroid" style="width:180px;"><i class="fa fa-image"></i> Foto KTP Pemohon</button>
											</a>
										</td>
									</tr>
									<tr>
										<td>KTP <?php echo $siapanih;?></td>
										<td>:</td>
										<td>
											<?php if($siapanih == "Penjamin" || $siapanih == "PENJAMIN"){ ?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($data['Penjamin_Fotoktp']);?>" data-lightbox="property">
											<?php }else if($siapanih == "Pasangan" || $siapanih == "PASANGAN"){ ?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($data['Pasangan_Fotoktp']);?>" data-lightbox="property">
											<?php } else { echo"<a href='#'>"; } ?>
												<button type="button" class="btn btn-custom btn-xs img-polaroid" style="width:180px;"><i class="fa fa-image"></i> Foto KTP <?php echo $siapanih;?></button>
											</a>
										</td>
									</tr>
									<tr>
										<td>Kartu Keluarga (KK) Pemohon</td>
										<td>:</td>
										<td>
											<a href="data:image/jpeg;base64,<?php echo base64_encode($data['Pemohon_FotoKK']);?>" data-lightbox="property">
												<button type="button" class="btn btn-custom btn-xs img-polaroid" style="width:180px;"><i class="fa fa-image"></i> Kartu Keluarga (KK)</button>
											</a>
										</td>
									</tr>
									<?php
									if($siapanih == "Penjamin"){
									?>
									<tr>
										<td>Kartu Keluarga (KK) Penjamin</td>
										<td>:</td>
										<td>
											<a href="data:image/jpeg;base64,<?php echo base64_encode($data['Penjamin_FotoKK']);?>" data-lightbox="property">
												<button type="button" class="btn btn-custom btn-xs img-polaroid" style="width:180px;"><i class="fa fa-image"></i> Kartu Keluarga (KK)</button>
											</a>
										</td>
									</tr>
									<?php } ?>
									<?php
									if (strpos($no, 'PRS') !== false) {
									?>
									<!--<tr>
										<td>FOTO SPK</td>
										<td>:</td>
										<td>
											<?php// if($data4['IMG_SPK'] == ''){ echo"<a href='#'>";  ?>
											
										
										
												<a href="data:image/jpeg;base64,<?php// echo base64_encode($data4['IMG_SPK']);?>" data-lightbox="property">
											
												<button type="button" class="btn btn-custom btn-xs img-polaroid" style="width:180px;"><i class="fa fa-image"></i> Foto SPK </button>
											</a>
										</td>
									</tr>-->
									<tr>
										<td>FOTO BUKU NIKAH</td>
										<td>:</td>
										<td>
											<?php if($dataNikah['IMG_SRC'] == NULL){ echo"<a href='#'>";  ?>
											
										
											<?php  }else { ?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($dataNikah['IMG_SRC']);?>" data-lightbox="property">
											<?php } ?>
												<button type="button" class="btn btn-custom btn-xs img-polaroid" style="width:180px;"><i class="fa fa-image"></i> FOTO BUKU NIKAH </button>
											</a>
										</td>
									</tr>
									
									<tr>
										<td>FOTO KK PASANGAN / PENJAMIN</td>
										<td>:</td>
										<td>
											<?php if($dataKk['IMG_SRC'] == NULL){ echo"<a href='#'>";  ?>
											
										
											<?php  }else { ?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($dataKk['IMG_SRC']);?>" data-lightbox="property">
											<?php } ?>
												<button type="button" class="btn btn-custom btn-xs img-polaroid"><i class="fa fa-image"></i> Foto KK PASANGAN / PENJAMIN </button>
											</a>
										</td>
									</tr>
									<?php }else{ ?>
									
									
									<tr>
										<td>FOTO SPK</td>
										<td>:</td>
										<td>
											<?php if($data['FOTO_SPK'] == NULL){ echo"<a href='#'>";  ?>
											
										
											<?php  }else { ?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($data['FOTO_SPK']);?>" data-lightbox="property">
											<?php } ?>
												<button type="button" class="btn btn-custom btn-xs img-polaroid" style="width:180px;"><i class="fa fa-image"></i> Foto SPK </button>
											</a>
										</td>
									</tr>
									
									<tr>
										<td>FOTO BUKU NIKAH</td>
										<td>:</td>
										<td>
											<?php if($dataNikah['IMG_SRC'] == NULL){ echo"<a href='#'>";  ?>
											
										
											<?php  }else { ?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($dataNikah['IMG_SRC']);?>" data-lightbox="property">
											<?php } ?>
												<button type="button" class="btn btn-custom btn-xs img-polaroid" style="width:180px;"><i class="fa fa-image"></i> FOTO BUKU NIKAH </button>
											</a>
										</td>
									</tr>
									
									<tr>
										<td>FOTO KK PASANGAN / PENJAMIN</td>
										<td>:</td>
										<td>
											<?php if($dataKk['IMG_SRC'] == NULL){ echo"<a href='#'>";  ?>
											
										
											<?php  }else { ?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($dataKk['IMG_SRC']);?>" data-lightbox="property">
											<?php } ?>
												<button type="button" class="btn btn-custom btn-xs img-polaroid"><i class="fa fa-image"></i> Foto KK PASANGAN / PENJAMIN </button>
											</a>
										</td>
									</tr>
									
									<?php } ?>
								</table>
									<?php }?>
							</div>
							<div id="reject_note"> 
							<hr>
							<b>Reject Notes</b><br>
							<?php 
							while($dataReject = sqlsrv_fetch_array($execReject)){ ?>
							<label>REJECTED BY : </label><p class="category"><b><?php echo strtoupper($dataReject['USER_REJECT'])."</b> - ".$dataReject['CREATE_NOTE']->format("d F Y H:i:s");?></p>
							<label>NOTES : </label><p class="category"><?php echo $dataReject['NOTES'];?></p>
							
							
							<?php } ?>	
							</div>
							<hr>
							<b>Note :</b><br>
							<i>
								* Jika foto tidak dapat dilihat, maka foto tidak ada di database<br>
								* Check lewat SLIK dengan data berikut<br>
								* Upload hasil SLIK pada form dibawah ini<br>
								* Pilih submit jika hasil SLIK sudah diupload<br>
								* Pilih reject jika informasi yang ditampilkan kurang lengkap<br>
							</i>
							
							<hr>
								<b>GENERATE NO IDEB :</b><br>
							<form action="" method="post">
								<input name='id' type='hidden' value='<?php echo $id;?>'>
								<input name='prospect_no' type='hidden' value='<?php echo $no;?>'>
								<input name='no_ktp' type='hidden' value='<?php echo $nik;?>'>
								<input name='name' type='hidden' value="<?php echo $nama;?>">
								
								<input name='tipe_cust' type='hidden' value='<?php echo $siapanih1;?>'>
								<input name='branch_id' type='hidden' value='<?php echo $dataBranch['OFFICE_CODE'];?>'>
								<input name='kategori' type='hidden' value='<?php echo $dataBranch['KATEGORI'];?>'>
								<?php IF($dataGenerate['IDEB_NO']==NULL){ ?>
							<input type="submit" value="Generate" class="btn btn-primary" name="submit_col">
								<?php } ?>
							</form>
							<input name='no_ideb' type='text' class='form-control' value='<?php echo $dataGenerate['IDEB_NO'];?>'>
							<hr>
							<b>Upload hasil SLIK (PDF)</b>
							<form  action="index.php?page=check_pefindo_new&USERNAME=<?php echo $user;?>" method="post" enctype="multipart/form-data" id="pefindo">
											
											<input name='id' type='hidden' value='<?php echo $id;?>'>
												<input name='prospect_no' type='hidden' value='<?php echo $no;?>'>
											<input name='no_ktp' type='hidden' value='<?php echo $nik;?>'>
											<input name='name' type='hidden' value="<?php echo $nama;?>">
											<input name='tipe_cust' type='hidden' value='<?php echo $siapanih1;?>'>
											<input name='date' type='hidden'  value="<?php if($data9['BIRTH_DATE']<>NULL){echo $data9['BIRTH_DATE']->format('Y-m-d');}?>">
											<input name='mother_name' type='hidden' value="">
											<input name='birth_place' type='hidden' value="">
									
											
										</form>
							<form action="pages/action-upload-slik.php" method="post" enctype="multipart/form-data" id="myForm">
								<input type="hidden" name="mapping_id" value="<?php echo $id;?>"> 
								<input type="hidden" name="prospect_no" value="<?php echo $no;?>"> 
								<input type="hidden" name="no_ktp" value="<?php echo $nik;?>"> 
								<input type="hidden" name="user" value="<?php echo $userlogin;?>"> 
								
								<div class="form-group">
									<input type="file" name="file" class="form-control">
									
										<br>
											<b>Upload Fasilitas (Txt)</b>
										<input type="file" name="slik" id="slik" class="form-control" >
										<br>
										<input type="checkbox" name="notFound" id="notFound"  onclick="myFunction()"> &nbsp;<b><label  style="font-size:14px;color:black;">Data tidak ditemukan di SLIK</label></b>
											<input type="hidden" name="notFound" id="notFound2" value="">
												
								</div>
								<div class="">
									<div class="dropdown">
										<button class="btn btn-custom btn-sm dropdown-toggle" type="button" data-toggle="dropdown" style="width:100%;">ACTION
										<span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li class=""><a href="#" onclick="document.getElementById('pefindo').submit();">Cek Pefindo</a></li>
											<li><a href="#" onclick="document.getElementById('myForm').submit();">Submit hasil SLIK</a></li>
											<li><a href="index.php?page=slik-note&USERNAME=<?php echo $user;?>&id=<?php echo $id;?>&flag=2">Reject request</a></li>
											<li><a href="pages/slik-not-found.php?USERNAME=<?php echo $user;?>&id=<?php echo $id;?>&no=<?php echo $no;?>">Data tidak ditemukan di SLIK</a></li>
										</ul>
									</div> 
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="assets/js/jqueryrotate.min.js"></script>
<script>
var checker = document.getElementById('notFound');
var sendbtn = document.getElementById('slik');
checker.onchange = function() {
  sendbtn.disabled = !!this.checked;
};

function myFunction() {
  var checkBox = document.getElementById("notFound");
  var text = document.getElementById("notFound2");
  
  if (checkBox.checked == true){
    text.value = "1";
  } else {
     text.value = "";
  }
}


var j = jQuery.noConflict();
j(document).ready(function() {
	j(".fancybox").fancybox();
});
</script>
<script>
(function() {
  var $, Lightbox, LightboxOptions;

  $ = jQuery;

  LightboxOptions = (function() {
    function LightboxOptions() {
      this.fadeDuration = 500;
      this.fitImagesInViewport = true;
      this.resizeDuration = 700;
      this.showImageNumberLabel = true;
      this.wrapAround = false;
    }

    LightboxOptions.prototype.albumLabel = function(curImageNum, albumSize) {
      return "Image " + curImageNum + " of " + albumSize;
    };

    return LightboxOptions;

  })();

  Lightbox = (function() {
    function Lightbox(options) {
      this.options = options;
      this.album = [];
      this.currentImageIndex = void 0;
      this.init();
    }

    Lightbox.prototype.init = function() {
      this.enable();
      return this.build();
    };

    Lightbox.prototype.enable = function() {
      var _this = this;
      return $('body').on('click', 'a[rel^=lightbox], area[rel^=lightbox], a[data-lightbox], area[data-lightbox]', function(e) {
        _this.start($(e.currentTarget));
        return false;
      });
    };

    Lightbox.prototype.build = function() {
      var _this = this;
      $("<div id='lightboxOverlay' class='lightboxOverlay'></div><div id='lightbox' class='lightbox'><div class='lb-outerContainer'><div class='lb-container'><img class='lb-image' src='' /><div class='lb-nav'><a class='lb-prev' href='' ></a><a class='lb-next' href='' ></a></div><div class='lb-loader'><a class='lb-cancel'></a></div></div></div><div class='lb-dataContainer'><div class='lb-data'><div class='lb-details'><span class='lb-caption'></span><span class='lb-number'></span></div><div class='lb-closeContainer'><a class='lb-close' style='margin:5px;'><button class='btn btn-danger btn-sm btn-fill'><i class='fa fa-times'></i></button></a>&nbsp;&nbsp;&nbsp;<a class='lb-rotate' style='margin:5px;'><button class='btn btn-primary btn-sm btn-fill' style='margib-right:5px;'><i class='fa fa-undo'></i></button></a></div></div></div></div>").appendTo($('body'));
      this.$lightbox = $('#lightbox');
      this.$overlay = $('#lightboxOverlay');
      this.$outerContainer = this.$lightbox.find('.lb-outerContainer');
      this.$container = this.$lightbox.find('.lb-container');
      this.containerTopPadding = parseInt(this.$container.css('padding-top'), 10);
      this.containerRightPadding = parseInt(this.$container.css('padding-right'), 10);
      this.containerBottomPadding = parseInt(this.$container.css('padding-bottom'), 10);
      this.containerLeftPadding = parseInt(this.$container.css('padding-left'), 10);
      this.$overlay.hide().on('click', function() {
        _this.end();
        return false;
      });
      this.$lightbox.hide().on('click', function(e) {
        if ($(e.target).attr('id') === 'lightbox') {
          _this.end();
        }
        return false;
      });
      this.$outerContainer.on('click', function(e) {
        if ($(e.target).attr('id') === 'lightbox') {
          _this.end();
        }
        return false;
      });
      this.$lightbox.find('.lb-prev').on('click', function() {
        if (_this.currentImageIndex === 0) {
          _this.changeImage(_this.album.length - 1);
        } else {
          _this.changeImage(_this.currentImageIndex - 1);
        }
        return false;
      });
      this.$lightbox.find('.lb-next').on('click', function() {
        if (_this.currentImageIndex === _this.album.length - 1) {
          _this.changeImage(0);
        } else {
          _this.changeImage(_this.currentImageIndex + 1);
        }
        return false;
      });
      this.$lightbox.find('.lb-rotate').on('click', function() {
          $cont = _this.$lightbox.find('.lb-outerContainer');
          $image = _this.$lightbox.find('.lb-image');
          
            if ($($cont).attr('angle') == null) {
                $($cont).attr('angle', 0);
            }
            var value = Number($($cont).attr('angle'));
            value += 90;
        
            $($cont).rotate({ animateTo:value});
            $($cont).attr('angle', value);          
          
          return false;
      });      
      
      return this.$lightbox.find('.lb-loader, .lb-close').on('click', function() {
        _this.end();
        return false;
      });
    };

    Lightbox.prototype.start = function($link) {
      var $window, a, dataLightboxValue, i, imageNumber, left, top, _i, _j, _len, _len1, _ref, _ref1;
      $(window).on("resize", this.sizeOverlay);
      $('select, object, embed').css({
        visibility: "hidden"
      });
      this.$overlay.width($(document).width()).height($(document).height()).fadeIn(this.options.fadeDuration);
      this.album = [];
      imageNumber = 0;
      dataLightboxValue = $link.attr('data-lightbox');
      if (dataLightboxValue) {
        _ref = $($link.prop("tagName") + '[data-lightbox="' + dataLightboxValue + '"]');
        for (i = _i = 0, _len = _ref.length; _i < _len; i = ++_i) {
          a = _ref[i];
          this.album.push({
            link: $(a).attr('href'),
            title: $(a).attr('title')
          });
          if ($(a).attr('href') === $link.attr('href')) {
            imageNumber = i;
          }
        }
      } else {
        if ($link.attr('rel') === 'lightbox') {
          this.album.push({
            link: $link.attr('href'),
            title: $link.attr('title')
          });
        } else {
          _ref1 = $($link.prop("tagName") + '[rel="' + $link.attr('rel') + '"]');
          for (i = _j = 0, _len1 = _ref1.length; _j < _len1; i = ++_j) {
            a = _ref1[i];
            this.album.push({
              link: $(a).attr('href'),
              title: $(a).attr('title')
            });
            if ($(a).attr('href') === $link.attr('href')) {
              imageNumber = i;
            }
          }
        }
      }
      $window = $(window);
      top = $window.scrollTop() + $window.height() / 10;
      left = $window.scrollLeft();
      this.$lightbox.css({
        top: top + 'px',
        left: left + 'px'
      }).fadeIn(this.options.fadeDuration);
      this.changeImage(imageNumber);
    };

    Lightbox.prototype.changeImage = function(imageNumber) {
      var $image, preloader,
        _this = this;
      this.disableKeyboardNav();
      $image = this.$lightbox.find('.lb-image');
      
      this.sizeOverlay();
      this.$overlay.fadeIn(this.options.fadeDuration);
      $('.lb-loader').fadeIn('slow');
      this.$lightbox.find('.lb-image, .lb-nav, .lb-prev, .lb-next, .lb-dataContainer, .lb-numbers, .lb-caption').hide();
      this.$outerContainer.addClass('animating');
      preloader = new Image();
      preloader.onload = function() {
        var $preloader, imageHeight, imageWidth, maxImageHeight, maxImageWidth, windowHeight, windowWidth;
        $image.attr('src', _this.album[imageNumber].link);
        $preloader = $(preloader);
        $image.width(preloader.width);
        $image.height(preloader.height);
        if (_this.options.fitImagesInViewport) {
          windowWidth = $(window).width();
          windowHeight = $(window).height();
          maxImageWidth = windowWidth - _this.containerLeftPadding - _this.containerRightPadding - 20;
          maxImageHeight = windowHeight - _this.containerTopPadding - _this.containerBottomPadding - 110;
          if ((preloader.width > maxImageWidth) || (preloader.height > maxImageHeight)) {
            if ((preloader.width / maxImageWidth) > (preloader.height / maxImageHeight)) {
              imageWidth = maxImageWidth;
              imageHeight = parseInt(preloader.height / (preloader.width / imageWidth), 10);
              $image.width(imageWidth);
              $image.height(imageHeight);
            } else {
              imageHeight = maxImageHeight;
              imageWidth = parseInt(preloader.width / (preloader.height / imageHeight), 10);
              $image.width(imageWidth);
              $image.height(imageHeight);
            }
          }
        }
        return _this.sizeContainer($image.width(), $image.height());
      };
      preloader.src = this.album[imageNumber].link;
      this.currentImageIndex = imageNumber;
    };

    Lightbox.prototype.sizeOverlay = function() {
      return $('#lightboxOverlay').width($(document).width()).height($(document).height());
    };

    Lightbox.prototype.sizeContainer = function(imageWidth, imageHeight) {
      var newHeight, newWidth, oldHeight, oldWidth,
        _this = this;
      oldWidth = this.$outerContainer.outerWidth();
      oldHeight = this.$outerContainer.outerHeight();
      newWidth = imageWidth + this.containerLeftPadding + this.containerRightPadding;
      newHeight = imageHeight + this.containerTopPadding + this.containerBottomPadding;
      this.$outerContainer.animate({
        width: newWidth,
        height: newHeight
      }, this.options.resizeDuration, 'swing');
      setTimeout(function() {
        _this.$lightbox.find('.lb-dataContainer').width(newWidth);
        _this.$lightbox.find('.lb-prevLink').height(newHeight);
        _this.$lightbox.find('.lb-nextLink').height(newHeight);
        _this.showImage();
      }, this.options.resizeDuration);
    };

    Lightbox.prototype.showImage = function() {
      this.$lightbox.find('.lb-loader').hide();
      this.$lightbox.find('.lb-image').fadeIn('slow');
      this.updateNav();
      this.updateDetails();
      this.preloadNeighboringImages();
      this.enableKeyboardNav();
    };

    Lightbox.prototype.updateNav = function() {
      this.$lightbox.find('.lb-nav').show();
      if (this.album.length > 1) {
        if (this.options.wrapAround) {
          this.$lightbox.find('.lb-prev, .lb-next').show();
        } else {
          if (this.currentImageIndex > 0) {
            this.$lightbox.find('.lb-prev').show();
          }
          if (this.currentImageIndex < this.album.length - 1) {
            this.$lightbox.find('.lb-next').show();
          }
        }
      }
    };

    Lightbox.prototype.updateDetails = function() {
      var _this = this;
      if (typeof this.album[this.currentImageIndex].title !== 'undefined' && this.album[this.currentImageIndex].title !== "") {
        this.$lightbox.find('.lb-caption').html(this.album[this.currentImageIndex].title).fadeIn('fast');
      }
      if (this.album.length > 1 && this.options.showImageNumberLabel) {
        this.$lightbox.find('.lb-number').text(this.options.albumLabel(this.currentImageIndex + 1, this.album.length)).fadeIn('fast');
      } else {
        this.$lightbox.find('.lb-number').hide();
      }
      this.$outerContainer.removeClass('animating');
      this.$lightbox.find('.lb-dataContainer').fadeIn(this.resizeDuration, function() {
        return _this.sizeOverlay();
      });
    };

    Lightbox.prototype.preloadNeighboringImages = function() {
      var preloadNext, preloadPrev;
      if (this.album.length > this.currentImageIndex + 1) {
        preloadNext = new Image();
        preloadNext.src = this.album[this.currentImageIndex + 1].link;
      }
      if (this.currentImageIndex > 0) {
        preloadPrev = new Image();
        preloadPrev.src = this.album[this.currentImageIndex - 1].link;
      }
    };

    Lightbox.prototype.enableKeyboardNav = function() {
      $(document).on('keyup.keyboard', $.proxy(this.keyboardAction, this));
    };

    Lightbox.prototype.disableKeyboardNav = function() {
      $(document).off('.keyboard');
    };

    Lightbox.prototype.keyboardAction = function(event) {
      var KEYCODE_ESC, KEYCODE_LEFTARROW, KEYCODE_RIGHTARROW, key, keycode;
      KEYCODE_ESC = 27;
      KEYCODE_LEFTARROW = 37;
      KEYCODE_RIGHTARROW = 39;
      keycode = event.keyCode;
      key = String.fromCharCode(keycode).toLowerCase();
      if (keycode === KEYCODE_ESC || key.match(/x|o|c/)) {
        this.end();
      } else if (key === 'p' || keycode === KEYCODE_LEFTARROW) {
        if (this.currentImageIndex !== 0) {
          this.changeImage(this.currentImageIndex - 1);
        }
      } else if (key === 'n' || keycode === KEYCODE_RIGHTARROW) {
        if (this.currentImageIndex !== this.album.length - 1) {
          this.changeImage(this.currentImageIndex + 1);
        }
      }
    };

    Lightbox.prototype.end = function() {
      this.disableKeyboardNav();
      $(window).off("resize", this.sizeOverlay);
      this.$lightbox.fadeOut(this.options.fadeDuration);
      this.$overlay.fadeOut(this.options.fadeDuration);
      return $('select, object, embed').css({
        visibility: "visible"
      });
    };

    return Lightbox;

  })();

  $(function() {
    var lightbox, options;
    options = new LightboxOptions();
    return lightbox = new Lightbox(options);
  });

}).call(this);
</script>