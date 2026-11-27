<?php
/*$id = $_GET['id'];*/
$date = date("Y-m-d");
$nik=$_GET['nik'];
$prospect=$_GET['prospect'];
$id=$_GET['id'];
$call = "{call  SP_GET_PENGKINIAN_DATA_BY_NIK(?)}";
$param = array(array($nik, SQLSRV_PARAM_IN));
$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
$data = sqlsrv_fetch_array($exec);

$call1 = "{call  SP_GET_UNLOCK_REJECT(?)}";
$param1 = array(array($id, SQLSRV_PARAM_IN));
$options1 =  array( "Scrollable" => "buffered" );
$exec1 = sqlsrv_query( $conn, $call1, $param1,$options1) or die( print_r( sqlsrv_errors(), true)); 
$numrows2 = sqlsrv_num_rows($exec1);


if(isset($_POST['upload'])){
	$src=$_FILES['resi']['name'];
	$src1=$_FILES['kk']['name'];
	$output = prepareImageDBString($_FILES['resi']['tmp_name']);
	$output1 = prepareImageDBString($_FILES['kk']['tmp_name']);
	$images = $output;
	$images1 = $output1;
	$type = "FOTO BUKTI";
	$user = $_GET['USERNAME'];
	//echo $src;
	$call = "{call  SP_INSERT_IMAGES_DUKCAPIL_KK(?,?,?,?)}";
	$param = array(
					array($nik, SQLSRV_PARAM_IN),
					array($images, SQLSRV_PARAM_IN),
					array($images1, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));
	
	
	$callHold = "{call SP_GET_CHECK_SOURCE_DETAIL_STATUS_REJECT(?,?,?)}";
	$paramHold = array(array($id, SQLSRV_PARAM_IN),
					array($prospect, SQLSRV_PARAM_IN),
					array($nik, SQLSRV_PARAM_IN));
	$optionsHold =  array( "Scrollable" => "buffered" );
	$execHold = sqlsrv_query( $conn, $callHold, $paramHold, $optionsHold) or die( print_r( sqlsrv_errors(), true));
	$dataHold = sqlsrv_fetch_array($execHold);
	$checkHold=sqlsrv_num_rows($execHold);
	
	if($checkHold > 0){
		$callInsertStat = "{call SP_INSERT_STATUS_UNLOCK_DUKCAPIL(?,?,?,?,?)}";
		$paramsInsertStat = array(array($id, SQLSRV_PARAM_IN),array($data['PROSPECT_NO'], SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN), array('0', SQLSRV_PARAM_IN));
		$execInsertStat = sqlsrv_query( $conn, $callInsertStat, $paramsInsertStat) or die( print_r( sqlsrv_errors(), true));
		
	}
	
	if($exec){
		echo"<script>alert('Data berhasil disimpan');window.location='index.php?USERNAME=".$user."&page=pengkinian-data-dukcapil'</script>";
	}else{
		echo"<script>alert('Data gagal disimpan');history.back();</script>";
	}

}

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
?>

