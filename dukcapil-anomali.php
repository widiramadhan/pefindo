<?php
require_once("config/configuration.php");

function prepareImageDBString($filepath)
{
	$output = 'null';
	$handle = @fopen($filepath, 'rb');
	if ($handle) {
		$content = @fread($handle, filesize($filepath));
		$content = bin2hex($content);
		@fclose($handle);
		$output = "0x" . strtoupper($content);
	}
	return $output;
}
$nokon = $_GET['NOREG'];

$callKontrak = "{call SP_GET_CONTRACT_FROM_CONFINS_ANOMALI(?)}";
$paramsKontrak = array(array($nokon, SQLSRV_PARAM_IN));
$execKontrak = sqlsrv_query($conn, $callKontrak, $paramsKontrak) or die(print_r(sqlsrv_defaults(), true));
$dataKontrak = sqlsrv_fetch_array($execKontrak);

$NO_REG = $dataKontrak['NOMOR_KONTRAK'];

if (isset($_POST['submit_data'])) {
	$NO_REG = $_POST['no_reg'];
	$NIK = $_POST['no_ktp'];
	$NAMA_LGKP = $_POST['nama'];
	$ALAMAT = $_POST['alamat'];
	$STATUS_KAWIN = $_POST['status_kawin'];
	$TMPT_LHR = $_POST['tmpt_lahir'];
	$TGL_LHR1 = $_POST['tgl_lahir'];
	$TGL_LHR2 = strtotime($TGL_LHR1);
	$TGL_LHR = date("d-m-Y", $TGL_LHR2);
	$TGL_LHR_INPUT = date("Y-m-d", $TGL_LHR2);
	$JENIS_KLMIN = $_POST['jk'];
	$JENIS_PKRJN = $_POST['pekerjaan'];
	$NAMA_LGKP_IBU = $_POST['nama_ibu'];
	// $TGL_LHR= "06-07-1987";
	$KAB_NAME = " ";
	$KEC_NAME = " ";
	$KEL_NAME = " ";
	$PROP_NAME = "";
	$NO_RT = "";
	$NO_RW = "";
	$NO_KK = $_POST['no_kk'];


	$img1 = prepareImageDBString($_FILES['foto_ktp']['tmp_name']);




	$TRESHOLD = "90";
	//$USER_ID= "10643174202101271dummy_suzuki_finance";
	$USER_ID = "25082022141010SUZUKI_FINANCE4288";
	//$PASSWORD= "123456";
	$PASSWORD = "MZ33CU";
	$IP_USER = "172.16.2.5";


	$no_ktp = $_POST['no_ktp'];
	$user = $_GET['USERNAME'];



	// $param_dukcapil_array= array('NIK' => $NIK, 'NAMA_LGKP' => $NAMA_LGKP, 'ALAMAT' => $ALAMAT, 'STATUS_KAWIN' => $STATUS_KAWIN, 'TMPT_LHR' => $TMPT_LHR, 'TGL_LHR' => $TGL_LHR, 
	// 						'KAB_NAME' => $KAB_NAME, 'KEC_NAME' => $KEC_NAME, 'KEL_NAME' => $KEL_NAME, 'PROP_NAME' => $PROP_NAME, 'NO_RT' => $NO_RT, 'JENIS_KLMIN' => $JENIS_KLMIN, 
	// 						'JENIS_PKRJN' => $JENIS_PKRJN, 'NAMA_LGKP_IBU' => $NAMA_LGKP_IBU, 'TRESHOLD' => $TRESHOLD, 'USER_ID' => $USER_ID, 'PASSWORD' => $PASSWORD, 'IP_USER' => $IP_USER);
	// $param_dukcapil = json_encode($param_dukcapil_array);
	// $curlDkUpil = curl_init();
	// curl_setopt_array($curlDkUpil, array(
	// 	//CURLOPT_URL => "http://172.16.160.84:8000/dukcapil/get_json/suzuki_finance/nik_verifby_elemen",
	// 	//CURLOPT_URL => "http://172.16.160.128:8000/dukcapil/get_json/suzuki_finance/nik_verifby_elemen",
	// 	CURLOPT_URL => "http://172.16.160.186:8000/dukcapil/get_json/990040921021160/CALL_VERIFY_BY_ELEMEN",
	// 	CURLOPT_RETURNTRANSFER => true,
	// 	CURLOPT_ENCODING => "",
	// 	CURLOPT_MAXREDIRS => 10,
	// 	CURLOPT_TIMEOUT => 30,
	// 	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	// 	CURLOPT_CUSTOMREQUEST => "POST",
	// 	CURLOPT_POSTFIELDS => "$param_dukcapil",
	// 	CURLOPT_SSL_VERIFYHOST => false,
	// 	CURLOPT_SSL_VERIFYPEER => false,
	// 	CURLOPT_HTTPHEADER => array(
	// 		'Accept: application/json',
	// 		'Content-Type: application/json',
	// 		"Postman-Token: ae0ace2e-aa92-4d66-8d14-d67edb42fa84",
	// 		"cache-control: no-cache"
	// 	),
	// ));

	// $responseDkUpil = curl_exec($curlDkUpil);
	// $errDkUpil = curl_error($curlDkUpil);

	// //echo '<pre>' . var_export($errDkUpil,true) .'<pre>'; 
	// 		//exit();
	// curl_close($curlDkUpil);


	// $resultDukcapil = json_decode($responseDkUpil, true);



	// $curl = curl_init();

	// curl_setopt_array($curl, array(
	//   CURLOPT_URL => 'http://172.16.160.189/data_balikan/public/Api/Nik_store',
	//   CURLOPT_RETURNTRANSFER => true,
	//   CURLOPT_ENCODING => '',
	//   CURLOPT_MAXREDIRS => 10,
	//   CURLOPT_TIMEOUT => 0,
	//   CURLOPT_FOLLOWLOCATION => true,
	//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	//   CURLOPT_CUSTOMREQUEST => 'POST',
	//   CURLOPT_POSTFIELDS =>array('nik' => $no_ktp,
	// 							'id_lembaga' => '041148', 
	// 							'nama_lembaga' => 'PT. SUZUKI FINANCE INDONESIA', 
	// 							//'param' => '[{"id_lembaga": "041148","NIK": "'.$no_ktp.'" ,"indexno": "0"},{ "id_lembaga": "041148","NO_ORDER":  "MANUAL","indexno": "1"}]'),
	// 							'param' => '[{"NO_CIF":  "MANUAL"}]'),
	//   CURLOPT_HTTPHEADER => array(
	// 	'Authorization: Bearer nkqAt2em3pjIc9bR4xJJMNG8PT7yqVFLlu2RpfJNHHLPRNb70eZLnSf5A1cG8HcX5hrXpF4Av8A3C8YqVNxzdpuBZ4VZgvDmoAgB',
	// 	'Cookie: adminduk_session=eyJpdiI6ImZvSkY1SG1SeXJOa01xcHpGUUhkN0E9PSIsInZhbHVlIjoidDhsbjBrbEdSQ015NE8rS29OcDRzd0YybW9CbTJacmI4ZG5UZno3XC81R2lnOTllbFBXRklSSnFhcjVOZG9zcGVYVmlqTXBrZ0ZYZjZEWHZCV0p4akxBPT0iLCJtYWMiOiI5OWNkZDMxZWM1OGI5MzU2NmE4NDhkNGM0NTQzOWZiNWMxZDM3ZWZiZGUxM2I1NTkzOTE0MTIwMzY1ZDhhY2QyIn0%3D'
	//   ),
	// ));

	// $response = curl_exec($curl);

	// curl_close($curl);


	// $response_balikan = str_replace('"',"",$response);

	// $callSPLogDkUpilNtValid = "{call SP_INSERT_LOG_DATA_BALIKAN(?,?,?,?)}";
	// $paramsLogDkUpilNtValid = array(array('MANUAL', SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN), array($response_balikan, SQLSRV_PARAM_IN),array($_GET['USERNAME'], SQLSRV_PARAM_IN));
	// $execLogDkUpilNtValid = sqlsrv_query( $conn, $callSPLogDkUpilNtValid, $paramsLogDkUpilNtValid) or die( print_r( sqlsrv_defaults(), true));	





	// if(empty($resultDukcapil)){
	// 	//----# Insert LOG
	// 		$SourceLogDkUpilNtValid = "DUKCAPIL";
	// 		$StatusLogDkUpilNtValid = "KTP TIDAK VALID";
	// 		echo "<script>alert('Error : ".$StatusLogDkUpilNtValid." (Pada saat pengecekan NIK ke Dukcapil.!)');history.back();</script>";
	// 		$DkcplCustType = "";
	// 			$DkcplNIK = "";
	// 			$DkcplNAMA_LGKP = "";
	// 			$DkcplJENIS_KLMIN = "";
	// 			$DkcplTMPT_LHR =  "";
	// 			$DkcplTGL_LHR = "";
	// 			$DkcplSTATUS_KAWIN = "";
	// 			$DkcplNAMA_LGKP_IBU = "";
	// 			$DkcplJENIS_PKRJN = "";
	// 			$DkcplALAMAT = "";
	// 			$DkcplNO_RT = "";
	// 			$DkcplNO_RW = "";
	// 			$DkcplNO_PROP = "";
	// 			$DkcplPROP_NAME = "";
	// 			$DkcplNO_KAB = "";
	// 			$DkcplKAB_NAME = "";
	// 			$DkcplKEC_NAME = "";
	// 			$DkcplNO_KEL = "";
	// 			$DkcplNO_KEC = "";
	// 			$DkcplKEL_NAME = "";
	// 			$DkcplNO_KK = "";
	// 		//----# Insert LOG End

	// 		//echo "<script>alert('Error : ".$StatusLogDkUpilNtValid." (Pada saat pengecekan No KTP di Dukcapil.!)')</script>";
	// 		//$Warning_Data = $Warning_Data." - KTP TIDAK VALID (Pada saat pengecekan No KTP di Dukcapil.!) ";
	// 	//----# Insert LOG End
	// }else{
	// 	if($errDkUpil){
	// 		//----# Insert LOG
	// 		$SourceLogDkUpil = "DUKCAPIL";
	// 		$StatusLogDkUpil = "ERROR";

	// 		$callSPLogDkUpil = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
	// 		$paramsLogDkUpil = array(array('MANUAL', SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkUpil, SQLSRV_PARAM_IN),array($StatusLogDkUpil, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
	// 		$execLogDkUpil = sqlsrv_query( $conn, $callSPLogDkUpil, $paramsLogDkUpil) or die( print_r( sqlsrv_defaults(), true));
	// 		if($execLogDkUpil === false){
	// 			echo"<script>alert('Error insert log Dukcapil');</script>";
	// 		}
	// 		//----# Insert LOG End
	// 		echo "<script>alert('Error : ".$errDkUpil." (Pada saat pengecekan No KTP di Dukcapil..!)')</script>";
	// 	}else{
	// 		if(isset($resultDukcapil['content'][0]['RESPONSE'])) {
	// 			//----# Insert LOG
	// 			$SourceLogDkUpilnotfound = "DUKCAPIL";
	// 			$StatusLogDkUpilnotfound = strtoupper($resultDukcapil['content'][0]['RESPONSE']);

	// 			$callSPLogDkUpilnotfound = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
	// 			$paramsLogDkUpilnotfound = array(array('MANUAL', SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkUpilnotfound, SQLSRV_PARAM_IN),array($StatusLogDkUpilnotfound, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
	// 			$execLogDkUpilnotfound = sqlsrv_query( $conn, $callSPLogDkUpilnotfound, $paramsLogDkUpilnotfound) or die( print_r( sqlsrv_defaults(), true));
	// 			//----# Insert LOG End

	// 			echo "<script>alert('Error : ".$StatusLogDkUpilnotfound." (Pada saat pengecekan No KTP di Dukcapil!)')</script>";

	// 		}else{
	//----# Insert LOG



	// foreach($resultDukcapil['content'] as $contentdata){
	// $DkcplNIK = $contentdata['NIK'];
	// $DkcplNAMA_LGKP = $contentdata['NAMA_LGKP'];
	// $DkcplJENIS_KLMIN = $contentdata['JENIS_KLMIN'];
	// $DkcplTMPT_LHR = $contentdata['TMPT_LHR'];
	// $DkcplTGL_LHR = $contentdata['TGL_LHR'];
	// //$DkcplTGL_LHR = $contentdata['TGL_LHR'];
	// $DkcplSTATUS_KAWIN = $contentdata['STATUS_KAWIN'];
	// $DkcplNAMA_LGKP_IBU = $contentdata['NAMA_LGKP_IBU'];
	// $DkcplJENIS_PKRJN = $contentdata['JENIS_PKRJN'];
	// $DkcplALAMAT = $contentdata['ALAMAT'];
	// $DkcplNO_RT = $contentdata['NO_RT'];
	// $DkcplNO_RW = $contentdata['NO_RW'];
	// $DkcplPROP_NAME = $contentdata['PROP_NAME'];
	// $DkcplKAB_NAME = $contentdata['KAB_NAME'];
	// $DkcplKEC_NAME = $contentdata['KEC_NAME'];
	// $DkcplKEL_NAME = $contentdata['KEL_NAME'];
	// $DkcplNO_KK = $contentdata['NO_KK'];


	$callImgIns = "{call SP_INSERT_IMAGES_REQUEST(?,?,?,?,?,?,?)}";
	$paramsImgIns = array(
		array($NO_REG, SQLSRV_PARAM_IN),
		array($NO_REG, SQLSRV_PARAM_IN),
		array($no_ktp, SQLSRV_PARAM_IN),
		array('FOTO_KTP', SQLSRV_PARAM_IN),
		array('ANOMALI_SLIK', SQLSRV_PARAM_IN),
		array($user, SQLSRV_PARAM_IN),
		array($img1, SQLSRV_PARAM_IN)
	);
	$execImgIns = sqlsrv_query($conn, $callImgIns, $paramsImgIns) or die(print_r(sqlsrv_defaults(), true));

	// $callLogScore = "{call SP_INSERT_LOG_SCORING_DUKCAPIL_1(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	// $paramsLogScore = array(
	// 	array($idLog, SQLSRV_PARAM_IN),
	// 	array($NO_REG, SQLSRV_PARAM_IN),
	// 	array($no_ktp, SQLSRV_PARAM_IN),
	// 	array($user, SQLSRV_PARAM_IN),
	// 	array($NIK, SQLSRV_PARAM_IN),
	// 	array($DkcplNIK, SQLSRV_PARAM_IN),
	// 	array($NAMA_LGKP, SQLSRV_PARAM_IN),
	// 	array($DkcplNAMA_LGKP, SQLSRV_PARAM_IN),
	// 	array($ALAMAT, SQLSRV_PARAM_IN),
	// 	array($DkcplALAMAT, SQLSRV_PARAM_IN),
	// 	array($STATUS_KAWIN, SQLSRV_PARAM_IN),
	// 	array($DkcplSTATUS_KAWIN, SQLSRV_PARAM_IN),
	// 	array($TMPT_LHR, SQLSRV_PARAM_IN),
	// 	array($DkcplTMPT_LHR, SQLSRV_PARAM_IN),
	// 	array($TGL_LHR, SQLSRV_PARAM_IN),
	// 	array($DkcplTGL_LHR, SQLSRV_PARAM_IN),
	// 	array($JENIS_KLMIN, SQLSRV_PARAM_IN),
	// 	array($DkcplJENIS_KLMIN, SQLSRV_PARAM_IN),
	// 	array($NAMA_LGKP_IBU, SQLSRV_PARAM_IN),
	// 	array($DkcplNAMA_LGKP_IBU, SQLSRV_PARAM_IN),
	// 	array($JENIS_PKRJN, SQLSRV_PARAM_IN),
	// 	array($DkcplJENIS_PKRJN, SQLSRV_PARAM_IN),
	// 	array($NO_KK, SQLSRV_PARAM_IN),
	// 	array($DkcplNO_KK, SQLSRV_PARAM_IN),
	// );
	// $execLogScore = sqlsrv_query($conn, $callLogScore, $paramsLogScore) or die(print_r(sqlsrv_defaults(), true));





	$callInsAn = "{call SP_INSERT_DATA_SLIK_ANOMALI(?,?,?,?,?,?,?,?)}";
	$paramsInsAn = array(
		array($NO_REG, SQLSRV_PARAM_IN),
		array($no_ktp, SQLSRV_PARAM_IN),
		array($NAMA_LGKP, SQLSRV_PARAM_IN),
		array($STATUS_KAWIN, SQLSRV_PARAM_IN),
		array($TMPT_LHR, SQLSRV_PARAM_IN),
		array($TGL_LHR_INPUT, SQLSRV_PARAM_IN),
		array($NAMA_LGKP_IBU, SQLSRV_PARAM_IN),
		array($user, SQLSRV_PARAM_IN)
	);
	$execInsAn = sqlsrv_query($conn, $callInsAn, $paramsInsAn) or die(print_r(sqlsrv_defaults(), true));


	$callApv = "{call SP_INSERT_APPROVAL_DUKCAPIL_ANOMALI(?,?,?,?,?)}";
	$paramsApv = array(
		array($NO_REG, SQLSRV_PARAM_IN),
		array($NO_REG, SQLSRV_PARAM_IN),
		array($no_ktp, SQLSRV_PARAM_IN),
		array($NAMA_LGKP, SQLSRV_PARAM_IN),
		array($user, SQLSRV_PARAM_IN)
	);
	$execApv = sqlsrv_query($conn, $callApv, $paramsApv) or die(print_r(sqlsrv_defaults(), true));

	if ($execApv) {
		echo "<script>alert('Data Berhasil Disimpan');window.location='index.php?page=tasklist-data-anomali&USERNAME=" . $_GET['USERNAME'] . "'</script>";
	} else {
		echo "<script>alert('Data Gagal Disimpan');history.back();</script>";
	}

	// }


	// 			}
	// 		}
	// 	}
} else {
	$NIK = $dataKontrak['ID_NO'];
	$NAMA_LGKP = $dataKontrak['NAMA_LENGKAP'];
	$ALAMAT = $dataKontrak['ADDR'];
	$STATUS_KAWIN = $dataKontrak['MR_MARITAL_STAT'];
	$TMPT_LHR = $dataKontrak['BIRTH_PLACE'];
	$TGL_LHR1 = $dataKontrak['BIRTH_DT']->format('Y-m-d');
	$JENIS_KLMIN = $dataKontrak['JENIS_KELAMIN'];
	$JENIS_PKRJN = $dataKontrak['JENIS_PEKERJAAN'];
	$NAMA_LGKP_IBU = $dataKontrak['MOTHER_MAIDEN_NAME'];

	$NO_KK =  "";
}
?>

