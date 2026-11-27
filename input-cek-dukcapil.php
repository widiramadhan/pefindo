<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script> 
<?php

// $callGet = "{call SP_GET_REQ_ID_GENERATE_VENDOR_BRANCH(?)}";
// $paramGet = array(array('DEALER', SQLSRV_PARAM_IN));
// $execGet = sqlsrv_query( $conn, $callGet,$paramGet) or die( print_r( sqlsrv_defaults(), true)); 
// $dataGet = sqlsrv_fetch_array($execGet);

$reqIdExist = 1;

while($reqIdExist == 1){
  $number = '';
  for ($i = 0; $i < 10; $i++) {
      $number .= mt_rand(0, 9);
  }
  $reqId = 'REQ_CEK_D_' . $number;
  // $reqId = 'REQ_CEK_D_' . str_pad(mt_rand(0, 9999999999), 10, '0', STR_PAD_LEFT);

  $callCheckDukcapilStaging = "{call SP_CHECK_DUKCAPIL_STAGING (?)}";
  $paramCheckDukcapilStaging =  array(array($reqId, SQLSRV_PARAM_IN));
  $execCheckDukcapilStaging = sqlsrv_query($conn, $callCheckDukcapilStaging, $paramCheckDukcapilStaging) or die(print_r(sqlsrv_defaults(), true));
  $dataCheckDukcapilStaging = sqlsrv_fetch_array($execCheckDukcapilStaging);

  if ($dataCheckDukcapilStaging == false) {
    $reqIdExist = 0;
  }
}

$error="";
$req_id = $reqId;
$date = date("Y-m-d");
$uploadDir = 'pdf_upload';

/*
$call2 = "{call SP_GET_IMG_VENDOR_BRANCH(?)}";
$param2 = array(array($req_id, SQLSRV_PARAM_IN));
$exec2 = sqlsrv_query( $conn, $call2,$param2)  or die( print_r( sqlsrv_errors(), true));
$data2 = sqlsrv_fetch_array($exec2);
*/
// function prepareImageDBString($filepath){
// 	$output = 'null';
// 	$handle = @fopen($filepath, 'rb');  
// 	if ($handle){
// 		$content = @fread($handle, filesize($filepath));
// 		$content = bin2hex($content);
// 		@fclose($handle);
// 		$output = "0x".strtoupper($content);
// 	}
// 	return $output;
// }

function prepareImageDBString($filepath) {
    if (!is_readable($filepath)) {
        return null;
    }

    $handle = fopen($filepath, 'rb');
    if (!$handle) {
        return null;
    }

    $hex = '';
    while (!feof($handle)) {
        $hex .= bin2hex(fread($handle, 8192));
    }

    fclose($handle);
    return '0x' . strtoupper($hex);
}

// Define a function to check allowed file types
function isAllowedFile($fileName) {
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf']; // Define allowed file types
    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    return in_array($extension, $allowedExtensions);
}

function generateRandomName($length = 12) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomName = '';
    for ($i = 0; $i < $length; $i++) {
        $randomName .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    return $randomName;
}


// Define the getFileArr function
function getFileArr($fileInfo = '') {
    $result = [
        'fileName' => null,
        'fileDir' => null,
        'ranName' => null,
        'savedName' => null,
		  'extension' => null, // Add an extension field
    ];

    if (isset($_FILES[$fileInfo]) && $_FILES[$fileInfo]['name'] !== "" && isAllowedFile($_FILES[$fileInfo]['name'])) {
        $result['fileName'] = $_FILES[$fileInfo]['name'];
        $result['fileDir'] = $_FILES[$fileInfo]['tmp_name'];
        $result['ranName'] = explode(".", $result['fileName']); // Get the name part without extension
		$result['extension'] = strtolower(pathinfo($result['fileName'], PATHINFO_EXTENSION)); // Get file extension
        $result['savedName'] = round(microtime(true)) . '.' . end($result['ranName']); // Generate unique name
    }

    return $result;
}


	

