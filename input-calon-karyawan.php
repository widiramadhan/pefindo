   <script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script> 
<?php
$callGet = "{call SP_GET_REQ_ID_GENERATE}";
$execGet = sqlsrv_query( $conn, $callGet) or die( print_r( sqlsrv_defaults(), true)); 
$dataGet = sqlsrv_fetch_array($execGet);


  $error="";
$req_id = $dataGet['REQ_ID'];
$date = date("Y-m-d");

$call2 = "{call SP_GET_IMG_KARYAWAN_BARU(?)}";
$param2 = array(array($req_id, SQLSRV_PARAM_IN));
$exec2 = sqlsrv_query( $conn, $call2,$param2)  or die( print_r( sqlsrv_errors(), true));
$data2 = sqlsrv_fetch_array($exec2);

function prepareImageDBString($filepath){
	$output = 'null';
	$handle = @fopen($filepath, 'rb');
	if ($handle){
		$content = @fread($handle, filesize($filepath));
		$content = bin2hex($content);
		@fclose($handle);
		$output = "0x".strtoupper($content);
	}
	return $output;
}

if(isset($_FILES['foto_ktp']['name'])){
	$output = prepareImageDBString($_FILES['foto_ktp']['tmp_name']);
	//echo $output;
	
	$req_id = $_POST['req_id'];
	$images = $output;
	$type = "FOTO KTP";
	$user = $_GET['USERNAME'];
	
	$call = "{call  SP_UPDATE_IMAGES_KARYAWAN_BARU(?,?,?,?)}";
	$param = array(array($req_id, SQLSRV_PARAM_IN),
					array($images, SQLSRV_PARAM_IN),
					array($type, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));

	echo"<script>window.location='index.php?USERNAME=".$user."&page=input-calon-karyawan'</script>";
}

if(isset($_FILES['foto_kk']['name'])){
	$output = prepareImageDBString($_FILES['foto_kk']['tmp_name']);
	//echo $output;
	
	$req_id = $_POST['req_id'];
	$images = $output;
	$type = "FOTO KK";
	$user = $_GET['USERNAME'];
	
	$call = "{call  SP_UPDATE_IMAGES_KARYAWAN_BARU(?,?,?,?)}";
	$param = array(array($req_id, SQLSRV_PARAM_IN),
					array($images, SQLSRV_PARAM_IN),
					array($type, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));

	echo"<script>window.location='index.php?USERNAME=".$user."&page=input-calon-karyawan'</script>";
}

if(isset($_FILES['foto_npwp']['name'])){
	$output = prepareImageDBString($_FILES['foto_npwp']['tmp_name']);
	//echo $output;
	
		$req_id = $_POST['req_id'];
	$images = $output;
	$type = "FOTO NPWP";
	$user = $_GET['USERNAME'];
	
	$call = "{call  SP_UPDATE_IMAGES_KARYAWAN_BARU(?,?,?,?)}";
	$param = array(array($req_id, SQLSRV_PARAM_IN),
					array($images, SQLSRV_PARAM_IN),
					array($type, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));

	echo"<script>window.location='index.php?USERNAME=".$user."&page=input-calon-karyawan'</script>";
}


