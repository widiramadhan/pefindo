<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script> 
<?php
$apvno=$_GET['apvno'];
$trxno=$_GET['trxno'];
$error="";
 //=======HEADER
$date = date("Y-m-d");
$call = "{call SP_DATA_VIEW_INQUIRY(?)}";
$param = array(array($trxno, SQLSRV_PARAM_IN));
$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_defaults(), true)); 
$data = sqlsrv_fetch_array($exec);
//====>>>>SPK
$callspk = "{call SP_DATA_SPK(?)}";
$paramspk = array(array($trxno, SQLSRV_PARAM_IN));
$execspk = sqlsrv_query( $conn, $callspk, $paramspk) or die( print_r( sqlsrv_defaults(), true)); 
$dataspk = sqlsrv_fetch_array($execspk);
//====>>>>PASANGAN/PENJAMIN
$callpasangan = "{call SP_DATA_PASANGAN_PENJAMIN(?)}";
$parampasangan = array(array($trxno, SQLSRV_PARAM_IN));
$execpasangan = sqlsrv_query( $conn, $callpasangan, $parampasangan) or die( print_r( sqlsrv_defaults(), true)); 
$datapasangan = sqlsrv_fetch_array($execpasangan);
//=====>ceck verifff 
$callverif = "{call SP_CHECK_VERIF(?,?)}";
$paramverif = array(array($trxno, SQLSRV_PARAM_IN),
			array($user, SQLSRV_PARAM_IN));
$execverif = sqlsrv_query( $conn, $callverif, $paramverif) or die( print_r( sqlsrv_defaults(), true)); 
$dataverif = sqlsrv_fetch_array($execverif);

//=========IMG
$call2 = "{call SP_VIEW_INQUIRY_IMAGES(?)}";
$param2 = array(array($trxno, SQLSRV_PARAM_IN));
$exec2 = sqlsrv_query( $conn, $call2,$param2) or die( print_r( sqlsrv_defaults(), true)); 
$data2 = sqlsrv_fetch_array($exec2);

if($data2['FOTO_KTP_PASANGAN'] <> NULL){
	$siapanih="PASANGAN";
	$foto_siapanih=$data2['FOTO_KTP_PASANGAN'];
}else{
	$siapanih="PENJAMIN";
	$foto_siapanih=$data2['FOTO_KTP_PENJAMIN'];
}
 
