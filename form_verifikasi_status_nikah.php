<?php
ini_set('memory_limit','256M'); // This also needs to be increased in some cases. Can be changed to a higher value as per need)
ini_set('sqlsrv.ClientBufferMaxKBSize','524288'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size','524288'); // Setting to 512M - for pdo_sqlsrv
$user=$_GET['USERNAME'];
$prospect=$_GET['prospect'];
$id_no=$_GET['nik'];



if (strpos($prospect, 'PRS') !== false) {
$call3 = "{call SP_GETDATA_INFO_CUSTOMER_NEWVERSE_2_FORM(?,?)}";
$param3 = array(array($id_no, SQLSRV_PARAM_IN),
				array($prospect, SQLSRV_PARAM_IN));
$options3 =  array( "Scrollable" => "buffered" );
$exec3 = sqlsrv_query( $conn, $call3, $param3, $options3) or die( print_r( sqlsrv_errors(), true));
$data3 = sqlsrv_fetch_array($exec3);

$callImg = "{call PEFINDO_GETDATA_PASANGAN_1(?)}";
$paramImg = array(array($prospect, SQLSRV_PARAM_IN));
$execImg = sqlsrv_query( $conn, $callImg, $paramImg) or die( print_r( sqlsrv_errors(), true));
$dataImg = sqlsrv_fetch_array($execImg);


$siapanih = 'Pemohon';
}else{
$call3 = "{call VBS_GET_DATA_CUSTOMER_KTP_1(?,?)}";
$param3 = array(array($id_no, SQLSRV_PARAM_IN),
				array($prospect, SQLSRV_PARAM_IN));
$options3 =  array( "Scrollable" => "buffered" );
$exec3 = sqlsrv_query( $conn, $call3, $param3, $options3) or die( print_r( sqlsrv_errors(), true));
$data3 = sqlsrv_fetch_array($exec3);

$callImg = "{call PEFINDO_GETDATA_PASANGAN_BY_ORDER_NO_1(?)}";
$paramImg = array(array($prospect, SQLSRV_PARAM_IN));
$execImg = sqlsrv_query( $conn, $callImg, $paramImg) or die( print_r( sqlsrv_errors(), true));
$dataImg = sqlsrv_fetch_array($execImg);

$siapanih = $data3['TYPE'];
$mother_nm = $data3['NAMA_IBU'];
$date1=date("Y-m-d", strtotime($data3['TTL']));
}

$callTgl = "{call SP_GET_TANGGAL_ORDER(?)}";
$paramTgl = array(array($prospect, SQLSRV_PARAM_IN));
$optionsTgl =  array( "Scrollable" => "buffered" );
$execTgl = sqlsrv_query( $conn, $callTgl, $paramTgl, $optionsTgl) or die( print_r( sqlsrv_errors(), true));
$dataTgl = sqlsrv_fetch_array($execTgl);


$NIK= $id_no;
$NAMA_LGKP= $data3['CUST_NAME'];
$ALAMAT=$data3['ALAMAT'];



IF($data3['STATUS_KAWIN'] == "SUDAH KAWIN"){
	$STATUS_KAWIN= "KAWIN";
}Else IF($data3['STATUS_KAWIN'] == "BELUM KAWIN"){
	$STATUS_KAWIN= "BELUM KAWIN";
}Else{
	$STATUS_KAWIN=$data3['STATUS_KAWIN'];
}
	
	
$TMPT_LHR= $data3['TTL'];

$TGL_LHR1= $data3['TL'];

$TGL_LHR2 = strtotime($TGL_LHR1);
$TGL_LHR =  date("d-m-Y", $TGL_LHR2);

// $TGL_LHR= "06-07-1987";
$KAB_NAME= " ";
$KEC_NAME= " ";
$KEL_NAME= " ";
$PROP_NAME= "";
$NO_RT= "";
$NO_RW= "";

$JK = $data3['JENIS_KELAMIN']; 
IF($JK == "LAKI-LAKI"){
$JENIS_KLMIN= "Laki-Laki";
}Else IF($JK == "PEREMPUAN"){
$JENIS_KLMIN= "Perempuan";
}else{
	$JENIS_KLMIN= $data3['JENIS_KELAMIN']; 
}

$JENIS_PKRJN= $data3['PEKERJAAN'];
$NAMA_LGKP_IBU= $data3['NAMA_IBU'];
$TRESHOLD= "90";
//$USER_ID= "10643174202101271dummy_suzuki_finance";
$USER_ID= "singlesuzukifinance";
//$PASSWORD= "123456";
$PASSWORD= "s3Jsm8K9";
$IP_USER= $user;


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

if(isset($_FILES['foto_status_nikah']['name'])){
	$output = prepareImageDBString($_FILES['foto_status_nikah']['tmp_name']);
	//echo $output;
	
	$user=$_GET['USERNAME'];
	$prospect=$_POST['prospect'];
	$id_no=$_POST['id_no'];
	$images = $output;
	
	
	$call = "{call SP_UPDATE_IMAGES_STATUS_NIKAH(?,?,?,?)}";
	$param = array(array($prospect, SQLSRV_PARAM_IN),
					array($id_no, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN),
					array($images, SQLSRV_PARAM_IN));

	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));

	echo"<script>window.location='index.php?USERNAME=".$user."&page=form_verifikasi_status_nikah&prospect=".$prospect."&nik=".$id_no."'</script>";
}

