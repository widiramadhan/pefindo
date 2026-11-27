<?php
date_default_timezone_set('Asia/Jakarta');

//$id=$_POST['no_ktp'];
$req_id=$_GET['req_id'];
$req_id1=$_GET['req_id1'];
$getUsername=$_GET['USERNAME'];

$startDate=date("Y-m-d H:i:s");



$callKar = "{call SP_GET_DATA_KARYAWAN_SLIK(?)}";
$paramKar = array(array($req_id, SQLSRV_PARAM_IN));
$execKar = sqlsrv_query( $conn, $callKar,$paramKar)  or die( print_r( sqlsrv_errors(), true));
$dataKar = sqlsrv_fetch_array($execKar);

$nik=$dataKar['ID_NO'];
$nama=$dataKar['CALON_KARYAWAN_NAME'];
$no_regist = $dataKar['NOMOR_REGIST'];
if($dataKar['BIRTH_DATE']<>NULL){$birth_date = $dataKar['BIRTH_DATE']->format("d F Y");}else{$birth_date="";}
$alamat = $dataKar['ALAMAT'];
$mother_name = $dataKar['MOTHER_NAME'];
$status_kawin = $dataKar['STATUS_KAWIN'];



	$callGenerate = "{call SP_GENERATE_SLIK_GETDATA_DEBITUR(?,?)}";
	$paramGenerate = array(array($no_regist, SQLSRV_PARAM_IN),
						 array($nik, SQLSRV_PARAM_IN));
	$execGenerate = sqlsrv_query( $conn, $callGenerate, $paramGenerate) or die( print_r( sqlsrv_errors(), true));
	$dataGenerate = sqlsrv_fetch_array($execGenerate);
	

if(isset($_POST['submit_col']) ){
	
	
	$nik=$dataKar['ID_NO'];
	$nama=$dataKar['CALON_KARYAWAN_NAME'];
	$no_regist = $dataKar['NOMOR_REGIST'];
	if($dataKar['BIRTH_DATE']<>NULL){$birth_date = $dataKar['BIRTH_DATE']->format("d F Y");}else{$birth_date="";}

	//$date=$_POST['date'];
	
	$getUsername=$_GET['USERNAME'];
	$startDate=date("Y-m-d H:i:s");
	$inquiryDate=date("Y-m-d");
	
	$kategori = '10';

	
	$callBranch = "{call SP_GENERATE_DEBSLIK_INSERT_DEBITUR_H2H(?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramBranch = array(array('1', SQLSRV_PARAM_IN),
						 array($kategori, SQLSRV_PARAM_IN),
						 array('1000', SQLSRV_PARAM_IN),
						 array('PERSONAL', SQLSRV_PARAM_IN),
						 array($inquiryDate, SQLSRV_PARAM_IN),
						 array($nama, SQLSRV_PARAM_IN),
						 array('01', SQLSRV_PARAM_IN),
						 array($no_regist, SQLSRV_PARAM_IN),
						 array('', SQLSRV_PARAM_IN),	 
					     array($nik, SQLSRV_PARAM_IN),
						 array('', SQLSRV_PARAM_IN),
						 array($getUsername, SQLSRV_PARAM_IN),
						 array('1', SQLSRV_PARAM_IN));
	
	$execBranch = sqlsrv_query( $conn, $callBranch, $paramBranch) or die( print_r( sqlsrv_errors(), true));
	$dataBranch = sqlsrv_fetch_array($execBranch);
	
		

	$callGenerate = "{call SP_GENERATE_SLIK_GETDATA_DEBITUR(?,?)}";
	$paramGenerate = array(array($no_regist, SQLSRV_PARAM_IN),
						 array($nik, SQLSRV_PARAM_IN));
	$execGenerate = sqlsrv_query( $conn, $callGenerate, $paramGenerate) or die( print_r( sqlsrv_errors(), true));
	$dataGenerate = sqlsrv_fetch_array($execGenerate);
	
}

	$call = "{call SP_GET_IMG_KARYAWAN_BARU(?)}";
	$param = array(array($req_id1, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));
	$data = sqlsrv_fetch_array($exec);


	$callStat = "{call SP_UPDATE_SLIK_RESULT_NEW_MAPPING(?,?)}";
	$paramStat = array(array($req_id, SQLSRV_PARAM_IN),array(3, SQLSRV_PARAM_IN));
	$execStat = sqlsrv_query( $conn, $callStat, $paramStat) or die( print_r( sqlsrv_defaults(), true)); 

$call3 = "{call SP_GET_PERFORMANCE_ACTIVITY_NEW_MAPPING(?)}";
$param3 = array(array($req_id, SQLSRV_PARAM_IN));
$option3 = array( "Scrollable" => "buffered" );
$exec3 = sqlsrv_query($conn, $call3, $param3, $option3) or die( print_r( sqlsrv_errors(), true));
$numrows3 = sqlsrv_num_rows($exec3);

	$call4 = "{call SP_INSERT_PERFORMANCE_ACTIVITY_NEW_MAPPING(?,?,?,?)}";
	$param4 = array(array($req_id, SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN),array($startDate, SQLSRV_PARAM_IN),array(NULL, SQLSRV_PARAM_IN));
	$exec4 = sqlsrv_query($conn, $call4, $param4) or die( print_r( sqlsrv_errors(), true));
	



?>
<style>
.title-content{
	font-size:18px;
	font-weight:bold;
	color:#035c7a;
}
.sub-title-content{
	font-size:14px;
	font-weight:bold;
	color:#035c7a;
}
</style>

