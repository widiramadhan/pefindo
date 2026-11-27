<?php
date_default_timezone_set('Asia/Jakarta');

// for file directory
// const BASE_URL = "http://172.16.2.5/h2h_pefindo/"; # OUTSIDE 2.5
// const BASE_URL = "http://10.10.30.61/pefindo/"; # LOCALHOST
const BASE_URL = ""; # INSIDE 2.5

const FILE_DIR_NPWP = "assets/company/NPWP/";
const FILE_DIR_LO = "assets/company/LO/";
const FILE_DIR_FAPP = "assets/company/FAPP/";
const FILE_DIR = "assets/ktp/";

function displayFile($_fileName, $_fileType, $_filePath, $_fileTitle)
{
	// extension reader
	$is_image = array('gif', 'png', 'jpg', 'jpeg');

	if ($_fileName <> NULL) {
		if (in_array(strtolower($_fileType), $is_image)) {			
			$lightbox = '<a href="' . BASE_URL . $_filePath . '" ';

			$lightbox .= 'data-lightbox="property">';
			$lightbox .= '<button type="button" class="btn btn-custom btn-xs img-polaroid" style="width:180px;"><i class="fa fa-image">';
			$lightbox .= "</i>Foto $_fileTitle</button></a>";

			echo $lightbox;
		} else {
			echo '<a href="' . BASE_URL . $_filePath . '" target="_blank" class="btn btn-custom btn-xs img-polaroid" style="width:180px;">File ' . $_fileTitle . '</a>';
		}
	}
}

$id = $_GET['id'];
$prospect = $_GET['prospect_no'];
$id_no = $_GET['id_no'];
$name = $_GET['name'];
$ack_date = $_GET['ack_date'];
$ack_place = $_GET['ack_place'];
$tipe_cust = $_GET['tipe_cust'];
$userlogin = $_GET['USERNAME'];
$startDate = date("Y-m-d H:i:s");


# Periksa nomor IDEB yang sudah ter-generate
$callGenerate = "{call SP_GENERATE_SLIK_GETDATA_DEBITUR(?,?)}";
$paramGenerate = array(
	array($prospect, SQLSRV_PARAM_IN),
	array($id_no, SQLSRV_PARAM_IN)
);
$execGenerate = sqlsrv_query($conn, $callGenerate, $paramGenerate) or die(print_r(sqlsrv_errors(), true));
$dataGenerate = sqlsrv_fetch_array($execGenerate);

if (isset($_POST['submit_col'])) {
	// // $id = $_POST['id'];
	// // $ack_date = $_POST['ack_date'];
	// // $ack_place = $_POST['ack_place'];
	// // $tipe_cust = $_POST['tipe_cust'];
	// // $startDate = date("Y-m-d H:i:s");

	// // $name = $_POST['name'];
	// // $prospect = $_POST['prospect_no'];
	// // $id_no = $_POST['id_no'];
	// // $userlogin = $_GET['USERNAME'];

	$kategori = $_POST['kategori'];
	$branch_id = $_POST['branch_id'];
	$inquiryDate = date("Y-m-d");

	# Generate nomor IDEB
	$callGen = "{call SP_GENERATE_DEBSLIK_INSERT_DEBITUR_H2H(?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramGen = array(
		array('1', SQLSRV_PARAM_IN),
		array($kategori, SQLSRV_PARAM_IN),
		array($branch_id, SQLSRV_PARAM_IN),
		array($tipe_cust, SQLSRV_PARAM_IN),
		array($inquiryDate, SQLSRV_PARAM_IN),
		array($name, SQLSRV_PARAM_IN),
		array('01', SQLSRV_PARAM_IN),
		array($prospect, SQLSRV_PARAM_IN),
		array('', SQLSRV_PARAM_IN),
		array($id_no, SQLSRV_PARAM_IN),
		array('', SQLSRV_PARAM_IN),
		array($userlogin, SQLSRV_PARAM_IN),
		array('1', SQLSRV_PARAM_IN)
	);

	$execGen = sqlsrv_query($conn, $callGen, $paramGen) or die(print_r(sqlsrv_errors(), true));
	$dataGen = sqlsrv_fetch_array($execGen);

	# Agar muncul setelah di-submit
	$callGenerate = "{call SP_GENERATE_SLIK_GETDATA_DEBITUR(?,?)}";
	$paramGenerate = array(
		array($prospect, SQLSRV_PARAM_IN),
		array($id_no, SQLSRV_PARAM_IN)
	);
	$execGenerate = sqlsrv_query($conn, $callGenerate, $paramGenerate) or die(print_r(sqlsrv_errors(), true));
	$dataGenerate = sqlsrv_fetch_array($execGenerate);
}