if(isset($_POST['submit'])){
	$no_regist = $_POST['no_regist'];
	$req_id = $dataGet['REQ_ID'];

	$ktp_pemohon=$_POST['ktp_pemohon'];
	$nama_karyawan=$_POST['nama_karyawan'];
	$tgl_pemohon=$_POST['tgl_pemohon'];
	$alamat=$_POST['alamat'];
	$nama_ibu_pemohon=$_POST['nama_ibu_pemohon'];
	$status_pemohon=$_POST['status_pemohon'];
	
	if($ktp_pemohon == ""){
		echo"<script>alert('Nomor KTP Pemohon Wajib Diisi');history.back();</script>";
	}else if($nama_karyawan == ""){
		echo"<script>alert('Nomor Nama Pemohon Wajib Diisi');history.back();</script>";
	}else if($tgl_pemohon == ""){
		echo"<script>alert('Nomor Tanggal Lahir Pemohon Wajib Diisi');history.back();</script>";
	}else if($nama_ibu_pemohon == ""){
		echo"<script>alert('Nomor Nama Ibu Pemohon Wajib Diisi');history.back();</script>";
	}else{
		
		$callFound = "{call SP_CHECK_INPUT_DATA_KARYAWAN(?)}";
		$paramFound = array(array($no_regist, SQLSRV_PARAM_IN));
		$execFound = sqlsrv_query( $conn, $callFound, $paramFound) or die( print_r( sqlsrv_errors(), true)); 
		$dataFound = sqlsrv_fetch_array($execFound);
		
		if($dataFound['FOUND'] == "YES"){
		echo"<script>alert('Data ini sudah di input dalam 1 bulan terakhir');history.back();</script>";
		exit();
		}
		//pemohon 
		$call = "{call SP_INSERT_DATA_KARYAWAN_BARU_TASKLIST(?,?,?,?,?,?,?,?,?)}";
		$param = array(	array($req_id, SQLSRV_PARAM_IN),
						array($no_regist, SQLSRV_PARAM_IN),
						array($ktp_pemohon, SQLSRV_PARAM_IN),
						array($nama_karyawan, SQLSRV_PARAM_IN),
						array($tgl_pemohon, SQLSRV_PARAM_IN),
						array($alamat, SQLSRV_PARAM_IN),
						array($nama_ibu_pemohon, SQLSRV_PARAM_IN),
						array($status_pemohon, SQLSRV_PARAM_IN),
						array($_GET['USERNAME'], SQLSRV_PARAM_IN));
		$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
	
		
		if($exec){
			//update status jadi on progress
			

			echo"<script>alert('Data Berhasil Disimpan');window.location='index.php?USERNAME=".$_GET['USERNAME']."'</script>";
		}else{
			echo"<script>alert('Data Gagal Disimpan');history.back();</script>";
		}
	}
}
?>
<style>
.img-custom{
	width:100%;
	height:200px;
}
</style>
<!--<form action="" method="post">-->

	<link rel="stylesheet" href="assets/css/lightbox.css" type="text/css" media="screen" />
	 
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="content">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DATA CALON KARYAWAN</td>
									</tr>
									<tr>
										<td style="width:50%;">Nomor Regist <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="no_regist" class="form-control" placeholder="Nomor KTP" value="<?php ?>" required id="no_regist" onkeyup="function_no_regist(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nomor KTP <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="ktp_pemohon" onkeypress="return onlyNumber(event)" maxlength="16" class="form-control" placeholder="Nomor KTP" value="" required id="ktp_pemohon" onkeyup="function_ktp_pemohon(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nama Karyawan <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="nama_karyawan" class="form-control" placeholder="Nama karyawan" value="" required id="nama_karyawan" onkeyup="function_nama_karyawan(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Tanggal Lahir <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<div class="input-group date">
												<input type="text" name="tgl_pemohon" class="form-control" placeholder="Tanggal Lahir" value="" required id="tgl_pemohon" onchange="function_tgl_pemohon(this.value)" autocomplete="off">
												<div class="input-group-addon">
													<span class="add-on"><i class="fa fa-calendar"></i></span>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Alamat<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="alamat" class="form-control" placeholder="alamat" required id="alamat" value="" onkeyup="function_alamat(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nama Ibu Kandung <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="nama_ibu_pemohon" class="form-control" placeholder="Nama Ibu Kandung" required id="ibu_pemohon" value="" onkeyup="function_ibu_pemohon(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Status Kawin <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<select class="form-control" name="status_kawin_pemohon"  id="status_pemohon" onchange="function_status_pemohon(this.value)">
												<option value="MAR">KAWIN</option>
												<option value="SIN">SINGLE</option>
												<option value="DIV" >CERAI</option>
												<option value="WID" >DUDA/JANDA</option>
											</select>
										</td>
									</tr>
								</table>
							</div>								
						</div>
						
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DOKUMEN</td>
									</tr>
										<tr>
										<td style="width:50%;">Foto KTP</td>
										<td style="width:50%;">
											<?php if($data2['FOTO_KTP'] <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_KTP']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_KTP']);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											<form action="" method="post" enctype="multipart/form-data">
												<input type="hidden" name="req_id"  value="<?php echo $req_id;?>">
												<div class="form-group" style="margin-top:5px;">
													<label style="color:#333;">Ganti Foto</label>
													<input type="file" name="foto_ktp" onchange="submit()">
												</div>
											</form>
										</td>
										
									</tr>
									<tr>
										<td style="width:50%;">Foto Kartu Keluarga</td>
										<td style="width:50%;">
											<?php if($data2['FOTO_KK'] <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_KK']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_KK']);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											<form action="" method="post" enctype="multipart/form-data">
												<input type="hidden" name="req_id"  value="<?php echo $req_id;?>">
												<div class="form-group" style="margin-top:5px;">
													<label style="color:#333;">Ganti Foto</label>
													<input type="file" name="foto_kk" onchange="submit()">
												</div>
											</form>
										</td>
									</tr>
								
											<tr>
										<td style="width:50%;">Foto NPWP</td>
										<td style="width:50%;">
											<?php if($data2['FOTO_NPWP'] <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_NPWP']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_NPWP']);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											<form action="" method="post" enctype="multipart/form-data">
												<input type="hidden" name="req_id"  value="<?php echo $req_id;?>">
												<div class="form-group" style="margin-top:5px;">
													<label style="color:#333;">Ganti Foto</label>
													<input type="file" name="foto_npwp" onchange="submit()">
												</div>
											</form>
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
								<form action="" method="post">
								
									<input type="hidden" name="ktp_pemohon" id="ktp_pemohon2">
									<input type="hidden" name="nama_karyawan" id="nama_karyawan2">
									<input type="hidden" name="tgl_pemohon" id="tgl_pemohon2">
									<input type="hidden" name="nama_ibu_pemohon" id="ibu_pemohon2">
									<input type="hidden" name="status_pemohon" id="status_pemohon2">
									<input type="hidden" name="no_regist" id="no_regist2">
									<input type="hidden" name="alamat" id="alamat2">
									
									<?php echo $error;?>
									<input type="submit" name="submit" class="btn btn-custom" value="SIMPAN DATA" style="width:200px;">
									<a href="index.php?page=input-calon-karyawan&USERNAME=<?php echo $user;?>" class="btn btn-custom" style="width:200px;">BATAL</a>
									
								</form>
							</center>
							<br><br>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!--</form>-->