if(isset($_FILES['foto_kk_pasangan']['name'])){
	$output = prepareImageDBString($_FILES['foto_kk_pasangan']['tmp_name']);
	//echo $output;
	
	$user=$_GET['USERNAME'];
	$prospect=$_POST['prospect'];
	$id_no=$_POST['id_no'];
	$images = $output;
	
	
	$call = "{call SP_UPDATE_IMAGES_KK_PASANGAN(?,?,?,?)}";
	$param = array(array($prospect, SQLSRV_PARAM_IN),
					array($id_no, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN),
					array($images, SQLSRV_PARAM_IN));

	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));

	echo"<script>window.location='index.php?USERNAME=".$user."&page=form_verifikasi_status_nikah&prospect=".$prospect."&nik=".$id_no."'</script>";
}

$call2 = "{call SP_GET_IMAGES_STATUS_NIKAH(?,?)}";
$param2 = array(array($prospect, SQLSRV_PARAM_IN),
					array($id_no, SQLSRV_PARAM_IN));
$exec2 = sqlsrv_query( $conn, $call2,$param2)  or die( print_r( sqlsrv_errors(), true));
$data2 = sqlsrv_fetch_array($exec2);



$callKk = "{call SP_GET_IMAGES_KK_PASANGAN(?,?)}";
$paramKk = array(array($prospect, SQLSRV_PARAM_IN),
					array($id_no, SQLSRV_PARAM_IN));
$execKk = sqlsrv_query( $conn, $callKk,$paramKk)  or die( print_r( sqlsrv_errors(), true));
$dataKk = sqlsrv_fetch_array($execKk);


if(isset($_POST['submitDoc'])){
	
$tgl1 = $dataTgl['SUBMIT_DATE']->format("Y-m-d");
$tgl2 = $_POST['tgl_nikah'];



$callSla = "{call GET_SLA_TIME(?,?)}";
$paramSla = array(array($tgl1, SQLSRV_PARAM_IN),
				  array($tgl2, SQLSRV_PARAM_IN));

$optionsSla =  array( "Scrollable" => "buffered" );
$execSla = sqlsrv_query( $conn, $callSla, $paramSla, $optionsSla) or die( print_r( sqlsrv_errors(), true));
$dataSla = sqlsrv_fetch_array($execSla);

$sla = $dataSla['SLA_TIME'];
$sla1 = substr($sla,0,1);

	if($sla >= -730 && $sla <= 1){
		$verifikasi= "VERIEFIED";
	}
	else if($sla1 == "-"){
		$verifikasi= "NOT VERIEFIED";
	}else IF($sla <= 730){
		
		$verifikasi= "VERIEFIED";
	
	}else IF($sla >= 730){
		$verifikasi= "NOT VERIEFIED";
		
		
	}else{
		$verifikasi= "NOT VERIEFIED";
	}

	
}else{
$verifikasi= "";
$tgl2= "";
}
if(isset($_POST['submit1'])){
	$notes = $_POST['notes'];
	$verf = $_POST['verf'];
	$notfound=$_POST['notFound'];
	$tglnih = $_POST['tglnih'];
	/*if($notfound == ''){
		//pemohon 
		$call = "{call SP_INSERT_DATA_VERIFIKASI_STATUS_NIKAH(?,?,?,?,?,?,?,?)}";
		$param = array(	array($prospect, SQLSRV_PARAM_IN),
						array($id_no, SQLSRV_PARAM_IN),
						array($NAMA_LGKP, SQLSRV_PARAM_IN),
						array($STATUS_KAWIN, SQLSRV_PARAM_IN),
						array($verf, SQLSRV_PARAM_IN),
						array($notes, SQLSRV_PARAM_IN),
						array($user, SQLSRV_PARAM_IN),
						array($tglnih, SQLSRV_PARAM_IN));
		$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
	
		
		if($exec){
			//update status jadi on progress
			*/

			echo"<script>alert('Data Berhasil Disimpan');window.location='index.php?USERNAME=".$_GET['USERNAME']."'</script>";
		/*}else{
			echo"<script>alert('Data Gagal Disimpan');history.back();</script>";
		}
		
	}else{
		//pemohon 
		$call = "{call SP_INSERT_DATA_VERIFIKASI_STATUS_NIKAH(?,?,?,?,?,?,?,?)}";
		$param = array(	array($prospect, SQLSRV_PARAM_IN),
						array($id_no, SQLSRV_PARAM_IN),
						array($NAMA_LGKP, SQLSRV_PARAM_IN),
						array($STATUS_KAWIN, SQLSRV_PARAM_IN),
						array('VERIEFIED', SQLSRV_PARAM_IN),
						array($notes, SQLSRV_PARAM_IN),
						array($user, SQLSRV_PARAM_IN),
						array($tglnih, SQLSRV_PARAM_IN));
		$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
	
		
		if($exec){
			//update status jadi on progress
			

			echo"<script>alert('Data Berhasil Disimpan');window.location='index.php?USERNAME=".$_GET['USERNAME']."'</script>";
		}else{
			echo"<script>alert('Data Gagal Disimpan');history.back();</script>";
		}
		
	}
	*/
}