// // if (strpos($prospect, 'PRS') !== false) {
	$securityDeposit = "0";

	$callBranch = "{call SP_GET_BRANCH_STATUS_PROSPECT(?,?)}";
	$paramBranch = array(array($prospect, SQLSRV_PARAM_IN), array('PROSPECT_NO', SQLSRV_PARAM_IN));
	$execBranch = sqlsrv_query($conn, $callBranch, $paramBranch) or die(print_r(sqlsrv_errors(), true));
	$dataBranch = sqlsrv_fetch_array($execBranch);

	# detail pengurus
	$call = "{call CPY_PEFINDO_GETDATA_DETAIL_PENGURUS(?,?,?)}";
	$param = array(
		array($prospect, SQLSRV_PARAM_IN),
		array(0, SQLSRV_PARAM_IN),
		array($id_no, SQLSRV_PARAM_IN),
	);
	$exec = sqlsrv_query($conn, $call, $param) or die(print_r(sqlsrv_errors(), true));
	$data = sqlsrv_fetch_array($exec);
// // } else {
// // 	if ($dataBranch['OFFICE_CODE'] == "1025" || $dataBranch['OFFICE_CODE'] == "1535") {
// // 		$securityDeposit = "1";
// // 	} else {
// // 		$securityDeposit = "0";
// // 	}
// // 	$callBranch = "{call SP_GET_BRANCH_STATUS_PROSPECT(?,?)}";
// // 	$paramBranch = array(array($prospect, SQLSRV_PARAM_IN), array('ORDER_NO', SQLSRV_PARAM_IN));
// // 	$execBranch = sqlsrv_query($conn, $callBranch, $paramBranch) or die(print_r(sqlsrv_errors(), true));
// // 	$dataBranch = sqlsrv_fetch_array($execBranch);
// // }


// // /***** CEK DUKCAPIL *****/
// // $callDuk = "{call SP_CHECK_LOG_DUKCAPIL(?,?)}";
// // $paramsDuk = array(
// // 	array($prospect, SQLSRV_PARAM_IN),
// // 	array($id_no, SQLSRV_PARAM_IN)
// // );
// // $options =  array("Scrollable" => "buffered");
// // $execDuk = sqlsrv_query($conn, $callDuk, $paramsDuk, $options) or die(print_r(sqlsrv_errors(), true));
// // $dataDuk = sqlsrv_fetch_array($execDuk);
// // $checkDukcapil = sqlsrv_num_rows($execDuk);
// // $id_log = $dataDuk['LOG_CHECK_BYSOURCE_ID'];

// // /***** CEK LOG ERROR *****/
// // $callChekLogError = "{call SP_CHECK_LOG_ERROR_DUKCAPIL(?)}";
// // $paramsChekLogError = array(
// // 	array($id_log, SQLSRV_PARAM_IN)
// // );
// // $optionsChekLogError =  array("Scrollable" => "buffered");
// // $execChekLogError = sqlsrv_query($conn, $callChekLogError, $paramsChekLogError, $optionsChekLogError) or die(print_r(sqlsrv_errors(), true));
// // $checkLogError = sqlsrv_num_rows($execChekLogError);
// // /***** END CEK LOG ERROR *****/


# cek status terakhir pengecekan slik
# kemudian update menjadi on proggress jika masih open

$callLastSLIK = "{call SP_CHECK_STATUS_SLIK(?)}";
$paramLastSLIK = array(array($id, SQLSRV_PARAM_IN));
$execLastSLIK = sqlsrv_query($conn, $callLastSLIK, $paramLastSLIK) or die(print_r(sqlsrv_errors(), true));
$dataLastSLIK = sqlsrv_fetch_array($execLastSLIK);

if ($dataLastSLIK['SUB_PARAM_ID'] != 22 || $dataLastSLIK['SUB_PARAM_ID'] != 23) {

	# update progres jika SUB_PARAM_ID 21 (Open) atau 24 (Reject)
	$callUpdateDukcapil = "{call SP_UPDATE_DUKCAPIL_HOLD(?,?,?)}";
	$paramUpdateDukcapil = array(
		array($prospect, SQLSRV_PARAM_IN),
		array($id_no, SQLSRV_PARAM_IN),
		array('22', SQLSRV_PARAM_IN)
	);
	$execUpdateDukcapil = sqlsrv_query($conn, $callUpdateDukcapil, $paramUpdateDukcapil) or die(print_r(sqlsrv_errors(), true));
}

