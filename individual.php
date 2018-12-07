<style>
th{
	text-align:center;
	font-weight:bold;
}
td{
	text-align:center;
}
</style>
<?php
require_once("config/configuration.php");
error_reporting(0);

if(isset($_POST['select'])){
	$prospect_no=$_POST['prospect_no'];
	$id_no=$_POST['id_no'];
	$cust_name=$_POST['cust_name'];
	$birth_dt=$_POST['birth_dt'];
}else{
	$prospect_no="";
	$id_no="";
	$cust_name="";
	$birth_dt="";
}	

if(isset($_POST['submit'])){
	$prospect=$_POST['prospect_no'];
	$date=$_POST['date'];
	$nama=$_POST['name'];
	$no_ktp=$_POST['no_ktp'];
}else{
	$prospect="";
	$date="";
	$nama="";
	$no_ktp="";
}

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $pefindoURL,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "<?xml version='1.0' encoding='UTF-8'?><soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" \r\nxmlns:cb5=\"http://creditinfo.com/CB5\" \r\nxmlns:smar=\"http://creditinfo.com/CB5/v5.48/SmartSearch\">\r\n\t<soapenv:Header/>\r\n\t<soapenv:Body>\r\n\t\t<cb5:SmartSearchIndividual>\r\n\t\t<cb5:query>\r\n\t\t\t<smar:InquiryReason>ProvidingFacilities</smar:InquiryReason>\r\n\t\t\t<smar:InquiryReasonText/>\r\n\t\t\t<smar:Parameters>\r\n\t\t\t\t<smar:DateOfBirth>".$date."</smar:DateOfBirth>\r\n\t\t\t\t<smar:FullName>".$nama."</smar:FullName>\r\n\t\t\t\t<smar:IdNumbers>\r\n\t\t\t\t\t<!--Zero or more repetitions:-->\r\n\t\t\t\t\t<smar:IdNumberPairIndividual>\r\n\t\t\t\t\t\t<smar:IdNumber>".$no_ktp."</smar:IdNumber>\r\n\t\t\t\t\t\t<smar:IdNumberType>KTP</smar:IdNumberType>\r\n\t\t\t\t\t</smar:IdNumberPairIndividual>\r\n\t\t\t\t</smar:IdNumbers>\r\n\t\t\t</smar:Parameters>\r\n\t\t</cb5:query>\r\n\t</cb5:SmartSearchIndividual>\r\n</soapenv:Body>\r\n</soapenv:Envelope>",
  CURLOPT_HTTPHEADER => array(
	"Authorization: Basic " . base64_encode("$username:$password"),
    "Content-Type: text/xml",
    "Postman-Token: ae0ace2e-aa92-4d66-8d14-d67edb42fa84",
    "SOAPAction: ".$smartSearchIndividual,
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	//echo "cURL Error #:" . $err;
	echo"<script>window.location='index.php?page=error'</script>";
} else {
	$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
	$xml = new SimpleXMLElement($response);
	$body = $xml->xpath('//sBody')[0];
	$array = json_decode(json_encode((array)$body), TRUE); 
	//print_r($array);
}
?>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Individual</h4>
				<p class="category">Sistem Informasi Debitur</p>
			</div>
			<div class="content">
				<form action="" method="post">
					<div class="row">
						<div class="col-md-3">
							<label>Prospect Number</label>	
							<div class="input-group date">
								<input type="text" name="no_prospect" class="form-control" placeholder="Prospect Number" value="<?php echo $prospect_no;?>" disabled style="cursor:pointer;">
								<input type="hidden" name="prospect_no" value="<?php echo $prospect_no;?>">
								<div class="input-group-addon" data-target="#prospect" data-toggle="modal" style="cursor:pointer;">
									<i class="fa fa-search"></i>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>KTP Number</label>
								<input type="text" class="form-control" placeholder="KTP Number" value="<?php echo $id_no;?>" disabled>
								<input type="hidden" name="no_ktp" value="<?php echo $id_no;?>">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Fullname</label>
								<input type="text" name="name" class="form-control" placeholder="Fullname" value="<?php echo $cust_name;?>" disabled>
								<input type="hidden" name="name" value="<?php echo $cust_name;?>">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Date of Birth</label>
								<div class="input-group date">
									<input type="text" class="form-control pull-right" name="date" id="datepicker" readonly="true" placeholder="Date" value="<?php echo $birth_dt;?>" disabled>
									<input type="hidden" name="date" id="datepicker" value="<?php echo $birth_dt;?>">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="pull-right">
						<button type="submit" name="submit" class="btn btn-primary">Search</button>
						<button type="reset" class="btn btn-danger">Cancel</button>
					</div>
					<div style="clear:both;"></div>
				</form>
				<hr>
				<table class="table table-bordered table-stripped">
					<thead>
						<tr>
							<th>No</th>
							<th>KTP Number</th>
							<th>Fullname</th>
							<th>Date of Birth</th>
							<th>Address</th>
							<th style="width:10%;">Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
						if($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aStatus'] == 'SubjectFound'){
							if($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aPefindoId'] <> NULL){
					?>
						<tr>
							<td>1</td>
							<td><?php echo $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aKTP'];?></td>
							<td><?php echo $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aFullName'];?></td>
							<td><?php echo date('d-m-Y', strtotime($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aDateOfBirth']));?></td>
							<td><?php echo $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aAddress'];?></td>
							<td>
								<a href="check.php?request=individual&no=<?php echo $prospect;?>&id=<?php echo $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aPefindoId'];?>" class="btn btn-success"><i class="fa fa-search"></i> Check Scoring</a>
							</td>
						</tr>
					<?php
							}else{
								$no=0;
								foreach($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord'] as $item) {
									$no++;
					?>
						<tr>
							<td><?php echo $no;?></td>
							<td><?php echo $item['aKTP'];?></td>
							<td><?php echo $item['aFullName'];?></td>
							<td><?php echo date('d-m-Y', strtotime($item['aDateOfBirth']));?></td>
							<td><?php echo $item['aAddress'];?></td>
							<td>
								<a href="check.php?request=individual&no=<?php echo $prospect;?>&id=<?php echo $item['aPefindoId'];?>" class="btn btn-success"><i class="fa fa-search"></i> Check Scoring</a>
							</td>
						</tr>
					<?php
								}
							}
						}else{
							if(isset($_POST['submit'])){
								echo"<script>alert('Not Found')</script>";
							}
					?>
						<tr>
							<td colspan="6" style="text-align:center;">Not Found</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>