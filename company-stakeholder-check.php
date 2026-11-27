<?php
require_once("config/configuration.php");
$Warning_Data = "";
$WarningNama = "";
$WarningTTL = "";


if (isset($_POST['check'])) {
	$prospect = $_POST['prospect_no'];
	$no_ktp = $_POST['no_ktp'];
	$nama = $_POST['name'];
	$date = date("Y-m-d", strtotime($_POST['date']));
	// $mother_nm = (isset($_POST['mother_name'])) ? $_POST['mother_name'] : '';
	$birth_place = $_POST['birth_place'];
	$alamat = (isset($_POST['alamat'])) ? $_POST['alamat'] : '-';
	//$siapanih = 'PENGURUS';
	$userName = $_GET['USERNAME'];

	$dateCapil = date("d-m-Y", strtotime($_POST['date']));

	# get info stakeholder / company
	$call3 = "{call SP_GETDATA_INFO_CUSTOMER_NEWVERSE_2(?,?)}";
	$param3 = array(
		array($no_ktp, SQLSRV_PARAM_IN),
		array($prospect, SQLSRV_PARAM_IN)
	);
	$options3 =  array("Scrollable" => "buffered");
	$exec3 = sqlsrv_query($conn, $call3, $param3, $options3) or die(print_r(sqlsrv_errors(), true));
	$data3 = sqlsrv_fetch_array($exec3);

	// $callStatVerf = "{call SP_GET_STATUS_VERIFIKASI(?,?)}";
	// $paramsStatVerf = array(
	// 	array($prospect, SQLSRV_PARAM_IN),
	// 	array($no_ktp, SQLSRV_PARAM_IN)
	// );
	// $optionsStatVerf =  array("Scrollable" => "buffered");
	// $execStatVerf = sqlsrv_query($conn, $callStatVerf, $paramsStatVerf, $optionsStatVerf) or die(print_r(sqlsrv_errors(), true));
	// $dataStatVerf = sqlsrv_fetch_array($execStatVerf);
	// $checkStatVerf = sqlsrv_num_rows($execStatVerf);

	# Periksa data pada blacklist pefindo dan tambahkan ke log
	$call_bls = "{call SP_CHECK_PEFINDO_BLACKLIST(?, ?, ?, ?, ?, ?, ?)}";
	$params_bls = array(
		array($no_ktp, SQLSRV_PARAM_IN),
		array($nama, SQLSRV_PARAM_IN),
		array(NULL, SQLSRV_PARAM_IN),
		array(NULL, SQLSRV_PARAM_IN),
		array(NULL, SQLSRV_PARAM_IN),
		array($prospect, SQLSRV_PARAM_IN),
		array($userName, SQLSRV_PARAM_IN)
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
	else {
		if ($no_ktp == "") {
			echo "<script>alert('Nomor KTP tidak boleh kosong, silahkan lakukan edit data di CONFINS');history.back();</script>";
		} else if ($nama == "") {
			echo "<script>alert('Nama tidak boleh kosong, silahkan lakukan edit data di CONFINS');history.back();</script>";
		} else if ($date == "") {
			echo "<script>alert('Tanggal lahir tidak boleh kosong, silahkan lakukan edit data di CONFINS');history.back();</script>";
		} else if (substr($no_ktp, 0, 1) == "0") {
			echo "<script>alert('Nomor KTP tidak boleh berawalan 0');history.back();</script>";
		} else if (substr($no_ktp, -4) == "0000") {
			echo "<script>alert('4 Digit Nomor KTP tidak boleh 0000');history.back();</script>";
		} else if (strlen(trim($no_ktp)) <> 16) {
			echo "<script>alert('NIK harus 16 digit');history.back();</script>";
		} else if (preg_match("/^[a-zA-Z]$/", $no_ktp)) {
			echo "<script>alert('NIK tidak boleh mengandung alphabet');history.back();</script>";
		} else {
			//require_once("company-stakeholder-check-dukcapil-non.php");
			require_once("company-stakeholder-check-dukcapil.php");
		}
	}
} else if (isset($_POST['slik'])) {
	$prospect = $_POST['prospect_no'];
	$no_ktp = $_POST['no_ktp'];
	$nama = $_POST['name'];
	$date = date("Y-m-d", strtotime($_POST['date']));
	$birth_place = $_POST['birth_place'];
	$alamat = (isset($_POST['alamat'])) ? $_POST['alamat'] : '-';
	$userName = $_GET['USERNAME'];

	// // $mother_nm = (isset($_POST['mother_name'])) ? $_POST['mother_name'] : '';
	// // $siapanih = (isset($_POST['tipe_cust'])) ? $_POST['tipe_cust'] : '';

	// // $callCheck = "{call SP_CHECK_SLIK_CHECKED(?)}";
	// // $paramCheck = array(array($no_ktp, SQLSRV_PARAM_IN));
	// // $optionCheck = array("Scrollable" => "buffered");
	// // $execCheck = sqlsrv_query($conn, $callCheck, $paramCheck, $optionCheck) or die(print_r(sqlsrv_errors(), true));
	// // $dataCheck =  sqlsrv_fetch_array($execCheck);
	// // $rowsCheck = sqlsrv_num_rows($execCheck);

	// // $callCheck1 = "{call SP_CHECK_SLIK_CHECKED_PROSPECT(?,?)}";
	// // $paramCheck1 = array(
	// // 	array($no_ktp, SQLSRV_PARAM_IN),
	// // 	array($prospect, SQLSRV_PARAM_IN)
	// // );
	// // $optionCheck1 = array("Scrollable" => "buffered");
	// // $execCheck1 = sqlsrv_query($conn, $callCheck1, $paramCheck1, $optionCheck1) or die(print_r(sqlsrv_errors(), true));
	// // $dataCheck1 =  sqlsrv_fetch_array($execCheck1);
	// // $rowsCheck1 = sqlsrv_num_rows($execCheck1);

	// // $call3 = "{call SP_CHECK_DUKCAPIL_MAPPING_HOLD(?,?)}";
	// // $param3 = array(
	// // 	array($prospect, SQLSRV_PARAM_IN),
	// // 	array($no_ktp, SQLSRV_PARAM_IN)
	// // );
	// // $options =  array("Scrollable" => "buffered");
	// // $exec3 = sqlsrv_query($conn, $call3, $param3, $options) or die(print_r(sqlsrv_defaults(), true));
	// // $data3 = sqlsrv_fetch_array($exec3);
	// // $checkData = sqlsrv_num_rows($exec3);

	# insert data to tasklist
	$callInsert = "{call CPY_INSERT_TASKLIST(?, ?, ?, ?, ?, ?, ?, ?, ?)}";
	$paramInsert = array(
		array($prospect, SQLSRV_PARAM_IN),
		array($no_ktp, SQLSRV_PARAM_IN),
		array($nama, SQLSRV_PARAM_IN),
		array($date, SQLSRV_PARAM_IN),
		array('PENGURUS', SQLSRV_PARAM_IN),
		array('KTP', SQLSRV_PARAM_IN),
		array($userName, SQLSRV_PARAM_IN),
		array('801', SQLSRV_PARAM_IN),
		array('21', SQLSRV_PARAM_IN)
	);
	$execInsert = sqlsrv_query($conn, $callInsert, $paramInsert) or die(print_r(sqlsrv_errors(), true));


	# update is_checked untuk pengurus
	$callSPUpdateChecked = "{call CPY_UPDATE_CHECKED_DATA(?, ?, ?, ?)}";
	$id_type = 'KTP';
	$paramsUpdateChecked = array(
		array($prospect, SQLSRV_PARAM_IN),
		array($no_ktp, SQLSRV_PARAM_IN),
		array($id_type, SQLSRV_PARAM_IN),
		array($user, SQLSRV_PARAM_IN)
	);
	$execUpdateChecked = sqlsrv_query($conn, $callSPUpdateChecked, $paramsUpdateChecked) or die(print_r(sqlsrv_errors(), true));

	# arahkan kembali ke company prospect
	$callCpyDetail = "{call CPY_PEFINDO_GETDATA_DETAIL_COMPANY(?)}";
	$paramsCpyDetail = array(array($prospect, SQLSRV_PARAM_IN));
	$execCpyDetail = sqlsrv_query($conn, $callCpyDetail, $paramsCpyDetail) or die(print_r(sqlsrv_errors(), true));
	$dataCpyDetail = sqlsrv_fetch_array($execCpyDetail);

	echo "<script>alert('Data Berhasil Terkirim ke tasklist');</script>";
	echo
	'<body onload="document.redirectform.submit()">   
			<form method="POST" action="index.php?page=company-prospek-piloting&USERNAME=' . $userName . '" name="redirectform" style="display:none">
			<input name="prospect_no" value="' . $prospect . '">
			<input name="order_no" value="' . $prospect . '">
			<input name="npwp" value="' . $dataCpyDetail["ID_NO"] . '">
			<input name="name" value="' . $dataCpyDetail["STAKEHOLDER_NAME"] . '">
			</form>
		</body>';
} else {
	$prospect = $_POST['prospect_no'];
	$no_ktp = $_POST['no_ktp'];
	$nama = $_POST['name'];
	$date = date("Y-m-d", strtotime($_POST['date']));
	$birth_place = $_POST['birth_place'];
	$alamat = (isset($_POST['alamat'])) ? $_POST['alamat'] : '-';
	$userName = $_GET['USERNAME'];

	// $mother_nm = (isset($_POST['mother_name'])) ? $_POST['mother_name'] : '';
	// $siapanih = (isset($_POST['tipe_cust'])) ? $_POST['tipe_cust'] : '';
}

$callGetError = "{call SP_GET_VALIDASI_DUKCAPIL(?,?)}";
$options =  array("Scrollable" => "buffered");
$paramsGetError = array(array($prospect, SQLSRV_PARAM_IN), array($no_ktp, SQLSRV_PARAM_IN));
$execGetError = sqlsrv_query($conn, $callGetError, $paramsGetError, $options) or die(print_r(sqlsrv_errors(), true));
$dataGetError = sqlsrv_fetch_array($execGetError);
$checkGetError = sqlsrv_num_rows($execGetError);


$call3 = "{call SP_GETDATA_INFO_CUSTOMER_NEWVERSE_2(?,?)}";
$param3 = array(
	array($no_ktp, SQLSRV_PARAM_IN),
	array($prospect, SQLSRV_PARAM_IN)
);
$options3 =  array("Scrollable" => "buffered");
$exec3 = sqlsrv_query($conn, $call3, $param3, $options3) or die(print_r(sqlsrv_errors(), true));
$data3 = sqlsrv_fetch_array($exec3);


$callGetOrder = "{call SP_GET_ORDER_FROM_PROSPECT(?)}";
$paramGetOrder = array(array($prospect, SQLSRV_PARAM_IN));
$optionGetOrder = array("Scrollable" => "buffered");
$execGetOrder = sqlsrv_query($conn, $callGetOrder, $paramGetOrder, $optionGetOrder) or die(print_r(sqlsrv_errors(), true));
$dataGetOrder =  sqlsrv_fetch_array($execGetOrder);


$callChecked = "{call SP_GET_CHECKED_PEFINDO_SLIK(?,?)}";
$paramChecked = array(
	array($dataGetOrder['ORDER_NO'], SQLSRV_PARAM_IN),
	array($no_ktp, SQLSRV_PARAM_IN)
);
$optionChecked = array("Scrollable" => "buffered");
$execChecked = sqlsrv_query($conn, $callChecked, $paramChecked, $optionChecked) or die(print_r(sqlsrv_errors(), true));
//$dataChecked =  sqlsrv_fetch_array($execChecked);
$dataCheckedLog = sqlsrv_num_rows($execChecked);


$callCheckedProspect = "{call SP_GET_CHECKED_PEFINDO_SLIK(?,?)}";
$paramCheckedProspect = array(
	array($prospect, SQLSRV_PARAM_IN),
	array($no_ktp, SQLSRV_PARAM_IN)
);
$optionCheckedProspect = array("Scrollable" => "buffered");
$execCheckedProspect = sqlsrv_query($conn, $callCheckedProspect, $paramCheckedProspect, $optionCheckedProspect) or die(print_r(sqlsrv_errors(), true));
//$dataCheckedProspect =  sqlsrv_fetch_array($execCheckedProspect);
$dataCheckedLogProspect = sqlsrv_num_rows($execCheckedProspect);


# verify if user already check slik
$callIfAlreadyChecked = "{call CPY_GET_CHECKED_PENGURUS(?, ?)}";
$paramIfAlreadyChecked = array(
	array($prospect, SQLSRV_PARAM_IN),
	array($no_ktp, SQLSRV_PARAM_IN)
);
$optionIfAlreadyChecked = array("Scrollable" => "buffered");
$execIfAlreadyChecked = sqlsrv_query($conn, $callIfAlreadyChecked, $paramIfAlreadyChecked, $optionIfAlreadyChecked) or die(print_r(sqlsrv_errors(), true));
$dataIfAlreadyChecked =  sqlsrv_fetch_array($execIfAlreadyChecked);


# Periksa waktu request SLIK
$callDate = "{call SP_GET_DATE_SLIK}";
$execDate = sqlsrv_query($conn, $callDate) or die(print_r(sqlsrv_errors(), true));
$dataDate = sqlsrv_fetch_array($execDate);
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

<?php
/***** CEK DUKCAPIL *****/
$call = "{call SP_CHECK_LOG_DUKCAPIL(?,?)}";
$params = array(
	array($prospect, SQLSRV_PARAM_IN),
	array($no_ktp, SQLSRV_PARAM_IN)
);
$options =  array("Scrollable" => "buffered");
$exec = sqlsrv_query($conn, $call, $params, $options) or die(print_r(sqlsrv_errors(), true));
$data = sqlsrv_fetch_array($exec);
$checkDukcapil = sqlsrv_num_rows($exec);
$id_log = $data['LOG_CHECK_BYSOURCE_ID'];

/***** CEK LOG ERROR *****/
$callChekLogError = "{call SP_CHECK_LOG_ERROR_DUKCAPIL(?)}";
$paramsChekLogError = array(
	array($id_log, SQLSRV_PARAM_IN)
);
$optionsChekLogError =  array("Scrollable" => "buffered");
$execChekLogError = sqlsrv_query($conn, $callChekLogError, $paramsChekLogError, $optionsChekLogError) or die(print_r(sqlsrv_errors(), true));
$checkLogError = sqlsrv_num_rows($execChekLogError);
/***** END CEK LOG ERROR *****/
?>

<div class="row">
	<?php
	if ($checkGetError > 0) {
		$Warning_Data = 'Silahkan lakukan pengkinian data ke dukcapil setempat';
	}

	if ($checkLogError > 0) {
		echo '<div class="col-md-12">
					<div class="alert alert-danger alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
						<strong>Perhatian !</strong> Silahkan lakukan pengkinian data ke dukcapil setempat
					</div>
				</div>';
	} else {
		if ($Warning_Data <> "") {
			echo '<div class="col-md-12">
						<div class="alert alert-danger alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
							<strong>Perhatian !</strong> ' . $Warning_Data . '
						</div>
					</div>';
		}
	}

	if ($dataDate['VOID'] == '1') {
		echo '<div class="alert alert-danger alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
		<strong>PERHATIAN <br>UNTUK PENGECEKAN SLIK DIMULAI PUKUL 09:00 - 17:00 WIB<br>
		</div>';
	}

	?>

	<div class="col-md-12">
		<?php if ($dataCheckedLog > 0) { ?>
			<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
				<strong>Perhatian !</strong><br>
				<strong>Nomor Order <?php echo $dataGetOrder['ORDER_NO']; ?> Sudah Pernah Melakukan Pengecekan Pefindo /
					Slik</strong><br>

			</div>
		<?php } ?>
		<?php if ($dataCheckedLogProspect > 0) { ?>
			<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
				<strong>Perhatian !</strong><br>
				<strong>Nomor Prospect <?php echo $prospect; ?> dan NIK : <?php echo $no_ktp; ?> Sudah Pernah Melakukan
					Pengecekan Pefindo / Slik</strong><br>
			<?php } ?>
			</div>

			<?php
			$no = 0;
			$callErr = "{call SP_GET_VALIDASI_DUKCAPIL_NEW(?,?)}";
			$paramErr =  array(
				array($prospect, SQLSRV_PARAM_IN),
				array($no_ktp, SQLSRV_PARAM_IN)
			);
			$execErr = sqlsrv_query($conn, $callErr, $paramErr) or die(print_r(sqlsrv_errors(), true));
			while ($dataErr = sqlsrv_fetch_array($execErr)) {
			?>
				<div class="alert alert-danger alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
					<h5 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> WARNING!</h5>
					Terdapat <?php echo $dataErr['MSG_NAME']; ?> <b></b>.
				</div>
			<?php } ?>
			<div class="card">
				<div class="header">
					<h4 class="title">Disdukcapil</h4>
					<p class="category">Pengecekan Disdukcapil</p>

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
											<th class="th-custom" style="color:#FFF;background-color:#035c7a;">Nomor Prospek
											</th>
											<th class="th-custom" style="color:#FFF;background-color:#035c7a;">Nomor KTP
											</th>
											<th class="th-custom" style="color:#FFF;background-color:#035c7a;">Nama Lengkap
											</th>
											<th class="th-custom" style="color:#FFF;background-color:#035c7a;">Tempat,
												Tanggal Lahir</th>
											<th class="th-custom" style="color:#FFF;background-color:#035c7a;">Alamat</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="td-custom">1</td>
											<td class="td-custom"><?php echo $prospect; ?></td>
											<td class="td-custom"><?php echo $no_ktp; ?></td>
											<td class="td-custom"><?php echo $nama; ?></td>
											<td class="td-custom"><?php echo "$birth_place, $date"; ?></td>
											<td class="td-custom"><?php echo $alamat; ?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<b>DATA DUKCAPIL :</b><br>
							<div class="table-responsive">
								<table class="table table-bordered" style="width:100%">
									<thead>
										<tr>
											<th class="th-custom" style="color:#FFF;background-color:#035c7a;">No</th>
											<th class="th-custom" style="color:#FFF;background-color:#035c7a;">Nomor KTP
											</th>
											<th class="th-custom" style="color:#FFF;background-color:#035c7a;">Nama Lengkap
											</th>
											<th class="th-custom" style="color:#FFF;background-color:#035c7a;">Tanggal Lahir
											</th>
											<th class="th-custom" style="color:#FFF;background-color:#035c7a;">Status
												Pengecekan</th>
											<th class="th-custom" style="color:#FFF;background-color:#035c7a;">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$callCheckDuk = "{call SP_GET_RESPONSE_RESULT_ERROR_DETAIL_DUKCAPIL(?,?)}";
										$paramCheckDuk = array(array($prospect, SQLSRV_PARAM_IN), array($no_ktp, SQLSRV_PARAM_IN));
										$execCheckDuk = sqlsrv_query($conn, $callCheckDuk, $paramCheckDuk) or die(print_r(sqlsrv_defaults(), true));
										$dataCheckDuk = sqlsrv_fetch_array($execCheckDuk);

										$resDukMessage = strtoupper($dataCheckDuk['MSG_NAME']);

										# verify if this data already checked or not
										$dukcapilVerified = ($checkDukcapil > 0 && $checkGetError == 0 && $dataCheckedLog == 0 && $dataCheckedLogProspect == 0);
										$stakeholderChecked = $dataIfAlreadyChecked["IS_CHECKED"] == 1;

										# hardcode 2023-03-17 : DUKCAPIL ERROR
										// $dukcapilVerified = true;
										?>

										<tr>
											<td style="text-align:center;">1</td>
											<td style="text-align:center;"><?= $no_ktp ?></td>
											<td style="text-align:center;"><?= $nama ?></td>
											<td style="text-align:center;"><?= $date ?></td>
											<td style="text-align:center;">
												<?= ($resDukMessage == "") ? "-" : $resDukMessage ?></td>
											<td style="text-align:center;">
												<form action="" method="post">
													<input name='prospect_no' type='hidden' value='<?php echo $prospect; ?>'>
													<input name='no_ktp' type='hidden' value='<?php echo $no_ktp; ?>'>
													<input name='name' type='hidden' value="<?php echo $nama; ?>">
													<input name='date' type='hidden' value='<?php echo $date; ?>'>
													<input name='birth_place' type='hidden' value='<?php echo $birth_place; ?>'>
													<input type="submit" class="btn btn-custom btn-xs" value="Check Dukcapil" name="check" onclick="return confirm('Apakah anda yakin ingin mengecek data ini? Pengecekan akan dikenakan biaya dan tercatat di log')" <?= $dukcapilVerified ? 'disabled' : '' ?>>
												</form>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div style="float:left;">
								<?php if ($dataDate['VOID'] == '1') : ?>

									<form action="" method="post">
										<input type="submit" class="btn btn-custom btn-xs" value="Request Slik" name="slik" onclick="return confirm('Apakah anda yakin ingin merequest data ini?')" disabled>
									</form>

								<?php elseif ($dataDate['VOID'] == '0' && $dukcapilVerified) : ?>

									<form action="" method="post">
										<input name='prospect_no' type='hidden' value='<?php echo $prospect; ?>'>
										<input name='no_ktp' type='hidden' value='<?php echo $no_ktp; ?>'>
										<input name='name' type='hidden' value="<?php echo $nama; ?>">
										<input name='date' type='hidden' value='<?php echo $date; ?>'>
										<input name='birth_place' type='hidden' value='<?php echo $birth_place; ?>'>
										<input type="submit" class="btn btn-custom btn-xs" value="Request Slik" name="slik" onclick="return confirm('Apakah anda yakin ingin merequest data ini?')" <?= $stakeholderChecked ? 'disabled' : '' ?>>
									</form>

								<?php endif; ?>
							</div>
						</div>
					</div>

					<!-- <div class="row">
						<div class="col-md-12">
							<pre>
								<?php // echo var_dump($resultDukcapil['content']); 
								?>
							</pre>
						</div>
					</div> -->

					<div class="row">
						<div class="col-md-12">
							<div class="text-danger" style="float:left; font-style:italic;">
								<?php if ($dukcapilVerified && $stakeholderChecked) : ?>
									*Data Sesuai dan sudah pernah melakukan Request Slik.
								<?php elseif ($dukcapilVerified) : ?>
									*Data Sesuai, Silahkan Cek Slik.
								<?php endif; ?>
							</div>
						</div>
					</div>
					<br>
				</div>
			</div>
	</div>
</div>