<link rel="stylesheet" href="assets/css/lightbox.css" type="text/css" media="screen" />
<div class="row">
    <div class="col-md-12">

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
										<td colspan="3" style="color:#FFF;background-color:#035c7a;font-weight:bold;">Data</td>
									</tr>
									<tr>
										<td>Nomor Regist</td>
										<td>:</td>
										<td><?php echo strtoupper($no_regist);?></td>
									</tr>
									<tr>
										<td>Nomor Identitas (KTP)</td>
										<td>:</td>
										<td><?php echo strtoupper($nik);?></td>
									</tr>
									<tr>
										<td>Nama</td>
										<td>:</td>
										<td><?php echo strtoupper($nama);?></td>
									</tr>
									<tr>
										<td>Tanggal Lahir</td>
										<td>:</td>
										<td><?php echo strtoupper($birth_date);?></td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td>:</td>
										<td><?php echo strtoupper($alamat);?></td>
									</tr>
									<tr>
										<td>Nama Ibu Kandung</td>
										<td>:</td>
										<td><?php echo strtoupper($mother_name);?></td>
									</tr>
									<tr>
										<td>Status Kawin</td>
										<td>:</td>
										<td><?php echo strtoupper($status_kawin);?></td>
									</tr>
								</table>
							</div>
					
						</div>
						<div class="col-md-6">
							<div class="table-responsive">
								<table class="table table-bordered" style="width:100%;">
									<tr>
										<td colspan="3" style="color:#FFF;background-color:#035c7a;font-weight:bold;">DOKUMEN</td>
									</tr>
									<tr>
										<td>KTP Pemohon</td>
										<td>:</td>
										<td>
											<a href="data:image/jpeg;base64,<?php echo base64_encode($data['FOTO_KTP']);?>" data-lightbox="property">
												<button type="button" class="btn btn-custom btn-xs img-polaroid" style="width:180px;"><i class="fa fa-image"></i> Foto KTP </button>
											</a>
										</td>
									</tr>
									
									<tr>
										<td>Kartu Keluarga (KK)</td>
										<td>:</td>
										<td>
											<a href="data:image/jpeg;base64,<?php echo base64_encode($data['FOTO_KK']);?>" data-lightbox="property">
												<button type="button" class="btn btn-custom btn-xs img-polaroid" style="width:180px;"><i class="fa fa-image"></i> Kartu Keluarga (KK)</button>
											</a>
										</td>
									</tr>
								<tr>
										<td>NPWP</td>
										<td>:</td>
										<td>
											<a href="data:image/jpeg;base64,<?php echo base64_encode($data['FOTO_NPWP']);?>" data-lightbox="property">
												<button type="button" class="btn btn-custom btn-xs img-polaroid" style="width:180px;"><i class="fa fa-image"></i> NPWP</button>
											</a>
										</td>
									</tr>
								</table>
							</div>
						
							
							<b>GENERATE NO IDEB :</b><br>
							<form action="" method="post">
							
								<?php IF($dataGenerate['IDEB_NO']==NULL){ ?>
							<input type="submit" value="Generate" class="btn btn-primary" name="submit_col">
								<?php } ?>
							</form>
							<input name='no_ideb' type='text' class='form-control' value='<?php echo $dataGenerate['IDEB_NO'];?>'>
							<hr>
					
								<form action="pages/action-upload-slik-karyawan.php" method="post" enctype="multipart/form-data" id="myForm">
							
								<input type="hidden" name="req_id" value="<?php echo $req_id;?>"> 
								<input type="hidden" name="nomor_regist" value="<?php echo $no_regist;?>"> 
								<input type="hidden" name="no_ktp" value="<?php echo $nik;?>"> 
								<input type="hidden" name="user" value="<?php echo $getUsername;?>"> 
								<input type="hidden" name="tipe" id="tipe" value="KARYAWAN" >
							<div class="form-group">
							<b>Upload hasil SLIK (PDF)</b>
												<input type="file" name="file" class="form-control" >
												<br>
													<b>Upload Fasilitas (Txt)</b>
												<input type="file" name="slik" id="slik" class="form-control" >
												<br>
												<input type="checkbox" name="notFound" id="notFound"  onclick="myFunction()"> &nbsp;<b><label  style="font-size:14px;color:black;">Data tidak ditemukan di SLIK</label></b>
													<input type="hidden" name="notFound" id="notFound2" value="">
								
												
								
								
								
								</div>
								</form>
					
								<div class="">
									<div class="dropdown">
										<button class="btn btn-custom btn-sm dropdown-toggle" type="button" data-toggle="dropdown" style="width:100%;">ACTION
										<span class="caret"></span></button>
										<ul class="dropdown-menu">
										
								
									
												<!--<input type="submit" class="btn btn-custom btn-xs" value="Lanjutkan">-->
									
										
												<!--<li><a href="#" onclick="alertdukcapil();">Cek Dukcapil</a></li>-->
											
												
						
														<li class=""><a href="#" onclick="document.getElementById('myForm').submit();">Submit hasil SLIK</a></li>
											
														<li class=""><a href="index.php?page=slik-note-new-mapping&USERNAME=<?php echo $user;?>&id=<?php echo $req_id;?>&flag=2">Reject request</a></li>
														
										
									
											
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
  
  if (checkBox.checked == true){
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

function alertdukcapil()
{
if (confirm('Apakah anda yakin ingin mengecek data ini? Pengecekan akan dikenakan biaya dan tercatat di log')){
	 document.getElementById('ff').submit();
};
}
function alertdukcapilPenjamin()
{
if (confirm('Apakah anda yakin ingin mengecek data ini? Pengecekan akan dikenakan biaya dan tercatat di log')){
	 document.getElementById('formJaminanDukcapil').submit();
};
}
function checkdukcapil()
{
   document.getElementById('ff').submit();
}
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