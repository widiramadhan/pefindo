<?php
require_once("config/configuration.php");
require_once("config/connection.php");

$getUsername=$_GET['USERNAME'];
$req_id = $_GET['request_id'];

if(isset($_POST['submit'])){
	$assignment_id = $_POST['assignment_id'];
	$order_no = $_POST['order_no'];
	$status = $_POST['status'];
	$notes = $_POST['notes'];
	
	$call = "{call SP_INSERT_RESPONSE_REQUEST_MH(?,?,?,?,?,?)}";
	$param = array(array($assignment_id, SQLSRV_PARAM_IN),array($req_id, SQLSRV_PARAM_IN),array($order_no, SQLSRV_PARAM_IN),array($status, SQLSRV_PARAM_IN),array($notes, SQLSRV_PARAM_IN),array($getUsername, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_defaults(), true)); 
	
	//update status jadi finish
	$call4 = "{call UPDATE_STATUS_REQUEST_MH(?,?,?)}";
	$param4 = array(array($assignment_id, SQLSRV_PARAM_IN),array($req_id, SQLSRV_PARAM_IN),array('3', SQLSRV_PARAM_IN));
	$exec4 = sqlsrv_query( $conn, $call4, $param4) or die( print_r( sqlsrv_defaults(), true)); 
	$data4= sqlsrv_fetch_array($exec4);
	
	if($exec){
		echo"<script>alert('Data berhasil disimpan');window.location='index.php?page=hasil-pengecekan&USERNAME=".$getUsername."'</script>";
	}else{
		echo"<script>alert('Data gagal disimpan');history.back();</script>";
	}
}else{
	$id=$_POST['id'];
	$no_ktp=$_POST['no_ktp'];
	$nama=$_POST['name'];
	$date=$_POST['date'];
	$mother_nm=$_POST['mother_name'];
	$siapanih=$_POST['tipe_cust'];

	$call = "{call SP_GET_DETAIL_REQUEST_MH(?,?)}";
	$param = array(array($id, SQLSRV_PARAM_IN),array($req_id, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_defaults(), true)); 
	$data = sqlsrv_fetch_array($exec);

	if($no_ktp==""){
		echo"<script>alert('Nomor KTP tidak boleh kosong');history.back();</script>";
	}else if($nama==""){
		echo"<script>alert('Nama tidak boleh kosong');history.back();</script>";
	}else if($date==""){
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
		//echo"<script>alert('Masuk Else');history.back();</script>";
		
		/***** CHECK BLACKLIST *****/
		$call_bls = "{call SP_CHECK_BLACKLIST_REQ_MH(?,?,?,?,?,?)}";
		$params_bls = array(
						array($no_ktp, SQLSRV_PARAM_IN),
						array($nama, SQLSRV_PARAM_IN),
						array($date, SQLSRV_PARAM_IN),
						array($mother_nm, SQLSRV_PARAM_IN),
						array($data['ORDER_NO'], SQLSRV_PARAM_IN),
						array($getUsername, SQLSRV_PARAM_IN)
					);
		$options =  array( "Scrollable" => "buffered" );
		$exec_bls = sqlsrv_query($conn, $call_bls, $params_bls, $options) or die( print_r( sqlsrv_errors(), true));
		/***** END CHECK BLACKLIST *****/	
		
		$call_sd = "{call SP_GET_DUKCAPIL_RESULT(?,?)}";
		$params_sd = array(
						array($data['ORDER_NO'], SQLSRV_PARAM_IN),
						array($no_ktp, SQLSRV_PARAM_IN)
					);
		$options =  array( "Scrollable" => "buffered" );
		$exec_sd = sqlsrv_query($conn, $call_sd, $params_sd, $options) or die( print_r( sqlsrv_errors(), true));
		$num_rows = sqlsrv_num_rows($exec_sd);
		if($num_rows == 0){
			/***** CHECK DUKCAPIL *****/
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

				$callSPLogDkUpilNtValid = "{call SP_INSERT_LOG_BYSOURCE_NEWVERSE(?,?,?,?,?)}";
				$paramsLogDkUpilNtValid = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN), array($SourceLogDkUpilNtValid, SQLSRV_PARAM_IN),array($StatusLogDkUpilNtValid, SQLSRV_PARAM_IN), array($getUsername, SQLSRV_PARAM_IN));
				$execLogDkUpilNtValid = sqlsrv_query( $conn, $callSPLogDkUpilNtValid, $paramsLogDkUpilNtValid) or die( print_r( sqlsrv_errors(), true));
				if($execLogDkUpilNtValid === false){
					echo"<script>alert('Error insert log Dukcapil Not Valid');</script>";
				}
				//----# Insert LOG End

				//echo "<script>alert('Error : ".$StatusLogDkUpilNtValid." (Pada saat pengecekan No KTP di Dukcapil.!)')</script>";
				//$Warning_Data = $Warning_Data." - KTP TIDAK VALID (Pada saat pengecekan No KTP di Dukcapil.!) ";
			}else{
				if($errDkUpil){
					//----# Insert LOG
					$SourceLogDkUpil = "DUKCAPIL";
					$StatusLogDkUpil = "ERROR";

					$callSPLogDkUpil = "{call SP_INSERT_LOG_BYSOURCE_NEWVERSE(?,?,?,?,?)}";
					$paramsLogDkUpil = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkUpil, SQLSRV_PARAM_IN),array($StatusLogDkUpil, SQLSRV_PARAM_IN), array($getUsername, SQLSRV_PARAM_IN));
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

						$callSPLogDkUpilnotfound = "{call SP_INSERT_LOG_BYSOURCE_NEWVERSE(?,?,?,?,?)}";
						$paramsLogDkUpilnotfound = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkUpilnotfound, SQLSRV_PARAM_IN),array($StatusLogDkUpilnotfound, SQLSRV_PARAM_IN), array($getUsername, SQLSRV_PARAM_IN));
						$execLogDkUpilnotfound = sqlsrv_query( $conn, $callSPLogDkUpilnotfound, $paramsLogDkUpilnotfound) or die( print_r( sqlsrv_errors(), true));
						
						if($execLogDkUpilnotfound === false){
							echo"<script>alert('NIK Tersebut Tidak ditemukan di Dukcapil.!');</script>";
						}
						//----# Insert LOG End
						
						echo "<script>alert('Error : ".$StatusLogDkUpilnotfound." (Pada saat pengecekan No KTP di Dukcapil!)')</script>";
						//$Warning_Data = $Warning_Data."  ".$StatusLogDkUpilnotfound."  (Pada saat pengecekan NO KTP di Dukcapil.!) ";
						
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

						$callSPLogDkcpl = "{call SP_INSERT_LOG_BYSOURCE_NEWVERSE(?,?,?,?,?)}";
						$paramsLogDkcpl = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkcpl, SQLSRV_PARAM_IN),array($StatusLogDkcpl, SQLSRV_PARAM_IN), array($getUsername, SQLSRV_PARAM_IN));
						$execLogDkcpl = sqlsrv_query( $conn, $callSPLogDkcpl, $paramsLogDkcpl) or die( print_r( sqlsrv_errors(), true));
						//----# Insert LOG End
						
						//GET LOG ID
						$callGetLog = "{call SP_GET_LOG_ID_DUKCAPIL(?,?)}";
						$paramsGetLog = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN));
						$execGetLog = sqlsrv_query( $conn, $callGetLog, $paramsGetLog) or die( print_r( sqlsrv_errors(), true));
						$dataGetLog = sqlsrv_fetch_array($execGetLog);
						$idLog = $dataGetLog['LOG_CHECK_BYSOURCE_ID'];
						
						foreach($resultDukcapil['content'] as $contentdata){
							$DkcplCustType = $siapanih;
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
								//$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
								//$WarningNama = "Perbedaan Nama Lengkap :<br>Data CONFINS : <b>".$nama."</b><br>Data Dukcapil : <b>".$DkcplNAMA_LGKP."</b><br>";
								
								$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL(?,?,?,?,?)}";
								$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('1', SQLSRV_PARAM_IN),array($getUsername, SQLSRV_PARAM_IN));
								$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
							}
							if($DkcplTGL_LHR != $date){
								//$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
								//$WarningTTL = "Perbedaan Tanggal lahir :<br>Data CONFINS : <b>".$date."</b><br>Data Dukcapil : <b>".$DkcplTGL_LHR."</b><br>";
								
								$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL(?,?,?,?,?)}";
								$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('2', SQLSRV_PARAM_IN),array($getUsername, SQLSRV_PARAM_IN));
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
								//echo $_POST['mother_name'];
								//echo $namaIbuTanpaSpasiP;
								
								if($namaIbuTanpaSpasiD <> ""){
									if($namaIbuTanpaSpasiD != $namaIbuTanpaSpasiP){
										//$Warning_Data = "Silahkan lakukan pengkinian data ke dukcapil setempat<br>";
										//$WarningIbu = "Perbedaan Nama Ibu Kandung :<br>Data CONFINS : <b>".$mother_nm."</b><br>Data Dukcapil : <b>".$DkcplNAMA_LGKP_IBU."</b><br>";
										
										$callInsertError = "{call SP_INSERT_ERROR_DUKCAPIL(?,?,?,?,?)}";
										$paramsInsertError = array(array($idLog, SQLSRV_PARAM_IN),array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array('3', SQLSRV_PARAM_IN),array($getUsername, SQLSRV_PARAM_IN));
										$execInsertError = sqlsrv_query($conn, $callInsertError, $paramsInsertError) or die(print_r(sqlsrv_errors(), true));
									}
								}
							}
						}	
					}
				}
			}
			/***** END CHECK DUKCAPIL *****/
		}
	}
}
?>
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
						<table class="table">
							<tr>
								<td>Nomor Order</td>
								<td>:</td>
								<td><?php echo $data['ORDER_NO'];?></td>
							</tr>
							<tr>
								<td>NIK</td>
								<td>:</td>
								<td><?php echo $no_ktp;?></td>
							</tr>
							<tr>
								<td>Nama Customer</td>
								<td>:</td>
								<td><?php echo $nama;?></td>
							</tr>
						</table>
					</div>
					<div class="col-md-6">
						<table class="table">
							<tr>
								<td>Nama Dealer</td>
								<td>:</td>
								<td><?php echo $data['DEALER_NAME'];?></td>
							</tr>
							<tr>
								<td>User Request</td>
								<td>:</td>
								<td><?php echo $data['MH'];?></td>
							</tr>
							<tr>
								<td>Tanggal Request</td>
								<td>:</td>
								<td><?php echo $data['CREATE_DATE']->format('Y-m-d H:i:s');?></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title"></h4>
				<p class="category"></p>
			</div>
			<div class="content">		
				<div class="row">
					<div class="col-md-12">
						<?php
						$call2 = "{call SP_GET_RESPONSE_RESULT_DUKCAPIL(?,?)}";
						$param2 = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN));
						$exec2 = sqlsrv_query( $conn, $call2, $param2) or die( print_r( sqlsrv_defaults(), true)); 
						while($data2 = sqlsrv_fetch_array($exec2)){
							if($data2['SOURCE'] == "PEFINDO BIRO KREDIT / SLIK"){
						?>
						<table class="table table-bordered" style="width:100%;font-size:12px;">
							<thead>
								<tr>
									<th style="color:#FFF;font-weight:bold;background-color:#035c7a;" colspan="2">REQUEST CEK SLIK</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<div class="row">
											<div class="col-md-12">
												<form action='check-slik.php' method='post'>
													<input name='prospect_no' type='hidden' value='<?php echo $data['ORDER_NO'];?>'>
													<input name='no_ktp' type='hidden' value='<?php echo $no_ktp;?>'>
													<input name='nama' type='hidden' value="<?php echo $nama;?>">
													<input name='birth_dt' type='hidden' value='<?php echo $date;?>'>
													<input name='cust_type' type='hidden' value='P'>
													<input name='id_type' type='hidden' value="KTP">
													<input name='username' type='hidden' value="<?php echo $user;?>">
													<input name='tipe_cust' type='hidden' value="<?php echo $siapanih;?>">
													<button type='submit' class='btn btn-custom btn-sm' style="width:100%;">AJUKAN CEK SLIK</button>
												</form>
											</div>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						<?php
							}else{
						?>
						<table class="table table-bordered" style="width:100%;font-size:12px;">
							<thead>
								<tr>
									<th style="color:#FFF;font-weight:bold;background-color:#035c7a;" colspan="2">HASIL PENGECEKAN <?php echo $data2['SOURCE'];?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td style="width:50%;">Hasil Pengecekan</td>
									<td style="width:50%;">
										<?php 
											if($data2['RESULT'] == "PENGKINIAN DATA"){
												$call3 = "{call SP_GET_RESPONSE_RESULT_ERROR_DETAIL(?,?)}";
												$param3 = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN));
												$exec3 = sqlsrv_query( $conn, $call3, $param3) or die( print_r( sqlsrv_defaults(), true)); 
												while($data3 = sqlsrv_fetch_array($exec3)){
													echo strtoupper($data3['MSG_NAME']).", ";
												}
											}else{
												//echo substr($data2['RESULT'],0,strlen(-2));
												echo $data2['RESULT'];
											}
										?>
									</td>
								</tr>
								<tr>
									<td style="width:50%;">Checked By</td>
									<td style="width:50%;"><?php echo $data2['USER_CREATE'];?></td>
								</tr>
								<tr>
									<td style="width:50%;">Checked Date</td>
									<td style="width:50%;"><?php if($data2['CREATE_DATE']<>NULL){echo $data2['CREATE_DATE']->format('Y-m-d H:i:s');}?></td>
								</tr>
							</tbody>
						</table>
						<?php } } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>