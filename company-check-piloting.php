<?php
require_once("config/configuration.php");

$user = $_GET['USERNAME'];
$prospect = $_POST['prospect_no'];
$npwp = $_POST['npwp'];
$name = $_POST['name'];
$est = $_POST['est'];

if (isset($_POST['submitPefindo'])) {
	$id_type = 'NPWP';
	$pefindoId = $_POST['pefindo_id'];

	# get mapping id
	$callMappingId = "{call SP_GET_PEFINDO_MAPPING_ID(?,?,?,?,?)}";
	$paramsMappingId = array(array($pefindoId, SQLSRV_PARAM_IN), array($prospect, SQLSRV_PARAM_IN), array($npwp, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN), array('COMPANY', SQLSRV_PARAM_IN));
	$execMappingId = sqlsrv_query($conn, $callMappingId, $paramsMappingId) or die(print_r(sqlsrv_errors(), true));
	$dataMappingId = sqlsrv_fetch_array($execMappingId);
	$mappingId = $dataMappingId['PEFINDO_MAPPING_ID'];


	# update data tasklist
	$callInsert = "{call CPY_UPDATE_TASKLIST(?, ?, ?, ?, ?, ?)}";
	$paramInsert = array(
		array($prospect, SQLSRV_PARAM_IN),
		array($npwp, SQLSRV_PARAM_IN),
		array('COMPANY', SQLSRV_PARAM_IN),
		array($user, SQLSRV_PARAM_IN),
		array('802', SQLSRV_PARAM_IN),
		array('28', SQLSRV_PARAM_IN)
	);
	$execInsert = sqlsrv_query($conn, $callInsert, $paramInsert) or die(print_r(sqlsrv_errors(), true));


	# update is_checked
	$callSPUpdateChecked = "{call CPY_UPDATE_CHECKED_DATA(?,?,?,?)}";
	$paramsUpdateChecked = array(
		array($prospect, SQLSRV_PARAM_IN),
		array($npwp, SQLSRV_PARAM_IN),
		array($id_type, SQLSRV_PARAM_IN),
		array($user, SQLSRV_PARAM_IN)
	);
	$execUpdateChecked = sqlsrv_query($conn, $callSPUpdateChecked, $paramsUpdateChecked) or die(print_r(sqlsrv_errors(), true));


	# arahkan ke halaman scoring pefindo
	echo "<script>window.location='index.php?USERNAME=" . $user . "&page=scoring-company-piloting&id=" . $mappingId . "&no=" . $prospect . "&redirect=1'</script>";
} else {

	if ($npwp == "") {
		echo "<script>alert('Nomor NPWP tidak boleh kosong, silahkan lakukan edit data di CONFINS');history.back();</script>";
	} else if ($name == "") {
		echo "<script>alert('Nama tidak boleh kosong, silahkan lakukan edit data di CONFINS');history.back();</script>";
	}

	$Warning_Data = "";

	# Periksa data pada blacklist pefindo dan tambahkan ke log
	$call_bls = "{call SP_CHECK_PEFINDO_BLACKLIST(?, ?, ?, ?, ?, ?, ?)}";
	$params_bls = array(
		array($npwp, SQLSRV_PARAM_IN),
		array($name, SQLSRV_PARAM_IN),
		array(NULL, SQLSRV_PARAM_IN),
		array(NULL, SQLSRV_PARAM_IN),
		array(NULL, SQLSRV_PARAM_IN),
		array($prospect, SQLSRV_PARAM_IN),
		array($user, SQLSRV_PARAM_IN)
	);
	$options =  array("Scrollable" => "buffered");
	$exec_bls = sqlsrv_query($conn, $call_bls, $params_bls, $options) or die(print_r(sqlsrv_errors(), true));
	$data = sqlsrv_fetch_array($exec_bls);
	$checkBlacklist = sqlsrv_num_rows($exec_bls);

	# Membaca apakah ada row pada table blacklist
	if ($checkBlacklist > 0) {
		echo "<script>alert('Customer tersebut terdaftar di Customer Blacklist Internal.');</script>";
		$Warning_Data = $Warning_Data . " - Customer ini terdaftar di Customer Blacklist Internal.!<br>";
	}

	# Cek Pefindo
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => $pefindoURL,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"\r\nxmlns:cb5=\"http://creditinfo.com/CB5\"\r\nxmlns:smar=\"http://creditinfo.com/CB5/v5.31/SmartSearch\">\r\n <soapenv:Header/>\r\n <soapenv:Body>\r\n <cb5:SmartSearchCompany>\r\n <cb5:query>\r\n <smar:InquiryReason>ProvidingFacilities</smar:InquiryReason>\r\n <smar:InquiryReasonText/>\r\n <smar:Parameters>\r\n <smar:CompanyName>" . $name . "</smar:CompanyName>\r\n <smar:IdNumbers>\r\n <smar:IdNumberPairCompany>\r\n <smar:IdNumber>" . $npwp . "</smar:IdNumber>\r\n <smar:IdNumberType>NPWP</smar:IdNumberType>\r\n </smar:IdNumberPairCompany>\r\n </smar:IdNumbers>\r\n </smar:Parameters>\r\n </cb5:query>\r\n </cb5:SmartSearchCompany>\r\n </soapenv:Body>\r\n</soapenv:Envelope>",
		CURLOPT_HTTPHEADER => array(
			"Authorization: Basic " . base64_encode("$username:$password"),
			"Content-Type: text/xml",
			"Postman-Token: ae0ace2e-aa92-4d66-8d14-d67edb42fa84",
			"SOAPAction: " . $smartSearchCompany,
			"cache-control: no-cache"
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);

	# Request pefindo Error
	if ($err) {
		# Tambah log PEFINDO Error
		$SourceLog = "PEFINDO";
		$StatusLog = "ERROR";

		$callSPLogPfnd = "{call SP_INSERT_LOG_BYSOURCE(?, ?, ?, ?, ?)}";
		$paramsLogPfnd = array(array($prospect, SQLSRV_PARAM_IN), array($npwp, SQLSRV_PARAM_IN), array($SourceLog, SQLSRV_PARAM_IN), array($StatusLog, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
		$execLogPfnd = sqlsrv_query($conn, $callSPLogPfnd, $paramsLogPfnd) or die(print_r(sqlsrv_errors(), true));
		if ($execLogPfnd === false) {
			echo "<script>alert('Error insert log');</script>";
		}

		echo "<script>window.location='index.php?USERNAME=" . $user . "&page=error'</script>";
	} else {
		$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
		$xml = new SimpleXMLElement($response);
		$body = $xml->xpath('//sBody')[0];
		$array = json_decode(json_encode((array)$body), TRUE);
		// //print_r($array);

		if ($array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aStatus'] == 'SubjectFound') {
			if ($array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aPefindoId'] <> NULL) {
				# Tambah log PEFINDO ditemukan
				$SourceLogPfndScss = "PEFINDO";
				$StatusLogPfndScss = "DATA DITEMUKAN";

				$callSPLogPfndScss = "{call SP_INSERT_LOG_BYSOURCE(?, ?, ?, ?, ?)}";
				$paramsLogPfndScss = array(array($prospect, SQLSRV_PARAM_IN), array($npwp, SQLSRV_PARAM_IN), array($SourceLogPfndScss, SQLSRV_PARAM_IN), array($StatusLogPfndScss, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
				$execLogPfndScss = sqlsrv_query($conn, $callSPLogPfndScss, $paramsLogPfndScss) or die(print_r(sqlsrv_errors(), true));
				if ($execLogPfndScss === false) {
					echo "<script>alert('Error insert log Pefindo DataFound');</script>";
				}
			} else {
				# Tambah log PEFINDO ditemukan dengan multiple ID
				$SourceLogPfndScssMlti = "PEFINDO";
				$StatusLogPfndScssMlti = "DATA DITEMUKAN - MULTI PEFINDO ID";

				$callSPLogPfndScssMlti = "{call SP_INSERT_LOG_BYSOURCE(?, ?, ?, ?, ?)}";
				$paramsLogPfndScssMlti = array(array($prospect, SQLSRV_PARAM_IN), array($npwp, SQLSRV_PARAM_IN), array($SourceLogPfndScssMlti, SQLSRV_PARAM_IN), array($StatusLogPfndScssMlti, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
				$execLogPfndScssMlti = sqlsrv_query($conn, $callSPLogPfndScssMlti, $paramsLogPfndScssMlti) or die(print_r(sqlsrv_errors(), true));
				if ($execLogPfndScssMlti === false) {
					echo "<script>alert('Error insert log Pefindo DataFoundMulti');</script>";
				}
			}
		} else {
			# Tambah log PEFINDO tidak ditemukan
			$SourceLogPfndNtfnd = "PEFINDO";
			$StatusLogPfndNtfnd = "DATA TIDAK DITEMUKAN";

			$callSPLogPfndNtfnd = "{call SP_INSERT_LOG_BYSOURCE(?, ?, ?, ?, ?)}";
			$paramsLogPfndNtfnd = array(array($prospect, SQLSRV_PARAM_IN), array($npwp, SQLSRV_PARAM_IN), array($SourceLogPfndNtfnd, SQLSRV_PARAM_IN), array($StatusLogPfndNtfnd, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
			$execLogPfndNtfnd = sqlsrv_query($conn, $callSPLogPfndNtfnd, $paramsLogPfndNtfnd) or die(print_r(sqlsrv_errors(), true));
			if ($execLogPfndNtfnd === false) {
				echo "<script>alert('Error insert log Pefindo DataFound');</script>";
			}
		}
	}
}
?>

<style>
	.th-custom {
		text-align: center;
		vertical-align: middle;
		font-weight: bold;
	}

	.td-custom {
		text-align: center;
		vertical-align: middle;
	}
</style>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Hasil Pengecekan</h4>
				<p class="category">Pengecekan berdasarkan Blacklist Internal dan Pefindo</p>
			</div>
			<hr>
			<div class="content">
				<div class="row">
					<div class="col-md-12">
						<b>DATA CONFINS :</b><br>
						<div class="table-responsive">
							<table class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;background-color:#035c7a;">No</th>
										<th class="th-custom" style="color:#FFF;background-color:#035c7a;">Nomor Prospek</th>
										<th class="th-custom" style="color:#FFF;background-color:#035c7a;">Nomor NPWP</th>
										<th class="th-custom" style="color:#FFF;background-color:#035c7a;">Nama Perusahaan</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="td-custom">1</td>
										<td class="td-custom"><?php echo $prospect; ?></td>
										<td class="td-custom"><?php echo $npwp; ?></td>
										<td><?php echo $name; ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<b>DATA PEFINDO :</b><br>
						<div class="table-responsive">
							<table class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;background-color:#035c7a;">No</th>
										<th class="th-custom" style="color:#FFF;background-color:#035c7a;">NPWP</th>
										<th class="th-custom" style="color:#FFF;background-color:#035c7a;">Nama Perusahaan</th>
										<th class="th-custom" style="color:#FFF;background-color:#035c7a;">Alamat</th>
										<th class="th-custom" style="color:#FFF;background-color:#035c7a;">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$pefindoFound = false; # default
									$period = date("Ymd");

									# Cari pefindo ID yang masih berlaku, agar ketika di-cek scoring akan menampilkan halaman scoring saja
									$callActiveId = "{call SP_CHECK_PEFINDO_ID(?, ?, ?, ?)}";
									$paramsActiveId = array(
										array('', SQLSRV_PARAM_IN),
										array($prospect, SQLSRV_PARAM_IN),
										array($npwp, SQLSRV_PARAM_IN),
										array($period, SQLSRV_PARAM_IN)
									);
									$optionsActiveId =  array("Scrollable" => "buffered");
									$execActiveId = sqlsrv_query($conn, $callActiveId, $paramsActiveId, $optionsActiveId) or die(print_r(sqlsrv_errors(), true));
									$dataActiveId = sqlsrv_fetch_array($execActiveId);
									$pefindoChecked = sqlsrv_num_rows($execActiveId) > 0;
									// // var_dump($dataActiveId);

									# pefindo id lama yang masih aktif
									$pefindoId = $dataActiveId['PEFINDO_ID'];
									$enableRequest = is_null($pefindoId);

									# Periksa apakah data PEFINDO ditemukan
									if ($array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aStatus'] == 'SubjectFound') {
									?>
										<?php

										# PEFINDO ditemukan
										$pefindoFound = true;

										if ($array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aPefindoId'] <> NULL) {
											$pefId = $array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aCompanyRecords']['aSearchCompanyRecord']['aPefindoId'];
											$pefCompanyNpwp = $array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aCompanyRecords']['aSearchCompanyRecord']['aNPWP'];
											$pefCompanyName = $array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aCompanyRecords']['aSearchCompanyRecord']['aCompanyName'];
											$pefCompanyAddress = $array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aCompanyRecords']['aSearchCompanyRecord']['aAddress'];

											# Jika tidak ada PEFINDO ID yang aktif, gunakan PEFINDO ID baru
											if ($enableRequest) {
												$pefindoId = $pefId;
											}
										?>

											<?php if ($pefCompanyNpwp == $npwp) : ?>
											<tr>
												<td class="td-custom">1</td>
												<td class="td-custom">
													<?= (sizeof($pefCompanyNpwp) > 0) ? $pefCompanyNpwp : "-" ?>
												</td>
												<td>
													<?= (sizeof($pefCompanyName) > 0) ? $pefCompanyName : "-" ?>
												</td>
												<td class="td-custom">
													<?= (sizeof($pefCompanyAddress) > 0) ? $pefCompanyAddress : "-" ?>
												</td>
												<td class="td-custom">
													<form action="check-pefindo-company.php" method="post">
														<input type="hidden" name="user" value="<?php echo $user; ?>">
														<input type="hidden" name="no_prospect" value="<?php echo $prospect; ?>">
														<input type="hidden" name="npwp" value="<?php echo $npwp; ?>">
														<input type="hidden" name="name" value="<?php echo $name; ?>">
														<input type="hidden" name="pefindo_id" value="<?php echo $pefindoId; ?>">
														<input type="hidden" name="est" value="<?php echo $est; ?>">
														<input type="submit" class="btn btn-custom btn-xs" value="Check Scoring">
													</form>
												</td>
											</tr>
											<?php else : ?>
											<tr>
												<td colspan="6" style="text-align:center;">Data tidak ditemukan (NPWP Tidak sesuai)</td>
											</tr>
											<?php endif; ?>

										<?php
										} else {
											# PEFINDO ditemukan dengan multiple ID
										?>
											<tr>
												<td colspan="6" style="text-align:center;">Data tidak ditemukan</td>
											</tr>
										<?php }
									} else {
										if ($enableRequest) {
											# PEFINDO tidak ditemukan
											$pefindoId = '0000';
											$date = date("Y-m-d");

											# Tambahkan data (piloting) ke table PEFINDO_MAPPING dengan PEFINDO ID 0000
											$callSPInsert = "{call SP_INSERT_PEFINDO_ID(?, ?, ?, ?, ?)}";
											$paramsInsert = array(array($pefindoId, SQLSRV_PARAM_IN), array($prospect, SQLSRV_PARAM_IN), array($npwp, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN), array('COMPANY', SQLSRV_PARAM_IN));
											$execInsert = sqlsrv_query($conn, $callSPInsert, $paramsInsert) or die(print_r(sqlsrv_errors(), true));
										}
										?>
										<tr>
											<td colspan="6" style="text-align:center;">Data tidak ditemukan</td>
										</tr>
									<?php
									}
									?>
								</tbody>
							</table>
						</div>
						<b><label style="color:red; font-size: 14px"><?php echo $Warning_Data; ?></label></b>
						<hr>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div style="float:left;">
							<?php if ($enableRequest) : ?>
								<form action="" method="post">
									<input type="hidden" name="no_prospect" value="<?php echo $prospect; ?>">
									<input type="hidden" name="npwp" value="<?php echo $npwp; ?>">
									<input type="hidden" name="name" value="<?php echo $name; ?>">
									<input type="hidden" name="user" value="<?php echo $user; ?>">
									<input type="hidden" name="pefindo_id" value="<?php echo $pefindoId; ?>">
									<input type="submit" class="btn btn-custom btn-xs" value="Submit" name="submitPefindo" onclick="return confirm('Pastikan bahwa hasil PEFINDO tidak ditemukan. jika sudah, silahkan lanjutkan proses.');">
								</form>
							<?php endif; ?>
							
							<div class="text-danger" style="font-style:italic;">
								<?php
								if ($pefindoChecked) {
									echo '*Data ini sudah pernah dilakukan pengecekan.';
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('#datatable').DataTable();
	});
</script>