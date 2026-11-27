<?php
require_once("config/configuration.php");

$prospect=$_POST['prospect_no'];
$npwp=$_POST['npwp'];
$nama=$_POST['name'];

if($npwp==""){
	echo"<script>alert('Nomor NPWP tidak boleh kosong, silahkan lakukan edit data di CONFINS');history.back();</script>";
}else if($nama==""){
	echo"<script>alert('Nama tidak boleh kosong, silahkan lakukan edit data di CONFINS');history.back();</script>";
}

$Warning_Data ="";


/********** CEK BLACKLIST **********/
$call_bls = "{call SP_CHECK_PEFINDO_BLACKLIST(?,?,?,?,?,?,?)}";
$params_bls = array(
				array($npwp, SQLSRV_PARAM_IN),
				array($nama, SQLSRV_PARAM_IN),
				array(NULL, SQLSRV_PARAM_IN),
				array(NULL, SQLSRV_PARAM_IN),
				array(NULL, SQLSRV_PARAM_IN),
				array($prospect, SQLSRV_PARAM_IN),
				array($user, SQLSRV_PARAM_IN)
			);
$options =  array( "Scrollable" => "buffered" );
$exec_bls = sqlsrv_query( $conn, $call_bls, $params_bls, $options) or die( print_r( sqlsrv_errors(), true)); 
$data = sqlsrv_fetch_array($exec_bls);
$checkBlacklist=sqlsrv_num_rows($exec_bls);

if($checkBlacklist > 0){	//----# Cek Blacklist
	echo"<script>alert('Customer tersebut terdaftar di Customer Blacklist Internal.');</script>";
	$Warning_Data = $Warning_Data." - Customer ini terdaftar di Customer Blacklist Internal.!<br>";
}
/********** END CEK BLACKLIST **********/