<script src="assets/js/jqueryrotate.min.js"></script>
<script>
$(document).ready(function() {
	 var ktp_pemohon = $("#ktp_pemohon").val();
	 $("#ktp_pemohon2").val(ktp_pemohon);
	 var nama_karyawan = $("#nama_karyawan").val();
	 $("#nama_karyawan2").val(nama_karyawan);
	 var tgl_pemohon = $("#tgl_pemohon").val();
	 $("#tgl_pemohon2").val(tgl_pemohon);
	 var ibu_pemohon = $("#ibu_pemohon").val();
	 $("#ibu_pemohon2").val(ibu_pemohon);
	 var status_pemohon = $("#status_pemohon").val();
	 $("#status_pemohon2").val(status_pemohon);
	 
	 var no_regist = $("#no_regist").val();
	 $("#no_regist2").val(no_regist);
	 var alamat = $("#alamat").val();
	 $("#alamat2").val(alamat);

});


function function_ktp_pemohon(value){ document.getElementById("ktp_pemohon2").value = value;}
function function_nama_karyawan(value){ document.getElementById("nama_karyawan2").value = value;}
function function_tgl_pemohon(value){ document.getElementById("tgl_pemohon2").value = value;}
function function_ibu_pemohon(value){ document.getElementById("ibu_pemohon2").value = value;}
function function_status_pemohon(value){ document.getElementById("status_pemohon2").value = value;}

function function_no_regist(value){ document.getElementById("no_regist2").value = value;}
function function_alamat(value){ document.getElementById("alamat2").value = value;}

</script>
<script>
$( document ).ready(function() {   
	$('#tgl_pemohon').datepicker({
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
function onlyNumber(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;
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
        
            $($cont).rotate({ animateTo:value});
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

