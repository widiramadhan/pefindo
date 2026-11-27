<?php
require_once("config/configuration.php");
$prefix = "REQDUP";

// Generate timestamp (YearMonthDay + Seconds)
$timestamp = date("Ymd") . date("s");

// Generate a random 3-digit number
$randomNumber = rand(100, 999);

// Combine everything
$uniqueCode = $prefix . $timestamp . $randomNumber;

if(isset($_POST['submit'])){
	$NIK= $_POST['no_ktp'];
    $NAMA_LGKP= $_POST['nama'];
    $ALAMAT= $_POST['alamat'];
    $STATUS_KAWIN= $_POST['status_kawin'];
    $TMPT_LHR= $_POST['tmpt_lahir'];
	$TGL_LHR1= $_POST['tgl_lahir'];
	$TGL_LHR2 = strtotime($TGL_LHR1);
	$TGL_LHR = date("d-m-Y", $TGL_LHR2);
	$JENIS_KLMIN= $_POST['jk'];
    $JENIS_PKRJN= $_POST['pekerjaan'];
	$NAMA_LGKP_IBU= $_POST['nama_ibu'];
   // $TGL_LHR= "06-07-1987";
    $KAB_NAME= " ";
    $KEC_NAME= " ";
    $KEL_NAME= " ";
    $PROP_NAME= "";
    $NO_RT= "";
    $NO_RW= "";
	$NO_KK = $_POST['no_kk'];
  
  
    $TRESHOLD= "90";
    //$USER_ID= "10643174202101271dummy_suzuki_finance";
	$USER_ID= "25082022141010SUZUKI_FINANCE4288";
    //$PASSWORD= "123456";
	$PASSWORD= "MZ33CU";
    $IP_USER= "172.16.2.5";
	
	
	$no_ktp = $_POST['no_ktp'];
	$user = $_GET['USERNAME'];
	
	
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
				$DkcplNO_KK = "";
				
	if($no_ktp==""){
		echo"<script>alert('Nomor KTP tidak boleh kosong');history.back();</script>";
	}else if($NAMA_LGKP==""){
		echo"<script>alert('Nama tidak boleh kosong');history.back();</script>";
	}else if($TGL_LHR==""){
		echo"<script>alert('Tanggal lahir tidak boleh kosong');history.back();</script>";
	}else if(substr($no_ktp,0,1) == "0"){
		echo"<script>alert('Nomor KTP tidak boleh berawalan 0');history.back();</script>";
	}else if(substr($no_ktp,-4) == "0000"){
		echo"<script>alert('4 Digit Nomor KTP tidak boleh 0000');history.back();</script>";
	}else if(strlen(trim($no_ktp)) <> 16){
		echo"<script>alert('NIK harus 16 digit');history.back();</script>";
	}else if(preg_match("/^[a-zA-Z]$/", $no_ktp)){
		echo"<script>alert('NIK tidak boleh mengandung alphabet');history.back();</script>";
	}else{
	
	
	$param_dukcapil_array= array('NO_KK'=>$NO_KK, 'NIK' => $NIK, 'NAMA_LGKP' => $NAMA_LGKP, 'ALAMAT' => $ALAMAT, 'STATUS_KAWIN' => $STATUS_KAWIN, 'TMPT_LHR' => $TMPT_LHR, 'TGL_LHR' => $TGL_LHR, 
							'KAB_NAME' => $KAB_NAME, 'KEC_NAME' => $KEC_NAME, 'KEL_NAME' => $KEL_NAME, 'PROP_NAME' => $PROP_NAME, 'NO_RT' => $NO_RT, 'JENIS_KLMIN' => $JENIS_KLMIN, 
							'JENIS_PKRJN' => $JENIS_PKRJN, 'NAMA_LGKP_IBU' => $NAMA_LGKP_IBU, 'TRESHOLD' => $TRESHOLD, 'USER_ID' => $USER_ID, 'PASSWORD' => $PASSWORD, 'IP_USER' => $IP_USER);
	$param_dukcapil = json_encode($param_dukcapil_array);
	$curlDkUpil = curl_init();
	curl_setopt_array($curlDkUpil, array(
		//CURLOPT_URL => "http://172.16.160.84:8000/dukcapil/get_json/suzuki_finance/nik_verifby_elemen",
		//CURLOPT_URL => "https://172.16.160.177:8000/dukcapil/get_json/SUZUKI_FINANCE/CALL_VERIFY_BY_ELEMEN",
		CURLOPT_URL => "http://172.16.160.186:8000/dukcapil/get_json/990040921021160/CALL_VERIFY_BY_ELEMEN",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "$param_dukcapil",
		CURLOPT_SSL_VERIFYHOST => false,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_HTTPHEADER => array(
			'Accept: application/json',
			'Content-Type: application/json',
			"Postman-Token: ae0ace2e-aa92-4d66-8d14-d67edb42fa84",
			"cache-control: no-cache"
		),
	));

	$responseDkUpil = curl_exec($curlDkUpil);
	$errDkUpil = curl_error($curlDkUpil);

	curl_close($curlDkUpil);
	$resultDukcapil = json_decode($responseDkUpil, true);
	
		//echo '<pre>' . var_export($errDkUpil,true) .'<pre>'; 
					//exit();
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'http://172.16.160.189/data_balikan/public/Api/Nik_store',
	 // CURLOPT_URL => 'http://172.16.160.189/data_balikan/public/Api/Nik_store',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS =>array('id_lembaga' => '041148', 
								'nik' => $no_ktp,
								'nama_lembaga' => 'PT. SUZUKI FINANCE INDONESIA', 
								//'param' => '[{"id_lembaga": "041148","NIK": "'.$no_ktp.'" ,"indexno": "0"},{ "id_lembaga": "041148","NO_ORDER":  "MANUAL","indexno": "1"}]'),
								'param' => '[{"NO_CIF":  "'.$uniqueCode.'"}]'),
								
	  CURLOPT_HTTPHEADER => array(
		'Authorization: Bearer nkqAt2em3pjIc9bR4xJJMNG8PT7yqVFLlu2RpfJNHHLPRNb70eZLnSf5A1cG8HcX5hrXpF4Av8A3C8YqVNxzdpuBZ4VZgvDmoAgB',
		'Cookie: adminduk_session=eyJpdiI6ImZvSkY1SG1SeXJOa01xcHpGUUhkN0E9PSIsInZhbHVlIjoidDhsbjBrbEdSQ015NE8rS29OcDRzd0YybW9CbTJacmI4ZG5UZno3XC81R2lnOTllbFBXRklSSnFhcjVOZG9zcGVYVmlqTXBrZ0ZYZjZEWHZCV0p4akxBPT0iLCJtYWMiOiI5OWNkZDMxZWM1OGI5MzU2NmE4NDhkNGM0NTQzOWZiNWMxZDM3ZWZiZGUxM2I1NTkzOTE0MTIwMzY1ZDhhY2QyIn0%3D'
	  ),
	));

	$response = curl_exec($curl);
	
	curl_close($curl);


	$response_balikan = str_replace('"',"",$response);
		
	$callSPLogDkUpilNtValid = "{call SP_INSERT_LOG_DATA_BALIKAN(?,?,?,?)}";
	$paramsLogDkUpilNtValid = array(array($uniqueCode, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN), array($response_balikan, SQLSRV_PARAM_IN),array($_GET['USERNAME'], SQLSRV_PARAM_IN));
	$execLogDkUpilNtValid = sqlsrv_query( $conn, $callSPLogDkUpilNtValid, $paramsLogDkUpilNtValid) or die( print_r( sqlsrv_errors(), true));	

			

		
	if(empty($resultDukcapil)){
		//----# Insert LOG
			$SourceLogDkUpilNtValid = "DUKCAPIL";
			$StatusLogDkUpilNtValid = "KTP TIDAK VALID";
			echo "<script>alert('Error : ".$StatusLogDkUpilNtValid." (Pada saat pengecekan NIK ke Dukcapil.!)');history.back();</script>";
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
				$DkcplNO_KK = "";
			//----# Insert LOG End

			//echo "<script>alert('Error : ".$StatusLogDkUpilNtValid." (Pada saat pengecekan No KTP di Dukcapil.!)')</script>";
			//$Warning_Data = $Warning_Data." - KTP TIDAK VALID (Pada saat pengecekan No KTP di Dukcapil.!) ";
		//----# Insert LOG End
	}else{
		if($errDkUpil){
			//----# Insert LOG
			$SourceLogDkUpil = "DUKCAPIL";
			$StatusLogDkUpil = "ERROR";

			$callSPLogDkUpil = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
			$paramsLogDkUpil = array(array($uniqueCode, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkUpil, SQLSRV_PARAM_IN),array($StatusLogDkUpil, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
			$execLogDkUpil = sqlsrv_query( $conn, $callSPLogDkUpil, $paramsLogDkUpil) or die( print_r( sqlsrv_errors(), true));
			if($execLogDkUpil === false){
				echo"<script>alert('Error insert log Dukcapil');</script>";
			}
			//----# Insert LOG End
			echo "<script>alert('Error : ".$errDkUpil." (Pada saat pengecekan No KTP di Dukcapil..!)')</script>";
		}else{
			if(isset($resultDukcapil['content'][0]['RESPONSE'])) {
				//----# Insert LOG
				$SourceLogDkUpilnotfound = "DUKCAPIL";
				$StatusLogDkUpilnotfound = strtoupper($resultDukcapil['content'][0]['RESPONSE']);

				$callSPLogDkUpilnotfound = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
				$paramsLogDkUpilnotfound = array(array($uniqueCode, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkUpilnotfound, SQLSRV_PARAM_IN),array($StatusLogDkUpilnotfound, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
				$execLogDkUpilnotfound = sqlsrv_query( $conn, $callSPLogDkUpilnotfound, $paramsLogDkUpilnotfound) or die( print_r( sqlsrv_errors(), true));
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
				$DkcplNO_KK = "";
			}else{
				//----# Insert LOG
				$SourceLogDkcpl = "DUKCAPIL";
				$StatusLogDkcpl = "VALID";

				$callSPLogDkcpl = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
				$paramsLogDkcpl = array(array($uniqueCode, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkcpl, SQLSRV_PARAM_IN),array($StatusLogDkcpl, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
				$execLogDkcpl = sqlsrv_query( $conn, $callSPLogDkcpl, $paramsLogDkcpl) or die( print_r( sqlsrv_errors(), true));
				//----# Insert LOG End
				
				$callGetLog = "{call SP_GET_LOG_ID_DUKCAPIL(?,?)}";
				$paramsGetLog = array(array($uniqueCode, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN));
				$execGetLog = sqlsrv_query( $conn, $callGetLog, $paramsGetLog) or die( print_r( sqlsrv_errors(), true));
				$dataGetLog = sqlsrv_fetch_array($execGetLog);
				$idLog = $dataGetLog['LOG_CHECK_BYSOURCE_ID'];	
				
				foreach($resultDukcapil['content'] as $contentdata){
					$DkcplNIK = $contentdata['NIK'];
					$DkcplNAMA_LGKP = $contentdata['NAMA_LGKP'];
					$DkcplJENIS_KLMIN = $contentdata['JENIS_KLMIN'];
					$DkcplTMPT_LHR = $contentdata['TMPT_LHR'];
					$DkcplTGL_LHR = $contentdata['TGL_LHR'];
					//$DkcplTGL_LHR = $contentdata['TGL_LHR'];
					$DkcplSTATUS_KAWIN = $contentdata['STATUS_KAWIN'];
					$DkcplNAMA_LGKP_IBU = $contentdata['NAMA_LGKP_IBU'];
					$DkcplJENIS_PKRJN = $contentdata['JENIS_PKRJN'];
					$DkcplALAMAT = $contentdata['ALAMAT'];
					$DkcplNO_RT = $contentdata['NO_RT'];
					$DkcplNO_RW = $contentdata['NO_RW'];
					$DkcplPROP_NAME = $contentdata['PROP_NAME'];
					$DkcplKAB_NAME = $contentdata['KAB_NAME'];
					$DkcplKEC_NAME = $contentdata['KEC_NAME'];
					$DkcplKEL_NAME = $contentdata['KEL_NAME'];
					$DkcplNO_KK = $contentdata['NO_KK'];
					
					$callLogScore = "{call SP_INSERT_LOG_SCORING_DUKCAPIL_1(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
					$paramsLogScore = array(array($idLog, SQLSRV_PARAM_IN),
											array($uniqueCode, SQLSRV_PARAM_IN),
											array($no_ktp, SQLSRV_PARAM_IN),
											array($user, SQLSRV_PARAM_IN),
											array($NIK, SQLSRV_PARAM_IN),
											array($DkcplNIK, SQLSRV_PARAM_IN),
											array($NAMA_LGKP, SQLSRV_PARAM_IN),
											array($DkcplNAMA_LGKP, SQLSRV_PARAM_IN),
											array($ALAMAT, SQLSRV_PARAM_IN),
											array($DkcplALAMAT, SQLSRV_PARAM_IN),
											array($STATUS_KAWIN, SQLSRV_PARAM_IN),
											array($DkcplSTATUS_KAWIN, SQLSRV_PARAM_IN),
											array($TMPT_LHR, SQLSRV_PARAM_IN),
											array($DkcplTMPT_LHR, SQLSRV_PARAM_IN),
											array($TGL_LHR, SQLSRV_PARAM_IN),
											array($DkcplTGL_LHR, SQLSRV_PARAM_IN),
											array($JENIS_KLMIN, SQLSRV_PARAM_IN),
											array($DkcplJENIS_KLMIN, SQLSRV_PARAM_IN),
											array($NAMA_LGKP_IBU, SQLSRV_PARAM_IN),
											array($DkcplNAMA_LGKP_IBU, SQLSRV_PARAM_IN),
											array($JENIS_PKRJN, SQLSRV_PARAM_IN),
											array($DkcplJENIS_PKRJN, SQLSRV_PARAM_IN),
											array($NO_KK, SQLSRV_PARAM_IN),
											array($DkcplNO_KK, SQLSRV_PARAM_IN),);
					$execLogScore = sqlsrv_query( $conn, $callLogScore, $paramsLogScore) or die( print_r( sqlsrv_errors(), true));
							
				}

						
			}
		}
	}

	}
}else{
	$NIK= "";
    $NAMA_LGKP= "";
    $ALAMAT= "";
    $STATUS_KAWIN="";
    $TMPT_LHR= "";
	$TGL_LHR1="";
	$TGL_LHR2 = "";
	$TGL_LHR = "";
	$JENIS_KLMIN= "";
    $JENIS_PKRJN= "";
	$NAMA_LGKP_IBU= "";
	$NO_KK =  "";
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
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Customer Identity Check - Dukcapil</h4>
				<p class="category">Pengecekan Dukcapil Manual</p>
			</div>
			<div class="content">
				<form action="" method="post">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label>NIK</label>
								<input type="text" name="no_ktp" class="form-control" placeholder="Nomor KTP" value="<?php echo $NIK;?>" oninput="processNum(this)" onkeypress="return onlyNumber(event)" maxlength="16">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Nama Lengkap</label>
								<input type="text" name="nama" id="nama" class="form-control" placeholder="NAMA_LGKP" value="<?php echo $NAMA_LGKP;?>" oninput="processLet(this)" onkeypress="return ValidateAlpha(event)" maxlength="100">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Jenis Kelamin</label>
								<select name="jk" class="form-control">
									<option value="Laki-Laki" <?php if("Laki-Laki"==$JENIS_KLMIN){ echo "selected"; }?>>Laki-Laki</option>
									<option value="Perempuan" <?php if("Perempuan"==$JENIS_KLMIN){ echo "selected"; }?>>Perempuan</option>
								</select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Tempat Lahir</label>
								<input type="text" name="tmpt_lahir" id="tmpt_lahir"class="form-control" placeholder="Tempat Lahir" value="<?php echo $TMPT_LHR;?>" oninput="processLet(this)" onkeypress="return ValidateAlpha(event)" maxlength="100">
							</div>
						</div>
						</div>
						<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label>Tanggal Lahir</label>
								<div class="input-group date">
									<input type="text" class="form-control pull-right" readonly name="tgl_lahir" id="startDate" placeholder="Date" value="<?php echo $TGL_LHR1;?>">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-md-3">
							<div class="form-group">
								<label>Status Kawin</label>
								<select name="status_kawin" class="form-control">
									<option value="KAWIN" <?php if("KAWIN"==$STATUS_KAWIN){ echo "selected"; }?>>KAWIN</option>
									<option value="BELUM KAWIN" <?php if("BELUM KAWIN"==$STATUS_KAWIN){ echo "selected"; }?>>BELUM KAWIN</option>
									<option value="CERAI HIDUP" <?php if("CERAI HIDUP"==$STATUS_KAWIN){ echo "selected"; }?>>CERAI HIDUP</option>
									<option value="CERAI MATI" <?php if("CERAI MATI"==$STATUS_KAWIN){ echo "selected"; }?>>CERAI MATI</option>
								</select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Nama Ibu Kandung</label>
								<input type="text" name="nama_ibu" id="nama_ibu"  class="form-control" placeholder="nama ibu" value="<?php echo $NAMA_LGKP_IBU;?>" oninput="processLet(this)" onkeypress="return ValidateAlpha(event)" maxlength="100"> 
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Pekerjaan</label>
								<input type="text" name="pekerjaan" id="pekerjaan" class="form-control" placeholder="pekerjaan" value="<?php echo $JENIS_PKRJN;?>" oninput="processLet(this)" onkeypress="return ValidateAlpha(event)" maxlength="100">
							</div>
						</div>
						</div>
						<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label>No KK</label>
								<input type="text" name="no_kk" class="form-control" placeholder="NO KK" value="<?php echo $NO_KK;?>" onkeypress="return onlyNumber(event)" maxlength="16">
							</div>
						</div>
						
						<div class="col-md-5">
							<div class="form-group">
								<label>Alamat</label>
								<textarea rows="4"  type="text" name="alamat" class="form-control" placeholder="alamat" ><?php echo $ALAMAT;?></textarea>
							</div>
						</div>
						
						<?php /*
						<div class="col-md-6">
							<div class="form-group">
								<label>Type</label>
								<select name="type" class="form-control">
									<option value="Pemohon">Pemohon</option>
									<option value="Pasangan">Pasangan</option>
									<option value="Penjamin">Penjamin</option>
									<option value="Pemegang Saham">Pemegang Saham</option>
								</select>
							</div>
						</div>
						*/ ?>
					</div>
					<div class="pull-right">
						<input type="submit" name="submit" class="btn btn-custom" value="CARI">
					</div>
					<div style="clear:both;"></div>
				</form>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="content">
								<div class="row">
									<div class="col-md-12">
										<h4 class="title">Response Dukcapil</h4><br>
										<div class="table-responsive">
											<?php if(isset($_POST['submit'])){ ?>
												<table class="table table-bordered table-striped" style="width:100%;font-size:12px;">
													<thead>
														<tr>
															<th style="color:#FFF;background-color:#035c7a;font-weight:bold;" colspan="2">Response Dukcapil</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>NIK</td>
															<td><?php echo $DkcplNIK;?></td>
														</tr>
														<tr>
															<td >Nama Lengkap</td>
															<td><?php echo $DkcplNAMA_LGKP;?></td>
														</tr>
														<tr>
															<td>Tempat Lahir</td>
															<td><?php echo $DkcplTMPT_LHR;?></td>
														</tr>
														<tr>
															<td>Tanggal Lahir</td>
															<td><?php echo $DkcplTGL_LHR;?></td>
														</tr>
														<tr>
															<td>Jenis Kelamin</td>
															<td><?php echo $DkcplJENIS_KLMIN;?></td>
														</tr>
														<tr>
															<td>Alamat</td>
															<td><?php echo $DkcplALAMAT;?></td>
														</tr>
															<td>Status Kawin</td>
															<td><?php echo $DkcplSTATUS_KAWIN;?></td>
														</tr>
														<tr>
															<td>Nama Ibu Kandung</td>
															<td><?php echo $DkcplNAMA_LGKP_IBU;?></td>
														</tr>
														<tr>
															<td>Pekerjaan</td>
															<td><?php echo $DkcplJENIS_PKRJN;?></td>
														</tr>
														<tr>
															<td>No KK</td>
															<td><?php echo $DkcplNO_KK;?></td>
														</tr>
														<?php /*
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
														*/?>
														
													</tbody>
												</table>
											<?php }else{ ?>
												<table class="table table-bordered table-stripped" style="width:100%;font-size:12px;">
													<thead>
														<tr>
															<th style="color:#FFF;background-color:#035c7a;font-weight:bold;">Response Dukcapil</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td style="text-align:center;">Silahkan cari data terlebih dahulu</td>
														</tr>
													</tbody>
												</table>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
function onlyNumber(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;
return true;
}

function ValidateAlpha(evt)
    {
        var keyCode = (evt.which) ? evt.which : evt.keyCode
        if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 123) && keyCode != 32 )
         
        return false;
            return true;
	}	
	$('#nama').keyup(function() {
    $(this).val($(this).val().replace(/[^\w\s]+/g, ''));
	});
    
	
	$('#tmpt_lahir').keyup(function() {
    $(this).val($(this).val().replace(/[^\w\s]+/g, ''));
	});
	$('#nama_ibu').keyup(function() {
    $(this).val($(this).val().replace(/[^\w\s]+/g, ''));
	});
	$('#pekerjaan').keyup(function() {
    $(this).val($(this).val().replace(/[^\w\s]+/g, ''));
	});
	
        function processNum(input){
  let value = input.value;
  let numbers = value.replace(/[^0-9]/g, "");
  input.value = numbers;
}
function processLet(input){
  let value = input.value;
  let letters = value.replace(/[0-9]/g, "");
  input.value = letters;
}
	
	
	
</script>
<script>
$(document).ready(function() {
$('#startDate').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange: '1930:2021',
	});
} );
</script>