/*
if(isset($_FILES['foto_ktp']['name'])){
	$output = prepareImageDBString($_FILES['foto_ktp']['tmp_name']);
	//echo $output;
	
	$req_id = $_POST['req_id'];
	$images = $output;
	$type = "FOTO KTP";
	$user = $_GET['USERNAME'];
	
	$call = "{call  SP_UPDATE_IMAGES_DUKCAPIL_STAGING(?,?,?,?)}";
	$param = array(array($req_id, SQLSRV_PARAM_IN),
					array($images, SQLSRV_PARAM_IN),
					array($type, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));

	echo"<script>window.location='index.php?USERNAME=".$user."&page=input-vendor-cabang-individual'</script>";
}

if(isset($_FILES['foto_sl']['name'])){
	$output = prepareImageDBString($_FILES['foto_sl']['tmp_name']);
	//echo $output;
	
	$req_id = $_POST['req_id'];
	$images = $output;
	$type = "FOTO PKS";
	$user = $_GET['USERNAME'];
	
	$call = "{call  SP_UPDATE_IMAGES_DUKCAPIL_STAGING(?,?,?,?)}";
	$param = array(array($req_id, SQLSRV_PARAM_IN),
					array($images, SQLSRV_PARAM_IN),
					array($type, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));

	echo"<script>window.location='index.php?USERNAME=".$user."&page=input-vendor-cabang-individual'</script>";
}

if(isset($_FILES['foto_cc']['name'])){
	$output = prepareImageDBString($_FILES['foto_cc']['tmp_name']);
	//echo $output;
	
		$req_id = $_POST['req_id'];
	$images = $output;
	$type = "FOTO CC";
	$user = $_GET['USERNAME'];
	
	$call = "{call  SP_UPDATE_IMAGES_DUKCAPIL_STAGING(?,?,?,?)}";
	$param = array(array($req_id, SQLSRV_PARAM_IN),
					array($images, SQLSRV_PARAM_IN),
					array($type, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));

	echo"<script>window.location='index.php?USERNAME=".$user."&page=input-vendor-cabang-individual'</script>";
}

*/
if(isset($_POST['submit'])){
	// $no_regist = $_POST['no_regist'];
	$req_id = $reqId;

  $callRegNumber = "{call SP_GET_REG_NUMBER_DUKCAPIL_STAGING(?)}";
	$paramRegNumber = array(array($user, SQLSRV_PARAM_IN));
	$execRegNumber = sqlsrv_query( $conn, $callRegNumber, $paramRegNumber) or die( print_r( sqlsrv_errors(), true));
  $dataRegNumber = sqlsrv_fetch_array($execRegNumber);

  $reg_no = 'DKCPL_'.$dataRegNumber['BranchID'].'_'.$dataRegNumber['YearMonth'].$dataRegNumber['OrderNumber'];

	$ktp_pemohon=$_POST['ktp_pemohon'];
  $kk_pemohon=$_POST['kk_pemohon'];
	$nama_calon=$_POST['nama_calon'];
	$tgl_pemohon=$_POST['tgl_pemohon'];
	$alamat=$_POST['alamat'];
	$nama_ibu_pemohon=$_POST['nama_ibu_pemohon'];
	$status_pemohon=$_POST['status_pemohon'];
  $tujuan=$_POST['tujuan'];
  $tempat_lahir=$_POST['tempat_lahir'];

  $fotoKtp = prepareImageDBString($_FILES['foto_ktp']['tmp_name']);
  $fotoDT = prepareImageDBString($_FILES['foto_dt']['tmp_name']);
  $fotoKK = prepareImageDBString($_FILES['foto_kk']['tmp_name']);
  $typeFotoKtp = 'FOTO KTP';
  $typeFotoDT = 'FOTO DT';
  $typeFotoKK = 'FOTO KK';
  $uploadDir = 'pdf_upload/';
 
	$strlenKTP = mb_strlen(trim($ktp_pemohon), 'UTF-8');
  $strlenKK = mb_strlen(trim($kk_pemohon), 'UTF-8');
	
	if($ktp_pemohon == ""){
		echo"<script>alert('Nomor KTP Pemohon Wajib Diisi');history.back();</script>";
	}else if($strlenKTP != 16){
		echo"<script>alert('Nomor KTP Pemohon Harus 16 digit');history.back();</script>";
	}else if($kk_pemohon != '' && $strlenKK != 16){
		echo"<script>alert('Nomor KK Pemohon Harus 16 digit');history.back();</script>";
	} else if (substr($ktp_pemohon, 0, 1) == "0") {
		echo "<script>alert('Nomor KTP tidak boleh berawalan 0');history.back();</script>";
	} else if (substr($ktp_pemohon, -4) == "0000") {
		echo "<script>alert('4 Digit Nomor KTP tidak boleh 0000');history.back();</script>";
	}else if($nama_calon == ""){
		echo"<script>alert('Nama Pemohon Wajib Diisi');history.back();</script>";
	}else if($tgl_pemohon == ""){
		echo"<script>alert('Tanggal Lahir Pemohon Wajib Diisi');history.back();</script>";
	}else if($nama_ibu_pemohon == ""){
		echo"<script>alert('Nama Ibu Pemohon Wajib Diisi');history.back();</script>";
	}else{
		//pemohon 
	
	$fileInfo = getFileArr('foto_ktp');
	
	 if($fileInfo['fileName']) {
	  $randomName = generateRandomName();
	  $filePathKtp = $uploadDir . $randomName.'.'.$fileInfo['extension'];
	  if($fileInfo['extension'] == 'pdf'){
		  
	  // move_uploaded_file($fileInfo['fileDir'], $filePathKtp);
	  
	  $callKtp = "{call SP_UPDATE_IMAGES_PDF_DUKCAPIL_STAGING(?,?,?,?,?,?)}";
	$paramKtp = array(array($req_id, SQLSRV_PARAM_IN),
					array($typeFotoKtp, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN),
					array($fileInfo['extension'], SQLSRV_PARAM_IN),
					array($randomName, SQLSRV_PARAM_IN),
          array($fotoKtp, SQLSRV_PARAM_IN));
	$execKtp = sqlsrv_query( $conn, $callKtp, $paramKtp) or die( print_r( sqlsrv_errors(), true));
	    
		  
	  }else{
	  
	$callKtp = "{call  SP_UPDATE_IMAGES_DUKCAPIL_STAGING(?,?,?,?)}";
	$paramKtp = array(array($req_id, SQLSRV_PARAM_IN),
					array($fotoKtp, SQLSRV_PARAM_IN),
					array($typeFotoKtp, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$execKtp = sqlsrv_query( $conn, $callKtp, $paramKtp) or die( print_r( sqlsrv_errors(), true));
	  }
	}
   
   
	$fileInfo2 = getFileArr('foto_dt');
	$randomName2 = generateRandomName();
	 if($fileInfo2['fileName']) {

	  $filePathDT = $uploadDir . $randomName2.'.'.$fileInfo2['extension'];;
	  if($fileInfo2['extension'] == 'pdf'){
		  
	  // move_uploaded_file($fileInfo2['fileDir'], $filePathDT);
	  
	  $callDT = "{call SP_UPDATE_IMAGES_PDF_DUKCAPIL_STAGING(?,?,?,?,?,?)}";
	$paramDT = array(array($req_id, SQLSRV_PARAM_IN),
					array($typeFotoDT, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN),
					array($fileInfo2['extension'], SQLSRV_PARAM_IN),
					array($randomName2, SQLSRV_PARAM_IN),
          array($fotoDT, SQLSRV_PARAM_IN));
	$execDT = sqlsrv_query( $conn, $callDT, $paramDT) or die( print_r( sqlsrv_errors(), true));
	  
	 
	  }else{
	  
   
	
   
	$callDT = "{call  SP_UPDATE_IMAGES_DUKCAPIL_STAGING(?,?,?,?)}";
	$paramDT = array(array($req_id, SQLSRV_PARAM_IN),
					array($fotoDT, SQLSRV_PARAM_IN),
					array($typeFotoDT, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$execDT = sqlsrv_query( $conn, $callDT, $paramDT) or die( print_r( sqlsrv_errors(), true));
	
	  }
	}
		$fileInfo3 = getFileArr('foto_kk');
		$randomName3 = generateRandomName();
	 if($fileInfo3['fileName']) {

	  $filePathKK = $uploadDir . $randomName3.'.'.$fileInfo3['extension'];;
	  if($fileInfo3['extension'] == 'pdf'){
		  
	  // move_uploaded_file($fileInfo3['fileDir'], $filePathKK);
	  
	  $callKK = "{call SP_UPDATE_IMAGES_PDF_DUKCAPIL_STAGING(?,?,?,?,?,?)}";
	$paramKK = array(array($req_id, SQLSRV_PARAM_IN),
					array($typeFotoKK, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN),
					array($fileInfo3['extension'], SQLSRV_PARAM_IN),
					array($randomName3, SQLSRV_PARAM_IN),
          array($fotoKK, SQLSRV_PARAM_IN));
	$exeKKC = sqlsrv_query( $conn, $callKK, $paramKK) or die( print_r( sqlsrv_errors(), true));
	  
		  
	  }else{
	  
	
	$callKK = "{call  SP_UPDATE_IMAGES_DUKCAPIL_STAGING(?,?,?,?)}";
	$paramKK = array(array($req_id, SQLSRV_PARAM_IN),
					array($fotoKK, SQLSRV_PARAM_IN),
					array($typeFotoKK, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$execKK = sqlsrv_query( $conn, $callKK, $paramKK) or die( print_r( sqlsrv_errors(), true));
	
	  }
	}

  $callGetNextApproval = "{call SP_CHECK_NEXT_APPROVAL_BM_USER (?)}";
  $paramGetNextApproval =  array(array($_GET['USERNAME'], SQLSRV_PARAM_IN));
  $execGetNextApproval = sqlsrv_query($conn, $callGetNextApproval, $paramGetNextApproval) or die(print_r(sqlsrv_defaults(), true));
  $dataGetNextApproval = sqlsrv_fetch_array($execGetNextApproval);
	
	 
		$call = "{call SP_INSERT_DUKCAPIL_STAGING_DATA(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
		$param = array(	array($req_id, SQLSRV_PARAM_IN),
						array($reg_no, SQLSRV_PARAM_IN),
						array($ktp_pemohon, SQLSRV_PARAM_IN),
            array($kk_pemohon, SQLSRV_PARAM_IN),
						array($nama_calon, SQLSRV_PARAM_IN),
            array($tempat_lahir, SQLSRV_PARAM_IN),
						array($tgl_pemohon, SQLSRV_PARAM_IN),
						array($alamat, SQLSRV_PARAM_IN),
						array($nama_ibu_pemohon, SQLSRV_PARAM_IN),
						array($status_pemohon, SQLSRV_PARAM_IN),
            array($tujuan, SQLSRV_PARAM_IN),
						array($_GET['USERNAME'], SQLSRV_PARAM_IN),
            array($dataGetNextApproval['USERNAME'], SQLSRV_PARAM_IN),
            array($dataGetNextApproval['BRANCH'], SQLSRV_PARAM_IN),
            array($dataGetNextApproval['OFFICE_NAME'], SQLSRV_PARAM_IN));
		$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
	
		if($exec){
			//update status jadi on progress
			

			echo"<script>alert('Data Berhasil Disimpan');window.location='index.php?USERNAME=".$user."&page=input-cek-dukcapil'</script>";
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

<form action="" method="post" enctype="multipart/form-data" onsubmit="return submitValidation()">
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
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DATA PENGECEKAN DUKCAPIL</td>
									</tr>
          
									<!-- <tr>
										<td style="width:50%;">Nomor Register <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="no_regist" class="form-control" placeholder="Nomor Perjanjian" value="" required id="no_regist" onkeyup="function_no_regist(this.value)" autocomplete="off">
										</td>
									</tr> -->
									<tr>
										<td style="width:50%;">Nomor Identitas (KTP) <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="ktp_pemohon" onkeypress="return onlyNumber(event)" maxlength="16" class="form-control" placeholder="Nomor KTP" value="" required id="ktp_pemohon" onkeyup="function_ktp_pemohon(this.value)" autocomplete="off">
										</td>
									</tr>
                  <tr>
										<td style="width:50%;">Nomor Kartu Keluarga</td>
										<td style="width:50%;">
											<input type="text" name="kk_pemohon" onkeypress="return onlyNumber(event)" maxlength="16" class="form-control" placeholder="Nomor KK" value="" id="kk_pemohon" onkeyup="function_kk_pemohon(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nama <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="nama_calon" class="form-control" placeholder="Nama Calon" value="" required id="nama_calon" onkeyup="function_nama_calon(this.value)" autocomplete="off">
										</td>
									</tr>
                  <tr>
										<td style="width:50%;">Tempat Lahir <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir" value="" required id="tempat_lahir" onkeyup="function_tempat_lahir(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Tanggal Lahir <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<div class="input-group date">
												<input type="text" name="tgl_pemohon" class="form-control" placeholder="Tanggal Lahir" value="" required id="tgl_pemohon" onchange="function_tgl_pemohon(this.value)" autocomplete="off">
												<div class="input-group-addon">
													<span class="add-on"><i class="fa fa-calendar"></i></span>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Alamat<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="alamat" class="form-control" placeholder="alamat" required id="alamat" value="" onkeyup="function_alamat(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nama Ibu Kandung <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="nama_ibu_pemohon" class="form-control" placeholder="Nama Ibu Kandung" required id="ibu_pemohon" value="" onkeyup="function_ibu_pemohon(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Status Kawin <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<select class="form-control" name="status_kawin_pemohon"  id="status_pemohon" onchange="function_status_pemohon(this.value)">
												<option value="KAWIN" >KAWIN</option>
                        <option value="BELUM KAWIN" >BELUM KAWIN</option>
                        <option value="CERAI HIDUP" >CERAI HIDUP</option>
                        <option value="CERAI MATI" >CERAI MATI</option>
											</select>
										</td>
									</tr>
                  <tr>
										<td style="width:50%;">Tujuan Pengecekan Dukcapil <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<select class="form-control" name="tujuan"  id="tujuan" onchange="function_tujuan(this.value)">
                        <?php
                        $callTujuan = "{call SP_GET_DUKCAPIL_STAGING_TUJUAN_PENGECEKAN()}";
                        $paramTujuan = array();
                        $execTujuan = sqlsrv_query( $conn, $callTujuan,$paramTujuan) or die( print_r( sqlsrv_defaults(), true)); 
                        // $dataTujuan = sqlsrv_fetch_array($execTujuan);
                        // var_dump($dataTujuan);
                        //   die();
                        while ($data = sqlsrv_fetch_array($execTujuan, SQLSRV_FETCH_ASSOC)) {
                          
                        ?>
												  <option value="<?= $data['DUKCAPIL_STAGING_TUJUAN_PENGECEKAN_ID']?>" ><?= $data['DESCRIPTION']?></option>
                        <?php
                        }
                        ?>
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
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DOKUMEN PELAPOR</td>
									</tr>
                  <tr>
										<td style="width:50%;">Upload KTP</td>
										<td style="width:50%;">
                    <a id="spoilktp1" href="#" data-lightbox="property">
                    <img id="spoilktp" src="#"  style="height:200px;width:300px;" />
                    </a>
                    <div class="form-group" style="margin-top:5px;">
                    <label style="color:#333;">Ganti Foto</label>
                    <input type="file" name="foto_ktp" id="foto_ktp" required style="margin-bottom:5px;" onchange="readURLKtp(this);" />
                    </div>	
                  </td>
								  		
                  <tr>
										<td style="width:50%;">Upload Kartu Keluarga</td>
										<td style="width:50%;">
                    <a id="spoilkk1" href="#" data-lightbox="property">
                    <img id="spoilkk" src="#"  style="height:200px;width:300px;" />
                    </a>  
                    <div class="form-group" style="margin-top:5px;">
                    <label style="color:#333;">Ganti Foto</label>
                    <input type="file" name="foto_kk" id="foto_kk" style="margin-bottom:5px;" onchange="readURLKK(this);" />
                    </div>	
                  </td>
									</tr>
										
                  <tr>
										<td style="width:50%;">Upload Dokumen Tambahan</td>
										<td style="width:50%;">
                    <a id="spoildt1" href="#" data-lightbox="property">
                    <img id="spoildt" src="#"  style="height:200px;width:300px;" />
                    </a>
                    <div class="form-group" style="margin-top:5px;">
                    <label style="color:#333;">Ganti Foto</label>
                    <input type="file" name="foto_dt" id="foto_dt" style="margin-bottom:5px;" onchange="readURLDT(this);" />
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
                  <input type="hidden" name="kk_pemohon" id="kk_pemohon2">
									<input type="hidden" name="nama_calon" id="nama_calon2">
									<input type="hidden" name="tgl_pemohon" id="tgl_pemohon2">
									<input type="hidden" name="nama_ibu_pemohon" id="ibu_pemohon2">
									<input type="hidden" name="status_pemohon" id="status_pemohon2">
									<!-- <input type="hidden" name="no_regist" id="no_regist2"> -->
									<input type="hidden" name="alamat" id="alamat2">
                  <input type="hidden" name="tujuan" id="tujuan2">
                  
									<input type="hidden" name="tempat_lahir" id="tempat_lahir2">
									
									<?php echo $error;?>
									<input type="submit" name="submit" class="btn btn-custom" value="SIMPAN DATA" style="width:200px;">
									<a href="index.php?page=input-cek-dukcapil&USERNAME=<?php echo $user;?>" class="btn btn-custom" style="width:200px;">BATAL</a>
									
								</form>
							</center>
							<br><br>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- </form> -->
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
   var tujuan = $("#tujuan").val();
	 $("#tujuan2").val(tujuan);
	 
	//  var no_regist = $("#no_regist").val();
	//  $("#no_regist2").val(no_regist);
	 var alamat = $("#alamat").val();
	 $("#alamat2").val(alamat);
   
	 var tempat_lahir = $("#tempat_lahir").val();
	 $("#tempat_lahir2").val(tempat_lahir);
tempat_lahir
});


function function_ktp_pemohon(value){ document.getElementById("ktp_pemohon2").value = value;}
function function_kk_pemohon(value){ document.getElementById("kk_pemohon2").value = value;}
function function_nama_calon(value){ document.getElementById("nama_calon2").value = value;}
function function_tgl_pemohon(value){ document.getElementById("tgl_pemohon2").value = value;}
function function_ibu_pemohon(value){ document.getElementById("ibu_pemohon2").value = value;}
function function_status_pemohon(value){ document.getElementById("status_pemohon2").value = value;}
function function_tujuan(value){ document.getElementById("tujuan2").value = value;}

// function function_no_regist(value){ document.getElementById("no_regist2").value = value;}
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
    function readURLDT(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#spoildt').attr('src', e.target.result);
                
                $('#spoildt1').attr('href', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
	    function readURLKK(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#spoilkk').attr('src', e.target.result);
                
                $('#spoilkk1').attr('href', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<script>
function submitValidation() {
    var inputKtp = document.getElementById('ktp_pemohon').value.trim();
    var inputKk = document.getElementById('kk_pemohon').value.trim();

    if (inputKtp.length != 16) {
        alert('Nomor KTP Pemohon Harus 16 digit');
        return false;
    }
    if (inputKtp.substr(0, 1) == '0') {
        alert('Nomor KTP tidak boleh berawalan 0');
        return false;
    }
    if (inputKtp.substr(-4) == '0000') {
        alert('4 Digit Nomor KTP tidak boleh 0000');
        return false;
    }
    if (inputKk != '' && inputKk.length != 16) {
        alert('Nomor KK Pemohon Harus 16 digit');
        return false;
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

