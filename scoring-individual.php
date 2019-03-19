<?php
require_once("config/configuration.php");
require_once("config/connection.php");
$id=$_GET['id'];
$user=$_GET['USERNAME'];
$date=date("Y-m-d");
$noProsepekPemohon=$_GET['no'];

$callSP = "{call SP_GET_MASTER_INDIVIDUAL(?)}";
$params = array(array($id, SQLSRV_PARAM_IN));
$exec = sqlsrv_query( $conn, $callSP, $params) or die( print_r( sqlsrv_errors(), true));
$data = sqlsrv_fetch_array($exec);

$callJOB = "{call SP_GET_JOB_TITLE(?)}";
$paramsJOB = array(array($user, SQLSRV_PARAM_IN));
$execJOB = sqlsrv_query( $conn, $callJOB, $paramsJOB) or die( print_r( sqlsrv_errors(), true));
$dataJOB = sqlsrv_fetch_array($execJOB);



//penjamin atau pasangan
$callPenjamin = "{call PEFINDO_GETDATA_PASANGAN(?)}";
$paramsPenjamin = array(array($noProsepekPemohon, SQLSRV_PARAM_IN));
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
}else if($ktp_penjamin <> ""){
	$ktp2=$ktp_penjamin;
	$nama2=$nama_penjamin;
	$tglLahir2=$tgl_lahir_penjamin;
}

//--# Cek Dukcapil
$param_dukcapil_arrayPenjamin= array('nik' => $ktp2, 'user_id' => "devsuzukif", 'password' => "XNcPZp41", 'IP_USER' => "10.162.130.2");
$param_dukcapilPenjamin = json_encode($param_dukcapil_arrayPenjamin);
$Warning_DataPenjamin = "";

$call_blsPenjamin = "{call SP_CHECK_BLACKLIST_PENJAMIN(?,?,?)}";
$params_blsPenjamin = array(array($ktp2, SQLSRV_PARAM_IN),array($nama2, SQLSRV_PARAM_IN),array($tglLahir2, SQLSRV_PARAM_IN));
$optionsPenjamin =  array( "Scrollable" => "buffered" );
$exec_blsPenjamin = sqlsrv_query( $conn, $call_blsPenjamin, $params_blsPenjamin, $optionsPenjamin) or die( print_r( sqlsrv_errors(), true)); 
$data_blsPenjamin = sqlsrv_fetch_array($exec_blsPenjamin);
$checkBlacklistPenjamin=sqlsrv_num_rows($exec_blsPenjamin);

if($checkBlacklistPenjamin > 0){
	$Warning_DataPenjamin = $Warning_DataPenjamin." - Customer ini terdaftar di Customer Blacklist Internal.!<br>";
}
//----# Cek Dukcapil
$curlDkUpilPenjamin = curl_init();
curl_setopt_array($curlDkUpilPenjamin, array(
  CURLOPT_URL => "http://172.16.160.128:8000/dukcapil/get_json/SUZUKI_FINANCE/CALL_NIK",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "$param_dukcapilPenjamin",
  CURLOPT_HTTPHEADER => array(
	"Authorization: Basic " . base64_encode("devsuzukif:XNcPZp41"),
	"Content-Type: application/json",
	"Postman-Token: ae0ace2e-aa92-4d66-8d14-d67edb42fa84",
	"cache-control: no-cache"
  ),
));

$responseDkUpilPenjamin = curl_exec($curlDkUpilPenjamin);
$errDkUpilPenjamin = curl_error($curlDkUpilPenjamin);			
curl_close($curlDkUpilPenjamin);
$resultDukcapilPenjamin = json_decode($responseDkUpilPenjamin, true);
if(empty($resultDukcapilPenjamin)){
	$Warning_DataPenjamin = $Warning_DataPenjamin." - KTP TIDAK VALID (Pada saat pengecekan No KTP di Dukcapil.!)<br>";
}

