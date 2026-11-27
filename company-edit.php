<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
<?php
$error = "";
$date = date("Y-m-d");

// for file directory
// const BASE_URL = "http://172.16.2.5/h2h_pefindo/"; # OUTSIDE 2.5
// const BASE_URL = "http://10.10.30.61/pefindo/"; # LOCALHOST
const BASE_URL = ""; # INSIDE 2.5

const FILE_DIR_NPWP = "assets/company/NPWP/";
const FILE_DIR_LO = "assets/company/LO/";
const FILE_DIR_FAPP = "assets/company/FAPP/";
const FILE_DIR_CC = "assets/company/CC/";

// extension reader
$is_image = array('gif', 'png', 'jpg', 'jpeg');

// passed variable
$user 		 = sanitizeInput($_GET['USERNAME']);
$prospect_no = sanitizeInput($_POST['prospect_no']);
$order_no 	 = sanitizeInput($_POST['order_no']);


# Periksa nomor order / prospect
$callExchange = "{call CPY_VALIDATE_ORDER_AND_PROSPECT(?, ?)}";
$paramExchange = array(
	array($prospect_no, SQLSRV_PARAM_IN),
	array($order_no, SQLSRV_PARAM_IN),
);
$execExchange = sqlsrv_query($conn, $callExchange, $paramExchange) or die(print_r(sqlsrv_errors(), true));
$dataExchange = sqlsrv_fetch_array($execExchange);

$prospect_no = $dataExchange['OUTPUT'];

# Kembali ke halaman sebelumnya, untuk refresh nomor order jadi nomor prospect
if ($dataExchange['IS_UPDATE'] == 1)
{
	echo "<script>history.back();</script>";
}

# Ambil data Company
$call = "{call CPY_PEFINDO_GETDATA_DETAIL_COMPANY(?)}";
$param = array(array($prospect_no, SQLSRV_PARAM_IN));
$exec = sqlsrv_query($conn, $call, $param) or die(print_r(sqlsrv_errors(), true));
$data = sqlsrv_fetch_array($exec);


# Periksa waktu request SLIK
$callDate = "{call SP_GET_DATE_SLIK}";
$execDate = sqlsrv_query($conn, $callDate) or die(print_r(sqlsrv_errors(), true));
$dataDate = sqlsrv_fetch_array($execDate);

// echo '<pre>';
// var_dump($data);
// echo '</pre>';
// die();

function getFileArr($fileInfo = '')
{
	$result = [
		'fileName' => null,
		'fileDir' => null,
		'ranName' => null,
		'savedName' => null,
	];

	if (isset($_FILES[$fileInfo]) && $_FILES[$fileInfo]['name'] !== "" && isAllowedFile($_FILES[$fileInfo]['name'])) {
		$result['fileName'] = $_FILES[$fileInfo]['name'];
		$result['fileDir'] = $_FILES[$fileInfo]['tmp_name'];
		$result['ranName'] = explode(".", $result['fileName']); //untuk mengambil nama file gambarnya saja tanpa format gambarnya
		$result['savedName'] = round(microtime(true)) . '.' . end($result['ranName']); //fungsi untuk membuat nama acak
	}

	return $result;
}

function moveFile($img_arr = [], $dir = '', $oldFile = '')
{
	/// $img_arr : berisi data file (seperti nama, path, dll)
	/// $dir : tempat file akan disimpan
	if (!is_null($img_arr) && isset($img_arr['savedName']) && isset($img_arr['fileDir'])) {
		// ### check if is directory / directory is exist
		// #
		$dstfile = $dir . $img_arr['savedName'];

		try {
			// ### create dir if not exist
			// #
			if (!is_dir($dir)) mkdir(dirname($dstfile), 0777, true);

			// ### copy files to dir
			// #
			copy($img_arr['fileDir'], $dstfile);

			// ### delete old files
			// #
			if ($oldFile <> NULL) {
				unlink($dir . $oldFile);
			}
		} catch (\Throwable $th) {
			// do nothing
		}
	}
}

