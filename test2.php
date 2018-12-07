<?php
//Single

$response='<?xml version="1.0" encoding="UTF-8"?>
<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
	<s:Body>
		<SmartSearchCompanyResponse xmlns="http://creditinfo.com/CB5">
			<SmartSearchCompanyResult xmlns:a="http://creditinfo.com/CB5/v5.31/SmartSearch" xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
				<a:CompanyRecords>
					<a:SearchCompanyRecord>
						<a:Address>jl Wika No. 23 Jaksel</a:Address>
						<a:CompanyName>PT Pertambangan Indonesia</a:CompanyName>
						<a:NPWP>1123433</a:NPWP>
						<a:PefindoId>9181810</a:PefindoId>
					</a:SearchCompanyRecord>
				</a:CompanyRecords>
				<a:NilReport i:nil="true"/>
				<a:Parameters>
					<a:CompanyName>Tambang</a:CompanyName>
					<a:IdNumbers>
						 <a:IdNumberPairCompany>
							 <a:IdNumber>1123433</a:IdNumber>
							 <a:IdNumberType>NPWP</a:IdNumberType>
						 </a:IdNumberPairCompany>
					</a:IdNumbers>
				</a:Parameters>
				<a:PefindoId>9181810</a:PefindoId>
				<a:SearchRuleApplied>TaxNumber</a:SearchRuleApplied>
				<a:Status>SubjectFound</a:Status>
			</SmartSearchCompanyResult>
		</SmartSearchCompanyResponse>
	</s:Body>
</s:Envelope>';

//Multiple
/*
$response='<?xml version="1.0" encoding="UTF-8"?>
<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
	<s:Body>
		<SmartSearchCompanyResponse xmlns="http://creditinfo.com/CB5">
			<SmartSearchCompanyResult xmlns:a="http://creditinfo.com/CB5/v5.31/SmartSearch" xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
				<a:CompanyRecords>
					<a:SearchCompanyRecord>
						<a:Address>Jl. DR. Muwardi No. 14 Sukoharjo</a:Address>
						<a:CompanyName>CV Lumbung Abadi Jaya</a:CompanyName>
						<a:NPWP>030265624791000</a:NPWP>
						<a:PefindoId>1107315</a:PefindoId>
					</a:SearchCompanyRecord>
					<a:SearchCompanyRecord>
						<a:Address>Jln. Banda no 5, Bandung</a:Address>
						<a:CompanyName>PT Lumbung Berkat Indonesia</a:CompanyName>
						<a:NPWP>15154841114</a:NPWP>
						<a:PefindoId>2310671</a:PefindoId>
					</a:SearchCompanyRecord>
					<a:SearchCompanyRecord>
						<a:Address>Jln. Banda no 5, Bandung</a:Address>
						 <a:CompanyName>PT Lumbung Berkat Indonesia</a:CompanyName>
						 <a:NPWP>15154841114</a:NPWP>
						 <a:PefindoId>49675131</a:PefindoId>
					</a:SearchCompanyRecord>
				</a:CompanyRecords>
				<a:NilReport i:nil="true"/>
				<a:Parameters>
					<a:CompanyName>Lumbung</a:CompanyName>
					<a:IdNumbers>
						<a:IdNumberPairCompany>
							<a:IdNumber>2131241</a:IdNumber>
							<a:IdNumberType>NPWP</a:IdNumberType>
						</a:IdNumberPairCompany>
					</a:IdNumbers>
				</a:Parameters>
				<a:PefindoId i:nil="true"/>
				<a:SearchRuleApplied>CompanyName</a:SearchRuleApplied>
				<a:Status>SubjectFound</a:Status>
			</SmartSearchCompanyResult>
		</SmartSearchCompanyResponse>
	</s:Body>
</s:Envelope>';*/
$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
$xml = new SimpleXMLElement($response);
$body = $xml->xpath('//sBody')[0];
$array = json_decode(json_encode((array)$body), TRUE); 
//$array = json_decode( str_replace('@', '', json_encode((array)$body)), TRUE);
print_r($array);
echo"<br><br>";
if($array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aPefindoId'] == NULL){
	echo"total array lebih dari 1";	
}else{
	echo"total array 1";
}
?>