if (isset($resultDukcapilPenjamin['content'][0]['RESPON'])) {
	$StatusLogDkUpilnotfoundPenjamin = strtoupper($resultDukcapilPenjamin['content'][0]['RESPON']);
	$Warning_DataPenjamin = $Warning_DataPenjamin." - ".$StatusLogDkUpilnotfoundPenjamin."  (Pada saat pengecekan No KTP di Dukcapil.!)<br>";
	
	$DkcplNIKPenjamin = "";
	$DkcplNAMA_LGKPPenjamin = "";
	$DkcplJENIS_KLMINPenjamin ="";
	$DkcplTMPT_LHRPenjamin = "";
	$DkcplTGL_LHRPenjamin = "";
	$DkcplSTATUS_KAWINPenjamin = "";
	$DkcplNAMA_LGKP_IBUPenjamin = "";
	$DkcplJENIS_PKRJNPenjamin = "";
	$DkcplALAMATPenjamin = "";
	$DkcplNO_RTPenjamin = "";
	$DkcplNO_RWPenjamin = "";
	$DkcplNO_PROPPenjamin = "";
	$DkcplPROP_NAMEPenjamin = "";
	$DkcplNO_KABPenjamin = "";
	$DkcplKAB_NAMEPenjamin = "";
	$DkcplKEC_NAMEPenjamin = "";
	$DkcplNO_KELPenjamin = "";
	$DkcplNO_KECPenjamin = "";
	$DkcplKEL_NAMEPenjamin = "";
}else{
	foreach($resultDukcapilPenjamin['content'] as $contentdata){
		$DkcplNIKPenjamin = number_format($contentdata['NIK'], 0, '', '');
		$DkcplNAMA_LGKPPenjamin = $contentdata['NAMA_LGKP'];
		$DkcplJENIS_KLMINPenjamin = $contentdata['JENIS_KLMIN'];
		$DkcplTMPT_LHRPenjamin = $contentdata['TMPT_LHR'];
		$DkcplTGL_LHRPenjamin = $contentdata['TGL_LHR'];
		$DkcplSTATUS_KAWINPenjamin = $contentdata['STATUS_KAWIN'];
		$DkcplNAMA_LGKP_IBUPenjamin = $contentdata['NAMA_LGKP_IBU'];
		$DkcplJENIS_PKRJNPenjamin = $contentdata['JENIS_PKRJN'];
		$DkcplALAMATPenjamin = $contentdata['ALAMAT'];
		$DkcplNO_RTPenjamin = $contentdata['NO_RT'];
		$DkcplNO_RWPenjamin = $contentdata['NO_RW'];
		$DkcplNO_PROPPenjamin = $contentdata['NO_PROP'];
		$DkcplPROP_NAMEPenjamin = $contentdata['PROP_NAME'];
		$DkcplNO_KABPenjamin = $contentdata['NO_KAB'];
		$DkcplKAB_NAMEPenjamin = $contentdata['KAB_NAME'];
		$DkcplKEC_NAMEPenjamin = $contentdata['KEC_NAME'];
		$DkcplNO_KELPenjamin = $contentdata['NO_KEL'];
		$DkcplNO_KECPenjamin = $contentdata['NO_KEC'];
		$DkcplKEL_NAMEPenjamin = $contentdata['KEL_NAME'];
		
		if($DkcplNAMA_LGKPPenjamin != $nama2){
			$Warning_DataPenjamin = $Warning_DataPenjamin." - Nama Lengkap Tidak Sama dengan data di Dukcapil.!<br>";
		}
		if($DkcplTGL_LHRPenjamin != $tglLahir2->format("Y-m-d")){
			$Warning_DataPenjamin = $Warning_DataPenjamin." - Tanggal Lahir Tidak Sama dengan data di Dukcapil.!<br>";
		}
		
		$Is_Similar = 0;
		if($Warning_DataPenjamin != ""){
			$Is_Similar = 1;
		}
	}
}

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://bo.pefindobirokredit.com/WsReport/v5.31/Service.svc",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"\r\nxmlns:cb5=\"http://creditinfo.com/CB5\"\r\nxmlns:smar=\"http://creditinfo.com/CB5/v5.31/SmartSearch\">\r\n <soapenv:Header/>\r\n <soapenv:Body>\r\n <cb5:SmartSearchIndividual>\r\n <cb5:query>\r\n <smar:InquiryReason>ProvidingFacilities</smar:InquiryReason>\r\n <smar:InquiryReasonText/>\r\n <smar:Parameters>\r\n <smar:DateOfBirth>".$tglLahir2->format("Y-m-d")."</smar:DateOfBirth>\r\n <smar:FullName>".$nama2."</smar:FullName>\r\n <smar:IdNumbers>\r\n <smar:IdNumberPairIndividual>\r\n <smar:IdNumber>".$ktp2."</smar:IdNumber>\r\n <smar:IdNumberType>KTP</smar:IdNumberType>\r\n </smar:IdNumberPairIndividual>\r\n </smar:IdNumbers>\r\n </smar:Parameters>\r\n </cb5:query>\r\n </cb5:SmartSearchIndividual>\r\n </soapenv:Body>\r\n</soapenv:Envelope>\r\n",
  CURLOPT_HTTPHEADER => array(
	"Authorization: Basic " . base64_encode("$username:$password"),
	"Content-Type: text/xml",
	"Postman-Token: ae0ace2e-aa92-4d66-8d14-d67edb42fa84",
	"SOAPAction: http://creditinfo.com/CB5/IReportPublicServiceBase/SmartSearchIndividual",
	"cache-control: no-cache"
  ),
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
	echo"<script>window.location='index.php?USERNAME=".$user."&page=error'</script>";
} else {
	$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
	$xml = new SimpleXMLElement($response);
	$body = $xml->xpath('//sBody')[0];
	$array = json_decode(json_encode((array)$body), TRUE); 
}


//cek apakah dia pemohon atau penjamin
$call3= "{call SP_CHECK_TYPE_CUSTOMER(?,?)}";
$options3 =  array( "Scrollable" => "buffered" );
$params3 = array(array($id, SQLSRV_PARAM_IN),array($noProsepekPemohon, SQLSRV_PARAM_IN));
$exec3 = sqlsrv_query($conn, $call3, $params3, $options3) or die( print_r( sqlsrv_errors(), true));
$data3 = sqlsrv_fetch_array($exec3);
$numRows3 = sqlsrv_num_rows($exec3); 
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
    background: url('assets/img/loading.gif') 50% 50% no-repeat rgb(255,255,255);
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
<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
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
<div class="loader" id="loader"></div>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<div class="pull-left">
					<h4 class="title">Scoring Report <?php echo $data3['CUST_TYPE'];?></h4>
					<p class="category">Host to Host SFI - Pefindo</p>
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
					<div id="summary" class="tab-pane fade in active">
						<?php require_once("pages/individual/tab-summary.php");?>
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
<script type="text/javascript">
	$(window).on("load", function(){
		setTimeout(function(){
			$("#loader").fadeOut("slow");
		}, 2000);
	});
</script>
<script>
	/*Highcharts.chart('container', {
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