?>
<style>
.img-custom{
	width:100%;
	height:200px;
}
.th-custom{
	text-align:center;
	background-color:#035c7a;
}
.td-center{
	text-align:center;
}
.pagination > li > a, .pagination > li > span{
	background-color:#FFF;
	color:#035c7a;
}
.pagination > li.active > a, .pagination > li.active > span{
	background-color:#035c7a;
	color:#FFF;
}
.pagination > li.active > a:hover, .pagination > li.active > span:hover{
	background-color:#035c7a;
	color:#FFF;
}
.pagination > li.focus > a, .pagination > li.focus > span:hover{
	background-color:#035c7a;
	color:#FFF;
}
.pagination > li.active > a.page-link, .pagination > li.active > span.page-link{
	background-color:#035c7a;
	color:#FFF;
}
</style>
<form method="post">
	<input type="hidden" name="order_no" value="<?php echo $data['ORDER_NO'];?>">
	
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
									<td><?php echo $data['ID_NO'];?></td>
								</tr>
								<tr>
									<td>Nama Customer</td>
									<td>:</td>
									<td><?php echo $data['CUSTOMER_NAME'];?></td>
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
									<td>
										<?php echo $data['CREATE_DATE']->format('Y-m-d H:i:s');?>	
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
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
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DATA PEMOHON</td>
									</tr>
									<tr>
										<td style="width:50%;">Foto KTP</td>
										<td style="width:50%;">
											<?php if($data2['FOTO_KTP_PEMOHON'] <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_KTP_PEMOHON']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_KTP_PEMOHON']);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
										 
											
												<input type="hidden" name="order_no" value="<?php echo $data['ORDER_NO'];?>">
												<div class="form-group" style="margin-top:5px;">
													<!-- <label style="color:#333;">Ganti Foto</label> -->
													<!-- <input type="file" name="foto_ktp_pemohon" onchange="submit()"> -->
												</div>
										 
										</td>
									</tr>
									
									<tr>
										<td style="width:50%;">Nomor KTP <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" disabled name="ktp_pemohon" onkeypress="return onlyNumber(event)" maxlength="16" class="form-control" placeholder="Nomor KTP" value="<?php echo $data['ID_NO'];?>" required id="ktp_pemohon" onkeyup="function_ktp_pemohon(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nama Pemohon <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" disabled name="nama_pemohon" class="form-control" placeholder="Nama Lengkap" value="<?php echo $data['CUSTOMER_NAME'];?>" required id="nama_pemohon" onkeyup="function_nama_pemohon(this.value)" autocomplete="off" disable>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Tanggal Lahir <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<div class="input-group date">
												<input type="text" disabled name="tgl_pemohon" class="form-control" placeholder="Tanggal Lahir" value="<?php if($data['BIRTH_DATE']<>NULL){echo $data['BIRTH_DATE']->format("Y-m-d");}?>" required id="ttl_pemohon" onchange="function_ttl_pemohon(this.value)" autocomplete="off" disable>
												<div class="input-group-addon">
													<span class="add-on"><i class="fa fa-calendar"></i></span>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nama Ibu Kandung <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" disabled name="nama_ibu_pemohon" class="form-control" placeholder="Nama Ibu Kandung" required id="ibu_pemohon" value="<?php echo $data['MOTHER_NAME'];?>" onkeyup="function_ibu_pemohon(this.value)" autocomplete="off" disable>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Status Kawin <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<select class="form-control" disabled name="status_kawin_pemohon"  id="status_pemohon" onchange="function_status_pemohon(this.value)" disable>
												<option value="MAR" <?php if($data['MARITAL_STATUS']=="MAR"){echo "selected";}?>>KAWIN</option>
												<option value="SIN" <?php if($data['MARITAL_STATUS']=="SIN"){echo "selected";}?>>SINGLE</option>
												<option value="DIV" <?php if($data['MARITAL_STATUS']=="DIV"){echo "selected";}?>>CERAI</option>
												<option value="WID" <?php if($data['MARITAL_STATUS']=="WID"){echo "selected";}?>>DUDA/JANDA</option>
											</select>
										</td>
									</tr>
									<tr>
										 
											<td style="width:50%;">Status Verification
												<span class="text-danger">*</span>
												<input type="checkbox" name="checkverif[]" value="Pemohon" required disabled <?php if ($dataverif['IS_VERIFIED']=='1') {echo 'checked';}?>>
											</td>
											<td style="width:50%;">
												 
											</td>
										 
									</tr>
								</table>
							</div>								
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DATA <?php echo $siapanih;?></td>
									</tr>
									<tr>
										<td style="width:50%;">Foto KTP</td>
										<td style="width:50%;">
											<?php if($foto_siapanih <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($foto_siapanih);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($foto_siapanih);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											 
												
												<input type="hidden" name="order_no" value="<?php echo $data['ORDER_NO'];?>">
												<div class="form-group" style="margin-top:5px;">
													<!-- <label style="color:#333;">Ganti Foto</label> -->
													<!-- <input type="file" name="foto_ktp_pasangan_penjamin" onchange="submit()"> -->
												</div>
											 
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nomor KTP</td>
										<td style="width:50%;">
											<input type="text" name="ktp_pasangan" value="<?php echo $datapasangan['ID_NO']?>" onkeypress="return onlyNumber(event)" maxlength="16" class="form-control" id="ktp_pasangan" onkeyup="function_ktp_pasangan(this.value)" autocomplete="off" disabled>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nama <?php echo $siapanih;?></td>
										<td style="width:50%;">
											<input type="text" name="nama_pasangan" value="<?php echo $datapasangan['CUST_NAME']?>" class="form-control"  id="nama_pasangan" onkeyup="function_nama_pasangan(this.value)" autocomplete="off" disabled>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Tanggal Lahir</td>
										<td style="width:50%;">
											<div class="input-group date">
												<input type="text" name="tgl_pasangan" class="form-control" value="<?php if($datapasangan['BIRTH_DATE']<>NULL){echo $datapasangan['BIRTH_DATE']->format("Y-m-d");}?>"  id="ttl_pasangan" onchange ="function_ttl_pasangan(this.value)" autocomplete="off" disabled>
												<div class="input-group-addon">
													<span class="add-on"><i class="fa fa-calendar"></i></span>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nama Ibu Kandung</td>
										<td style="width:50%;">
											<input type="text" name="nama_ibu_pasangan" class="form-control" value="<?php echo $datapasangan['MOTHER_NAME']?>"  id="ibu_pasangan" onkeyup="function_ibu_pasangan(this.value)" autocomplete="off" disabled>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Status Kawin</td>
										<td style="width:50%;">
                                        <input type="text" name="nama_ibu_pasangan" class="form-control" value="<?php echo $datapasangan['MARITAL_STATUS_CODE']?>"  id="ibu_pasangan" onkeyup="function_ibu_pasangan(this.value)" autocomplete="off" disabled>
											 
										</td>
									</tr>
									<tr>
										 
											<td style="width:50%;">Status Verification
												<span class="text-danger">*</span>
												<input type="checkbox" name="checkverif[]" value="<?php $siapanih?>" required disabled <?php if ($dataverif['IS_VERIFIED']=='1') {echo 'checked';}?>>
											</td>
											<td style="width:50%;">
												 
											</td>
										 
									</tr>
								</table>	
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">KARTU KELUARGA</td>
									</tr>
								<tr>
										<td style="width:50%;">Foto KK</td>
										<td style="width:50%;">
											<?php if($data2['FOTO_KK_PEMOHON'] <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_KK_PEMOHON']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_KK_PEMOHON']);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											 
												
												<input type="hidden" name="order_no" value="<?php echo $data['ORDER_NO'];?>">
												<div class="form-group" style="margin-top:5px;">
													<!-- <label style="color:#333;">Ganti Foto</label> -->
													<!-- <input type="file" name="foto_kk" onchange="submit()"> -->
												</div>
										 
										</td>
									</tr>
										 
											<td style="width:50%;">Status Verification
												<span class="text-danger">*</span>
												<input type="checkbox" name="checkverif[]" value="kk" disabled required <?php if ($dataverif['IS_VERIFIED']=='1') {echo 'checked';}?>>
											</td>
											<td style="width:50%;">
												 
											</td>
										 
									</tr>
								</table>

							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">PBB/AJB/Sertifikat</td>
									</tr>
									<tr>
										<td style="width:50%;">Foto PBB/AJB/Sertifikat</td>
										<td style="width:50%;">
											<?php if($data2['FOTO_PENDUKUNG'] <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_PENDUKUNG']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_PENDUKUNG']);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											 
												
												<input type="hidden" name="order_no" value="<?php echo $data['ORDER_NO'];?>">
												<div class="form-group" style="margin-top:5px;">
													<!-- <label style="color:#333;">Ganti Foto</label> -->
													<!-- <input type="file" name="foto_pendukung" onchange="submit()"> -->
												</div>
											 
										</td>
									</tr>
									<tr>
										 
											<td style="width:50%;">Status Verification
												<span class="text-danger">*</span>
												<input type="checkbox" name="checkverif[]" value="pbb/ajb/sertifikat" disabled required <?php if ($dataverif['IS_VERIFIED']=='1') {echo 'checked';}?>>
											</td>
											<td style="width:50%;">
											 
											</td>
										 	
									</tr>
								</table>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">SLIP GAJI</td>
									</tr>
									<tr>
										<td style="width:50%;">Foto Slip Gaji</td>
										<td style="width:50%;">
											<?php if($data2['FOTO_SLIP_GAJI'] <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_SLIP_GAJI']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_SLIP_GAJI']);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											 
											
												<input type="hidden" name="order_no" value="<?php echo $data['ORDER_NO'];?>">
												<div class="form-group" style="margin-top:5px;">
													<!-- <label style="color:#333;">Ganti Foto</label> -->
													<!-- <input type="file" name="foto_slip_gaji" onchange="submit()"> -->
												</div>
											 
										</td>
										
									</tr>
									<tr>
										<td style="width:50%;">Foto Slip Gaji 2</td>
										<td style="width:50%;">
											<?php if($data2['FOTO_SLIP_GAJI_2'] <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_SLIP_GAJI_2']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_SLIP_GAJI_2']);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											<form action="" method="post" enctype="multipart/form-data">
												
												<input type="hidden" name="order_no" value="<?php echo $data['ORDER_NO'];?>">
												<div class="form-group" style="margin-top:5px;">
													
												</div>
											</form>
										</td>
										
									</tr>
									<tr>
										<td style="width:50%;">Foto Slip Gaji 3</td>
										<td style="width:50%;">
											<?php if($data2['FOTO_SLIP_GAJI_3'] <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_SLIP_GAJI_3']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_SLIP_GAJI_3']);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											<form action="" method="post" enctype="multipart/form-data">
											
												<input type="hidden" name="order_no" value="<?php echo $data['ORDER_NO'];?>">
												<div class="form-group" style="margin-top:5px;">
													
												</div>
											</form>
										</td>
										
									</tr>
									<tr>
										<td style="width:50%;">Foto Slip Gaji 4</td>
										<td style="width:50%;">
											<?php if($data2['FOTO_SLIP_GAJI_4'] <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_SLIP_GAJI_4']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_SLIP_GAJI_4']);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											<form action="" method="post" enctype="multipart/form-data">
											
												<input type="hidden" name="order_no" value="<?php echo $data['ORDER_NO'];?>">
												<div class="form-group" style="margin-top:5px;">
													
												</div>
											</form>
										</td>
										
									</tr>
									<tr>
										<td style="width:50%;">Foto Slip Gaji 5</td>
										<td style="width:50%;">
											<?php if($data2['FOTO_SLIP_GAJI_5'] <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_SLIP_GAJI_5']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_SLIP_GAJI_5']);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											<form action="" method="post" enctype="multipart/form-data">
									
												<input type="hidden" name="order_no" value="<?php echo $data['ORDER_NO'];?>">
												<div class="form-group" style="margin-top:5px;">
													
												</div>
											</form>
										</td>
										
									</tr>
									<tr>
										<td style="width:50%;">Foto Slip Gaji 6</td>
										<td style="width:50%;">
											<?php if($data2['FOTO_SLIP_GAJI_6'] <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_SLIP_GAJI_6']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_SLIP_GAJI_6']);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											<form action="" method="post" enctype="multipart/form-data">
												
												<input type="hidden" name="order_no" value="<?php echo $data['ORDER_NO'];?>">
												<div class="form-group" style="margin-top:5px;">
													
												</div>
											</form>
										</td>
										
									</tr>
									<tr>
									 
											<td style="width:50%;">Status Verification
												<span class="text-danger">*</span>
												<input type="checkbox" name="checkverif[]" value="slip gaji" required disabled <?php if ($dataverif['IS_VERIFIED']=='1') {echo 'checked';}?>>
											</td>
											<td style="width:50%;">
											 
											</td>
										 
									</tr>
								</table>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">SURAT PEMESANAN KENDARAAN</td>
									</tr>
									<tr>
										<td style="width:50%;">Foto SPK</td>
										<td style="width:50%;">
											<?php if($data2['FOTO_SPK'] <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_SPK']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_SPK']);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											 
											
												<input type="hidden" name="order_no" value="<?php echo $data['ORDER_NO'];?>">
												<div class="form-group" style="margin-top:5px;">
													<!-- <label style="color:#333;">Ganti Foto</label> -->
													<!-- <input type="file" name="foto_spk" onchange="submit()"> -->
												</div>
										 
										</td>
									</tr>
									 
									<tr>
										<td style="width:50%;">No SPK<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="spk_no" id="spk_no" style="width: 100%;" disabled value="<?php echo $dataspk['NO_SPK']?>">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Tanggal SPK <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<div class="input-group date">
												<input type="text" name="tgl_spk" class="form-control" value="<?php echo $dataspk['TANGGAL_SPK']->format('Y-m-d');?>" placeholder="Tanggal SPK"  required id="ttl_spk" onchange="function_ttl_spk(this.value)" autocomplete="off" disabled>
												<div class="input-group-addon">
													<span class="add-on"><i class="fa fa-calendar"></i></span>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nama Pemesan<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="nama_pemesan" id="nama_pemesan" style="width: 100%;" value="<?php echo $dataspk['NAMA_PEMESAN']?>" disabled>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Alamat KTP<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="alamat_ktp" id="alamat_ktp" style="width: 100%;" disabled value="<?php echo $dataspk['ALAMAT_KTP']?>">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Alamat Tinggal<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="alamat_tinggal" id="alamat_tinggal" style="width: 100%;" value="<?php echo $dataspk['ALAMAT_TINGGAL']?>" disabled>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">No HP<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="no_hp" id="no_hp" style="width: 100%;" value="<?php echo $dataspk['NO_HP']?>" onkeypress="return hanyaAngka(event)" maxlength="12" disabled>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">No NPWP<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="no_npwp" id="no_npwp" style="width: 100%;" value="<?php echo $dataspk['NO_NPWP']?>" onkeypress="return hanyaAngka(event)" disabled>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Merk Kendaraan<span class="text-danger">*</span></td>
										<td style="width:50%;">
										<input type="text" name="merk" id="no_npwp" style="width: 100%;" value="<?php echo $dataspk['MERK_KENDARAAN']?>" onkeypress="return hanyaAngka(event)" disabled>
											
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Tipe Kendaraan<span class="text-danger">*</span></td>
										<td style="width:50%;">
										<input type="text" name="type" id="no_npwp" style="width: 100%;" value="<?php echo $dataspk['TIPE_KENDARAAN']?>" onkeypress="return hanyaAngka(event)" disabled>
											 
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Tahun Kendaraan<span class="text-danger">*</span><jg/td>
										<td style="width:50%;">
											<input type="text" name="thn_kendaraan" id="thn_kendaraan" value="<?php echo $dataspk['TAHUN_KENDARAN']?>" style="width: 100%;" onkeypress="return hanyaAngka(event)" maxlength="4" disabled>
										</td>
									</tr>
										<!-- <script type="text/javascript">
		
										var rupiah = document.getElementById('rupiah');
										rupiah.addEventListener('keyup', function(e){
											// tambahkan 'Rp.' pada saat form di ketik
											// gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
											rupiah.value = formatRupiah(this.value, 'Rp. ');
										});
								 
										/* Fungsi formatRupiah */
										function formatRupiah(angka, prefix){
											var number_string = angka.replace(/[^,\d]/g, '').toString(),
											split   		= number_string.split(','),
											sisa     		= split[0].length % 3,
											rupiah     		= split[0].substr(0, sisa),
											ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
								 
											// tambahkan titik jika yang di input sudah menjadi angka ribuan
											if(ribuan){
												separator = sisa ? '.' : '';
												rupiah += separator + ribuan.join('.');
											}
								 
											rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
											return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
										}
									</script> -->
									<tr>
										<td style="width:50%;">Harga OTR<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="harga_otr" value="<?php echo $dataspk['HARGA_OTR']?>" id="harga_otr" style="width: 100%;" onkeypress="return hanyaAngka(event)" onkeyup = "javascript:this.value=Comma(this.value);" disabled>
										</td>
									</tr>
									<tr>
										<script>
											function hanyaAngka(evt) {
											  var charCode = (evt.which) ? evt.which : event.keyCode
											   if (charCode > 31 && (charCode < 48 || charCode > 57))
									 
											    return false;
											  return true;
											}
										</script>
										<td style="width:50%;">Tenor<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="tenor" id="tenor" value="<?php echo $dataspk['TENOR']?>" style="width: 100%;" maxlength="2" onkeypress="return hanyaAngka(event)" disabled>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Angsuran<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="angsuran" id="angsuran" value="<?php echo $dataspk['ANGSURAN']?>" style="width: 100%;" onkeypress="return hanyaAngka(event)" onkeyup = "javascript:this.value=Comma(this.value);" disabled>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">DP Total<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="dp_total" id="dp_total" value="<?php echo $dataspk['DP_TOTAL']?>" style="width: 100%;" onkeypress="return hanyaAngka(event)" onkeyup = "javascript:this.value=Comma(this.value);" disabled>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Pencairan<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="pencairan" id="pencairan" value="<?php echo $dataspk['PENCAIRAN']?>" style="width: 100%;" onkeypress="return hanyaAngka(event)" onkeyup = "javascript:this.value=Comma(this.value);" disabled>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Uang Jaminan<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="uang_jaminan" value="<?php echo $dataspk['UANG_JAMINAN']?>" id="uang_jaminan" style="width: 100%;" onkeypress="return hanyaAngka(event)" onkeyup = "javascript:this.value=Comma(this.value);" disabled>
										</td>
									</tr>
									<tr>
										 
											<td style="width:50%;">Status Verification
												<span class="text-danger">*</span>
												<input type="checkbox" name="checkverif[]" value="spk" required disabled <?php if ($dataverif['IS_VERIFIED']=='1') {echo 'checked';}?>>
											</td>
											<td style="width:50%;">
												 
											</td>
										 
									</tr>
									<tr>
									</tr>
								</form>
								</table>	
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">NOMOR POKOK WAJIB PAJAK</td>
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
												<input type="hidden" name="order_no" value="<?php echo $data['ORDER_NO'];?>">
												<div class="form-group" style="margin-top:5px;">
													<!-- <label style="color:#333;">Ganti Foto</label> -->
													<!-- <input type="file" name="foto_npwp" onchange="submit()"> -->
												</div>
											 
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nomor NPWP</td>
										<td style="width:50%;">
											<input type="text" disabled name="npwp" class="form-control" onkeypress="return onlyNumber(event)" placeholder="Nomor NPWP" id="npwp" onkeyup="function_npwp(this.value)" autocomplete="off" value="<?php echo $data['NO_NPWP'];?>">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Status Verification
											<span class="text-danger">*</span>
											<input type="checkbox" name="checkverif[]" value="npwp" required disabled <?php if ($dataverif['IS_VERIFIED']=='1') {echo 'checked';}?>>
										</td>
										<td style="width:50%;">
										 
										</td>
									</tr>
								</table>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Screenshoot Whatsapp</td>
									</tr>
									<tr>
										<td style="width:50%;">Foto SS WA</td>
										<td style="width:50%;">
											<?php if($data2['FOTO_SS_WA'] <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_SS_WA']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_SS_WA']);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
										 
												<input type="hidden" name="order_no" value="<?php echo $data['ORDER_NO'];?>">
												<div class="form-group" style="margin-top:5px;">
													<!-- <label style="color:#333;">Ganti Foto</label> -->
												<!-- 	<input type="file" name="foto_ss_wa" onchange="submit()"> -->
												</div>
											 
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Tanggal Dealer kirim foto</td>
										<td style="width:50%;"> 
											<input type="text" name="" class="form-control" value="<?php if($data['DEALER_DATE']<>NULL){echo $data['DEALER_DATE']->format('Y-m-d H:i:s');}?>" readonly>
											
										</td>
									</tr>
									<tr>
									 
											<td style="width:50%;">Status Verification
												<span class="text-danger">*</span>
												<input type="checkbox" name="checkverif[]" value="screenshot" required disabled <?php if ($dataverif['IS_VERIFIED']=='1') {echo 'checked';}?>>
											</td>
											<td style="width:50%;">
												 
											</td>
										 
									</tr>
								</table>
							</div>					
						</div>
					</div>
            <div class="card">
				<div class="header">
					<h4 class="title">INQUIRY APPROVAL</h4>
					<p class="category"></p>
				</div>
				<div class="content">		
                <div class="row">
                   <div class="col-md-12">
                       <div class="table-responsive">
                           <table class="table table-bordered table-striped" id="tb_list_apv" style="font-size:10px;">
                               <thead>
                                   <tr>
                                       <th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
                                       <th class="th-custom" style="color:#FFF;font-weight:bold;">APPROVAL NO</th>
                                       <th class="th-custom" style="color:#FFF;font-weight:bold;">LEVEL</th>
                                       <th class="th-custom" style="color:#FFF;font-weight:bold;">JABATAN</th>
                                       <th class="th-custom" style="color:#FFF;font-weight:bold;">USERNAME</th>
                                       <th class="th-custom" style="color:#FFF;font-weight:bold;">STATUS</th>
                                       <th class="th-custom" style="color:#FFF;font-weight:bold;">NOTES</th>
									   <th class="th-custom" style="color:#FFF;font-weight:bold;">TANGGAL APPROVE</th>
                                    
                                   </tr>
                               </thead>
                               <tbody>
                                   <?php
                                 
                                       $no=0;
                                       $call = "{call  SP_APPROVAL_GETLIST_LOA(?)}";
                                       $param = array(array($apvno, SQLSRV_PARAM_IN));
                                       $exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
                                       while($data = sqlsrv_fetch_array($exec)){
                                           $no++;
                                   ?> 
                                   <tr>
                                       
                                       <td class="td-center"><?php echo $no;?></td>
                                       <td class="td-center"><?php echo $data['APV_NO']?></td>
                                       <td class="td-center"><?php echo $data['LEVEL']?></td>
                                       <td class="td-center"><?php echo $data['ROLE_CODE']?></td>
                                       <td class="td-center"><?php echo $data['USERNAME']?></td>
                                       <td class="td-center"><?php echo $data['STATUS']?></td>
                                       <td class="td-center"><?php echo $data['NOTES'];?></td>
									   <td class="td-center"><?php if($data['UPDATE_DATE']<>NULL){echo $data['UPDATE_DATE']->format('Y-m-d H:i:s');}else{echo"-";}?></td>
									   
									   
                                        
                                   </tr>
                                   <?php
                                       }
                                   ?>
                               </tbody>
                           </table>
                       </div>
                   </div>
               </div> 
               </div> 
               </div> 
