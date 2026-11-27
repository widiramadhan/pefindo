<?php
require_once("config/configuration.php");


$Warning_Data ="";
$Warning_Data_Pefindo ="";
$Warning_Data_Sementara ="";


/********** CEK BLACKLIST **********/
function checkBlacklist($no_ktp, $nama, $date, $birth_place, $mother_nm, $prospect, $user){
	global $conn;
	$call_bls = "{call SP_CHECK_PEFINDO_BLACKLIST(?,?,?,?,?,?,?)}";
	$params_bls = array(
					array($no_ktp, SQLSRV_PARAM_IN),
					array($nama, SQLSRV_PARAM_IN),
					array($date, SQLSRV_PARAM_IN),
					array($birth_place, SQLSRV_PARAM_IN),
					array($mother_nm, SQLSRV_PARAM_IN),
					array($prospect, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN)
				);
	$options =  array( "Scrollable" => "buffered" );
	$exec_bls = sqlsrv_query($conn, $call_bls, $params_bls, $options) or die( print_r( sqlsrv_errors(), true)); 
	$data = sqlsrv_fetch_array($exec_bls);
	$checkBlacklist=sqlsrv_num_rows($exec_bls);

	if($checkBlacklist > 0){	//----# Cek Blacklist
		/*echo"<script>alert('Customer tersebut terdaftar di Customer Blacklist Internal.');</script>";*/
		$Warning_Data = $Warning_Data." - Customer ini terdaftar di Customer Blacklist Internal.!<br>";
		$blacklist = "YA";
	}else{
		$blacklist = "TIDAK";
	}
	return $blacklist;
}
/********** END CEK BLACKLIST **********/


/********** CEK PEFINDO **********/
function checkPefindo($prospect, $no_ktp){
	global $conn;
	$call_pfnd = "{call SP_CHECK_LOG_PEFINDO(?,?)}";
	$params_pfnd = array(
					array($prospect, SQLSRV_PARAM_IN),
					array($no_ktp, SQLSRV_PARAM_IN)
				);
	$options =  array( "Scrollable" => "buffered" );
	$exec_pfnd = sqlsrv_query( $conn, $call_pfnd, $params_pfnd, $options) or die( print_r( sqlsrv_errors(), true)); 
	$data_pfnd = sqlsrv_fetch_array($exec_pfnd);
	$checkPefindo=sqlsrv_num_rows($exec_pfnd);

	if($checkPefindo > 0){ 
		$pefindo = $data_pfnd['STATUS'];
	}else{
		$pefindo = "BELUM PERNAH DICEK";
	}
	return $pefindo;
}
/********** END CEK PEFINDO **********/