# detail performa pengerjaan SLIK
$callGetPerformance = "{call SP_GET_PERFORMANCE_ACTIVITY(?)}";
$paramGetPerfomance = array(array($id, SQLSRV_PARAM_IN));
$optionGetPerformance = array("Scrollable" => "buffered");
$execGetPerformance = sqlsrv_query($conn, $callGetPerformance, $paramGetPerfomance, $optionGetPerformance) or die(print_r(sqlsrv_errors(), true));
$numrowsGetPerformance = sqlsrv_num_rows($execGetPerformance);

$callInsertPerformance = "{call SP_INSERT_PERFORMANCE_ACTIVITY(?,?,?,?)}";
$paramInsertPerformance = array(array($id, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN), array($startDate, SQLSRV_PARAM_IN), array(NULL, SQLSRV_PARAM_IN));
$execInsertPerformance = sqlsrv_query($conn, $callInsertPerformance, $paramInsertPerformance) or die(print_r(sqlsrv_errors(), true));

# cek data fasilitas SLIK yang masih berlaku (1 bulan) berdasarkan CREATE_DATE
if ($tipe_cust == "PENGURUS") {
	$callFasilitas = "{call PGRS_CHECK_FASILITAS_SLIK_COMPANY(?)}";
} elseif ($tipe_cust == "COMPANY") {
	$callFasilitas = "{call CPY_CHECK_FASILITAS_SLIK_COMPANY(?)}";
}
$paramFasilitas = array(array($id_no, SQLSRV_PARAM_IN));
$optionFasilitas = array("Scrollable" => "buffered");
$execFasilitas = sqlsrv_query($conn, $callFasilitas, $paramFasilitas, $optionFasilitas) or die(print_r(sqlsrv_errors(), true));
$dataFasilitas =  sqlsrv_fetch_array($execFasilitas);
$checkFasilitas = sqlsrv_num_rows($execFasilitas);

# tampilkan reject notes
$callReject = "{call SP_GET_REJECT_NOTES(?,?,?)}";
$paramReject = array(
	array($prospect, SQLSRV_PARAM_IN),
	array($id_no, SQLSRV_PARAM_IN),
	array($id, SQLSRV_PARAM_IN)
);
$optionReject = array("Scrollable" => "buffered");
$execReject = sqlsrv_query($conn, $callReject, $paramReject, $optionReject) or die(print_r(sqlsrv_errors(), true));
$numrowsReject = sqlsrv_num_rows($execReject);

# periksa request AFA
$callAfa = "{call SP_GET_NOTES_AFA_UNLOCK(?,?)}";
$paramAfa = array(
	array($prospect, SQLSRV_PARAM_IN),
	array($id_no, SQLSRV_PARAM_IN)
);
$optionAfa = array("Scrollable" => "buffered");
$execAfa = sqlsrv_query($conn, $callAfa, $paramAfa, $optionAfa) or die(print_r(sqlsrv_errors(), true));
$dataAfa = sqlsrv_fetch_array($execAfa);
$numrowsAfa = sqlsrv_num_rows($execAfa);

?>

<style>
	.title-content {
		font-size: 18px;
		font-weight: bold;
		color: #035c7a;
	}

	.sub-title-content {
		font-size: 14px;
		font-weight: bold;
		color: #035c7a;
	}
</style>