function displayFile($_fileName, $_fileType, $_filePath, $_fileTitle)
{
	// extension reader
	$is_image = array('gif', 'png', 'jpg', 'jpeg');

	if ($_fileName <> NULL) {
		if (in_array(strtolower($_fileType), $is_image)) {
			$lightbox = '<a href="' . BASE_URL . $_filePath . '" ';
			$lightbox .= 'data-lightbox="property">';
			$lightbox .= '<button type="button" class="btn theme-btn" style="margin:0px;padding:10px;font-size:12px;"><i class="fa fa-image">';
			$lightbox .= "</i>Foto $_fileTitle</button></a>";

			echo $lightbox;
		} else {
			echo '<a href="' . BASE_URL . $_filePath . '" target="_blank" class="btn theme-btn" style="margin:0px;padding:10px;font-size:12px;">File ' . $_fileTitle . '</a>';
		}
	}
}

function isAllowedFile($name) {
    $n = strrpos($name, '.');
    $ext = ($n === false) ? '' : substr($name, $n+1);
	$allowedExt = array("jpg", "jpeg", "pdf", "png");

	if (!in_array($ext, $allowedExt)) {
		die('file yang anda upload tidak diizinkan!');
	}

	return true;
}

function sanitizeInput($input)
{
	# hanya mengizinkan alphanumeric, titik, underscore, strip dan spasi.
	return preg_replace("/[^a-zA-Z0-9._,\s-]+/", "", trim($input));
}

if (isset($_POST['submit'])) {

	# Define Variable
	$cust_id 		 = sanitizeInput($_POST['cust_id']);
	$npwp 		 	 = sanitizeInput($_POST['npwp']);
	$nama_perusahaan = sanitizeInput($_POST['nama_perusahaan']);
	$tgl_didirikan 	 = sanitizeInput($_POST['tanggal_pendirian']);
	$tmpt_didirikan  = sanitizeInput($_POST['tempat_pendirian']);

	if ($npwp == "") {
		echo "<script>alert('NPWP Wajib Diisi');history.back();</script>";
	} else if ($nama_perusahaan == "") {
		echo "<script>alert('Nama Perusahaan Wajib Diisi');history.back();</script>";
	} else if ($tgl_didirikan == "") {
		echo "<script>alert('Tanggal Didirikan Wajib Diisi');history.back();</script>";
	} else if ($tmpt_didirikan == "") {
		echo "<script>alert('Tempat Didirikan Wajib Diisi');history.back();</script>";
	} else {
		// image array
		$file_npwp = getFileArr('file_npwp');
		$file_lo = getFileArr('file_lo');
		$file_fapp = getFileArr('file_fapp');
		$file_cc = getFileArr('file_cc');

		$call = "{call CPY_PEFINDO_UPDATE_DETAIL_COMPANY_REV_1(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
		$param = array(
			array(sanitizeInput($prospect_no), SQLSRV_PARAM_IN),
			array(sanitizeInput($order_no), SQLSRV_PARAM_IN),
			array(sanitizeInput($cust_id), SQLSRV_PARAM_IN),
			array(sanitizeInput($npwp), SQLSRV_PARAM_IN),
			array($nama_perusahaan, SQLSRV_PARAM_IN),
			array($tgl_didirikan, SQLSRV_PARAM_IN),
			array($tmpt_didirikan, SQLSRV_PARAM_IN),
			array(sanitizeInput($file_npwp['savedName']), SQLSRV_PARAM_IN),
			array(sanitizeInput($file_lo['savedName']), SQLSRV_PARAM_IN),
			array(sanitizeInput($file_fapp['savedName']), SQLSRV_PARAM_IN),
			array(sanitizeInput($file_cc['savedName']), SQLSRV_PARAM_IN),
			array(sanitizeInput($_GET['USERNAME']), SQLSRV_PARAM_IN)
		);
		$exec = sqlsrv_query($conn, $call, $param) or die(print_r(sqlsrv_errors(), true));

		if ($exec) {
			// move file(s)
			moveFile($file_npwp, FILE_DIR_NPWP, $data['FILE_NPWP']);
			moveFile($file_lo, FILE_DIR_LO, $data['FILE_LO']);
			moveFile($file_fapp, FILE_DIR_FAPP, $data['FILE_FAPP']);
			moveFile($file_cc, FILE_DIR_CC, $data['FILE_CC']);

			echo "<script>
				if (!sessionStorage.getItem('reloaded')) {
					sessionStorage.setItem('reloaded', 'true');
					alert('Data Berhasil Disimpan');
					window.location.reload();
				} else {
					sessionStorage.removeItem('reloaded');
				}
			</script>";

		} else {
			echo "<script>alert('Data Gagal Disimpan');history.back();</script>";
		}
	}
}