</form>					 
				
					
					<div class="row">
						<div class="col-md-6">
							<!-- <div class="table-responsive">
									<table class="table table-bordered">
										<tr>
											<td> -->
							<!-- <center> -->
								<form action="" method="post">
									
									<input type="hidden" name="order_no" value="<?php echo $data['ORDER_NO'];?>">
								
									<input type="hidden" name="ktp_pemohon" id="ktp_pemohon2">
									<input type="hidden" name="nama_pemohon" id="nama_pemohon2">
									<input type="hidden" name="tgl_pemohon" id="ttl_pemohon2">
									<input type="hidden" name="nama_ibu_pemohon" id="ibu_pemohon2">
									<input type="hidden" name="status_pemohon" id="status_pemohon2">
									
									<input type="hidden" name="ktp_pasangan" id="ktp_pasangan2">
									<input type="hidden" name="nama_pasangan" id="nama_pasangan2">
									<input type="hidden" name="tgl_pasangan" id="ttl_pasangan2">
									<input type="hidden" name="nama_ibu_pasangan" id="ibu_pasangan2">
									<input type="hidden" name="status_pasangan" id="status_pasangan2">
									
									<input type="hidden" name="ktp_penjamin" id="ktp_penjamin2">
									<input type="hidden" name="nama_penjamin" id="nama_penjamin2">
									<input type="hidden" name="tgl_penjamin" id="ttl_penjamin2">
									<input type="hidden" name="nama_ibu_penjamin" id="ibu_penjamin2">
									<input type="hidden" name="status_penjamin" id="status_penjamin2">

									<input type="hidden" name="npwp" id="npwp2">

									<input type="hidden" name="" id="">
									<input type="hidden" name="" id="">
									<input type="hidden" name="" id="">
									<input type="hidden" name="" id="">
									<input type="hidden" name="" id="">
									<input type="hidden" name="" id="">
									<?php echo $error;?>
									<!-- <input type="submit" name="submit" class="btn btn-custom" value="SIMPAN DATA" style="width:150px;">
									<a href="index.php?page=request-mh&USERNAME=<?php// echo $user;?>" class="btn btn-custom" style="width:150px;">BATAL</a>
									<a href="index.php?page=return-mh&USERNAME=<?php //echo $user;?>&id=<?php //echo $id;?>&request_id=<?php //echo $req_id;?>" class="btn btn-custom" style="width:150px;">KEMBALIKAN DATA</a> -->
								</form>
								</div> 
								<!-- </center> -->
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
	 var nama_pemohon = $("#nama_pemohon").val();
	 $("#nama_pemohon2").val(nama_pemohon);
	 var ttl_pemohon = $("#ttl_pemohon").val();
	 $("#ttl_pemohon2").val(ttl_pemohon);
	 var ibu_pemohon = $("#ibu_pemohon").val();
	 $("#ibu_pemohon2").val(ibu_pemohon);
	 var status_pemohon = $("#status_pemohon").val();
	 $("#status_pemohon2").val(status_pemohon);
	 
	 var ktp_pasangan = $("#ktp_pasangan").val();
	 $("#ktp_pasangan2").val(ktp_pasangan);
	 var nama_pasangan = $("#nama_pasangan").val();
	 $("#nama_pasangan2").val(nama_pasangan);
	 var ttl_pasangan = $("#ttl_pasangan").val();
	 $("#ttl_pasangan2").val(ttl_pasangan);
	 var ibu_pasangan = $("#ibu_pasangan").val();
	 $("#ibu_pasangan2").val(ibu_pasangan);
	 var status_pasangan = $("#status_pasangan").val();
	 $("#status_pasangan2").val(status_pasangan);
	 
	 var ktp_penjamin = $("#ktp_penjamin").val();
	$("#ktp_penjamin2").val(ktp_penjamin);
	var nama_penjamin = $("#nama_penjamin").val();
	$("#nama_penjamin2").val(nama_penjamin);
	var ttl_penjamin = $("#ttl_penjamin").val();
	$("#ttl_penjamin2").val(ttl_penjamin);
	var ibu_penjamin = $("#ibu_penjamin").val();
	$("#ibu_penjamin2").val(ibu_penjamin);
	var status_penjamin = $("#status_penjamin").val();
	$("#status_penjamin2").val(status_penjamin);
	
	var npwp = $("#npwp").val();
	$("#npwp2").val(npwp);


	var npwp = $("#npwp").val();
	$("#npwp2").val(npwp);
});


