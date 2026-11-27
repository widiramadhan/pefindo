   <script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script> 
<?php
$callGet = "{call SP_GET_REQ_ID_GENERATE}";
$execGet = sqlsrv_query( $conn, $callGet) or die( print_r( sqlsrv_defaults(), true)); 
$dataGet = sqlsrv_fetch_array($execGet);


  $error="";
$req_id = $dataGet['REQ_ID'];
$date = date("Y-m-d");



if(isset($_POST['submit_col']) ){
$nokon = $_POST['nokon'];	
	
	$call2 = "{call SP_GET_DATA_FROM_NOMOR_KONTRAK(?)}";
	$param2 = array(array($nokon, SQLSRV_PARAM_IN));
	$exec2 = sqlsrv_query( $conn, $call2,$param2)  or die( print_r( sqlsrv_errors(), true));
	$data2 = sqlsrv_fetch_array($exec2);
	if($data2['Pasangan_Noktp'] == "" || $data2['Pasangan_Noktp'] == NULL){
		$siapanih = "Penjamin";
		$ktpsaya = $data2['Penjamin_Noktp'];
		$namasaya = $data2['Penjamin_Nama'];
		if($data2['Penjamin_TglLahir']<>NULL){$tgllahirsaya = $data2['Penjamin_TglLahir']->format("Y-m-d");}else{$tgllahirsaya="";}
		$tgllahirsaya1=$data2['Penjamin_TglLahir'];
		//$tempatlahirsaya = $data2['Penjamin_TempatLahir'];
		 if($data2['Penjamin_Ibu']<>NULL){$namaibusaya = $data2['Penjamin_Ibu'];}else{$namaibusaya="";}
		if($data2['Penjamin_Alamat']<>NULL){$alamatsaya = $data2['Penjamin_Alamat'];}else{$alamatsaya="";}
		$status_kawin_saya = $data2['Penjamin_status_kawin'];
		
	}else{
		$siapanih = "Pasangan";
		$ktpsaya = $data2['Pasangan_Noktp'];
		$namasaya = $data2['Pasangan_Nama'];
		if($data2['Pasangan_TglLahir']<>NULL){$tgllahirsaya = $data2['Pasangan_TglLahir']->format("Y-m-d");}else{$tgllahirsaya="";}
		$tgllahirsaya1=$data2['Pasangan_TglLahir'];
		//$tempatlahirsaya = $data2['Pasangan_TempatLahir'];
		if($data2['Pasangan_Ibu']<>NULL){$namaibusaya = $data2['Pasangan_Ibu'];}else{$namaibusaya="";}
		if($data2['Pasangan_Alamat']<>NULL){$alamatsaya = $data2['Pasangan_Alamat'];}else{$alamatsaya="";}
		$status_kawin_saya = $data2['Pasangan_status_kawin'];
	}
	
	$ktp = $data2['ID_NO'];
	$nama=$data2['CUST_NAME'];
	if($data2['BIRTH_DT']<>NULL){$tgllahir=$data2['BIRTH_DT']->format("Y-m-d");}
	$alamat = $data2['ADDR'];
	$namaibu = $data2['MOTHER_MAIDEN_NAME'];
	$status_kawin = $data2['STATUS_KAWIN'];
	$fotoKTPPemohon = $data2['Pemohon_FotoKTP'];
	$fotoKTPPasangan = $data2['Pasangan_Fotoktp'];
	$fotoKTPenjamin = $data2['Penjamin_Fotoktp'];
	$fotoKK = $data2['Pemohon_FotoKK'];
	$survey_id = $data2['SURVEY_ID'];
	//if($data2['Pemohon_FotoNPWP']<>NULL){
	//	$fotoNPWP=$data2['Pemohon_FotoNPWP'];
	//	}else{
			$fotoNPWP='';
	//	};
	//$fotoNPWP = $data2['Pemohon_FotoNPWP'];
	
}	
else{
	$nokon = "";
	$siapanih = "Pasangan";
		$ktpsaya = "";
		$namasaya = "";
	    $tgllahirsaya="";
		$tgllahirsaya1="";
		//$tempatlahirsaya = $data2['Pasangan_TempatLahir'];
		$namaibusaya="";
		$alamatsaya="";
		$status_kawin_saya ="";
		
		$ktp = "";
		$nama="";
		$tgllahir = "";
		$alamat = "";
		$namaibu = "";
		$status_kawin = "";
		$fotoKTPPemohon = "";
		$fotoKTPPasangan =  "";
		$fotoKTPenjamin = "";
		$fotoKK =  "";
		$fotoNPWP = "";
		$survey_id = "";
}

	
	