<link rel="stylesheet" href="assets/css/lightbox.css" type="text/css" media="screen" />
<div class="row">
	<div class="col-md-12">

		<?php if ($checkFasilitas > 0) { ?>
			<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
				<strong>Customer ini pernah melakukan pengecekan SLIK pada tanggal <?= ($dataFasilitas['TANGGAL_CHECK'] <> NULL) ? $dataFasilitas['TANGGAL_CHECK']->format("d F Y") : '' ?>
					User yang mengecek <?php echo $dataFasilitas['USER_CHECK'] . "<br>"; ?> </strong><br>

			</div>
		<?php } ?>

		<?php if ($numrowsAfa > 0) { ?>
			<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
				<strong>Pengajuan ini sudah Request by AFA <br>
					NOTES : <?php echo $dataAfa['NOTES']; ?><br>
					Dibuat pada tanggal <?php if ($dataAfa['CREATE_DATE'] <> NULL) {
											echo $dataAfa['CREATE_DATE']->format("d F Y");
										} ?> </strong><br>
			</div>
		<?php } ?>

		<?php if ($securityDeposit == "1") { ?>
			<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
				<strong>Pengajuan ini sudah Request by AFA Penggunaan Security Deposit Dealer NSCB <br>
			</div>
		<?php } ?>

		<div class="card">
			<div class="header">
				<h4 class="title">Detail Informasi</h4>
				<p class="category">Informasi Detail untuk prospek</p>
				<hr>
			</div>
			<div class="content">
				<div class="">
					<div class="row">
						<div class="col-md-6">
							<div class="table-responsive">
								<table class="table table-bordered table-striped" style="width:100%;">
									<tr>
										<td colspan="3" style="color:#FFF;background-color:#035c7a;font-weight:bold;"><?= $tipe_cust ?></td>
									</tr>
									<tr>
										<td>Nomor Prospek / Nomor Order</td>
										<td>:</td>
										<td><?php echo strtoupper($prospect); ?></td>
									</tr>


									<?php if ($tipe_cust == "PENGURUS") : ?>
										<tr>
											<td>Nomor Identitas (KTP)</td>
											<td>:</td>
											<td><?php echo strtoupper($data['ID_NO']); ?></td>
										</tr>
										<tr>
											<td>Nama Lengkap</td>
											<td>:</td>
											<td><?php echo strtoupper($data['STAKEHOLDER_NAME']); ?></td>
										</tr>
										<tr>
											<td>Tempat, Tanggal Lahir</td>
											<td>:</td>
											<td><?php
												$ack_place = $data['ACK_PLACE'];
												$ack_date = ($data['ACK_DT'] <> NULL) ? $data['ACK_DT']->format("d-m-Y") : '';

												echo strtoupper("{$ack_place}, {$ack_date}");
												?></td>
										</tr>
										<tr>
											<td>Alamat</td>
											<td>:</td>
											<td><?php echo strtoupper($data['CURRENT_ADDRESS']); ?></td>
										</tr>


									<?php elseif ($tipe_cust == "COMPANY") : ?>
										<tr>
											<td>Nomor Identitas (NPWP)</td>
											<td>:</td>
											<td><?php echo strtoupper($data['ID_NO']); ?></td>
										</tr>
										<tr>
											<td>Nama Perusahaan</td>
											<td>:</td>
											<td><?php echo strtoupper($data['STAKEHOLDER_NAME']); ?></td>
										</tr>
										<tr>
											<td>Tahun Pendirian</td>
											<td>:</td>
											<td><?php echo ($data['ACK_DT'] <> NULL) ? $data['ACK_DT']->format("d-m-Y") : ''; ?></td>
										</tr>
										<tr>
											<td>Alamat</td>
											<td>:</td>
											<td><?php echo strtoupper($data['ACK_PLACE']); ?></td>
										</tr>
									<?php endif; ?>

								</table>
							</div>
						</div>


						<?php
						// get Company ID / NPWP
						$callCompany = "{call CPY_PEFINDO_GET_COMPANY_ID(?)}";
						$paramCompany = array(
							array($prospect, SQLSRV_PARAM_IN),
						);
						$execCompany = sqlsrv_query($conn, $callCompany, $paramCompany) or die(print_r(sqlsrv_errors(), true));
						$dataCompany = sqlsrv_fetch_array($execCompany);
						$npwp = $dataCompany['ID_NO'];
						$idCompany = $dataCompany['CUST_ID'];

						// pass Company ID / NPWP to get company detail
						$callCompanyDetail = "{call CPY_PEFINDO_GETDATA_DETAIL_COMPANY(?)}";
						$paramCompanyDetail = array(array($prospect, SQLSRV_PARAM_IN));
						$execCompanyDetail = sqlsrv_query($conn, $callCompanyDetail, $paramCompanyDetail) or die(print_r(sqlsrv_errors(), true));
						$dataCompanyDetail = sqlsrv_fetch_array($execCompanyDetail);

						// var_dump($dataCompany);
						// var_dump($dataCompanyDetail);
						?>

						<div class="col-md-6">
							<div class="table-responsive">
								<table class="table table-bordered" style="width:100%;">
									<tr>
										<td colspan="3" style="color:#FFF;background-color:#035c7a;font-weight:bold;">DOKUMEN</td>
									</tr>
									<tr>
										<td>NPWP PERUSAHAAN</td>
										<td>:</td>
										<td>
											<?php displayFile($dataCompanyDetail['FILE_NPWP'], $dataCompanyDetail['FILE_TYPE_NPWP'], FILE_DIR_NPWP . $dataCompanyDetail['FILE_NPWP'], 'NPWP Perusahaan'); ?>
										</td>
									</tr>
									<tr>
										<td>LEGAL OPINION (LO)</td>
										<td>:</td>
										<td>
											<?php displayFile($dataCompanyDetail['FILE_LO'], $dataCompanyDetail['FILE_TYPE_LO'], FILE_DIR_LO . $dataCompanyDetail['FILE_LO'], 'LO'); ?>
										</td>
									</tr>
									<tr>
										<td>FAPP PERUSAHAAN</td>
										<td>:</td>
										<td>
											<?php displayFile($dataCompanyDetail['FILE_FAPP'], $dataCompanyDetail['FILE_TYPE_FAPP'], FILE_DIR_FAPP . $dataCompanyDetail['FILE_FAPP'], 'FAPP Perusahaan'); ?>
										</td>
									</tr>
									<?php if ($tipe_cust == "PENGURUS") : ?>
										<tr>
											<td>KTP PENGURUS</td>
											<td>:</td>
											<td>
												<?php displayFile($data['FILE_SRC'], $data['FILE_TYPE'], FILE_DIR . $data['FILE_SRC'], 'KTP Pengurus'); ?>
											</td>
										</tr>
									<?php endif; ?>
								</table>
							</div>


							<div id="reject_note">
								<hr>
								<b>Reject Notes</b><br>
								<?php
								while ($dataReject = sqlsrv_fetch_array($execReject)) { ?>
									<label>REJECTED BY : </label>
									<p class="category"><b><?php echo strtoupper($dataReject['USER_REJECT']) . "</b> - " . $dataReject['CREATE_NOTE']->format("d F Y H:i:s"); ?></p>
									<label>NOTES : </label>
									<p class="category"><?php echo $dataReject['NOTES']; ?></p>


								<?php } ?>
							</div>
							<hr>
							<b>Note :</b><br>
							<i>
								* Jika foto tidak dapat dilihat, maka foto tidak ada di database<br>
								* Check lewat SLIK dengan data berikut<br>
								* Upload hasil SLIK pada form dibawah ini<br>
								* Pilih submit jika hasil SLIK sudah diupload<br>
								* Pilih reject jika informasi yang ditampilkan kurang lengkap<br>
							</i>
							<hr>


							<b>GENERATE NO IDEB :</b><br>
							<form action="" method="post">
								<input name='kategori' type='hidden' value='<?php echo $dataBranch['KATEGORI']; ?>'>
								<input name='branch_id' type='hidden' value='<?php echo $dataBranch['OFFICE_CODE']; ?>'>

								<?php if ($dataGenerate['IDEB_NO'] == NULL) { ?>
									<input type="submit" value="Generate" class="btn btn-custom" name="submit_col">
								<?php } ?>
							</form>
							<input name='no_ideb' type='text' class='form-control' value='<?php echo $dataGenerate['IDEB_NO']; ?>'>
							<hr>


							<b>Upload hasil SLIK (PDF)</b>

							<?php
							switch ($tipe_cust) {
								case 'PENGURUS':
									$uploadSlikAction = "pages/action-upload-slik-pengurus.php";
									$slikNotFoundLink = "pages/slik-not-found-pengurus.php?USERNAME=$user&id=$id&no=$prospect";
									$pefindoCheckingMenu = "<li><a href=\"#\" onclick=\"document.getElementById('pefindo').submit();\">Cek Pefindo</a></li>";
									break;
								case 'COMPANY':
									$uploadSlikAction = "pages/action-upload-slik-company.php";
									$slikNotFoundLink = "pages/slik-not-found-company.php?USERNAME=$user&id=$id&no=$prospect";
									$pefindoCheckingMenu = "<li><a href=\"#\" onclick=\"document.getElementById('pefindo_company').submit();\">Cek Pefindo</a></li>";
									break;
								default:
									$uploadSlikAction = "#";
									break;
							}
							?>

							<form action="<?= $uploadSlikAction ?>" method="post" enctype="multipart/form-data" id="myForm">
								<input type="hidden" name="mapping_id" value="<?php echo $id; ?>">
								<input type="hidden" name="prospect_no" value="<?php echo $prospect; ?>">
								<input type="hidden" name="id_no" value="<?php echo $id_no; ?>">
								<input type="hidden" name="user" value="<?php echo $userlogin; ?>">

								<div class="form-group">
									<!-- <input type="file" name="file" class="form-control" disabled> -->
									<br>
									<b>Upload Fasilitas (Txt)</b>
									<input type="file" name="slik" id="slik" class="form-control">
									<br>
									<input type="checkbox" name="notFound" id="notFound" onclick="myFunction()"> &nbsp;<b><label style="font-size:14px;color:black;">Data tidak ditemukan di SLIK</label></b>
									<input type="hidden" name="notFound" id="notFound2" value="">
								</div>
							</form>

							<form action="index.php?page=company-stakeholder-check-pefindo&USERNAME=<?php echo $user; ?>" method="post" id="pefindo">
								<input type="hidden" name="id" value='<?php echo $id; ?>'>
								<input type="hidden" name="prospect_no" value='<?php echo $prospect; ?>'>
								<input type="hidden" name="no_ktp" value='<?php echo $data['ID_NO']; ?>'>
								<input type="hidden" name="name" value="<?php echo $data['STAKEHOLDER_NAME']; ?>">
								<input type="hidden" name="date" value="<?php echo ($data['ACK_DT'] <> NULL) ? $data['ACK_DT']->format("Y-m-d") : ''; ?>">
								<input type="hidden" name="tipe_cust" value='<?php echo $tipe_cust; ?>'>
							</form>

							<form action="index.php?page=company-check-piloting&USERNAME=<?php echo $user; ?>" method="post" id="pefindo_company">
								<input type="hidden" name="prospect_no" value="<?php echo $prospect; ?>">
								<input type="hidden" name="npwp" value="<?php echo $data['ID_NO']; ?>">
								<input type="hidden" name="name" value="<?php echo $data['STAKEHOLDER_NAME']; ?>">
								<input type="hidden" name="est" value="<?php echo ($data['ACK_DT'] <> NULL) ? $data['ACK_DT']->format("d-m-Y") : '-'; ?>">
							</form>

							<div class="">
								<div class="dropdown">
									<button class="btn btn-custom btn-sm dropdown-toggle" type="button" data-toggle="dropdown" style="width:100%;">ACTION
										<span class="caret"></span></button>
									<ul class="dropdown-menu">
										<?php echo $pefindoCheckingMenu; # untuk menampilkan menu cek PEFINDO untuk pengurus ?>
										<li class=""><a href="#" onclick="document.getElementById('myForm').submit();">Submit hasil SLIK</a></li>
										<li class=""><a href="index.php?page=slik-note-company&USERNAME=<?php echo $user; ?>&id=<?php echo $id; ?>">Reject request</a></li>
										<li class=""><a href="<?= $slikNotFoundLink ?>">Data tidak ditemukan di SLIK</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="assets/js/jqueryrotate.min.js"></script>


<script>
	var checker = document.getElementById('notFound');
	var sendbtn = document.getElementById('slik');
	checker.onchange = function() {
		sendbtn.disabled = !!this.checked;
	};

	function myFunction() {
		var checkBox = document.getElementById("notFound");
		var text = document.getElementById("notFound2");

		if (checkBox.checked == true) {
			text.value = "1";
		} else {
			text.value = "";
		}
	}

	var j = jQuery.noConflict();
	j(document).ready(function() {
		j(".fancybox").fancybox();
	});
</script>

<script>
	// // function alertdukcapil() {
	// // 	if (confirm('Apakah anda yakin ingin mengecek data ini? Pengecekan akan dikenakan biaya dan tercatat di log')) {
	// // 		document.getElementById('ff').submit();
	// // 	};
	// // }

	// // function alertdukcapilPenjamin() {
	// // 	if (confirm('Apakah anda yakin ingin mengecek data ini? Pengecekan akan dikenakan biaya dan tercatat di log')) {
	// // 		document.getElementById('formJaminanDukcapil').submit();
	// // 	};
	// // }

	// // function checkdukcapil() {
	// // 	document.getElementById('ff').submit();
	// // }

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
				// return "Image " + curImageNum + " of " + albumSize;
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