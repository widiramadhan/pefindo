<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Host to Host SFI - Pefindo</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/animate.min.css" rel="stylesheet"/>
    <link href="assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet"/>
    <link href="assets/css/demo.css" rel="stylesheet" />
	<link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link href='assets/css/fonts.css' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
	<link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css" type="text/css">
	<link rel="stylesheet" href="assets/css/jquery-ui.css">
	<link rel="stylesheet" href="assets/plugins/fancybox/source/jquery.fancybox.css?v=2.1.7" type="text/css" media="screen" />	
	<link rel="stylesheet" href="assets/css/lightbox.css" type="text/css" media="screen" />
	
    <script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
</head>

<?php
require_once("config/configuration.php");
require_once("config/connection.php");
$noProsepekPemohonSLIK=$_GET['no'];
$cust_type=$_GET['custtype'];
$id=$_GET['id'];

$callSP = "{call SP_GET_SLIK_INDIVIDUAL_REPORT(?,?)}";
$options = array( "Scrollable" => "buffered" );
$params = array(array($noProsepekPemohonSLIK, SQLSRV_PARAM_IN),array($cust_type, SQLSRV_PARAM_IN));
$exec = sqlsrv_query( $conn, $callSP, $params, $options) or die( print_r( sqlsrv_errors(), true));
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
					<h4 class="title">SCORING REPORT <?php echo $data['TIPE_CUST'];?></h4>
					<p class="category">Host to Host SFI - Pefindo</p>
				</div>
				<div style="clear:both;"></div>
			</div>
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
								<div class="col-md-3 col-sm-3">
									<div class="table-responsive">
										<table id="datatable1" class="table table-bordered" style="width:100%">
											<thead>
												<tr>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">Fasilitas Aktif</th>
												</tr>
											</thead>
										</table>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-sm-12" style="overflow-x: auto;">Pemohon
									<div class="table-responsive">
										<table id="datatable" class="table table-bordered" style="width:100%">
											<thead>
												<tr>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">No</th>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">Nama Pemberi Fasilitas</th>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">Jenis Fasilitas</th>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">Plafon</th>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">Tanggal Akad Awal</th>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">Tanggal Akad Akhir</th>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">Tenor</th>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">Sisa Tenor</th>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">Baki Debet</th>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">Angsuran</th>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">OD</th>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">Keterangan Status</th>
													<!-- <th class="th-custom" style="color:#FFF;font-weight:bold;">Sisa Tenor</th> -->
													<th class="th-custom" style="color:#FFF;font-weight:bold;">Restruktur</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$totalPlafondPemohon = 0;
												$totalBakiDebetPemohon = 0;
												$totalAngsuranPemohon = 0;

												$totalNaPlafondPemohon = 0;
												$totalNaBakiDebetPemohon = 0;
												$totalNaAngsuranPemohon = 0;

												$callPefindoPemohon = "{call SP_SLIK_SUMMARY_FASILITAS_AKTIF(?)}";
												$paramPefindoPemohon =  array(array($id, SQLSRV_PARAM_IN));
												$execPefindoPemohon = sqlsrv_query($conn, $callPefindoPemohon, $paramPefindoPemohon) or die(print_r(sqlsrv_errors(), true));

												$callPefindoNaPemohon = "{call SP_SLIK_SUMMARY_FASILITAS_NONAKTIF(?)}";
												$paramPefindoNaPemohon =  array(array($id, SQLSRV_PARAM_IN));
												$execPefindoNaPemohon = sqlsrv_query($conn, $callPefindoNaPemohon, $paramPefindoNaPemohon) or die(print_r(sqlsrv_errors(), true));
												$num_rows = sqlsrv_num_rows($execPefindoPemohon);
												$no = 0;

												while ($rowGetProspect = sqlsrv_fetch_array($execPefindoPemohon)) {
													$no++;
													$totalPlafondPemohon = +$totalPlafondPemohon + $rowGetProspect['PLAFON'];
													$totalBakiDebetPemohon = +$totalBakiDebetPemohon + $rowGetProspect['BAKI_DEBET'];
													$totalAngsuranPemohon = +$totalAngsuranPemohon + $rowGetProspect['ANGSURAN'];

													//echo $percent;
												?>
													<tr>
														<td class="td-custom" style="padding:5px;"><?php echo $no; ?></td>
														<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspect['PEMBERI_CREDIT']; ?></td>
														<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspect['CONTRACT_TYPE']; ?></td>
														<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($rowGetProspect['PLAFON'], 0, ',', '.'); ?></td>
														<td class="td-custom" style="padding:5px;"><?php if ($rowGetProspect['TANGGAL_AKAD_AWAL'] <> NULL) {
																										echo $rowGetProspect['TANGGAL_AKAD_AWAL']->format('Y-m-d');
																									} else {
																										echo "-";
																									} ?></td>
														<td class="td-custom" style="padding:5px;"><?php if ($rowGetProspect['TGL_JATUH_TEMPO'] <> NULL) {
																										echo $rowGetProspect['TGL_JATUH_TEMPO']->format('Y-m-d');
																									} else {
																										echo "-";
																									} ?></td>
														<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspect['TENOR']; ?></td>
														<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspect['SISA_TENOR']; ?></td>
														<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($rowGetProspect['BAKI_DEBET'], 0, ',', '.'); ?></td>
														<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($rowGetProspect['ANGSURAN'], 0, ',', '.'); ?></td>
														<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspect['OD']; ?></td>
														<!-- <td class="td-custom" style="padding:5px;"><?php //echo $rowGetProspectPasangan['SISA_TENOR'];
																										?></td> -->
														<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspect['CONTRACT_STATUS']; ?></td>
														<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspect['RESTRUKTUR']; ?></td>


													</tr>
												<?php } ?>
												</tr>
												<td class="td-custom" style="padding:5px;"></td>
												<td class="td-custom" style="padding:5px;">TOTAL</td>
												<td class="td-custom" style="padding:5px;"></td>
												<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($totalPlafondPemohon, 0, ',', '.'); ?></td>
												<td class="td-custom" style="padding:5px;"></td>
												<td class="td-custom" style="padding:5px;"></td>
												<td class="td-custom" style="padding:5px;"></td>
												<td class="td-custom" style="padding:5px;"></td>
												<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($totalBakiDebetPemohon, 0, ',', '.'); ?></td>
												<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($totalAngsuranPemohon, 0, ',', '.'); ?></td>
												<td class="td-custom" style="padding:5px;"></td>
												<td class="td-custom" style="padding:5px;"></td>
												<td class="td-custom" style="padding:5px;"></td>
												<td class="td-custom" style="padding:5px;"></td>
												</tr>
											</tr>
										</tbody>
										</table>
									</div>
								</div>
							</div>
							


							<div class="row" style="margin-top: 2%">
								<div class="col-md-3 col-sm-3">
									<div class="table-responsive">
										<table id="datatable1" class="table table-bordered" style="width:100%">
											<thead>
												<tr>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">Fasilitas Non Aktif</th>
												</tr>
											</thead>
										</table>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12 col-sm-12" style="overflow-x: auto;">
									<div class="table-responsive">
										<table id="datatable" class="table table-bordered" style="width:100%">
											<thead>
												<tr>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">No</th>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">Nama Pemberi Fasilitas</th>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">Jenis Fasilitas</th>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">Plafon</th>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">Tanggal Akad Awal</th>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">Tanggal Akad Akhir</th>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">Tenor</th>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">Sisa Tenor</th>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">Baki Debet</th>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">Angsuran</th>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">OD</th>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">Keterangan Status</th>
													<!-- <th class="th-custom" style="color:#FFF;font-weight:bold;">Sisa Tenor</th> -->
													<th class="th-custom" style="color:#FFF;font-weight:bold;">Restruktur</th>
												</tr>
											</thead>
											<tbody>
												<?php

												$num_rows = sqlsrv_num_rows($execPefindoNaPemohon);
												$no = 0;

												while ($rowGetProspectNa = sqlsrv_fetch_array($execPefindoNaPemohon)) {
													$no++;
													$totalNaPlafondPemohon = +$totalNaPlafondPemohon + $rowGetProspectNa['PLAFON'];
													$totalNaBakiDebetPemohon = +$totalNaBakiDebetPemohon + $rowGetProspectNa['BAKI_DEBET'];
													$totalNaAngsuranPemohon = +$totalNaAngsuranPemohon + $rowGetProspectNa['ANGSURAN'];

													//echo $percent;
												?>
													<tr>
														<td class="td-custom" style="padding:5px;"><?php echo $no; ?></td>
														<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectNa['PEMBERI_CREDIT']; ?></td>
														<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectNa['CONTRACT_TYPE']; ?></td>
														<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($rowGetProspectNa['PLAFON'], 0, ',', '.'); ?></td>
														<td class="td-custom" style="padding:5px;"><?php if ($rowGetProspectNa['TANGGAL_AKAD_AWAL'] <> NULL) {
																										echo $rowGetProspectNa['TANGGAL_AKAD_AWAL']->format('Y-m-d');
																									} else {
																										echo "-";
																									} ?></td>
														<td class="td-custom" style="padding:5px;"><?php if ($rowGetProspectNa['TGL_JATUH_TEMPO'] <> NULL) {
																										echo $rowGetProspectNa['TGL_JATUH_TEMPO']->format('Y-m-d');
																									} else {
																										echo "-";
																									} ?></td>
														<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectNa['TENOR']; ?></td>
														<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectNa['SISA_TENOR']; ?></td>
														<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($rowGetProspectNa['BAKI_DEBET'], 0, ',', '.'); ?></td>
														<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($rowGetProspectNa['ANGSURAN'], 0, ',', '.'); ?></td>
														<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectNa['OD']; ?></td>
														<!-- <td class="td-custom" style="padding:5px;"><?php //echo $rowGetProspectNaPasangan['SISA_TENOR'];
																										?></td> -->
														<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectNa['CONTRACT_STATUS']; ?></td>
														<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectNa['RESTRUKTUR']; ?></td>


													</tr>
												<?php } ?>
												</tr>
												<td class="td-custom" style="padding:5px;"></td>
												<td class="td-custom" style="padding:5px;">TOTAL</td>
												<td class="td-custom" style="padding:5px;"></td>
												<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($totalNaPlafondPemohon, 0, ',', '.'); ?></td>
												<td class="td-custom" style="padding:5px;"></td>
												<td class="td-custom" style="padding:5px;"></td>
												<td class="td-custom" style="padding:5px;"></td>
												<td class="td-custom" style="padding:5px;"></td>
												<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($totalNaBakiDebetPemohon, 0, ',', '.'); ?></td>
												<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($totalNaAngsuranPemohon, 0, ',', '.'); ?></td>
												<td class="td-custom" style="padding:5px;"></td>
												<td class="td-custom" style="padding:5px;"></td>
												<td class="td-custom" style="padding:5px;"></td>
												<td class="td-custom" style="padding:5px;"></td>



												</tr>
												</tr>

											</tbody>
										</table>
									</div>
								</div>
							</div>
							
						
							<div class="row" style="margin-top: 2%">
								<div class="col-md-6 col-sm-6">
									<div class="table-responsive">
										<table id="datatable2" class="table table-bordered" style="width:100%">
											<thead>
												<tr>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">Keterangan</th>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">Jumlah</th>
													<th class="th-custom" style="color:#FFF;font-weight:bold;">Amount angsuran / bln</th>

												</tr>
											</thead>
											<tbody>
												<?php
												
													$callPemohonScore = "{call SP_RAK_GET_SLIK_COUNT_LUNAS_NEW_NEW_2025(?)}";
													$paramPemohonScore =  array(array($id, SQLSRV_PARAM_IN));
													$execPemohonScore = sqlsrv_query($conn, $callPemohonScore, $paramPemohonScore) or die(print_r(sqlsrv_errors(), true));
													$dataPemohonScore = sqlsrv_fetch_array($execPemohonScore);
												//echo $percent;
												?>
												<tr>
													<td class="td-custom" style="padding:5px;">Fasilitas Aktif</td>
													<td class="td-custom" style="padding:5px;"><?php echo $dataPemohonScore['FASILITAS_AKTIF']; ?></td>
													<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPemohonScore['ANGSURAN_AKTIF'], 0, ',', '.'); ?></td>
												</tr>
												<tr>
													<td class="td-custom" style="padding:5px;">Fasilitas Non Aktif</td>
													<td class="td-custom" style="padding:5px;"><?php echo $dataPemohonScore['FASILITAS_NON_AKTIF']; ?></td>
													<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPemohonScore['ANGSURAN_NON_AKTIF'], 0, ',', '.'); ?></td>
												</tr>
												<tr>
													<td class="td-custom" style="padding:5px;">Fasilitas Restruktur Aktif</td>
													<td class="td-custom" style="padding:5px;"><?php echo $dataPemohonScore['FASILITAS_RESTRUKTUR']; ?></td>
													<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPemohonScore['ANGSURAN_RESTRUKTUR'], 0, ',', '.'); ?></td>
												</tr>
											</tbody>
										</table>


									</div>
								</div>
							</div>																				


					</div>
				</div>
		</div>
	</div>
</div>

	<script src="assets/js/jquery-ui.js"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="assets/js/chartist.min.js"></script>
    <script src="assets/js/bootstrap-notify.js"></script>
	<script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>
	<script src="assets/js/demo.js"></script>
	<script src="assets/js/jquery.maskedinput.js"></script>
	<script src="assets/js/jquery.dataTables.min.js"></script>
	<script src="assets/js/dataTables.bootstrap4.min.js"></script>
	<script src="assets/plugins/fancybox/lib/jquery.mousewheel.pack.js"></script>
	<script src="assets/plugins/fancybox/source/jquery.fancybox.pack.js?v=2.1.7"></script>
</html>
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