function prepareImageDBString($filepath){
	$output = 'null';
	$handle = @fopen($filepath, 'rb');
	if ($handle){
		$content = @fread($handle, filesize($filepath));
		$content = bin2hex($content);
		@fclose($handle);
		$output = "0x".strtoupper($content);
	}
	return $output;
}


if(isset($_POST['submit'])){
	$req_id = $dataGet['REQ_ID'];
		$nokon = $_POST['nokon'];
		$siapanih =  $_POST['siapanih'];
		$ktpsaya =  $_POST['ktp_pasangan'];
		$namasaya =  $_POST['nama_pasangan'];
	    $tgllahirsaya= $_POST['tgl_pasangan'];
		//$tempatlahirsaya = $data2['Pasangan_TempatLahir'];
		$namaibusaya= $_POST['nama_ibu_pasangan'];
		$alamatsaya= $_POST['alamatsaya'];
		$status_kawin_saya = $_POST['status_pasangan'];
		
		$ktp =  $_POST['ktp_pemohon'];
		$nama= $_POST['nama_pemohon'];
		$tgllahir =  $_POST['tgl_pemohon'];
		$alamat =  $_POST['alamat'];
		$namaibu =  $_POST['nama_ibu_pemohon'];
		$status_kawin = $_POST['status_kawin_pemohon'];
		
		//pemohon 
		$call = "{call SP_INSERT_DATA_DEBITUR_EXISTING_TASKLIST(?,?,?,?,?,?,?,?,?,?)}";
		$param = array(	array($req_id, SQLSRV_PARAM_IN),
						array($nokon, SQLSRV_PARAM_IN),
						array($ktp, SQLSRV_PARAM_IN),
						array($nama, SQLSRV_PARAM_IN),
						array($tgllahir, SQLSRV_PARAM_IN),
						array($alamat, SQLSRV_PARAM_IN),
						array($namaibu, SQLSRV_PARAM_IN),
						array($status_kawin, SQLSRV_PARAM_IN),
						array($_GET['USERNAME'], SQLSRV_PARAM_IN),
						array('Pemohon', SQLSRV_PARAM_IN));

		$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
	
		//pasangan pemohon
		
		$call7 = "{call SP_INSERT_DATA_DEBITUR_EXISTING_TASKLIST(?,?,?,?,?,?,?,?,?,?)}";
		$param7 = array(array($req_id, SQLSRV_PARAM_IN),
						array($nokon, SQLSRV_PARAM_IN),
						array($ktpsaya, SQLSRV_PARAM_IN),
						array($namasaya, SQLSRV_PARAM_IN),
						array($tgllahirsaya, SQLSRV_PARAM_IN),
						array($alamatsaya, SQLSRV_PARAM_IN),
						array($namaibusaya, SQLSRV_PARAM_IN),
						array($status_kawin_saya, SQLSRV_PARAM_IN),
						array($_GET['USERNAME'], SQLSRV_PARAM_IN),
						array($siapanih, SQLSRV_PARAM_IN));
		$exec7 = sqlsrv_query( $conn, $call7, $param7) or die( print_r( sqlsrv_errors(), true)); 
			
		
		if($exec7){
			//update status jadi on progress
			

			echo"<script>alert('Data Berhasil Disimpan');window.location='index.php?USERNAME=".$_GET['USERNAME']."'</script>";
		}else{
			echo"<script>alert('Data Gagal Disimpan');history.back();</script>";
		}
	
}
?>
<style>
.img-custom{
	width:100%;
	height:200px;
}
</style>
<!--<form action="" method="post">-->
	<link rel="stylesheet" href="assets/css/lightbox.css" type="text/css" media="screen" />
	 <div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="header">
					<h4 class="title"></h4>
					<p class="category"></p>
				</div>
				<div class="content">		
					<div class="row">
						<div class="col-md-6">
							Data Debitur Existing
						</div>
						<div class="col-md-3">
							Cari Nomor Kontrak
						</div>
						<div class="col-md-2">
						 <form action="" method="post">
							<input type="text" name="nokon" class="form-control"  required id="nokon" value = "<?php echo $nokon;?>" autocomplete="off">
						   
						</div>
						<div class="col-md-1">
						
							<input type="submit" value="Search" class="btn btn-primary" name="submit_col">
						   </form>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="content">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DATA PEMOHON</td>
									</tr>
									<tr>
										<td style="width:50%;">Nomor KTP <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="ktp_pemohon" readonly  onkeypress="return onlyNumber(event)" maxlength="16" class="form-control" placeholder="Nomor KTP" value="<?php echo $ktp;?>" required id="ktp_pemohon" onkeyup="function_ktp_pemohon(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nama Pemohon <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="nama_pemohon" readonly class="form-control" placeholder="Nama karyawan" value="<?php echo $nama;?>" required id="nama_pemohon" onkeyup="function_nama_karyawan(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Tanggal Lahir <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<div class="input-group date">
												<input type="text" name="tgl_pemohon" readonly class="form-control" placeholder="Tanggal Lahir" value="<?php   if($tgllahir<>NULL){
													echo $tgllahir;
													}ELSE{
													echo '-';}?>" required id="tgl_pemohon" onchange="function_tgl_pemohon(this.value)" autocomplete="off">
												<div class="input-group-addon">
													<span class="add-on"><i class="fa fa-calendar"></i></span>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Alamat<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="alamat" readonly class="form-control" placeholder="alamat" required id="alamat" value="<?php echo $alamat;?>" onkeyup="function_alamat(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nama Ibu Kandung <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="nama_ibu_pemohon" readonly class="form-control" placeholder="Nama Ibu Kandung" required id="ibu_pemohon" value="<?php echo $namaibu;?>" onkeyup="function_ibu_pemohon(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Status Kawin <span class="text-danger">*</span></td>
										<td style="width:50%;">
										<input type="text" name="status_kawin_pemohon"  readonly class="form-control"  required id="status_kawin_pemohon" value="<?php echo $status_kawin;?>" onkeyup="function_ibu_pemohon(this.value)" autocomplete="off">
											
										</td>
									</tr>
								</table>
							</div>								
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DATA <?php echo $siapanih;?></td>
									</tr>
									<tr>
										<td style="width:50%;">Nomor KTP <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="ktp_pasangan" readonly onkeypress="return onlyNumber(event)" maxlength="16" class="form-control" placeholder="Nomor KTP" value="<?php echo $ktpsaya;?>" required id="ktp_pasangan" onkeyup="function_ktp_pasangan(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nama <?php echo $siapanih;?> <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="nama_pasangan" readonly class="form-control" placeholder="Nama karyawan" value="<?php echo $namasaya;?>" required id="nama_pasangan" onkeyup="function_nama_karyawan(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Tanggal Lahir <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<div class="input-group date">
												<input type="text" name="tgl_pasangan" readonly class="form-control" placeholder="Tanggal Lahir" value="<?php echo $tgllahirsaya;?>" required id="tgl_pasangan" onchange="function_tgl_pasangan(this.value)" autocomplete="off">
												<div class="input-group-addon">
													<span class="add-on"><i class="fa fa-calendar"></i></span>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Alamat<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="alamat_pasangan" readonly class="form-control" placeholder="alamat" required id="alamat_pasangan" value="<?php echo $alamatsaya;?>" onkeyup="function_alamat(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nama Ibu Kandung <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="nama_ibu_pasangan" readonly class="form-control" placeholder="Nama Ibu Kandung" required id="ibu_pasangan"  value="<?php echo $namaibusaya;?>" onkeyup="function_ibu_pasangan(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Status Kawin <span class="text-danger">*</span></td>
										<td style="width:50%;">
										<input type="text" name="status_kawin_pasangan" readonly class="form-control"  required id="status_kawin_pasangan"  value="<?php echo $status_kawin_saya;?>" onkeyup="function_ibu_pasangan(this.value)" autocomplete="off">
											
										</td>
									</tr>
								</table>
							</div>								
						</div>
						
						
						
						
					</div>
						
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DOKUMEN</td>
									</tr>
									
									<?php if ($survey_id == '0'){?>
									<tr>
										<td style="width:50%;">Foto KTP PEMOHON </td>
										<td style="width:50%;">
											<?php if($fotoKTPPemohon <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo $fotoKTPPemohon;?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo $fotoKTPPemohon;?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											
										</td>
										
									</tr>
											<tr>
										<td style="width:50%;">Foto KTP <?php echo $siapanih;?> </td>
										<?php if($siapanih == 'Pasangan'){?>
										<td style="width:50%;">
											<?php if($fotoKTPPasangan <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo $fotoKTPPasangan;?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo $fotoKTPPasangan;?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											
										</td>
										<?php }else{?>
										<td style="width:50%;">
											<?php if($fotoKTPenjamin <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo $fotoKTPenjamin;?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo $fotoKTPenjamin;?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
										 <?php } }?>
											
											
										</td>
										
									</tr>
									<tr>
										<td style="width:50%;">Foto Kartu Keluarga</td>
										<td style="width:50%;">
											<?php if($fotoKK <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo $fotoKK;?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo $fotoKK;?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
										
										</td>
									</tr>
								
											<tr>
										<td style="width:50%;">Foto NPWP</td>
										<td style="width:50%;">
											<?php if($fotoNPWP <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo $fotoNPWP;?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo $fotoNPWP;?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											
										</td>
									</tr>
									<?php }else{ ?>
										<tr>
										<td style="width:50%;">Foto KTP PEMOHON </td>
										<td style="width:50%;">
											<?php if($fotoKTPPemohon <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($fotoKTPPemohon);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($fotoKTPPemohon);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											
										</td>
										
									</tr>
											<tr>
										<td style="width:50%;">Foto KTP <?php echo $siapanih;?> </td>
										<?php if($siapanih == 'Pasangan'){?>
										<td style="width:50%;">
											<?php if($fotoKTPPasangan <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($fotoKTPPasangan);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($fotoKTPPasangan);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											
										</td>
										<?php }else{?>
										<td style="width:50%;">
											<?php if($fotoKTPenjamin <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($fotoKTPenjamin);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($fotoKTPenjamin);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
										 <?php } }?>
											
											
										</td>
										
									</tr>
									<tr>
										<td style="width:50%;">Foto Kartu Keluarga</td>
										<td style="width:50%;">
											<?php if($fotoKK <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($fotoKK);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($fotoKK);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
										
										</td>
									</tr>
								
											<tr>
										<td style="width:50%;">Foto NPWP</td>
										<td style="width:50%;">
											<?php if($fotoNPWP <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($fotoNPWP);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($fotoNPWP);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											
										</td>
									</tr>
									<?php } ?>
								</table>
							</div>
						</div>
					</div>
					
					<hr>
					<div class="row">
						<div class="col-md-12">
							<center>
								<form action="" method="post">
								
									<input type="hidden" name="ktp_pemohon" id="ktp_pemohon2" value ="<?php echo $ktp; ?>">
									<input type="hidden" name="nama_pemohon1" value="<?php echo $nama;?>" id="nama_pemohon1">
									<input type="hidden" name="nama_pemohon" value="<?php echo $nama;?>" id="nama_pemohon">
									<input type="hidden" name="tgl_pemohon" id="tgl_pemohon2" value ="<?php echo $tgllahir; ?>">
									<input type="hidden" name="nama_ibu_pemohon" id="ibu_pemohon2" value ="<?php echo $namaibu; ?>"> 
									<input type="hidden" name="alamat" id="alamat2" value ="<?php echo $alamat; ?>">
									<input type="hidden" name="status_kawin_pemohon" id="status_kawin_pemohon" value="<?php echo $status_kawin;?>">
									<input type="hidden" name="ktp_pasangan" id="ktp_pasangan2" value ="<?php echo $ktpsaya ; ?>">
									<input type="hidden" name="nama_pasangan" id="nama_karyawan2" value ="<?php echo $namasaya ; ?>">
									<input type="hidden" name="tgl_pasangan" id="tgl_pasangan2" value ="<?php echo $tgllahirsaya; ?>">
									<input type="hidden" name="nama_ibu_pasangan" id="ibu_pasangan2" value ="<?php echo $namaibusaya; ?>">
									<input type="hidden" name="alamatsaya" id="alamatsaya2" value ="<?php echo $alamatsaya; ?>">
									<input type="hidden" name="status_pasangan" id="status_pasangan2" value ="<?php echo $status_kawin_saya; ?>">
									<input type="hidden" name="siapanih" id="status_pasangan2" value ="<?php echo $siapanih; ?>">
								
									<input type="hidden" name="no_regist" id="no_regist2" value ="<?php echo $req_id; ?>">
									<input type="hidden" name="nokon" id="nokon2" value ="<?php echo $nokon; ?>">
							
									
									<?php echo $error;?>
									<input type="submit" name="submit" class="btn btn-custom" value="SIMPAN DATA" style="width:200px;">
									<a href="index.php?page=input-calon-karyawan&USERNAME=<?php echo $user;?>" class="btn btn-custom" style="width:200px;">BATAL</a>
									
								</form>
							</center>
							<br><br>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!--</form>-->
<script src="assets/js/jqueryrotate.min.js"></script>
<script>

</script>
<script>
$( document ).ready(function() {   
	$('#tgl_pemohon').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		yearRange: '1900:2025',
		endDate: new Date()
	});
	
});
</script>
<script>
function onlyNumber(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;
return true;
}
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

