<?php
require_once("config/configuration.php");
$id=$_GET['id'];
$date=date("Y-m-d");

$curl = curl_init();
?>
<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
<!-- jquery ui -->
<link rel="stylesheet" href="assets/css/jquery-ui.css">
<script src="assets/js/jquery-ui.js"></script>
<!-- end jquery ui -->

<!-- Datatable -->
<link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css" type="text/css">
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.bootstrap4.min.js"></script>
<!-- End Datatable -->
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
<?php
$callSP = "{call SP_GET_MASTER_COMPANY(?)}";
$params = array(array($id, SQLSRV_PARAM_IN));
$exec = sqlsrv_query( $conn, $callSP, $params) or die( print_r( sqlsrv_errors(), true));
$data = sqlsrv_fetch_array($exec);
?>
<div class="loader" id="loader"></div>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<div class="pull-left">
					<h4 class="title">Scoring Report</h4>
					<p class="category">Host to Host SFI - Pefindo</p>
				</div>
				<!--<div class="pull-right">
					<a href="pages/getPDF.php?USERNAME=<?php echo $user;?>&id=<?php echo $id;?>&type=<?php echo $data['CUST_TYPE'];?>"" target="_blank" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Export Report to PDF</a>&nbsp;
					<a href="pages/getExcel.php?USERNAME=<?php echo $user;?>&id=<?php echo $id;?>" target="_blank" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Export Summary to Excel</a>
				</div>-->
				<div style="clear:both;"></div>
			</div>
			<div class="content">
				<div id="accordion">
					<div class="card">
						<div class="header">
							<div class="pull-left">
								<p class="name text-danger"><?php echo $data['COMPANY'];?></p>
							</div>
							<div class="pull-right">
								<a class="card-link" data-toggle="collapse" href="#collapseOne">
									<i class="fa fa-chevron-down text-danger"></i>
								</a>
							</div>
							<div style="clear:both"></div>
						</div>
						<div id="collapseOne" class="collapse content" data-parent="#accordion">
							<div class="table-responsive">
								<table class="table table-borderless">
									<tbody>
										<tr>
											<td>NPWP</td>
											<td><?php echo $data['NPWP'];?></td>
											<td>Pefindo ID</td>
											<td><?php echo $data['PEFINDO_ID'];?></td>
										</tr>
										<tr>
											<td>Status</td>
											<td><?php echo $data['LEGAL_FORM'];?></td>
											<td rowspan="2" style="vertical-align:top;">Establishment</td>
											<td rowspan="2" style="vertical-align:top;"><?php echo $data['ESTABILISHMENT_DATE']->format('Y-m-d');?></td>
										</tr>
										<tr>
											<td>Credit Data Available</td>
											<td>Ya</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#summary">Summary</a></li>
					<li><a data-toggle="tab" href="#dashboard">Dashboard</a></li>
					<li><a data-toggle="tab" href="#informasi-perusahaan">Informasi perusahaan</a></li>
					<li><a data-toggle="tab" href="#skorPS">Skor PS</a></li>
					<li><a data-toggle="tab" href="#pefindo-alert-quest">PEFINDO Alert Quest</a></li>
					<li><a data-toggle="tab" href="#fasilitas">Fasilitas</a></li>
					<li><a data-toggle="tab" href="#agunan">Agunan</a></li>
					<li><a data-toggle="tab" href="#surat-berharga">Surat Berharga</a></li>
					<li><a data-toggle="tab" href="#tagihan-lainnya">Tagihan Lainnya</a></li>
					<li><a data-toggle="tab" href="#penyertaan">Penyertaan</a></li>
					<li><a data-toggle="tab" href="#hubungan">Hubungan</a></li>
					<li><a data-toggle="tab" href="#permintaan-informasi">Permintaan Informasi</a></li>
					<li><a data-toggle="tab" href="#pengaduan">Pengaduan</a></li>
					<li><a data-toggle="tab" href="#financial">Financial Statement</a></li>
				</ul>
				<br>
				<div class="tab-content">
					<div id="summary" class="tab-pane fade in active">
						<?php require_once("pages/company/tab-summary-company.php");?>
					</div>
					<div id="dashboard" class="tab-pane fade">
						<?php require_once("pages/company/tab-dashboard-company.php");?>
					</div>
					<div id="informasi-perusahaan" class="tab-pane fade">
						<?php require_once("pages/company/tab-informasi-perusahaan-company.php");?>
					</div>
					<div id="skorPS" class="tab-pane fade">
						<?php require_once("pages/company/tab-skor-ps-company.php");?>
					</div>
					<div id="pefindo-alert-quest" class="tab-pane fade">
						<?php //require_once("pages/company/tab-PAQ-company.php");?>
					</div>
					<div id="fasilitas" class="tab-pane fade">
						<?php require_once("pages/company/tab-fasilitas-company.php");?>
					</div>
					<div id="agunan" class="tab-pane fade">
						<?php require_once("pages/company/tab-agunan-company.php");?>
					</div>
					<div id="surat-berharga" class="tab-pane fade">
						<?php require_once("pages/company/tab-surat-berharga-company.php");?>
					</div>
					<div id="tagihan-lainnya" class="tab-pane fade">
						<?php require_once("pages/company/tab-tagihan-lainnya-company.php");?>
					</div>
					<div id="penyertaan" class="tab-pane fade">
						<?php require_once("pages/company/tab-penyertaan-company.php");?>
					</div>
					<div id="hubungan" class="tab-pane fade">
						<?php require_once("pages/company/tab-hubungan-company.php");?>
					</div>
					<div id="permintaan-informasi" class="tab-pane fade">
						<?php require_once("pages/company/tab-permintaan-info-company.php");?>
					</div>
					<div id="pengaduan" class="tab-pane fade">
						<?php require_once("pages/company/tab-pengaduan-company.php");?>
					</div>
					<div id="financial" class="tab-pane fade">
						<?php require_once("pages/company/tab-financial-company.php");?>
					</div>
					<div class="disclaimer">
						<b>Disclaimer PBK</b><br>
						Informasi Perkreditan ini didasarkan pada data yang dihimpun dari Sistem Informasi Debitur Bank Indonesia / Sistem Layanan Informasi Keuangan (SLIK) Otoritas Jasa Keuangan (OJK), Lembaga Keuangan yang menjadi Anggota atau Mitra PEFINDO Biro Kredit (PBK), serta instansi pemerintah maupun pihak swasta yang menjadi sumber data PBK.<br>
						PBK tidak bertanggungjawab atas kebenaran dan keakuratan data yang dihimpun dari pemberi data.<br>
						PBK tidak bertanggungjawab terhadap segala akibat yang timbul sehubungan dengan ketidakbenaran dan ketidakakuratan data serta penggunaan Informasi Perkreditan ini di kemudian hari.<br>
						PBK menerima aduan atas indikasi ketidakbenaran dan ketidakakuratan data dan akan menindaklanjuti sesuai ketentuan peraturan perundangan yang berlaku.	
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
$callCIP3 = "{call SP_GET_TAB_SKOR_PS_TBL_CIP_COMPANY(?)}";
$paramsCIP3 = array(array($id, SQLSRV_PARAM_IN),array($dataCIPCOM['M_CIP_ID'], SQLSRV_PARAM_IN));
?>
<script type="text/javascript">
	$(window).on("load", function(){
		setTimeout(function(){
			$("#loader").fadeOut("slow");
		}, 2000);
	});