function function_ktp_pemohon(value){ document.getElementById("ktp_pemohon2").value = value;}
function function_nama_pemohon(value){ document.getElementById("nama_pemohon2").value = value;}
function function_ttl_pemohon(value){ document.getElementById("ttl_pemohon2").value = value;}
function function_ttl_spk(value){ document.getElementById("ttl_spk").value = value;}
function function_ibu_pemohon(value){ document.getElementById("ibu_pemohon2").value = value;}
function function_status_pemohon(value){ document.getElementById("status_pemohon2").value = value;}

function function_ktp_pasangan(value){ document.getElementById("ktp_pasangan2").value = value;}
function function_nama_pasangan(value){ document.getElementById("nama_pasangan2").value = value;}
function function_ttl_pasangan(value){ document.getElementById("ttl_pasangan2").value = value;}
function function_ibu_pasangan(value){ document.getElementById("ibu_pasangan2").value = value;}
function function_status_pasangan(value){ document.getElementById("status_pasangan2").value = value;}

function function_ktp_penjamin(value){ document.getElementById("ktp_penjamin2").value = value;}
function function_nama_penjamin(value){ document.getElementById("nama_penjamin2").value = value;}
function function_ttl_penjamin(value){ document.getElementById("ttl_penjamin2").value = value;}
function function_ibu_penjamin(value){ document.getElementById("ibu_penjamin2").value = value;}
function function_status_penjamin(value){ document.getElementById("status_penjamin2").value = value;}

