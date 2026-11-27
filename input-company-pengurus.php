<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
<?php
$error = "";
$date = date("Y-m-d");

// for file directory
// const BASE_URL = "http://172.16.2.5/h2h_pefindo/"; # OUTSIDE 2.5
// const BASE_URL = "http://10.10.30.61/pefindo/"; # LOCALHOST
const BASE_URL = ""; # INSIDE 2.5

const FILE_DIR = "assets/ktp/";

// extension reader
$is_image = array('gif', 'png', 'jpg', 'jpeg');

// retrive data
$prospect_no = $_POST['prospect_no'];
$order_no 	 = $_POST['order_no'];
$nik 		 = (isset($_POST['nik'])) ? $_POST['nik'] : '';
$action 	 = (isset($_POST['action'])) ? $_POST['action'] : 'ACTION_EDIT';


$call = "{call CPY_PEFINDO_GETDATA_DETAIL_PENGURUS_BY_ORDER (?, ?)}";
$param = array(
	array($order_no, SQLSRV_PARAM_IN),
	array($nik, SQLSRV_PARAM_IN),
);
$exec = sqlsrv_query($conn, $call, $param) or die(print_r(sqlsrv_errors(), true));
$data = sqlsrv_fetch_array($exec);

// // echo '<pre>';
// // var_dump($data);
// // echo '</pre>';
// // die();

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
	$new_nik 		= sanitizeInput($_POST['no_ktp']);
	$nama_lengkap 	= sanitizeInput($_POST['nama_lengkap']);
	$tanggal_lahir 	= sanitizeInput($_POST['tanggal_lahir']);
	$tempat_lahir 	= sanitizeInput($_POST['tempat_lahir']);
	$alamat 		= sanitizeInput($_POST['alamat']);

	if ($new_nik == "") {
		echo "<script>alert('Nomor KTP Pengurus Wajib Diisi');history.back();</script>";
	} else if ($nama_lengkap == "") {
		echo "<script>alert('Nama Pengurus Wajib Diisi');history.back();</script>";
	} else if ($tanggal_lahir == "") {
		echo "<script>alert('Tanggal Lahir Pengurus Wajib Diisi');history.back();</script>";
	} else if (strtotime($tanggal_lahir) === false) {
		echo "<script>alert('Pastikan Format Tanggal Lahir sudah benar');history.back();</script>";
	} else if ($tempat_lahir == "") {
		echo "<script>alert('Tempat Lahir Pengurus Wajib Diisi');history.back();</script>";
	} else {
		$savedName = null;

		if (isset($_FILES['foto_ktp']) && $fileName = $_FILES['foto_ktp']['name'] !== "" && isAllowedFile($_FILES['foto_ktp']['name'])) {
			$fileName 	= $_FILES['foto_ktp']['name'];
			$fileDir	= $_FILES['foto_ktp']['tmp_name'];
			$ranName	= explode(".", $fileName); //untuk mengambil nama file gambarnya saja tanpa format gambarnya
			$savedName	= round(microtime(true)) . '.' . end($ranName); //fungsi untuk membuat nama acak
		}

		// // $call = "{call CPY_PEFINDO_UPDATE_PENGURUS(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
		$call = "{call CPY_PEFINDO_UPDATE_PENGURUS_BY_ORDER(?, ?, ?, ?, ?, ?, ?, ?, ?)}";
		$param = array(
			array(sanitizeInput($order_no), SQLSRV_PARAM_IN),
			array(sanitizeInput($nik), SQLSRV_PARAM_IN),
			array(sanitizeInput($new_nik), SQLSRV_PARAM_IN),
			array(sanitizeInput($nama_lengkap), SQLSRV_PARAM_IN),
			array(sanitizeInput($tanggal_lahir), SQLSRV_PARAM_IN),
			array(sanitizeInput($tempat_lahir), SQLSRV_PARAM_IN),
			array(sanitizeInput($alamat), SQLSRV_PARAM_IN),
			array(sanitizeInput($savedName), SQLSRV_PARAM_IN),
			array(sanitizeInput($_GET['USERNAME']), SQLSRV_PARAM_IN)
		);

		$exec = sqlsrv_query($conn, $call, $param) or die(print_r(sqlsrv_errors(), true));

		if ($exec) {
			if (isset($savedName) && isset($fileDir)) {
				try {
					// ### check if is directory / directory is exist
					// #
					$dstfile = FILE_DIR . $savedName;
					if (!is_dir(FILE_DIR)) mkdir(dirname($dstfile), 0777, true);

					// ### copy files to directory
					// #
					copy($fileDir, $dstfile);

					// ### delete old files
					// #
					if ($data['FILE_SRC'] <> NULL) {
						unlink(FILE_DIR . $data['FILE_SRC']);
					}
				} catch (\Throwable $th) {
					//throw $th;
					//do nothing
				}
			}
			$submitted = true;
			echo "<script>alert('Data Berhasil Disimpan');</script>";
		} else {
			echo "<script>alert('Data Gagal Disimpan');history.back();</script>";
		}

		// var_dump([
		// 	'No. Prospek' => $prospect_no,
		// 	'Cust ID' => $id,
		// 	'Old NIK' => $nik,
		// 	'NIK' => $new_nik,
		// 	'Nama' => $nama_lengkap,
		// 	'Tanggal Lahir' => $tanggal_lahir,
		// 	'Tempat Lahir' => $tempat_lahir,
		// 	'Alamat' => $alamat,
		// 	'Gambar KTP' => $image
		// ]);
	}
}
?>
<style>
	.img-custom {
		width: 100%;
		height: 200px;
	}

	td {
		padding-right: 2rem;
	}