/********** CEK SCORING **********/
function checkScoring($prospect, $no_ktp){
	global $conn;
	//cek ke table log sudah pernah di cek atau belum
	$call_scoring = "{call SP_CHECK_LOG_SCORING(?,?)}";
	$params_scoring = array(
					array($prospect, SQLSRV_PARAM_IN),
					array($no_ktp, SQLSRV_PARAM_IN)
				);
	$options =  array( "Scrollable" => "buffered" );
	$exec_scoring = sqlsrv_query( $conn, $call_scoring, $params_scoring, $options) or die( print_r( sqlsrv_errors(), true)); 
	$data_scoring = sqlsrv_fetch_array($exec_scoring);
	$checkScoring=sqlsrv_num_rows($exec_scoring);
	
	if($checkScoring > 0){ 
		//jika ditemukan di table pengecekan pefindo
		$scoring = "DATA DITEMUKAN - CHECKED BY : ".$data_scoring['USER_CREATE']." (".$data_scoring['CREATE_DATE']->format('d-m-Y H:i:s').")";
		$slik = "-";
	}else{ 
		//jika tidak ditemukan di table pengecekan pefindo, maka cari di table pengecekan slik
		$call_slik = "{call SP_CHECK_LOG_SLIK(?,?)}";
		$params_slik = array(
						array($prospect, SQLSRV_PARAM_IN),
						array($no_ktp, SQLSRV_PARAM_IN)
					);
		$options =  array( "Scrollable" => "buffered" );
		$exec_slik = sqlsrv_query( $conn, $call_slik, $params_slik, $options) or die( print_r( sqlsrv_errors(), true)); 
		$data_slik = sqlsrv_fetch_array($exec_slik);
		$checkSlik = sqlsrv_num_rows($exec_slik);
		
		if($checkSlik > 0){
			//jika ditemukan di table slik result, cek status nya
			if($data_slik['STATUS'] == "DITEMUKAN"){
				//jika ditemukan di slik artinya sudah ada hasilnya di slik result dan status nya 1
				$scoring = "DATA TIDAK DITEMUKAN";
				$slik = "DATA DITEMUKAN - CHECKED BY : ".$data_slik['CREATE_USER']." (".$data_slik['CREATE_DATE']->format('d-m-Y H:i:s').")";
			}else if($data_slik['STATUS'] == "TIDAK DITEMUKAN"){
				//jika tidak ditemukan di slik artinya status nya 2 di table slik result
				$scoring = "DATA TIDAK DITEMUKAN";
				$slik = "DATA TIDAK DITEMUKAN";
			}else{
				//jika tidak ada di table slik result berarti belum pernah dicek di slik
				$scoring = "BELUM PERNAH DICEK";
				$slik = "BELUM PERNAH DICEK";
			}
		}else{
			//jika tidak ditemukan di table slik result artinya tidak ada di pefindo dan belum pernah di cek di slik
			$scoring = "BELUM PERNAH DICEK";
			$slik = "BELUM PERNAH DICEK";
		}
	}
	$arr = array("slik" => $slik, "scoring" => $scoring);
	return $arr;
}
/********** END CEK SCORING **********/

	
/********** ACTION CLICK BUTTON CHECK PEFINDO **********/
$prospect=$_POST['prospect_no'];
$no_ktp=$_POST['no_ktp'];
$nama=$_POST['name'];
$date=$_POST['date'];
$mother_nm=$_POST['mother_name'];
$birth_place=$_POST['birth_place'];
$siapanih=$_POST['tipe_cust'];
$getUsername=$_GET['USERNAME'];