</script>
<script>
/*	Highcharts.chart('container', {
		credits: {
			 enabled: false
		},
		exporting: { 
			enabled: false 
		},
		title: {
			text: ''
		},
		subtitle: {
			text: ''
		},
		yAxis: {
			title: {
				enabled: true,
				text: 'Score'
			}
		},
		xAxis: {
			categories: [<?php $execCIP3 = sqlsrv_query( $conn, $callCIP3, $paramsCIP3) or die( print_r( sqlsrv_errors(), true)); while($dataCIP3 = sqlsrv_fetch_array($execCIP3)){echo "'".$dataCIP3['DATE']->format('m/Y')."',";}?>]																
		},
		legend: {
			layout: 'vertical',
			align: 'right',
			verticalAlign: 'middle'
		},
		series: [{
			name: 'Pefindo Score',
			data: [<?php $execCIP3 = sqlsrv_query( $conn, $callCIP3, $paramsCIP3) or die( print_r( sqlsrv_errors(), true)); while($dataCIP3 = sqlsrv_fetch_array($execCIP3)){echo $dataCIP3['SCORE'].",";}?>]
		}],
		responsive: {
			rules: [{
				condition: {
					maxWidth: 500
				},
				chartOptions: {
					legend: {
						layout: 'horizontal',
						align: 'center',
						verticalAlign: 'bottom'
					}
				}
			}]
		}

	});*/
</script>

<script>
$('tr.header').click(function(){
    $(this).nextUntil('tr.header').css('display', function(i,v){
        return this.style.display === 'table-row' ? 'none' : 'table-row';
    });
});
</script>