</style>

<link rel="stylesheet" href="assets/css/lightbox.css" type="text/css" media="screen" />

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="content">
				<div class="row">
					<div class="col-md-8 col-sm-12">
						<form action="" method="post" enctype="multipart/form-data">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DATA PENGURUS</td>
									</tr>
									<tr>
										<td style="width:50%;">Foto KTP</td>
										<td style="width:50%;">
											<?php if ($data['FILE_SRC'] <> NULL) { ?>
												<?php if (in_array(strtolower($data['FILE_TYPE']), $is_image)) : ?>
													<a href="<?= BASE_URL .FILE_DIR . $data['FILE_SRC'] ?>" data-lightbox="property">
														<img src="<?= BASE_URL . FILE_DIR . $data['FILE_SRC'] ?>" width="100%" class="img-custom">
													</a>
												<?php else : ?>
													<a href="<?= BASE_URL . FILE_DIR . $data['FILE_SRC'] ?>" class="btn theme-btn" style="margin:0px;padding:10px;font-size:12px;">View / Download</a>
												<?php endif; ?>
											<?php } else { ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											<div class="form-group" style="margin-top:5px;">
												<label style="color:#333;">UPLOAD FOTO KTP</label>
												<input type="file" id="foto_ktp" name="foto_ktp" onchange="fileValidation(this)">
											</div>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nomor KTP <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" onkeypress="return onlyNumber(event)" maxlength="16" class="form-control" placeholder="Nomor KTP" value="<?php echo htmlentities($data['ID_NO'], ENT_QUOTES, 'UTF-8'); ?>" required id="no_ktp" name="no_ktp" autocomplete="off" <?= $data['IS_VALID'] == 1 ? 'readonly' : '' ?> >
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nama Pengurus <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" class="form-control" placeholder="Nama Lengkap" value="<?php echo htmlentities($data['STAKEHOLDER_NAME'], ENT_QUOTES, 'UTF-8'); ?>" required id="nama_lengkap" name="nama_lengkap" autocomplete="off" maxlength="100">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Tempat, Tanggal Lahir <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<div class="row">
												<div class="col-md-6">
													<input type="text" class="form-control" placeholder="Tempat lahir" required id="tempat_lahir" value="<?php echo htmlentities($data['ACK_PLACE'], ENT_QUOTES, 'UTF-8'); ?>" name="tempat_lahir" autocomplete="off" maxlength="50">
												</div>
												<div class="col-md-6">
													<div class="input-group date">
														<?php if ($data['ACK_DT'] <> '') {
															$bDate = $data['ACK_DT']->format('Y-m-d');
														} else {
															$bDate = '';
														}
														?>
														<input type="text" class="form-control" placeholder="Tanggal Lahir" value="<?php echo $bDate; ?>" required id="tanggal_lahir" name="tanggal_lahir" autocomplete="off">
														<div class="input-group-addon">
															<span class="add-on"><i class="fa fa-calendar"></i></span>
														</div>
													</div>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Alamat</td>
										<td style="width:50%;">
											<input type="text" class="form-control" placeholder="Alamat Tinggal" required id="alamat" value="<?php echo htmlentities($data['CURRENT_ADDRESS'], ENT_QUOTES, 'UTF-8'); ?>" name="alamat" autocomplete="off" maxlength="150">
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
							<table>
								<tr>
									<td>
										<?= $error ?>
										<input type="hidden" name="prospect_no" value="<?= $prospect_no ?>" />
										<input type="hidden" name="order_no" value="<?= $order_no ?>" />
										<input type="hidden" name="nik" value="<?= $nik ?>" />
										<input type="hidden" name="action" value="<?= $action ?>" />
										<input type="submit" name="submit" class="btn btn-custom" value="SIMPAN DATA" style="width:200px;">
										</form>
									</td>
									<td>
										<form action="index.php?page=company-prospek-piloting&USERNAME=<?= $user ?>" method="post" id="formBack">
											<input type="hidden" name="prospect_no" value="<?= $prospect_no ?>">
											<input type="hidden" name="order_no" value="<?= $order_no ?>" />
											<input type="hidden" name="action" value="<?= $action ?>" />
											<button type="submit" class="btn btn-custom" style="width:200px;">KEMBALI</button>
										</form>
									</td>
								</tr>
							</table>
						</center>
						<br><br>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="assets/js/jqueryrotate.min.js"></script>

<script>
	const isSubmitComplete = <?= (isset($submitted)) ? $submitted : false ?>;

	$(document).ready(function() {
		if (isSubmitComplete) {
			$('#formBack').submit();
		}
	});
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
	$(document).ready(function() {
		$('#tanggal_lahir').datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			showButtonPanel: true,
			yearRange: '1900:2025',
			endDate: new Date()
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