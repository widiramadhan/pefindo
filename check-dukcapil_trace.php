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
	$getUsername=$_GET['USERNAME'];
	
	if($no_ktp==""){
		echo"<script>alert('Nomor KTP tidak boleh kosong, silahkan lakukan edit data di CONFINS');history.back();</script>";
	}else if($nama==""){
		echo"<script>alert('Nama tidak boleh kosong, silahkan lakukan edit data di CONFINS');history.back();</script>";
	}else if($date==""){
		echo"<script>alert('Tanggal lahir tidak boleh kosong, silahkan lakukan edit data di CONFINS');history.back();</script>";
	}else if(substr($no_ktp,0,1) == "0"){
		echo"<script>alert('Nomor KTP tidak boleh berawalan 0');history.back();</script>";
	}else if(substr($no_ktp,-4) == "0000"){
		echo"<script>alert('4 Digit Nomor KTP tidak boleh 0000');history.back();</script>";
	}else if(strlen(trim($no_ktp)) <> 16){
		echo"<script>alert('NIK harus 16 digit');history.back();</script>";
	}else if(preg_match("/^[a-zA-Z]$/", $no_ktp)){
		echo"<script>alert('NIK tidak boleh mengandung alphabet');history.back();</script>";
	}else{
		$param_dukcapil_array= array('nik' => $no_ktp, 'user_id' => "singlesuzukifinance", 'password' => "s3Jsm8K9", 'IP_USER' => $getUsername);
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

			$callSPLogDkUpilNtValid = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
			$paramsLogDkUpilNtValid = array(array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN), array($SourceLogDkUpilNtValid, SQLSRV_PARAM_IN),array($StatusLogDkUpilNtValid, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
			$execLogDkUpilNtValid = sqlsrv_query( $conn, $callSPLogDkUpilNtValid, $paramsLogDkUpilNtValid) or die( print_r( sqlsrv_errors(), true));
			if($execLogDkUpilNtValid === false){
				echo"<script>alert('Error insert log Dukcapil Not Valid');</script>";
			}
			//----# Insert LOG End

			//echo "<script>alert('Error : ".$StatusLogDkUpilNtValid." (Pada saat pengecekan No KTP di Dukcapil.!)')</script>";
			$Warning_Data = $Warning_Data." - KTP TIDAK VALID (Pada saat pengecekan No KTP di Dukcapil.!) ";
		}else{
			if($errDkUpil){
				//----# Insert LOG
				$SourceLogDkUpil = "DUKCAPIL";
				$StatusLogDkUpil = "ERROR";

				$callSPLogDkUpil = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
				$paramsLogDkUpil = array(array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkUpil, SQLSRV_PARAM_IN),array($StatusLogDkUpil, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
				$execLogDkUpil = sqlsrv_query( $conn, $callSPLogDkUpil, $paramsLogDkUpil) or die( print_r( sqlsrv_errors(), true));
				if($execLogDkUpil === false){
					echo"<script>alert('Error insert log Dukcapil');</script>";
				}
				//----# Insert LOG End
				echo "<script>alert('Error : ".$errDkUpil." (Pada saat pengecekan No KTP di Dukcapil..!)')</script>";
			}else{
				if(isset($resultDukcapil['content'][0]['RESPON'])) {
					//----# Insert LOG
					$SourceLogDkUpilnotfound = "DUKCAPIL";
					$StatusLogDkUpilnotfound = strtoupper($resultDukcapil['content'][0]['RESPON']);

					$callSPLogDkUpilnotfound = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
					$paramsLogDkUpilnotfound = array(array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkUpilnotfound, SQLSRV_PARAM_IN),array($StatusLogDkUpilnotfound, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
					$execLogDkUpilnotfound = sqlsrv_query( $conn, $callSPLogDkUpilnotfound, $paramsLogDkUpilnotfound) or die( print_r( sqlsrv_errors(), true));
					
					if($execLogDkUpilnotfound === false){
						echo"<script>alert('NIK Tersebut Tidak ditemukan di Dukcapil.!');</script>";
					}
					//----# Insert LOG End
					
					echo "<script>alert('Error : ".$StatusLogDkUpilnotfound." (Pada saat pengecekan No KTP di Dukcapil!)')</script>";
					$Warning_Data = $Warning_Data."  ".$StatusLogDkUpilnotfound."  (Pada saat pengecekan NO KTP di Dukcapil.!) ";
					
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
					$SourceLogDkcpl = "DUKCAPIL";
					$StatusLogDkcpl = "VALID";

					$callSPLogDkcpl = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
					$paramsLogDkcpl = array(array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkcpl, SQLSRV_PARAM_IN),array($StatusLogDkcpl, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
					$execLogDkcpl = sqlsrv_query( $conn, $callSPLogDkcpl, $paramsLogDkcpl) or die( print_r( sqlsrv_errors(), true));
					//----# Insert LOG End
					
					//GET LOG ID
					$callGetLog = "{call SP_GET_LOG_ID_DUKCAPIL(?,?)}";
					$paramsGetLog = array(array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN));
					$execGetLog = sqlsrv_query( $conn, $callGetLog, $paramsGetLog) or die( print_r( sqlsrv_errors(), true));
					$dataGetLog = sqlsrv_fetch_array($execGetLog);
					$idLog = $dataGetLog['LOG_CHECK_BYSOURCE_ID'];
					
					foreach($resultDukcapil['content'] as $contentdata){
						$DkcplCustType = "PEMOHON";
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

						$namaTanpaTitikD = str_replace("."," ",$DkcplNAMA_LGKP);
						$namaTanpaKomaD = str_replace(","," ",$namaTanpaTitikD);
						$namaTanpaPetikD = str_replace("'"," ",$namaTanpaKomaD);
						$namaTanpaStripD = str_replace("-"," ",$namaTanpaPetikD); 
						$namaTanpaSpasiDoubleD = str_replace("  "," ",$namaTanpaStripD);
						$namaTanpaSpasiD = strtoupper(trim(preg_replace('/[\t|\s{2,}]/', '', $namaTanpaSpasiDoubleD)));
						//echo $namaTanpaSpasiD;
						//echo strlen($namaTanpaSpasiD);
						
						$namaTanpaTitikP = str_replace("."," ",$nama);
						$namaTanpaKomaP = str_replace(","," ",$namaTanpaTitikP);
						$namaTanpaPetikP = str_replace("'"," ",$namaTanpaKomaP);
						$namaTanpaStripP =  str_replace("-"," ",$namaTanpaPetikP);
						$namaTanpaSpasiDoubleP = str_replace("  "," ",$namaTanpaStripP);
						$namaTanpaSpasiP = strtoupper(trim(preg_replace('/[\t|\s{2,}]/', '', $namaTanpaSpasiDoubleP)));
						//echo $namaTanpaSpasiP;
						//echo strlen($namaTanpaSpasiP);
						
						if($namaTanpaSpasiD != $namaTanpaSpasiP){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('1', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
						}
						if($DkcplTGL_LHR != $date){
							$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat";
							
							$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL(?,?,?,?,?)}";
							$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('2', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
							$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
						}
						if(strtoupper($siapanih) == "PEMOHON"){
							$namaIbuTanpaTitikD = str_replace("."," ",$DkcplNAMA_LGKP_IBU);
							$namaIbuTanpaKomaD = str_replace(","," ",$namaIbuTanpaTitikD);
							$namaIbuTanpaPetikD = str_replace("'"," ",$namaIbuTanpaKomaD);
							$namaIbuTanpaStripD = str_replace("-"," ",$namaIbuTanpaPetikD); 
							$namaIbuTanpaSpasiDoubleD = str_replace("  "," ",$namaIbuTanpaStripD);
							$namaIbuTanpaSpasiD = strtoupper(trim(preg_replace('/[\t|\s{2,}]/', '', $namaIbuTanpaSpasiDoubleD)));
							//echo $namaIbuTanpaSpasiD;
							
							$namaIbuTanpaTitikP = str_replace("."," ",$mother_nm);
							$namaIbuTanpaKomaP = str_replace(","," ",$namaIbuTanpaTitikP);
							$namaIbuTanpaPetikP = str_replace("'"," ",$namaIbuTanpaKomaP);
							$namaIbuTanpaStripP = str_replace("-"," ",$namaIbuTanpaPetikP);
							$namaIbuTanpaSpasiDoubleP = str_replace("  "," ",$namaIbuTanpaStripP);
							$namaIbuTanpaSpasiP = strtoupper(trim(preg_replace('/[\t|\s{2,}]/', '', $namaIbuTanpaSpasiDoubleP)));
							//echo $namaIbuTanpaSpasiP;
							
							if($namaIbuTanpaSpasiD <> ""){
								if($namaIbuTanpaSpasiD != $namaIbuTanpaSpasiP){
									$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat";
									
									$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL(?,?,?,?,?)}";
									$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('3', SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
									$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
								}
							}
						}
						$Is_Similar = 0;
						if($Warning_Data != ""){
							$Is_Similar = 1;
						}
					}	
				}
			}
		}
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
<?php
/***** CEK DUKCAPIL *****/
$call = "{call SP_CHECK_LOG_DUKCAPIL(?,?)}";
$params = array(
				array($prospect, SQLSRV_PARAM_IN),
				array($no_ktp, SQLSRV_PARAM_IN)
			);
$options =  array( "Scrollable" => "buffered" );
$exec = sqlsrv_query($conn, $call, $params, $options) or die( print_r( sqlsrv_errors(), true)); 
$data = sqlsrv_fetch_array($exec);
$checkDukcapil=sqlsrv_num_rows($exec);
$id_log = $data['LOG_CHECK_BYSOURCE_ID'];

/***** CEK LOG ERROR *****/
$callChekLogError = "{call SP_CHECK_LOG_ERROR_DUKCAPIL(?)}";
$paramsChekLogError = array(
				array($id_log, SQLSRV_PARAM_IN)
			);
$optionsChekLogError =  array( "Scrollable" => "buffered" );
$execChekLogError = sqlsrv_query($conn, $callChekLogError, $paramsChekLogError, $optionsChekLogError) or die( print_r( sqlsrv_errors(), true)); 
$checkLogError=sqlsrv_num_rows($execChekLogError);
/***** END CEK LOG ERROR *****/
?>
<div class="row">
	<?php 
		if($checkLogError > 0){
			echo'<div class="col-md-12">
					<div class="alert alert-danger alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
						<strong>Perhatian !</strong> Silahkan lakukan pengkinian data ke dukcapil setempat
					</div>
				</div>';
		}else{
			if($Warning_Data <> ""){
				echo'<div class="col-md-12">
						<div class="alert alert-danger alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
							<strong>Perhatian !</strong>'.$Warning_Data.'
						</div>
					</div>';
			}
		}
	?>
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Disdukcapil</h4>
				<p class="category">Pengecekan Disdukcapil</p>
			</div>
			<hr>
			<div class="content">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-bordered table-striped" style="width:100%;font-size:12px;">
								<thead></thead>
								<tbody>
									<tr>
										<td colspan="3" style="color:#FFF;background-color:#035c7a;"><b>DISDUKCAPIL</td>
									</tr>
									<?php
									if($checkDukcapil > 0){
										echo"
										<tr>
											<td style='width:33%;'>Hasil Pengecekan</td>
											<td style='width:33%;'>".$data['STATUS']."</td>
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
								if($checkDukcapil > 0){
									if($checkLogError > 0){
										echo'<input type="button" class="btn btn-custom btn-xs" value="Lanjutkan" disabled>';
									}else{
										if($Warning_Data == ""){
							?>
								<form action="index.php?page=check-pefindo&USERNAME=<?php echo $user;?>" method="post">
									<input name='prospect_no' type='hidden' value='<?php echo $prospect;?>'>
									<input name='no_ktp' type='hidden' value='<?php echo $no_ktp;?>'>
									<input name='name' type='hidden' value='<?php echo $nama;?>'>
									<input name='date' type='hidden' value='<?php echo $date;?>'>
									<input name='mother_name' type='hidden' value='<?php echo $mother_nm;?>	'>
									<input name='birth_place' type='hidden' value='<?php echo $birth_place;?>'>
									<input name='tipe_cust' type='hidden' value='<?php echo $siapanih;?>'>
									<input type="submit" class="btn btn-custom btn-xs" value="Lanjutkan">
								</form>
							<?php 
										}else{ 
											echo'<input type="button" class="btn btn-custom btn-xs" value="Lanjutkan" disabled>';
										} 
									}
								}else{
									echo'<input type="button" class="btn btn-custom btn-xs" value="Lanjutkan" disabled>';
								} 
							?>
						</div>
						<div style="float:right;margin-right:10px;">
							<form action="" method="post">
								<input name='prospect_no' type='hidden' value='<?php echo $prospect;?>'>
								<input name='no_ktp' type='hidden' value='<?php echo $no_ktp;?>'>
								<input name='name' type='hidden' value='<?php echo $nama;?>'>
								<input name='date' type='hidden' value='<?php echo $date;?>'>
								<input name='mother_name' type='hidden' value='<?php echo $mother_nm;?>	'>
								<input name='birth_place' type='hidden' value='<?php echo $birth_place;?>'>
								<input name='tipe_cust' type='hidden' value='<?php echo $siapanih;?>'>
								<input type="submit" class="btn btn-custom btn-xs" value="Check Dukcapil" name="check" onclick="return confirm('Apakah anda yakin ingin mengecek data ini? Pengecekan akan dikenakan biaya dan tercatat di log')">
							</form>
						</div>
					</div>
				</div>
				<br>
			</div>
		</div>
	</div>
</div>