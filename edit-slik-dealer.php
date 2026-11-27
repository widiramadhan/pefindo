<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script> 
<?php

$req_id = $_GET['REQ_ID'];

$callImg = "{call SP_GET_IMG_SLIK_DEALER(?)}";
$paramImg = array(array($req_id, SQLSRV_PARAM_IN));
$execImg = sqlsrv_query( $conn, $callImg,$paramImg)  or die( print_r( sqlsrv_defaults(), true));
$dataImg = sqlsrv_fetch_array($execImg);

$callVdr = "{call SP_GET_DATA_SLIK_DEALER(?)}";
$paramVdr = array(array($req_id, SQLSRV_PARAM_IN));
$execVdr = sqlsrv_query( $conn, $callVdr,$paramVdr)  or die( print_r( sqlsrv_defaults(), true));
$dataVdr = sqlsrv_fetch_array($execVdr);


$nik=$dataVdr['ID_NO'];
$nama=$dataVdr['NAMA_CALON'];
$no_regist = $dataVdr['NOMOR_REGIST'];
if($dataVdr['BIRTH_DATE']<>NULL){$birth_date = $dataVdr['BIRTH_DATE']->format("d F Y");}else{$birth_date="";}	
$tempat_lahir =$dataVdr['TEMPAT_LAHIR'];
$alamat = $dataVdr['ALAMAT'];
$mother_name = $dataVdr['MOTHER_NAME'];
$status_kawin = $dataVdr['STATUS_KAWIN'];


/*
$call2 = "{call SP_GET_IMG_VENDOR_BRANCH(?)}";
$param2 = array(array($req_id, SQLSRV_PARAM_IN));
$exec2 = sqlsrv_query( $conn, $call2,$param2)  or die( print_r( sqlsrv_defaults(), true));
$data2 = sqlsrv_fetch_array($exec2);
*/
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