<style type="text/css">
.container {
  padding: 50px 200px;
}
.box {
  position: relative;
  background: #ffffff;
  width: 100%;
}
.box-header {
  color: #444;
  display: block;
  padding: 10px;
  position: relative;
  border-bottom: 1px solid #f4f4f4;
  margin-bottom: 10px;
}
.box-tools {
  position: absolute;
  right: 10px;
  top: 5px;
}
.dropzone-wrapper {
  border: 2px dashed #91b0b3;
  color: #92b0b3;
  position: relative;
  height: 150px;
}
.dropzone-desc {
  position: absolute;
  margin: 0 auto;
  left: 0;
  right: 0;
  text-align: center;
  width: 40%;
  top: 50px;
  font-size: 16px;
}
.dropzone,
.dropzone:focus {
  position: absolute;
  outline: none !important;
  width: 100%;
  height: 150px;
  cursor: pointer;
  opacity: 0;
}
.dropzone-wrapper:hover,
.dropzone-wrapper.dragover {
  background: #ecf0f5;
}
.preview-zone {
  text-align: center;
}
.preview-zone .box {
  box-shadow: none;
  border-radius: 0;
  margin-bottom: 0;
}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Upload Resi Dukcapil</h4>
				<p class="category">NIK : <?php echo $data['ID_NO'];?></p>
			</div>
			<div class="content">

					<?php if($numrows2 > 0){ ?>
					<div class="alert alert-danger alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
							<strong>Perhatian !</strong><br>
							<?php
							
								while($data2 = sqlsrv_fetch_array($exec1)){ ?>
									Note Reject : <?php echo $data2['NOTES']."<br>";
								}
							?>
						</div>
					<?php } ?>						
				<div class="row">
					<div class="col-md-6">
						<form action="" method="POST" enctype="multipart/form-data" >   
							
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label">Upload File</label>       
											<div class="preview-zone hidden">
												<div class="box box-solid">
													<div class="box-header with-border">
														<div><b>Preview</b></div>
														<div class="box-tools pull-right">
															<button type="button" class="btn btn-danger btn-xs remove-preview">
																<i class="fa fa-times"></i> Reset This Form
															</button>
														</div>
													</div>
													<div class="box-body"></div>
												</div>
											</div>       
											<div class="dropzone-wrapper">
												<div class="dropzone-desc">
													<i class="fa fa-upload"></i>
													<p>Pilih Resi Dukcapil atau Drag disini</p>
												</div>
												<input type="file" name="resi" class="dropzone">
											</div>      
										</div>
									</div>
								</div>    
								<div class="row">
									<div class="col-md-12">
										
										<!--<a href="index.php?page=detail-aro&id=<?php //echo $data['EMP_NO'];?>&nik=<?php //echo $data['employeeNIK'];?>"  class="btn btn-primary">Request Unlock</a>-->
									</div>
								</div>   
							<br><br>
						
					</div>
					<div class="row">
					<div class="col-md-6">
						
							
								
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label">Upload File</label>       
											<div class="preview-zone hidden">
												<div class="box box-solid">
													<div class="box-header with-border">
														<div><b>Preview</b></div>
														<div class="box-tools pull-right">
															<button type="button" class="btn btn-danger btn-xs remove-preview">
																<i class="fa fa-times"></i> Reset This Form
															</button>
														</div>
													</div>
													<div class="box-body"></div>
												</div>
											</div>       
											<div class="dropzone-wrapper">
												<div class="dropzone-desc">
													<i class="fa fa-upload"></i>
													<p>Pilih Foto KK atau Drag disini</p>
												</div>
												<input type="file" name="kk" class="dropzone">
											</div>      
										</div>
									</div>
								   
								<div class="row">
									<div class="col-md-12">
										<input type="submit" name="upload" class="btn btn-custom pull-right" value="Upload">
										<!--<a href="index.php?page=detail-aro&id=<?php //echo $data['EMP_NO'];?>&nik=<?php //echo $data['employeeNIK'];?>"  class="btn btn-primary">Request Unlock</a>-->
									</div>
								</div>   
							
						</form>
					</div>
						</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<center>
							<?php if($data['IMG_SRC'] <> NULL || $data['IMG_SRC'] <> ""){ ?>
								<a href="data:image/jpeg;base64,<?php echo base64_encode($data['IMG_SRC']);?>" data-lightbox="property">
									<img src="data:image/jpeg;base64,<?php echo base64_encode($data['IMG_SRC']);?>" width="50%" class="img-custom">
								</a>
								<a href="data:image/jpeg;base64,<?php echo base64_encode($data['IMG_KK']);?>" data-lightbox="property">
									<img src="data:image/jpeg;base64,<?php echo base64_encode($data['IMG_KK']);?>" width="50%" class="img-custom">
								</a>
							<?php }else{} ?>
						</center>
					</div>
				</div>
				<br><br>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
  function readFile(input) {
 if (input.files && input.files[0]) {
 var reader = new FileReader();
 
 reader.onload = function (e) {
 var htmlPreview = 
 '<img width="200" src="' + e.target.result + '" />'+
 '<p>' + input.files[0].name + '</p>';
 var wrapperZone = $(input).parent();
 var previewZone = $(input).parent().parent().find('.preview-zone');
 var boxZone = $(input).parent().parent().find('.preview-zone').find('.box').find('.box-body');
 
 wrapperZone.removeClass('dragover');
 previewZone.removeClass('hidden');
 boxZone.empty();
 boxZone.append(htmlPreview);
 };
 
 reader.readAsDataURL(input.files[0]);
 }
}function reset(e) {
 e.wrap('<form>').closest('form').get(0).reset();
 e.unwrap();
}$(".dropzone").change(function(){
 readFile(this);
});$('.dropzone-wrapper').on('dragover', function(e) {
 e.preventDefault();
 e.stopPropagation();
 $(this).addClass('dragover');
});$('.dropzone-wrapper').on('dragleave', function(e) {
 e.preventDefault();
 e.stopPropagation();
 $(this).removeClass('dragover');
});$('.remove-preview').on('click', function() {
 var boxZone = $(this).parents('.preview-zone').find('.box-body');
 var previewZone = $(this).parents('.preview-zone');
 var dropzone = $(this).parents('.form-group').find('.dropzone');
 boxZone.empty();
 previewZone.addClass('hidden');
 reset(dropzone);
});
</script>