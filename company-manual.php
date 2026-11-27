<?php
require_once("config/configuration.php");
if(isset($_POST['submit'])){
	$npwp = $_POST['npwp'];
	$name = $_POST['name'];
	
	$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_URL => $pefindoURL,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 60,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"\r\nxmlns:cb5=\"http://creditinfo.com/CB5\"\r\nxmlns:smar=\"http://creditinfo.com/CB5/v5.31/SmartSearch\">\r\n <soapenv:Header/>\r\n <soapenv:Body>\r\n <cb5:SmartSearchCompany>\r\n <cb5:query>\r\n <smar:InquiryReason>ProvidingFacilities</smar:InquiryReason>\r\n <smar:InquiryReasonText/>\r\n <smar:Parameters>\r\n <smar:CompanyName>".$name."</smar:CompanyName>\r\n <smar:IdNumbers>\r\n <smar:IdNumberPairCompany>\r\n <smar:IdNumber>".$npwp."</smar:IdNumber>\r\n <smar:IdNumberType>NPWP</smar:IdNumberType>\r\n </smar:IdNumberPairCompany>\r\n </smar:IdNumbers>\r\n </smar:Parameters>\r\n </cb5:query>\r\n </cb5:SmartSearchCompany>\r\n </soapenv:Body>\r\n</soapenv:Envelope>",
		CURLOPT_HTTPHEADER => array(
			"Authorization: Basic " . base64_encode("$username:$password"),
			"Content-Type: text/xml",
			"Postman-Token: ae0ace2e-aa92-4d66-8d14-d67edb42fa84",
			"SOAPAction: ".$smartSearchCompany,
			"cache-control: no-cache"
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	
	if ($err) { //jika pemintaan request pefindo error
		echo "cURL Error #:" . $err;
		
		//echo"<script>window.location='index.php?USERNAME=".$user."&page=error'</script>";
	} else {
		$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
		$xml = new SimpleXMLElement($response);
		$body = $xml->xpath('//sBody')[0];
		$array = json_decode(json_encode((array)$body), TRUE); 
		//print_r($array);
	}
}else{
	$npwp = "";
	$name = "";
	$date = "";
	$siapanih = "";
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
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Company</h4>
				<p class="category">Pengecekan Company Manual</p>
			</div>
			<div class="content">
				<form action="" method="post">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Nomor NPWP</label>
								<input type="text" name="npwp" class="form-control" placeholder="Nomor NPWP" value="<?php echo $npwp;?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Nama Perusahaan</label>
								<input type="text" name="name" class="form-control" placeholder="Nama Perusahaan" value="<?php echo $name;?>">
							</div>
						</div>
					</div>
					<div class="pull-right">
						<input type="submit" name="submit" class="btn btn-custom" value="CARI">
					</div>
					<div style="clear:both;"></div>
				</form>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="content">
								<div class="row">
									<div class="col-md-12">
										<h4 class="title">Response Pefindo</h4><br>
										<div class="table-responsive">
											<?php if(isset($_POST['submit'])){ ?>
												<table class="table table-bordered table-striped" style="width:100%;font-size:12px;">
													<thead>
														<tr>
															<th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">No</th>
															<th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">Nomor NPWP</th>
															<th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">Nama Perusahaan</th>
															<th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">Alamat</th>
															<th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">Action</th>
														</tr>
													</thead>
													<tbody>
													<?php
														if($array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aStatus'] == 'SubjectFound'){
															if($array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aPefindoId'] <> NULL){
													?>
														<tr>
															<td class="td-custom">1</td>
															<td class="td-custom">
																<?php echo $array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aCompanyRecords']['aSearchCompanyRecord']['aNPWP'];?>
															</td>
															<td><?php echo $array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aCompanyRecords']['aSearchCompanyRecord']['aCompanyName'];?></td>
															<td><?php echo $array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aCompanyRecords']['aSearchCompanyRecord']['aAddress'];?></td>
															<td class="td-custom">
																<form action="check.php" method="post">
																	<input type="hidden" name="user" value="<?php echo $user;?>">
																	<input type="hidden" name="request" value="company">
																	<input type="hidden" name="no_prospect" value="MANUAL">
																	<input type="hidden" name="no_ktp" value="<?php echo $npwp;?>">
																	<input type="hidden" name="pefindo_id" value="<?php echo $array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aCompanyRecords']['aSearchCompanyRecord']['aPefindoId'];?>">
																	<input type="hidden" name="type_customer" value="">
																	<input type="submit" class="btn btn-custom btn-xs" value="Check Scoring">
																</form>
															</td>
														</tr>
													<?php
															}else{
																$no=0;
																foreach($array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aCompanyRecords']['aSearchCompanyRecord'] as $item) {
																	$no++;
													?>
														<tr>
															<td class="td-custom"><?php echo $no;?></td>
															<td class="td-custom"><?php if($item['aNPWP'] <> NULL){echo $item['aNPWP'];}?></td>
															<td><?php echo strtoupper($item['aCompanyName']);?></td>
															<td><?php if($item['aAddress'] <> NULL){echo $item['aAddress'];}?></td>
															<td class="td-custom">
																<form action="check.php" method="post">
																	<input type="hidden" name="user" value="<?php echo $user;?>">
																	<input type="hidden" name="request" value="company">
																	<input type="hidden" name="no_prospect" value="MANUAL">
																	<input type="hidden" name="no_ktp" value="<?php echo $npwp;?>">
																	<input type="hidden" name="pefindo_id" value="<?php echo $item['aPefindoId'];?>">
																	<input type="hidden" name="type_customer" value="">
																	<input type="submit" class="btn btn-custom btn-xs" value="Check Scoring">
																</form>
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
												<div class="row">
													<div class="col-md-12">
														<i class="text-danger"><b>*Jika data tidak ada di Pefindo, maka klik tombol "CEK DI SLIK"</b></i>
													</div>
												</div>
												<hr>
												<div class="row">
													<div class="col-md-12">
														<form action='check-slik.php' method='post'>
															<input name='prospect_no' type='hidden' value='MANUAL'>
															<input name='no_ktp' type='hidden' value='<?php echo $npwp;?>'>
															<input name='nama' type='hidden' value='<?php echo $name;?>'>
															<input name='birth_dt' type='hidden' value=''>
															<input name='cust_type' type='hidden' value='C'>
															<input name='id_type' type='hidden' value='NPWP'>
															<input name='username' type='hidden' value='<?php echo $user;?>'>
															<input name='tipe_cust' type='hidden' value=''>
															<button type='submit' class='btn btn-custom' style="width:100%;"><i class="fa fa-search"></i> CEK DI SLIK</div>
														</form>
													</div>
												</div>
											<?php }else{ ?>
												<table class="table table-bordered table-striped" style="width:100%;font-size:12px;">
													<thead>
														<tr>
															<th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">No</th>
															<th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">Nomor NPWP</th>
															<th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">Nama Perusahaan</th>
															<th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">Alamat</th>
															<th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">Action</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td colspan="6" style="text-align:center;">Silahkan cari data terlebih dahulu</td>
														</tr>
													</tbody>
												</table>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
