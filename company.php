<style>
th{
	text-align:center;
	font-weight:bold;
}
td{
	text-align:center;
}
.loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 99999999999999999999999999999;
    background: url('assets/img/loading.gif') 50% 50% no-repeat rgb(255,255,255);
    opacity: 1;
}
</style>
<?php
require_once("config/configuration.php");
error_reporting(0);

if(isset($_POST['select'])){
	$prospect_no=$_POST['prospect_no'];
	$id_no=$_POST['id_no'];
	$comp_name=$_POST['comp_name'];
}else{
	$prospect_no="";
	$npwp="";
	$comp_name="";
}	

if(isset($_POST['submit'])){
	$prospect=$_POST['prospect_no'];
	$npwp=$_POST['npwp'];
	$nama=$_POST['name'];
}else{
	$prospect="";
	$npwp="";
	$nama="";
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

if ($err) {
	//echo "cURL Error #:" . $err;
	echo"<script>window.location='index.php?USERNAME=".$user."&page=error'</script>";
} else {
	$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
	$xml = new SimpleXMLElement($response);
	$body = $xml->xpath('//sBody')[0];
	$array = json_decode(json_encode((array)$body), TRUE); 
	//print_r($array);
} 
?>
<div class="loader" id="loader"></div>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Company</h4>
				<p class="category">Sistem Informasi Debitur</p>
			</div>
			<div class="content">
				<form action="" method="post">
					<div class="row">
						<div class="col-md-4">
							<label>Prospect Number</label>	
							<div class="input-group date">
								<input type="text" name="no_prospect" class="form-control" placeholder="Prospect Number" value="<?php echo $prospect_no;?>" disabled style="cursor:pointer;">
								<input type="hidden" name="prospect_no" value="<?php echo $prospect_no;?>">
								<div class="input-group-addon" data-target="#prospectCompany" data-toggle="modal" style="cursor:pointer;">
									<i class="fa fa-search"></i>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>NPWP</label>
								<input type="text" class="form-control" placeholder="NPWP"  value="<?php echo $id_no;?>" disabled>
								<input type="hidden" name="npwp" value="<?php echo $id_no;?>">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Company Name</label>
								<input type="text" name="name" class="form-control" placeholder="Company Name" value="<?php echo $comp_name;?>" disabled>
								<input type="hidden" name="name" value="<?php echo $comp_name;?>">
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
							<th>NPWP</th>
							<th>Company Name</th>
							<th>Address</th>
							<th style="width:10%;">Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
						if($array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aStatus'] == 'SubjectFound'){
							if($array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aPefindoId'] <> NULL){
					?>
						<tr>
							<td>1</td>
							<td><?php echo $array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aCompanyRecords']['aSearchCompanyRecord']['aNPWP'];?></td>
							<td><?php echo $array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aCompanyRecords']['aSearchCompanyRecord']['aCompanyName'];?></td>
							<td><?php echo $array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aCompanyRecords']['aSearchCompanyRecord']['aAddress'];?></td>
							<td>
								<a href="check.php?USERNAME=<?php echo $user;?>&request=company&no=<?php echo $prospect;?>&id=<?php echo $array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aCompanyRecords']['aSearchCompanyRecord']['aPefindoId'];?>" class="btn btn-success"><i class="fa fa-search"></i> Check Scoring</a>
							</td>
						</tr>
					<?php
							}else{
								$no=0;
								foreach($array['SmartSearchCompanyResponse']['SmartSearchCompanyResult']['aCompanyRecords']['aSearchCompanyRecord'] as $item) {
									$no++;
					?>	
						<tr>
							<td><?php echo $no;?></td>
							<td><?php echo $item['aNPWP'];?></td>
							<td><?php echo $item['aCompanyName'];?></td>
							<td><?php echo $item['aAddress'];?></td>
							<td>
								<a href="check.php?USERNAME=<?php echo $user;?>&request=company&no=<?php echo $prospect;?>&id=<?php echo $item['aPefindoId'];?>" class="btn btn-success"><i class="fa fa-search"></i> Check Scoring</a>
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
							<td colspan="5" style="text-align:center;">Not Found</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$(window).on("load", function(){
		setTimeout(function(){
			$("#loader").fadeOut("slow");
		}, 2000);
	});
</script>