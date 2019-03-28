<?php
require_once("config/configuration.php");
$noProsepekPemohonSLIK=$_GET['id'];

//penjamin atau pasangan
$callPenjamin = "{call PEFINDO_GETDATA_PASANGAN(?)}";
$paramsPenjamin = array(array($noProsepekPemohonSLIK, SQLSRV_PARAM_IN));
$optionsPenjamin =  array( "Scrollable" => "buffered" );
$execPenjamin = sqlsrv_query( $conn, $callPenjamin, $paramsPenjamin, $optionsPenjamin) or die( print_r( sqlsrv_errors(), true));
$dataPenjamin = sqlsrv_fetch_array($execPenjamin);
$numrosPenjamin = sqlsrv_num_rows($execPenjamin);
if($numrosPenjamin<>0){
	$ktp_pasangan = $dataPenjamin['Pasangan_Noktp'];
	$nama_pasangan = $dataPenjamin['Pasangan_Nama'];
	$tgl_lahir_pasangan = $dataPenjamin['Pasangan_TglLahir'];
	$ktp_penjamin = $dataPenjamin['Penjamin_Noktp'];
	$nama_penjamin = $dataPenjamin['Penjamin_Nama'];
	$tgl_lahir_penjamin = $dataPenjamin['Penjamin_TglLahir'];
}else{
	$ktp_pasangan = "";
	$nama_pasangan = "";
	$tgl_lahir_pasangan = "";
	$ktp_penjamin = "";
	$nama_penjamin = "";
	$tgl_lahir_penjamin = "";
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
/*$curlDkUpilPenjamin = curl_init();
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
$resultDukcapilPenjamin = json_decode($responseDkUpilPenjamin, true);*/
$resultDukcapilPenjamin=null;
if(empty($resultDukcapilPenjamin)){
	//$Warning_DataPenjamin = $Warning_DataPenjamin." - KTP TIDAK VALID (Pada saat pengecekan No KTP di Dukcapil.!)<br>";
}else{
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
$callSP = "{call SP_GET_SLIK_INDIVIDUAL_REPORT(?)}";
$options = array( "Scrollable" => "buffered" );
$params = array(array($noProsepekPemohonSLIK, SQLSRV_PARAM_IN));
$exec = sqlsrv_query( $conn, $callSP, $params, $options) or die( print_r( sqlsrv_errors(), true));
$numrows = sqlsrv_num_rows($exec);
$data = sqlsrv_fetch_array($exec);
?>
<div class="loader" id="loader"></div>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<div class="pull-left">
					<h4 class="title">Scoring Report <?php echo $data['TIPE_CUST'];?></h4>
					<p class="category">Host to Host SFI - Pefindo</p>
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
									<p class="pull-right">
										<?php
											if($data['TIPE_CUST'] == "PEMOHON"){
										?>
											<a href="#" data-target="#dataDukcapilPenjaminSLIK" data-toggle="modal" class="btn btn-primary btn-sm" style="cursor:pointer;border:1px solid #035c7a;color:#035c7a;">
												CHECK SCORING PENJAMIN
											</a>
										<?php
											}
										?>
									</p>
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
								<div class="col-md-11">
									<center>
										<h3>DATA TIDAK DITEMUKAN DI SLIK</h3><br>
									</center>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
				}
			?>
		</div>
	</div>
</div>
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