<style>
	.img-custom {
		width: 100%;
		height: 200px;
	}

	.th-custom {
		text-align: center;
		vertical-align: middle;
		background-color: #035c7a;
	}

	.td-custom {
		text-align: center;
		vertical-align: middle;
	}

	.pagination>li>a,
	.pagination>li>span {
		background-color: #FFF;
		color: #035c7a;
	}

	.pagination>li.active>a,
	.pagination>li.active>span {
		background-color: #035c7a;
		color: #FFF;
	}

	.pagination>li.active>a:hover,
	.pagination>li.active>span:hover {
		background-color: #035c7a;
		color: #FFF;
	}

	.pagination>li.focus>a,
	.pagination>li.focus>span:hover {
		background-color: #035c7a;
		color: #FFF;
	}

	.pagination>li.active>a.page-link,
	.pagination>li.active>span.page-link {
		background-color: #035c7a;
		color: #FFF;
	}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Dukcapil</h4>
				<p class="category">Pengecekan Dukcapil Data Anomali OJK</p>
			</div>
			<div class="content">
				<form enctype="multipart/form-data" action="" method="post">

					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DATA CHECK DUKCAPIL</td>
									</tr>
									<tr>
										<td style="width:50%;">Nomor Kontrak <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="no_reg" class="form-control" readonly placeholder="Nomor Kontrak" value="<?php echo $NO_REG; ?>" required id="no_reg" onkeyup="function_no_reg(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nomor KTP <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="no_ktp" onkeypress="return onlyNumber(event)" maxlength="16" class="form-control" placeholder="Nomor KTP" value="<?php echo $NIK; ?>" required id="ktp_pemohon" onkeyup="function_ktp_pemohon(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nama Lengkap <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="nama" class="form-control" placeholder="Nama" value="<?php echo $NAMA_LGKP ?>" required id="nama" onkeyup="function_nama_karyawan(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr style="display:none;">
										<td style="width:50%;">JENIS KELAMIN <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<select name="jk" class="form-control">
												<option value="Laki-Laki" <?php if ("Laki-Laki" == $JENIS_KLMIN) {
																				echo "selected";
																			} ?>>Laki-Laki</option>
												<option value="Perempuan" <?php if ("Perempuan" == $JENIS_KLMIN) {
																				echo "selected";
																			} ?>>Perempuan</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Tempat Lahir <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="tmpt_lahir" class="form-control" placeholder="Tempat Lahir" value="<?php echo $TMPT_LHR; ?>" required id="tmpt_lahir" onkeyup="function_nama_karyawan(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Tanggal Lahir <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<div class="input-group date">
												<input type="text" class="form-control pull-right" name="tgl_lahir" id="startDate" placeholder="Date" value="<?php echo $TGL_LHR1; ?>">
												<div class="input-group-addon">
													<span class="add-on"><i class="fa fa-calendar"></i></span>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">STATUS KAWIN <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<select name="status_kawin" class="form-control">
												<option value="KAWIN" <?php if ("KAWIN" == $STATUS_KAWIN) {
																			echo "selected";
																		} ?>>KAWIN</option>
												<option value="BELUM KAWIN" <?php if ("BELUM KAWIN" == $STATUS_KAWIN) {
																				echo "selected";
																			} ?>>BELUM KAWIN</option>
												<option value="CERAI HIDUP" <?php if ("CERAI HIDUP" == $STATUS_KAWIN) {
																				echo "selected";
																			} ?>>CERAI HIDUP</option>
												<option value="CERAI MATI" <?php if ("CERAI MATI" == $STATUS_KAWIN) {
																				echo "selected";
																			} ?>>CERAI MATI</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nama Ibu Kandung <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="nama_ibu" class="form-control" placeholder="nama ibu" value="<?php echo $NAMA_LGKP_IBU; ?> " required>
										</td>
									</tr>
									<tr style="display:none;">
										<td style="width:50%;">Jenis Pekerjaan <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="pekerjaan" class="form-control" placeholder="pekerjaan" value="<?php echo $JENIS_PKRJN; ?> " required>
										</td>
									</tr>
									<tr style="display:none;">
										<td style="width:50%;">Nomor Kartu Keluarga <span class="text-danger"></span></td>
										<td style="width:50%;">
											<input type="text" name="no_kk" class="form-control" placeholder="NO KK" value="<?php echo $NO_KK; ?>">
										</td>
									</tr>
									<tr style="display:none;">
										<td style="width:50%;">Alamat <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<textarea rows="4" type="text" name="alamat" class="form-control" placeholder="alamat"><?php echo $ALAMAT; ?></textarea>
										</td>
									</tr>
									<!--
                                    <tr>
										<td style="width:50%;">Tujuan Pengecekan <span class="text-danger">*</span></td>
										<td style="width:50%;">
                                        <textarea rows="4"  type="text" name="tujuan_pengecekan" class="form-control" placeholder="Tujuan Pengecekan" ><?php// echo $tujuan_pengecekan; ?></textarea>
										</td>
									</tr>
									-->

								</table>
							</div>
						</div>

						<div class="col-md-6 col-sm-6">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DOKUMEN</td>
									</tr>
									<tr>
										<td style="width:50%;">Foto KTP<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<?PHP
											$callImgDev1 = "{call SP_GET_IMAGES_REQUEST(?)}";
											$paramImgDev1 =  array(array($NO_REG, SQLSRV_PARAM_IN));
											$execImgDev1 = sqlsrv_query($conn, $callImgDev1, $paramImgDev1) or die(print_r(sqlsrv_defaults(), true));
											$dataImgDev1 = sqlsrv_fetch_array($execImgDev1);

											?>
											<?php if ($dataImgDev1 <> NULL) { ?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($dataImgDev1['IMG_SRC']); ?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($dataImgDev1['IMG_SRC']); ?>" style="height:300px;width:200px;" class="img-custom">
												</a>
											<?php } else { ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>


											<div class="form-group" style="margin-top:5px;">
												<label style="color:#333;">Ganti Foto</label>
												<input type="file" name="foto_ktp" onchange="validateFile(this)" required />
											</div>

										</td>

									</tr>

									<tr>
										<td style="width:50%;">Foto KTP Di Sistem</td>
										<td style="width:50%;">

											<a href="assets/img/default.jpg" data-lightbox="property">
												<img src="assets/img/default.jpg" width="100%" class="img-custom">
											</a>

										</td>

									</tr>


								</table>
							</div>
						</div>


						<hr>
						<div class="row">
							<div class="col-md-12">
								<center>
									<!-- <form action="" method="post">
								
									<input type="hidden" name="ktp_pemohon" id="ktp_pemohon2">
									<input type="hidden" name="nama_karyawan" id="nama_karyawan2">
									<input type="hidden" name="tgl_pemohon" id="tgl_pemohon2">
									<input type="hidden" name="nama_ibu_pemohon" id="ibu_pemohon2">
									<input type="hidden" name="status_pemohon" id="status_pemohon2">
									<input type="hidden" name="no_reg" id="no_reg2">
									<input type="hidden" name="alamat" id="alamat2"> -->

									<input type="submit" name="submit_data" id="submit_data" class="btn btn-custom" value="SIMPAN DATA" style="width:200px;">

									<!-- </form> -->
								</center>
								<br><br>
							</div>

							<div style="clear:both;"></div>
				</form>
				<hr>
			</div>
		</div>
	</div>
</div>
</div>

</div>

<script>
	document.getElementById('submit_data').addEventListener('click', function(event) {
		const confirmation = confirm(
			"Apakah anda yakin untuk melakukan cek dukcapil ?"
		);
		if (!confirmation) {
			event.preventDefault(); // Prevent form submission
		}
	});

	function validateFile(input) {
		const file = input.files[0]; // Ambil file yang dipilih
		if (file) {
			const allowedTypes = ["image/jpeg", "image/png", "image/gif"];
			if (!allowedTypes.includes(file.type)) {
				alert("Format file tidak valid! Harap unggah gambar (JPEG, PNG, GIF).");
				input.value = ""; // Reset input file
			}
		}
	}
</script>
<script>
	$(document).ready(function() {
		$('#startDate').datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			yearRange: '1950:2021',

		});
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

					$($cont).rotate({
						animateTo: value
					});
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