# Request SLIK ketika dokumen sudah lengkap
else  if (isset($_POST['slik'])) {
	
	# Define Variable
	$npwp 		 	 = sanitizeInput($_POST['npwp']);
	$nama_perusahaan = sanitizeInput($_POST['nama_perusahaan']);
	$tgl_didirikan 	 = sanitizeInput($_POST['tanggal_pendirian']);
    $id_type 		 = 'NPWP';

    # Tambah data ke tasklist
    $callInsert = "{call CPY_INSERT_TASKLIST(?, ?, ?, ?, ?, ?, ?, ?, ?)}";
    $paramInsert = array(
        array($prospect_no, SQLSRV_PARAM_IN),
        array($npwp, SQLSRV_PARAM_IN),
        array($nama_perusahaan, SQLSRV_PARAM_IN),
        array(date("Y-m-d", strtotime($tgl_didirikan)), SQLSRV_PARAM_IN),
        array('COMPANY', SQLSRV_PARAM_IN),
        array($id_type, SQLSRV_PARAM_IN),
        array($user, SQLSRV_PARAM_IN),
        array('801', SQLSRV_PARAM_IN),
        array('21', SQLSRV_PARAM_IN)
    );
    $execInsert = sqlsrv_query($conn, $callInsert, $paramInsert) or die(print_r(sqlsrv_errors(), true));

    # Update status is_checked menjadi 1 pada table M_STAKEHOLDER
    $callSPUpdateChecked = "{call CPY_UPDATE_CHECKED_DATA(?,?,?,?)}";
    $paramsUpdateChecked = array(
        array($prospect_no, SQLSRV_PARAM_IN),
        array($npwp, SQLSRV_PARAM_IN),
        array($id_type, SQLSRV_PARAM_IN),
        array($user, SQLSRV_PARAM_IN)
    );
    $execUpdateChecked = sqlsrv_query($conn, $callSPUpdateChecked, $paramsUpdateChecked) or die(print_r(sqlsrv_errors(), true));

    echo "<script>alert('Data Berhasil Terkirim ke tasklist');window.location.reload();'</script>";
}

?>
<style>
	.img-custom {
		width: 100%;
		height: 200px;
	}
</style>

<link rel="stylesheet" href="assets/css/lightbox.css" type="text/css" media="screen" />

