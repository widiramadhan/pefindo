<?php
require_once("config/configuration.php");
$noProsepekPemohonSLIK=$_GET['no'];
$cust_type=$_GET['custtype'];
$id=$_GET['id'];
$tipe = $_GET['tipe'];

$callSP = "{call SP_GET_SLIK_INDIVIDUAL_REPORT_NEW_MAPPING(?,?)}";
$options = array( "Scrollable" => "buffered" );
$params = array(array($id, SQLSRV_PARAM_IN),array($tipe, SQLSRV_PARAM_IN));
$exec = sqlsrv_query( $conn, $callSP, $params, $options) or die( print_r( sqlsrv_defaults(), true));
$numrows = sqlsrv_num_rows($exec);
$data = sqlsrv_fetch_array($exec);
?>
<style>
a{
	color:red;
}
th{
	text-align:center;
	font-weight:bold;
}
a:hover{
	color:red;
}
.text-default{
	color:#AAA;
}
.name{
	font-size:18px;
	font-weight:bold;
}
.table-borderless > tbody > tr > td{
    border: none;
}
ul > li > a {
	color:black;
}
ul > li > a:hover {
	color:red;
}
ul > li > .active > a:focus {
	color:red;
}
.box-yellow{
	padding:10px;
	font-size:24px;
	font-weight:bold;
	background-color:#ff8b00;
	color:#FFF;
	width:80px;
	margin-right:10px;
	border-radius:5px;
	margin-bottom:10px;
}
.box-green{
	padding:10px;
	font-size:24px;
	font-weight:bold;
	background-color:#009a00;
	color:#FFF;
	width:80px;
	margin-right:10px;
	border-radius:5px;
	margin-bottom:10px;
}
.box-red{
	padding:10px;
	font-size:24px;
	font-weight:bold;
	background-color:#c5071f;
	color:#FFF;
	width:80px;
	margin-right:10px;
	border-radius:5px;
	margin-bottom:10px;
}
.box-white{
	padding:10px;
	font-size:24px;
	font-weight:bold;
	background-color:#FFF;
	color:#AAA;
	border:1px solid #AAA;
	width:80px;
	margin-right:10px;
	border-radius:5px;
	margin-bottom:10px;
}
.circle-green{
	padding:8px 5px 5px 5px;
	font-size:8px;
	font-weight:bold;
	background-color:#009a00;
	color:#FFF;
	border:0px solid #333;
	width:28px;
	height:28px;
	border-radius:50%;
}
.circle-red{
	padding:8px 5px 5px 5px;
	font-size:8px;
	font-weight:bold;
	background-color:#c5071f;
	color:#FFF;
	border:0px solid #333;
	width:28px;
	height:28px;
	border-radius:50%;
}
.circle-yellow{
	padding:8px 5px 5px 5px;
	font-size:8px;
	font-weight:bold;
	background-color:#ff8b00;
	color:#FFF;
	border:0px solid #333;
	width:28px;
	height:28px;
	border-radius:50%;
}
.circle-default{
	padding:8px 5px 5px 5px;
	font-size:8px;
	font-weight:bold;
	background-color:#CCC;
	color:#FFF;
	border:0px solid #333;
	width:28px;
	height:28px;
	border-radius:50%;
}
.disclaimer{
	padding:30px;
	background-color:#EEE;
}
.bg-td{
	background-color:#f9f9f9;
}

.loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 99999999999999999999999999999;
    background: url('assets/img/basicloader.gif') 50% 50% no-repeat rgb(255,255,255);
    opacity: 1;
}
tr.header{
    cursor:pointer;
	display: table-row;
}
tr.child {
    display: none;
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
<script>
$(document).ready(function(){
  $("#collapseOne").on("hide.bs.collapse", function(){
    $(".card-link").html('<span class="fa fa-chevron-down text-danger"></span>');
  });
  $("#collapseOne").on("show.bs.collapse", function(){
    $(".card-link").html('<span class="fa fa-chevron-up text-danger"></span>');
  });
  $("#collapseOne2").on("hide.bs.collapse", function(){
    $(".card-link2").html('<span class="fa fa-chevron-down text-danger"></span>');
  });
  $("#collapseOne2").on("show.bs.collapse", function(){
    $(".card-link2").html('<span class="fa fa-chevron-up text-danger"></span>');
  });
});
</script>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<div class="pull-left">
					<h4 class="title">SCORING REPORT <?php echo $cust_type;?></h4>
					
				</div>
				<div style="clear:both;"></div>
			</div>
				<?php
				if($data['DATA_NOT_FOUND']==1){
			?>
				<div class="content">
					<div class="card">
						<div class="header">
							<div class="row">
								<div class="col-md-11">
									<p class="name pull-left">Summary</p>
								</div>
							</div>
						</div>
						<div class="content">
							<div class="row">
								<div class="col-md-11">
									<div class="card">
										<div class="content" style="padding:0px;">
											<div class="table-responsive">
												<table class="table" style="width:100%;">
													<tr>
														<td style="padding:10px;width:100px;"><img src="assets/img/default-user.png" style="width:100%;border-radius:50%;border:1px solid #CCC;"></td>
														<td style="vertical-align:middle;font-size:18px;"><b><?php echo strtoupper($data['CUST_NAME']);?></b><div style="font-size:16px;color:#AAA;"><?php echo $data['ID_NO'];?></div></td>
														<td style="vertical-align:middle;font-size:36px;width:200px;text-align:center;background-color:#035c7a;color:#FFF;"><div style="font-size:16px;">SCORE</div><b><?php echo $data['SLIK_SCORE'];?></b><br><div style="font-size:14px;"><?php echo $data['RANGE_DAYS_OD'];?></div></td>
													</tr>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<div class="card">
										<div class="content">
											<center>
												<div style="color:#AAA;">TOTAL FASILITAS</div>
												<div style="font-size:36px;font-weight:bold;"><?php echo $data['TOTAL_FASILITAS'];?></div>
											</center>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="card">
										<div class="content">
											<center>
												<div style="color:#AAA;">TOTAL PLAFOND</div>
												<div style="font-size:36px;font-weight:bold;"><span style="color:#AAA;font-size:18px;">Rp.</span> <?php echo number_format($data['TOTAL_PLAFOND'],0,',','.');?></div>
											</center>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="card">
										<div class="content">
											<center>
												<div style="color:#AAA;">TOTAL BAKI DEBET</div>
												<div style="font-size:36px;font-weight:bold;"><span style="color:#AAA;font-size:18px;">Rp.</span> <?php echo number_format($data['TOTAL_BAKI_DEBET'],0,',','.');?></div>
											</center>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-11">
									<div class="table-responsive">
										<table class="table table-bordered" style="width:100%;border:none;">
											<thead>
												<th class="bg-td" style="width:12.5%;font-weight:bold;">Lancar</th>
												<th class="bg-td" style="width:12.5%;font-weight:bold;">1 - 30</th>
												<th class="bg-td" style="width:12.5%;font-weight:bold;">31 - 60</th>
												<th class="bg-td" style="width:12.5%;font-weight:bold;">61 - 90</th>
												<th class="bg-td" style="width:12.5%;font-weight:bold;">91 - 120</th>
												<th class="bg-td" style="width:12.5%;font-weight:bold;">121 - 150</th>
												<th class="bg-td" style="width:12.5%;font-weight:bold;">151 - 180</th>
												<th class="bg-td" style="width:12.5%;font-weight:bold;">> 180</th>
											</thead>
											<tbody>
												<tr>
													<?php
														if($numrows <> 0){
													?>
													<td align="center"><?php if($data['DAYS_OD']==0){ echo "<i class='fa fa-check'></i>";}?></td>
													<td align="center"><?php if($data['DAYS_OD'] >= 1 && $data['DAYS_OD'] <= 30){ echo "<i class='fa fa-check'></i>";}?></td>
													<td align="center"><?php if($data['DAYS_OD'] >= 31 && $data['DAYS_OD'] <= 60){ echo "<i class='fa fa-check'></i>";}?></td>
													<td align="center"><?php if($data['DAYS_OD'] >= 61 && $data['DAYS_OD'] <= 90){ echo "<i class='fa fa-check'></i>";}?></td>
													<td align="center"><?php if($data['DAYS_OD'] >= 91 && $data['DAYS_OD'] <= 120){ echo "<i class='fa fa-check'></i>";}?></td>
													<td align="center"><?php if($data['DAYS_OD'] >= 121 && $data['DAYS_OD'] <= 150){ echo "<i class='fa fa-check'></i>";}?></td>
													<td align="center"><?php if($data['DAYS_OD'] >= 151 && $data['DAYS_OD'] <= 180){ echo "<i class='fa fa-check'></i>";}?></td>
													<td align="center"><?php if($data['DAYS_OD'] > 180){ echo "<i class='fa fa-check'></i>";}?></td>
													<?php }else{ ?>
													<td align="center"></td>
													<td align="center"></td>
													<td align="center"></td>
													<td align="center"></td>
													<td align="center"></td>
													<td align="center"></td>
													<td align="center"></td>
													<td align="center"></td>
													<?php } ?>
												</tr>
											</tbody>	
										</table>
									</div>	
								</div>		
							</div>	
								
							
							<div class="row">
								<div class="col-md-11">
									<div class="table-responsive">
							<table class="table table-bordered table-striped" id="history" style="font-size:12px;">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">JENIS FASILITAS</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">DAYS OD TERAKHIR</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">SLIK SCORE</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">TOTAL PLAFOND</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">TOTAL BAKI DEBET</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">TANGGAL AKAD AWAL</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">TANGGAL AKAD AKHIR</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">CREATE DATE</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$call = "{call SP_GET_FASILITAS_SLIK_NEW_MAPPING(?)}";
									$param = array(array($id, SQLSRV_PARAM_IN));
									$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_defaults(), true));
									$no=0;
									while($data4 = sqlsrv_fetch_array($exec)){
										$no++;
									?>
									<tr>
										<td class="td-center"><?php echo $no;?></td>
										<td><?php echo $data4['JENIS_FASILITAS'];?></td>
										<td class="td-center"><?php echo $data4['DAYS_OD_TERAKHIR'];?></td>
										<td class="td-center"><?php echo $data4['SLIK_SCORE'];?></td>
										<td style="text-align:right;">Rp. <?php echo number_format($data4['TOTAL_PLAFOND']);?></td>
										<td style="text-align:right;">Rp. <?php echo number_format($data4['TOTAL_BAKI_DEBET']);?></td>
										<td class="td-center"><?php if($data4['TANGGAL_AKAD_AWAL']<>NULL){echo $data4['TANGGAL_AKAD_AWAL']->format('Y-m-d');}?></td>
										<td class="td-center"><?php if($data4['TANGGAL_AKAD_AKHIR']<>NULL){echo $data4['TANGGAL_AKAD_AKHIR']->format('Y-m-d');}?></td>
										<td class="td-center"><?php echo $data4['CREATE_DATE']->format('Y-m-d H:i:s');?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
										</div>	
								</div>		
							</div>
							<HR>
							<p class="name pull-left">Detail</p>
							<br>
							<br>
							<p>Header</p>
							<div class="row">
							
								<div class="col-md-11">
								<div class="card">
										<div class="content">
									<div class="table-responsive">
							<table class="table table-bordered table-striped" id="history" style="font-size:12px;">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Kode Ref. Pengguna</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Nomor Laporan</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Posisi Data Terakhir</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Tanggal Permintaan</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$callHeader = "{call SP_GET_FASILITAS_SLIK_HEADER_NEW_MAPPING(?)}";
									$paramHeader = array(array($id, SQLSRV_PARAM_IN));
									$execHeader = sqlsrv_query( $conn, $callHeader, $paramHeader) or die( print_r( sqlsrv_defaults(), true));
									$dataHeader = sqlsrv_fetch_array($execHeader)
								
									?>
									<tr> 
										<td class="td-center"><?php echo $dataHeader['kodeReferensiPengguna'];?></td>
										<td class="td-center"><?php echo $dataHeader['nomorLaporan'];?></td>
										
										<td class="td-center"><?php echo  date("F Y", strtotime(substr($dataHeader['posisiDataTerakhir'], 0, -2)."-".substr($dataHeader['posisiDataTerakhir'], 4)));?></td>
										<td class="td-center"><?php if ($dataHeader['tanggalPermintaan'] == null){echo '-';}else{echo  $dataHeader['tanggalPermintaan']->format('Y-m-d');}?></td>
										
									</tr>
									
								</tbody>
							</table>
										</div>	
								</div>		
							</div>			
							</div>		
							</div>	
							<p>Data Pokok Debitur</p>
							<div class="row">
								<div class="col-md-11">
								<div class="card">
										<div class="content">
								
								<?php
									$callDebitur = "{call SP_GET_FASILITAS_SLIK_DATA_POKOK_DEBITUR_NEW_MAPPING(?)}";
									$paramDebitur = array(array($id, SQLSRV_PARAM_IN));
									$execDebitur = sqlsrv_query( $conn, $callDebitur, $paramDebitur) or die( print_r( sqlsrv_defaults(), true));
									$noDebitur=0;
									while($dataDebitur = sqlsrv_fetch_array($execDebitur)){
										$noDebitur++;
									
									?>
									<p class="category">Data Pokok Debitur <?php echo $noDebitur?></p>
									<div class="card">
										<div class="content" style="padding:0px;">
									<div class="table-responsive">

									
							<table class="table table-bordered table-striped" border="1" id="history" style="font-size:12px;">
								<div class="row">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Nama Sesuai Identitas</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Identitas</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Jenis Kelamin / NPWP</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Tempat / Tgl Lahir</th>
										<th colspan="2" class="th-custom" style="color:#FFF;font-weight:bold;">Pelapor / Tanggal Update</th>
									</tr>
								</thead>
								
								<tbody>
									
									<tr> 
										<td class="td-center"><?php echo $dataDebitur['namaDebitur'];?></td>
										<td class="td-center"><?php if($dataDebitur['identitas'] == '1'){ echo "KTP";} echo   '/ ';echo $dataDebitur['noIdentitas'];?></td>
										<td class="td-center"><?php echo $dataDebitur['jenisKelaminKet'];echo   '/ ';echo $dataDebitur['npwp'];?></td>
										<td class="td-center"><?php echo $dataDebitur['tempatLahir'];echo   '/ ';echo date("Y-m-d", strtotime($dataDebitur['tanggalLahir']));?></td>
										<td  colspan="2"  class="td-center"><?php echo $dataDebitur['pelaporKet'];echo   '/ '; if($dataDebitur['tanggalUpdate']<>NULL){echo 	$dataDebitur['tanggalUpdate']->format('Y-m-d');
										}else{echo"-";}
										?> 
									</td>
									</tr>
									
									
								</tbody>
								
									<thead>
								
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Alamat</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Kelurahan</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Kecamatan</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Kabupaten / Kota</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Kode Pos</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Negara</th>
									</tr>
								</thead>
						
								<tbody>
									
									<tr> 
										<td class="td-center"><?php echo $dataDebitur['alamat'];?></td>
										<td class="td-center"><?php echo $dataDebitur['kelurahan'];?></td>
										<td class="td-center"><?php echo $dataDebitur['kecamatan'];?></td>
										<td class="td-center"><?php echo $dataDebitur['kabKotaKet'];?></td>
										<td class="td-center"><?php echo $dataDebitur['kodePos'];?></td>
										<td class="td-center"><?php echo $dataDebitur['negaraKet'];
										?> 
									</td>
									</tr>
									</thead>
										<thead>
										<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Pekerjaan</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Tempat Bekerja</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Bidang Usaha</th>
										<th colspan="3"  class="th-custom" style="color:#FFF;font-weight:bold;">Status Gelar Debitur</th>
										
									</tr>
								
								</tbody>
								<tbody>
									
									<tr> 
										<td class="td-center"><?php echo $dataDebitur['pekerjaanKet'];?></td>
										<td class="td-center"><?php echo $dataDebitur['tempatBekerja'];?></td>
										<td class="td-center"><?php echo $dataDebitur['bidangUsahaKet'];?></td>
										<td colspan="3"  class="td-center"><?php echo $dataDebitur['statusGelarDebitur'];?></td>
										
									</tr>
								</tbody>
								</table>
								
									</div>
										</div>	
										</div>		
									
									<?php } ?>
								
							
											
							</div>		
						</div>	
						</div>		
						</div>	
						
							<p >Ringkasan Fasilitas</p>
							<div class="row">
								
								<div class="col-md-11">
								<div class="card">
										<div class="content">
									<div class="table-responsive">
							<table class="table table-bordered table-striped" id="history" style="font-size:12px;">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Fasilitas</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Kredit/Pembiayaan(dalam IDR)</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Irrevocable L/C(dalam IDR)</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Garansi Yang Diberikan(dalam IDR)</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Fasilitas Lain (dalam IDR)</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Total (dalam IDR)</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Kualitas Terburuk / Bulan Data</th>
									</tr>
								</thead>
								<tbody>
								
									<tr> 
										<td class="td-center">Plafon Efektif</td>
										<td class="td-center"><?php echo number_format($dataHeader['plafonEfektifKreditPembiayaan'],0,',','.');?></td>
										<td class="td-center"><?php echo number_format($dataHeader['plafonEfektifLc'],0,',','.');?></td>
										<td class="td-center"><?php echo number_format($dataHeader['plafonEfektifGyd'],0,',','.');?></td>
										<td class="td-center"><?php echo number_format($dataHeader['plafonEfektifLain'],0,',','.');?></td>
										<td class="td-center"><?php echo number_format($dataHeader['plafonEfektifTotal'],0,',','.');?></td>
										<td class="td-center"><?php echo $dataHeader['kualitasTerburuk'];echo   '/ ';echo date("F Y", strtotime($dataHeader['kualitasBulanDataTerburuk']));?></td>
									</tr>
									<tr> 
										<td class="td-center">Baki Debet</td>
										<td class="td-center"><?php echo number_format($dataHeader['bakiDebetKreditPembiayaan'],0,',','.');?></td>
										<td class="td-center"><?php echo number_format($dataHeader['bakiDebetLc'],0,',','.');?></td>
										<td class="td-center"><?php echo number_format($dataHeader['bakiDebetGyd'],0,',','.');?></td>
										<td class="td-center"><?php echo number_format($dataHeader['bakiDebetLain'],0,',','.');?></td>
										<td class="td-center"><?php echo number_format($dataHeader['bakiDebetTotal'],0,',','.');?></td>
										<td class="td-center"><?php echo $dataHeader['kualitasTerburuk'];echo   '/';echo date("F Y", strtotime($dataHeader['kualitasBulanDataTerburuk']));?></td>
									</tr>
									
								</tbody>
							</table>
										</div>
								<div class="col-md-2">
								<label>Jumlah Kreditur : </label>&nbsp;&nbsp;
								</div>
								<div class="col-md-2">
								<label>Bank Umum</label>&nbsp;&nbsp;<input type="text" style="width:50px;"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataHeader['krediturBankUmum'];?>">
								</div>
								<div class="col-md-2">
								<label>BPR / BPRS</label>&nbsp;&nbsp;<input type="text" style="width:50px;"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataHeader['krediturBPR_S'];?>">
								</div>
								<div class="col-md-3">
								<label>Lembaga Pembiayaan</label>&nbsp;&nbsp;<input type="text" style="width:50px;"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataHeader['krediturLp'];?>">
								</div>
								<div class="col-md-3">
								<label>Lainnya</label>&nbsp;&nbsp;<input type="text" style="width:50px;"name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataHeader['krediturLainnya'];?>">
								</div>
								</div>	
								<br>
							</div>	
								</div>		
							</div>								
	
							<p>Kredit / Pembiayaan</p>
							<div class="row">
							
								<div class="col-md-11">
								<div class="card">
										<div class="content">
								
								<?php
									$callFasilitas = "{call SP_GET_FASILITAS_SLIK_FASILITAS_NEW_MAPPING(?)}";
									$paramFasilitas = array(array($id, SQLSRV_PARAM_IN));
									$execFasilitas = sqlsrv_query( $conn, $callFasilitas, $paramFasilitas) or die( print_r( sqlsrv_defaults(), true));
									$noFasilitas=0;
									while($dataFasilitas = sqlsrv_fetch_array($execFasilitas)){
										$noFasilitas++;
									
									?>
									<p class="category">Kredit / Pembiayaan <?php echo $noFasilitas?></p>
									<div class="card">
										<div class="content" style="padding:0px;">
									<div class="table-responsive">

									
							<table class="table table-bordered table-striped" border="1" id="history" style="font-size:12px;">
								<div class="row">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;width:200px;">Pelapor</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;width:200px;">Cabang</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;width:200px;">Baki Debet</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;width:200px;">Tanggal Update</th>
									</tr>
								</thead>
								<tbody>
								
									<tr> 
										<td class="td-center"><?php echo $dataFasilitas['ljk']; echo '-'; echo $dataFasilitas['ljkKet'];?></td>
										<td class="td-center"><?php echo $dataFasilitas['cabangKet'];?></td>
										<td class="td-center">Rp. <?php echo number_format($dataFasilitas['bakiDebet'],0,',','.');?></td> 
										<td class="td-center"><?php if ($dataFasilitas['tanggalUpdate'] == null){echo '-';}else{echo  $dataFasilitas['tanggalUpdate']->format('Y-m-d');}?></td>
									</tr>
									
								</tbody>
							</table>
							</div>
										</div>	
									<div class="table-responsive">

									
							<table class="table table-bordered" border="0" id="history" style="font-size:12px;">
								<div class="row">
									<tr> 
									
									<?php 
									$year = substr($dataFasilitas['tanggalAkadAwal'], 0, -4);
									$month = substr($dataFasilitas['tanggalAkadAwal'], 4,-2);
									$day = substr($dataFasilitas['tanggalAkadAwal'], 6);
									$tahun=$year."-".$month."-".$day;
									 ?>
									
										<td rowspan="3"class="td-center" style="width:100px;">Kualitas / Jumlah Hari Tunggakan</td>
										<td class="td-center"  style="width:100px;"><?php echo date("F Y", strtotime(substr($dataFasilitas['tahunBulan01'], 0, -2)."-".substr($dataFasilitas['tahunBulan01'], 4))); ?><br>
																	<input  type="text" style="width:30px;text-align: center"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan01Kol'];?>">
																	<input type="text" style="width:30px;text-align: center" name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan01Ht'];?>"></td>
										<td class="td-center"  style="width:100px;"><?php echo date("F Y", strtotime(substr($dataFasilitas['tahunBulan02'], 0, -2)."-".substr($dataFasilitas['tahunBulan02'], 4))); ?><br>
																	<input  type="text" style="width:30px;text-align: center"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan02Kol'];?>">
																	<input type="text" style="width:30px;text-align: center" name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan02Ht'];?>"></td>
										<td class="td-center" style="width:100px;"><?php echo date("F Y", strtotime(substr($dataFasilitas['tahunBulan03'], 0, -2)."-".substr($dataFasilitas['tahunBulan03'], 4))); ?><br>
																	<input  type="text" style="width:30px;text-align: center"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan03Kol'];?>">
																	<input type="text" style="width:30px;text-align: center" name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan03Ht'];?>"></td>
										<td class="td-center" style="width:100px;"><?php echo date("F Y", strtotime(substr($dataFasilitas['tahunBulan04'], 0, -2)."-".substr($dataFasilitas['tahunBulan04'], 4))); ?><br>
																	<input  type="text" style="width:30px;text-align: center"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan04Kol'];?>">
																	<input type="text" style="width:30px;text-align: center" name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan04Ht'];?>"></td>
										<td class="td-center" style="width:100px;"><?php echo date("F Y", strtotime(substr($dataFasilitas['tahunBulan05'], 0, -2)."-".substr($dataFasilitas['tahunBulan05'], 4))); ?><br>
																	<input  type="text" style="width:30px;text-align: center"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan05Kol'];?>">
																	<input type="text" style="width:30px;text-align: center" name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan05Ht'];?>"></td>
										<td class="td-center" style="width:100px;"><?php echo date("F Y", strtotime(substr($dataFasilitas['tahunBulan06'], 0, -2)."-".substr($dataFasilitas['tahunBulan06'], 4))); ?><br>
																	<input  type="text" style="width:30px;text-align: center"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan06Kol'];?>">
																	<input type="text" style="width:30px;text-align: center" name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan06Ht'];?>"></td>
										<td class="td-center" style="width:100px;"><?php echo date("F Y", strtotime(substr($dataFasilitas['tahunBulan07'], 0, -2)."-".substr($dataFasilitas['tahunBulan07'], 4))); ?><br>
																	<input  type="text" style="width:30px;text-align: center"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan07Kol'];?>">
																	<input type="text" style="width:30px;text-align: center" name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan07Ht'];?>"></td>
										<td class="td-center" style="width:100px;"><?php echo date("F Y", strtotime(substr($dataFasilitas['tahunBulan08'], 0, -2)."-".substr($dataFasilitas['tahunBulan08'], 4))); ?><br>
																	<input  type="text" style="width:30px;text-align: center"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan08Kol'];?>">
																	<input type="text" style="width:30px;text-align: center" name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan08Ht'];?>"></td>
										<td class="td-center" style="width:100px;"><?php echo date("F Y", strtotime(substr($dataFasilitas['tahunBulan09'], 0, -2)."-".substr($dataFasilitas['tahunBulan09'], 4))); ?><br>
																	<input  type="text" style="width:30px;text-align: center"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan09Kol'];?>">
																	<input type="text" style="width:30px;text-align: center" name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan09Ht'];?>"></td>
									<tr>
										<td class="td-center" style="width:100px;"><?php echo date("F Y", strtotime(substr($dataFasilitas['tahunBulan08'], 0, -2)."-".substr($dataFasilitas['tahunBulan08'], 4))); ?><br>
																	<input  type="text" style="width:30px;text-align: center"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan08Kol'];?>">
																	<input type="text" style="width:30px;text-align: center" name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan08Ht'];?>"></td>
										<td class="td-center" style="width:100px;"><?php echo date("F Y", strtotime(substr($dataFasilitas['tahunBulan09'], 0, -2)."-".substr($dataFasilitas['tahunBulan09'], 4))); ?><br>
																	<input  type="text" style="width:30px;text-align: center"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan09Kol'];?>">
																	<input type="text" style="width:30px;text-align: center" name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan09Ht'];?>"></td>
										<td class="td-center" style="width:100px;"><?php echo date("F Y", strtotime(substr($dataFasilitas['tahunBulan10'], 0, -2)."-".substr($dataFasilitas['tahunBulan10'], 4))); ?><br>
																	<input  type="text" style="width:30px;text-align: center"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan10Kol'];?>">
																	<input type="text" style="width:30px;text-align: center" name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan10Ht'];?>"></td>
										<td class="td-center"><?php echo date("F Y", strtotime(substr($dataFasilitas['tahunBulan11'], 0, -2)."-".substr($dataFasilitas['tahunBulan11'], 4))); ?><br>
																	<input  type="text" style="width:30px;text-align: center"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan11Kol'];?>">
																	<input type="text" style="width:30px;text-align: center" name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan11Ht'];?>"></td>
										<td class="td-center"><?php echo date("F Y", strtotime(substr($dataFasilitas['tahunBulan12'], 0, -2)."-".substr($dataFasilitas['tahunBulan12'], 4))); ?><br>
																	<input  type="text" style="width:30px;text-align: center"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan12Kol'];?>">
																	<input type="text" style="width:30px;text-align: center" name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan12Ht'];?>"></td>
										<td class="td-center"><?php echo date("F Y", strtotime(substr($dataFasilitas['tahunBulan13'], 0, -2)."-".substr($dataFasilitas['tahunBulan13'], 4))); ?><br>
																	<input  type="text" style="width:30px;text-align: center"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan13Kol'];?>">
																	<input type="text" style="width:30px;text-align: center" name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan13Ht'];?>"></td>
										<td class="td-center"><?php echo date("F Y", strtotime(substr($dataFasilitas['tahunBulan14'], 0, -2)."-".substr($dataFasilitas['tahunBulan14'], 4))); ?><br>
																	<input  type="text" style="width:30px;text-align: center"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan14Kol'];?>">
																	<input type="text" style="width:30px;text-align: center" name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan14Ht'];?>"></td>
										<td class="td-center"><?php echo date("F Y", strtotime(substr($dataFasilitas['tahunBulan15'], 0, -2)."-".substr($dataFasilitas['tahunBulan15'], 4))); ?><br>
																	<input  type="text" style="width:30px;text-align: center"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan15Kol'];?>">
																	<input type="text" style="width:30px;text-align: center" name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan15Ht'];?>"></td>
										<td class="td-center"><?php echo date("F Y", strtotime(substr($dataFasilitas['tahunBulan16'], 0, -2)."-".substr($dataFasilitas['tahunBulan16'], 4))); ?><br>
																	<input  type="text" style="width:30px;text-align: center"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan16Kol'];?>">
																	<input type="text" style="width:30px;text-align: center" name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan16Ht'];?>"></td>
									</tr>
									<tr>
										
										
										<td class="td-center"><?php echo date("F Y", strtotime(substr($dataFasilitas['tahunBulan17'], 0, -2)."-".substr($dataFasilitas['tahunBulan17'], 4))); ?><br>
																	<input  type="text" style="width:30px;text-align: center"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan17Kol'];?>">
																	<input type="text" style="width:30px;text-align: center" name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan17Ht'];?>"></td>
										<td class="td-center"><?php echo date("F Y", strtotime(substr($dataFasilitas['tahunBulan18'], 0, -2)."-".substr($dataFasilitas['tahunBulan18'], 4))); ?><br>
																	<input  type="text" style="width:30px;text-align: center"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan18Kol'];?>">
																	<input type="text" style="width:30px;text-align: center" name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan18Ht'];?>"></td>
										<td class="td-center"><?php echo date("F Y", strtotime(substr($dataFasilitas['tahunBulan19'], 0, -2)."-".substr($dataFasilitas['tahunBulan19'], 4))); ?><br>
																	<input  type="text" style="width:30px;text-align: center"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan19Kol'];?>">
																	<input type="text" style="width:30px;text-align: center" name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan19Ht'];?>"></td>
										<td class="td-center"><?php echo date("F Y", strtotime(substr($dataFasilitas['tahunBulan20'], 0, -2)."-".substr($dataFasilitas['tahunBulan20'], 4))); ?><br>
																	<input  type="text" style="width:30px;text-align: center"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan20Kol'];?>">
																	<input type="text" style="width:30px;text-align: center" name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan20Ht'];?>"></td>
										<td class="td-center"><?php echo date("F Y", strtotime(substr($dataFasilitas['tahunBulan21'], 0, -2)."-".substr($dataFasilitas['tahunBulan21'], 4))); ?><br>
																	<input  type="text" style="width:30px;text-align: center"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan21Kol'];?>">
																	<input type="text" style="width:30px;text-align: center" name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan21Ht'];?>"></td>
										<td class="td-center"><?php echo date("F Y", strtotime(substr($dataFasilitas['tahunBulan22'], 0, -2)."-".substr($dataFasilitas['tahunBulan22'], 4))); ?><br>
																	<input  type="text" style="width:30px;text-align: center"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan22Kol'];?>">
																	<input type="text" style="width:30px;text-align: center" name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan22Ht'];?>"></td>
										<td class="td-center"><?php echo date("F Y", strtotime(substr($dataFasilitas['tahunBulan23'], 0, -2)."-".substr($dataFasilitas['tahunBulan23'], 4))); ?><br>
																	<input  type="text" style="width:30px;text-align: center"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan23Kol'];?>">
																	<input type="text" style="width:30px;text-align: center" name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan23Ht'];?>"></td>
										<td class="td-center"><?php echo date("F Y", strtotime(substr($dataFasilitas['tahunBulan24'], 0, -2)."-".substr($dataFasilitas['tahunBulan24'], 4))); ?><br>
																	<input  type="text" style="width:30px;text-align: center"  name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan24Kol'];?>">
																	<input type="text" style="width:30px;text-align: center" name="bankumum" id="bankumum" autocomplete="off" readonly value="<?php echo $dataFasilitas['tahunBulan24Ht'];?>"></td>
									</tr>
								
							
								
									
								
							</table>
									</div>
										</div>	
										
						
							<table class="table table-bordered" border="0" id="history" style="font-size:12px;">
								
								<tr>
									<td class="td-left">No Rekening</td>
									<td class="td-left"><?php echo $dataFasilitas['noRekening'];?></td>
									<td class="td-left" >Kualitas</td>
									<td class="td-left" ><?php echo $dataFasilitas['kualitas']."-".$dataFasilitas['kualitasKet'];?></td>
								</tr>
								
								<tr>
									<td class="td-left">Sifat Kredit/Pembiayaan</td>
									<td class="td-left"><?php echo $dataFasilitas['sifatKreditPembiayaanKet'];?></td>
									<td class="td-left" >Jumlah Hari Tunggakan</td>
									<td class="td-left"><?php echo $dataFasilitas['jumlahHariTunggakan'];?></td>
								</tr>
								
								<tr>
									<td class="td-left">Jenis Kredit/Pembiayaan</td>
									<td class="td-left"><?php echo $dataFasilitas['jenisKreditPembiayaanKet'];?></td>
									<td class="td-left" >Nilai Proyek</td>
									<td class="td-left"><?php echo $dataFasilitas['nilaiProyek'];?></td>
								</tr>
								
								<tr>
									<td class="td-left">Akad Kredit/Pembiayaan</td>
									<td class="td-left"><?php echo $dataFasilitas['akadKreditPembiayaanKet'];?></td>
									<td class="td-left" >Plafon Awal</td>
									<td class="td-left">Rp. <?php echo number_format($dataFasilitas['plafonAwal'],0,',','.');?></td>
								</tr>
								
								<tr>
									<td class="td-left">Frekuensi Perpanjangan Kredit/Pembiayaan</td>
									<td class="td-left"><?php echo $dataFasilitas['frekPerpjganKreditPembiayaan'];?></td>
									<td class="td-left" >Plafon</td>
									<td class="td-left">Rp. <?php echo number_format($dataFasilitas['plafon'],0,',','.');?></td>
								</tr>
								
								<tr>
									<td class="td-left">No Akad Awal</td>
									<td class="td-left"><?php echo $dataFasilitas['noAkadAwal'];?></td>
									<td class="td-left" >Realisasi/Pencairan Bulan Berjalan</td>
									<td class="td-left"><?php echo $dataFasilitas['realisasiBulanBerjalan'];?></td>
								</tr>
								
								<tr>
									<td class="td-left">Tanggal Akad Awal</td>
									<td class="td-left"><?php if($dataFasilitas['tanggalAwalKredit']<>NULL){echo $dataFasilitas['tanggalAwalKredit']->format('d F Y');}else{echo"-";}?></td>
									<td class="td-left" >Nilai dalam Mata Uang Asal</td>
									<td class="td-left"><?php echo $dataFasilitas['nilaiDalamMataUangAsal'];?></td>
								</tr>
								
								<tr>
									<td class="td-left">No Akad Akhir</td>
									<td class="td-left"><?php echo $dataFasilitas['noAkadAkhir'];?></td>
									<td class="td-left" >Sebab Macet</td>
									<td class="td-left"><?php echo $dataFasilitas['sebabMacetKet'];?></td>
								</tr>
								<tr>
									<td class="td-left">Tanggal Akad Akhir</td>
									<td class="td-left"><?php if($dataFasilitas['tanggalAkadAkhir']<>NULL){echo $dataFasilitas['tanggalAkadAkhir']->format('d F Y');}else{echo"-";}?></td>
									<td class="td-left" >Tanggal Macet</td>
									<td class="td-left"><?php if($dataFasilitas['tanggalMacet']<>''){
										echo date("d F Y", strtotime(substr($dataFasilitas['tanggalMacet'], 0, -4)."-".substr($dataFasilitas['tanggalMacet'], 4,-2)."-".substr($dataFasilitas['tanggalMacet'], 6)));
										}else{
											echo '-';
										}										?></td></tr>
								
								<tr>
									<td class="td-left">Tanggal Awal Kredit</td>
									<td class="td-left"><?php if($dataFasilitas['tanggalAwalKredit']<>NULL){echo $dataFasilitas['tanggalAwalKredit']->format('d F Y');}else{echo"-";}?></td>
									
									<td class="td-left" >Tunggakan Pokok</td>
									<td class="td-left">Rp. <?php echo number_format($dataFasilitas['tunggakanPokok'],0,',','.');?></td>
								</tr>
								
								<tr>
									<td class="td-left">Tanggal Mulai</td>
									<td class="td-left"><?php if($dataFasilitas['tanggalMulai']<>NULL){echo $dataFasilitas['tanggalMulai']->format('d F Y');}else{echo"-";}?></td>
									
									<td class="td-left" >Tunggakan Bunga</td>
									<td class="td-left">Rp. <?php echo number_format($dataFasilitas['tunggakanBunga'],0,',','.');?></td>
								</tr>
								
								<tr>
									<td class="td-left">Tanggal Jatuh Tempo</td>
									<td class="td-left"><?php if($dataFasilitas['tanggalJatuhTempo']<>NULL){echo $dataFasilitas['tanggalJatuhTempo']->format('d F Y');}else{echo"-";}?></td>
							
									<td class="td-left" >Frekuensi Tunggakan</td>
									<td class="td-left"><?php echo $dataFasilitas['frekuensiTunggakan'];?></td>
								</tr>
								
								<tr>
									<td class="td-left">Kategori Debitur</td>
									<td class="td-left"><?php echo $dataFasilitas['kategoriDebiturKet'];?></td>
									<td class="td-left" >Denda</td>
									<td class="td-left">Rp. <?php echo number_format($dataFasilitas['denda'],0,',','.');?></td>
								</tr>
								
								<tr>
									<td class="td-left">Jenis Penggunaan</td>
									<td class="td-left"><?php echo $dataFasilitas['jenisPenggunaanKet'];?></td>
									<td class="td-left" >Frekuensi Restrukturisasi</td>
									<td class="td-left"><?php echo $dataFasilitas['frekuensiTunggakan'];?></td>
								</tr>
								
								<tr>
									<td class="td-left">Sektor Ekonomi</td>
									<td class="td-left"><?php echo $dataFasilitas['sektorEkonomiKet'];?></td>
									<td class="td-left" >Tanggal Restrukturisasi Akhir</td>
									<td class="td-left"><?php echo $dataFasilitas['tanggalRestrukturisasiAkhir'];?></td>
								</tr>
								
								<tr>
									<td class="td-left">Kredit Program Pemerintah</td>
									<td class="td-left"><?php echo $dataFasilitas['kreditProgramPemerintahKet'];?></td>
									<td class="td-left" >Cara Restrukturisasi</td>
									<td class="td-left"><?php echo $dataFasilitas['restrukturisasiKet'];?></td>
								</tr>
								
								<tr>
									<td class="td-left">Kab/Kota Lokasi Proyek</td>
									<td class="td-left"><?php echo $dataFasilitas['lokasiProyekKet'];?></td>
									<td class="td-left" >Kondisi</td>
									<td class="td-left"><?php echo $dataFasilitas['kondisiKet'];?></td>
								</tr>
								
								<tr>
									<td class="td-left">Valuta</td>
									<td class="td-left"><?php echo $dataFasilitas['valutaKode'];?></td>
									<td class="td-left" >Tanggal Kondisi</td>
									<td class="td-left">
									<?php if($dataFasilitas['tanggalKondisi']<>''){
										echo date("d F Y", strtotime(substr($dataFasilitas['tanggalKondisi'], 0, -4)."-".substr($dataFasilitas['tanggalKondisi'], 4,-2)."-".substr($dataFasilitas['tanggalKondisi'], 6)));
										}else{
											echo '-';
										}
									 ?></td>
								</tr>
								
								<tr>
									<td class="td-left">Suku Bunga/Imbalan</td>
									<td class="td-left"><?php echo $dataFasilitas['sukuBungaImbalan']; echo "%"; ?></td>
									<td class="td-left" >Jenis Suku Bunga/Imbalan</td>
									<td class="td-left"><?php echo $dataFasilitas['jenisSukuBungaImbalanKet'];?></td>
								</tr>
								
								<tr>
									<td class="td-left">Keterangan</td>
									<td colspan="3"class="td-left"><?php echo $dataFasilitas['keterangan'];?></td>
								
								</tr>
								
								
											
							</table>
								<p class="category">Agunan</p>
								<?php if($dataFasilitas['nomorAgunan'] != ''){?>
								<table class="table table-bordered table-striped" border="1" id="history" style="font-size:12px;">
								<div class="row">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;width:200px;">Jenis Agunan</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;width:200px;">Nilai Agunan</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;width:200px;">Paripasu</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;width:200px;">Tanggal Update</th>
									</tr>
								</thead>
								<tbody>
								
									<tr> 
										<td class="td-center"><?php echo $dataFasilitas['ljk']; echo '-'; echo $dataFasilitas['ljkKet'];?></td>
										<td class="td-center">Rp. <?php echo number_format($dataFasilitas['nilaiAgunanMenurutLJK'],0,',','.');?></td> 
										<td class="td-center"><?php echo $dataFasilitas['prosentaseParipasu'];?></td>
										<td class="td-center"><?php if ($dataFasilitas['tanggalUpdate'] == null){echo '-';}else{echo  $dataFasilitas['tanggalUpdate']->format('Y-m-d');}?></td>
									</tr>
									
								</tbody>
							</table>
							<table class="table table-bordered" border="0" id="history" style="font-size:12px;">
								
								<tr>
									<td class="td-left">Nomor Agunan</td>
									<td class="td-left"><?php echo $dataFasilitas['nomorAgunan'];?></td>
									<td class="td-left" >Peringkat Agunan</td>
									<td class="td-left" ><?php echo $dataFasilitas['peringkatAgunan'];?></td>
								</tr>
								<tr>
									<td class="td-left">Jenis Pengikatan</td>
									<td class="td-left"><?php echo $dataFasilitas['jenisPengikatanKet'];?></td>
									<td class="td-left" >Lembaga Pemeringkat</td>
									<td class="td-left" ><?php echo $dataFasilitas['lembagaPemeringkat'];?></td>
								</tr>
								<tr>
									<td class="td-left">Tanggal Pengikatan</td>
									<td class="td-left"><?php if($dataFasilitas['tanggalPengikatan']<>NULL){echo $dataFasilitas['tanggalPengikatan']->format('d F Y');}else{echo"-";}?></td>
									<td class="td-left" >Bukti Kepemilikan</td>
									<td class="td-left" ><?php echo $dataFasilitas['buktiKepemilikan'];?></td>
								</tr>
								<tr>
									<td class="td-left">Nama Pemilik Agunan</td>
									<td class="td-left"><?php echo $dataFasilitas['namaPemilikAgunan'];?></td>
									<td class="td-left" >Nilai Agunan (NJOP) / Nilai Wajar</td>
									<td class="td-left" >Rp. <?php echo number_format($dataFasilitas['nilaiAgunanNjop'],0,',','.');?></td>
								</tr>
								<tr>
									<td class="td-left">Alamat Agunan</td>
									<td class="td-left"><?php echo $dataFasilitas['alamatAgunan'];?></td>
									<td class="td-left" >Nilai Agunan Penilai Independen</td>
									<td class="td-left" ><?php echo $dataFasilitas['nilaiAgunanIndep'];?></td>
								</tr>
								<tr>
									<td class="td-left">Kab/Kota Lokasi Agunan</td>
									<td class="td-left"><?php echo $dataFasilitas['kabKotaLokasiAgunanKet'];?></td>
									<td class="td-left" >Nama Penilai Independen</td>
									<td class="td-left" ><?php echo $dataFasilitas['namaPenilaiIndep'];?></td>
								</tr>
								<tr>
									<td class="td-left">Tanggal Penilaian Pelapor</td>
									<td class="td-left"><?php echo date("d F Y", strtotime(substr($dataFasilitas['tglPenilaianPelapor'], 0, -4)."-".substr($dataFasilitas['tglPenilaianPelapor'], 4,-2)."-".substr($dataFasilitas['tglPenilaianPelapor'], 6))); ?></td>
									<td class="td-left" >Asuransi</td>
									<td class="td-left" ><?php echo $dataFasilitas['asuransi'];?></td>
								</tr>
								<tr>
									<td class="td-left">Keterangan</td>
									<td class="td-left"><?php echo $dataFasilitas['keteranganAgunan'];?></td>
									<td class="td-left" >Tgl Penilaian Penilai Independen</td>
									<td class="td-left" ><?php echo date("d F Y", strtotime(substr($dataFasilitas['tanggalPenilaianPenilaiIndependen'], 0, -4)."-".substr($dataFasilitas['tanggalPenilaianPenilaiIndependen'], 4,-2)."-".substr($dataFasilitas['tanggalPenilaianPenilaiIndependen'], 6))); ?></td>
								</tr>
							</table>
								<?php } else {  ?>
										<br>
									<?php } } ?>
								
							
											
							</div>		
						</div>	
						</div>		
						</div>	
							
							
							
							
							
							
							
							
						<?php /* ?>
							<div class="row">
								<div class="col-md-11">
									<?php
										$callPDF = "{call SP_GET_PDF_SLIK_NEW_MAPPING(?)}";
										$paramPDF = array(array($id, SQLSRV_PARAM_IN));
										$execPDF = sqlsrv_query($conn, $callPDF, $paramPDF) or die( print_r( sqlsrv_defaults(), true));
										$dataPDF = sqlsrv_fetch_array($execPDF);

										
										$file = "http://172.16.2.6/h2h_pefindo/assets/doc/".$dataPDF['PDF_SRC'];
										
										if($dataPDF['PDF_SRC'] <> ""){
											if($file){
												echo'<iframe src="http://172.16.2.6/h2h_pefindo/assets/doc/'.$dataPDF['PDF_SRC'].'" style="width:100%;height:700px;"></iframe>';
												echo'a';
											}else{
												echo'<iframe src="http://172.16.2.6/h2h_pefindo/assets/doc/notfound.pdf" style="width:100%;height:700px;"></iframe>';
												echo'b';
											}
										}else{
											echo'<iframe src="http://172.16.2.6/h2h_pefindo/assets/doc/notfound.pdf" style="width:100%;height:700px;"></iframe>';
												echo'c';
										}
									?>
								</div>
							</div>
						*/	?>
									
						</div>	
				
						


						
					</div>
				</div>

<?php
				}else{
			?>
				<div class="content">
					<div class="card">
						<div class="header">
							<div class="row">
								<div class="col-md-12">
									<center>
										<h3>DATA <?php echo $data['CUST_NAME'];?> <br>TIDAK DITEMUKAN DI PEFINDO DAN SLIK</h3><br>
									</center>
									<br><br>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
				}
			?>









<script type="text/javascript">
	$(window).on("load", function(){
		setTimeout(function(){
			$("#loader").fadeOut("slow");
		}, 2000);
	});
</script>
<script>
$('tr.header').click(function(){
    $(this).nextUntil('tr.header').css('display', function(i,v){
        return this.style.display === 'table-row' ? 'none' : 'table-row';
    });
});
</script>