/*
if(isset($_FILES['foto_ktp']['name'])){
	$output = prepareImageDBString($_FILES['foto_ktp']['tmp_name']);
	//echo $output;
	
	$req_id = $_POST['req_id'];
	$images = $output;
	$type = "FOTO KTP";
	$user = $_GET['USERNAME'];
	
	$call = "{call  SP_UPDATE_IMAGES_KARYAWAN_BARU(?,?,?,?)}";
	$param = array(array($req_id, SQLSRV_PARAM_IN),
					array($images, SQLSRV_PARAM_IN),
					array($type, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_defaults(), true));

	echo"<script>window.location='index.php?USERNAME=".$user."&page=input-vendor-cabang-individual'</script>";
}

if(isset($_FILES['foto_sl']['name'])){
	$output = prepareImageDBString($_FILES['foto_sl']['tmp_name']);
	//echo $output;
	
	$req_id = $_POST['req_id'];
	$images = $output;
	$type = "FOTO PKS";
	$user = $_GET['USERNAME'];
	
	$call = "{call  SP_UPDATE_IMAGES_KARYAWAN_BARU(?,?,?,?)}";
	$param = array(array($req_id, SQLSRV_PARAM_IN),
					array($images, SQLSRV_PARAM_IN),
					array($type, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_defaults(), true));

	echo"<script>window.location='index.php?USERNAME=".$user."&page=input-vendor-cabang-individual'</script>";
}

if(isset($_FILES['foto_cc']['name'])){
	$output = prepareImageDBString($_FILES['foto_cc']['tmp_name']);
	//echo $output;
	
		$req_id = $_POST['req_id'];
	$images = $output;
	$type = "FOTO CC";
	$user = $_GET['USERNAME'];
	
	$call = "{call  SP_UPDATE_IMAGES_KARYAWAN_BARU(?,?,?,?)}";
	$param = array(array($req_id, SQLSRV_PARAM_IN),
					array($images, SQLSRV_PARAM_IN),
					array($type, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_defaults(), true));

	echo"<script>window.location='index.php?USERNAME=".$user."&page=input-vendor-cabang-individual'</script>";
}

*/
if(isset($_POST['submit'])){
	$no_perjanjian = $_POST['no_perjanjian'];
	$req_id = $_GET['REQ_ID'];
  $branch_id = $_POST['branch'];

	$ktp_pemohon=$_POST['ktp_pemohon'];
	$nama_calon=$_POST['nama_calon'];
	$tgl_pemohon=$_POST['tgl_pemohon'];
	$alamat=$_POST['alamat'];
	$nama_ibu_pemohon=$_POST['nama_ibu_pemohon'];
	$status_pemohon=$_POST['status_pemohon'];
  $tempat_lahir=$_POST['tempat_lahir'];

  $fotoKtp = prepareImageDBString($_FILES['foto_ktp']['tmp_name']);
  $fotoSL = prepareImageDBString($_FILES['foto_sl']['tmp_name']);
  $fotoCC = prepareImageDBString($_FILES['foto_cc']['tmp_name']);
  $typeFotoKtp = 'FOTO KTP';
  $typeFotoSL = 'FOTO SL';
  $typeFotoCC = 'FOTO CC';
	
	if($ktp_pemohon == ""){
		echo"<script>alert('Nomor KTP Pemohon Wajib Diisi');history.back();</script>";
	}else if($nama_calon == ""){
		echo"<script>alert('Nomor Nama Pemohon Wajib Diisi');history.back();</script>";
	}else if($tgl_pemohon == ""){
		echo"<script>alert('Nomor Tanggal Lahir Pemohon Wajib Diisi');history.back();</script>";
	}else if($nama_ibu_pemohon == ""){
		echo"<script>alert('Nomor Nama Ibu Pemohon Wajib Diisi');history.back();</script>";
	}else{
		//pemohon 

    if($fotoKtp !== 'null' ){
	$callKtp = "{call  SP_UPDATE_IMAGES_KARYAWAN_BARU(?,?,?,?)}";
	$paramKtp = array(array($req_id, SQLSRV_PARAM_IN),
					array($fotoKtp, SQLSRV_PARAM_IN),
					array($typeFotoKtp, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$execKtp = sqlsrv_query( $conn, $callKtp, $paramKtp) or die( print_r( sqlsrv_defaults(), true));
    }

    if($fotoSL !== 'null'){
	$callSL = "{call  SP_UPDATE_IMAGES_KARYAWAN_BARU(?,?,?,?)}";
	$paramSL = array(array($req_id, SQLSRV_PARAM_IN),
					array($fotoSL, SQLSRV_PARAM_IN),
					array($typeFotoSL, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
      //         				echo '<pre>' . var_export($paramSL,true) .'<pre>'; 
			// exit();  
	$execSL = sqlsrv_query( $conn, $callSL, $paramSL) or die( print_r( sqlsrv_defaults(), true));
    }


   if($fotoCC !== 'null'){
	$callCC = "{call  SP_UPDATE_IMAGES_KARYAWAN_BARU(?,?,?,?)}";
	$paramCC = array(array($req_id, SQLSRV_PARAM_IN),
					array($fotoCC, SQLSRV_PARAM_IN),
					array($typeFotoCC, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$execCC = sqlsrv_query( $conn, $callCC, $paramCC) or die( print_r( sqlsrv_defaults(), true));
   }

		$call = "{call SP_INSERT_SLIK_DEALER(?,?,?,?,?,?,?,?,?,?)}";
		$param = array(	array($req_id, SQLSRV_PARAM_IN),
						array($no_perjanjian, SQLSRV_PARAM_IN),
						array($ktp_pemohon, SQLSRV_PARAM_IN),
						array($nama_calon, SQLSRV_PARAM_IN),
            array($tempat_lahir, SQLSRV_PARAM_IN),
						array($tgl_pemohon, SQLSRV_PARAM_IN),
						array($alamat, SQLSRV_PARAM_IN),
						array($nama_ibu_pemohon, SQLSRV_PARAM_IN),
						array($status_pemohon, SQLSRV_PARAM_IN),
						array($_GET['USERNAME'], SQLSRV_PARAM_IN));
      // 				echo '<pre>' . var_export($param,true) .'<pre>'; 
			// exit();  
		$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_defaults(), true)); 
	
		
		if($exec){
			//update status jadi on progress
			

			echo"<script>alert('Data Berhasil Disimpan');window.location='index.php?USERNAME=".$user."&page=tasklist-check-slik-dealer'</script>";
		}else{
			echo"<script>alert('Data Gagal Disimpan');history.back();</script>";
		}
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

<form action="" method="post" enctype="multipart/form-data">
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
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DATA CALON KARYAWAN</td>
									</tr>
                  
									<tr>
										<td style="width:50%;">Nomor Perjanjian <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="no_perjanjian" class="form-control" placeholder="Nomor Perjanjian" value="<?php echo $no_regist;?>" required id="no_perjanjian" onkeyup="function_no_perjanjian(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nomor KTP <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="ktp_pemohon" onkeypress="return onlyNumber(event)" maxlength="16" class="form-control" placeholder="Nomor KTP" value="<?php echo $nik;?>" required id="ktp_pemohon" onkeyup="function_ktp_pemohon(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nama <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="nama_calon" class="form-control" placeholder="Nama Calon" value="<?php echo $nama;?>" required id="nama_calon" onkeyup="function_nama_calon(this.value)" autocomplete="off">
										</td>
									</tr>
                  <tr>
										<td style="width:50%;">Tempat Lahir <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir" value="<?php echo $tempat_lahir;?>" required id="tempat_lahir" onkeyup="function_tempat_lahir(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Tanggal Lahir <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<div class="input-group date">
												<input type="text" name="tgl_pemohon" class="form-control" placeholder="Tanggal Lahir" value="<?php echo $birth_date;?>" required id="tgl_pemohon" onchange="function_tgl_pemohon(this.value)" autocomplete="off">
												<div class="input-group-addon">
													<span class="add-on"><i class="fa fa-calendar"></i></span>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Alamat<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="alamat" class="form-control" placeholder="alamat" required id="alamat" value="<?php echo $alamat;?>" onkeyup="function_alamat(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nama Ibu Kandung <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="nama_ibu_pemohon" class="form-control" placeholder="Nama Ibu Kandung" required id="ibu_pemohon" value="<?php echo $mother_name;?>" onkeyup="function_ibu_pemohon(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Status Kawin <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<select class="form-control" name="status_kawin_pemohon"  id="status_pemohon" onchange="function_status_pemohon(this.value)">
												<option <?php if ($dataVdr['MARITAL_STATUS_CODE'] == "MAR" ) {echo 'selected';}?> value="MAR">KAWIN</option>
												<option <?php if ($dataVdr['MARITAL_STATUS_CODE'] == "SIN" ) {echo 'selected';}?> value="SIN">SINGLE</option>
												<option <?php if ($dataVdr['MARITAL_STATUS_CODE'] == "DIV" ) {echo 'selected';}?> value="DIV" >CERAI</option>
												<option <?php if ($dataVdr['MARITAL_STATUS_CODE'] == "WID" ) {echo 'selected';}?> value="WID" >DUDA/JANDA</option>
											</select>
										</td>
									</tr>
								</table>
							</div>								
						</div>
						
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DOKUMEN</td>
									</tr>
                  <tr>
										<td style="width:50%;">Foto KTP</td>
										<td style="width:50%;">
           
                    <a href="data:image/jpeg;base64,<?php echo base64_encode($dataImg['FOTO_KTP']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($dataImg['FOTO_KTP']);?>" width="100%" class="img-custom">
												</a>
                        
                    <a id="spoilktp1" href="#" data-lightbox="property">
                    <img id="spoilktp" src="#"  style="height:200px;width:300px;" />
                    </a>
                    <div class="form-group" style="margin-top:5px;">
                    <label style="color:#333;">Ganti Foto</label>
                    <input type="file" name="foto_ktp" id="foto_ktp"  style="margin-bottom:5px;" onchange="readURLKtp(this);" />
                    </div>	
                  </td>
									</tr>

									 <tr>
										<td style="width:50%;">Foto Surat Lamaran</td>
										<td style="width:50%;">
                    <a href="data:image/jpeg;base64,<?php echo base64_encode($dataImg['FOTO_SL']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($dataImg['FOTO_SL']);?>" width="100%" class="img-custom">
												</a>
                    <a id="spoilsl1" href="#" data-lightbox="property">
                    <img id="spoilsl" src="#"  style="height:200px;width:300px;" />
                    </a>
                    <div class="form-group" style="margin-top:5px;">
                    <label style="color:#333;">Ganti Foto</label>
                    <input type="file" name="foto_sl" id="foto_sl"  style="margin-bottom:5px;" onchange="readURLSL(this);" />
                    </div>	
                  </td>
									</tr>
								
										
                  <tr>
										<td style="width:50%;">Foto Customer Concent</td>
										<td style="width:50%;">
                    <a href="data:image/jpeg;base64,<?php echo base64_encode($dataImg['FOTO_CC']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($dataImg['FOTO_CC']);?>" width="100%" class="img-custom">
												</a>
                    <a id="spoilcc1" href="#" data-lightbox="property">
                    <img id="spoilcc" src="#"  style="height:200px;width:300px;" />
                    </a>
                    <div class="form-group" style="margin-top:5px;">
                    <label style="color:#333;">Ganti Foto</label>
                    <input type="file" name="foto_cc" id="foto_cc"  style="margin-bottom:5px;" onchange="readURLCC(this);" />
                    </div>	
                  </td>
									</tr>

                  
								</table>
							</div>
						</div>
					</div>
					
					<hr>
          
					<div class="row">
						<div class="col-md-12">
							<center>
								
									<input type="hidden" name="ktp_pemohon" id="ktp_pemohon2">
									<input type="hidden" name="nama_calon" id="nama_calon2">
									<input type="hidden" name="tgl_pemohon" id="tgl_pemohon2">
									<input type="hidden" name="nama_ibu_pemohon" id="ibu_pemohon2">
									<input type="hidden" name="status_pemohon" id="status_pemohon2">
									<input type="hidden" name="no_perjanjian" id="no_perjanjian2">
									<input type="hidden" name="alamat" id="alamat2">
                  
									<input type="hidden" name="tempat_lahir" id="tempat_lahir2">
									
									<input type="submit" name="submit" class="btn btn-custom" value="UPDATE DATA" style="width:200px;">
									<a href="index.php?page=tasklist-check-vendor&USERNAME=<?php echo $user;?>" class="btn btn-custom" style="width:200px;">BATAL</a>
									
								</form>
							</center>
							<br><br>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
  <div class="card">
				<div class="content">
					<div class="row">
						<div class="col-md-12 col-sm-12">
						<div class="table-responsive">
                           <table class="table table-bordered table-striped" id="tb_list_apv" style="font-size:10px;">
                               <thead>
                                   <tr>
                                       <th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">NO</th>
                                       <th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">APPROVAL NO</th>
                                       <th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">LEVEL</th>
                                       <th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">JABATAN</th>
                                       <th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">USERNAME</th>
                                       <th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">STATUS</th>
                                       <th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">NOTES</th>
									   <th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">TANGGAL APPROVE</th>
                                    
                                   </tr>
                               </thead> 
                               <tbody>
                                   <?php
										/*
										$callApv = "{call SP_APPROVAL_GETLIST_APV_NO_RAK(?)}";
										$paramApv =  array(array($prospect, SQLSRV_PARAM_IN));
										$execApv = sqlsrv_query( $conn, $callApv, $paramApv) or die( print_r( sqlsrv_defaults(), true));
										$dataApv= sqlsrv_fetch_array($execApv);
										*/
                                       $no=0;
                                       $callLoa = "{call  SP_APPROVAL_GETLIST_LOA_SLIK_DEALER(?)}";
                                       $paramLoa = array(array($req_id, SQLSRV_PARAM_IN));
                                       $execLoa = sqlsrv_query( $conn, $callLoa, $paramLoa) or die( print_r( sqlsrv_defaults(), true)); 
                                       while($dataLoa = sqlsrv_fetch_array($execLoa)){
                                           $no++;
                                   ?> 
                                   <tr>
                                       
                                       <td class="td-center"><?php echo $no;?></td>
                                       <td class="td-center"><?php echo $dataLoa['APV_NO']?></td>
                                       <td class="td-center"><?php echo $dataLoa['LEVEL']?></td>
                                       <td class="td-center"><?php echo $dataLoa['ROLE_CODE']?></td>
                                       <td class="td-center"><?php echo $dataLoa['USERNAME']?></td>
                                       <td class="td-center"><?php echo $dataLoa['STATUS']?></td>
                                       <td class="td-center"><?php echo $dataLoa['NOTES'];?></td>
									   <td class="td-center"><?php if($dataLoa['UPDATE_DATE']<>NULL){echo $dataLoa['UPDATE_DATE']->format('Y-m-d H:i:s');}else{echo"-";}?></td>
									   
									   
                                        
                                   </tr>
                                   <?php
                                       }
                                   ?>
                               </tbody>
							   
                           </table>
						 
					
						</div>
</DIV>
</DIV>						
</DIV>	
</DIV>	
<!--</form>-->
<script src="assets/js/jqueryrotate.min.js"></script>
<script>
$(document).ready(function() {
	 var ktp_pemohon = $("#ktp_pemohon").val();
	 $("#ktp_pemohon2").val(ktp_pemohon);
	 var nama_calon = $("#nama_calon").val();
	 $("#nama_calon2").val(nama_calon);
	 var tgl_pemohon = $("#tgl_pemohon").val();
	 $("#tgl_pemohon2").val(tgl_pemohon);
	 var ibu_pemohon = $("#ibu_pemohon").val();
	 $("#ibu_pemohon2").val(ibu_pemohon);
	 var status_pemohon = $("#status_pemohon").val();
	 $("#status_pemohon2").val(status_pemohon);
	 
	 var no_perjanjian = $("#no_perjanjian").val();
	 $("#no_perjanjian2").val(no_perjanjian);
	 var alamat = $("#alamat").val();
	 $("#alamat2").val(alamat);
   
	 var tempat_lahir = $("#tempat_lahir").val();
	 $("#tempat_lahir2").val(tempat_lahir);
tempat_lahir
});


function function_ktp_pemohon(value){ document.getElementById("ktp_pemohon2").value = value;}
function function_nama_calon(value){ document.getElementById("nama_calon2").value = value;}
function function_tgl_pemohon(value){ document.getElementById("tgl_pemohon2").value = value;}
function function_ibu_pemohon(value){ document.getElementById("ibu_pemohon2").value = value;}
function function_status_pemohon(value){ document.getElementById("status_pemohon2").value = value;}

function function_no_perjanjian(value){ document.getElementById("no_perjanjian2").value = value;}
function function_alamat(value){ document.getElementById("alamat2").value = value;}

function function_tempat_lahir(value){ document.getElementById("tempat_lahir2").value = value;}

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
<script type="text/javascript">
    function readURLKtp(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
              $('#spoilktp').attr('src', e.target.result);
                
                $('#spoilktp1').attr('href', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    function readURLSL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
              $('#spoilsl').attr('src', e.target.result);
                
                $('#spoilsl1').attr('href', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    function readURLCC(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#spoilcc').attr('src', e.target.result);
                
                $('#spoilcc1').attr('href', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
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

