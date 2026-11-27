<?php
require_once("config/configuration.php");
require_once("config/connection.php");
$id=$_GET['id'];
$prospect_no=$_GET['prospect_no'];
$user=$_GET['USERNAME'];
$date=date("Y-m-d");

$callSP = "{call SP_GET_MASTER_INDIVIDUAL(?)}";
$params = array(array($id, SQLSRV_PARAM_IN));
$exec = sqlsrv_query( $conn, $callSP, $params) or die( print_r( sqlsrv_errors(), true));
$data = sqlsrv_fetch_array($exec);

$callJOB = "{call SP_GET_JOB_TITLE(?)}";
$paramsJOB = array(array($user, SQLSRV_PARAM_IN));
$execJOB = sqlsrv_query( $conn, $callJOB, $paramsJOB) or die( print_r( sqlsrv_errors(), true));
$dataJOB = sqlsrv_fetch_array($execJOB);

$callSP2 = "{call SP_GET_PEFINDO_ID(?)}";
$params2 = array(array($id, SQLSRV_PARAM_IN));
$exec2 = sqlsrv_query( $conn, $callSP2, $params2) or die( print_r( sqlsrv_errors(), true));
$data2 = sqlsrv_fetch_array($exec2);




//penjamin atau pasangan
/*$callPenjamin = "{call PEFINDO_GETDATA_PASANGAN(?)}";
$paramsPenjamin = array(array($prospect_no, SQLSRV_PARAM_IN));
$optionsPenjamin =  array( "Scrollable" => "buffered" );
$execPenjamin = sqlsrv_query( $conn, $callPenjamin, $paramsPenjamin, $optionsPenjamin) or die( print_r( sqlsrv_errors(), true));
$dataPenjamin = sqlsrv_fetch_array($execPenjamin);
$numrowsPenjamin = sqlsrv_num_rows($execPenjamin);
if($numrowsPenjamin<>0){
	$ktp_pasangan = $dataPenjamin['Pasangan_Noktp'];
	$nama_pasangan = $dataPenjamin['Pasangan_Nama'];
	$tgl_lahir_pasangan = $dataPenjamin['Pasangan_TglLahir'];
	$ktp_penjamin = $dataPenjamin['Penjamin_Noktp'];
	$nama_penjamin = $dataPenjamin['Penjamin_Nama'];
	$tgl_lahir_penjamin = $dataPenjamin['Penjamin_TglLahir'];
	
	//cek di ceknya by slik or pefindo
	$callCheckPenjamin = "{call PEFINDO_GETDATA_PASANGAN(?)}";
	$paramsCheckPenjamin = array(array($prospect_no, SQLSRV_PARAM_IN));
	$optionsCheckPenjamin =  array( "Scrollable" => "buffered" );
	$execCheckPenjamin = sqlsrv_query( $conn, $callCheckPenjamin, $paramsCheckPenjamin, $optionsCheckPenjamin) or die( print_r( sqlsrv_errors(), true));
	$dataCheckPenjamin = sqlsrv_fetch_array($execCheckPenjamin);
}else{
	$ktp_pasangan = "0";
	$nama_pasangan = "";
	$tgl_lahir_pasangan = DateTime::createFromFormat('Y-m-d', '1970-01-01');
	$ktp_penjamin = "0";
	$nama_penjamin = "";
	$tgl_lahir_penjamin = DateTime::createFromFormat('Y-m-d', '1970-01-01');
}

if($ktp_pasangan <> ""){
	$ktp2=$ktp_pasangan;
	$nama2=$nama_pasangan;
	$tglLahir2=$tgl_lahir_pasangan;
	$type_cust="PASANGAN";
}else if($ktp_penjamin <> ""){
	$ktp2=$ktp_penjamin;
	$nama2=$nama_penjamin;
	$tglLahir2=$tgl_lahir_penjamin;
	$type_cust="PENJAMIN";
}*/