if($no_ktp==""){
	echo"<script>alert('Nomor KTP tidak boleh kosong, silahkan lakukan edit data di CONFINS');history.back();</script>";
}else if($nama==""){
	echo"<script>alert('Nama tidak boleh kosong, silahkan lakukan edit data di CONFINS');history.back();</script>";
}else if($date==""){
	echo"<script>alert('Tanggal lahir tidak boleh kosong, silahkan lakukan edit data di CONFINS');history.back();</script>";
}else if(substr($no_ktp,0,1) == "0"){
	echo"<script>alert('Nomor KTP tidak boleh berawalan 0');history.back();</script>";
}else if(substr($no_ktp,-4) == "0000"){
	echo"<script>alert('4 Digit Nomor KTP tidak boleh 0000');history.back();</script>";
}else if(strlen(trim($no_ktp)) <> 16){
	echo"<script>alert('NIK harus 16 digit');history.back();</script>";
}else if(preg_match("/^[a-zA-Z]$/", $no_ktp)){
	echo"<script>alert('NIK tidak boleh mengandung alphabet');history.back();</script>";
}else{		
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => "https://bo.pefindobirokredit.com/WsReport/v5.31/Service.svc",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 60,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"\r\nxmlns:cb5=\"http://creditinfo.com/CB5\"\r\nxmlns:smar=\"http://creditinfo.com/CB5/v5.31/SmartSearch\">\r\n <soapenv:Header/>\r\n <soapenv:Body>\r\n <cb5:SmartSearchIndividual>\r\n <cb5:query>\r\n <smar:InquiryReason>ProvidingFacilities</smar:InquiryReason>\r\n <smar:InquiryReasonText/>\r\n <smar:Parameters>\r\n <smar:DateOfBirth>".$date."</smar:DateOfBirth>\r\n <smar:FullName>".$nama."</smar:FullName>\r\n <smar:IdNumbers>\r\n <smar:IdNumberPairIndividual>\r\n <smar:IdNumber>".$no_ktp."</smar:IdNumber>\r\n <smar:IdNumberType>KTP</smar:IdNumberType>\r\n </smar:IdNumberPairIndividual>\r\n </smar:IdNumbers>\r\n </smar:Parameters>\r\n </cb5:query>\r\n </cb5:SmartSearchIndividual>\r\n </soapenv:Body>\r\n</soapenv:Envelope>\r\n",
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
	
	if ($err) { //jika pemintaan request pefindo error
		//echo "cURL Error #:" . $err;
		
		//----# Insert LOG
		$SourceLog = "PEFINDO";
		$StatusLog = "ERROR";

		$callSPLogPfnd = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?)}";
		$paramsLogPfnd = array(array($prospect, SQLSRV_PARAM_IN),array($SourceLog, SQLSRV_PARAM_IN),array($StatusLog, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
		$execLogPfnd = sqlsrv_query( $conn, $callSPLogPfnd, $paramsLogPfnd) or die( print_r( sqlsrv_errors(), true));
		if($execLogPfnd === false){
			echo"<script>alert('Error insert log');</script>";
		}
		//----# Insert LOG End

		echo"<script>window.location='index.php?USERNAME=".$user."&page=error'</script>";
	} else {
		$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
		$xml = new SimpleXMLElement($response);
		$body = $xml->xpath('//sBody')[0];
		$array = json_decode(json_encode((array)$body), TRUE); 
		//print_r($array);

		if($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aStatus'] == 'SubjectFound'){
			if($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aPefindoId'] <> NULL){
				//----# Insert LOG
				$SourceLogPfndScss = "PEFINDO";
				$StatusLogPfndScss = "DATA DITEMUKAN";

				$callSPLogPfndScss = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?)}";
				$paramsLogPfndScss = array(array($prospect, SQLSRV_PARAM_IN),array($SourceLogPfndScss, SQLSRV_PARAM_IN),array($StatusLogPfndScss, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
				$execLogPfndScss = sqlsrv_query( $conn, $callSPLogPfndScss, $paramsLogPfndScss) or die( print_r( sqlsrv_errors(), true));
				if($execLogPfndScss === false){
					echo"<script>alert('Error insert log Pefindo DataFound');</script>";
				}
				//----# Insert LOG End
			}else{
				//----# Insert LOG
				$SourceLogPfndScssMlti = "PEFINDO";
				$StatusLogPfndScssMlti = "DATA DITEMUKAN - MULTI PEFINDO ID";

				$callSPLogPfndScssMlti = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?)}";
				$paramsLogPfndScssMlti = array(array($prospect, SQLSRV_PARAM_IN),array($SourceLogPfndScssMlti, SQLSRV_PARAM_IN),array($StatusLogPfndScssMlti, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
				$execLogPfndScssMlti = sqlsrv_query( $conn, $callSPLogPfndScssMlti, $paramsLogPfndScssMlti) or die( print_r( sqlsrv_errors(), true));
				if($execLogPfndScssMlti === false){
					echo"<script>alert('Error insert log Pefindo DataFoundMulti');</script>";
				}
				//----# Insert LOG End
			}
		}else{
			//----# Insert LOG
			$SourceLogPfndNtfnd = "PEFINDO";
			$StatusLogPfndNtfnd = "DATA TIDAK DITEMUKAN";

			$callSPLogPfndNtfnd = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?)}";
			$paramsLogPfndNtfnd = array(array($prospect, SQLSRV_PARAM_IN),array($SourceLogPfndNtfnd, SQLSRV_PARAM_IN),array($StatusLogPfndNtfnd, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
			$execLogPfndNtfnd = sqlsrv_query( $conn, $callSPLogPfndNtfnd, $paramsLogPfndNtfnd) or die( print_r( sqlsrv_errors(), true));
			if($execLogPfndNtfnd === false){
				echo"<script>alert('Error insert log Pefindo DataFound');</script>";
			}
			//----# Insert LOG End
		}
	}
	
	$blacklist = checkBlacklist($no_ktp, $nama, $date, $birth_place, $mother_nm, $prospect, $user);
	$pefindo = checkPefindo($prospect, $no_ktp);
	$arr = checkScoring($prospect, $no_ktp);
	extract($arr);
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
</style>
<div class="row">
	<?php if($Warning_Data <> ""){?>
	<div class="alert alert-danger fade in">
		<strong>Danger!</strong><br>
		<?php echo $Warning_Data;?>
	</div>
	<br>
	<?php } ?>
	<?php if($Warning_Data_Pefindo <> ""){?>
	<div class="alert alert-warning fade in">
		<strong><i class="fa fa-exclamation-triangle"></i> Warning!</strong><br>
		<?php echo $Warning_Data;?>
	</div>
	<br>
	<?php } ?>
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Data Individual</h4>
				<p class="category">Data indivial dari hasil survey</p>
			</div>
			<hr>
			<div class="content">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-striped table-bordered" style="width:100%;font-size:12px;">
								<tbody>
									<tr>
										<td colspan="2" style="color:#FFF;background-color:#035c7a;"><b>DATA INDIVIDUAL</td>
									</tr>
									<tr>
										<td>Nomor Prospek</td>
										<td><?php echo $prospect;?></td>
									</tr>
									<tr>
										<td>Nomor KTP</td>
										<td><?php echo $no_ktp;?></td>
									</tr>
									<tr>
										<td>Nama Lengkap</td>
										<td><?php echo $nama;?></td>
									</tr>
									<tr>
										<td>Tanggal Lahir</td>
										<td><?php echo $date;?></td>
									</tr>
									<tr>
										<td>Nama Ibu Kandung</td>
										<td><?php echo $mother_nm;?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Hasil Pengecekan</h4>
				<p class="category">Pengecekan Blacklist Internal, Dukcapil, dan Pefindo</p>
			</div>
			<hr>
			<div class="content">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-bordered table-striped" style="width:100%;font-size:12px;">
								<thead></thead>
								<tbody>
									<tr>
										<td colspan="2" style="color:#FFF;background-color:#035c7a;"><b>HASIL PENGECEKAN</td>
									</tr>
									<?php
									/***** CEK BLACKLIST *****/
									$call_bls = "{call SP_CHECK_PEFINDO_BLACKLIST(?,?,?,?,?,?,?)}";
									$params_bls = array(
													array($no_ktp, SQLSRV_PARAM_IN),
													array($nama, SQLSRV_PARAM_IN),
													array($date, SQLSRV_PARAM_IN),
													array($birth_place, SQLSRV_PARAM_IN),
													array($mother_nm, SQLSRV_PARAM_IN),
													array($prospect, SQLSRV_PARAM_IN),
													array($user, SQLSRV_PARAM_IN)
												);
									$options =  array( "Scrollable" => "buffered" );
									$exec_bls = sqlsrv_query($conn, $call_bls, $params_bls, $options) or die( print_r( sqlsrv_errors(), true)); 
									$data = sqlsrv_fetch_array($exec_bls);
									$checkBlacklist=sqlsrv_num_rows($exec_bls);

									if($checkBlacklist > 0){
										echo"
										<tr>
											<td>Blacklist Internal</td>
											<td>DITEMUKAN</td>
										</tr>";
									}else{
										echo"
										<tr>
											<td>Blacklist Internal</td>
											<td>TIDAK DITEMUKAN</td>
										</tr>";
									}
									
									/***** CEK DUKCAPIL *****/
									$call_dkcpl = "{call SP_CHECK_LOG_DUKCAPIL(?)}";
									$params_dkcpl = array(
													array($prospect, SQLSRV_PARAM_IN)//,
													//array($no_ktp, SQLSRV_PARAM_IN)
												);
									$options =  array( "Scrollable" => "buffered" );
									$exec_dkcpl = sqlsrv_query( $conn, $call_dkcpl, $params_dkcpl, $options) or die( print_r( sqlsrv_errors(), true)); 
									$data_dkcpl = sqlsrv_fetch_array($exec_dkcpl);
									$checkDukcapil=sqlsrv_num_rows($exec_dkcpl);
									
									if($checkDukcapil > 0){
										echo"
										<tr>
											<td>Disdukcapil</td>
											<td>".$data_dkcpl['STATUS']." - CHECKED BY : ".$data_dkcpl['CREATE_USER']." (".$data_dkcpl['CREATE_DATE']->format('d-m-Y H:i:s').")</td>
										</tr>";
									}else{
										echo"
										<tr>
											<td>Disdukcapil</td>
											<td>TIDAK DITEMUKAN</td>
										</tr>";
									}
									
									/***** CEK SCORING *****/
									$call_scoring = "{call SP_CHECK_LOG_SCORING(?,?)}";
									$params_scoring = array(
													array($prospect, SQLSRV_PARAM_IN),
													array($no_ktp, SQLSRV_PARAM_IN)
												);
									$options =  array( "Scrollable" => "buffered" );
									$exec_scoring = sqlsrv_query( $conn, $call_scoring, $params_scoring, $options) or die( print_r( sqlsrv_errors(), true)); 
									$data_scoring = sqlsrv_fetch_array($exec_scoring);
									$checkScoring=sqlsrv_num_rows($exec_scoring);
									
									if($checkScoring > 0){
										echo"
										<tr>
											<td>Pefindo Biro Kredit</td>
											<td>DITEMUKAN</td>
										</tr>";
									}else{
										echo"
										<tr>
											<td>Pefindo Biro Kredit</td>
											<td>TIDAK DITEMUKAN</td>
										</tr>";
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="content">
				<div class="row">
					<div class="col-md-12">
						<h4 class="title">Response Pefindo</h4><br>
						<div class="table-responsive">
							<table class="table table-bordered table-stripped" style="width:100%;font-size:12px;">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">No</th>
										<th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">Nomor KTP</th>
										<th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">Nama Lengkap</th>
										<th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">Tanggal Lahir</th>
										<th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">Alamat</th>
										<th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">Action</th>
									</tr>
								</thead>
								<tbody>
								<?php
									if($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aStatus'] == 'SubjectFound'){
										if($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aPefindoId'] <> NULL){
											
											if($no_ktp != $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aKTP']){
												$Warning_Data_Pefindo = $Warning_Data_Pefindo." - Terdapat perbedaan data antara NIK CONFINS dan PEFINDO.!<br>";
											}
											
											if(strtoupper(trim($nama)) != strtoupper(trim($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aFullName']))){
												$Warning_Data_Pefindo = $Warning_Data_Pefindo." - Terdapat perbedaan data antara Nama CONFINS dan PEFINDO.!<br>";
											}
											
											if($date != date('Y-m-d', strtotime($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aDateOfBirth']))){
												$Warning_Data_Pefindo = $Warning_Data_Pefindo." - Terdapat perbedaan data antara Tanggal Lahir CONFINS dan PEFINDO.!<br>";
											}
								?>
									<tr>
										<td class="td-custom">1</td>
										<td class="td-custom">
											<!--<a href="#" data-target="#dataDukcapil" data-toggle="modal" style="cursor:pointer; color: blue;">-->
												<?php echo $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aKTP'];?>
											<!--</a>-->
										</td>
										<td><?php echo strtoupper($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aFullName']);?></td>
										<td class="td-custom"><?php echo date('Y-m-d', strtotime($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aDateOfBirth']));?></td>
										<td><?php echo $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aAddress'];?></td>
										<td class="td-custom">
											<?php if($Warning_Data == ""){ ?>
											<a href="check.php?USERNAME=<?php echo $user;?>&request=individual&no=<?php echo $prospect;?>&id=<?php echo $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aPefindoId'];?>&custtype=<?php echo $siapanih;?>" class="btn btn-custom btn-sm"><i class="fa fa-search"></i> CHECK SCORING</a>
											<?php }else{ ?>
											<button type="button" disabled class="btn btn-custom btn-sm"><i class="fa fa-search"></i> CHECK SCORING</button>
											<?php } ?>
										</td>
									</tr>
								<?php
										}else{
											$no=0;
											foreach($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord'] as $item) {
												$no++;
								?>
									<tr>
										<td class="td-custom"><?php echo $no;?></td>
										<td class="td-custom"><?php if($item['aKTP'] <> NULL){echo $item['aKTP'];}?></td>
										<td><?php echo strtoupper($item['aFullName']);?></td>
										<td class="td-custom"><?php echo date('Y-m-d', strtotime($item['aDateOfBirth']));?></td>
										<td><?php if($item['aAddress'] <> NULL){echo $item['aAddress'];}?></td>
										<td class="td-custom">
											<?php if($Warning_Data == ""){ ?>
											<a href="check.php?USERNAME=<?php echo $user;?>&request=individual&no=<?php echo $prospect;?>&id=<?php echo $item['aPefindoId'];?>&custtype=<?php echo $siapanih;?>" class="btn btn-custom btn-sm"><i class="fa fa-search"></i> CHECK SCORING</a>								
											<?php }else{ ?>
											<button type="button" disabled class="btn btn-custom btn-sm"><i class="fa fa-search"></i> CHECK SCORING</button>
											<?php } ?>
										</td>
									</tr>
								<?php		
											}
										}
									}else{
										if(isset($_POST['submit'])){
											//echo"<script>alert('Prospek atas nama ".$nama." dengan NIK ".$no_ktp." tidak mempunyai record di Pefindo, silahkan cek kembali lewat SLIK')</script>";
										}
								?>
									<tr>
										<td colspan="6" style="text-align:center;">DATA TIDAK DITEMUKAN</td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<i class="text-danger"><b>*Jika data tidak ada di Pefindo, maka klik tombol "CEK DI SLIK"</b></i>
					</div>
				</div>
				<hr>
				<?php
				if($Warning_Data == ""){
					$call_scoring = "{call SP_CHECK_LOG_SCORING(?,?)}";
					$params_scoring = array(
									array($prospect, SQLSRV_PARAM_IN),
									array($no_ktp, SQLSRV_PARAM_IN)
								);
					$options =  array( "Scrollable" => "buffered" );
					$exec_scoring = sqlsrv_query( $conn, $call_scoring, $params_scoring, $options) or die( print_r( sqlsrv_errors(), true)); 
					$data_scoring = sqlsrv_fetch_array($exec_scoring);
					$checkScoring=sqlsrv_num_rows($exec_scoring);
					if($checkScoring > 0){ 
				?>
						<div class="row">
							<div class="col-md-12">
								<button type='button' class='btn btn-custom' disabled style="width:100%;"><i class="fa fa-search"></i> CEK DI SLIK</button>
							</div>
						</div>
					<?php }else{ ?>
				<div class="row">
					<div class="col-md-12">
						<form action='check-slik.php' method='post'>
							<input name='prospect_no' type='hidden' value='<?php echo $prospect;?>'>
							<input name='no_ktp' type='hidden' value='<?php echo $no_ktp;?>'>
							<input name='nama' type='hidden' value='<?php echo $nama;?>'>
							<input name='birth_dt' type='hidden' value='<?php echo $date;?>'>
							<input name='cust_type' type='hidden' value='P'>
							<input name='id_type' type='hidden' value='KTP'>
							<input name='username' type='hidden' value='<?php echo $user;?>'>
							<input name='tipe_cust' type='hidden' value='<?php echo $siapanih;?>'>
							<input name='message' type='hidden' value='<?php echo $Warning_Data_Sementara." ".$Warning_Data." ".$Warning_Data_Pefindo;?>'>
							<button type='submit' class='btn btn-custom' style="width:100%;"><i class="fa fa-search"></i> CEK DI SLIK</div>
						</form>
					</div>
				</div>
				<?php }
				}else{ 
				?>
				<div class="row">
					<div class="col-md-12">
						<button type='button' class='btn btn-custom' disabled style="width:100%;"><i class="fa fa-search"></i> CEK DI SLIK</button>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php } ?>