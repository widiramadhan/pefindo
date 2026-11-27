<?php
require_once("config/configuration.php");
$user = $_GET['USERNAME'];
if(isset($_POST['submit'])){
	set_time_limit(120);
	$no_ktp = trim($_POST['no_ktp']);
	$name = trim($_POST['name']);
	$date = trim($_POST['date']);
	// $baseUrl = 'http://10.10.30.84:8000';
	// $baseUrl = 'http://uat.sfi.co.id/sfi/';
	$baseUrl = 'http://integration.sfi.co.id/sfi/';
	
	$ch = curl_init();
	$header = [
		"Content-Type: application/json"
	];

	$data = [
		"type" => 'PERSONAL',
		"id_type" => 'KTP',
		"id_no" => $no_ktp,
		"name" => $name,
		"date_of_birth" => $date,
		"report_date" => null
	];

	curl_setopt($ch, CURLOPT_URL, $baseUrl . '/api/credit_score/pefindo/search_product');
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
		
		//echo"<script>window.location='index.php?USERNAME=".$user."&page=error'</script>";
	} else {
		// $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
		// $xml = new SimpleXMLElement($response);
		// $body = $xml->xpath('//sBody')[0];
		// $array = json_decode(json_encode((array)$body), TRUE); 
		
		$array = json_decode($response,true, 512, JSON_BIGINT_AS_STRING); 

		if($array['code'] != '01'){
			echo"<script>alert('Gagal memperoleh data, silahkan dicoba kembali'); window.location='index.php?USERNAME=".$user."&page=individual-manual-new';</script>";
			exit;
		}

		// var_dump($array);
		// die();
	}
}else{
	$no_ktp = "";
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
				<h4 class="title">Individual</h4>
				<p class="category">Pengecekan Individual Manual</p>
			</div>
			<div class="content">
				<form action="" method="post">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Nomor KTP <span style="color:red">*</span></label>
								<input type="text" name="no_ktp" class="form-control" placeholder="Nomor KTP" value="<?php echo $no_ktp;?>" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Nama Lengkap <span style="color:red">*</span></label>
								<input type="text" name="name" class="form-control" placeholder="Nama Lengkap" value="<?php echo $name;?>" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Tanggal Lahir <span style="color:red">*</span></label>
								<div class="input-group date">
									<input type="text" class="form-control pull-right" name="date" id="datepicker1" placeholder="ex: yyyy-mm-dd" value="<?php echo $date;?>" required>
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
								</div>
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
															<th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">Nomor KTP</th>
															<th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">Nama Lengkap</th>
															<th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">Tanggal Lahir</th>
															<th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">Alamat</th>
															<th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">Action</th>
														</tr>
													</thead>
													<tbody>
													<?php
													if($array['code'] == '01'){
														$no=0;
															foreach($array['data'] as $item) {
																$no++;
													?>
														<tr>
															<td class="td-custom"><?php echo $no;?></td>
															<td class="td-custom"><?php if($item['id_no'] <> NULL){echo $item['id_no'];}?></td>
															<td><?php echo strtoupper($item['nama_debitur']);?></td>
															<td class="td-custom"><?php echo date('Y-m-d', strtotime($item['tanggal_lahir']));?></td>
															<td><?php if($item['alamat'] <> NULL){echo $item['alamat'];}?></td>
															<td class="td-custom">
																<form action="index.php?page=individual-manual-detail-new&USERNAME=<?php echo $user;?>" method="post">
																	<input type="hidden" name="inquiry_id" value="<?= $array['inquiry_id'] ?>">
																	<input type="hidden" name="id_type" value="KTP">
																	<input type="hidden" name="id_no" value="<?= $item['id_no'] ?>">
																	<input type="hidden" name="id_pefindo" value="<?= $item['id_pefindo'] ?>">
																	<input type="submit" class="btn btn-custom btn-xs" value="Check Scoring">
																</form>
															</td>
														</tr>
													<?php }
												}else{
													?>
													<tr>
														<td colspan="6" style="text-align:center;">Data tidak ditemukan</td>
													</tr>
												<?php	
												} 
												?>
													</tbody>
												</table>
												<!-- <div class="row">
													<div class="col-md-12">
														<i class="text-danger"><b>*Jika data tidak ada di Pefindo, maka klik tombol "CEK DI SLIK"</b></i>
													</div>
												</div>
												<hr>
												<div class="row">
													<div class="col-md-12">
														<form action='check-slik.php' method='post'>
															<input name='prospect_no' type='hidden' value='MANUAL'>
															<input name='no_ktp' type='hidden' value='<?php echo $no_ktp;?>'>
															<input name='nama' type='hidden' value="<?php echo $name;?>">
															<input name='birth_dt' type='hidden' value='<?php echo $date;?>'>
															<input name='cust_type' type='hidden' value='P'>
															<input name='id_type' type='hidden' value='KTP'>
															<input name='username' type='hidden' value='<?php echo $user;?>'>
															<input name='tipe_cust' type='hidden' value='<?php echo $siapanih;?>'>
															<button type='submit' class='btn btn-custom' style="width:100%;"><i class="fa fa-search"></i> CEK DI SLIK</div>
														</form>
													</div>
												</div> -->
											<?php }else{ ?>
												<table class="table table-bordered table-striped" style="width:100%;font-size:12px;">
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
<script>
$(document).ready(function() {
	$('#datepicker1').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		yearRange: '-150:+1',
		onClose: function(selectedDate) {
			$('#endDate').datepicker("option", "maxDate", selectedDate);
		}
	});
});
</script>