?>

<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script> 

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
				<div class="content">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DATA Prospek</td>
									</tr>
									<tr>
										<td style="width:50%;">Prospek No / ORDER NO </td>
										<td style="width:50%;">
											<input type="text" name="prospek_no" id="prospek_no"  value="<?php echo $prospect;?>" class="form-control" readonly onautocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Tanggal </td>
										<td style="width:50%;">
											<input type="text" name="tanggal_prospek" id="tanggal_prospek" value="<?php echo $dataTgl['SUBMIT_DATE']->format("Y-m-d");?>" readonly class="form-control" autocomplete="off">
										</td>
									</tr>
								</table>
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Customer</td>
									</tr>
									<tr>
										<td style="width:50%;">Nik </td>
										<td style="width:50%;">
											<input type="text" name="nik" id="nik" value="<?php echo $id_no;?>" readonly class="form-control" required onautocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nama </td>
										<td style="width:50%;">
											<input type="text" name="nama" id="nama" value="<?php echo $NAMA_LGKP;?>" readonly class="form-control" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Tempat Lahir</td>
										<td style="width:50%;">
											<input type="text" name="tempat_lahir" value="<?php echo $TMPT_LHR;?>" readonly id="tempat_lahir" class="form-control" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Tanggal lahir</td>
										<td style="width:50%;">
											<input type="text" name="tanggal_lahir" value="<?php echo $TGL_LHR;?>" readonly id="tanggal_lahir" class="form-control" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Alamat</td>
										<td style="width:50%;">
											<textarea name="alamat" id="alamat" value="<?php echo $ALAMAT;?>" readonly class="form-control"> </textarea>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Status</td>
										<td style="width:50%;">
											<input type="text" name="status" id="status"  value="<?php echo $STATUS_KAWIN;?>" readonly class="form-control" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Jenis Kelamin</td>
										<td style="width:50%;">
											<input type="text" name="jenis_kelamin" id="jenis_kelamin" value="<?php echo $JENIS_KLMIN;?>" readonly class="form-control" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nama Gadis Ibu kandung</td>
										<td style="width:50%;">
											<input type="text" name="gadis_ibu_kandung" id="gadis_ibu_kandung" value="<?php echo $NAMA_LGKP_IBU;?>" readonly class="form-control" autocomplete="off">
										</td>
									</tr>
								</table>								
							</div>								
						</div>
						<div class="col-md-6 col-md-12">
							<div class="table-responsive">
								<table class="table table-stripped">	
									<tr>
									<td style="width:50%;" colspan="2"> Foto Akta Nikah / Akta Cerai</td>
									</tr>
									<tr>									
										<td style="width:50%;" colspan="2">
											<?php if($data2['IMG_SRC'] <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($data2['IMG_SRC']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($data2['IMG_SRC']);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											<form action="" method="post" enctype="multipart/form-data">
												
												<div class="form-group" style="margin-top:5px;">
													<label style="color:#333;">Upload Foto</label>
													<input type="hidden" name="prospect"  value="<?php echo $prospect;?>">
													<input type="hidden" name="id_no"  value="<?php echo $id_no;?>">
													<input type="hidden" name="user"  value="<?php echo $user;?>">
													<input type="file" name="foto_status_nikah" onchange="submit()">
												</div>
											</form>											
											
										</td>
									</tr>
									
										<tr>
									<td style="width:50%;" colspan="2"> Foto KK Pasangan / Penjamin (Upload Bila Diperlukan)</td>
									</tr>
									<tr>									
										<td style="width:50%;" colspan="2">
											<?php if($dataKk['IMG_SRC'] <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($dataKk['IMG_SRC']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($dataKk['IMG_SRC']);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											<form action="" method="post" enctype="multipart/form-data">
												
												<div class="form-group" style="margin-top:5px;">
													<label style="color:#333;">Upload Foto</label>
													<input type="hidden" name="prospect"  value="<?php echo $prospect;?>">
													<input type="hidden" name="id_no"  value="<?php echo $id_no;?>">
													<input type="hidden" name="user"  value="<?php echo $user;?>">
													<input type="file" name="foto_kk_pasangan" onchange="submit()">
												</div>
											</form>											
											
										</td>
									</tr>
									
									<tr>
									<td> Foto KK</td>
									</tr>
									<tr>									
										<td style="width:50%;" colspan="2">
											<?php if($dataImg['Pemohon_FotoKK'] <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($dataImg['Pemohon_FotoKK']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($dataImg['Pemohon_FotoKK']);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
										
										</td>
									</tr>
									
									
									<form action="" method="post">	
									<tr>
										<td style="width:25%;">Tanggal Nikah </td>
										<td style="width:50%;">
										<div class="input-group date">
												<input type="text" name="tgl_nikah" class="form-control" placeholder="tgl_nikah" value="<?php echo $tgl2;?>" id="tgl_nikah"  autocomplete="off">
												<div class="input-group-addon">
													<span class="add-on"><i class="fa fa-calendar"></i></span>
												</div>
											</div>
										
										</td>
									</tr>
															
									<tr>
										<td style="width:25%;">
									
												<input type="submit" name="submitDoc" class="btn btn-custom" value="Verifikasi Doc" style="width:100%;">
										</td>
										<td>
										<?php IF($verifikasi != ""){?>
										Dokumen <?php echo $verifikasi;?>
										<?php } ?>
										</td>	
										<td>
											
										</td>
									</tr>
									</form>
									<tr>
									<form action="" method="post">
									<tr>
										<td style="width:25%;" >
											Verified Final
											<input type="checkbox" name="notFound" id="notFound"  onclick="myFunction()"> &nbsp;<b></b>
												
										</td>
										<td>
											
										</td>
									</tr>
									
									<tr>
										<td style="width:25%;">Notes </td>
										<td style="width:50%;">
											<input type="text" name="notes" id="notes" minlength="20" class="form-control" required onautocomplete="off">
												<input type="hidden" name="notFound" id="notFound2" value="">
											<input type="hidden" name="verf" id="verf" value="<?php echo $verifikasi;?>" class="form-control"  onautocomplete="off">
											<input type="hidden" name="tglnih" id="tglnih" value="<?php echo $tgl2;?>" class="form-control"  onautocomplete="off">
											
										</td>
									</tr>
									
								</table>
						</div>

					<hr>
					<div class="row">
						<div class="col-md-12">
							<center>
							
								
									
									
									<input type="submit" name="submit1" class="btn btn-custom" value="Submit" style="width:200px;">
									<a href="index.php?page=input-vendor&USERNAME=<?php echo $user;?>" class="btn btn-custom" style="width:200px;">BATAL</a>
									
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
$(document).ready(function() {
	 var ktp_pemohon = $("#ktp_pemohon").val();
	 $("#ktp_pemohon2").val(ktp_pemohon);
	 var nama_karyawan = $("#nama_karyawan").val();
	 $("#nama_karyawan2").val(nama_karyawan);
	 var tgl_pemohon = $("#tgl_pemohon").val();
	 $("#tgl_pemohon2").val(tgl_pemohon);
	 var ibu_pemohon = $("#ibu_pemohon").val();
	 $("#ibu_pemohon2").val(ibu_pemohon);
	 var status_pemohon = $("#status_pemohon").val();
	 $("#status_pemohon2").val(status_pemohon);
	 
	 var no_regist = $("#no_regist").val();
	 $("#no_regist2").val(no_regist);
	 var alamat = $("#alamat").val();
	 $("#alamat2").val(alamat);
	  var tgl_nikah = $("#tgl_nikah").val();
	 $("#tgl_nikah2").val(tgl_nikah);

});

function myFunction() {
  var checkBox = document.getElementById("notFound");
  var text = document.getElementById("notFound2");
  
  if (checkBox.checked == true){
    text.value = "1";
  } else {
     text.value = "";
  }
}
function function_ktp_pemohon(value){ document.getElementById("ktp_pemohon2").value = value;}
function function_nama_karyawan(value){ document.getElementById("nama_karyawan2").value = value;}
function function_tgl_pemohon(value){ document.getElementById("tgl_pemohon2").value = value;}
function function_ibu_pemohon(value){ document.getElementById("ibu_pemohon2").value = value;}
function function_status_pemohon(value){ document.getElementById("status_pemohon2").value = value;}

function function_no_regist(value){ document.getElementById("no_regist2").value = value;}
function function_alamat(value){ document.getElementById("alamat2").value = value;}
function function_alamat(value){ document.getElementById("tgl_nikah2").value = value;}
</script>
<script>
$( document ).ready(function() {   
	$('#tgl_nikah').datepicker({
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

