<?php
require_once("config/configuration.php");
if(isset($_POST['submit'])){
	$no_ktp = $_POST['no_ktp'];
	$user = $_GET['USERNAME'];
	$siapanih = $_POST['type'];
	
	$param_dukcapil_array= array('nik' => $no_ktp, 'user_id' => "singlesuzukifinance", 'password' => "s3Jsm8K9", 'IP_USER' => $user);
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
		$paramsLogDkUpilNtValid = array(array('MANUAL', SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN), array($SourceLogDkUpilNtValid, SQLSRV_PARAM_IN),array($StatusLogDkUpilNtValid, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
		$execLogDkUpilNtValid = sqlsrv_query( $conn, $callSPLogDkUpilNtValid, $paramsLogDkUpilNtValid) or die( print_r( sqlsrv_errors(), true));
		//----# Insert LOG End
	}else{
		if($errDkUpil){
			//----# Insert LOG
			$SourceLogDkUpil = "DUKCAPIL";
			$StatusLogDkUpil = "ERROR";

			$callSPLogDkUpil = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
			$paramsLogDkUpil = array(array('MANUAL', SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkUpil, SQLSRV_PARAM_IN),array($StatusLogDkUpil, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
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
				$paramsLogDkUpilnotfound = array(array('MANUAL', SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkUpilnotfound, SQLSRV_PARAM_IN),array($StatusLogDkUpilnotfound, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
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
			}else{
				//----# Insert LOG
				$SourceLogDkcpl = "DUKCAPIL";
				$StatusLogDkcpl = "VALID";

				$callSPLogDkcpl = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
				$paramsLogDkcpl = array(array('MANUAL', SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkcpl, SQLSRV_PARAM_IN),array($StatusLogDkcpl, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
				$execLogDkcpl = sqlsrv_query( $conn, $callSPLogDkcpl, $paramsLogDkcpl) or die( print_r( sqlsrv_errors(), true));
				//----# Insert LOG End
				
				foreach($resultDukcapil['content'] as $contentdata){
					$DkcplCustType = strtoupper($siapanih);
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
}else{
	$no_ktp = "";
	$siapanih = "";
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
				<h4 class="title">Dukcapil</h4>
				<p class="category">Pengecekan Dukcapil Manual</p>
			</div>
			<div class="content">
				<form action="" method="post">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Nomor KTP</label>
								<input type="text" name="no_ktp" class="form-control" placeholder="Nomor KTP" value="<?php echo $no_ktp;?>">
							</div>
						</div>
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
															<td>TTL</td>
															<td><?php echo $DkcplTMPT_LHR.", ".$DkcplTGL_LHR;?></td>
														</tr>
														<tr>
															<td>Jenis Kelamin</td>
															<td><?php echo $DkcplJENIS_PKRJN;?></td>
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
														<tr>
															<td>Nama Ibu Kandung</td>
															<td><?php echo $DkcplNAMA_LGKP_IBU;?></td>
														</tr>
														<tr>
															<td>Pekerjaan</td>
															<td><?php echo $DkcplJENIS_PKRJN;?></td>
														</tr>
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