/********** CEK PEFINDO **********/
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => $pefindoURL,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 60,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"\r\nxmlns:cb5=\"http://creditinfo.com/CB5\"\r\nxmlns:smar=\"http://creditinfo.com/CB5/v5.31/SmartSearch\">\r\n <soapenv:Header/>\r\n <soapenv:Body>\r\n <cb5:SmartSearchCompany>\r\n <cb5:query>\r\n <smar:InquiryReason>ProvidingFacilities</smar:InquiryReason>\r\n <smar:InquiryReasonText/>\r\n <smar:Parameters>\r\n <smar:CompanyName>".$nama."</smar:CompanyName>\r\n <smar:IdNumbers>\r\n <smar:IdNumberPairCompany>\r\n <smar:IdNumber>".$npwp."</smar:IdNumber>\r\n <smar:IdNumberType>NPWP</smar:IdNumberType>\r\n </smar:IdNumberPairCompany>\r\n </smar:IdNumbers>\r\n </smar:Parameters>\r\n </cb5:query>\r\n </cb5:SmartSearchCompany>\r\n </soapenv:Body>\r\n</soapenv:Envelope>",
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
	//echo "cURL Error #:" . $err;
	//----# Insert LOG
	$SourceLog = "PEFINDO";
	$StatusLog = "ERROR";

	$callSPLogPfnd = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
	$paramsLogPfnd = array(array($prospect, SQLSRV_PARAM_IN),array($npwp, SQLSRV_PARAM_IN),array($SourceLog, SQLSRV_PARAM_IN),array($StatusLog, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
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

	if($array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aStatus'] == 'SubjectFound'){
		if($array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aPefindoId'] <> NULL){
			//----# Insert LOG
			$SourceLogPfndScss = "PEFINDO";
			$StatusLogPfndScss = "DATA DITEMUKAN";

			$callSPLogPfndScss = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
			$paramsLogPfndScss = array(array($prospect, SQLSRV_PARAM_IN),array($npwp, SQLSRV_PARAM_IN),array($SourceLogPfndScss, SQLSRV_PARAM_IN),array($StatusLogPfndScss, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
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
			$paramsLogPfndScssMlti = array(array($prospect, SQLSRV_PARAM_IN),array($npwp, SQLSRV_PARAM_IN),array($SourceLogPfndScssMlti, SQLSRV_PARAM_IN),array($StatusLogPfndScssMlti, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
			$execLogPfndScssMlti = sqlsrv_query( $conn, $callSPLogPfndScssMlti, $paramsLogPfndScssMlti) or die( print_r( sqlsrv_errors(), true));
			if($execLogPfndScssMlti === false){
				echo"<script>alert('Error insert log Pefindo DataFoundMulti');</script>";
			}
			//----# Insert LOG End
		}
	}else{
		
	}
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
				<h4 class="title">Hasil Pengecekan</h4>
				<p class="category">Pengecekan berdasarkan Blacklist Internal dan Pefindo</p>
			</div>
			<hr>
			<div class="content">
				<div class="row">
					<div class="col-md-12">
						<b>DATA CONFINS :</b><br>
						<div class="table-responsive">
							<table class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;background-color:#035c7a;">No</th>
										<th class="th-custom" style="color:#FFF;background-color:#035c7a;">Nomor Prospek</th>
										<th class="th-custom" style="color:#FFF;background-color:#035c7a;">Nomor NPWP</th>
										<th class="th-custom" style="color:#FFF;background-color:#035c7a;">Nama Perusahaan</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="td-custom">1</td>
										<td class="td-custom"><?php echo $prospect;?></td>
										<td class="td-custom"><?php echo $npwp;?></td>
										<td><?php echo $nama;?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<b>DATA PEFINDO :</b><br>
						<div class="table-responsive">
							<table class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;background-color:#035c7a;">No</th>
										<th class="th-custom" style="color:#FFF;background-color:#035c7a;">NPWP</th>
										<th class="th-custom" style="color:#FFF;background-color:#035c7a;">Nama Perusahaan</th>
										<th class="th-custom" style="color:#FFF;background-color:#035c7a;">Alamat</th>
										<th class="th-custom" style="color:#FFF;background-color:#035c7a;">Action</th>
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
											<!--<a href="#" data-target="#dataDukcapil" data-toggle="modal" style="cursor:pointer; color: blue;">-->
                                            <?php echo $array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aCompanyRecords']['aSearchCompanyRecord']['aNPWP'];?>
											<!--</a>-->
										</td>
										<td><?php echo $array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aCompanyRecords']['aSearchCompanyRecord']['aCompanyName'];?></td>
										<?php $alamatPefindo =  $array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aCompanyRecords']['aSearchCompanyRecord']['aAddress'];?>
									
										<td class="td-custom"><?php if (empty($alamatPefindo)){
												echo "-";
										}else{
										
										echo  $array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aCompanyRecords']['aSearchCompanyRecord']['aAddress'];
										}
										?>
										
										</td>
										<td class="td-custom">
                                           <!--<a href="check.php?USERNAME=<?php //echo $user;?>&request=company&no=<?php //echo $prospect;?>&id=<?php //echo $array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aCompanyRecords']['aSearchCompanyRecord']['aPefindoId'];?>" class="btn btn-success"><i class="fa fa-search"></i> Check Scoring</a>-->
											<form action="check.php" method="post">
												<input type="hidden" name="user" value="<?php echo $user;?>">
												<input type="hidden" name="request" value="company">
												<input type="hidden" name="no_prospect" value="<?php echo $prospect;?>">
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
                                        <td class="td-custom"><?php echo $item['aNPWP'];?></td>
                                        <td class="td-custom"><?php echo $item['aCompanyName'];?></td>
                                        <td class="td-custom"><?php if($item['aAddress'] <> NULL) {
																	echo $item['aAddress'];
																	}else{
																		echo '-';
																	}?></td>
                                        <td class="td-custom">
                                            <!--<a href="check.php?USERNAME=<?php //echo $user;?>&request=company&no=<?php //echo $prospect;?>&id=<?php //echo $item['aPefindoId'];?>" class="btn btn-success"><i class="fa fa-search"></i> Check Scoring</a>-->
											<form action="check.php" method="post">
												<input type="hidden" name="user" value="<?php echo $user;?>">
												<input type="hidden" name="request" value="company">
												<input type="hidden" name="no_prospect" value="<?php echo $prospect;?>">
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
										<td colspan="6" style="text-align:center;">Data tidak ditemukan</td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
						<b><label style="color:red; font-size: 14px"><?php echo $Warning_Data;?></label></b>
						<hr>
						<!--<i class="text-danger"><b>*Jika data tidak ada di Pefindo, maka klik tombol "CEK DI SLIK"</b></i>-->
					</div>
				</div>
				<!--<hr>
				<div class="row">
					<div class="col-md-12">
						<form action='check-slik.php' method='post'>
							<input name='prospect_no' type='text' value='<?php //echo $prospect;?>'>
							<input name='no_ktp' type='text' value='<?php //echo $no_ktp;?>'>
							<input name='nama' type='text' value='<?php //echo $nama;?>'>
							<input name='birth_dt' type='text' value='<?php//echo $date;?>'>
							<input name='cust_type' type='text' value='P'>
							<input name='id_type' type='text' value='KTP'>
							<input name='username' type='text' value='<?php //echo $user;?>'>
							<input name='tipe_cust' type='text' value='<?php //echo $siapanih;?>'>
							<button type='submit' class='btn btn-danger' style="width:100%;"><i class="fa fa-search"></i> CEK DI SLIK</div>
						</form>
					</div>
				</div>-->
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
    $('#datatable').DataTable();
});
</script>