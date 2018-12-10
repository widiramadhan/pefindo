<?php
require_once("../config/configuration.php");
require_once("../config/connection.php");

$pefindoId=$_GET['id'];

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $pefindoURL,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"\r\nxmlns:cb5=\"http://creditinfo.com/CB5\"\r\nxmlns:cus=\"http://creditinfo.com/CB5/v5.48/CustomReport\">\r\n <soapenv:Header/>\r\n <soapenv:Body>\r\n <cb5:GetPdfReport>\r\n <cb5:parameters>\r\n <cus:Consent>true</cus:Consent>\r\n <cus:IDNumber>".$pefindoId."</cus:IDNumber>\r\n <cus:IDNumberType>PefindoId</cus:IDNumberType>\r\n <cus:InquiryReason>ProvidingFacilities</cus:InquiryReason>\r\n <cus:InquiryReasonText/>\r\n <cus:LanguageCode>id-ID</cus:LanguageCode>\r\n <cus:ReportName>PEFINDOScore</cus:ReportName>\r\n <cus:SubjectType>Individual</cus:SubjectType>\r\n </cb5:parameters>\r\n </cb5:GetPdfReport>\r\n </soapenv:Body>\r\n</soapenv:Envelope>",
  CURLOPT_HTTPHEADER => array(
	"Authorization: Basic " . base64_encode("$username:$password"),
    "Content-Type: text/xml",
    "Postman-Token: ae0ace2e-aa92-4d66-8d14-d67edb42fa84",
    "SOAPAction: ".$getReportPDF,
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	//echo "cURL Error #:" . $err;
	echo"<script>window.location='../index.php?page=error'</script>";
} else {
	header('Content-Type: application/zip');
	header('Content-disposition: filename="PDFReportPefindo_'.$pefindoId.'.zip"');
	$out = base64_decode($response);
	print($out);
}
?>