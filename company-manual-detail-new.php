<?php
require_once("config/configuration.php");
$user = $_GET['USERNAME'];
// var_dump($_POST['inquiry_id']);
// die();
if(isset($_POST['inquiry_id']) || isset($_POST['pefindo_mapping_id'])){
	set_time_limit(360);
	$inquiry_id = isset($_POST['inquiry_id'])?$_POST['inquiry_id']:null;
	$id_type = isset($_POST['id_type'])?$_POST['id_type']:null;
	$id_no = isset($_POST['id_no'])?$_POST['id_no']:null;
	$id_pefindo = isset($_POST['id_pefindo'])?$_POST['id_pefindo']:null;
	$pefindo_mapping_id = isset($_POST['pefindo_mapping_id'])?$_POST['pefindo_mapping_id']:null;
	// $baseUrl = 'http://10.10.30.84:8000';
	// $baseUrl = 'http://uat.sfi.co.id/sfi/';
	$baseUrl = 'http://integration.sfi.co.id/sfi/';

	if(isset($_POST['pefindo_mapping_id']) && $pefindo_mapping_id != null && $pefindo_mapping_id != ''){
		$callDataChecking = "{call SP_GET_PEFINDO_CHECKING_DATA_PEFINDO_MAPPING_ID (?)}";
		$paramDataChecking =  array(array($pefindo_mapping_id, SQLSRV_PARAM_IN));
		$execDataChecking = sqlsrv_query($conn, $callDataChecking, $paramDataChecking) or die(print_r(sqlsrv_defaults(), true));
		$dataDataChecking = sqlsrv_fetch_array($execDataChecking);
	}else{
		$callDataChecking = "{call SP_GET_PEFINDO_CHECKING_DATA (?,?)}";
		$paramDataChecking =  array(array($id_pefindo, SQLSRV_PARAM_IN),array($id_no, SQLSRV_PARAM_IN));
		$execDataChecking = sqlsrv_query($conn, $callDataChecking, $paramDataChecking) or die(print_r(sqlsrv_defaults(), true));
		$dataDataChecking = sqlsrv_fetch_array($execDataChecking);
	}

	




	if($dataDataChecking === null){
		// var_dump(json_encode($json, JSON_PRETTY_PRINT));
		// die();

		$ch = curl_init();
		$header = [
			"Content-Type: application/json"
		];

		$data = [
			"inquiry_id" => $inquiry_id,
			"id_type" => $id_type,
			"id_no" => $id_no,
			"id_pefindo" => $id_pefindo
		];

		curl_setopt($ch, CURLOPT_URL, $baseUrl . '/api/credit_score/pefindo/generate_report');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		// curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		
		// Optional: Ignore SSL verification (if self-signed certificate)
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		$response = curl_exec($ch);
		$err = curl_error($ch);
		curl_close($ch);
			// print_r($err);
			// exit();
			
		if ($err) { //jika pemintaan request pefindo error
			echo "cURL Error #:" . $err;
		} else { 
			$array = json_decode($response,true, 512, JSON_BIGINT_AS_STRING); 
		}

		if($array['response_get']['code'] != '01' && $array['response_get']['code'] != '36'){
			echo"<script>alert('Gagal memperoleh data, silahkan dicoba kembali'); window.location='index.php?USERNAME=".$user."&page=company-manual-new';</script>";
			exit;
		}

		$jsonFile = $array['json_path'];

		$jsonFileBig = $array['json_big_path'];

		$pdfFile = $array['pdf_base64'];

		$pdfFile = str_replace(
			['data:application/pdf;base64,', ' ', "\n", "\r"],
			['', '+', '', ''],
			$pdfFile
		);

		$prospectNoExist = 1;

		while($prospectNoExist == 1){
			$prospectNo = 'PEFNEW' . str_pad(mt_rand(0, 9999999999), 10, '0', STR_PAD_LEFT);

			$callInsertPefindoMappingCheck = "{call SP_CHECK_PEFINDO_MAPPING_NODATA (?)}";
			$paramInsertPefindoMappingCheck =  array(array($prospectNo, SQLSRV_PARAM_IN));
			$execInsertPefindoMappingCheck = sqlsrv_query($conn, $callInsertPefindoMappingCheck, $paramInsertPefindoMappingCheck) or die(print_r(sqlsrv_defaults(), true));
			$dataInsertPefindoMappingCheck = sqlsrv_fetch_array($execInsertPefindoMappingCheck);

			if ($dataInsertPefindoMappingCheck == false) {
				$prospectNoExist = 0;
			}
		}

		if($jsonFileBig != null){
			$jsonFile = $jsonFileBig;
		}

		$json = file_get_contents($jsonFile);

		$dataChecking = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);

		$dataReport = isset($dataChecking['report']) ? $dataChecking['report'] : null;

		$callInsertPefindoMapping = "{call SP_INSERT_PEFINDO_MAPPING_GET_ID (?,?,?,?,?,?,?)}";
		$paramInsertPefindoMapping =  array(array($prospectNo, SQLSRV_PARAM_IN),array('NPWP', SQLSRV_PARAM_IN),array($id_no, SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN),array($dataReport['debitur']['tanggal_akta_pendirian'], SQLSRV_PARAM_IN),array('PEMOHON', SQLSRV_PARAM_IN),array($id_pefindo, SQLSRV_PARAM_IN));
		$execInsertPefindoMapping = sqlsrv_query($conn, $callInsertPefindoMapping, $paramInsertPefindoMapping) or die(print_r(sqlsrv_defaults(), true));
		$dataInsertPefindoMapping = sqlsrv_fetch_array($execInsertPefindoMapping);

		$callInsertDataChecking = "{call SP_INSERT_PEFINDO_CHECKING_DATA (?,?,?,?,?,?,?,?)}";
		$paramInsertDataChecking =  array(array($dataInsertPefindoMapping['PEFINDO_MAPPING_ID'], SQLSRV_PARAM_IN),array($id_pefindo, SQLSRV_PARAM_IN),array($id_no, SQLSRV_PARAM_IN),array($jsonFile, SQLSRV_PARAM_IN),array($jsonFileBig, SQLSRV_PARAM_IN),array($pdfFile, SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN),array('COMPANY', SQLSRV_PARAM_IN));
		$execInsertDataChecking = sqlsrv_query($conn, $callInsertDataChecking, $paramInsertDataChecking) or die(print_r(sqlsrv_defaults(), true));
		$dataInsertDataChecking = sqlsrv_fetch_array($execInsertDataChecking);

		$pefindoCheckingDataId = $dataInsertDataChecking['PEFINDO_CHECKING_DATA_ID'];

		/* ================= proses simpan ke database ================= */
		// /* DELETE */ require_once("pages/company-new/save-data/delete-data-pefindo-id.php");	
		/* DEBITUR */ require_once("pages/company-new/save-data/save-data-debitur-company.php");	
		/* FASILITAS */ require_once("pages/company-new/save-data/save-data-fasilitas.php");	
		/* SCORING */ require_once("pages/company-new/save-data/save-data-scoring.php");	
		/* RIWAYAT IDENTITAS */ require_once("pages/company-new/save-data/save-data-riwayat-identitas.php");	
		/* PENGURUS */ require_once("pages/company-new/save-data/save-data-pengurus.php");

	}else{
		$pefindoCheckingDataId = $dataDataChecking['PEFINDO_CHECKING_DATA_ID'];

		if($dataDataChecking['JSON_BIG_REPORT_URL'] != null){
			$jsonFile = $dataDataChecking['JSON_BIG_REPORT_URL'];
		}else{
			$jsonFile = $dataDataChecking['JSON_REPORT_URL'];
		}

		$json = file_get_contents($jsonFile);

		$dataChecking = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);

		$dataReport = isset($dataChecking['report']) ? $dataChecking['report'] : null;

		

		$pdfFile = $dataDataChecking['PDF_REPORT'];
		$pdfFile = str_replace(
			['data:application/pdf;base64,', ' ', "\n", "\r"],
			['', '+', '', ''],
			$pdfFile
		);
	}

	// $dataPermintaan12Bulan = $dataReport['summary_permintaan_data'][0];

	// var_dump($dataPermintaan12Bulan);
	// die();

	// /* ================= proses simpan ke database ================= */
	// /* DELETE */ require_once("pages/company-new/save-data/delete-data-pefindo-id.php");	
	// /* DEBITUR */ require_once("pages/company-new/save-data/save-data-debitur-company.php");	
	// /* FASILITAS */ require_once("pages/company-new/save-data/save-data-fasilitas.php");	
	// /* SCORING */ require_once("pages/company-new/save-data/save-data-scoring.php");	
	// /* RIWAYAT IDENTITAS */ require_once("pages/company-new/save-data/save-data-riwayat-identitas.php");
	// /* PENGURUS */ require_once("pages/company-new/save-data/save-data-pengurus.php");

	// var_dump($dataReport['fasilitas'][0]);
	// die();

	

	
	// $no_ktp = "";
	// $name = "";
	// $date = "";
	// $siapanih = "";
}else{
	// $no_ktp = "";
	// $name = "";
	// $date = "";
	// $siapanih = "";
}	
?>
<style>
.th-custom{
	text-align:center;
	vertical-align:middle;
	font-weight:bold;
}
.td-custom{
	text-align:center;
	vertical-align:middle;
}

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
.box-grey{
	padding:10px;
	font-size:24px;
	font-weight:bold;
	background-color:#BFBFBF;
	color:#FFF;
	width:80px;
	margin-right:10px;
	border-radius:5px;
	margin-bottom:10px;
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
	background-color:#80FF00;
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

/* #page-loader {
  position: fixed;
  inset: 0;
  background: white;
  z-index: 9999;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  font-family: Arial;
}

.spinner {
  width: 60px;
  height: 60px;
  border: 6px solid #ddd;
  border-top: 6px solid #000;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin-bottom: 15px;
}

@keyframes spin {
  100% { transform: rotate(360deg); }
} */
</style>
<!-- <div id="page-loader">
  <div class="spinner"></div>
  <div>Loading… Please wait</div>
</div> -->
<script>
$(document).ready(function(){
  $("#collapseOne").on("hide.bs.collapse", function(){
    $(".card-link").html('<span class="fa fa-chevron-down" style="color:#035c7a;"></span>');
  });
  $("#collapseOne").on("show.bs.collapse", function(){
    $(".card-link").html('<span class="fa fa-chevron-up" style="color:#035c7a;"></span>');
  });
});
</script>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Scoring Report</h4>
				<p class="category">Host to Host SFI - Pefindo</p>
			</div>
			<div class="content">
				<div id="accordion">
					<div class="card">
						<div class="header">
							<div class="pull-left">
								<p class="name" style="color:#035c7a;"><?php echo $dataReport['debitur']['nama_badan_usaha'];?></p>
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
											<td style="font-weight: bold;">NPWP</td>
											<td><?php echo $id_no?$id_no:$dataDataChecking['ID_NO'];?></td>
											<td style="font-weight: bold;">Pefindo ID</td>
											<td><?php echo $id_pefindo?$id_pefindo:$dataDataChecking['PEFINDO_ID'];?></td>
										</tr>
										<tr>
											<td style="font-weight: bold;">Tanggal Berdiri</td>
											<td><?php echo $dataReport['debitur']['tanggal_akta_pendirian'];?></td>
											<td rowspan="2" style="vertical-align:top; font-weight: bold;">Alamat</td>
											<td rowspan="2" style="vertical-align:top;"><?php echo $dataReport['debitur']['alamat_debitur'];?></td>
										</tr>
										<tr>
											<td style="font-weight: bold;">Data Kredit tersedia</td>
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
					<li><a data-toggle="tab" href="#informasi-debitur">Informasi Debitur</a></li>
					<li><a data-toggle="tab" href="#skorPS">Skor PS</a></li>
					<li><a data-toggle="tab" href="#fasilitas">Fasilitas</a></li>
					<li><a data-toggle="tab" href="#hubungan">Hubungan</a></li>
					<li><a data-toggle="tab" href="#permintaan-informasi">Permintaan Informasi</a></li>
					<!-- <li><a data-toggle="tab" href="#json">JSON data</a></li> -->
					<!--<li><a data-toggle="tab" href="#pdf">PDF</a></li>-->
				</ul>

				<div class="tab-content">
					<div id="dashboard" class="tab-pane fade in">
						<?php require_once("pages/company-new/tab-dashboard.php");?>
					</div>
					<div id="informasi-debitur" class="tab-pane fade in">
						<?php require_once("pages/company-new/tab-informasi-debitur.php");?>
					</div>
					<div id="skorPS" class="tab-pane fade">
						<?php require_once("pages/company-new/tab-skor-ps.php");?>
					</div>
					<div id="fasilitas" class="tab-pane fade">
						<?php require_once("pages/company-new/tab-fasilitas.php");?>
					</div>
					<div id="hubungan" class="tab-pane fade">
						<?php require_once("pages/company-new/tab-hubungan.php");?>
					</div>
					<div id="permintaan-informasi" class="tab-pane fade">
						<?php require_once("pages/company-new/tab-permintaan-informasi.php");?>
					</div>
					<div id="summary" class="tab-pane fade in active">
						<?php require_once("pages/company-new/tab-summary.php");?>
					</div>
					<!-- <div id="json" class="tab-pane fade">
						<br>
						<textarea id="jsonBox"
							class="form-control bg-light"
							rows="12"
							readonly
							style="font-family: Consolas, monospace;
									height:75vh;
									white-space: pre;
									font-size: 14px;">
<?= $json?>
				 		</textarea>
					</div> -->

					<!--<div id="pdf" class="tab-pane fade">
						<br>
						<iframe id="pdfFrame"
								style="width:100%; height:90vh; border:none;">
						</iframe>
					</div>-->
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



<script>
	const base64 = "<?= $pdfFile ?>";
	const binary = atob(base64);
	const len = binary.length;
	const bytes = new Uint8Array(len);

	for (let i = 0; i < len; i++) {
	bytes[i] = binary.charCodeAt(i);
	}

	const blob = new Blob([bytes], { type: 'application/pdf' });
	const url = URL.createObjectURL(blob)+'#toolbar=0';

	document.getElementById('pdfFrame').src = url;
</script>