//cek apakah dia pemohon atau penjamin
/*$call3= "{call SP_CHECK_TYPE_CUSTOMER(?,?)}";
$options3 =  array( "Scrollable" => "buffered" );
$params3 = array(array($id, SQLSRV_PARAM_IN),array($noProsepekPemohon, SQLSRV_PARAM_IN));
$exec3 = sqlsrv_query($conn, $call3, $params3, $options3) or die( print_r( sqlsrv_errors(), true));
$data3 = sqlsrv_fetch_array($exec3);
$numRows3 = sqlsrv_num_rows($exec3);*/
?>
<style>
a{
	color:#035c7a;
}
th{
	text-align:center;
	font-weight:bold;
}
a:hover{
	color:#035c7a;
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
	color:#035c7a;
}
ul > li > .active > a:focus {
	color:#035c7a;
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
	background-color:#035c7a;
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
	background-color:#035c7a;
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
tr.header{
    cursor:pointer;
	display: table-row;
}
tr.child {
    display: none;
}
.text-custom{
	color:#035c7a;
}
</style>
<script>
$(document).ready(function(){
  $("#collapseOne").on("hide.bs.collapse", function(){
    $(".card-link").html('<span class="fa fa-chevron-down" style="color:#035c7a;"></span>');
  });
  $("#collapseOne").on("show.bs.collapse", function(){
    $(".card-link").html('<span class="fa fa-chevron-up" style="color:#035c7a;"></span>');
  });
  $("#collapseOne2").on("hide.bs.collapse", function(){
    $(".card-link2").html('<span class="fa fa-chevron-down" style="color:#035c7a;"></span>');
  });
  $("#collapseOne2").on("show.bs.collapse", function(){
    $(".card-link2").html('<span class="fa fa-chevron-up" style="color:#035c7a;"></span>');
  });
});
</script>
<div class="row">
	<div class="col-md-12">
	<?php if($data2['PEFINDO_ID'] == '0000'){ ?>
				<div class="content">
					<div class="card">
						<div class="header">
							<div class="row">
								<div class="col-md-12">
									<center>
										<h3>DATA <?php echo $data2['CUST_TYPE'];?> <br>TIDAK DITEMUKAN DI PEFINDO</h3><br>
									</center>
									<br><br>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
				} else {
			?>
		<div class="card">
			<div class="header">
				<div class="pull-left">
					<h4 class="title">Scoring Report</h4>
					<p class="category">Host to Host SFI</p>
				</div>
				<div style="clear:both;"></div>
			</div>
			<div class="content">
				<div id="accordion">
					<div class="card">
						<div class="header">
							<div class="pull-left">
								<p class="name" style="color:#035c7a;"><?php echo $data['FULL_NAME'];?></p>
							</div>
							<div class="pull-right">
								<a class="card-link" data-toggle="collapse" href="#collapseOne">
									<i class="fa fa-chevron-down" style="color:#035c7a;"></i>
								</a>
							</div>
							<div style="clear:both"></div>
						</div>
						<div id="collapseOne" class="collapse content" data-parent="#accordion">
							<div class="table-responsive">
								<table class="table table-borderless">
									<tbody>
										<tr>
											<td>KTP</td>
											<td><?php echo $data['KTP'];?></td>
											<td>Pefindo ID</td>
											<td><?php echo $data['PEFINDO_ID'];?></td>
										</tr>
										<tr>
											<td>Tanggal Lahir</td>
											<td><?php if($data['DATE_OF_BIRTH']<>NULL){echo $data['DATE_OF_BIRTH']->format('Y-m-d');}else{echo"";}?></td>
											<td rowspan="2" style="vertical-align:top;">Alamat</td>
											<td rowspan="2" style="vertical-align:top;"><?php echo $data['ADDRESS_LINE'];?></td>
										</tr>
										<tr>
											<td>Data Kredit tersedia</td>
											<td>Ya</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				
				<ul class="nav nav-tabs">
					<?php //if($dataJOB['JOB_TITLE_CODE'] <> "SFICA" || $dataJOB['JOB_TITLE_CODE'] <> "SFICA"?>
					<li class="active"><a data-toggle="tab" href="#summary">Summary</a></li>
					<li><a data-toggle="tab" href="#dashboard">Dashboard</a></li>
					<li><a data-toggle="tab" href="#informasi-debitur">Informasi Debitur</a></li>
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
					<li><a data-toggle="tab" href="#footnote">Footnote</a></li>
				</ul>
				<br>
				<div class="tab-content">
					<div id="dashboard" class="tab-pane fade in">
						<?php require_once("pages/individual/tab-dashboard.php");?>
					</div>
					<div id="informasi-debitur" class="tab-pane fade in">
						<?php require_once("pages/individual/tab-informasi-debitur.php");?>
					</div>
					<div id="skorPS" class="tab-pane fade">
						<?php require_once("pages/individual/tab-skor-ps.php");?>
					</div>
					<div id="pefindo-alert-quest" class="tab-pane fade">
						<?php require_once("pages/individual/tab-PAQ.php");?>
					</div>
					<div id="fasilitas" class="tab-pane fade">
						<?php require_once("pages/individual/tab-fasilitas.php");?>
					</div>
					<div id="agunan" class="tab-pane fade">
						<?php require_once("pages/individual/tab-agunan.php");?>
					</div>
					<div id="surat-berharga" class="tab-pane fade">
						<?php require_once("pages/individual/tab-surat-berharga.php");?>
					</div>
					<div id="tagihan-lainnya" class="tab-pane fade">
						<?php require_once("pages/individual/tab-tagihan-lainnya.php");?>
					</div>
					<div id="penyertaan" class="tab-pane fade">
						<?php require_once("pages/individual/tab-penyertaan.php");?>
					</div>
					<div id="hubungan" class="tab-pane fade">
						<?php require_once("pages/individual/tab-hubungan.php");?>
					</div>
					<div id="permintaan-informasi" class="tab-pane fade">
						<?php require_once("pages/individual/tab-permintaan-informasi.php");?>
					</div>
					<div id="pengaduan" class="tab-pane fade">
						<?php require_once("pages/individual/tab-pengaduan.php");?>
					</div>
					<div id="summary" class="tab-pane fade">
						<?php require_once("pages/individual/tab-summary.php");?>
					</div>
					<div id="footnote" class="tab-pane fade in active">
						<?php require_once("pages/individual/tab-footnote.php");?>
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
$callCIP3 = "{call SP_GET_TAB_SKOR_PS_TBL_CIP(?)}";
$paramsCIP3 = array(array($id, SQLSRV_PARAM_IN),array($dataCIP['M_CIP_ID'], SQLSRV_PARAM_IN));
?>
<?php } ?>
<script>

$('tr.header').click(function(){
    $(this).nextUntil('tr.header').css('display', function(i,v){
        return this.style.display === 'table-row' ? 'none' : 'table-row';
    });
});
</script>