function function_npwp(value){ document.getElementById("npwp2").value = value;}

//function function_npwp(value){ document.getElementById("npwp2").value = value;}
</script>
<script>
$( document ).ready(function() {   
	$('#ttl_pemohon').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		yearRange: '1900:2025',
		endDate: new Date()
	});
	$('#ttl_pasangan').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		yearRange: '1900:2025',
		endDate: new Date()
	});
	$('#ttl_penjamin').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		yearRange: '1900:2025',
		endDate: new Date()
	});
	$('#ttl_spk').datepicker({
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
 function Comma(Num) { //function to add commas to textboxes
           Num += '';
           Num = Num.replace(',', ''); Num = Num.replace(',', ''); Num = Num.replace(',', '');
           Num = Num.replace(',', ''); Num = Num.replace(',', ''); Num = Num.replace(',', '');
           x = Num.split('.');
           x1 = x[0];
           x2 = x.length > 1 ? '.' + x[1] : '';
           var rgx = /(\d+)(\d{3})/;
           while (rgx.test(x1))
               x1 = x1.replace(rgx, '$1' + ',' + '$2');
           return x1 + x2;
       }

function onlyNumber(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;
return true;
}
function onCheckChange() {
	    if ($("#check_dt_pemohon").is(':checked')) {
	        $("#vr_pemohon").attr('disabled', 'disabled');
	        $("#check_dt_pemohon").val("TRUE");
	    } else {
	        $("#vr_pemohon").removeAttr('disabled');
	    }
	}
	$("#check_dt_pemohon").click(onCheckChange).change(onCheckChange);

function onCheckChange1() {
	    if ($("#check_dt_pasangan").is(':checked')) {
	        $("#vr_pasangan").attr('disabled', 'disabled');
	        $("#check_dt_pasangan").val("TRUE");
	    } else {
	        $("#vr_pasangan").removeAttr('disabled');
	    }
	}
	$("#check_dt_pasangan").click(onCheckChange1).change(onCheckChange1);

function onCheckChange2() {
	    if ($("#check_dt_kk").is(':checked')) {
	        $("#vr_kk").attr('disabled', 'disabled');
	        $("#check_dt_kk").val("TRUE");
	    } else {
	        $("#vr_kk").removeAttr('disabled');
	    }
	}
	$("#check_dt_kk").click(onCheckChange2).change(onCheckChange2);

function onCheckChange3() {
	    if ($("#check_dt_pendukung").is(':checked')) {
	        $("#vr_pendukung").attr('disabled', 'disabled');
	        $("#check_dt_pendukung").val("TRUE");
	    } else {
	        $("#vr_pendukung").removeAttr('disabled');
	    }
	}
	$("#check_dt_pendukung").click(onCheckChange3).change(onCheckChange3);

function onCheckChange4() {
	    if ($("#check_dt_slip_gaji").is(':checked')) {
	        $("#vr_slip_gaji").attr('disabled', 'disabled');
	        $("#check_dt_slip_gaji").val("TRUE");
	    } else {
	        $("#vr_slip_gaji").removeAttr('disabled');
	    }
	}
	$("#check_dt_slip_gaji").click(onCheckChange4).change(onCheckChange4);

function onCheckChange5() {
	    if ($("#check_dt_spk").is(':checked')) {
	        $("#vr_spk").attr('disabled', 'disabled');
	        $("#check_dt_spk").val("TRUE");
	    } else {
	        $("#vr_spk").removeAttr('disabled');
	    }
	}
	$("#check_dt_spk").click(onCheckChange5).change(onCheckChange5);

function onCheckChange6() {
	    if ($("#check_dt_npwp").is(':checked')) {
	        $("#vr_npwp").attr('disabled', 'disabled');
	        $("#check_dt_npwp").val("TRUE");
	    } else {
	        $("#vr_npwp").removeAttr('disabled');
	    }
	}
	$("#check_dt_npwp").click(onCheckChange6).change(onCheckChange6);

function onCheckChange7() {
	    if ($("#check_dt_ss_wa").is(':checked')) {
	        $("#vr_ss_wa").attr('disabled', 'disabled');
	        $("#check_dt_ss_wa").val("TRUE");
	    } else {
	        $("#vr_ss_wa").removeAttr('disabled');
	    }
	}
	$("#check_dt_ss_wa").click(onCheckChange7).change(onCheckChange7);

function myFunction() {
  var x = document.getElementById("merk_kendaraan").value;
  //console.log(value);
  document.getElementById("tipe_kendaraan").innerHTML = $x;
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