<div class="row">
	<?php if ($dataDate['VOID'] == '1') : ?>
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
            <strong>PERHATIAN <br>UNTUK PENGECEKAN SLIK DIMULAI PUKUL 09:00 - 17:00 WIB<br>
        </div>
    <?php endif; ?>

	<div class="col-md-12">
		<div class="card">
			<div class="content">
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<div class="table-responsive">
							<form action="" method="post" enctype="multipart/form-data" id="form_company">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DATA PERUSAHAAN</td>
									</tr>
									<tr>
										<td style="width:50%;">No Prospek <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="no_prospek" id="no_prospek" class="form-control" placeholder="Nomor Prospek" value="<?= htmlentities($prospect_no, ENT_QUOTES, 'UTF-8'); ?>" disabled>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">No Identitas <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="npwp" id="npwp" onkeypress="return onlyNumber(event)" maxlength="16" class="form-control" placeholder="No Identitas" value="<?= htmlentities($data['ID_NO'], ENT_QUOTES, 'UTF-8'); ?>" required autocomplete="off" <?= $data['IS_VALID'] == 1 ? 'readonly' : '' ?> pattern="[0-9]*">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nama Perusahaan <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="nama_perusahaan" id="nama_perusahaan" class="form-control" placeholder="Nama Perusahaan" value="<?= htmlentities($data['STAKEHOLDER_NAME'], ENT_QUOTES, 'UTF-8'); ?>" required autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Tanggal Pendirian <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<div class="input-group date">
												<?php $est = $data['ACK_DT'] <> '' ? $data['ACK_DT']->format('Y-m-d') : ''; ?>
												
												<input type="text" name="tanggal_pendirian" id="tanggal_pendirian" class="form-control" placeholder="Tanggal Pendirian" value="<?= htmlentities($est, ENT_QUOTES, 'UTF-8'); ?>" required autocomplete="off">
												<div class="input-group-addon">
													<span class="add-on"><i class="fa fa-calendar"></i></span>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Tempat Pendirian <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="tempat_pendirian" id="tempat_pendirian" class="form-control" placeholder="Tempat Pendirian" value="<?= htmlentities($data['ACK_PLACE'], ENT_QUOTES, 'UTF-8'); ?>" required autocomplete="off" maxlength="50">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Tipe <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<?php $tipe = ($data['STAKEHOLDER_TYPE'] == 'C') ? 'PERUSAHAAN' : 'undefined stakeholder type.'; ?>
											<input type="text" name="tipe" id="tipe" class="form-control" placeholder="Tipe" required value="<?= htmlentities($tipe, ENT_QUOTES, 'UTF-8'); ?>" autocomplete="off" readonly>
										</td>
									</tr>
								</table>
						</div>
					</div>
					<div class="col-md-6 col-sm-12">
						<div class="table-responsive">
							<table class="table">
								<tr>
									<td style="width:50%;">
										<div class="form-group" style="margin-top:5px;">
											<label style="color:#333;">UPLOAD FOTO NPWP</label>
											<input type="file" name="file_npwp" onchange="fileValidation(this)">
										</div>
									</td>
									<td align="right">
										<?php displayFile($data['FILE_NPWP'], $data['FILE_TYPE_NPWP'], FILE_DIR_NPWP . $data['FILE_NPWP'], 'NPWP Perusahaan'); ?>
									</td>
								</tr>
								<tr>
									<td style="width:50%;">
										<?php # if ($data['IS_DUKCAPIL_FINISH'] == '1') : ?>
											<div class="form-group" style="margin-top:5px;">
												<label style="color:#333;">UPLOAD LEGAL OPINION (LO)
											</label>
												<input type="file" name="file_lo" onchange="fileValidation(this)">
												<small class="form-text text-muted">
													*WAJIB DIUPLOAD, jika akan mengajukan RAK.
												</small>
											</div>
										<?php # endif; ?>
									</td>
									<td align="right">
										<?php displayFile($data['FILE_LO'], $data['FILE_TYPE_LO'], FILE_DIR_LO . $data['FILE_LO'], 'LO'); ?>
									</td>
								</tr>
								<tr>
									<td style="width:50%;">
										<div class="form-group" style="margin-top:5px;">
											<label style="color:#333;">UPLOAD FAPP COMPANY</label>
											<input type="file" name="file_fapp" onchange="fileValidation(this)">
										</div>
									</td>
									<td align="right">
										<?php displayFile($data['FILE_FAPP'], $data['FILE_TYPE_FAPP'], FILE_DIR_FAPP . $data['FILE_FAPP'], 'FAPP Perusahaan'); ?>
									</td>
								</tr>
								<tr>
									<td style="width:50%;">
										<div class="form-group" style="margin-top:5px;">
											<label style="color:#333;">UPLOAD CUSTOMER CONSENT</label>
											<input type="file" name="file_cc" onchange="fileValidation(this)">
											<small class="form-text text-muted">
												<a href="assets/company/customer_consent.docx" download="draft_customer_consent"><b>Download</b> Draft Customer Consent</a>
											</small>
										</div>
									</td>
									<td align="right">
										<?php displayFile($data['FILE_CC'], $data['FILE_TYPE_CC'], FILE_DIR_CC . $data['FILE_CC'], 'Customer Consent'); ?>
									</td>
								</tr>

								<tr>
									<td align="right">
										<?= $error ?>
										<input type="hidden" name="cust_id" value="<?= $data['CUST_ID'] ?>">
										<input type="hidden" name="prospect_no" value="<?= $prospect_no ?>">
										<input type="hidden" name="order_no" value="<?= $order_no ?>">
										<input type="submit" name="submit" class="btn btn-custom" value="SIMPAN DATA" style="width:200px;">
										</form>
									</td>
									<td>
										<form action="index.php?page=company-prospek-piloting&USERNAME=<?= $user ?>" method="post" id="formBack">
											<input type="hidden" name="prospect_no" value="<?= $prospect_no ?>">
											<input type="hidden" name="order_no" value="<?= $order_no ?>">
											<input type="hidden" name="action" value="<?= (isset($_POST['action'])) ? $_POST['action'] : 'ACTION_EDIT'; ?>">
											<button type="submit" class="btn btn-custom" style="width:200px;">KEMBALI</button>
										</form>
									</td>
								</tr>

								<tr>
									<td colspan="2">
										<?php
											# Pastikan data belum pernah di-request
											$callSlik = "{call CPY_CHECK_REQUEST_SLIK(?, ?)}";
											$paramSlik = array(
												array($prospect_no, SQLSRV_PARAM_IN),
												array($data['ID_NO'], SQLSRV_PARAM_IN),
											);
											$execSlik = sqlsrv_query($conn, $callSlik, $paramSlik, array("Scrollable" => "buffered")) or die(print_r(sqlsrv_errors(), true));
											$rowSlik = sqlsrv_num_rows($execSlik);

											# data yang sudah direquest ke HO tidak dapat direquest kembali
											$isRequested = $rowSlik > 0;
										?>

										<?php if ($dataDate['VOID'] == '0' && $data['IS_FILE_COMPLETE'] == '1') : ?>

											<form action="" method="post">
												<input type="hidden" name="prospect_no" value="<?php echo $prospect_no; ?>">
												<input type="hidden" name="order_no" value="<?php echo $order_no; ?>">
												<input type="hidden" name="npwp" value="<?php echo htmlentities($data['ID_NO'], ENT_QUOTES, 'UTF-8'); ?>">
												<input type="hidden" name="nama_perusahaan" value="<?php echo htmlentities($data['STAKEHOLDER_NAME'], ENT_QUOTES, 'UTF-8'); ?>">
												<input type="hidden" name="tanggal_pendirian" value="<?php echo $est; ?>">
												<button type="submit" id="slik_action" name="slik" style="display:none" />
												<button type="button" id="slik" class="btn btn-custom btn-xs" onclick="act_request_slik()" <?= $isRequested ? "disabled" : '' ?>>REQUEST SLIK</button>
											</form>

										<?php endif; ?>
										
										<?php if ($isRequested) : ?>
											<div class="text-danger" style="float:left; font-style:italic;">
												*Sudah melakukan Request SLIK.
											</div>
										<?php endif; ?>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>

				<?php if ($dataDate['VOID'] == '0' && $data['IS_FILE_COMPLETE'] == '1' && !$isRequested) : ?>

					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td width="1rem">
											<input type="checkbox" id="checkbox_confirmed" required>
										</td>
										<td>
											<b>Saya menyatakan, document yang diupload sudah lengkap dan terverifikasi sesuai dengan aturan yang berlaku.<b>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>

				<?php endif; ?>

				<hr>
			</div>
		</div>
	</div>
</div>


<script src="assets/js/jqueryrotate.min.js"></script>

<script>
	$(document).ready(function() {
		$('#tanggal_pendirian').datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			showButtonPanel: true,
			yearRange: '1900:2050',
			endDate: new Date()
		});
	});

	function act_request_slik() {
		var data = $('#form_company').serialize();
		$('#checkbox_confirmed').prop('required', true);

		if (!$('#checkbox_confirmed').is(':checked')) {
			alert('Harap centang pernyataan terlebih dahulu!');
		} else {
			// Konfirmasi sebelum submit form
			var confirmed = confirm('Apakah anda yakin ingin merequest data ini?');
			if (confirmed) {
				// Jika konfirmasi benar, submit form
				$('#slik_action').click();
			}
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

	function fileValidation(param) {
		var allowedExtensions = /(\.jpg|\.jpeg|\.pdf|\.png)$/i;
		var filePath = param.value;
		var input = param;
		var file = input.files[0];

		// Allowing file type 
		if (!allowedExtensions.exec(filePath)) {
			alert('Invalid file type!');
			param.value = '';
			return false;
		} else if (file.size > 7168000) {
			alert('Max 7Mb');
			param.value = '';
			return false;
		}

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