<?php
require_once("config/configuration.php");


$no_prospect = $_POST['no_prospect'];
$no_ktp = $_POST['no_ktp'];
$nama =$_POST['nama'];
$date = $_POST['date'];
$siapanih = "PASANGAN";

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $pefindoURL,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 60,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "<?xml version='1.0' encoding='UTF-8'?><soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" \r\nxmlns:cb5=\"http://creditinfo.com/CB5\" \r\nxmlns:smar=\"http://creditinfo.com/CB5/v5.31/SmartSearch\">\r\n\t<soapenv:Header/>\r\n\t<soapenv:Body>\r\n\t\t<cb5:SmartSearchIndividual>\r\n\t\t<cb5:query>\r\n\t\t\t<smar:InquiryReason>ProvidingFacilities</smar:InquiryReason>\r\n\t\t\t<smar:InquiryReasonText/>\r\n\t\t\t<smar:Parameters>\r\n\t\t\t\t<smar:DateOfBirth>".$date."</smar:DateOfBirth>\r\n\t\t\t\t<smar:FullName>".$nama."</smar:FullName>\r\n\t\t\t\t<smar:IdNumbers>\r\n\t\t\t\t\t<!--Zero or more repetitions:-->\r\n\t\t\t\t\t<smar:IdNumberPairIndividual>\r\n\t\t\t\t\t\t<smar:IdNumber>".$no_ktp."</smar:IdNumber>\r\n\t\t\t\t\t\t<smar:IdNumberType>KTP</smar:IdNumberType>\r\n\t\t\t\t\t</smar:IdNumberPairIndividual>\r\n\t\t\t\t</smar:IdNumbers>\r\n\t\t\t</smar:Parameters>\r\n\t\t</cb5:query>\r\n\t</cb5:SmartSearchIndividual>\r\n</soapenv:Body>\r\n</soapenv:Envelope>",
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
	//echo "cURL Error #:" . $err;
	echo"<script>window.location='index.php?username=".$user."&page=error'</script>";
} else {
	$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
	$xml = new SimpleXMLElement($response);
	$body = $xml->xpath('//sBody')[0];
	$array = json_decode(json_encode((array)$body), TRUE); 
	//print_r($array);
}
?>
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
				<a href="check.php?USERNAME=<?php echo $user;?>&request=individual&no=<?php echo $no_prospect;?>&id=<?php echo $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aPefindoId'];?>&custtype=<?php echo $siapanih;?>" class="btn btn-success btn-sm"><i class="fa fa-search"></i> Check Scoring</a>
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
				<a href="check.php?USERNAME=<?php echo $user;?>&request=individual&no=<?php echo $no_prospect;?>&id=<?php echo $item['aPefindoId'];?>&custtype=<?php echo $siapanih;?>" class="btn btn-success btn-sm"><i class="fa fa-search"></i> Check Scoring</a>					
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