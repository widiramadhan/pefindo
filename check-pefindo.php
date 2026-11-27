<?php
require_once("config/configuration.php");
$Warning_Data = "";

if(isset($_POST['check'])){
	$prospect=$_POST['prospect_no'];
	$no_ktp=$_POST['no_ktp'];
	$nama=$_POST['name'];
	$date=$_POST['date'];
	$mother_nm=$_POST['mother_name'];
	$birth_place=$_POST['birth_place'];
	$siapanih=$_POST['tipe_cust'];
	$getUsername=$_GET['USERNAME'];
	
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

		$callSPLogPfnd = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
		$paramsLogPfnd = array(array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLog, SQLSRV_PARAM_IN),array($StatusLog, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
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

				$callSPLogPfndScss = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
				$paramsLogPfndScss = array(array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogPfndScss, SQLSRV_PARAM_IN),array($StatusLogPfndScss, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
				$execLogPfndScss = sqlsrv_query( $conn, $callSPLogPfndScss, $paramsLogPfndScss) or die( print_r( sqlsrv_errors(), true));
				if($execLogPfndScss === false){
					echo"<script>alert('Error insert log Pefindo DataFound');</script>";
				}
				//----# Insert LOG End
			}else{
				//----# Insert LOG
				$SourceLogPfndScssMlti = "PEFINDO";
				$StatusLogPfndScssMlti = "DATA DITEMUKAN - MULTI PEFINDO ID";

				$callSPLogPfndScssMlti = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
				$paramsLogPfndScssMlti = array(array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogPfndScssMlti, SQLSRV_PARAM_IN),array($StatusLogPfndScssMlti, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
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

			$callSPLogPfndNtfnd = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
			$paramsLogPfndNtfnd = array(array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogPfndNtfnd, SQLSRV_PARAM_IN),array($StatusLogPfndNtfnd, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
			$execLogPfndNtfnd = sqlsrv_query( $conn, $callSPLogPfndNtfnd, $paramsLogPfndNtfnd) or die( print_r( sqlsrv_errors(), true));
			if($execLogPfndNtfnd === false){
				echo"<script>alert('Error insert log Pefindo DataFound');</script>";
			}
			//----# Insert LOG End
		}
	}
}else{
	$prospect=$_POST['prospect_no'];
	$no_ktp=$_POST['no_ktp'];
	$nama=$_POST['name'];
	$date=$_POST['date'];
	$mother_nm=$_POST['mother_name'];
	$birth_place=$_POST['birth_place'];
	$siapanih=$_POST['tipe_cust'];
	$getUsername=$_GET['USERNAME'];
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
</style>
<div class="row">
	<?php if($Warning_Data <> ""){?>
	<div class="alert alert-danger fade in">
		<strong>Danger!</strong><br>
		<?php echo $Warning_Data;?>
	</div>
	<br>
	<?php } ?>
	<br>
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Pefindo Biro Kredit</h4>
				<p class="category">Pengecekan Pefindo Biro Kredit</p>
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
										<td colspan="3" style="color:#FFF;background-color:#035c7a;"><b>PEFINDO BIRO KREDIT</td>
									</tr>
									<?php
									/***** CEK PEFINDO *****/
									$call = "{call SP_CHECK_LOG_PEFINDO(?,?)}";
									$params = array(
													array($prospect, SQLSRV_PARAM_IN),
													array($no_ktp, SQLSRV_PARAM_IN)
												);
									$options =  array( "Scrollable" => "buffered" );
									$exec = sqlsrv_query($conn, $call, $params, $options) or die( print_r( sqlsrv_errors(), true)); 
									$data = sqlsrv_fetch_array($exec);
									$checkPefindo=sqlsrv_num_rows($exec);

									if($checkPefindo > 0){
										if($data['CREATE_DATE'] <> ''){
											$checked_by = "Checked by ".$data['CREATE_USER']." (".$data['CREATE_DATE'].")";
										}else{
											$checked_by = "-";
										}
										echo"
										<tr>
											<td style='width:33%;'>Hasil Pengecekan Pefindo</td>
											<td style='width:33%;'>".$data['STATUS']."</td>
											<td style='width:33%;'>".$checked_by."</td>
										</tr>";
									}else{
										echo"
										<tr>
											<td style='width:33%;'>Hasil Pengecekan Pefindo</td>
											<td style='width:33%;'>BELUM PERNAH DI CEK</td>
											<td style='width:33%;'>-</td>
										</tr>";
									}
									
									$call2 = "{call SP_CHECK_LOG_SCORING(?,?)}";
									$params2 = array(
													array($prospect, SQLSRV_PARAM_IN),
													array($no_ktp, SQLSRV_PARAM_IN)
												);
									$options2 =  array( "Scrollable" => "buffered" );
									$exec2 = sqlsrv_query($conn, $call2, $params2, $options2) or die( print_r( sqlsrv_errors(), true)); 
									$data2 = sqlsrv_fetch_array($exec2);
									$checkPefindo2=sqlsrv_num_rows($exec2);
									
									if($checkPefindo2 > 0){
										if($data2['CREATE_DATE'] <> ''){
											$checked_by2 = "Checked by ".$data2['CREATE_USER']." (".$data2['CREATE_DATE'].")";
										}else{
											$checked_by2 = "-";
										}
										echo"
										<tr>
											<td style='width:33%;'>Hasil Pengecekan Scoring</td>
											<td style='width:33%;'>".$data2['STATUS']."</td>
											<td style='width:33%;'>".$checked_by2."</td>
										</tr>";
									}else{
										echo"
										<tr>
											<td style='width:33%;'>Hasil Pengecekan Scoring</td>
											<td style='width:33%;'>BELUM PERNAH DI CEK</td>
											<td style='width:33%;'>-</td>
										</tr>";
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div style="float:right;margin-right:10px;">
							<form action="" method="post">
								<input name='prospect_no' type='hidden' value='<?php echo $prospect;?>'>
								<input name='no_ktp' type='hidden' value='<?php echo $no_ktp;?>'>
								<input name='name' type='hidden' value='<?php echo $nama;?>'>
								<input name='date' type='hidden' value='<?php echo $date;?>'>
								<input name='mother_name' type='hidden' value='<?php echo $mother_nm;?>	'>
								<input name='birth_place' type='hidden' value='<?php echo $birth_place;?>'>
								<input name='tipe_cust' type='hidden' value='<?php echo $siapanih;?>'>
								<input type="submit" class="btn btn-custom btn-xs" value="Check Pefindo" name="check" onclick="return confirm('Apakah anda yakin ingin mengecek data ini?')">
							</form>
						</div>
					</div>
				</div>
				<br>
				<?php if(isset($_POST['check'])){ ?>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<p class="category">Response Pefindo Biro Kredit</p><br>
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
								?>
									<tr>
										<td class="td-custom">1</td>
										<td class="td-custom">
												<?php echo $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aKTP'];?>
										</td>
										<td><?php echo strtoupper($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aFullName']);?></td>
										<td class="td-custom"><?php echo date('Y-m-d', strtotime($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aDateOfBirth']));?></td>
										<td><?php if($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aAddress'] == NULL){ 
													echo "-"; 
											}else {
												  echo $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aAddress'];}?></td>
										<td class="td-custom">
											<?php if($Warning_Data == ""){ ?>
											<form action="check.php" method="post">
												<input type="hidden" name="user" value="<?php echo $user;?>">
												<input type="hidden" name="request" value="individual">
												<input type="hidden" name="no_prospect" value="<?php echo $prospect;?>">
												<input type="hidden" name="no_ktp" value="<?php echo $no_ktp;?>">
												<input type="hidden" name="pefindo_id" value="<?php echo $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aPefindoId'];?>">
												<input type="hidden" name="type_customer" value="<?php echo $siapanih;?>">
												<input type="submit" class="btn btn-custom btn-xs" value="Check Scoring">
											</form>
											<?php }else{ ?>
											<button type="button" disabled class="btn btn-custom btn-xs">Check Scoring</button>
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
											<form action="check.php" method="post">
												<input type="hidden" name="user" value="<?php echo $user;?>">
												<input type="hidden" name="request" value="individual">
												<input type="hidden" name="no_prospect" value="<?php echo $prospect;?>">
												<input type="hidden" name="no_ktp" value="<?php echo $no_ktp;?>">
												<input type="hidden" name="pefindo_id" value="<?php echo $item['aPefindoId'];?>">
												<input type="hidden" name="type_customer" value="<?php echo $siapanih;?>">
												<input type="submit" class="btn btn-custom btn-xs" value="Check Scoring">
											</form>
											<?php }else{ ?>
											<button type="button" disabled class="btn btn-custom btn-xs">Check Scoring</button>
											<?php } ?>
										</td>
									</tr>
								<?php		
											}
										}
									}else{
								?>
									<tr>
										<td colspan="6" style="text-align:center;">Data tidak ditemukan</td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<?php 
					$call51 = "{call SP_CHECK_LOG_PEFINDO_TIDAK_DITEMUKAN(?,?)}";
					$params51 = array(
									array($prospect, SQLSRV_PARAM_IN),
									array($no_ktp, SQLSRV_PARAM_IN)
								);
					$options51 =  array( "Scrollable" => "buffered" );
					$exec51 = sqlsrv_query($conn, $call51, $params51, $options51) or die( print_r( sqlsrv_errors(), true)); 
					$data51 = sqlsrv_fetch_array($exec51);
				
				?>
				<div class="row">
				<?php
				if($data51['STATUS'] == "DATA TIDAK DITEMUKAN"){
				?>
				<div class="col-md-6">
					<i class="text-danger"><b>*Jika data tidak ditemukan di Pefindo, maka klik tombol SUBMIT"</b></i>
				</div>
					<!--<div class="col-md-6">
						<i class="text-danger"><b>*Jika data tidak ada di Pefindo, maka klik tombol "AJUKAN CEK SLIK"</b></i>
					</div>-->
						<div class="row">
					<div class="col-md-6">
				
						<?php
						
						?>
						<form action="check-notfound.php" method="post">
							<input type="hidden" name="user" value="<?php echo $user;?>">
							<input type="hidden" name="request" value="individual">
							<input type="hidden" name="no_prospect" value="<?php echo $prospect;?>">
							<input type="hidden" name="no_ktp" value="<?php echo $no_ktp;?>">
							<input type="hidden" name="pefindo_id" value="0000">
							<input type="hidden" name="type_customer" value="<?php echo $siapanih;?>">
							<input type="submit" class="btn btn-custom btn-xs" style="width:100%;"  value="Submit">
						</form>
						
					</div>
						
						<?php /*
						
						<form action='check-slik.php' method='post'>
							<input name='prospect_no' type='hidden' value='<?php echo $prospect;?>'>
							<input name='no_ktp' type='hidden' value='<?php echo $no_ktp;?>'>
							<input name='nama' type='hidden' value='<?php echo $nama;?>'>
							<input name='birth_dt' type='hidden' value='<?php echo $date;?>'>
							<input name='cust_type' type='hidden' value='P'>
							<input name='id_type' type='hidden' value='KTP'>
							<input name='username' type='hidden' value='<?php echo $user;?>'>
							<input name='tipe_cust' type='hidden' value='<?php echo $siapanih;?>'>
							
							<button type='submit' class='btn btn-custom btn-sm' style="width:100%;">Ajukan Cek SLIK</button>
						</form>
						*/ ?>
						
					</div>
					<?php }else{ ?>
						<!--<button type='button' class='btn btn-custom btn-sm' disabled style="width:100%;">Ajukan Cek SLIK</button>-->
						<?php } ?>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>